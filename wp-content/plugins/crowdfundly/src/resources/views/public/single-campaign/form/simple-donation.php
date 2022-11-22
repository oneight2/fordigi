<?php
use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\SingleCampaignController;
use Crowdfundly\App\Helpers\DBAccessor;

?>

<form
class="cf-donation-form-type"
data-camp-id="<?php echo esc_attr( $data['campaign']['id'] ); ?>"
data-camp-permalink="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $data['campaign']['slug'] ) ); ?>"
data-camp-currency="<?php echo esc_html( $data['campaign']['currency_code'] ); ?>"
>

    <div class="cf-form-header">
        <a class="cf-back-btn">
            <i class="fas fa-arrow-left"></i>
            <?php _e( 'Back to Campaign', 'crowdfundly' ); ?>
        </a>

        <h3 class="cf-form-camp-name">
            <?php echo esc_html( $data['campaign']['name'] ); ?>
        </h3>

        <div class="cf-org">
            <div class="cf-org-by">
                <?php echo __( 'by', 'crowdfundly' ); ?>
            </div>
            <a
            href="<?php echo esc_url( OrganizationController::get_organization_permalink() ); ?>"
            class="cf-org-name"
            >
                <?php
                $org = DBAccessor::getItem( 'organization' );
                echo esc_html( $org['name'] );
                ?>
            </a>
        </div>
    </div>

    <div class="cf-form-inner">
        <div class="form form-group amount-wrap show">
            <label for="cf-donation-amount" class="cf-donation-label cf-amount-label">
                <span>
                    <?php _e( 'Amount *', 'crowdfundly' ); ?>
                </span>
            </label>

            <?php
            if ( ! empty( $data['campaign']['options']['presets'] ) ) :
                ?>
                <div class="cf-preset show">
                    <p>
                        <?php _e( '(Please select a preset amount or custom amount, a minimum of 1 or more.)', 'crowdfundly' ); ?>
                    </p>
                    <div class="cf-preset-inner">
                        <?php
                        foreach ( $data['campaign']['options']['presets'] as $preset ) :
                            ?>
                            <button class="cf-preset-btn" data-amount="<?php echo esc_attr( $preset ); ?>" >
                                <?php echo esc_html( $preset ); ?>
                            </button>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <?php
            endif;
            ?>

            <div class="cf-input-group cf-amount-wrap">
                <input
                id="cf-donation-amount"
                type="number"
                name="amount"
                class="noscroll"
                required
                >
                <span class="cf-donation-currency">
                    <?php echo esc_html( $data['campaign']['currency_code'] ); ?>
                </span>
            </div>
            <input type="hidden" name="amount" class="cf-donation-amount" >
        </div>

        <?php
        if (
            $data['settings']
            && isset( $data['settings']['donation'] )
            && $data['settings']['donation']['wants_tip']
        ) :
            ?>
            <div class="form form-group tip-wrap show">
                <label for="cf-tip-amount" class="cf-donation-label">
                    <span>
                        <?php _e( 'Tip Amount', 'crowdfundly' ); ?>
                    </span>
                </label>
                <span class="tip-description">
                    (<?php _e( 'Your tip will help us help more people', 'crowdfundly' ); ?>)
                </span>
                <input
                id="cf-tip-amount"
                class="cf-donation-input"
                type="number"
                name="tip_amount"
                class="noscroll"
                value="0"
                >
            </div>
            <?php
        endif;
        ?>

        <div class="form form-group" id="service-preview"></div>

        <!-- <div class="form form-group">
            <label class="cf-donation-label">
                <?php //_e( 'Recurring', 'crowdfundly' ); ?>
            </label>

            <div class="form-group-inner">
                <?php
                // $recurring = $data['campaign']['options']['recurring'];
                // $checked = $recurring ? esc_attr( 'checked' ) : '';
                ?>
                <div class="cf-radio-group">
                    <input
                    id="cf-recurringon"
                    type="radio"
                    name="recurring"
                    value="true"
                    required
                    <?php //echo $recurring ? esc_attr( 'checked' ) : ''; ?>
                    >
                    <label for="cf-recurringon" class="cf-radio-label">
                        <?php //_e( 'Yes, Monthly', 'crowdfundly' ); ?>
                    </label>
                </div>
                <div class="cf-radio-group">
                    <input
                    id="cf-recurringoff"
                    type="radio"
                    name="recurring"
                    value="false"
                    required
                    <?php //echo ! $recurring ? esc_attr( 'checked' ) : ''; ?>
                    >
                    <label for="cf-recurringoff" class="cf-radio-label">
                        <?php //_e( 'No, donate once', 'crowdfundly' ); ?>
                    </label>
                </div>
            </div>
        </div> -->

        <div class="form form-group">
            <label for="cf-donation-email" class="cf-donation-label">
                <span>
                    <?php _e( 'Email *', 'crowdfundly' ); ?>
                </span>
            </label>

            <input
            id="cf-donation-email"
            class="cf-donation-input"
            type="email"
            name="email"
            required
            >
        </div>

        <div class="form form-group">
            <div class="cf-checkbox-group">
                <input type="hidden" name="is_anonymous" value="false">
                <input
                id="cf-anonymous"
                class="cf-checkbox"
                type="checkbox"
                name="is_anonymous"
                value="true"
                >
                <label for="cf-anonymous" class="cf-checkbox-label">
                    <?php _e( 'Give Anonymously', 'crowdfundly' ); ?>
                </label>
            </div>
        </div>

        <?php
        if ( ! empty( $data['campaign']['rewards'] ) ) :
            ?>
            <div class="form form-group shipping">
                <label class="cf-donation-label" for="shipping_location">
                        <?php _e( 'Shipping Location *', 'crowdfundly' ); ?>
                </label>

                <select required name="shipping_location" id="shipping_location">
                    <option value="" default>
                        <?php _e( 'Select Location', 'crowdfundly' ); ?>
                    </option>
                </select>
            </div>

            <div class="form form-group shipping">
                <label class="cf-donation-label">
                    <span>
                        <?php _e( 'Shipping Info *', 'crowdfundly' ); ?>
                    </span>
                </label>

                <input
                id="cf-donation-address"
                class="cf-donation-input"
                type="text"
                name="shipping_address_line"
                placeholder="<?php _e( 'Address*', 'crowdfundly' ); ?>"
                required
                >

                <div class="form-group-inner">
                    <input
                    id="cf-donation-state"
                    class="cf-donation-input"
                    type="text"
                    name="shipping_state"
                    placeholder="<?php _e( 'State*', 'crowdfundly' ); ?>"
                    required
                    >
                    <input
                    id="cf-donation-zip"
                    class="cf-donation-input"
                    type="text"
                    name="shipping_zip"
                    placeholder="<?php _e( 'Zip*', 'crowdfundly' ); ?>"
                    required
                    >

                    <input
                    id="cf-donation-city"
                    class="cf-donation-input"
                    type="text"
                    name="shipping_city"
                    placeholder="<?php _e( 'City*', 'crowdfundly' ); ?>"
                    required
                    >

                    <div class="cf-country-wrap">
                        <input
                        id="cf-donation-country"
                        class="cf-donation-input"
                        type="text"
                        name="shipping_country"
                        placeholder="<?php _e( 'Country*', 'crowdfundly' ); ?>"
                        readonly
                        required
                        >
                        <select name="shipping_country_select" id="cf-country-options">
                            <option value=""><?php _e( 'Select a Country*', 'crowdfundly' ); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <?php
        endif;
        ?>

        <?php
        if ( ! empty( $data['campaign']['options']['dynamic_form'] ) && 
            ! empty( $data['campaign']['options']['dynamic_form']['fields'] )
        ) :
            $aditional_info = $data['campaign']['options']['dynamic_form'];
            ?>
            <div class="form form-group my-4">
                <h4 class="cf-aditional-info">
                    <?php echo esc_html( $aditional_info['title'] ); ?>
                </h4>

                <?php
                if ( ! empty( $aditional_info['fields'] ) ) :
                    foreach ( $aditional_info['fields'] as $field ) :
                        $field_name = implode( '_', explode( ' ', $field['label'] ) );
                        $name = strtolower( $field_name );
                        $is_required = $field['is_required'] ? 'required' : '';
                        ?>
                        <div class="form form-group">
                            <label for="<?php echo esc_attr( $name ); ?>" class="cf-donation-label">
                                <?php
                                echo esc_html( $field['label'] );
                                echo $is_required ? ' *' : '';
                                ?>
                            </label>
                            <input
                            id="<?php echo esc_attr( $name ); ?>"
                            class="cf-donation-input"
                            type="<?php echo esc_attr( $field['type'] ); ?>"
                            name="<?php echo esc_attr( $name ); ?>"
                            placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
                            <?php echo esc_attr( $is_required ); ?>
                            >
                        </div>
                        <?php
                    endforeach;
                // endif;

                // if ( isset( $aditional_info['consent'] ) && ! empty( $aditional_info['consent'] ) ) :
                    ?>
                    <div class="form form-group">
                        <div class="cf-checkbox-group">
                            <input type="hidden" name="consent" value="<?php echo esc_attr( $aditional_info['consent']['enable'] ); ?>">
                            <input
                            id="cf-consent"
                            class="cf-checkbox"
                            type="checkbox"
                            name="consent"
                            value="<?php echo esc_attr( $aditional_info['consent']['enable'] ); ?>"
                            required
                            >
                            <label for="cf-consent" class="cf-checkbox-label">
                                <?php echo esc_html( $aditional_info['consent']['text'] . " *" ); ?>
                            </label>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            <?php
        endif;
        ?>

        <div class="form form-group">
            <label class="cf-donation-label">
                    <?php _e( 'Choose A Payment Option', 'crowdfundly' ); ?>
            </label>
            <div class="form-group-inner">
                <input type="hidden" id="cf-payment-type" name="gateway">
                <?php
                $gateways = $data['gateways'];
                if ( ! empty( $gateways ) ) :
                    if(  $data['campaign']['currency_code'] !== 'INR' ) :
                        $remove_payment = array('razorpay');
                        $result = array_diff($gateways, $remove_payment);
                    foreach ( $result as $gateway ) :
                        $gateway_name = esc_attr( $gateway );
                        // var_dump($gateway);
                        ?>
                        <button
                        id="cf-payment-<?php echo $gateway_name; ?>"
                        class="cf-payment-btn"
                        type="button"
                        data-payment-type="<?php echo $gateway_name; ?>"
                        >
                            <img
                            src="<?php echo esc_url( cf_asset( 'images/admin/icons/payment/svg/' . esc_html( $gateway ) . '.svg' ) ); ?>"
                            alt="<?php echo $gateway_name; ?>"
                            >
                        </button>
                        <?php
                    endforeach;
                else:
                    // $remove_payment = array('stripe','paypal');
                    // $result = array_diff($gateways, $remove_payment);
                    // var_dump($data['campaign']['currency_code']);
                    foreach ( $gateways as $gateway ) :
                        $gateway_name = esc_attr( $gateway );
                        // var_dump($gateway);
                        ?>
                        <button
                        id="cf-payment-<?php echo $gateway_name; ?>"
                        class="cf-payment-btn"
                        type="button"
                        data-payment-type="<?php echo $gateway_name; ?>"
                        >
                            <img
                            src="<?php echo esc_url( cf_asset( 'images/admin/icons/payment/svg/' . esc_html( $gateway ) . '.svg' ) ); ?>"
                            alt="<?php echo $gateway_name; ?>"
                            >
                        </button>
                        <?php
                    endforeach;
                endif; 
                endif;
                ?>
            </div>
        </div>

        <div class="form form-group" id="stripe-card"></div>

        <div class="form form-group">
            <button
            id="cf-donation-submit"
            class="cf-donation-submit"
            type="submit"
            disabled="disabled"
            >
                <?php _e( 'Contribute Now', 'crowdfundly' ); ?>
            </button>
        </div>

    </div>

</form>
