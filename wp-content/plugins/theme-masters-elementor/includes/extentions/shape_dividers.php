<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Section_tmea_shape_divider {

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
            '_section_shape_divider',
            [
                'label' => esc_html__( 'TMEA Shape Divider', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $element->start_controls_tabs( 'tabs_divider_style' );
        
        $element->start_controls_tab(
			'tab_divider_top',
			[
				'label' => esc_html__( 'TOP', 'theme-masters-elementor'),
			]
        );
        
        $element->add_control(
			'tmea_shape_divider_top',
			[
                'label' => esc_html__( 'Type', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'none' => esc_html__( 'None', 'theme-masters-elementor' ),
                    'basic-triangle' => esc_html__( 'Basic Triangle', 'theme-masters-elementor' ),
                    'big-round' => esc_html__( 'Big Round', 'theme-masters-elementor' ),
                    'book' => esc_html__( 'Book', 'theme-masters-elementor' ),
                    'bubbles' => esc_html__( 'Bubbles', 'theme-masters-elementor' ), 
                    'christmas-trees' => esc_html__( 'Christmas Trees', 'theme-masters-elementor' ),
                    'clouds' => esc_html__( 'Clouds', 'theme-masters-elementor' ),
                    'faded-clouds' => esc_html__( 'Faded Clouds', 'theme-masters-elementor' ),
                    'faded-loops' => esc_html__( 'Faded Loops', 'theme-masters-elementor' ),
                    'faded-slant' => esc_html__( 'Faded Slant', 'theme-masters-elementor' ),
                    'faded-triangle' => esc_html__( 'Faded Triangle', 'theme-masters-elementor' ),
                    'fall-leaves' => esc_html__( 'Fall Leaves', 'theme-masters-elementor' ),
                    'fire' => esc_html__( 'Fire', 'theme-masters-elementor' ),
                    'half-sphere' => esc_html__( 'Half Sphere', 'theme-masters-elementor' ),
                    'iceberg' => esc_html__( 'Iceberg', 'theme-masters-elementor' ),
                    'mountain' => esc_html__( 'Mountain', 'theme-masters-elementor' ),
                    'paint-brush' => esc_html__( 'Paint Brush', 'theme-masters-elementor' ),
                    'paint-drip' => esc_html__( 'Paint Drip', 'theme-masters-elementor' ),
                    'pyramid' => esc_html__( 'Pyramid', 'theme-masters-elementor' ),
                    'rough-edges' => esc_html__( 'Rough Edges', 'theme-masters-elementor' ),
                    'sharp-paper' => esc_html__( 'Sharp Paper', 'theme-masters-elementor' ),
                    'sharp-slants' => esc_html__( 'Sharp Slants', 'theme-masters-elementor' ),
                    'shredded-paper' => esc_html__( 'Shredded Paper', 'theme-masters-elementor' ),
                    'side-triangle' => esc_html__( 'Side Triangle', 'theme-masters-elementor' ),
                    'slant' => esc_html__( 'Slant', 'theme-masters-elementor' ),
                    'slant-down' => esc_html__( 'Slant Down', 'theme-masters-elementor' ),
                    'slant-up' => esc_html__( 'Slant Up', 'theme-masters-elementor' ),
                    'small-triangles' => esc_html__( 'Small Triangles', 'theme-masters-elementor' ),
                    'snowflakes' => esc_html__( 'Snowflakes', 'theme-masters-elementor' ),
                    'three-triangles' => esc_html__( 'Three Triangles', 'theme-masters-elementor' ),
                    'tri-triangle' => esc_html__( 'Tri Triangle', 'theme-masters-elementor' ),
                    'triangle-dent' => esc_html__( 'Triangle Dent', 'theme-masters-elementor' ),
                    'triangle-uneven' => esc_html__( 'Triangle Uneven', 'theme-masters-elementor' ),
                    'wavy-dashed' => esc_html__( 'Wavy Dashed', 'theme-masters-elementor' ),
                    'wavy-loops' => esc_html__( 'Wavy Loops', 'theme-masters-elementor' ),
                    'wavy-motion' => esc_html__( 'Wavy Motion', 'theme-masters-elementor' ),
                    'custom' => esc_html__( 'Custom', 'theme-masters-elementor' )
				],
                'default' => 'none',
                'frontend_available' => true
			]
        );

        $element->add_control(
			'tmea_shape_divider_top_custom',
			[
				'label' => esc_html__( 'Select File', 'theme-masters-elementor' ),
				'type'	=> 'tmea-file-select',
				'placeholder' => esc_html__( 'URL to File', 'theme-masters-elementor' ),
                'default' => TMEA_PLUGINS_URL . 'assets/js/library/dividers/big-round-top.svg',
                'condition' => [
                    'tmea_shape_divider_top' => 'custom'
                ],
                'frontend_available' => true
			]
        );
        
        $element->add_control(
			'tmea_shape_divider_top_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'frontend_available' => true,
                'condition' => [
                    'tmea_shape_divider_top!' => 'none'
                ]
			]
        );

        $element->add_control(
            'tmea_shape_divider_top_width',
            [
                'label' => esc_html__( 'Width (%)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 100
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 300,
                        'step' => 1
                    ]
                ],
                'condition' => [
                    'tmea_shape_divider_top!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_shape_divider_top_height',
            [
                'label' => esc_html__( 'Height (px)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1
                    ]
                ],
                'condition' => [
                    'tmea_shape_divider_top!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_shape_divider_top_flip',
            [
                'label' => esc_html__( 'Flip', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'condition' => [
                    'tmea_shape_divider_top!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_shape_divider_top_zindex',
            [
                'label' => esc_html__( 'Z-index', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => -1,
                'condition' => [
                    'tmea_shape_divider_top!' => 'none'
                ],
                'frontend_available' => true
            ]
        );
        
        $element->end_controls_tab();

		$element->start_controls_tab(
			'tab_divider_bottom',
			[
				'label' => esc_html__( 'BOTTOM', 'theme-masters-elementor'),
			]
		);

        $element->add_control(
			'tmea_shape_divider_bottom',
			[
                'label' => esc_html__( 'Type', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'theme-masters-elementor' ),
                    'basic-triangle' => esc_html__( 'Basic Triangle', 'theme-masters-elementor' ),
                    'big-round' => esc_html__( 'Big Round', 'theme-masters-elementor' ),
                    'book' => esc_html__( 'Book', 'theme-masters-elementor' ),
                    'bubbles' => esc_html__( 'Bubbles', 'theme-masters-elementor' ), 
                    'christmas-trees' => esc_html__( 'Christmas Trees', 'theme-masters-elementor' ),
                    'city-skyline' => esc_html__( 'City Skyline', 'theme-masters-elementor' ),
                    'clouds' => esc_html__( 'Clouds', 'theme-masters-elementor' ),
                    'faded-clouds' => esc_html__( 'Faded Clouds', 'theme-masters-elementor' ),
                    'faded-loops' => esc_html__( 'Faded Loops', 'theme-masters-elementor' ),
                    'faded-slant' => esc_html__( 'Faded Slant', 'theme-masters-elementor' ),
                    'faded-triangle' => esc_html__( 'Faded Triangle', 'theme-masters-elementor' ),
                    'fall-leaves' => esc_html__( 'Fall Leaves', 'theme-masters-elementor' ),
                    'fire' => esc_html__( 'Fire', 'theme-masters-elementor' ),
                    'half-sphere' => esc_html__( 'Half Sphere', 'theme-masters-elementor' ),
                    'iceberg' => esc_html__( 'Iceberg', 'theme-masters-elementor' ),
                    'mountain' => esc_html__( 'Mountain', 'theme-masters-elementor' ),
                    'music-notes' => esc_html__( 'Music Notes', 'theme-masters-elementor' ),
                    'paint-brush' => esc_html__( 'Paint Brush', 'theme-masters-elementor' ),
                    'paint-drip' => esc_html__( 'Paint Drip', 'theme-masters-elementor' ),
                    'pyramid' => esc_html__( 'Pyramid', 'theme-masters-elementor' ),
                    'rough-edges' => esc_html__( 'Rough Edges', 'theme-masters-elementor' ),
                    'sharp-paper' => esc_html__( 'Sharp Paper', 'theme-masters-elementor' ),
                    'sharp-slants' => esc_html__( 'Sharp Slants', 'theme-masters-elementor' ),
                    'shredded-paper' => esc_html__( 'Shredded Paper', 'theme-masters-elementor' ),
                    'side-triangle' => esc_html__( 'Side Triangle', 'theme-masters-elementor' ),
                    'slant' => esc_html__( 'Slant', 'theme-masters-elementor' ),
                    'slant-down' => esc_html__( 'Slant Down', 'theme-masters-elementor' ),
                    'slant-up' => esc_html__( 'Slant Up', 'theme-masters-elementor' ),
                    'small-triangles' => esc_html__( 'Small Triangles', 'theme-masters-elementor' ),
                    'snowflakes' => esc_html__( 'Snowflakes', 'theme-masters-elementor' ),
                    'three-triangles' => esc_html__( 'Three Triangles', 'theme-masters-elementor' ),
                    'tri-triangle' => esc_html__( 'Tri Triangle', 'theme-masters-elementor' ),
                    'triangle-dent' => esc_html__( 'Triangle Dent', 'theme-masters-elementor' ),
                    'triangle-uneven' => esc_html__( 'Triangle Uneven', 'theme-masters-elementor' ),
                    'wavy-dashed' => esc_html__( 'Wavy Dashed', 'theme-masters-elementor' ),
                    'wavy-loops' => esc_html__( 'Wavy Loops', 'theme-masters-elementor' ),
                    'wavy-motion' => esc_html__( 'Wavy Motion', 'theme-masters-elementor' ),
                    'custom' => esc_html__( 'Custom', 'theme-masters-elementor' )
				],
                'default' => 'none',
                'frontend_available' => true
			]
        );

        $element->add_control(
			'tmea_shape_divider_bottom_custom',
			[
				'label' => esc_html__( 'Select File', 'theme-masters-elementor' ),
				'type'	=> 'tmea-file-select',
				'placeholder' => esc_html__( 'URL to File', 'theme-masters-elementor' ),
                'default' => TMEA_PLUGINS_URL . 'assets/js/library/dividers/big-round-bottom.svg',
                'condition' => [
                    'tmea_shape_divider_bottom' => 'custom'
                ],
                'frontend_available' => true
			]
        );

        $element->add_control(
			'tmea_shape_divider_bottom_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'frontend_available' => true,
                'condition' => [
                    'tmea_shape_divider_bottom!' => 'none'
                ]
			]
        );

        $element->add_control(
            'tmea_shape_divider_bottom_width',
            [
                'label' => esc_html__( 'Width (%)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 100
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 300,
                        'step' => 1
                    ]
                ],
                'condition' => [
                    'tmea_shape_divider_bottom!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_shape_divider_bottom_height',
            [
                'label' => esc_html__( 'Height (px)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1
                    ]
                ],
                'condition' => [
                    'tmea_shape_divider_bottom!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_shape_divider_bottom_flip',
            [
                'label' => esc_html__( 'Flip', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'condition' => [
                    'tmea_shape_divider_bottom!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->add_control(
            'tmea_shape_divider_bottom_zindex',
            [
                'label' => esc_html__( 'Z-index', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => -1,
                'condition' => [
                    'tmea_shape_divider_bottom!' => 'none'
                ],
                'frontend_available' => true
            ]
        );

        $element->end_controls_tab();
        $element->end_controls_tabs();

        $element->end_controls_section();
        
    }
}

Section_tmea_shape_divider::instance();
