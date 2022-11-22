<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Banner extends Widget_Base {

	public function get_name() {
		return 'tme-banner';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Banner Designer', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-banner', 'tme-button' ];
	}
    
    public function get_icon() {
		return 'eicon-banner';
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
			'content_section',
			[
				'label' => esc_html__( 'Banner', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'heading', [
				'label' => esc_html__( 'Heading', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'SALE', 'theme-masters-elementor' ),
                'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'divider',
			[
				'label' => esc_html__( 'Divider', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'sub_heading', [
				'label' => esc_html__( 'Sub Heading', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '50% OFF', 'theme-masters-elementor' ),
                'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA
			]
		);
        
        $this->add_control(
			'content', [
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'ON ORDERS ABOVE $99', 'theme-masters-elementor' ),
				'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'banner_link',
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
       
		$this->end_controls_section();
        
        $this->start_controls_section(
			'button_content',
			[
				'label' => esc_html__( 'Button', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'btn_text', [
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'BUY NOW', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'btn_website_link',
			[
				'label' => esc_html__( 'Link to', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://www.thememasters.club', 'theme-masters-elementor' ),
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
				'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-btn-md',
				'options' => [
					'tme-btn-md'  => esc_html__( 'Normal', 'theme-masters-elementor' ),
					'tme-btn-lg'  => esc_html__( 'Large', 'theme-masters-elementor' ),
                    'tme-btn-sm'  => esc_html__( 'Small', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_text_align',
			[
				'label' => esc_html__( 'Alignment', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theme-masters-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theme-masters-elementor' ),
						'icon' => 'fa fa-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper' => 'text-align: {{VALUE}};'
				],
				'toggle' => true,
			]
		);
        
        $this->add_control(
			'btn_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);
        
        $this->add_control(
			'btn_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'after'  => esc_html__( 'After', 'theme-masters-elementor' ),
					'before'  => esc_html__( 'Before', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_icon_spacing',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-btn-wrapper a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'banner_wrapper_style_section',
			[
				'label' => esc_html__( 'Container', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'banner_wrapper_align',
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
					'{{WRAPPER}} .tme-banner-wrapper' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'banner_wrapper_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-banner-wrapper',
			]
		);
        
        $this->add_control(
			'banner_wrapper_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'banner_wrapper_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-wrapper'
			]
		);
        
        $this->add_responsive_control(
			'banner_wrapper_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-banner-wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'banner_wrapper_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-wrapper'
			]
		);
       
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'banner_style_section',
			[
				'label' => esc_html__( 'Banner', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'banner_wrapper_width',
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
					'{{WRAPPER}} .tme-banner' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'banner_height',
			[
				'label' => esc_html__( 'Banner Height', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'rem' ],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
                    'vh' => [
						'min' => 0,
						'max' => 100,
					],
                    'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-banner' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
  
        $this->add_responsive_control(
			'h_align',
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
					'{{WRAPPER}} .tme-banner' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'v_align',
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
					'{{WRAPPER}} .tme-banner' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);

		$this->add_control(
			'banner_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
        );
        
        $this->add_control(
			'banner_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->start_controls_tabs( 'tabs_thumbnail_style' );
        
        $this->start_controls_tab(
			'tab_thumbnail_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'banner_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-banner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'banner_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner'
			]
		);

		$this->add_responsive_control(
			'banner_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-banner' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'banner_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnail_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'banner_bg_hover',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-banner-wrapper:hover .tme-banner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'banner_border_hover',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-wrapper:hover .tme-banner'
			]
		);

		$this->add_responsive_control(
			'banner_border_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-banner-wrapper:hover .tme-banner' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'banner_shadow_hover',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-wrapper:hover .tme-banner'
			]
		);

        $this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'banner_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'banner_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'heading_style_section',
			[
				'label' => esc_html__( 'Heading', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
  
        $this->add_control(
			'heading_html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'theme-masters-elementor' ),
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
        
        $this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-heading' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				
				'selector' => '{{WRAPPER}} .tme-banner-heading',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'heading_text_shadow',
				'selector' => '{{WRAPPER}} .tme-banner-heading',
			]
		);
        
        $this->add_control(
			'heading_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'heading_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-heading span' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'heading_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-heading'
			]
		);
        
        $this->add_responsive_control(
			'heading_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-banner-heading span' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'heading_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-heading'
			]
		);
        
        $this->add_control(
			'heading_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'heading_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner-heading span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'heading_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'divider_style_section',
			[
				'label' => esc_html__( 'Divider', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-divider' => 'background: {{VALUE}};',
				]
			]
		);
        
        $this->add_responsive_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
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
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-banner-divider' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'divider_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-banner-divider' => 'height: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'divider_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner-divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'sub_heading_style_section',
			[
				'label' => esc_html__( 'Sub Heading', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
  
        $this->add_control(
			'sub_heading_html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'theme-masters-elementor' ),
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
			'sub_heading_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-subheading' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_heading_typography',
				
				'selector' => '{{WRAPPER}} .tme-banner-subheading',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'sub_heading_text_shadow',
				'selector' => '{{WRAPPER}} .tme-banner-subheading',
			]
		);
        
        $this->add_control(
			'sub_heading_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'sub_heading_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-subheading span' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sub_heading_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-subheading'
			]
		);
        
        $this->add_responsive_control(
			'sub_heading_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-banner-subheading span' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sub_heading_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-subheading'
			]
		);
        
        $this->add_control(
			'sub_heading_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'sub_heading_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner-subheading span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'sub_heading_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner-subheading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'img_style_section',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'img_width',
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
					'{{WRAPPER}} img.tme-banner-img' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'img_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} img.tme-banner-img'
			]
		);
        
        $this->add_responsive_control(
			'img_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} img.tme-banner-img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'img_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} img.tme-banner-img'
			]
		);
        
        $this->add_control(
			'img_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'img_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} img.tme-banner-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'content_style_section',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
  
        $this->add_control(
			'content_html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'theme-masters-elementor' ),
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
				'default' => 'p',
			]
		);
        
        $this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-content' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				
				'selector' => '{{WRAPPER}} .tme-banner-content',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_text_shadow',
				'selector' => '{{WRAPPER}} .tme-banner-content',
			]
		);
        
        $this->add_control(
			'content_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-banner-content span' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-content'
			]
		);
        
        $this->add_responsive_control(
			'content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-banner-content span' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-banner-content'
			]
		);
        
        $this->add_control(
			'content_hr_2',
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
                    '{{WRAPPER}} .tme-banner-content span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-banner-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
         // section start
		$this->start_controls_section(
			'btn_style_section',
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
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a',
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

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_hover_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a:hover',
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
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        $target = $settings['banner_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['banner_link']['nofollow'] ? ' rel="nofollow"' : '';
        $target2 = $settings['btn_website_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow2 = $settings['btn_website_link']['nofollow'] ? ' rel="nofollow"' : '';
        $icon_position = $settings['btn_icon_position'];
        $video_properties = Embed::get_video_properties( $settings['banner_bg_video_link'] );
        ?>
        <div class="tme-banner-wrapper">
            <?php if ($settings['banner_link']['url']) { ?>
            <a href="<?php echo esc_url($settings['banner_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> class="tme-banner-url"></a>
            <?php } ?>
            <div class="tme-banner elementor-animation-<?php echo esc_attr($settings['banner_animation']); ?>">
				<?php 
				if ($settings['heading']) {
                    echo '<' . $settings['heading_html_tag'] . ' class="tme-banner-heading"><span>';
                    echo esc_html($settings['heading']);
                    echo '</span></' . $settings['heading_html_tag'] . '>';
				} 
				if ($settings['divider']) {
                    echo '<div class="tme-banner-divider"></div>';
				}
				if ($settings['sub_heading']) {
                    echo '<' . $settings['sub_heading_html_tag'] . ' class="tme-banner-subheading"><span>';
                    echo esc_html($settings['sub_heading']);
                    echo '</span></' . $settings['sub_heading_html_tag'] . '>';
				} 
				if ($settings['image']['url']) {
                    echo '<img class="tme-banner-img" src="' . $settings['image']['url'] . '">';
				} 
				if ($settings['content']) {
                    echo '<' . $settings['content_html_tag'] . ' class="tme-banner-content"><span>';
                    echo esc_html($settings['content']);
                    echo '</span></' . $settings['content_html_tag'] . '>';
                } ?>
                <?php if ($settings['btn_website_link']['url']) { ?>
                <div class="tme-btn-wrapper">
                    <a id="<?php echo esc_attr($settings['btn_id']); ?>" class="<?php echo esc_attr($settings['btn_size']); ?> <?php echo esc_attr($settings['btn_skin']); ?>" href="<?php echo esc_url($settings['btn_website_link']['url']); ?>" <?php echo $target2; ?> <?php echo $nofollow2; ?>>
						<?php 
						if ($icon_position == 'before') {
							\Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); 
							echo esc_html($settings['btn_text']);
						} else {
							echo esc_html($settings['btn_text']); 
							\Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] );
							} 
						?>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Banner() );