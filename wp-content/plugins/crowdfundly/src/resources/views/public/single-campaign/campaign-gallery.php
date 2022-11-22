<?php
use Crowdfundly\App\Controllers\SingleCampaignController;

$campaign = $data;
$gallery = [];
// if ( ! empty( $campaign['options']['gallery']['thumbnail'] ) ) {
// 	$thumbnail['url'] = $campaign['options']['gallery']['thumbnail'];
// 	$thumbnail['type'] = 'image';
// 	$gallery[] = $thumbnail;
// }

$media_items = $campaign['options']['gallery']['media'];
if ( ! empty( $media_items ) ) {
	foreach ( $media_items as $media ) {
		if ( ! isset( $media['type'] ) ) {
			$media['type'] = 'image';
		}
		$gallery[] = $media;
	}
}

if ( ! empty( $gallery ) ) :
	?>
	<div class="col-md-6">
		<div class="campaign__view-slider">
			<div class="main">
				<div class="slider gallery-slider">
					<?php
					foreach ( $gallery as $slide ) :
						?>
						<div class="slide">
							<div class="slide__inner">
								<?php
								if ( $slide['type'] == 'video' ) :
									if ( $slide['thumbnail'] ) :
										?>
										<div class="slide__bg" style="background-image: url(<?php echo esc_url( $slide['thumbnail'] ); ?>);"></div>
										<?php
									endif;
									?>
									<div class="v-player slide__iframe">
										<?php echo SingleCampaignController::render_slider_iframe( $slide['url'] ); ?>
									</div>
									<?php
								else:
									?>
									<div
									class="slide__bg"
									style="background-image: url(<?php echo esc_url( $slide['url'] ); ?>);"
									>
									</div>
									<img
									class="slide__img"
									src="<?php echo esc_url( $slide['url'] ); ?>"
									alt="<?php _e('Slider image', 'crowdfundly'); ?>"
									/>
									<?php
								endif;
								?>
							</div>
						</div>
						<?php
					endforeach;
					?>
				</div>

				<div class="cf-loaders" style="color:blue; width:80px;"></div>
				<div class="thumbnails slider gallery-slider-nav">
					<?php
					foreach ( $gallery as $slide ) :
						?>
						<div class="slide slide--thumbniail">
							<div class="slide__overlay"></div>
							<?php
							if ( $slide['type'] == 'video' ) :
								echo SingleCampaignController::render_slider_iframe( $slide['url'] );
							else:
								?>
								<img
								src="<?php echo esc_url( $slide['url'] ); ?>"
								alt="<?php echo esc_attr( 'Slider thumbniail' ); ?>" 
								/>
								<?php
							endif;
							?>
						</div>
						<?php
					endforeach;
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;
?>
<script>
	    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector(
              ".thumbnails").style.visibility = "hidden";
            document.querySelector(
              ".cf-loaders").style.visibility = "visible";
        } else {
            document.querySelector(
              ".cf-loaders").style.display = "none";
            document.querySelector(
              ".thumbnails").style.visibility = "visible";
        }
    };
</script>