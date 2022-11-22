<div id="welcome" class="welcome">
    <layout-auth
            :bg-image="$assets('/banner/auth-bg.png')"
            :banner-image="$assets('/banner/signin.svg')">
        <div class="welcome__inner">
            <div class="welcome__logo">
                <a href="<?php echo esc_url( CROWDFUNDLY_URL ); ?>" target="_blank">
                    <img src="<?php echo esc_url( cf_asset( 'images/admin/logo/crowdfundly.png' ) ); ?>" alt="<?php _e( 'Crowdfundly', 'crowdfundly' ); ?>">
                </a>
            </div>
            <h1 class="welcome__title">
                <?php echo esc_html__( 'All-In-One Digital Fundraising Solution', 'crowdfundly' ); ?>
            </h1>
            <p class="welcome__subtitle">
                <?php echo esc_html__( 'A powerful tool, designed for non-profit, content creators and creative projects. Boost your cause and raise funds by creating your own campaign.', 'crowdfundly' ); ?>
            </p>

            <div class="welcome__button-group">
                <c-button class="w-full mr-3" variant="primary" title="<?php echo esc_attr__( 'I Have An Account', 'crowdfundly' ) ?>" :loading="processing"
                          type="button" @onpress="()=>$redirect('appkey-login')"></c-button>

                <c-button class="w-full" variant="primary" title="<?php echo esc_attr__( 'Create An Account', 'crowdfundly' ) ?>" :loading="processing"
                          type="button" @onpress="()=>$redirect('signup')"></c-button>
            </div>
        </div>
    </layout-auth>
</div>


<script>
    let app = new Vue({
        el: '#welcome',
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
                    action: 'action=appkey_auth',
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
                            // this.$success(crowdfundlyAuth.success, crowdfundlyAuth.success_authenticated)
                            this.$redirect('dashboard')

                        } else {
                            // this.$error(crowdfundlyAuth.failed, res.message)
                        }
                    })
                    .catch(error => {
                        console.log('err::', error);
                        this.$error(crowdfundlyAuth.failed, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.crowdfundly_app_key = ''
                        this.authText = crowdfundlyAuth.connect
                        this.processing = false
                        this.$store.dispatch('clear_temp_auth')
                    })
            }
        }
    })
</script>