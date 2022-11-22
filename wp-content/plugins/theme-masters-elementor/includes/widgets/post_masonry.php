<?php
namespace Elementor;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Post_Masonry extends Widget_Base {

	public function get_name() {
		return 'tme-post_masonry';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Post Masonry', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-masonry','tme-post_masonry' ];
    }

    public function get_style_depends(){
		return [ 'tme-lib-masonry','tme-post_masonry', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
	}
    
    public function get_icon() {
		return 'eicon-gallery-masonry';
	}

	protected function register_controls() {
        
        $this->start_controls_section(
			'section_posts',
			[
				'label' => esc_html__( 'Posts', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'post_type',
			[
				'label' => esc_html__( 'Post Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'options' => TMEA_get_post_types(),
			]
		);
        
        $this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
                    'DESC'  => esc_html__( 'Descending', 'theme-masters-elementor' ),
					'ASC'  => esc_html__( 'Ascending', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
                    'post_date'  => esc_html__( 'Date', 'theme-masters-elementor' ),
					'title'  => esc_html__( 'Title', 'theme-masters-elementor' ),
					'rand'  => esc_html__( 'Random', 'theme-masters-elementor' ),
                    'comment_count'  => esc_html__( 'Comment Count', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'taxonomy',
			[
				'label' => esc_html__( 'Categories', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 'true',
                'multiple' => true,
				'default' => '',
				'options' => TMEA_get_categories(),
				'condition' => ['post_type' => 'post']
			]
		);

		$this->add_control(
			'tags',
			[
				'label' => esc_html__( 'Tags', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 'true',
                'multiple' => true,
				'default' => '',
				'options' => TMEA_get_tags(),
				'condition' => ['post_type' => 'post']
			]
		);

		$this->add_control(
			'authors',
			[
				'label' => esc_html__( 'Authors', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 'true',
                'multiple' => true,
				'default' => '',
				'options' => TMEA_get_authors(),
				'condition' => ['post_type' => 'post']
			]
		);
        
        $this->add_control(
			'max',
			[
				'label' => esc_html__( 'Maximum number of posts', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'include', [
				'label' => esc_html__( 'Include posts by ID', 'theme-masters-elementor' ),
                'description' => esc_html__( 'To include multiple posts, add comma between IDs.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => ''
			]
		);
        
        $this->add_control(
			'exclude', [
				'label' => esc_html__( 'Exclude posts by ID', 'theme-masters-elementor' ),
                'description' => esc_html__( 'To exclude multiple posts, add comma between IDs.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => ''
			]
		);
        
        $this->add_control(
			'excerpt_length',
			[
				'label' => esc_html__( 'Excerpt length (To remove excerpt, enter "0")', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => 140,
			]
		);
        
        $this->add_control(
			'section_posts_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'display_only_thumbnail', [
				'label' => esc_html__( 'Display only posts with thumbnail', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'display_thumbnail', [
				'label' => esc_html__( 'Display post thumbnail', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'display_category', [
				'label' => esc_html__( 'Display categories', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'display_date', [
				'label' => esc_html__( 'Display date', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'display_author_name', [
				'label' => esc_html__( 'Display author name', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'display_author_avatar', [
				'label' => esc_html__( 'Display author avatar', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
				'condition' => ['display_author_name' => 'yes']
			]
		);
        
        $this->add_control(
			'display_author_url', [
				'label' => esc_html__( 'Enable author url', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
				'condition' => ['display_author_name' => 'yes']
			]
		);
        
        $this->add_control(
			'enable_pagination', [
				'label' => esc_html__( 'Enable Pagination', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'add_classes', [
				'label' => esc_html__( 'Add default classes', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_masonry',
			[
				'label' => esc_html__( 'Masonry Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'three-columns',
				'options' => [
                    'one-column'  => esc_html__( '1 Column', 'theme-masters-elementor' ),
					'two-columns'  => esc_html__( '2 Column', 'theme-masters-elementor' ),
					'three-columns'  => esc_html__( '3 Column', 'theme-masters-elementor' ),
                    'four-columns'  => esc_html__( '4 Column', 'theme-masters-elementor' ),
                    'five-columns'  => esc_html__( '5 Column', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_responsive_control(
			'spacing',
			[
				'label' => esc_html__( 'Spacing', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tme-masonry-item' => 'padding: 0px {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-masonry-grid' => 'margin: 0px -{{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'margin_bottom',
			[
				'label' => esc_html__( 'Margin Bottom', 'theme-masters-elementor' ),
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-masonry-item' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
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
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_responsive',
			[
				'label' => esc_html__( 'Responsive', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'responsive_cat_title',
			[
				'label' => esc_html__( 'Categories', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'cats_desktop', [
				'label' => esc_html__( 'Hide On Desktop', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'cats_tablet', [
				'label' => esc_html__( 'Hide On Tablet', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'cats_mobile', [
				'label' => esc_html__( 'Hide On Mobile', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'responsive_excerpt_title',
			[
				'label' => esc_html__( 'Excerpt', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'excerpt_desktop', [
				'label' => esc_html__( 'Hide On Desktop', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'excerpt_tablet', [
				'label' => esc_html__( 'Hide On Tablet', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'excerpt_mobile', [
				'label' => esc_html__( 'Hide On Mobile', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'responsive_footer_title',
			[
				'label' => esc_html__( 'Card Footer', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'footer_desktop', [
				'label' => esc_html__( 'Hide On Desktop', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'footer_tablet', [
				'label' => esc_html__( 'Hide On Tablet', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'footer_mobile', [
				'label' => esc_html__( 'Hide On Mobile', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'Show', 'theme-masters-elementor' ),
				'return_value' => 'hide',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card',
			[
				'label' => esc_html__( 'Card', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'card_layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => [
                    'vertical'  => esc_html__( 'Vertical', 'theme-masters-elementor' ),
					'horizontal'  => esc_html__( 'Horizontal', 'theme-masters-elementor' ),
                    'horizontal-reverse'  => esc_html__( 'Horizontal Reverse', 'theme-masters-elementor' ),
                    'bg-img'  => esc_html__( 'BG Image (Featured image is required)', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_responsive_control(
			'card_img_width',
			[
				'label' => esc_html__( 'Image ratio (%)', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 40,
                ],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'card_layout',
                            'value' => 'horizontal',
                        ],
                        [
                            'name'  => 'card_layout',
                            'value' => 'horizontal-reverse',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-horizontal .tme-posts-card-img-wrapper' => 'width: {{SIZE}}%;',
                    '{{WRAPPER}} .tme-posts-horizontal .tme-posts-card-body-wrapper' => 'width: calc(100% - {{SIZE}}%)',
                    '{{WRAPPER}} .tme-posts-horizontal-reverse .tme-posts-card-img-wrapper' => 'width: {{SIZE}}%;',
                    '{{WRAPPER}} .tme-posts-horizontal-reverse .tme-posts-card-body-wrapper' => 'width: calc(100% - {{SIZE}}%)',
				],
			]
        );
        
        $this->add_responsive_control(
			'card_align',
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
                    '{{WRAPPER}} .tme-posts-card-body-wrapper' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-card-footer' => 'justify-content: {{VALUE}};'
				],
                'toggle' => false
			]
        );
        
        $this->add_responsive_control(
			'card_valign',
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
                'condition' => ['card_layout' => 'bg-img'],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-body-wrapper' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'card_text_align',
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
					'{{WRAPPER}} .tme-posts-card-body-wrapper' => 'text-align: {{VALUE}};',
				],
				'toggle' => false,
			]
		);
        
        $this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card',
			]
        );
        
        $this->add_control(
			'card_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card',
			]
		);
        
        $this->add_responsive_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card',
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_img',
			[
				'label' => esc_html__( 'Card Image', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'card_img_overflow', [
				'label' => esc_html__( 'Overflow Hidden', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'overflowhidden',
				'default' => '',
				'show_label' => true,
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'card_layout',
                            'value' => 'vertical',
                        ],
                        [
                            'name'  => 'card_layout',
                            'value' => 'bg-img',
                        ]
                    ]
                ],
			]
		);

		$this->add_control(
			'card_img_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-featured-img' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->add_control(
			'card_img_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'card_layout',
                            'value' => 'vertical',
                        ],
                        [
                            'name'  => 'card_layout',
                            'value' => 'bg-img',
                        ]
                    ]
                ],
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
					'{{WRAPPER}} .tme-posts-card-featured-img img' => 'opacity: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-horizontal .tme-posts-card-img-wrapper' => 'opacity: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-horizontal-reverse .tme-posts-card-img-wrapper' => 'opacity: {{VALUE}};'
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-featured-img img,{{WRAPPER}} .tme-posts-horizontal .tme-posts-card-img-wrapper,{{WRAPPER}} .tme-posts-horizontal-reverse .tme-posts-card-img-wrapper'
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
					'{{WRAPPER}} .tme-posts-card-featured-img:hover img' => 'opacity: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-horizontal .tme-posts-card-img-wrapper:hover' => 'opacity: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-horizontal-reverse .tme-posts-card-img-wrapper:hover' => 'opacity: {{VALUE}};'
				],
			]
        );

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter_hover',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-featured-img:hover img,{{WRAPPER}} .tme-posts-horizontal .tme-posts-card-img-wrapper:hover,{{WRAPPER}} .tme-posts-horizontal-reverse .tme-posts-card-img-wrapper:hover'
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'card_thumbnail_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_img_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-featured-img img',
			]
		);
        
        $this->add_responsive_control(
			'card_img_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-featured-img img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_img_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-featured-img img',
			]
        );
        
        $this->add_control(
			'card_thumbnail_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'card_img_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-featured-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_img_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-featured-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_body',
			[
				'label' => esc_html__( 'Card Body', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->start_controls_tabs( 'tabs_card_body_style' );
        
        $this->start_controls_tab(
			'tab_card_body_normal',
			[
				'label' => esc_html__( 'Normal', 'wpbits' ),
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'card_body_bg_color',
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-posts-card-body-wrapper',
			]
        );
        
        $this->add_control(
			'card_body_inner_bg_color',
			[
				'label' => esc_html__( 'Inner Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-body' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_card_body_hover',
			[
				'label' => esc_html__( 'Hover', 'wpbits' ),
			]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'card_body_bg_color_hover',
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-posts-card-body-wrapper:hover',
			]
        );
        
        $this->add_control(
			'card_body_inner_bg_color_hover',
			[
				'label' => esc_html__( 'Inner Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-body-wrapper:hover .tme-posts-card-body' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'card_body_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_body_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-body',
			]
		);
        
        $this->add_control(
			'card_body_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'card_body_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_body_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_footer',
			[
				'label' => esc_html__( 'Card Footer', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'card_footer_layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'card-footer-block',
				'options' => [
                    'card-footer-block'  => esc_html__( 'Block', 'theme-masters-elementor' ),
					'card-footer-inline'  => esc_html__( 'Inline', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'card_body_footer_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-footer' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_footer_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-footer',
			]
		);
        
        $this->add_responsive_control(
			'card_footer_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_categories',
			[
				'label' => esc_html__( 'Categories', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_category' => 'yes']
			]
        );
        
        $this->add_control(
			'card_category_style',
			[
				'label' => esc_html__( 'Style', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'list',
				'options' => [
                    'list'  => esc_html__( 'List', 'theme-masters-elementor' ),
					'badge'  => esc_html__( 'Badge', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'card_category_position',
			[
				'label' => esc_html__( 'Position', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
                    'top'  => esc_html__( 'Top', 'theme-masters-elementor' ),
					'bottom'  => esc_html__( 'Bottom', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_responsive_control(
			'card_category_padding',
			[
				'label' => esc_html__( 'Container Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-cats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_category_margin',
			[
				'label' => esc_html__( 'Container Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'card_badge_list_hr',
			[
				'label' => esc_html__( 'List and Badge', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'card_category_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-cats' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-card-cats a' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'card_category_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-cats a:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_category_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-posts-card-cats,{{WRAPPER}} .tme-posts-card-cats a',
			]
		);
        
        $this->add_control(
			'card_badge_hr',
			[
				'label' => esc_html__( 'Badge', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'card_badge_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-masonry-badge' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_badge_border',
				'label' => esc_html__( 'Badge Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-masonry-badge',
			]
		);
        
        $this->add_responsive_control(
			'card_badge_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-masonry-badge' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_badge_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-masonry-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_badge_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-masonry-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_title',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'card_title_html',
			[
				'label' => esc_html__( 'HTML Tag', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
                    'h1'  => esc_html__( 'H1', 'theme-masters-elementor' ),
					'h2'  => esc_html__( 'H2', 'theme-masters-elementor' ),
                    'h3'  => esc_html__( 'H3', 'theme-masters-elementor' ),
                    'h4'  => esc_html__( 'H4', 'theme-masters-elementor' ),
                    'h5'  => esc_html__( 'H5', 'theme-masters-elementor' ),
                    'h6'  => esc_html__( 'H6', 'theme-masters-elementor' ),
                    'div'  => esc_html__( 'div', 'theme-masters-elementor' ),
                    'span'  => esc_html__( 'span', 'theme-masters-elementor' ),
                    'p'  => esc_html__( 'p', 'theme-masters-elementor' ),
				],
			]
		);
        
        $this->add_control(
			'card_title_ellipsis', [
				'label' => esc_html__( 'Ellipsis', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'tme-ellipsis',
				'default' => '',
				'show_label' => true,
			]
		);
        
        $this->add_control(
			'card_title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-card-title a' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'card_title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-title a:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_title_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-posts-card-title,{{WRAPPER}} .tme-posts-card-title a',
			]
        );
        
        $this->add_control(
			'card_title_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'card_title_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'card_excerpt_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
                    '{{WRAPPER}} .tme-posts-excerpt p' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_excerpt_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-posts-excerpt p',
			]
		);
        
        $this->add_responsive_control(
			'card_excerpt_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-excerpt p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_excerpt_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-excerpt p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_author',
			[
				'label' => esc_html__( 'Author', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_author_name' => 'yes']
			]
		);
        
        $this->add_responsive_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Avatar Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 150,
				'step' => 1,
				'default' => 40,
                'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-img img.avatar' => 'width: {{VALUE}}px;height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-posts-card-author-img img' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'avatar_radius',
			[
				'label' => esc_html__( 'Avatar Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-img img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'avatar_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-card-author-img img',
			]
		);
        
        $this->add_control(
			'section_author_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'card_author_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-link' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'card_author_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-link:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_author_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-posts-card-author-link',
			]
        );
        
        $this->add_control(
			'card_author_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'card_author_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_author_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'card_author_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'card_author_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);
        
        $this->add_responsive_control(
			'card_author_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-author-link i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_card_date',
			[
				'label' => esc_html__( 'Date', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_date' => 'yes']
			]
		);
        
        $this->add_control(
			'card_date_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-date-link' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'card_date_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-date-link:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_date_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-posts-card-date-link',
			]
        );
        
        $this->add_control(
			'card_date_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'card_date_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-date-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'card_date_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-date-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'card_date_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'card_date_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);
        
        $this->add_responsive_control(
			'card_date_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-card-date-link i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__( 'Pagination', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['enable_pagination' => 'yes']
			]
		);
        
        $this->add_responsive_control(
			'pagination_margin',
			[
				'label' => esc_html__( 'Container Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_responsive_control(
			'pagination_align',
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
                    '{{WRAPPER}} .tme-posts-pager' => 'justify-content: {{VALUE}};'
				],
                'toggle' => false
			]
        );
        
        $this->add_control(
			'pagination_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        ); 
        
        $this->add_responsive_control(
			'pagination_item_size',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 1,
				'default' => 40,
                'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a' => 'width: {{VALUE}}px;height: {{VALUE}}px;line-height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-posts-pager > span' => 'width: {{VALUE}}px;height: {{VALUE}}px;line-height: {{VALUE}}px;',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_item_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-posts-pager > a, {{WRAPPER}} .tme-posts-pager > span',
			]
        );
        
        $this->add_control(
			'pagination_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        ); 

        $this->start_controls_tabs( 'tabs_pagination_style' );
        
        $this->start_controls_tab(
			'tab_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'wpbits' ),
			]
		);
        
        $this->add_control(
			'pagination_item_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-pager > span' => 'color: {{VALUE}};',
				],
			]
        );
        
        $this->add_control(
			'pagination_item_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-pager > span' => 'background-color: {{VALUE}};',
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pagination_item_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-pager > a, {{WRAPPER}} .tme-posts-pager > span',
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'wpbits' ),
			]
		);

        $this->add_control(
			'pagination_item_hover_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-pager > span.current' => 'color: {{VALUE}};'
				],
			]
        );
        
        $this->add_control(
			'pagination_item_bg_hover',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-posts-pager > span.current' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pagination_item_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-posts-pager > a:hover,{{WRAPPER}} .tme-posts-pager > span.current',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'pagination_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        ); 
        
        $this->add_responsive_control(
			'pagination_item_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-posts-pager > span' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'pagination_item_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-posts-pager > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tme-posts-pager > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();

	}
    
    protected function render() {
        $widget_id = $this->get_id();
        $settings = $this->get_settings_for_display();
		$postype = $settings['post_type'];
        $order = $settings['order'];
		$orderby = $settings['orderby'];
		$max = $settings['max'];
		$authors = $settings['authors'];
		$categories = $settings['taxonomy'];
        $tags = $settings['tags'];
        
        if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
        elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
        else { $paged = 1; } 

		$terms = array();
		if (empty($authors)) {
			$authors = array();
        }
        
        if (!$settings['enable_pagination']) {
            $paged = 1;
        }

        if ($settings['display_only_thumbnail']) {
            $metakey = '_thumbnail_id';
        } else {
            $metakey = false;
        }

		if ($categories && $tags) {
			$terms = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categories,
				),
				array(
					'taxonomy' => 'post_tag',
					'field'    => 'term_id',
					'terms'    => $tags,
				)
			);
		} elseif ($categories) {
			$terms = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categories,
				)
			);
		} elseif ($tags) {
			$terms = array(
				array(
					'taxonomy' => 'post_tag',
					'field'    => 'term_id',
					'terms'    => $tags,
				)
			);
		}
        
        if ($settings['exclude']) {
            $exclude = explode( ',', $settings['exclude'] );
        } else {
            $exclude = array();
		}
		
		if ($settings['include']) {
            $include = explode( ',', $settings['include'] );
        } else {
            $include = array();
        }

        $custom_query = new WP_Query( 
        	array(
                'post_type' => $postype, 
                'post_status' => 'publish',
                'posts_per_page' => $max,
                'order' => $order,
                'orderby' => $orderby,
                'paged' => $paged,
                'meta_key' => $metakey,
				'post__in' => $include,
				'post__not_in' => $exclude,
				'author__in' => $authors,
                'ignore_sticky_posts' => true,
                'tax_query' => $terms,
            )
        );

        if ($custom_query->have_posts()) {
        ?>
        <div id="tme-posts-<?php echo esc_attr($widget_id); ?>" class="tme-masonry-grid">
            <div class="tme-<?php echo esc_attr($settings['columns']); ?>" data-columns>
                <?php while($custom_query->have_posts()) : $custom_query->the_post(); ?>
                <div <?php if ($settings['add_classes']) { post_class('tme-masonry-item'); } else { echo 'class="tme-masonry-item"'; } ?>>
                    <div class="tme-posts-card tme-posts-<?php echo esc_attr($settings['card_layout']); ?>">
                    <?php if ((has_post_thumbnail()) && ($settings['display_thumbnail'])) { ?>
                    <?php
                    $tmeposts_thumb_id = get_post_thumbnail_id();
                    $tmeposts_thumb_url_array = wp_get_attachment_image_src($tmeposts_thumb_id, $settings['img_size'], true);
                    $tmeposts_thumb_url = $tmeposts_thumb_url_array[0];
                    ?>
                        
                    <?php if (($settings['card_layout'] == 'horizontal') || ($settings['card_layout'] == 'horizontal-reverse')) { ?> 
                    <div class="tme-posts-card-img-wrapper" style="background-image:url('<?php echo esc_url($tmeposts_thumb_url); ?>');">  
                        <a class="tme-posts-card-featured-img" href="<?php the_permalink(); ?>"></a>    
                    </div>    
                    <?php } else { ?> 
                    <div class="tme-posts-card-img-wrapper <?php echo esc_attr($settings['card_img_overflow']); ?>">  
                        <a class="tme-posts-card-featured-img elementor-animation-<?php echo esc_attr($settings['card_img_animation']); ?>" href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url($tmeposts_thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />   
                        </a>    
                    </div>     
                    <?php } ?>    
                         
                    <?php } ?>
                        <div class="tme-posts-card-body-wrapper">
                        <div class="tme-posts-card-body-wrapper-inner">
                        <?php if ($settings['card_layout'] == 'bg-img') { ?>
                            <a class="tme-posts-card-body-url" href="<?php the_permalink(); ?>"></a>
                        <?php } ?>    
                        <div class="tme-posts-card-body">
                            <?php if (( has_category() ) && ($settings['display_category']) && ($settings['card_category_position'] == 'top')) { ?> 
                            <div class="tme-posts-card-cats">
                                <?php if ($settings['card_category_style'] == 'badge') { ?>
                                <span class="tme-masonry-badge"><?php the_category('</span><span class="tme-masonry-badge">'); ?></span>
                                <?php } else { ?>
                                <span><?php the_category(',</span> <span>'); ?></span>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <<?php echo esc_attr($settings['card_title_html']); ?> class="tme-posts-card-title <?php echo esc_attr($settings['card_title_ellipsis']); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_attr($settings['card_title_html']); ?>>
                            <?php 
                            if ((get_the_excerpt()) && (!empty($settings['excerpt_length'])) && ($settings['excerpt_length'] != 0)) {
                                echo '<div class="tme-posts-excerpt">' . wpautop(TMEA_excerpt($settings['excerpt_length'])) . '</div>';
                            }
                            ?> 
                            <?php if (( has_category() ) && ($settings['display_category']) && ($settings['card_category_position'] == 'bottom')) { ?> 
                            <div class="tme-posts-card-cats">
                                <?php if ($settings['card_category_style'] == 'badge') { ?>
                                <span class="tme-masonry-badge"><?php the_category('</span><span class="tme-masonry-badge">'); ?></span>
                                <?php } else { ?>
                                <span><?php the_category(',</span> <span>'); ?></span>
                                <?php } ?>
                            </div>
                            <?php } ?>    
                        </div>
                        <div class="tme-posts-card-footer">
                            <?php if ($settings['display_author_avatar']) { ?>
                            <div class="tme-posts-card-author-img">
                                <?php if ($settings['display_author_url']) { ?>
                                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), $settings['avatar_size'] ); ?></a>
                                <?php } else { ?>
                                <?php echo get_avatar( get_the_author_meta( 'ID' ), $settings['avatar_size'] ); ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <div class="tme-posts-card-date <?php echo esc_attr($settings['card_footer_layout']) ?>">
                                <?php if ($settings['display_author_name']) { ?>           
                                <?php if ($settings['display_author_url']) { ?>
                                <a class="tme-posts-card-author-link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['card_author_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_author(); ?>
                                </a>
                                <?php } else { ?>
                                <span class="tme-posts-card-author-link">
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['card_author_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_author(); ?>
                                </span>
                                <?php } ?>
                                <?php } ?>
                                <?php if ($settings['display_date']) { ?>
                                <a class="tme-posts-card-date-link" href="<?php esc_url(the_permalink()); ?>">
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['card_date_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_time(get_option('date_format')); ?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div> 
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="tme-clear"></div>
        <?php if (( $custom_query->max_num_pages > 1 ) && ($settings['enable_pagination'])) { ?>
        <div class="tme-posts-pager">
            <?php 
            $big = 999999999;
            $args = array(
                'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
                'current' => max( 1, $paged ),
                'total' => $custom_query->max_num_pages,
                'show_all'           => false,
                'end_size'           => 1,
                'mid_size'           => 5,
                'prev_next'          => true,
                'prev_text'          => '<i class="fas fa-chevron-left"></i>',
                'next_text'          => '<i class="fas fa-chevron-right"></i>',
                'type'               => 'plain',
                'add_args'           => false,
                'add_fragment'       => '',
                'before_page_number' => '',
                'after_page_number'  => ''
            );
            echo paginate_links( $args );
            ?>
        </div> 
        <div class="tme-clear"></div>    
        <?php } ?>      
        <?php wp_reset_postdata(); ?>
        <style type="text/css">
            <?php
            $viewport_lg = get_option('elementor_viewport_lg', true);
            if (empty($viewport_lg)) {
                $viewport_lg = 1025;
            }                              
            $viewport_md = get_option('elementor_viewport_md', true);
            if (empty($viewport_md)) {
                $viewport_md = 768;
            } 
            ?>
            @media screen and (min-width: <?php echo ($viewport_lg + 1) . 'px'; ?>) {
                <?php if ($settings['cats_desktop']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-cats {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-cats {
                    display: block !important;
                }
                <?php } ?>
                <?php if ($settings['excerpt_desktop']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-excerpt {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-excerpt {
                    display: block !important;
                }
                <?php } ?>
                <?php if ($settings['footer_desktop']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-footer {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-footer {
                    display: flex !important;
                }
                <?php } ?>
            }
            @media only screen and (max-width: <?php echo esc_attr($viewport_lg) . 'px'; ?>) {
                <?php if ($settings['cats_tablet']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-cats {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-cats {
                    display: block !important;
                }
                <?php } ?>
                <?php if ($settings['excerpt_tablet']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-excerpt {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-excerpt {
                    display: block !important;
                }
                <?php } ?>
                <?php if ($settings['footer_tablet']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-footer {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-footer {
                    display: flex !important;
                }
                <?php } ?>
            }
            @media screen and (max-width: <?php echo esc_attr($viewport_md) . 'px'; ?>) {
                <?php if ($settings['cats_mobile']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-cats {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-cats {
                    display: block !important;
                }
                <?php } ?>
                <?php if ($settings['excerpt_mobile']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-excerpt {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_js($widget_id); ?> .tme-posts-excerpt {
                    display: block !important;
                }
                <?php } ?>
                <?php if ($settings['footer_mobile']) { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-footer {
                    display: none !important;
                }
                <?php } else { ?>
                #tme-posts-<?php echo esc_attr($widget_id); ?> .tme-posts-card-footer {
                    display: flex !important;
                }
                <?php } ?>
            }
        </style>
	<?php } else { ?>
    <div class="tme-danger"><?php esc_html_e( 'Nothing was found!', 'theme-masters-elementor' ); ?></div>         
<?php }
}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Post_Masonry() );
?>