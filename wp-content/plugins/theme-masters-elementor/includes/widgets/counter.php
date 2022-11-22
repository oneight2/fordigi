<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Counter extends Widget_Base {

	public function get_name() {
		return 'tme-counter';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Counter', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-counter' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-counter' ];
	}

	public function get_icon() {
		return 'eicon-counter';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'countdown_content',
  			[
  				'label' => esc_html__( 'Counter', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		); 
        
        $this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);

		$this->add_control(
			'selected_value',
			[
				'label' => esc_html__( 'Value', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom' => esc_html__( 'Custom Number', 'theme-masters-elementor' ),
                    'posts' => esc_html__( 'Posts', 'theme-masters-elementor' ),
                    'comments' => esc_html__( 'Comments', 'theme-masters-elementor' ),
                    'users' => esc_html__( 'Registered Users (BbPress)', 'theme-masters-elementor' ),
                    'forums' => esc_html__( 'Forums (BbPress)', 'theme-masters-elementor' ),
                    'topics' => esc_html__( 'Topics (BbPress)', 'theme-masters-elementor' ),
                    'replies' => esc_html__( 'Replies (BbPress)', 'theme-masters-elementor' ),
					'topic_tags' => esc_html__( 'Topic Tags (BbPress)', 'theme-masters-elementor' ),
					'members' => esc_html__( 'Members (BuddyPress)', 'theme-masters-elementor' ),
					'groups' => esc_html__( 'Groups (BuddyPress)', 'theme-masters-elementor' ),
					'activity' => esc_html__( 'Activity (BuddyPress)', 'theme-masters-elementor' ),
				],
			]
		);
        
        $this->add_control(
			'starting_number',
			[
				'label' => esc_html__( 'Starting Number', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => '',
                'dynamic' => [
					'active' => true,
				]
			]
		);
        
        $this->add_control(
			'ending_number',
			[
				'label' => esc_html__( 'Ending Number', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 100,
                'dynamic' => [
					'active' => true,
				],
				'condition' => ['selected_value' => 'custom']
			]
		);
        
        $this->add_control(
			'prefix', [
				'label' => esc_html__( 'Number Prefix', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => '$',
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'suffix', [
				'label' => esc_html__( 'Number Suffix', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Plus', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Cool Number', 'theme-masters-elementor' ),
                'label_block' => true
			]
		);
        
        $this->end_controls_section();
        
        // section start
  		$this->start_controls_section(
  			'settings_content',
  			[
  				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		); 
        
        $this->add_control(
			'content_layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'v-layout',
				'options' => [
					'h-layout'  => esc_html__( 'Horizontal', 'theme-masters-elementor' ),
					'h-layout-reverse' => esc_html__( 'Horizontal Reverse', 'theme-masters-elementor' ),
					'h-layout-alt'  => esc_html__( 'Horizontal Alt', 'theme-masters-elementor' ),
					'h-layout-reverse-alt' => esc_html__( 'Horizontal Reverse Alt', 'theme-masters-elementor' ),
                    'v-layout'  => esc_html__( 'Vertical', 'theme-masters-elementor' ),
					'v-layout-reverse' => esc_html__( 'Vertical Reverse', 'theme-masters-elementor' ),
				],
			]
		);
        
        $this->add_responsive_control(
			'horizontal_h_align',
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
				'default' => 'center',
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout',
                        ],
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout-reverse',
						],
						[
                            'name'  => 'content_layout',
                            'value' => 'h-layout-alt',
                        ],
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout-reverse-alt',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-counter.h-layout' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .tme-counter.h-layout-reverse' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .tme-counter.h-layout-alt' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .tme-counter.h-layout-reverse-alt' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'horizontal_v_align',
			[
				'label' => esc_html__( 'Vertical Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout',
                        ],
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout-reverse',
                        ],
						[
                            'name'  => 'content_layout',
                            'value' => 'h-layout-alt',
                        ],
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout-reverse-alt',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-counter.h-layout' => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .tme-counter.h-layout-reverse' => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .tme-counter.h-layout-alt' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .tme-counter.h-layout-reverse-alt' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);

		$this->add_responsive_control(
			'horizontal_text_align',
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
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
						[
                            'name'  => 'content_layout',
                            'value' => 'h-layout-alt',
                        ],
                        [
                            'name'  => 'content_layout',
                            'value' => 'h-layout-reverse-alt',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-counter-h-alt' => 'text-align: {{VALUE}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'vertical_h_align',
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
				'default' => 'center',
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'content_layout',
                            'value' => 'v-layout',
                        ],
                        [
                            'name'  => 'content_layout',
                            'value' => 'v-layout-reverse',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-counter.v-layout' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .tme-counter.v-layout-reverse' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);

        $this->add_control(
			'anim_duration',
			[
				'label' => esc_html__( 'Animation Duration (ms)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 100,
				'default' => 1000
			]
		);
        
        $this->add_control(
			'scroll_anim_switcher',
			[
				'label' => esc_html__( 'Scroll Based Animation', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Activate animation when the counter scrolls into view.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'seperator_switcher',
			[
				'label' => esc_html__( 'Thousand Seperator', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
  
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_counter_style',
			[
				'label' => esc_html__( 'Counter', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'counter_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-counter',
			]
		);
        
        $this->add_control(
			'counter_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'counter_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-counter'
			]
		);
        
        $this->add_responsive_control(
			'counter_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-counter' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'counter_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-counter'
			]
		);
        
        $this->add_control(
			'counter_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'counter_width',
			[
				'label' => esc_html__( 'Maximum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tme-counter' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'counter_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-counter-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tme-counter-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);
        
        $this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-counter-icon' => 'background-color: {{VALUE}}'
				],
			]
		);
        
        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','rem' ],
                'selectors' => [
                    '{{WRAPPER}} .tme-counter-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'SVG Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-counter-icon svg' => 'width: {{VALUE}}px;',
					'{{WRAPPER}} .tme-counter-icon' => 'width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'icon_height',
			[
				'label' => esc_html__( 'SVG Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-counter-icon' => 'height: {{VALUE}}px;',
					'{{WRAPPER}} .tme-counter-icon i' => 'line-height: {{VALUE}}px;',
					'{{WRAPPER}} .tme-counter-icon svg' => 'height: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_control(
			'icon_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-counter-icon'
			]
		);
        
        $this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-counter-icon' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-counter-icon'
			]
		);
        
        $this->add_control(
			'icon_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-counter-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-counter-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_number_style',
			[
				'label' => esc_html__( 'Number', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-counter-number' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				
				'selector' => '{{WRAPPER}} .tme-counter-number'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'number_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-counter-number',
			]
		);
        
        $this->add_control(
			'number_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'number_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-counter-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
   
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-counter-title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-counter-title'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-counter-title',
			]
		);
        
        $this->add_control(
			'title_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-counter-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
   
        $this->end_controls_section();
	}

	/**
	 * Render 
	 */
	protected function render( ) {
		$settings = $this->get_settings_for_display();
        $starting_number = 0;
        $ending_number = 100;
        if ($settings['starting_number']) {
           $starting_number = $settings['starting_number']; 
        }
        if ($settings['ending_number'] && $settings['selected_value'] == 'custom') {
           $ending_number = $settings['ending_number']; 
        } elseif ($settings['selected_value'] == 'posts') {
			$ending_number = TMEA_post_count();
		} elseif ($settings['selected_value'] == 'comments') {
			$ending_number = TMEA_comment_count();
		} elseif ($settings['selected_value'] == 'users') {
			$ending_number = TMEA_bbpress_user_count();
		} elseif ($settings['selected_value'] == 'forums') {
			$ending_number = TMEA_bbpress_forum_count();
		} elseif ($settings['selected_value'] == 'topics') {
			$ending_number = TMEA_bbpress_topic_count();
		} elseif ($settings['selected_value'] == 'replies') {
			$ending_number = TMEA_bbpress_reply_count();
		} elseif ($settings['selected_value'] == 'topic_tags') {
			$ending_number = TMEA_bbpress_topic_tag_count();
		} elseif ($settings['selected_value'] == 'members') {
			$ending_number = TMEA_bp_member_count();
		} elseif ($settings['selected_value'] == 'groups') {
			$ending_number = TMEA_bp_group_count();
		} elseif ($settings['selected_value'] == 'activity') {
			$ending_number = TMEA_bp_activity_count();
		}
        ?>
        <div id="tme-counter-<?php echo esc_attr($this->get_id()); ?>" class="tme-counter <?php echo esc_attr($settings['content_layout']); ?>">
            <?php if ($settings['icon']['value']) { ?>
            <div class="tme-counter-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
			<?php } ?>
			<?php if (($settings['content_layout'] == 'h-layout-alt') || ($settings['content_layout'] == 'h-layout-reverse-alt')) { ?>
			<div class="tme-counter-h-alt">
			<?php } ?>	
            <div class="tme-counter-number" data-endingnumber="<?php echo esc_attr($ending_number); ?>" data-animduration="<?php echo $settings['anim_duration']; ?>" <?php if ($settings['scroll_anim_switcher']) { ?>data-scrollanim<?php } ?> <?php if ($settings['seperator_switcher']) { ?>data-seperator<?php } ?>>
                <?php echo esc_html($settings['prefix']); ?><span><?php echo esc_html($starting_number); ?></span><?php echo esc_html($settings['suffix']); ?>
            </div>
            <?php if ($settings['title']) { ?>
            <div class="tme-counter-title"><?php echo esc_html($settings['title']); ?></div>
			<?php } ?>
			<?php if (($settings['content_layout'] == 'h-layout-alt') || ($settings['content_layout'] == 'h-layout-reverse-alt')) { ?>
			</div>
			<?php } ?>
        </div>
	<?php
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Counter() );