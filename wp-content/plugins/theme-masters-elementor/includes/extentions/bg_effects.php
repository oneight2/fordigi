<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Section_TMEA_BG_Effects {

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
    }
    
    public static function add_section( Element_Base $element ) {

        $element->start_controls_section(
            '_section_css_effects',
            [
                'label' => esc_html__( 'TMEA Background Effects', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $element->add_control(
            'tmea_bg_effects_enable',
            [
                'label' => esc_html__( 'Enable Background Effects', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_preview',
            [
                'label' => esc_html__( 'Preview', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'tmea_bg_effects_enable' => 'yes'
                ]
            ]
        );

        $element->add_control(
			'tmea_bg_effects_selected',
			[
                'label' => esc_html__( 'Background Effects', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'birds' => esc_html__( 'Birds', 'theme-masters-elementor' ),
                    'fog' => esc_html__( 'Fog', 'theme-masters-elementor' ),
                    'waves' => esc_html__( 'Waves', 'theme-masters-elementor' ),
                    'clouds' => esc_html__( 'Clouds', 'theme-masters-elementor' ),
                    'globe' => esc_html__( 'Globe', 'theme-masters-elementor' ),
                    'net' => esc_html__( 'Net', 'theme-masters-elementor' ),
                    'cells' => esc_html__( 'Cells', 'theme-masters-elementor' ),
                    'dots' => esc_html__( 'Dots', 'theme-masters-elementor' ),
                    'rings' => esc_html__( 'Rings', 'theme-masters-elementor' ),
                    'halo' => esc_html__( 'Halo', 'theme-masters-elementor' )
				],
                'default' => 'birds',
                'condition' => [
                    'tmea_bg_effects_enable' => 'yes'
                ],
                'frontend_available' => true
			]
        );

        $element->add_control(
            'tmea_bg_effects_mouse',
            [
                'label' => esc_html__( 'Mouse Controls', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'tmea_bg_effects_enable' => 'yes'
                ],
            ]
        );

        $element->add_control(
            'tmea_bg_effects_touch',
            [
                'label' => esc_html__( 'Touch Controls', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'tmea_bg_effects_enable' => 'yes'
                ],
            ]
        );

        $element->add_control(
			'tmea_bg_effects_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tmea-bg-effects' => 'opacity: {{VALUE}};'
                ],
                'condition' => [
                    'tmea_bg_effects_enable' => 'yes'
                ]
			]
		);

        $element->add_control(
			'tmea_bg_effects_color_1',
			[
				'label' => esc_html__( 'Color 1', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'birds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );
        
        $element->add_control(
			'tmea_bg_effects_color_2',
			[
				'label' => esc_html__( 'Color 2', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'birds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_highlight',
			[
				'label' => esc_html__( 'Highlight Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_midtone',
			[
				'label' => esc_html__( 'Mid Tone Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_lowlight',
			[
				'label' => esc_html__( 'Low Light Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_base',
			[
				'label' => esc_html__( 'Base Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_wavecolor',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'waves',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_skycolor',
			[
				'label' => esc_html__( 'Sky Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_cloudcolor',
			[
				'label' => esc_html__( 'Cloud Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_cloudshadow',
			[
				'label' => esc_html__( 'Cloud Shadow Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_suncolor',
			[
				'label' => esc_html__( 'Sun Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_sunglarecolor',
			[
				'label' => esc_html__( 'Sun Glare Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_sunlightcolor',
			[
				'label' => esc_html__( 'Sun Light Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_globebg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'globe',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_globe_color_1',
			[
				'label' => esc_html__( 'Color 1', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'globe',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );
        
        $element->add_control(
			'tmea_bg_effects_globe_color_2',
			[
				'label' => esc_html__( 'Color 2', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'globe',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_netcolor',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'net',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_netbgcolor',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'net',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_cellcolor_1',
			[
				'label' => esc_html__( 'Color 1', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'cells',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_cellcolor_2',
			[
				'label' => esc_html__( 'Color 2', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'cells',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_dots_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'dots',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_dots_color_1',
			[
				'label' => esc_html__( 'Color 1', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'dots',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_dots_color_2',
			[
				'label' => esc_html__( 'Color 2', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'dots',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_rings_color',
			[
				'label' => esc_html__( 'Base Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'rings',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_halo_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'halo',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );

        $element->add_control(
			'tmea_bg_effects_halo_base',
			[
				'label' => esc_html__( 'Base Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'frontend_available' => true,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'halo',
                        ]
                    ]
                ],
                'alpha' => false
			]
        );
        
        $element->add_control(
            'tmea_bg_effects_bird_size',
            [
                'label' => esc_html__( 'Bird Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 4,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'birds',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_quantity',
            [
                'label' => esc_html__( 'Quantity', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 0.1,
                'default' => 4,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'birds',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_speed_limit',
            [
                'label' => esc_html__( 'Speed Limit', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 10,
                'step' => 0.1,
                'default' => 5,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'birds',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_blurfactor',
            [
                'label' => esc_html__( 'Blur Factor', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 0.9,
                'step' => 0.1,
                'default' => 0.6,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_zoom',
            [
                'label' => esc_html__( 'Zoom', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 3,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_speed',
            [
                'label' => esc_html__( 'Speed', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 5,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'fog',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_shininess',
            [
                'label' => esc_html__( 'Shininess', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 150,
                'step' => 1,
                'default' => 30,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'waves',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_waveheight',
            [
                'label' => esc_html__( 'Wave Height', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 40,
                'step' => 1,
                'default' => 15,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'waves',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_wavespeed',
            [
                'label' => esc_html__( 'Wave Speed', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 2,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'waves',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_wavezoom',
            [
                'label' => esc_html__( 'Zoom', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.7,
                'max' => 1.8,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'waves',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_cloudspeed',
            [
                'label' => esc_html__( 'Speed', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 3,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'clouds',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_netpoints',
            [
                'label' => esc_html__( 'Points', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'default' => 10,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'net',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_netdistance',
            [
                'label' => esc_html__( 'Max. Distance', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 40,
                'step' => 1,
                'default' => 20,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'net',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_netspacing',
            [
                'label' => esc_html__( 'Spacing', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 20,
                'step' => 1,
                'default' => 15,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'net',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_cellsize',
            [
                'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 5,
                'step' => 0.1,
                'default' => 1.5,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'cells',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_cellspeed',
            [
                'label' => esc_html__( 'Speed', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 5,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'cells',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_dotsize',
            [
                'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.5,
                'max' => 10,
                'step' => 0.1,
                'default' => 3,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'dots',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_dotspacing',
            [
                'label' => esc_html__( 'Spacing', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 100,
                'step' => 0.1,
                'default' => 35,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'dots',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_halo_size',
            [
                'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 3,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'halo',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_halo_amplitude',
            [
                'label' => esc_html__( 'Amplitude Factor', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 3,
                'step' => 0.1,
                'default' => 1,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'halo',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_halo_xoffset',
            [
                'label' => esc_html__( 'X Offset', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -0.5,
                'max' => 0.5,
                'step' => 0.1,
                'default' => 0,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'halo',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_bg_effects_halo_yoffset',
            [
                'label' => esc_html__( 'Y Offset', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -0.5,
                'max' => 0.5,
                'step' => 0.1,
                'default' => 0,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'tmea_bg_effects_enable',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'tmea_bg_effects_selected',
                            'value' => 'halo',
                        ]
                    ]
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_section();
        
    }
}

Section_TMEA_BG_Effects::instance();
