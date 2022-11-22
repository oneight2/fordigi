<?php

use Crowdfundly\App\Controllers\SingleCampaignController;

$campaigns = $data['campaigns'];
$column = $data['column'];
$org_settings = $data['org_settings'];

if ( ! empty( $campaigns ) ) :
    foreach ( $campaigns as $camp ) :
        ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $column ); ?>">
            <a href="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $camp['slug'] ) ); ?>" class="campaign-card">
                <?php
                $thumbnail = cf_asset( 'images/public/campaign-thumbnail-placeholder.png' );
                if ( $camp['thumbnail'] ) {
                    $thumbnail = is_array( $camp['thumbnail'] ) ? $camp['thumbnail']['url'] : $camp['thumbnail'];
                }
                ?>
                <div class="campaign-card__top">
                    <div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( $thumbnail ); ?>);"></div>
                    <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_html( $camp['name'] ); ?>" class="campaign-card__img">                                                
                </div>

                <div class="campaign-card__details">
                    <h4 class="campaign-card__title" data-toggle="tooltip" title="<?php echo esc_html( $camp['name'] ); ?>">
                        <?php echo esc_html( $camp['name'] ); ?>
                    </h4>
                    <!-- <p class="campaign-card__description">
                        <?php //echo strip_tags( SingleCampaignController::get_campaign_story( $camp['story'], 20 ) ); ?>
                    </p> -->
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
endif;
