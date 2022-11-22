<div class="team-cap">
	<div class="team-cap__inner">
		<div class="team-cap__inner-checkbox" v-for="(grant, cap) in user_caps">
			<c-checkbox :id="cap" v-model="grant[1]" :checked="grant[1]" :label="grant[0]" />
		</div>
	</div>

	<div class="team-cap__wrap">
		<c-button
			class="team-cap__btn"
			@onpress="updateCaps()"
			title="<?php _e( 'Update', 'crowdfundly' ); ?>"
			:loading="processing"
		>
		</c-button>
	</div>
</div>
