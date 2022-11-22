<?php
use Elementor\Plugin;

class TMEA_Shortcode{

    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        add_shortcode('tm-template', [$this, 'render_shortcode']);
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        if ( is_admin() ) {
			add_action( 'manage_elementor_library_posts_columns', [ $this, 'admin_columns_headers' ] );
			add_action( 'manage_elementor_library_posts_custom_column', [ $this, 'admin_columns_content' ], 10, 2 );
		}
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ]);
    }

    public function admin_scripts($hook) {
        global $post_type;
        if( 'elementor_library' == $post_type && 'edit.php' == $hook) {
            wp_enqueue_style('TMEA-shortcode', TMEA_PLUGINS_URL . 'admin/css/shortcode.css');
            wp_enqueue_script('TMEA-shortcode' , TMEA_PLUGINS_URL . 'admin/js/shortcode.js', array( 'jquery' ), TMEA_VERSION, true );
        }
    }

    public function admin_columns_headers( $defaults ) {
		$defaults['tmea_shortcode'] = esc_html__( 'TMEA Shortcode', 'theme-masters-elementor' );
		return $defaults;
	}

	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'tmea_shortcode' === $column_name ) { ?>
            <div class="tmea-shortcode-wrapper">
                <input id="tmea-shortcode-input-<?php echo esc_attr($post_id); ?>" class="tmea-shortcode-input" type="text" readonly onfocus="this.select()" value="[tm-template id=<?php echo esc_attr($post_id); ?>]" />
                <div class="tmea-shortcode-tooltip">
                    <a class="tmea-shortcode-btn button button-primary" data-clipboard-target="#tmea-shortcode-input-<?php echo esc_attr($post_id); ?>">
                        <i class="eicons eicon-copy"></i>
                    </a>
                </div>
            </div>
		<?php }
	}

    public function render_shortcode($atts = []){

        if(!class_exists('Elementor\Plugin')){
            return '';
        }
        
        if(!isset($atts['id']) || empty($atts['id'])){
            return '';
        }

        return Plugin::instance()->frontend->get_builder_content_for_display($atts['id']);
    }

    public function enqueue_styles(){
        Plugin::instance()->frontend->enqueue_styles();
    }

}

/**
 * Returns the main instance of TMEA_Shortcode.
 *
 * @since 1.0
 * @return TMEA_Shortcode
 */
function TMEA_Shortcode() {  
	return TMEA_Shortcode::instance();
}

// Global for backwards compatibility.
$GLOBALS['TMEA_Shortcode'] = TMEA_Shortcode();