<template>
    <div>
        <div class="settings settings--payment-history" v-if="canBrowse">
            <settings-page-header :title="$t('settings')+' / '+$t('payment_history')"/>

            <div class="settings__inner">

                <!--tab start-->
                <div class="settings__tab">
                    <settings-tab/>
                </div>
                <!--tab end-->

                <div class="settings__body bg-transparent p-0" v-if="currentPlan">
                    <div class="settings__section">
                        <div class="settings__section-header">
                            <h4 class="settings__section-title" v-text="$t('your_plan')"></h4>
                            <loading-button class="btn btn-primary" :title="$t('renew_subscription')"
                                            v-if="renewSubscription"
                                            :disabled="unsubscribing" :loading="unsubscribing"
                                            @on-press="showPaymentModal(currentPlan.plan_id)"/>
                            <loading-button class="btn-outline-danger" :title="$t('cancel_subscription')"
                                            v-else
                                            :disabled="unsubscribing || currentPlan.cancel_at_period_end"
                                            :loading="unsubscribing" @on-press="unsubscribe"/>

                        </div>

                        <div class="settings__section-inner">
                            <loader v-if="fetchingPlan" type="dotted"></loader>

                            <div v-else class="payment-info payment-info--plan">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="payment-info__value mb-2">
                                            <n-link to="" v-text="currentPlan.plan_name"
                                                    class="payment-info__value-link"/>
                                            {{ $t('for') }} <strong
                                            v-text="'$' + Number(currentPlan.base_price / 100).toFixed(2)"/>/ {{
                                                planIntervalText
                                            }} +
                                            ( <a href="https://crowdfundly.io/comparison"
                                                 v-text="$t('view_pay_per_use_policy')" target="_blank"></a> )
                                        </h5>
                                    </div>
                                    <div class="col-4" v-if="!renewSubscription">
                                        <h5 class="payment-info__label mb-0" v-text="$t('your_next_billing_date')"></h5>
                                        <h5 class="text-danger">{{ renewDate }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings__section">
                        <div class="settings__section-header">
                            <h4 class="settings__section-title" v-text="$t('payment_history')"></h4>
                        </div>
                        <div class="settings__section-inner">
                            <div class="datatable m-0">
                                <div class="datatable__inner">
                                    <section-placeholder
                                        v-if="!payments.length && !loading"
                                        :description="$t('you_havent_made_any_payment_yet')"
                                        icon="fas fa-file-invoice-dollar"
                                        class="white m-0">
                                    </section-placeholder>
                                    <table v-if="!loading && payments.length">
                                        <thead>
                                        <tr>
                                            <th v-text="$t('date')"></th>
                                            <th v-text="$t('billing_reason')"></th>
                                            <th v-text="$t('amount')"></th>
                                            <th v-text="$t('view_invoice')"></th>
                                            <th v-text="$t('status')"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(payment, i) in payments" :key="i">
                                            <td v-text="payment.created_at" class="text-nowrap"></td>
                                            <td v-text="payment.message" class="text-nowrap"></td>
                                            <td v-text="'$' + Number(payment.amount).toFixed(2)"
                                                class="text-nowrap text-success"></td>
                                            <td class="text-nowrap">
                                                <a :href="payment.invoice_url" target="_blank"> View Invoice</a>
                                            </td>
                                            <td v-text="payment.status" class="text-nowrap"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <g-modal id="confirmModal" @after-hide="resetModal" size="xs" position="center-center"
                         :close-button="true">
                    <transition name="fade">
                        <div class="error-modal">
                            <div class="error-modal__header">
                                <h4 class="error-modal__title" v-text="$t('renew_subscription')"></h4>
                            </div>
                            <div class="form-group">
                                <label for="coupon">{{ $t('have_a_coupon') }}</label>
                                <input v-model="couponCode"
                                       maxlength="200"
                                       :placeholder="$t('apply_your_coupon_code_to_get_an_discount')"
                                       type="text" class="form-control" id="coupon">
                            </div>
                            <div class="error-modal__inner">
                                <loading-button class="btn btn-primary error-modal__btn"
                                                :title="$t('yes_confirm')" :disabled="processing"
                                                :loading="processing"
                                                type="button" @on-press="redirectToPaymentPage"/>
                            </div>
                        </div>
                    </transition>
                </g-modal>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "~/components/settings/PageHeader";
import SettingsTab from "~/components/organization/SettingsTab";
import {UPDATE_ORGANIZATION} from "~/enum/OrgPermission";
import * as dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'
import {mapGetters} from "vuex";

let stripe = null
let elements = null
let card = null

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
        return {title: this.$t('settings') + ' - ' + this.$t('payment_history')}
    },
    data() {
        return {
            currentPlan: null,
            loading: false,
            processing: false,
            payments: [],
            fetchingHistory: false,
            fetchingPlan: false,
            unsubscribing: false,
            renewSubscription: false,
            couponCode: null,
            selectedPlanId: null
        }
    },
    async created() {
        if (!this.canBrowse) {
            await this.$router.push('/dashboard/settings')
        }
        if (!this.$isOrgOwner()) {
            await this.$router.push({
                name: 'dashboard'
            })
        }
    },
    mounted() {
        Promise.all([
            this.fetchCurrentSubscriptionDetails(),
            this.fetchPayments(),
        ])
    },
    computed: {
        planIntervalText() {
            if (this.$auth.organization.subscription_type == 1) {
                return this.$t('month')
            } else {
                return this.$t('lifetime')
            }
        },
        renewDate() {
            if (this.$auth.organization.subscription_type == 1) {
                return this.currentPlan.subscription_ends_at
            } else {
                return this.$t('never')
            }
        },
        canBrowse() {
            return this.$auth.organization.plan_permission.package_type == 1;
        }
    },
    methods: {
        fetchPayments() {
            const endpoint = route_with_query('auth-payment-history', {organization_id: this.$auth.organization.id});
            this.fetchingHistory = true;
            this.$axios[endpoint.method](endpoint.absolute_path)
                .then(res => {
                        if (res.data.length > 0) {
                            this.payments = res.data
                        }
                    }
                )
                .finally(() => {
                    this.fetchingHistory = false

                })
        },

        fetchCurrentSubscriptionDetails() {
            const endpoint = route_with_query('fetch-org-subscriptions-data', {}, this.$auth.organization.id)
            this.fetchingCurrentSubscription = true
            this.fetchingPlan = true
            this.$axios[endpoint.method](endpoint.absolute_path)
                .then(res => {
                        this.currentPlan = res.data.plan_details
                        if (this.currentPlan) {
                            const date1 = dayjs(this.currentPlan.subscription_ends_on)
                            dayjs.extend(utc)
                            if (date1.diff(dayjs.utc().format(), 'second') < 0) {
                                this.renewSubscription = true
                            }
                        }
                    }
                )
                .finally(() => {
                    this.fetchingCurrentSubscription = false
                    this.fetchingPlan = false
                })
        },

        async unsubscribe() {
            if (!await this.$confirm(null, this.$t('you_want_to_cancel_the_subscription'))) return;
            this.unsubscribing = true
            let data = {
                organization_id: this.$auth.organization.id
            }
            const endpoint = route('unsubscribe-user')
            this.$axios[endpoint.method](endpoint.absolute_path, data)
                .then(async res => {
                    await this.$auth.fetchUser();
                    await this.$store.dispatch('sync_organization');
                    this.$success(null, res.data.message)
                })
                .catch(err => {
                    this.$error(null, getMessageFromError(err))
                })
                .finally(() => {
                    setTimeout(() => {
                        this.processingId = null
                        this.unsubscribing = false
                        this.$router.push({
                            name: 'user-username-story',
                            params: {username: this.$auth.user.username}
                        })
                    }, 2000)

                })
        },

        redirectToPaymentPage() {
            let data = {}
            data.plan_id = this.selectedPlanId
            data.interval = this.currentPlan.plan_interval;
            if (this.couponCode) {
                data.coupon_code = this.couponCode
            }

            this.processing = true

            const dest = route('update-subscription')

            this.$axios[dest.method](dest.absolute_path, data)
                .then(async res => {
                    await this.$store.dispatch('set_free_subscription_selection_data', res.data.redirect_to_stripe)
                    if (res.data.redirect_to_stripe == true) {
                        this.$success(null, this.$t('redirecting_to_stripe_checkout'))
                        const {error} = await stripe.redirectToCheckout({
                            sessionId: res.data.session_id
                        })

                        if (error.message) {
                            this.$error(null, error.message)
                        }
                    } else {
                        if (res.data.uuid) {
                            await this.$router.push({
                                name: 'subscribe-success',
                                query: {
                                    session_id: res.data.uuid
                                }
                            })
                        }
                        setTimeout(() => {
                            this.$success(null, this.$t('congratulation_your_plan_has_been_updated'))
                        }, 1000)

                        await this.$router.push({
                            name: 'subscribe-success',
                        })

                    }

                })
                .catch(e => {
                    console.error('error', e)
                    alert(e.response.data.message || this.$t('sorry_something_went_wrong'))
                })
                .finally(() => {
                    this.processing = false
                    this.couponCode = null
                    this.closeModal('confirmModal')
                })
        },

        showPaymentModal(planID) {
            if (this.userIsAppsumoSubscriber) {
                return this.redirectToAppsumoSubscription();
            }
            this.selectedPlanId = planID
            this.$showModal('confirmModal')
        },

        closeModal(id) {
            this.$hideModal(id)
        },
        resetModal() {
            return this.couponCode = null
        }
    }
};
</script>
