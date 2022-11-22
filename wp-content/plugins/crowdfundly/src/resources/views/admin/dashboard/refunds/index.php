<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <page-header :title="$t('refunds')" style="justify-content: flex-start">
            <small v-if="!isRefundEnabled"
                   class="status status--sm status--primary ml-1 text-bold"
                   v-text="$t('upgrade')"></small>
        </page-header>

        <div class="datatable">
            <div class="datatable__header">
                <!-- ------ Starts: Campaign Filter Section ------ -->
                <g-filter>
                    <form @submit.prevent="fetchRefunds(1)" class="d-flex flex-wrap align-items-center flex-1">
                        <filter-search v-model="filter.search" @button-clicked="search"></filter-search>
                        <filter-select
                                :placeholder="$t('filter_by')"
                                :options="$enum.Refund.AVAILABLE_STATUS_FILTER"
                                @selected-item="setStatusFilter"
                                :reset-value="filter.status === null"></filter-select>
                        <filter-button :title="$t('apply_filter')" type="submit"></filter-button>
                        <filter-button :title="$t('reset_all')" type="reset" @on-press="resetAll"></filter-button>
                    </form>

                    <filter-button>
                        <export-excel
                                :data="excel_data"
                                :fields="excel_fields"
                                worksheet="Crowdfundly"
                                name="refunds.xls">
                            {{ $t('export_to_excel') }}
                        </export-excel>
                    </filter-button>
                </g-filter>
                <!-- ------ Ends: Campaign Filter Section ------ -->
            </div>

            <div class="datatable__inner">

                <div v-if="loading" class="main-loader main-loader--60vh">
                    <loader></loader>
                </div>

                <div v-else>
                    <section-placeholder
                            v-if="refunds.length === 0"
                            :title="$t('sorry')"
                            :description="$t('no_refund_has_been_made')"
                            icon="fas fa-money-bill-alt"
                            class="white height-400">
                    </section-placeholder>
                    <table v-else>
                        <thead>
                        <tr>
                            <th v-text="$t('created_at')"></th>
                            <th v-text="$t('contributor_name')"></th>
                            <th v-text="$t('contributor_email')"></th>
                            <th v-text="$t('amount')"></th>
                            <th v-text="$t('tip_amount')"></th>
                            <th v-text="$t('campaign_name')"></th>
                            <th v-text="$t('transaction_id')"></th>
                            <th v-text="$t('note')"></th>
                            <th v-text="$t('status')"></th>
                            <th class="text-center" v-text="$t('actions')"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(refund, i) in refunds" :key="i">
                            <td v-text="getFormattedDate(refund.created_at)" class="text-nowrap"></td>
                            <td v-text="refund.requested_user ? refund.requested_user.name : ''"
                                class="text-nowrap"></td>
                            <td v-text="refund.requested_user ? refund.requested_user.email : ''"
                                class="text-nowrap"></td>
                            <td v-text="amount(refund.donation)" class="text-nowrap"></td>
                            <td v-text="tipAmount(refund.donation)" class="text-nowrap"></td>
                            <td class="max-300 min-300">
                                <a href="#" v-text="campaignName(refund.donation)"
                                ></a>
                            </td>
                            <td class="text-nowrap">
                                <span>{{ $t('platform') }}: {{ refund.tracking_id ? refund.tracking_id : 'N/A' }}</span>
                                <br>
                                <span>{{ $t('gateway') }}: {{ refund.transaction_id ? refund.transaction_id : 'N/A' }}</span>
                                <br>
                                <span>{{ $t('contribution') }}: {{ refund.donation.transaction.ref_id ? refund.donation.transaction.ref_id : 'N/A' }}</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn--text text-nowrap"
                                        v-if="refund.request_note || refund.note"
                                        @click="showNoteModal(refund)" v-text="$t('view_note')"></button>
                            </td>
                            <td v-text="statusText(refund)"
                                class="text-nowrap text-warning text-bold"></td>
                            <td class="text-center">
                                <action v-if="canSeeActionMenu(refund)" :isLoading="refund.processing">
                                    <action-item v-if="fundraiserCanMakeAction(refund)"
                                                 @action="updateAcceptanceByFundraiser(refund, $enum.Refund.STATUS_FUNDRAISER_ACCEPTED)"
                                                 icon="fa-check"
                                                 :title="$t('accept_request')" type="secondary"></action-item>
                                    <action-item v-if="fundraiserCanMakeAction(refund)"
                                                 @action="updateAcceptanceByFundraiser(refund, $enum.Refund.STATUS_FUNDRAISER_CANCELLED)"
                                                 icon="fa-times-circle"
                                                 :title="$t('decline_request')"
                                                 type="danger"></action-item>
                                    <action-item v-if="teamMemberCanMakeAction(refund)"
                                                 @action="showRefundModal(refund)"
                                                 icon="fa-check"
                                                 :title="$t('approve_refund')"
                                                 type="success"></action-item>
                                    <action-item v-if="teamMemberCanMakeAction(refund)"
                                                 @action="showCancelModal(refund)"
                                                 icon="fa-times-circle"
                                                 :title="$t('decline_refund')"
                                                 type="danger"></action-item>
                                </action>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Starts: Pagination -->
            <div v-if="refunds.length" class="pagination-section d-flex align-items-center justify-content-center mt-3">
                <pagination :limit="1" :data="paginator" @pagination-change-page="fetchRefunds"></pagination>
            </div>
            <div class="datatable__footer" v-if="refunds.length !== 0">
                <span class="datatable__footer__info" v-if="total > 0">
                    {{ $t('Showing') }} <strong>{{ refunds.length }}</strong> {{ $t('of') }} <strong>{{
                        total
                    }}</strong>
                </span>
                <pagination v-if="paginator" :limit="1" :data="paginator"
                            @pagination-change-page="fetchRefunds"></pagination>
            </div>
        </div>

        <g-modal id="refundModal" :title="$t('refund_note')" size="lg" position="center-center" :footer="false">
            <form action="" @submit.prevent="approveRefund(selectedRefund)">
                <div class="form-group">
                    <label for="refund_note">
                        {{ $t('note') }}
                    </label>
                    <textarea name="" id="refund_note" rows="5" class="form-control"
                              v-model.trim="approvalForm.note"
                              :placeholder="$t('note')"></textarea>
                </div>

                <div class="modal-footer d-flex align-items-center justify-content-end">
                    <button class="btn btn-primary" type="submit" v-text="$t('accept')"
                            :disabled="selectedRefund && selectedRefund.processing"></button>
                </div>
            </form>
        </g-modal>

        <g-modal id="cancelModal" :title="$t('refund_note')" size="lg" position="center-center">
            <form action="" @submit.prevent="declineRefund(selectedRefund)">
                <div class="form-group">
                    <label for="cancel_note">
                        {{ $t('note') }}
                    </label>
                    <textarea name="" id="cancel_note" rows="5" class="form-control"
                              v-model.trim="declineForm.note"
                              :placeholder="$t('write_a_note_here')+'...'"></textarea>
                </div>

                <div class="modal-footer d-flex align-items-center justify-content-end">
                    <button class="btn btn-primary" type="submit" v-text="$t('submit')"
                            :disabled="selectedRefund && selectedRefund.processing"></button>
                </div>
            </form>
        </g-modal>

        <g-modal id="viewNote" :title="$t('refund_note')" size="lg" position="center-center">
            <div v-if="selectedRefund">
                <div class="form-group" v-if="selectedRefund.request_note">
                    <label class="mb-0" for="request_note">
                        {{ $t('contributor_note') }}
                    </label>
                    <p class="mb-0" id="request_note">{{ selectedRefund.request_note }}</p>
                </div>

                <div class="form-group" v-if="selectedRefund.note">
                    <label class="mb-0" for="note">
                        {{ $t('admin_note') }}
                    </label>
                    <p class="mb-0" id="note">{{ selectedRefund.note }}</p>
                </div>
            </div>
        </g-modal>
    </dashboard-layout>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                refunds: [],
                processingRefund: false,
                loading: false,
                approvalForm: {
                    note: null,
                },
                declineForm: {
                    note: null,
                },
                selectedRefund: null,
                paginator: null,
                perPage: 10,
                filter: {
                    searchText: null,
                    status: null
                },
                resetFilterBy: false,
                excel_data: [],
                excel_fields: null,
                isRefundEnabled: false
            }
        },
        async created() {
            this.fetchRefunds()
            await this.checkPlan('allow_donation_refund', 'isRefundEnabled')
        },
        computed: {
            organization() {
                return this.$auth.organization
            },
            total() {
                return this.paginator ? this.paginator.total : 0
            },
            isFundraiser() {
                if (!this.organization) return false;
                return this.organization.auth_org_role == 'fundraiser'
            },
            domainName() {
                return baseDomain()
            },
        },
        methods: {
            fetchRefunds(page = 1) {
                this.loading = true;
                let query = {
                    per_page: this.perPage,
                    page:page
                }
                if (this.filter.searchText) {
                    query.searchText = this.filter.searchText
                }
                if (this.filter.status) {
                    query.status = this.$enum.Refund.STATUS_VALUE_MAP[this.filter.status]
                }
                let endpoint = route_with_query('get-auth-org-refunds', query);

                this.$axios
                    .get(endpoint.absolute_path)
                    .then(response => {
                        this.refunds = this.appendProcessingKey(response.data);
                        this.paginator = response
                        this.exportToExcelData(response.data);
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },
            async updateAcceptanceByFundraiser(refund, status) {
                if (!await this.$confirm()) return;
                refund.processing = true;
                let endpoint = route_with_query('update-refund-acceptance').absolute_path;
                this.$axios
                    .put(endpoint, {refund_id: refund.id, status: status})
                    .then(response => {
                        this.fetchRefunds();
                        this.$success(null, response.message || this.$t('successfully_updated'))
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        refund.processing = false;
                    })
            },
            async approveRefund(refund) {
                if (!await this.$confirm()) return;
                refund.processing = true;
                let endpoint = route_with_query('approve-refund-request').absolute_path;
                this.$axios
                    .post(endpoint, {refund_id: refund.id, note: this.approvalForm.note})
                    .then(response => {
                        this.fetchRefunds();
                        this.$success(null, response.message || this.$t('successfully_refunded'))
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        refund.processing = false;
                        this.$hideModal('refundModal')
                    })
            },
            async declineRefund(refund) {
                if (!await this.$confirm()) return;
                refund.processing = true;
                let endpoint = route_with_query('decline-refund-request').absolute_path;
                this.$axios
                    .post(endpoint, {refund_id: refund.id, note: this.declineForm.note})
                    .then(response => {
                        this.fetchRefunds();
                        this.$success(null, response.message || this.$t('successfully_declined'))
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        refund.processing = false;
                        this.$hideModal('cancelModal')
                    })
            },
            appendProcessingKey(refunds) {
                return refunds.map(refund => {
                    refund.processing = false;
                    return refund;
                });
            },
            setAppliedFilter(email, amount = false, payout = false) {
                this.appliedFilters.email = email
                this.appliedFilters.amount = amount
                this.appliedFilters.payout_id = payout
            },
            showRefundModal(refund) {
                this.selectedRefund = refund;
                this.approvalForm.note = null;
                return this.$showModal('refundModal')
            },
            showCancelModal(refund) {
                this.selectedRefund = refund;
                this.declineForm.note = null;
                return this.$showModal('cancelModal')
            },
            showNoteModal(refund) {
                this.selectedRefund = refund;
                this.$showModal('viewNote')
            },
            getFormattedDate(date) {
                return this.$moment(date, 'YYYY-MM-DD hh:mm:ss').format('DD/MM/YYYY hh:mm:ss A');
            },
            donorName(donation) {
                return donation.full_name
            },
            donorEmail(donation) {
                return donation.email
            },
            campaignRoute(slug) {
                return {
                    name: 'campaigns-slug',
                    params: {
                        slug: slug
                    }
                }
            },
            amount(donation) {
                return Number(donation.amount).toFixed(2) + ' ' + donation.currency_code
            },
            tipAmount(donation) {
                return Number(donation.tip_amount).toFixed(2) + ' ' + donation.currency_code
            },
            campaignName(donation) {
                return donation.campaign.name
            },
            campaignSlug(donation) {
                return donation.campaign.slug
            },
            userProfileRoute(username) {
                return {
                    name: 'user-username-story',
                    params: {
                        username: username
                    }
                }
            },
            canSeeActionMenu(refund) {
                return this.fundraiserCanMakeAction(refund) || this.teamMemberCanMakeAction(refund);
            },
            // returns status wording defending on role
            statusText(refund) {
                if (this.isFundraiser || this.orgOwnerIsFundraiser(refund)) {
                    return this.$enum.Refund.AVAILABLE_STATUS_FOR_FUNDRAISER[refund.status];
                }
                return this.$enum.Refund.AVAILABLE_STATUS[refund.status];
            },
            /* -------------- Starts: Campaign Filter methods -------------- */
            search(value) {
                this.filter.searchText = value;
                this.fetchRefunds(1);
            },
            setStatusFilter(value) {
                this.filter.status = value
            },
            resetAll() {
                this.filter.status = null;
                this.filter.searchText = null;
                this.fetchRefunds(1)
            },
            orgOwnerIsFundraiser(refund) {
                if (!this.organization) return false;
                return this.organization.auth_org_role == 'owner' &&
                    refund.donation.campaign.creator_id == this.$auth.user.id;
            },
            fundraiserCanMakeAction(refund) {
                return this.organization &&
                    this.organization.auth_org_role == 'fundraiser' &&
                    refund.donation.transaction.source != 6 &&  // 6 is for woocommerce gateway
                    refund.status == this.$enum.Refund.STATUS_PENDING
            },
            teamMemberCanMakeAction(refund) {
                return this.organization &&
                    (
                        this.organization.auth_org_role == 'team_member' ||
                        this.organization.auth_org_role == 'owner'
                    ) &&
                    refund.donation.transaction.source != 6 &&  // 6 is for woocommerce gateway
                    refund.status == this.$enum.Refund.STATUS_FUNDRAISER_ACCEPTED;
            },
            async checkPlan(permission, key) {
                return await get_plan_value(permission)
                    .then(value => {
                        this[key] = value
                    })
            },
            /* -------------- Ends: Campaign Filter methods -------------- */
            exportToExcelData(data) {
                this.excel_data = data.map((refund, index) => {
                    return {
                        created_at: refund.created_at,
                        full_name: refund.requested_user ? refund.requested_user.name : '',
                        email: refund.requested_user ? refund.requested_user.email : '',
                        amount: Number(refund.donation.amount).toFixed(2) + ' ' + refund.donation.currency_code,
                        tip_amount: Number(refund.donation.tip_amount).toFixed(2) + ' ' + refund.donation.currency_code,
                        campaign_name: refund.donation.campaign.name,
                        transaction_id: refund.tracking_id ? refund.tracking_id : 'N/A',
                        status: this.$enum.Refund.AVAILABLE_STATUS[refund.status]
                    }
                })
                this.excel_fields = {
                    'Date/Time': 'created_at',
                    'Contributor Name': 'full_name',
                    'Contributor Email': 'email',
                    'Amount Contributed': 'amount',
                    'Tip Amount': 'tip_amount',
                    'Campaign Name': 'campaign_name',
                    'Transaction ID': 'transaction_id',
                    'Status': 'status'
                }
            }
        }
    });
</script>