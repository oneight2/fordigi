<div id="campaignDashboard">
    <campaign-dashboard-layout>
        <div class="campaign-dashboard-page campaign-dashboard-page--statistics">
            <div class="main-loader main-loader--90vh" v-if="loading">
                <loader :description="$t('loading') + '...'"></loader>
            </div>

            <div v-else class="campaign-dashboard-page__inner">
                <div class="campaign-dashboard-page__header d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h4 class="campaign-dashboard-page__header-title" v-text="$t('statistics')"></h4>
                        <p class="campaign-dashboard-page__header-subtitle"
                        >{{ $t('get_an_overview') }}</p>
                    </div>
                    <a-link class="btn btn-primary"
                            target="_blank"
                            v-if="campaign && organization && organization.username"
                            :href="'#'"
                            v-text="$t('view_campaign')"
                    ></a-link>
                </div>

                <div class="campaign-dashboard-page__body">
                    <div class="chart-card">
                        <div class="chart-card__header">
                            <h5 class="chart-card__title text-capitalize" v-text="getTitle"></h5>
                            <chart-dropdown id="statisticChartDropdown" :border="true" @filter-data="watchFilterData"/>
                        </div>

                        <div class="chart-card__amount">
                            <h2 class="chart-card__amount-value" v-text="getAmount"></h2>
                            <h5 class="chart-card__amount-subtitle">
                                {{ $t('the_donation_amount_your_campaign_has_received') }}</h5>
                        </div>

                        <div v-if="processingStatistics" class="main-loader main-loader--40vh">
                            <loader type="dotted"></loader>
                        </div>
                        <!-- starts: Chart -->
                        <apex-charts v-else id="statistics" height="400px"
                                     :options="chart.options"
                                     :series="chart.series"
                        ></apex-charts>
                    </div>
                </div>
            </div>
        </div>
    </campaign-dashboard-layout>
</div>

<script>
    const app = new Vue({
        el: '#campaignDashboard',
        data() {
            return {
                loading: false,
                processingStatistics: false,
                stats: null,
                campaign: null,
                selectedFilter: {
                    dateRange: null,
                    filter: 'last_seven_day'
                },
                selectedFilterType: 'last_seven_day',
                chart: {
                    label: this.$t('last_seven_day'),
                    date: null,
                    amount: 0,
                    total: 0,
                    offline_amount: 0,
                    online_amount: 0,
                    options: {
                        chart: {
                            id: 'statistics',
                            type: 'area',
                        },
                        xaxis: {
                            categories: []
                        },
                        theme: {
                            palette: 'palette2'
                        },
                        stroke: {
                            curve: 'smooth',
                        },
                        colors: []
                    },
                    series: [],
                    xaxis: {
                        type: 'numeric'
                    }
                },
                chatTitle: {
                    'all': this.$t('all') + ' ' + this.$t('contribution'),
                    'today': this.$t('todays') + ' ' + this.$t('contributions'),
                    'yesterday': this.$t('yesterdays') + ' ' + this.$t('contributions'),
                    'last_seven_day': this.$t('last_seven_days') + ' ' + this.$t('contributions'),
                    'this_year': this.$t('this_years') + ' ' + this.$t('contributions'),
                    'last_year': this.$t('last_years') + ' ' + this.$t('contributions'),
                    'this_month': this.$t('this_months') + ' ' + this.$t('contributions'),
                    'last_month': this.$t('last_months') + ' ' + this.$t('contributions'),
                    'custom': this.$t('contributions') + ' ' + this.$t('between')
                },
            };
        },
        async mounted() {
            await this.fetchCampaignStats()
            await this.fetchCampaign()
            console.log('selectedCampaign',this.selectedCampaign)
        },
        computed: {
            organization() {
                return this.$auth.organization
            },
            selectedCampaign() {
                return this.$store.getters.selectedCampaign
            },
            domainName() {
                return baseDomain()
            },
            getAmount() {
                if (this.campaign && this.campaign.currency_code) {
                    return this.campaign.currency_symbol + this.chart.amount.toFixed() + ' ' + this.campaign.currency_code
                }
            },
            getTitle() {
                if (this.selectedFilter.filter === 'custom') {
                    return this.chatTitle[this.selectedFilter.filter] + ' ' + this.chart.date ? this.chart.date : ''
                }
                return this.chatTitle[this.selectedFilter.filter]
            },
        },
        watch: {
            selectedFilterType() {
                this.fetchCampaignStats()
            }
        },
        methods: {
            watchFilterData(data) {
                this.selectedFilter.filter = data.filter
                this.selectedFilter.dateRange = data.dateRange
                this.selectedFilterType = data.filter
            },

            async fetchCampaign() {
                this.loading = true;
                let endpoint = route_with_query('get-auth-campaign', null, this.selectedCampaign.slug).absolute_path;
                await this.$axios
                    .get(endpoint)
                    .then(result => {
                        console.log('campaign', result)
                        this.campaign = result
                        this.message_to_donor = result.message_to_donor;
                    })
                    .catch(error => {
                        throw this.$nuxtException()
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },

            async fetchCampaignStats() {
                let query = {type: this.selectedFilter.filter};
                if (this.selectedFilter.filter === 'custom') {
                    if (!this.selectedFilter.dateRange || !this.selectedFilter.dateRange.start || !this.selectedFilter.dateRange.end) {
                        this.$warning(null, this.$t('please_select_a_date_range'));
                        return;
                    }
                    query.from_date = this.selectedFilter.dateRange.start;
                    query.to_date = this.selectedFilter.dateRange.end;
                    this.chart.date = this.$moment(this.selectedFilter.dateRange.start, 'YYYY-MM-DD').format('DD MMM, YYYY') + ' - ' +
                        this.$moment(this.selectedFilter.dateRange.end, 'YYYY-MM-DD').format('DD MMM, YYYY')
                }
                this.processingStatistics = true;
                this.chart.label = this.$t(this.selectedFilter.filter)
                let endpoint = route_with_query('campaign-stats', query, this.selectedCampaign.slug).absolute_path;
                await this.$axios
                    .get(endpoint)
                    .then(response => {
                        console.log('response', response)
                        this.setChartData(response)
                    })
                    .catch(error => {
                        // throw this.$nuxtException();
                        console.log('error', error)
                    })
                    .finally(() => {
                        this.processingStatistics = false;
                    });

            },
            setChartData(response) {
                this.chart.amount = response.total_raised.amount;
                this.chart.options.xaxis.categories = Object.keys(response.total_raised.data);
                this.chart.online_amount = response.total_raised.online_amount;
                this.chart.offline_amount = response.total_raised.offline_amount;
                this.chart.series = [
                    {
                        name: this.$t('statistics'),
                        data: Object.values(response.total_raised.data)
                    }
                ];
                this.chart.options.colors = ['#33b5e5'];
            },
        }
    });
</script>