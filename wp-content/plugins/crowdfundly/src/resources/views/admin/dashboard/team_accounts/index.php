<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="dashboard-users">
            <page-header :title="$t('team_accounts')">
                <loading-button
                        @on-press="openAssignRoleModal"
                        class="btn btn-primary"
                        :class="isSmallDevice ? 'fas fa-plus py-2 px-3' : ''"
                        :title="!isSmallDevice ? $t('add_new') : ''"
                        v-if="__org_member_can($enum.OrgPermissions.ASSIGN_MEMBER) && !loading"
                        :is-pro="!isTeamMemberAllowed"></loading-button>
            </page-header>


            <div v-if="loading" class="main-loader main-loader--60vh">
                <loader></loader>
            </div>

            <div v-else class="dashboard-users__inner">
                <section-placeholder
                        v-if="users.length === 0"
                        :title="$t('sorry')"
                        :description="$t('no_team_account_found')"
                        icon="fas fa-users"
                        class="white height-400">
                </section-placeholder>

                <div v-else class="datatable">
                    <div class="datatable__inner">
                        <table>
                            <thead>
                            <tr>
                                <th v-text="$t('name')"></th>
                                <th v-text="$t('email')"></th>
                                <th v-text="$t('role')"></th>
                                <th class="text-center" v-text="$t('actions')"
                                    v-if="__org_member_can($enum.OrgPermissions.UPDATE_MEMBER) || __org_member_can($enum.OrgPermissions.DELETE_MEMBER)"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, i) in users" :key="i">
                                <td v-text="user.user.name" class="text-nowrap"></td>
                                <td v-text="user.user.email" class="text-nowrap"></td>
                                <td class="text-nowrap">
                                <span v-if="user.team_role" class="status status--primary min-150"
                                      v-text="user.team_role.name"></span>
                                    <span v-else class="text-danger" v-text="$t('not_set_yet')"></span>
                                </td>
                                <td class="text-center"
                                    v-if="__org_member_can($enum.OrgPermissions.UPDATE_MEMBER) || __org_member_can($enum.OrgPermissions.DELETE_MEMBER)">
                                    <action v-if="user.team_role
                                    && user.team_role.name !== 'owner'
                                    && user.team_role.name !== 'fundraiser'">
                                        <action-item
                                                @action="openUpdateRoleModal(i)"
                                                icon="fa-user-lock"
                                                :title="$t('update_role')"
                                                type="primary"
                                                v-if="__org_member_can($enum.OrgPermissions.UPDATE_MEMBER)"
                                        ></action-item>
                                        <action-item
                                                @action="deleteUser(user.id)"
                                                icon="fa-trash"
                                                :title="$t('delete')"
                                                type="danger"
                                                v-if="__org_member_can($enum.OrgPermissions.DELETE_MEMBER)"
                                        ></action-item>
                                    </action>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <assign-role-modal :permissions="permissions" :members="users" :roles="roles"
                               @after-created="afterCreated"></assign-role-modal>

            <update-assign-role-modal :permissions="permissions" :roles="roles" :current-role="userRole"
                                      @after-updated="afterUpdated"></update-assign-role-modal>

        </div>
    </dashboard-layout>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                processing: false,
                userRole: {
                    id: null,
                    role_id: null,
                    permissions: [],
                    _method: "PUT"
                },
                users: [],
                permissions: [],
                roles: [],
                loading: false,
                isTeamMemberAllowed: true,
                isSmallDevice: false
            };
        },
        async created() {
            if (this.organization.is_active) {
                await Promise.all([
                    this.fetchOrgUsers(),
                    this.fetchModules(),
                    this.fetchRoles()
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
            }
        },
        methods: {
            async fetchOrgUsers() {
                this.loading = true;
                const endpoint = route("team-users");

                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.users = res;
                        let userWithoutFundraiser = this.users.filter(value => value.team_role.name != 'fundraiser' && value.team_role.name != 'owner')
                        this.checkPlan('team_account', [userWithoutFundraiser.length], 'isTeamMemberAllowed')
                    })
                    .catch(error => {
                        this.$error(null, error.data.message)
                    })
            },
            async fetchModules() {
                this.loading = true;
                const endpoint = route("team-modules");
                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        let permissions = res;
                        for (let i of Object.keys(permissions)) {
                            permissions[i] = {
                                name: permissions[i],
                                isChecked: false
                            };
                        }
                        this.permissions = permissions;
                    })
                    .catch(() => {
                        this.$error(null, this.$t('sorry_something_went_wrong'))
                    })
            },
            async fetchRoles() {
                this.loading = true;
                const endpoint = route("team-roles");

                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.roles = res;
                    })
                    .catch(() => {
                        this.$error(null, this.$t('sorry_something_went_wrong'))
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },

            async afterCreated() {
                await this.fetchOrgUsers();
                await this.fetchModules();
                await this.fetchRoles();
                this.isBtnClicked = false;
            },
            async afterUpdated() {
                await this.fetchOrgUsers();
                await this.fetchModules();
                await this.fetchRoles();
                this.isBtnClicked = false;
            },

            openAssignRoleModal() {
                for (let i of Object.keys(this.permissions)) {
                    this.permissions[i].isChecked = false;
                }
                this.$showModal("assignRoleModal");
            },
            openUpdateRoleModal(event) {
                let selectedUser = this.users[event];
                let modules = this.permissions;
                // console.log("my i", event, selectedUser.modules, modules, Object.keys(modules), Object.values(selectedUser.modules));
                Object.keys(modules).filter(element => Object.values(selectedUser.modules).includes(element) ? modules[element].isChecked = true : modules[element].isChecked = false);
                this.userRole.role_id = selectedUser.team_role.id
                this.userRole.id = selectedUser.id;
                this.$showModal("updateRoleModal");
            },

            closeCreateModal() {
                this.$hideModal("assignRoleModal");
            },

            async deleteUser(userId) {
                if (!await this.$confirm()) return;
                const endpoint = route("delete-team-user", userId);
                let data = {};
                data._method = "DELETE";
                this.loading = true;
                this.$axios[endpoint.method](endpoint.absolute_path, data)
                    .then(response => {
                        this.$success(null, this.$t('successfully_team_account_deleted'))
                        this.fetchOrgUsers();
                        this.fetchModules();
                        this.fetchRoles();
                    })
                    .catch(error => {
                        this.$error(null, this.$t('sorry_something_went_wrong'))
                    })
                    .finally(() => {
                        this.isBtnClicked = false;
                    });
            },
            async checkPlan(permission, params, key) {
                return await get_plan_value(permission, params)
                    .then(value => {
                        this[key] = value
                    })

            },
        }
    });
</script>