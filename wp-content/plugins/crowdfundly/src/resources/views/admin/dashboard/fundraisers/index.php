<!-- 
Note: Menu has been removed from wp admin cf submenu. 
TODO: This file will be remeved in future -->
<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="dashboard-campaigns">
            <page-header :title="$t('fundraiser')" style="justify-content: flex-start">
                <small v-if="!isFundraiserEnabled"
                       class="status status--sm status--primary ml-1 text-bold"
                       v-text="$t('upgrade')"></small>
            </page-header>
            <div>
                <div class="datatable">
                    <div class="datatable__header">
                        <!-- ------ Starts: Campaign Filter Section ------ -->
                        <form @submit.prevent="applyFilter">
                            <g-filter>
                                <div class="d-flex flex-wrap align-center flex-1">
                                    <filter-search v-model="filter.search"
                                                   @button-clicked="applyFilter"
                                                   @reset="resetFilter('search')"></filter-search>
                                    <div class="filter__item">
                                        <div class="date-range">
                                            <date-range-picker
                                                    v-model="filter.date"
                                                    range
                                                    format="DD-MM-YYYY"
                                                    formatted="DD-MM-YYYY"
                                                    no-label
                                                    color="#ec7070"
                                                    button-color="#adc45b"
                                                    right
                                                    :label="$t('select_a_date_range')"></date-range-picker>
                                        </div>
                                    </div>
                                    <filter-button :title="$t('apply_filter')" type="submit"></filter-button>
                                    <filter-button :title="$t('reset_all')" type="reset"
                                                   @on-press="resetFilter"></filter-button>
                                </div>
                            </g-filter>
                        </form>
                        <!-- ------ Ends: Campaign Filter Section ------ -->
                    </div>

                    <div class="datatable__inner">

                        <div v-if="loading" class="main-loader main-loader--60vh">
                            <loader></loader>
                        </div>

                        <div v-else>
                            <section-placeholder
                                    v-if="fundraisers.length === 0"
                                    :title="$t('sorry')"
                                    :description="$t('no_fundraiser_found')"
                                    icon="fas fa-address-book"
                                    class="white height-400">
                            </section-placeholder>

                            <table v-else>
                                <thead>
                                <tr>
                                    <th class="text-nowrap" v-text="$t('name')"></th>
                                    <th v-text="$t('email')"></th>
                                    <th v-text="$t('total_campaigns')"></th>
                                    <th v-text="$t('successful_campaigns')"></th>
                                    <th v-text="$t('raised_amount')"></th>
                                    <th v-text="$t('joined_at')"></th>
                                    <th class="text-center" v-text="$t('actions')" v-if="true"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(fundraiser, i) in fundraisers" v-bind:key="i">
                                    <td class="min-300">
                                        <a style="cursor: pointer;"
                                           @click="redirectToProfile(fundraiser.user.username)"
                                           target="_blank"
                                           class="d-flex align-items-start justify-content-start">
                                                        <span v-text="fundraiser.user.name"
                                                              class="text-primary text-left"></span>
                                        </a>
                                    </td>
                                    <td class="text-nowrap" v-text="fundraiser.user.email"></td>
                                    <td class="text-nowrap" v-text="fundraiser.user.campaigns.length"></td>
                                    <td class="text-nowrap"
                                        v-text="fundraiser.user.successful_campaigns"></td>
                                    <td class="text-nowrap text-info" v-if="organization"
                                        v-text="$showAmount(fundraiser.user.total_raised_amount,organization.currency_symbol) + ' ' + organization.currency_code"></td>
                                    <td class="text-nowrap" v-text="_createdAt(fundraiser.created_at)"></td>
                                    <td class="text-center">
                                        <action>
                                            <action-item-link
                                                    link="#"
                                                    icon="fa-user"
                                                    :title="$t('view_profile')"
                                                    type="primary"
                                            ></action-item-link>
                                            <action-item-link
                                                    link="#"
                                                    icon="fa-bars"
                                                    :title="$t('view_campaigns')"
                                                    type="primary"
                                                    v-if="organization"
                                            ></action-item-link>
                                        </action>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="datatable__footer" v-if="fundraisers.length > 0">
                        <span class="datatable__footer__info" v-if="blueprint.total > 0">
                            {{ $t('showing') }} <strong>{{
                                fundraisers.length
                            }}</strong> {{ $t('of') }} <strong>{{ blueprint.total }}</strong>
                        </span>
                        <pagination v-if="blueprint" :limit="1" :data="blueprint"
                                    @pagination-change-page="fetchAllFundraisers"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </dashboard-layout>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                loading: true,
                fundraisers: [],
                blueprint: {},
                mapper: {
                    creator_column: "creator"
                },
                perPage: 20,
                processingDenial: false,
                filter: {
                    search: null,
                    sort_by: null,
                    filter_by: null,
                    date: null
                },
                resetSortBy: false,
                resetFilterBy: false,
                currentPage: 1,
                isFundraiserEnabled: true,
            };
        },
        computed: {
            organization() {
                return this.$auth.organization
            },
            domainName() {
                return baseDomain()
            },
        },
        async created() {
            this.fetchAllFundraisers(this.currentPage);

        },
        methods: {
            _createdAt(dateTimeObject) {
                return this.$moment(dateTimeObject).format(baseTimeStampFormat());
            },
            fetchAllFundraisers(page = 1) {
                this.loading = true;
                let query = {
                    per_page: this.perPage,
                    page: page
                }
                if (this.filter.search) {
                    query.search = this.filter.search
                }
                if (this.filter.filter_by) {
                    query.filter_by = this.filter.filter_by
                }
                if (this.filter.sort_by) {
                    query.sort_by = this.filter.sort_by
                }
                if (this.filter.date) {
                    query.from = this.filter.date.start
                    query.till = this.filter.date.end
                }

                const endpoint = route_with_query("get-org-fundraisers", query);
                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(async res => {
                        const {data, ...blueprint} = res;
                        this.fundraisers = data;
                        this.blueprint = blueprint;
                        this.currentPage = page;
                        await this.checkPlan('fundraiser', [res.total], 'isFundraiserEnabled')
                    })
                    .catch(e => {
                        console.error(e);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            redirectToProfile(username) {
                let routeData = this.$router.resolve({
                    name: "user-username-story",
                    params: {username}
                })
                window.open(routeData.href, '_blank');
            },
            redirectToCampaign(orgUsername, username) {
                let location = `http://${orgUsername}.${this.domainName}/campaigns?username=${username}`
                window.open(location, '_blank');
            },

            /* -------------- Starts: Campaign Filter methods -------------- */
            searchBtnClicked(value) {
                console.log("search button clicked", value);
            },
            sortBy(value) {
                this.filter.sort_by = value;
            },
            filterBy(value) {
                this.filter.filter_by = value;
            },
            resetFilter(type = null) {
                if (type) {
                    this.filter[type] = null
                    return this.fetchAllFundraisers(1);
                }
                this.filter.search = null;
                this.filter.date = null;
                this.filter.sort_by = null;
                this.filter.filter_by = null;
                this.resetSortBy = true;
                this.resetFilterBy = true;
                const _this = this;
                setTimeout(() => {
                    _this.resetSortBy = false;
                    _this.resetFilterBy = false;
                }, 500);
                this.fetchAllFundraisers(1);
            },
            applyFilter() {
                this.fetchAllFundraisers(1);
            },
            updateAt(timestamp) {
                if (!timestamp) {
                    return this.$t("n_a");
                }
                return this.$moment(timestamp).format(baseTimeStampFormat());
            },
            async checkPlan(permission, params, key) {
                return await get_plan_value(permission, params)
                    .then(value => {
                        this[key] = value
                    })

            }
        }
    });
</script>