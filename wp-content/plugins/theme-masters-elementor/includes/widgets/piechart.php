<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Piechart extends Widget_Base {

	public function get_name() {
		return 'tme-piechart';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Pie Chart', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-piechart' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-piechart' ];
	}

	public function get_icon() {
		return 'eicon-counter-circle';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'piechart_content',
  			[
  				'label' => esc_html__( 'Pie Chart', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		);
        
        $this->add_control(
			'percent',
			[
				'label' => esc_html__( 'Percent', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1,
				'step' => 0.01,
				'default' => 0.6,
			]
		);
        
        $this->add_control(
			'percent_switcher',
			[
				'label' => esc_html__( 'Display Percent Sign', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        
        $this->add_control(
			'piechart_content_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'title_v_align',
			[
				'label' => esc_html__( 'Title Position', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'column-reverse' => [
						'title' => esc_html__( 'Top', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'column' => [
						'title' => esc_html__( 'Bottom', 'theme-masters-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'column',
				'selectors' => [
					'{{WRAPPER}} .tme-piechart-text' => 'flex-direction: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_control(
			'piechart_content_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'piechart_width',
			[
				'label' => esc_html__( 'Chart Size (px)', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-piechart' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-piechart canvas' => 'max-height: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};'
				],
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
			'section_piechart_style',
			[
				'label' => esc_html__( 'Pie Chart', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'piechart_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-piechart' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'piechart_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'piechart_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-piechart'
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'piechart_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-piechart'
			]
		);
        
        $this->add_control(
			'piechart_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_responsive_control(
			'piechart_h_align',
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
					'{{WRAPPER}} .tme-piechart-wrapper' => 'justify-content: {{VALUE}};',
				],
                'toggle' => false
			]
		);
        
        $this->add_responsive_control(
			'piechart_pad',
			[
				'label' => esc_html__( 'Padding (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 500,
				'step' => 1,
                'default' => 0,
                'selectors' => [
					'{{WRAPPER}} .tme-piechart' => 'padding: {{VALUE}}px;',
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
			'thickness',
			[
				'label' => esc_html__( 'Thickness Ratio', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%'],
                'range' => [
					'%' => [
						'min' => 2,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => '%',
					'size' => 15,
				]
			]
		);
        
        $this->add_control(
			'bar_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#2ecc71'
			]
		);
        
        $this->add_control(
			'empty_bar_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.1)'
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
			'text_heading',
			[
				'label' => esc_html__( 'Percent', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);
        
        $this->add_control(
			'percent_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-piechart-percent' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'percent_typography',
				
				'selector' => '{{WRAPPER}} .tme-piechart-percent'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'percent_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-piechart-percent',
			]
		);
        
        $this->add_control(
			'text_heading_2',
			[
				'label' => esc_html__( 'Percent Sign', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'percent_sign_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-piechart-percent span' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'percent_sign_typography',
				
				'selector' => '{{WRAPPER}} .tme-piechart-percent span'
			]
		);
        
        $this->add_control(
			'percent_sign_valign',
			[
				'label' => esc_html__( 'Vertical Align', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'super',
				'options' => [
					'top' => esc_html__( 'Top', 'theme-masters-elementor' ),
                    'text-top' => esc_html__( 'Text Top', 'theme-masters-elementor' ),
                    'middle'  => esc_html__( 'Middle', 'theme-masters-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'theme-masters-elementor' ),
                    'text-bottom' => esc_html__( 'Text Bottom', 'theme-masters-elementor' ),
                    'super'  => esc_html__( 'Super', 'theme-masters-elementor' ),
                    'sub'  => esc_html__( 'Sub', 'theme-masters-elementor' ),
                    'baseline'  => esc_html__( 'Baseline', 'theme-masters-elementor' ),
				],
                'selectors' => [
					'{{WRAPPER}} .tme-piechart-percent span' => 'vertical-align: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'text_heading_3',
			[
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .tme-piechart-title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-piechart-title'
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-piechart-title',
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
        <div id="tme-piechart-<?php echo esc_attr($this->get_id()); ?>" class="tme-piechart-wrapper">
            <div class="tme-piechart" data-value="<?php echo esc_attr($settings['percent']); ?>" data-size="<?php echo esc_attr($settings['piechart_width']['size']); ?>" data-pad="<?php echo esc_attr($settings['piechart_pad']); ?>" data-thickness="<?php echo esc_attr($settings['thickness']['size']); ?>" data-fillcolor="<?php echo esc_attr($settings['bar_color']); ?>" data-emptyfill="<?php echo esc_attr($settings['empty_bar_color']); ?>" data-animduration="<?php echo $settings['anim_duration']; ?>" <?php if ($settings['percent_switcher']) { ?>data-dpercent<?php } ?> <?php if ($settings['scroll_anim_switcher']) { ?>data-scrollanim<?php } ?>>
                <div class="tme-piechart-text">
                    <div class="tme-piechart-percent">0<span>%</span></div>
                    <div class="tme-piechart-title"><?php echo esc_html($settings['title']); ?></div>
                </div>
				<canvas class="tme-placeholder-piechart" width="<?php echo esc_attr($settings['piechart_width']['size']) * 2; ?>" height="<?php echo esc_attr($settings['piechart_width']['size']) * 2; ?>" style="height:<?php echo esc_attr($settings['piechart_width']['size']); ?>px;width:<?php echo esc_attr($settings['piechart_width']['size']); ?>px;"></canvas>
            </div>
		</div>
	<?php
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Piechart() );