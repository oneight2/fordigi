<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$org_settings = $data['org_settings'];
$data = $data['campaign'];
?>

<div class="back-modal">
	<div class="back-modal-inner-wrapper">
		<div id="reward-modal-overlay"></div>

		<div class="back-modal-inner">
			<span class="reward-modal-close"><a href="#">X</a></span>
			
			<h5 class="g-modal__title reward-modal-title">
				<span><?php _e( 'Back this campaign', 'crowdfundly' ); ?></span>
			</h5>

			<div class="form-group reward-form">
				<label class="contribution-heading" for="contribution">
					<?php _e( 'Make a contribution', 'crowdfundly' ); ?>
				</label>

				<div class="contribution-box__row">
					<div id="crowdfundly-contribution" class="d-flex align-items-center mb-0">
						<div class="form-group__amount flex-1">
							<span class="form-group__left-text">
								<?php echo esc_html( $data['currency_symbol'] ); ?>
							</span>
							<input type="number" min="0" id="reward-contribution-input" class="form-control form-control--amount">
							<span class="form-group__right-text">
								<?php echo esc_html( $data['currency_code'] ); ?>
							</span>
						</div>

						<div class="reward-btn-wrapper">
							<button id="reward-contribution-btn" disabled="true" type="button" class="btn btn-loader btn-primary btn-min-50 contribution-box__btn">
								<span><?php _e( 'Continue', 'crowdfundly' ); ?></span>
							</button>
						</div>
					</div>
                    <?php if ( ! empty( $data['rewards'] ) ) : ?>
					<p class="g-modal__info-text mb-0 mt-1">
						<?php _e( 'Contributions are not associated with rewards', 'crowdfundly' ); ?>
					</p>
                    <?php endif; ?>
				</div>
			</div>

            <?php
            if ( ! empty( $data['rewards'] ) ) :
                ?>
                <div class="form-group reward-items">
                    <label for="contribution">
                        <?php _e( 'Select a Reward', 'crowdfundly' ); ?>
                    </label>
                    <div class="row">
                        <?php
                        foreach ( $data['rewards'] as $reward ) :
                            $image_url = ! empty( $reward['image'] ) ? $reward['image']['url'] : '';
                            $regular_price_format = SingleCampaignController::get_currency_format( $org_settings, $data, $reward['regular_price'] );
                            $offer_price_format = SingleCampaignController::get_currency_format( $org_settings, $data, $reward['offer_price'] );
                            ?>
                            <div class="col-md-6 mb-2 mt-2">
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
                                                __( 'left', 'crowdfundly' )
                                            );
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
                        ?>
                    </div>
                </div>
                <?php
            endif;
            ?>

		</div>
	</div>

</div>
