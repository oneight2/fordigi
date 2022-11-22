<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Countdown extends Widget_Base {

	public function get_name() {
		return 'tme-countdown';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Countdown', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-countdown' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-countdown' ];
	}

	public function get_icon() {
		return 'eicon-countdown';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'countdown_content',
  			[
  				'label' => esc_html__( 'Countdown', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		); 

		$this->add_control(
			'due_date',
			[
				'label' => esc_html__( 'Due Date', 'theme-masters-elementor' ),
                'description' => sprintf( esc_html__( 'Date set according to your timezone: %s.', 'theme-masters-elementor' ), Utils::get_timezone_string() ),
                'default' => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
			]
		);
        
        $this->add_control(
			'days_switcher',
			[
				'label' => esc_html__( 'Days', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        
        $this->add_control(
			'days', [
				'label' => esc_html__( 'Days', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Days', 'theme-masters-elementor' ),
                'condition' => ['days_switcher' => 'yes'],
                'show_label' => false,
                'label_block' => true
			]
		);
        
        $this->add_control(
			'hours_switcher',
			[
				'label' => esc_html__( 'Hours', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        
        $this->add_control(
			'hours', [
				'label' => esc_html__( 'Hours', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Hours', 'theme-masters-elementor' ),
                'condition' => ['hours_switcher' => 'yes'],
                'show_label' => false,
                'label_block' => true
			]
		);
        
        $this->add_control(
			'minutes_switcher',
			[
				'label' => esc_html__( 'Minutes', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        
        $this->add_control(
			'minutes', [
				'label' => esc_html__( 'Minutes', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Minutes', 'theme-masters-elementor' ),
                'condition' => ['minutes_switcher' => 'yes'],
                'show_label' => false,
                'label_block' => true
			]
		);
        
        $this->add_control(
			'seconds_switcher',
			[
				'label' => esc_html__( 'Seconds', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        
        $this->add_control(
			'seconds', [
				'label' => esc_html__( 'Seconds', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Seconds', 'theme-masters-elementor' ),
                'condition' => ['seconds_switcher' => 'yes'],
                'show_label' => false,
                'label_block' => true
			]
		);
        
        $this->add_control(
			'msg_expire',
			[
				'label' => esc_html__( 'Message After Expire', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_boxes_style',
			[
				'label' => esc_html__( 'Boxes', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'box_width',
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
					'{{WRAPPER}} .tme-countdown > div' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'box_width_2',
			[
				'label' => esc_html__( 'Width (%)', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div' => 'flex: 0 {{SIZE}}%;'
				],
			]
		);
        
        $this->add_responsive_control(
			'box_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tme-countdown > div' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'boxes_h_align',
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
				'selectors' => [
					'{{WRAPPER}} .tme-countdown' => 'justify-content: {{VALUE}};'
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'boxes_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-countdown > div',
			]
		);
        
        $this->add_control(
			'boxes_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div'
			]
		);
        
        $this->add_responsive_control(
			'box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div'
			]
		);
        
        $this->add_control(
			'boxes_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-countdown > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'box_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-countdown > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div' => 'justify-content: {{VALUE}};'
				],
                'toggle' => false
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
					'{{WRAPPER}} .tme-countdown > div' => 'align-items: {{VALUE}};'
				],
                'toggle' => false
			]
		);

        $this->add_control(
			'digits_heading',
			[
				'label' => esc_html__( 'Digits', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'digit_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.tme-countdown-value' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'digit_typography',
				
				'selector' => '{{WRAPPER}} span.tme-countdown-value'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'digit_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} span.tme-countdown-value',
			]
		);
        
        $this->add_control(
			'labels_heading',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.tme-countdown-label' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				
				'selector' => '{{WRAPPER}} span.tme-countdown-label'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'label_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} span.tme-countdown-label',
			]
		);
        
        $this->add_responsive_control(
			'label_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} span.tme-countdown-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'msg_heading',
			[
				'label' => esc_html__( 'Message After Expire', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'msg_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown-msg' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'msg_typography',
				
				'selector' => '{{WRAPPER}} .tme-countdown-msg'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'msg_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown-msg',
			]
		);

		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_days_style',
			[
				'label' => esc_html__( 'Days', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'days_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-days',
			]
		);

		$this->add_control(
			'days_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_control(
			'days_digits',
			[
				'label' => esc_html__( 'Digits', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'days_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-days > span.tme-countdown-value' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'days_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-days span.tme-countdown-value'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'days_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-days > span.tme-countdown-value',
			]
		);

		$this->add_control(
			'days_labels',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'days_label_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-days > span.tme-countdown-label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'days_label_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-days span.tme-countdown-label'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'days_label_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-days > span.tme-countdown-label',
			]
		);
   
		$this->end_controls_section();

		// section start
		$this->start_controls_section(
			'section_hours_style',
			[
				'label' => esc_html__( 'Hours', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'hours_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-hours',
			]
		);

		$this->add_control(
			'hours_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_control(
			'hours_digits',
			[
				'label' => esc_html__( 'Digits', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'hours_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-hours > span.tme-countdown-value' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hours_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-hours span.tme-countdown-value'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'hours_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-hours > span.tme-countdown-value',
			]
		);

		$this->add_control(
			'hours_labels',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hours_label_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-hours > span.tme-countdown-label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hours_label_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-hours span.tme-countdown-label'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'hours_label_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-hours > span.tme-countdown-label',
			]
		);
   
		$this->end_controls_section();

		// section start
		$this->start_controls_section(
			'section_minutes_style',
			[
				'label' => esc_html__( 'Minutes', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'minutes_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-minutes',
			]
		);

		$this->add_control(
			'minutes_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_control(
			'minutes_digits',
			[
				'label' => esc_html__( 'Digits', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'minutes_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-minutes > span.tme-countdown-value' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'minutes_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-minutes span.tme-countdown-value'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'minutes_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-minutes > span.tme-countdown-value',
			]
		);

		$this->add_control(
			'minutes_labels',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'minutes_label_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-minutes > span.tme-countdown-label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'minutes_label_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-minutes span.tme-countdown-label'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'minutes_label_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-minutes > span.tme-countdown-label',
			]
		);
   
		$this->end_controls_section();

		// section start
		$this->start_controls_section(
			'section_seconds_style',
			[
				'label' => esc_html__( 'Seconds', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'seconds_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-seconds',
			]
		);

		$this->add_control(
			'seconds_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_control(
			'seconds_digits',
			[
				'label' => esc_html__( 'Digits', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'seconds_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-seconds > span.tme-countdown-value' => 'color: {{VALUE}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'seconds_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-seconds span.tme-countdown-value'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'seconds_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-seconds > span.tme-countdown-value',
			]
		);

		$this->add_control(
			'seconds_labels',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'seconds_label_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-countdown > div.tme-countdown-seconds > span.tme-countdown-label' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'seconds_label_typography',
				
				'selector' => '{{WRAPPER}} div.tme-countdown-seconds span.tme-countdown-label'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'seconds_label_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-countdown > div.tme-countdown-seconds > span.tme-countdown-label',
			]
		);
   
		$this->end_controls_section();
	
	}

	/**
	 * Render 
	 */
	protected function render( ) {
		$settings = $this->get_settings_for_display();
        ?>
        <div class="tme-countdown <?php echo esc_attr($settings['content_layout']); ?>" data-duedate="<?php echo esc_attr($settings['due_date']); ?>">
            <?php if ($settings['days_switcher']) { ?>
            <div class="tme-countdown-days">
                <span class="tme-countdown-value">00</span><span class="tme-countdown-label"><?php echo esc_html($settings['days']); ?></span>
            </div>
            <?php } ?>
            <?php if ($settings['hours_switcher']) { ?>
            <div class="tme-countdown-hours">
                <span class="tme-countdown-value">00</span><span class="tme-countdown-label"><?php echo esc_html($settings['hours']); ?></span>
            </div>
            <?php } ?>
            <?php if ($settings['minutes_switcher']) { ?>
            <div class="tme-countdown-minutes">
                <span class="tme-countdown-value">00</span><span class="tme-countdown-label"><?php echo esc_html($settings['minutes']); ?></span>
            </div>
            <?php } ?>
            <?php if ($settings['seconds_switcher']) { ?>
            <div class="tme-countdown-seconds">
                <span class="tme-countdown-value">00</span><span class="tme-countdown-label"><?php echo esc_html($settings['seconds']); ?></span>
            </div>
            <?php } ?>
        </div>
        <?php if ($settings['msg_expire']) { ?>
        <div class="tme-countdown-msg" style="display:none;"><?php echo esc_attr($settings['msg_expire']); ?></div>
        <?php } ?>
	<?php
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Countdown() );