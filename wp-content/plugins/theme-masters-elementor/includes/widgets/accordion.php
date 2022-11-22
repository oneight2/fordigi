<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Accordion extends Widget_Base {

	public function get_name() {
		return 'tme-accordion';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Accordion', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-accordion' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-tabs', 'tme-accordion' ];
	}
    
    public function get_icon() {
		return 'eicon-accordion';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'icon_txt_switcher',
			[
				'label' => esc_html__( 'Prefix', 'theme-masters-elementor' ),
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


        $repeater->add_control(
			'title_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'condition' => ['icon_txt_switcher' => 'icon'],
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);

		$repeater->add_control(
			'title_icon_txt',
			[
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'condition' => ['icon_txt_switcher' => 'text'],
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '1'
			]
		);
        
        $repeater->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
        
        $repeater->add_control(
			'text', [
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
				'show_label' => false,
			]
		);
        
        $repeater->add_control(
			'status',
			[
				'label' => esc_html__( 'Opened by default', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'is-open' => [
						'title' => esc_html__( 'On', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'is-default' => [
						'title' => esc_html__( 'Off', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'is-default',
				'toggle' => false,
			]
		);
        
        $repeater->add_control(
			'self_block',
			[
				'label' => esc_html__( 'Block close event on click', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'On', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'Off', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'false',
				'toggle' => false,
			]
		);
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Accordion Items', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
                        'title_icon' => '',
						'title' => esc_html__( 'Title #1', 'theme-masters-elementor' ),
						'text' => esc_html__( 'Item content...', 'theme-masters-elementor' ),
                        'status' => 'is-default',
                        'self_block' => 'false',
					],
					[
                        'title_icon' => '',
						'title' => esc_html__( 'Title #2', 'theme-masters-elementor' ),
						'text' => esc_html__( 'Item content...', 'theme-masters-elementor' ),
                        'status' => 'is-default',
                        'self_block' => 'false',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
			'content_settings',
			[
				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		); 
        
        $this->add_control(
			'html_tag',
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
					'p' => 'p',
				],
				'default' => 'h5',
			]
		);
        
        $this->add_control(
			'hash', [
				'label' => esc_html__( 'Url Sharing', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Off', 'theme-masters-elementor' ),
				'return_value' => 'on',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'open_single',
			[
				'label' => esc_html__( 'Open Single', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'On', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'Off', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'false',
                'description' => esc_html__( 'Open just one accordion at once.', 'theme-masters-elementor' ),
				'toggle' => false,
			]
		);
        
        $this->add_control(
			'self_close',
			[
				'label' => esc_html__( 'Self Close', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'On', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'Off', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'false',
                'description' => esc_html__( 'Close accordion on click outside.', 'theme-masters-elementor' ),
				'toggle' => false,
			]
		);
        
        $this->add_control(
			'scroll',
			[
				'label' => esc_html__( 'Auto Scroll', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'On', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'Off', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'false',
                'description' => esc_html__( 'Scroll to accordion on open.', 'theme-masters-elementor' ),
				'toggle' => false,
			]
		);
        
        $this->add_control(
			'scroll_offset',
			[
				'label' => esc_html__( 'Scroll Offset', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2000,
				'step' => 10,
				'default' => 0
			]
		);
        
        $this->add_control(
			'scroll_speed',
			[
				'label' => esc_html__( 'Scroll Speed', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 10,
				'default' => 400
			]
		);
        
        $this->add_control(
			'open_speed',
			[
				'label' => esc_html__( 'Open Speed', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2000,
				'step' => 10,
				'default' => 200
			]
		);
        
        $this->add_control(
			'close_speed',
			[
				'label' => esc_html__( 'Close Speed', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2000,
				'step' => 10,
				'default' => 200
			]
		);
        
        $this->end_controls_section();  

		$this->start_controls_section(
			'section_accordion_style',
			[
				'label' => esc_html__( 'Accordion', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->start_controls_tabs( 'tabs_accordion_style' );
        
        $this->start_controls_tab(
			'tab_accordion_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordion_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmeaccordion'
			]
		);
        
        $this->add_control(
			'accordion_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordion_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion'
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'accordion_background',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion',
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_accordion_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordion_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion:hover,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open'
			]
		);
        
        $this->add_control(
			'accordion_hover_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-accordions .tmeaccordion.is-open' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordion_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion:hover,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open'
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'accordion_hover_background',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion:hover,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open',
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();  
        
        $this->add_control(
			'hr_accordion_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'accordion_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-accordions .tmeaccordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
       
		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion__head,{{WRAPPER}} .tmeaccordion__head button',
			]
		);
        
        $this->add_responsive_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Arrow Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 100,
				'step' => 1,
				'default' => 4,
                'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head button::after' => 'padding: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'arrow_thickness',
			[
				'label' => esc_html__( 'Arrow Thickness', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 100,
				'step' => 1,
				'default' => 4,
                'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head button::after' => 'border-width: 0 {{VALUE}}px {{VALUE}}px 0;'
				],
			]
		);
        
        $this->add_control(
			'hr_accordion_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->start_controls_tabs( 'tabs_title_style' );
        
        $this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head,{{WRAPPER}} .tme-accordions .tmeaccordion__head button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head,{{WRAPPER}} .tme-accordions .tmeaccordion__head button' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'arrow_color',
			[
				'label' => esc_html__( 'Arrow Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head button:after' => 'border-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordion_title_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion__head'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head:hover,{{WRAPPER}} .tme-accordions .tmeaccordion__head button:hover,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'title_hover_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head:hover,{{WRAPPER}} .tme-accordions .tmeaccordion__head button:hover,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head button' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'arrow_hover_color',
			[
				'label' => esc_html__( 'Arrow Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
				'selectors' => [
                    '{{WRAPPER}} .tme-accordions .tmeaccordion__head  button:hover:after,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head  button:after' => 'border-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordion_title_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head'
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();    
        
        $this->add_control(
			'hr_accordion_3',
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
                    '{{WRAPPER}} .tme-accordions .tmeaccordion__head > button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-accordions .tmeaccordion__head::after' => 'right: {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Prefix', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 100,
				'step' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button .tmeaccordion-prefix' => 'font-size: {{VALUE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Container Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 100,
				'step' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button .tmeaccordion-prefix' => 'width: {{VALUE}}px;min-width: {{VALUE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label' => esc_html__( 'Container Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 100,
				'step' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button .tmeaccordion-prefix' => 'height: {{VALUE}}px;line-height: {{VALUE}}px;'
				],
			]
		);

		$this->add_control(
			'hr_icon_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( 'tabs_icon_style' );
        
        $this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button .tmeaccordion-prefix' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button .tmeaccordion-prefix'
			]
		);  
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head:hover i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button:hover i,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head button i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head:hover .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button:hover .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head button .tmeaccordion-prefix' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg_hover',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion__head:hover i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button:hover i,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head button i',
				'{{WRAPPER}} .tme-accordions .tmeaccordion__head:hover .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button:hover .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion.is-open .tmeaccordion__head button .tmeaccordion-prefix' => 'color: {{VALUE}};'
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_control(
			'hr_icon_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head button i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix,{{WRAPPER}} .tme-accordions .tmeaccordion__head button .tmeaccordion-prefix' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-accordions .tmeaccordion__head i,{{WRAPPER}} .tme-accordions .tmeaccordion__head .tmeaccordion-prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion__body,{{WRAPPER}} .tmeaccordion__body p',
			]
		);
        
        $this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__body,{{WRAPPER}} .tmeaccordion__body p' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-accordions .tmeaccordion__body,{{WRAPPER}} .tmeaccordion__body p' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-accordions .tmeaccordion__body'
			]
		);
        
        $this->add_control(
			'hr_accordion_4',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-accordions .tmeaccordion__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
		$rand = '-' . rand();
        if ( $settings['list'] ) { ?>
            <div class="tme-accordions" data-selfclose="<?php echo $settings['self_close']; ?>" data-opensingle="<?php echo $settings['open_single']; ?>" data-openspeed="<?php echo $settings['open_speed']; ?>" data-closespeed="<?php echo $settings['close_speed']; ?>" data-autoscroll="<?php echo $settings['scroll']; ?>" data-scrollspeed="<?php echo $settings['scroll_speed']; ?>" data-scrolloffset="<?php echo $settings['scroll_offset']; ?>">
            <?php foreach ( $settings['list'] as $item ) { ?>   
                <div id="tme-<?php echo $item['_id'] . $rand; ?>" <?php if ($settings['hash']) { ?>data-hash="#tme-<?php echo $item['_id'] . $rand; ?>"<?php } ?> class="tmeaccordion <?php echo $item['status']; ?>" data-tmeaccordion-options='{"selfBlock": <?php echo $item['self_block']; ?>}'>
                    <?php echo '<' . $settings['html_tag'] . ' class="tmeaccordion__head">'; ?>
						<?php \Elementor\Icons_Manager::render_icon( $item['title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php if ($item['title_icon_txt']) { echo '<span class="tmeaccordion-prefix">' . $item['title_icon_txt'] . '</span>'; } ?>
						<?php echo $item['title']; ?>
                    <?php echo '</' . $settings['html_tag'] . '>'; ?>
                    <div class="tmeaccordion__body">
                        <?php echo $item['text']; ?>
                    </div>
                </div>
            <?php } ?>    
            </div>
            <?php
		}
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Accordion() );