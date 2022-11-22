<?php
namespace Elementor;

use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Sticky_Video extends Widget_Base {

	public function get_name() {
		return 'tme-sticy_video';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Sticky YouTube Video', 'theme-masters-elementor' );
	}
    
    public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-sticky_video' ];
    }

    public function get_script_depends(){
		return [ 'tme-sticky_video' ];
    }
    
    public function get_icon() {
		return 'eicon-youtube';
    }

    public function parse_yturl($url) 
    {
        $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, $url, $matches);
        return (isset($matches[1])) ? $matches[1] : false;
    }

	protected function register_controls() {
		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'youtube_url',
			[
				'label' => esc_html__( 'Video Link', 'theme-masters-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => esc_html__( 'Enter your URL', 'theme-masters-elementor' ) . ' (YouTube)',
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true
			]
		);

        $this->add_control(
			'aspect_ratio',
			[
				'label' => esc_html__( 'Aspect Ratio', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'169' => '16:9',
					'219' => '21:9',
					'43' => '4:3',
					'32' => '3:2',
					'11' => '1:1',
					'916' => '9:16',
				],
				'default' => '169'
			]
		);
        
        $this->end_controls_section();

		$this->start_controls_section(
			'sticky_settings_section',
			[
				'label' => esc_html__( 'Sticky Video', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_align',
			[
				'label' => esc_html__( 'Video Position', 'theme-masters-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'bottom-right' => esc_html__( 'Bottom Right', 'theme-masters-elementor' ),
					'bottom-left' => esc_html__( 'Bottom Left', 'theme-masters-elementor' ),
                    'top-right' => esc_html__( 'Top Right', 'theme-masters-elementor' ),
                    'top-left' => esc_html__( 'Top Left', 'theme-masters-elementor' ),
				],
				'default' => 'bottom-right'
			]
		);

		$this->add_responsive_control(
			'sticky_width',
			[
				'label' => esc_html__( 'Width (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 1,
				'default' => 480,
				'selectors' => [
					'{{WRAPPER}} .sticky-container_sticky .sticky-container__video' => 'width: {{VALUE}}px !important;'
				]
			]
		);

		$this->add_responsive_control(
			'sticky_height',
			[
				'label' => esc_html__( 'Height (px)', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 1,
				'default' => 270,
				'selectors' => [
					'{{WRAPPER}} .sticky-container_sticky .sticky-container__video' => 'height: {{VALUE}}px !important;'
				]
			]
		);

		$this->add_control(
			'sticky_zindex',
			[
				'label' => esc_html__( 'Z-index', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -9999999999,
				'max' => 9999999999,
				'step' => 1,
				'default' => 999,
				'selectors' => [
					'{{WRAPPER}} .sticky-container_sticky .sticky-container__video' => 'z-index: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
	
		 // section start
		 $this->start_controls_section(
			'section_sticky_video_style',
			[
				'label' => esc_html__( 'Sticky Video Container', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sticky_video_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .sticky-container_sticky .sticky-container__video'
			]
		);
        
        $this->add_control(
			'sticky_video_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .sticky-container_sticky .sticky-container__video' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sticky_video_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .sticky-container_sticky .sticky-container__video'
			]
		);

		$this->add_control(
			'sticky_video_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_responsive_control(
			'sticky_video_margin',
			[
				'label' => esc_html__( 'Margin', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .sticky-container_sticky .sticky-container__video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();
	
		 // section start
		 $this->start_controls_section(
			'section_sticky_iframe_style',
			[
				'label' => esc_html__( 'Iframe', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_iframe_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .sticky-container_sticky .sticky-container__video iframe' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sticky_iframe_border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .sticky-container_sticky .sticky-container__video iframe'
			]
		);

		$this->end_controls_section();

	}
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        ?>
        <div class="tme-sticky-video elementor-aspect-ratio-<?php echo esc_attr($settings['aspect_ratio']); ?>" data-playerid="tme-sticky-video-<?php echo esc_attr($widget_id); ?>">
            <div id="tme-sticky-video-<?php echo esc_attr($widget_id); ?>" class="elementor-fit-aspect-ratio tme-video-<?php echo esc_attr($settings['video_align']); ?>">
                <iframe class="elementor-video" src="https://www.youtube.com/embed/<?php echo esc_attr($this->parse_yturl($settings['youtube_url'])); ?>?rel=0&showinfo=0" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope" allowtransparency="false" allowfullscreen></iframe> 
            </div>
        </div>
<?php }
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Sticky_Video() );
?>

