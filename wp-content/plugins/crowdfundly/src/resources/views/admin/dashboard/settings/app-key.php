<template>
    <div class="settings settings--app-key">

        <settings-page-header :title="$t('settings') +' / '+ $t('app_key')">
            <loading-button
                @on-press="generateKey"
                class="btn btn-primary"
                icon="fas fa-plus"
                :title="!isSmallDevice ? $t('generate_new_app_key') : ''"
                :is-pro="false"/>
        </settings-page-header>

        <div class="settings__inner">

            <!--tab start-->
            <div class="settings__tab">
                <settings-tab/>
            </div>
            <!--tab end-->

            <div class="settings__body bg-transparent p-0 full-width">
                <div v-if="loading" class="main-loader">
                    <loader></loader>
                </div>

                <div v-else class="settings__body-inner">

                    <div class="datatable">

                        <div class="datatable__inner">
                            <div v-if="loading" class="main-loader main-loader--60vh">
                                <loader/>
                            </div>

                            <div v-else>
                                <section-placeholder
                                    v-if="!keys.length"
                                    :title="$t('sorry')"
                                    :description="$t('no_app_key_found')"
                                    icon="fas fa-network-wired"
                                    class="white height-400">
                                </section-placeholder>

                                <table v-else>
                                    <thead>
                                    <tr>
                                        <th v-text="'#'"></th>
                                        <!--                                        <th v-text="$t('label')"></th>-->
                                        <th v-text="$t('app_key')"></th>
                                        <th v-text="$t('created_at')"></th>
                                        <th class="text-center" v-text="$t('actions')"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, i) in keys" :key="i">
                                        <td class="text-nowrap" v-text="++i"></td>
                                        <!--                                        <td class="text-nowrap" v-text="item.label"></td>-->
                                        <td class="text-nowrap" v-text="item.token"></td>
                                        <td class="text-nowrap" v-text="formattedDate(item.created_at)"></td>
                                        <td class="text-center">
                                            <action>
                                                <action-item
                                                    @action="deleteKey(item.id)"
                                                    icon="fa-trash"
                                                    :title="$t('delete')"
                                                    type="danger"
                                                />
                                            </action>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="datatable__footer" v-if="false">
                            <span class="datatable__footer__info" v-if="blueprint.total > 0">
                                {{ $t('showing') }} <strong>{{
                                    campaigns.length
                                }}</strong> {{ $t('of') }} <strong>{{ blueprint.total }}</strong>
                            </span>
                            <pagination v-if="blueprint" :limit="1" :data="blueprint"
                                        @pagination-change-page="fetchAllCampaigns"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "~/components/settings/PageHeader";
import SettingsTab from "~/components/organization/SettingsTab";
import {UPDATE_ORGANIZATION} from "~/enum/OrgPermission";
import {mapGetters} from "vuex";

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
        return {title: this.$t('settings') + ' - ' + this.$t('app_key')}
    },
    data() {
        return {
            keys: [],
            loading: false,
            generating: false,
            deleting: false,
            processing: false,
            filter: {
                search: null
            },
            form: {
                label: null,
                key: null
            }
        };
    },
    async created() {
        if (!this.$isOrgOwner()) {
            await this.$router.push({
                name: 'dashboard'
            })
        }
    },
    mounted() {
        this.fetchTokens()
    },
    computed: {
        isSmallDevice() {
            let width = window.innerWidth
            return width < 576;
        },
    },
    methods: {
        formattedDate(date) {
            return this.$moment(date).format("ll");
        },
        async deleteKey(id) {
            if (!await this.$confirm()) return;
            this.deleting = true;
            let endpoint = route_with_query('org-delete-token', null, id).absolute_path;
            this.$axios
                .$delete(endpoint)
                .then(response => {
                    this.$success(null, response.message);
                    this.fetchTokens();
                })
                .catch(error => {
                    this.$error(null, getMessageFromError(error));
                })
                .finally(() => {
                    this.deleting = false;
                })
        },
        resetForm() {
            this.form.label = null
        },
        fetchTokens() {
            this.loading = true;
            let endpoint = route_with_query('org-get-all-tokens').absolute_path;
            this.$axios
                .get(endpoint)
                .then(response => {
                    this.keys = response;
                })
                .catch(error => {
                    this.$error(null, getMessageFromError(error));
                })
                .finally(() => {
                    this.loading = false;
                })
        },
        generateKey() {
            this.generating = true;
            let endpoint = route_with_query('org-generate-token').absolute_path;
            this.$axios
                .post(endpoint)
                .then(response => {
                    this.$success(null, this.$t('generated_successfully'));
                    this.fetchTokens();
                })
                .catch(error => {
                    this.$error(null, getMessageFromError(error));
                })
                .finally(() => {
                    this.generating = false;
                })
        }
    }
};
</script>
