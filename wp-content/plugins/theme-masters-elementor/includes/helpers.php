<?php
/**
 * 
 * Excerpt Length
 * 
 */

function TMEA_excerpt($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			return mb_substr( $subex, 0, $excut ) . ' ...';
		} else {
			return $subex . ' ...';
		}
	} else {
		return $excerpt;
	}
}

/**
 * 
 * Get Categories
 * 
 */

function TMEA_get_categories() {
    $output_terms = array();
    $args = array (
        'taxonomy' => array('category'),
        'hide_empty' => 1
    );
    $terms = get_terms($args);
    foreach($terms as $term) {
        $output_terms[$term->term_id] = $term->name;
    }
    return $output_terms;
}

/**
 * 
 * Get WooCommerce Categories
 * 
 */

function TMEA_get_woo_categories() {
    $output_terms = array();
    $args = array (
        'taxonomy' => array('product_cat'),
        'hide_empty' => 1
    );
    $terms = get_terms($args);
    foreach($terms as $term) {
        $output_terms[$term->term_id] = $term->name;
    }
    return $output_terms;
}

/**
 * 
 * Get Tags
 * 
 */

function TMEA_get_tags() {
    $output_terms = array();
    $args = array (
        'taxonomy' => array('post_tag'),
        'hide_empty' => 1
    );
    $terms = get_terms($args);
    foreach($terms as $term) {
        $output_terms[$term->term_id] = $term->name;
    }
    return $output_terms;
}

/**
 * 
 * Get WooCommerce Tags
 * 
 */

function TMEA_get_woo_tags() {
    $output_terms = array();
    $args = array (
        'taxonomy' => array('product_tag'),
        'hide_empty' => 1
    );
    $terms = get_terms($args);
    foreach($terms as $term) {
        $output_terms[$term->term_id] = $term->name;
    }
    return $output_terms;
}

/**
 * 
 * Get Authors
 * 
 */

function TMEA_get_authors() {
    $output_authors = array();
    $args = array(
        'role__in' => array('Administrator', 'Editor', 'Author'),
        'orderby' => 'post_count',
        'order' => 'DESC'
    );
    $users = get_users($args);
    foreach ($users as $user) {
        $output_authors[$user->ID] = $user->display_name;
    }
    return $output_authors;
}

/**
 * 
 * Get User Roles
 * 
 */

function TMEA_get_user_roles() {
    $output_roles = array();
    $roles = wp_roles()->get_names();
    foreach ($roles as $key => $role) {
        $output_roles[$key] = translate_user_role( $role );
    }
    return $output_roles;
}

/**
 * 
 * Get Image Sizes
 * 
 */

function TMEA_get_image_sizes() {
    $output_sizes = array();
    $img_sizes = get_intermediate_image_sizes();
    $output_sizes['full'] = esc_html__( 'Full', 'theme-masters-elementor' );
    foreach ($img_sizes as $size_name) {
        $output_sizes[$size_name] = $size_name;
    }
    return $output_sizes;
}

/**
 * 
 * Get Post Types
 * 
 */

function TMEA_get_post_types() {
    $output_post_types = array();
    $args = array('public' => true); 
    $output = 'names';
    $operator = 'and';
    $selected_post_types = get_post_types($args,$output,$operator);
    foreach($selected_post_types as $type) {
        $output_post_types[$type] = $type;
    }
    return $output_post_types;
}

/**
 * 
 * Add required mime types
 * 
 */

function TMEA_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'TMEA_mime_types' );

/**
 * 
 * Get menus
 * 
 */

function TMEA_get_menus() {
    $output_menus = array();
    $menus = wp_get_nav_menus();
    foreach($menus as $menu) {
        $output_menus[$menu->term_id] = $menu->name;
    }
    return $output_menus;
}

/**
 * 
 * Get WooCommerce Products
 * 
 */

function TMEA_get_woo_products() {
    $output_products = array();
    $args = array (
        'numberposts'		=> -1,
        'post_type'		=> 'product',
        'orderby' 		=> 'title',
        'order' 		=> 'ASC',
    );
    $products = get_posts($args);
    foreach($products as $product) {
        $output_products[$product->ID] = $product->post_title;
    }
    return $output_products;
}

/**
 * 
 * Get bbPress forums
 * 
 */

function TMEA_get_forums() {
    $output_terms = array();
    $args = array (
        'post_type' => 'forum',
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => 999999
    );
    $forums = get_posts($args);
    $output_terms[''] = esc_html__( 'Select Forum', 'theme-masters-elementor' );
    foreach($forums as $forum) {
        $output_terms[$forum->ID] = $forum->post_title;
    }
    return $output_terms;
}

/**
 * 
 * Get bbPress topics
 * 
 */

function TMEA_get_topics() {
    $output_terms = array();
    $args = array (
        'post_type' => 'topic',
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => 999999
    );
    $topics = get_posts($args);
    $output_terms[''] = esc_html__( 'Select Topic', 'theme-masters-elementor' );
    foreach($topics as $topic) {
        $output_terms[$topic->ID] = $topic->post_title;
    }
    return $output_terms;
}

/**
 * 
 * Get Post count
 * 
 */
function TMEA_post_count() {
    return wp_count_posts()->publish;
}

/**
 * 
 * Get Comment Count
 * 
 */
function TMEA_comment_count() {
    return wp_count_comments()->approved;
}

/**
 * 
 * Get BbPress Registered User count
 * 
 */
function TMEA_bbpress_user_count() {
    if ( function_exists( 'bbp_get_statistics' ) ) {
        $stats = bbp_get_statistics();
        return $stats['user_count'];
    } else {
        return '0';
    }
}

/**
 * 
 * Get BbPress Forum Count
 * 
 */
function TMEA_bbpress_forum_count() {
    if ( function_exists( 'bbp_get_statistics' ) ) {
        $stats = bbp_get_statistics();
        return $stats['forum_count'];
    } else {
        return '0';
    }
}

/**
 * 
 * Get BbPress Topic Count
 * 
 */
function TMEA_bbpress_topic_count() {
    if ( function_exists( 'bbp_get_statistics' ) ) {
        $stats = bbp_get_statistics();
        return $stats['topic_count'];
    } else {
        return '0';
    }
}

/**
 * 
 * Get BbPress Reply Count
 * 
 */
function TMEA_bbpress_reply_count() {
    if ( function_exists( 'bbp_get_statistics' ) ) {
        $stats = bbp_get_statistics();
        return $stats['reply_count'];
    } else {
        return '0';
    }
}

/**
 * 
 * Get BbPress Topic Tag Count
 * 
 */
function TMEA_bbpress_topic_tag_count() {
    if ( function_exists( 'bbp_get_statistics' ) ) {
        $stats = bbp_get_statistics();
        return $stats['topic_tag_count'];
    } else {
        return '0';
    }
}

/**
 * 
 * Get BuddyPress Member Count
 * 
 */
function TMEA_bp_member_count() {
    if ( function_exists( 'bp_core_get_total_member_count' ) ) {
        return bp_core_get_total_member_count();
    }
    else {
        return '0';
    }
}

/**
 * 
 * Get BuddyPress Group Count
 * 
 */
function TMEA_bp_group_count() {
    if ( function_exists( 'groups_get_total_group_count' ) ) {
        return groups_get_total_group_count();
    }
    else {
        return '0';
    }
}

/**
 * 
 * Get BuddyPress Activity Count
 * 
 */
function TMEA_bp_activity_count() {
    if ( function_exists( 'bp_is_active' ) && bp_is_active( 'activity' ) ) {
        global $bp, $wpdb;
        $item_id = null;       
        $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM {$wpdb->prefix}bp_activity 
                        WHERE type = 'activity_update'
                        AND item_id = '%s' ", $item_id ) );	
        return $count;
    } else {
        return '0';
    }
}

/**
 * 
 * Get Exit Animations
 * 
 */
function TMEA_get_anim_exits($animation) {
    if ($animation) {
    $animation_array = array(
        'bounce' => 'fadeOut',
        'flash' => 'fadeOut',
        'pulse' => 'fadeOut',
        'rubberBand' => 'fadeOut',
        'shake' => 'fadeOut',
        'swing' => 'fadeOut',
        'tada' => 'fadeOut',
        'wobble' => 'fadeOut',
        'jello' => 'fadeOut',
        'heartBeat' => 'fadeOut',
        'bounceIn' => 'bounceOut',
        'bounceInDown' => 'bounceOutUp',
        'bounceInLeft' => 'bounceOutLeft',
        'bounceInRight' => 'bounceOutRight',
        'bounceInUp' => 'bounceOutDown',
        'fadeIn' => 'fadeOut',
        'fadeInDown' => 'fadeOutUp',
        'fadeInDownBig' => 'fadeOutUpBig',
        'fadeInLeft' => 'fadeOutLeft',
        'fadeInLeftBig' => 'fadeOutLeftBig',
        'fadeInRight' => 'fadeOutRight',
        'fadeInRightBig' => 'fadeOutRightBig',
        'fadeInUp' => 'fadeOutDown',
        'fadeInUpBig' => 'fadeOutDownBig',
        'flip' => 'fadeOut',
        'flipInX' => 'flipOutX',
        'flipInY' => 'flipOutY',
        'lightSpeedIn' => 'lightSpeedOut',
        'rotateIn' => 'rotateOut',
        'rotateInDownLeft' => 'rotateOutUpLeft',
        'rotateInDownRight' => 'rotateOutUpRight',
        'rotateInUpLeft' => 'rotateOutDownLeft',
        'rotateInUpRight' => 'rotateOutDownRight',
        'slideInUp' => 'slideOutDown',
        'slideInDown' => 'slideOutUp',
        'slideInLeft' => 'slideOutLeft',
        'slideInRight' => 'slideOutRight',
        'zoomIn' => 'zoomOut',
        'zoomInDown' => 'zoomOutUp',
        'zoomInLeft' => 'zoomOutLeft',
        'zoomInRight' => 'zoomOutRight',
        'zoomInUp' => 'zoomOutDown',
        'hinge' => 'fadeOut',
        'jackInTheBox' => 'fadeOut',
        'rollIn' => 'fadeOut'
    );
    $animation = $animation_array[$animation];
    return $animation;
}
}

/**
 * 
 * Get data
 * 
 */
function TMEA_get_data( $data ) {
 
    if( ! isset( $data[ 'tid' ] ) ) {
        return rest_ensure_response( false );
    }
   
    if( $data['istheme'] == "local" ){
        $response = wp_remote_get( TMEA_PLUGINS_URL ."assets/js/templates/template-".$data["tid"].".json" );     
    }else{
        $theme_templates = apply_filters( "TMEA_THEME_LIB", "" );
        $response = wp_remote_get( $theme_templates[$data["tid"]]["templateUrl"] );     
    }


    // process json
    $response = tme_process_json( json_decode( $response["body"], true ) );

    return rest_ensure_response( $response );    
}

/**
 * 
 *  Restroute for local
 * 
 */
function TMEA_rest_route() {
    register_rest_route( 'TMEA', 'get-json/(?P<istheme>[a-zA-Z0-9-]+)/(?P<tid>\d+)', array(
        'methods' => 'GET',
        'callback' => 'TMEA_get_data',
        'permission_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
        'args' => array(
            'tid' => array( 
                'validate_callback' => function( $param, $request, $key ) {
                    return is_numeric($param);
                }
            ),
            'istheme' => array( 
                'validate_callback' => function( $param, $request, $key ) {
                    return esc_url($param);
                }
            ),            
        )                    
    )
);
}
add_action( 'rest_api_init', 'TMEA_rest_route', 10 );
 


/**
 * 
 * Get Previously Uploaded Image
 * 
 */
function TMEA_get_image( $hash ){
    global $wpdb;

    $post_id = $wpdb->get_var(
        $wpdb->prepare(
            'SELECT `post_id` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = \'_TMEA_image_hash\' AND `meta_value` = %s ;', 
            $hash
        )
    );

    if ( $post_id ) {
        return [
            'id' => $post_id,
            'url' => wp_get_attachment_url( $post_id ),
        ];
    }
    
    return false;
}


/**
 * 
 * Process JSON
 * 
 */
function tme_process_json( $response, $collect = "" ){

	$collect = empty($collect) ? [] : $collect;

	foreach( $response as $key => $value  ){
		
		if( is_array( $value ) ){


			if(  
                ($key === "image" ||  $key === "bg_image" || $key === "background_image" || $key === "before_image" || $key === "after_image" || $key === "lightbox_image" || $key === "logo" || $key === "value" || $key === "lightbox_image" || $key === "container_bg_image" || $key === "banner_wrapper_bg" || $key === "banner_bg" || $key === "tmea_parallax_bg_img" ) && 
                is_array( $value ) && 
                isset( $value["url"] )  
            ){

                
                /**
                 * get previously uploaded image id/url or upload 
                 */
                $get_saved_image = TMEA_get_image( sha1( $value["url"] ) );

                if( $get_saved_image ){
                    $value["id"] = $get_saved_image["id"];
                    $value["url"] = $get_saved_image["url"];
                    $collect[$key] = $value;
                }else{
                    $newAttachmentID = TMEA_handle_upload( $value );
                    $value["id"] = $newAttachmentID["id"];
                    $value["url"] = $newAttachmentID["url"];
                    $collect[$key] = $value;
                }


            }elseif( ($key === "wp_gallery" || $key === "gallery") && is_array( $value ) ){  
                
                    $value_ = [];
         
                    foreach( $value as $gallery_item ){

                        /**
                         * get previously uploaded image id/url or upload 
                         */
                        $get_saved_image = TMEA_get_image( sha1( $gallery_item["url"] ) );

                        if( $get_saved_image ){
                            $gallery_item["id"] = $get_saved_image["id"];
                            $gallery_item["url"] = $get_saved_image["url"];                            
                        }else{
                            $newAttachmentID = TMEA_handle_upload( $gallery_item );
                            $gallery_item["id"] = $newAttachmentID["id"];
                            $gallery_item["url"] = $newAttachmentID["url"];
                        }
                                                

                        $value_[] = $gallery_item; 
                    }

                   $collect[$key] = $value_;
                     
                     
			}else{
				$collect[$key] = tme_process_json($value);
            }
            

		}else{
            $collect[$key] = $value; 
		}

	}

	return $collect;
}


/**
 * 
 * Handle Media Upload
 * 
 */
 function TMEA_handle_upload( $attachment ) {

        //get xml content & store 
        global $wp_filesystem;
    

        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        require_once(  ABSPATH . '/wp-admin/includes/image.php' );

        // Extract the file name and extension from the url.
        $filename = basename( $attachment['url'] );

       
        /***
         * 
         * 
         * TO-DO: Test wp_safe_remote_get instead of wp_remote_get
         * wp_safe_remote_get fails on localhost URL's
         * 
         */
        $file_content = wp_remote_retrieve_body( wp_remote_get( $attachment['url'] ) );

        if ( empty( $file_content ) ) {
            return false;
        }

        $upload = wp_upload_bits(
            $filename,
            null,
            $file_content
        );

        $post = [
            'post_title' => $filename,
            'guid' => $upload['url'],
        ];

        $info = wp_check_filetype( $upload['file'] );

        if ( $info ) {
            $post['post_mime_type'] = $info['type'];
        } else {
            return $attachment;
        }

        $post_id = wp_insert_attachment( $post, $upload['file'] );
        wp_update_attachment_metadata(
            $post_id,
            wp_generate_attachment_metadata( $post_id, $upload['file'] )
        );
        
        update_post_meta( $post_id, '_TMEA_image_hash', sha1( $attachment['url'] ) );

        $new_attachment = [
            'id' => $post_id,
            'url' => $upload['url'],
        ];

        return $new_attachment;
 }


 /**
 * 
 * Custom Icons
 * 
 */

function TMEA_get_icons_url( $filename, $ext_type = 'css' ) {
    $suffix = '';
    if ($ext_type == 'css') {
        $suffix = '.min';
    }
    $url = TMEA_PLUGINS_URL . 'assets/icon-library/' . $ext_type . '/' . $filename . $suffix;
    return $url . '.' . $ext_type;
}

function TMEA_custom_icons( $attachment ) {
    $TMEA_icon_list = array(
        'tm-material-icons' => [
            'name' => 'tm-material-icons',
            'label' => esc_html__( 'Material Icons', 'theme-masters-elementor' ),
            'url' => TMEA_get_icons_url( 'material-icons' ),
            'enqueue' => [ TMEA_get_icons_url( 'material-icons' ) ],
            'prefix' => 'tm-material-icon-',
            'displayPrefix' => '',
            'labelIcon' => 'tm-material-icon-flag',
            'ver' => '3.0.1',
            'fetchJson' => TMEA_get_icons_url( 'material-icons', 'json' ),
            'native' => true
        ],
        'tm-fontisto' => [
            'name' => 'tm-fontisto',
            'label' => esc_html__( 'Fontisto', 'theme-masters-elementor' ),
            'url' => TMEA_get_icons_url( 'fontisto' ),
            'enqueue' => [ TMEA_get_icons_url( 'fontisto' ) ],
            'prefix' => 'fi-',
            'displayPrefix' => 'fi',
            'labelIcon' => 'fi fi-flag',
            'ver' => '3.0.4',
            'fetchJson' => TMEA_get_icons_url( 'fontisto', 'json' ),
            'native' => true
        ],
        'tm-iconic-font' => [
            'name' => 'tm-iconic-font',
            'label' => esc_html__( 'Iconic Font', 'theme-masters-elementor' ),
            'url' => TMEA_get_icons_url( 'iconic-font' ),
            'enqueue' => [ TMEA_get_icons_url( 'iconic-font' ) ],
            'prefix' => 'im-',
            'displayPrefix' => 'im',
            'labelIcon' => 'im im-flag',
            'ver' => '1.3.0',
            'fetchJson' => TMEA_get_icons_url( 'iconic-font', 'json' ),
            'native' => true
        ],
        'tm-linear-icons' => [
            'name' => 'tm-linear-icons',
            'label' => esc_html__( 'Linear Icons', 'theme-masters-elementor' ),
            'url' => TMEA_get_icons_url( 'linear-icons' ),
            'enqueue' => [ TMEA_get_icons_url( 'linear-icons' ) ],
            'prefix' => 'lnr-',
            'displayPrefix' => 'lnr',
            'labelIcon' => 'lnr lnr-flag',
            'ver' => '1.0.0',
            'fetchJson' => TMEA_get_icons_url( 'linear-icons', 'json' ),
            'native' => true
        ],
    );

    if (function_exists('TMEA_get_option') && TMEA_get_option('tm-material-icons')) {
        unset($TMEA_icon_list['tm-material-icons']);
    }

    if (function_exists('TMEA_get_option') && TMEA_get_option('tm-fontisto')) {
        unset($TMEA_icon_list['tm-fontisto']);
    }

    if (function_exists('TMEA_get_option') && TMEA_get_option('tm-iconic-font')) {
        unset($TMEA_icon_list['tm-iconic-font']);
    }

    if (function_exists('TMEA_get_option') && TMEA_get_option('tm-linear-icons')) {
        unset($TMEA_icon_list['tm-linear-icons']);
    }

    return $TMEA_icon_list;
}

if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_icons')) {
    add_filter( 'elementor/icons_manager/additional_tabs', 'TMEA_custom_icons', 98, 3 );
}

/* ---------------------------------------------------------
Ajax Search
----------------------------------------------------------- */

function TMEA_post_title_filter($where, &$wp_query) {
    global $wpdb;
    if ( $search_term = $wp_query->get( 'TMEA_search_post_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
    }
    return $where;
}

function TMEA_ajax_post_search() {
    $term = strtolower( $_GET['term'] );
    $post_type = strtolower( $_GET['post_type'] );
    $max = strtolower( $_GET['posts_per_page'] );
    if ((isset($post_type)) && (!empty($post_type))) {
        $selected_post_type = $post_type;
    } else {
        $selected_post_type = 'post';
    }
    if ((isset($max)) && (!empty($max))) {
        $selected_max = $max;
    } else {
        $selected_max = 5;
    }
    
    $suggestions = array();
    
    add_filter( 'posts_where', 'TMEA_post_title_filter', 10, 2 );
    $loop = new WP_Query( 
        array(
            'post_type' => $selected_post_type, 
            'post_status' => 'publish',
            'posts_per_page' => $max, 
            'TMEA_search_post_title' => $term
        )
    );
    remove_filter( 'posts_where', 'TMEA_post_title_filter', 10 );
		
    if ($loop->have_posts()) {
    while( $loop->have_posts() ) {
        $loop->the_post();
        $price = '';
        if (($selected_post_type == 'product') && (class_exists( 'woocommerce' ))) {
            $product = wc_get_product( get_the_ID() );
            $price = '<div class="tmea-search-ui-price">' . $product->get_price_html() . '</div>';
        }
        $suggestion = array();
        if (has_post_thumbnail()) {
            $post_img_id = get_post_thumbnail_id();
            $post_img_array = wp_get_attachment_image_src($post_img_id, 'thumbnail', true);
            $post_img = $post_img_array[0];
            $post_img_output = '<div class="tmea-search-ui-img"><img src="' . $post_img . '" /></div>';
            $suggestion['label'] = html_entity_decode($post_img_output . '<div class="tmea-search-ui-title">' . get_the_title() . '</div>' . $price);
        } else {
            $suggestion['label'] = html_entity_decode('<div class="tmea-search-ui-title">' . get_the_title() . '</div>' . $price);
        }
        $suggestion['value'] = get_permalink();
        $suggestions[] = $suggestion;
    }
    } else {
        $suggestion = array();
        $suggestion['label'] = '';
        $suggestion['value'] = '';
        $suggestions[] = $suggestion;
    }
    
    wp_reset_postdata();
    	
    $response = wp_json_encode( $suggestions );
    print $response;
    exit();
}


add_action( 'wp_ajax_TMEA_ajax_post_search', 'TMEA_ajax_post_search' );
add_action( 'wp_ajax_nopriv_TMEA_ajax_post_search', 'TMEA_ajax_post_search' );

function TMEA_ajax_bbpress_search() {
    $term = strtolower( $_GET['term'] );
    $max = strtolower( $_GET['posts_per_page'] );
    if ((isset($max)) && (!empty($max))) {
        $selected_max = $max;
    } else {
        $selected_max = 5;
    }
    
    $suggestions = array();
    
    add_filter( 'posts_where', 'TMEA_post_title_filter', 10, 2 );
    $loop = new WP_Query( 
        array(
            'post_type' => array('forum', 'topic'), 
            'post_status' => 'publish',
            'posts_per_page' => $max, 
            'TMEA_search_post_title' => $term
        )
    );
    remove_filter( 'posts_where', 'TMEA_post_title_filter', 10 );
		
    if ($loop->have_posts()) {
    while( $loop->have_posts() ) {
        $loop->the_post();
        $suggestion = array();
        $suggestion['label'] = html_entity_decode('<div class="tmea-search-ui-title">' . get_the_title() . '</div>');
        $suggestion['value'] = get_permalink();
        $suggestions[] = $suggestion;
    }
    } else {
        $suggestion = array();
        $suggestion['label'] = '';
        $suggestion['value'] = '';
        $suggestions[] = $suggestion;
    }
    
    wp_reset_postdata();
    	
    $response = wp_json_encode( $suggestions );
    print $response;
    exit();
}


add_action( 'wp_ajax_TMEA_ajax_bbpress_search', 'TMEA_ajax_bbpress_search' );
add_action( 'wp_ajax_nopriv_TMEA_ajax_bbpress_search', 'TMEA_ajax_bbpress_search' );