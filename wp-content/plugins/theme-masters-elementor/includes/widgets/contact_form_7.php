<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Contact_Form_7 extends Widget_Base {

	public function get_name() {
		return 'tme-contact_form_7';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Contact Form 7', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-contact_form_7' ];
	}
    
    public function get_icon() {
		return 'eicon-form-horizontal';
	}
    
    public function get_contact_forms() {
		$args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
        $cf7Forms = get_posts( $args );
        $list = array();
        $list[0] = esc_html__( 'Select a contact form', 'theme-masters-elementor' );
        foreach ( $cf7Forms as $form ) {
            $list[$form->ID] = $form->post_title;
        }
        return $list;
	}
    
	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'form_content',
			[
				'label' => esc_html__( 'Contact Form', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'subtitle', [
				'label' => esc_html__( 'Sub Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'subtitle_html_tag',
			[
				'label' => esc_html__( 'Sub Title HTML Tag', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'p',
			]
		);
        
        $this->add_control(
			'form',
			[
				'label' => esc_html__( 'Select Form', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 0,
				'options' => $this->get_contact_forms(),
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
                    '{{WRAPPER}} .tme-cf7form' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-cf7form p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-cf7form label' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				
				'selector' => '{{WRAPPER}} .tme-cf7form,{{WRAPPER}} .tme-cf7form p,{{WRAPPER}} .tme-cf7form label',
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
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-cf7-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-cf7-title',
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => esc_html__( 'Text Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-cf7-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_title',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-cf7-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-cf7-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();

		// section start
		$this->start_controls_section(
			'section_subtitle_style',
			[
				'label' => esc_html__( 'Sub Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-cf7-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				
				'selector' => '{{WRAPPER}} .tme-cf7-subtitle',
			]
		);

		$this->add_responsive_control(
			'subtitle_align',
			[
				'label' => esc_html__( 'Text Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'End', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-cf7-subtitle' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hr_subtitle',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-cf7-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'subtitle_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-cf7-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
				
				'selector' => '{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit),{{WRAPPER}} .tme-cf7form textarea'
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
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-cf7form textarea' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit)::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-cf7form textarea::placeholder' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit)' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-cf7form textarea' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit),{{WRAPPER}} .tme-cf7form textarea'
			]
		);
        
        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit)' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-cf7form textarea' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit),{{WRAPPER}} .tme-cf7form textarea'
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
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit):focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-cf7form textarea:focus' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit):focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-cf7form textarea:focus' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit):focus,{{WRAPPER}} .tme-cf7form textarea:focus'
			]
		);
        
        $this->add_responsive_control(
			'border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit):focus' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-cf7form textarea:focus' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit):focus,{{WRAPPER}} .tme-cf7form textarea:focus'
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
					'{{WRAPPER}} .tme-cf7form input[type="text"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form input[type="number"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form input[type="email"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form input[type="tel"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form input[type="url"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form input[type="password"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form input[type="search"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form select' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-cf7form textarea' => 'width: {{SIZE}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-cf7form textarea' => 'max-height: {{VALUE}}px;',
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
                    '{{WRAPPER}} .tme-cf7form input:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-cf7form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .tme-cf7form > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
				
				'selector' => '{{WRAPPER}} .tme-cf7form input.wpcf7-submit',
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
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input.wpcf7-submit'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input.wpcf7-submit'
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
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit:hover' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input.wpcf7-submit:hover'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-cf7form input.wpcf7-submit:hover'
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
                    '{{WRAPPER}} .tme-cf7form input.wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    '{{WRAPPER}} .tme-cf7form input.wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-cf7form input.wpcf7-submit' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_tip_style',
			[
				'label' => esc_html__( 'Validation Tip', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'tip_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} span.wpcf7-not-valid-tip' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'tip_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} span.wpcf7-not-valid-tip' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tip_typography',
				
				'selector' => '{{WRAPPER}} span.wpcf7-not-valid-tip',
			]
		);
        
        $this->add_control(
			'tip_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tip_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} span.wpcf7-not-valid-tip'
			]
		);
        
        $this->add_responsive_control(
			'tip_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} span.wpcf7-not-valid-tip' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'tip_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'tip_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} span.wpcf7-not-valid-tip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'tip_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} span.wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} div.wpcf7-response-output' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'msg_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'msg_typography',
				
				'selector' => '{{WRAPPER}} div.wpcf7-response-output',
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
				'selector' => '{{WRAPPER}} div.wpcf7-response-output'
			]
		);
        
        $this->add_responsive_control(
			'msg_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'msg_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} div.wpcf7-response-output'
			]
		);
        
        $this->add_control(
			'warning_heading',
			[
				'label' => esc_html__( 'Warning Messages', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'warning_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-spam-blocked' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-validation-errors' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-acceptance-missing' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'warning_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-spam-blocked' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-validation-errors' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-acceptance-missing' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'warning_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-spam-blocked' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-validation-errors' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-acceptance-missing' => 'border-color: {{VALUE}};',
				]
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
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-mail-sent-ng' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-aborted' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'error_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-mail-sent-ng' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-aborted' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'error_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-mail-sent-ng' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpcf7-response-output.wpcf7-aborted' => 'border-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'success_heading',
			[
				'label' => esc_html__( 'Success Messages', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'success_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-mail-sent-ok' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'success_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-mail-sent-ok' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'success_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} div.wpcf7-response-output.wpcf7-mail-sent-ok' => 'border-color: {{VALUE}};'
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
                    '{{WRAPPER}} div.wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    '{{WRAPPER}} div.wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        $form_id = '';
        if ($settings['form'] == 0) {
            $args = array(
                'post_type' => 'wpcf7_contact_form',
                'numberposts' => 1,
                'order' => 'ASC'
            );
            $cf7Forms = get_posts( $args );
            $form_id = $cf7Forms[0]->ID;
        } else {
            $form_id = $settings['form'];
        }
		echo '<div class="tme-form-wrapper"><div class="tme-form-wrapper-inner">';
		if ($settings['title']) {
			echo '<' . $settings['title_html_tag'] . ' class="tme-cf7-title">';
			echo esc_html($settings['title']);
			echo '</' . $settings['title_html_tag'] . '>';
		}
		if ($settings['subtitle']) {
			echo '<' . $settings['subtitle_html_tag'] . ' class="tme-cf7-subtitle">';
			echo esc_html($settings['subtitle']);
			echo '</' . $settings['subtitle_html_tag'] . '>';
		}
        echo do_shortcode('[contact-form-7 id="' . $form_id . '" title="' . get_the_title($form_id) . '" html_id="tme-cf7form-' . $this->get_id() . '" html_class="tme-cf7form"]');
        echo '</div></div>';
        ?>

<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Contact_Form_7() );