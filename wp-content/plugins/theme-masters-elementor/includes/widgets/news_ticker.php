<?php
namespace Elementor;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_News_Ticker extends Widget_Base {

	public function get_name() {
		return 'tme-news_ticker';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'News Ticker', 'theme-masters-elementor' );
    }
    
    public function get_categories() {
		return [ 'theme-masters-elementor' ];
    }
    
    public function get_style_depends(){
		return [ 'tme-news_ticker', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
    }
    
    public function get_script_depends() {
		return [ 'tme-news_ticker' ];
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
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
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Latest News', 'theme-masters-elementor' ),
			]
        );
        
        $this->add_control(
			'display_nav', [
				'label' => esc_html__( "Display navigation", 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
        );
        
        $this->add_control(
			'display_today', [
				'label' => esc_html__( "Display current date", 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
			'display_date', [
				'label' => esc_html__( 'Display post date', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
        );

        $this->add_control(
			'display_time', [
				'label' => esc_html__( 'Display post time', 'theme-masters-elementor' ),
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
				'label' => esc_html__( 'Display author', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'show_label' => true,
			]
        );

        $this->add_control(
			'hr_settings_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );

        $this->add_control(
			'animation_direction',
			[
				'label' => esc_html__( 'Animation Direction', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'up' => [
						'title' => esc_html__( 'Start', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'down' => [
						'title' => esc_html__( 'End', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
                'default' => 'down',
                'toggle' => false
			]
		);

        $this->add_control(
			'duration',
			[
				'label' => esc_html__( 'Autoplay Duration (ms)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 100,
				'default' => 4000
			]
        );
        
        $this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Animation Speed (ms)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 100,
				'default' => 600
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-row-left',
				'options' => [
					'tme-row-left'  => esc_html__( 'Left Aligned', 'theme-masters-elementor' ),
                    'tme-row-right'  => esc_html__( 'Right Aligned', 'theme-masters-elementor' ),
				],
			]
        );

        $this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-wrapper' => 'line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-news-ticker-wrapper .tme-news-ticker-post' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-news-ticker-wrapper .tme-newsticker li .tme-news-ticker-thumbnail' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'container_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-news-ticker-wrapper',
			]
        );

        $this->add_control(
			'hr_container_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-news-ticker-wrapper'
			]
		);
        
        $this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-news-ticker-wrapper'
			]
		);

        $this->add_control(
			'hr_container_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_today_style',
			[
				'label' => esc_html__( 'Current Date', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_today' => 'yes'],
			]
        );

        $this->add_control(
			'today_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-calendar-alt',
					'library' => 'solid',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'today_typography',
				
				'selector' => '{{WRAPPER}} .tme-news-ticker-today',
			]
        );
        
        $this->add_control(
			'today_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-today' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'today_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-today' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'hr_today_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'today_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-today' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'today_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-today i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_control(
			'title_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-news-ticker-title',
			]
        );
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-title' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-title' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-news-ticker-wrapper.tme-row-left .tme-news-ticker-title:after' => 'border-left-color: {{VALUE}};',
                    '{{WRAPPER}} .tme-news-ticker-wrapper.tme-row-right .tme-news-ticker-title:after' => 'border-right-color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'hr_title_1',
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
                    '{{WRAPPER}} .tme-news-ticker-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .tme-news-ticker-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'title_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-title i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_thumb_style',
			[
				'label' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_thumbnail' => 'yes'],
			]
        );

        $this->add_control(
			'thumb_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-thumbnail img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'thumb_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'section_author_style',
			[
				'label' => esc_html__( 'Author', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_author_name' => 'yes'],
			]
        );

        $this->add_control(
			'author_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-user-alt',
					'library' => 'solid',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				
				'selector' => '{{WRAPPER}} .tme-news-ticker-author',
			]
        );
        
        $this->add_control(
			'author_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-author' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'author_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-author' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'hr_author_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'author_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'author_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'author_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-author i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_date_style',
			[
				'label' => esc_html__( 'Post Date', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_date' => 'yes'],
			]
        );

        $this->add_control(
			'date_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-calendar-alt',
					'library' => 'solid',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				
				'selector' => '{{WRAPPER}} .tme-news-ticker-date',
			]
        );
        
        $this->add_control(
			'date_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-date' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'date_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-date' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'hr_date_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'date_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'date_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'date_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-date i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_time_style',
			[
				'label' => esc_html__( 'Time', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_time' => 'yes'],
			]
        );

        $this->add_control(
			'time_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-clock',
					'library' => 'solid',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'time_typography',
				
				'selector' => '{{WRAPPER}} .tme-news-ticker-time',
			]
        );
        
        $this->add_control(
			'time_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-time' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'time_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-time' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'hr_time_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'time_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'time_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'time_icon_padding',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-time i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_post_title_style',
			[
				'label' => esc_html__( 'Post Title', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'post_typography',
				
				'selector' => '{{WRAPPER}} .tme-news-ticker-post',
			]
        );
        
        $this->add_control(
			'post_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-post a' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'post_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-post a:hover' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'post_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-post' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'post_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-news-ticker-post'
			]
		);

        $this->add_control(
			'hr_post_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_responsive_control(
			'post_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'post_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'section_nav_style',
			[
				'label' => esc_html__( 'Navigation', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_nav' => 'yes'],
			]
        );

        $this->add_control(
			'nav_prev_icon',
			[
				'label' => esc_html__( 'Previous Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-chevron-circle-left',
					'library' => 'solid',
				],
			]
        );

        $this->add_control(
			'nav_next_icon',
			[
				'label' => esc_html__( 'Next Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-chevron-circle-right',
					'library' => 'solid',
				],
			]
        );

        $this->add_responsive_control(
			'nav_icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'theme-masters-elementor' ),
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
					'size' => 18,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-wrapper .tme-news-ticker-nav i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-nav i' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'nav_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-nav span:hover i' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'nav_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-news-ticker-nav' => 'background-color: {{VALUE}};'
				],
			]
        );

        $this->add_control(
			'hr_nav_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );

        $this->add_responsive_control(
			'nav_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'nav_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-news-ticker-nav i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'post__in' => $include,
				'post__not_in' => $exclude,
				'author__in' => $authors,
                'ignore_sticky_posts' => true,
                'tax_query' => $terms,
            )
        );
        if ($custom_query->have_posts()) {
        ?>
		<div class="tme-news-ticker-wrapper <?php echo esc_attr($settings['direction']); ?>" style="display:none;">
			<?php if ($settings['display_today']) { ?>
            <div class="tme-news-ticker-today">
            <?php \Elementor\Icons_Manager::render_icon( $settings['today_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php echo date(get_option('date_format')); ?>
			</div>
			<?php } ?>
            <?php if ($settings['title']) { ?>
            <div class="tme-news-ticker-title">
            <?php \Elementor\Icons_Manager::render_icon( $settings['title_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php echo $settings['title']; ?>
            </div>
            <?php } ?>
            <div class="tme-news-ticker-posts">
                <ul class="tme-newsticker" data-height="<?php echo esc_attr($settings['height']['size']); ?>" data-duration="<?php echo esc_attr($settings['duration']); ?>" data-speed="<?php echo esc_attr($settings['speed']); ?>" data-direction="<?php echo esc_attr($settings['animation_direction']); ?>">
                    <?php while($custom_query->have_posts()) : $custom_query->the_post(); ?>
                    <li>
                        <?php
                        if ((has_post_thumbnail()) && ($settings['display_thumbnail'])) {
                        $tmeposts_thumb_id = get_post_thumbnail_id();
                        $tmeposts_thumb_url_array = wp_get_attachment_image_src($tmeposts_thumb_id, 'thumbnail', true);
                        $tmeposts_thumb_url = $tmeposts_thumb_url_array[0];
                        ?>
                        <div class="tme-news-ticker-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url($tmeposts_thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />   
                            </a>  
                        </div>
                        <?php } ?>
                        <?php if ($settings['display_author_name']) { ?> 
                        <div class="tme-news-ticker-author">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['author_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_author(); ?>
                        </div>
                        <?php } ?>
                        <?php if ($settings['display_date']) { ?>
                        <div class="tme-news-ticker-date">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['date_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_time(get_option('date_format')); ?>
                        </div>
                        <?php } ?>
                        <?php if ($settings['display_time']) { ?>
                        <div class="tme-news-ticker-time">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['time_icon'], [ 'aria-hidden' => 'true' ] ); ?><?php the_time('G:i'); ?>
                        </div>
                        <?php } ?>
                        <div class="tme-news-ticker-post">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php if ($settings['display_nav']) { ?>
            <div class="tme-news-ticker-nav">
                <span class="tme-news-ticker-nav-prev"><?php \Elementor\Icons_Manager::render_icon( $settings['nav_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                <span class="tme-news-ticker-nav-next"><?php \Elementor\Icons_Manager::render_icon( $settings['nav_next_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
            </div>
            <?php } ?>
        </div> 
        <?php wp_reset_postdata(); ?>
	<?php } else { ?>
    <div class="tme-danger"><?php esc_html_e( 'Nothing was found!', 'theme-masters-elementor' ); ?></div>         
<?php } ?>
<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_News_Ticker() );
?>