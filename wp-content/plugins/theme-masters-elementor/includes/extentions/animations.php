<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Section_TMEA_Animations {

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
        add_action( 'elementor/element/common/_section_style/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
    }
    
    public static function add_controls_section( Element_Base $element ) {
        $element->start_controls_section(
            '_section_css_effects',
            [
                'label' => esc_html__( 'TMEA Animations', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'tmea_transform_fx',
            [
                'label' => esc_html__( 'Enable Animation', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_transform_fx_duration',
            [
                'label' => esc_html__( 'Animation Duration', 'theme-masters-elementor' ),
                'description' => esc_html__( 'How long you want it to last in seconds.', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_transform_fx_delay',
            [
                'label' => esc_html__( 'Animation Delay (Second)', 'theme-masters-elementor' ),
                'description' => esc_html__( 'How long you want to wait before the animation starts.', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 0
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
			'tmea_transform_fx_timing',
			[
                'label' => esc_html__( 'Animation Timing', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Specifies the speed curve of the animation.', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'linear' => esc_html__( 'Linear', 'theme-masters-elementor' ),
                    'ease' => esc_html__( 'Ease', 'theme-masters-elementor' ),
                    'ease-in' => esc_html__( 'Ease In', 'theme-masters-elementor' ),
                    'ease-out' => esc_html__( 'Ease Out', 'theme-masters-elementor' ),
                    'ease-in-out' => esc_html__( 'Ease In Out', 'theme-masters-elementor' ),
				],
                'default' => 'linear',
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
			]
        );
        
        $element->add_control(
			'tmea_transform_fx_direction',
			[
                'label' => esc_html__( 'Animation Direction', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Which direction you want the frames to flow.', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'normal' => esc_html__( 'Normal', 'theme-masters-elementor' ),
                    'reverse' => esc_html__( 'Reverse', 'theme-masters-elementor' ),
                    'alternate' => esc_html__( 'Alternate', 'theme-masters-elementor' ),
                    'alternate-reverse' => esc_html__( 'Alternate Reverse', 'theme-masters-elementor' )
				],
                'default' => 'alternate',
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
			]
        );
        
        $element->add_control(
			'tmea_transform_fx_iteration',
			[
                'label' => esc_html__( 'Iteration Count', 'theme-masters-elementor' ),
                'description' => esc_html__( 'How many times you want the animation to repeat.', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'infinite' => esc_html__( 'Infinite', 'theme-masters-elementor' ),
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
				],
                'default' => 'infinite',
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
			]
        );

        $element->add_control(
			'anim_hr_1',
			[
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
			]
		); 

        $element->start_controls_tabs( 'tabs_transform_style' );
        
        $element->start_controls_tab(
			'tab_transform_translate',
			[
                'label' => esc_html__( 'Translate', 'theme-masters-elementor'),
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ]
			]
		);
        
        $element->add_responsive_control(
            'tmea_transform_fx_translate_x',
            [
                'label' => esc_html__( 'Translate X (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_translate_x_to',
            [
                'label' => esc_html__( 'Translate X (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_translate_y',
            [
                'label' => esc_html__( 'Translate Y (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_translate_y_to',
            [
                'label' => esc_html__( 'Translate Y (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );
        
        $element->end_controls_tab();

		$element->start_controls_tab(
			'tab_transform_rotate',
			[
                'label' => esc_html__( 'Rotate', 'theme-masters-elementor'),
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
			]
		);

        $element->add_responsive_control(
            'tmea_transform_fx_rotate_x',
            [
                'label' => esc_html__( 'Rotate X (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_rotate_x_to',
            [
                'label' => esc_html__( 'Rotate X (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_rotate_y',
            [
                'label' => esc_html__( 'Rotate Y (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_rotate_y_to',
            [
                'label' => esc_html__( 'Rotate Y (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_rotate_z',
            [
                'label' => esc_html__( 'Rotate Z (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_rotate_z_to',
            [
                'label' => esc_html__( 'Rotate Z (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab(
			'tab_transform_scale',
			[
                'label' => esc_html__( 'Scale', 'theme-masters-elementor'),
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
			]
		);

        $element->add_responsive_control(
            'tmea_transform_fx_scale_x',
            [
                'label' => esc_html__( 'Scale X (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_scale_x_to',
            [
                'label' => esc_html__( 'Scale X (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_scale_y',
            [
                'label' => esc_html__( 'Scale Y (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_scale_y_to',
            [
                'label' => esc_html__( 'Scale Y (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_transform_fx_opacity',
            [
                'label' => esc_html__( 'Opacity (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );
        
        $element->add_control(
            'tmea_transform_fx_opacity_to',
            [
                'label' => esc_html__( 'Opacity (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => .1
                    ]
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab(
			'tab_transform_skew',
			[
                'label' => esc_html__( 'Skew', 'theme-masters-elementor'),
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
			]
        );
        
        $element->add_responsive_control(
            'tmea_transform_fx_skew_x',
            [
                'label' => esc_html__( 'Skew X (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_skew_x_to',
            [
                'label' => esc_html__( 'Skew X (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_skew_y',
            [
                'label' => esc_html__( 'Skew Y (From)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_responsive_control(
            'tmea_transform_fx_skew_y_to',
            [
                'label' => esc_html__( 'Skew Y (To)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                    ]
                ],
                'default' => [
                    'size' => 0
                ],
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_tab();
        $element->end_controls_tabs();

        $element->add_control(
			'anim_hr_2',
			[
				'label' => esc_html__( 'Custom Breakpoints', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
			]
		);
        
        $element->add_control(
            'tmea_transform_fx_tablet',
            [
                'label' => esc_html__( 'Tablet', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => get_option('elementor_viewport_lg', true),
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_transform_fx_mobile',
            [
                'label' => esc_html__( 'Mobile', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => get_option('elementor_viewport_md', true),
                'condition' => [
                    'tmea_transform_fx' => 'yes'
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_section();
        
    }
}

Section_TMEA_Animations::instance();
