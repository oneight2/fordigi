<?php

namespace Crowdfundly\App\Controllers;

/**
 * Customizer support Controller
 * Provides functionality for Customizer.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class CustomizerController extends BaseController
{
    function register()
    {
		add_action( 'customize_register', [ $this, 'customizer_settings' ] );
        add_action( 'customize_preview_init', [ $this, 'enqueue_live_edit_js' ] );
        cf_loadTemplate( 'resources/views/customizer/styles.php' );
	}

	public function customizer_settings($wp_customize)
    {
        $this->load_templates();

		// custom design for pages
		$this->create_sections($wp_customize);

		// custom panel for Crowd Fundly
		$this->create_panel($wp_customize);
	}

    private function load_templates()
    {
        cf_loadTemplate( 'resources/views/customizer/sanitize.php' );

        cf_loadTemplate( 'Helpers/CustomizerControls/HeadingControl.php' );
        cf_loadTemplate( 'Helpers/CustomizerControls/RangeControl.php' );
        cf_loadTemplate( 'Helpers/CustomizerControls/SwitcherControl.php' );
        cf_loadTemplate( 'Helpers/CustomizerControls/DimensionControl.php' );
        cf_loadTemplate( 'Helpers/CustomizerControls/SelectControl.php' );
        cf_loadTemplate( 'Helpers/CustomizerControls/NumberControl.php' );

        cf_loadTemplate( 'resources/views/customizer/pages/organization-page.php' );
        cf_loadTemplate( 'resources/views/customizer/pages/all-campaign-page.php' );
        cf_loadTemplate( 'resources/views/customizer/pages/single-campaign-page.php' );
    }

    private function create_sections($wp_customize)
    {
		$wp_customize->add_section( 'cf_organizaton_page' , array(
			'title'      => __( 'Organization Page','crowdfundly' ),
			'priority'   => 30
		) );	
		organization_page($wp_customize);

		$wp_customize->add_section( 'cf_all_campaign_page' , array(
			'title'      => __( 'All Campaign Page','crowdfundly' ),
			'priority'   => 31
		) );	
		all_campaign($wp_customize);

		$wp_customize->add_section( 'cf_single_campaign_page' , array(
			'title'      => __( 'Single Campaign Page','crowdfundly' ),
			'priority'   => 32
		) );	
		single_campaign($wp_customize);
	}

    private function create_panel($wp_customize)
    {
		$wp_customize->add_panel( 'cf_customize_option', array(
			'priority' 			=> 30,
			'theme_supports' 	=> '',
			'title' 			=> __( 'Crowdfundly', 'crowdfundly' ),
			'description' 		=> __( 'Crowdfundly Pages design.', 'crowdfundly' ),
		) );
		$wp_customize->get_section('cf_organizaton_page')->panel = 'cf_customize_option';
		$wp_customize->get_section('cf_all_campaign_page')->panel = 'cf_customize_option';
		$wp_customize->get_section('cf_single_campaign_page')->panel = 'cf_customize_option';
	}

    public function enqueue_live_edit_js()
    {
		wp_enqueue_script( 
			cf_prefix( '-customizer-js' ),
            cf_asset( 'customizer/js/customizer.js' ),
            array( 'jquery', 'customize-preview' ),
            CROWDFUNDLY_VERSION,
            true 
		);
	}

}
