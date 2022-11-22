<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$packages = $data['campaign']['packages'];
$org_settings = $data['org_settings'];
$data = $data['campaign'];

?>

<div class="tab-pane fade active show" id="select-reward" role="tabpanel" aria-labelledby="select-reward-tab">
    <div class="g-tab__index">
        <div class="select-offer">
            <div class="row">
                <?php
                if ( ! empty( $packages ) ) :
                    foreach ( $packages as $package ) :
                        $image_url = ! empty( $package['image'] ) ? $package['image']['url'] : '';
                        $currency_format = SingleCampaignController::get_currency_format( $org_settings, $data, $package['formatted_price'] );

                        $is_public = SingleCampaignController::campaign_donation_status($data);

                        $donation_status = ( $is_public == false ) ? 'pointer-events: none' : '';
                        ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-2 mt-2">
                            <div class="offer-card">
                                <div
                                    class="offer-card__img offer-card__img--bg"
                                    style="background-image: url(<?php echo esc_url( $image_url ); ?>);">
                                </div>

                                <div class="offer-card__body">
                                    <h4 class="offer-card__title mb-2">
                                        <?php echo esc_html( $package['name'] ); ?>
                                    </h4>
                                    <div class="offer-card__price">
                                        <h6 class="offer-card__price">
											<?php echo esc_html( $currency_format ); ?>
										</h6>
                                    </div>
                                    <p class="offer-card__description">
                                        <?php echo wp_kses_post( $package['description'] ); ?>
                                    </p>
                                </div>

                                <div class="offer-card__footer">
                                    <a
                                    type="button"
                                    
                                    style="<?php echo $donation_status; ?>"
                                    class="btn btn-outline-primary package-get-product"
                                    data-package-id="<?php echo esc_attr( $package['id'] ); ?>"
                                    data-title="<?php echo esc_attr( $package['name'] ); ?>"
                                    data-package-amount="<?php echo esc_attr( $package['price'] ); ?>"
                                    data-package-price="<?php echo esc_attr( $currency_format ); ?>"
                                    data-media="<?php echo esc_attr( $image_url ); ?>"
                                    >
                                        <?php echo __( 'Get Now', 'crowdfundly' ); ?>
                                    </a>
                                </div>
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
                                <?php echo __( 'No Package Found', 'crowdfundly' ); ?>
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
