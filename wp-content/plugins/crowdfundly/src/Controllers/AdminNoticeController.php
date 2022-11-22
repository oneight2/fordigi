<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\Singleton;

/**
 * Class for creating admin panel notices.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.1.1
 */
class AdminNoticeController extends BaseController
{
    use Singleton;

    private $notices = [];

    public function __construct()
    {
        $this->remove_third_party_notices();

        if ( ! get_option( 'crowdfundly_intro_notice' ) ) {
            $this->make( [ $this, 'intro_notice' ] );
        }
    }

    public function register()
    {
        if ( count( $this->notices ) > 0 ) {
            foreach ( $this->notices as $notice ) {
                add_action( 'admin_notices', $notice );
            }
        }

        cf_wp_ajax( 'cf_dismiss_notice', [ $this, 'dismiss_notice' ] );
    }

    public function make($callback)
    {
        $this->notices[] = $callback;
    }

    public function intro_notice()
    {
        $this->render( 'admin/notice/intro.php' );
    }

    public function dismiss_notice()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_global_nonce', 'security' );
        if ( false == $security ) return;

        $option = isset( $_GET['option_key'] ) ? esc_html( $_GET['option_key'] ) : null;
        $option ? add_option( $option, true ) : null;
        
        wp_send_json( [ 'status' => 'dismissed' ] );
        wp_die();
    }

    /**
     * Remove third party notices on Crowdfundly admin dashboard.
     *
     * @return void
     */
    public function remove_third_party_notices()
    {
        $page = isset( $_GET['page'] ) ? esc_html( $_GET['page'] ) : null;
        if ( ! $page && ! cf_is_dashboard( $page ) ) return;

        add_action(
            'in_admin_header',
            function() {
                remove_all_actions( 'user_admin_notices' );
                remove_all_actions( 'admin_notices' );
            },
            99
        );
    }

}
