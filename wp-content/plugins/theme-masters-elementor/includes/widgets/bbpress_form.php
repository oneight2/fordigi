<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

if (!defined( 'WP_USE_THEMES' )) {
    define ('WP_USE_THEMES', true);
}

class Widget_TMEA_bbpress_form extends Widget_Base {

	public function get_name() {
		return 'tme-bbpress_form';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'bbPress Form', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-bbpress_form' ];
	}
    
    public function get_icon() {
		return 'eicon-form-horizontal';
	}
    
	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'form_content',
			[
				'label' => esc_html__( 'Form', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'form',
			[
				'label' => esc_html__( 'Select Form', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bbp-forum-form',
				'options' => [
					'bbp-forum-form' => esc_html__( 'New Forum', 'theme-masters-elementor' ),
                    'bbp-topic-form' => esc_html__( 'New Topic', 'theme-masters-elementor' ),
                    'bbp-search-form' => esc_html__( 'Search', 'theme-masters-elementor' ),
                    'bbp-login' => esc_html__( 'Login', 'theme-masters-elementor' ),
                    'bbp-register' => esc_html__( 'Register', 'theme-masters-elementor' ),
                    'bbp-lost-pass' => esc_html__( 'Lost Password', 'theme-masters-elementor' ),
				]
			]
		);

		$this->add_control(
			'forum_id',
			[
				'label' => esc_html__( 'Forum (Optional)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => TMEA_get_forums(),
				'condition' => ['form' => 'bbp-topic-form'],
			]
		);
       
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_form_container_style',
			[
				'label' => esc_html__( 'Form Container', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'form_width',
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
                'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper > .tme-form-wrapper-inner' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'form_align',
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
					'{{WRAPPER}} .tme-form-wrapper' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'form_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
         $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'form_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-form-wrapper > .tme-form-wrapper-inner',
			]
		);
        
        $this->add_control(
			'form_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper-inner' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-form-wrapper-inner p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner label' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner,{{WRAPPER}} .tme-form-wrapper-inner p,{{WRAPPER}} .tme-form-wrapper-inner label',
			]
		);
        
        $this->add_control(
			'form_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'form_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper > .tme-form-wrapper-inner'
			]
		);
        
        $this->add_responsive_control(
			'form_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper > .tme-form-wrapper-inner' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'form_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper > .tme-form-wrapper-inner'
			]
		);
        
        $this->add_control(
			'form_hr_4',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'form_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper > .tme-form-wrapper-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'form_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_input_style',
			[
				'label' => esc_html__( 'Input & Textarea', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button),{{WRAPPER}} .tme-form-wrapper-inner textarea'
			]
		);
        
        $this->add_control(
			'input_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->start_controls_tabs( 'form_input_style' );
        
        $this->start_controls_tab(
			'form_input_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button)::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea::placeholder' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button)' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button),{{WRAPPER}} .tme-form-wrapper-inner textarea'
			]
		);
        
        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button)' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button),{{WRAPPER}} .tme-form-wrapper-inner textarea'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'form_input_hover',
			[
				'label' => esc_html__( 'Focus', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button):focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea:focus' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button):focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea:focus' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button):focus,{{WRAPPER}} .tme-form-wrapper-inner textarea:focus'
			]
		);
        
        $this->add_responsive_control(
			'border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner input:not(.button):focus' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea:focus' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button):focus,{{WRAPPER}} .tme-form-wrapper-inner textarea:focus'
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'input_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_responsive_control(
			'input_width',
			[
				'label' => esc_html__( 'Input & Textarea Width', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="text"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="number"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="email"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="tel"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="url"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="password"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-form-wrapper-inner input[type="search"]' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner select' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'textarea_height',
			[
				'label' => esc_html__( 'Textarea Max. Height (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 1,
                'default' => 200,
                'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'max-height: {{VALUE}}px;',
				],
			]
		);
        
        $this->add_responsive_control(
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_responsive_control(
			'input_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper-inner input:not(.button)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-form-wrapper-inner textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_btn_style',
			[
				'label' => esc_html__( 'Submit Button', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner .button',
			]
		);
        
        $this->add_control(
			'btn_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  
        
        $this->start_controls_tabs( 'tabs_button_style' );
        
        $this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'btn_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner .button' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner .button' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner .button'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner .button' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner .button'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'btn_text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner .button:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner .button:hover' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner .button:hover'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-form-wrapper-inner .button:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-form-wrapper-inner .button:hover'
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'btn_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper-inner .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-form-wrapper-inner .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__( 'Button Width', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tme-form-wrapper-inner .button' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_msg_style',
			[
				'label' => esc_html__( 'Messages', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'msg_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.bbp-template-notice' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.bbp-template-notice a' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'msg_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.bbp-template-notice' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'msg_typography',
				
				'selector' => '{{WRAPPER}} div.bbp-template-notice',
			]
		);
        
        $this->add_control(
			'msg_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'msg_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} div.bbp-template-notice'
			]
		);
        
        $this->add_responsive_control(
			'msg_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} div.bbp-template-notice' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'msg_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} div.bbp-template-notice'
			]
		);
        
        $this->add_control(
			'error_heading',
			[
				'label' => esc_html__( 'Error Messages', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'error_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.bbp-template-notice.error' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.bbp-template-notice.warning' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'error_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.bbp-template-notice.error' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.bbp-template-notice.warning' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'error_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.bbp-template-notice.error' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.bbp-template-notice.warning' => 'border-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'msg_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'msg_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} div.bbp-template-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'msg_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} div.bbp-template-notice' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
    }
    
    protected function render() {
		$settings = $this->get_settings_for_display();
		$form = $settings['form'];
		$forum_id = $settings['forum_id'];
		echo '<div class="tme-form-wrapper"><div class="tme-form-wrapper-inner">';
		if ($form == 'bbp-topic-form' && !empty($forum_id)) {
			echo do_shortcode(shortcode_unautop('[bbp-topic-form forum_id=' . $forum_id . ']'));
		} else {
			echo do_shortcode(shortcode_unautop('[' . $form . ']'));
		}	
        echo '</div></div>';
        ?>

<?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_bbpress_form() );