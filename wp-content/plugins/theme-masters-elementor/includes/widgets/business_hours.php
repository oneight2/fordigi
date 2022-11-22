<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Business_Hours extends Widget_Base {

	public function get_name() {
		return 'tme-business_hours';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Business Hours', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-business_hours' ];
	}
    
    public function get_icon() {
		return 'eicon-clock-o';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Business Hours', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT
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
				'default' => 'h3',
			]
		);

		$this->add_control(
			'hr_bh_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
			'day', [
				'label' => esc_html__( 'Day', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
        
        $repeater->add_control(
			'time', [
				'label' => esc_html__( 'Time', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
        
        $repeater->add_control(
			'style_row',
			[
				'label' => esc_html__( 'Style This Day', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $repeater->add_control(
			'day_color',
			[
				'label' => esc_html__( 'Day Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .tme-business-day' => 'color: {{VALUE}};'
				]
			]
		);
        
        $repeater->add_control(
			'time_color',
			[
				'label' => esc_html__( 'Time Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .tme-business-time' => 'color: {{VALUE}};'
				]
			]
		);
        
        $repeater->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['style_row' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
				]
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
						'day' => esc_html__( 'Monday', 'theme-masters-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Tuesday', 'theme-masters-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Wednesday', 'theme-masters-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Thursday', 'theme-masters-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Friday', 'theme-masters-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Saturday', 'theme-masters-elementor' ),
						'time' => esc_html__( '08:00 - 19:00', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
                    [
						'day' => esc_html__( 'Sunday', 'theme-masters-elementor' ),
						'time' => esc_html__( 'Closed', 'theme-masters-elementor' ),
                        'day_color' => '',
                        'time_color' => '',
                        'bg_color' => '',
					],
				],
				'title_field' => '{{{ day }}}',
			]
		);

		$this->end_controls_section();

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
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-business-hours-title' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				'name' => 'title_typography',
				
				'selector' => '{{WRAPPER}} .tme-business-hours-title',
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => esc_html__( 'Text Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theme-masters-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tme-business-hours-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-business-hours-title',
			]
		);
        
        $this->add_control(
			'title_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-business-hours-title'
			]
		);
        
        $this->add_responsive_control(
			'title_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-business-hours-title' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-business-hours-title'
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
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-business-hours-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                    '{{WRAPPER}} .tme-business-hours-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_item_style',
			[
				'label' => esc_html__( 'List Item', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'list_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-business-hour' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'hr_list_item_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'list_item_divider_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-business-hour' => 'border-bottom-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_responsive_control(
			'list_item_divider_width',
			[
				'label' => esc_html__( 'Border Height', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
                    'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-business-hour' => 'border-bottom-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->add_control(
			'list_item_divider_style',
			[
				'label' => esc_html__( 'Border Style', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'theme-masters-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'theme-masters-elementor' ),
                    'dotted' => esc_html__( 'Dotted', 'theme-masters-elementor' ),
                    'double' => esc_html__( 'Double', 'theme-masters-elementor' )
				],
				'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .tme-business-hour' => 'border-bottom-style: {{VALUE}};'
				],
			]
		);
        
        $this->end_controls_section();

		$this->start_controls_section(
			'section_day_time_style',
			[
				'label' => esc_html__( 'Day and Time', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'day_width',
			[
				'label' => esc_html__( 'Day Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%'],
				'range' => [
                    '%' => [
						'min' => 0,
						'max' => 90,
					],
				],
                'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-business-day' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tme-business-time' => 'width: calc(100% - {{SIZE}}{{UNIT}});'
				],
			]
		);
        
        $this->add_control(
			'day_color',
			[
				'label' => esc_html__( 'Day Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-business-day' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Day Typography', 'theme-masters-elementor' ),
				'name' => 'day_typography',
				
				'selector' => '{{WRAPPER}} .tme-business-day',
			]
		);
        
        $this->add_responsive_control(
			'day_align',
			[
				'label' => esc_html__( 'Day Alignment', 'theme-masters-elementor' ),
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
					'{{WRAPPER}} .tme-business-day' => 'text-align: {{VALUE}};'
				],
				'toggle' => false
			]
		);
        
        $this->add_control(
			'hr_day_color_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'time_color',
			[
				'label' => esc_html__( 'Time Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-business-time' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Time Typography', 'theme-masters-elementor' ),
				'name' => 'time_typography',
				
				'selector' => '{{WRAPPER}} .tme-business-time',
			]
		);
        
        $this->add_responsive_control(
			'time_align',
			[
				'label' => esc_html__( 'Time Alignment', 'theme-masters-elementor' ),
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
                'default' => 'right',
				'selectors' => [
					'{{WRAPPER}} .tme-business-time' => 'text-align: {{VALUE}};'
				],
				'toggle' => false
			]
		);
       
		$this->end_controls_section();
  
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display(); ?>
		<?php if ( $settings['title'] ) {
			echo '<' . $settings['html_tag'] . ' class="tme-business-hours-title">' . esc_html($settings['title']) . '</' . $settings['html_tag'] . '>';
		} ?>
		<?php if ( $settings['list'] ) { ?>
        <div class="tme-business-hours">
            <?php foreach ( $settings['list'] as $item ) { ?> 
            <div class="tme-business-hour elementor-repeater-item-<?php echo $item['_id']; ?>">
                <div class="tme-business-day">
                    <?php echo esc_html($item['day']); ?>
                </div>
                <div class="tme-business-time">
                     <?php echo esc_html($item['time']); ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php
		}
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Business_Hours() );