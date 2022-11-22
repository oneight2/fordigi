<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Radar_Chart extends Widget_Base {

	public function get_name() {
		return 'tme-radar_chart';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Radar Chart', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-chart', 'tme-radar_chart' ];
	}

	public function get_icon() {
		return 'eicon-number-field';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'radar_chart_content',
  			[
  				'label' => esc_html__( 'Radar Chart', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
        );
        
        $this->add_control(
			'labels',
			[
                'label' => esc_html__( 'Labels', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Write multiple label with comma (,) separator.', 'theme-masters-elementor' ),
                'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'January, February, March'
			]
        );
        
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'item_label',
			[
                'label' => esc_html__( 'Label', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Dataset 1', 'theme-masters-elementor' ),
			]
        );

        $repeater->add_control(
			'item_data',
			[
                'label' => esc_html__( 'Data', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Write data values with comma (,) separator.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '100, 70, -30'
			]
        );

        $repeater->add_control(
			'item_point_style',
			[
				'label' => esc_html__( 'Point Style', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle'  => esc_html__( 'Circle', 'theme-masters-elementor' ),
                    'cross'  => esc_html__( 'Cross', 'theme-masters-elementor' ),
                    'crossRot'  => esc_html__( 'Cross Rotated', 'theme-masters-elementor' ),
                    'dash'  => esc_html__( 'Dash', 'theme-masters-elementor' ),
                    'line'  => esc_html__( 'Line', 'theme-masters-elementor' ),
                    'rect'  => esc_html__( 'Rectangle', 'theme-masters-elementor' ),
                    'rectRounded'  => esc_html__( 'Rounded Rectangle', 'theme-masters-elementor' ),
                    'rectRot'  => esc_html__( 'Rotated Rectangle', 'theme-masters-elementor' ),
                    'star'  => esc_html__( 'Star', 'theme-masters-elementor' ),
                    'triangle'  => esc_html__( 'Triangle', 'theme-masters-elementor' )
				],
			]
        );

        $repeater->add_control(
			'item_point_size',
			[
                'label' => esc_html__( 'Point Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 99,
				'step' => 1,
				'default' => 5
			]
        );

        $repeater->add_control(
			'item_point_color',
			[
				'label' => esc_html__( 'Point Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 99, 132, 1)'
			]
        );

        $repeater->add_control(
			'item_style',
			[
				'label' => esc_html__( 'Line Style', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'Filled',
				'options' => [
					'Unfilled'  => esc_html__( 'Unfilled', 'theme-masters-elementor' ),
                    'Filled'  => esc_html__( 'Filled', 'theme-masters-elementor' ),
                    'Dashed'  => esc_html__( 'Dashed', 'theme-masters-elementor' )
				],
			]
        );

        $repeater->add_control(
			'item_border_width',
			[
                'label' => esc_html__( 'Line Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 99,
				'step' => 1,
				'default' => 1
			]
		);
        
        $repeater->add_control(
			'item_border',
			[
				'label' => esc_html__( 'Line Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 99, 132, 1)'
			]
        );
        
        $repeater->add_control(
			'item_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 99, 132, 0.5)'
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
						'item_label' => esc_html__( 'Dataset 1', 'theme-masters-elementor' ),
						'item_data' => '50, 30, 70'
					],
					[
						'item_label' => esc_html__( 'Dataset 2', 'theme-masters-elementor' ),
						'item_data' => '90, 70, 30'
					],
					[
						'item_label' => esc_html__( 'Dataset 3', 'theme-masters-elementor' ),
						'item_data' => '20, 45, 25'
					],
				],
				'title_field' => '{{{ item_label }}}',
			]
		);
		
		$this->end_controls_section();  

		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'font_family',
			[
				'label' => esc_html__( 'Font Family', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '"Helvetica Neue", "Helvetica", "Arial", sans-serif',
				'options' => [
					'"Helvetica Neue", "Helvetica", "Arial", sans-serif'  => esc_html__( 'Helvetica Neue', 'theme-masters-elementor' ),
					'Georgia, serif'  => esc_html__( 'Georgia', 'theme-masters-elementor' ),
					'"Palatino Linotype", "Book Antiqua", Palatino, serif'  => esc_html__( 'Palatino Linotype', 'theme-masters-elementor' ),
					'"Times New Roman", Times, serif'  => esc_html__( 'Times New Roman', 'theme-masters-elementor' ),
                    'Arial, Helvetica, sans-serif'  => esc_html__( 'Arial', 'theme-masters-elementor' ),
                    '"Arial Black", Gadget, sans-serif'  => esc_html__( 'Arial Black', 'theme-masters-elementor' ),
                    '"Comic Sans MS", cursive, sans-serif'  => esc_html__( 'Comic Sans', 'theme-masters-elementor' ),
					'Impact, Charcoal, sans-serif'  => esc_html__( 'Impact', 'theme-masters-elementor' ),
					'"Lucida Sans Unicode", "Lucida Grande", sans-serif'  => esc_html__( 'Lucida Sans', 'theme-masters-elementor' ),
					'Tahoma, Geneva, sans-serif'  => esc_html__( 'Tahoma', 'theme-masters-elementor' ),
					'"Trebuchet MS", Helvetica, sans-serif'  => esc_html__( 'Trebuchet', 'theme-masters-elementor' ),
					'Verdana, Geneva, sans-serif'  => esc_html__( 'Verdana', 'theme-masters-elementor' ),
					'"Courier New", Courier, monospace'  => esc_html__( 'Courier New', 'theme-masters-elementor' ),
					'"Lucida Console", Monaco, monospace'  => esc_html__( 'Lucida Console', 'theme-masters-elementor' )
				],
			]
		);
		
		$this->add_control(
			'font_size',
			[
                'label' => esc_html__( 'Font Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 12
			]
		);

		$this->add_control(
			'font_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#252525'
			]
        );

        $this->end_controls_section();  

		$this->start_controls_section(
			'section_legend_style',
			[
				'label' => esc_html__( 'Legend', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
			'legend_position',
			[
				'label' => esc_html__( 'Position', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
                    'top'  => esc_html__( 'Top', 'theme-masters-elementor' ),
                    'left'  => esc_html__( 'Left', 'theme-masters-elementor' ),
                    'bottom'  => esc_html__( 'Bottom', 'theme-masters-elementor' ),
                    'right'  => esc_html__( 'Right', 'theme-masters-elementor' )
				],
			]
		);

        $this->add_control(
			'legend_box_width',
			[
                'label' => esc_html__( 'Box Width', 'theme-masters-elementor' ),
                'description' => esc_html__( 'Width of coloured box.', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 40
			]
        );
        
        $this->add_control(
			'legend_font_size',
			[
                'label' => esc_html__( 'Font Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 12
			]
		);

        $this->add_control(
			'legend_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#cc0000'
			]
        );

        $this->add_control(
			'legend_padding',
			[
                'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 10
			]
		);

		$this->end_controls_section();  

		$this->start_controls_section(
			'section_gridline_style',
			[
				'label' => esc_html__( 'Gridlines', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'gridline',
			[
				'label' => esc_html__( 'Display Gridlines', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'Yes', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'No', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'true',
				'toggle' => false,
			]
		);

		$this->add_control(
			'gridline_circular',
			[
				'label' => esc_html__( 'Circular', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'Yes', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'No', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'true',
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'gridline_color',
			[
				'label' => esc_html__( 'Line Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.1)'
			]
		);
		
		$this->add_control(
			'gridline_border_width',
			[
                'label' => esc_html__( 'Line Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 99,
				'step' => 1,
				'default' => 1
			]
		);
        
        $this->end_controls_section();  

		$this->start_controls_section(
			'section_tooltip_style',
			[
				'label' => esc_html__( 'Tooltip', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tooltip_text_align',
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
			]
		);

		$this->add_control(
			'tooltip_font_size',
			[
                'label' => esc_html__( 'Font Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 12
			]
		);
		
		$this->add_control(
			'tooltip_color',
			[
				'label' => esc_html__( 'Font Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 1)'
			]
		);
		
		$this->add_control(
			'tooltip_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.8)'
			]
		);
		
		$this->add_control(
			'tooltip_padding',
			[
                'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 10
			]
		);

		$this->add_control(
			'tooltip_border_radius',
			[
                'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 10
			]
		);

		$this->add_control(
			'tooltip_boxes',
			[
				'label' => esc_html__( 'Display Color Boxes', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'true' => [
						'title' => esc_html__( 'Yes', 'theme-masters-elementor' ),
						'icon' => 'fas fa-check',
					],
					'false' => [
						'title' => esc_html__( 'No', 'theme-masters-elementor' ),
						'icon' => 'fas fa-times',
					],
				],
				'default' => 'true',
				'toggle' => false,
			]
		);
		
		$this->add_control(
			'tooltip_title_margin',
			[
                'label' => esc_html__( 'Title Margin Bottom', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 6
			]
		);
        
        $this->end_controls_section();
  
	}

	/**
	 * Render 
	 */
	protected function render( ) {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        if (is_rtl()) {
            $rtl = 'true';
            $direction = 'rtl';
        } else {
            $rtl = 'false';
            $direction = 'ltr';
        }
        if ( $settings['list'] ) {
            foreach ( $settings['list'] as $item ) { 
                echo '<div class="tmea-radar-chart-data" style="display:none;" data-label="' . $item['item_label'] . '" data-value="' . $item['item_data'] . '" data-bgcolor="' . $item['item_bg'] . '" data-bcolor="' . $item['item_border'] . '" data-lstyle="' . $item['item_style'] . '" data-lbwidth="' . $item['item_border_width'] . '" data-pointsize="' . $item['item_point_size'] . '" data-pointstyle="' . $item['item_point_style'] . '" data-pointcolor="' . $item['item_point_color'] . '"></div>';
            }
        }
        ?>
			<div class="tmea-radar-chart-container" style="width: 100%;"  data-fontfamily="<?php echo esc_attr($settings['font_family']); ?>" data-fcolor="<?php echo $settings['font_color']; ?>" data-fsize="<?php echo $settings['font_size']; ?>" data-labels="<?php echo $settings['labels']; ?>" data-lposition="<?php echo $settings['legend_position']; ?>" data-tdirection="<?php echo $direction; ?>" data-lcolor="<?php echo $settings['legend_color']; ?>" data-lbox="<?php echo $settings['legend_box_width']; ?>" data-lfontsize="<?php echo $settings['legend_font_size']; ?>" data-lpadding="<?php echo $settings['legend_padding']; ?>" data-tooltipcolor="<?php echo $settings['tooltip_color']; ?>" data-tooltipbg="<?php echo $settings['tooltip_bg']; ?>" data-tooltipfsize="<?php echo $settings['tooltip_font_size']; ?>" data-tooltippadding="<?php echo $settings['tooltip_padding']; ?>" data-tooltipradius="<?php echo $settings['tooltip_border_radius']; ?>" data-tooltipboxes="<?php echo $settings['tooltip_boxes']; ?>" data-tooltipalign="<?php echo $settings['tooltip_text_align']; ?>" data-tooltiptmargin="<?php echo $settings['tooltip_title_margin']; ?>" data-gridline="<?php echo $settings['gridline']; ?>" data-gcolor="<?php echo $settings['gridline_color']; ?>" data-gwidth="<?php echo $settings['gridline_border_width']; ?>" data-circular="<?php echo $settings['gridline_circular']; ?>">
		        <canvas id="tmea-radar-chart-<?php echo $widget_id; ?>" class="tmea-radar-chart"></canvas>
	        </div>
	<?php
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Radar_Chart() );