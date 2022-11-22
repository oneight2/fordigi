<?php
use Crowdfundly\App\Controllers\AllCampaignController;

$elementor_widget_data = apply_filters( 'crowdfundly_all_camps', '' );
?>

<div class="all-campaign__header">
    <h1 class="all-campaign__title">
        <?php
        $crowdfundly_search_bar_heading = get_theme_mod( 'cf_all_camp_title', __( 'Campaigns', 'crowdfundly' ) );

        if ( ! empty( $elementor_widget_data['search_bar_heading_text'] ) ) {
            $crowdfundly_search_bar_heading = $elementor_widget_data['search_bar_heading_text'];
        }
        if ( empty( $crowdfundly_search_bar_heading ) ) {
            $crowdfundly_search_bar_heading = __( 'Campaigns', 'crowdfundly' );
        }

        if ( isset( $_GET['search'] ) || isset( $_GET['type'] ) ) {
            printf(
                '<a href="%s">%s</a>',
                AllCampaignController::get_all_campaigns_permalink(),
                esc_html( $crowdfundly_search_bar_heading )
            );
        } else {
            echo esc_html( $crowdfundly_search_bar_heading );
        }
        ?>
    </h1>
    <div class="all-campaign__filter">
        <div class="all-campaign__filter-search">
            <i class="all-campaign__filter-search-icon fas fa-search"></i>
            <input
            type="text"
            id="allCampaignSearchBox"
            placeholder="<?php echo esc_attr( 'Search here...', 'crowdfundly' ); ?>"
            class="all-campaign__filter-search-input"
            data-page-url="<?php echo esc_url( AllCampaignController::get_all_campaigns_permalink() ); ?>"
            >
            <button type="button" class="all-campaign__filter-search-btn-clear">
                <img src="<?php echo esc_url( cf_asset('images/public/gray.png') ); ?>" alt="Close" class="all-campaign__filter-search-btn-clear-icon">
            </button>
        </div>
        <select id="allCampaignTypeSelect" class="all-campaign__filter-select" data-page-url="<?php echo esc_url( AllCampaignController::get_all_campaigns_permalink() ); ?>">
            <option selected="selected" disabled="disabled"><?php echo __( 'Sort by', 'crowdfundly' ); ?></option>
            <option value="trending"><?php echo __( 'Trending', 'crowdfundly' ); ?></option>
            <option value="almost_there"><?php echo __( 'Almost there', 'crowdfundly' ); ?></option>
            <option value="newest"><?php echo __( 'Newest', 'crowdfundly' ); ?></option>
            <option value="successful"><?php echo __( 'Successful', 'crowdfundly' ); ?></option>
            <option value="last_updated"><?php echo __( 'Last updated', 'crowdfundly' ); ?></option>
        </select>
    </div>
</div>
