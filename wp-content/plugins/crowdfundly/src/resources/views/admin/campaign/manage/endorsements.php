<div id="campaignDashboard">
    <campaign-dashboard-layout>
        <div class="campaign-dashboard-page campaign-dashboard-page--chat-presets">
            <div class="main-loader main-loader--70vh" v-if="loading">
                <loader :description="$t('loading') + '...'"></loader>
            </div>

            <div v-else class="campaign-dashboard-page__inner">
                <div
                        class="campaign-dashboard-page__header d-flex align-items-center justify-content-between flex-wrap">
                    <h4 class="campaign-dashboard-page__header-title mb-0" v-text="$t('endorsements')"></h4>
                    <a-link class="btn btn-primary"
                            target="_blank"
                            v-if="organization && organization.username"
                            :href="'#'"
                            v-text="$t('view_campaign')"
                    ></a-link>
                </div>

                <section-placeholder
                        v-if="!endorsements.length"
                        :description="$t('no_endorsement_found_for_this_campaign')"
                        icon="fas fa-user-check"
                        class="white">
                </section-placeholder>

                <div v-else class="row">
                    <div class="col-12 col-md-6" v-for="(endorsement,_) in endorsements" v-bind:key="_">
                        <endorsement
                                :is-org-member="campaign.auth_member_of_org"
                                :auth-org-role="campaign.organization.auth_org_role"
                                :endorsement="endorsement">
                        </endorsement>
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
                campaign: {},
                isLoading: false,
                processing: false,
                loading: false,
                max_preset_count: 100,
                campaignUpdatesCount: 0,
                activitiesCount: 0,
                endorsements: [],
            };
        },
        computed: {
            organization(){
                return this.$auth.organization
            },
            selectedCampaign(){
                return this.$store.getters.selectedCampaign
            },
            domainName() {
                return baseDomain()
            },
        },
        async mounted() {
            this.loading = true
            await this.fetchCampaign();
            if (this.campaign) {
                await this.fetchEndorsements();
            }
            this.loading = false;
        },
        methods: {
            async fetchCampaign() {
                let endpoint = route_with_query('get-auth-campaign', null, this.selectedCampaign.slug).absolute_path;
                await this.$axios
                    .get(endpoint)
                    .then(result => {
                        this.campaign = result;
                        this.campaignUpdatesCount = this.campaign.updates_count;
                        this.activitiesCount = this.campaign.activities_count;
                    })
                    .catch(error => {
                        this.$error(null,getMessageFromError(error))
                        // throw this.$nuxtException(getMessageFromError(error))
                    })
            },
            async fetchEndorsements() {
                const dest = route('campaigns-endorsements', this.campaign.id);
                const url = dest.absolute_path + '?show_all=true';

                await this.$axios[dest.method](url)
                    .then(res => {
                        this.endorsements = res.data;
                        this.approvedEndorsementCount = res.data.approved_count;
                    })
                    .catch(e => {
                        const msg = form_errors_to_array(e).join("");
                    });
            },
        }
    });
</script>