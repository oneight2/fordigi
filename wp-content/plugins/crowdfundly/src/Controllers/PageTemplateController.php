<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\PageTemplate;

/**
 * Public page template Controller
 * Creates a page template for the public pages
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class PageTemplateController
{
    public function register()
    {
        $posts_template = PageTemplate::get_instance();

        if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
            add_filter( 'page_attributes_dropdown_pages_args', array( $posts_template, 'register_templates' ) );
        } else {
            add_filter( 'theme_page_templates', array( $posts_template, 'add_new_template' ) );
        }

        add_filter( 'wp_insert_post_data', array( $posts_template, 'register_templates' ) );
        add_filter( 'template_include', array( $posts_template, 'view_template' ) );

        $posts_template->load_dependencies(
            'crowdfundly-template.php', __( 'Crowdfundly Template', 'crowdfundly' )
        );
    }
}
