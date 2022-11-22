<div id="emailLogin" :class="classList">
    <layout-auth
    v-if="!organizationList"
    :bg-image="$assets('/banner/auth-bg.png')"
    :banner-image="$assets('/banner/signin.svg')">
        <c-auth-card
        classname="c-auth-card email-login"
        :footer="true"
        type="login"
        :logo="$assets('/logo/crowdfundly.png')">
            <form @submit.prevent="login">
                <c-input
                id="email"
                type="email"
                label="<?php echo esc_attr__( 'Email Address', 'crowdfundly' ) ?>"
                v-model="data.email"
                placeholder="<?php echo esc_attr__( 'example@email.com', 'crowdfundly' ) ?>"
                required>
                </c-input>
                <c-input
                id="password"
                type="password"
                label="<?php echo esc_attr__( 'Password', 'crowdfundly' ) ?>"
                v-model="data.password"
                required>
                </c-input>

                <c-button
                    class="w-full"
                    variant="primary"
                    title="<?php echo esc_attr__( 'Log In', 'crowdfundly' ); ?>"
                    :loading="processing"
                    :disabled="processing || !data.email || !data.password"
                    type="submit"
                ></c-button>
            </form>
        </c-auth-card>
    </layout-auth>

    <layout-dashboard v-if="organizationList">
        <c-auth-card
        classname="c-auth-card email-login select-org"
        :header="false"
        :footer="false"
        :logo="false">
            <div v-if="processing" class="main-loader">
                <c-loader variant="primary vh50"></c-loader>
            </div>

            <div class="org-list" v-if="!processing">
                <h3 class="org-list__title">
                    <?php echo esc_html__( 'Select your organization', 'crowdfundly' ); ?>
                </h3>
                <div class="org-list__inner">
                    <li
                        v-if="!processing"
                        v-for="organization in organizationList"
                        :key="organization.username"
                        v-text="organization.name"
                        class="org-list__item"
                        @click="selectOrganization(organization.username)"
                    >
                    </li>
                </div>
            </div>
        </c-auth-card>
    </layout-dashboard>
</div>

<script>
    let app = new Vue({
        el: '#emailLogin',
        data() {
            return {
                classList: 'w-full',
                processing: false,
                checkingAuth: false,
                data: {
                    email: null,
                    password: null
                },
                crowdfundly_app_key: null,
                authText: 'connect',
                organizationList: null
            }
        },
        // async created() {
        //     await this.checkAuth()
        // },
        methods: {
            checkAuth() {
                this.checkingAuth = true
                if (this.$auth.loggedIn) {
                    return this.$redirect('dashboard')
                }
                this.checkingAuth = false
            },
            login() {
                this.processing = true
                this.authText = crowdfundlyAuth.connecting

                const queries = '?action=cf_email_auth&security=' + crowdfundlyAuth.nonce;
                this.$axios.post(
                    crowdfundlyAuth.ajax_url + queries,
                    this.data
                )
                    .then(async res => {
                        // console.log(res)
                        if (res?.status === 200) {
                            this.$cfNotify('success', this.$auth.connected, this.$auth.success_login);
                           if (res?.data?.org_list.length > 0) {
                                this.organizationList = res?.data?.org_list
                                this.classList = 'w-full' + ' select-org-wrap'
                           } else {
                                this.$redirect('organization-create')
                           }
                        }
                    })
                    .catch(error => {
                        console.log('err::', error);
                        const {data} = error.response.data
                        this.$cfNotify('error', null, data.message)
                    })
                    .finally(() => {
                        this.crowdfundly_app_key = ''
                        this.authText = crowdfundlyAuth.connected
                        this.processing = false
                    })
            },
            selectOrganization(orgUserName) {
                // console.log(orgUserName)
                this.processing = true
                this.authText = crowdfundlyAuth.connecting

                const queries = '?action=cf_after_email_login&security=' + crowdfundlyAuth.nonce;
                this.$axios.post(
                    crowdfundlyAuth.ajax_url + queries,
                    {orgUserName: orgUserName}
                )
                    .then(async res => {
                        if (res?.status === 200) {
                            this.$redirect('dashboard')
                        }
                    })
                    .catch(error => {
                        console.log('err::', error);
                        this.$error(crowdfundlyAuth.failed, getMessageFromError(error))
                    });
            }
        }
    })
</script>