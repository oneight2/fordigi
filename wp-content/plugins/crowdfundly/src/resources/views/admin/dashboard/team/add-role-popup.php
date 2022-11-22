<?php
use Crowdfundly\App\Controllers\TeamController;

// $users = TeamController::get_wp_users();
// if ( ! empty( $users ) ) {
// 	foreach ( $users as $id => $user ) :
// 		dump($user);
// 	endforeach;
// }
?>

<div class="team__assign-role">
	<div class="team__assign-role__inner">
		<select v-model="wpUser">
			<option value=""><?php _e( 'Select User', 'crowdfundly' ); ?></option>
			<?php
			$users = TeamController::get_wp_users();
			if ( ! empty( $users ) ) :
				foreach ( $users as $id => $user ) :
				?>
				<option value="<?php echo esc_attr( $id ); ?>">
					<?php echo esc_html( $user ); ?>
				</option>
				<?php
				endforeach;
			endif;
			?>
		</select>

		<select v-model="userRole">
			<option value=""><?php _e( 'Select Role', 'crowdfundly' ); ?></option>
			<?php
			$roles = TeamController::get_cf_roles();
			if ( ! empty( $roles ) ) :
				foreach ( $roles as $key => $role ) :
				?>
				<option value="<?php echo esc_attr( $key ); ?>">
					<?php echo esc_html( $role ); ?>
				</option>
				<?php
				endforeach;
			endif;
			?>
		</select>
	</div>

	<div class="team__assign-role__wrap">
		<c-button
			class="team__assign-role-btn"
			@onpress="addRole()"
			title="<?php _e( 'Assign', 'crowdfundly' ); ?>"
			:loading="processing"
		>
		</c-button>
	</div>
</div>
