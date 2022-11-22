<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <div class="dashboard-contributions">
            <page-header title="<?php _e( 'Online Contributions', 'crowdfundly' ); ?>"></page-header>
            
            <table
            is="c-data-table"
            id="online-contributions-list"
            v-model:limit="limit"
            :headers='headers'
            :data='contributions'
            :pagination="blueprint"
            @pagination-change-page="fetchAllOnlineContributions"
            @update-limit="updatelimit"
            :loading="loading">
                <template slot="header">
                    <form @submit.prevent="applyFilter">
                        <div class="d-flex flex-wrap align-items-center">
                            <c-filter-search v-model="filter.value"></c-filter-search>
                            <c-filter-select placeholder="Filter By" :options="$getAvailableFilterStatus()" label="label" value-key="value" v-model="filter.status"></c-filter-select>
                            <c-filter-search-select v-if="campaigns != null" id="campaign"  :placeholder="plceholder" :options="campaigns" :reduce="campaign => campaign.id" label="name" @selected-value="setSearchSelectValue">
                            </c-filter-search-select>

                            <c-button class="c-filter-item" variant="success" title="Apply" :loading="loading"
                                      type="submit" transparent></c-button>

                            <c-button class="c-filter-item" variant="danger" title="Reset" :loading="loading" type="reset" @onpress="resetFilter" transparent></c-button>
                        </div>
                    </form>
                </template>
                <template slot="placeholder">
                    <c-section-placeholder></c-section-placeholder>
                </template>
                <tr v-for="(contribution,idx) in contributions" :key="idx">
                    <td class="text-nowrap" v-text="_createdAt(contribution.created_at)"></td>
                    <td class="text-nowrap">
                        <span >
                            <a v-html="getContributorName(contribution)"></a>
                        </span>
                    </td>
                    <td class="text-nowrap" v-text="donorEmail(contribution)"></td>
                    <td class="text-nowrap" v-text="amount(contribution)"></td>
                    <td class="text-nowrap" v-text="$getFormattedCurrency(contribution.tip_amount,contribution)"
                        v-if="isOwnerOrTeamMember"></td>
                    <td class="text-nowrap" v-if="isOwnerOrTeamMember" v-html="fee(contribution)"></td>
                    <td class="text-nowrap">
                        <a :href="$campaignUrl(contribution.campaign.slug)" class="a-link" target="_blank"
                           v-text="contribution.campaign.name"></a>
                    </td>

                    <!-- reward col-->
                    <td class="text-nowrap">
                        <span v-if="contribution.offer" @click="openOfferModal(contribution)"
                              class="contribution-offer-show-span">
                            {{contribution.offer.title}}
                        </span>
                        <span v-else class="text-warning">N/A</span>
                    </td>

                    <!-- addtional information col -->
                    <td class="text-nowrap">
                        <span v-if="contribution.form_inputs && contribution.form_inputs.length && hasAdditionalInfo(contribution)"
                              class="contribution-offer-show-span" @click="openAdditionalInfoModal(contribution)"
                              v-text="'view'">

                        </span>
                        <span v-else class="text-warning">N/A</span>
                    </td>
                    <td class="text-nowrap" v-text="refId(contribution)"></td>
                    <td v-text="$getPymentGateway(contribution.transaction.source)"></td>

                    <!-- message col -->
                    <td class="text-nowrap">
                        <span v-if="contribution.message" class="contribution-offer-show-span"
                              @click="openMessageModal(contribution)" v-text="'view'">
                        </span>
                        <span v-else class="text-warning">N/A</span>
                    </td>
                    <td class="text-nowrap">
                        <c-pill :label="$getContributionStatus(contribution.status)"
                                :variant="$getContributionStatusColor(contribution.status)"></c-pill>
                    </td>
                    <td>
                        <c-dropdown-action :id="`dropdown_${idx+1}`">
                            <c-dropdown-item variant="primary" @onpress="openRefundModal(contribution)">
                                <span class="mdi mdi-cash-refund mr-2"></span>
                                Refund
                            </c-dropdown-item>
                        </c-dropdown-action>
                    </td>
                </tr>
            </table>

            <vue-advance-dialog id="offer-dialog" position="top-center" size="xs" title="Reward Details">

                <div class="offer-details" v-if="offer">
                    <div class="offer-details__img">
                        <img :src="coverPhoto(offer.image)" alt="img" class="offer-details__img--img">
                    </div>
                    <div class="offer-details__body">
                        <h4 class="offer-details__title">
                            {{ offer.title }}
                        </h4>
                        <div class="offer-details__price d-flex">
                            <h5 class="offer-details__price-new">{{ offer.currency_symbol }}{{ offer.offer_price }}</h5>
                            <h5 class="offer-details__price-old ">{{ offer.currency_symbol }}{{ offer.regular_price
                                }}</h5>
                        </div>
                        <p class="offer-details__description" v-html="showDescription(offer.description)">
                            {{ showDescription(offer.description) }}
                        </p>

                        <div class="offer-details__shipping" v-if="offer.is_shipping">
                            <div class="d-flex align-items-center">
                                <h5 class="offer-details__shipping-title" v-text="'Customer Details'">

                                </h5>
                            </div>
                        </div>
                        <div class="d-flex">
                            <label v-text="'Email'" class="text-dark text-bold mb-0"></label>:
                            {{ customer.email }}
                        </div>
                        <div class="d-flex">
                            <label v-text="'Name'" class="text-dark text-bold"></label>:
                            {{ customer.name }}
                        </div>
                        <div class="d-flex" v-if="offerDonation.shipping_location">
                            <label v-text="'Shipping Location'" class="text-dark text-bold"></label>:
                            {{ offerDonation.shipping_location }}
                        </div>
                        <div class="d-flex mt-2" v-if="offerDetails && offerDetails.shipping_info">
                            <label v-text="'Shipping Address'" class="text-dark text-bold"></label>:
                            {{ getShippingAddress(offerDetails?.shipping_address) }}
                            <!-- <span class="offer-details__shipping-address">{{ getShippingAddress(offerDetails?.shipping_address) }}</span> -->
                        </div>
                        <div class="d-flex" v-if="offerDonation.shipping_amount">
                            <label v-text="'Shipping Fee'" class="text-dark text-bold"></label>:
                            {{ offer.currency_symbol }} {{ offerDonation.shipping_amount }}
                            
                        </div>
                        <div v-if="offerDetails && offerDetails.offer_form_inputs">
                            <div v-for="(item,i) in offerDetails.offer_form_inputs" class="elements" :key="i">
                                <label v-text="item.label + ':'"
                                       class="text-dark text-bold text-capitalize mb-0"></label>
                                <span v-text="item.value" style="line-break: anywhere;line-height: 1.2rem"> </span>
                            </div>
                        </div>

                    </div>
                </div>
            </vue-advance-dialog>
            <vue-advance-dialog id="additional-info" position="top-center" size="xs" title="Additional Information">
                <div v-for="info in additionalInfo" :key="info.label">
                    <label><b v-text="info.label+': '"></b></label>
                    <span v-text="info.value"></span>
                </div>
            </vue-advance-dialog>
            <vue-advance-dialog id="message-dialog" position="top-center" size="xs" title="Message">
                <div v-if="donorMessage">
                    <p v-text="donorMessage" class="offer-details__message">
                    </p>
                </div>
            </vue-advance-dialog>
            <refund-modal id="refund-modal" title="Refund Note"></refund-modal>
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
                    status: null,
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
                headers: [
                    {text: 'Time In UTC', sortable: true, sortKey: 'created_at'},
                    {text: 'Contributor Name', sortable: true, sortKey: 'full_name'},
                    {text: 'Conributor Email', sortable: true, sortKey: 'email'},
                    {text: 'Amount', sortable: true, sortKey: 'amount'},
                    {text: 'Tip amount', sortable: true, sortKey: 'tip_amount', hide: false},
                    {text: 'Fee', sortable: false, hide: false},
                    {text: 'Campaign', sortable: true, sortKey: 'campaign.name'},
                    {text: 'Selected Offer', sortable: false},
                    {text: 'Additional Information', sortable: false},
                    {text: 'Ref Id', sortable: false},
                    {text: 'Gateway', sortable: true, sortKey: 'transaction.source'},
                    {text: 'Message', sortable: false},
                    {text: 'Status', sortable: true, sortKey: 'status'},
                    {text: 'Actions', sortable: false},

                ],
                campaigns: [],
                plceholder: "Campaigns",
                offerDonation: {},
                offer: {},
                offerDetails: {},
                customer: {},
                donorMessage: null,
                additionalInfo: null,
                selectedContribution:{}
            }
        },
        methods: {
            getContributorName(contributor){
                console.log("Contributor", contributor);
                if(contributor.is_anonymous==1 && ! contributor.full_name){
                 return `Contributed Anonymously`
                }
                if(contributor.is_anonymous==1 && contributor.full_name){
                 return contributor.full_name + `<br /> (Contributed Anonymously)`;
                }
                if(contributor.is_anonymous==0 && contributor.full_name== ""){
                 return `Contributed Anonymously`
                }
                return contributor.full_name;
            },
            async fetchInitialOnlineContributions(page = 1) {
                this.loading = true;
                await this.fetchAllOnlineContributions(page).finally(() => {
                    this.loading = false
                })
            },
            async fetchAllOnlineContributions(page = 1) {
                let params = {
                    per_page: this.limit,
                    page
                }

                for (const filterKey in this.filter) {
                    if (!this.filter[filterKey]) {
                        continue
                    }
                    params[filterKey] = this.filter[filterKey]
                }

                return this.$axios.$get('/auth-org-donations', {
                    params
                })
                    .then(res => {
                        const {
                            data,
                            ...blueprint
                        } = res;
                        console.log({res})
                        this.contributions = data;
                        this.blueprint = blueprint;
                        this.currentPage = page;
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            _createdAt(dateTimeObject) {
                return this.$moment(dateTimeObject).format("MMM Do YY")
            },
            donorName(contribution) {
                return contribution.full_name;
            },
            donorEmail(contribution) {
                return contribution.email;
            },
            amount(contribution) {
                return $getFormattedCurrency(contribution.amount - contribution.tip_amount);
            },
            isOwnerOrTeamMember() {
                if (!this.$auth.organization) return false;
                return this.$auth.organization.auth_org_role == 'team_member' || this.$auth.organization.auth_org_role == 'owner';
            },
            fee(contribution) {
                let orgFee = 'Organization Fee' + ": " + this.$getFormattedCurrency(contribution.organization_fee, contribution);
                let gatewayFee = 'Payment Gateway Fee' + ": " + this.$getFormattedCurrency(contribution.transaction.payment_gateway_processing_fee, contribution);
                return (
                    orgFee + "<br>" + gatewayFee
                );
            },
            hasAdditionalInfo(info) {
                if (!info.form_inputs) return false;
                let data = info.form_inputs
                for (let i in data) {
                    if (data[i].value) {
                        return true
                    }
                    break
                }
                return false
            },
            transaction(contribution) {
                return contribution.transaction;
            },
            refId(contribution) {
                return this.transaction(contribution).ref_id
            },
            updatelimit(value) {
                this.limit = value;
                this.fetchAllOnlineContributions();
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
            setSearchSelectValue(value) {
                this.filter.campaign_id = value
            },
            applyFilter() {
                this.fetchInitialOnlineContributions(1);
                this.$forceUpdate();
            },
            openOfferModal(donation) {
                console.log("log====: ",donation);
                this.offerDonation = donation
                this.offer = donation.offer_info
                this.offer.currency_code = donation.currency_code
                this.offer.currency_symbol = donation.currency_symbol
                this.offer.image = donation.offer?.image?.source_path
                this.offerDetails = donation.offer_info
                // console.log("offerDetails.shipping_info: ",this.offerDetails?.shipping_address?.address)
                this.customer = {
                    email: donation.email,
                    name: donation.full_name
                }

                this.$eventHub.$emit('show-dialog', 'offer-dialog')
            },
            openAdditionalInfoModal(donation) {
                let data = []

                if (donation.form_inputs) {
                    data = [...data, ...donation.form_inputs]
                }
                if (donation.offer_info && donation.offer_info.offer_form_inputs) {
                    data = [...data, ...donation.offer_info.offer_form_inputs]
                }
                this.additionalInfo = data
                this.$eventHub.$emit('show-dialog', 'additional-info')
            },
            openMessageModal(donation) {
                this.donorMessage = donation.message
                if (this.donorMessage) {
                    this.$eventHub.$emit('show-dialog', 'message-dialog')
                }
            },

            coverPhoto(image) {
                if (image) {
                    if (image.source_path) {
                        return image.source_path
                    }
                    return image
                }

                return this.$assets('/images/placeholder/bg.png');
            },
            showDescription(data) {
                try {
                    return JSON.parse(data);
                } catch (e) {
                    return data;
                }
            },

            getShippingAddress(address) {
                if (!address) return '';
                let fullAddress

                if (address.address) {
                    fullAddress = address.address
                }
                if (address.state) {
                    fullAddress = fullAddress + ', ' + address.state
                }
                if (address.city) {
                    fullAddress = fullAddress + ', ' + address.city
                }
                if (address.zip_code) {
                    fullAddress = fullAddress + ', ' + address.zip_code
                }
                if (address.country) {
                    fullAddress = fullAddress + ', ' + address.country
                }
                return fullAddress;
            },
            async resetFilter() {
                this.loading = true;
                this.filter.campaign_id = null
                this.filter.value = null
                this.filter.status = null

                await this.fetchAllOnlineContributions(1).finally(() => {
                    this.loading = false
                });
                this.$forceUpdate()
            },
            openRefundModal(contribution){
                this.selectedContribution = contribution
                this.$showDialog('refund-modal')
            },
            refund(){
                console.log("refund contribution", this.selectedContribution)
            }

        },
        created() {
            this.fetchInitialOnlineContributions()
            this.fetchAuthCampaigns()
            // console.log('organzation auth_org_role: ',this.$auth.organization.auth_org_role)
        }
    })
</script>