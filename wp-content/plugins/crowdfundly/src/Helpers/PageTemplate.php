<?php

namespace Crowdfundly\App\Helpers;

/**
 * Overwrite the default template for pages.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       1.0.0
 */
class PageTemplate
{
    protected $templates;

    private static $instance;

    public static function get_instance()
    {
        if ( null == self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function load_dependencies($file, $title)
    {
        $this->templates = array( $file => $title );
    }

    public function add_new_template( $posts_templates ) 
    {
        $posts_templates = array_merge( $posts_templates, $this->templates );
        return $posts_templates;
    }

    public function register_templates( $atts ) 
    {
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
        $templates = wp_get_theme()->get_page_templates();
        if ( empty( $templates ) ) {
            $templates = array();
        }

        // New cache, therefore remove the old one
        wp_cache_delete( $cache_key , 'themes');

        // Now add our template to the list of templates by merging our templates
        // with the existing templates array from the cache.
        $templates = array_merge( $templates, $this->templates );

        // Add the modified cache to allow WordPress to pick it up for listing
        // available templates
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );

        return $atts;
    }

    public function view_template( $template ) 
    {
        global $post;
        if ( ! $post ) {
            return $template;
        }

        // Return default template if we don't have a custom one defined
        if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
            return $template;
        }
        $file = CROWDFUNDLY_DIR_PATH . 'src/resources/views/public/'. get_post_meta( $post->ID, '_wp_page_template', true );

        // Just to be safe, we check if the file exist first
        if ( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }

        return $template;
    }
}
