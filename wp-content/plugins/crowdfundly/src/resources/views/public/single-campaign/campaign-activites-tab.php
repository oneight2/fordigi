<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$activities = [];
// var_dump($data['activities'] );
// var_dump($data['activities']['data']);
if ( $data['activities'] ) {
	$activities = $data['activities']['data'];
	$last_page = $data['activities']['last_page'];
	$current_page = $data['activities']['current_page'];
}
$campaign = $data['campaign'];
$camp_id = $data['campaign']['id'];
$org_settings = $data['org_settings'];
// var_dump($data['activities']['data']);
?>

<div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab">
	<div class="g-tab__index">
		<div class="activities">
			<?php
			if ( $data['activities'] && ! empty( $activities ) ) :
				foreach ( $activities as $activity ) :
					$avatar_url = cf_asset( 'images/public/avatar.png' );
					if ( ! $activity['is_anonymous']
					&& isset( $activity['donation']['avatar'] )
					&& ! empty( $activity['donation']['avatar'] )
					) {
						$avatar_url = $activity['donation']['avatar'];
					}
					$name = '';
					if ( isset( $activity['donation']['full_name'] ) && ! isset( $activity['donation']['name'] ) ) {
						$name = isset( $activity['donation']['full_name'] ) ? $activity['donation']['full_name'] : 'Anonymous Contributor 1';
					}
					if ( ! isset( $activity['donation']['full_name'] ) && isset( $activity['donation']['name'] ) ) {
						$name = isset( $activity['donation']['name'] ) ? $activity['donation']['name'] : 'Anonymous Contributor 2';
					}
					if ( $activity['is_anonymous'] && isset( $activity['donation']['name'] ) == null ) {
						$name = isset( $activity['donation']['full_name'] ) ? $activity['donation']['full_name'] : 'Anonymous Contributor 3';
					}
					if ( $activity['is_anonymous'] && isset( $activity['donation']['full_name']) ==null) {
						$name = isset( $activity['donation']['name'] ) ? $activity['donation']['name'] : 'Anonymous Contributor';
					}
					if ( $activity['donation']['is_anonymous'] === (int) 0 && isset( $activity['donation']['full_name'])) {
						$name = 'Anonymous Contributor';
					}
					

					?>
					<div class="activity">
						<div class="activity__avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
						<div class="activity__details">
							<div class="activity__row">
								<div class="activity__name">
									<?php
									$offline = '';
									if($activity['donation']['is_anonymous'] === (boolean)true || isset( $activity['donation']['name'] )) {
										$offline = __( 'offline', 'crowdfundly' );
									}
									echo esc_html( $name );
									?>
									<span class="activity__label">
										<?php
										_e( 'has contributed', 'crowdfundly' );
										echo esc_html( ' ' . $offline );
										?>
									</span>
								</div>
								<p class="activity__date">
									<?php echo date_i18n( get_option( 'links_updated_date_format' ), strtotime( $activity['created_at'] ) ); ?>
								</p>
							</div>
							<div class="activity__row">
								<div class="activity__label">
									<?php _e( 'Amount:', 'crowdfundly' ); ?> 
									<span class="activity__value">
										<?php echo esc_html( SingleCampaignController::get_currency_format( $org_settings, $campaign, $activity['formatted_donation_amount'] ) ); ?>
									</span>
								</div>
							</div>
							<?php if ( isset( $activity['donation']['message'] ) ) : ?>
								<div class="activity__row">
									<p class="activity__message">
										<?php echo $activity['donation']['message']; ?>
									</p>
								</div>
							<?php endif; ?>                                                 
						</div>
					</div>
					<?php 
				endforeach;
			else: 
				?>
				<div>
					<div class="section-placeholder section-placeholder--sm">
						<div class="section-placeholder__inner">
							<div class="section-placeholder__icon">
								<span class="section-placeholder__icon-text">
									<i class="fas fa-chart-line"></i>
								</span>
							</div>
							<p class="section-placeholder__desc">
								<?php echo __( 'No activities found for this campaign', 'crowdfundly' ); ?>
							</p>
						</div>
					</div>
				</div>
				<?php
			endif;
			?>
		</div>

		<?php
		if ( ! empty( $activities ) && $last_page > $current_page ) :
			$currency = [
				'currency_code' => $campaign['currency_code'],
				'currency_symbol' => $campaign['currency_symbol'],
			];
			?>
			<div class="text-center mt-3">
				<a
				id="crowdfundly-activites-load-more" 
				class="btn btn-primary btn-sm px-5"
				href="#"
				data-last-page="<?php echo esc_attr( $last_page ); ?>" 
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
