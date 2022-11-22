<?php
namespace eptaFeedbackNotice;

if ( ! class_exists( 'eptaFeedbackNotice' ) ) {
	class eptaFeedbackNotice {
		/**
		 * The Constructor
		 */
		public function __construct() {
			// register actions
			if ( is_admin() ) {
				add_action( 'admin_notices', array( $this, 'epta_admin_notice_for_reviews' ) );
				add_action( 'admin_print_scripts', array( $this, 'epta_load_script' ) );
				add_action( 'wp_ajax_tecset_dismiss_notice', array( $this, 'epta_dismiss_review_notice' ) );
			}
		}

		/**
		 * Load script to dismiss notices.
		 *
		 * @return void
		 */
		public function epta_load_script() {
			wp_register_script( 'epta-feedback-notice-script', EPTA_PLUGIN_URL . 'assets/js/epta-admin-feedback-notice.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'epta-feedback-notice-script' );
			wp_register_style( 'epta-feedback-notice-styles', EPTA_PLUGIN_URL . 'assets/css/epta-admin-feedback-notice.css' );
			wp_enqueue_style( 'epta-feedback-notice-styles' );
		}
		// ajax callback for review notice
		public function epta_dismiss_review_notice() {
			$rs = update_option( 'tecset-ratingDiv', 'yes' );
			echo json_encode( array( 'success' => 'true' ) );
			exit;
		}
		// admin notice
		public function epta_admin_notice_for_reviews() {

			if ( ! current_user_can( 'update_plugins' ) ) {
				return;
			}
			 // get installation dates and rated settings
			 $installation_date = get_option( 'tecset-installDate' );
			 $alreadyRated      = get_option( 'tecset-ratingDiv' ) != false ? get_option( 'tecset-ratingDiv' ) : 'no';
			 // check user already rated
			if ( $alreadyRated == 'yes' ) {
				return;
			}

			// grab plugin installation date and compare it with current date
			$display_date = gmdate( 'Y-m-d h:i:s' );
			$install_date = new \DateTime( $installation_date );
			$current_date = new \DateTime( $display_date );
			$difference   = $install_date->diff( $current_date );
			$diff_days    = $difference->days;
			// check if installation days is greator then week
			if ( isset( $diff_days ) && $diff_days >= 3 ) {
				echo wp_kses_post( $this->epta_create_notice_content() );
			}
		}

		// generated review notice HTML
		function epta_create_notice_content() {

			$ajax_url           = admin_url( 'admin-ajax.php' );
			$ajax_callback      = 'tecset_dismiss_notice';
			$wrap_cls           = 'notice notice-info is-dismissible';
			$img_path           = EPTA_PLUGIN_URL . 'assets/images/epta-logo.png';
			$plugin_info        = get_plugin_data( EPTA_PLUGIN_FILE, true, true );
			$p_name             = $plugin_info['Name'];
			$like_it_text       = 'Rate Now! ★★★★★';
			$already_rated_text = esc_html__( 'I already rated it', 'esca' );
			$not_like_it_text   = esc_html__( 'Not Interested', 'cool-timeline' );
			$p_link             = esc_url( 'https://wordpress.org/support/plugin/event-page-templates-addon-for-the-events-calendar/reviews/#new-post' );
			$pro_url            = esc_url( 'https://eventscalendaraddons.com/' );

			$message = "Thanks for using <b>$p_name</b> - WordPress plugin. We hope it meets your expectations! <br/>Please give us a quick rating, it works as a boost for us to keep working on more <a href='https://coolplugins.net' target='_blank'><strong>Cool Plugins</strong></a>!<br/>";

			$html = '<div data-ajax-url="%8$s"  data-ajax-callback="%9$s" class="cool-feedback-notice-wrapper %1$s">
        <div class="logo_container"><a href="%5$s"><img src="%2$s" alt="%3$s"></a></div>
        <div class="message_container">%4$s
        <div class="callto_action">
        <ul>
            <li class="love_it"><a href="%5$s" class="like_it_btn button button-primary" target="_new" title="%6$s">%6$s</a></li>
            <li class="already_rated"><a href="#" class="already_rated_btn button tecset_dismiss_notice" title="%7$s">%7$s</a></li> 
            <li class="already_rated"><a href="#" class="already_rated_btn button tecset_dismiss_notice" title="%11$s">%11$s</a></li>                       
        </ul>
        <div class="clrfix"></div>
        </div>
        </div>
        </div>';

			return sprintf(
				$html,
				$wrap_cls,
				$img_path,
				$p_name,
				$message,
				$p_link,
				$like_it_text,
				$already_rated_text,
				$ajax_url, // 8
				$ajax_callback, // 9
				$pro_url, // 10
				$not_like_it_text
			);

		}

	} //class end

}



