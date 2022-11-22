<?php

use Crowdfundly\App\Controllers\SingleCampaignController;

$top_contributers = [];

if ( $data['top_contributors'] ) {
	$top_contributors = $data['top_contributors']['data'];
	$total = $data['top_contributors']['total'];
	$current_page = ceil($total / 4);

}
$campaign = $data['campaign'];
$camp_id = $data['campaign']['id'];
$org_settings = $data['org_settings'];
?>

<div class="tab-pane fade" id="top-contributors" role="tabpanel" aria-labelledby="top-contributors-tab">
	<div class="g-tab__index">
		<div class="top-donors">
			<?php
			if ( $data['top_contributors'] && ! empty( $top_contributors ) ) :
				?>
				<div class="donor-list">
					<?php
					foreach ( $top_contributors as $contributor ) :
						
						$avatar_url = cf_asset( 'images/public/avatar.png' );
						if ( ! $contributor['is_anonymous'] && $contributor['avatar'] ) {
							$avatar_url = $contributor['avatar'];
						}
						?>
						<div class="donor-list__item">
							<div class="donor-card">
								<div class="donor-card__avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
								<div class="donor-card__details">
									<h6 class="donor-card__name">
									<?php /*var_dump($contributor['full_name']); */ ?>
										<?php //echo isset( $contributor['full_name'] ) ? esc_html( $contributor['full_name'] ) : 'Anonymous Contributor'; ?>
										<?php echo isset( ($contributor['full_name'])) && ! empty($contributor['full_name'])  ? esc_html( $contributor['full_name'] ) : 'Anonymous Contributor'; ?>
									</h6> 
									<h6 class="donor-card__label">
										<?php _e( 'Amount:', 'crowdfundly' ); ?> 
										<span class="donor-card__value">
											<?php echo esc_html( SingleCampaignController::get_currency_format( $org_settings, $campaign, $contributor['formatted_amount'] ) ); ?>
										</span>
									</h6>
								</div>
								<div class="donor-card__badge">
									<img src="<?php echo esc_url( cf_asset( 'images/public/medal.svg' ) ); ?>" alt="<?php echo __( 'Badge', 'crowdfundly' ); ?>" class="donor-card__badge-img">
								</div>
							</div>
						</div>
						<?php
					endforeach;
					?>
				</div>
				<?php
			else:
				?>
				<div>
					<div class="section-placeholder section-placeholder--sm">
						<div class="section-placeholder__inner">
							<div class="section-placeholder__icon">
								<span class="section-placeholder__icon-text">
									<i class="fas fa-donate"></i>
								</span>
							</div>
							<p class="section-placeholder__desc">
								<?php _e( 'No one has contributed yet.', 'crowdfundly' ); ?>
							</p>
						</div>
					</div>
				</div>
				<?php
			endif;
			?>
		</div>
		<?php
		if ( ! empty( $top_contributors )   && $total > 4) :
			$currency = [
				'currency_code' => $campaign['currency_code'],
				'currency_symbol' => $campaign['currency_symbol'],
			];
			?>
			<div class="text-center mt-3">
				<a
				id="crowdfundly-topcontributers-load-more" 
				class="btn btn-primary btn-sm px-5"
				href="#"
				data-last-page="<?php echo esc_attr( $current_page ); ?>" 
				data-camp-id="<?php echo esc_attr( $camp_id ); ?>"
				data-org-settings="<?php echo esc_attr( json_encode( $org_settings ) ); ?>"
				data-camp-currency="<?php echo esc_attr( json_encode( $currency ) ); ?>"
				>
					<span class="d-flex align-items-center justify-content-center">
						<span class="ml-2"><?php echo __( 'Load more', 'crowdfundly' ); ?></span>
					</span>
				</a>
			</div>
			<?php
		endif;
		?>
	</div>
</div>
