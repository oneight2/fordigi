<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$crowdfundly_single_camp_hide_similar_camps = get_theme_mod( 'cf_single_camp_hide_similar_camps', false );
if ( $crowdfundly_single_camp_hide_similar_camps != true ) :

$similar_camps = $data['similar_camps'];
$campaign = $data['campaign'];
$org_settings = $data['org_settings'];
// dd($campaign);
?>
<div class="g-section">
	<div class="campaign__view-related">
		<h4 class="campaign__view-related-title">
			<?php
			$crowdfundly_similar_camp_heading = get_theme_mod( 'cf_single_camp_similar_campaign_heading', __( 'Similar Campaign', 'crowdfundly' ) );

			if ( ! empty( $crowdfundly_elementor_settings['similar_camps_heading_text'] ) ) {
				$crowdfundly_similar_camp_heading = $crowdfundly_elementor_settings['similar_camps_heading_text'];
			}
			if ( empty( $crowdfundly_similar_camp_heading ) ) {
				$crowdfundly_similar_camp_heading = __( 'Similar Campaign', 'crowdfundly' );
			}

			echo esc_html( $crowdfundly_similar_camp_heading );
			?>
		</h4>
		<div class="row">
			<?php
			$crowdfundly_single_camp_col = '4';
			if ( ! empty( get_theme_mod( 'cf_single_camp_card_column', $crowdfundly_single_camp_col ) ) ) {
				$crowdfundly_single_camp_col = get_theme_mod( 'cf_single_camp_card_column', $crowdfundly_single_camp_col );
			}
			if ( ! empty( $crowdfundly_elementor_settings['similar_camp_card_columns'] ) ) {
				$crowdfundly_single_camp_col = $crowdfundly_elementor_settings['similar_camp_card_columns'];
			}
			foreach ($similar_camps as $similar): ?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $crowdfundly_single_camp_col ); ?>">
					<a href="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink($similar['slug']) ); ?>" class="campaign-card">
						<?php
							$thumbnail = cf_asset( 'images/public/campaign-thumbnail-placeholder.png' ); 
							// dump($similar['thumbnail']['url']);
							// if( isset( empty($similar['thumbnail']) && !empty($similar['thumbnail']) ) : 
								$logo = is_array( $similar['thumbnail'] ) ? $similar['thumbnail']['url'] : $thumbnail;
						?>
						<div class="campaign-card__top">
							<div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( "&quot;". $logo ."&quot;"); ?>);"></div>
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr($similar['name'] ); ?>" class="campaign-card__img">                                                
						</div>
					
						<div class="campaign-card__details">
							<h4 class="campaign-card__title" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html($similar['name']); ?>">
								<?php echo esc_html($similar['name']); ?>
							</h4>
							<!-- <p class="campaign-card__description"> -->
								<?php //echo strip_tags(SingleCampaignController::get_campaign_story_excerpt($similar['story'], 20)); ?>
							<!-- </p> -->
						</div>
						<div class="campaign-card__footer">
							<?php if($campaign['type'] == 3): 
								?>
								<div class="progress progress--slim">
								<div class="progress__bar progress__bar--secondary" style="width: <?php echo esc_attr( round(( ($similar['raised_amount'] > 0 ? $similar['raised_amount'] : 0 )*100)/ $similar['target_amount']) ); ?>%;"></div>
								</div>
								<p class="campaign-card__amount"> 
								<strong>
									<i class="fas fa-hand-holding-usd"></i> <?php 
									echo SingleCampaignController::get_currency_format( $org_settings, $campaign, $similar['formatted_raised_amount'] );
									// sprintf(__("%1\$d %2\$s", 'crowdfundly'), round($similar['raised_amount'], 2), $similar['currency_code'] );
									 ?>
								</strong>
								<?php
								 echo sprintf(__("%1\$s", 'crowdfundly'), ' OF ' ); 
								 echo SingleCampaignController::get_currency_format( $org_settings, $campaign, $similar['formatted_target_amount'] );
								// echo sprintf(__("OF %1\$d %2\$s", 'crowdfundly'), $similar['target_amount'], $similar['currency_code'] );
								 ?>
							</p>
							<?php endif; ?>	
							<?php if($campaign['type'] == 2 || $campaign['type'] == 1): ?>
								<p class="campaign-card__footer-raised">Total Raised</p> 
								<p class="campaign-card__amount" style="margin-bottom: 0px;">
								<span class="text-nowrap campaign-card__amount-raised" style="font-size: 20px; font-weight: 600;">
									<?php 
									  echo SingleCampaignController::get_currency_format( $org_settings, $campaign, $similar['formatted_raised_amount'] );
									// echo sprintf(__("%1\$d", 'crowdfundly'), SingleCampaignController::get_currency_format( $org_settings, $similar_camps, $similar['formatted_raised_amount'] ) ); 
									//   echo sprintf(__("%1\$s %2\$d", 'crowdfundly'), $similar['currency_code'], $similar['raised_amount'] ); 
									
									?>
								</span> <!---->
								</p>
							<?php endif; ?>							
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
