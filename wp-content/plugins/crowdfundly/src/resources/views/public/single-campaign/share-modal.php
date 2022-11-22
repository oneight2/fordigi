<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$camp = $data['campaign'];
?>

<div id="crowdfundly-share-modal" class="g-modal">
	<div class="g-modal__inner top-center">
		<div id="share-modal-overlay" class="g-modal__overlay"></div>
		
		<div class="g-modal__content g-modal__content--sm undefined">
			<a id="share-modal-close-btn" class="g-modal__close-btn">x</a>
			
			<div class="g-modal__body">
				<div class="share-modal">
					<h5 class="share-modal__title"><?php _e( 'Share this campaign', 'crowdfundly' ); ?></h5> 
					<p class="share-modal__info-text"><?php _e( 'A single share from you will usually lead to at least one contribution. Sharing this campaign only take 10 seconds', 'crowdfundly' ); ?></p>
					
					<div class="share-modal__buttons">
						<div class="share-modal__buttons-list">
							<div class="share-modal__buttons-list-item">
								<a href="#"
								class="share-network-facebook"
								data-sharer="facebook"
								data-url="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $camp['slug'] ) ); ?>"
								>
									<button class="btn share-modal__button share-modal__button--facebook">
										<i class="share-modal__button-icon fab fa-facebook-f"></i>
                        				<?php _e( 'Share On Facebook', 'crowdfundly' ); ?>
                    				</button>
								</a>
							</div>
							<div class="share-modal__buttons-list-item">
								<a
								href="#"
								class="share-network-twitter"
								data-sharer="twitter"
								data-title="<?php echo esc_html( $camp['name'] ); ?>"
								data-url="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $camp['slug'] ) ); ?>"
								>
									<button class="btn share-modal__button share-modal__button--twitter">
										<i class="share-modal__button-icon fab fa-twitter"></i>
                        				<?php _e( 'Share On Twitter', 'crowdfundly' ); ?>
                    				</button>
								</a>
							</div>
							<div class="share-modal__buttons-list-item">
								<a
								href="#"
								class="share-network-linkedin"
								data-sharer="linkedin"
								data-url="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $camp['slug'] ) ); ?>"
								>
									<button class="btn share-modal__button share-modal__button--linkedin">
										<i class="share-modal__button-icon fab fa-linkedin-in"></i>
                        				<?php _e( 'Share On LinkedIn', 'crowdfundly' ); ?>
                    				</button>
								</a>
							</div>
							<div class="share-modal__buttons-list-item">
								<a
								href="#"
								class="share-network-whatsapp"
								data-sharer="whatsapp"
								data-title="<?php echo esc_html( $camp['name'] ); ?>"
								data-url="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $camp['slug'] ) ); ?>"
								>
									<button class="btn share-modal__button share-modal__button--whatsapp">
										<i class="share-modal__button-icon fab fa-whatsapp"></i>
										<?php _e( 'Share On Whatsapp', 'crowdfundly' ); ?>
									</button>
								</a>
							</div>
						</div>
					</div>

					<!-- <p class="share-modal__info-text"><?php //_e( 'Or print out this flyer and help spread the world', 'crowdfundly' ); ?></p>  -->
					<div class="flyer">
						<div class="flyer__inner">
							<div class="flyer-card flyer-card--0">
								<?php
								$thumbnail = cf_asset( 'images/public/campaign-thumbnail-placeholder.png' );
								if ( isset( $camp['thumbnail'] ) && ! empty( $camp['thumbnail'] ) ) {
									$thumbnail = $camp['thumbnail']['url'];
								}
								?>
								<div class="flyer-card__img" style="background-image: url(<?php echo esc_url( $thumbnail ); ?>);"></div> 
								<!-- <div class="flyer-card__inner">
									<h5 class="flyer-card__title"><?php //_e( 'Help growing clubs', 'crowdfundly' ); ?></h5> 
									<div class="flyer-card__description"></div>
								</div> -->
							</div>
						</div>
						<!-- <a href="#" class="btn btn-primary btn-min-50 btn-block mt-4"><?php //_e( 'Download The PDF Flyer', 'crowdfundly' ); ?></a> -->
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
