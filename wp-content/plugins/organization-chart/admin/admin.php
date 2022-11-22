<?php

defined('ABSPATH') || exit;

class wpda_org_chart_admin_main {

    public function __construct() {
        if (is_admin()) {
            $this->admin_files();
            $this->admin_filters();
        }
        $this->gutenberg();
    }

	/*############ Function for the admin files ##################*/	
	
    private function admin_files() {
        require_once wpda_org_chart_plugin_path . 'admin/tree-page/class-tree-page.php';
        require_once wpda_org_chart_plugin_path . 'admin/theme-page/class-tree-theme-page.php';
        require_once wpda_org_chart_plugin_path . 'admin/popup-page/class-popup-theme-page.php';
        require_once wpda_org_chart_plugin_path . 'admin/user-permissions/user-permissions.php';
    }

	/*############ Function for the admin filters ##################*/	
	
    private function admin_filters() {
        add_action('admin_menu', array($this, 'create_admin_menu'));
        //classic editor button
        add_filter('mce_external_plugins', array($this, 'mce_external_plugins'));
        add_filter('mce_buttons', array($this, 'mce_buttons'));
        add_action('admin_enqueue_scripts', array($this, 'mce_buttons_style'));
        add_action('wp_ajax_wpda_org_chart_post_page_content', array($this, "post_page_content"));
    }
	/*############ Function that creates the admin menu ##################*/
	
    public function create_admin_menu() {
        global $submenu;
        wpda_org_chart_user_permissions_library::initial_information();
        wpda_org_chart_user_permissions::initial_options();
        add_menu_page("Wpdevart Chart", "Wpdevart Chart", wpda_org_chart_user_permissions::get_allowed_page_permission('chart_page'), "wpda_chart_tree_page", array($this, 'manage_tree'), 'dashicons-networking');
        $main_page = add_submenu_page("wpda_chart_tree_page", "Charts", "Charts",  wpda_org_chart_user_permissions::get_allowed_page_permission('chart_page'), "wpda_chart_tree_page", array($this, 'manage_tree'));
        $theme = add_submenu_page("wpda_chart_tree_page", "Themes", "Themes", wpda_org_chart_user_permissions::get_allowed_page_permission('chart_theme_page'), "wpda_chart_tree_themes", array($this, 'manage_tree_themes'));
        $popup = add_submenu_page("wpda_chart_tree_page", "Popup Themes", "Popup Themes", wpda_org_chart_user_permissions::get_allowed_page_permission('chart_popup_page'), "wpda_chart_tree_popup_themes", array($this, 'manage_tree_popup'));
        $user_permissions = add_submenu_page("wpda_chart_tree_page", "User Permissions", "User Permissions", 'manage_options', "wpda_chart_tree_user_permissions", array($this, 'manage_user_permissions'));
        $featured_page = add_submenu_page("wpda_chart_tree_page", "Featured Plugins", "Featured Plugins", 'read', "wpda_chart_featured_plugins", array($this, 'featured_plugins'));
        $hire_expert = add_submenu_page("wpda_chart_tree_page", 'Hire an Expert', '<span style="color:#00ff66" >Hire an Expert</span>', 'read', "wpda_chart_hire_expert", array($this, 'hire_expert'));
        add_action('load-' . $main_page, array($this, 'save_tree_page'));
        add_action('admin_print_styles-' . $main_page, array($this, 'tree_page_js_css'));
        add_action('load-' . $theme, array($this, 'save_theme_page'));
        add_action('admin_print_styles-' . $theme, array($this, 'tree_theme_js_css'));
        add_action('load-' . $popup, array($this, 'save_popup_page'));
        add_action('admin_print_styles-' . $popup, array($this, 'tree_popup_js_css'));
        add_action('load-' .  $user_permissions, array($this, 'save_user_permissions'));
        add_action('admin_print_styles-' .  $user_permissions, array($this, 'user_permissions_js_css'));
        add_action('admin_print_styles-' . $featured_page, array($this, 'tree_featured_plugins_js_css'));
        add_action('admin_print_styles-' . $hire_expert, array($this, 'hire_expert_js_css'));
        if (isset($submenu['wpda_chart_tree_page'])) {
            add_submenu_page('wpda_chart_tree_page', "Support or Any Ideas?", "<span style='color:#00ff66' >Support or Any Ideas?</span>", 'read', "wpdevar_youtube_any_ideas", array($this, 'any_ideas'), 156);
        }
        if (isset($submenu['wpda_chart_tree_page'])) {
            $count_pages = count($submenu['wpda_chart_tree_page'])-1;
            $submenu['wpda_chart_tree_page'][$count_pages][2] = wpda_org_chart_support_url;
        }
    }
    // tree page 
    public function save_tree_page() {
        wpda_org_chart_admin_tree::initial_task();
        wpda_org_chart_admin_tree::database_actions();
    }

    public function tree_page_js_css() {
        wpda_org_chart_admin_tree::enqueue_scripts_styles();
    }

    public function manage_tree() {
        wpda_org_chart_admin_tree::render_tree();
    }
    // theme page
    public function save_theme_page() {
        wpda_org_chart_tree_theme_page::initial_task();
        wpda_org_chart_tree_theme_page::initial_options();
        wpda_org_chart_tree_theme_page::database_actions();
    }

    public function tree_theme_js_css() {
        wpda_org_chart_tree_theme_page::enqueue_scripts_styles();
    }

    public function manage_tree_themes() {
        wpda_org_chart_tree_theme_page::render_theme();
    }
    // popup page     
    public function save_popup_page() {
        wpda_org_chart_admin_popup::initial_task();
        wpda_org_chart_admin_popup::initial_options();
        wpda_org_chart_admin_popup::database_actions();
    }

    public function tree_popup_js_css() {
        wpda_org_chart_admin_popup::enqueue_scripts_styles();
    }

    public function manage_tree_popup() {
        wpda_org_chart_admin_popup::render_popup();
    }
    // user permissions
    public function save_user_permissions(){
        wpda_org_chart_user_permissions::database_actions();
    }

    public function manage_user_permissions(){
        wpda_org_chart_user_permissions::render_user_permissions();
    }

    public function user_permissions_js_css(){
        wpda_org_chart_user_permissions::enqueue_scripts_styles();
    }

    public function tree_featured_plugins_js_css() {
        wp_enqueue_style('wpda_chart_featured_page_css', wpda_org_chart_plugin_url . 'admin/assets/css/featured_plugins_css.css');
    }

    public function hire_expert_js_css() {
        wp_enqueue_style('wpda_chart_hire_expert_css', wpda_org_chart_plugin_url . 'admin/assets/css/hire_expert.css');
    }

    /*connect with gutenberg editor*/
    public function gutenberg() {
        require_once wpda_org_chart_plugin_path . 'admin/gutenberg/gutenberg.php';
        $gutenberg = new wpda_chart_gutenberg();
    }
    /*post page button*/
    public function mce_external_plugins($plugin_array) {
        $plugin_array["wpda_org_chart"] = wpda_org_chart_plugin_url . 'admin/assets/js/post_page_insert_button.js';
        return $plugin_array;
    }
    /*post page button add_class*/
    public function mce_buttons($buttons) {
        wp_enqueue_script('wpda_org_chart_inline_js',wpda_org_chart_plugin_url . 'admin/assets/js/empty.js');
        wp_add_inline_script('wpda_org_chart_inline_js','let wpda_org_chart_insert_post_shortcode_nonce = "'.wp_create_nonce('wpda_org_chart_insert_post_shortcode_nonce').'"');
        array_push($buttons, "wpda_org_chart");
        return $buttons;
    }
    /*button styling*/
    public function mce_buttons_style() {
        wp_register_style('wpda_org_chart_inline_css', false);
        wp_enqueue_style('wpda_org_chart_inline_css');
        wp_add_inline_style('wpda_org_chart_inline_css', '.mce-i-wpdevart_org_chart.dashicons.dashicons-networking::before{font-family: \'dashicons\';font-size: 20px;color:}');
    }
    /*button html*/
    public function post_page_content() {
        global $wpdb;
        if(!wp_verify_nonce($_GET['wpda_org_chart_insert_post_shortcode_nonce'],'wpda_org_chart_insert_post_shortcode_nonce')){
            die();
        }
        if(!current_user_can( 'edit_posts' )){
            die('0');
        }
        $trees = $wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_database::$table_names['tree']);
        $themes = $wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_database::$table_names['theme']);
        $cur_chart = intval($_GET["chart_id"]) . "";
        $cur_theme = intval($_GET["theme_id"]) . "";
        $html = '<!DOCTYPE html>';
        $html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $html .= '<head>';
        $html .= '<title>WpDevArt Organization Chart</title>';
        $html .= '<script language="javascript" type="text/javascript" src="' . site_url() . '/wp-includes/js/tinymce/tiny_mce_popup.js"></script>';
        $html .= '<script language="javascript" type="text/javascript" src="' . site_url() . '/wp-includes/js/tinymce/utils/mctabs.js"></script>';
        $html .= '<script language="javascript" type="text/javascript" src="' . site_url() . '/wp-includes/js/tinymce/utils/form_utils.js"></script>';
        $html .= '<script type="text/javascript">';
        $html .= 'function insert_chart() {';
        $html .= 'let tagText;';
        $html .= 'tagText = \'<p>[wpda_org_chart tree_id="\' + document.getElementById("select_chart").value + \'"  theme_id="\' + document.getElementById("select_theme").value + \'"]</p>\';';
        $html .= 'window.parent.tinyMCE.execCommand("mceInsertContent", false, tagText);';
        $html .= 'tinyMCEPopup.close();}';
        $html .= '</script>';
        $html .= '</head><body>';
        $html .= '<table width="100%" style="margin-bottom: 100px;" class="paramlist admintable" cellspacing="1"><tbody><tr>';
        $html .= '<td style="width: 150px;vertical-align: top;" class="paramlist_key"><span class="editlinktip"><label style="font-size:12px;" class="hasTip">Select a Tree: </label></span></td>';
        $html .= '<td class="paramlist_value" ><select style="min-width:200px;font-size:12px" id="select_chart">';
        foreach ($trees as $value) {
            $html .= '<option ' . selected($value->id, $cur_chart, false) . ' value="' . $value->id . '">' . $value->name . '</option>';
        }
        $html .= '</td></tr><tr><td style="width: 150px;" class="paramlist_key"><span class="editlinktip"><label style="font-size:12px" class="hasTip">Select a Theme: </label></span></td><td class="paramlist_value" ><select style="min-width:200px;font-size:12px" id="select_theme">';
        foreach ($themes as $value) {
            $html .= '<option ' . selected($value->id, $cur_theme, false) . ' value="' . $value->id . '">' . $value->name . '</option>';
        }
        $html .= '</select></td></tr></tbody></table>';
        $html .= '<div class="mceActionPanel"><div style="float: left"><input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();"/></div><div style="float: right"><input type="submit" id="insert" name="insert" value="Insert" onClick="insert_chart();"/><input type="hidden" name="iden" value="1"/></div></div>';
        $html .= '</body></html>';
        echo $html;
        exit;
    }

    public function hire_expert() {
        $plugins_array = array(
            'custom_site_dev' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/1.png',
                'title' => 'Custom WordPress Development',
                'description' => 'Hire a WordPress expert and make any custom development for your WordPress website.',
            ),
            'custom_plug_dev' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/2.png',
                'title' => 'WordPress Plugin Development',
                'description' => 'Our developers can create any WordPress plugin from zero. Also, they can customize any plugin and add any functionality.',
            ),
            'custom_theme_dev' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/3.png',
                'title' => 'WordPress Theme Development',
                'description' => 'If you need an unique theme or any customizations for a ready theme, then our developers are ready.',
            ),
            'custom_theme_inst' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/4.png',
                'title' => 'WordPress Theme Installation and Customization',
                'description' => 'If you need a theme installation and configuration, then just let us know, our experts configure it.',
            ),
            'gen_wp_speed' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/5.png',
                'title' => 'General WordPress Support',
                'description' => 'Our developers can provide general support. If you have any problem with your website, then our experts are ready to help.',
            ),
            'speed_op' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/6.png',
                'title' => 'WordPress Speed Optimization',
                'description' => 'Hire an expert from WpDevArt and let him take care of your website speed optimization.',
            ),
            'mig_serv' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/7.png',
                'title' => 'WordPress Migration Services',
                'description' => 'Our developers can migrate websites from any platform to WordPress.',
            ),
            'page_seo' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/hire_expert/8.png',
                'title' => 'WordPress SEO',
                'description' => 'SEO is an important part of any website. Hire an expert and he will organize the SEO of your website.',
            ),
        );
        $content = '';
        $content .= '<h1 class="wpda_hire_exp_h1"> Hire an Expert from WpDevArt </h1>';
        $content .= '<div class="hire_expert_main">';
        foreach ($plugins_array as $key => $plugin) {
            $content .= '<div class="wpdevart_hire_main"><a target="_blank" class="wpda_hire_buklet" href="https://wpdevart.com/hire-a-wordpress-developer-online-submit-form/">';
            $content .= '<div class="wpdevart_hire_image"><img src="' . $plugin["image_url"] . '"></div>';
            $content .= '<div class="wpdevart_hire_information">';
            $content .= '<div class="wpdevart_hire_title">' . $plugin["title"] . '</div>';
            $content .= '<p class="wpdevart_hire_description">' . $plugin["description"] . '</p>';
            $content .= '</div></a></div>';
        }
        $content .= '<div><a target="_blank" class="wpda_hire_button" href="https://wpdevart.com/hire-a-wordpress-developer-online-submit-form/">Hire an Expert</a></div>';
        $content .= '</div>';
        echo $content;
    }

    public function featured_plugins() {
        $plugins_array = array(
            'gallery_album' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/gallery-album-icon.png',
                'site_url' => 'http://wpdevart.com/wordpress-gallery-plugin',
                'title' => 'WordPress Gallery plugin',
                'description' => 'Gallery plugin is an useful tool that will help you to create Galleries and Albums. Try our nice Gallery views and awesome animations.',
            ),
            'coming_soon' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/coming_soon.png',
                'site_url' => 'http://wpdevart.com/wordpress-coming-soon-plugin/',
                'title' => 'Coming soon and Maintenance mode',
                'description' => 'Coming soon and Maintenance mode plugin is an awesome tool to show your visitors that you are working on your website to make it better.',
            ),
            'Contact forms' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/contact_forms.png',
                'site_url' => 'http://wpdevart.com/wordpress-contact-form-plugin/',
                'title' => 'Contact Form Builder',
                'description' => 'Contact Form Builder plugin is an handy tool for creating different types of contact forms on your WordPress websites.',
            ),
            'Booking Calendar' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/Booking_calendar_featured.png',
                'site_url' => 'http://wpdevart.com/wordpress-booking-calendar-plugin/',
                'title' => 'WordPress Booking Calendar',
                'description' => 'WordPress Booking Calendar plugin is an awesome tool to create a booking system for your website. Create booking calendars in a few minutes.',
            ),
            'Pricing Table' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/Pricing-table.png',
                'site_url' => 'https://wpdevart.com/wordpress-pricing-table-plugin/',
                'title' => 'WordPress Pricing Table',
                'description' => 'WordPress Pricing Table plugin is a nice tool for creating beautiful pricing tables. Use WpDevArt pricing table themes and create tables just in a few minutes.',
            ),
            'youtube' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/youtube.png',
                'site_url' => 'http://wpdevart.com/wordpress-youtube-embed-plugin',
                'title' => 'WordPress YouTube Embed',
                'description' => 'YouTube Embed plugin is an convenient tool for adding videos to your website. Use YouTube Embed plugin for adding YouTube videos in posts/pages, widgets.',
            ),
            'facebook-comments' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/facebook-comments-icon.png',
                'site_url' => 'http://wpdevart.com/wordpress-facebook-comments-plugin/',
                'title' => 'Wpdevart Social comments',
                'description' => 'WordPress Facebook comments plugin will help you to display Facebook Comments on your website. You can use Facebook Comments on your pages/posts.',
            ),
            'countdown' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/countdown.jpg',
                'site_url' => 'http://wpdevart.com/wordpress-countdown-plugin/',
                'title' => 'WordPress Countdown plugin',
                'description' => 'WordPress Countdown plugin is an nice tool for creating countdown timers for your website posts/pages and widgets.',
            ),
            'lightbox' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/lightbox.png',
                'site_url' => 'http://wpdevart.com/wordpress-lightbox-plugin',
                'title' => 'WordPress Lightbox plugin',
                'description' => 'WordPress Lightbox Popup is an high customizable and responsive plugin for displaying images and videos in popup.',
            ),
            'facebook' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/facebook.png',
                'site_url' => 'http://wpdevart.com/wordpress-facebook-like-box-plugin',
                'title' => 'Social Like Box',
                'description' => 'Facebook like box plugin will help you to display Facebook like box on your website, just add Facebook Like box widget to sidebar or insert it into posts/pages and use it.',
            ),
            'poll' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/poll.png',
                'site_url' => 'http://wpdevart.com/wordpress-polls-plugin',
                'title' => 'WordPress Polls system',
                'description' => 'WordPress Polls system is an handy tool for creating polls and survey forms for your visitors. You can use our polls on widgets, posts and pages.',
            ),
            'poll' => array(
                'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/featured_plugins/vertical-menu.png',
                'site_url' => 'http://wpdevart.com/wordpress-polls-plugin',
                'title' => 'WordPress Vertical Menu',
                'description' => 'WordPress Vertical Menu is a handy tool for adding nice vertical menus. You can add icons for your website vertical menus using our plugin.',
            ),

        );
        $html = '';
        $html .= '<h1 class="wpda_featured_plugins_title">Featured Plugins</h1>';
        foreach ($plugins_array as $plugin) {
            $html .= '<div class="featured_plugin_main">';
            $html .= '<div class="featured_plugin_image"><a target="_blank" href="' . $plugin['site_url'] . '"><img src="' . $plugin['image_url'] . '"></a></div>';
            $html .= '<div class="featured_plugin_information">';
            $html .= '<div class="featured_plugin_title">';
            $html .= '<h4><a target="_blank" href="' . $plugin['site_url'] . '">' . $plugin['title'] . '</a></h4>';
            $html .= '</div>';
            $html .= '<p class="featured_plugin_description">' . $plugin['description'] . '</p>';
            $html .= '<a target="_blank" href="' . $plugin['site_url'] . '" class="blue_button">Check The Plugin</a>';
            $html .= '</div>';
            $html .= '<div style="clear:both"></div>';
            $html .= '</div>';
        }
        echo $html;
    }
}
