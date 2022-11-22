<div id="campaignDashboard">
    <layout-campaign variant="dashboard">
        <div class="campaign-dashboard-page">
            <div class="campaign-dashboard-page__loader" v-if="loading">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-else class="campaign-dashboard-page__inner">
                <transition name="fade">
                    <form @submit.prevent="updateCampaign" v-if="!isFormOpen && !isPackageFormOpen">
                        <!--Basic-->
                        <div class="campaign-dashboard-page__section">
                            <div class="campaign-dashboard-page__section-header d-flex">
                                <h3 class="campaign-dashboard-page__section-title flex-1">
                                    <?php _e( 'Basic', 'crowdfundify' ); ?>
                                </h3>

                                <c-button variant="primary" title="<?php _e( 'View Campaign', 'crowdfundify' ); ?>"
                                          @onpress="$redirectToCampaign($params('slug'))"></c-button>
                            </div>

                            <div class="campaign-dashboard-page__section-inner">
                                <div class="row">
                                    <div class="col-12">
                                        <c-input
                                        required
                                        label="<?php _e( 'Campaign Name', 'crowdfundify' ); ?>"
                                        placeholder="<?php _e( 'Write your campaign title', 'crowdfundify' ); ?>"
                                        id="campaignName"
                                        type="text"
                                        v-model="campaign.name"
                                        maxlength="150"></c-input>
                                    </div>

                                    <div v-if="campaign.type === $campaignTypes.FUNDRAISE"
                                         class="col-12">
                                        <c-input
                                        required
                                        type="text"
                                        label="<?php _e( 'Target Amount', 'crowdfundify' ); ?>"
                                        placeholder="0"
                                        id="targetAmount"
                                        v-model="campaign.target_amount"
                                        input-inner-class="amount-input"
                                        input-class="amount-input__input">
                                        <c-search-select
                                        v-model="campaign.currency_id"
                                        label="full_info"
                                        :reduce="currency => currency.id"
                                        :options="currencies"
                                        placeholder="Currency"
                                        class="amount-input__currency"
                                        disabled
                                        required>
                                        </c-search-select>
                                        </c-input>
                                    </div>
                                    <div v-else class="col-12 col-sm-6 col-md-5 col-xl-3">
                                        <c-input-group required label="Currency">
                                            <c-search-select
                                                    placeholder="Currency"
                                                    :options="currencies"
                                                    :reduce="currency => currency.id"
                                                    label="full_info"
                                                    disabled
                                                    required
                                                    v-model="campaign.currency_id"></c-search-select>
                                        </c-input-group>
                                    </div>

                                    <div v-if="campaign.type === $campaignTypes.FUNDRAISE"
                                         class="col-12 col-sm-12 col-md-12 col-lg-6">
                                        <c-input-group required label="<?php _e( 'Duration', 'crowdfundify' ); ?>">
                                            <div class="new-campaign__duration">
                                                <div class="v-input-group__inner new-campaign__duration-radio-group">
                                                    <c-radio
                                                    class="mr-3"
                                                    name="duration-type"
                                                    id="ongoing"
                                                    required
                                                    label="<?php _e( 'On going', 'crowdfundify' ); ?>"
                                                    :default-value="false"
                                                    v-model="hasDeadline"></c-radio>

                                                    <c-radio
                                                    name="duration-type"
                                                    id="deadline"
                                                    required
                                                    label="<?php _e( 'Deadline', 'crowdfundify' ); ?>"
                                                    :default-value="true"
                                                    v-model="hasDeadline">
                                                    </c-radio>
                                                </div>

                                                <c-date-time-picker v-if="hasDeadline" v-model="campaign.target_date"
                                                                    only-date format="YYYY-MM-DD"
                                                                    formatted="YYYY-MM-DD"
                                                                    locale="en"
                                                                    no-label color="#5777f3"
                                                                    button-color="#5777f3"
                                                                    label="<?php _e( 'Select date', 'crowdfundify' ); ?>"
                                                                    :min-date="$moment().add(1,'days').format('YYYY-MM-DD').toString()"
                                                                    required></c-date-time-picker>
                                            </div>
                                        </c-input-group>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-3 col-xl-2"
                                         v-if="campaign.type !== $campaignTypes.FUNDRAISE">
                                        <c-input-group required label="<?php _e( 'Recurring', 'crowdfundify' ); ?>" class="mb-0">
                                            <div class="v-input-group__inner d-flex align-items-center">
                                                <c-radio class="mr-3" name="recurring" id="recurringOn" required
                                                         label="<?php _e( 'On', 'crowdfundify' ); ?>"
                                                         :default-value="true"
                                                         v-model="campaign.options.recurring"></c-radio>

                                                <c-radio name="recurring" id="recurringOff" required label="<?php _e( 'Off', 'crowdfundify' ); ?>"
                                                         :default-value="false"
                                                         v-model="campaign.options.recurring"></c-radio>
                                            </div>
                                        </c-input-group>
                                    </div>

                                    <div class="col-12">
                                        <c-input-group required label="<?php _e( 'Payment Gateway', 'crowdfundify' ); ?>" class="mb-0">
                                            <div class="new-campaign__payment-gateways">
                                                <c-payment-gateways
                                                :icon-path="$assets()"
                                                :selected-gateways="selectedGateways"
                                                :gateways="paymentGateways"
                                                @select="selectPaymentGateway">
                                                    <div v-if="gatewayNotConfig">
                                                        <span>{{ gatewayNotConfig }} <?php _e( 'is not configured.', 'crowdfundify' ); ?> </span>
                                                        <a :href="$redirect('settings-payment', {}, 'url')"><?php _e( 'set configaration', 'crowdfundify' ); ?></a>
                                                    </div>
                                                </c-payment-gateways>
                                            </div>
                                        </c-input-group>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Media-->
                        <div class="campaign-dashboard-page__section">
                            <div class="campaign-dashboard-page__section-header">
                                <h3 class="campaign-dashboard-page__section-title"><?php _e( 'Media', 'crowdfundify' ); ?></h3>
                            </div>

                            <div class="campaign-dashboard-page__section-inner">
                                <div class="row">
                                    <div class="col-12 col-xl-3">
                                        <c-input-group required label="<?php _e( 'Thumbnail', 'crowdfundify' ); ?>" label-for="campaignThumbnail">
                                            <image-picker media-key="thumbnail" id="campaignThumbnail"
                                                          v-model="campaign.options.gallery.thumbnail"
                                                          :image="currentCampaign.options.gallery.thumbnail"
                                                          :aspect-ratio="16 / 9"></image-picker>
                                        </c-input-group>
                                    </div>
                                    <div class="col-12">
                                        <c-input-group label="<?php _e( 'Upload Image/Video', 'crowdfundify' ); ?>" required class="mb-0">
                                            <template v-slot:label>
                                                <small class="text-primary">(Max 10 images/Links)</small>
                                                <br>
                                                <small><?php _e( 'You can drag & drop image & video link', 'crowdfundify' ); ?></small>
                                            </template>

                                            <div class="new-campaign__image-section">
                                                <gallery-uploader
                                                        :gallery="currentCampaign.options.gallery.media || []"
                                                        source="campaign"
                                                        v-model="campaign.options.gallery.media"></gallery-uploader>
                                            </div>
                                        </c-input-group>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Story-->
                        <div  class="campaign-dashboard-page__section">
                            <div class="campaign-dashboard-page__section-header">
                                <h3 class="campaign-dashboard-page__section-title"><?php _e( 'Story', 'crowdfundify' ); ?></h3>
                            </div>

                            <div class="campaign-dashboard-page__section-inner">
                                <c-input-group label="Write Campaign story" :required="campaign.type === $campaignTypes.FUNDRAISE" class="mb-0">
                                    <vue-editor id="privacyPolicyData" class="w-full" :data="campaign.options.story"
                                                v-model="campaign.options.story"></vue-editor>
                                </c-input-group>
                            </div>
                        </div>

                        <!--Additional Info-->
                        <div v-if="campaign.type === $campaignTypes.FUNDRAISE" class="campaign-dashboard-page__section">
                            <div class="campaign-dashboard-page__section-header">
                                <h3 class="campaign-dashboard-page__section-title"><?php _e( 'Additional Info', 'crowdfundify' ); ?></h3>
                            </div>

                            <div class="campaign-dashboard-page__section-inner bg-transparent p-0">
                                <form-creator id="campaignCreate"
                                              :data="currentCampaign.options.dynamic_form || false"
                                              v-model="campaign.options.dynamic_form"></form-creator>
                            </div>
                        </div>

                        <!--submit-->
                        <div class="campaign-dashboard-page__section">
                            <div class="campaign-dashboard-page__section-footer">
                                <button class="c-button c-button--dark">
                                    <a :href="$redirect('campaigns', {}, 'url')" class="text-white">
                                        <?php _e( 'Cancel', 'crowdfundly' ); ?>
                                    </a>
                                </button>
                                <div class="d-flex" v-if="currentCampaign.status!==20">
                                    <c-button
                                    :btn-class="'mr-4'"
                                    variant="black"
                                    title="<?php echo esc_attr__( 'Save As Draft', 'crowdfundly' ); ?>"
                                    :loading="saving"
                                    :disabled="processing"
                                    @onPress="submitStatus=0"
                                    type="submit">
                                    </c-button>
                                    <c-button
                                    variant="primary"
                                    title="<?php echo esc_attr__( 'Publish', 'crowdfundly' ); ?>"
                                    :loading="publishing"
                                    :disabled="processing"
                                    @onPress="submitStatus=20"
                                    type="submit">
                                    </c-button>
                                </div>
                                <div class="d-flex" v-if="currentCampaign.status==20">
                                    <c-button
                                    variant="primary"
                                    title="<?php echo esc_attr__( 'Update', 'crowdfundly' ); ?>"
                                    :loading="processing"
                                    :disabled="processing"
                                    type="submit">
                                    </c-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </transition>

                <!--Reward-->
                <div id="rewardUpdate" v-if="campaign.type === $campaignTypes.FUNDRAISE"
                     class="campaign-dashboard-page__section">
                    <div class="campaign-dashboard-page__section-header">
                        <h3 class="campaign-dashboard-page__section-title">
                            <?php _e( 'Reward', 'crowdfundly' ); ?>
                        </h3>
                    </div>

                    <div class="campaign-dashboard-page__section-inner bg-transparent p-0">
                        <div class="new-campaign__rewards" v-if="!isFormOpen">
                            <div class="new-campaign__rewards-row">
                                <div class="new-campaign__rewards-row-item"
                                v-for="(reward, i) in currentCampaign.rewards" :key="i" >
                                    <div class="reward-card">
                                        <div class="reward-card__header">
                                            <h5 class="reward-card__title" v-text="reward.title"></h5>
                                            <c-dropdown :id="`reward_dropdown_${i+1}`"
                                                        class="reward-card__header-action">
                                                <template v-slot:toggle>
                                                    <div class="reward-card__header-action-button">
                                                        <span class="mdi mdi-dots-vertical"></span>
                                                    </div>
                                                </template>
                                                <c-dropdown-item
                                                variant="info"
                                                title="<?php echo esc_attr__( 'Edit', 'crowdfundly' ); ?>"
                                                @onpress="editReward(reward)">
                                                </c-dropdown-item>
                                                <c-dropdown-item
                                                variant="danger"
                                                title="<?php echo esc_attr__( 'Delete', 'crowdfundly' ); ?>"
                                                @onpress="deleteReward(reward.id)">
                                                </c-dropdown-item>
                                            </c-dropdown>
                                        </div>

                                        <div class="reward-card__banner" v-if="reward.image"
                                             :style="'background-image: url('+reward.image.url+')'">
                                            <span class="reward-card__status"><?php _e( 'Stock', 'crowdfundly' ); ?> {{ reward.stock }}</span>
                                        </div>

                                        <div class="reward-card__price">
                                            <span class="reward-card__price-key">
                                                <?php _e( 'Price:', 'crowdfundly' ); ?>
                                            </span>
                                            <div class="d-flex align-items-center">
                                                <span
                                                class="reward-card__price-value"
                                                v-text="$getFormattedCurrency(reward.offer_price, currentCampaign)">
                                                </span>
                                                <span
                                                class="reward-card__price-value--old"
                                                v-text="$getFormattedCurrency(reward.regular_price, currentCampaign)">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="reward-card__inner">
                                            <p class="reward-card__description" v-html="reward.description"></p>

                                            <div class="reward-card__shipping"
                                                 v-for="(shipping, shipping_i) in reward.shipping_info"
                                                 :key="shipping_i">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span class="reward-card__shipping-title">
                                                            <?php _e( 'Shipping to', 'crowdfundly' ); ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span
                                                        class="reward-card__shipping-value"
                                                        v-text="shipping.location">
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <span class="reward-card__shipping-title">
                                                            <?php _e( 'Shipping Fee', 'crowdfundly' ); ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span
                                                        class="reward-card__shipping-value"
                                                        v-text="'$'+shipping.shippingFee">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="new-campaign__rewards-row-item">
                                    <div class="reward-card reward-card--add">
                                                <c-button
                                                variant="primary"
                                                class="reward-card__add-button"
                                                @onpress="toggleCreateForm">
                                            <span class="mdi mdi-plus-circle mr-2"></span>
                                            <?php _e( 'Add new reward', 'crowdfundly' ); ?>
                                        </c-button>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="new-campaign__rewards-row-item"> -->
                                <!-- <div class="reward-card reward-card--add">
                                    <c-button
                                    variant="primary"
                                    class="reward-card__add-button"
                                    @onpress="toggleCreateForm">
                                        <span class="mdi mdi-plus-circle mr-2"></span>
                                        <?php _e( 'Add new reward', 'crowdfundly' ); ?>
                                    </c-button>
                                </div> -->
                            <!-- </div> -->
                        </div>

                        <reward-creator
                        v-if="isFormOpen"
                        :current-data="selectedReward"
                        @closed="toggleCreateForm">
                        </reward-creator>
                    </div>
                </div>

                <!--Packages-->
                <div id="packageUpdate" v-if="campaign.type === $campaignTypes.SPONSOR"
                     class="campaign-dashboard-page__section">
                     <div class="campaign-dashboard-page__section-header">
                        <h3 class="campaign-dashboard-page__section-title">
                            <?php _e( 'Package', 'crowdfundly' ); ?>
                        </h3>
                    </div>

                    <div class="new-campaign__packages" v-if="!isPackageFormOpen">
                        <div class="new-campaign__packages-row">
                            <div class="new-campaign__packages-row-item"
                                 v-for="(item, i) in currentCampaign.packages" :key="i">
                                <div class="package-card" style="margin-bottom: 10px;">
                                    <div class="package-card__header">
                                        <h5 class="package-card__title" v-text="item.name"></h5>

                                        <c-dropdown :id="`package_dropdown_${i+1}`" class="package-card__header-action">
                                            <template v-slot:toggle>
                                                <div class="package-card__header-action-button">
                                                    <span class="mdi mdi-dots-vertical"></span>
                                                </div>
                                            </template>
                                            <c-dropdown-item
                                            variant="info"
                                            title="<?php _e( 'Edit', 'crowdfundly' ); ?>"
                                            @onpress="editPackage(item)"></c-dropdown-item>
                                            <c-dropdown-item
                                            variant="danger"
                                            title="<?php _e( 'Delete', 'crowdfundly' ); ?>"
                                                             @onpress="deletePackage(item.id)"></c-dropdown-item>
                                        </c-dropdown>
                                    </div>

                                    <div class="package-card__banner" v-if="item.image && item.image.url"
                                         :style="'background-image: url('+item.image.url+')'">
                                    </div>

                                    <div class="package-card__inner">
                                        <div class="package-card__price">
                                            <span class="package-card__price-key">
                                                <?php _e( 'Price:', 'crowdfundly' ); ?>
                                            </span>
                                            <span
                                            class="package-card__price-value"
                                            v-text="$getFormattedCurrency(item.price,currentCampaign)">
                                            </span>
                                        </div>
                                        <p class="package-card__description" v-html="item.description"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="new-campaign__packages-row-item">
                                <div class="package-card package-card--add">
                                    <c-button
                                            class=" package-card__add-button"
                                            @onpress="togglePackageCreateForm"
                                            type="button">
                                        <span class="mdi mdi-plus-circle mr-2"></span>
                                        <?php _e( 'Add new Package', 'crowdfundly' ); ?>
                                    </c-button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <package-creator
                    v-if="isPackageFormOpen"
                    :current-data="selectedPackage"
                    @closed="togglePackageCreateForm">
                    </package-creator>
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
                processing: false,
                hasDeadline: false,
                isFormOpen: false,
                selectedReward: null,
                paymentGateways: this.$paymentGateways,
                selectedGateways: [],
                selectedPackage: false,
                isPackageFormOpen: false,
                gatewayNotConfig: null,
                availableGateways: [],
                campaign: {
                    type: 2,
                    name: null,
                    target_amount: null,
                    target_date: null,
                    currency_id: null,
                    currency_code: null,
                    status: null,
                    organization_id: null,
                    packages: [],
                    rewards: [],
                    options: {
                        gallery: null,
                        presets: null,
                        story: null,
                        flyer: null,
                        dynamic_form: null,
                        recurring: false,
                        gateways: []
                    }
                },
                submitStatus: null,
                newThumbnail: null,
                saving: false,
                publishing: false,
            };
        },
        async created() {
            if (!this.$params('slug')) {
                this.$redirect('campaigns')
            }
            this.loading = true
            this.getPaymentGateways()
            await this.$store.dispatch('currencies/fetch')
            await this.$store.dispatch('campaign/fetch', this.$params('slug'))
                .then(campaign => {
                    this.campaign = campaign
                    if (campaign.options.gateways.length == 0 && this.availableGateways.length > 0) {
                        this.selectedGateways = this.availableGateways
                    }
                    if (campaign.options.gateways.length > 0) {
                        this.selectedGateways = campaign.options.gateways
                    }
                    this.hasDeadline = !!campaign.target_date
                })
                .finally(() => {
                    this.loading = false
                })
        },
        computed: {
            ...this.$mapState({
                currencies: state => state.currencies.data,
                currentCampaign: state => state?.campaign?.current,
            }),
        },
        methods: {
          
            // for reward
            toggleCreateForm() {
                this.selectedReward = null
                this.isFormOpen = !this.isFormOpen
                this.$forceUpdate()
                this.$scrollIntoView('rewardUpdate', 100)
            },
            editReward(reward) {
                this.selectedReward = reward
                this.isFormOpen = true
            },
            deleteReward(id) {
                this.$store.dispatch('campaign/deleteReward', id)
                    .then(() => {
                        this.$forceUpdate()
                    })
            },
            //
            // for packages
            togglePackageCreateForm() {
                this.selectedPackage = null
                this.isPackageFormOpen = !this.isPackageFormOpen
                this.$forceUpdate()
                this.$scrollIntoView('packageUpdate')
            },
            editPackage(item) {
                this.selectedPackage = item
                this.isPackageFormOpen = true
            },
            deletePackage(id) {
                this.$store.dispatch('campaign/deletePackage', id)
                    .then(() => this.$forceUpdate())
            },
            selectPaymentGateway(key) {
                if (this.selectedGateways.includes(key)) {
                    const index = this.selectedGateways.indexOf(key)
                    this.selectedGateways.splice(index, 1)
                    return;
                }
                const hasGateway = this.availableGateways.indexOf(key)
                if (hasGateway > -1) {
                    this.gatewayNotConfig = null
                    this.selectedGateways.push(key)
                } else {
                    this.gatewayNotConfig = key
                }
            },
            getPaymentGateways() {
                const bodyParams = {
                    action: 'action=cf_update_payment_gateway',
                    nonce: '&security=' + this.$auth.nonce,
                }

                this.$axios.post(
                    this.$auth.ajax_url,
                    bodyParams.action + bodyParams.nonce,
                    {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
                )
                .then(async res => {
                    this.availableGateways = res.data
                })
                .catch(error => {
                    this.$cfNotify('error', null, error.message)
                    console.log('err::', error);
                });
            },
            async updateCampaign() {
                if(this.campaign.type === this.$campaignTypes.FUNDRAISE && !this.campaign.options.story){
                    return this.$cfNotify('warn', null, 'Campaign story is required')
                }
                 if (!this.selectedGateways.length) {
                    return this.$cfNotify('warn', null, 'You must select at least 1 payment gateway.')
                }
                 let thumbnail = await this.$store.dispatch('media/upload', {key: 'thumbnail'});
                // if (this.currentThumbnail) {
                //     this.campaign.options.gallery.thumbnail = this.currentThumbnail;
                // } 
                if (!this.campaign.options.gallery.thumbnail?.hasOwnProperty('url')) {
                    return this.$cfNotify('warn', null, 'Please select a thumbnail image')
                }
                if (!this.campaign.options.gallery.media.length) {
                    return this.$cfNotify('warn',null, 'Select a minimum of 1 gallery image/video')
                }
                if (!this.hasDeadline) {
                    this.campaign.target_date = null
                }

                if(this.submitStatus == 0){
                    this.saving = true
                } else if(this.submitStatus == 20){
                    this.publishing = true
                } else{
                    this.processing = true
                }
                let promises = [
                    this.$store.dispatch('campaign/setOption', {
                        key: 'recurring',
                        value: this.campaign.options.recurring
                    }),
                    this.$store.dispatch('campaign/setOption', {key: 'gateways', value: this.selectedGateways}),
                    this.$store.dispatch('campaign/setOption', {
                        key: 'gallery',
                        value: this.campaign.options.gallery
                    }),
                    this.$store.dispatch('campaign/setOption', {key: 'story', value: this.campaign.options.story}),
                ]
                if (this.campaign.type === this.$campaignTypes.FUNDRAISE) {
                    promises = promises.concat([
                        this.$store.dispatch('campaign/setOption', {
                            key: 'dynamic_form',
                            value: this.campaign.options.dynamic_form
                        })
                    ])
                } else {
                    delete this.campaign.target_amount
                }
                await Promise.allSettled(promises)
                
                if(this.submitStatus != null){
                     this.campaign.status = this.submitStatus;
                }
                
                return this.$store.dispatch('campaign/update', this.campaign)
                    .then(async (campaign) => {
                        this.$cfNotify('success', null, 'Successfully campaign updated.')
                        this.$forceUpdate()
                        this.$redirect('campaigns')
                    })
                    .catch((error) => {
                        this.$cfNotify('error', null, this.$getMessageFromError(error))
                    })
                    .finally(() => {
                        this.saving = false
                        this.publishing = false
                        this.processing = false
                        this.submitStatus = null
                    })
            },
            back() {
                this.$redirect('campaigns')
            }
        }
    });
</script>