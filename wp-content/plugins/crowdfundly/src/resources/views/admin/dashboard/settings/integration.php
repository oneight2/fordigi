<?php
use Crowdfundly\App\Controllers\IntegrationController;
use Crowdfundly\App\Controllers\IntegrationSchemaController;

$integration_status = IntegrationController::status();
// dump($integration_status);
$is_checked = ! $integration_status ? 'false' : 'true';
// dump($is_checked);
// $crowdfundly_settings = get_option( 'crowdfundly_settings', false );
// dump($crowdfundly_settings);
?>

<div id="settings-integration" class="main-wrapper">
    <layout-dashboard>
        <layout-settings sub-title="<?php echo esc_attr__( 'Integration', 'crowdfundly' ); ?>">
            <div class="settings__integration">

                <div class="integration-header">
                    <div class="integration-switcher-wrap">
                        <c-switcher
                        @input="integrationInitiat"
                        group-class="integration-switcher"
                        :checked="<?php echo esc_attr( $is_checked ); ?>">
                        </c-switcher>
                    </div>

                    <p class="integration-description">
                        <?php _e( 'Integrations enable your business to use various platforms, software, and systems according to its specific needs.', 'crowdfundly' ); ?>
                    </p>
                </div>

                <?php
                $classname = ! $integration_status ? ' not-active' : '';
                ?>
                <div class="intigration-list<?php echo esc_attr( $classname ); ?>">
                    <div v-if="processing" class="main-loader">
                        <c-loader variant="primary vh25"></c-loader>
                    </div>

                    <?php
                    $integrations = IntegrationSchemaController::get_schema();
                    foreach ( $integrations as $integration ) :
                        $module_status = IntegrationSchemaController::module_status( $integration );
                        ?>
                        <div class="card-wrap" v-if="!processing">
                            <c-card
                            @click="cardClick('<?php echo esc_attr( $integration['codeName'] ); ?>')"
                            label="<?php echo esc_attr( $module_status['message'] ); ?>"
                            title="<?php echo esc_html( $integration['description'] ); ?>"
                            sub-title="<?php echo esc_html( $integration['name'] ); ?>"
                            image-url="<?php echo cf_asset( $integration['iconPath'] ); ?>"
                            variant="white"
                            layout="column"
                            >
                            </c-card>

                            <?php
                            if ( $integration_status && $module_status['status'] ) :
                                ?>
                                <vue-advance-dialog id="<?php echo esc_attr( $integration['codeName'] ); ?>" toggleTitle="Show Dialog">
                                    <div class="intregration-handler">

                                        <div class="handler-events">
                                            <div class="event-label">
                                                <img
                                                src="<?php echo cf_asset( $integration['iconPath'] ); ?>"
                                                alt="<?php echo esc_attr( $integration['codeName'] ); ?>"
                                                >
                                                <span><?php echo esc_html( $integration['name'] ); ?></span>
                                            </div>

                                            <div class="event-options">
                                                <div class="brand-events">
                                                    <?php
                                                    $events = IntegrationController::get_handlers( $integration['codeName'] );
                                                    if ( $events ) :
                                                        foreach ( $events as $key => $event ) :
                                                            $id = array_key_first( $event );
                                                            ?>
                                                            <div class="c-checkbox c-checkbox--primary">
                                                                <input
                                                                class="c-checkbox__input"
                                                                v-model="<?php echo esc_attr( $id ); ?>"
                                                                type="checkbox"
                                                                id="<?php echo esc_attr( $id ); ?>"
                                                                />
                                                                <label class="c-checkbox__label" for="<?php echo esc_attr( $id ); ?>">
                                                                    <?php echo esc_html( $event['label'] ); ?>
                                                                </label>
                                                            </div>

                                                            <?php
                                                            if ( isset( $event['fcrm_contact'] ) ) {
                                                                cf_loadViewTemplate(
                                                                    'admin/dashboard/settings/integration-components/fcrm.php'
                                                                );
                                                            }
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="submit-handler">
                                            <c-button
                                                variant="primary"
                                                class="submit-handler__btn"
                                                title="<?php echo esc_attr__( 'Save', 'crowdfundly' ); ?>"
                                                @onpress="updateIntegrationHandlers"
                                                :loading="processing"
                                                :disabled="processing">
                                            </c-button>
                                        </div>
                                    </div>
                                </vue-advance-dialog>
                                <?php
                            endif;
                            ?>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>

            </div>
        </layout-settings>
    </layout-dashboard>
</div>

<script>
    let app = new Vue({
        el: '#settings-integration',
        data() {
            return {
                brandWP: true,
                brandFluentCrm: false,
                wpBtnClass: 'brand-btn active',
                fcrmBtnClass: 'brand-btn',
                wp_user: false,
                fcrm_contact: false,
                // crm_tag: false,
                handlerList: {
                    'wp_user': 'wp_user',
                    'fcrm_contact': 'fcrm_contact',
                },
                processing: false,
                disableBtnLoading: false,
                enableBtnLoading: false,
                webhookName: '',
                tableColumns: [
                    {
                        text: 'URL',
                    },
                    {
                        text: 'Action',
                    },
                ],
                tagSelectedVal: [],
                tagOptions: [],
                listOptions: [],
                listSelectedVal: [],
                selectedTags: [],
                selectedLists: [],
            }
        },
        created() {
            this.processing = true;
            const quries = "?action=cf_handlers_list&security=" + crowdfundlyAuth.nonce;
            this.$axios.post(crowdfundlyAuth.ajax_url + quries)
                .then(async res => {
                    const handleKeys = Object.keys(res.data)
                    handleKeys.map(key => {
                        if (this.handlerList[key]) {
                            this[this.handlerList[key]] = res.data[key]
                        }
                    })
                })
                .catch(error => {
                    console.log('err::', error);
                })
                .finally(() => {
                    setTimeout(() => {
                        this.processing = false;
                    }, 500);
                });
        },
        methods: {
            integrationInitiat(val) {
                if (val) {
                    this.enableIntegrationRequest()
                } else {
                    this.disableIntegrationRequest()
                }
		    },
            enableIntegrationRequest() {
                this.processing = true;

                const quries = "?action=cf_enable_integration&security=" + crowdfundlyAuth.nonce;
                this.$axios.post( crowdfundlyAuth.ajax_url + quries)
                    .then(async res => {
                        this.$redirect('settings-integration')
                    })
                    .catch(error => {
                        this.processing = false
                        console.log('err::', error);
                    });
            },
            disableIntegrationRequest() {
                this.processing = true;
			    
                const quries = "?action=cf_disable_integration&security=" + crowdfundlyAuth.nonce;
                this.$axios.post( crowdfundlyAuth.ajax_url + quries)
                    .then(async res => {
                        this.$redirect('settings-integration')
                    })
                    .catch(error => {
                        this.processing = false
                        console.log('err::', error);
                    });
		    },
            updateIntegrationHandlers() {
                this.processing = true
                const quries = "?action=cf_update_handlers&security=" + crowdfundlyAuth.nonce;
                const data = {}
                const handlerListKeys = Object.keys(this.handlerList)
                for (const key of handlerListKeys) {
                    if (key == 'fcrm_contact' && this.fcrm_contact) {
                        data[key] = {'list': this.listSelectedVal, 'tag': this.tagSelectedVal}
                    } else {
                        data[key] = this[key]
                    }
                }

                this.$axios.post(crowdfundlyAuth.ajax_url + quries, data)
                    .then(async res => {
                        // console.log('integration res', res)
                        this.$redirect('settings-integration')
                    })
                    .catch(error => {
                        this.processing = false
                        console.log('err::', error);
                    });
            },
            selectBrand(brandName) {
                if ( brandName == 'wp' ) {
                    this.brandFluentCrm = false;
                    this.brandWP = true;
                    this.wpBtnClass = 'brand-btn active';
                    this.fcrmBtnClass = 'brand-btn';
                } else {
                    this.brandWP = false;
                    this.brandFluentCrm = true;
                    this.wpBtnClass = 'brand-btn';
                    this.fcrmBtnClass = 'brand-btn active';
                }
            },
            cardClick(codeName) {
                console.log('cardClick', codeName);
                this.$eventHub.$emit('show-dialog',  codeName)
            },
            tagSelectedValues(val) {
                this.tagSelectedVal = val
                console.log('tag selected', val);
            },
            listSelectedValues(val) {
                this.listSelectedVal = val
                console.log('list selected', val);
            },
            getTags() {
                const quries = "?action=get_fcrm_data&data_type=tag&security=" + crowdfundlyAuth.nonce;
                this.$axios.post(crowdfundlyAuth.ajax_url + quries)
                    .then(async res => {
                        this.tagOptions = res?.data?.crm
                        this.tagSelectedVal = res?.data?.default
                    })
                    .catch(error => {
                        console.log('err::', error);
                    });
            },
            getLists() {
                const quries = "?action=get_fcrm_data&data_type=list&security=" + crowdfundlyAuth.nonce;
                this.$axios.post(crowdfundlyAuth.ajax_url + quries)
                    .then(async res => {
                        this.listOptions = res?.data?.crm
                        this.listSelectedVal = res?.data?.default
                        console.log('fcrm lists', res)
                    })
                    .catch(error => {
                        console.log('err::', error);
                    });
            }
        }
    });
</script>
