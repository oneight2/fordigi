<div id="signup" style="width: 100%">
    <layout-auth
        :bg-image="$assets('/banner/auth-bg.png')"
        :banner-image="$assets('/banner/signin.svg')">
        <c-auth-card type="signup" :footer="false" :logo="$assets('/logo/crowdfundly.png')">
            <form @submit.prevent="register">
                <c-input
                id="name"
                type="text"
                label="<?php echo esc_attr__( 'Full Name', 'crowdfundly' ); ?>"
                v-model="data.name"
                placeholder="<?php echo esc_attr__( 'Your full name', 'crowdfundly' ); ?>"
                required>
                </c-input>

                <c-input
                id="email"
                type="email"
                label="<?php echo esc_attr__( 'Email', 'crowdfundly' ); ?>"
                v-model="data.email"
                placeholder="example@email.com"
                required>
                </c-input>

                <c-input
                id="password"
                type="password"
                label="<?php echo esc_attr__( 'Password', 'crowdfundly' ); ?>"
                v-model.trim="data.password"
                maxlength="60"
                minlength="6"
                placeholder="<?php echo esc_attr__( 'Password', 'crowdfundly' ); ?>"
                required>
                </c-input>

                <c-input
                id="confirm_password"
                type="password"
                label="<?php echo esc_attr__( 'Confirm Password', 'crowdfundly' ); ?>"
                v-model.trim="data.password_confirmation"
                maxlength="60"
                minlength="6"
                placeholder="<?php echo esc_attr__( 'Confirm password', 'crowdfundly' ); ?>"
                required>
                </c-input>
                <c-input-group>
                    <c-checkbox
                    id="terms&conditions"
                    v-model="acceptTermsAndConditions"
                    :required="true"
                    :checked="false">
                        <?php _e( 'By Creating An Account, I Accept The', 'crowdfundly' ); ?>
                        <a href="<?php echo esc_url( 'https://crowdfundly.com/terms/' ); ?>" target="_blank">
                            <?php _e( 'Terms', 'crowdfundly' ); ?>
                        </a>

                        <?php _e( 'And Privacy', 'crowdfundly' ); ?> 
                        <a href="<?php echo esc_url( 'https://crowdfundly.com/privacy/' ); ?>" target="_blank">
                            <?php _e( 'Conditions', 'crowdfundly' ); ?>
                        </a>.
                    </c-checkbox>
                </c-input-group>
                <c-button
                btn-class="w-full"
                variant="primary"
                title="<?php echo esc_attr__( 'Sign Up', 'crowdfundly' ); ?>"
                :loading="processing"
                :disabled="!acceptTermsAndConditions"
                type="submit">
                </c-button>
            </form>
        </c-auth-card>
    </layout-auth>
</div>


<script>
    let app = new Vue({
        el: '#signup',
        data() {
            return {
                processing: false,
                checkingAuth: false,
                acceptTermsAndConditions: false,
                data: {
                    name: '',
                    email: '',
                    password: '',
                    type: 'regular',
                    password_confirmation: '',
                }
            }
        },
        methods: {
            register() {
                this.processing = true

                const queries = '?action=cf_signup&security=' + crowdfundlyAuth.nonce;
                this.$axios.$post(
                    crowdfundlyAuth.ajax_url + queries, this.data)
                    .then(async res => {
                        // console.log(res)
                        let data = {
                            bearer_token: res.token,
                            token_ttl: res.ttl,
                            tempLoggedIn: res.temp_login,
                            login_session: res.login_session,
                            user: res.user,
                        }
                        crowdfundlyAuth = {...crowdfundlyAuth, ...data}
                        this.$redirect('organization-create')
                    })
                    .catch(error => {
                        console.log('err::', error.response);
                        const {data} = error.response.data
                        if ( data && data.errors ) {
                            if ( data.errors.email ) {
                                const {email} = data.errors;
                                this.$cfNotify('error', this.$auth.failed, email[0], 7000);
                            } else if ( data.errors.password ) {
                                const {password} = data.errors;
                                this.$cfNotify('error', this.$auth.failed, password[0], 7000);
                            }
                            return;
                        }
                        const {statusText} = error.response;
                        this.$cfNotify('error', this.$auth.failed, statusText);
                    })
                    .finally(() => {
                        this.processing = false
                    })
            },
        }
    })
</script>