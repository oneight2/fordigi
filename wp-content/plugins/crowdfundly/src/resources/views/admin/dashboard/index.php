<div id="dashboard" class="main-wrapper">
    <layout-dashboard>

        <div v-if="loading" class="main-loader main-loader--70vh">
            <c-loader variant="primary"></c-loader>
        </div>

        <div v-else class="dashboard">
            <div class="dashboard__overview">
                <div class="c-card-wrap">
                    <c-card
                            title="<?php _e( 'Total Fundraised', 'crowdfundly' ); ?>"
                            :sub-title="totalFundraised"
                            icon="mdi-cash-multiple"
                            variant="blue"></c-card>
                </div>

                <div class="c-card-wrap">
                    <c-card
                            title="<?php _e( 'Total Contributors', 'crowdfundly' ); ?>"
                            :sub-title="totalContributor"
                            icon="mdi-account-multiple"
                            variant="light-blue"></c-card>
                </div>
                <div class="c-card-wrap">
                    <c-card
                            title="<?php _e( 'Total Campaigns', 'crowdfundly' ); ?>"
                            :sub-title="totalCampaign"
                            icon="mdi-bullhorn"
                            variant="dark-blue"></c-card>
                </div>
                <div class="c-card-wrap">
                    <c-card
                            title="<?php _e( 'Total Published Campaigns', 'crowdfundly' ); ?>"
                            :sub-title="totalPublishedCampaign"
                            icon="mdi-check-underline-circle"
                            variant="purple"></c-card>
                </div>
                <div class="c-card-wrap">
                    <c-card
                    title="<?php _e( 'Received Tip', 'crowdfundly' ); ?>"
                    :sub-title="getTipAmount()"
                    icon="mdi-check-decagram"
                    variant="orange">
                    </c-card>
                </div>
            </div>
        </div>
        <!-- <div v-if="!loading && countStats" class="dashboard-landing__inner">
            <div class="dashboard-section">
                <div class="dashboard-section__header">
                    <h5 class="dashboard-section__title text-uppercase">
                        {{ $t('overview') }}
                    </h5>
                </div>
                <div class="dashboard-section__inner">

                    <overview>
                        <overview-item variant="info"
                                        :value="getValue(countStats.donation.total_fundraised)"
                                        :label="$t('total_fundraised')"
                                        :icon="$imagePath('icons/dollar.svg')">
                        <span class="overview-additional" v-if="countStats.donation.total_fundraised">
                            <span
                                    class="overview-additional__amount text-nowrap">
                                <span class="overview-additional__amount-label">{{ $t('online_raised') }}</span>
                                <strong
                                        class="overview-additional__amount-value"
                                        v-text="getValue(countStats.donation.total_online_fundraised)">
                                </strong>
                            </span>
                            <span
                                    class="overview-additional__amount text-nowrap">
                                <span class="overview-additional__amount-label">{{ $t('offline_raised') }}</span>
                                <strong
                                        class="overview-additional__amount-value"
                                        v-text="getValue(countStats.donation.total_offline_fundraised)">
                                </strong>
                            </span>
                        </span>
                        </overview-item>

                        <overview-item variant="secondary" :value="countStats.user.fundraisers_count"
                                        v-if="!authHasRole('fundraiser')"
                                        :label="$t('total_fundraiser')"
                                        :icon="$imagePath('icons/group-of-users-silhouette.svg')"></overview-item>
                        <overview-item variant="success" :value="countStats.user.contributors_count"
                                        :label="$t('total_contributors')"
                                        :icon="$imagePath('icons/hand-usd.svg')"></overview-item>
                    </overview>

                    <div class="hr hr--30"></div>

                    <overview>
                        <overview-item variant="primary" :value="countStats.campaign.total"
                                        :label="$t('total_campaigns')"
                                        :icon="$imagePath('icons/campaign.svg')"></overview-item>
                        <overview-item variant="success" :value="countStats.campaign.total_approved"
                                        :label="$t('total_publish_campaigns')"
                                        :icon="$imagePath('icons/checked.svg')"></overview-item>
                        <overview-item variant="info" :value="countStats.campaign.total_raised"
                                        :label="$t('total_raised') + ' ' + $t('campaigns')"
                                        :icon="$imagePath('icons/approval.svg')"></overview-item>
                        <overview-item variant="warning" :value="countStats.campaign.total_pending"
                                        :label="$t('total_under_verification_campaigns')"
                                        :icon="$imagePath('icons/pending.svg')"></overview-item>
                        <overview-item variant="danger" :value="countStats.campaign.total_rejected"
                                        :label="$t('total') + ' ' + $t('rejected_campaigns')"
                                        :icon="$imagePath('icons/rejection.svg')"></overview-item>
                    </overview>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="dashboard-section__inner">
                    <div class="dashboard-chart">
                        <div class="dashboard-chart__header">
                            <h5 class="dashboard-chart__title">
                                {{ $t('crowdfunding_growth') }}
                            </h5>
                            <chart-dropdown id="filterRaisedStats"
                                            @filter-data="watchFilterRaisedStats"></chart-dropdown>
                        </div>
                        <div class="p-4" v-if="loadingRaisedStatsChart">
                            <loader></loader>
                        </div>

                        <div v-else class="dashboard-chart__inner">
                            <div class="dashboard-chart__statistics">
                                <div class="dashboard-chart__statistics-row">
                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_raised">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-info"
                                                v-text="getValue(activeChart.total_raised.amount)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('total_raised')"></p>
                                            <span class="overview-additional text-center text-info"
                                                    v-if="activeChart.total_raised.amount">
                                            <span
                                                    class="overview-additional__amount">
                                                <span
                                                        class="overview-additional__amount-label">{{
                                                        $t('online_raised')
                                                    }}</span>
                                                <strong
                                                        class="overview-additional__amount-value"
                                                        v-text="getValue(activeChart.total_raised.online_amount)">
                                                </strong>
                                            </span>

                                            <span
                                                    class="overview-additional__amount">
                                                <span
                                                        class="overview-additional__amount-label">{{
                                                        $t('offline_raised')
                                                    }} </span>
                                                <strong
                                                        class="overview-additional__amount-value"
                                                        v-text="getValue(activeChart.total_raised.offline_amount)">
                                                </strong>
                                            </span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <apex-charts id="growth_chart_raised" height="400px"
                                            v-if="activeChart.total_raised.options.xaxis.categories.length && activeChart.total_raised.series"
                                            :options="activeChart.total_raised.options"
                                            :series="activeChart.total_raised.series"></apex-charts>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="dashboard-section__inner">
                    <div class="dashboard-chart">
                        <div class="dashboard-chart__header">
                            <h5 class="dashboard-chart__title">
                                {{ $t('crowdfunding_growth') }} | <strong class="text-primary">{{
                                        $t('payouts')
                                    }}</strong>
                            </h5>

                            <chart-dropdown id="filterPayoutStats"
                                            @filter-data="watchFilterPayoutStats"></chart-dropdown>
                        </div>
                        <div class="p-4" v-if="loadingPayoutStatsChart">
                            <loader></loader>
                        </div>

                        <div v-else class="dashboard-chart__inner">
                            <div class="dashboard-chart__statistics">
                                <div class="dashboard-chart__statistics-row">
                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_payout">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-primary"
                                                v-text="getValue(activeChart.total_payout.amount)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('total_payout')"></p>
                                        </div>
                                    </div>

                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_payout">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-warning"
                                                v-text="getValue(activeChart.total_payout.pending)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('pending_clearance')"></p>
                                        </div>
                                    </div>

                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_payout && false">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-success"
                                                v-text="getValue(availableToPayout)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('available_to_payout')"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <apex-charts id="growth_chart_payouts" height="400px"
                                            v-if="activeChart.total_payout.options.xaxis.categories.length && activeChart.total_payout.series"
                                            :options="activeChart.total_payout.options"
                                            :series="activeChart.total_payout.series"></apex-charts>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-section" v-if="isOwnerOrTeamMember">
                <div class="dashboard-section__inner">
                    <div class="dashboard-chart">
                        <div class="dashboard-chart__header">
                            <h5 class="dashboard-chart__title">
                                {{ $t('crowdfunding_growth') }} | <strong class="text-warning"
                                                                            v-text="$t('revenue')"></strong>
                            </h5>
                            <chart-dropdown id="filterRevenueStats"
                                            @filter-data="watchFilterRevenueStats"></chart-dropdown>
                        </div>
                        <div class="p-4" v-if="loadingRevenueStatsChart">
                            <loader></loader>
                        </div>

                        <div v-else class="dashboard-chart__inner">
                            <div class="dashboard-chart__statistics">
                                <div class="dashboard-chart__statistics-row">
                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_revenue">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-primary"
                                                v-text="getValue(activeChart.total_revenue.amount)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('total_revenue')"></p>
                                        </div>
                                    </div>

                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_revenue">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-warning"
                                                v-text="getValue(activeChart.total_revenue.tip_amount)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('total_tip_amount')"></p>
                                        </div>
                                    </div>

                                    <div class="dashboard-chart__statistics-row-item"
                                            v-if="activeChart.total_revenue">
                                        <div class="dashboard-chart__card">
                                            <h2 class="dashboard-chart__card-value text-success"
                                                v-text="getValue(activeChart.total_revenue.organization_fee)"></h2>
                                            <p class="dashboard-chart__card-label"
                                                v-text="$t('total_org_commission')"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <apex-charts id="growth_chart_revenue" height="400px"
                                            v-if="activeChart.total_revenue.options.xaxis.categories.length && activeChart.total_revenue.series"
                                            :options="activeChart.total_revenue.options"
                                            :series="activeChart.total_revenue.series"></apex-charts>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </layout-dashboard>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                loading: true,
                orgStats: null,
                totalFundraised: 0,
                totalContributor: 0,
                totalCampaign: 0,
                totalPublishedCampaign: 0,
                walletReceivedTip: null,
                wallet: null
                // filterTypes: {
                //     'all': this.$t('all'),
                //     'today': this.$t('today'),
                //     'yesterday': this.$t('yesterday'),
                //     'last_seven_day': this.$t('last_7_days'),
                //     'this_year': this.$t('this_year'),
                //     'last_year': this.$t('last_year'),
                //     'this_month': this.$t('this_month'),
                //     'last_month': this.$t('last_month'),
                //     'custom': this.$t('custom')
                // },
                // selectedFilter: {
                //     raisedStats: {
                //         dateRange: null,
                //         filter: 'last_seven_day'
                //     },
                //     payoutStats: {
                //         dateRange: null,
                //         filter: 'last_seven_day'
                //     },
                //     revenueStats: {
                //         dateRange: null,
                //         filter: 'last_seven_day'
                //     }
                // },
                // chartStats: {
                //     label: this.$t('last_7_days'),
                //     date: '04 May, 2020 - 11 May, 2020',
                //     total_raised: {
                //         amount: 0,
                //         offline_amount: 0,
                //         online_amount: 0,
                //         options: {
                //             chart: {
                //                 id: 'growth_chart_raised',
                //                 type: 'area',
                //             },
                //             xaxis: {
                //                 categories: []
                //             },
                //             theme: {
                //                 palette: 'palette2'
                //             },
                //             stroke: {
                //                 curve: 'smooth',
                //             },
                //             colors: []
                //         },
                //         series: [],
                //         xaxis: {
                //             type: 'numeric'
                //         }
                //     },
                //     total_payout: {
                //         amount: 0,
                //         pending: 0,
                //         options: {
                //             chart: {
                //                 id: 'growth_chart_payouts',
                //                 type: 'area',
                //             },
                //             xaxis: {
                //                 categories: []
                //             },
                //             theme: {
                //                 palette: 'palette2'
                //             },
                //             stroke: {
                //                 curve: 'smooth',
                //             },
                //             colors: []
                //         },
                //         series: [],
                //     },
                //     total_revenue: {
                //         amount: 0,
                //         organization_fee: 0,
                //         tip_amount: 0,
                //         options: {
                //             chart: {
                //                 id: 'growth_chart_revenue',
                //                 type: 'area',
                //             },
                //             xaxis: {
                //                 categories: []
                //             },
                //             theme: {
                //                 palette: 'palette2'
                //             },
                //             stroke: {
                //                 curve: 'smooth',
                //             },
                //             colors: []
                //         },
                //         series: [],
                //     },
                // },
                // loadingRaisedStatsChart: false,
                // loadingPayoutStatsChart: false,
                // loadingRevenueStatsChart: false,
                // stats: null,
            }
        },
        mounted() {
            this.fetchCountStats();
            this.fetchWallet();
            this.orgCurrency();
            //     this.fetchRaisedStats();
            //     this.fetchPayoutStats();
            //     this.fetchRevenueStats();
        },
        // computed: {
        //     organization() {
        //         return this.$auth.organization
        //     },
            orgCurrency() {
                if (!this.organization) return '$'
                return this.organization.currency_symbol
            },
        //     activeChart() {
        //         return this.chartStats;
        //     },
        //     availableToPayout() {
        //         if (this.countStats) {
        //             return this.countStats.donation.total_online_fundraised - (this.activeChart.total_payout.pending + this.activeChart.total_payout.amount)
        //         }

        //         return 0;
        //     },
        //     isOwnerOrTeamMember() {
        //         return this.organization &&
        //             (this.organization.auth_org_role == 'team_member' || this.organization.auth_org_role == 'owner')
        //     }
        // },
        // watch: {
        //     'organization': function (value) {
        //  if (this.$auth.loggedIn) {
        // this.fetchCountStats();
        //  this.fetchRaisedStats();
        //  this.fetchPayoutStats();
        //  this.fetchRevenueStats();
        //  }
        // },
        // },
        methods: {
            fetchCountStats() {
                this.$axios.get('organization/stats')
                    .then(response => {
                        // console.log(response);
                        this.orgStats = response.data;
                        this.totalFundraised = this.wallet.currency_code + " " + Math.round(this.orgStats.donation.total_fundraised * 100) / 100
                        this.totalContributor = this.orgStats.donation.total_donors
                        this.totalCampaign = this.orgStats.campaign.total
                        this.totalPublishedCampaign = this.orgStats.campaign.total_approved
                        console.log("Ki data pilam",this.orgStats);
                        this.loading = false;
                    })
                    .catch(error => {
                        console.log('error', error)
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            fetchWallet() {
                this.loading = false;
                this.$axios.get(`wallets/view`).then(res => {
                    this.wallet = res.data.wallet
                    console.log("wallet data: ", res.data)
                }).catch(err => {
                    console.log('err::', err)
                }).finally(() => {
                    this.loading = false
                });
            },
            getTipAmount() {
                if (this.orgStats) {
                    return this.wallet.currency_code + " " +Number(this.orgStats.donation.total_tip_amount).toFixed(2)
                }
            }
             // getTipAmount() {
            //     if (this.wallet) {
            //         console.log("My tip amount", this.wallet.formatted_total_tip_amount);
            //         return this.wallet.currency_code + " " +this.wallet.formatted_total_tip_amount
            //     }
            // }
            // fetchRaisedStats() {
            //     let query = {type: this.selectedFilter.raisedStats.filter};

            //     if (this.selectedFilter.raisedStats.filter === 'custom') {
            //         if (!this.selectedFilter.raisedStats.dateRange || !this.selectedFilter.raisedStats.dateRange.start || !this.selectedFilter.raisedStats.dateRange.end) {
            //             this.$warning(null, this.$t('please_select_a_date_range'));
            //             return;
            //         }
            //         query.from_date = this.selectedFilter.raisedStats.dateRange.start;

            //         query.to_date = this.selectedFilter.raisedStats.dateRange.end;
            //     }

            //     this.loadingRaisedStatsChart = true;

            //     let endpoint = route_with_query('organization-contribution-stats', query).absolute_path;
            //     this.$axios.get(endpoint)
            //         .then(response => {
            //             this.setRaisedChartData(response)
            //         })
            //         .catch(error => {
            //             console.log('fetch-error', error)
            //         })
            //         .finally(() => {
            //             this.loadingRaisedStatsChart = false;
            //         });
            // },
            // fetchPayoutStats() {
            //     let query = {type: this.selectedFilter.payoutStats.filter};

            //     if (this.selectedFilter.payoutStats.filter === 'custom') {
            //         if (!this.selectedFilter.payoutStats.dateRange || !this.selectedFilter.payoutStats.dateRange.start || !this.selectedFilter.payoutStats.dateRange.end) {
            //             this.$warning(null, this.$t('select_a_date_range'));
            //             return;
            //         }
            //         query.from_date = this.selectedFilter.payoutStats.dateRange.start;

            //         query.to_date = this.selectedFilter.payoutStats.dateRange.end;
            //     }

            //     this.loadingPayoutStatsChart = true;

            //     let endpoint = route_with_query('organization-payout-stats', query).absolute_path;
            //     this.$axios.get(endpoint)
            //         .then(response => {
            //             this.setPayoutsChartData(response)
            //         })
            //         .catch(error => {
            //             console.log('fetch-error', error)
            //         })
            //         .finally(() => {
            //             this.loadingPayoutStatsChart = false;
            //         });
            // },
            // fetchRevenueStats() {
            //     let query = {type: this.selectedFilter.revenueStats.filter};

            //     if (this.selectedFilter.revenueStats.filter === 'custom') {
            //         if (!this.selectedFilter.revenueStats.dateRange || !this.selectedFilter.revenueStats.dateRange.start || !this.selectedFilter.revenueStats.dateRange.end) {
            //             this.$warning(null, this.$t('please_select_a_date_range'));
            //             return;
            //         }
            //         query.from_date = this.selectedFilter.revenueStats.dateRange.start;

            //         query.to_date = this.selectedFilter.revenueStats.dateRange.end;
            //     }

            //     this.loadingRevenueStatsChart = true;

            //     let endpoint = route_with_query('organization-revenue-stats', query).absolute_path;
            //     this.$axios.get(endpoint)
            //         .then(response => {
            //             this.setRevenueChartData(response)
            //         })
            //         .catch(error => {
            //             console.log('fetch-error', error)
            //         })
            //         .finally(() => {
            //             this.loadingRevenueStatsChart = false;
            //         });
            // },

            // watchFilterRaisedStats(data) {
            //     this.selectedFilter.raisedStats.filter = data.filter
            //     this.selectedFilter.raisedStats.dateRange = data.dateRange
            //     this.fetchRaisedStats();
            // },

            // watchFilterPayoutStats(data) {
            //     this.selectedFilter.payoutStats.filter = data.filter
            //     this.selectedFilter.payoutStats.dateRange = data.dateRange
            //     this.fetchPayoutStats();
            // },

            // watchFilterRevenueStats(data) {
            //     this.selectedFilter.revenueStats.dateRange = data.dateRange
            //     this.selectedFilter.revenueStats.filter = data.filter
            //     this.fetchRevenueStats();
            // },

            // authHasRole(role) {
            //     return this.organization && (role == this.organization.auth_org_role);
            // },

            // setRaisedChartData(response) {
            //     this.chartStats.total_raised.options.xaxis.categories = Object.keys(response.total_raised.data);
            //     this.chartStats.total_raised.amount = response.total_raised.amount;
            //     this.chartStats.total_raised.online_amount = response.total_raised.online_amount;
            //     this.chartStats.total_raised.offline_amount = response.total_raised.offline_amount;
            //     this.chartStats.total_raised.series = [
            //         {
            //             name: this.$t('total_raised'),
            //             data: Object.values(response.total_raised.data)
            //         }
            //     ];

            //     this.chartStats.total_raised.options.colors = ['#33b5e5'];
            // },

            // setPayoutsChartData(response) {
            //     this.chartStats.total_payout.options.xaxis.categories = Object.keys(response.total_payout.data);
            //     this.chartStats.total_payout.amount = response.total_payout.amount;
            //     this.chartStats.total_payout.pending = response.total_payout.pending;
            //     this.chartStats.total_payout.series = [
            //         {
            //             name: this.$t('total_payouts'),
            //             data: Object.values(response.total_payout.data)
            //         }
            //     ];

            //     this.chartStats.total_payout.options.colors = ['#5777f3'];
            // },

            // setRevenueChartData(response) {
            //     this.chartStats.total_revenue.options.xaxis.categories = Object.keys(response.total_revenue.data);
            //     this.chartStats.total_revenue.amount = response.total_revenue.amount;
            //     this.chartStats.total_revenue.tip_amount = response.total_revenue.tip_amount;
            //     this.chartStats.total_revenue.organization_fee = response.total_revenue.organization_fee;
            //     this.chartStats.total_revenue.series = [
            //         {
            //             name: this.$t('total_revenue'),
            //             data: Object.values(response.total_revenue.data)
            //         }
            //     ];

            //     this.chartStats.total_revenue.options.colors = ['#FF9635'];
            // },
            // getValue(amount) {
            //     let currencySymbol = this.organization.currency_symbol ? this.organization.currency_symbol : '$'
            //     let currencyCode = this.organization.currency_code ? this.organization.currency_code : 'USD'
            //     return currencySymbol + Number(amount).toFixed(2) + ' ' + currencyCode
            // }
        },
    })
</script>
