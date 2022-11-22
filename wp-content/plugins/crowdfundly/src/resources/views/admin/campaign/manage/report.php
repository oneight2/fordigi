<template>
    <div class="campaign-report">
        <div class="container">
            <div v-if="!loadedCountries" class="main-loader main-loader--70vh">
                <loader
                        :description="$t('loading') + '...'"
                        class="py-5 my-5">
                </loader>
            </div>
            <div class="campaign-report__inner" v-else>
                <form @submit.prevent="submitReport">
                    <div class="campaign-report_form">
                        <!-- Starts: Single Report Block  -->
                        <div class="campaign-report__block mb-4">
                            <h3 class="campaign-report__block-title" v-text="$t('report_this_campaign')"></h3>
                            <p class="campaign-report__block-text"
                               v-text="$t('examples_of_some_activities_that_may_considered_as_fraudulent')+':'"></p>
                            <ul class="campaign-report__block-list">
                                <li class="campaign-report__block-list-item" v-text="$t('breaking_the_rules')"></li>
                                <li class="campaign-report__block-list-item"
                                    v-text="$t('lying_about_the_benefactor_of_the_publicity__')"></li>
                                <li class="campaign-report__block-list-item"
                                    v-text="$t('posted_with_misleading_statements_in_the_campaign')"></li>
                                <li class="campaign-report__block-list-item"
                                    v-text="$t('does_not_send_timely_funding_to_the_stated_beneficiary_etc')"></li>
                            </ul>
                            <!--                                <p class="campaign-report__block-text"-->
                            <!--                                   v-text="$t('sometimes_there_may_be_situations__') + ':'"></p>-->
                            <!--                                <ul class="campaign-report__block-list">-->
                            <!--                                    <li class="campaign-report__block-list-item"-->
                            <!--                                        v-text="$t('rumors_or_speculations_of_fraud')"></li>-->
                            <!--                                    <li class="campaign-report__block-list-item"-->
                            <!--                                        v-text="$t('disagreement_with_the_nature__')"></li>-->
                            <!--                                    <li class="campaign-report__block-list-item"-->
                            <!--                                        v-text="$t('custody_or_familial_disputes_and_disagreements')"></li>-->
                            <!--                                </ul>-->
                            <p class="campaign-report__block-text"
                               v-text="$t('to_report_a_campaign_for_fraud__')"></p>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="reporter-full-name" class="form-group campaign-report__block">
                            <label for="full-name" class="campaign-report__block-label"
                                   v-text="$t('your_full_name')+'*'"></label>
                            <input
                                    v-model.trim="report.name"
                                    type="text"
                                    id="full-name"
                                    maxlength="100"
                                    class="form-control campaign-report__block-input"
                                    :placeholder="$t('enter_your_full_name')"
                                    required/>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="reporter-phone-number" class="form-group campaign-report__block">
                            <label for="phone-number" class="campaign-report__block-label mb-1"
                                   v-text="$t('your_phone_number')+'*'"></label>
                            <p class="campaign-report__block-subtitle"
                               v-text="$t('required_in_case_our_team_needs__')"></p>
                            <div class="row">
                                <div class="col-4 pr-1">
                                    <v-select id="country_code"
                                              class="form-control form-control__mobile-code"
                                              :placeholder="$t('select_code')"
                                              :options="countryMobileCodes"
                                              :reduce="item => item.country_id"
                                              label="full_info"
                                              v-model="report.contact_number_code"
                                              :required="true"
                                              :value="$store.id">
                                        <template #search="{attributes, events}">
                                            <input
                                                    class="vs__search"
                                                    :required="!report.contact_number_code"
                                                    v-bind="attributes"
                                                    v-on="events"
                                            />
                                        </template>
                                    </v-select>
                                </div>
                                <div class="col-8 pl-1">
                                    <input
                                            v-model.trim="report.contact_number"
                                            type="tel"
                                            oninput="javascript: this.value = this.value.replace(/[^0-9]/gi, '');"
                                            onchange="javascript: this.value = this.value.replace(/[^0-9]/gi, '');"
                                            step="1"
                                            maxlength="15"
                                            id="phone-number"
                                            class="form-control campaign-report__block-input"
                                            :placeholder="$t('enter_your_phone_number')"
                                            required/>
                                </div>
                            </div>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="reporter-email" class="form-group campaign-report__block">
                            <label for="email" class="campaign-report__block-label"
                                   v-text="$t('your_email_number')+'*'"></label>
                            <input
                                    v-model.trim="report.email"
                                    type="email"
                                    id="email"
                                    maxlength="100"
                                    class="form-control campaign-report__block-input"
                                    :placeholder="$t('enter_your_email_address')"
                                    required/>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="reporter-relation" class="form-group campaign-report__block">
                            <label class="campaign-report__block-label"
                                   v-text="$t('do_you_know_the_campaign_organizer')"></label>

                            <div class="radio radio--secondary d-inline-flex">
                                <input
                                        v-model="report.knows_fundraiser"
                                        class="radio__input"
                                        name="organizer-relationship"
                                        type="radio"
                                        value="1"
                                        id="organizer-relationship-yes"
                                        required/>
                                <label class="radio__label" for="organizer-relationship-yes"
                                       v-text="$t('yes')"></label>
                            </div>
                            <div class="radio radio--secondary d-inline-flex">
                                <input
                                        v-model="report.knows_fundraiser"
                                        class="radio__input"
                                        name="organizer-relationship"
                                        type="radio"
                                        value="0"
                                        id="organizer-relationship-no"
                                        required/>
                                <label class="radio__label" for="organizer-relationship-no"
                                       v-text="$t('no')"></label>
                            </div>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="relation-desc" class="form-group campaign-report__block"
                             v-if="report.knows_fundraiser == '1'">
                            <label for="organizer-relation-desc" class="campaign-report__block-label"
                                   v-text="$t('please_explain_your_relationship_to_the_campaign_or_campaign_organizer')"></label>
                            <textarea
                                    v-model.trim="report.relationship_explanation"
                                    id="organizer-relation-desc"
                                    class="form-control campaign-report__block-input"
                                    :placeholder="$t('write_here')+'...'"
                                    rows="4"
                                    maxlength="250"
                                    required>
                            </textarea>
                            <p class="campaign-report__block-help text-right pr-2"
                               v-text="report.relationship_explanation.length + '/250'"></p>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="select-describe" class="form-group campaign-report__block">
                            <label class="campaign-report__block-label"
                                   v-text="$t('which_best_describes_you')"></label>
                            <div class="radio radio--secondary"
                                 v-for="(reporterTypeId, index) in Object.keys(reporterTypes)" :key="index">
                                <input
                                        v-model="report.reporter_type"
                                        class="radio__input"
                                        name="select-describes"
                                        type="radio"
                                        :value="reporterTypeId"
                                        :id="'select-describes-donor-' + index"
                                        required/>
                                <label class="radio__label" :for="'select-describes-donor-' + index"
                                       v-text="reporterTypes[reporterTypeId]"></label>
                            </div>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="reporter-concern" class="form-group campaign-report__block">
                            <label for="concern" class="campaign-report__block-label"
                                   v-text="$t('describe_your_concerns_about_this_campaign')"></label>
                            <textarea
                                    v-model.trim="report.report"
                                    id="concern"
                                    class="form-control campaign-report__block-input"
                                    :placeholder="$t('write_here')+'...'"
                                    rows="4"
                                    maxlength="250"
                                    required>
                            </textarea>
                            <p class="campaign-report__block-help text-right pr-2"
                               v-text="report.report.length + '/250'"></p>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="reporter-involve" class="form-group campaign-report__block">
                            <label class="campaign-report__block-label"
                                   v-text="$t('are_you_involved_in_a_legal_dispute_with_the_campaign_organizer')"></label>

                            <div class="radio radio--secondary d-inline-flex">
                                <input
                                        v-model="report.legal_dispute_to_fundraiser"
                                        class="radio__input"
                                        name="organizer-involve"
                                        type="radio"
                                        value="1"
                                        id="organizer-involve-yes"
                                        required/>
                                <label class="radio__label" for="organizer-involve-yes" v-text="$t('yes')"></label>
                            </div>
                            <div class="radio radio--dark d-inline-flex">
                                <input
                                        v-model="report.legal_dispute_to_fundraiser"
                                        class="radio__input"
                                        name="organizer-involve"
                                        type="radio"
                                        value="0"
                                        id="organizer-involve-no"
                                        required/>
                                <label class="radio__label" for="organizer-involve-no" v-text="$t('no')"></label>
                            </div>
                        </div>
                        <!-- Ends: Single Report Block  -->

                        <!-- Starts: Single Report Block  -->
                        <div id="campaign-violate" class="form-group campaign-report__block">
                            <label class="campaign-report__block-label"
                                   v-text="$t('does_the_campaign_violate_crowdfundlys_terms_and_conditions')"></label>
                            <div class="radio radio--secondary d-inline-flex">
                                <input
                                        v-model="report.violates_rule"
                                        class="radio__input"
                                        name="report-violate"
                                        type="radio"
                                        value="1"
                                        id="campaign-violate-yes"
                                        required/>
                                <label class="radio__label" for="campaign-violate-yes" v-text="$t('yes')"></label>
                            </div>
                            <div class="radio radio--dark d-inline-flex">
                                <input
                                        v-model="report.violates_rule"
                                        class="radio__input"
                                        name="report-violate"
                                        type="radio"
                                        value="0"
                                        id="campaign-violate-no"
                                        required/>
                                <label class="radio__label" for="campaign-violate-no" v-text="$t('no')"></label>
                            </div>
                        </div>

                        <!-- Starts: Form Error Box  -->
                        <form-error-box></form-error-box>
                        <!-- Ends: Form Error Box  -->

                        <div class="campaign-report__block-action full-width">
                            <loading-button
                                    :disabled="processing"
                                    :loading="processing"
                                    :title="$t('submit')"
                                    type="submit"
                                    class="btn btn-primary btn-min-50 min-200">
                            </loading-button>
                        </div>
                        <!-- Ends: Single Report Block  -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import FormErrorBox from '~/components/FormErrorBox'
    import {REPORTER_TYPES, TYPE_DONOR} from "~/enum/Report";
    import * as CountryEnum from "~/enum/Country";
    import {mapGetters} from 'vuex';

    export default {
        layout: 'campaign-view',
        components: {
            'form-error-box': FormErrorBox
        },
        middleware: 'auth',
        data() {
            return {
                campaign: null,
                loading: false,
                loadedCountries: false,
                processing: false,
                reporterTypes: REPORTER_TYPES,
                countryMobileCodes: [],
                report: {
                    name: null,
                    contact_number: null,
                    contact_number_code: 240,
                    email: null,
                    knows_fundraiser: "0",
                    legal_dispute_to_fundraiser: "0",
                    violates_rule: "0",
                    relationship_explanation: '',
                    report: '',
                    reporter_type: TYPE_DONOR,
                    campaign_id: null,
                }
            }
        },
        head() {
            return {
                title: this.$t('report'),
                meta: [
                    {
                        property: 'og:title',
                        hid: 'og:title',
                        content: this.$t('report')
                    },
                ],
            }
        },
        async mounted() {
            await this.fetchCampaign()
        },
        created() {
            this.fetchCountries();
        },
        computed: {
            subdomain() {
                let domain = window.location.host.split('.')
                if (domain[0].length > 3) {
                    return domain[0]
                }
            },
        },
        methods: {
            async fetchCampaign() {
                this.getSlugFromUrl = window.location.pathname.split('/')[2]

                let endpoint = {}
                if (this.getSlugFromUrl) {
                    endpoint = route(
                        "get-campaign-by-slug",
                        this.getSlugFromUrl
                    );
                } else {
                    endpoint = route(
                        "get-campaign-by-slug",
                        this.$route.params.slug
                    );
                }
                await this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.campaign = res.data
                        this.report.campaign_id = this.campaign.id;
                        this.$emit('campaign', {
                            id: this.campaign.id,
                            slug: this.campaign.slug,
                            organization: this.campaign.organization,
                            auth_member_of_org: this.campaign.auth_member_of_org ? this.campaign.auth_member_of_org : false
                        })
                    })
                    .catch(async (e) => {
                        throw new Error(this.$t('campaign_not_found'));
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            fetchCountries() {
                this.$axios
                    .get('/countries')
                    .then(response => {
                        this.countryMobileCodes = this.formatCountryMobileCodes(response)
                        this.countryMobileCodes.map((item) => {
                            return item.full_info = '+' + item.code + ' (' + item.country + ')';
                        });
                        this.loadedCountries = true;
                    })
                    .catch(async error => {
                        await this.$error(this.$t('unable_to_prepare_data'))
                        this.$router.push('/')
                    })
            },
            submitReport() {
                this.processing = true;
                let endpoint = route_with_query('report-campaign').absolute_path;
                this.report.contact_number_code = (this.countryMobileCodes.find(item => item.country_id == this.report.contact_number_code)).code;
                this.$axios
                    .post(endpoint, this.report)
                    .then(response => {
                        this.$success(null, response.message)
                        window.location.href = 'http://' + this.subdomain + '.' + baseDomain() + '/campaigns/' + this.$route.params.slug
                        this.resetForm();
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error));
                    })
                    .finally(() => {
                        this.processing = false
                    })
            },
            formatCountryMobileCodes(countries) {
                return countries.map(item => {
                    return {
                        country_id: item.id,
                        country: item.short_name,
                        code: Number(item.country_mobile_code),
                    }
                });
            },
            resetForm() {
                this.report = {
                    name: this.$auth.loggedIn ? this.$auth.user.name : null,
                    contact_number: null,
                    contact_number_code: CountryEnum.DEFAULT_MOBILE_CODE,
                    email: this.$auth.loggedIn ? this.$auth.user.email : null,
                    knows_fundraiser: "0",
                    legal_dispute_to_fundraiser: "0",
                    violates_rule: "0",
                    relationship_explanation: '',
                    report: '',
                    reporter_type: TYPE_DONOR,
                    campaign_id: this.campaign.id,
                }
            }
        },
    }
</script>