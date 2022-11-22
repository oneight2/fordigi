<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$campaigns = $data['campaigns'];
$last_page = $data['last_page'];
$org_settings = $data['org_settings'];
$total_cam    = $data['total'];
?>

<div class="row" id="all-camp-row">
    <?php
    if ( ! empty( $campaigns ) ) :
        $crowdfundly_all_camp_col = '4';
        // if ( ! empty( get_theme_mod( 'cf_all_camp_card_column', $crowdfundly_all_camp_col ) ) ) {
        //     $crowdfundly_all_camp_col = get_theme_mod( 'cf_all_camp_card_column', $crowdfundly_all_camp_col );
        // }
        // if ( ! empty( $crowdfundly_elementor_settings['all_camp_card_columns'] ) ) {
        //     $crowdfundly_all_camp_col = $crowdfundly_elementor_settings['all_camp_card_columns'];
        // }

        foreach ( $campaigns as $camp ) :
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $crowdfundly_all_camp_col ); ?>">
                <a href="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $camp['slug'] ) ); ?>" class="campaign-card">
                    <div class="campaign-card__top">
                        <?php
                        $thumbnail = cf_asset( 'images/public/campaign-thumbnail-placeholder.png' );
                        if ( $camp['thumbnail'] ) {
                            $thumbnail = is_array( $camp['thumbnail'] ) ? $camp['thumbnail']['url'] : $camp['thumbnail'];
                        }
                        ?>
                        <div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( $thumbnail ); ?>);"></div>
                        <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_html( $camp['name'] ); ?>" class="campaign-card__img">
                    </div>
                    <div class="campaign-card__details">
                        <h4 class="campaign-card__title" data-toggle="tooltip" title="<?php echo esc_html( $camp['name'] ); ?>">
                            <?php echo esc_html( $camp['name'] ); ?>
                        </h4>
                        <p class="campaign-card__description">
                            <?php //echo SingleCampaignController::get_campaign_story_excerpt( $camp['story'], 20 ); ?>
                        </p>
                    </div>
                    <div class="campaign-card__footer">
                        <div class="progress progress--slim camp-type-<?php echo esc_attr( $camp['type'] ); ?>">
                            <?php
                            if ( $camp['type'] == 3 ) :
                                $width = 0;
                                if ( $camp['raised_amount'] && $camp['target_amount'] ) {
                                    $width = round( ( $camp['raised_amount'] * 100 ) / $camp['target_amount'] );
                                }
                                ?>
                                <div
                                class="progress__bar progress__bar--secondary"
                                style="width: <?php echo esc_html( $width . '%' ); ?>"
                                ></div>
                                <?php
                            endif;
                            ?>
                        </div>

                        <p class="campaign-card__amount">
                            <strong>
                                <i class="fas fa-hand-holding-usd"></i>
                                <?php
                                echo SingleCampaignController::get_currency_format(
                                    $org_settings, $camp, $camp['formatted_raised_amount'], 'after'
                                );
                                ?>
                            </strong>
                            <?php
                            if ( $camp['type'] == 3 ) {
                                printf( '%s %s', __('OF', 'crowdfundly'),
                                    SingleCampaignController::get_currency_format(
                                        $org_settings, $camp, $camp['formatted_target_amount'], 'after'
                                    )
                                );
                            }    
                            ?>
                        </p>
                    </div>
                </a>
            </div>
            <?php
        endforeach;
    else:
        ?>
        <div class="section-placeholder">
            <div class="section-placeholder__inner">
                <div class="section-placeholder__icon">
                    <span class="section-placeholder__icon-text">
                        <i class="fas fa-bullhorn"></i>
                    </span>
                </div>
                <h3 class="section-placeholder__title"><?php _e( 'Sorry', 'crowdfundly' ); ?></h3>
                <p class="section-placeholder__desc"> <?php _e( 'No campaigns to show', 'crowdfundly' ); ?></p>
            </div>
        </div>
        <?php
    endif;
    ?>
</div>

<?php
// $cf_all_campaign_load_more_hide = get_theme_mod( 'cf_all_campaign_load_more_hide', false );

// $per_page_items = get_theme_mod( 'cf_all_camp_per_page', 5 );
// $per_page_items = ! empty( $crowdfundly_elementor_settings['all_camp_per_page'] ) ? $crowdfundly_elementor_settings['all_camp_per_page'] : $per_page_items;
$per_page_items = 3;
$number = $total_cam % $per_page_items;
// echo $total_cam;
// echo $number;
if ( ! empty( $campaigns ) && 6 <= count( $campaigns ) && $total_cam != 6) :
    ?>
    <div class="load-more-btn-wrapper text-center">
        <button
        id="crowdfundly-all-camp-loadmore"
        class="btn btn-primary mt-5" 
        data-per-page="<?php echo esc_attr( $per_page_items ); ?>"
        data-last-page="<?php echo esc_attr( $last_page ); ?>"
        data-column="<?php echo esc_attr( $crowdfundly_all_camp_col ); ?>"
        data-total-cam="<?php echo esc_attr( $total_cam ); ?>"
        data-org-settings="<?php echo esc_attr( json_encode( $org_settings ) ); ?>"
        >
            <?php _e( 'Load More', 'crowdfundly' ); ?>
        </button>
    </div>
    <?php
endif;
?>
