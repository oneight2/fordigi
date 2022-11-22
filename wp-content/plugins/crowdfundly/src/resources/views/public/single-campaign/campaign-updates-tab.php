<?php
$updates = $data['updates'];
$tab_class = '';
$camp_story = $data['campaign']['options']['story'];
if ( ! $camp_story && empty( $data['campaign']['packages'] ) && $data['campaign']['type'] !== 3 ) {
	$tab_class = ' active show';
}
?>

<div class="tab-pane fade<?php echo esc_attr( $tab_class ); ?>" id="updates" role="tabpanel" aria-labelledby="updates-tab">
	<div class="g-tab__index">
		<div class="campaign-updates">
			<div class="campaign-updates__inner">
				<?php
				if ( ! empty( $updates['data'] ) ) :
					foreach ( $updates['data'] as $update ) :
						?>
						<div class="campaign-update">
							<div class="campaign-update__inner">
								<div class="campaign-update__row align-items-start">
									<p class="campaign-update__date flex-1">
										<?php
										echo date_i18n(
											get_option( 'links_updated_date_format' ),
											strtotime( $update['created_at'] )
											);
										?>
									</p>
								</div>

								<div class="campaign-update__info-text">
									<div class="campaign-view-updates__single-text-line">
										<?php
										$message = str_replace('"', '', $update['message']); 
										$message = str_replace('"', '', $message);                                                                         
										echo $message;
										?>
									</div>
								</div>

								<?php
								if ( isset( $update['video_url'] ) ) :
									$pattern = '/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i';
									$vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
									// preg_match( $pattern, $update['video_url'], $results );
									?>
									<div class="story-video-wrapper">
										<?php if ( preg_match( $pattern, $update['video_url'], $results ) ) : ?>
											<iframe width="470" height="1200" src="<?php echo esc_url( 'https://www.youtube.com/embed/' . $results[6] . '?controls=0' ); ?>" frameborder="0" allowfullscreen></iframe>
										<?php elseif(preg_match($vm_rx, $update['video_url'], $matches)) : 
											$viemo_id = $matches[count($matches) - 1];
										?>	
											<iframe width="470" height="1200" src="<?php echo esc_url( 'https://player.vimeo.com/video/' . $viemo_id ); ?>" frameborder="0" allowfullscreen></iframe>
										<?php endif; ?>		
									</div>
									<?php
								endif;
								
								if ( isset( $update['images'] ) ) :
									foreach ( $update['images'] as $image ) :
										?>
										<div class="mb-3">
											<img
											src="<?php echo esc_url( $image['source_path'] ); ?>"
											alt="<?php echo __('Campaign update image', 'crowdfundly'); ?>"
											class="campaign-update__img"
											>
										</div>
										<?php
									endforeach;
								endif;
								?>
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
										<i class="fas fa-bezier-curve"></i>
									</span>
								</div>
								<p class="section-placeholder__desc">
									<?php echo __( 'No Update Found', 'crowdfundly' ); ?>
								</p>
							</div>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>
