<div id="subscribe" class="main-wrapper">
    <g-notify group="notify"></g-notify>
    <div v-if="checkingAuth" class="main-loader main-loader--80vh">
        <loader></loader>
    </div>
    <div v-else>
        <g-notify group="notify"></g-notify>
        <div class="subscribe subscribe--payment">
            <div class="container">
                <div class="subscribe__inner">
                    <!--card 3-->
                    <div class="subscribe__card" id="packageInfo" v-if="selectedPackage">
                        <div class="subscribe__card-header">
                            <h4 class="subscribe__card-header-title"><?php _e('Package Information', 'crowdfundly'); ?></h4>
                        </div>
                        <div class="subscribe__card-inner p-0">
                            <div class="datatable m-0">
                                <div class="datatable__inner">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th><?php _e('Package Name', 'crowdfundly'); ?></th>
                                            <th class="text-center max-100"><?php _e('Price', 'crowdfundly'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td v-text="selectedPackage.package_name"></td>
                                            <td class="text-center max-100">
                                                <span v-text="'$' + getPlanPriceString(selectedPackage)"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-bold text-dark">
                                                <?php _e('Total=', 'crowdfundly'); ?>
                                            </td>
                                            <td class="max-100 text-bold text-dark text-center">
                                                {{ '$' + getPlanPriceString(selectedPackage) }}
                                                ( <a :href="'https:\\app.'+ $baseDomain() + '/pricing'"
                                                     target="_blank"><?php _e('View pay per use policy', 'crowdfundly'); ?></a>
                                                )
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--card 3 end-->

                    <!--selected packages info-->
                    <div class="subscribe__card" id="packageInfo" v-if="selectedPackages.length">
                        <div class="subscribe__card-header">
                            <h4 class="subscribe__card-header-title">
                                {{ $t('cart_information') }}
                            </h4>
                        </div>
                        <div class="subscribe__card-inner p-0">
                            <div class="datatable m-0">
                                <div class="datatable__inner">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th v-text="$t('package_name')"></th>
                                            <th v-text="$t('price')"></th>
                                            <th v-text="$t('quantity')"></th>
                                            <th v-text="$t('subtotal')"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, i) in selectedPackages" :key="i">
                                            <td v-text="item.package_name" class="text-nowrap"></td>
                                            <td class="text-nowrap"
                                                v-text="'$'+price(item.price)"></td>
                                            <td v-text="item.quantity" class="text-nowrap"></td>
                                            <td v-text="'$'+getTotal(item.price, item.quantity)"
                                                class="text-nowrap"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-dark" colspan="3">{{ $t('subtotal') }}
                                                =
                                            </td>
                                            <td class="max-100 text-dark" v-text="'$'+getSubtotal"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-dark" colspan="3">{{ $t('coupon_discount') }}
                                                =
                                            </td>
                                            <td class="max-100 text-dark" v-text="'- ' + couponText"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-bold text-dark" colspan="3">{{
                                                    $t('grand_total')
                                                }}
                                                =
                                            </td>
                                            <td class="max-100 text-bold text-dark" v-text="'$'+ totalAmount"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--selected packages info end-->

                    <!--coupon-->
                    <div class="subscribe__card" v-if="selectedPackages.length">
                        <div class="subscribe__card-header">
                            <h4 class="subscribe__card-header-title">
                                {{ $t('apply_coupon') }}
                            </h4>
                        </div>
                        <div class="subscribe__card-inner">
                            <form @submit.prevent="validateCoupon">
                                <div class="form-group" v-if="!couponDetails">
                                    <label for="coupon">{{ $t('have_a_coupon') }}</label>
                                    <input v-model="couponCode"
                                           maxlength="200"
                                           :placeholder="$t('apply_your_coupon_code_to_get_an_discount')"
                                           type="text" class="form-control" id="coupon">
                                </div>
                                <div class="form-group" v-if="couponDetails">
                                    <label for="coupon">{{ $t('applied_coupons') }}</label>
                                    <div class="coupons">
                                        <div class="coupons__item">
                                            <p class="coupons__item-text">
                                                {{ $t('coupon') }} <strong v-text="couponDetails.code"></strong>
                                                {{ $t('applied_for') }}
                                                {{ couponText }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button class="btn btn-primary" v-text="$t('change_coupon')" type="button" @click="clearCoupon"
                                            v-if="showChangeButton"></button>
                                    <loading-button type="submit"
                                                    v-else
                                                    :title="$t('apply_coupon')"
                                                    :disabled="selectedPackages.length === 0 || !couponCode"
                                                    :loading="processing"
                                                    :class="'btn-primary'"></loading-button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--coupon end-->

                    <!--card 4-->
                    <div v-if="selectedPackage || selectedPackages">
                        <!--User info-->
                        <div class="subscribe__card">
                            <div class="subscribe__card-header d-flex align-items-center justify-content-between">
                                <h4 class="subscribe__card-header-title"><?php _e('Your information', 'crowdfundly'); ?></h4>
                            </div>
                            <div class="subscribe__card-inner">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name"><?php _e('Your Full Name', 'crowdfundly'); ?></label>
                                            <input type="text" maxlength="100" class="form-control" id="name"
                                                   name="name"
                                                   v-model="user.name"
                                                   placeholder="Your Name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="email"><?php _e('Your Email', 'crowdfundly'); ?></label>
                                            <input type="email" maxlength="100" class="form-control" id="email"
                                                   name="email"
                                                   v-model="user.email"
                                                   placeholder="example@email.com"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group mb-md-0">
                                            <label for="password"><?php _e('Password', 'crowdfundly'); ?></label>
                                            <input type="password" minlength="6" maxlength="60" class="form-control"
                                                   id="password"
                                                   name="password"
                                                   v-model="user.password" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="password"><?php _e('Confirm Password', 'crowdfundly'); ?></label>
                                            <input type="password"
                                                   minlength="6" maxlength="60"
                                                   v-model="user.password_confirmation"
                                                   class="form-control bg-warning"
                                                   name="password_confirm" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-0">
                                            <div class="checkbox checkbox--primary">
                                                <input class="checkbox__input" type="checkbox"
                                                       v-model="acceptConditions"
                                                       id="acceptConditions"/>
                                                <label class="checkbox__label" for="acceptConditions">
                                                    <div class="full-width">
                                                        <?php
                                                        printf('%s <a href="%s" target="_blank">%s</a> %s ',
                                                            __('By creating an account, I accept the', 'crowdfundly'),
                                                            esc_url('https://crowdfundly.io/terms/'),
                                                            __('terms', 'crowdfundly'),
                                                            __('and', 'crowdfundly')
                                                        );

                                                        printf('<a href="%s" target="_blank">%s</a> %s',
                                                            esc_url('https://crowdfundly.io/privacy/'),
                                                            __('privacy', 'crowdfundly'),
                                                            __('conditions.', 'crowdfundly')
                                                        );
                                                        ?>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form-error-box class="mt-4"></form-error-box>

                                <!--                                    <div class="d-flex justify-content-end">-->
                                <!--                                        <loading-button type="submit" :title="payNowText"-->
                                <!--                                                        :disabled="processing || !canPayNow"-->
                                <!--                                                        :loading="processing"-->
                                <!--                                                        :class="canPayNow ? 'btn-primary' : 'btn-danger'"-->
                                <!--                                                        class="btn-min-50"></loading-button>-->
                                <!--                                    </div>-->
                            </div>
                        </div>
                        <!--User info end-->

                        <div class="subscribe__card" v-if="selectedPackage && selectedPackageId !== 'free'">
                            <div class="subscribe__card-header">
                                <h4 class="subscribe__card-header-title"><?php _e('Coupon', 'crowdfundly'); ?></h4>
                            </div>
                            <div class="subscribe__card-inner">
                                <div class="form-group">
                                    <label for="coupon"><?php _e('Have a coupon?', 'crowdfundly'); ?></label>
                                    <input v-model="couponCode"
                                           maxlength="200"
                                           placeholder="<?php echo esc_attr__('Apply your coupon code to get a discount', 'crowdfundly'); ?>"
                                           type="text" class="form-control" id="coupon">
                                </div>

                            </div>
                        </div>

                        <div class="subscribe__card"
                             v-if="selectedPackage && selectedPackage.lifetime == false && selectedPackageId !== 'free'">
                            <div class="alert alert-info text-center mb-0">
                                <?php _e('A charge may apply based on usage at the end of your billing period.', 'crowdfundly'); ?>
                                <a :href="'https:\\app.'+ $baseDomain() + '/pricing'"
                                   target="_blank"><?php _e('Check usage pricing', 'crowdfundly'); ?></a>
                            </div>
                        </div>

                        <div class="subscribe__card">
                            <div class="subscribe__card-inner">
                                <loader type="dotted" v-if="processingPayment"></loader>
                                <payment v-else :can-pay="canPayNow" :data="finalData"
                                         @success-payment="afterPaymentAction"></payment>
                            </div>
                        </div>
                    </div>
                    <!--card 4 end-->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let app = new Vue({
        el: '#subscribe',
        data: () => {
            return {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                },
                couponCode: null,
                couponDetails: null,
                selectedPackage: null,
                selectedPackages: [],
                selectedPackageId: null,
                interval: 'monthly',
                acceptConditions: false,
                processing: false,
                processingPayment: false,
                checkingAuth: false,
            }
        },
        watch: {
            // selectedPackage: {
            //     handler(val) {
            //         this.setPaymentData()
            //     },
            //     deep: true
            // },
            // couponCode() {
            //     this.setPaymentData()
            // }
        },
        async created() {
            await this.checkAuth();
            await this.checkHasSelectedPlan();
            await this.setSelectedPackage();
            await this.setSelectedPackages();
        },
        computed: {
            finalData() {
                let baseData = {
                    type: 'subscribe',
                    endpoint: null,
                    redirectURL: this.$href('create-organization')
                }

                let paymentData = this.user;

                if (this.selectedPackage && !this.selectedPackages.length) {
                    baseData.endpoint = 'request-subscription'
                    paymentData.plan_id = this.selectedPackageId;
                    paymentData.interval = this.interval;

                    if (this.couponCode) {
                        paymentData.coupon_code = this.couponCode
                    } else {
                        delete paymentData.coupon_code
                    }
                }

                if(this.selectedPackages.length && !this.selectedPackage){
                    baseData.endpoint = 'fetch-purchase-licence-intent'
                    paymentData.amount= this.getSubtotal * 100;
                    paymentData.purchases= this.preparePurchaseData();
                    // paymentData['ref-id']= this.$route.query.fpr ? this.$route.query.fpr : '';
                    if (this.couponDetails) {
                        paymentData.coupon_code = this.couponDetails.code
                    }else {
                        delete paymentData.coupon_code
                    }
                }

                return {baseData: baseData, paymentData: paymentData}
            },
            selectedPlan() {
                return this.$store.getters.selectedPlan
            },
            canPayNow() {
                if (!this.selectedPackage && !this.selectedPackages.length) {
                    return false
                }
                if (!this.$auth.loggedIn) {
                    for (const prop in this.user) {
                        if (this.user.hasOwnProperty(prop)) {
                            if (!this.user[prop]) {
                                return false
                            }
                        }
                    }
                } else if (!this.user.name || !this.user.email) {
                    return false;
                }

                if (!this.acceptConditions) {
                    return false
                }
                return true
            },

            intervalText() {
                return this.interval == 'monthly' ? 'Month' : 'Year';
            },

            getSubtotal() {
                if (!this.selectedPackages) {
                    return 0
                }
                let prices = []
                for (let item in this.selectedPackages) {
                    prices.push(this.selectedPackages[item].price * this.selectedPackages[item].quantity)
                }
                let subtotal = prices.reduce((a, b) => {
                    return a + b
                }, 0)
                return Number(subtotal / 100).toFixed(2)
            },
            couponText() {
                if (this.couponDetails) {
                    if (this.couponDetails.coupon.is_percentage_discount === 0) {
                        return '$' + Number(this.couponDetails.coupon.discount_amount / 100).toFixed(2)
                    }
                    return "$" + Number(this.getSubtotal - this.totalAmount).toFixed(2) + " (" + this.couponDetails.coupon.discount_amount + '%)'
                }
                return '$' + 0
            },
            totalAmount() {
                if (this.getSubtotal === 0) {
                    return 0
                }
                let subTotal = this.getSubtotal
                if (this.couponDetails) {
                    if (this.couponDetails.coupon.is_percentage_discount === 0) {
                        return Number(subTotal - Number(this.couponDetails.coupon.discount_amount / 100)).toFixed(2)
                    }
                    return Number(this.getSubtotal - Number(subTotal * this.couponDetails.coupon.discount_amount / 100)).toFixed(2)
                }
                return subTotal
            },
            showChangeButton() {
                return !!this.couponDetails;
            }
        },
        methods: {
            checkAuth() {
                this.checkingAuth = true
                if (this.$auth.loggedIn) {
                    return window.location.replace('?page=crowdfundly-dashboard')
                }
                this.checkingAuth = false
            },
            checkHasSelectedPlan() {
                // if (!this.selectedPlan) {
                //     return this.$redirect('subscribe')
                // }
            },
            selectPackage(data) {
                this.selectedPackage = data;
                this.selectedPackageId = data.id
                setTimeout(() => {
                    this.scrollToEnd()
                }, 500)
            },

            getPlanPriceString(plan) {
                return Number(plan.interval[this.interval].base_price / 100).toFixed(2) + ' / ' + this.intervalText;
            },

            async login(data) {
                await this.$auth.setUserToken(data.access_token);
                await this.$store.dispatch('fetch_countries')
                    .then(result => {
                        this.$store.dispatch('set_countries', result)
                    })
                    .catch(error => {
                    })

                await this.$store.dispatch('fetch_currencies')
                    .then(result => {
                        this.$store.dispatch('set_currencies', result)
                    })
                    .catch(error => {
                    })
            },

            scrollToEnd() {
                let el = document.getElementById('packageInfo')
                el.scrollIntoView({behavior: 'smooth', block: 'center', inline: 'center'})
            },

            setSelectedPackage() {
                this.selectedPackage = this.selectedPlan
                if (this.selectedPlan) {
                    this.selectedPackageId = this.selectedPlan.id
                }
            },

            setSelectedPackages() {
                this.selectedPackages = this.$store.getters.selectedPlans
                // console.log('selectedPackages',this.selectedPackages)
                // if (this.selectedPlan) {
                //     this.selectedPackageId = this.selectedPlan.id
                // }
            },
            async afterPaymentAction(res) {
                let authData = {
                    loggedIn: true,
                    _token: res.access_token,
                    user_id: res.user_id,
                    username: res.username
                }
                await this.$store.dispatch('set_temp_auth', authData)
                setTimeout(() => {
                    this.$redirect('organization-create')
                }, 500);
            },

            price(amount) {
                return Number(amount / 100).toFixed(2)
            },
            getTotal(price, qty) {
                return Number((price / 100) * qty).toFixed(2)
            },

            validateCoupon() {
                let endpoint = route_with_query('validate-coupon');
                let data = {
                    'coupon_code': this.couponCode
                }
                this.processing = true
                this.$axios.$post(endpoint.absolute_path, data)
                    .then(res => {
                        this.couponDetails = res
                    })
                    .catch(e => {
                        console.log('error', e)
                        this.$error(null, getMessageFromError(e))
                        console.log(e)
                        // this.clearCoupon()
                    })
                    .finally(() => {
                        this.processing = false
                    })

            },
            preparePurchaseData: function () {
                let data = []
                for (let item in this.selectedPackages) {
                    data.push({
                        'plan_id': this.selectedPackages[item].id,
                        'quantity': this.selectedPackages[item].quantity,
                        'interval': 'monthly'
                    })
                }
                return data
            },
        }
    })
</script>