<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="settings settings--others">

            <settings-page-header :title="$t('settings')+' / '+$t('policies')"></settings-page-header>

            <div class="settings__inner">

                <!--tab start-->
                <div class="settings__tab">
                    <settings-tab></settings-tab>
                </div>
                <!--tab end-->

                <div class="settings__body">
                    <div v-if="loading" class="main-loader">
                        <loader></loader>
                    </div>

                    <div v-else class="settings__body-inner">
                        <form action="" @submit.prevent="save">
                            <div class="others-info">
                                <div class="form-group">
                                    <label for="other-info">
                                        {{$t('select_page_you_need')}}
                                    </label>

                                    <div class="row" id="other-info">
                                        <div class="col-12 col-sm-6">
                                            <div class="checkbox checkbox--success">
                                                <input class="checkbox__input" type="checkbox"
                                                       v-model="form.privacy_page.status"
                                                       id="privacyPolicy"/>
                                                <label class="checkbox__label font-weight-normal text-capitalize"
                                                       for="privacyPolicy"
                                                       v-text="$t('privacy_policy')"></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="checkbox checkbox--success">
                                                <input class="checkbox__input" type="checkbox"
                                                       v-model="form.terms_page.status"
                                                       id="termsAndConditions"/>
                                                <label class="checkbox__label font-weight-normal text-capitalize"
                                                       for="termsAndConditions"
                                                       v-text="$t('terms_conditions')"></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="checkbox checkbox--success">
                                                <input class="checkbox__input" type="checkbox"
                                                       v-model="form.refund_policy_page.status"
                                                       id="refundPolicy"/>
                                                <label class="checkbox__label font-weight-normal text-capitalize"
                                                       for="refundPolicy"
                                                       v-text="$t('refund_policy')"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" v-if="form.privacy_page.status">
                                    <label>{{$t('privacy_policy')}}</label>
                                    <g-editor id="privacyPolicyData" :data="form.privacy_page.value"
                                              @data="setPrivacyData"></g-editor>
                                </div>

                                <div class="form-group" v-if="form.terms_page.status">
                                    <label>{{$t('terms_conditions')}}</label>
                                    <g-editor id="termsAndConditionsData" :data="form.terms_page.value"
                                              @data="setTermsData"></g-editor>
                                </div>

                                <div class="form-group" v-if="form.refund_policy_page.status">
                                    <label>{{$t('refund_policy')}}</label>
                                    <g-editor id="refundPolicyData" :data="form.refund_policy_page.value"
                                              @data="setRefundData"></g-editor>
                                </div>

<!--                                <div class="form-group">-->
<!--                                    <form-error-box></form-error-box>-->
<!--                                </div>-->
                            </div>

                            <loading-button class="btn-primary btn-min-50 min-150" :title="$t('save')"
                                            :disabled="processing"
                                            :loading="processing" @on-press="save" type="button"></loading-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </dashboard-layout>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',

        data() {
            return {
                loading: false,
                processing: false,
                form: {
                    privacy_page: {
                        status: false,
                        title: this.$t('privacy_policy'),
                        slug: 'privacy_page',
                        value: null,
                        type: this.$enum.OrgContent.TYPE_PAGE
                    },
                    terms_page: {
                        status: false,
                        title: this.$t('terms_conditions'),
                        value: null,
                        slug: 'terms_page',
                        type: this.$enum.OrgContent.TYPE_PAGE
                    },
                    refund_policy_page: {
                        status: false,
                        title: this.$t('refund_policy'),
                        slug: 'refund_policy_page',
                        value: null,
                        type: this.$enum.OrgContent.TYPE_PAGE
                    },
                },
            };
        },

        computed: {
            organization() {
                return this.$auth.organization
            },

            preparePayload() {
                let payload = [];
                Object.keys(this.form).forEach(item => {
                    payload.push(this.form[item]);
                });
                return {items: payload};
            },
        },

        async mounted() {
            await this.fetchPages();
        },
        methods: {
            async fetchPages() {
                this.loading = true;
                let endpoint = route_with_query('organization-pages', null, this.organization.username).absolute_path;
                await this.$axios
                    .get(endpoint)
                    .then(response => {
                        this.mergeResponse(response);
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            save() {
                this.processing = true;
                let endpoint = route('organization-contents').absolute_path;
                this.$axios
                    .put(endpoint, this.preparePayload)
                    .then(response => {
                        this.$success(null, response.message || this.$t('success'));
                        this.fetchPages();
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.processing = false;
                    });
            },
            mergeResponse(response) {
                response.forEach(item => {
                    if (this.form[item.slug]) {
                        this.form[item.slug] = item;
                    }
                })
            },
            setPrivacyData(data) {
                this.form.privacy_page.value = data
            },
            setRefundData(data) {
                this.form.refund_policy_page.value = data
            },
            setTermsData(data) {
                this.form.terms_page.value = data
            },
        }
    });
</script>
