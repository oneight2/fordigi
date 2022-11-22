<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Progress_Bar extends Widget_Base {

	public function get_name() {
		return 'tme-progress_bar';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Progress Bar', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-progress_bar' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-progress_bar' ];
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'progress_bar_content',
  			[
  				'label' => esc_html__( 'Progress Bar', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		);
        
        $this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'WordPress', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'percent',
			[
				'label' => esc_html__( 'Percent', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%'],
                'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => '%',
					'size' => 60,
				],
                'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'percent_select',
			[
				'label' => esc_html__( 'Display Percent', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'in',
				'options' => [
					''  => esc_html__( 'No', 'theme-masters-elementor' ),
					'in'  => esc_html__( 'Display in the bar', 'theme-masters-elementor' ),
                    'out'  => esc_html__( 'Display out of the bar', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_control(
			'stripes',
			[
				'label' => esc_html__( 'Animated Stripes', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'progress_bar_content_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'anim_duration',
			[
				'label' => esc_html__( 'Animation Duration (ms)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 100,
				'default' => 1000
			]
		);
        
        $this->add_control(
			'scroll_anim_switcher',
			[
				'label' => esc_html__( 'Scroll Based Animation', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Activate animation when the pie chart scrolls into view.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_progress_bar_style',
			[
				'label' => esc_html__( 'Progress Bar', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'progress_bar_overflow',
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
			'progress_bar_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.1)',
                'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-wrapper' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'progress_bar_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'progress_bar_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-progress-bar-wrapper'
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'progress_bar_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-progress-bar-wrapper'
			]
		);
        
        $this->add_control(
			'progress_bar_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'progress_bar_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'progress_bar_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-progress-bar-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
    
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_bar_style',
			[
				'label' => esc_html__( 'Bar', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'bar_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#3498db',
                'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-overlay' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'bar_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'selectors' => [
					'{{WRAPPER}} .tme-progress-bar' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'bar_valign',
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
					'{{WRAPPER}} .tme-progress-bar' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'bar_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bar_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-progress-bar-overlay'
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'bar_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-progress-bar-overlay'
			]
		);
        
         $this->add_control(
			'bar_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-overlay' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_control(
			'bar_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'bar_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-progress-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'text_heading_3',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-progress-bar-title'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-progress-bar-title',
			]
		);
        
        $this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Percent', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'percent_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-percent' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tme-progress-bar-percent-out' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'percent_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-percent' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tme-progress-bar-percent:after' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .tme-progress-bar-percent-out' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tme-progress-bar-percent-out:after' => 'border-top-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'percent_typography',
				
				'selector' => '{{WRAPPER}} .tme-progress-bar-percent,{{WRAPPER}} .tme-progress-bar-percent-out'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'percent_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-progress-bar-percent,{{WRAPPER}} .tme-progress-bar-percent-out',
			]
		);

		$this->add_responsive_control(
			'percent_horizontal_align',
			[
				'label' => esc_html__( 'Horizontal Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-percent' => ' transform:translateX({{SIZE}}%);',
					'{{WRAPPER}} .tme-progress-bar-percent-out' => ' transform:translateX({{SIZE}}%);'
				],
			]
		);

		$this->add_control(
			'percent_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-percent' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-progress-bar-percent-out' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_responsive_control(
			'percent_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-percent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-progress-bar-percent-out' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'percent_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-progress-bar-percent' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-progress-bar-percent-out' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        ?>
		<div id="tme-progress-bar-<?php echo esc_attr($this->get_id()); ?>" class="tme-progress-bar-wrapper" <?php if ($settings['progress_bar_overflow']) { ?>style="overflow:hidden;"<?php } ?>>
			<div class="tme-progress-bar-overlay"></div>
            <div class="tme-progress-bar <?php if ($settings['stripes']) { echo 'stripes'; } ?>" style="width:<?php echo esc_attr($settings['percent']['size']); ?>%;" data-prct="<?php echo esc_attr($settings['percent']['size']); ?>%" data-animduration="<?php echo $settings['anim_duration']; ?>" <?php if ($settings['scroll_anim_switcher']) { ?>data-scrollanim<?php } ?>>
                <div class="tme-progress-bar-title"><?php echo esc_html($settings['title']); ?></div>
                <?php if ($settings['percent_select'] == 'in') { ?>
                <div class="tme-progress-bar-percent"><?php echo esc_html($settings['percent']['size']); ?>%</div>
                <?php } ?>
			</div>
			<?php if ($settings['percent_select'] == 'out') { ?>
                <div class="tme-progress-bar-percent-out"><?php echo esc_html($settings['percent']['size']); ?>%</div>
            <?php } ?>
        </div>
	<?php
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Progress_Bar() );