<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="campaign-reports">
            <page-header :title="$t('campaign_reports')"></page-header>

            <div class="datatable">

                <div class="datatable__header">
                    <!-- ------ Starts: Campaign Filter Section ------ -->
                    <form @submit.prevent="fetchReports(1)">
                        <g-filter>
                            <div class="d-flex flex-wrap align-center flex-1">
                                <filter-search v-model="filter.search" @button-clicked="fetchReports(1)"
                                               @reset="resetFilter()"></filter-search>
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
                                v-if="reports.length === 0"
                                :title="$t('sorry')"
                                :description="$t('no_report_found')"
                                icon="fas fa-bullhorn "
                                class="white height-400">
                        </section-placeholder>

                        <table v-else>
                            <thead>
                            <tr>
                                <th class="text-center" v-text="$t('report_date')"></th>
                                <th class="text-center" v-text="$t('campaign')"></th>
                                <th class="text-center" v-text="$t('reporter_name')"></th>
                                <th class="text-center" v-text="$t('reporter_email')"></th>
                                <th class="text-center" v-text="$t('details')"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(report, index) in reports" :key="index">
                                <td class="text-center" style="min-width: 100px">
                                    <span v-text="formatDate(report.created_at)"></span>
                                </td>
                                <td style="min-width: 250px">
                                    <a :href="$campaignUrl(report.campaign.slug)"
                                       class="d-flex align-items-center justify-content-center" target="_blank">
                                    <span
                                            v-text="report.campaign.name"
                                            class="text-primary text-center">
                                    </span>
                                    </a>
                                </td>
                                <td class="text-center" style="min-width: 150px">
                                    <span v-text="report.name"></span>
                                </td>
                                <td class="text-center" style="min-width: 150px">
                                    <span v-text="report.email"></span>
                                </td>
                                <td class="text-center" style="min-width: 90px">
                                    <button class="btn btn-info btn--icon br-5" @click="viewReport(report)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="datatable__footer" v-if="paginator">
<!--                    <span class="datatable__footer__info">-->
<!--                        {{ $t('showing') }} <strong>{{-->
<!--                            reports.length-->
<!--                        }}</strong> {{ $t('of') }} <strong>{{ reports.length }}</strong>-->
<!--                    </span>-->
                    <pagination :data="paginator" :limit="1" @pagination-change-page="fetchReports"></pagination>
                </div>
            </div>

            <g-modal
                    id="viewReportModal"
                    size="md"
                    :title="$t('report_details')"
                    :footer="false">

                <div class="campaign-reports__modal" v-if="selectedReport">

                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-user campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('name')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span
                                v-text="selectedReport.name"
                                class="campaign-reports__modal-value">
                    </span>
                    </div>
                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-envelope campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('email')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value" v-text="selectedReport.email"></span>
                    </div>
                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-phone-alt campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('phone')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value"
                              v-text="'+' + selectedReport.contact_number_code + selectedReport.contact_number"></span>
                    </div>
                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-bullhorn  campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('reported_Campaign')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <a :href="'http://'+selectedReport.campaign.organization.username +'.'+ domainName + '/campaigns/'+selectedReport.campaign.slug"
                           class="campaign-reports__modal-value" v-text="selectedReport.campaign.name"
                           target="_blank"></a>
                    </div>
                    <div class="campaign-reports__modal-single campaign-reports__modal-single--question">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-check-double campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('knows_the_organizer')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value"
                              v-text="selectedReport.knows_fundraiser == '1' ? $t('yes') : $t('no')"></span>
                    </div>
                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-check-double campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('explained_relation')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value"
                              v-text="selectedReport.relationship_explanation"></span>
                    </div>
                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-check-double campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('reporter_describes')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value"
                              v-text="$enum.Report.REPORTER_TYPES[selectedReport.reporter_type]"></span>
                    </div>
                    <div class="campaign-reports__modal-single">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-file-alt campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text" v-text="$t('concern')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value" v-text="selectedReport.report"></span>
                    </div>
                    <div class="campaign-reports__modal-single campaign-reports__modal-single--full">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-check-double campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text"
                              v-text="$t('did_reporter_involve_in_a_legal_dispute_with_the_campaign_organizer')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value"
                              v-text="selectedReport.legal_dispute_to_fundraiser == '1' ? 'Yes':'No'"></span>
                    </div>
                    <div class="campaign-reports__modal-single campaign-reports__modal-single--full">
                    <span class="campaign-reports__modal-label">
                        <i class="fas fa-check-double campaign-reports__modal-label-icon"></i>
                        <span class="campaign-reports__modal-label-text"
                              v-text="$t('did_the_campaign_violate_crowdfundlys_terms_and_conditions')"></span>
                    </span>
                        <span class="pr-1" v-text="':'"></span>
                        <span class="campaign-reports__modal-value"
                              v-text="selectedReport.violates_rule == '1' ? $t('yes') : $t('no')"></span>
                    </div>
                </div>
            </g-modal>
        </div>
    </dashboard-layout>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                paginator: null,
                loading: false,
                perPage: 10,
                timeFormat: 'D MMM YYYY',
                selectedReport: null,
                reports: [],
                filter: {
                    search: null,
                },
            }
        },
        computed: {
            organization() {
                return this.$auth.organization
            },
            domainName() {
                return this.$baseDomain()
            }
        },
        async created() {
            await this.fetchReports();
        },
        mounted() {
            if (this.organization.auth_org_role == 'fundraiser') {
                this.$redirect('dashboard')
            }
        },
        methods: {
            async fetchReports(page = 1) {
                this.loading = true;
                let query = {
                    per_page: this.perPage,
                    page: page,
                }
                if (this.filter.search) {
                    query.search = this.filter.search
                }
                let url = route_with_query('org-all-reports', query).absolute_path;

                await this.$axios
                    .get(url)
                    .then(response => {
                        this.reports = response.data;
                        this.paginator = response;
                    })
                    .catch(error => {
                        this.$error(getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },
            formatDate(timeStamp) {
                return this.$moment(timeStamp).format(this.timeFormat)
            },

            viewReport(report) {
                this.selectedReport = report;
                this.$showModal('viewReportModal')
            },
            resetFilter() {
                this.filter.search = null;
                this.fetchReports(1);
            },
        },
    })
</script>