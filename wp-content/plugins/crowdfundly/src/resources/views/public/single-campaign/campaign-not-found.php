<?php
use Crowdfundly\App\Controllers\AllCampaignController;
?>

<div id="public">
    <div class="content-wrapper template crowdfundly-single-camp">
        <div class="content-body">
            <div class="campaign">
                <div class="campaign__view">
                    <div class="container">
                        <h2 class="text-center mb-5">
                            <?php _e( 'Campaign not found', 'crowdfundly' ); ?>
                        </h2>

                        <div class="col-12 d-flex align-items-center justify-content-center org-all-campaign-btn-wrap pb-5">
                            <a href="<?php echo esc_url( AllCampaignController::get_all_campaigns_permalink() ); ?>" class="btn btn-primary organization-all-camp-btn">
                                <?php _e( 'All Campaigns', 'crowdfundly' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
