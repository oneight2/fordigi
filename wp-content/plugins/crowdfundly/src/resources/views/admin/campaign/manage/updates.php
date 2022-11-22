<div id="campaignDashboard">
    <layout-campaign variant="dashboard">
        <div class="campaign-dashboard-page">
            <div class="campaign-dashboard-page__loader" v-if="loading">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-if="!loading" class="campaign-dashboard-page__inner">
                <div class="campaign-dashboard-page__header">
                    <div class="flex-1">
                        <h4 class="campaign-dashboard-page__header-title">Post Update</h4>
                    </div>

                    <c-button variant="primary" title="View Campaign"
                              @onpress="$redirectToCampaign($params('slug'))"></c-button>
                </div>

                <div class="campaign-dashboard-page__body">
                    <campaign-updates
                            :visible-post-button="true"
                            :visible-delete-button="true"
                            :updates="updates"
                            :blueprint="blueprint"
                            :campaign="campaign"
                            :loading="loadingUpdates"
                            @load-more="loadMore"
                            @deleted="fetchCampaignUpdates"
                            @new-update="fetchCampaignUpdates"
                    ></campaign-updates>
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
                campaign: {},
                blueprint: {},
                updates: [],
                limit: 3,
                limitStep: 3,
                loading: false,
                loadingUpdates: false,
                processing: false,
            };
        },
        created() {
            this.fetchCampaign();
        },
        methods: {
            fetchCampaign() {
                this.loading = true
                return this.$store.dispatch('campaign/fetch', this.$params('slug'))
                    .then(campaign => {
                        this.campaign = campaign;
                        this.fetchCampaignUpdates()
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },

            fetchCampaignUpdates() {
                this.loadingUpdates = true
                this.$axios.$get(`/campaigns/${this.campaign.id}/updates?per_page=${this.limit}`)
                    .then(updates => {
                        const {data, ...blueprint} = updates
                        this.updates = data
                        this.blueprint = blueprint
                        this.$forceUpdate()
                    })
                    .catch(error => {
                        this.$cfNotify('error', null, this.$getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loadingUpdates = false
                    })
            },
            loadMore() {
                this.limit = this.limit + this.limitStep
                this.fetchCampaignUpdates()
            }
        }
    });
</script>