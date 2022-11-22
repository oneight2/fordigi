<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Section_TMEA_Parallax_Bg {

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
            '_section_parallax_bg',
            [
                'label' => esc_html__( 'TMEA Parallax Background', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $element->add_control(
            'tmea_parallax_bg_enable',
            [
                'label' => esc_html__( 'Enable Parallax Background', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true
            ]
        );

        $element->add_control(
			'tmea_parallax_bg_type',
			[
				'label' => esc_html__( 'Background Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'img',
				'options' => [
					'img'  => esc_html__( 'Image', 'theme-masters-elementor' ),
					'video'  => esc_html__( 'Video', 'theme-masters-elementor' )
                ],
                'condition' => [
                    'tmea_parallax_bg_enable' => 'yes'
                ],
                'frontend_available' => true
			]
		);

        $element->add_control(
			'tmea_parallax_bg_img',
			[
				'label' => esc_html__( 'Background Image', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'img',
                        ]
                    ]
                ],
                'frontend_available' => true
			]
        );

        $element->add_control(
			'tmea_parallax_bg_video',
			[
				'label' => esc_html__( 'Video Url', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'https://www.youtube.com/watch?v=z7yqtW4Isec',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'video',
                        ]
                    ]
                ],
                'label_block' => true,
                'frontend_available' => true
			]
		);

        $element->add_control(
			'tmea_parallax_bg_speed',
			[
				'label' => esc_html__( 'Parallax Speed', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'max' => 2,
				'step' => 0.1,
                'default' => 0.5,
                'condition' => [
                    'tmea_parallax_bg_enable' => 'yes'
                ],
                'frontend_available' => true
			]
        );
        
        $element->add_control(
			'tmea_parallax_bg_start_time',
			[
                'label' => esc_html__( 'Start Time', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Start time in seconds when video will be started.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 9999,
				'step' => 1,
                'default' => 0,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'video',
                        ]
                    ]
                ],
                'frontend_available' => true
			]
        );
        
        $element->add_control(
			'tmea_parallax_bg_end_time',
			[
                'label' => esc_html__( 'End Time', 'theme-masters-elementor' ),
                'description' => esc_html__( 'End time in seconds when video will be ended.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 9999,
				'step' => 1,
                'default' => 0,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'video',
                        ]
                    ]
                ],
                'frontend_available' => true
			]
        );
        
        $element->add_control(
            'tmea_parallax_bg_loop',
            [
                'label' => esc_html__( 'Loop', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Loop video to play infinitely.', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'video',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_parallax_bg_only_visible',
            [
                'label' => esc_html__( 'Play Only Visible', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Play video only when it is visible on the screen.', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'video',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_parallax_bg_lazy',
            [
                'label' => esc_html__( 'Lazy Loading', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Preload videos only when it is visible on the screen.', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_parallax_bg_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_parallax_bg_type',
                            'value' => 'video',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_parallax_bg_mobile',
            [
                'label' => esc_html__( 'Disable on Mobile Devices', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'condition' => [
                    'tmea_parallax_bg_enable' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_section();
        
    }
}

Section_TMEA_Parallax_Bg::instance();
