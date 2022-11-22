<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="dashboard-roles" v-if="__org_member_can($enum.OrgPermissions.CREATE_ROLE) || __org_member_can($enum.OrgPermissions.UPDATE_ROLE)">
            <page-header :title="$t('role')">
                <loading-button
                        @on-press="openAddModal"
                        class="btn btn-primary"
                        :class="isSmallDevice ? 'fas fa-plus py-2 px-3' : ''"
                        :title="!isSmallDevice ? $t('add_new') : ''"
                        v-if="__org_member_can($enum.OrgPermissions.CREATE_ROLE) && !loading"
                        :is-pro="!isTeamMemberAllowed"></loading-button>
            </page-header>

            <div v-if="loading" class="main-loader main-loader--60vh">
                <loader></loader>
            </div>
            <div v-else class="dashboard-roles__inner">
                <section-placeholder
                        v-if="roles.length === 0"
                        :title="$t('sorry')"
                        :description="$t('no_role_found')"
                        icon="fa fa-tasks"
                        class="white height-400">
                </section-placeholder>

                <div v-else class="datatable">
                    <div class="datatable__inner">
                        <table>
                            <thead>
                            <tr>
                                <th v-text="$t('name')"></th>
                                <th class="text-center max-50" v-text="$t('actions')"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(role, i) in roles" :key="i">
                                <td class="text-nowrap">
                                    <span class="status status--primary auto-width min-100 fit-content"
                                          v-text="role.name"></span>
                                </td>
                                <td class="text-center max-50">
                                    <action>
                                        <action-item @action="openUpdateModal(i)" icon="fa-edit"
                                                     :title="$t('edit')" type="primary"
                                                     v-if="__org_member_can($enum.OrgPermissions.UPDATE_ROLE)"></action-item>
                                    </action>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--create modal-->
            <add-role-modal :permissions="permissions" @after-created="afterCreatedRole"></add-role-modal>
            <!--create modal end-->

            <!--update modal-->
            <update-role-modal :permissions="permissions" :current-role-data="roleData"
                               @after-updated="afterUpdatedRole"></update-role-modal>
            <!--update modal end-->
        </div>
    </dashboard-layout>
</div>

<script>

    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                roleData: {
                    name: null,
                    permissions: [],
                    _method: 'PUT'
                },
                permissions: [],
                roles: [],
                loading: false,
                checkAll: false,
                isTeamMemberAllowed: true,
                isSmallDevice: false
            }
        },

        async created() {
            if (!__org_member_can(this.$enum.OrgPermissions.CREATE_ROLE) && !__org_member_can(this.$enum.OrgPermissions.UPDATE_ROLE)) {
                await this.$redirect('dashboard')
            }
            if (this.organization.is_active) {
                await Promise.all([
                    this.fetchModules(),
                    this.fetchRoles(),
                    this.fetchOrgUsers()
                ])
            }
        },
        mounted() {
            let width = window.innerWidth
            this.isSmallDevice = width < 576;
        },
        computed: {
            organization(){
                return this.$auth.organization
            },
        },
        methods: {
            async fetchOrgUsers() {
                this.loading = true;
                const endpoint = route("team-users");

                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.users = res
                    })
                    .catch(error => {
                        this.$error(null, error.data.message)
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            fetchModules() {
                this.loading = true;
                const endpoint = route('team-modules')
                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        let permissions = res
                        for (let i of Object.keys(permissions)) {
                            permissions[i] = {
                                name: permissions[i],
                                isChecked: false
                            }
                        }
                        this.permissions = permissions
                    })
                    .catch(() => {
                        this.$error(null, this.$t('sorry_something_went_wrong'))
                    })
            },
            fetchRoles() {
                this.loading = true;
                const endpoint = route('team-roles')
                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.roles = res
                    })
                    .catch(() => {
                        this.$error(null, this.$t('sorry_something_went_wrong'))
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },

            openAddModal() {
                for (let i of Object.keys(this.permissions)) {
                    this.permissions[i].isChecked = false;
                }
                this.$showModal('roleAddModal')
            },
            openUpdateModal(id) {
                let selectedRole = this.roles[id]
                let modules = this.permissions
                Object.keys(modules).filter(element => selectedRole.modules.includes(element) ? modules[element].isChecked = true : modules[element].isChecked = false);
                this.roleData.id = selectedRole.id
                this.roleData.name = selectedRole.name
                this.$showModal('roleUpdateModal')
            },

            async afterCreatedRole() {
                await this.fetchRoles()
                await this.fetchModules()
                this.isBtnClicked = false
            },
            async afterUpdatedRole() {
                await this.fetchRoles()
                await this.fetchModules()
                this.isBtnClicked = false
            },
        }
    });
</script>
