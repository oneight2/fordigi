<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Table extends Widget_Base {

	public function get_name() {
		return 'tme-table';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Table', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-lib-table','elementor-icons-fa-solid','tme-table' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-table', 'tme-table' ];
	}
    
    public function get_icon() {
		return 'eicon-table';
    }

	protected function register_controls() {
        $this->start_controls_section(
			'table_source_section',
			[
				'label' => esc_html__( 'Table', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'table_source',
			[
                'label' => esc_html__( 'Source', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'custom' => esc_html__( 'Custom', 'theme-masters-elementor' ),
                    'csv' => esc_html__( 'CSV', 'theme-masters-elementor' )
				],
                'default' => 'custom'
			]
        );
        
        $this->add_control(
			'csv_link',
			[
				'label' => esc_html__( 'Select CSV File', 'theme-masters-elementor' ),
				'type'	=> 'tmea-file-select',
				'placeholder' => esc_html__( 'URL to File', 'theme-masters-elementor' ),
                'default' => TMEA_PLUGINS_URL . 'assets/img/sample.csv',
                'condition' => [
                    'table_source' => 'csv'
                ],
			]
        );   
        
        $this->end_controls_section();
		$this->start_controls_section(
			'table_header_section',
			[
				'label' => esc_html__( 'Table Header', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'table_source' => 'custom'
                ]
			]
		);
     
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'content_type',
			[
				'label' => esc_html__( 'Content Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'label',
				'options' => [
                    'label'  => esc_html__( 'Label', 'theme-masters-elementor' ),
					'icon'  => esc_html__( 'Icon', 'theme-masters-elementor' ),
					'image'  => esc_html__( 'Image', 'theme-masters-elementor' ),
                    'shortcode'  => esc_html__( 'Shortcode', 'theme-masters-elementor' )
				],
			]
		);

        $repeater->add_control(
			'table_header_label',
			[
				'label' => esc_html__( 'Label', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => ['content_type' => 'label'],
			]
        );

        $repeater->add_control(
			'table_header_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => ['content_type' => 'icon'],
			]
		);
        
        $repeater->add_control(
			'table_header_image',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => ['content_type' => 'image'],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        
        $repeater->add_control(
			'table_header_shortcode',
			[
				'label' => esc_html__('Shortcode', 'theme-masters-elementor'),
                'condition' => ['content_type' => 'shortcode'],
				'type' => Controls_Manager::TEXTAREA
			]
		); 

        $repeater->add_control(
			'table_header_style_column',
			[
				'label' => esc_html__( 'Style This Column', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
        );
        
        $repeater->add_responsive_control(
			'table_header_style_column_min_width',
			[
				'label' => esc_html__( 'Minumum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'rem' ],
				'range' => [
					'vw' => [
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
                'condition' => ['table_header_style_column' => 'yes'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'min-width: {{SIZE}}{{UNIT}};'
				]
			]
        );
        
        $repeater->add_control(
			'table_header_style_column_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['table_header_style_column' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}} !important;'
				]
			]
		);
        
        $repeater->add_control(
			'table_header_style_column_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'condition' => ['table_header_style_column' => 'yes'],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}} !important;'
				]
			]
		);
        
        $this->add_control(
			'table_header_list',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
						'table_header_label' => esc_html__( 'Name', 'theme-masters-elementor' )
					],
					[
                        'table_header_label' => esc_html__( 'Position', 'theme-masters-elementor' )
                    ],
                    [
                        'table_header_label' => esc_html__( 'Office', 'theme-masters-elementor' )
                    ],
                    [
                        'table_header_label' => esc_html__( 'Age', 'theme-masters-elementor' )
                    ],
                    [
                        'table_header_label' => esc_html__( 'Start Date', 'theme-masters-elementor' )
                    ],
                    [
                        'table_header_label' => esc_html__( 'Salary', 'theme-masters-elementor' )
					],
				],
				'title_field' => '{{{ table_header_label }}}',
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
			'table_body_section',
			[
				'label' => esc_html__( 'Table Body', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'table_source' => 'custom'
                ]
			]
		);
     
        $repeater2 = new \Elementor\Repeater();

        $repeater2->add_control(
			'table_body_action',
			[
                'label' => esc_html__( 'Action', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'Cell' => esc_html__( 'Add New Cell', 'theme-masters-elementor' ),
                    'Start Row' => esc_html__( 'Start New Row', 'theme-masters-elementor' )
				],
                'default' => 'Cell'
			]
        );

        $repeater2->add_control(
			'body_content_type',
			[
				'label' => esc_html__( 'Content Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'label',
				'options' => [
                    'label'  => esc_html__( 'Text', 'theme-masters-elementor' ),
					'icon'  => esc_html__( 'Icon', 'theme-masters-elementor' ),
					'image'  => esc_html__( 'Image', 'theme-masters-elementor' ),
                    'shortcode'  => esc_html__( 'Shortcode', 'theme-masters-elementor' )
                ],
                'condition' => ['table_body_action' => 'Cell'],
			]
		);

        $repeater2->add_control(
			'table_body_label',
			[
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'body_content_type',
                            'value' => 'label',
                        ],
                        [
                            'name'  => 'table_body_action',
                            'value' => 'Cell',
                        ]
                    ]
                ],
			]
        );

        $repeater2->add_control(
			'table_body_icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'body_content_type',
                            'value' => 'icon',
                        ],
                        [
                            'name'  => 'table_body_action',
                            'value' => 'Cell',
                        ]
                    ]
                ],
			]
		);
        
        $repeater2->add_control(
			'table_body_image',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'body_content_type',
                            'value' => 'image',
                        ],
                        [
                            'name'  => 'table_body_action',
                            'value' => 'Cell',
                        ]
                    ]
                ],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        
        $repeater2->add_control(
			'table_body_shortcode',
			[
				'label' => esc_html__('Shortcode', 'theme-masters-elementor'),
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'body_content_type',
                            'value' => 'shortcode',
                        ],
                        [
                            'name'  => 'table_body_action',
                            'value' => 'Cell',
                        ]
                    ]
                ],
				'type' => Controls_Manager::TEXTAREA
			]
		); 

        $repeater2->add_control(
			'table_body_style_column',
			[
				'label' => esc_html__( 'Style This Column', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => '',
                'condition' => ['table_body_action' => 'Cell'],
			]
        );
        
        $repeater2->add_control(
			'table_body_style_column_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'table_body_style_column',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'table_body_action',
                            'value' => 'Cell',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}} !important;'
				]
			]
		);
        
        $repeater2->add_control(
			'table_body_style_column_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'conditions'   => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name'  => 'table_body_style_column',
                            'value' => 'yes',
                        ],
                        [
                            'name'  => 'table_body_action',
                            'value' => 'Cell',
                        ]
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}} !important;'
				]
			]
		);
        
        $this->add_control(
			'table_body_list',
			[
				'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater2->get_controls(),
                'show_label' => false,
				'default' => [
					[
                        'table_body_action' => 'Cell',
						'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
					],
					[
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Start Row'
                    ],
                    [
                        'table_body_action' => 'Cell',
						'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
					],
					[
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    [
                        'table_body_action' => 'Cell',
                        'table_body_label' => esc_html__( 'Sample Content...', 'theme-masters-elementor' )
                    ],
                    
				],
				'title_field' => '{{{ table_body_action }}}: {{{ table_body_label }}}',
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
			'table_settings_section',
			[
				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $this->add_control(
			'table_paging',
			[
				'label' => esc_html__( 'Paging', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => 'yes'
			]
        );

        $this->add_control(
            'table_page_length',
            [
                'label' => esc_html__( 'Page Length', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20
            ]
        );

        $this->add_control(
			'table_info',
			[
				'label' => esc_html__( 'Info', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => 'yes'
			]
        );

        $this->add_control(
			'table_searching',
			[
				'label' => esc_html__( 'Searching', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => 'yes'
			]
        );

        $this->add_control(
			'table_ordering',
			[
				'label' => esc_html__( 'Ordering', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => 'yes'
			]
        );

        $this->add_control(
			'table_buttons',
			[
				'label' => esc_html__( 'Buttons', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => 'yes'
			]
        );

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'table_style_section',
			[
				'label' => esc_html__( 'Table', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_responsive_control(
			'table_spacing',
			[
				'label' => esc_html__( 'Inner Spacing (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
                'default' => 10,
                'selectors' => [
					'{{WRAPPER}} table.dataTable thead th' => 'padding: {{VALUE}}px;',
					'{{WRAPPER}} table.dataTable.cell-border tbody td' => 'padding: {{VALUE}}px;'
				]
			]
		);

		$this->add_responsive_control(
			'table_top_bottom_spacing',
			[
				'label' => esc_html__( 'Top-Bottom Spacing (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
                'default' => 15,
                'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_scroll' => 'padding: {{VALUE}}px 0;'
				]
			]
		);
        
        $this->add_control(
			'table_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#dddddd',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable.cell-border tbody th' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable.cell-border tbody td' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead th' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead td' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper.no-footer .dataTables_scrollBody' => 'border-color: {{VALUE}};'
				]
			]
        );
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'table_header_style_section',
			[
				'label' => esc_html__( 'Table Header', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_header_typography',
				
				'selector' => '{{WRAPPER}} table.dataTable thead th',
			]
        );
        
        $this->add_control(
			'table_header_text_align',
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
				'default' => 'left',
                'toggle' => false,
                'selectors' => [
					'{{WRAPPER}} table.dataTable thead th' => 'text-align: {{VALUE}};',
				]
			]
        );
        
        $this->add_control(
			'table_header_sorting_align',
			[
				'label' => esc_html__( 'Sorting Icon Align', 'theme-masters-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theme-masters-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
				'selectors' => [
                    '{{WRAPPER}} .dataTables_scrollHead table.dataTable thead .sorting:after' => '{{VALUE}}: {{table_spacing.VALUE}}px;',
                    '{{WRAPPER}} .dataTables_scrollHead table.dataTable thead .sorting_asc:after' => '{{VALUE}}: {{table_spacing.VALUE}}px;',
                    '{{WRAPPER}} .dataTables_scrollHead table.dataTable thead .sorting_desc:after' => '{{VALUE}}: {{table_spacing.VALUE}}px;',
                    '{{WRAPPER}} .dataTables_scrollHead table.dataTable thead .sorting_asc_disabled:after' => '{{VALUE}}: {{table_spacing.VALUE}}px;',
                    '{{WRAPPER}} .dataTables_scrollHead table.dataTable thead .sorting_desc_disabled:after' => '{{VALUE}}: {{table_spacing.VALUE}}px;',
				],
                'toggle' => false
			]
		);

        $this->add_control(
			'table_header_font_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#252525',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable thead th' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'table_header_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable thead th' => 'background-color: {{VALUE}};'
				]
			]
		);
		
		$this->add_control(
			'table_header_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

        $this->add_responsive_control(
			'table_header_min_width',
			[
				'label' => esc_html__( 'Minumum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'rem' ],
				'range' => [
					'vw' => [
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
                    '{{WRAPPER}} table.dataTable thead th' => 'min-width: {{SIZE}}{{UNIT}};'
				]
			]
        );

        $this->add_responsive_control(
			'table_header_img_width',
			[
				'label' => esc_html__( 'Image Maximum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'rem' ],
				'range' => [
					'vw' => [
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
					'size' => 200,
				],
                'selectors' => [
                    '{{WRAPPER}} table.dataTable thead th img' => 'max-width: {{SIZE}}{{UNIT}};'
				]
			]
		);
		
		$this->add_responsive_control(
			'table_header_img_border_radius',
			[
				'label' => esc_html__( 'Image Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} table.dataTable thead th img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'table_header_icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} table.dataTable thead th i' => 'font-size: {{VALUE}}px;'
				],
			]
		);

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'table_body_style_section',
			[
				'label' => esc_html__( 'Table Body', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_body_typography',
				
				'selector' => '{{WRAPPER}} table.dataTable tbody tr',
			]
        );

        $this->add_control(
			'table_body_text_align',
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
				'default' => 'left',
                'toggle' => false,
                'selectors' => [
					'{{WRAPPER}} table.dataTable tbody tr' => 'text-align: {{VALUE}};',
				]
			]
		);

        $this->add_control(
			'table_body_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

        $this->start_controls_tabs( 'table_body_styles' );
        
        $this->start_controls_tab(
			'table_body_odd',
			[
				'label' => esc_html__( 'Odd', 'theme-masters-elementor'),
			]
		);
        
        $this->add_control(
			'table_body_font_color_odd',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#757575',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.odd' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'table_body_odd_bg',
			[
				'label' => esc_html__( 'Row Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.odd' => 'background-color: {{VALUE}};'
				]
			]
        );
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'table_body_even',
			[
				'label' => esc_html__( 'Even', 'theme-masters-elementor'),
			]
		);

        $this->add_control(
			'table_body_font_color_even',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#757575',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.even' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'table_body_even_bg',
			[
				'label' => esc_html__( 'Row Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.even' => 'background-color: {{VALUE}};'
				]
			]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'table_body_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 

		$this->add_responsive_control(
			'table_body_img_width',
			[
				'label' => esc_html__( 'Image Maximum Width', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'rem' ],
				'range' => [
					'vw' => [
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
					'size' => 200,
				],
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr img' => 'max-width: {{SIZE}}{{UNIT}};'
				]
			]
		);
		
		$this->add_responsive_control(
			'table_body_img_border_radius',
			[
				'label' => esc_html__( 'Image Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr img' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'table_body_icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr i' => 'font-size: {{VALUE}}px;'
				],
			]
		);

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'table_buttons_style_section',
			[
				'label' => esc_html__( 'Buttons', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'table_buttons' => 'yes'
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_btn_typography',
				
				'selector' => '{{WRAPPER}} button.dt-button,{{WRAPPER}} div.dt-button,{{WRAPPER}} a.dt-button',
			]
		);
        
        $this->add_control(
			'table_btn_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  
        
        $this->start_controls_tabs( 'tabs_table_button_style' );
        
        $this->start_controls_tab(
			'tab_table_button_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'table_btn_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} button.dt-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.dt-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} a.dt-button' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'table_btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} button.dt-button' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.dt-button' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} a.dt-button' => 'background-color: {{VALUE}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} button.dt-button,{{WRAPPER}} div.dt-button,{{WRAPPER}} a.dt-button'
			]
		);
        
        $this->add_responsive_control(
			'table_btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} button.dt-button' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} div.dt-button' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} a.dt-button' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_btn_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} button.dt-button,{{WRAPPER}} div.dt-button,{{WRAPPER}} a.dt-button'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_table_button_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'table_btn_text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
                    '{{WRAPPER}} button.dt-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.dt-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} a.dt-button:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'table_btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
                    '{{WRAPPER}} button.dt-button:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.dt-button:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} a.dt-button:hover' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} button.dt-button:hover,{{WRAPPER}} div.dt-button:hover,{{WRAPPER}} a.dt-button:hover'
			]
		);
        
        $this->add_responsive_control(
			'table_btn_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} button.dt-button:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} div.dt-button:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} a.dt-button:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_btn_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} button.dt-button:hover,{{WRAPPER}} div.dt-button:hover,{{WRAPPER}} a.dt-button:hover'
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'table_btn_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'table_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} button.dt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} div.dt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} a.dt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'table_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} button.dt-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} div.dt-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} a.dt-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        // section start
		$this->start_controls_section(
			'table_pagination_style_section',
			[
				'label' => esc_html__( 'Pagination', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'table_paging' => 'yes'
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_pagination_typography',
				
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button',
			]
		);
        
        $this->add_control(
			'table_pagination_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  
        
        $this->start_controls_tabs( 'tabs_table_pagination_style' );
        
        $this->start_controls_tab(
			'tab_table_pagination_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'table_pagination_text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'table_pagination_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_pagination_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button'
			]
		);
        
        $this->add_responsive_control(
			'table_pagination_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_pagination_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_table_pagination_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'table_pagination_text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:active' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'table_pagination_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:active' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_pagination_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current,{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:hover,{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:active'
			]
		);
        
        $this->add_responsive_control(
			'table_pagination_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:active' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_pagination_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current,{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:hover,{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button:active'
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'table_pagination_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->add_responsive_control(
			'table_pagination_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'table_pagination_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_paginate .paginate_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'table_search_style_section',
			[
				'label' => esc_html__( 'Search Box', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'table_searching' => 'yes'
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_search_typography',
				
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_filter input'
			]
		);
        
        $this->add_control(
			'table_search_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		); 
        
        $this->start_controls_tabs( 'table_search_style' );
        
        $this->start_controls_tab(
			'table_search_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'table_search_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'table_search_placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input::placeholder' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'table_search_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_search_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_filter input'
			]
		);
        
        $this->add_responsive_control(
			'table_search_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_search_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_filter input'
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'table_search_hover',
			[
				'label' => esc_html__( 'Focus', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'table_search_text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input:focus' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'table_search_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input:focus' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_search_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_filter input:focus'
			]
		);
        
        $this->add_responsive_control(
			'table_search_border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_filter input:focus' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_search_border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_filter input:focus'
			]
		);
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'input_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'table_search_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .dataTables_wrapper .dataTables_filter input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
        );
        
        $this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'table_info_style_section',
			[
				'label' => esc_html__( 'Info', 'theme-masters-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'table_info' => 'yes'
                ],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_info_typography',
				
				'selector' => '{{WRAPPER}} .dataTables_wrapper .dataTables_info',
			]
        );

        $this->add_control(
			'table_info_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .dataTables_wrapper .dataTables_info' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->end_controls_section();
	}
    
    protected function render() {
        $settings = $this->get_settings_for_display(); 
        $widget_id = $this->get_id();
        ?>
        <div class="tmea-table-container" data-source="<?php echo $settings['table_source']; ?>" data-sourcecsv="<?php echo $settings['csv_link']; ?>" data-paging="<?php echo $settings['table_paging'] ? 'true' : 'false'; ?>" data-pagelength="<?php echo $settings['table_page_length']; ?>" data-info="<?php echo $settings['table_info'] ? 'true' : 'false'; ?>" data-searching="<?php echo $settings['table_searching'] ? 'true' : 'false'; ?>" data-ordering="<?php echo $settings['table_ordering'] ? 'true' : 'false'; ?>" data-buttons="<?php echo $settings['table_buttons'] ? 'true' : 'false'; ?>">
            <?php if ($settings['table_source'] == 'custom') { ?>
                <table id="tmea-table-<?php echo $widget_id; ?>" class="tmea-table cell-border" style="width:100%;visibility:hidden;">
                <thead>
                    <tr>
                    <?php foreach ( $settings['table_header_list'] as $item ) { ?>
                        <th class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                        <?php
                        if ($item['content_type'] == 'icon') {
                            \Elementor\Icons_Manager::render_icon( $item['table_header_icon'], [ 'aria-hidden' => 'true' ] );
                        } elseif ($item['content_type'] == 'label') {
                            echo wp_kses_post($item['table_header_label']);
                        } elseif ($item['content_type'] == 'image') {
                            echo '<img src="' . $item['table_header_image']['url'] . '" />';
                        } elseif ($item['content_type'] == 'shortcode') {
                            echo do_shortcode($item['table_header_shortcode']);
                        }
                        ?>
                        </th>
                    <?php } ?> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php foreach ( $settings['table_body_list'] as $item ) { ?>
                        <?php if ($item['table_body_action'] == 'Cell') { ?>
                            <td class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                            <?php
                            if ($item['body_content_type'] == 'icon') {
                                \Elementor\Icons_Manager::render_icon( $item['table_body_icon'], [ 'aria-hidden' => 'true' ] );
                            } elseif ($item['body_content_type'] == 'label') {
                                echo wp_kses_post($item['table_body_label']);
                            } elseif ($item['body_content_type'] == 'image') {
                                echo '<img src="' . $item['table_body_image']['url'] . '" />';
                            } elseif ($item['body_content_type'] == 'shortcode') {
                                echo do_shortcode($item['table_body_shortcode']);
                            }
                            ?>
                            </td>
                        <?php } else {
                            echo '</tr><tr>';
                        } ?>
                    <?php } ?>
                    </tr>
                </tbody>
                </table>
            <?php } ?>    
        </div>
            <?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Table() );