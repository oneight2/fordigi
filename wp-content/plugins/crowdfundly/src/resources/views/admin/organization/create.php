<div id="organization-create" class="main-wrapper">
    <layout-dashboard>
        <div class="container">
            <div class="main-wrapper__loader" v-if="loading">
                <c-loader variant="primary"></c-loader>
            </div>

            <div v-else class="organization-create">
                <h2 class="organization-create__title">
                    <?php _e('Create Your Organization', 'crowdfundly'); ?>
                </h2>
                <p v-if="packageName">You have selected <span v-text="packageName" class="text-primary" /> Plan</p>
                <div class="organization-create__inner">
                    <form @submit.prevent="create" class="w-full">
                        <!-- <c-input-group
                        label="<?php echo esc_attr__('Select A Plan', 'crowdfundly'); ?>"
                        label-for="subscriptions"
                        required>
                            <c-search-select
                            id="subscriptions"
                            placeholder="<?php echo esc_attr__('Select a plan', 'crowdfundly'); ?>"
                            :options="subscriptions"
                            :reduce="subscription => subscription.id"
                            label="package_name"
                            v-model="selectedSubscription"
                            :required="true">
                            </c-search-select>
                        </c-input-group> -->
                        <c-input label="<?php echo esc_attr__('Organization Name', 'crowdfundly'); ?>" type="text" v-model="form.name" required placeholder="<?php echo esc_attr__('Enter organization name', 'crowdfundly'); ?>">
                        </c-input>

                        <c-input-group label="<?php echo esc_attr__('Username', 'crowdfundly'); ?>" required>
                            <template v-slot:label v-if="showUsernameUnavailability">
                                <small class="text-transform-none" :class="getAvailabilityTextCSSClass" v-text="usernameAvailabilityText">
                                </small>
                            </template>

                            <c-input group-class="mb-1" input-inner-class="subdomain-input" input-class="subdomain-input__input" v-debounce:1s="checkUsernameAvailability" type="text" v-model="form.username" required>
                                <div class="subdomain-input__domain" v-text="domain"></div>
                            </c-input>
                            <small class="text-warning font-italic">
                                <strong><?php _e('Tip:', 'crowdfundly'); ?></strong>
                                <?php _e("Length must be between 4 and 20 lowercase characters, numbers and - in middle are
                                allowed.", "crowdfundly"); ?>
                            </small>
                        </c-input-group>

                        <!-- <c-textarea label="<?php echo esc_attr__('Address', 'crowdfundly'); ?>" v-model="form.address" rows="4" required placeholder="<?php echo esc_attr__('Write organization address here..', 'crowdfundly'); ?>">
                        </c-textarea> -->

                        <!-- <c-input-group label="<?php echo esc_attr__('Description', 'crowdfundly'); ?>" label-for="organization-description">
                            <vue-editor class="w-full" id="organization-description" v-model="form.description" :editor-toolbar="customToolbar">
                            </vue-editor>
                        </c-input-group> -->

                        <div class="row">
                            <div class="col-6">
                                <c-input-group label="<?php echo esc_attr__('Country', 'crowdfundly'); ?>" label-for="country" required>
                                    <c-search-select id="country" placeholder="Select country" :options="countries" :reduce="country => country.id" label="country_name" v-model="form.country_id" :required="true">
                                    </c-search-select>
                                </c-input-group>
                            </div>
                            <div class="col-6">
                                <c-input-group label="<?php echo esc_attr__('Currency', 'crowdfundly'); ?>" label-for="currencies" required>
                                    <c-search-select id="currencies" placeholder="<?php echo esc_attr__('Select currency', 'crowdfundly'); ?>" :options="currencies" :reduce="currency => currency.id" label="full_info" v-model="form.currency_id" :required="true">
                                    </c-search-select>
                                    <small class="text-warning font-italic">
                                        <strong><?php _e('Note:', 'crowdfundly'); ?></strong>
                                        <?php _e('You can\'t change the currency after the organization is created.', 'crowdfundly'); ?>
                                    </small>
                                </c-input-group>
                            </div>
                        </div>

                        <!-- <c-input-group label="<?php echo esc_attr__('Contact Number', 'crowdfundly'); ?>" label-for="currencies" required>
                            <div class="number-input w-full">
                                <c-search-select id="number-code" class="number-input__select" placeholder="<?php echo esc_attr__('Select code', 'crowdfundly'); ?>" :options="countries" :reduce="currency => currency.id" label="full_info" v-model="form.contact_number_code" :required="true">
                                </c-search-select>
                                <c-input group-class="number-input__input mb-0" placeholder="<?php echo esc_attr__('Enter contact number here', 'crowdfundly'); ?>" type="text" v-model="form.contact_number" required>
                                </c-input>
                            </div>
                        </c-input-group> -->
                        <c-input-group>
                            <c-checkbox id="privacyPolicy" v-model="isAgreeTerms" :checked="false">
                                <?php _e('I agree to the', 'crowdfundly'); ?>
                                <a href="<?php echo esc_url('https://crowdfundly.com/privacy'); ?>">
                                    <?php _e('Privacy policy', 'crowdfundly'); ?>
                                </a>
                            </c-checkbox>
                        </c-input-group>

                        <c-button :disabled="!isAgreeTerms || processing" variant="primary" title="<?php echo esc_attr__('Create & Continue', 'crowdfundly'); ?>" :loading="false" type="submit">
                        </c-button>
                    </form>
                </div>
            </div>
        </div>
    </layout-dashboard>
</div>

<script>
    let app = new Vue({
        el: '#organization-create',
        data() {
            return {
                loading: false,
                subscriptions: [],
                form: {
                    name: null,
                    username: null,
                    address: null,
                    description: null,
                    country_id: 240,
                    contact_number: null,
                    contact_number_code: 240,
                    currency_id: 212
                },
                isCheckingAvailability: true,
                isUsernameAvailable: false,
                isAgreeTerms: false,
                processing: false,
                customToolbar: [
                    ["bold", "italic", "underline"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }],
                ],
                // selectedSubscription: null
            };
        },
        watch: {
            'form.username': function() {
                this.form.username = this.form.username.toLowerCase()
            }
        },

        created() {
            // this.fetchPackages()
            this.$store.dispatch('countries/fetch')
            this.$store.dispatch('currencies/fetch')
        },
        computed: {
            packageName() {
                let selectedPlan = JSON.parse(localStorage.getItem("crowdfundly_selected_package"))
                return selectedPlan?.name
            },
            countries() {
                return this.$store.state.countries.data;
            },
            currencies() {
                return this.$store.state.currencies.data
            },

            isValidUserName() {
                return this.form?.username?.match(/^(?=[a-z0-9-]{4,20}$)(?!.*[-.]{2})[^-.].*[^-.]$/)
            },
            showUsernameUnavailability() {
                return this.form?.username?.length > 3 && this.isValidUserName;
            },
            usernameAvailabilityText() {
                if (this.isCheckingAvailability) {
                    return 'Checking availability...'
                }
                return this.isUsernameAvailable ? 'Available' : 'Not available'
            },
            getAvailabilityTextCSSClass() {
                if (this.isCheckingAvailability) {
                    return 'text-primary';
                }
                return this.isUsernameAvailable ? 'text-success' : 'text-danger';
            },
            domain() {
                return process.env.BASE_DOMAIN
            },
        },
        methods: {
            // fetchPackages() {
            //     this.loading = true
            //     this.$axios.$get('/cashier/subscriptions?limit=100')
            //         .then(response => {
            //             let subscriptions = response.data
            // if (subscriptions.length == 0) {
            // this.$redirect('package')
            // }
            // subscriptions.map(subscription => {
            //     subscription.package_name = subscription.package.name
            // })
            // this.subscriptions = subscriptions;
            //         })
            //         .catch(e => {
            //             console.log('error', e);
            //         })
            //         .finally(() => {
            //             this.loading = false
            //         })
            // },

            async checkUsernameAvailability() {
                if (!this.form.username || !this.form.username.length > 3 || !this.isValidUserName) return false;

                this.isCheckingAvailability = true;
                await this.$axios
                    .$get(`/organization/${this.form.username}/check-username-availability`)
                    .then(response => {
                        this.isUsernameAvailable = response.is_available;
                    })
                    .catch(error => {
                        this.isUsernameAvailable = false;
                    }).finally(() => {
                        this.isCheckingAvailability = false;
                    });
            },
            async create() {
                if (!this.isAgreeTerms) {
                    this.$cfNotify('error', null, 'Please agree to terms');
                    return;
                }
                if (!this.isValidUserName) {
                    return this.$cfNotify('error', 'Invalid username', 'Please check username length and supported characters', 4000);
                }
                this.processing = true;
                // this.form.subscription_id = this.selectedSubscription

                await localStorage.setItem("crowdfundly_create_org_data", JSON.stringify(this.form))
                this.processing = false;
                this.$redirect('package')
                
                // const queries = '?action=cf_create_organization&security=' + crowdfundlyAuth.nonce;
                // this.$axios.$post(crowdfundlyAuth.ajax_url + queries, this.form)
                //     .then(response => {
                //         this.generateToken(response?.id)
                //     })
                //     .catch(async error => {
                //         console.log('error', error, error.message, error.response);
                //         this.$cfNotify('error', null, error.response?.data?.message, 4000);
                //     })
                //     .finally(async () => {
                //         this.processing = false;
                //     })
            },
            generateToken(orgId) {
                this.processing = true;
                this.$axios.defaults.headers.common['organization-id'] = orgId
                this.$axios.$post('/wp/generate-token')
                    .then(response => {
                        this.appKeyLogin(response.data)
                    })
                    .finally(() => {
                        this.processing = false;
                    })
            },
            appKeyLogin(key) {
                this.loading = true
                const bodyParams = {
                    action: 'action=cf_appkey_auth',
                    nonce: '&security=' + crowdfundlyAuth.nonce,
                    app_key: '&app_key=' + key,
                }

                this.$axios.post(
                        crowdfundlyAuth.ajax_url,
                        bodyParams.action + bodyParams.nonce + bodyParams.app_key, {
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        }
                    )
                    .then(async res => {
                        let {
                            data
                        } = res
                        if (data?.code === 200) {
                            // await this.$store.dispatch('organization/fetch', res.data.organization_username)
                            // this.$success(crowdfundlyAuth.success, crowdfundlyAuth.success_authenticated)
                            this.$redirect('dashboard')

                        } else {
                            // this.$error(crowdfundlyAuth.failed, res.message)
                        }
                    })
                    .catch(error => {
                        console.log('err::', error);
                        // this.$error(crowdfundlyAuth.failed, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loading = false
                        // this.$store.dispatch('clear_temp_auth')
                    })
            }
        }
    })
</script>