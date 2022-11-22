<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Team_Carousel extends Widget_Base {

	public function get_name() {
		return 'tme-team_carousel';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Team Carousel', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-lib-slick','elementor-icons-fa-solid','tme-lib-animate','tme-lib-lightbox','tme-team_member' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-slick','tme-lib-lightbox','tme-team_carousel' ];
	}

	public function get_icon() {
		return 'eicon-person';
	}
    
    function get_anim_exits($animation) {
		if ($animation) {
        $animation_array = array(
            'bounce' => 'fadeOut',
            'flash' => 'fadeOut',
            'pulse' => 'fadeOut',
            'rubberBand' => 'fadeOut',
            'shake' => 'fadeOut',
            'swing' => 'fadeOut',
            'tada' => 'fadeOut',
            'wobble' => 'fadeOut',
            'jello' => 'fadeOut',
            'heartBeat' => 'fadeOut',
            'bounceIn' => 'bounceOut',
            'bounceInDown' => 'bounceOutUp',
            'bounceInLeft' => 'bounceOutLeft',
            'bounceInRight' => 'bounceOutRight',
            'bounceInUp' => 'bounceOutDown',
            'fadeIn' => 'fadeOut',
            'fadeInDown' => 'fadeOutUp',
            'fadeInDownBig' => 'fadeOutUpBig',
            'fadeInLeft' => 'fadeOutLeft',
            'fadeInLeftBig' => 'fadeOutLeftBig',
            'fadeInRight' => 'fadeOutRight',
            'fadeInRightBig' => 'fadeOutRightBig',
            'fadeInUp' => 'fadeOutDown',
            'fadeInUpBig' => 'fadeOutDownBig',
            'flip' => 'fadeOut',
            'flipInX' => 'flipOutX',
            'flipInY' => 'flipOutY',
            'lightSpeedIn' => 'lightSpeedOut',
            'rotateIn' => 'rotateOut',
            'rotateInDownLeft' => 'rotateOutUpLeft',
            'rotateInDownRight' => 'rotateOutUpRight',
            'rotateInUpLeft' => 'rotateOutDownLeft',
            'rotateInUpRight' => 'rotateOutDownRight',
            'slideInUp' => 'slideOutDown',
            'slideInDown' => 'slideOutUp',
            'slideInLeft' => 'slideOutLeft',
            'slideInRight' => 'slideOutRight',
            'zoomIn' => 'zoomOut',
            'zoomInDown' => 'zoomOutUp',
            'zoomInLeft' => 'zoomOutLeft',
            'zoomInRight' => 'zoomOutRight',
            'zoomInUp' => 'zoomOutDown',
            'hinge' => 'fadeOut',
            'jackInTheBox' => 'fadeOut',
            'rollIn' => 'fadeOut'
        );
        $animation = $animation_array[$animation];
		return $animation;
	}
    }
    
	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Team', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'show_label' => false
			]
		);
        
        $repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Name', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => esc_html__( 'John Doe', 'theme-masters-elementor' )
			]
		);
        
        $repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Info', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => esc_html__( 'Web Designer', 'theme-masters-elementor' )
			]
		);
        
        $repeater->add_control(
			'heading_lightbox',
			[
				'label' => esc_html__( 'Link to', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $repeater->add_control(
			'lightbox_style',
			[
				'label' => esc_html__( 'Link to', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
                    'none'  => esc_html__( 'No link', 'theme-masters-elementor' ),
                    'external'  => esc_html__( 'External Url', 'theme-masters-elementor' ),
					'img'  => esc_html__( 'Image', 'theme-masters-elementor' ),
					'video' => esc_html__( 'Video', 'theme-masters-elementor' ),
				],
                'label_block' => true,
                'show_label' => false
			]
		);
        
        $repeater->add_control(
			'external_link',
			[
				'label' => esc_html__( 'Destination Url', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'theme-masters-elementor' ),
				'show_external' => true,
                'condition' => ['lightbox_style' => 'external'],
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
        
        $repeater->add_control(
			'lightbox_image',
			[
				'label' => esc_html__( 'Lightbox Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['lightbox_style' => 'img'],
                'show_label' => false
			]
		);
        
        $repeater->add_control(
			'oembed',
			[
				'label' => esc_html__( 'Lightbox Video URL', 'theme-masters-elementor' ),
                'description' => esc_html__( 'For example: https://www.youtube.com/watch?v=8AZ8GqW5iak', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => ['lightbox_style' => 'video'],
				'input_type' => 'url',
                'show_label' => false
			]
		);
        
        $repeater->add_control(
			'lightbox_content',
			[
				'label' => esc_html__( 'Lightbox Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'lightbox_style',
                            'value' => 'img',
                        ],
                        [
                            'name'  => 'lightbox_style',
                            'value' => 'video',
                        ]
                    ]
                ],
			]
		);
        
        $repeater->add_control(
			'box_content', [
				'label' => esc_html__( 'Lightbox Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
				'label_block' => true,
                'show_label' => false,
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'lightbox_style',
                            'value' => 'img',
                        ],
                        [
                            'name'  => 'lightbox_style',
                            'value' => 'video',
                        ]
                    ]
                ],
			]
        );
        
        $this->add_control(
			'gallery', [
				'label' => esc_html__( 'Team Members', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
                    [
                        'title' => esc_html__( 'Title #1', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #1', 'theme-masters-elementor' ),
                        'image' => \Elementor\Utils::get_placeholder_image_src(),
                        'lightbox_image' => '',
                        'oembed' => '',
                        'lightbox_content' => ''
				    ],
                    [
                        'title' => esc_html__( 'Title #2', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #2', 'theme-masters-elementor' ),
                        'image' => \Elementor\Utils::get_placeholder_image_src(),
                        'lightbox_image' => '',
                        'oembed' => '',
                        'lightbox_content' => ''
				    ],
                    [
                        'title' => esc_html__( 'Title #3', 'theme-masters-elementor' ),
                        'subtitle' => esc_html__( 'Subtitle #3', 'theme-masters-elementor' ),
                        'image' => \Elementor\Utils::get_placeholder_image_src(),
                        'lightbox_image' => '',
                        'oembed' => '',
                        'lightbox_content' => ''
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
				'default' => 'yes',
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
				'default' => '',
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
        
        // section start
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
				'default' => 'large',
				'options' => TMEA_get_image_sizes(),
			]
		);
        
        $this->add_responsive_control(
			'max_img_size',
			[
				'label' => esc_html__( 'Max. Thumb Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 2000,
				'step' => 10,
				'default' => 600,
                'selectors' => [
					'{{WRAPPER}} .tme-team-member' => 'max-width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'img_h_align',
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
					'{{WRAPPER}} .tme-team-member-wrapper' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'thumbnail_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} .tme-team-member a' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'thumbnail_opacity_duration',
			[
				'label' => esc_html__( 'Opacity Animation Duration', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 0.2,
                'selectors' => [
					'{{WRAPPER}} .tme-team-member img' => 'transition-duration: {{VALUE}}s;'
				],
			]
		);

		$this->add_control(
			'thumb_hr_1',
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
		
		$this->add_control(
			'thumbnail_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-team-member img' => 'opacity: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-member img'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnail_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);

		$this->add_control(
			'thumbnail_hover_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-team-member a:hover img' => 'opacity: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_css_filter',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-member a:hover img'
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'thumb_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumb_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-member a',
			]
		);
        
        $this->add_responsive_control(
			'thumb_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-member a' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-team-member img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-team-member' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'thumb_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ), 
				'selector' => '{{WRAPPER}} .tme-team-member',
			]
		);
        
		$this->end_controls_section();
		
		// section start
        $this->start_controls_section(
			'section_carousel',
			[
				'label' => esc_html__( 'Carousel', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
        
        $this->end_controls_section();
        
        // section start
        $this->start_controls_section(
			'section_caption',
			[
				'label' => esc_html__( 'Box Content', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_placement',
			[
				'label' => esc_html__( 'Placement', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'in-img',
				'options' => [
					'in-img'  => esc_html__( 'On the image', 'theme-masters-elementor' ),
					'below-img' => esc_html__( 'Below the image', 'theme-masters-elementor' ),
				]
			]
		);
        
        $this->add_control(
			'caption_style',
			[
				'label' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => esc_html__( 'Name & Info', 'theme-masters-elementor' ),
					'icon' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				]
			]
		);
        
        $this->add_responsive_control(
			'caption_align',
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
					'{{WRAPPER}} .tme-team-overlay' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'caption_valign',
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
					'{{WRAPPER}} .tme-team-overlay' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'caption_text_align',
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
					]
				],
                'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .tme-team-texts' => 'text-align: {{VALUE}};'
				],
				'toggle' => false
			]
		);
        
        $this->add_control(
			'box_content_animation',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
		);

		$this->add_control(
			'overflow_hidden',
			[
				'label' => esc_html__( 'Overflow', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hidden', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Auto', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'box_content_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->start_controls_tabs( 'box_content_style' );
        
        $this->start_controls_tab(
			'box_content_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_responsive_control(
			'box_content_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-team-overlay' => 'opacity: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_content_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-team-overlay',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_content_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-overlay'
			]
		);
        
        $this->add_responsive_control(
			'box_content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'box_content_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_responsive_control(
			'box_content_hover_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-team-overlay:hover' => 'opacity: {{VALUE}};'
				],
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_content_hover_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-team-overlay:hover',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_content_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-overlay:hover'
			]
		);
        
        $this->add_responsive_control(
			'box_content_hover_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'box_content_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'box_content_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-team-overlay' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
        $this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['caption_style' => 'name']
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-title' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-team-overlay .tme-team-title',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-title',
			]
		);
        
        $this->add_control(
			'title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-title span' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'title_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'title_entrance_animation',
			[
				'label' => esc_html__( 'Entrance Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ANIMATION
			]
		);
        
        $this->add_control(
			'title_entrance_animation_duration',
			[
				'label' => esc_html__( 'Entrance Animation Duration', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
                'label_block' => 'true',
				'options' => [
					''  => esc_html__( 'Default', 'theme-masters-elementor' ),
					'fast'  => esc_html__( 'Fast', 'theme-masters-elementor' ),
                    'faster'  => esc_html__( 'Faster', 'theme-masters-elementor' ),
                    'slow'  => esc_html__( 'Slow', 'theme-masters-elementor' ),
                    'slower'  => esc_html__( 'Slower', 'theme-masters-elementor' ),
				],
			]
		);
        
        $this->add_control(
			'title_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
        $this->start_controls_section(
			'section_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['caption_style' => 'name']
			]
		);
        
        $this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-subtitle' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-team-overlay .tme-team-subtitle',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-subtitle',
			]
		);
        
        $this->add_control(
			'subtitle_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-subtitle span' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'subtitle_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'subtitle_entrance_animation',
			[
				'label' => esc_html__( 'Entrance Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ANIMATION
			]
		);
        
        $this->add_control(
			'subtitle_entrance_animation_duration',
			[
				'label' => esc_html__( 'Entrance Animation Duration', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
                'label_block' => 'true',
				'options' => [
					''  => esc_html__( 'Default', 'theme-masters-elementor' ),
					'fast'  => esc_html__( 'Fast', 'theme-masters-elementor' ),
                    'faster'  => esc_html__( 'Faster', 'theme-masters-elementor' ),
                    'slow'  => esc_html__( 'Slow', 'theme-masters-elementor' ),
                    'slower'  => esc_html__( 'Slower', 'theme-masters-elementor' ),
				],
			]
		);
        
        $this->add_control(
			'subtitle_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'subtitle_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-subtitle span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-overlay .tme-team-texts .tme-team-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
        $this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['caption_style' => 'icon']
			]
		);
        
        $this->add_control(
			'thumb_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-search',
					'library' => 'solid',
				],
			]
		);
        
        $this->add_control(
			'icon_animation',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
		);
        
        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 1,
				'default' => 30,
                'selectors' => [
					'{{WRAPPER}} .tme-team-icon i' => 'font-size: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-team-icon i' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'icon_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-icon i',
			]
		);
        
        $this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .tme-team-icon' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'icon_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 300,
				'step' => 1,
				'default' => 30,
                'selectors' => [
					'{{WRAPPER}} .tme-team-icon' => 'width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_control(
			'icon_height',
			[
				'label' => esc_html__( 'Height (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 300,
				'step' => 1,
				'default' => 30,
                'selectors' => [
					'{{WRAPPER}} .tme-team-icon' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-team-icon i' => 'line-height: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'icon_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-icon' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-team-icon i',
			]
		);
        
        $this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-team-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
        $this->start_controls_section(
			'section_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'lightbox_bg_color',
			[
				'label' => esc_html__( 'Content Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff'
			]
		);
        
        $this->add_control(
			'box_width',
			[
				'label' => esc_html__( 'Maximum Lightbox Width (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 3000,
				'step' => 10,
				'default' => 800,
			]
		);
        
        $this->add_control(
			'lightbox_spacing',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-lightbox-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-team-carousel .slick-prev' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-team-carousel .slick-next' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .tme-team-carousel .slick-prev' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-team-carousel .slick-next' => 'background-color: {{VALUE}};'
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
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-team-carousel .slick-prev:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-team-carousel .slick-next:hover' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .tme-team-carousel .slick-prev:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-team-carousel .slick-next:hover' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .tme-team-carousel .slick-prev' => 'font-size: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-team-carousel .slick-next' => 'font-size: {{VALUE}}px;',
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
					'{{WRAPPER}} .tme-team-carousel .slick-prev' => 'height: {{VALUE}}px;width: {{VALUE}}px;line-height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-team-carousel .slick-next' => 'height: {{VALUE}}px;width: {{VALUE}}px;line-height: {{VALUE}}px;'
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
					'{{WRAPPER}} .tme-team-carousel .slick-next' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-team-carousel .slick-prev' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-team-carousel .slick-next' => 'right: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-team-carousel .slick-prev' => 'left: {{VALUE}}px;'
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
					'{{WRAPPER}} .tme-team-carousel .slick-dots li button:before' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .tme-team-carousel .slick-dots li button:before' => 'font-size: {{VALUE}}px;line-height: {{VALUE}}px;width: {{VALUE}}px;height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-team-carousel .slick-dots li button' => 'width: {{VALUE}}px;height: {{VALUE}}px;',
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
                    '{{WRAPPER}} .tme-team-carousel .slick-dots li' => 'margin-left: {{VALUE}}px !important;margin-right: {{VALUE}}px !important;',
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
				'default' => 20,
                'selectors' => [
                    '{{WRAPPER}} .tme-team-carousel .slick-dots' => 'bottom: {{VALUE}}px;',
				],
			]
		);
        
        $this->end_controls_section();

	}

	/**
	 * Render 
	 */
	protected function render( ) {
        $settings = $this->get_settings_for_display(); 
        if ($settings['gallery']) {
        ?>
        <div id="tme-team-carousel-<?php echo esc_attr($this->get_id()); ?>" class="tme-team-carousel <?php echo esc_attr($settings['carousel_overflow_hidden']); ?>" data-prv="<?php echo $settings['nav_arrow_prev_icon']['value']; ?>" data-nxt="<?php echo $settings['nav_arrow_next_icon']['value']; ?>" data-autoplay="<?php if ($settings['autoplay']) { echo 'true'; } else { echo 'false'; } ?>" data-duration="<?php echo esc_attr($settings['autoplay_duration']); ?>000" data-infinite="<?php if ($settings['infinite']) { echo 'true'; } else { echo 'false'; } ?>" data-nav="<?php if ($settings['display_nav']) { echo 'true'; } else { echo 'false'; } ?>" data-dots="<?php if ($settings['display_dots']) { echo 'true'; } else { echo 'false'; } ?>" data-postcolumns="<?php echo esc_attr($settings['columns']); ?>" data-rtl="<?php if (is_rtl()) { echo 'true'; } else { echo 'false'; } ?>">
        <?php foreach ( $settings['gallery'] as $item ) { ?>
            <?php 
            $img_url = wp_get_attachment_image_url( $item['image']['id'], $settings['img_size'] );  
            if (!$img_url) {
            $img_url = $item['image']['url']; 
            } 
            ?>
            <div class="tme-carousel-item">
                <div class="tme-team-member-wrapper">
                    <div class="tme-team-member <?php echo esc_attr($settings['caption_placement']); ?>">
                        <?php if ($item['lightbox_style'] == 'external') { ?>
                        <?php
                        $target = $item['external_link']['is_external'] ? ' target="_blank"' : '';
                        $nofollow = $item['external_link']['nofollow'] ? ' rel="nofollow"' : '';
                        ?>
                        <a href="<?php echo esc_url($item['external_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> data-elementor-open-lightbox="no" class="<?php if ($settings['overflow_hidden']) { echo 'no-overlay'; } ?>">
                        <?php } elseif ($item['lightbox_style'] != 'none') { ?>
                        <a href="#tme-lightbox-<?php echo esc_attr($item['_id']); ?>" data-elementor-open-lightbox="no" class="has-lightbox <?php if ($settings['overflow_hidden']) { echo 'no-overlay'; } ?>">
                        <?php } ?>    
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($item['title']); ?>" />
                            <?php if (($settings['caption_style'] == 'name') && (($item['title']) || ($item['subtitle']))) { ?>
                            <div class="tme-team-overlay elementor-animation-<?php echo esc_attr($settings['box_content_animation']); ?>  <?php if ($settings['overflow_hidden']) { echo 'no-overlay'; } ?>">
                                <div class="tme-team-texts">
                                    <?php if ($item['title']) { ?>
                                    <div class="tme-team-title <?php if (($settings['title_entrance_animation']) && ($settings['title_entrance_animation'] != 'none')) { ?>animated tme-hide<?php } ?> <?php echo $settings['title_entrance_animation_duration']; ?>" data-animation="<?php echo $settings['title_entrance_animation']; ?>" data-exit="<?php echo $this->get_anim_exits($settings['title_entrance_animation']); ?>">
                                        <span><?php echo esc_html($item['title']); ?></span>
                                    </div>
                                    <?php } ?>
                                    <?php if ($item['subtitle']) { ?>
                                    <div class="tme-team-subtitle <?php if (($settings['subtitle_entrance_animation']) && ($settings['subtitle_entrance_animation'] != 'none')) { ?>animated tme-hide<?php } ?> <?php echo $settings['subtitle_entrance_animation_duration']; ?>" data-animation="<?php echo $settings['subtitle_entrance_animation']; ?>" data-exit="<?php echo $this->get_anim_exits($settings['subtitle_entrance_animation']); ?>">
                                        <span><?php echo esc_html($item['subtitle']); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } elseif ($settings['caption_style'] == 'icon') { ?>
                            <div class="tme-team-overlay elementor-animation-<?php echo esc_attr($settings['icon_animation']); ?> <?php if ($settings['overflow_hidden']) { echo 'no-overlay'; } ?>">
                                <div class="tme-team-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['thumb_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
                            </div>
                            <?php } ?> 
                        <?php if ($item['lightbox_style'] != 'none') { ?>    
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
        <?php foreach ( $settings['gallery'] as $item ) { ?>
        <?php 
        if (($item['lightbox_style'] == 'img') || ($item['lightbox_style'] == 'video')) {
        /**
        * Lightbox content
        */
        $lightbox_image = $item['lightbox_image'];    
        $video_url = $item['oembed']; 
        $box_content = $item['box_content'];
        ?>
        <div id="tme-lightbox-<?php echo esc_attr($item['_id']); ?>" class="tme-lightbox-oembed">
            <?php if (($video_url) && ($item['lightbox_style'] == 'video')) { ?>
            <div class="tme-lightbox-iframe">
            <?php
            $args = array(
                'width' => $settings['box_width']
            );
            ?>
            <?php $oembed = wp_oembed_get( $settings['oembed'], $args ); ?>
            <?php echo ( $oembed ) ? $oembed : $settings['oembed']; ?>
            </div>
            <?php } elseif (($item['lightbox_image']['url']) && ($item['lightbox_style'] == 'img')) { ?>
            <?php $lightbox_image_url = wp_get_attachment_image_url( $item['lightbox_image']['id'], 'full' );  ?>
            <div class="tme-lightbox-image" style="max-width:<?php echo esc_attr($settings['box_width']); ?>px;">
                <img src="<?php echo esc_url($lightbox_image_url); ?>" alt="" />
            </div>
            <?php } ?>
            <?php if ($box_content) { ?>
            <div class="tme-lightbox-content" style="max-width:<?php echo esc_attr($settings['box_width']); ?>px;background-color:<?php echo esc_attr($settings['lightbox_bg_color']); ?>;padding:<?php echo esc_attr($settings['lightbox_spacing']['top'] . $settings['lightbox_spacing']['unit']); ?> <?php echo esc_attr($settings['lightbox_spacing']['right'] . $settings['lightbox_spacing']['unit']); ?> <?php echo esc_attr($settings['lightbox_spacing']['bottom'] . $settings['lightbox_spacing']['unit']); ?> <?php echo esc_attr($settings['lightbox_spacing']['left'] . $settings['lightbox_spacing']['unit']); ?>">
                <?php echo do_shortcode($box_content); ?>
            </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php } ?>
    <?php }
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Team_Carousel() );