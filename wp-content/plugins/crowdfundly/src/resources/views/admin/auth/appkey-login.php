<div id="appKeyLogin" style="width: 100%">
    <layout-auth
            :bg-image="$assets('/banner/auth-bg.png')"
            :banner-image="$assets('/banner/signin.svg')">
        <c-auth-card :footer="true" type="login" :logo="$assets('/logo/crowdfundly.png')">
            <form @submit.prevent="appKeyAuth">
                <c-input
                id="app-key"
                type="text"
                label="<?php echo esc_attr__( 'APP Key', 'crowdfundly' ) ?>"
                v-model="crowdfundly_app_key"
                placeholder="<?php echo esc_attr__( 'Please enter app key here.', 'crowdfundly' ) ?>"
                required>
                </c-input>

                <c-button
                        class="w-full"
                        variant="primary"
                        title="<?php echo esc_attr__('Connect', 'crowdfundly'); ?>"
                        :loading="processing"
                        type="submit"
                        :disabled="processing || !crowdfundly_app_key"
                >
                </c-button>
            </form>
        </c-auth-card>
    </layout-auth>
</div>

<script>
    let app = new Vue({
        el: '#appKeyLogin',
        data() {
            return {
                processing: false,
                checkingAuth: false,
                crowdfundly_app_key: null,
                authText: 'connect',
                responseCode: null
            }
        },
        async created() {
            await this.checkAuth()
        },
        methods: {
            checkAuth() {
                this.checkingAuth = true
                if (this.$auth.loggedIn) {
                    return this.$redirect('dashboard')
                }
                this.checkingAuth = false
            },
            appKeyAuth() {
                this.processing = true
                this.authText = crowdfundlyAuth.connecting
                const bodyParams = {
                    action: 'action=cf_appkey_auth',
                    nonce: '&security=' + crowdfundlyAuth.nonce,
                    app_key: '&app_key=' + this.crowdfundly_app_key,
                }

                this.$axios.post(
                    crowdfundlyAuth.ajax_url,
                    bodyParams.action + bodyParams.nonce + bodyParams.app_key,
                    {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
                )
                    .then(async res => {
                        let {data} = res
                        if (data?.code === 200) {
                            this.$cfNotify('success', this.$auth.connected, this.$auth.success_connected)
                            // await this.$store.dispatch('organization/fetch', res.data.organization_username)
                            this.$redirect('dashboard')
                        }
                    })
                    .catch(error => {
                        this.$cfNotify('error', null, error.message)
                        console.log('err::', error);
                    })
                    .finally(() => {
                        this.crowdfundly_app_key = ''
                        this.authText = crowdfundlyAuth.connected
                        this.processing = false
                    })
            }
        }
    })
</script>