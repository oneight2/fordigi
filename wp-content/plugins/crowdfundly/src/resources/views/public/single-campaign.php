<?php

use Crowdfundly\App\Controllers\SingleCampaignController;

// data comes from the SingleCampaignController
$campaign = $data['campaign'];
$camp_story = $campaign['options']['story'];
$activities = $data['activities'];
$updates = $data['updates'];
$endorsements = $data['endorsements'];
$top_contributors = $data['top_contributors'];
$notification = $data['notification'];
$gateways = $data['gateways'];
$settings = $data['settings'];
$org_settings = $data['org_settings'];
//Test Data
$similar_camps = $data['similar_camps'];

$crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_single_camp', '' );
// dump($campaign);

$donation_status = 'disabled';
$donation_status = SingleCampaignController::campaign_donation_status($campaign);
$donation_status = ( $donation_status == false ) ? 'disabled' : '';

// dump($similar_camps);
?>
<div id="public">
    <div class="content-wrapper template crowdfundly-single-camp">
        <div class="content-body">
            <div class="campaign">
                <div class="campaign__view">
                    <div class="container">
                        <?php
                        if ( $notification ) :
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php echo esc_html( $notification ); ?>
                            </div>
                            <?php 
                        endif;
                        ?>

                        <div class="g-section cf-camp-header cf-show">
                            <?php
                            $gallery = $campaign['options']['gallery']['media'];
                            $alignment = empty( $gallery ) ? 'justify-content-center' : '';
                            if ( ! isset( $_GET['stripe_key'] ) && (! isset( $_GET['token'] ) && ! isset( $_GET['PayerID'] )) && ! isset( $_GET['razorpay_key'] )) :
                                ?>
                                <div class="row <?php echo esc_attr( $alignment ); ?>">
                                    <?php
                                    cf_loadViewTemplate( 'public/single-campaign/campaign-gallery.php', $campaign );
                                    cf_loadViewTemplate(
                                        'public/single-campaign/campaign-detail.php',
                                        [ 'campaign' => $campaign, 'org_settings' => $org_settings ]
                                    );
                                    ?>
                                </div>
                                <?php
                            elseif ( isset( $_GET['stripe_key'] ) || (isset( $_GET['token'] ) && isset( $_GET['PayerID'] )) || isset( $_GET['razorpay_key'] )) :
                                ?>
                                <div class="row justify-content-center">
                                    <?php
                                    cf_loadViewTemplate(
                                        'public/single-campaign/form/after-donation.php',
                                        [
                                            'campaign' => $campaign
                                        ]
                                    );
                                    ?>
                                </div>
                                <?php
                            endif;

							cf_loadViewTemplate( 'public/single-campaign/share-modal.php',
                                [
                                    'campaign' => $campaign,
                                ]
                            );
							cf_loadViewTemplate( 'public/single-campaign/set-reminder.php',
                                [
                                    'campaign' => $campaign,
                                ]
                            );
							?>
                        </div>

                        <div class="g-section cf-donation-form">
                            <?php
                            cf_loadViewTemplate(
                                'public/single-campaign/form/simple-donation.php',
                                [
                                    'campaign' => $campaign,
                                    'gateways' => $gateways,
                                    'settings' => $settings,
                                ]
                            );
                            ?>
                        </div>

                        <div class="g-section">
                            <div class="campaign__view-tab">
                                <div class="g-tab">
                                    <ul class="nav nav-tabs g-tab__nav" id="campaignTab" role="tablist">

                                        <?php
                                        $camp_type = $campaign['type'] == 2 || $campaign['type'] == 3;
                                        if ( ! empty( $campaign['packages'] ) ) :
                                            ?>
                                            <li class="nav-item g-tab__nav-item active">
                                                <a
                                                class="nav-link<?php echo esc_attr( ' active' ); ?>"
                                                id="select-reward-tab"
                                                data-toggle="tab"
                                                data-target="#select-reward"
                                                role="tab"
                                                aria-controls="select-reward"
                                                aria-selected="false">
                                                    <button type="button" class="btn btn-primary">
                                                        <?php _e( 'Select a Package', 'crowdfundly' ); ?>
                                                    </button>
                                                </a>
                                            </li>
                                            <?php
                                        endif;
                                        ?>

                                        <?php
                                            if ( $camp_story ) :
                                                ?>
                                                <li class="nav-item g-tab__nav-item">
                                                    <a
                                                    class="nav-link <?php echo esc_attr( empty( $campaign['packages']) ? 'active': '' ); ?>"
                                                    id="story-tab"
                                                    data-toggle="tab"
                                                    data-target="#story"
                                                    role="tab"
                                                    aria-controls="story"
                                                    aria-selected="true">
                                                            <?php _e( 'Campaign story', 'crowdfundly' ); ?><span>
                                                    </a>
                                                </li>
                                                <?php
                                            endif;

                                        // $tab_class = '';
                                        // if ( ! $camp_story ) {
                                        //     $tab_class = ' active';
                                        // }
                                        $active_tab_class = '';
                                        ?>
                                        <li class="nav-item g-tab__nav-item">
                                            <a
                                            class="nav-link <?php echo esc_attr( empty( $campaign['packages']) && empty($camp_story) ? 'active': '' ); ?>"
                                            id="updates-tab"
                                            data-toggle="tab"
                                            data-target="#updates"
                                            role="tab"
                                            aria-controls="updates"
                                            aria-selected="<?php echo $active_tab_class ? 'true' : 'false'; ?>">
                                                <?php _e('Updates', 'crowdfundly'); ?> 
                                                <span class="pl-1">
                                                    (<?php
                                                    $updates_total = isset( $updates['total'] ) ? $updates['total'] : 0;
                                                    echo esc_html( $updates_total );
                                                    ?>)
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="activities-tab" data-toggle="tab" data-target="#activities" role="tab" aria-controls="activities" aria-selected="false">
                                               <?php _e('Activities', 'crowdfundly'); ?>
                                               <span class="pl-1">
                                                   (<?php
                                                   $activities_total = isset( $activities['total'] ) ? $activities['total'] : 0;
                                                   echo esc_html( $activities_total );
                                                   ?>)
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="endorsements-tab" data-toggle="tab" data-target="#endorsements" role="tab" aria-controls="endorsements" aria-selected="false">
                                                <?php _e( 'Endorsements', 'crowdfundly' ); ?>
                                                <span class="pl-1">
                                                    (<?php
                                                   $endorsements_total = isset( $endorsements['data'] ) ? $endorsements['data']['total'] : 0;
                                                   echo esc_html( $endorsements_total );
                                                   ?>)
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="top-contributors-tab" data-toggle="tab" data-target="#top-contributors" role="tab" aria-controls="top-contributors" aria-selected="false">
                                                <?php _e( 'Top Contributors', 'crowdfundly' ); ?>
                                            </a>
                                        </li>

                                        <?php
                                        if ( ! empty( $campaign['rewards'] ) && $campaign['type'] == 3 ) :
                                            ?>
                                            <li class="nav-item g-tab__nav-item active">
                                                <a class="nav-link" id="select-reward-tab" data-toggle="tab" data-target="#select-reward" role="tab" aria-controls="select-reward" aria-selected="false">
                                                    <button type="button" class="btn btn-primary">
                                                        <?php _e( 'Select a Reward', 'crowdfundly' ); ?>
                                                    </button>
                                                </a>
                                            </li>
                                            <?php
                                        endif;
                                        ?>
                                    </ul>

                                    <div class="tab-content g-tab__body" id="campaignTabContent">
										<?php
                                        if ( $campaign['type'] == 2 && ! empty( $campaign['packages'] ) ) {
                                            cf_loadViewTemplate(
                                                'public/single-campaign/campaign-package.php',
                                                [ 'campaign' => $campaign, 'org_settings' => $org_settings ]
                                            );
                                        }
                                        
                                        if ( $camp_story ) {
                                            cf_loadViewTemplate(
                                                'public/single-campaign/campaign-story-tab.php',
                                                $campaign
                                            );
                                        }

                                        cf_loadViewTemplate(
                                            'public/single-campaign/campaign-updates-tab.php',
                                            [ 'campaign' => $campaign, 'updates' => $updates ]
                                        );
                                        cf_loadViewTemplate(
                                            'public/single-campaign/campaign-activites-tab.php',
                                            [
                                                'activities' => $activities,
                                                'campaign' => $campaign,
                                                'org_settings' => $org_settings,
                                            ]
                                        );
                                        cf_loadViewTemplate(
                                            'public/single-campaign/campaign-endorsments-tab.php',
                                            [ 'endorsements' => $endorsements ]
                                        );
                                        cf_loadViewTemplate(
                                            'public/single-campaign/campaign-top-contributers.php',
                                            [
                                                'top_contributors' => $top_contributors,
                                                'campaign' => $campaign,
                                                'org_settings' => $org_settings,
                                            ]
                                        );

                                        if ( $campaign['type'] == 3 && ! empty( $campaign['rewards'] ) ) {
                                            cf_loadViewTemplate(
                                                'public/single-campaign/campaign-reward.php',
                                                [ 'campaign' => $campaign, 'org_settings' => $org_settings ]
                                            );
                                        }
										?>
                                    </div>
                                </div>
                            </div>
                        </div>

						<?php
                        // reward
                        if ( $campaign['type'] == 3 ) {
                            cf_loadViewTemplate(
                                'public/single-campaign/modal/campaign-reward-modal.php',
                                [ 'campaign' => $campaign, 'org_settings' => $org_settings ]
                            );
                        }
                        // package
                        if ( $campaign['type'] == 2 ) {
                            cf_loadViewTemplate(
                                'public/single-campaign/modal/campaign-package-modal.php',
                                [ 'campaign' => $campaign, 'org_settings' => $org_settings ]
                            );
                        }

                        if ( ! empty( $similar_camps ) ) {
							cf_loadViewTemplate( 'public/single-campaign/campaign-similar-camp.php',
                                [ 
                                    'similar_camps' => $similar_camps, 
                                    'campaign' => $campaign,
                                    'org_settings' => $org_settings 
                                ] 
                            );
						}
						?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
