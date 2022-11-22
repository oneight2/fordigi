<?php

use Crowdfundly\App\Controllers\TeamController;

?>

<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <div class="dashboard-campaigns">
            <page-header title="<?php _e( 'Campaigns', 'crowdfundly' ); ?>">
                <?php
                if (TeamController::has_cap('crowdfundly_create_campaign')) :
                    ?>
                    <c-button
                    title="<?php _e( 'Add New Campaign', 'crowdfundly' ); ?>"
                    @onpress="$redirect('new-campaign')"
                    variant="primary text-nowrap">
                    </c-button>
                    <?php
                endif;
                ?>
            </page-header>

            <table is="c-data-table"
                   id="campaign-list"
                   v-model:limit="limit"
                   :headers="headers"
                   :data="campaigns"
                   :pagination="blueprint"
                   @pagination-change-page="fetchAllCampaigns"
                   @update-limit="updatelimit"
                   :loading="loading">

                <template slot="placeholder">
                    <c-section-placeholder></c-section-placeholder>
                </template>

                <template slot="header">
                    <form @submit.prevent="applyFilter">
                        <div class="d-flex flex-wrap align-items-center">
                            <c-filter-search v-model="filter.search"></c-filter-search>
                            <c-filter-select placeholder="Sort By" :options="sorts" label="label" value-key="value"
                                             v-model="filter.sort_by"></c-filter-select>
                            <c-filter-select placeholder="Filter By" :options="filters" label="label" value-key="value"
                                             v-model="filter.status"></c-filter-select>
                            <c-filter-date-range format="YYYY-MM-DD" formatted="YYYY-MM-DD"
                                                 v-model="filter.date"></c-filter-date-range>

                            <c-button
                            class="c-filter-item"
                            variant="success"
                            title="Apply"
                            :loading="filtering"
                            type="submit"
                            transparent
                            :disabled="!campaigns.length || filtering"></c-button>

                            <c-button
                            class="c-filter-item"
                            variant="danger"
                            title="Reset"
                            :loading="filtering"
                            type="reset"
                            transparent
                            @onpress="resetFilter"
                            :disabled="filtering"></c-button>
                        </div>
                    </form>
                </template>

                <tr v-for="(campaign, i) in campaigns" :key="i">
                    <td class="text-nowrap" v-text="_createdAt(campaign.created_at)"></td>
                    <td class="text-nowrap" v-text="$campaignType(campaign.type)"></td>
                    <td class="min-300">
                        <a :href="$campaignUrl(campaign.slug)" class="a-link" target="_blank"
                            v-text="campaign.name"></a>
                    </td>
                    <td class="text-nowrap" v-text="$getFormattedCurrency(campaign.organization_fee,campaign)"></td>
                    <td class="text-nowrap text-success"
                        v-text="$getFormattedCurrency(campaign.raised_amount, campaign)"></td>
                    <td class="text-nowrap text-warning" v-if="campaign.target_amount"
                        v-text="$getFormattedCurrency(campaign.target_amount, campaign)"></td>
                    <td class="text-nowrap text-warning" v-else v-text="'N/A'"></td>
                    <td class="text-nowrap" v-text="updateAt(campaign.updated_at)" v-if="false"></td>
                    <td class="text-nowrap">
                        <c-pill :label="$campaignStatus(campaign.status)"
                                :variant="$campaignStatusColor(campaign.status)"></c-pill>
                    </td>
                    <td class="text-center">
                        <c-dropdown-action :id="`dropdown_${i+1}`">
                            <?php
                            if (TeamController::has_cap('crowdfundly_manage_campaign')) :
                                ?>
                                <c-dropdown-item variant="primary"
                                                @onpress="$redirect('campaign-edit', {slug:campaign.slug})">
                                    <span class="mdi mdi-cog mr-2"></span>
                                    <?php _e('Manage', 'crowdfundly'); ?>
                                </c-dropdown-item>
                                <?php
                            endif;
                            ?>
                            <c-dropdown-item v-if="canRaisedManually(campaign)" variant="secondary"
                                             @onpress="changeRaisedStatus(campaign, true)">
                                <span class="mdi mdi-check-bold mr-2"></span>
                                <?php _e('Set as raised', 'crowdfundly'); ?>
                            </c-dropdown-item>
                            <c-dropdown-item
                            v-if="campaign.target_amount_raised"
                            variant="secondary"
                            @onpress="changeRaisedStatus(campaign, false)">
                                <span class="mdi mdi-check-bold mr-2"></span>
                                <?php _e( 'Unset as raised', 'crowdfundly' ); ?>
                            </c-dropdown-item>
                            <c-dropdown-item
                            v-if="(campaign.status != 20)"
                            variant="primary"
                            @onpress="publishCampaign(campaign)"
                            >
                                <div v-if="dropdownLoading">
                                    <c-loader size="sm" type="dotted" variant="black" />
                                </div>
                                <div v-else>
                                    <span class="mdi mdi-publish mr-2"></span>
                                    <?php _e('Publish campaign', 'crowdfundly'); ?>
                                </div>
                            </c-dropdown-item>
                            <?php
                            if (TeamController::has_cap('crowdfundly_delete_campaign')) :
                                ?>
                                <c-dropdown-item
                                variant="danger"
                                @onpress="deleteCampaign(campaign)"
                                v-if="(campaign.status != 16)"
                                >
                                    <span class="mdi mdi-delete mr-2"></span>
                                    <?php _e('Delete', 'crowdfundly'); ?>
                                </c-dropdown-item>
                                <?php
                            endif;
                            ?>
                            <c-dropdown-item
                            variant="dark"
                            @onpress="draftCampaign(campaign)"
                            :loading="dropdownLoading"
                            v-if="campaign.status != 0"
                            >
                                <div v-if="dropdownLoading">
                                    <c-loader size="sm" type="dotted" variant="black" />
                                </div>
                                <div v-else>
                                    <span class="mdi mdi-file-document-outline mr-2"></span>
                                    <?php _e('Draft', 'crowdfundly'); ?>
                                </div>
                            </c-dropdown-item>
                        </c-dropdown-action>
                    </td>
                </tr>
            </table>
        </div>
    </layout-dashboard>
</div>

<script>
    let app = new Vue({
        el: '#dashboard',
        data() {
            return {
                targetRaised: false,
                dropdownLoading: false,
                loading: false,
                filtering: false,
                campaigns: [],
                blueprint: {},
                limit: 10,
                placeholder: "/images/placeholder/placeholder-new.png",
                filter: {
                    search: null,
                    sort_by: null,
                    status: null,
                    date: {}
                },
                sorts: [
                    {
                        label: 'Newest',
                        value: 'newest'
                    },
                    {
                        label: 'Most Contributed',
                        value: 'most_contributed'
                    },
                ],
                filters: [
                    {
                        label: 'Published',
                        value: 'published'
                    },
                    {
                        label: 'Drafted',
                        value: 'drafted'
                    },
                    {
                        label: 'Deleted',
                        value: 'deleted'
                    },
                    {
                        label: 'Pending',
                        value: 'pending'
                    },
                ],
                currentPage: 1,
                headers: [
                    {text: 'Created at', sortable: true, sortKey: 'created_at'},
                    {text: 'Type', sortable: true, sortKey: 'type'},
                    {text: 'Campaign', sortable: true, sortKey: 'name'},
                    {text: 'Commission', sortable: true, sortKey: 'organization_fee'},
                    {text: 'Raised', sortable: true, sortKey: 'raised_amount'},
                    {text: 'Target', sortable: true, sortKey: 'target_amount'},
                    {text: 'Status', sortable: true, sortKey: 'status'},
                    {text: 'Actions', sortable: false}
                ],
                organization: this.$auth.organization
            };
        },
        created() {
            this.initialFetchCampaigns(this.currentPage);
        },
        methods: {
            async initialFetchCampaigns(page = 1) {
                this.loading = true;
                await this.fetchAllCampaigns(page).finally(() => {
                    this.loading = false
                })
            },
            async fetchAllCampaigns(page = 1) {
                let params = {
                    organization: this.$auth.organization.id,
                    per_page: this.limit,
                    page,
                }
                for (const filterKey in this.filter) {
                    if (!this.filter[filterKey]) {
                        continue;
                    }
                    if (filterKey === "date") {
                        params.from = this.filter[filterKey].start
                        params.till = this.filter[filterKey].end
                        continue;
                    }
                    params[filterKey] = this.filter[filterKey]
                }
                return this.$axios.$get('/campaign', {params})
                    .then(res => {
                        const {data, ...blueprint} = res;
                        this.campaigns = data;
                        this.blueprint = blueprint;
                        this.currentPage = page;
                    })
                    .catch(e => {
                        console.error(e);
                    })
            },
            /* -------------- Starts: Campaign Filter methods -------------- */
            async resetFilter() {
                this.loading = true;
                this.filter.search = null;
                this.filter.date = {};
                this.filter.sort_by = null;
                this.filter.status = null;
                await this.fetchAllCampaigns(1).finally(() => {
                    this.loading = false
                });
                this.$forceUpdate()
            },
            async applyFilter() {
                this.filtering = true
                await this.fetchAllCampaigns(1).finally(() => {
                    this.filtering = false
                });
                this.$forceUpdate();
            },
            _createdAt(dateTimeObject) {
                return this.$moment(dateTimeObject).format("MMM Do YY")
            },
            updateAt(timestamp) {
                if (!timestamp) {
                    return this.$t("n_a");
                }
                return this.$moment(timestamp).format(baseTimeStampFormat());
            },
            updatelimit(value) {
                this.limit = value
                this.fetchAllCampaigns()
            },

            redirectToEdit(id, slug) {
                // this.$router.push({
                //     name: "campaigns-slug-edit",
                //     params: {id, slug}
                // });
            },
            async changeRaisedStatus(campaign, bool) {
                const isRaisedManually = this.canRaisedManually(campaign);

                const endpoint = `/campaigns/${campaign.slug}/target-amount-raised`;
                await this.$axios.$put(endpoint, {
                    target_amount_raised: bool
                })
                    .then(res => {
                        this.fetchAllCampaigns(this.currentPage);
                        if (bool) {
                            this.$cfNotify('success', null, 'Campaign is set to target amount raised');
                        } else {
                            this.$cfNotify('success', null, 'Campaign is Unset to target amount raised');
                        }
                    })
                    .catch(e => {
                        console.error(e);
                    })
            },
            canRaisedManually(campaign) {
                // console.log(campaign);
                if (campaign.target_amount && (campaign.target_amount < campaign.raised_amount)) {
                    return false;
                }
                if (!campaign.target_amount_raised) {
                    return true;
                }
            },
            async draftCampaign(campaign) {
                this.dropdownLoading = true;
                const endpoint = '/campaigns/' + campaign.slug + '/draft';
                return this.$axios.$put(endpoint)
                    .then(res => {
                        this.fetchAllCampaigns(this.currentPage);
                        this.$cfNotify('success', null, 'Campaign is drafted');
                    })
                    .catch(e => {
                        console.error(e);
                    })
                    .finally(() => {
                        this.dropdownLoading = false;
                    })
            },
            async deleteCampaign(campaign) {
                this.$swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete "${campaign.name}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                })
                .then(async (result) => {
                    if (! result.isConfirmed) return;
                    
                    const endpoint = '/campaigns/' + campaign.slug + '/delete';
                    return this.$axios.$put(endpoint)
                        .then(res => {
                            this.fetchAllCampaigns(this.currentPage);
                            this.$cfNotify('success', null, 'Campaign is deleted');
                        })
                        .catch(e => {
                            console.error(e);
                        })
                })
                .catch(e => {
                    console.error(e);
                })
            },
            publishCampaign(campaign) {
                this.dropdownLoading = true;
                const endpoint = '/campaigns/' + campaign.slug + '/publish';
                return this.$axios.$put(endpoint)
                    .then(res => {
                        this.fetchAllCampaigns(this.currentPage);
                        this.$cfNotify('success', null, 'Campaign is published');
                    })
                    .catch(e => {
                        console.error(e.message);
                        this.$cfNotify('error', null, this.$getMessageFromError(e));
                    })
                    .finally(() => {
                        this.dropdownLoading = false;
                    })
            }
        }
    })
</script>
