<?php
namespace Elementor;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Post_List extends Widget_Base {

	public function get_name() {
		return 'tme-post_list';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Post List', 'theme-masters-elementor' );
    }
    
    public function get_categories() {
		return [ 'theme-masters-elementor' ];
    }
    
    public function get_style_depends(){
		return [ 'tme-post_list' ];
	}

	public function get_icon() {
		return 'eicon-post-list';
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
			'section_posts_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
			'display_only_thumbnail', [
				'label' => esc_html__( 'Display only posts with thumbnail', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
				'condition' => ['display_thumbnail' => 'yes']
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
			'display_author_url', [
				'label' => esc_html__( 'Enable author url', 'theme-masters-elementor' ),
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
                'condition' => ['display_author_url' => 'yes'],
				'show_label' => true,
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_list_item',
			[
				'label' => esc_html__( 'List Item', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_responsive_control(
			'list_item_valign',
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
					'{{WRAPPER}} .tme-post-list-wrapper' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
        );
        
        $this->add_control(
			'column_reverse', [
				'label' => esc_html__( 'Reverse Columns', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'reverse',
				'default' => '',
				'show_label' => true,
			]
        );

        $this->add_control(
			'list_item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-wrapper' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'list_item_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-list-wrapper',
			]
		);
        
        $this->add_responsive_control(
			'list_item_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_item_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-list-wrapper',
			]
        );
        
        $this->add_control(
			'list_item_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'list_item_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'list_item_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_list_img',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_thumbnail' => 'yes']
			]
		);
        
        $this->add_responsive_control(
			'list_img_width',
			[
				'label' => esc_html__( 'Width (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 500,
				'step' => 1,
				'default' => 40,
                'selectors' => [
					'{{WRAPPER}} .tme-post-list-left' => 'width: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-post-list-right' => 'width: calc(100% - {{VALUE}}px)',
				],
			]
		);
        
        $this->add_control(
			'list_img_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION
			]
		);
        
        $this->add_control(
			'list_thumbnail_opacity',
			[
				'label' => esc_html__( 'Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-post-list-img img' => 'opacity: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'list_thumbnail_hover_opacity',
			[
				'label' => esc_html__( 'Hover Opacity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.1,
				'default' => 1,
                'selectors' => [
					'{{WRAPPER}} .tme-post-list-img:hover img' => 'opacity: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'list_img_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-img' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'list_img_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_img_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-list-img img',
			]
		);
        
        $this->add_responsive_control(
			'list_img_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-img img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_img_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-list-img img',
			]
        );
        
        $this->add_control(
			'list_img_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'list_img_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'list_img_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_list_title',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'list_title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-title' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'list_title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-title:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'list_title_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-post-list-title',
			]
        );
        
        $this->add_control(
			'list_title_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'list_title_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'list_title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_list_author',
			[
				'label' => esc_html__( 'Author', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_author_name' => 'yes']
			]
        );
        
        $this->add_control(
			'list_author_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-author-link' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'list_author_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-author-link:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'list_author_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-post-list-author-link',
			]
        );
        
        $this->add_control(
			'author_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'list_author_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-author-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'list_author_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-author-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'author_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
				'default' => 16,
                'selectors' => [
					'{{WRAPPER}} .tme-post-list-date img' => 'width: {{VALUE}}px;height: {{VALUE}}px;'
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
					'{{WRAPPER}} .tme-post-list-date img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'author_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'list_author_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);
        
        $this->add_responsive_control(
			'list_author_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-author-link i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_list_date',
			[
				'label' => esc_html__( 'Date', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_date' => 'yes']
			]
		);
        
        $this->add_control(
			'list_date_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-date-link' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control(
			'list_date_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-date-link:hover' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'list_date_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tme-post-list-date-link',
			]
        );
        
        $this->add_control(
			'list_date_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'list_date_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);
        
        $this->add_responsive_control(
			'list_date_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-date-link i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'list_date_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'list_date_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-date-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'list_date_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-list-date-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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

		$terms = array();
		if (empty($authors)) {
			$authors = array();
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
        <?php while($custom_query->have_posts()) : $custom_query->the_post(); ?>
        <div class="tme-post-list-wrapper <?php echo esc_attr($settings['column_reverse']); ?>">
            <?php if ((has_post_thumbnail()) && ($settings['display_thumbnail'])) { ?>
            <?php
            $tmeposts_thumb_id = get_post_thumbnail_id();
            $tmeposts_thumb_url_array = wp_get_attachment_image_src($tmeposts_thumb_id, 'thumbnail', true);
            $tmeposts_thumb_url = $tmeposts_thumb_url_array[0];
            ?>
            <div class="tme-post-list-left">  
                <a class="tme-post-list-img elementor-animation-<?php echo esc_attr($settings['list_img_animation']); ?>" href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url($tmeposts_thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />   
                </a>    
            </div>    
            <?php } ?>
            <div class="tme-post-list-right">
                <a class="tme-post-list-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <div class="tme-post-list-date">
                    <?php if ($settings['display_author_name']) { ?>           
                        <?php if ($settings['display_author_url']) { ?>
                        <a class="tme-post-list-author-link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                            <?php if ($settings['display_author_avatar']) { echo get_avatar( get_the_author_meta( 'ID' ), $settings['avatar_size'] ); } ?><?php \Elementor\Icons_Manager::render_icon( $settings['list_author_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_author(); ?>
                        </a>
                        <?php } else { ?>
                        <span class="tme-post-list-author-link">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['list_author_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_author(); ?>
                        </span>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($settings['display_date']) { ?>
                    <a class="tme-post-list-date-link" href="<?php esc_url(the_permalink()); ?>">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['list_date_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_time(get_option('date_format')); ?>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <div class="tme-clear"></div>   
        <?php wp_reset_postdata(); ?>
	<?php } else { ?>
    <div class="tme-danger"><?php esc_html_e( 'Nothing was found!', 'theme-masters-elementor' ); ?></div>         
<?php } ?>
<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Post_List() );
?>