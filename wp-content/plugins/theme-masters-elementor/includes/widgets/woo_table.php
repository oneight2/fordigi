<?php
namespace Elementor;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Woo_Table extends Widget_Base {

	public function get_name() {
		return 'tme-woo_table';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'WooCommerce Table', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-lib-table','elementor-icons-fa-solid','tme-table' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-table', 'tme-woo_table' ];
	}
    
    public function get_icon() {
		return 'eicon-woocommerce';
    }

	protected function register_controls() {
        $this->start_controls_section(
			'section_products',
			[
				'label' => esc_html__( 'Products', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                    'popularity'  => esc_html__( 'Popularity', 'theme-masters-elementor' ),
                    'rating'  => esc_html__( 'Rating', 'theme-masters-elementor' )
				],
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
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'orderby',
                            'value' => 'post_date',
                        ],
                        [
                            'name'  => 'orderby',
                            'value' => 'title',
                        ],
                        [
                            'name'  => 'orderby',
                            'value' => 'rand',
                        ]
                    ]
                ],
			]
		);
        
        $this->add_control(
			'max',
			[
				'label' => esc_html__( 'Maximum number of products', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 9999,
				'step' => 1,
				'default' => 99,
			]
        );
        
        $this->add_control(
			'posts_hr_5',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
				'options' => TMEA_get_woo_categories()
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
				'options' => TMEA_get_woo_tags()
			]
		);

		$this->add_control(
			'include', [
				'label' => esc_html__( 'Included Products', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 'true',
                'multiple' => true,
				'default' => '',
				'options' => TMEA_get_woo_products()
			]
		);
        
        $this->add_control(
			'exclude', [
				'label' => esc_html__( 'Excluded Products', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => 'true',
                'multiple' => true,
				'default' => '',
				'options' => TMEA_get_woo_products()
			]
        );

        $this->add_control(
			'onsale',
			[
				'label' => esc_html__( 'On Sale Products', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
                'default' => '',
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'orderby',
                            'value' => 'post_date',
                        ],
                        [
                            'name'  => 'orderby',
                            'value' => 'title',
                        ],
                        [
                            'name'  => 'orderby',
                            'value' => 'rand',
                        ]
                    ]
                ],
			]
        );
        
        $this->add_control(
			'featured',
			[
				'label' => esc_html__( 'Featured Products', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'stock',
			[
				'label' => esc_html__( 'Stock Status', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
                    'all'  => esc_html__( 'All Products', 'theme-masters-elementor' ),
                    'instock'  => esc_html__( 'In Stock', 'theme-masters-elementor' ),
                    'outofstock'  => esc_html__( 'Out Of Stock', 'theme-masters-elementor' )
				],
			]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'table_columns_section',
			[
				'label' => esc_html__( 'Columns', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'column_name',
			[
				'label' => esc_html__( 'Column Name', 'theme-masters-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Column Name', 'theme-masters-elementor' )
			]
        );

        $repeater->add_control(
			'column_source',
			[
				'label' => esc_html__( 'Source', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'thumbnail',
				'options' => [
                    'thumbnail'  => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
					'name'  => esc_html__( 'Product Name', 'theme-masters-elementor' ),
                    'price'  => esc_html__( 'Price', 'theme-masters-elementor' ),
                    'sku'  => esc_html__( 'SKU', 'theme-masters-elementor' ),
                    'stock_quantity'  => esc_html__( 'Stock Quantity', 'theme-masters-elementor' ),
                    'stock'  => esc_html__( 'Stock Status', 'theme-masters-elementor' ),
                    'add_to_cart'  => esc_html__( 'Add to Cart Button', 'theme-masters-elementor' )
				],
			]
        );
        
        $repeater->add_responsive_control(
			'column_align',
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
				'default' => ''
			]
        );
        
        $this->add_control(
			'column_list',
			[
				'label' => esc_html__( 'Columns', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => false,
				'default' => [
					[
                        'column_name' => esc_html__( 'Thumbnail', 'theme-masters-elementor' ),
                        'column_source' => 'thumbnail',
                        'column_align' => 'left'
                    ],
                    [
                        'column_name' => esc_html__( 'Product Name', 'theme-masters-elementor' ),
                        'column_source' => 'name',
                        'column_align' => 'left'
                    ],
                    [
                        'column_name' => esc_html__( 'Price', 'theme-masters-elementor' ),
                        'column_source' => 'price',
                        'column_align' => 'left'
                    ],
                    [
                        'column_name' => esc_html__( 'Add to Cart', 'theme-masters-elementor' ),
                        'column_source' => 'add_to_cart',
                        'column_align' => 'left'
					],
				],
				'title_field' => '{{{ column_name }}}',
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
				'label' => esc_html__( 'Table Buttons', 'theme-masters-elementor' ),
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
					'size' => 100,
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
			'table_body_link_color_odd',
			[
				'label' => esc_html__( 'Link Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#2e5d9f',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.odd a.tmea-table-link' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'table_body_link_hover_color_odd',
			[
				'label' => esc_html__( 'Link Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#2e5d9f',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.odd a.tmea-table-link:hover' => 'color: {{VALUE}};'
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
			'table_body_link_color_even',
			[
				'label' => esc_html__( 'Link Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#2e5d9f',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.even a.tmea-table-link' => 'color: {{VALUE}};'
				]
			]
        );

        $this->add_control(
			'table_body_link_hover_color_even',
			[
				'label' => esc_html__( 'Link Hover Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#2e5d9f',
                'selectors' => [
                    '{{WRAPPER}} table.dataTable tbody tr.even a.tmea-table-link:hover' => 'color: {{VALUE}};'
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
				'label' => esc_html__( 'Table Buttons', 'theme-masters-elementor' ),
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

        $this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Add To Cart Button', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => esc_html__( 'Typography', 'theme-masters-elementor' ),
				
				'selector' => '{{WRAPPER}} .tmebtn-primary a.button,{{WRAPPER}} .tmebtn-primary a.added_to_cart',
			]
		);
        
        $this->start_controls_tabs( 'tabs_btn_primary_style' );
        
        $this->start_controls_tab(
			'tab_btn_primary_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart' => 'color: {{VALUE}};'
				],
			]
        );
        
        $this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmebtn-primary a.button,{{WRAPPER}} .tmebtn-primary a.added_to_cart',
			]
		);
        
        $this->add_responsive_control(
			'btn_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmebtn-primary a.button,{{WRAPPER}} .tmebtn-primary a.added_to_cart',
			]
        );
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_primary_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);

        $this->add_control(
			'btn_hover_color',
			[
				'label' => esc_html__( 'Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart:hover' => 'color: {{VALUE}};'
				],
			]
        );
        
        $this->add_control(
			'btn_bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart:hover' => 'background-color: {{VALUE}};'
				],
			]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tmebtn-primary a.button:hover,{{WRAPPER}} .tmebtn-primary a.added_to_cart:hover',
			]
		);
        
        $this->add_responsive_control(
			'btn_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart:hover' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
                'selector' => '{{WRAPPER}} .tmebtn-primary a.button:hover',
                'selector' => '{{WRAPPER}} .tmebtn-primary a.added_to_cart:hover',
			]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'btn_hr_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'btn_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'isLinked' => false,
                ],
				'selectors' => [
					'{{WRAPPER}} .tmebtn-primary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
                'default' => [
                    'top' => '15',
                    'right' => '20',
                    'bottom' => '15',
                    'left' => '20',
                    'isLinked' => false,
                ],
				'selectors' => [
                    '{{WRAPPER}} .tmebtn-primary a.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tmebtn-primary a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        $widget_id = $this->get_id();
        $settings = $this->get_settings_for_display();
        $order = $settings['order'];
		$orderby = $settings['orderby'];
		$max = $settings['max'];
		$categories = $settings['taxonomy'];
        $tags = $settings['tags'];
        $stock = $settings['stock'];

        $stock_array = array();
        $terms = array();
        $featured = array();
        $order_array = array();

        if ($stock == 'instock') {
            $stock_array = array(
                'meta_query' => array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock'
                    )
                )
            );
        } elseif ($stock == 'outofstock') {
            $stock_array = array(
                'meta_query' => array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'outofstock'
                    )
                )
            );
        }
        
        if ($settings['featured']) {
            $featured = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN'
            );
        } else {
            $featured = null;
        }

		if ($categories && $tags) {
			$terms = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $categories,
				),
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'term_id',
					'terms'    => $tags,
                ),
                $featured
			);
		} elseif ($categories) {
			$terms = array(
                'relation' => 'AND',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $categories,
                ),
                $featured
			);
		} elseif ($tags) {
			$terms = array(
                'relation' => 'AND',
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'term_id',
					'terms'    => $tags,
                ),
                $featured
			);
        } else {
            if (!empty($featured)) {
                $terms = array($featured);
            }
        }
        
        if ($settings['exclude']) {
            $exclude = $settings['exclude'];
        } else {
            $exclude = array();
		}
		
		if ($settings['include']) {
            $include = $settings['include'];
        } else {
            $include = array();
        }

        $base_array = array(
            'post_type' => 'product', 
            'post_status' => 'publish',
            'posts_per_page' => $max,
            'post__in' => $include,
            'post__not_in' => $exclude,
            'ignore_sticky_posts' => true,
            'tax_query' => $terms,
        );

        if ($orderby == 'popularity') {
            $order_array = array(
                'orderby' => 'meta_value_num',
                'meta_key' => 'total_sales',
                'meta_value_num' => 'DESC',
            );
        } elseif ($orderby == 'rating') {
            $order_array = array(
                'orderby' => 'meta_value_num',
                'meta_key' => '_wc_average_rating',
                'meta_value_num' => 'DESC',
            );
        } else {
            $order_array = array(
                'order' => $order,
                'orderby' => $orderby
            );
            if ($settings['onsale']) {
                $order_array = $order_array + array(
                    'meta_key' => '_sale_price',
                    'meta_value' => '0',
                    'meta_compare' => '>='
                );
            } 
        }

        $base_array = $base_array + $order_array;

        $custom_query = new WP_Query($base_array + $stock_array);
        ?>
        <div class="tmea-table-container" data-paging="<?php echo $settings['table_paging'] ? 'true' : 'false'; ?>" data-pagelength="<?php echo $settings['table_page_length']; ?>" data-info="<?php echo $settings['table_info'] ? 'true' : 'false'; ?>" data-searching="<?php echo $settings['table_searching'] ? 'true' : 'false'; ?>" data-ordering="<?php echo $settings['table_ordering'] ? 'true' : 'false'; ?>" data-buttons="<?php echo $settings['table_buttons'] ? 'true' : 'false'; ?>">
                <table id="tmea-table-<?php echo $widget_id; ?>" class="tmea-woocommerce-table tmea-table cell-border" style="width:100%;visibility:hidden;">
                <thead>
                    <tr>
                    <?php foreach ( $settings['column_list'] as $item ) { ?>
                        <th style="text-align:<?php echo $item['column_align']; ?>;"><?php echo $item['column_name']; ?></th>
                    <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while($custom_query->have_posts()) : $custom_query->the_post(); ?>
                    <tr>
                    <?php 
                    global $product;
                    foreach ( $settings['column_list'] as $item ) {
                        if ($item['column_source'] == 'thumbnail') {
                            $thumb_id = get_post_thumbnail_id();
                            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
                            $thumb_url = $thumb_url_array[0];
                            $img_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
                            $img_url = $img_url_array[0];
                            echo '<td style="text-align:' . $item['column_align'] . ';">';
                            if (!empty($thumb_url)) {
                                echo '<a href="' . $img_url . '" data-elementor-open-lightbox="default">';
                                echo '<img src="' . $thumb_url . '" />';
                                echo '</a>';
                            }
                            echo '</td>';
                        } elseif ($item['column_source'] == 'name') {
                            echo '<td style="text-align:' . $item['column_align'] . ';"><a class="tmea-table-link" href="' . get_the_permalink() . '">' . get_the_title() . '</a></td>';
                        } elseif ($item['column_source'] == 'price') {
                            $price = $product->get_price();
                            $price_string = wc_price($price);
                            echo '<td style="text-align:' . $item['column_align'] . ';">' . $price_string . '</td>';
                        } elseif ($item['column_source'] == 'sku') {
                            $sku = $product->get_sku();
                            echo '<td style="text-align:' . $item['column_align'] . ';">' . $sku . '</td>';
                        } elseif ($item['column_source'] == 'stock_quantity') {
                            $stock_quantity = $product->get_stock_quantity();
                            echo '<td style="text-align:' . $item['column_align'] . ';">' . $stock_quantity . '</td>';
                        } elseif ($item['column_source'] == 'stock') {
                            $stock = $product->get_stock_status();
                            $stock = str_replace( array('instock','outofstock'), array(esc_html__( 'In Stock', 'theme-masters-elementor' ),esc_html__( 'Out Of Stock', 'theme-masters-elementor' )), $stock );
                            echo '<td style="text-align:' . $item['column_align'] . ';">' . $stock . '</td>';
                        } elseif ($item['column_source'] == 'add_to_cart') {
                            $btn_shortcode = '[add_to_cart id="' . get_the_ID() . '" style="" show_price="false" class="tmebtn tmebtn-primary"]';
                            echo '<td style="text-align:' . $item['column_align'] . ';">' . do_shortcode($btn_shortcode) . '</td>';
                        }
                    } ?>
                    </tr>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </tbody>
                </table> 
        </div>
            <?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Woo_Table() );