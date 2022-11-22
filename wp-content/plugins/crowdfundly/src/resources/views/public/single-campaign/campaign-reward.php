<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$org_settings = $data['org_settings'];
$data = $data['campaign'];
?>

<div class="tab-pane fade" id="select-reward" role="tabpanel" aria-labelledby="select-reward-tab">
    <div class="g-tab__index">
        <div class="select-offer">
            <div class="row">
                <?php
                if ( ! empty( $data['rewards'] ) ) :
                    foreach ( $data['rewards'] as $reward ) :
                        $image_url = ! empty( $reward['image'] ) ? $reward['image']['url'] : '';
                        $regular_price_format = SingleCampaignController::get_currency_format( $org_settings, $data, $reward['regular_price'] );
                        $offer_price_format = SingleCampaignController::get_currency_format( $org_settings, $data, $reward['offer_price'] );
                        ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-2 mt-2">
                            <div class="offer-card">
                                <div class="offer-card__img offer-card__img--bg" style="background-image: url(<?php echo esc_url( $image_url ); ?>);"></div>
                                
                                <div class="offer-card__body">
                                    <h4 class="offer-card__title">
                                        <?php echo esc_html( $reward['title'] ); ?>
                                    </h4>
                                    <span class="badge  badge-warning">
                                        <?php
                                        printf( '%s %s %s',
                                        __( 'Only', 'crowdfundly' ),
                                        esc_html( $reward['stock'] ),
                                        __( 'left', 'crowdfundly' ) );
                                        ?>
                                    </span>
                                    <div class="offer-card__price">
                                        <h5 class="offer-card__price-old">
                                            <?php echo esc_html( $regular_price_format ); ?>
                                        </h5>
                                        <h5 class="offer-card__price-new">
                                            <?php echo esc_html( $offer_price_format ); ?>
                                        </h5>
                                    </div>
                                    <p class="offer-card__description">
                                        <?php echo wp_kses_post( $reward['description'] ); ?>
                                    </p>

                                    <?php
                                    if ( ! empty( $reward['shipping_info'] ) ) :
                                        ?>
                                        <div class="offer-card__shipping">
                                            <div class="d-flex align-items-center">
                                                <h5 class="offer-card__shipping-title">
                                                    <?php _e( 'Shipping', 'crowdfundly' ); ?>
                                                </h5>
                                            </div>

                                            <?php
                                            foreach ( $reward['shipping_info'] as $info ) :
                                                ?>
                                                <div class="offer-card__shipping-info">
                                                    <p class="offer-card__shipping-info-location">
                                                        <strong class="offer-card__shipping-info-label">
                                                            <?php echo __( 'Shipping location: ', 'crowdfundly' ); ?>
                                                        </strong>
                                                        <?php echo esc_html( $info['location'] ); ?>
                                                    </p>
                                                    <p class="offer-card__shipping-info-fee">
                                                        <strong class="offer-card__shipping-info-label">
                                                            <?php echo __( 'Shipping Fee: ', 'crowdfundly' ); ?>
                                                        </strong>
                                                        <?php echo esc_html( $data['currency_code'] . ' ' . $info['shippingFee'] ); ?>
                                                    </p>
                                                </div>
                                                <?php
                                            endforeach;
                                            ?>
                                        </div>
                                        <?php
                                    endif;
                                    ?>
                                </div>

                                <div class="offer-card__footer">
                                    <a
                                    data-reward-id="<?php echo esc_attr( $reward['id'] ); ?>"
                                    type="button"
                                    class="btn btn-outline-primary reward-get-product"
                                    data-title="<?php echo esc_attr( $reward['title'] ); ?>"
                                    data-reward-amount="<?php echo esc_attr( $reward['offer_price'] ); ?>"
                                    data-regular-price="<?php echo esc_attr( $regular_price_format ); ?>"
                                    data-offer-price="<?php echo esc_attr( $offer_price_format ); ?>"
                                    data-media="<?php echo esc_attr( $image_url ); ?>"
                                    data-shipping-locations="<?php echo esc_attr( json_encode( $reward['shipping_info'] ) ); ?>"
                                    data-currency-code="<?php echo esc_attr( $data['currency_code'] ); ?>"
                                    >
                                        <?php echo __( 'Get Now', 'crowdfundly' ); ?>
                                    </a>
                                </div>

                                <?php
                                if ( isset( $reward['offer_price'] ) && $reward['offer_price'] > 0 ) :
                                    $off_price = floor( ( ( (int)$reward['regular_price'] - (int)$reward['offer_price'] ) / (int)$reward['regular_price'] ) * 100 );
                                    ?>
                                    <div class="offer-card__badge">
                                        <?php printf( '%s %s %s', $off_price, __( 'OFF', 'crowdfundly' ), '%' ); ?>
                                    </div>
                                    <?php
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                    endforeach;
                else:
                    ?>
                    <div class="section-placeholder section-placeholder--sm">
                        <div class="section-placeholder__inner">
                            <div class="section-placeholder__icon">
                                <span class="section-placeholder__icon-text">
                                    <i class="fas fa-bezier-curve"></i>
                                </span>
                            </div>
                            <p class="section-placeholder__desc">
                                <?php echo __( 'No Reword Found', 'crowdfundly' ); ?>
                            </p>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
