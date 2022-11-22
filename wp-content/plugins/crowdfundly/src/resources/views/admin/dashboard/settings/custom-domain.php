<div id="dashboard" class="main-wrapper">
    <layout-dashboard>
        <layout-settings sub-title="Custom Domain">
            <div class="settings__section settings__section--custom-domain">
                <div class="settings__section-inner" v-if="loading">
                    <c-loader variant="primary"></c-loader>
                </div>
                <div class="settings__section-inner" v-else>
                    <div class="row">
                        <div class="col-12">
                            <!-- <form action="">
                                <div class="custom__domain">
                                    <div class="custom__domain--input">
                                        <c-input-group label="Custom Domain" label-for="custom-domain">
                                            <c-input placeholder="Ex: zone.yourdomain.com" :disabled="!isCustomDomainAllowed" v-model="form.cname">
                                                <small v-if="!isCustomDomainAllowed" class="status status--sm status--primary">Upgrade</small>
                                            </c-input>
                                        </c-input-group>
                                    </div>
                                    <div class="custom__domain--info">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text">In order to use a domain / subdomain you need to make CNAME entries in the DNS settings of the domain.</p>
                                                <hr>
                                                <p>Add your <span class="text-secondary font-italic">hostname</span> is an alias of <span class="text-secondary font-italic">cname.crowdfundly.com</span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom__domain--button mt-4">
                                        <c-button title="Save" variant="primary" :disabled="processing || !isCustomDomainAllowed" :loading="processing"></c-button>
                                    </div>
                                </div>
                            </form> -->
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <form action="">
                                <div class="custom__email">
                                    <div class="custom__email--input">
                                        <c-input-group label="Custom Emil" label-for="custom-email">
                                            <c-input placeholder="EX: support@yourdomain.com" v-model="form.emailUserName">
                                                <small v-if="isValidEmail"> After your email is verified, your users will receive your organizational emails from <span class="font-italic text-secondary">support2@dev.com.bd</span> </small>
                                            </c-input>
                                        </c-input-group>
                                    </div>
                                    <div class="custom__email--buttons d-flex align-items-center justify-content-between">
                                        <c-button variant="primary" title="Save" type="button" :disabled=" processingEmail || !isCustomEmailAllowed" :loading="processingEmail" @onpress="saveEmail"></c-button>
                                        <c-button variant="warning" title="Varify" type="button" :disabled=" processingEmail || !isCustomEmailAllowed || varifying || !isValidEmail"></c-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-5" v-show="dnsRecords.length>0">
                        <div class="col-12">
                            <div class="datatable">
                                <div class="datatable__header">
                                    <h4 class="settings__section-title mb-0">DNS Records</h4>
                                </div>
                                <div class="datatable__inner">
                                    <table is="c-data-table" :headers="dnsRecordsTableHeaders">
                                        <tr v-for="(record,idx) in dnsRecords" :key="idx">
                                            <td class="text-nowrap">{{record.type.toUpperCase()}}</td>
                                            <td class="text-nowrap">{{record.name}}</td>
                                            <td class="text-nowrap">{{record.content}}</td>
                                            <td class="text-nowrap">
                                                <small v-if="record.status === 'ok'" class="status status--sm status--success ml-1 text-bold">OK</small>
                                                <small v-else class="status status--sm status--danger ml-1 text-bold">{{ record.status || 'missing' }}</small>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="datatable__inner__info">
                                        <div class="card bg-white border-0 full-width" style="border-radius: 10px">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <span class="text-danger">*</span> Please add these DNS records from your domain control panel.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                form: {
                    cname: null,
                    emailUserName: null
                },
                loading: false,
                processing: false,
                customToolbar: [
                    ["bold", "italic", "underline"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }],
                ],
                deleting: false,
                isCustomDomainAllowed: false,
                dnsRecords: [],
                isEmailVarified: false,
                processingEmail: false,
                isCustomEmailAllowed: false,
                varifying: false,
                dnsRecordsTableHeaders: [

                    {
                        text: 'type',
                        sortable: false
                    },
                    {
                        text: 'Name',
                        sortable: false
                    },
                    {
                        text: 'Content',
                        sortable: false
                    },
                    {
                        text: 'Status',
                        sortable: false
                    }
                ],
            };
        },
        computed: {
            isValidEmail() {
                let pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return this.form.emailUserName && pattern.test(String(this.form.emailUserName))
            }
        },
        mounted() {
            this.isCustomDomainAllowed = this.$currentOrganization.features['custom_domain']
            this.isCustomEmailAllowed = this.$currentOrganization.features['custom_email']
        },
        async mounted() {
            console.log('')
        },
        created() {
            this.fetchSetting();
            this.fetchDnsRecords();
        },
        methods: {
            async fetchSetting() {
                this.loading = true;
                let orgId = this.$auth.organization.id;
                this.$axios.$get(`/organization/${orgId}/setting`)
                    .then(res => {
                        if (res) {
                            this.form.cname = res.cname;
                            this.form.emailUserName = res.email_username;
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            fetchDnsRecords() {
                let orgId = this.$auth.organization.id;
                this.$axios.$get(`/organization/${orgId}/dns`)
                    .then(res => {
                        this.dnsRecords = res.records || [];
                        this.isEmailVarified = res.varified || false
                    })
            },

            saveEmail() {
                if (this.form.emailUserName && !this.isValidEmail) return this.$cfNotify('error', '', 'Invalid Email')
                this.processingEmail = true;
                this.saveSettings().finally(() => {
                    this.processingEmail = false;
                    this.fetchDnsRecords()
                })
            },

            saveSettings() {
                return this.$axios.$put(`/organizations/cname`, this.form)
                    .then(res => {
                        this.$cfNotify('success', '', res.message || 'success')
                    })
            }

        }
    });
</script>