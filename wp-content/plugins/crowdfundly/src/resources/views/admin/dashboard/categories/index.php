<!-- 
Note: Menu has been removed from wp admin cf submenu. 
TODO: This file will be remeved in future -->
<div id="dashboard" class="main-wrapper">
    <dashboard-layout>
        <div class="dashboard-categories">
            <page-header :title="$t('categories')">
                <loading-button
                        @on-press="openAddModal"
                        class="btn btn-primary"
                        :class="isSmallDevice ? 'fas fa-plus py-2 px-3' : ''"
                        :title="!isSmallDevice ? $t('add_new') : ''"
                        v-if="!loading"></loading-button>
            </page-header>
            <div class="datatable__header">
                <!-- ------ Starts: Campaign Filter Section ------ -->
                <form @submit.prevent="applyFilter">
                    <g-filter>
                        <div class="d-flex flex-wrap align-center flex-1">
                            <filter-search v-model="filter.search" @button-clicked="applyFilter"></filter-search>

                            <filter-select
                                    :placeholder="$t('filter_by')"
                                    :options="{
                                    'charity': $t('donation_campaign'),
                                    'business': $t('reward_campaign')
                                }"
                                    @selected-item="filterBy"
                                    :reset-value="resetFilterBy"></filter-select>
                            <filter-button :title="$t('apply_filter')" type="submit"></filter-button>
                            <filter-button :title="$t('reset_all')" type="reset" @on-press="resetFilter"></filter-button>
                        </div>
                    </g-filter>
                </form>
                <!-- ------ Ends: Campaign Filter Section ------ -->
            </div>
            <div class="dashboard-roles">

                <div v-if="loading" class="main-loader main-loader--60vh">
                    <loader></loader>
                </div>
                <div v-else class="dashboard-roles__inner">
                    <section-placeholder
                            v-if="categories.length === 0"
                            :title="$t('sorry')"
                            :description="$t('no_category_found')"
                            icon="fa fa-tasks"
                            class="white height-400">
                    </section-placeholder>

                    <div v-else class="datatable">
                        <div class="datatable__inner">
                            <table>
                                <thead>
                                <tr>
                                    <th v-text="$t('name')"></th>
                                    <th v-text="$t('type')"></th>
                                    <th v-text="$t('icon')"></th>
                                    <th class="text-center max-50" v-text="$t('actions')"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category, i) in categories" :key="i">
                                    <td class="text-nowrap">
                                    <span class="status status--primary auto-width min-100 fit-content"
                                          v-text="category.name"></span>
                                    </td>
                                    <td class="text-nowrap">
                                    <span class="status status--primary auto-width min-100 fit-content"
                                          v-text="category.type == 1 ? 'Donation Based Campaign':'Reward Based Campaign'"></span>
                                    </td>
                                    <td class="text-nowrap">
                                        <i :class="category.icon"></i>
                                    </td>

                                    <td class="text-center max-50">
                                        <action>
                                            <action-item @action="openUpdateModal(i)" icon="fa-edit"
                                                         :title="$t('edit')" type="primary"></action-item>
                                            <action-item
                                                    @action="deleteCategory(category.id)"
                                                    icon="fa-trash"
                                                    :title="$t('delete')"
                                                    type="danger"></action-item>
                                        </action>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <add-category-modal @after-created="afterCreatedCategory"></add-category-modal>
                <update-category-modal :current-category-data="categoryData"
                                       @after-updated="afterUpdatedCategory"></update-category-modal>
            </div>
        </div>
    </dashboard-layout>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                categoryData: {
                    name: null,
                    icon: null,
                    type: null,
                    _method: 'PUT'
                },
                filter: {
                    search: null,
                    filter_by: null
                },
                resetFilterBy: false,
                categories: [],
                loading: false,
                isTeamMemberAllowed: true,
                isSmallDevice: false
            }
        },

        async created() {

        },
        mounted() {
            this.fetchCategories()
        },
        computed: {
            organization() {
                return this.$auth.organization
            }
        },
        methods: {
            fetchCategories() {
                this.loading = true;
                let query = {
                    orgId: this.organization.id
                }

                if (this.filter.search) {
                    query.search = this.filter.search
                }

                if (this.filter.filter_by) {
                    query.type = this.filter.filter_by
                }

                let endpoint = route_with_query('org-categories',query);
                this.$axios[endpoint.method](endpoint.absolute_path)
                    .then(res => {
                        this.categories = res.data
                    })
                    .catch(() => {
                        this.$error(null, this.$t('sorry_something_went_wrong'))
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            applyFilter() {
                this.fetchCategories();
            },
            filterBy(value) {
                this.filter.filter_by = value;
            },
            resetFilter() {
                this.filter.search = null;
                this.filter.filter_by = null;
                this.resetFilterBy = true;
                const _this = this;
                setTimeout(() => {
                    _this.resetFilterBy = false;
                }, 500);
                this.fetchCategories();
            },
            async afterCreatedCategory() {
                await this.fetchCategories()
            },
            async afterUpdatedCategory() {
                await this.fetchCategories()
            },
            async deleteCategory(id) {
                if (!await this.$confirm()) return
                const endpoint = route("delete-org-category", id);
                let data = {};
                data._method = "DELETE";
                this.$axios[endpoint.method](endpoint.absolute_path, data)
                    .then(response => {
                        this.$success(null, this.$t('successfully_category_deleted'))
                        this.fetchCategories();
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error))
                    })
                    .finally(() => {

                    });
            },
            openUpdateModal(id) {
                let selectedCategory = this.categories[id]
                this.categoryData.id = selectedCategory.id
                this.categoryData.icon = selectedCategory.icon
                this.categoryData.name = selectedCategory.name
                this.categoryData.type = selectedCategory.type
                this.$showModal('categoryUpdateModal')
            },
            openAddModal() {
                this.$showModal('categoryAddModal')
            },
        }
    })
</script>