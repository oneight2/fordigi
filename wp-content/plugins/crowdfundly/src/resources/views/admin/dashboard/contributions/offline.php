<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <div class="dashboard-contributions">
            <page-header title="Offline Contributions"></page-header>
            <table is="c-data-table" id="offline-contributions-list" v-model:limit="limit" :headers='headers' :data='contributions' :pagination="blueprint" @pagination-change-page="fetchAllOfflineContributions" @update-limit="updatelimit" :loading="loading">
                <template slot="header">
                    <form @submit.prevent="applyFilter">
                        <div class="d-flex flex-wrap align-items-center">
                            <c-filter-search v-model="filter.value"></c-filter-search>
                            <c-filter-search-select v-if="campaigns != null" id="campaign"  :placeholder="plceholder" :options="campaigns" :reduce="campaign => campaign.id" label="name" @selected-value="setSearchSelectValue">
                            </c-filter-search-select>

                            <c-button class="c-filter-item" variant="success" title="Apply" :loading="loading" type="submit" transparent></c-button>

                            <c-button class="c-filter-item" variant="danger" title="Reset" :loading="loading" type="reset" transparent @onpress="resetFilter"></c-button>
                        </div>
                    </form>
                </template>

                <template slot="placeholder">
                    <c-section-placeholder></c-section-placeholder>
                </template>

                <tr v-for="(contribution,idx) in contributions" :key="idx">
                     <td class="text-nowrap" v-text="_createdAt(contribution.created_at)"></td>
                     <td class="no-wrap">
                         <span v-if="contribution.is_anonymous" class="donated-anonymously" v-html="donorName(contribution) + '<br> (Contributed Anonymously)'">
                         </span>
                        <div v-else>
                            <span v-text="donorName(contribution)"></span>
                        </div>

                     </td>
                     <td class="text-nowrap" v-text="donorEmail(contribution)"></td>
                     <td class="text-nowrap" v-text="$getFormattedCurrency(contribution.amount,contribution)"></td>
                     <td class="text-nowrap">
                        <a :href="$campaignUrl(contribution.campaign.slug)" class="a-link" target="_blank" v-text="contribution.campaign.name"></a>
                    </td>
                    <td>
                        <c-dropdown-action :id="`dropdown_${idx+1}`">
                           <c-dropdown-item variant="primary" @onpress="editOfflineContribution(contribution)">
                                <span class="mdi mdi-square-edit-outline mr-2"></span>
                                Edit
                            </c-dropdown-item>
                            <c-dropdown-item variant="danger" @onpress="deleteContribution(contribution.id)">
                                <span class="mdi mdi-delete mr-2"></span>
                                Delete
                            </c-dropdown-item>
                        </c-dropdown-action>
                    </td>
                </tr>
            </table>
            <offline-donation-modal id="editOfflineContributionModal" v-if="selectedContribution" :current-data="selectedContribution" :currency="selectedContribution.currency" :campaign="selectedContribution.campaign" @submitted="fetchAllOfflineContributions"></offline-donation-modal>
        </div>
    </layout-dashboard>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                limit: 10,
                filter: {
                    value: null,
                    campaign_id: null
                },
                filters: [{
                        label: 'All',
                        value: 'all'
                    },
                    {
                        label: 'Refunded',
                        value: 'refunded'
                    },

                    {
                        label: 'Pending',
                        value: 'pending'
                    },
                ],
                contributions: [],
                blueprint: {},
                currentPage: 1,
                loading: false,
                headers: [{
                        text: 'Time In UTC',
                        sortable: true,
                        sortKey: 'created_at'
                    },
                    {
                        text: 'Contributor Name',
                        sortable: true,
                        sortKey: 'full_name'
                    },
                    {
                        text: 'Conributor Email',
                        sortable: true,
                        sortKey: 'email'
                    },
                    {
                        text: 'Amount',
                        sortable: true,
                        sortKey: 'amount'
                    },
                    {
                        text: 'Campaign',
                        sortable: true,
                        sortKey: 'campaign.name'
                    },
                    {
                        text: 'Actions',
                        sortable: false
                    },

                ],
                campaigns: [],
                plceholder: "Campaigns",
                offerDonation: {},
                offer: {},
                offerDetails: {},
                customer: {},
                donorMessage: null,
                additionalInfo: null,
                selectedContribution: {
                    campaign:{},
                    currency:{}
                },
                editingCurrency:{},
                campaign:{}
            }
        },
        methods: {
            async fetchInitialOfflineContributions(page = 1) {
                this.loading = true
                await this.fetchAllOfflineContributions(page).finally(() => {
                    this.loading = false
                })
            },
            async fetchAllOfflineContributions(page=1){
                let params = {
                    per_page: this.limit,
                    page
                }

                for (const filterKey in this.filter) {
                    console.log("filterKey: ",filterKey)
                    if (!this.filter[filterKey]) {
                        continue
                    }
                    params[filterKey] = this.filter[filterKey]
                }

                // console.log("params: ",params)

                return this.$axios.get('auth-org-offline-donations',{params})
                       .then(res=>{
                           console.log("offile_contributions: ",res.data.data);
                            const {data, ...blueprint} =  res.data;
                            this.contributions = data;
                            this.blueprint = blueprint;
                            this.currentPage = page
                            console.log("blueprint: ",this.blueprint)
                        })
                        .catch(err=> console.log(err));
            },
            _createdAt(dateTimeObject) {
                return this.$moment(dateTimeObject).format("MMM Do YY")
            },
            donorName(contribution) {
                return contribution.name;
            },
            donorEmail(contribution) {
                return contribution.email;
            },
            updatelimit(value) {
                console.log("value: ",value)
                this.limit = value;
                this.fetchAllOfflineContributions();
            },
            async fetchAuthCampaigns() {
                await this.$axios.get("/campaign", {
                    params: {
                        no_limit: 1,
                        organization: this.$auth.organization.id
                    }
                }).then(res => {
                    this.campaigns = res.data
                }).catch(err => {
                    console.log("error in fetch all capaign: ", err)
                })
            },
            applyFilter() {
                this.fetchInitialOfflineContributions(1);
                this.$forceUpdate();
            },
            resetFilter() {
                this.filter.campaign_id = null
                this.filter.value = null
                this.fetchInitialOfflineContributions(1);
                this.$forceUpdate()
            },
            setSearchSelectValue(value){
                this.filter.campaign_id = value
            },
            async editOfflineContribution(contribution){
                contribution.currency.currency_symbol = contribution.currency.symbol
                await Promise.all([ this.selectedContribution = contribution])
                this.$showDialog('editOfflineContributionModal')
                console.log("selectedContribution: ",this.selectedContribution)
            },
            deleteContribution(id) {
                console.log("deleting..")
                this.$axios.$delete(`offline-donations/${id}`)
                    .then(response => {
                        this.$cfNotify('success','Contribution Removed',response.message)
                        this.fetchAllOfflineContributions()
                    })
                    .catch((e) => {
                       console.log(e)
                    })
            },
        },
        created() {
            this.fetchInitialOfflineContributions();
            this.fetchAuthCampaigns();
        }
    })
</script>
