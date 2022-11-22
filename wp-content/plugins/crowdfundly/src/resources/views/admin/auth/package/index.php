<div id="package" class="main-wrapper">
    <layout-dashboard>
        <div class="container">
            <div class="main-wrapper__loader" v-if="loading">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-else class="public-package">
                <div class="public-package__section" v-if="(packages && !selectedPackage) || (packages && selectedPackageType == 0)">
                    <h1 class="package__section-title">
                        <?php _e('Choose a Package', 'crowdfundly'); ?>
                    </h1>

                    <div class="public-package__row">
                        <div class="public-package__row-item" v-for="(item, i) in packages" :key="i">
                            <c-package-card :selected="selectedPackage && selectedPackage.hasOwnProperty('id') && selectedPackage?.id == item.id" :package-plan="item" @selected="setSelectedPackage" />
                        </div>
                    </div>
                </div>

                <div class="public-package__section bundles" v-if="(bundles && !selectedPackage) || (bundles && selectedPackageType == 1)">
                    <h1 class="package__section-title">
                        <?php _e( 'Choose a Bundle', 'crowdfundly' ); ?>
                    </h1>

                    <div class="public-package__row">
                        <div class="public-package__row-item" v-for="(item, i) in bundles" :key="i">
                            <c-package-card :badge-icon="$assets('/icons/bundle-badge.svg')" :selected="selectedPackage && selectedPackage.hasOwnProperty('id') &&  selectedPackage?.id ==item.id" :package-plan="item" @selected="setSelectedPackage" />
                        </div>
                    </div>
                </div>

                <!--selected packages info-->
                <div class="public-package__section" v-if="selectedPackage">
                    <h1 class="package__section-title">
                        <?php _e('Cart information', 'crowdfundly'); ?>
                    </h1>

                    <div class="public-package__section-inner">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php _e('Package Name', 'crowdfundly'); ?></th>
                                    <th><?php _e('Price', 'crowdfundly'); ?></th>
                                    <th><?php _e('Quantity', 'crowdfundly'); ?></th>
                                    <th><?php _e('Subtotal', 'crowdfundly'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td v-text="selectedPackage.name" class="text-nowrap"></td>
                                    <td class="text-nowrap" v-text="'$'+price(selectedPackage.price)"></td>
                                    <td v-text="selectedPackage.qty" class="text-nowrap"></td>
                                    <td v-text="'$'+getTotal(selectedPackage.price, selectedPackage.qty)" class="text-nowrap"></td>
                                </tr>
                                <tr>
                                    <td class="text-right text-dark" colspan="3">
                                        <?php _e('Subtotal =', 'crowdfundly'); ?>
                                    </td>
                                    <td class="max-100 text-dark" v-text="'$'+getSubtotal()"></td>
                                </tr>
                                <tr>
                                    <td class="text-right text-dark" colspan="3">
                                        <?php _e('Coupon discount =', 'crowdfundly'); ?>
                                    </td>
                                    <td class="max-100 text-dark" v-if="couponDiscount != 0" v-text="'- $' + couponDiscount"></td>
                                    <td class="max-100 text-dark" v-else v-text="couponDiscount"></td>
                                </tr>

                                <tr>
                                    <td>
                                        <!--coupon-->
                                        <div class="cupon-wrap" v-if="showCoupon">
                                            <div class="cupon-inner">
                                                <form @submit.prevent="validateCoupon">
                                                    <div class="form-group" v-if="!couponDetails">
                                                        <c-input
                                                        input-inner-class="cupon-input"
                                                        label=""
                                                        v-model="couponCode"
                                                        maxlength="200"
                                                        placeholder="<?php echo esc_attr__('Coupon Code', 'crowdfundly'); ?>"
                                                        type="text"
                                                        id="coupon">
                                                        </c-input>
                                                    </div>

                                                    <p class="coupons__item-text" v-else>
                                                        <strong v-text="couponCode"></strong>
                                                    </p>

                                                    <c-input-group class="mb-0">
                                                        <c-button v-if="couponDetails" variant="info" title="<?php echo esc_attr__('Change coupon', 'crowdfundly'); ?>" @onpress="clearCoupon" type="button">
                                                        </c-button>
                                                        <c-button v-else variant="primary" title="<?php echo esc_attr__('Apply', 'crowdfundly'); ?>" :disabled="!couponCode" :loading="processing" type="submit">
                                                        </c-button>
                                                    </c-input-group>
                                                </form>
                                            </div>
                                        </div>
                                        <!--coupon end-->
                                    </td>
                                    <td></td>
                                    <td colspan="1">
                                        <div class="text-right text-bold text-dark">
                                            <?php _e('Grand total =', 'crowdfundly'); ?>
                                        </div>
                                    </td>
                                    <td class="max-100 text-bold text-dark" v-text="'$'+ totalAmount()"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="public-package__section create-org" v-if="selectedPackage && totalAmount() == 0">
                            <c-button
                            class="payment-section__button"
                            variant="primary"
                            type="button"
                            @onpress="requestPayment"
                            title="<?php echo esc_attr__( 'Create Organization', 'crowdfundly' ); ?>"
                            :loading="processing">
                            </c-button>
                        </div>
                    </div>
                </div>
                <!--selected packages info end-->

                <!--payment-->
                <div class="public-package__section" v-if="selectedPackage && totalAmount() > 0">
                    <h1 class="package__section-title">
                        <?php _e('Payment details', 'crowdfundly'); ?>
                    </h1>

                    <div class="public-package__section-inner">

                        <div class="payment-section">
                            <div class="alert alert-warning mb-3" v-if="selectedPackage && selectedPackage.id == 1">
                                <?php _e('We will charge you 50 cents ($0.50) for varification purpose.', 'crowdfundly'); ?>
                            </div>

                            <h4 class="payment-section__title">
                                <?php _e('Choose way to pay', 'crowdfundly'); ?>
                            </h4>
                            <p class="payment-section__description" v-if="false">
                                <?php _e('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae dolorum libero nam non
                                nulla, recusandae.', 'crowdfundly'); ?>
                            </p>

                            <div class="payment-section__inner">
                                <div class="payment-gateways mb-4">
                                    <div class="payment-gateways__row">
                                        <div class="payment-gateways__row-item">
                                            <div class="payment-gateway" :class="{'active':selectedGateway === 'stripe'}" @click="selectGateway('stripe')">
                                                <h4 class="payment-gateway__title">
                                                    <?php _e('Payment By Stripe', 'crowdfundly'); ?>
                                                </h4>
                                                <div class="payment-gateway__icon">
                                                    <img class="payment-gateway__icon-img" :src="$assets('/icons/payment/svg/stripe.png')" alt="<?php echo esc_attr__('Stripe', 'crowdfundly'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="payment-gateways__row-item">
                                            <div
                                            class="payment-gateway"
                                            :class="{'active':selectedGateway === 'paypal'}"
                                            @click="selectGateway('paypal')">
                                                <h4 class="payment-gateway__title">
                                                    <?php //_e( 'Payment By PayPal', 'crowdfundly' ); 
                                                    ?>
                                                </h4>
                                                <div class="payment-gateway__icon">
                                                    <img
                                                    class="payment-gateway__icon-img"
                                                    :src="$assets('/icons/payment/svg/paypal.svg')"
                                                    alt="<?php //echo esc_attr__( 'PayPal', 'crowdfundly' ); 
                                                            ?>">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <c-loader class="mb-4 w-max-content" variant="primary" type="dotted" v-if="initializingCard">
                                </c-loader>
                                <div class="w-full mb-4" v-if="selectedGateway !== 'paypal'">
                                    <div ref="card" class="w-full"></div>
                                    <div id="card-errors" role="alert"></div>
                                </div>

                                <c-button
                                class="payment-section__button"
                                variant="primary"
                                type="button"
                                @onpress="requestPayment"
                                title="<?php echo esc_attr__('Pay Now', 'crowdfundly'); ?>"
                                :disabled="processing || !selectedGateway || (selectedGateway === 'stripe' && !isCompleteCardEntry)"
                                :loading="processing">
                                </c-button>

                                <div class="pay-paypal">
                                    <p>
                                        <?php  
                                        printf(
                                            "%s <a href='%s' target='_blank'>%s</a>",
                                            __( 'To pay with PayPal,', 'crowdfundly' ),
                                            esc_url( 'https://crowdfundly.com/pay-with-paypal/' ),
                                            __( 'click here', 'crowdfundly' )
                                        );
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--payment end-->
            </div>
        </div>
    </layout-dashboard>

</div>

<script>
    let app = new Vue({
        el: '#package',
        data: () => {
            return {
                publishableKey: process.env.STRIPE_PUBLIC_KEY,
                packagePlan: null,
                packages: [],
                // selectedPackages: {},
                selectedPackage: null,
                processing: false,
                loading: false,
                checkingAuth: false,
                couponDiscountAmount: 0,
                couponCode: null,
                couponDetails: null,
                packageType: {
                    free: 1,
                    professional: 2
                },
                initializingCard: false,
                paymentData: {},
                isCompleteCardEntry: false,
                acceptConditions: this.$auth.loggedIn,
                selectedGateway: null,
                elementsOptions: {
                    appearance: {},
                    clientSecret: null
                },
                confirmParams: {
                    return_url: 'https://cfplugin.test/wp-admin/admin.php?page=crowdfundly-package', // success url
                },
                stripe: null,
                card: null,
                elements: null,
                bundles: []
            }
        },
        async created() {
            // await this.paypalCallback();

            await this.fetchPackages();
        },
        mounted() {
            this.selectedPackage = this.package() || null
        },
        computed: {
            couponDiscount() {
                if (this.couponDetails && this.selectedPackage.type == 0) {
                    if (this.selectedPackage.id == 2 && this.selectedPackage.price > 0) {
                        this.couponDiscountAmount = this.couponDetails.discounted_amount
                        return this.couponDetails.discounted_amount
                    } else {
                        this.couponDiscountAmount = 0
                        return 0
                    }
                } else if (this.couponDetails && this.selectedPackage.type == 1) {
                    if (this.selectedPackage.price > 0) {
                        this.couponDiscountAmount = this.couponDetails.discounted_amount
                        return this.couponDetails.discounted_amount
                    } else {
                        this.couponDiscountAmount = 0
                        return 0
                    }
                }
                return 0
            },
            hasOrgCreateData() {
                let createOrgData = JSON.parse(localStorage.getItem("crowdfundly_create_org_data"))
                // console.log("createOrgData ? true : false: ", createOrgData ? true : false)
                return createOrgData ? true : false
            },
            selectedPackageType() {
                return this.selectedPackage?.type
            },
            showCoupon() {
                if (! this.selectedPackage) return false

                if (this.selectedPackage.type == 0 && this.selectedPackage.id == 2) {
                    return true
                } else if (this.selectedPackage.type == 1) {
                    return true
                }
                return false
            },
        },
        methods: {
            package() {
                let selectedPlan = JSON.parse(localStorage.getItem("crowdfundly_selected_package"))
                // console.log("selectedPlan: ", selectedPlan, this.selectedPackage)
                return selectedPlan
            },
            async initializeCard() {
                try {
                    this.stripe = await this.$stripe(process.env.STRIPE_PUBLIC_KEY)
                    this.elements = this.stripe.elements()
                    this.card = this.elements.create('card')

                    this.card.mount(this.$refs.card)

                    var data = this
                    this.card.on('change', function(event) {
                        data.isCompleteCardEntry = event.complete
                        let displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                        } else {
                            displayError.textContent = '';
                        }
                    });
                } catch (e) {
                    console.log('error::', e)
                }
            },
            checkAuth() {
                this.checkingAuth = true
                if (!this.$auth.loggedIn) {
                    return window.location.replace('?page=crowdfundly-dashboard')
                }
                this.checkingAuth = false
            },
            async fetchPackages() {
                this.loading = true
                await this.$axios.$get('/cashier/package')
                    .then(res => {
                        const packages = res.data.filter(item => item.type == 0)
                        const bundles = res.data.filter(item => item.type == 1)
                        for (let item of packages) {
                            this.packages.push(item)
                        }
                        this.bundles = bundles
                        // console.log("this.packages: ", this.packages)
                        // console.log("this.bundles", this.bundles)
                    })
                    .catch(error => {
                        console.log('error', error)
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            setSelectedPackage(data) {
                // console.log("setSelectedPackage", this.selectedPackage, data)
                if (this.selectedPackage && this.selectedPackage.id == data.id) {
                    this.selectedPackage = null
                    return
                }

                this.selectedPackage = data
                localStorage.setItem("crowdfundly_selected_package", JSON.stringify(this.selectedPackage))
                this.$forceUpdate()
                if (!this.hasOrgCreateData && this.selectedPackage.type !== 1) {
                    this.$redirect("organization-create")
                }
            },
            validateCoupon() {
                this.processing = true
                let params = {
                    'code': this.couponCode,
                    'packages': [{
                        id: this.selectedPackage.id,
                        qty: this.selectedPackage.qty
                    }]
                }
                this.$axios.$post('/coupons/calculate', params)
                    .then(res => {
                        // console.log("cupon: ", res)
                        this.couponDetails = res?.coupon
                    })
                    .catch(e => {
                        console.error('validate cupon error', e.response)
                        const errorMessage = e.response?.data?.message
                        this.$cfNotify('error', null, errorMessage, 3500)
                    })
                    .finally(() => {
                        this.processing = false
                    });
            },
            clearCoupon() {
                this.couponCode = null;
                this.couponDetails = null;
            },
            price(amount) {
                return Number(amount / 100).toFixed(2)
            },
            getTotal(price, qty = 1) {
                return Number((price / 100) * qty).toFixed(2)
            },
            getSubtotal() {
                if (!this.selectedPackage) {
                    return 0
                }
                // let subtotal = 0;
                // Object.keys(this.selectedPackages).map(key => {
                //     subtotal = subtotal + (this.selectedPackages[key].price * this.selectedPackages[key].qty)
                // })
                return Number(this.selectedPackage.price / 100).toFixed(2)
            },
            totalAmount() {
                let subTotal = this.getSubtotal()
                // console.log("totalAmount: ", this.couponDiscountAmount)

                if (subTotal <= 0) {
                    return 0
                }
                if (this.couponDetails && this.couponDiscountAmount != 0) {
                    return this.couponDetails.total
                }
                return subTotal
            },
            selectGateway(gateway, orgData = null) {
                this.selectedGateway = gateway

                if (gateway === 'stripe') {
                    let params = {
                        gateway: gateway,
                        packages: [this.selectedPackage],
                        email: this.$auth.user.email,
                        coupon: this.couponDetails?.code || null
                    }

                    this.initializingCard = true
                    const queries = '?action=cf_package_gateway&security=' + crowdfundlyAuth.nonce;
                    this.$axios.$post(crowdfundlyAuth.ajax_url + queries, params)
                        .then(res => {
                            // console.log('gatway', res)
                            this.paymentData = res.payment
                            if (this.totalAmount() == 0) {
                                this.createOrg(orgData)
                            }
                            return this.initializeCard()
                        })
                        .catch(error => {
                            console.log('error:', error)
                        })
                        .finally(() => {
                            this.initializingCard = false
                        });
                }
            },
            requestPayment() {
                if (this.processing) return;

                if (this.totalAmount() > 0) {
                    if (this.selectedGateway === 'paypal') {
                        return this.payWithPaypal()
                    } else {
                        return this.payWithStripe()
                    }
                } else {
                    let orgData = JSON.parse(localStorage.getItem("crowdfundly_create_org_data"))
                    this.selectGateway('stripe', orgData)
                    // this.createOrg(orgData)
                }
            },
            // payWithPaypal() {
            //     this.processing = true

            //     let params = {
            //         gateway: this.selectedGateway,
            //         packages: this.selectedPackage,
            //         user_id: this.$auth.user.id,
            //         on_success: this.$auth.cf_admin_url,
            //         on_failed: `${window.location.href}`
            //     }

            //     this.$axios.$post('/cashier/package/buy', params)
            //         .then(res => {
            //             this.paymentData = res.payment
            //             console.log('paypal res', res)
            //             if (this.paymentData?.request && this.paymentData.request?.redirect_url) {
            //                 localStorage.setItem('payment_id', res.payment.id)
            //                 window.location.href = this.paymentData.request.redirect_url
            //             } else {
            //                 // TODO: $0 payment should go to the above payment process 
            //                 this.$redirect('organization-create');
            //             }
            //         })
            //         .finally(() => {
            //             this.processing = false
            //         });
            // },
            async createOrg(orgData) {
                const queries = '?action=cf_create_organization&security=' + crowdfundlyAuth.nonce;
                this.$axios.$post(crowdfundlyAuth.ajax_url + queries, orgData)
                    .then(async (response) => {
                        this.$cfNotify('success', null, 'Organization successfully created.')
                        // console.log("org created: ", response)

                        await localStorage.removeItem("crowdfundly_create_org_data")
                        await localStorage.removeItem("crowdfundly_selected_package")
                        this.$redirect('admin')
                    })
                    .catch(async error => {
                        console.error('error', error, error.message, error.response);
                        this.$cfNotify('error', null, error.response?.data?.message, 4000);
                    })
                    .finally(async () => {
                        this.processing = false;
                    })
            },
            payWithStripe() {
                this.processing = true

                if (!this.paymentData?.request) {
                    // TODO: $0 payment should go to the above payment process
                    this.$redirect('organization-create');
                    return;
                }

                if (this.paymentData?.request && this.paymentData.request?.client_secret) {
                    this.stripe.confirmCardPayment(this.paymentData.request.client_secret, {
                            payment_method: {
                                card: this.card,
                            },
                        })
                        .then(({
                            paymentIntent
                        }) => {
                            if (paymentIntent?.status !== 'succeeded') return;

                            const data = {
                                payment_id: this.paymentData.id,
                                payment_intent: paymentIntent
                            }
                            const queries = '?action=cf_package_capture&security=' + crowdfundlyAuth.nonce;
                            this.$axios.$post(
                                    crowdfundlyAuth.ajax_url + queries,
                                    data
                                )
                                .then(async res => {
                                    // console.log('capture', res)
                                    let orgData = await JSON.parse(localStorage.getItem("crowdfundly_create_org_data"))
                                    
                                    if (orgData && this.selectedPackage?.type != 1) {
                                        this.$cfNotify('success', null, 'Payment Completed Successfully.')
                                        await this.createOrg(orgData)
                                    } else if (orgData && this.selectedPackage?.type == 1) {
                                        this.$cfNotify('success', null, 'Payment Completed Successfully. Please check your Email.', 3000)
                                        
                                        await localStorage.removeItem("crowdfundly_create_org_data")
                                        await localStorage.removeItem("crowdfundly_selected_package")
                                        setTimeout(() => {
                                            this.$redirect('organization-create')
                                        }, 3000)
                                    }
                                })
                                .catch(error => {
                                    console.log('capture error', error)
                                });
                        });
                }
            },

            // paypalCallback() {
            //     const params = window.location.search
            //     if (!params.includes('token') && !params.includes('PayerID')) return;
            //     this.loading = true

            //     return this.$axios.$post(`/cashier/payment/${localStorage.getItem('payment_id')}/capture`, params)
            //         .then((res) => {
            //             // this.$success(null, 'Successfully payment completed.')
            //             localStorage.removeItem('payment_id')
            //             return this.$redirect('organization-create')
            //         })
            //         .catch(e => {
            //             console.log({e})
            //             return this.$redirect('package')
            //         })
            //         .finally(() => {
            //             this.loading = false
            //         })
            // }
        }
    })
</script>