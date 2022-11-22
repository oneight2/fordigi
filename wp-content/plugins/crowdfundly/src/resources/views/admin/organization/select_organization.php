<div id="select_org" :class="classList">
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
        el: '#select_org',
        data() {
            return {
                classList: 'w-full',
                processing: false,
                organizationList: null
            }
        },
        async created() {
            if (this.$auth.loggedIn) {
                return this.$redirect('dashboard')
            }
            this.selectOrg();
        },
        methods: {
            selectOrg() {
                this.processing = true
                this.authText = crowdfundlyAuth.connecting

                const queries = '?action=cf_org_list&security=' + crowdfundlyAuth.nonce;
                this.$axios.post(
                    crowdfundlyAuth.ajax_url + queries,
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
                        const {data} = error.response.data
                        console.log('err::', data);
                        this.$cfNotify('error', null, data.message)
                    })
                    .finally(() => {
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
