<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_QRcode extends Widget_Base {

	public function get_name() {
		return 'tme-qrcode';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'QR Code', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_script_depends(){
		return [ 'tme-qrcode' ];
	}
    
    public function get_icon() {
		return 'eicon-barcode';
	}

	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'qrcode_content_qrcode',
			[
				'label' => esc_html__( 'QR Code', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'content_type',
			[
				'label' => esc_html__( 'Content Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
                    ''  => esc_html__( 'Custom Text or Link', 'theme-masters-elementor' ),
                    'mailto:'  => esc_html__( 'Email Address', 'theme-masters-elementor' ),
					'tel:'  => esc_html__( 'Phone Number', 'theme-masters-elementor' ),
                    'sms:'  => esc_html__( 'SMS', 'theme-masters-elementor' )
				],
			]
        );
        
        $this->add_control(
			'text', [
				'label' => esc_html__( 'Content', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'www.codecanyon.net', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);

        $this->add_control(
			'mode',
			[
				'label' => esc_html__( 'Mode', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'plain',
				'options' => [
                    'plain'  => esc_html__( 'Plain', 'theme-masters-elementor' ),
                    'label'  => esc_html__( 'Label', 'theme-masters-elementor' ),
					'image'  => esc_html__( 'Image', 'theme-masters-elementor' )
				],
			]
        );

        $this->add_control(
			'label', [
				'label' => esc_html__( 'Label', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'TM', 'theme-masters-elementor' ),
                'condition' => ['mode' => 'label'],
                'dynamic' => [
					'active' => true,
				],
			]
		);

        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['mode' => 'image'],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'msize',
            [
                'label' => esc_html__( 'Label/Image Size', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default' => [
                    'size' => 30
                ],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'mode',
                            'value' => 'label',
                        ],
                        [
                            'name'  => 'mode',
                            'value' => 'image',
                        ]
                    ]
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1
                    ]
                ]
            ]
        );

        $this->add_control(
            'mposx',
            [
                'label' => esc_html__( 'Label/Image Position X', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default' => [
                    'size' => 50
                ],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'mode',
                            'value' => 'label',
                        ],
                        [
                            'name'  => 'mode',
                            'value' => 'image',
                        ]
                    ]
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1
                    ]
                ]
            ]
        );

        $this->add_control(
            'mposy',
            [
                'label' => esc_html__( 'Label/Image Position Y', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default' => [
                    'size' => 50
                ],
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'mode',
                            'value' => 'label',
                        ],
                        [
                            'name'  => 'mode',
                            'value' => 'image',
                        ]
                    ]
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        // section start
		$this->start_controls_section(
			'qrcode_content_settings',
			[
				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'render',
			[
				'label' => esc_html__( 'Render Method', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'svg',
				'options' => [
                    'svg'  => esc_html__( 'SVG', 'theme-masters-elementor' ),
                    'canvas'  => esc_html__( 'Canvas', 'theme-masters-elementor' ),
                    'image'  => esc_html__( 'Image', 'theme-masters-elementor' )
				],
			]
        );

        $this->add_control(
			'qrsize',
			[
				'label' => esc_html__( 'Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 2000,
				'step' => 1,
				'default' => 200
			]
		);

        $this->add_control(
            'crisp',
            [
                'label' => esc_html__( 'Crisp', 'theme-masters-elementor' ),
                'description'    => esc_html__( 'Render pixel-perfect lines.', 'theme-masters-elementor'), 
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
					'true' => [
						'title' => esc_html__( 'Enable', 'theme-masters-elementor' ),
						'icon' => 'eicons eicon-check',
					],
					'false' => [
						'title' => esc_html__( 'Disable', 'theme-masters-elementor' ),
						'icon' => 'eicons eicon-close',
					],
				],
				'default' => 'true',
				'toggle' => false
            ]
        );

        $this->add_control(
            'minversion',
            [
                'label' => esc_html__( 'Minimum Version', 'theme-masters-elementor' ),
                'description' => esc_html__( 'https://www.qrcode.com/en/about/version.html', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'size' => 1
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 40,
                        'step' => 1
                    ]
                ]
            ]
        );

        $this->add_control(
			'eclevel',
			[
				'label' => esc_html__( 'Error Correction Level', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'H',
				'options' => [
                    'H'  => esc_html__( 'H - high (30%)', 'theme-masters-elementor' ),
                    'Q'  => esc_html__( 'Q - quartile (25%)', 'theme-masters-elementor' ),
                    'M'  => esc_html__( 'M - medium (15%)', 'theme-masters-elementor' ),
                    'L'  => esc_html__( 'L - low (7%)', 'theme-masters-elementor' )
				],
			]
        );

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'QR Code', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'share_buttons_align',
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
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .tme-qrcode-wrapper' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .tme-qrcode-wrapper canvas,{{WRAPPER}} .tme-qrcode-wrapper img,{{WRAPPER}} .tme-qrcode-wrapper svg' => 'vertical-align:bottom;',
				],
                'toggle' => false
			]
		);

        $this->add_control(
			'code_color',
			[
				'label' => esc_html__( 'Code Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
                'alpha' => false
			]
		);

        $this->add_control(
            'rounded',
            [
                'label' => esc_html__( 'Code Rounding', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default' => [
                    'size' => 0
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ]
            ]
        );

        $this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
                'alpha' => false
			]
		);

        $this->add_control(
			'label_family',
			[
				'label' => esc_html__( 'Label Font Family', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
                'default' => "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                'options' => [
                    "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif" => esc_html__( 'Helvetica Neue', 'tmfeed' ),
                    "Georgia, serif" => esc_html__( 'Georgia', 'tmfeed' ),
                    "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => esc_html__( 'Palatino Linotype', 'tmfeed' ),
                    "'Times New Roman', Times, serif" => esc_html__( 'Times New Roman', 'tmfeed' ),
                    "Arial, Helvetica, sans-serif" => esc_html__( 'Arial', 'tmfeed' ),
                    "'Arial Black', Gadget, sans-serif" => esc_html__( 'Arial Black', 'tmfeed' ),
                    "'Comic Sans MS', cursive, sans-serif" => esc_html__( 'Comic Sans', 'tmfeed' ),
                    "Impact, Charcoal, sans-serif" => esc_html__( 'Impact', 'tmfeed' ),
                    '"Lucida Sans Unicode", "Lucida Grande", sans-serif' => esc_html__( 'Lucida Sans', 'tmfeed' ),
                    "Tahoma, Geneva, sans-serif" => esc_html__( 'Tahoma', 'tmfeed' ),
                    "'Trebuchet MS', Helvetica, sans-serif" => esc_html__( 'Trebuchet', 'tmfeed' ),
                    "Verdana, Geneva, sans-serif" => esc_html__( 'Verdana', 'tmfeed' ),
                    "'Courier New', Courier, monospace" => esc_html__( 'Courier New', 'tmfeed' ),
                    "'Lucida Console', Monaco, monospace" => esc_html__( 'Lucida Console', 'tmfeed' )
				]
			]
		);

        $this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
                'alpha' => false
			]
		);

        $this->add_control(
			'wrapper_title',
			[
				'label' => esc_html__( 'Wrapper', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'wrapper_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tme-qrcode' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wrapper_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-qrcode'
			]
		);

        $this->add_control(
			'wrapper_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-qrcode' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wrapper_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-qrcode'
			]
		);

        $this->add_responsive_control(
			'wrapper_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-qrcode' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        echo '<div class="tme-qrcode-wrapper" style="display:flex;visibility:hidden;"><div class="tme-qrcode" 
        data-qrtext="' . esc_attr($settings['content_type'] . $settings['text']) . '" 
        data-qrrender="' . $settings['render'] . '" 
        data-qrcrisp="' . $settings['crisp'] . '" 
        data-qrmode="' . $settings['mode'] . '" 
        data-qrlabel="' . esc_attr($settings['label']) . '" 
        data-qrsize="' . ($settings['qrsize'] ? $settings['qrsize'] : 200) . '" 
        data-qrminversion="' . $settings['minversion']['size'] . '" 
        data-qreclevel="' . $settings['eclevel'] . '" 
        data-qrcolor="' . $settings['code_color'] . '" 
        data-qrbgcolor="' . $settings['bg_color'] . '" 
        data-qrrounded="' . $settings['rounded']['size'] . '" 
        data-qrmsize="' . ($settings['msize'] ? $settings['msize']['size'] : 30) . '" 
        data-qrmposx="' . ($settings['mposx'] ? $settings['mposx']['size'] : 0) . '" 
        data-qrmposy="' . ($settings['mposy'] ? $settings['mposy']['size'] : 0) . '" 
        data-qrfcolor="' . $settings['label_color'] . '" 
        data-qrfamily="' . $settings['label_family'] . '">';
        if ($settings['image'] && !empty($settings['image']['url'])) {
            echo '<img class="tme-qrcode-img" style="display:none;" src="' . esc_url($settings['image']['url']) . '" />';
        }
        echo '</div></div>';
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_QRcode() );