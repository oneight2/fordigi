<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Search_Form extends Widget_Base {

	public function get_name() {
		return 'tme-search_form';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Search Form', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-search_form','elementor-icons-fa-solid' ];
	}

	public function get_script_depends() {
		return [ 'jquery-ui-autocomplete', 'tme-search_form' ];
    }
    
    public function get_icon() {
		return 'eicon-site-search';
	}
    
	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'section_search_form',
			[
				'label' => esc_html__( 'Search Form', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => esc_html__( 'Post Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'label_block' => true,
				'options' => TMEA_get_post_types(),
			]
		);

		$this->add_control(
			'autocomplete',
			[
				'label' => esc_html__( 'Autocomplete', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'max',
			[
				'label' => esc_html__( 'Maximum number of posts', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 5,
				'condition' => ['autocomplete' => 'yes']
			]
		);

		$this->add_control(
			'min',
			[
				'label' => esc_html__( 'Minimum Length', 'theme-masters-elementor' ),
				'description' => esc_html__( 'Open the menu, if the minimum length has been met.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 3,
				'condition' => ['autocomplete' => 'yes']
			]
		);

		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Menu Opening Delay (ms)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 99999,
				'step' => 1,
				'default' => 0,
				'condition' => ['autocomplete' => 'yes']
			]
		);

		$this->add_control(
			'search_form_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'placeholder', [
				'label' => esc_html__( 'Placeholder', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter a Keyword...', 'theme-masters-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'search_form_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'btn_type',
			[
				'label' => esc_html__( 'Button Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'theme-masters-elementor' ),
						'icon' => 'eicon-star',
					],
					'text' => [
						'title' => esc_html__( 'Text', 'theme-masters-elementor' ),
						'icon' => 'eicon-heading',
					],
				],
				'default' => 'icon',
				'toggle' => true,
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label' => esc_html__( 'Button Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => ['btn_type' => 'icon'],
                'default' => [
					'value' => 'fas fa-search',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'btn_text', [
				'label' => esc_html__( 'Button Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => ['btn_type' => 'text'],
				'label_block' => true,
				'default' => esc_html__( 'Search', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tmea-search-form-container > .tmea-search-form' => 'max-width: {{SIZE}}{{UNIT}};'
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
					'{{WRAPPER}} .tmea-search-form-container' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'form_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container > .tmea-search-form'
			]
		);
        
        $this->add_control(
			'form_hr_1',
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
                    '{{WRAPPER}} .tmea-search-form-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
				
				'selector' => '{{WRAPPER}} .tmea-search-form-container input'
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
					'{{WRAPPER}} .tmea-search-form-container input' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container input::placeholder' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container input' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container input'
			]
		);
        
        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container input' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container input'
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
					'{{WRAPPER}} .tmea-search-form-container input:focus' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container input:focus' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container input:focus'
			]
		);
        
        $this->add_responsive_control(
			'border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container input:focus' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container input:focus'
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
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-search-form-container input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
				
				'selector' => '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn',
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
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn'
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
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn:hover' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn:hover'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn:hover'
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
                    '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    '{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__( 'Button Minimum Width', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tmea-search-form-container button.tmea-search-form-btn' => 'min-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
		$this->end_controls_section();
		
		// section start
		$this->start_controls_section(
			'section_autocomplete_style',
			[
				'label' => esc_html__( 'Autocomplete', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['autocomplete' => 'yes']
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'autocomplete_typography',
				
				'selector' => '.tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'autocomplete_price_typography',
				'label' => esc_html__( 'Price Typography', 'theme-masters-elementor' ),
				
				'selector' => '.tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item .tmea-search-ui-price',
				'condition' => ['post_type' => 'product']
			]
		);

		$this->add_control(
			'autocomplete_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'autocomplete_loader_color',
			[
				'label' => esc_html__( 'Loader Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form.TMEA_ajax_search_loading .tmea-search-form-btn:before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'autocomplete_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'autocomplete_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu'
			]
		);
        
        $this->add_control(
			'autocomplete_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'autocomplete_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu'
			]
		);

		$this->add_control(
			'autocomplete_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->start_controls_tabs( 'tabs_thumbnail_style' );
        
        $this->start_controls_tab(
			'tab_autocomplete_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor'),
			]
		);
		
		$this->add_control(
			'autocomplete_link_color',
			[
				'label' => esc_html__( 'Link Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'autocomplete_item_bg_color',
			[
				'label' => esc_html__( 'Link Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'autocomplete_separator_color',
			[
				'label' => esc_html__( 'Link Separator Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item' => 'border-bottom-color: {{VALUE}};'
				]
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_autocomplete_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor'),
			]
		);

		$this->add_control(
			'autocomplete_link_hover_color',
			[
				'label' => esc_html__( 'Link Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'autocomplete_item_bg_hover_color',
			[
				'label' => esc_html__( 'Link Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item:hover' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'autocomplete_separator_hover_color',
			[
				'label' => esc_html__( 'Link Separator Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item:hover' => 'border-bottom-color: {{VALUE}};'
				]
			]
		);

        $this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'autocomplete_item',
			[
				'label' => esc_html__( 'Link Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
		
		$this->add_control(
			'autocomplete_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_responsive_control(
			'thumb_size',
			[
				'label' => esc_html__( 'Thumbnail Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 150,
				'step' => 1,
				'default' => 40,
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item .tmea-search-ui-img img' => 'width: {{VALUE}}px;'
				],
			]
		);

		$this->add_control(
			'thumb_border_radius',
			[
				'label' => esc_html__( 'Thumbnail Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item .tmea-search-ui-img img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'thumb_padding',
			[
				'label' => esc_html__( 'Thumbnail Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-search-form-container .tmea-search-form .ui-menu .ui-menu-item .tmea-search-ui-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id(); ?>
        <div class="tmea-search-form-container <?php if (is_rtl()) { echo 'form-is-rtl'; } ?>" data-posttype="<?php echo esc_attr($settings['post_type']); ?>" data-smax="<?php echo esc_attr($settings['max']); ?>" data-smin="<?php echo esc_attr($settings['min']); ?>"  data-sdelay="<?php echo esc_attr($settings['delay']); ?>">
			<form id="tmea-search-form-<?php echo $widget_id; ?>" role="search" method="get" class="tmea-search-form ui-front" style="display:flex;" action="<?php echo esc_url(home_url( '/' )); ?>">
				<input type="text" class="tmea-search-form-term autocomplete-<?php echo $settings['autocomplete']; ?><?php if (is_rtl()) { echo '-rtl'; } ?>" placeholder="<?php echo esc_attr($settings['placeholder']); ?>" name="s" />
				<input type="hidden" name="post_type" style="display:none;" value="<?php echo $settings['post_type']; ?>" /> 
                <button type="submit" class="tmea-search-form-btn">
				<?php \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php 
				if ($settings['btn_text']) {
					echo $settings['btn_text'];
				} ?>
				</button>
            </form>
		</div>	
		<?php 
		if ($settings['autocomplete']) {
			wp_localize_script( 'tme-search_form', 'tmeaAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' )) ); 
		}
		?>
	<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Search_Form() );