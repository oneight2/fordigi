<?php

use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\AllCampaignController;
use Crowdfundly\App\Controllers\SingleCampaignController;

// data comes from the public/organization.php
$organization = $data['organization'];
$recent_campaigns = $data['recent_campaigns'];
$org_settings = $data['org_settings'];
?>

<div class="content-wrapper template crowdfundy-org">
	<div class="content-body">
		<div class="template">
			<div class="template__1">
				<div class="organization">
					<?php
                    $crowdfundly_hide_slider = get_theme_mod( 'cf_org_hide_slider', false );
                    if ( $crowdfundly_hide_slider != true ) :
						$slides = OrganizationController::get_slider($organization);
                        ?>
                        <div class="organization__slider">
                            <div class="main agile">
                                <div class="slider org-slider">
                                    <?php
									if ( ! empty( $slides ) ) :
										foreach( $slides as $slide_url ):
											?>
											<div>
												<img class="slide" src="<?php echo esc_url( $slide_url ); ?>" alt="<?php echo __('Campaign slider image', 'crowdfundly'); ?>">
											</div>
											<?php
										endforeach;
									endif;
									?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>

					<div class="container <?php echo $crowdfundly_hide_slider ? esc_attr( 'crowdfundly-org-without-slider' ) : ''; ?>">
						<div class="organization__details">
							<div class="row">
								<div class="col-12 col-md-4 organization__details-left">
									<div class="organization__info">
										<div class="organization__info-top">
											<div class="organization__info-logo">
                                                <?php
                                                $logo = null;
                                                if ( ! empty( $organization['logo'] ) ) {
                                                    $logo = $organization['logo']['source_path'];
                                                } else {
                                                    $logo = cf_asset('images/public/avatar.png');
                                                }
                                                ?>
                                                <img
												src="<?php echo esc_url( $logo ); ?>"
												class="organization__info-logo-img"
												alt="<?php echo esc_attr( $organization['name'] ); ?>">
                                            </div>

											<div class="organization__info-top-right">
												<h4 class="organization__info-name">
                                                    <?php echo esc_html( $organization['name'] ); ?>
                                                </h4>
                                                <p class="organization__info-address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo esc_html( $organization['address'] ); ?>
                                                </p>
											</div>
										</div>

										<?php 
										if ( ! empty(  $organization['socialProfiles'] ) ) :
											?>
											<div class="organization__social">
												<h5 class="organization__social-title">
													<?php echo __('Linked accounts', 'crowdfundly'); ?>
												</h5>
												<ul class="organization__social-list">
													<?php
													if ( ! empty(  $organization['socialProfiles'] ) ) :
														foreach ( $organization['socialProfiles'] as $profile ) :
															if ( ! empty( $profile['link'] ) ) :
															?>
															<li class="organization__social-item organization__social-item--<?php echo esc_html( $profile['social_network']['name'] ); ?>">
																<a href="<?php echo esc_url( $profile['link'] ); ?>" target="_blank" title="<?php echo esc_attr( $profile['social_network']['name'] ); ?>" class="organization__social-item-link">
																	<i class="organization__social-item-icon <?php echo esc_attr( $profile['social_network']['icon'] ); ?>"></i>
																	<div class="organization__social-item-details">
																		<h5  class="organization__social-item-title">
																			<?php echo esc_html( $profile['social_network']['name'] ); ?>
																		</h5>
																		<p class="organization__social-item-subtitle">
																			<?php echo esc_html( $profile['link'] ); ?>
																		</p>
																	</div>
																</a>
															</li>
															<?php
															endif;
														endforeach;
													endif;
													?>
												</ul>
											</div>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-12 col-md-8">
									<div class="organization__details-inner">
										<h1 class="organization__details-title">
                                            <?php echo esc_html( $organization['name'] ); ?>
                                        </h1>
                                        <div>
                                            <?php echo $organization['description']; ?>
                                        </div>
									</div>
								</div>
							</div>
						</div>
		
						<?php
                        $crowdfundly_hide_recent_camps = get_theme_mod( 'cf_org_hide_recent_camps', false );
						if ( $crowdfundly_hide_recent_camps != true ) :
                            if ( $recent_campaigns && ! empty( $recent_campaigns['data'] ) ) :
                                ?>
                                <div class="organization__campaigns">
                                    <h4 class="organization__campaigns-title">
                                        <?php
                                        $crowdfundly_recent_text = get_theme_mod( 'cf_org_recent_campaign_title', __( 'Recent Campaign', 'crowdfundly' ) );

                                        $crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_org_camp', '' );
                                        if ( ! empty( $crowdfundly_elementor_settings['recent_camps_heading_text'] ) ) {
                                            $crowdfundly_recent_text = $crowdfundly_elementor_settings['recent_camps_heading_text'];
                                        }
                                        if ( empty( $crowdfundly_recent_text ) ) {
                                            $crowdfundly_recent_text = __( 'Recent Campaign', 'crowdfundly' );
                                        }
                                        echo esc_html( $crowdfundly_recent_text );

                                        $crowdfundly_recent_camp_col = '3';
                                        if ( ! empty( get_theme_mod( 'cf_org_recent_camp_card_column', $crowdfundly_recent_camp_col ) ) ) {
											$crowdfundly_recent_camp_col = get_theme_mod( 'cf_org_recent_camp_card_column', $crowdfundly_recent_camp_col );
										}
                                        if ( ! empty( $crowdfundly_elementor_settings['camp_card_columns'] ) ) {
                                            $crowdfundly_recent_camp_col = $crowdfundly_elementor_settings['camp_card_columns'];
                                        }
                                        ?>
                                    </h4>

                                    <div class="row" id="recent-campaigns">
                                        <?php
                                        foreach ( $recent_campaigns['data'] as $campaign ) :
                                            ?>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $crowdfundly_recent_camp_col ); ?>">
                                                <a href="<?php echo esc_url( SingleCampaignController::get_single_camp_permalink( $campaign['slug'] ) ); ?>" class="campaign-card">
                                                    <div class="campaign-card__top">
                                                        <?php
                                                        $future_image = cf_asset( 'images/public/campaign-thumbnail-placeholder.png' );
                                                        if ( $campaign['thumbnail'] ) {
                                                            $future_image = is_array( $campaign['thumbnail'] ) ? $campaign['thumbnail']['url'] : $campaign['thumbnail'];
                                                        }
                                                        ?>
                                                        <div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( $future_image ); ?>);"></div>
                                                        <img src="<?php echo esc_url( $future_image ); ?>" alt="<?php echo esc_html( $campaign['name'] ); ?>" class="campaign-card__img">
                                                    </div>
                                                    <div class="campaign-card__details"> 
                                                        <h4 class="campaign-card__title" data-toggle="tooltip" title="<?php echo esc_html( $campaign['name'] ); ?>">
                                                            <?php echo esc_html( $campaign['name'] ); ?>
                                                        </h4>
                                                        <!-- <p class="campaign-card__description">
                                                            <?php //echo strip_tags( SingleCampaignController::get_campaign_story( $campaign['story'], 20 ) ); ?>
                                                        </p> -->
                                                    </div>

                                                    <div class="campaign-card__footer">
                                                        <div class="progress progress--slim camp-type-<?php echo esc_attr( $campaign['type'] ); ?>">
                                                            <?php
                                                            if ( $campaign['type'] == 3 ) :
                                                                $width = 0;
                                                                if ( $campaign['raised_amount'] && $campaign['target_amount'] ) {
                                                                    $width = round( ( $campaign['raised_amount'] * 100 ) / $campaign['target_amount'] );
                                                                }
                                                                ?>
                                                                <div class="progress__bar progress__bar--secondary" style="width: <?php echo esc_attr( $width ); ?>%;"></div>
                                                                <?php
                                                            endif;
                                                            ?>
                                                        </div>

                                                        <p class="campaign-card__amount">
                                                            <strong>
                                                                <i class="fas fa-hand-holding-usd"></i>
                                                                <?php
                                                                echo SingleCampaignController::get_currency_format(
                                                                    $org_settings, $campaign, $campaign['formatted_raised_amount'], 'after'
                                                                );
                                                                ?>
                                                            </strong>
                                                            <?php
                                                            if ( $campaign['type'] == 3 ) {
                                                                printf( '%s %s', __('OF', 'crowdfundly'),
                                                                    SingleCampaignController::get_currency_format(
                                                                        $org_settings, $campaign, $campaign['formatted_target_amount'], 'after'
                                                                    )
                                                                );
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        endforeach;
                                        
										$crowdfundly_hide_all_camps_btn = get_theme_mod( 'cf_org_hide_btn', false );
										if ( $crowdfundly_hide_all_camps_btn != true ) :
										    ?>
                                            <div class="col-12 d-flex align-items-center justify-content-center org-all-campaign-btn-wrap">
                                                <a href="<?php echo esc_url( AllCampaignController::get_all_campaigns_permalink() ); ?>" class="btn btn-primary organization-all-camp-btn">
                                                    <?php _e( 'All Campaigns', 'crowdfundly' ); ?>
                                                </a>
                                            </div>
                                            <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endif;
                        ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
