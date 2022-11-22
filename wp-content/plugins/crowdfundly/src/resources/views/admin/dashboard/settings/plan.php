<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="settings settings--plan">

            <settings-page-header :title="$t('settings')+' / '+$t('plan')"></settings-page-header>

            <div class="settings__inner">

                <!--tab start-->
                <div class="settings__tab">
                    <settings-tab></settings-tab>
                </div>
                <!--tab end-->

                <div class="settings__body p-0 bg-transparent">

                    <div class="main-loader main-loader--60vh" v-if="fetchingCurrentSubscription">
                        <loader :description="$t('checking_current_subscription_type')"></loader>
                    </div>
                    <div v-else class="settings__body-inner">
                        <div class="settings__section" v-if="organization.plan_permission.package_type == 2">
                            <div class="settings__section-header">
                                <h4 class="settings__section-title" v-text="$t('ltd_packages')"></h4>
                            </div>

                            <div class="alert alert-info text-center mb-3">
                                {{ $t('ltd_license_is_not_upgradable__') }}
                                <a :href="$href('lifetime-deal')" class="text-bold" v-text="'View Pricing'"></a>
                            </div>

                            <div class="settings__section-inner">
                                <div class="main-loader main-loader--30vh" v-if="!ltdPackages && loadingLtdPackages">
                                    <loader type="dotted"></loader>
                                </div>
                                <ltd-plans v-if="ltdPackages && !loadingLtdPackages" :packages="ltdPackages"
                                           :current-plan-id="organization.plan_permission.id"></ltd-plans>
                            </div>
                        </div>

                        <div class="settings__section" v-if="organization.plan_permission.package_type == 1">
                            <div class="settings__section-header">
                                <h4 class="settings__section-title" v-text="$t('metered_packages')"></h4>
                            </div>

                            <div class="settings__section-inner">
                                <div class="main-loader main-loader--30vh" v-if="!packages && loadingPackages">
                                    <loader type="dotted"></loader>
                                </div>
                                <plans v-if="packages && !loadingPackages" :packages="packages"
                                       :current-plan-details="currentPlanDetails"
                                       :current-plan-id="currentPlanId" @selected="handleUpgrade"></plans>
                            </div>
                        </div>

                        <!--card 4-->
                        <transition name="fade" v-if="currentPlanId == 'free'">
                            <div class="subscribe__card">
                                <div class="subscribe__card-header">
                                    <h4 class="subscribe__card-header-title">
                                        {{ $t('payment_details') }}
                                    </h4>
                                </div>
                                <div class="subscribe__card-inner">
                                    <div class="alert alert-warning text-center" role="alert"
                                         v-text="$t('we_will_charge_50_cent__')"></div>

                                    <div class="form-group">
                                        <label for="couponCode" class="text-primary">{{ $t('have_a_coupon') }}</label>
                                        <input v-model="couponCode"
                                               maxlength="200"
                                               :placeholder="$t('apply_your_coupon_code_to_get_an_discount')"
                                               type="text" class="form-control" id="couponCode">
                                    </div>

                                    <div ref="card" class="full-width"></div>
                                    <div id="card-errors" role="alert"></div>

                                    <div class="d-flex justify-content-end">
                                        <loading-button :class="'btn-primary'"
                                                        class="btn-min-50"
                                                        :title="$t('yes_confirm')"
                                                        :disabled="processing || !isCompleteCardEntry"
                                                        :loading="processing"
                                                        type="button"
                                                        @on-press="redirectToPaymentPage"></loading-button>
                                    </div>
                                </div>
                            </div>
                        </transition>
                        <!--card 4 end-->

                        <g-modal id="confirmModal" @after-hide="resetModal" size="xs"
                                 position="center-center"
                                 :close-button="true">
                            <transition name="fade">
                                <div class="error-modal">
                                    <div class="error-modal__header">
                                        <h4 class="error-modal__title" v-text="$t('are_you_sure')"></h4>
                                        <p class="error-modal__text">
                                            {{ $t('your_payment_will_be__') }}
                                            <a href="https://crowdfundly.io/privacy/" class="alert-link"
                                               target="_blank"
                                               :to="{name:'dashboard'}">
                                                {{ $t('visit_our_payment_policy') }}
                                            </a>
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="coupon">{{ $t('have_a_coupon') }}</label>
                                        <input v-model="couponCode"
                                               :placeholder="$t('apply_your_coupon_code_to_get_an_discount')"
                                               type="text" maxlength="200" class="form-control" id="coupon">
                                    </div>
                                    <div class="error-modal__inner">
                                        <loading-button class="btn btn-primary error-modal__btn"
                                                        :title="$t('yes_confirm')"
                                                        :disabled="processing || selectedPlanId == null"
                                                        :loading="processing"
                                                        type="button"
                                                        @on-press="redirectToPaymentPage"></loading-button>
                                    </div>
                                </div>
                            </transition>
                        </g-modal>
                    </div>
                </div>
            </div>
        </div>
    </dashboard-layout>
</div>

<script>
    let stripe = null;
    let card = null
    let elements = null

    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                couponCode: null,
                processing: false,
                SUBSCRIPTION_TYPE_APPSUMO: this.$enum.SubscriptionType.SUBSCRIPTION_TYPE_APPSUMO,
                PACKAGE_TYPE_APPSUMO: this.$enum.PackageType.PACKAGE_TYPE_APPSUMO,
                PACKAGE_TYPE_STRIPE: this.$enum.PackageType.PACKAGE_TYPE_STRIPE,
                fetchingCurrentSubscription: false,
                currentPlanDetails: {
                    plan_id: null,
                    required_coupon_count: 0,
                    is_lifetime_subscription: false,
                    subscription_ends_on: null,
                    price: 0
                },
                currentPlanId: null,
                loadingPackages: false,
                loadingLtdPackages: false,
                packages: null,
                ltdPackages: null,
                planType: 'monthly',
                selectedPlanId: null,
                isCompleteCardEntry: false
            };
        },
        computed: {
            organization() {
                return this.$auth.organization
            },
            userIsAppsumoSubscriber() {
                return this.$auth.loggedIn &&
                    (this.$auth.user.subscription_type == this.SUBSCRIPTION_TYPE_APPSUMO);
            },

            packageType() {
                return this.userIsAppsumoSubscriber ? this.PACKAGE_TYPE_APPSUMO : this.PACKAGE_TYPE_STRIPE;
            },
            isOwner() {
                return true
                return this.organization && this.organization.auth_org_role === 'owner'
            }
        },
        async created() {
            if (!this.isOwner) {
                this.$redirect('dashboard')
            }
            const key = this.$env.STRIPE_PUBLIC_KEY
            // stripe = await loadStripe(key)
            // if (!stripe) {
            //     this.$redirect('dashboard')
            // }
        },
        async mounted() {
            await this.fetchCurrentSubscriptionDetails()
            await this.fetchPackages()
            await this.fetchLtdPackages()
            if (this.currentPlanId == 'free') {
                this.initializeCard()
            }
        },
        methods: {
            initializeCard() {
                const apiKey = this.$env.STRIPE_PUBLIC_KEY
                try {
                    stripe = Stripe(apiKey)
                    elements = stripe.elements()
                    card = elements.create('card')
                    setTimeout(() => {
                        card.mount(this.$refs.card)
                    }, 2000)
                    let data = this
                    card.on('change', function (event) {
                        let displayError = document.getElementById('card-errors');
                        data.isCompleteCardEntry = event.complete
                        if (event.error) {
                            displayError.textContent = event.error.message;
                        } else {
                            displayError.textContent = '';
                        }
                    });
                } catch (e) {
                    alert(this.$t('error_making_card_mount'))
                }
            },
            handleUpgrade(data) {
                this.selectedPlanId = data.id
                if (this.currentPlanId != 'free') {
                    return this.$showModal('confirmModal')
                }
            },
            async fetchCurrentSubscriptionDetails() {
                const endpoint = route_with_query('fetch-org-subscriptions-data', {}, this.organization.id)
                this.fetchingCurrentSubscription = true
                await this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                            this.setCurrentPlanInfo(res.plan_details)
                        }
                    )
                    .finally(() => this.fetchingCurrentSubscription = false)
            },
            async fetchPackages() {
                let endpoint = route_with_query('public-packages', {type: this.packageType}).absolute_path;
                this.loadingPackages = true
                await this.$axios.get(endpoint)
                    .then(response => {
                        this.packages = response;
                    })
                    .catch(error => {
                        throw new Error(this.$t('no_plan_found'));
                    })
                    .finally(() => {
                        this.loadingPackages = false
                    });
            },
            async fetchLtdPackages() {
                let endpoint = route_with_query('public-packages', {type: this.PACKAGE_TYPE_APPSUMO}).absolute_path;
                this.loadingLtdPackages = true
                await this.$axios.get(endpoint)
                    .then(response => {
                        this.ltdPackages = response;
                    })
                    .catch(error => {
                        throw new Error(this.$t('no_plan_found'));
                    })
                    .finally(() => {
                        this.loadingLtdPackages = false
                    });
            },

            setCurrentPlanInfo(plansObject) {
                this.currentPlanId = plansObject.plan_id
                this.currentPlanDetails = plansObject
            },

            redirectToPaymentPage() {
                let data = {}
                data.plan_id = this.selectedPlanId
                data.interval = this.planType
                data.organization_id = this.organization.id
                if (this.couponCode) {
                    data.coupon_code = this.couponCode
                }

                this.processing = true

                const dest = route('update-subscription')

                this.$axios[dest.method](dest.absolute_path, data)
                    .then(async res => {
                        await this.$store.dispatch('set_free_subscription_selection_data', res.data.redirect_to_stripe)
                        if (res.data.redirect_to_stripe == true) {
                            this.$success(null, this.$t('redirecting_to_stripe_checkout'))
                            const {error} = await stripe.redirectToCheckout({
                                sessionId: res.data.session_id
                            })
                            if (error.message) {
                                this.$error(null, error.message)
                            }
                        } else {
                            if (this.currentPlanId == 'free') {
                                await this.confirmCardPayment(res.data.secret);
                            }
                            if (res.data.uuid) {
                                await this.$router.push({
                                    name: 'subscribe-success',
                                    query: {
                                        session_id: res.data.uuid
                                    }
                                })
                            }
                            setTimeout(() => {
                                this.$success(null, this.$t('congratulation_your_plan_has_been_updated'))
                            }, 1000)

                            await this.$router.push({
                                name: 'subscribe-success',
                            })

                        }

                    })
                    .catch(e => {
                        console.error('error', e)
                        this.$error(null, e.response.data.message || this.$t('sorry_something_went_wrong'))
                        // alert(e.response.data.message || this.$t('sorry_something_went_wrong'))
                    })
                    .finally(() => {
                        this.processing = false
                        this.couponCode = null
                        this.closeModal('confirmModal')
                    })
            },
            async confirmCardPayment(secret) {
                return new Promise(async (resolve, reject) => {
                    try {
                        const stripeResponse = await stripe.confirmCardPayment(secret, {payment_method: {card: card}});
                        if (stripeResponse.error) {
                            reject(stripeResponse.error)
                        } else {
                            resolve(stripeResponse.paymentIntent)
                        }
                    } catch (e) {
                        reject(e);
                    }
                })
            },
            closeModal(id) {
                this.$hideModal(id)
            },
            resetModal() {
                return this.couponCode = null
            }
        }
    });
</script>