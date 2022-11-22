<div id="campaignDashboard" class="campaign-offline-donation">
    <layout-campaign variant="dashboard">
        <div class="campaign-dashboard-page">
            <div class="campaign-dashboard-page__loader" v-if="loading && !donations.length">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-else class="campaign-dashboard-page__inner">
                <div class="campaign-dashboard-page__header">
                    <h4 class="campaign-dashboard-page__header-title">Offline Contributions</h4>
                    <div class="d-flex align-center">
                        <c-button variant="primary" title="View Campaign"
                                  @onpress="$redirectToCampaign($params('slug'))"></c-button>
                        <c-button variant="primary" class="ml-2" @onpress="$showDialog('addOfflineDonation')">
                            <i class="mdi mdi-plus"></i> Add
                        </c-button>
                    </div>
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
                            @pagination-change-page="fetchDonations"
                            @update-limit="updateLimit"
                            :loading="loading">

                        <template slot="placeholder">
                            <c-section-placeholder></c-section-placeholder>
                        </template>

                        <tr v-for="(donation, i) in donations" :key="i">
                            <td v-text="getFormattedDate(donation.created_at)" class="text-nowrap"></td>
                            <td class="text-nowrap">
                            <span v-if="donation.is_anonymous" class="donated-anonymously" v-html="donation.name + '<br> (Contributed Anonymously)'">
                         </span>
                        <div v-else>
                            <span v-text="donation.name"></span>
                        </div>
                            </td>
                            <td class="text-nowrap" v-text="donation.email"></td>
                            <td class="text-nowrap" v-text="donation.address"></td>
                            <td v-text="$getFormattedCurrency(donation.amount, donation.currency)"
                                class="text-nowrap"></td>
                            <td>{{ donation.is_anonymous ? 'Yes' : 'No' }}</td>
                        </tr>
                    </table>
                </div>

                <offline-donation-modal id="addOfflineDonation"
                                        v-if="campaign"
                                        :campaign="campaign"
                                        :currency="campaign.currency"
                                        @submitted="fetchDonations"
                ></offline-donation-modal>
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
                blueprint: null,
                limit: 10,
                donations: [],
                campaign: {},
                selectedDonation: null,
                headers: [
                    {text: 'Time In UTC', sortable: true, sortKey: 'created_at'},
                    {text: 'Contributor Name', sortable: true, sortKey: 'full_name'},
                    {text: 'Email', sortable: true, sortKey: 'email'},
                    {text: 'Address', sortable: true, sortKey: 'address'},
                    {text: 'Amount', sortable: true, sortKey: 'amount'},
                    {text: 'Anonymous', sortable: false, sortKey: 'is_anonymous'},
                ]
            };
        },
        created() {
            this.fetchCampaign()
                .then(() => {
                    this.initialFetchContributions();
                })
        },
        methods: {
            initialFetchContributions(page = 1) {
                this.loading = true;
                this.fetchDonations(page).finally(() => {
                    this.loading = false;
                })
            },
            async fetchDonations(page = 1) {
                return this.$axios
                    .$get(`/campaigns/${this.$params('slug')}/offline-donations?per_page=${this.limit}&page=${page}`)
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
            fetchCampaign() {
                this.loading = true
                return this.$store.dispatch('campaign/fetch', this.$params('slug'))
                    .then(campaign => {
                        campaign.currency = {
                            currency_code: campaign.currency_code,
                            currency_symbol: campaign.currency_symbol
                        }
                        this.campaign = campaign
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    });
</script>