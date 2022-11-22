<?php

use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\SingleCampaignController;
use Crowdfundly\App\Helpers\DBAccessor;

?>

<form
class="cf-donation-form-update"
data-camp-id="<?php echo esc_attr( $data['campaign']['id'] ); ?>"
data-camp-permalink="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $data['campaign']['slug'] ) ); ?>"
>
    <div class="cf-form-header">
        <a class="cf-back-btn" href="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $data['campaign']['slug'] ) ); ?>">
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
        <div class="form form-group">
            <label for="cf-donnar-name" class="cf-donation-label">
                <span>
                    <?php _e( 'Name', 'crowdfundly' ); ?>
                </span>
            </label>

            <input
            id="cf-donnar-name"
            class="cf-donation-input noscroll"
            type="text"
            name="full_name"
            >
        </div>

        <div class="form form-group">
            <label for="cf-donation-message" class="cf-donation-label">
                <span>
                    <?php _e( 'Message', 'crowdfundly' ); ?>
                </span>
            </label>

            <textarea
            class="cf-donation-textarea"
            id="cf-donation-message"
            name="message" rows="2"></textarea>
        </div>

        <div class="form form-group">
            <button
            id="cf-donation-submit"
            class="cf-donation-update"
            type="submit"
            >
                <?php _e( 'Continue', 'crowdfundly' ); ?>
            </button>
        </div>

    </div>

</form>
