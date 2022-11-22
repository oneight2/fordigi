<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Weather extends Widget_Base {

	public function get_name() {
		return 'tme-weather';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Weather', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-weather', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-weather' ];
	}
    
    public function get_icon() {
		return 'eicon-flash';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
    
        $this->add_control(
			'apikey',
			[
				'label' => esc_html__( 'API Key', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'description' => '<a href="https://openweathermap.org/" target="_blank">' . esc_html__('You must get an API Key from openweathermap.org', 'theme-masters-elementor') . '</a>'
			]
        );
        
        $this->add_control(
			'place',
			[
				'label' => esc_html__( 'Place', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'New York', 'theme-masters-elementor' ),
                'label_block' => true
			]
        );
        
        $this->add_control(
			'language',
			[
				'label' => esc_html__( 'Language', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'en' => esc_html__( 'English', 'theme-masters-elementor' ),
                    'af' => esc_html__( 'Africaans', 'theme-masters-elementor' ),
                    'al' => esc_html__( 'Albanian', 'theme-masters-elementor' ),
                    'ar' => esc_html__( 'Arabic', 'theme-masters-elementor' ),
                    'az' => esc_html__( 'Azerbaijani', 'theme-masters-elementor' ),
                    'bg' => esc_html__( 'Bulgarian', 'theme-masters-elementor' ),
                    'ca' => esc_html__( 'Catalan', 'theme-masters-elementor' ),
                    'cz' => esc_html__( 'Czech', 'theme-masters-elementor' ),
                    'da' => esc_html__( 'Danish', 'theme-masters-elementor' ),
                    'de' => esc_html__( 'German', 'theme-masters-elementor' ),
                    'el' => esc_html__( 'Greek', 'theme-masters-elementor' ),
                    'eu' => esc_html__( 'Basque', 'theme-masters-elementor' ),
                    'fa' => esc_html__( 'Persian (Farsi)', 'theme-masters-elementor' ),
                    'fi' => esc_html__( 'Finnish', 'theme-masters-elementor' ),
                    'fr' => esc_html__( 'French', 'theme-masters-elementor' ),
                    'gl' => esc_html__( 'Galician', 'theme-masters-elementor' ),
                    'he' => esc_html__( 'Hebrew', 'theme-masters-elementor' ),
                    'hi' => esc_html__( 'Hindi', 'theme-masters-elementor' ),
                    'hr' => esc_html__( 'Croatian', 'theme-masters-elementor' ),
                    'hu' => esc_html__( 'Hungarian', 'theme-masters-elementor' ),
                    'id' => esc_html__( 'Indonesian', 'theme-masters-elementor' ),
                    'it' => esc_html__( 'Italian', 'theme-masters-elementor' ),
                    'ja' => esc_html__( 'Japanese', 'theme-masters-elementor' ),
                    'kr' => esc_html__( 'Korean', 'theme-masters-elementor' ),
                    'la' => esc_html__( 'Latvian', 'theme-masters-elementor' ),
                    'lt' => esc_html__( 'Lithuanian', 'theme-masters-elementor' ),
                    'mk' => esc_html__( 'Macedonian', 'theme-masters-elementor' ),
                    'no' => esc_html__( 'Norwegian', 'theme-masters-elementor' ),
                    'nl' => esc_html__( 'Dutch', 'theme-masters-elementor' ),
                    'pl' => esc_html__( 'Polish', 'theme-masters-elementor' ),
                    'pt' => esc_html__( 'Portuguese', 'theme-masters-elementor' ),
                    'pt_br' => esc_html__( 'Portugues Brasil', 'theme-masters-elementor' ),
                    'ro' => esc_html__( 'Romanian', 'theme-masters-elementor' ),
                    'ru' => esc_html__( 'Russian', 'theme-masters-elementor' ),
                    'sv, se' => esc_html__( 'Swedish', 'theme-masters-elementor' ),
                    'sk' => esc_html__( 'Slovak', 'theme-masters-elementor' ),
                    'sl' => esc_html__( 'Slovenian', 'theme-masters-elementor' ),
                    'sp, es' => esc_html__( 'Spanish', 'theme-masters-elementor' ),
                    'sr' => esc_html__( 'Serbian', 'theme-masters-elementor' ),
                    'th' => esc_html__( 'Thai', 'theme-masters-elementor' ),
                    'tr' => esc_html__( 'Turkish', 'theme-masters-elementor' ),
                    'ua, uk' => esc_html__( 'Ukrainian', 'theme-masters-elementor' ),
                    'vi' => esc_html__( 'Vietnamese', 'theme-masters-elementor' ),
                    'zh_cn' => esc_html__( 'Chinese Simplified', 'theme-masters-elementor' ),
                    'zh_tw' => esc_html__( 'Chinese Traditional', 'theme-masters-elementor' ),
                    'zu' => esc_html__( 'Zulu', 'theme-masters-elementor' ),
				],
				'default' => 'en',
			]
        );

        $this->add_control(
			'content_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );

        $this->add_control(
			'display_icon', [
				'label' => esc_html__( 'Display Weather Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
        );

        $this->add_control(
			'display_place', [
				'label' => esc_html__( 'Display Place', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
        );
        
        $this->add_control(
			'display_description', [
				'label' => esc_html__( 'Display Description', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
        );
        
        $this->add_control(
			'display_wind_speed', [
				'label' => esc_html__( 'Display Wind Speed', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
        );
        
        $this->add_control(
			'display_humidity', [
				'label' => esc_html__( 'Display Humidity', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'show_label' => true,
			]
        );
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => esc_html__( 'Container', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'container_layout',
			[
				'label' => esc_html__( 'Layout', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
                    '1'  => esc_html__( 'Layout 1', 'theme-masters-elementor' ),
                    '2'  => esc_html__( 'Layout 2', 'theme-masters-elementor' ),
                    '3'  => esc_html__( 'Layout 3', 'theme-masters-elementor' ),
                    '4'  => esc_html__( 'Layout 4', 'theme-masters-elementor' )
                ]
			]
        );
        
        $this->add_responsive_control(
			'container_align',
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
					'{{WRAPPER}} .tme-weather-container' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
        );

        $this->add_responsive_control(
			'container_valign',
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
					'{{WRAPPER}} .tme-weather' => 'align-items: {{VALUE}};',
				],
                'toggle' => false
			]
        );
        
        $this->add_responsive_control(
			'container_width',
			[
				'label' => esc_html__( 'Maximum Width', 'theme-masters-elementor' ),
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
                'default' => [
					'unit' => 'px',
					'size' => 480,
				],
				'selectors' => [
					'{{WRAPPER}} .tme-weather' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'container_bg',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-weather',
			]
        );

        $this->add_control(
			'overlay_heading',
			[
				'label' => esc_html__( 'Overlay', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => esc_html__( 'Overlay Background', 'theme-masters-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-weather-overlay',
			]
        );

        $this->add_control(
			'container_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather'
			]
		);
        
        $this->add_responsive_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-weather' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tme-weather-overlay' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather'
			]
		);
        
        $this->add_control(
			'container_hr_2',
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
                    '{{WRAPPER}} .tme-weather' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'container_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->end_controls_section();

        // section start
		$this->start_controls_section(
			'section_temperature_style',
			[
				'label' => esc_html__( 'Temperature', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'temperature_typography',
				
				'selector' => '{{WRAPPER}} .tme-weather-temperature',
			]
		);
        
        $this->add_control(
			'temperature_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-temperature' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'temperature_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather-temperature',
			]
		);
        
        $this->add_responsive_control(
			'temperature_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-temperature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();

        // section start
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Weather Icon', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_icon' => 'yes'],
			]
        );

        $this->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
                    'filled' => esc_html__( 'Filled', 'theme-masters-elementor' ),
					'outline' => esc_html__( 'Outline', 'theme-masters-elementor' ),
				],
				'default' => 'filled',
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
        );
        
        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-icon' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'icon_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather-icon',
			]
		);

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_place_style',
			[
				'label' => esc_html__( 'Place', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_place' => 'yes'],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'place_typography',
				
				'selector' => '{{WRAPPER}} .tme-weather-place',
			]
		);
        
        $this->add_control(
			'place_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-place' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'place_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather-place',
			]
		);
        
        $this->add_responsive_control(
			'place_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-place' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_description' => 'yes'],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				
				'selector' => '{{WRAPPER}} .tme-weather-description',
			]
		);
        
        $this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-description' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'description_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather-description',
			]
		);
        
        $this->add_responsive_control(
			'description_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_divider_style',
			[
				'label' => esc_html__( 'Divider', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_responsive_control(
			'divider_height',
			[
				'label' => esc_html__( 'Height', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-divider' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_responsive_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-divider' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
        );

        $this->add_responsive_control(
			'divider_spacing',
			[
				'label' => esc_html__( 'Spacing (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-divider' => 'margin: {{SIZE}}{{UNIT}} 0;'
				],
			]
        );

        $this->add_control(
			'divider_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-divider' => 'background-color: {{VALUE}};'
				]
			]
        );

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_wind_speed_style',
			[
				'label' => esc_html__( 'Wind Speed', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_wind_speed' => 'yes'],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'wind_speed_typography',
				
				'selector' => '{{WRAPPER}} .tme-weather-wind-speed',
			]
		);
        
        $this->add_control(
			'wind_speed_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-wind-speed' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'wind_speed_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-wind-speed i' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'wind_speed_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather-wind-speed',
			]
		);
        
        $this->add_responsive_control(
			'wind_speed_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-wind-speed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_humidity_style',
			[
				'label' => esc_html__( 'Humidity', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['display_humidity' => 'yes'],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'humidity_typography',
				
				'selector' => '{{WRAPPER}} .tme-weather-humidity',
			]
		);
        
        $this->add_control(
			'humidity_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-humidity' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'humidity_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tme-weather-humidity i' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'humidity_shadow',
				'label' => esc_html__( 'Text Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-weather-humidity',
			]
		);
        
        $this->add_responsive_control(
			'humidity_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-weather-humidity' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();
     
	}
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        if ($settings['apikey']) {
        ?>
        <div class="tme-weather-container">
            <div class="tme-weather tme-weather-layout-<?php echo esc_attr($settings['container_layout']); ?>" data-apikey="<?php echo esc_attr($settings['apikey']); ?>" data-place="<?php echo esc_attr($settings['place']); ?>" data-lang="<?php echo esc_attr($settings['language']); ?>" data-iconstyle="<?php echo esc_attr($settings['icon_style']); ?>">
                <div class="tme-weather-overlay"></div>
                <div class="tme-weather-left">
                    <?php if ($settings['display_place']) { ?>
                    <div class="tme-weather-place"></div>
                    <?php } ?>
                    <?php if ($settings['display_description']) { ?>
                    <div class="tme-weather-description"></div>
                    <?php } ?>
                    <div class="tme-weather-divider-wrapper"><div class="tme-weather-divider"></div></div>
                    <?php if ($settings['display_wind_speed']) { ?>
                    <div class="tme-weather-wind-speed"></div>
                    <?php } ?>
                    <?php if ($settings['display_humidity']) { ?>
                    <div class="tme-weather-humidity"></div>
                    <?php } ?>
                </div>
                <div class="tme-weather-right">
                    <?php if ($settings['display_icon']) { ?>
                    <i class="tme-weather-icon" data-wicon=""></i>
                    <?php } ?>
                    <div class="tme-weather-temperature"></div>
                </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="tme-danger"><?php esc_html_e( 'You must enter an API Key.', 'theme-masters-elementor' ); ?></div>  
        <?php }
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Weather() );