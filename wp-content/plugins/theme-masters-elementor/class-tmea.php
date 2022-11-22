<?php
/**
 * TMEA setup
 *
 * @package TM Elementor Addons
 * @since 1.0
 */
 
/**
 * Main TMEA Class.
 *
 * @class TMEA
 */
final class TMEA {

	/**
	 * TMEA version.
	 *
	 * @var string
	 */
	public $version = '3.4.1';

	/**
	 * The single instance of the class.
	 *
	 * @var TMEA
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Main TMEA Instance.
	 *
	 * Ensures only one instance of TMEA is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @return TMEA - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * TMEA Constructor.
	 */
	public function __construct() {
		$this->define_constants(); 
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * When WP has loaded all plugins, trigger the `TMEA_loaded` hook.
	 *
	 * This ensures `TMEA_loaded` is called only after all other plugins
	 * are loaded, to avoid issues caused by plugin directory naming changing
	 * the load order. See #21524 for details.
	 *
	 * @since 1.0
	 */
	public function on_plugins_loaded() {
		do_action( 'TMEA_loaded' );
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ), -1 );		 
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ));
	}

	/**
	 * Admin Scripts
	 */
	function admin_scripts($hook){
		if ( 'toplevel_page_TMEA_settings' != $hook ) {
			return;
		}
		global $wp_version;
		wp_enqueue_style('TMEA-admin', TMEA_PLUGINS_URL . 'assets/admin/admin.css', false, TMEA_VERSION);
		wp_enqueue_script('TMEA-admin-tabs' , TMEA_PLUGINS_URL . 'assets/admin/tabs.js', array( 'jquery' ), TMEA_VERSION, true );
		
		/**
		 * CMB2 WP 5.4.2+ compatibility
		 */
		if( version_compare( $wp_version, '5.4.2' , '>=' ) ) {
			wp_localize_script(
			'wp-color-picker',
			'wpColorPickerL10n',
			array(
				'clear'            => esc_html__( 'Clear', 'theme-masters-elementor' ),
				'clearAriaLabel'   => esc_html__( 'Clear color', 'theme-masters-elementor' ),
				'defaultString'    => esc_html__( 'Default', 'theme-masters-elementor' ),
				'defaultAriaLabel' => esc_html__( 'Select default color', 'theme-masters-elementor' ),
				'pick'             => esc_html__( 'Select Color', 'theme-masters-elementor' ),
				'defaultLabel'     => esc_html__( 'Color value', 'theme-masters-elementor' )
			)
			);
		}
	}

	/**
	 * Define Constants.
	 */
	private function define_constants() {
		$this->define( 'TMEA_ABSPATH', dirname( TMEA_PLUGIN_FILE ) . '/' );
		$this->define( 'TMEA_PLUGIN_BASENAME', plugin_basename( TMEA_PLUGIN_FILE ) );
		$this->define( 'TMEA_VERSION', $this->version );	
		$this->define( 'TMEA_PLUGINS_URL', plugins_url( '/', TMEA_PLUGIN_FILE ) );	
		$this->define( 'TMEA_PLUGIN_DIR_PATH', plugin_dir_path( TMEA_PLUGIN_FILE ) );	
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string $name Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		if ( file_exists( dirname( TMEA_PLUGIN_FILE ) . '/includes/cmb2/init.php' ) ) {
			require_once dirname( TMEA_PLUGIN_FILE ) . '/includes/cmb2/init.php';
		} elseif ( file_exists(  dirname( TMEA_PLUGIN_FILE ) . '/includes/CMB2/init.php' ) ) {
			require_once dirname( TMEA_PLUGIN_FILE ) . '/includes/CMB2/init.php';
		}
		include_once TMEA_ABSPATH . 'admin/admin-dashboard.php';
		include_once TMEA_ABSPATH . 'includes/admin-fields.php';
		include_once TMEA_ABSPATH . 'includes/settings.php';		
		include_once TMEA_ABSPATH . 'includes/helpers.php';
		include_once TMEA_ABSPATH . 'includes/shortcodes.php';
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_animations')) {
			include_once TMEA_ABSPATH . 'includes/extentions/animations.php';
		}
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_protected_content')) {
			include_once TMEA_ABSPATH . 'includes/extentions/protected_content.php';
		}
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_parallax_bg')) {
			include_once TMEA_ABSPATH . 'includes/extentions/parallax_bg.php';
		}
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_bg_effects')) {
			include_once TMEA_ABSPATH . 'includes/extentions/bg_effects.php';
		}
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_gradient_bg_anim')) {
			include_once TMEA_ABSPATH . 'includes/extentions/gradient_bg.php';
		}
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_shape_divider')) {
			include_once TMEA_ABSPATH . 'includes/extentions/shape_dividers.php';
		}
		if (function_exists('TMEA_get_option') && !TMEA_get_option('ext_template_shortcode')) {
			include_once TMEA_ABSPATH . 'includes/extentions/template_shortcode.php';
		}
		include_once TMEA_ABSPATH . 'includes/elementor-config.php';
	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {
	}
 
	/**
	 * Init TMEA when WordPress Initialises.
	 */
	public function init() {
		// Before init action.
		do_action( 'before_TMEA_init' );

		// Set up localisation.
		$this->load_plugin_textdomain();

		// Init action.
		do_action( 'TMEA_init' );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/theme-masters-elementor/theme-masters-elementor-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/theme-masters-elementor-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = determine_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'theme-masters-elementor' );
		unload_textdomain( 'theme-masters-elementor' );
		load_textdomain( 'theme-masters-elementor', WP_LANG_DIR . '/theme-masters-elementor/theme-masters-elementor-' . $locale . '.mo' );
		load_plugin_textdomain( 'theme-masters-elementor', false, plugin_basename( dirname( TMEA_PLUGIN_FILE ) ) . '/languages' );
	} 
}