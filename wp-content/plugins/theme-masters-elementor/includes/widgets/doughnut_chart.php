<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Widget_TMEA_Doughnut_Chart extends Widget_Base {

	public function get_name() {
		return 'tme-doughnut_chart';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Doughnut Chart', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_script_depends() {
		return [ 'tme-lib-chart', 'tme-doughnut_chart' ];
	}

	public function get_icon() {
		return 'eicon-number-field';
	}
    
	protected function register_controls() {

		// section start
  		$this->start_controls_section(
  			'bar_chart_content',
  			[
  				'label' => esc_html__( 'Bar Chart', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
  			]
          );
          
        $this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Type', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'doughnut',
				'options' => [
					'doughnut'  => esc_html__( 'Doughnut', 'theme-masters-elementor' ),
					'pie'  => esc_html__( 'Pie', 'theme-masters-elementor' )
				],
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
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 15
			]
        );

        $repeater->add_control(
			'item_bg',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.1)'
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
                        'item_label' => esc_html__( 'Data 1', 'theme-masters-elementor' ),
                        'item_data' => 15
					],
					[
                        'item_label' => esc_html__( 'Data 2', 'theme-masters-elementor' ),
                        'item_data' => 60
                    ],
                    [
                        'item_label' => esc_html__( 'Data 3', 'theme-masters-elementor' ),
                        'item_data' => 25
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
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#ffffff'
			]
        );

        $this->add_control(
			'border_width',
			[
                'label' => esc_html__( 'Border Width', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 999,
				'step' => 1,
				'default' => 2
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
                echo '<div class="tmea-doughnut-chart-data" style="display:none;" data-label="' . $item['item_label'] . '" data-value="' . $item['item_data'] . '" data-bgcolor="' . $item['item_bg'] . '"></div>';
            }
        }
        ?>
			<div class="tmea-doughnut-chart-container" style="width: 100%;" data-fontfamily="<?php echo esc_attr($settings['font_family']); ?>" data-layout="<?php echo $settings['layout']; ?>" data-lposition="<?php echo $settings['legend_position']; ?>" data-tdirection="<?php echo $direction; ?>" data-lcolor="<?php echo $settings['legend_color']; ?>" data-lbox="<?php echo $settings['legend_box_width']; ?>" data-lfontsize="<?php echo $settings['legend_font_size']; ?>" data-lpadding="<?php echo $settings['legend_padding']; ?>" data-tooltipcolor="<?php echo $settings['tooltip_color']; ?>" data-tooltipbg="<?php echo $settings['tooltip_bg']; ?>" data-tooltipfsize="<?php echo $settings['tooltip_font_size']; ?>" data-tooltippadding="<?php echo $settings['tooltip_padding']; ?>" data-tooltipradius="<?php echo $settings['tooltip_border_radius']; ?>" data-tooltipboxes="<?php echo $settings['tooltip_boxes']; ?>" data-tooltipalign="<?php echo $settings['tooltip_text_align']; ?>" data-tooltiptmargin="<?php echo $settings['tooltip_title_margin']; ?>" data-bordercolor="<?php echo $settings['border_color']; ?>" data-borderwidth="<?php echo $settings['border_width']; ?>">
		        <canvas id="tmea-doughnut-chart-<?php echo $widget_id; ?>" class="tmea-doughnut-chart"></canvas>
	        </div>
	<?php
    } 

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Doughnut_Chart() );