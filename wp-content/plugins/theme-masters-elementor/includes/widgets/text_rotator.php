<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Text_rotator extends Widget_Base {

	public function get_name() {
		return 'tme-text_rotator';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Text Rotator', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}

	public function get_style_depends(){
		return [ 'tme-text_rotator' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-text_rotator' ];
	}

	public function get_icon() {
		return 'eicon-animation-text';
	}
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'anim_text_content',
  			[
  				'label' => esc_html__( 'Text Rotator', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		); 

		$this->add_control(
			'prefix_text',
			[
				'label' => esc_html__('Prefix Text', 'theme-masters-elementor'),
				'type' => Controls_Manager::TEXTAREA
			]
		); 
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'title', [
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Animated Text', 'theme-masters-elementor' ),
				'label_block' => true,
			]
		);
        
        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Animated Texts', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
						'title' => esc_html__( 'Animated Text #1', 'theme-masters-elementor' ),
					],
					[
                        'title' => esc_html__( 'Animated Text #2', 'theme-masters-elementor' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);
        
        $this->add_control(
			'suffix_text',
			[
				'label' => esc_html__('Suffix Text', 'theme-masters-elementor'),
				'type' => Controls_Manager::TEXTAREA
			]
		); 
        
        $this->end_controls_section();
        
        // section start
  		$this->start_controls_section(
  			'anim_text_settings',
  			[
  				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
  		); 
 
		$this->add_control(
			'html_tag',
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
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);
        
        $this->add_responsive_control(
			'text_align',
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
					'{{WRAPPER}} .tme-anim-text-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'anim',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
                'label_block' => true
			]
		);
        
        $this->add_control(
			'anim_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 10000,
				'step' => 500,
				'default' => 3000
			]
		);

		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'anim_text_general_styles',
			[
				'label' => esc_html__( 'General', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				
				'selector' => '{{WRAPPER}} .tme-anim-text-wrapper',
			]
		);
        
        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-anim-text-wrapper' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
			'text_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-anim-text-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .tme-anim-text-wrapper',
			]
		);

		$this->add_control(
			'text_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'text_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-anim-text-wrapper',
			]
		);

		$this->add_control(
			'text_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'text_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-anim-text-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-anim-text-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'anim_text_styles',
			[
				'label' => esc_html__( 'Animated Text', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'anim_text_typography',
				
				'selector' => '{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span',
			]
		);
        
        $this->add_control(
			'anim_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
			'anim_text_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span' => 'background-color: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'anim_text_shadow',
				'selector' => '{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span',
			]
		);

		$this->add_control(
			'anim_text_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'anim_text_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span',
			]
		);

		$this->add_control(
			'anim_text_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'anim_text_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'anim_text_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-anim-text-wrapper .tme-anim-text span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        ?>
        <?php echo '<' . $settings['html_tag'] . ' class="tme-anim-text-wrapper">'; ?>
        <span class="tme-anim-text-prefix"><?php echo $settings['prefix_text']; ?></span>
        <span class="tme-anim-text" style="display:none;" data-txtanim="<?php echo $settings['anim']; ?>" data-animduration="<?php echo $settings['anim_duration']; ?>">
        <?php $last_key = end($settings['list']); ?>    
        <?php foreach ( $settings['list'] as $item ) { ?> 
        <?php echo $item['title']; ?><?php if ($item != $last_key) { ?> | <?php } ?>
        <?php } ?>
        </span>    
        <span class="tme-anim-text-suffix"><?php echo $settings['suffix_text']; ?></span>
        <?php echo '</' . $settings['html_tag'] . '>'; ?>
	<?php }
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Text_rotator() );