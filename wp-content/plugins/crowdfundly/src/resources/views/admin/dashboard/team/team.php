<?php
use Crowdfundly\App\Controllers\TeamController;
?>

<div id="crowdfundly-team" class="main-wrapper">
    <layout-dashboard>
		<div class="team">
			<page-header title="<?php _e( 'Team & Roles', 'crowdfundly' ); ?>"></page-header>
			
			<div class="team__btn">
				<c-button
					class="team__btn__add-role"
					@onpress="popUp()"
					title="<?php _e( 'Assign Role', 'crowdfundly' ); ?>"
				/>
			</div>

			<vue-advance-dialog id="dialog" toggleTitle="Show Dialog">
				<?php cf_loadViewTemplate( 'admin/dashboard/team/add-role-popup.php' ); ?>
			</vue-advance-dialog>

			<?php
			$users = TeamController::get_cf_users();
			if ( ! empty( $users ) ) :
				?>
				<table
					is="c-data-table"
					id="team-member-list"
					:headers="headers"
					class="team__table"
				>
					<?php
					foreach ( $users as $id => $user ) :
						?>
						<tr>
							<td>
								<?php echo esc_html( $user['name'] ); ?>
							</td>
							<td>
								<?php echo esc_html( $user['role'] ); ?>
							</td>
							<td>
								<?php
								$current_user = TeamController::$wp_current_user;
								if ( $current_user && $current_user->ID !== $id ) :
									?>
									<div class="team__table__btn-wrap">
										<a
										class="team__table__edit-cap"
										title="<?php echo esc_attr__( 'Edit Capabilities', 'crowdfundly' ); ?>"
										@click.prevent="editCap(<?php echo esc_attr( $id ); ?>)"
										>
											<img src="<?php echo cf_asset( 'images/admin/icons/settings.svg' ); ?>" alt="">
										</a>
										<a
										class="team__table__delete-role"
										title="<?php echo esc_attr__( 'Remove Crowdfundly Role', 'crowdfundly' ); ?>"
										@click.prevent="deleteRole(<?php echo esc_attr( $id ); ?>)"
										:data-user-id="<?php echo esc_attr( $id ); ?>"
										>
											<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAOVBMVEUAAAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAD/AAAAAADuZEZFAAAAEXRSTlMAH7z0uyLkJbrz8ucp4yQg33ZEai0AAAABYktHRACIBR1IAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAB3RJTUUH5AULByUMuupxDAAAAShJREFUWMOtl9kWgyAMRMG1G7b8/8/Wo1VBWZKZ+uRD5poDyZgY27Rdb6Cnn6XWNN77YUT04zBLb+buQcKi948lA4Sw6ucM+gEi/PRDv78+X4B+FQGEk0RNuAiUhES4ipAMVhAyoWJCNlBIKISJCMUgAaESUiWwAWyKskNy3CEbMznumrMERakmCapmSRCU7XohqA3jRAAsKyJAphkQIH1AAPWH8WO/jSAH8PsxAdMb8/6sejdh+u0Y4AQ2PUo49BiBvca9fiYH5RDUH0SI6hcgnOpfTbj0j5KQ6D8VIdm/CkKm/8WErH8ICQX/ERGK/iUgVPyvSqj6Z4Ug8N+Jnx/IIY0fE/lBlR+V+WGdXxf4hYVfmSIRvfbRi+dfVl9q+bZde0PX/1lqv3ZfOK+N7xmZAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA1LTExVDA3OjM3OjEyKzAwOjAwRqDbDQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wNS0xMVQwNzozNzoxMiswMDowMDf9Y7EAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC" alt="">
										</a>
									</div>
									<?php
								endif;
								?>
							</td>
						</tr>
						<?php
					endforeach;
					?>
				</table>
				<?php
			endif;
			?>

			<vue-advance-dialog id="editCap" toggleTitle="Show Dialog">
				<?php cf_loadViewTemplate( 'admin/dashboard/team/edit-cap-popup.php' ); ?>
			</vue-advance-dialog>

		</div>
	</layout-dashboard>
</div>

<script>
const table_head = crowdfundlyAuth.team.table_head;

let team = new Vue({
	el: '#crowdfundly-team',
	data() {
		return {
			wpUser: '',
			wpUserId: '',
			userRole: '',
			user_caps: [],
			processing: false,
			headers: [
				{text: table_head.name, sortable: true, sortKey: 'name'},
				{text: table_head.role, sortable: false},
				{text: table_head.action, sortable: false},
			]
		}
	},
	methods: {
		popUp() {
			this.$eventHub.$emit('show-dialog',  'dialog')
		},
		addRole() {
			this.processing = true;
			const bodyParams = {
				action: 'action=cf_add_role',
				nonce: '&security=' + crowdfundlyAuth.nonce,
				wp_user: '&cf_wp_user=' + this.wpUser,
				user_role: '&cf_role=' + this.userRole,
			}

			this.$axios.post(
				crowdfundlyAuth.ajax_url,
				bodyParams.action + bodyParams.nonce + bodyParams.wp_user + bodyParams.user_role,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
			)
			.then(async res => {
				setTimeout(() => {
					this.processing = false;
					this.$redirect('team-roles')
				}, 300);
			})
			.catch(error => {
				console.log('err::', error);
			})
		},
		deleteRole(wpUserId) {
			console.log('wpUserId::', this.wpUserId);
			const bodyParams = {
				action: 'action=cf_delete_role',
				nonce: '&security=' + crowdfundlyAuth.nonce,
				wp_user: '&cf_wp_user=' + wpUserId
			}

			this.$axios.post(
				crowdfundlyAuth.ajax_url,
				bodyParams.action + bodyParams.nonce + bodyParams.wp_user,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
			)
			.then(async res => {
				console.log('res', res)
				setTimeout(() => {
					this.$redirect('team-roles')
				}, 300);
			})
			.catch(error => {
				console.log('err::', error);
			})
		},
		editCap(userID) {
			this.user_caps = []
			this.wpUserId = userID;
			console.log(this.wpUserId)
			this.getCaps(userID)
			this.$eventHub.$emit('show-dialog',  'editCap')
		},
		getCaps(userID) {
			const bodyParams = {
				action: 'action=cf_get_user_caps',
				nonce: '&security=' + crowdfundlyAuth.nonce,
				app_key: '&user_id=' + userID,
			}

			this.$axios.post(
				crowdfundlyAuth.ajax_url,
				bodyParams.action + bodyParams.nonce + bodyParams.app_key,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
			)
			.then(async res => {
				console.log('res', res)
				this.user_caps = res.data
			})
			.catch(error => {
				console.log('err::', error);
			});
		},
		updateCaps() {
			this.processing = true;
			const bodyParams = {
				action: 'action=cf_update_caps',
				nonce: '&security=' + crowdfundlyAuth.nonce,
				user_id: '&user_id=' + this.wpUserId,
				caps: '&caps=' + JSON.stringify(this.user_caps)
			}

			this.$axios.post(
				crowdfundlyAuth.ajax_url,
				bodyParams.action + bodyParams.nonce + bodyParams.user_id + bodyParams.caps,
				{headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
			)
			.then(async res => {
				if (res.status === 200) {
					this.processing = false;
					this.$redirect('team-roles')
				}
			})
			.catch(error => {
				console.log('err::', error);
			});
		}
	}
});
</script>
