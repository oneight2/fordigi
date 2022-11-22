<?php

use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\SingleCampaignController;
use Crowdfundly\App\Helpers\DBAccessor;

$org_settings = $data['org_settings'];
$campaign = $data['campaign'];
$gallery = $campaign['options']['gallery']['media'];
?>

<div class="col-md-6"> 
	<div class="campaign__details">
		<h1 class="campaign__title campaign__title--status">
			<?php echo esc_html( $campaign['name'] ); ?>
		</h1>
		<?php if( ! empty(wp_get_current_user()->roles) ): ?>
		<div class="campaign__status">
			<?php $status = SingleCampaignController::donation_status(  $campaign['status'] ); ?>
			<span class="campaign__status-title status-<?php echo strtolower( esc_attr( $status ) ); ?> mr-2">
				<i class="fas fa-circle campaign__status-title-icon"></i>
				<?php echo esc_html( $status ); ?>
			</span>
		</div>
		<?php endif; ?>
		<?php
		$org = DBAccessor::getItem( 'organization' );
		if ( $org ) :
			?>
			<div class="campaign__fundraiser">
				<p class="campaign__fundraiser-name">
					<?php echo __( 'by', 'crowdfundly' ); ?> 
					<a
					href="<?php echo esc_url( OrganizationController::get_organization_permalink() ); ?>"
					class="campaign__fundraiser-name-link"
					>
						<?php echo esc_html( $org['name'] ); ?>
					</a>
				</p>
			</div>
			<?php
		endif;
		?>

		<div class="campaign__funding">
			<div class="campaign__funding-row">
				<?php
				if ( $campaign['type'] == 3 ) :
					?>
					<div class="campaign__funding-item">
						<div class="funding-card funding-goal">
							<h5 class="funding-card__value">
								<?php echo esc_html( SingleCampaignController::get_currency_format( $org_settings, $campaign, $campaign['formatted_target_amount'] ) ); ?>
							</h5>
							<p class="funding-card__lavel">
								<?php _e( 'Funding Goal', 'crowdfundly' ); ?>
							</p>
						</div>
					</div>
					<?php
				endif;
				?>
				<div class="campaign__funding-item">
					<div class="funding-card fund-raised">
						<h5 class="funding-card__value">
							<?php echo esc_html( SingleCampaignController::get_currency_format( $org_settings, $campaign, $campaign['formatted_raised_amount'] ) ); ?>
						</h5>
						<p class="funding-card__lavel">
							<?php _e( 'Funds Raised', 'crowdfundly' ); ?>
						</p>
					</div>
				</div>

				<?php
				if ( $campaign['type'] !== 1 && isset( $campaign['validity_countdown_days'] ) ) :
					?>
					<div class="campaign__funding-item">
						<div class="funding-card funding-duration">
							<h5 class="funding-card__value">
								<?php echo esc_html( $campaign['validity_countdown_days'] ); ?>
							</h5>
							<p class="funding-card__lavel">
								<?php _e( 'Days to Go', 'crowdfundly' ); ?>
							</p>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>

		<?php
		if ( $campaign['type'] == 3 ) :
			?>
			<div class="campaign__progress">
				<div class="progress progress--sm camp-type-<?php echo esc_attr( $campaign['type'] ); ?>">
					<?php
					$width = 0;
					if ( $campaign['raised_amount'] && $campaign['target_amount'] ) {
						$width = ( $campaign['raised_amount'] * 100 ) / $campaign['target_amount'];
					}
					?>
					<div class="progress__bar progress__bar--secondary" style="width: <?php echo esc_attr( $width . '%' ); ?>"></div>
				</div>
			</div>
			<?php
		endif;
		?>

		<div class="campaign__actions">
			<?php
			$crowdfundly_settings = get_option( 'crowdfundly_settings', null );
			// dump($crowdfundly_settings);
			$button_default_text = __( 'Contribute', 'crowdfundly' );
			$btn_id = null;
			
			$is_public = SingleCampaignController::campaign_donation_status($campaign);
			$donation_status = ( $is_public == false ) ? 'disabled' : '';
			// dd($donation_status);
			$donation_type = '';
			if ( $campaign['type'] == 1 ) $donation_type = 'donation';
			if ( $campaign['type'] == 2 ) $donation_type = 'crowdfunding';
			if ( $campaign['type'] == 3 ) $donation_type = 'reward';

			if ( $campaign['type'] != 2 ) :
				?>
				<button
				<?php echo esc_attr( $donation_status ); ?>
				id="<?php //echo esc_attr( $btn_id ); ?>"
				type="button"
				class="btn btn-primary btn-block campaign__actions-btn donation-btn"
				data-donation-type="<?php echo esc_attr( $donation_type ); ?>"
				>
					<?php echo esc_html( get_theme_mod( 'cf_single_campn_donation_btn_texts', $button_default_text ) ); ?>
				</button>
				<?php
			else:
				?>
				<div class="sponsor-btn-wrap">
					<button
					<?php echo esc_attr( $donation_status ); ?>
					id="cf-sponsor-support"
					type="button"
					class="btn btn-primary btn-block campaign__actions-btn sponsor-btn"
					>
						<?php _e( 'Support', 'crowdfundly' ); ?>
					</button>

					<?php
					if ( ! empty( $campaign['packages'] ) ) :
						?>
						<button
						<?php echo esc_attr( $donation_status ); ?>
						id="cf-sponsor-membership"
						type="button"
						class="btn btn-primary btn-block campaign__actions-btn sponsor-btn"
						>
							<?php _e( 'Membership', 'crowdfundly' ); ?>
						</button>
						<?php
					endif;
					?>
				</div>
				<?php
			endif;
			?>
		</div>

		<div class="campaign__actions-row">
			<button id="share-campaign-btn" class="btn btn-outline btn-outline-primary campaign__actions-btn">
				<?php _e( 'Share', 'crowdfundly' ); ?>
			</button>
			<button id="set-reminder-btn" class="btn btn-outline btn-outline-primary campaign__actions-btn"><?php _e( 'Set Reminder', 'crowdfundly' ); ?></button>
		</div>
	</div>
</div>
