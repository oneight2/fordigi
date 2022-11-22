<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$packages = $data['campaign']['packages'];
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
							<input type="number" id="reward-contribution-input" class="form-control form-control--amount">
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
					<?php if ( ! empty( $data['packages'] ) ) : ?>
					<p class="g-modal__info-text mb-0 mt-1">
						<?php _e( 'Contributions are not associated with package', 'crowdfundly' ); ?>
					</p>
					<?php endif; ?>
				</div>
			</div>

			<?php
			if ( ! empty( $data['packages'] ) ) :
				?>
				<div class="form-group reward-items">
					<label for="contribution">
						<?php _e( 'Select a Package', 'crowdfundly' ); ?>
					</label>
					<div class="row">
						<?php
						foreach ( $data['packages'] as $package ) :
							$image_url = ! empty( $package['image'] ) ? $package['image']['url'] : '';
							$currency_format = SingleCampaignController::get_currency_format( $org_settings, $data, $package['formatted_price'] );
							?>
							<div class="col-md-6 mb-2 mt-2">
								<div class="offer-card">
									<div class="offer-card__img offer-card__img--bg" style="background-image: url(<?php echo esc_url( $image_url ); ?>);"></div>
									<div class="offer-card__body">
										<h4 class="offer-card__title">
											<?php echo esc_html( $package['name'] ); ?>
										</h4>
										<div class="offer-card__price">
											<h5 class="offer-card__price">
												<?php echo esc_html( $currency_format ); ?>
											</h5>
										</div>
										<p class="offer-card__description">
											<?php echo wp_kses_post( $package['description'] ); ?>
										</p>
									</div>
									<div class="offer-card__footer">
										<a
										data-package-id="<?php echo esc_attr( $package['id'] ); ?>"
										type="button"
										class="btn btn-outline-primary package-get-product"
										data-title="<?php echo esc_attr( $package['name'] ); ?>"
										data-package-amount="<?php echo esc_attr( $package['price'] ); ?>"
										data-package-price="<?php echo esc_attr( $currency_format ); ?>"
										data-media="<?php echo esc_attr( $image_url ); ?>"
										data-modal="yes"
										>
											<?php echo __( 'Get Now', 'crowdfundly' ); ?>
										</a>
									</div>
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
