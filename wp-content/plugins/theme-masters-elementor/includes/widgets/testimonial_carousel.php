<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Testimonial_Carousel extends Widget_Base {

	public function get_name() {
		return 'tme-testimonial_carousel';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Testimonial Carousel', 'theme-masters-elementor' );
	}
    
    public function get_categories() {
		return [ 'theme-masters-elementor' ];
    }
    
    public function get_script_depends() {
		return [ 'tme-lib-slick', 'tme-testimonial_carousel' ];
    }
    
    public function get_style_depends(){
		return [ 'tme-lib-slick','tme-testimonial', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
    }
    
    public function get_icon() {
		return 'eicon-testimonial-carousel';
    }

	protected function register_controls() {
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Testimonials', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true
			]
		);
        
        $repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true
			]
		);
        
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA
			]
		);
        
        $repeater->add_control(
			'content', [
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pugnant Stoici cum Peripateticis. Et quidem, inquit, vehementer errat; Quamquam id quidem, infinitum est in hac urbe; Duo Reges: constructio interrete.</p>',
				'label_block' => true,
			]
		);
        
        $this->add_control(
			'testimonials', [
				'label' => esc_html__( 'Testimonials', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
                    [
                        'title' => esc_html__( 'Title #1', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #1', 'theme-masters-elementor' ),
                        'image' => '',
                        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pugnant Stoici cum Peripateticis. Et quidem, inquit, vehementer errat; Quamquam id quidem, infinitum est in hac urbe; Duo Reges: constructio interrete.</p>'
				    ],
                    [
                        'title' => esc_html__( 'Title #2', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #2', 'theme-masters-elementor' ),
                        'image' => '',
                        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pugnant Stoici cum Peripateticis. Et quidem, inquit, vehementer errat; Quamquam id quidem, infinitum est in hac urbe; Duo Reges: constructio interrete.</p>'
					],
					[
                        'title' => esc_html__( 'Title #3', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #3', 'theme-masters-elementor' ),
                        'image' => '',
                        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pugnant Stoici cum Peripateticis. Et quidem, inquit, vehementer errat; Quamquam id quidem, infinitum est in hac urbe; Duo Reges: constructio interrete.</p>'
					],
					[
                        'title' => esc_html__( 'Title #4', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #4', 'theme-masters-elementor' ),
                        'image' => '',
                        'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pugnant Stoici cum Peripateticis. Et quidem, inquit, vehementer errat; Quamquam id quidem, infinitum est in hac urbe; Duo Reges: constructio interrete.</p>'
				    ]
			     ],
                'title_field' => '{{{ title }}}',
            ]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'three',
				'options' => [
                    'one'  => esc_html__( '1 Column', 'theme-masters-elementor' ),
					'two'  => esc_html__( '2 Column', 'theme-masters-elementor' ),
					'three'  => esc_html__( '3 Column', 'theme-masters-elementor' ),
                    'four'  => esc_html__( '4 Column', 'theme-masters-elementor' ),
                    'five'  => esc_html__( '5 Column', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'display_nav', [
				'label' => esc_html__( 'Display Navigation Arrows', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'display_dots', [
				'label' => esc_html__( 'Display Navigation Dots', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'infinite', [
				'label' => esc_html__( 'Infinite Loop', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'autoplay', [
				'label' => esc_html__( 'Autoplay', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Infinite loop should be on.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'autoplay_duration',
			[
				'label' => esc_html__( 'Autoplay Duration (Second)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 120,
				'step' => 1,
				'default' => 5,
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
        
        $this->add_control(
			'carousel_overflow_hidden', [
				'label' => esc_html__( 'Overflow Hidden', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'tme-overflow-hidden',
				'default' => '',
				'show_label' => true,
			]
		);

		$this->add_responsive_control(
			'carousel_spacing',
			[
				'label' => esc_html__( 'Spacing', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .slick-slide' => 'margin-left: {{LEFT}}{{UNIT}};margin-right: {{RIGHT}}{{UNIT}};margin-top: {{TOP}}{{UNIT}};margin-bottom: {{BOTTOM}}{{UNIT}};',
                    '{{WRAPPER}} .slick-list' => 'margin-left: -{{LEFT}}{{UNIT}};margin-right: -{{RIGHT}}{{UNIT}};'
				],
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

        $this->start_controls_section(
			'section_navigation',
			[
				'label' => esc_html__( 'Navigation Arrows', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_nav' => 'yes']
			]
        );
        
        $this->add_control(
			'nav_arrow_next_icon',
			[
				'label' => esc_html__( 'Next Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'solid',
				],
			]
        );
        
        $this->add_control(
			'nav_arrow_prev_icon',
			[
				'label' => esc_html__( 'Previous Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-arrow-left',
					'library' => 'solid',
				],
			]
        );
        
        $this->start_controls_tabs( 'tabs_arrow_style' );
        
        $this->start_controls_tab(
			'tab_arrow_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
        );
        
        $this->add_control(
			'nav_arrow_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-prev' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-next' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'nav_arrow_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-prev' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-next' => 'background-color: {{VALUE}};'
				],
			]
		);
 
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrow_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);

        $this->add_control(
			'nav_arrow_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-prev:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-next:hover' => 'color: {{VALUE}};'
				],
			]
        );
        
        $this->add_control(
			'nav_arrow_bg_hover_color',
			[
				'label' => esc_html__( 'Background Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-prev:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-next:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'nav_arrow_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'nav_arrow_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 1,
				'default' => 30,
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-prev' => 'font-size: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-next' => 'font-size: {{VALUE}}px;',
				],
			]
		);
        
        $this->add_responsive_control(
			'nav_arrow_box_size',
			[
				'label' => esc_html__( 'Box Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 1,
				'default' => 60,
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-prev' => 'height: {{VALUE}}px;width: {{VALUE}}px;line-height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-next' => 'height: {{VALUE}}px;width: {{VALUE}}px;line-height: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'nav_arrow_radius',
			[
				'label' => esc_html__( 'Box Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-next' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-prev' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'nav_arrow_box_margin',
			[
				'label' => esc_html__( 'Box Right/Left Margin (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -100,
				'max' => 100,
				'step' => 1,
				'default' => 0,
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-next' => 'right: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-prev' => 'left: {{VALUE}}px;'
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_navigation_dots',
			[
				'label' => esc_html__( 'Navigation Dots', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_dots' => 'yes']
			]
		);
        
        $this->add_control(
			'dots_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-dots li button:before' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'dots_size',
			[
				'label' => esc_html__( 'Dot Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 1,
				'default' => 20,
                'selectors' => [
					'{{WRAPPER}} .tme-testimonials-carousel .slick-dots li button:before' => 'font-size: {{VALUE}}px;line-height: {{VALUE}}px;width: {{VALUE}}px;height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-dots li button' => 'width: {{VALUE}}px;height: {{VALUE}}px;',
				],
			]
		);
        
        $this->add_responsive_control(
			'dot_margin',
			[
				'label' => esc_html__( 'Dot Right/Left Padding (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 2,
                'selectors' => [
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-dots li' => 'margin-left: {{VALUE}}px !important;margin-right: {{VALUE}}px !important;',
				],
			]
		);
        
        $this->add_responsive_control(
			'dots_bottom_margin',
			[
				'label' => esc_html__( 'Dots Bottom Margin (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -100,
				'max' => 100,
				'step' => 1,
				'default' => -40,
                'selectors' => [
                    '{{WRAPPER}} .tme-testimonials-carousel .slick-dots' => 'bottom: {{VALUE}}px;',
				],
			]
		);
        
        $this->end_controls_section();

	}
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div id="tme-testimonials-carousel-<?php echo esc_attr($this->get_id()); ?>" class="tme-testimonials-carousel <?php echo esc_attr($settings['carousel_overflow_hidden']); ?>" data-prv="<?php echo $settings['nav_arrow_prev_icon']['value']; ?>" data-nxt="<?php echo $settings['nav_arrow_next_icon']['value']; ?>" data-autoplay="<?php if ($settings['autoplay']) { echo 'true'; } else { echo 'false'; } ?>" data-duration="<?php echo esc_attr($settings['autoplay_duration']); ?>000" data-infinite="<?php if ($settings['infinite']) { echo 'true'; } else { echo 'false'; } ?>" data-nav="<?php if ($settings['display_nav']) { echo 'true'; } else { echo 'false'; } ?>" data-dots="<?php if ($settings['display_dots']) { echo 'true'; } else { echo 'false'; } ?>" data-postcolumns="<?php echo esc_attr($settings['columns']); ?>" data-rtl="<?php if (is_rtl()) { echo 'true'; } else { echo 'false'; } ?>">
        <?php foreach ( $settings['testimonials'] as $item ) { ?>
        <?php $img_url = wp_get_attachment_image_url( $item['image']['id'], $settings['img_size'] ); ?>
            <div class="tme-testimonials-slide">
                <div class="tme-testimonials-item">
                    <div class="tme-testimonials-content <?php echo $settings['content_arrow']; ?>">
                        <?php echo wp_kses_post($item['content']); ?>
                    </div>
                    <div class="tme-testimonials-person">
                        <?php if ($img_url) { ?>
                        <div class="tme-testimonials-thumb"><img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($item['title']); ?>" /></div>
                        <?php } ?>
                        <div class="tme-testimonials-info">
                            <?php if ($item['title']) { ?>
                            <span class="tme-testimonials-title"><?php echo wp_kses_post($item['title']); ?></span>
                            <?php } ?>
                            <?php if ($item['subtitle']) { ?>
                            <span class="tme-testimonials-subtitle"><?php echo wp_kses_post($item['subtitle']); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Testimonial_Carousel() );
?>