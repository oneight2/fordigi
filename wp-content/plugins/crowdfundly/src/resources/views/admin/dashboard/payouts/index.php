<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <div v-if="loading" class="main-loader main-loader--70vh">
            <c-loader variant="primary"></c-loader>
        </div>

        <div class="dashboard dashboard--payouts" v-else>
            <page-header title="Wallet"></page-header>
            <div class="wallet-palceholder" v-if="!wallet && !fetchingWallet">
                <c-section-placeholder description="No Wallet Records"></c-section-placeholder>
            </div>
            <div class="dashboard__overview" v-else>
                <div class="c-card-wrap">
                    <c-card title="Net Earning" :sub-title="$getFormattedCurrency(wallet.total_amount)" icon="mdi-currency-usd" variant="purple"></c-card>
                </div>
                <div class="c-card-wrap" v-if="false">
                    <c-card title="Available Amount" :sub-title="$getFormattedCurrency(wallet.available_amount)" icon="mdi-currency-usd" variant="light-green"></c-card>
                </div>
                <div class="c-card-wrap" v-if="!fundraiser">
                    <c-card title="Paid" :sub-title="$getFormattedCurrency(wallet.total_paid)" icon="mdi-currency-usd" variant="light-blue"></c-card>
                </div>
                <div class="c-card-wrap" v-if="fundraiser">
                    <c-card title="Withdrawn" :sub-title="$getFormattedCurrency(wallet.total_withdrawn)" icon="mdi-currency-usd" variant="green"></c-card>
                </div>
                <div class="c-card-wrap" v-if="!fundraiser">
                    <c-card title="Available To Pay" :sub-title="$getFormattedCurrency(wallet.payable)" icon="mdi-currency-usd" variant="green"></c-card>
                </div>
                <div class="c-card-wrap" v-if="fundraiser">
                    <c-card title="Available For Withdrawal" :sub-title="$getFormattedCurrency(wallet.receivable)" icon="mdi-currency-usd" variant="green"></c-card>
                </div>
                <div class="c-card-wrap" v-if="!fundraiser">
                    <c-card title="Pending Clearance" :sub-title="$getFormattedCurrency(wallet.total_escrow)" icon="mdi-currency-usd" variant="light-green"></c-card>
                </div>
                <div class="c-card-wrap" v-if="fundraiser">
                    <c-card title="Pending Clearance" :sub-title="$getFormattedCurrency(wallet.total_escrow)" icon="mdi-currency-usd" variant="red"></c-card>
                </div>
                <div class="c-card-wrap" v-if="!fundraiser">
                    <c-card title="Received Tip" :sub-title="$getFormattedCurrency(wallet.total_tip_amount)" icon="mdi-currency-usd" variant="orange"></c-card>
                </div>
                <div class="c-card-wrap" v-if="!fundraiser">
                    <c-card title="Received Fee" :sub-title="$getFormattedCurrency(wallet.total_organization_fee)" icon="mdi-currency-usd" variant="red"></c-card>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <page-header title="Payout History"></page-header>
                    <table is="c-data-table" id="payout-lists" v-model="limit" :headers="headers" :header="false" :data="payouts" :pagination="bluePrint" @pagination-change-page="fetch" @update-limit="updatelimit" :loading="loading">
                        <template slot="placeholder">
                            <c-section-placeholder></c-section-placeholder>
                        </template>
                        <tr v-for="(payout,idx) in payouts" :key="idx">
                            <td class="text-nowrap" v-text="'#'+payout.id"></td>
                            <!--                                                            <td class="text-nowrap"-->
                            <!--                                                                v-text="payoutAmountWithCurrency(payout)"></td>-->
                            <td class="text-nowrap" v-text="$getFormattedCurrency(payout.amount)">
                            </td>
                            <!-- <td class="text-nowrap">
                                <a v-text="payout.fundraiser.name" class="a-link" :href="$getFundraiserUrl(payout.fundraiser.username)" target="_blank" />
                            </td> -->
                            <td class="text-nowrap">
                                <c-pill :label="$getPayoutStatus(payout.status)" :variant="$getPayoutStatusColor(payout.status)"></c-pill>
                            </td>
                            <td class="text-nowrap text-center" v-text="$getPayoutMethods(payout.payout_method.type)"></td>
                            <td class="text-nowrap" v-text="_createdAt(payout.created_at)"></td>
                            <td class="text-nowrap">
                                <!--if has attachment-->
                                <image-viewer v-if="payout.attachment" :src="payout.attachment" :id="`preview-image-${Math.random()}`"></image-viewer>
                                <span v-else v-text="'No Attachment Found'"></span>
                            </td>
                            <td class="text-center">
                                <c-dropdown-action :id="`dropdown_${idx+1}`">
                                    <c-dropdown-item variant="success" @onpress="viewPayout(payout)">
                                        <span class="mdi mdi-eye mr-2"></span>
                                        View
                                    </c-dropdown-item>
                                </c-dropdown-action>
                            </td>
                        </tr>
                    </table>
                    <payout-details-modal id="payout-details" :payout="selectedPayout"></payout-details-modal>
                </div>
            </div>

        </div>
    </layout-dashboard>
</div>


<script>
    let app = new Vue({
        el: "#dashboard",
        data() {
            return {
                loading: true,
                fetchingWallet: false,
                wallet: {},
                limit: 10,
                payouts: [],
                bluePrint: {},
                currentPage: 1,
                headers: [{
                        text: "Payout ID",
                        sortable: true,
                        sortKey: 'id'
                    },
                    {
                        text: "Amount",
                        sortable: true,
                        sortKey: 'amount'
                    },
                    // {
                    //     text: "Fundraiser",
                    //     sortable: true,
                    //     sortKey: 'fundraiser.name'
                    // },
                    {
                        text: "Status",
                        sortable: true,
                        sortKey: 'status'
                    },
                    {
                        text: "Payment Method",
                        sortable: true,
                        sortKey: 'payout.payout_method.type'
                    },
                    {
                        text: "Date",
                        sortable: true,
                        sortKey: 'created_at'
                    },
                    {
                        text: "Attachment",
                        sortable: false
                    },
                    {
                        text: "Actions",
                        sortable: false,
                    }

                ],
                selectedPayout: null,
                reverseStatusMap: null,
                processingId: null,
            }
        },
        created() {
            this.fetchWallet();
            this.initialFetchPayouts();
            this.reverseStatusMap = this.$reverseMap(this.$getPayoutStatus())
        },
        mounted() {
            this.fetchPayouts();
        },
        methods: {
            fetchWallet() {
                this.fetchingWallet = true
                this.$axios.get(`wallets/view`).then(res => {
                    this.wallet = res.data.wallet
                    console.log("wallet data: ", res.data)
                }).catch(err => {
                    console.log(err)
                }).finally(() => {
                    this.fetchingWallet = false
                    this.loading = false
                })
            },

            initialFetchPayouts(page = 1) {
                this.loading = true;
                this.fetch(page).finally(() => this.loading = false);
            },

            async fetch(page) {
                let params = {
                    per_page: this.limit,
                    page
                }

                return this.$axios.$get('/wallets/organization/payouts', {
                        params
                    })
                    .then(res => {
                        console.log("initialFetchPayouts: ", res);
                        const {
                            data,
                            ...blueprint
                        } = res
                        this.payouts = data;
                        this.bluePrint = blueprint;
                        this.currentPage = page
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },

            updatelimit(value) {
                this.limit = value;
                this.initialFetchPayouts();
            },
            _createdAt(dateTimeObject) {
                return this.$moment(dateTimeObject).format("MMM Do YY")
            },
            viewPayout(payout) {
                console.log('payout: ', payout);
                this.selectedPayout = payout;
                this.$eventHub.$emit('show-dialog', 'payout-details');
            },
            canDeny(payoutStatus) {
                if (this.fundraiser) {
                    return false
                }
                return this.reverseStatusMap['requested'] == payoutStatus
            },
            showDenyModal(payout) {
                this.selectedPayout = payout;
                // this.$eventHub.$emit('show-dialog','deny-modal');
            },
            canAccept(payoutStatus) {
                if (this.fundraiser) {
                    return false
                }
                return this.reverseStatusMap['requested'] == payoutStatus
            },

            async acceptRequest(payout) {
                let formData = new FormData
                formData.append('id', payout.id)
                formData.append('status', 'accepted')
                this.acceptOrDenyPayoutRequest(formData, payout, true)

            },
            acceptOrDenyPayoutRequest(formData, payout, successAction) {
                this.processingId = payout.id;
                this.$axios.$post("/wallets/payouts/approval")
                    .then(res => {
                        this.$success(null, res.data.message)
                        if (successAction) {
                            payout.status = this.reverseStatusMap['accepted']
                        } else {
                            payout.status = this.reverseStatusMap['rejected']
                        }
                    })
                    .catch(err => {
                        this.$error(null, getMessageFromError(err))
                    })
                    .finally(() => {
                        this.processingId = null
                        this.$hideDialog('denyModal')
                        this.fetch()
                        this.processing = false
                    })
            },
            openUpdateWithdrawRequestModal(payout) {
                this.selectedPayout = payout;
                this.$eventHub.$emit("show-dailog", "update-withdraw-request-modal");
            },
            fetchPayouts() {
                this.$axios.$get('/wallets/fundraisers/payout-methods')
                    .then(res => {
                        this.payoutMethods = res.data.data;
                    })
                    .catch(err => {
                        this.$cfNotify('error', '', err)
                    })
            }
        },
        computed: {
            fundraiser() {
                if (!this.$auth.organization) {
                    return false
                }
                return this.$auth.organization.auth_org_role === "fundraiser"
            },

        },
    })
</script>