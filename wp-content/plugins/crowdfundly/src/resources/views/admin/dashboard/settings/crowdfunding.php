<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="settings settings--others">

            <settings-page-header :title="$t('settings')+' / '+$t('crowdfunding')"></settings-page-header>

            <div class="settings__inner">

                <!--tab start-->
                <div class="settings__tab">
                    <settings-tab></settings-tab>
                </div>
                <!--tab end-->

                <div v-if="loading" class="settings__body bg-transparent p-0">
                    <div class="main-loader">
                        <loader></loader>
                    </div>
                </div>

                <div v-else class="settings__body bg-transparent p-0">
                    <form action="" @submit.prevent="saveSettings">
                        <div class="settings__section">
                            <div class="settings__section-inner">
                                <div class="form-group max-500">
                                    <label for="commission_percentage" class="d-flex align-items-center">
                                        {{ $t('commission_percentage') }}(%)
                                        <small v-if="!isCommissionEnabled"
                                               class="status status--sm status--primary ml-1 text-bold"
                                               v-text="$t('upgrade')"></small>
                                    </label>
                                    <input type="number"
                                           min="0"
                                           step="0.01"
                                           v-model.trim="settingForm.donation.commission_percentage"
                                           :disabled="!isCommissionEnabled"
                                           class="form-control"
                                           id="commission_percentage"
                                           :placeholder="$t('commission_percentage')">
                                    <span v-if="false"
                                          class="small">{{ $t('contributor_will_see_tip_presets_based_on__') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings__section">
                            <div class="settings__section-inner">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <div class="form-group">
                                            <label for="auto_approval" class="d-flex align-items-center mb-0">
                                                {{ $t('auto_approval') }}
                                                <small v-if="!isCommissionEnabled"
                                                       class="status status--sm status--primary ml-1 text-bold"
                                                       v-text="$t('upgrade')"></small>
                                            </label>
                                            <small>{{ $t('auto_approval_for_publishing_new_campaign') }}</small>
                                            <switcher id="auto_approval"
                                                      class="mt-2"
                                                      :disabled="!isCommissionEnabled"
                                                      :active="settingForm.fundraiser.auto_approval"
                                                      v-model.trim="settingForm.fundraiser.auto_approval"
                                                      type="primary"></switcher>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <div class="form-group">
                                            <label for="allow_public_fundrise" class="d-flex align-items-center mb-0">
                                                {{ $t('allow_public_fundraise') }}
                                                <small v-if="!isCommissionEnabled"
                                                       class="status status--sm status--primary ml-1 text-bold"
                                                       v-text="$t('upgrade')"></small>

                                            </label>
                                            <small>{{ $t('allow_public_fundraise_for_campaign') }}</small>
                                            <switcher id="allow_public_fundrise"
                                                      class="mt-2"
                                                      :disabled="!isCommissionEnabled"
                                                      :active="settingForm.fundraiser.allow_public_fundraise"
                                                      v-model.trim="settingForm.fundraiser.allow_public_fundraise"
                                                      type="primary"></switcher>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <div class="form-group">
                                            <label for="update_auto_approval" class="d-flex align-items-center mb-0">
                                                {{ $t('update') }} {{ $t('auto_approval') }}
                                                <small v-if="!isCommissionEnabled"
                                                       class="status status--sm status--primary ml-1 text-bold"
                                                       v-text="$t('upgrade')"></small>
                                            </label>
                                            <small>{{ $t('auto_approval_for_updated_campaign') }}</small>
                                            <switcher id="update_auto_approval"
                                                      class="mt-2"
                                                      :disabled="!isCommissionEnabled"
                                                      :active="settingForm.fundraiser.update_auto_approval"
                                                      v-model.trim="settingForm.fundraiser.update_auto_approval"
                                                      type="primary"></switcher>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <div class="form-group">
                                            <label for="allow-tip" class="mb-0">
                                                <div class="d-flex align-items-center">
                                                    {{ $t('allow_tip') }}
                                                    <small v-if="!isTipsEnabled"
                                                           class="status status--sm status--primary ml-1 text-bold"
                                                           v-text="$t('upgrade')"></small>
                                                </div>
                                            </label>
                                            <br>
                                            <small>{{ $t('allow_tip_during_contribution') }}</small>

                                            <switcher v-model="settingForm.donation.wants_tip"
                                                      id="allow-tip"
                                                      class="mt-2"
                                                      :disabled="!isTipsEnabled"
                                                      :active="settingForm.donation.wants_tip"
                                                      type="primary"></switcher>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <div class="form-group">
                                            <label for="show_similar_campaigns" class="mb-0">
                                                <div class="d-flex align-items-center">
                                                    {{ $t('show_similar_campaigns') }}
                                                </div>
                                            </label>
                                            <br>
                                            <small>{{ $t('show_similar_campaigns_during_contribution') }}</small>
                                            <switcher v-model="settingForm.fundraiser.show_similar_campaigns"
                                                      id="show_similar_campaigns"
                                                      class="mt-2"
                                                      :active="settingForm.fundraiser.show_similar_campaigns"
                                                      type="primary"></switcher>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
                                        <div class="form-group">
                                            <label for="allow_escrow" class="d-flex align-items-center mb-0">
                                                {{ $t('escrow') }}
                                                <small v-if="!isRefundEnabled"
                                                       class="status status--sm status--primary ml-1 text-bold"
                                                       v-text="$t('upgrade')"></small>
                                            </label>
                                            <small>{{ $t('do_you_want_to_add_escrow_duration') }}</small>
                                            <switcher id="allow_escrow"
                                                      class="mt-2"
                                                      :disabled="!isRefundEnabled"
                                                      :active="settingForm.fundraiser.escrow_enabled"
                                                      v-model.trim="settingForm.fundraiser.escrow_enabled"
                                                      type="primary"></switcher>
                                        </div>
                                    </div>

                                    <transition name="fade">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4"
                                             v-if="settingForm.fundraiser.escrow_enabled">
                                            <div class="form-group col-12 col-sm-6 col-md-10 col-xl-8 p-0">
                                                <label for="escrow_duration">
                                                    {{ $t('escrow_duration') }}
                                                </label>
                                                <div class="form-group__subdomain">
                                                    <input
                                                            type="number"
                                                            class="form-control"
                                                            id="escrow_duration"
                                                            step="1"
                                                            min="1"
                                                            v-model="settingForm.fundraiser.escrow_duration"
                                                    />
                                                    <span class="form-group__subdomain-name">{{ $t('days') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>

                                    <transition name="fade">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4"
                                             v-if="settingForm.fundraiser.escrow_enabled">
                                            <div class="form-group">
                                                <label for="allow_refund" class="mb-0">
                                                    <div class="d-flex align-items-center">
                                                        {{ $t('allow_Refund') }}
                                                        <small v-if="!isRefundEnabled"
                                                               class="status status--sm status--primary ml-1 text-bold"
                                                               v-text="$t('upgrade')"></small>
                                                    </div>
                                                </label>
                                                <br>
                                                <small v-text="$t('allow_contributor_to_request_for_refund_contributed_amount')"></small>
                                                <switcher id="allow_refund"
                                                          class="mt-2"
                                                          :disabled="!isRefundEnabled"
                                                          :active="settingForm.fundraiser.allow_refund"
                                                          v-model.trim="settingForm.fundraiser.allow_refund"
                                                          type="primary"></switcher>
                                            </div>
                                        </div>
                                    </transition>
                                </div>

                                <!--                                <form-error-box></form-error-box>-->
                            </div>
                        </div>
                        <div class="settings__section">
                            <div class="settings__section-inner d-flex align-items-center justify-content-between">
                                <loading-button class="btn-primary btn-min-50 min-150" :title="$t('save')"
                                                :disabled="processing"
                                                :loading="processing" type="submit"></loading-button>
                            </div>
                        </div>
                    </form>
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
                settingForm: {
                    fundraiser: {
                        auto_approval: false,
                        escrow_duration: 0,
                        update_auto_approval: false,
                        allow_refund: false,
                        escrow_enabled: false,
                        allow_public_fundraise: true,
                        show_similar_campaigns: false,
                        allow_login: false
                    },
                    donation: {
                        commission_percentage: 0,
                        wants_tip: false,
                        tip_percentage: 5,
                    }
                },
                isCommissionEnabled: false,
                isTipsEnabled: false,
                isRefundEnabled: false,
            };
        },
        computed: {
            organization() {
                return this.$auth.organization
            }
        },
        async mounted() {
            await this.fetchSetting();
            await this.checkPlan('system_commission', 'isCommissionEnabled')
            await this.checkPlan('donation_tips', 'isTipsEnabled')
            await this.checkPlan('allow_donation_refund', 'isRefundEnabled')
        },
        methods: {
            async fetchSetting() {
                this.loading = true;
                let endpoint = route_with_query('get-organization-settings', null, this.organization.id).absolute_path;
                await this.$axios
                    .get(endpoint)
                    .then(response => {
                        if (response.fundraiser) {
                            this.settingForm.fundraiser = response.fundraiser;
                            this.settingForm.donation = response.donation;
                            this.settingForm.fundraiser.escrow_duration = this.settingForm.fundraiser.escrow_duration / (24 * 60)
                        }
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            saveSettings() {
                this.processing = true;
                let endpoint = route_with_query('save-organization-settings').absolute_path
                this.settingForm.donation.tip_percentage = 5
                this.$axios
                    .put(endpoint, this.settingForm)
                    .then(response => {
                        this.$success(null, response.message || this.$t('success'));
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {
                        this.processing = false;
                    })
            },
            async checkPlan(permission, key) {
                return await get_plan_value(permission)
                    .then(value => {
                        this[key] = value
                    })
            },

        }
    });
</script>
