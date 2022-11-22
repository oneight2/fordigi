<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Statistics extends Widget_Base {

	public function get_name() {
		return 'tme-statistics';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Statistics', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-statistics','elementor-icons-fa-solid' ];
	}

	public function get_icon() {
		return 'eicon-number-field';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'statistics_content',
  			[
  				'label' => esc_html__( 'Statistics', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
        ); 

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

        $repeater->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true
			]
		);

		$repeater->add_control(
			'selected_value',
			[
				'label' => esc_html__( 'Statistic', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'posts',
				'options' => [
                    'posts' => esc_html__( 'Posts', 'theme-masters-elementor' ),
                    'comments' => esc_html__( 'Comments', 'theme-masters-elementor' ),
                    'users' => esc_html__( 'Registered Users (BbPress)', 'theme-masters-elementor' ),
                    'forums' => esc_html__( 'Forums (BbPress)', 'theme-masters-elementor' ),
                    'topics' => esc_html__( 'Topics (BbPress)', 'theme-masters-elementor' ),
                    'replies' => esc_html__( 'Replies (BbPress)', 'theme-masters-elementor' ),
					'topic_tags' => esc_html__( 'Topic Tags (BbPress)', 'theme-masters-elementor' ),
					'members' => esc_html__( 'Members (BuddyPress)', 'theme-masters-elementor' ),
					'groups' => esc_html__( 'Groups (BuddyPress)', 'theme-masters-elementor' ),
					'activity' => esc_html__( 'Activity (BuddyPress)', 'theme-masters-elementor' ),
                ],
                'label_block' => true
			]
        );
        
        $repeater->add_control(
			'external_link',
			[
				'label' => esc_html__( 'Destination Url (Optional)', 'theme-masters-elementor' ),
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
			]
		);
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Items', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
						'title' => esc_html__( 'Title #1', 'theme-masters-elementor' ),
                        'selected_value' => 'posts'
					],
					[
						'title' => esc_html__( 'Title #2', 'theme-masters-elementor' ),
						'selected_value' => 'posts'
					],
				],
				'title_field' => '{{{ title }}}',
			]
        );
        
        $this->end_controls_section();
     
        // section start
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'List Item', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'content_layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-statistics-layout-1',
				'options' => [
					'tme-statistics-layout-1'  => esc_html__( 'Layout 1', 'theme-masters-elementor' ),
                    'tme-statistics-layout-2'  => esc_html__( 'Layout 2', 'theme-masters-elementor' ),
                    'tme-statistics-layout-3'  => esc_html__( 'Layout 3', 'theme-masters-elementor' ),
				],
			]
        );
        
        $this->add_control(
			'item_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list' => 'background-color: {{VALUE}}'
				],
			]
        );
        
        $this->add_control(
			'item_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-statistics-list'
			]
		);
        
        $this->add_responsive_control(
			'item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-statistics-list'
			]
		);
        
        $this->add_control(
			'item_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        ); 
        
        $this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-statistics-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'item_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-statistics-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
     
        // section start
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon' => 'width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'icon_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
                    '{{WRAPPER}} .tme-statistics-list-icon' => 'height: {{VALUE}}px;',
				],
			]
        );

        $this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon' => 'background-color: {{VALUE}};'
				]
			]
        );
        
        $this->add_control(
			'icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-statistics-list-icon'
			]
		);
        
        $this->add_control(
			'hr_icon_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tme-statistics-list-icon svg' => 'fill: {{VALUE}};',
				]
			]
		);
        
        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'rem' => [
						'min' => 0,
						'max' => 50,
					],
                    'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'icon_svg_width',
			[
				'label' => esc_html__( 'SVG Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon svg' => 'width: {{VALUE}}px;'
				],
			]
		);
        
        $this->add_responsive_control(
			'icon_svg_height',
			[
				'label' => esc_html__( 'SVG Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 5,
                'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-icon svg' => 'height: {{VALUE}}px;'
				],
			]
        );
        
        $this->end_controls_section();
     
        // section start
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-statistics-list-title'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-statistics-list-title',
			]
        );
        
        $this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-statistics-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();

        // section start
		$this->start_controls_section(
			'section_number_style',
			[
				'label' => esc_html__( 'Number', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-statistics-list-value' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				
				'selector' => '{{WRAPPER}} .tme-statistics-list-value'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'number_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-statistics-list-value',
			]
        );
        
        $this->add_responsive_control(
			'number_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-statistics-list-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        if ( $settings['list'] ) {
            foreach ( $settings['list'] as $item ) {
            $target = $item['external_link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item['external_link']['nofollow'] ? ' rel="nofollow"' : '';
            $statistic = 0;
            if ($item['selected_value'] == 'posts') {
                $statistic = TMEA_post_count();
            } elseif ($item['selected_value'] == 'comments') {
                $statistic = TMEA_comment_count();
            } elseif ($item['selected_value'] == 'users') {
                $statistic = TMEA_bbpress_user_count();
            } elseif ($item['selected_value'] == 'forums') {
                $statistic = TMEA_bbpress_forum_count();
            } elseif ($item['selected_value'] == 'topics') {
                $statistic = TMEA_bbpress_topic_count();
            } elseif ($item['selected_value'] == 'replies') {
                $statistic = TMEA_bbpress_reply_count();
            } elseif ($item['selected_value'] == 'topic_tags') {
                $statistic = TMEA_bbpress_topic_tag_count();
            } elseif ($item['selected_value'] == 'members') {
                $statistic = TMEA_bp_member_count();
            } elseif ($item['selected_value'] == 'groups') {
                $statistic = TMEA_bp_group_count();
            } elseif ($item['selected_value'] == 'activity') {
                $statistic = TMEA_bp_activity_count();
            }
        ?>
        <div class="tme-statistics-list <?php echo esc_attr($settings['content_layout']); ?>">
            <?php if ($item['external_link']['url']) { ?>
            <a class="tme-statistics-list-url" href="<?php echo esc_url($item['external_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>></a>
            <?php } ?>
            <div class="tme-statistics-list-left">
                <div class="tme-statistics-list-icon">
                <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            </div>
            <div class="tme-statistics-list-right">
                <div class="tme-statistics-list-title">
                    <?php echo $item['title']; ?>
                </div>
                <div class="tme-statistics-list-value">
                    <?php echo $statistic; ?>
                </div>
            </div>
        </div>
    <?php
        }
    } 
}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Statistics() );