<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$campaign = $data;

$active = '';
if ( empty( $campaign['packages'] ) ) {
	$active = 'active show';
}
// dump($campaign['options']['story']);
?>

<div class="tab-pane fade <?php echo esc_attr( $active ); ?>" id="story" role="tabpanel" aria-labelledby="story-tab">
	<div class="g-tab__index">
		<div class="editor-view" id="story_tab">
			<div class="cf-loader-wrap">
				<div class="cf-loader" style="color:blue; width:80px;"></div>
			</div>
		</div>
	</div>
</div>
