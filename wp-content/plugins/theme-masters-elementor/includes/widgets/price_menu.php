<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Price_Menu extends Widget_Base {

	public function get_name() {
		return 'tme-price_menu';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Price Menu', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-price_menu' ];
	}
    
    public function get_icon() {
		return 'eicon-price-list';
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
			'image',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA
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
			'desc', [
				'label' => esc_html__( 'Description', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
				'label_block' => true,
			]
		);
        
        $repeater->add_control(
			'price', [
				'label' => esc_html__( 'Price', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => false,
			]
		);
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Menu Items', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
                        'image' => '',
						'title' => esc_html__( 'Title #1', 'theme-masters-elementor' ),
						'desc' => esc_html__( 'Description...', 'theme-masters-elementor' ),
                        'price' => esc_html__( '$49', 'theme-masters-elementor' ),
					],
					[
                        'image' => '',
						'title' => esc_html__( 'Title #2', 'theme-masters-elementor' ),
						'desc' => esc_html__( 'Description...', 'theme-masters-elementor' ),
                        'price' => esc_html__( '$49', 'theme-masters-elementor' ),
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
			'layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'layout-1' => esc_html__( 'Layout 1', 'theme-masters-elementor' ),
					'layout-2' => esc_html__( 'Layout 2', 'theme-masters-elementor' ),
                    'layout-3' => esc_html__( 'Layout 3', 'theme-masters-elementor' ),
				],
				'default' => 'layout-1',
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
			'seperator_switcher',
			[
				'label' => esc_html__( 'Seperator', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'img_size',
			[
				'label' => esc_html__( 'Thumbnail Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'thumbnail',
				'options' => TMEA_get_image_sizes(),
			]
		);
        
        $this->add_control(
			'lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'theme-masters-elementor' ),
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
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'menu_item_style_section',
			[
				'label' => esc_html__( 'Menu Item', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'menu_item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-wrapper' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-wrapper'
			]
		);
        
        $this->add_responsive_control(
			'menu_item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'menu_item_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-wrapper'
			]
		);
        
        $this->add_control(
			'price_menu_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'menu_item_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'menu_item_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'title_style_section',
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
					'{{WRAPPER}} .tme-price-menu-name' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-menu-name',
			]
		);
        
        $this->add_control(
			'title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-bar' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-bar'
			]
		);
        
        $this->add_responsive_control(
			'title_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-bar' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_4',
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
                    '{{WRAPPER}} .tme-price-menu-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'price_style_section',
			[
				'label' => esc_html__( 'Price', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-price' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-menu-price',
			]
		);
        
        $this->add_control(
			'price_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-price' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_5',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'price_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-price'
			]
		);
        
        $this->add_responsive_control(
			'price_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-price' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_6',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'price_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();
        
         // section start
		$this->start_controls_section(
			'seperator_style_section',
			[
				'label' => esc_html__( 'Seperator', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['seperator_switcher' => 'yes']
			]
		);

		$this->add_control(
			'seperator_style',
			[
				'label' => esc_html__( 'Border Style', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dashed',
				'options' => [
					'dashed'  => esc_html__( 'Dashed', 'theme-masters-elementor' ),
					'dotted'  => esc_html__( 'Dotted', 'theme-masters-elementor' ),
					'solid'  => esc_html__( 'Solid', 'theme-masters-elementor' ),
					'double'  => esc_html__( 'Double', 'theme-masters-elementor' )
				],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-seperator' => 'border-bottom-style: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'seperator_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-seperator' => 'border-bottom-color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'seperator_width',
			[
				'label' => esc_html__( 'Border Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
                    'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-seperator' => 'height: {{SIZE}}{{UNIT}};border-bottom-width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'seperator_spacing',
			[
				'label' => esc_html__( 'Spacing', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-seperator' => 'margin:0 {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
         // section start
		$this->start_controls_section(
			'desc_style_section',
			[
				'label' => esc_html__( 'Description', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-description' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				
				'selector' => '{{WRAPPER}} .tme-price-menu-description',
			]
		);
        
        $this->add_control(
			'desc_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-description' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_9',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'desc_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-description'
			]
		);
        
        $this->add_responsive_control(
			'desc_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-description' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'price_menu_hr_10',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'desc_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'desc_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'thumbnail_style_section',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'thumbnail_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-price-menu-img img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-price-menu-title' => 'width: calc(100% - {{SIZE}}{{UNIT}});'
				],
			]
		);
        
        $this->add_control(
			'thumbnail_hover',
			[
				'label' => esc_html__( 'Hover Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
		);
        
        $this->add_control(
			'price_menu_hr_7',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumbnail_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-img img'
			]
		);
        
        $this->add_responsive_control(
			'thumbnail_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-price-menu-img img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'thumbnail_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-price-menu-img img'
			]
		);
        
        $this->add_control(
			'price_menu_hr_8',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'thumbnail_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-price-menu-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        if ( $settings['list'] ) {
		?>
        <?php foreach ( $settings['list'] as $item ) { ?> 
        <div class="tme-price-menu-wrapper tme-price-menu-<?php echo $settings['layout']; ?>">
            <?php if ($item['image']['url']) { ?>
            <div class="tme-price-menu-img elementor-animation-<?php echo $settings['thumbnail_hover']; ?>">
                <?php $thumbnail = wp_get_attachment_image_url( $item['image']['id'], $settings['img_size'] ); ?>
                <?php $full_img = wp_get_attachment_image_url( $item['image']['id'], 'full' ); ?>
                <?php if ($settings['lightbox'] == 'true') { ?>
                <a href="<?php echo esc_url($full_img); ?>" data-elementor-open-lightbox="yes">
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($item['title']); ?>" /> 
                </a>
                <?php } else { ?>
                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                <?php } ?>
            </div>
            <?php } ?>
            <div class="tme-price-menu-title <?php if (!$item['image']['url']) { echo 'tme-price-menu-title-full'; } ?>">
                <div class="tme-price-menu-bar">
                    <?php if ($item['title']) {
                        echo '<' . $settings['html_tag'] . ' class="tme-price-menu-name">';
                        echo esc_html($item['title']);
                        echo '</' . $settings['html_tag'] . '>';
                    } ?>
					<?php if ($settings['seperator_switcher']) { ?>
                    <div class="tme-price-menu-seperator"></div>
                    <?php } ?>
                    <?php if ($item['price']) { ?>
                    <div class="tme-price-menu-price">
                        <?php echo esc_html($item['price']); ?>
                    </div>
                    <?php } ?>
                </div>
                <?php if ($item['desc']) { ?>
                <div class="tme-price-menu-description">
                    <?php echo wp_kses_post($item['desc']); ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php
        }
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Price_Menu() );