<?php
namespace Elementor;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Post_Timeline extends Widget_Base {

	public function get_name() {
		return 'tme-post_timeline';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Post Timeline', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-post_timeline', 'elementor-icons-fa-regular', 'tme-button' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-post_timeline' ];
	}
    
    public function get_icon() {
		return 'eicon-time-line';
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
				'description' => esc_html__( 'Load more button loads this number of posts each time.', 'theme-masters-elementor' ),
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
			'display_btn', [
				'label' => esc_html__( 'Display Read More Button', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
				'separator' => 'before'
			]
        );
        
        $this->add_control(
			'button_text', [
				'label' => esc_html__( 'Button Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'theme-masters-elementor' ),
                'label_block' => true,
                'condition' => ['display_btn' => 'yes']
			]
		);

		$this->add_control(
			'load_more', [
				'label' => esc_html__( 'Load More', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
				'separator' => 'before'
			]
		);
		
		$this->add_control(
			'load_more_text', [
				'label' => esc_html__( 'Button Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'LOAD MORE', 'theme-masters-elementor' ),
                'label_block' => true,
                'condition' => ['load_more' => 'yes']
			]
		);

		$this->add_control(
			'loading_text', [
				'label' => esc_html__( 'Disabled Button Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'LOADING...', 'theme-masters-elementor' ),
                'label_block' => true,
                'condition' => ['load_more' => 'yes']
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_timeline_style',
			[
				'label' => esc_html__( 'Timeline', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-post-timeline-2-col',
				'options' => [
					'tme-post-timeline-2-col'  => esc_html__( 'Two Column', 'theme-masters-elementor' ),
					'tme-post-timeline-1-col' => esc_html__( 'One Column', 'theme-masters-elementor' )
				],
			]
        );

        $this->add_responsive_control(
			'bar_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->add_control(
			'timeline_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

        $this->add_control(
			'bar_thickness',
			[
				'label' => esc_html__( 'Bar Thickness', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 4,
                'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__container:before' => 'width: {{VALUE}}px;'
				],
			]
        );
        
        $this->add_control(
			'bar_color',
			[
				'label' => esc_html__( 'Bar Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__container:before' => 'background-color: {{VALUE}};'
				],
			]
        );

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_card_img',
			[
				'label' => esc_html__( 'Post Image', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_thumbnail' => 'yes']
			]
		);
		
		$this->add_control(
			'img_size',
			[
				'label' => esc_html__( 'Thumbnail Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'large',
				'options' => TMEA_get_image_sizes()
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
					'{{WRAPPER}} .tme-post-timeline-img img' => 'opacity: {{VALUE}};'
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-img img'
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
					'{{WRAPPER}} .tme-post-timeline-img:hover img' => 'opacity: {{VALUE}};'
				],
			]
        );

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_css_filter_hover',
				'label' => esc_html__( 'CSS Filters', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-img:hover img'
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
				'selector' => '{{WRAPPER}} .tme-post-timeline-img img',
			]
		);
        
        $this->add_responsive_control(
			'card_img_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-img img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_img_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-img img',
			]
        );
        
        $this->add_control(
			'card_thumbnail_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'card_img_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_responsive_control(
			'content_text_align',
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
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__content' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'display_arrow', [
				'label' => esc_html__( 'Display arrow', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'show-arrow',
				'default' => 'show-arrow',
				'show_label' => true,
			]
		);

        $this->add_control(
			'content_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#eeeeee',
				'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline__content' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-post-timeline__content:before' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-post-timeline.tme-post-timeline-2-col .tme-post-timeline__block:nth-child(odd) .tme-post-timeline__content:before' => 'border-left-color: {{VALUE}};'
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline__content'
			]
		);

        $this->add_control(
			'content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__content' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline__content'
			]
		);
		
		$this->add_control(
			'content_hr_1',
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
                    '{{WRAPPER}} .tme-post-timeline__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    '{{WRAPPER}} .tme-post-timeline__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'content_heading_2',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'title_html_tag',
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
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-post-timeline-title a' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline-title a:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-post-timeline-title'
			]
        );
        
        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'content_heading_3',
			[
				'label' => esc_html__( 'Paragraph', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );
        
        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__content p' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				
				'selector' => '{{WRAPPER}} .tme-post-timeline__content p'
			]
        );
        
        $this->add_responsive_control(
			'text_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline__content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
		
		$this->end_controls_section();

         // section start
		$this->start_controls_section(
			'date_style_section',
			[
				'label' => esc_html__( 'Date', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'date_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__date' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				
				'selector' => '{{WRAPPER}} .tme-post-timeline__date'
			]
		);

		$this->add_control(
			'date_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  
		
		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Date Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'far fa-calendar-alt',
					'library' => 'regular',
				],
			]
        );

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'default' => 22,
                'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline__img i' => 'font-size: {{VALUE}}px;line-height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-post-timeline__img svg' => 'width: {{VALUE}}px;'
				],
			]
		);
		
		$this->add_responsive_control(
			'icon_container_size',
			[
				'label' => esc_html__( 'Icon Container Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'default' => 60,
                'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline__img' => 'width: {{VALUE}}px;height: {{VALUE}}px;',
                    '{{WRAPPER}} .tme-post-timeline.tme-post-timeline-2-col .tme-post-timeline__block .tme-post-timeline__img' => 'margin-left: calc(5% - ({{VALUE}}px / 2));',
                    '{{WRAPPER}} .tme-post-timeline.tme-post-timeline-2-col .tme-post-timeline__block:nth-child(even) .tme-post-timeline__img' => 'margin-right: calc(5% - ({{VALUE}}px / 2));',
                    '{{WRAPPER}} .tme-post-timeline__container:before' => 'left: calc(({{VALUE}}px - {{bar_thickness.VALUE}}px) / 2);',
                    '{{WRAPPER}} .tme-post-timeline__content:before' => 'top: calc(({{VALUE}}px / 2) - 8px);'
				],
			]
        );

        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline__img i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-post-timeline__img svg' => 'fill: {{VALUE}};'
				],
			]
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_container_bg',
				'label' => esc_html__( 'Icon Container Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-post-timeline__img',
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_container_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline__img'
			]
		);
        
        $this->add_control(
			'icon_container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline__img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_container_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline__img'
			]
		);
		
		$this->add_control(
			'date_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  

        $this->add_responsive_control(
			'date_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-post-timeline-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();

         // section start
		$this->start_controls_section(
			'btn_style_section',
			[
				'label' => esc_html__( 'Read More Button', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['display_btn' => 'yes']
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'btn_text_shadow',
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a',
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
					'{{WRAPPER}} .tme-post-timeline-read-more a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .tme-post-timeline-read-more a' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_bg_color_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-read-more a,{{WRAPPER}} .tme-post-timeline-read-more a:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a'
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
					'{{WRAPPER}} .tme-post-timeline-read-more a:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-read-more a:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_bg_color_hover_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a:hover',
			]
		);
        
        $this->add_control(
			'btn_animation_color',
			[
				'label' => esc_html__( 'Animation Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-read-more a:before' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a:hover'
			]
		);
        
        $this->add_responsive_control(
			'btn_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-read-more a:hover,{{WRAPPER}} .tme-post-timeline-read-more a:hover:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-read-more a:hover'
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
                    '{{WRAPPER}} .tme-post-timeline-read-more a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'{{WRAPPER}} .tme-post-timeline-read-more a' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_control(
			'btn_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
					'{{WRAPPER}} .tme-post-timeline-read-more' => 'text-align: {{VALUE}};'
				],
				'toggle' => true,
			]
        );
        
        $this->add_control(
			'btn_heading_1',
			[
				'label' => esc_html__( 'Button Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
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
                    '{{WRAPPER}} .tme-post-timeline-read-more a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
		$this->end_controls_section();
		
		// section start
		$this->start_controls_section(
			'btn_ajax_style_section',
			[
				'label' => esc_html__( 'Load More Button', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['load_more' => 'yes']
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_ajax_typography',
				
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'btn_ajax_text_shadow',
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button',
			]
		);

		$this->add_control(
			'btn_ajax_skin',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_btn_skins(),
			]
		);

		$this->add_control(
			'btn_ajax_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  

		$this->start_controls_tabs( 'tabs_load_more_style' );

		$this->start_controls_tab(
			'tab_load_more_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);

		$this->add_control(
			'btn_ajax_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'btn_ajax_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_ajax_bg_color_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_ajax_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button'
			]
		);

		$this->add_responsive_control(
			'btn_ajax_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button,{{WRAPPER}} .tme-post-timeline-ajax button:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_ajax_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_load_more_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);

		$this->add_control(
			'btn_ajax_text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'btn_ajax_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_ajax_bg_color_hover_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button:hover',
			]
		);

		$this->add_control(
			'btn_ajax_animation_color',
			[
				'label' => esc_html__( 'Animation Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button:before' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_ajax_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button:hover'
			]
		);

		$this->add_responsive_control(
			'btn_ajax_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button:hover,{{WRAPPER}} .tme-post-timeline-ajax button:hover:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_ajax_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-post-timeline-ajax button:hover'
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'btn_ajax_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_responsive_control(
			'btn_ajax_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-post-timeline-ajax button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'btn_ajax_width',
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
					'{{WRAPPER}} .tme-post-timeline-ajax button' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'btn_ajax_hr_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_control(
			'btn_ajax_size',
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
			'btn_ajax_text_align',
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
					'{{WRAPPER}} .tme-post-timeline-ajax' => 'text-align: {{VALUE}};'
				],
				'toggle' => true,
			]
		);

		$this->end_controls_section();
     
	}
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $obj_id = get_queried_object_id();
        $current_url = get_permalink( $obj_id );
        $icon_position = $settings['btn_icon_position'];
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
                'paged' => $paged
            )
        );
        if ($custom_query->have_posts()) { ?>
        <div class="tme-post-timeline <?php echo $settings['layout']; ?>">
            <div class="tme-post-timeline__container tme-post-ajax-id-<?php echo esc_attr($this->get_id()); ?>" data-ajaxid="<?php echo esc_attr($this->get_id()); ?>" data-pageid="<?php echo esc_attr($paged); ?>" data-maxpage="<?php echo esc_attr($custom_query->max_num_pages); ?>">
            <?php while($custom_query->have_posts()) : $custom_query->the_post(); ?>
            <div class="tme-post-timeline__block">
                    <div class="tme-post-timeline__img">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                    <div class="tme-post-timeline__content <?php echo $settings['display_arrow']; ?>">
                    <?php if ((has_post_thumbnail()) && ($settings['display_thumbnail'])) { ?>
                    <?php
                    $tmeposts_thumb_id = get_post_thumbnail_id();
                    $tmeposts_thumb_url_array = wp_get_attachment_image_src($tmeposts_thumb_id, $settings['img_size'], true);
                    $tmeposts_thumb_url = $tmeposts_thumb_url_array[0];
                    ?>
                    <a class="tme-post-timeline-img" href="<?php the_permalink(); ?>">
                        <img src="<?php echo esc_url($tmeposts_thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />  
                    </a>
                    <?php } ?>
                    <div class="tme-post-timeline-date">
                        <span class="tme-post-timeline__date"><?php the_time(get_option('date_format')); ?></span>
                    </div>
                    <<?php echo esc_attr($settings['title_html_tag']); ?> class="tme-post-timeline-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_attr($settings['title_html_tag']); ?>>
                    <?php 
                    if ((get_the_excerpt()) && (!empty($settings['excerpt_length'])) && ($settings['excerpt_length'] != 0)) {
                        echo wpautop(TMEA_excerpt($settings['excerpt_length']));
                    }
                    ?>
                    <?php if ($settings['display_btn']) { ?>
                    <div class="tme-btn-wrapper tme-post-timeline-read-more">
                        <a class="<?php echo esc_attr($settings['btn_size']); ?> <?php echo esc_attr($settings['btn_skin']); ?>" href="<?php the_permalink(); ?>">
                            <?php 
                            if ($icon_position == 'before') {
                                \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); 
                                echo esc_html($settings['button_text']);
                            } else {
                                echo esc_html($settings['button_text']); 
                                \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] );
                                } 
                            ?>
                        </a>
                    </div>
                    <?php } ?>
                    </div>
                </div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
			<?php if (($settings['load_more']) && (!get_query_var( 'paged' ))) { ?>
			<div class="tme-post-timeline-ajax-content"></div>
			<?php } ?>
            </div>
		</div>
		<?php if ($settings['load_more']) { ?>
		<div class="tme-btn-wrapper tme-post-timeline-ajax">
			<button class="tme-post-timeline-ajax-btn <?php echo esc_attr($settings['btn_ajax_size']); ?> <?php echo esc_attr($settings['btn_ajax_skin']); ?>" type="button" data-loading="<?php echo esc_attr($settings['loading_text']); ?>" data-loaded="<?php echo esc_attr($settings['load_more_text']); ?>"><?php echo esc_html($settings['load_more_text']); ?></button>
		</div>
		<?php } ?>
        <?php
		} else { ?>
            <div class="tme-danger"><?php esc_html_e( 'Nothing was found!', 'theme-masters-elementor' ); ?></div>    
        <?php }
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Post_Timeline() );