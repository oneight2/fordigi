<div id="campaignDashboard">
    <layout-campaign variant="dashboard">
        <div class="campaign-dashboard-page">
            <div class="campaign-dashboard-page__loader" v-if="loading">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-if="!loading" class="campaign-dashboard-page__inner">
                <div class="campaign-dashboard-page__header">
                    <div class="flex-1">
                        <h4 class="campaign-dashboard-page__header-title">Presets</h4>
                    </div>

                    <c-button variant="primary" title="View Campaign"
                              @onpress="$redirectToCampaign($params('slug'))"></c-button>
                </div>

                <div class="campaign-dashboard-page__section">
                    <div class="campaign-dashboard-page__section-inner">
                        <form @submit.prevent="savePresets">
                            <c-input-group label="Amount Preset" label-class="mb-2">
                                <p class="mb-4">
                                    Set the preset amounts for contributions and explain what they mean to your cause.
                                    That way, contributors can see how their contributions are helping.
                                </p>
                                <presets-creator v-if="campaign" id="amountPresets" input-type="number"
                                                 :placeholder="$getFormattedCurrency(20, campaign)"
                                                 v-model="presets"
                                                 :current-data="currentPresets"></presets-creator>
                            </c-input-group>

                            <c-button type="submit" variant="primary" title="Save"></c-button>
                        </form>
                    </div>
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
                deleting: false,
                loading: false,
                presets: [],
                currentPresets: [],
                campaign: {}
            };
        },
        mounted() {
            this.fetchCampaign()
        },
        methods: {
            fetchCampaign() {
                this.loading = true
                return this.$store.dispatch('campaign/fetch', this.$params('slug'))
                    .then(campaign => {
                        this.campaign = campaign
                        this.currentPresets = campaign?.options?.presets
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            savePresets() {
                return this.$store.dispatch('campaign/setOption', {key: 'presets', value: this.presets})
                    .then(() => {
                        this.$cfNotify('success', null, 'Successfully, amount presets have been saved.')
                        this.$forceUpdate()
                    })
                    .catch((error) => {
                        this.$cfNotify('error', null, this.$getMessageFromError(error))
                    })
            },
        }
    });
</script>