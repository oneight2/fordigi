<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Smart_Menu extends Widget_Base {

	public function get_name() {
		return 'tme-smart_menu';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Smart Menu', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-smart_menu','elementor-icons-fa-solid','tme-lib-animate' ];
    }
    
    public function get_script_depends() {
		return [ 'tme-smart_menu' ];
	}
    
    public function get_icon() {
		return 'eicon-nav-menu';
    }
    
	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Smart Menu', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $this->add_control(
			'menu',
			[
				'label' => esc_html__( 'Select a Menu', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => TMEA_get_menus(),
			]
        );
        
        $this->add_control(
			'menu_layout',
			[
				'label' => esc_html__( 'Menu Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'sm-horizontal' => esc_html__( 'Horizontal', 'theme-masters-elementor' ),
					'sm-horizontal-justified' => esc_html__( 'Horizontal-Justified', 'theme-masters-elementor' ),
                    'sm-vertical' => esc_html__( 'Vertical', 'theme-masters-elementor' )
				],
                'default' => 'sm-horizontal',
			]
		);
		
		$this->add_control(
			'menu_h_align',
			[
				'label' => esc_html__( 'Horizontal Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'menu_layout',
                            'value' => 'sm-horizontal',
                        ],
                        [
                            'name'  => 'menu_layout',
                            'value' => 'sm-vertical',
                        ]
                    ]
                ],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tmea-smart-menu-desktop.tmea-smart-menu-wrapper' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);

		$this->add_control(
			'vertical_menu_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition' => [
                    'menu_layout' => 'sm-vertical'
                ],
				'selectors' => [
					'{{WRAPPER}} .tmea-smart-menu-desktop.tmea-smart-menu-wrapper .tmea-sm-skin.sm-vertical' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'smart_menu_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		$this->add_control(
            'menu_breakpoint',
            [
                'label' => esc_html__( 'Mobile Breakpoint', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => get_option('elementor_viewport_lg', true)
            ]
        );

        $this->add_control(
			'menu_toggle', [
				'label' => esc_html__( 'Mobile Menu Toggle', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
		);

		$this->add_control(
			'menu_toggle_text', [
				'label' => esc_html__( 'Mobile Menu Toggle Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'MENU', 'theme-masters-elementor' ),
				'condition' => [
                    'menu_toggle' => 'yes'
                ]
			]
		);

		$this->add_control(
			'menu_toggle_text_h_align',
			[
				'label' => esc_html__( 'Mobile Menu Toggle Alignment', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
                    'menu_toggle' => 'yes'
                ],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tmea-smart-menu-toggle-container' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);
		
		$this->add_control(
			'menu_collapsible_behavior',
			[
				'label' => esc_html__( 'Collapsible Behavior', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'theme-masters-elementor' ),
					'toggle' => esc_html__( 'Toggle', 'theme-masters-elementor' ),
					'link' => esc_html__( 'Link', 'theme-masters-elementor' ),
					'accordion' => esc_html__( 'Accordion', 'theme-masters-elementor' ),
					'accordion-toggle' => esc_html__( 'Accordion-Toggle', 'theme-masters-elementor' ),
					'accordion-link' => esc_html__( 'Accordion-Link', 'theme-masters-elementor' ),
				],
                'default' => 'link',
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_main_menu_container',
			[
				'label' => esc_html__( 'Menu Container', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'main_menu_background',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tmea-sm-skin',
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_menu_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin',
			]
		);
        
        $this->add_responsive_control(
			'main_menu_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'main_menu_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin',
			]
        );

        $this->add_control(
			'main_menu_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration (ms)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
                'default' => 0.2,
                'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin a' => 'transition: all {{VALUE}}s ease-in-out;'
				]
			]
		);
		
		$this->add_control(
			'main_menu_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'main_menu_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'main_menu_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_main_menu_items',
			[
				'label' => esc_html__( 'Main Menu Items', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'main_menu_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tmea-sm-skin > li > a',
			]
        );
        
        $this->add_control(
			'main_menu_icon',
			[
				'label' => esc_html__( 'Dropdown Menu Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
                    'caret' => esc_html__( 'Caret', 'theme-masters-elementor' ),
                    'caret-square' => esc_html__( 'Caret-Square', 'theme-masters-elementor' ),
					'chevron' => esc_html__( 'Chevron', 'theme-masters-elementor' ),
                    'chevron-circle' => esc_html__( 'Chevron-Circle', 'theme-masters-elementor' ),
                    'plus' => esc_html__( 'Plus', 'theme-masters-elementor' ),
                    'plus-circle' => esc_html__( 'Plus-Circle', 'theme-masters-elementor' ),
				],
                'default' => 'caret',
			]
        );

        $this->add_responsive_control(
            'main_menu_icon_size',
            [
                'label' => esc_html__( 'Dropdown Menu Icon Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin a .sub-arrow:before' => 'font-size: {{VALUE}}px;'
				]
            ]
		);

		$this->add_control(
			'main_menu_icon_color',
			[
				'label' => esc_html__( 'Icon Color (Mobile)', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin a .sub-arrow' => 'color: {{VALUE}};'
				]
			]
        );
		
		$this->add_control(
			'main_menu_icon_bg',
			[
				'label' => esc_html__( 'Icon Background Color (Mobile)', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin a .sub-arrow' => 'background: {{VALUE}};'
				]
			]
		);
		
		$this->add_control(
			'main_menu_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->start_controls_tabs( 'main_menu_link_style' );
        
        $this->start_controls_tab(
			'main_menu_link_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor'),
			]
        );  

        $this->add_control(
			'main_menu_item_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin > li > a' => 'color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'main_menu_item_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin > li > a' => 'background: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_menu_item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin > li > a',
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'main_menu_link_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor'),
			]
        );

        $this->add_control(
			'main_menu_item_color_hover',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin > li > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li > a:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li > a:active' => 'color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'main_menu_item_bg_hover',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin > li > a:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li > a:focus' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li > a:active' => 'background: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_menu_item_border_hover',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin > li > a:hover,{{WRAPPER}} .tmea-sm-skin > li > a:focus,{{WRAPPER}} .tmea-sm-skin > li > a:active',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
			'main_menu_link_active',
			[
				'label' => esc_html__( 'Active', 'theme-masters-elementor'),
			]
        );  

        $this->add_control(
			'main_menu_item_color_active',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a.highlighted' => 'color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'main_menu_item_bg_active',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a.highlighted' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:focus' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:active' => 'background: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_menu_item_border_active',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a,{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a.highlighted,{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:hover,{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:focus,{{WRAPPER}} .tmea-sm-skin > li.current-menu-item > a:active',
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'main_menu_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'main_menu_item_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tmea-sm-skin > li > a > .sub-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_sub_menus',
			[
				'label' => esc_html__( 'Sub Menus', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'menu_sub_menu_animation',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ANIMATION
			]
		);

        $this->add_control(
			'menu_sub_menu_max_width',
			[
				'label' => esc_html__( 'Maximum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'em',
					'size' => 20,
				]
			]
        );
        
        $this->add_control(
			'menu_sub_menu_min_width',
			[
				'label' => esc_html__( 'Minimum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'em',
					'size' => 10,
				]
			]
        );

        $this->add_control(
            'mainMenuSubOffsetX',
            [
                'label' => esc_html__( 'First-level Offset X', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0
            ]
        );

        $this->add_control(
            'mainMenuSubOffsetY',
            [
                'label' => esc_html__( 'First-level Offset Y', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0
            ]
        );

        $this->add_control(
            'subMenusSubOffsetX',
            [
                'label' => esc_html__( 'Second-level Offset X', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0
            ]
        );

        $this->add_control(
            'subMenusSubOffsetY',
            [
                'label' => esc_html__( 'Second-level Offset Y', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0
            ]
        );
        
        $this->add_control(
			'menu_rtl_sub_menus', [
				'label' => esc_html__( 'Right to Left', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
		
		$this->add_control(
			'sub_menu_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'sub_menu_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin ul' => 'background: {{VALUE}};'
				]
			]
        );
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sub_menu_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-smart-menu-desktop .tmea-sm-skin ul',
			]
		);

		$this->add_control(
			'sub_menu_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-smart-menu-desktop .tmea-sm-skin ul' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sub_menu_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-smart-menu-desktop .tmea-sm-skin ul'
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_sub_menu_items',
			[
				'label' => esc_html__( 'Sub Menu Items', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'main_sub_menu_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tmea-sm-skin li ul li a',
			]
        );
        
        $this->start_controls_tabs( 'main_sub_menu_link_style' );
        
        $this->start_controls_tab(
			'main_sub_menu_link_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor'),
			]
        );  

        $this->add_control(
			'main_sub_menu_item_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin li ul li a' => 'color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'main_sub_menu_item_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin li ul li a' => 'background: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_sub_menu_item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin li ul li a',
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'main_sub_menu_link_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor'),
			]
        );

        $this->add_control(
			'main_sub_menu_item_color_hover',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-sm-skin li ul li a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin li ul li a:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin li ul li a:active' => 'color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'main_sub_menu_item_bg_hover',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin li ul li a:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin li ul li a:focus' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin li ul li a:active' => 'background: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_sub_menu_item_border_hover',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin li ul li a:hover,{{WRAPPER}} .tmea-sm-skin li ul li a:focus,{{WRAPPER}} .tmea-sm-skin li ul li a:active',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
			'main_sub_menu_link_active',
			[
				'label' => esc_html__( 'Active', 'theme-masters-elementor'),
			]
        );  

        $this->add_control(
			'main_sub_menu_item_color_active',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a.highlighted' => 'color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'main_sub_menu_item_bg_active',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a.highlighted' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:focus' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:active' => 'background: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_sub_menu_item_border_active',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a,{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a.highlighted,{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:hover,{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:focus,{{WRAPPER}} .tmea-sm-skin ul li.current-menu-item > a:active',
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_control(
			'sub_menu_item_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'main_sub_menu_item_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-sm-skin ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tmea-sm-skin ul li a .sub-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_mobile_menu',
			[
				'label' => esc_html__( 'Mobile Menu Toggle', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mobile_menu_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-smart-menu-toggle',
			]
		);
		
		$this->add_control(
			'mobile_menu_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-smart-menu-toggle' => 'color: {{VALUE}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mobile_menu_background',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-smart-menu-toggle',
			]
        );
		
		$this->add_control(
			'mobile_menu_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tme-smart-menu-toggle' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_menu_text_align',
			[
				'label' => esc_html__( 'Text Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-smart-menu-toggle' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_menu_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mobile_menu_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-smart-menu-toggle',
			]
		);
        
        $this->add_responsive_control(
			'mobile_menu_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-smart-menu-toggle' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mobile_menu_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-smart-menu-toggle',
			]
        );
        
        $this->add_control(
			'mobile_menu_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		$this->add_responsive_control(
			'mobile_menu_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-smart-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'mobile_menu_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-smart-menu-toggle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
       
		$this->end_controls_section();
	}
    
    protected function render() {
        $settings = $this->get_settings_for_display();
		$menu_id = $this->get_id(); 
		$rtl = '';
		if (is_rtl()) {
			$rtl = 'sm-rtl';
		}
		?>
        <div style="display:none;" class="tmea-smart-menu-container <?php if ($settings['menu_rtl_sub_menus']) { echo 'tmea-smart-menu-rtl-submenu'; } ?>" data-animin="<?php echo $settings['menu_sub_menu_animation']; ?>" data-animout="<?php echo TMEA_get_anim_exits($settings['menu_sub_menu_animation']); ?>" data-collapsiblebehavior="<?php echo esc_attr($settings['menu_collapsible_behavior']); ?>" data-mainmenusuboffsetx="<?php echo esc_attr($settings['mainMenuSubOffsetX']); ?>" data-mainmenusuboffsety="<?php echo esc_attr($settings['mainMenuSubOffsetY']); ?>" data-submenussuboffsetx="<?php echo esc_attr($settings['subMenusSubOffsetX']); ?>" data-submenussuboffsety="<?php echo esc_attr($settings['subMenusSubOffsetY']); ?>" data-submenumin="<?php echo esc_attr($settings['menu_sub_menu_min_width']['size'] . $settings['menu_sub_menu_min_width']['unit']); ?>"  data-submenumax="<?php echo esc_attr($settings['menu_sub_menu_max_width']['size'] . $settings['menu_sub_menu_max_width']['unit']); ?>" data-rtlsubmenu="<?php echo esc_attr($settings['menu_rtl_sub_menus']); ?>" data-mtoggle="<?php echo esc_attr($settings['menu_toggle']); ?>" data-bpoint="<?php echo esc_attr($settings['menu_breakpoint']); ?>">
        <?php if ($settings['menu_toggle']) { ?>
            <div class="tmea-smart-menu-toggle-container">
                <div class="tme-smart-menu-toggle">
                    <i class="fas fa-bars"></i> <span><?php echo $settings['menu_toggle_text']; ?></span>
                </div>
            </div>
        <?php } ?>
            <?php wp_nav_menu([
                'menu'            => $settings['menu'],
                'container'       => 'nav',
                'container_id' => 'tmea-smart-menu-wrapper-' . $menu_id,
                'container_class' => 'tmea-smart-menu-wrapper',
                'menu_id'         => 'tmea-smart-menu-' . $menu_id,
                'menu_class'      => 'tmea-smart-menu sm tmea-sm-skin animated ' . $settings['menu_layout'] . ' ' . $settings['main_menu_icon'] . ' ' . $rtl,
                'depth'           => 99
            ]); ?>
        </div>
	<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Smart_Menu() );