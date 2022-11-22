<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Section_tmea_gradient_bg {

    protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }
    
    public function __construct() {
		$this->init_hooks();
	}

    public static function init_hooks() {
        add_action( 'elementor/element/section/section_layout/after_section_end', [__CLASS__, 'add_section'] );
        add_action( 'elementor/element/column/section_style/before_section_start', [__CLASS__, 'add_section'] );
    }
    
    public static function add_section( Element_Base $element ) {

        $element->start_controls_section(
            '_section_gradient_anim',
            [
                'label' => esc_html__( 'TMEA Gradient BG Animation', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $element->add_control(
            'tmea_gradient_bg_enable',
            [
                'label' => esc_html__( 'Enable Animation', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true
            ]
        );

        $element->add_control(
			'tmea_gradient_bg_rotate',
			[
				'label' => esc_html__( 'Rotate', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => -45,
                ],
                'frontend_available' => true,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ]
			]
        );

        $element->add_control(
            'tmea_gradient_bg_size',
            [
                'label' => esc_html__( 'Background Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 1000,
                'step' => 10,
                'default' => 400,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_gradient_bg_duration',
            [
                'label' => esc_html__( 'Animation Duration (second)', 'theme-masters-elementor' ),
                'description' => esc_html__( 'How long you want it to last in seconds.', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 15,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
			'tmea_gradient_bg_hr_1',
			[
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ],
			]
		); 

        $element->add_control(
			'tmea_gradient_bg_color_1',
			[
				'label' => esc_html__( 'Color 1', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ee7752',
                'frontend_available' => true,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ]
			]
        );

        $element->add_control(
			'tmea_gradient_bg_color_2',
			[
				'label' => esc_html__( 'Color 2', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e73c7e',
                'frontend_available' => true,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ]
			]
        );

        $element->add_control(
			'tmea_gradient_bg_color_3',
			[
				'label' => esc_html__( 'Color 3', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#23a6d5',
                'frontend_available' => true,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ]
			]
        );

        $element->add_control(
			'tmea_gradient_bg_color_4',
			[
				'label' => esc_html__( 'Color 4', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#23d5ab',
                'frontend_available' => true,
                'condition' => [
                    'tmea_gradient_bg_enable' => 'yes'
                ]
			]
        );

        $element->end_controls_section();
        
    }
}

Section_tmea_gradient_bg::instance();
