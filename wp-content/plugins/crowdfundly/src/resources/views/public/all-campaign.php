<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_all_camps', '' );

// data comes from the AllCampaignController
// data comes from public/all-campaign.php
$campaigns = $data['campaign']['data'];
$org_settings = $data['org_settings'];
// var_dump($data['campaign']['meta']['last_page']);
$last_page = 0;
if ( ! empty( $campaigns ) ) {
    $last_page = $data['campaign']['meta']['last_page'];
    $total_cam = $data['campaign']['meta']['total'];
   
}

?>
<div id="public">
    <div class="content-wrapper template all-camps">
        <div class="content-body">
            <div class="all-campaign">
                <div class="container">
                    <?php
                    $crowdfundly_all_camp_hide_search_bar = get_theme_mod( 'cf_all_camp_hide_search_bar', false );
                    if ( $crowdfundly_all_camp_hide_search_bar != true ) :
                        cf_loadViewTemplate('public/all-campaigns/all-camp-header.php');
                    endif;
                    ?>

                    <div class="all-campaign__inner">    
                        <?php
                        cf_loadViewTemplate(
                            'public/all-campaigns/camp-loop.php',
                            [
                                'campaigns'     => $campaigns,
                                'last_page'     => $last_page,
                                'org_settings'  => $org_settings,
                                'total'         => $total_cam 
                            ]
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
