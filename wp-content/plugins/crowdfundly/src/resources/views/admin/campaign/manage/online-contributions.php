<div id="campaignDashboard">
    <layout-campaign variant="dashboard">
        <div class="campaign-dashboard-page">
            <div class="campaign-dashboard-page__loader" v-if="loading && !donations.length">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-else class="campaign-dashboard-page__inner">
                <div class="campaign-dashboard-page__header">
                    <div class="flex-1">
                        <div class="d-flex align-items-center">
                            <h4 class="campaign-dashboard-page__header-title">
                                <?php _e( 'Online Contributions', 'crowdfundly' ); ?>
                            </h4>
                        </div>
                        <p class="campaign-dashboard-page__header-subtitle">
                            <?php _e( 'Get an overview of how your campaign is doing so far', 'crowdfundly' ); ?>
                        </p>
                    </div>

                    <c-button variant="primary" title="<?php _e( 'View Campaign', 'crowdfundly' ); ?>"
                              @onpress="$redirectToCampaign($params('slug'))"></c-button>
                </div>

                <div class="campaign-dashboard-page__body p-0 bg-transparent">
                    <table
                            is="c-data-table"
                            id="campaign-list"
                            v-model:limit="limit"
                            :header="false"
                            :headers="headers"
                            :data="donations"
                            :pagination="blueprint"
                            @pagination-change-page="fetch"
                            @update-limit="updateLimit"
                            :loading="loading">

                        <template slot="placeholder">
                            <c-section-placeholder></c-section-placeholder>
                        </template>

                        <tr v-for="(donation, i) in donations" :key="i">
                            <td v-text="getFormattedDate(donation.created_at)" class="text-nowrap"></td>
                            <td class="text-nowrap">
                                <div>
                                    <span v-if="donation.full_name" v-text="donation.full_name"></span>
                                    <span v-else class="text-warning"><?php _e( 'Contributed anonymously', 'crowdfundly' ); ?></span>
                                </div>
                                <div v-if="donation.is_anonymous === 1">
                                    <!-- <small class="text-warning-dark"><?php //_e( 'Contributed anonymously', 'crowdfundly' ); ?></small> -->
                                </div>
                            </td>
                            <td v-text="$getFormattedCurrency(donation.amount, donation)" class="text-nowrap"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </layout-campaign>
</div>

<script>
    const app = new Vue({
        el: '#campaignDashboard',
        data() {
            return {
                form: {
                    request_note: null
                },
                loading: false,
                campaign: {},
                blueprint: null,
                limit: 10,
                donations: [],
                selectedDonation: null,
                headers: [
                    {text: 'Time In UTC', sortable: true, sortKey: 'created_at'},
                    {text: 'Contributor Name', sortable: true, sortKey: 'full_name'},
                    {text: 'Amount', sortable: true, sortKey: 'amount'},
                ]
            };
        },
        created() {
            this.loading = true
            this.$store.dispatch('campaign/fetch', this.$params('slug'))
                .then(campaign => {
                    this.campaign = campaign
                    this.initialFetchContributions();
                })
                .finally(() => {
                    this.loading = true
                })
        },
        methods: {
            initialFetchContributions(page = 1) {
                this.loading = true;
                this.fetch(page).finally(() => {
                    this.loading = false;
                })
            },
            async fetch(page = 1) {
                return this.$axios
                    .$get(`/campaigns/${this.campaign?.id}/donations?per_page=${this.limit}&page=${page}`)
                    .then(response => {
                        const {data, ...blueprint} = response;
                        this.donations = data;
                        this.blueprint = blueprint;
                    })
                    .catch(error => {
                        this.$cfNotify('error', null, this.$getMessageFromError(error))
                    })
            },
            getFormattedDate(date) {
                return this.$moment(date).format('MMM Do YY');
            },
            updateLimit(value) {
                this.limit = value;
                this.fetch()
            },
        }
    });
</script>