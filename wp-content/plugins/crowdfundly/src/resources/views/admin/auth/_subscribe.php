<div id="subscribe" class="main-wrapper">
    <g-notify group="notify"></g-notify>
    <div v-if="checkingAuth" class="main-loader main-loader--80vh">
        <loader></loader>
    </div>
    <div v-else>
        <g-notify group="notify"></g-notify>
        <div class="subscribe">
            <div class="container">
                <div class="subscribe__inner">
                    <div class="subscribe__card p-0 bg-transparent">
                        <div class="subscribe__card-header">
                            <h4 class="subscribe__card-header-title"><?php _e('Choose Package', 'crowdfundly'); ?></h4>
                        </div>
                        <subscription-packages
                        v-if="packages"
                        :packages="packages"
                        :selected-package="selectedPackage"
                        @selected="selectPackage">
                        </subscription-packages>
                    </div>
                    <!--card 1 end-->
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
                                            <th><?php echo esc_html__('Package Name', 'crowdfundly'); ?></th>
                                            <th class="text-center max-100"><?php echo esc_html__('Price', 'crowdfundly'); ?></th>
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
                                                <?php echo esc_html__('Total=', 'crowdfundly'); ?>
                                            </td>
                                            <td class="max-100 text-bold text-dark text-center">
                                                {{ '$' + getPlanPriceString(selectedPackage) }}
                                                ( <a :href="'https:\\app.'+ $baseDomain() + '/pricing'"
                                                     target="_blank"><?php echo esc_html__('View pay per use policy', 'crowdfundly'); ?></a>
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
                    <!--card 4-->

                    <transition name="fade">
                        <div v-if="selectedPackage">
                            <div class="subscribe__card" v-if="selectedPackageId !== 'free'">
                                <div class="subscribe__card-header">
                                    <h4 class="subscribe__card-header-title"><?php echo esc_html__('Coupon', 'crowdfundly'); ?></h4>
                                </div>
                                <div class="subscribe__card-inner">
                                    <div class="form-group">
                                        <label for="coupon"><?php echo esc_html__('Have a coupon?', 'crowdfundly'); ?></label>
                                        <input
                                        v-model="couponCode"
                                        maxlength="200"
                                        placeholder="<?php echo esc_attr__('Apply your coupon code to get a discount', 'crowdfundly'); ?>"
                                        type="text"
                                        class="form-control"
                                        id="coupon">
                                    </div>

                                </div>
                            </div>

                            <div class="subscribe__card" v-if="selectedPackage && selectedPackageId !== 'free'">
                                <div class="alert alert-info text-center mb-0">
                                    <?php echo esc_html__('A charge may apply based on usage at the end of your billing period.', 'crowdfundly'); ?>
                                    <a :href="'https:\\app.'+ $baseDomain() + '/pricing'"
                                       target="_blank"><?php echo esc_html__('Check usage pricing', 'crowdfundly'); ?></a>
                                </div>
                            </div>

                            <!--User info-->
                            <div class="subscribe__card">
                                <div class="subscribe__card-header d-flex align-items-center justify-content-between">
                                    <h4 class="subscribe__card-header-title"><?php echo esc_html__('Your information', 'crowdfundly'); ?></h4>
                                </div>
                                <div class="subscribe__card-inner">
                                    <form @submit.prevent="makePayment">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name"><?php echo esc_html__('Your Full Name', 'crowdfundly'); ?></label>
                                                    <input
                                                    type="text"
                                                    maxlength="100"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    v-model="user.name"
                                                    placeholder="<?php echo esc_attr__('Your Name', 'crowdfundly' ); ?>"
                                                    required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="email"><?php echo esc_html__('Your Email', 'crowdfundly'); ?></label>
                                                    <input
                                                    type="email"
                                                    maxlength="100"
                                                    class="form-control"
                                                    id="email"
                                                    name="email"
                                                    v-model="user.email"
                                                    placeholder="<?php echo esc_attr__('example@email.com', 'crowdfundly' ); ?>"
                                                    required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group mb-md-0">
                                                    <label for="password"><?php echo esc_html__('Password', 'crowdfundly'); ?></label>
                                                    <input
                                                    type="password"
                                                    minlength="6"
                                                    maxlength="60"
                                                    class="form-control"
                                                    id="password"
                                                    name="password"
                                                    v-model="user.password"
                                                    required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="password"><?php echo esc_html__('Confirm Password', 'crowdfundly'); ?></label>
                                                    <input
                                                    type="password"
                                                    minlength="6"
                                                    maxlength="60"
                                                    v-model="user.password_confirmation"
                                                    class="form-control bg-warning"
                                                    name="password_confirm"
                                                    required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mb-0">
                                                    <div class="checkbox checkbox--primary">
                                                        <input
                                                        class="checkbox__input"
                                                        type="checkbox"
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

                                        <form-error-box></form-error-box>

                                        <div class="d-flex justify-content-end">
                                            <loading-button
                                            type="submit"
                                            :title="payNowText"
                                            :disabled="processing || !canPayNow || !acceptConditions"
                                            :loading="processing"
                                            :class="canPayNow ? 'btn-primary' : 'btn-danger'"
                                            class="btn-min-50">
                                            </loading-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--User info end-->
                        </div>
                    </transition>
                    <!--card 4 end-->
                </div>
            </div>
        </div>
        <payment-modal :data="finalData"></payment-modal>
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
                packages: null,
                selectedPackage: null,
                selectedPackageId: null,
                interval: 'monthly',
                licenceCount: null,
                registration: false,
                subscriptionCount: null,
                acceptConditions: false,
                processing: false,
                checkingAuth: false,
                finalData: {}
            }
        },
        computed: {
            canPayNow() {
                if (!this.selectedPackage) {
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
                return true
            },

            payNowText() {
                if (!this.selectedPackage) {
                    return 'Please select a package'
                }
                if (!this.$auth.loggedIn) {
                    for (const prop in this.user) {
                        if (this.user.hasOwnProperty(prop)) {
                            if (!this.user[prop]) {
                                return 'Please fill in all the fields'
                            }
                        }
                    }
                } else if (!this.user.name || !this.user.email) {
                    return 'Please fill in all the fields'
                }
                if (this.selectedPackage == 'free') {
                    return 'Subscribe Now'
                }
                return 'Pay now'
            },

            intervalText() {
                return this.interval == 'monthly' ? 'Month' : 'Year';
            }
        },
        async created() {
            await this.checkAuth()
            await this.fetchPackages()
        },
        methods: {
            async fetchPackages() {
                let endpoint = route_with_query('public-packages', {type: this.$enum.PackageType.PACKAGE_TYPE_STRIPE}).absolute_path;

                return this.$axios.get(endpoint)
                    .then(res => {
                        this.packages = res
                    })
                    .catch(error => {
                        console.log('error', error)
                    })
            },
            checkAuth() {
                this.checkingAuth = true
                if (this.$auth.loggedIn) {
                    return window.location.replace('?page=crowdfundly-dashboard')
                }
                this.checkingAuth = false
            },
            selectPackage(data) {
                this.selectedPackage = data;
                this.selectedPackageId = data.id
                setTimeout(() => {
                    this.scrollToEnd()
                }, 500)
            },


            async makePayment() {
                this.$showModal('paymentModal')

                let baseData = {
                    type: 'subscribe',
                    endpoint: this.$route_with_query('request-subscription').absolute_path,
                    redirectURL: this.$href('create-organization')
                }

                let paymentData = this.user;

                paymentData.plan_id = this.selectedPackageId;
                paymentData.interval = this.interval;

                if (this.couponCode) {
                    paymentData.coupon_code = this.couponCode
                } else {
                    delete paymentData.coupon_code
                }

                this.finalData = {baseData: baseData, paymentData: paymentData}
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
        }
    })
</script>