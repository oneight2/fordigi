<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Heading extends Widget_Base {

	public function get_name() {
		return 'tme-heading';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Heading', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-heading' ];
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'heading_content',
  			[
  				'label' => esc_html__( 'Heading', 'theme-masters-elementor' )
  			]
		);

		$this->add_control(
			'heading_text',
			[
				'label' => esc_html__('Heading Text', 'theme-masters-elementor'),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your title', 'theme-masters-elementor' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'theme-masters-elementor' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);  
 
		$this->add_control(
			'html_tag',
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
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'theme-masters-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// section start
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Heading', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-heading, {{WRAPPER}} .tme-heading a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				
				'selector' => '{{WRAPPER}} .tme-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .tme-heading',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'theme-masters-elementor' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'difference' => 'Difference',
					'exclusion' => 'Exclusion',
					'hue' => 'Hue',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .tme-heading' => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => ['gradient_heading' => '', 'rotate_switch' => ''],
				'separator' => 'none',
			]
		);
        
        $this->add_control(
			'flex_direction',
			[
				'label' => esc_html__( 'Before/After Layout', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'column' => esc_html__( 'Vertical', 'theme-masters-elementor' ),
                    'row' => esc_html__( 'Horizontal', 'theme-masters-elementor' )
				],
                'default' => 'column',
				'selectors' => [
					'{{WRAPPER}} .tme-heading' => 'flex-direction: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);
        
        $this->add_responsive_control(
			'justify',
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
                'condition' => ['flex_direction' => 'row'],
				'selectors' => [
					'{{WRAPPER}} .tme-heading' => 'justify-content: {{VALUE}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'align',
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
                'condition' => ['flex_direction' => 'column'],
				'selectors' => [
					'{{WRAPPER}} .tme-heading' => 'text-align: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
			'hr_heading_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'max_width',
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
					'{{WRAPPER}} .tme-heading' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'hr_heading_2',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'gradient_heading',
			[
				'label' => esc_html__( 'Gradient Heading', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Off', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'gradient_heading_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-heading',
				'condition' => ['gradient_heading' => 'yes'],
			]
		);

		$this->add_control(
			'hr_heading_3',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'rotate_switch',
			[
				'label' => esc_html__( 'Rotate Text', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Off', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'text_rotate',
			[
				'label' => esc_html__( 'Rotate', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'condition' => ['rotate_switch' => 'yes'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 180,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-heading' => 'writing-mode: vertical-rl;transform: rotate({{SIZE}}deg);'
				],
			]
        );
        
        $this->end_controls_section();

		// section start
		$this->start_controls_section(
			'section_line1_style',
			[
				'label' => esc_html__( 'Before', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'line1_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-heading:before' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'line1_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-heading:before' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'line1_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-heading:before' => 'background: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
			'line1_align',
			[
				'label' => esc_html__( 'Alignment', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'flex-start' => esc_html__( 'Start', 'theme-masters-elementor' ),
					'center' => esc_html__( 'Center', 'theme-masters-elementor' ),
                    'flex-end' => esc_html__( 'End', 'theme-masters-elementor' ),
				],
                'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tme-heading:before' => 'align-self: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);
        
        $this->add_responsive_control(
			'line1_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-heading:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'line1_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-heading:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'line1_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-heading:before',
			]
		);

		$this->end_controls_section();	
        
        // section start
		$this->start_controls_section(
			'section_line2_style',
			[
				'label' => esc_html__( 'After', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'line2_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-heading:after' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'line2_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-heading:after' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'line2_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-heading:after' => 'background: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
			'line2_align',
			[
				'label' => esc_html__( 'Alignment', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'flex-start' => esc_html__( 'Start', 'theme-masters-elementor' ),
					'center' => esc_html__( 'Center', 'theme-masters-elementor' ),
                    'flex-end' => esc_html__( 'End', 'theme-masters-elementor' ),
				],
                'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tme-heading:after' => 'align-self: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);
        
        $this->add_responsive_control(
			'line2_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-heading:after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'line2_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-heading:after' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'line2_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-heading:after',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render 
	 */
	protected function render( ) {
		$settings = $this->get_settings_for_display();

		if ( '' === $settings['heading_text'] ) {
			return;
		}

		$heading_output = $settings['heading_text'];
		$this->add_render_attribute( 'heading_text', 'class', "tme-heading" );

		if ($settings['gradient_heading'] === 'yes') {
			$this->add_render_attribute( 'heading_text', 'class', "tme-gradient-heading" );
		}

		// link
		if ( ! empty( $settings['link']['url'] ) ) {

			$this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

			$heading_output = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $heading_output );
		}

		// heading tag
		printf( '<%1$s %2$s><span>%3$s</span></%1$s>', $settings['html_tag'], $this->get_render_attribute_string( 'heading_text' ), $heading_output );
	} 

}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Heading() );