<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <layout-settings>
            <div class="settings__section">
                <div class="settings__section-inner" v-if="loading">
                    <c-loader variant="primary"></c-loader>
                </div>
                <div v-else class="settings__section-inner">
                    <form @submit.prevent="save">
                        <div class="basic-info">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <c-input
                                    label="Name"
                                    v-model="organization.name"
                                    placeholder="<?php echo esc_attr__( 'Enter organization name', 'crowdfundly' ); ?>"
                                    maxlength="100"
                                    id="name"
                                    required>
                                    </c-input>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <c-input label="<?php echo esc_attr__( 'Username', 'crowdfundly' ); ?>" group-class="mb-1" input-inner-class="subdomain-input"
                                             input-class="subdomain-input__input"
                                             type="text" v-model="organization.username" required disabled>
                                        <div class="subdomain-input__domain" v-text="domain"></div>
                                    </c-input>
                                </div>

                                <div class="col-12">
                                    <c-textarea label="<?php echo esc_attr__( 'Address', 'crowdfundly' ); ?>" v-model="organization.address" rows="4"
                                                placeholder="<?php echo esc_attr__( 'Write organization address here..', 'crowdfundly' ); ?>"></c-textarea>
                                </div>

                                <div class="col-12">
                                    <c-input-group label="<?php echo esc_attr__( 'Description', 'crowdfundly' ); ?>" label-for="organization-description">
                                        <vue-editor class="w-full" id="organization-description"
                                                    v-model="organization.description"
                                                    />
                                    </c-input-group>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <c-input-group label="<?php echo esc_attr__( 'Country', 'crowdfundly' ); ?>" label-for="country" required>
                                        <c-search-select id="country"
                                                         placeholder="<?php echo esc_attr__( 'Select country', 'crowdfundly' ); ?>"
                                                         :options="countries"
                                                         :reduce="country => country.id"
                                                         label="country_name"
                                                         v-model="organization.country_id"
                                                         :required="true">
                                        </c-search-select>
                                    </c-input-group>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    <c-input-group label="<?php echo esc_attr__( 'Currency', 'crowdfundly' ); ?>" label-for="currencies" required>
                                        <c-search-select id="currencies"
                                                         placeholder="<?php echo esc_attr__( 'Select currency', 'crowdfundly' ); ?>"
                                                         :options="currencies"
                                                         :reduce="currency => currency.id"
                                                         label="full_info"
                                                         v-model="organization.currency_id"
                                                         :required="true" disabled>
                                        </c-search-select>
                                    </c-input-group>
                                </div>

                                <div class="col-12">
                                    <c-input-group label="<?php echo esc_attr__( 'Contact Number', 'crowdfundly' ); ?>" label-for="currencies">
                                        <div class="number-input w-full">
                                            <c-search-select id="number-code"
                                                             class="number-input__select"
                                                             placeholder="<?php echo esc_attr__( 'Select code', 'crowdfundly' ); ?>"
                                                             :options="countries"
                                                             :reduce="currency => currency.id"
                                                             label="full_info"
                                                             v-model="organization.contact_number_code"
                                                             >
                                            </c-search-select>
                                            <c-input group-class="number-input__input mb-0"
                                                     placeholder="<?php echo esc_attr__( 'Enter contact number here', 'crowdfundly' ); ?>"
                                                     type="text" v-model="organization.contact_number" >
                                            </c-input>
                                        </div>
                                    </c-input-group>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <c-button variant="primary mb-3 mb-sm-0 mr-0 mr-sm-3"
                                          title="<?php echo esc_attr__( 'Save', 'crowdfundly' ); ?>"
                                          :disabled="processing"
                                          :loading="processing" type="submit"></c-button>

                                <c-button variant="danger"
                                          title="<?php echo esc_attr__( 'Delete Organization', 'crowdfundly' ); ?>"
                                          disabled
                                          :loading="deletingOrganization"
                                          type="button"
                                          @onpress="openDeleteOrganizationModal"></c-button>
                            </div>
                        </div>
                    </form>
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
                organization: {
                    name: null,
                    username: null,
                    address: null,
                    description: null,
                    country_id: null,
                    contact_number: null,
                    contact_number_code: null,
                    currency_id: null,
                    template_id: 1,
                },
                loading: false,
                processing: false,
                deletingOrganization: false,
                customToolbar: [
                    ["bold", "italic", "underline"],
                    [{list: "ordered"}, {list: "bullet"}],
                ],
                deleting: false,
            };
        },
        computed: {
            domain() {
                return process.env.BASE_DOMAIN
            },
            ...this.$mapState({
                countries: state => state.countries.data,
                currencies: state => state.currencies.data,
            }),
        },
        created() {
            this.$store.dispatch('countries/fetch')
            this.$store.dispatch('currencies/fetch')
            this.initialFetch()
        },
        methods: {
            initialFetch() {
                this.loading = true
                this.fetchOrganization()
                    .finally(() => {
                        this.loading = false
                    })
            },
            fetchOrganization() {
                return this.$axios.$get('/organization')
                    .then(organization => {
                        this.organization = organization
                    })
                    .catch(error => {
                        this.$cfNotify('error', null, this.$getMessageFromError(error))
                    })
            },
            async save() {
                this.processing = true;
                this.$axios
                    .$put('/organization/basic', this.organization)
                    .then(async response => {
                        this.$cfNotify('success', null, 'Organization updated');
                        this.fetchOrganization()
                    })
                    .catch(error => {
                        this.$cfNotify('error', null, this.$getMessageFromError(error))
                    })
                    .finally(() => {
                        this.processing = false;
                    });
            },
            openDeleteOrganizationModal() {
                this.$showDialog('deleteOrganizationModal')
            },
            closeDeleteOrganizationModal() {
                this.$hideDialog('deleteOrganizationModal')
            },
            async deleteOrganization() {
                this.deletingOrganization = true;
                let endpoint = route_with_query('delete-organization').absolute_path;
                this.$axios
                    .$delete(endpoint)
                    .then(async response => {
                        this.closeDeleteOrganizationModal();
                        await this.$success(null, response.message || this.$t('organization_deleted'));
                        await this.$auth.fetchUser();
                        await this.$store.dispatch('clear_organization');
                        this.$cookies.remove('selected_organization_id')
                        this.$redirectToApp('/')
                    })
                    .catch(error => {
                        this.$error(null, getMessageFromError(error));
                    })
                    .finally(() => {
                        this.deletingOrganization = false;
                    })
            },
        }
    });
</script>
