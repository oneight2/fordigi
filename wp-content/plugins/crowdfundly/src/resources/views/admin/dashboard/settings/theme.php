<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <layout-settings sub-title="Theme">
            <div class="settings__section settings__section--theme">
                <div class="settings__section-inner" v-if="loading">
                    <c-loader variant="primary"></c-loader>
                </div>
                <div class="settings__section-inner" v-else>
                    <div class="theme">
                        <div class="row">
                            <div class="col-12">
                                <div class="theme__header">
                                    <h4 class="settings__section-header-title text-capitalize">Choose Theme</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-6 col-md-6">
                                <theme-picker id="temp-1" img-url="<?php echo cf_asset( 'images/admin/theme-template/1.png' ); ?>">
                                    <c-radio variant="success"  label="Theme 1" id="theme-1" name="template_id" v-model="template_id"  :default-value="1"></c-radio>
                                </theme-picker>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <theme-picker id="temp-2" img-url="<?php echo cf_asset( 'images/admin/theme-template/2.png' ); ?>">
                                    <c-radio variant="success"  label="Theme 2" id="theme-2" name="template_id" v-model="template_id"  :default-value="2"></c-radio>
                                </theme-picker>
                            </div>
                            <div class="col-12 mt-4">
                                <c-button title="save" @onpress="save" :loading="processingTheme"></c-button>
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
                template_id: null,
                checkedValus: ['1'],
                currencies: this.$currencies,
                loading: false,
                processing: false,
                processingTheme: false,
                loadingColors: false,
                brandColor: {
                    primary: '#5777f3',
                    secondary: '#14C479',
                }
            };
        },
        created() {
            this.template_id = this.$auth.organization.template_id
            this.fetchBrandColorSetting()
        },
        watch: {
           template_id(val, oldVal) {
                console.log('selected template: ', val)
            },
        },
        methods: {
            fetchBrandColorSetting() {
                this.loadingColors = true;
                this.loading = true
                let orgId = this.$auth.organization.id
                this.$axios.$get(`/organization/${orgId}/brand-color`)
                    .then(res => {
                        this.brandColor = {
                            ...this.brandColor,
                            ...res
                        }
                        console.log('brandColors: ', this.brandColor);
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.loadingColors = false;
                        this.loading = false
                    })
            },
            async save() {

                if (this.template_id == null) {
                    this.$cfNotify('warning', '', 'Please Select A Theme !')
                    return;
                }
                this.processingTheme = true;

                const bodyParams = {
                    action: 'action=cf_change_theme',
                    nonce: '&security=' + crowdfundlyAuth.nonce,
                    theme_id: '&theme_id=' + this.template_id,
                }
                this.$axios.$post(
                        this.$auth.ajax_url,
                        bodyParams.action + bodyParams.nonce + bodyParams.theme_id
                    )
                    .then(res => {
                        this.$cfNotify('success', '', res.message);
                    })
                    .catch(err => {
                        console.log(err)
                        this.$cfNotify('error', '', res.message);
                    })
                    .finally(() => {
                        this.processingTheme = false
                    })
            }
        },
    });
</script>