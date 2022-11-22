<?php
/*---------------------------------------------------
Add widget scripts
----------------------------------------------------*/

function TMEA_dashboard_scripts($hook) {
    if( 'index.php' != $hook ) {
		return;
    }
    wp_enqueue_style('TMEA-dashboard', TMEA_PLUGINS_URL . 'admin/css/style.css');
}
add_action( 'admin_enqueue_scripts', 'TMEA_dashboard_scripts' );

/**
 * Add a widget to the dashboard.
*/
function TMEA_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'tmea_dashboard_widget',
        esc_html__( 'TM Elementor Addons', 'theme-masters-elementor' ),
        'TMEA_add_dashboard_function'
    );	
}
add_action( 'wp_dashboard_setup', 'TMEA_add_dashboard_widget' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */

function TMEA_add_dashboard_function() {
    $current_version = TMEA_VERSION;
?>
<div id="tmea-dashboard-widget">
<?php TMEA_get_version($current_version); ?>
<h3><span class="dashicons dashicons-megaphone"></span> <?php esc_html_e( 'News & Updates', 'theme-masters-elementor' ); ?></h3>
 
<?php
include_once( ABSPATH . WPINC . '/feed.php' );
 
$rss = fetch_feed( 'https://www.thememasters.club/feed/' );
 
if ( ! is_wp_error( $rss ) ) :
 
    $maxitems = $rss->get_item_quantity( 5 );
    $rss_items = $rss->get_items( 0, $maxitems );
 
endif;
?>
 
<ul>
    <?php if ( $maxitems == 0 ) : ?>
        <li><?php esc_html_e( 'No items', 'theme-masters-elementor' ); ?></li>
    <?php else : ?>
        <?php foreach ( $rss_items as $item ) : ?>
            <li>
                <a href="<?php echo esc_url( $item->get_permalink() ); ?>">
                    <?php echo esc_html( $item->get_title() ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
</div>   
<?php
}
/**
 * 
 * Version Check
 * 
 */

function TMEA_get_version($current_version) {
    if( current_user_can('administrator') ) {
        $request = wp_remote_get( 'http://thememasters.club/edd-api/products?product=1286' );
        if( is_wp_error( $request ) ) {
            return false; // Bail early
        }

        $body = wp_remote_retrieve_body( $request );

        $data = json_decode( $body, true );
        $latest_version = floatval($data['products'][0]['info']['version']);
        $changelog = '<div style="padding:20px;">' . $data['products'][0]['info']['changelog'] . '<div style="height:60px;"></div></div>';

        if ($current_version < $latest_version) { ?>
        <p><?php echo esc_html__( 'Current version:', 'theme-masters-elementor' ) . ' ' . $current_version; ?></p>
        <p class="tmea-text-warning"><strong><?php echo esc_html__( 'Latest version:', 'theme-masters-elementor' ) . ' ' . $latest_version; ?></strong></p>
        <div class="tmea-notice tmea-notice-warning">
            <?php echo esc_html__( 'There is a new update available! You can download the latest version from your Codecanyon account. To update the plugin, just install the latest version and replace it with the old version. You will not lose any data.', 'theme-masters-elementor' ); ?>
        </div>    
        <?php } else { ?>
            <div class="tmea-notice tmea-notice-info">
                <?php echo esc_html__( 'The plugin is up to date.', 'theme-masters-elementor' ); ?>
            </div>  
        <?php } ?>
        <?php add_thickbox(); ?>
        <div id="tmea-changelog" style="display:none;">
            <?php echo $changelog; ?>
        </div>
        <style>#TB_window {min-width:800px!important;}</style>
        <div class="tmea-changelog">
        <a href="#TB_inline?&inlineId=tmea-changelog" title="<?php echo esc_attr__( 'Changelog', 'theme-masters-elementor' ); ?>" class="thickbox"><?php echo esc_html__( 'View Changelog', 'theme-masters-elementor' ); ?></a>	
        </div>
    <?php }
}