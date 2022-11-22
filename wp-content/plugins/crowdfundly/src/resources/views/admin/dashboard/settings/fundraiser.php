<template>
    <div class="settings settings--others">

        <settings-page-header :title="$t('Setting_fundraiser')"></settings-page-header>

        <div class="settings__inner">

            <!--tab start-->
            <div class="settings__tab">
                <settings-tab/>
            </div>
            <!--tab end-->

            <div class="settings__body">
                <div v-if="loading" class="main-loader">
                    <loader></loader>
                </div>

                <div v-else class="settings__body-inner">
                    <form action="" @submit.prevent="saveSettings">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="auto_approval">{{$t('auto_approval')}}</label>
                                    <switcher id="auto_approval" :active="settingForm.fundraiser.auto_approval"
                                              v-model.trim="settingForm.fundraiser.auto_approval" type="primary"/>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="update_auto_approval">{{$t('update')}}  {{$t('auto_approval')}}</label>
                                    <switcher id="update_auto_approval"
                                              :active="settingForm.fundraiser.update_auto_approval"
                                              v-model.trim="settingForm.fundraiser.update_auto_approval"
                                              type="primary"/>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="allow_refund"> {{$t('allow_Refund')}}</label>
                                    <switcher id="allow_refund" :active="settingForm.fundraiser.allow_refund"
                                              v-model.trim="settingForm.fundraiser.allow_refund" type="primary"/>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label for="escrow_duration">{{$t('escrow_duration')}}</label>
                                    <div class="form-group__subdomain">
                                        <input
                                                type="number"
                                                class="form-control"
                                                id="escrow_duration"
                                                min="1"
                                                step="1"
                                                v-model="settingForm.fundraiser.escrow_duration"
                                        />
                                        <span class="form-group__subdomain-name">{{$t('days')}}</span>
                                    </div>
                                </div>
                            </div>

<!--                            <div class="col-12">-->
<!--                                <div class="form-group">-->
<!--                                    <form-error-box></form-error-box>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>

                        <loading-button class="btn-primary btn-min-50 min-150" :title="$t('save')" :disabled="processing"
                                        :loading="processing" type="submit"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Header from "~/components/settings/PageHeader";
    import SettingsTab from "~/components/organization/SettingsTab";
    import {UPDATE_ORGANIZATION} from "~/enum/OrgPermission";

    export default {
        layout: "org-dashboard",
        middleware: ["redirectIfNoOrg", "permitOrg"],
        meta: {
            permitOrg: {
                permission: UPDATE_ORGANIZATION,
            }
        },
        components: {
            "page-header": Header,
            "settings-tab": SettingsTab,
        },
        head() {
            return {title: this.$t('settings_fundraiser')}
        },
        data() {
            return {
                loading: false,
                processing: false,
                settingForm: {
                    fundraiser: {
                        auto_approval: true,
                        escrow_duration: 0,
                        update_auto_approval: false,
                        allow_refund: true,
                    }
                }
            };
        },
        async mounted() {
            await this.fetchSetting();
        },
        methods: {
            async fetchSetting() {
                this.loading = true;
                let endpoint = route_with_query('get-organization-settings', null, this.$auth.organization.id).absolute_path;
                await this.$axios
                    .get(endpoint)
                    .then(response => {
                        console.log(response)
                        if (response.fundraiser) {
                            this.settingForm.fundraiser = response.fundraiser;
                        }
                        console.log(this.settingForm.fundraiser)
                    })
                    .catch(error => {
                        this.$error(null,getMessageFromError(error))
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            saveSettings() {
                this.processing = true;
                let endpoint = route_with_query('save-organization-settings').absolute_path
                console.log(this.settingForm.fundraiser)
                this.$axios
                    .put(endpoint, this.settingForm)
                    .then(response => {
                        this.$success(null,response.message || this.$t('success'));
                    })
                    .catch(error => {
                        this.$error(null,getMessageFromError(error))
                    })
                    .finally(() => {
                        this.processing = false;
                    })
            }
        }
    };
</script>
