<?php
$camp = $data['campaign'];
?>
<div id="crowdfundly-set-reminder-modal" class="g-modal">
	<div class="g-modal__inner top-center">
		<div id="set-reminder-modal-overlay" class="g-modal__overlay"></div>

		<div class="g-modal__content g-modal__content--sm undefined">
			<a id="set-reminder-modal-close-btn" class="g-modal__close-btn">x</a>
			
			<div class="g-modal__body">
				<div class="remind-modal">
					<form 
					id="reminder-form" 
					data-camp-id="<?php echo esc_attr( $camp['id'] ); ?>" 
					data-success-msg="<?php esc_attr_e( 'Reminder successfully set', 'crowdfundly' ); ?>"
					>
						<h5 class="remind-modal__title"><?php _e( 'Remind me later', 'crowdfundly' ); ?></h5>
						<p class="remind-modal__info-text"><?php _e( 'We will send you an email to reminding you to make contribution later. Select when should we remind you', 'crowdfundly' ); ?></p>
						<div class="remind-modal__options">
							<div class="remind-options">
								<div class="remind-option">
								<input type="hidden" name="campaign_id" value="<?php echo $camp['id']; ?>">
									<input type="radio" name="hours_after" id="reminder-0" checked="checked" class="remind-option__input" value="12">
									<label for="reminder-0" class="remind-option__inner">
										<span class="reminder__box-label-text text-center">
											<?php _e( '12', 'crowdfundly' ); ?>
											<br>
											<?php _e( 'Hours', 'crowdfundly' ); ?>
										</span>
									</label>
								</div>
								<div class="remind-option">
									<input type="radio" name="hours_after" id="reminder-1" checked="checked" class="remind-option__input" value="24">
									<label for="reminder-1" class="remind-option__inner">
										<span class="reminder__box-label-text text-center">
											<?php _e( '1', 'crowdfundly' ); ?>
											<br>
											<?php _e( 'DAY', 'crowdfundly' ); ?>
										</span>
									</label>
								</div>
								<div class="remind-option">
									<input type="radio" name="hours_after" id="reminder-2" checked="checked" class="remind-option__input" value="48">
									<label for="reminder-2" class="remind-option__inner">
										<span class="reminder__box-label-text text-center">
											<?php _e( '2', 'crowdfundly' ); ?>
											<br>
											<?php _e( 'DAYS', 'crowdfundly' ); ?>
										</span>
									</label>
								</div>
								<div class="remind-option">
									<input type="radio" name="hours_after" id="reminder-3" checked="checked" class="remind-option__input" value="72">
									<label for="reminder-3" class="remind-option__inner">
										<span class="reminder__box-label-text text-center">
											<?php _e( '3', 'crowdfundly' ); ?>
											<br>
											<?php _e( 'DAYS', 'crowdfundly' ); ?>
										</span>
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="receiver_email"><?php _e( 'Email Address', 'crowdfundly' ); ?></label>
							<input id="receiver_email" type="email" name="receiver_email" maxlength="100" placeholder="Enter email address" required="required" class="form-control">
						</div>

						<button type="submit" id="reminder-submit-btn" class="btn btn-primary btn-block btn-min-50 mt-4" value="submit"><?php _e( 'Remind me later', 'crowdfundly' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
