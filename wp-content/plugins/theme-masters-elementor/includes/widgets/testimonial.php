<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Testimonial extends Widget_Base {

	public function get_name() {
		return 'tme-testimonial';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Testimonial', 'theme-masters-elementor' );
	}
    
    public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-testimonial' ];
    }
    
    public function get_icon() {
		return 'eicon-testimonial';
    }

	protected function register_controls() {
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Testimonials', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Name', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'John Doe', 'theme-masters-elementor' )
			]
		);
        
        $this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Info', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'Web Designer', 'theme-masters-elementor' )
			]
		);
        
        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA
			]
		);
        
        $this->add_control(
			'content', [
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => esc_html__( 'Enim ad commodo do est proident excepteur nulla enim pariatur. Proident et laborum reprehenderit voluptate velit Lorem culpa ullamco.', 'theme-masters-elementor' )
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_item',
			[
				'label' => esc_html__( 'Testimonial', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'item_direction',
			[
				'label' => esc_html__( 'Flex Direction', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'column',
				'options' => [
                    'column'  => esc_html__( 'Column', 'theme-masters-elementor' ),
                    'column-reverse'  => esc_html__( 'Column Reverse', 'theme-masters-elementor' ),
					'row'  => esc_html__( 'Row', 'theme-masters-elementor' ),
                    'row-reverse'  => esc_html__( 'Row Reverse', 'theme-masters-elementor' )
                ],
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-item' => 'flex-direction: {{VALUE}};'
				],
			]
        );
        
        $this->add_responsive_control(
			'item_width',
			[
				'label' => esc_html__( 'Max Width (px)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-item' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'item_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-item' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-item',
			]
		);
        
        $this->add_responsive_control(
			'item_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-item' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow',
				'label' => esc_html__( 'Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-item',
			]
        );
        
        $this->add_control(
			'item_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'item_margin',
			[
				'label' => esc_html__( 'Item Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_info',
			[
				'label' => esc_html__( 'Author Info', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'info_direction',
			[
				'label' => esc_html__( 'Flex Direction', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
                    'column'  => esc_html__( 'Column', 'theme-masters-elementor' ),
                    'column-reverse'  => esc_html__( 'Column Reverse', 'theme-masters-elementor' ),
					'row'  => esc_html__( 'Row', 'theme-masters-elementor' ),
                    'row-reverse'  => esc_html__( 'Row Reverse', 'theme-masters-elementor' )
                ],
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'flex-direction: {{VALUE}};'
				],
			]
        );

        $this->add_responsive_control(
			'info_min_width',
			[
				'label' => esc_html__( 'Min Width (px)', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
						'min' => 100,
						'max' => 500,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 150,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_direction',
                            'operator' => '==',
                            'value' => 'row'
                        ],
                        [
                            'name' => 'item_direction',
                            'operator' => '==',
                            'value' => 'row-reverse'
                        ]
                    ]
                ],
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'min-width: {{SIZE}}{{UNIT}};'
				],
			]
		);

        $this->add_responsive_control(
			'info_horizontal_align_column',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'info_direction',
                            'operator' => '==',
                            'value' => 'column'
                        ],
                        [
                            'name' => 'info_direction',
                            'operator' => '==',
                            'value' => 'column-reverse'
                        ]
                    ]
                ],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
        );
        
        $this->add_responsive_control(
			'info_vertical_align_column',
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
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'info_direction',
                                    'operator' => '==',
                                    'value' => 'column'
                                ],
                                [
                                    'name' => 'info_direction',
                                    'operator' => '==',
                                    'value' => 'column-reverse'
                                ]
                            ]
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'item_direction',
                                    'operator' => '==',
                                    'value' => 'row'
                                ],
                                [
                                    'name' => 'item_direction',
                                    'operator' => '==',
                                    'value' => 'row-reverse'
                                ]
                            ]
                        ]
                    ]
                ],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'info_horizontal_align_row',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'info_direction',
                            'operator' => '==',
                            'value' => 'row'
                        ],
                        [
                            'name' => 'info_direction',
                            'operator' => '==',
                            'value' => 'row-reverse'
                        ]
                    ]
                ],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
        );
        
        $this->add_responsive_control(
			'info_vertical_align_row',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'info_direction',
                            'operator' => '==',
                            'value' => 'row'
                        ],
                        [
                            'name' => 'info_direction',
                            'operator' => '==',
                            'value' => 'row-reverse'
                        ]
                    ]
                ],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'info_text_align',
			[
				'label' => esc_html__( 'Text Alignment', 'theme-masters-elementor' ),
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
					],
                ],
                'default' => 'left',
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'text-align: {{VALUE}};',
				],
				'toggle' => false,
			]
        );
        
        $this->add_control(
			'info_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'info_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'info_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-person' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'content_font_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-testimonials-content p' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_font_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-testimonials-content,{{WRAPPER}} .tme-testimonials-content p',
			]
		);
        
        $this->add_control(
			'content_heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content h1' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-content h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-content h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-content h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-content h5' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-content h6' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_heading_typography',
				'label' => esc_html__( 'Heading Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-testimonials-content h1,{{WRAPPER}} .tme-testimonials-content h2,{{WRAPPER}} .tme-testimonials-content h3,{{WRAPPER}} .tme-testimonials-content h4,{{WRAPPER}} .tme-testimonials-content h5,{{WRAPPER}} .tme-testimonials-content h6',
			]
		);
        
        $this->add_responsive_control(
			'content_text_align',
			[
				'label' => esc_html__( 'Text Alignment', 'theme-masters-elementor' ),
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
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .tme-testimonials-content p' => 'text-align: {{VALUE}};'
				],
				'toggle' => false,
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
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-content',
			]
		);
        
        $this->add_responsive_control(
			'content_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'label' => esc_html__( 'Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-content',
			]
        );
        
        $this->add_control(
			'content_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_arrow',
			[
				'label' => esc_html__( 'Content Arrow', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'content_arrow',
			[
				'label' => esc_html__( 'Arrow', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no-arrow',
				'options' => [
                    'no-arrow'  => esc_html__( 'None', 'theme-masters-elementor' ),
                    'top-arrow'  => esc_html__( 'Top', 'theme-masters-elementor' ),
                    'bottom-arrow'  => esc_html__( 'Bottom', 'theme-masters-elementor' ),
                    'left-arrow'  => esc_html__( 'Left', 'theme-masters-elementor' ),
                    'right-arrow'  => esc_html__( 'Right', 'theme-masters-elementor' ),
				],
			]
        );
        
        $this->add_responsive_control(
			'content_arrow_top',
			[
				'label' => esc_html__( 'Top Spacing', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 500,
                    ],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'content_arrow',
                            'operator' => '==',
                            'value' => 'left-arrow'
                        ],
                        [
                            'name' => 'content_arrow',
                            'operator' => '==',
                            'value' => 'right-arrow'
                        ]
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .tme-testimonials-content.left-arrow:after' => 'top: {{SIZE}}{{UNIT}};transform:translateY(0) translateX(-100%);',
                    '{{WRAPPER}} .tme-testimonials-content.right-arrow:after' => 'top: {{SIZE}}{{UNIT}};transform:translateY(0) translateX(100%);'
				],
			]
        );
        
        $this->add_responsive_control(
			'content_arrow_left',
			[
				'label' => esc_html__( 'Left Spacing', 'theme-masters-elementor' ),
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'content_arrow',
                            'operator' => '==',
                            'value' => 'top-arrow'
                        ],
                        [
                            'name' => 'content_arrow',
                            'operator' => '==',
                            'value' => 'bottom-arrow'
                        ]
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .tme-testimonials-content.top-arrow:after' => 'left: {{SIZE}}{{UNIT}};transform:none;',
                    '{{WRAPPER}} .tme-testimonials-content.bottom-arrow:after' => 'left: {{SIZE}}{{UNIT}};transform:none;'
				],
			]
		);

        $this->add_control(
			'arrow_color',
			[
				'label' => esc_html__( 'Arrow Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content:after' => 'border-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Arrow Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 15,
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-content:after' => 'border-width: {{VALUE}}px;'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Name', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-title' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-testimonials-title',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-title',
			]
        );

        $this->add_control(
			'title_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-testimonials-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_subtitle',
			[
				'label' => esc_html__( 'Info', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-subtitle' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-testimonials-subtitle',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-subtitle',
			]
        );

        $this->add_control(
			'subtitle_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-testimonials-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_thumbnail',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
        
        $this->add_responsive_control(
			'thumb_width',
			[
				'label' => esc_html__( 'Max Width (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 70,
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-thumb' => 'width: {{VALUE}}px;'
				],
			]
        );
        
        $this->add_control(
			'thumb_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumb_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-thumb img',
			]
		);
        
        $this->add_responsive_control(
			'thumb_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-thumb img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'thumb_shadow',
				'label' => esc_html__( 'Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-testimonials-thumb img',
			]
        );

        $this->add_control(
			'thumb_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'thumb_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();

	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        ?>
        <?php 
        $img_url = wp_get_attachment_image_url( $settings['image']['id'], $settings['img_size'] );  
        ?>
        <div class="tme-testimonials-item">
            <div class="tme-testimonials-content <?php echo $settings['content_arrow']; ?>">
                <?php echo wp_kses_post($settings['content']); ?>
            </div>
            <div class="tme-testimonials-person">
                <?php if ($img_url) { ?>
                <div class="tme-testimonials-thumb"><img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($settings['title']); ?>" /></div>
                <?php } ?>
                <div class="tme-testimonials-info">
                    <?php if ($settings['title']) { ?>
                    <span class="tme-testimonials-title"><?php echo wp_kses_post($settings['title']); ?></span>
                    <?php } ?>
                    <?php if ($settings['subtitle']) { ?>
                    <span class="tme-testimonials-subtitle"><?php echo wp_kses_post($settings['subtitle']); ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Testimonial() );
?>