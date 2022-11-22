<?php
add_action( 'cmb2_admin_init', 'TMEA_register_theme_options_metabox' );

function TMEA_register_theme_options_metabox() {
	$cmb_options = new_cmb2_box( array(
		'id'           => 'TMEA_settings_metabox',
		'title'        =>  esc_html__( 'TM Elementor Addons', 'theme-masters-elementor' ) . '<span class="tme-version">version ' . TMEA_VERSION . '</span>',
		'object_types' => array( 'options-page' ),
        'option_key'      => 'TMEA_settings',
        'capability'      => 'manage_options',
        'save_button'     => esc_html__( 'Save Settings', 'theme-masters-elementor' ),
		'menu_title'      => esc_html__( 'TMEA', 'theme-masters-elementor' ),
		'position'        => 59,
		'vertical_tabs' => false,
        'tabs' => array(
            array(
                'id'    => 'tab-1',
                'icon' => 'dashicons-admin-generic',
                'title' => esc_html__( 'Elements', 'theme-masters-elementor' ),
                'fields' => array(
                    'heading',
                    'button',
                    'dropdown_button',
                    'smart_menu',
                    'accordion',
                    'tabs',
                    'table',
                    'slider',
                    'post_slider',
                    'post_masonry',
                    'post_carousel',
                    'post_list',
                    'news_ticker',
                    'search_form',
                    'photo_gallery',
                    'gallery_slider',
                    'banner',
                    'portfolio_grid',
                    'team_member',
                    'team_carousel',
                    'team_masonry',
                    'price_table',
                    'price_menu',
                    'flip_box',
                    'logo_grid',
                    'site_logo',
                    'testimonial',
                    'testimonial_carousel',
                    'business_hours',
                    'login_form',
                    'image_compare',
                    'countdown',
                    'counter',
                    'piechart',
                    'progress_bar',
                    'text_rotator',
                    'timeline',
                    'post_timeline',
                    'qrcode',
                    'shape',
                    'tooltip',
                    'contact_form_7',
                    'youtube_tv',
                    'sticky_video',
                    'scroll_nav',
                    'statistics',
                    'weather',
                    'bar_chart',
                    'line_chart',
                    'doughnut_chart',
                    'radar_chart',
                    'polar_area_chart',
                    'share',
                    'pdf_viewer',
                    'bbpress_form',
                    'bbpress_content',
                    'bbpress_search',
                    'woo_slider',
                    'woo_masonry',
                    'woo_carousel',
                    'woo_table',
                    'woo_gallery',
                    'woo_button'
                ),
            ),
            array(
                'id'    => 'tab-3',
                'icon' => 'dashicons-admin-plugins',
                'title' => esc_html__( 'Extentions', 'theme-masters-elementor' ),
                'fields' => array(
                    'ext_template_library',
                    'ext_protected_content',
                    'ext_animations',
                    'ext_bg_effects',
                    'ext_parallax_bg',
                    'ext_gradient_bg_anim',
                    'ext_shape_divider',
                    'ext_template_shortcode'
                ),
            ),
            array(
                'id'    => 'tab-4',
                'icon' => 'dashicons-flag',
                'title' => esc_html__( 'Icon Library', 'theme-masters-elementor' ),
                'fields' => array(
                    'tm-material-icons',
                    'tm-fontisto',
                    'tm-iconic-font',
                    'tm-linear-icons'
                ),
            ),
            array(
                'id'    => 'tab-2',
                'icon' => 'dashicons-format-image',
                'title' => esc_html__( 'Lightbox', 'theme-masters-elementor' ),
                'fields' => array(
                    'lightbox_overlay_color',
                    'lightbox_ui_color',
                    'lightbox_ui_hover_color',
                    'lightbox_icon_size',
                    'lightbox_icon_padding',
                    'lightbox_loader_color',
                    'lightbox_loader_bg_color',
                    'lightbox_caption_size',
                    'lightbox_caption_color',
                    'lightbox_caption_bg',
                    'lightbox_caption_padding'
                ),
            ),
        )
    ) );
    
    /**
     * ELEMENTS
     */

	$cmb_options->add_field( array(
        'name'          => esc_html__( 'Heading', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/heading/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
		'id'            => 'heading',
        'type'	           => 'switch',
        'default'          => ''
	) );

	$cmb_options->add_field( array(
        'name'          => esc_html__( 'Button', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/button/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'button',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Dropdown Button', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/dropdown-button/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
		'id'            => 'dropdown_button',
		'type'	           => 'switch',
        'default'          => ''
    ) );
    
    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Smart Menu', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/smart-menu/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
		'id'            => 'smart_menu',
		'type'	           => 'switch',
        'default'          => ''
	) );

	$cmb_options->add_field( array(
        'name'          => esc_html__( 'Accordion', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/accordion/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'accordion',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Tabs', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/tabs/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'tabs',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Table', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/table/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'table',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Slider', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/slider/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'slider',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Post Slider', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/post-slider/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'post_slider',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Post Masonry', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/post-masonry/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'post_masonry',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Post Carousel', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/post-carousel/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'post_carousel',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Post List', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/post-list/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'post_list',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'News Ticker', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/news-ticker/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'news_ticker',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Search Form', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/search-form/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'search_form',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Photo Gallery', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/photo-gallery/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'photo_gallery',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Gallery Slider', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/gallery-slider/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'gallery_slider',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Banner Designer', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/banner-designer/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'banner',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Portfolio Grid', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/filterable-portfolio-grid/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'portfolio_grid',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Team Member', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/team-member/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'team_member',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Team Carousel', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/team-carousel/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'team_carousel',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Team Masonry', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/team-masonry/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'team_masonry',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Price Table', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/price-table/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'price_table',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Price Menu', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/price-menu/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'price_menu',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Flip Box', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/flip-box/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'flip_box',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Logo Grid', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/logo-grid/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'logo_grid',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Site Logo', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/site-logo/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'site_logo',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Testimonial', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/testimonial/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'testimonial',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Testimonial Carousel', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/testimonial-carousel/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'testimonial_carousel',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Business Hours', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/business-hours/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'business_hours',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Login Form', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/login-form/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'login_form',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Image Compare', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/image-compare/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'image_compare',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Countdown', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/countdown/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'countdown',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Counter', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/counter/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'counter',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Pie Chart', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/pie-chart/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'piechart',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Progress Bar', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/progress-bar/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'progress_bar',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Text Rotator', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/text-rotator/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'text_rotator',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Timeline', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/timeline/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'timeline',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Post Timeline', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/post-timeline/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'post_timeline',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'QR Code', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/qr-code/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'qrcode',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Shape', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/shape/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'shape',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Tooltip', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/tooltip/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'tooltip',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Contact Form 7', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/contact-form-7/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'contact_form_7',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'YouTube TV', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/youtube-tv/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'youtube_tv',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'YouTube Sticky Video', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/youtube-sticky-video/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'sticky_video',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Scroll Navigation', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/scroll-navigation/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'scroll_nav',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Statistics', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/statistics/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'statistics',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Weather', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/weather/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'weather',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Bar Chart', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/bar-chart/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'bar_chart',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Line Chart', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/line-chart/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'line_chart',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Doughnut Chart', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/doughnut-chart/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'doughnut_chart',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Radar Chart', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/radar-chart/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'radar_chart',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Polar Area Chart', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/polar-area-chart/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'polar_area_chart',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Share Buttons', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/share/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'share',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'PDF Viewer', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/pdf-viewer/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'pdf_viewer',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'bbPress Form', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/bbpress-form/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'bbpress_form',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'bbPress Content', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/bbpress-content/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'bbpress_content',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'bbPress Search', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/bbpress-search/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'bbpress_search',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'WooCommerce Slider', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/woocommerce-slider/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'woo_slider',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'WooCommerce Masonry', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/woocommerce-masonry/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'woo_masonry',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'WooCommerce Carousel', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/woocommerce-carousel/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'woo_carousel',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'WooCommerce Table', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/woocommerce-table/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'woo_table',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'WooCommerce Gallery', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/woocommerce-gallery/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'woo_gallery',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'WooCommerce Button', 'theme-masters-elementor' ),
        'before_field'  => '<a href="https://demos.thememasters.club/woocommerce-button/" target="_blank" class="demo-link"><span class="dashicons dashicons-laptop"></span></a>',
        'id'            => 'woo_button',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    /**
     * LIGHTBOX
     */

    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'Overlay Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_overlay_color',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.7)',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );
    
    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'UI Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_ui_color',
            'type' => 'colorpicker',
            'default' => 'rgba(255,255,255,0.5)',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );
    
    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'UI Hover Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_ui_hover_color',
            'type' => 'colorpicker',
            'default' => '#ffffff',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );
    
    $cmb_options->add_field( array(
        'name' => esc_html__( 'Icon Size (px)', 'theme-masters-elementor' ),
        'id'   => 'lightbox_icon_size',
        'type' => 'text',
        'default' => 30,
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        )
    ) );
    
    $cmb_options->add_field( array(
        'name' => esc_html__( 'Icon Padding (px)', 'theme-masters-elementor' ),
        'id'   => 'lightbox_icon_padding',
        'type' => 'text',
        'default' => 25,
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        )
    ) );

    $cmb_options->add_field( array(
        'name' => esc_html__( 'Caption Padding (px)', 'theme-masters-elementor' ),
        'id'   => 'lightbox_caption_padding',
        'type' => 'text',
        'default' => 10,
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        )
    ) );
    
    $cmb_options->add_field( array(
        'name' => esc_html__( 'Caption Font Size (px)', 'theme-masters-elementor' ),
        'id'   => 'lightbox_caption_size',
        'type' => 'text',
        'default' => 16,
        'attributes' => array(
            'type' => 'number',
            'pattern' => '\d*',
        )
    ) );
    
    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'Caption Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_caption_color',
            'type' => 'colorpicker',
            'default' => '#ffffff',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );
    
    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'Caption Background Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_caption_bg',
            'type' => 'colorpicker',
            'default' => 'rgba(0,0,0,0.7)',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );
    
    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'Loader Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_loader_color',
            'type' => 'colorpicker',
            'default' => '#000000',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );
    
    $cmb_options->add_field(
        array(
            'name' => esc_html__( 'Loader Background Color', 'theme-masters-elementor'),  
            'id' => 'lightbox_loader_bg_color',
            'type' => 'colorpicker',
            'default' => '#ffffff',
            'options' => array(
                'alpha' => true, 
            ),
        )
    );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Template Library', 'theme-masters-elementor' ),
		'id'            => 'ext_template_library',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Protected Content', 'theme-masters-elementor' ),
		'id'            => 'ext_protected_content',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Widget Animations', 'theme-masters-elementor' ),
		'id'            => 'ext_animations',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Background Effects', 'theme-masters-elementor' ),
		'id'            => 'ext_bg_effects',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Parallax Background', 'theme-masters-elementor' ),
		'id'            => 'ext_parallax_bg',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Gradient Background Animation', 'theme-masters-elementor' ),
		'id'            => 'ext_gradient_bg_anim',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Shape Divider', 'theme-masters-elementor' ),
		'id'            => 'ext_shape_divider',
        'type'	           => 'switch',
        'default'          => ''
    ) );

    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Template Shortcode', 'theme-masters-elementor' ),
		'id'            => 'ext_template_shortcode',
        'type'	           => 'switch',
        'default'          => ''
    ) );
    
    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Material Icons', 'theme-masters-elementor' ) . ' (1140+)',
		'id'            => 'tm-material-icons',
        'type'	           => 'switch',
        'default'          => ''
    ) );
    
    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Fontisto', 'theme-masters-elementor' ) . ' (616+)',
		'id'            => 'tm-fontisto',
        'type'	           => 'switch',
        'default'          => ''
    ) );
    
    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Iconic Font', 'theme-masters-elementor' ) . ' (300+)',
		'id'            => 'tm-iconic-font',
        'type'	           => 'switch',
        'default'          => ''
    ) );
    
    $cmb_options->add_field( array(
        'name'          => esc_html__( 'Linear Icons', 'theme-masters-elementor' ) . ' (170+)',
		'id'            => 'tm-linear-icons',
        'type'	           => 'switch',
        'default'          => ''
	) );

}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function TMEA_get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'TMEA_settings', $key, $default );
	}

	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'TMEA_settings', $default );

	$val = $default;

	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;
}
