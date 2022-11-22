<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Scroll_Nav extends Widget_Base {

	public function get_name() {
		return 'tme-scroll_nav';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Scroll Navigation', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-scroll_nav', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-scroll_nav' ];
	}

	public function get_icon() {
		return ' eicon-navigation-vertical';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'scroll_nav_content',
  			[
  				'label' => esc_html__( 'Scroll Navigation', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
        );
        
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'section_id',
			[
                'label' => esc_html__( 'ID', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Use only use latin characters and dashes. You must enter the same ID to the destination section.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

        $repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'section-id-1',
                'label_block' => true
			]
        );
        
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
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Menu Items', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
						'title' => esc_html__( 'Title #1', 'theme-masters-elementor' ),
						'section_id' => esc_html__( 'section-id-1', 'theme-masters-elementor' )
					],
					[
                        'title' => esc_html__( 'Title #2', 'theme-masters-elementor' ),
						'section_id' => esc_html__( 'section-id-2', 'theme-masters-elementor' )
					],
				],
				'title_field' => '{{{ title }}}',
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
			'position',
			[
				'label' => esc_html__( 'Position', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tm-scroll-nav-right',
				'options' => [
					'tm-scroll-nav-right'  => esc_html__( 'Center Right', 'theme-masters-elementor' ),
                    'tm-scroll-nav-left'  => esc_html__( 'Center Left', 'theme-masters-elementor' ),
                    'tm-scroll-nav-right-top'  => esc_html__( 'Top Right', 'theme-masters-elementor' ),
                    'tm-scroll-nav-left-top'  => esc_html__( 'Top Left', 'theme-masters-elementor' ),
                    'tm-scroll-nav-right-bottom'  => esc_html__( 'Bottom Right', 'theme-masters-elementor' ),
					'tm-scroll-nav-left-bottom'  => esc_html__( 'Bottom Left', 'theme-masters-elementor' ),
				],
			]
        );
        
        $this->add_responsive_control(
			'container_margin',
			[
				'label' => esc_html__( 'Container Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->add_responsive_control(
			'label_spacing',
			[
				'label' => esc_html__( 'Item Spacing (px)', 'theme-masters-elementor' ),
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
					'size' => 5,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav li' => 'margin: {{SIZE}}{{UNIT}} 0;'
				],
			]
        );

        $this->add_control(
			'display_text', [
				'label' => esc_html__( 'Display Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_text' => 'yes'],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-scroll-nav-item-text',
			]
        );
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-scroll-nav-item-text' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-scroll-nav-item-text',
			]
        );
        
        $this->add_control(
			'hr_title_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-scroll-nav-item-text'
			]
		);
        
        $this->add_responsive_control(
			'title_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-scroll-nav-item-text' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-scroll-nav-item-text'
			]
		);

        $this->add_control(
			'hr_title_2',
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
                    '{{WRAPPER}} .tme-scroll-nav-item-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .tme-scroll-nav-item-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        
        $this->add_control(
			'hr_title_3',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'title_icon_size',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav-item-text i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_control(
			'title_icon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-scroll-nav-item-text i' => 'color: {{VALUE}};'
				],
			]
        );

        $this->add_responsive_control(
			'title_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav-item-text i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
    
        $this->end_controls_section();

        $this->start_controls_section(
			'section_dots_style',
			[
				'label' => esc_html__( 'Navigation Dots', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->start_controls_tabs( 'tabs_dots_style' );
        
        $this->start_controls_tab(
			'tab_dots_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor'),
			]
        );
        
        $this->add_responsive_control(
			'dots_size',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
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
					'size' => 14,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav-item-icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'dots_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'selectors' => [
					'{{WRAPPER}} .tme-scroll-nav-item-icon' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor'),
			]
        );
        
        $this->add_responsive_control(
			'dots_hover_size',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
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
					'size' => 14,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav-item-icon' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-scroll-nav-item-icon:hover' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-scroll-nav-item-active .tme-scroll-nav-item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tme-scroll-nav-item-hover .tme-scroll-nav-item-icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_control(
			'dots_hover_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
                    '{{WRAPPER}} .tme-scroll-nav-item-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-scroll-nav-item-active .tme-scroll-nav-item-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-scroll-nav-item-hover .tme-scroll-nav-item-icon' => 'color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();  
  
	}

	/**
	 * Render 
	 */
	protected function render( ) {
        $settings = $this->get_settings_for_display();
        if ( $settings['list'] ) {
        ?>
        <div id="tme-scroll-nav-<?php echo esc_attr($this->get_id()); ?>" class="tme-scroll-nav-wrapper <?php echo $settings['position']; ?>">
           <ul class="tme-scroll-nav">
           <?php $i = 0; ?>
           <?php foreach ( $settings['list'] as $item ) { ?>
                <li id="tme-scroll-nav-item-<?php echo $item['_id']; ?>" class="<?php if ($i == 0) { echo 'tme-scroll-nav-item-active'; } ?>">
                    <a href="#<?php echo $item['section_id']; ?>">
                    <?php if ( $settings['display_text'] ) { ?><span class="tme-scroll-nav-item-text"><?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?><?php echo $item['title']; ?></span><?php } ?><span class="tme-scroll-nav-item-icon"><i class="fas fa-circle"></i></span>
                    </a>
                </li>
            <?php $i ++; ?>     
            <?php } ?>
           </ul> 
		</div>
	    <?php
        }
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Scroll_Nav() );