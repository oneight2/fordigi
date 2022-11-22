<template>
    <div class="dashboard-campaigns">
        <page-header :title="$t('payout_methods')">
            <button class="btn btn-primary" @click="openAddPayoutMethodModal"
                    v-text="$t('add_new_payout_method')"></button>
        </page-header>

        <div class="datatable">
            <div v-if="loading" class="main-loader">
                <loader/>
            </div>

            <div v-else class="datatable__inner">
                <section-placeholder
                        v-if="payoutMethods.length == 0"
                        :title="$t('sorry')"
                        :description="$t('no_payout_method_found')"
                        icon="far fa-list-alt"
                        class="white">
                </section-placeholder>

                <table v-else>
                    <thead>
                    <tr>
                        <th v-text="$t('created_at')"></th>
                        <th v-text="$t('method_name')"></th>
                        <th v-text="$t('status')"></th>
                        <th class="text-center" v-text="$t('actions')"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, i) in payoutMethods" :key="i">
                        <td class="text-nowrap" v-text="createdAt(item.created_at)"></td>
                        <td class="text-nowrap">{{PAYOUT_METHODS[item.type]}}</td>
                        <td class="text-nowrap">
                            <span class="status status--primary" v-text="$t('active')"></span>
                        </td>
                        <td class="text-center">
                            <action>
                                <action-item
                                        @action="openMethodDetailsModal(item)"
                                        icon="fa-eye"
                                        :title="$t('view_details')"
                                        type="info"
                                />
                                <action-item
                                        v-if="false"
                                        @action="openUpdatePayoutMethodModal"
                                        icon="fa-edit"
                                        :title="$t('update_method')"
                                        type="primary"
                                />
                                <action-item
                                        v-if="false"
                                        @action="function() {}"
                                        icon="fa-trash"
                                        :title="$t('delete_method')"
                                        type="danger"
                                />
                            </action>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="datatable__footer" v-if="false">
                                          <span class="datatable__footer__info" v-if="blueprint.total > 0">
                                              {{$t('showing')}} <strong>{{ campaigns.length }}</strong> {{$t('of')}} <strong>{{ blueprint.total }}</strong>
                                          </span>
                <pagination v-if="blueprint" :limit="1" :data="blueprint"
                            @pagination-change-page="fetchAllCampaigns"></pagination>
            </div>
        </div>

        <add-payout-method-modal @submitted="afterSaveMethod" @created="fetchPayoutMethods"/>
        <update-payout-method-modal @submitted="afterUpdateMethod"/>
        <method-details-modal :method="method"/>
    </div>
</template>

<script>
    import PageHeader from "~/partials/dashboard/PageHeader";
    import Overview from '~/components/dashboard/overview/index'
    import OverviewItem from '~/components/dashboard/overview/Item'
    import AddPayoutMethodModal from "~/components/payout/AddPayoutMethosModal";
    import UpdatePayoutMethodModal from "~/components/payout/UpdatePayoutMethosModal";
    import MethodDetailsModal from "~/components/payout/ViewMethodDetailsModal";
    import {PAYOUT_METHODS} from "~/enum/payout"

    export default {
        layout: 'org-dashboard',
        middleware: ["redirectIfNoOrg"],
        head() {
            return {
                title: this.$t('payout_methods')
            };
        },
        components: {
            MethodDetailsModal,
            UpdatePayoutMethodModal,
            AddPayoutMethodModal,
            PageHeader,
            Overview,
            OverviewItem,
        },
        data() {
            return {
                filter: {
                    search: null,
                    sort_by: null,
                    filter_by: null,
                    date: null,
                    resetSortBy: false,
                    resetFilterBy: false,
                },
                payoutMethods: [],
                loading: false,
                method: null,
                PAYOUT_METHODS
            }
        },
        created() {
            this.fetchPayoutMethods()
        },
        methods: {
            createdAt(timestamp = null) {
                if (!timestamp) {
                    return ''
                }
                return this.$moment(timestamp).format(explainedDateFormat())
            },
            fetchPayoutMethods() {
                this.loading = true

                const endpoint = route("fundraiser-payout-methods")

                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.payoutMethods = res.data.methods
                    })
                    .catch(err => {
                        this.$error(null,getMessageFromError(err))
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            afterSaveMethod() {
                this.$success(null,this.$t('method_saved'))
            },
            afterUpdateMethod() {
                this.$success(null,this.$t('method_updated'))
            },
            openAddPayoutMethodModal() {
                this.$showModal('addPayoutMethodModal')
            },
            openUpdatePayoutMethodModal() {
                this.$showModal('updatePayoutMethodModal')
            },
            openMethodDetailsModal(method) {
                console.log(method)
                this.method = method
                this.$showModal('methodDetailsModal')
            }
        },
    }
</script>