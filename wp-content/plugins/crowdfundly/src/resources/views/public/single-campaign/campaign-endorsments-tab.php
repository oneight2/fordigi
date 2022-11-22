<?php

$endorsements = false;
$is_approved = false;
if ( $data['endorsements'] ) {
	$endorsements = $data['endorsements']['data'];
	$is_approved = $data['endorsements']['approved_count'];
}
?>

<div class="tab-pane fade" id="endorsements" role="tabpanel" aria-labelledby="endorsements-tab">
	<div class="g-tab__index">
		<div class="endorsements">
			<?php
			if ( $endorsements && $is_approved ) :
				foreach ( $endorsements['data'] as $endorsement ) :
					$avatar_url = cf_asset( 'images/public/avatar.png' );
					if ( isset( $endorsement['user']['avatar'] ) ) {
						$avatar_url = $endorsement['user']['avatar'];
					}
					?>
					<div class="endorsement">
						<div class="endorsement__avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
						<div class="endorsement__details">
							<div class="endorsement__row">
								<h6 class="endorsement__name">
									<span>
										<?php echo esc_html( $endorsement['user']['name'] ); ?>
									</span>
									<span class="endorsement__label">
										<?php echo __('has endorsed as a', 'crowdfundly'); ?> 
										<strong>
											<?php echo esc_html( $endorsement['relation'] ); ?>
										</strong>
									</span>
								</h6> 
							</div>
							<div class="endorsement__row">
								<p class="endorsement__message">
									<?php echo esc_html( $endorsement['message'] ); ?>
								</p>
							</div>
							<div class="endorsement__row justify-content-end"></div>
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
								<i class="fas fa-user-check"></i>
							</span>
						</div> 
						<p class="section-placeholder__desc">
							<?php _e( 'No Endorsement found for this campaign', 'crowdfundly' ); ?>
						</p>
					</div>
				</div>
				<?php
			endif;
			?>
		</div>
	</div>
</div>
