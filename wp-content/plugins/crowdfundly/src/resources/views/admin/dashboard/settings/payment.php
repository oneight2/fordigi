<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <layout-settings sub-title="Payment">
            <div class="settings__section settings__section--payment">
                <div class="settings__section-inner" v-if="loading">
                    <c-loader variant="primary"></c-loader>
                </div>
                <div v-else>
                    <div class="settings__section-inner">
                        <div class="row">
                            <div class="col-12">

                                <div class="payment-header d-flex align-items-center">
                                    <h4 class="settings__section-header-title">Stripe</h4>
                                    <inline-documentation>
                                        <a class="text-capitalize" href="<?php echo esc_url( 'https://crowdfundly.com/docs/how-to-configure-stripe-as-organization-payment-method/' ); ?>" target="_blank" v-text="'How To Configure Stripe'"></a>
                                    </inline-documentation>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="pyment-body payment-body--stripe">
                                    <div class="" v-if="!gateways.stripe">
                                        <p class=" my-3">Connect your stripe account to <strong> Crowdfundly </strong></p>
                                        <c-button variant="info">
                                            <a :href="stripeAuthUrl()" style="color: var(--white_light)">
                                                <span>Connect <strong v-text="'Crowdfundly'"></strong> with Stripe</span>
                                            </a>
                                            <!-- <span v-else>processing</span> -->
                                        </c-button>
                                    </div>
                                    <div v-else>
                                        <div class="form-group">
                                        
                                            <c-input-group label="Stripe Account Id" label-for="stripe-account-id">
                                                <c-input :disabled="true" id="stripe-account-id" type="text" v-model="gateways.stripe.credentials.user_id || gateways.stripe.credentials.stripe_key"></c-input>
                                            </c-input-group>
                                        </div>
                                        <div class="d-flex align-items-center  flex-wrap">
                                            <c-button variant="danger" @onpress="removePaymentMethod('stripe')" title="Remove Payment Method.">
                                            </c-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="settings__section-inner mt-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="payment-header payment-header--paypal d-flex align-items-center">
                                    <h4 class="settings__section-header-title mr-2">Paypal</h4>
                                    <c-pill label="Active" v-if="gateways.paypal"></c-pill>
                                    <inline-documentation>
                                        <a class="text-capitalize" href="<?php echo esc_url( 'https://crowdfundly.com/docs/how-to-configure-paypal-as-organization-payment-method/' ); ?>" target="_blank" v-text="'How to configure paypal'"></a>
                                    </inline-documentation>
                                </div>
                            </div>

                            <div class="col-12">
                                <div v-show="processingPayPal" class="loader loader--paypal">
                                    <p>Loading....</p>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="payment-body payment-body--paypal">
                                    <div class="btn-group d-flex align-items-center " v-if="gateways.paypal && !showPaypalForm">
                                        <c-button title="Change Paypal Credentials" btn-class="mr-3" variant="primary" @onpress="showFormOF('showPaypalForm')"></c-button>
                                        <c-button title="Disconnect Payment Method" variant="danger" @onpress="removePaymentMethod('paypal')"></c-button>
                                    </div>

                                    <form v-else @submit.prevent="savePaypalCredentials" autocomplete="off">
                                        <div class="form-group" >
                                            <c-input-group label="Clinet Id" label-for="client_id">
                                                <c-input type="text" required v-model.trim="paypalForm.client_id" autocomplete="off" class="form-control" id="client_id" placeholder="Client Id">
                                            </c-input-group>
                                        </div>
                                        <div class="form-group">
                                            <c-input-group label="Clinet Secret" label-for="client-secret">
                                                <c-input  id="client_secret" type="password" required v-model.trim="paypalForm.client_secret" autocomplete="off" class="form-control" id="client_secret" placeholder="Client Secret">
                                            </c-input-group>
                                        </div>
                                        <c-button variant="primary" title="Save"  :loading="processingPayPal" type="submit" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="settings__section-inner mt-3" v-if="supportRza == 'INR'">
                        <div class="row">
                            <div class="col-12">
                                <div class="payment-header payment-header--paypal d-flex align-items-center">
                                    <h4 class="settings__section-header-title mr-2">Razorpay</h4>
                                    <c-pill label="Active" v-if="gateways.razorpay"></c-pill>
                                    <inline-documentation>
                                        <a class="text-capitalize" href="<?php echo esc_url( 'https://crowdfundly.com/docs/how-to-configure-razorpay/' ); ?>" target="_blank" v-text="'How to configure razorpay'"></a>
                                    </inline-documentation>
                                </div>
                            </div>

                            <div class="col-12">
                                <div v-show="processingRazorpay" class="loader loader--paypal">
                                    <p>Loading....</p>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="payment-body payment-body--paypal">
                                    <div class="btn-group d-flex align-items-center " v-if="gateways.razorpay && !showRazorpayForm">
                                        <c-button title="Change Razorpay Credentials" btn-class="mr-3" variant="primary" @onpress="showFormOF('showRazorpayForm')"></c-button>
                                        <c-button title="Disconnect Payment Method" variant="danger" @onpress="removePaymentMethod('razorpay')"></c-button>
                                    </div>

                                    <form v-else @submit.prevent="saveRazorpayCredentials" autocomplete="off">
                                        <div class="form-group" >
                                            <c-input-group label="Key Id" label-for="key_id">
                                                <c-input type="text" required v-model.trim="razorpayFrom.key_id" autocomplete="off" class="form-control" id="key_id" placeholder="Key Id">
                                            </c-input-group>
                                        </div>
                                        <div class="form-group">
                                            <c-input-group label="Secret Key" label-for="secret_key">
                                                <c-input  id="secret_key" type="password" required v-model.trim="razorpayFrom.key_secret" autocomplete="off" class="form-control" placeholder="Secret Key">
                                            </c-input-group>
                                        </div>
                                        <c-button variant="primary" title="Save"  :loading="processingRazorpay" type="submit" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </layout-settings>
    </layout-dashboard>
</div>


<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                processing: false,
                processingPayPal: false,
                processingRazorpay: false,
                saving: false,
                showRazorpayForm:false,
                stripeAccount: null,
                // stripePersonalAcc: null,
                loading: false,
                loadingText: 'loading',
                processingText: "Verifying",
                gateways: [],
                // showStripeForm: false,
                // showSslcommerzForm: false,
                // showAamarPayFom: false,
                // showStripeBadge: null,
                showPaypalForm: false,
                organization: {},
                settingForm: {
                    donation: {
                        wants_tip: true,
                        tip_percentage: null,
                    }
                },
                // sslcommerzForm: {
                //     sslcom_store_id: '',
                //     sslcom_store_passwd: ''
                // },
                // aamarpayForm: {
                //     aamarpay_store_id: '',
                //     aamarpay_signature_key: ''
                // },
                paypalForm: {
                    client_id: '',
                    client_secret: ''
                },
                razorpayFrom:{
                    key_id:null,
                    key_secret: null
                }
                // personalStripe: {
                //     personal_stripe_key: '',
                //     personal_stripe_secret: ''
                // },
                // stripeSection: {
                //     title: "Stripe ",
                //     connect: true,
                //     personal: false
                // }
            }
        },
        computed: {
            supportRza(){
                console.log("Currency Code", this.$auth.organization.currency_code);
              return this.$auth.organization.currency_code
            }
        },
        async created() {
            this.loading = true
            await this.fetchOrgGateways()
            this.setStripeGetway()
            // if (this.$route.query.hasOwnProperty('code')) {
            //     this.authorizeWithCode(this.$route.query['code'])
            // } else {
            //     this.fetchOrganizationStripeConnectId()
            // }
        },
        methods: {
            stripeAuthUrl() {
                const state = {
                    'org': this.$auth.organization.username,
                    'ru': this.$auth.cf_admin_url.split('//')[1]
                }
                let baseUrl = 'https://connect.stripe.com/oauth/authorize'
                let clientID = process.env.STRIPE_CONNECT_KEY
                baseUrl += '?client_id=' + clientID
                baseUrl += '&scope=read_write'
                baseUrl += '&response_type=code'
                baseUrl += '&state=' + btoa(JSON.stringify(state))
                baseUrl += '&stripe_user[email]=' + this.$auth.user.email
                baseUrl += '&redirect_uri=' + process.env.STRIPE_CALLBACK_URL
                return baseUrl;
            },
            setStripeGetway() {
                const searchParams = new URLSearchParams(window.location.search)
                if (! searchParams.has('code')) return;

                const data = {
                    user_id: searchParams.get('code'),
                    gateway: "stripe"
                }
                this.storeGatewayCredentials(data)
                    .then(()=> {
                        this.$redirect('settings-payment')
                        this.$cfNotify('success', '' ,'Stripe Credentials Saved')
                    });
            },
            fetchOrgGateways() {
                this.$axios.$get('organization/gateways')
                    .then(response => {
                        this.gateways = response
                        if (this.gateways.paypal) {
                            this.paypalForm = this.gateways.paypal.credentials
                        }
                        if(this.gateways.razorpay){
                            this.razorpayFrom = {...this.gateways.razorpay.credentials}
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            async storeGatewayCredentials(data) {
               this.processing = true
               await this.$axios.$post('/organization/gateways',data)
                        .then(res=> {
                            this.gateways[res.gateway] = res
                            this.$forceUpdate()
                        })
                        .catch(err=>{
                            console.log(err)
                        })
                        .finally(()=>{
                            this.processing = false
                        })
            },
            savePaypalCredentials() {
                this.processingPayPal = true 
                this.storeGatewayCredentials({...this.paypalForm,gateway: 'paypal'})
                    .then(() => {
                    this['processingPayPal'] = false 
                    this.showPaypalForm = false
                    this.$cfNotify('success','','Paypal Credentials Saved')
                })
            },
            saveRazorpayCredentials(){
             this.processingRazorpay = true
             this.storeGatewayCredentials({...this.razorpayFrom,gateway: 'razorpay'})
                    .then(() => {
                    this['processingRazorpay'] = false 
                    this.showRazorpayForm = false
                    this.$cfNotify('success','','Razorpay Credentials Saved')
                })
            },
            async removePaymentMethod(paymentMethod) {
                this.$axios.$delete(`organization/gateways/${this.gateways[paymentMethod]?.id}`)
                            .then(res=>{
                                delete this.gateways[paymentMethod]
                                this.$forceUpdate()
                                this.$cfNotify('success','',res.message)
                            })
                            .catch(err=>{
                                console.lo('err', err)
                            });
            },
            showFormOF(key) {
                this[key] = true
            }
        }
    });
</script>