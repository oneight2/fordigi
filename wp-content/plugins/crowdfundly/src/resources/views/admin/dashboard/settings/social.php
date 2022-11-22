<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <layout-settings sub-title="Social">
            <div class="settings__section settings__section--social">
                <div class="settings__section-inner" v-if="loading">
                    <c-loader variant="primary"></c-loader>
                </div>
                <div class="settings__section-inner" v-else>
                    <div class="row">
                        <div class="col-12">
                            <form @submit.prevent="save">
                                <div class="social">
                                    <div class="form-group my-4" v-for="(social,idx) in socialLinks" :key="idx">
                                        <div class="social__item d-flex align-items-center">
                                            <i class="social__item-icon " :class="'social__item-icon--'+getSocialNetworkNameById(social.social_network_id,social.social_network.name) + ' '+getSocialNetworkIconById(social.social_network_id)"></i>
                                            <c-input type="url" v-model.trim="social.link" :placeholder="'https://www.'+getSocialNetworkNameById(social.social_network_id) +'.com/username'">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <c-button variant="primary" title="Save" type="submit" :disabled="processing" :loading="processing"></c-button>
                                    </div>
                                </div>
                            </form>
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
                loading: false,
                processing: false,
                socialTypes: [],
                socialLinks: [],
            }
        },
        async created() {
            await this.fetch();
            await this.fetchSocialNetworks();
        },
        methods: {
            async fetch() {
                this.loading = true;
                let orgUserName = this.$auth.organization.username;
                this.$axios.$get(`organizations/${orgUserName}`)
                    .then(res => {
                        console.log("socialProfiles: ", res);
                        this.socialLinks = res.socialProfiles;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            async fetchSocialNetworks() {
                this.loading = true;
                await this.$axios.$get('/social-networks')
                    .then(res => {
                        console.log('social networks: ', res)
                        this.socialTypes = res;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            getSocialNetworkNameById(id) {
                let socialNetwork = this.socialTypes.find(item => {
                    return item.id === id
                });
                if (socialNetwork && socialNetwork.name) {
                    return socialNetwork.name;
                }

                return '';
            },
            getSocialNetworkIconById(id) {
                let socialNetwork = this.socialTypes.find(item => {
                    return item.id === id
                });

                switch (socialNetwork.name) {
                    case 'facebook':
                        socialNetwork.icon = "mdi mdi-facebook";
                        break;

                    case 'twitter':
                        socialNetwork.icon = "mdi mdi-twitter";
                        break;

                    case 'linkedin':
                        socialNetwork.icon = "mdi mdi-linkedin";
                        break;

                    case 'instagram':
                        socialNetwork.icon = "mdi mdi-instagram";
                        break;

                    case 'youtube':
                        socialNetwork.icon = "mdi mdi-youtube";
                        break;

                    default:
                        break;
                }

                if (socialNetwork && socialNetwork.icon) {
                    return socialNetwork.icon;
                }
                return '';
            },
            async save() {
                this.processing = true;
                let payload = {
                    social_profiles: this.socialLinks
                }
                await this.$axios.$put('/organization/others', payload)
                    .then(res => {
                        console.log("saved: ", res);
                        this.$cfNotify('success',' ',res.message)
                    })
                    .catch(err => {
                        console.log(err)
                        this.$cfNotify('error','','Something Happend Wrong')
                    })
                    .finally(() => {
                        this.processing = false
                    })
            }
        }
    });
</script>