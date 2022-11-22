<?php
/**
 * Elementor Config File
 */

/**
* Module List
*/	
function TMEA_get_module_list() {
    $TMEA_module_list = apply_filters('TMEA_modules',array( 
        "heading",
        "button", 
        "dropdown_button", 
        "smart_menu", 
        "accordion",
        "tabs",
        "table",
        "slider",
        "post_slider",
        "post_masonry",
        "post_carousel",
        "post_list",
        "post_timeline",
        "news_ticker",
        "share",
        "search_form",
        "photo_gallery",
        "gallery_slider",
        "banner",
        "portfolio_grid",
        "team_member",
        "team_carousel",
        "team_masonry",
        "price_table",
        "price_menu",
        "flip_box",
        "logo_grid",
        "site_logo",
        "testimonial",
        "testimonial_carousel",
        "business_hours",
        "login_form",
        "image_compare",
        "countdown",
        "counter",
        "piechart",
        "progress_bar",
        "text_rotator",
        "timeline",
        "qrcode",
        "shape",
        "tooltip",
        "statistics",
        "youtube_tv",
        "sticky_video",
        "scroll_nav",
        "weather",
        "bar_chart",
        "line_chart",
        "doughnut_chart",
        "radar_chart",
        "polar_area_chart",
        "pdf_viewer"
    ));
        
    // Check Contact Form 7 Plugin
    if ( class_exists( "WPCF7" ) ){
        array_push($TMEA_module_list, 'contact_form_7');
    }

    // Check bbpress Plugin
    if (class_exists( 'bbPress' )) {
        array_push($TMEA_module_list, 'bbpress_form');
        array_push($TMEA_module_list, 'bbpress_content');
        array_push($TMEA_module_list, 'bbpress_search');
    }

    // Check WooCommerce Plugin
    if (class_exists( 'woocommerce' )) {
        array_push($TMEA_module_list, 'woo_slider');
        array_push($TMEA_module_list, 'woo_masonry');
        array_push($TMEA_module_list, 'woo_carousel');
        array_push($TMEA_module_list, 'woo_table');
        array_push($TMEA_module_list, 'woo_gallery');
        array_push($TMEA_module_list, 'woo_button');
    }

    foreach ( $TMEA_module_list as $module_name) {
        if (function_exists('TMEA_get_option') && TMEA_get_option($module_name)) {
            $TMEA_module_list = array_diff($TMEA_module_list, array($module_name));
        }
    }

    return $TMEA_module_list;
 
}
add_action( "elementor/widgets/widgets_registered", "TMEA_get_module_list", 10, 1 );

/**
* Include Controls
*/	
function TMEA_controls() {
    require_once( TMEA_ABSPATH . '/includes/controls/fileselect-control.php' );
    \Elementor\Plugin::$instance->controls_manager->register_control( 'tmea-file-select', new \TMEA_FileSelect_Control() );
}

add_action( 'elementor/controls/controls_registered', 'TMEA_controls' );

/**
* Include Widgets
*/	
function TMEA_widgets() {
    foreach ( TMEA_get_module_list() as $module_name) {
        include( TMEA_ABSPATH . "/includes/widgets/".$module_name.".php" );
    }
}
add_action( "elementor/widgets/widgets_registered", "TMEA_widgets", 10, 1 );

/**
* Register CSS Files
*/	
function TMEA_css(){

    $suffix = ( defined( 'WPBT_SCRIPT_DEBUG' ) && WPBT_SCRIPT_DEBUG ) ? '' : '.min';
    
    // lib files
    wp_register_style('tme-lib-masonry' , TMEA_PLUGINS_URL . 'assets/css/library/masonry'.$suffix.'.css', false, TMEA_VERSION );
    wp_register_style('tme-lib-lightbox' , TMEA_PLUGINS_URL . 'assets/css/library/featherlight'.$suffix.'.css', false, TMEA_VERSION );
    wp_register_style('tme-lib-animate' , TMEA_PLUGINS_URL . 'assets/css/library/animate'.$suffix.'.css', false, TMEA_VERSION );
    wp_register_style('tme-lib-slick' , TMEA_PLUGINS_URL . 'assets/css/library/slick'.$suffix.'.css', false, TMEA_VERSION );
    wp_register_style('tme-lib-table' , TMEA_PLUGINS_URL . 'assets/css/library/table'.$suffix.'.css', false, TMEA_VERSION );

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_parallax_bg')) {
        wp_enqueue_style('tmea-parallax-bg' , TMEA_PLUGINS_URL . 'assets/css/library/parallax-bg'.$suffix.'.css', false, TMEA_VERSION );
    }

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_gradient_bg_anim')) {
        wp_enqueue_style('tmea-gradient-bg-anim' , TMEA_PLUGINS_URL . 'assets/css/library/gradient-bg'.$suffix.'.css', false, TMEA_VERSION );
    }

    // frontend
    wp_enqueue_style('tme-lib-frontend' , TMEA_PLUGINS_URL . 'assets/css/frontend'.$suffix.'.css', false, TMEA_VERSION );
        
    // widget files
    foreach (  TMEA_get_module_list() as $module_name) {
        $file = TMEA_PLUGIN_DIR_PATH . 'assets/css/'.$module_name.''.$suffix.'.css';
        if( file_exists($file) ){
            wp_register_style('tme-'. $module_name , TMEA_PLUGINS_URL . 'assets/css/'.$module_name.''.$suffix.'.css', false, TMEA_VERSION );
        }
    }		
}
add_action( "elementor/frontend/after_enqueue_styles", "TMEA_css", 10, 1 );

/**
* Register JS files
*/	
function TMEA_js(){
    
    $suffix = ( defined( 'WPBT_SCRIPT_DEBUG' ) && WPBT_SCRIPT_DEBUG ) ? '' : '.min';

    // lib files
    wp_register_script('tme-afe-imagesloaded' , TMEA_PLUGINS_URL . 'assets/js/library/imagesloaded'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_register_script('tme-lib-masonry' , TMEA_PLUGINS_URL . 'assets/js/library/masonry'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_register_script('tme-lib-tabs' , TMEA_PLUGINS_URL . 'assets/js/library/tabs'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_register_script('tme-lib-lightbox' , TMEA_PLUGINS_URL . 'assets/js/library/featherlight'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_register_script('tme-lib-slick' , TMEA_PLUGINS_URL . 'assets/js/library/slick'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_register_script('tme-lib-chart' , TMEA_PLUGINS_URL . 'assets/js/library/chart'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_register_script('tme-lib-table' , TMEA_PLUGINS_URL . 'assets/js/library/table'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
        
    // widget files
    foreach (  TMEA_get_module_list() as $module_name) {
        $file = TMEA_PLUGIN_DIR_PATH . 'assets/js/'.$module_name.''. $suffix .'.js';
        if( file_exists($file) ){
            wp_register_script('tme-'.$module_name , TMEA_PLUGINS_URL . 'assets/js/'.$module_name.''. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
        }
    }

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_animations')) {
        wp_enqueue_script('tmea-animations' , TMEA_PLUGINS_URL . 'assets/js/tmea_animations'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    }

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_bg_effects')) {
        wp_enqueue_script('tmea-bg-effects' , TMEA_PLUGINS_URL . 'assets/js/library/bg-effects'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
        wp_enqueue_script('tmea-bg-effect-temp' , TMEA_PLUGINS_URL . 'assets/js/library/bg-effect-temp'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
        wp_localize_script(
            'tmea-bg-effect-temp',
            'TMEBgEffectParams',
            [
                'tmeURL' => TMEA_PLUGINS_URL
            ]
        );
    }

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_parallax_bg')) {
        wp_enqueue_script('tmea-parallax-bg' , TMEA_PLUGINS_URL . 'assets/js/library/parallax-bg'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    }

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_gradient_bg_anim')) {
        wp_enqueue_script('tmea-gradient-bg-anim' , TMEA_PLUGINS_URL . 'assets/js/library/gradient-bg'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    }

    if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_shape_divider')) {
        wp_enqueue_script('tmea-shape-divider' , TMEA_PLUGINS_URL . 'assets/js/library/shape-divider'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
        wp_localize_script(
            'tmea-shape-divider',
            'TMEDividerParams',
            [
                'tmeURL' => TMEA_PLUGINS_URL
            ]
        );
    }

    // localization
    $tme_table_param = array(
        "lengthMenu" => esc_html__( 'Display _MENU_ records per page', 'theme-masters-elementor' ),
        "zeroRecords" => esc_html__( 'Nothing found - sorry', 'theme-masters-elementor' ),
        "info" => esc_html__( 'Showing page _PAGE_ of _PAGES_', 'theme-masters-elementor' ),
        "infoEmpty" => esc_html__( 'No records available', 'theme-masters-elementor' ),
        "infoFiltered" => esc_html__( '(filtered from _MAX_ total records)', 'theme-masters-elementor' ),
        "searchPlaceholder" => esc_html__( 'Search...', 'theme-masters-elementor' ),
        "processing" => esc_html__( 'Processing...', 'theme-masters-elementor' ),
        "csvHtml5" => esc_html__( 'CSV', 'theme-masters-elementor' ),
        "excelHtml5" => esc_html__( 'Excel', 'theme-masters-elementor' ),
        "pdfHtml5" => esc_html__( 'PDF', 'theme-masters-elementor' ),
        "print" => esc_html__( 'Print', 'theme-masters-elementor' )
    );
    wp_localize_script('tme-lib-table', 'tme_table_vars', $tme_table_param);

}
add_action( 'elementor/frontend/after_register_scripts', 'TMEA_js');


/**
* Register Editor JS
*/	
function TMEA_editor_js(){

    $suffix = ( defined( 'WPBT_SCRIPT_DEBUG' ) && WPBT_SCRIPT_DEBUG ) ? '' : '.min';
    
    // lib files
    wp_enqueue_style('tme-lib-lightbox' , TMEA_PLUGINS_URL . 'assets/css/library/featherlight'. $suffix .'.css', false, TMEA_VERSION );
    wp_enqueue_script('tme-lib-lightbox' , TMEA_PLUGINS_URL . 'assets/js/library/featherlight'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );
    wp_enqueue_script('tme-afe-imagesloaded' , TMEA_PLUGINS_URL . 'assets/js/library/imagesloaded'. $suffix .'.js', array( 'jquery' ), TMEA_VERSION, true );

    wp_enqueue_script('tme-afe-editor' , TMEA_PLUGINS_URL . 'assets/js/editor'. $suffix .'.js', array( 'jquery', 'underscore', 'backbone-marionette' ), TMEA_VERSION, true );

    wp_localize_script(
        'tme-afe-editor',
        'TMEEditorParams',
        [
            'tmeURL' => TMEA_PLUGINS_URL,
            'home'   => esc_url( home_url( '/' ) ),
            'root'   => esc_url_raw( rest_url() ),
            'nonce'  => wp_create_nonce( 'wp_rest' )
        ]
    );

    $theme_data = wp_get_theme(); 
    $main_theme_data = $theme_data->parent(); 

    if( ! empty( $main_theme_data ) ){		
        $theme_version = $main_theme_data->get("Version");
        $theme_name  = $main_theme_data->get("Name");
    }else{		
        $theme_version = $theme_data->get("Version");
        $theme_name  = $theme_data->get("Name");
    }
    
    wp_localize_script(
        'tme-afe-editor',
        'TMEThemeLibrary',
            [            
                'themeName' =>  $theme_name,
                'themeVersion' =>  $theme_version,
                'themeURL'  => get_template_directory_uri(),
                'templates' => apply_filters( "TMEA_THEME_LIB", "" )
            ]
    );
}

if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_template_library')) {
    add_action( 'elementor/editor/before_enqueue_scripts', 'TMEA_editor_js', 10 );
}

/**
* Lightbox Inline Styles
*/	
function TMEA_lightbox_styles() {
    if (function_exists('TMEA_get_option')) {
    $overlay_color = TMEA_get_option('lightbox_overlay_color');
    $ui_color = TMEA_get_option('lightbox_ui_color');
    $ui_hover_color = TMEA_get_option('lightbox_ui_hover_color');
    $icon_size = TMEA_get_option('lightbox_icon_size');
    $icon_padding = TMEA_get_option('lightbox_icon_padding'); 
    $loader_color = TMEA_get_option('lightbox_loader_color');
    $loader_bg_color = TMEA_get_option('lightbox_loader_bg_color');  
    $caption_size = TMEA_get_option('lightbox_caption_size');
    $caption_color = TMEA_get_option('lightbox_caption_color');
    $caption_bg = TMEA_get_option('lightbox_caption_bg');
    $caption_padding = TMEA_get_option('lightbox_caption_padding');
    
    $inline_style = '';
    
    if ((!empty($caption_size)) && ($caption_size != '16')) {
        $inline_style .= '.featherlight .tme-gallery-caption {font-size: ' . $caption_size . 'px;}';
    }
    
    if ((!empty($caption_color)) && ($caption_color != '#ffffff')) {
        $inline_style .= '.featherlight .tme-gallery-caption {color: ' . $caption_color . ';}';
    }
    
    if ((!empty($caption_bg)) && ($caption_bg != 'rgba(0,0,0,0.7)')) {
        $inline_style .= '.featherlight .tme-gallery-caption {background-color: ' . $caption_bg . ';}';
    }
    
    if ((!empty($caption_padding)) && ($caption_padding != '20')) {
        $inline_style .= '.featherlight .tme-gallery-caption {padding-top: ' . $caption_padding . 'px;padding-bottom: ' . $caption_padding . 'px;}';
    }
    
    if ((!empty($overlay_color)) && ($overlay_color != 'rgba(0,0,0,0.7)')) {
        $inline_style .= '.featherlight:last-of-type {background: ' . $overlay_color . ';}';
    }
    
    if ((!empty($ui_color)) && ($ui_color != 'rgba(255,255,255,0.5)')) {
        $inline_style .= '.featherlight-next,.featherlight-previous,.featherlight .featherlight-close-icon {color: ' . $ui_color . ';}';
    }
    
    if ((!empty($ui_hover_color)) && ($ui_hover_color != '#ffffff')) {
        $inline_style .= '.featherlight-next:hover,.featherlight-previous:hover,.featherlight .featherlight-close-icon:hover {color: ' . $ui_hover_color . ';}';
    }
    
    if ((!empty($icon_size)) && ($icon_size != '30')) {
        $inline_style .= '.featherlight-next,.featherlight-previous,.featherlight .featherlight-close-icon {font-size: ' . $icon_size . 'px;line-height: ' . $icon_size . 'px;}';
    }
    
    if ((!empty($icon_padding)) && ($icon_padding != '25')) {
        $inline_style .= '.featherlight-previous {left: ' . $icon_padding . 'px;}';
        $inline_style .= '.featherlight-next {right: ' . $icon_padding . 'px;}';
        $inline_style .= '.featherlight .featherlight-close-icon {top: ' . $icon_padding . 'px;right: ' . $icon_padding . 'px;}';
    }
    
    if ((!empty($loader_color)) && ($loader_color != '#000000')) {
        $inline_style .= '.featherlight-loading .featherlight-content {border-top-color: ' . $loader_color . ';}';
    }
    
    if ((!empty($loader_bg_color)) && ($loader_bg_color != '#000000')) {
        $inline_style .= '.featherlight-loading .featherlight-content {border-bottom-color: ' . $loader_bg_color . ';border-left-color: ' . $loader_bg_color . ';border-right-color: ' . $loader_bg_color . ';}';
    }
    
    wp_add_inline_style( 'tme-lib-lightbox', $inline_style );
}
}

add_action('elementor/frontend/after_enqueue_styles','TMEA_lightbox_styles', 9, 1 );

/**
* Add Elementor Category
*/	
function TMEA_category($elements_manager){
    $elements_manager->add_category(
		'theme-masters-elementor',
		[
			'title' => esc_html__( 'Theme Masters', 'theme-masters-elementor' ),
			'icon' => 'fa fa-plug',
		]
	);
}
add_action( 'elementor/elements/categories_registered', 'TMEA_category' );

/**
 * 
 * Enqueue admin styles
 * 
 */
function TMEA_admin_style() {
    
    $suffix = ( defined( 'WPBT_SCRIPT_DEBUG' ) && WPBT_SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_style('tme-lib-modal' , TMEA_PLUGINS_URL . 'assets/css/modal'.$suffix.'.css', false, TMEA_VERSION );

} 

add_action( "elementor/editor/after_enqueue_styles", "TMEA_admin_style", 10, 1 );
