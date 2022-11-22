<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\Elementor\OrganizationWidget;
use Crowdfundly\App\Helpers\Elementor\AllCampaignWidget;
use Crowdfundly\App\Helpers\Elementor\SingleCampaignWidget;

/**
 * Elementor support Controller
 * Provides functionality for Elementor.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class ElementorController {

    private $elementor_old_lts = '3.1.4';
	private $current_page;

	public function register() {
		$this->current_page = isset( $_GET['page'] ) ? esc_html( $_GET['page'] ) : null;
		add_action( 'plugins_loaded', [ $this, 'load_elementor_support' ] );
	}

	public function load_elementor_support() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) return;

		$current_page = $this->current_page ? (strpos( $this->current_page, 'crowdfundly' ) === 0) : null;
		if ( ! $this->is_compatible() && $current_page ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}
		
		add_action( 'elementor/init', [ $this, 'init' ] );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'frontend_assets' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'crowdfundly_editor_styles' ] );
	}

	public function is_compatible() {
		return version_compare( ELEMENTOR_VERSION, $this->elementor_old_lts, '>=' );
	}

	public function init() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'add_widgets' ] );
	}

	public function crowdfundly_editor_styles() {
		wp_enqueue_style(
			cf_prefix('-editor-css'),
			cf_asset( 'public/pagebuilders/elementor/icons/style.css' ),
			[],
            CROWDFUNDLY_VERSION,
            'all' 
		);
	}

	public function frontend_assets() {
		wp_enqueue_style( 
			cf_prefix('-slick'), 
			cf_asset( 'public/vendors/slick-dist/slick/slick.css' ),
			[],
            CROWDFUNDLY_VERSION,
            'all' 
		);

		wp_enqueue_style(
			cf_asset('slick-theme'), 
			cf_asset( 'public/vendors/slick-dist/slick/slick-theme.css' ),
			[],
            CROWDFUNDLY_VERSION,
            'all'
		);

		wp_enqueue_script( 
			cf_prefix('-slickjs'), 
			cf_asset( 'public/vendors/slick-dist/slick/slick.min.js' ),
			array( 'jquery' ),
            CROWDFUNDLY_VERSION,
            true
		);

		wp_enqueue_script(
			cf_prefix('-elementor-main-js'), 
			cf_asset( 'public/pagebuilders/elementor/main.js' ), 
			array( 'jquery' ),
            CROWDFUNDLY_VERSION,
            'all' 
		);
	}

	public function add_category($elements_manager) {
		$elements_manager->add_category(
			'crowdfundly_elementor_category',
			array(
				'title' => __( 'Crowdfundly', 'crowdfundly' ),
				'icon' => '',
			)
		);
	}

	public function add_widgets($widgets_manager) {
		$widgets_manager->register_widget_type( new OrganizationWidget() );
		$widgets_manager->register_widget_type( new AllCampaignWidget() );
		$widgets_manager->register_widget_type( new SingleCampaignWidget() );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			__( '%1$s requires %2$s version %3$s or greater.', 'crowdfundly' ),
			'<strong>' . __( 'Crowdfundly', 'crowdfundly' ) . '</strong>',
			'<strong>' . __( 'Elementor', 'crowdfundly' ) . '</strong>',
			$this->elementor_old_lts
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

}
