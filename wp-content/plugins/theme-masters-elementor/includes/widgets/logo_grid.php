<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Logo_Grid extends Widget_Base {

	public function get_name() {
		return 'tme-logo_grid';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Logo Grid', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-logo_grid', 'tme-tooltip' ];
	}

	public function get_script_depends() {
		return [ 'tme-tooltip' ];
	}

	public function get_icon() {
		return 'eicon-logo';
	}
    
	protected function register_controls() {

        // section start
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Logos', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Logo', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );
        
        $repeater->add_control(
			'website_link',
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
				]
			]
        );
        
        $this->add_control(
			'list', [
				'label' => esc_html__( 'Logos', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
                    [
                        'image' => \Elementor\Utils::get_placeholder_image_src()
				    ],
				    [
                        'image' => \Elementor\Utils::get_placeholder_image_src()
					],
					[
                        'image' => \Elementor\Utils::get_placeholder_image_src()
				    ],
				    [
                        'image' => \Elementor\Utils::get_placeholder_image_src()
				    ]
			     ]
            ]
		);
		
		$this->add_control(
			'hr_img_size',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'img_size',
			[
				'label' => esc_html__( 'Image Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'large',
				'options' => TMEA_get_image_sizes(),
			]
		);
        
		$this->end_controls_section();
		
		// section start
		$this->start_controls_section(
			'content_tooltip_settings',
			[
				'label' => esc_html__( 'Tooltip Settings', 'theme-masters-elementor' ),
			  	'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		); 

		$this->add_control(
			'enable_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'OFF', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'description' => esc_html__( 'Display the caption of the image.', 'theme-masters-elementor' )
			]
		);
	  
		$this->add_control(
			'anim',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'label_block' => true
			]
		);
		
		$this->add_control(
			'follow_mouse',
			[
				'label' => esc_html__( 'Follow Mouse', 'theme-masters-elementor' ),
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
				'description' => esc_html__( 'If set to enabled the tooltip will follow the users mouse cursor.', 'theme-masters-elementor' ),
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'mouse_on_to_popup',
			[
				'label' => esc_html__( 'Mouse on to Popup', 'theme-masters-elementor' ),
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
				'description' => esc_html__( 'Allow the mouse to hover on the tooltip. This lets users interact with the content in the tooltip. Only applies if Follow Mouse is disabled.', 'theme-masters-elementor' ),
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'placement',
			[
				'label' => esc_html__( 'Placement', 'theme-masters-elementor' ),
				'description' => esc_html__( 'Placement location of the tooltip relative to the element it is open for.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'n',
				'options' => [
					'n'  => esc_html__( 'Top', 'theme-masters-elementor' ),
					'e'  => esc_html__( 'Right', 'theme-masters-elementor' ),
					'w'  => esc_html__( 'Left', 'theme-masters-elementor' ),
					's'  => esc_html__( 'Bottom', 'theme-masters-elementor' ),
					'nw'  => esc_html__( 'Top-Left', 'theme-masters-elementor' ),
					'ne'  => esc_html__( 'Top-Right', 'theme-masters-elementor' ),
					'sw'  => esc_html__( 'Bottom-Left', 'theme-masters-elementor' ),
					'se'  => esc_html__( 'Bottom-Right', 'theme-masters-elementor' ),
					'nw-alt'  => esc_html__( 'Top-Left-Alt', 'theme-masters-elementor' ),
					'ne-alt'  => esc_html__( 'Top-Right-Alt', 'theme-masters-elementor' ),
					'sw-alt'  => esc_html__( 'Bottom-Left-Alt', 'theme-masters-elementor' ),
					'se-alt'  => esc_html__( 'Bottom-Right-Alt', 'theme-masters-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'smart_placement',
			[
				'label' => esc_html__( 'Smart Placement', 'theme-masters-elementor' ),
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
				'description' => esc_html__( 'When enabled the plugin will try to keep tips inside the browser viewport. Only applies if follow mouse is disabled.', 'theme-masters-elementor' ),
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Offset', 'theme-masters-elementor' ),
				'description' => esc_html__( 'This will be the offset from the element the tooltip is open for, or from the mouse cursor if follow mouse is enabled.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 10
			]
		);
		
		$this->end_controls_section();

        $this->start_controls_section(
			'grid_section',
			[
				'label' => esc_html__( 'Grid', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 12,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-logo-grid' => 'grid-template-columns:repeat({{SIZE}}, 1fr);'
				],
			]
		);
        
        $this->add_responsive_control(
			'gap',
			[
				'label' => esc_html__( 'Grid Gap (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-logo-grid' => 'grid-gap: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
        $this->start_controls_section(
			'section_grid_item',
			[
				'label' => esc_html__( 'Grid Item', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'grid_item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-logo-grid-item' => 'background-color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'hr_grid_item_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_responsive_control(
			'grid_item_min_height',
			[
				'label' => esc_html__( 'Minimum Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem', 'vh' ],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 1000,
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
				'selectors' => [
                    '{{WRAPPER}} .tme-logo-grid-item' => 'min-height: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_responsive_control(
			'grid_item_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-logo-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );

        $this->add_control(
			'hr_grid_item_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'grid_item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item'
			]
		);
        
        $this->add_control(
			'grid_item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-logo-grid-item' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'grid_item_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item'
			]
		);
        
        $this->end_controls_section();

        
        // section start
        $this->start_controls_section(
			'section_thumbnail',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'thumbnail_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
        );

		$this->add_responsive_control(
			'thumbnail_max_width',
			[
				'label' => esc_html__( 'Maximum Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
				'selectors' => [
                    '{{WRAPPER}} .tme-logo-grid-item img' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'hr_thumbnail_1',
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
        
        $this->add_responsive_control(
			'thumbnail_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-logo-grid-item img' => 'opacity: {{VALUE}};'
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumb_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item img',
			]
		);
        
        $this->add_responsive_control(
			'thumb_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-logo-grid-item img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'thumb_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item img',
			]
		);
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item img'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnail_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_responsive_control(
			'thumbnail_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-logo-grid-item:hover img' => 'opacity: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumb_border_hover',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item:hover img',
			]
		);
        
        $this->add_responsive_control(
			'thumb_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-logo-grid-item:hover img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'thumb_shadow_hover',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item:hover img',
			]
		);
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter_hover',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-logo-grid-item:hover img'
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
		$this->end_controls_section();
		
		 // section start
		$this->start_controls_section(
			'style_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'tooltip_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#ffffff',
				'selectors' => [
                    '#tme-tooltip-popup.tme-tooltip-{{ID}}' => 'color: {{VALUE}};',
					'#tme-tooltip-popup.tme-tooltip-{{ID}}' . ' p' => 'color: {{VALUE}};',
                    '#tme-tooltip-popup.tme-tooltip-{{ID}}' . ' a' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				'name' => 'tooltip_text_typography',
				
				'selector' => '#tme-tooltip-popup.tme-tooltip-{{ID}}, #tme-tooltip-popup.tme-tooltip-{{ID}} p'
			]
		);
        
        $this->add_control(
			'tooltip_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => 'rgba(0, 0, 0, 0.8)',
				'selectors' => [
                    '#tme-tooltip-popup.tme-tooltip-{{ID}}' => 'background-color: {{VALUE}};border-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'tooltip_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_control(
			'tooltip_max_width',
			[
				'label' => esc_html__( 'Maximum Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 10,
				'default' => 300,
                'selectors' => [
					'#tme-tooltip-popup.tme-tooltip-{{ID}}' => 'max-width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'tooltip_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '#tme-tooltip-popup.tme-tooltip-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'tooltip_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'#tme-tooltip-popup.tme-tooltip-{{ID}}' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tooltip_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '#tme-tooltip-popup.tme-tooltip-{{ID}}'
			]
		);
        
        $this->end_controls_section();
  
	}

	/**
	 * Render 
	 */
	protected function render( ) {
		$settings = $this->get_settings_for_display();
		$settings_id = $this->get_id();
        if ( $settings['list'] ) { ?>
        <div class="tme-logo-grid">
        <?php foreach ( $settings['list'] as $item ) { ?>
            <?php
            $target = $item['website_link']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $item['website_link']['nofollow'] ? ' rel="nofollow"' : '';
			$img_url = \Elementor\Utils::get_placeholder_image_src();
			$img_alt = '';
			$img_caption = '';
			if ($item['image']['url'] != $img_url) {
            	$img_array = wp_get_attachment_image_src($item['image']['id'], $settings['img_size'], true);
            	$img_url = $img_array[0];
				$img_alt = get_post_meta( $item['image']['id'], '_wp_attachment_image_alt', true );
				$img_caption = wp_get_attachment_caption($item['image']['id']);
			}
            ?>
			<div id="tme-logo-<?php echo $item['_id']; ?>" class="tme-logo-grid-item">
				<?php if ($settings['enable_tooltip'] && !empty($img_caption)) { ?>
					<div class="tme-logo-grid-item-inner tme-tooltip-wrapper elementor-animation-<?php echo esc_attr($settings['thumbnail_animation']); ?>" data-tpid="tme-tooltip-<?php echo esc_attr($settings_id); ?> animated fast <?php echo esc_attr($settings['anim']); ?>" data-followmouse="<?php echo esc_attr($settings['follow_mouse']); ?>" data-motp="<?php echo esc_attr($settings['mouse_on_to_popup']); ?>" data-placement="<?php echo esc_attr($settings['placement']); ?>" data-smart="<?php echo esc_attr($settings['smart_placement']); ?>" data-offset="<?php echo esc_attr($settings['offset']); ?>">
					<?php if ($item['website_link']['url']) { ?>
					<a href="<?php echo esc_url($item['website_link']['url']); ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?>>
					<?php } ?>
						<img src="<?php echo esc_url($img_url); ?>" class="tme-tooltip tme-tooltip-type-text" data-powertip="<?php echo esc_attr($img_caption); ?>" alt="<?php echo esc_attr($img_alt); ?>"/>
					<?php if ($item['website_link']['url']) { ?>
					</a>
					<?php } ?>
					</div>
				<?php } else { ?>
					<div class="tme-logo-grid-item-inner elementor-animation-<?php echo esc_attr($settings['thumbnail_animation']); ?>">
					<?php if ($item['website_link']['url']) { ?>
					<a href="<?php echo esc_url($item['website_link']['url']); ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?>>
					<?php } ?>
					<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" />
					<?php if ($item['website_link']['url']) { ?>
					</a>
					<?php } ?>
					</div>
				<?php } ?>
            </div>
        <?php } ?>
        </div>
    <?php } ?>
    <?php } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Logo_Grid() );