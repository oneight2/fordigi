<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Price_Table extends Widget_Base {

	public function get_name() {
		return 'tme-price_table';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Price Table', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-button', 'tme-price_table' ];
	}
    
    public function get_icon() {
		return 'eicon-price-table';
	}
    
    public function get_btn_skins() {
        $output_skins = apply_filters('tme-btn-skins', array( 
            '' => esc_html__( 'None', 'theme-masters-elementor' ),
            'tme-btn-1' => esc_html__( 'Animation 1', 'theme-masters-elementor' ),
            'tme-btn-2' => esc_html__( 'Animation 2', 'theme-masters-elementor' ),
            'tme-btn-3' => esc_html__( 'Animation 3', 'theme-masters-elementor' ),
            'tme-btn-4' => esc_html__( 'Animation 4', 'theme-masters-elementor' ),
            'tme-btn-5' => esc_html__( 'Animation 5', 'theme-masters-elementor' ),
            'tme-btn-6' => esc_html__( 'Animation 6', 'theme-masters-elementor' ),
            'tme-btn-7' => esc_html__( 'Animation 7', 'theme-masters-elementor' ),
            'tme-btn-8' => esc_html__( 'Animation 8', 'theme-masters-elementor' ),
            
        ));
        return $output_skins;
    }
    
	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'header_content',
			[
				'label' => esc_html__( 'Header', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'header_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => Controls_Manager::ICONS
			]
		);
        
        $this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter your title', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'desc', [
				'label' => esc_html__( 'Description', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Enter your description', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'html_tag',
			[
				'label' => esc_html__( 'Heading Tag', 'theme-masters-elementor' ),
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
				'default' => 'h3',
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'ribbon_content',
			[
				'label' => esc_html__( 'Ribbon', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'show_ribbon',
			[
				'label' => esc_html__( 'Show Ribbon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'ribbon_text', [
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'POPULAR', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'ribbon_style',
			[
				'label' => esc_html__( 'Style', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-price-table-ribbon',
				'options' => [
					'tme-price-table-ribbon'  => esc_html__( 'Ribbon', 'theme-masters-elementor' ),
					'tme-price-table-vertical'  => esc_html__( 'Vertical Text', 'theme-masters-elementor' ),
					'tme-price-table-horizontal'  => esc_html__( 'Horizontal Text', 'theme-masters-elementor' )
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_align',
			[
				'label' => esc_html__( 'Horizontal Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'v-left' => [
						'title' => esc_html__( 'Left', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'v-right' => [
						'title' => esc_html__( 'Right', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
				'default' => 'v-right',
                'toggle' => false
			]
		);
       
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'pricing_content',
			[
				'label' => esc_html__( 'Pricing', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'price_prefix', [
				'label' => esc_html__( 'Price Prefix', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '$', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'price', [
				'label' => esc_html__( 'Price', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '49', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'price_suffix', [
				'label' => esc_html__( 'Price Suffix', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '.99', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'original_price', [
				'label' => esc_html__( 'Original Price', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'period', [
				'label' => esc_html__( 'Period', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'features_content',
			[
				'label' => esc_html__( 'Features', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'item_text', [
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
				'label_block' => true,
			]
		);
        
        $default_icon = [
			'value' => 'far fa-check-circle',
			'library' => 'fa-regular',
		];
        
        $repeater->add_control(
			'item_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => $default_icon,
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}',
				],
			]
		);
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'List Items', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
						'item_text' => esc_html__( 'List Item #1', 'theme-masters-elementor' ),
						'item_icon' => $default_icon
					],
					[
                        'item_text' => esc_html__( 'List Item #2', 'theme-masters-elementor' ),
						'item_icon' => $default_icon
					],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'footer_content',
			[
				'label' => esc_html__( 'Footer', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'btn_text', [
				'label' => esc_html__( 'Button Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'BUY NOW', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'btn_link',
			[
				'label' => esc_html__( 'Link to', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'theme-masters-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'btn_size',
			[
				'label' => esc_html__( 'Button Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-btn-md',
				'options' => [
					'tme-btn-md'  => esc_html__( 'Normal', 'theme-masters-elementor' ),
					'tme-btn-lg'  => esc_html__( 'Large', 'theme-masters-elementor' ),
                    'tme-btn-sm'  => esc_html__( 'Small', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'btn_id',
			[
				'label' => esc_html__( 'Button ID', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows A-Z 0-9  & underscore chars without spaces.', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'footer_info', [
				'label' => esc_html__( 'Additional Info', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'container_zoom',
			[
				'label' => esc_html__( 'Zoom', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0.5,
				'max' => 2.0,
				'step' => 0.1,
				'default' => 1.0,
                'selectors' => [
					'{{WRAPPER}} .tme-price-table' => 'transform:scale({{VALUE}});'
				]
			]
		);

		$this->add_responsive_control(
			'text_align',
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
					'{{WRAPPER}} .tme-price-table-footer' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .tme-price-table-subheader' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} ul.tme-price-table-features' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_width',
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
					'{{WRAPPER}} .tme-price-table' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'container_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'container_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-price-table',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table'
			]
		);
        
        $this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table'
			]
		);
        
        $this->add_control(
			'container_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'container_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Header', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'header_text_align',
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
					'{{WRAPPER}} .tme-price-table-header' => 'align-items: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-price-table-header',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'header_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-header'
			]
		);
        
        $this->add_responsive_control(
			'header_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-header' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_responsive_control(
			'header_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'header_title_heading',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'header_title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-title' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-title',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'header_title_text_shadow',
				'selector' => '{{WRAPPER}} .tme-price-table-title',
			]
		);
        
        $this->add_responsive_control(
			'header_title_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'header_desc_heading',
			[
				'label' => esc_html__( 'Description', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'header_desc_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-desc' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_desc_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-desc',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'header_desc_text_shadow',
				'selector' => '{{WRAPPER}} .tme-price-table-desc',
			]
		);
        
        $this->add_responsive_control(
			'header_desc_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
       
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_header_icon_style',
			[
				'label' => esc_html__( 'Header Icon', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'header_icon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-header-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tme-price-table-header-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);
        
        $this->add_control(
			'header_icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-header-icon' => 'background-color: {{VALUE}}'
				],
			]
		);
        
        $this->add_responsive_control(
			'header_icon_size',
			[
				'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','rem' ],
                'selectors' => [
					'{{WRAPPER}} .tme-price-table-header-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'header_icon_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'header_icon_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-header-icon'
			]
		);
        
        $this->add_responsive_control(
			'header_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-header-icon' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'header_icon_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-header-icon'
			]
		);
        
        $this->add_control(
			'header_icon_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'header_icon_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-price-table-header-icon' => 'width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'header_icon_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-price-table-header-icon' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-price-table-header-icon i' => 'line-height: {{VALUE}}px;',
				],
			]
		);
        
        $this->add_responsive_control(
			'header_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-header-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'header_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-header-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_ribbon_style',
			[
				'label' => esc_html__( 'Ribbon', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'ribbon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-ribbon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tme-price-table-vertical' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tme-price-table-horizontal' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_control(
			'ribbon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-ribbon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .tme-price-table-vertical' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .tme-price-table-horizontal' => 'background-color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ribbon_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-ribbon,{{WRAPPER}} .tme-price-table-vertical,{{WRAPPER}} .tme-price-table-horizontal',
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ribbon_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-ribbon,{{WRAPPER}} .tme-price-table-vertical,{{WRAPPER}} .tme-price-table-horizontal'
			]
		);

		$this->add_control(
			'hr_ribbon_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
			]
		);

		$this->add_responsive_control(
			'ribbon_text_align',
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
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-vertical' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .tme-price-table-horizontal' => 'text-align: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_height',
			[
				'label' => esc_html__( 'Min Width (px)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px','%' ],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
                'selectors' => [
					'{{WRAPPER}} .tme-price-table-vertical' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'ribbon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-vertical' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-price-table-horizontal' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',					]
			]
		);

		$this->add_responsive_control(
			'ribbon_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-vertical' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-price-table-horizontal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'				
				]
			]
		);
        
        $this->add_responsive_control(
			'ribbon_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-vertical',
                        ],
                        [
                            'name'  => 'ribbon_style',
                            'value' => 'tme-price-table-horizontal',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-vertical' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-price-table-horizontal' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_pricing_style',
			[
				'label' => esc_html__( 'Pricing', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pricing_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-price-table-subheader',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pricing_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-subheader'
			]
		);
        
        $this->add_responsive_control(
			'pricing_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-subheader' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_responsive_control(
			'pricing_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-subheader' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'pricing_spacing',
			[
				'label' => esc_html__( 'Inner Spacing', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'px' => [
						'min' => 0,
						'max' => 50,
					],
                    'rem' => [
						'min' => 0,
						'max' => 5,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-original-price' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-price-table-price-value' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_control(
			'pricing_prefix',
			[
				'label' => esc_html__( 'Price Prefix', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'pricing_prefix_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-price-prefix' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_prefix_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-price-prefix',
			]
		);
        
        $this->add_responsive_control(
			'pricing_prefix_v_align',
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
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-price-prefix' => 'align-self: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'pricing_price',
			[
				'label' => esc_html__( 'Price', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'pricing_price_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-price-value' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_price_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-price-value',
			]
		);
        
        $this->add_responsive_control(
			'pricing_price_v_align',
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
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-price-value' => 'align-self: {{VALUE}};',
				],
                'toggle' => false
			]
		);

		$this->add_responsive_control(
			'pricing_price_align',
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
					'{{WRAPPER}} .tme-price-table-price' => 'justify-content: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'pricing_suffix',
			[
				'label' => esc_html__( 'Price Suffix', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'pricing_suffix_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-price-suffix' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_suffix_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-price-suffix',
			]
		);
        
        $this->add_responsive_control(
			'pricing_suffix_v_align',
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
				'default' => 'flex-end',
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-price-suffix' => 'align-self: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'pricing_original',
			[
				'label' => esc_html__( 'Original Price', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'pricing_original_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-original-price' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_original_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-original-price',
			]
		);
        
        $this->add_responsive_control(
			'pricing_original_v_align',
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
				'default' => 'flex-end',
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-original-price' => 'align-self: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'pricing_period',
			[
				'label' => esc_html__( 'Period', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'pricing_period_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-period' => 'color: {{VALUE}}'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_period_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-period',
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_features_style',
			[
				'label' => esc_html__( 'Features', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'features_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} ul.tme-price-table-features li' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'features_typography',
				
				'selector' => '{{WRAPPER}} ul.tme-price-table-features li span',
			]
		);
        
        $this->add_control(
			'hr_features_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'features_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','rem' ],
                'selectors' => [
                    '{{WRAPPER}} ul.tme-price-table-features li i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'features_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} ul.tme-price-table-features li i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'hr_features_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'features_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-price-table-content',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'features_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-content'
			]
		);
        
        $this->add_responsive_control(
			'features_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-content' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'hr_features_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'features_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'features_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} ul.tme-price-table-features li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'features_item_margin',
			[
				'label' => esc_html__( 'Item Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} ul.tme-price-table-features li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'features_divider',
			[
				'label' => esc_html__( 'Divider', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'features_divider_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} ul.tme-price-table-features li' => 'border-bottom-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_responsive_control(
			'features_divider_width',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
                    '{{WRAPPER}} ul.tme-price-table-features li' => 'border-bottom-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'features_divider_style',
			[
				'label' => esc_html__( 'Style', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'theme-masters-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'theme-masters-elementor' ),
                    'dotted' => esc_html__( 'Dotted', 'theme-masters-elementor' ),
                    'double' => esc_html__( 'Double', 'theme-masters-elementor' )
				],
				'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} ul.tme-price-table-features li' => 'border-bottom-style: {{VALUE}};'
				],
			]
		);
       
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_btn_style',
			[
				'label' => esc_html__( 'Button', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'btn_text_shadow',
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a',
			]
		);
        
        $this->add_control(
			'btn_skin',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_btn_skins(),
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
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a,{{WRAPPER}} .tme-btn-wrapper a:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a'
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
					'{{WRAPPER}} .tme-btn-wrapper a:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:hover' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'btn_animation_color',
			[
				'label' => esc_html__( 'Animation Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:before' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a:hover'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:hover,{{WRAPPER}} .tme-btn-wrapper a:hover:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a:hover'
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
                    '{{WRAPPER}} .tme-btn-wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    '{{WRAPPER}} .tme-btn-wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-btn-wrapper a' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_footer_style',
			[
				'label' => esc_html__( 'Footer', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'footer_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-footer-desc' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'footer_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-table-footer-desc',
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'footer_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-price-table-footer',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'footer_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-table-footer'
			]
		);
        
        $this->add_responsive_control(
			'footer_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-table-footer' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_responsive_control(
			'footer_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-table-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
       
		$this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        $target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
    ?>    
        <div class="tme-price-table" <?php if ($settings['show_ribbon']) { echo 'style="overflow:hidden;"'; } ?>>
            <?php if ($settings['show_ribbon']) { ?>
            <div class="tme-price-table-ribbon-wrapper"><div class="<?php echo esc_attr($settings['ribbon_style']); ?> <?php echo esc_attr($settings['ribbon_align']); ?>"><?php echo esc_html($settings['ribbon_text']); ?></div></div>
            <?php } ?>
            <div class="tme-price-table-header">
                <div class="tme-price-table-header-icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings['header_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
                <?php 
                if ($settings['title']) {
                    echo '<' . $settings['html_tag'] . ' class="tme-price-table-title">';
                    echo esc_html($settings['title']);
                    echo '</' . $settings['html_tag'] . '>';
                } ?>
                <?php if ($settings['desc']) { ?>
                <span class="tme-price-table-desc"><?php echo esc_html($settings['desc']); ?></span>    
                <?php } ?>
            </div>
            <div class="tme-price-table-subheader">
                <div class="tme-price-table-price">
                    <?php if ($settings['original_price']) { ?> 
                    <div class="tme-price-table-original-price"><del><?php echo esc_html($settings['original_price']); ?></del></div>
                    <?php } ?>
                    <?php if ($settings['price_prefix']) { ?> 
                    <div class="tme-price-table-price-prefix"><?php echo esc_html($settings['price_prefix']); ?></div>
                    <?php } ?>
                    <?php if ($settings['price'] || $settings['price'] == '0') { ?> 
                    <div class="tme-price-table-price-value"><?php echo esc_html($settings['price']); ?></div>
                    <?php } ?>
                    <?php if ($settings['price_suffix']) { ?> 
                    <div class="tme-price-table-price-suffix"><?php echo esc_html($settings['price_suffix']); ?></div>
                    <?php } ?>
                </div>
                <?php if ($settings['period']) { ?> 
                <div class="tme-price-table-period">
                    <span><?php echo esc_html($settings['period']); ?></span>
                </div>
                <?php } ?>
            </div>
            <div class="tme-price-table-content">
                <ul class="tme-price-table-features">
                    <?php foreach ( $settings['list'] as $item ) { ?> 
                    <li class="elementor-repeater-item-<?php echo $item['_id']; ?>"><?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?><span><?php echo wp_kses_post($item['item_text']); ?></span></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tme-price-table-footer">
                <div class="tme-btn-wrapper">
                    <a id="<?php echo esc_attr($settings['btn_id']); ?>" class="<?php echo esc_attr($settings['btn_size']); ?> <?php echo esc_attr($settings['btn_skin']); ?>" href="<?php echo esc_url($settings['btn_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>>
                        <?php echo esc_html($settings['btn_text']); ?>
                    </a>
                </div>
                <?php if ($settings['footer_info']) { ?> 
                    <span class="tme-price-table-footer-desc"><?php echo wp_kses_post($settings['footer_info']); ?></span>
                <?php } ?>
            </div>
        </div>
     
	<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Price_Table() );