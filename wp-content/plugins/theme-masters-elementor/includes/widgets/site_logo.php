<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Site_Logo extends Widget_Base {

	public function get_name() {
		return 'tme-site_logo';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Site Logo', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_icon() {
		return 'eicon-site-logo';
	}
    
	protected function register_controls() {

        // section start
		$this->start_controls_section(
			'logo_section',
			[
				'label' => esc_html__( 'Site Logo', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $this->add_control(
			'logo_source',
			[
				'label' => esc_html__( 'Source', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
                    'custom'  => esc_html__( 'Custom Logo', 'theme-masters-elementor' ),
					'customizer'  => esc_html__( 'Customizer', 'theme-masters-elementor' )
                ],
                'frontend_available' => true
			]
		);
        
        $this->start_controls_tabs( 'tabs_thumbnail_style' );
        
        $this->start_controls_tab(
			'tab_desktop',
			[
                'label' => esc_html__( 'Desktop', 'theme-masters-elementor' ),
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );      
        
        $this->add_control(
			'before_image',
			[
				'label' => esc_html__( 'Logo', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );

        $this->add_control(
			'img_size',
			[
				'label' => esc_html__( 'Image Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'full',
                'options' => TMEA_get_image_sizes(),
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_mobile',
			[
                'label' => esc_html__( 'Mobile', 'theme-masters-elementor' ),
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );
        
        $this->add_control(
			'after_image',
			[
				'label' => esc_html__( 'Logo', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );

        $this->add_control(
			'mobile_img_size',
			[
				'label' => esc_html__( 'Image Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'large',
                'options' => TMEA_get_image_sizes(),
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'logo_hr_1',
			[
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );
        
        $this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'theme-masters-elementor' ),
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
                'default' => [
					'url' => home_url( '/' ),
					'is_external' => false,
					'nofollow' => false,
				],
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );

        $this->add_control(
			'logo_hr_2',
			[
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition' => [
                    'logo_source' => 'custom'
                ]
			]
        );

        $this->add_control(
            'breakpoint',
            [
                'label' => esc_html__( 'Mobile Breakpoint', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => get_option('elementor_viewport_lg', true),
                'condition' => [
                    'logo_source' => 'custom'
                ]
            ]
        );

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_logo_style',
			[
				'label' => esc_html__( 'Site Logo', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_responsive_control(
			'logo_h_align',
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
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tmea-site-logo-container' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'logo_max_width',
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
					'{{WRAPPER}} .tmea-site-logo-container img' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_responsive_control(
			'logo_width',
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
				'selectors' => [
					'{{WRAPPER}} .tmea-site-logo-container img' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_control(
			'logo_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );

        $this->add_control(
			'logo_bg_color',
			[
                'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
                    '{{WRAPPER}} .tmea-site-logo-container img' => 'background-color: {{VALUE}};'
				]
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'logo_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-site-logo-container img'
			]
		);
        
        $this->add_control(
			'logo_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tmea-site-logo-container img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'logo_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmea-site-logo-container img'
			]
        );
        
        $this->add_control(
			'logo_hr_4',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );

		$this->add_responsive_control(
			'logo_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-site-logo-container img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'logo_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmea-site-logo-container img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();
	}

	/**
	 * Render 
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();
        $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
        ?>
        <div class="tmea-site-logo-container" style="display:flex;flex-direction:column;">
        <?php if ($settings['logo_source'] == 'customizer') {
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<strong>' . esc_html__( 'Please add a logo from customizer.', 'theme-masters-elementor' ) . '</strong>';
            }
        } else {
            if ($settings['link']['url']) {
                if ($settings['before_image']['url']) {
                    echo '<a href="' . $settings['link']['url'] . '" class="tmea-logo-desktop"' . $target . ' ' . $nofollow . '><span>' . wp_get_attachment_image( $settings['before_image']['id'], $settings['img_size'] ) . '</span></a>';
                }
                if ($settings['after_image']['url'] && $settings['breakpoint']) {
                    echo '<a href="' . $settings['link']['url'] . '" class="tmea-logo-mobile"' . $target . ' ' . $nofollow . '><span>' . wp_get_attachment_image( $settings['after_image']['id'], $settings['mobile_img_size'] ) . '</span></a>';
                }
            } else {
                if ($settings['before_image']['url']) {
                    echo '<div class="tmea-logo-desktop"><span>' . wp_get_attachment_image( $settings['before_image']['id'], $settings['img_size'] ) . '</span></div>';
                }
                if ($settings['after_image']['url'] && $settings['breakpoint']) {
                    echo '<div class="tmea-logo-mobile"><span>' . wp_get_attachment_image( $settings['after_image']['id'], $settings['mobile_img_size'] ) . '</span></div>';
                }
            }
        } ?>
        </div>
        <?php if ($settings['after_image']['url'] && $settings['breakpoint']) { ?>
        <style>
        @media screen and (min-width: <?php echo ($settings['breakpoint'] + 1) . 'px'; ?>) {
            .tmea-logo-desktop span {display:block;}
            .tmea-logo-mobile span {display:none;}
        }
        @media screen and (max-width: <?php echo ($settings['breakpoint']) . 'px'; ?>) {
            .tmea-logo-desktop span {display:none;}
            .tmea-logo-mobile span {display:block;}
        }
        </style>
        <?php } ?>
    <?php } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Site_Logo() );