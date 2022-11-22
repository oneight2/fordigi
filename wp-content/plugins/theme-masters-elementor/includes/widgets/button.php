<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_TMEA_Button extends Widget_Base {

	public function get_name() {
		return 'tme-button';
	}

	public function get_title() {
		return "[TM] " . esc_html__( 'Button', 'theme-masters-elementor' );
	}

	public function get_categories() {
		return [ 'theme-masters-elementor' ];
	}
    
    public function get_style_depends(){
		return [ 'tme-button' ];
	}
    
    public function get_icon() {
		return 'eicon-button';
	}
    
    public function get_btn_skins() {
        $output_skins = apply_filters('tme-btn-skins', array( 
            '' => esc_html__( 'None', 'theme-masters-elementor' ),
            'tme-btn-1' => esc_html__( 'Animation 1', 'theme-masters-elementor' ),
            'tme-btn-2' => esc_html__( 'Animation 2', 'theme-masters-elementor' ),
            'tme-btn-3' => esc_html__( 'Animation 3', 'theme-masters-elementor' ),
            'tme-btn-4' => esc_html__( 'Animation 4', 'theme-masters-elementor' ),
            'tme-btn-5' => esc_html__( 'Animation 5', 'theme-masters-elementor' ),
            'tme-btn-6' => esc_html__( 'Animation 6', 'theme-masters-elementor' ),
            'tme-btn-7' => esc_html__( 'Animation 7', 'theme-masters-elementor' ),
            'tme-btn-8' => esc_html__( 'Animation 8', 'theme-masters-elementor' ),
            
        ));
        return $output_skins;
    }

	protected function register_controls() {
        // section start
		$this->start_controls_section(
			'button_content',
			[
				'label' => esc_html__( 'Settings', 'theme-masters-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'text', [
				'label' => esc_html__( 'Text', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);
        
        $this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'tme-btn-md',
				'options' => [
					'tme-btn-md'  => esc_html__( 'Normal', 'theme-masters-elementor' ),
					'tme-btn-lg'  => esc_html__( 'Large', 'theme-masters-elementor' ),
                    'tme-btn-sm'  => esc_html__( 'Small', 'theme-masters-elementor' )
				],
			]
		);
        
        $this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'theme-masters-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper' => 'text-align: {{VALUE}};'
				],
				'toggle' => true,
			]
		);
        
        $this->add_control(
			'icon_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        
        $this->add_control(
			'icon_switcher',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'theme-masters-elementor' ),
				'label_off' => esc_html__( 'No', 'theme-masters-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
        
        $this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'show_label' => false,
                'condition' => ['icon_switcher' => 'yes'],
			]
		);
        
        $this->add_control(
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'after'  => esc_html__( 'After', 'theme-masters-elementor' ),
					'before'  => esc_html__( 'Before', 'theme-masters-elementor' )
				],
                'condition' => ['icon_switcher' => 'yes'],
			]
		);
        
        $this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Icon Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-btn-wrapper a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
                'condition' => ['icon_switcher' => 'yes'],
			]
		);
        
        $this->add_control(
			'btn_heading_1',
			[
				'label' => esc_html__( 'Link to', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->start_controls_tabs( 'tabs_btn_link_style' );
        
        $this->start_controls_tab(
			'tab_btn_link',
			[
				'label' => esc_html__( 'URL', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'website_link',
			[
				'label' => esc_html__( 'Link to', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://www.thememasters.club', 'theme-masters-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
                'dynamic' => [
					'active' => true,
				],
                'show_label' => false,
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_lightbox',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
			]
		);

        $this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'show_label' => false,
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_control(
			'btn_heading_3',
			[
				'label' => esc_html__( 'Button ID', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
			'btn_id',
			[
				'label' => esc_html__( 'Button ID', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows A-Z 0-9  & underscore chars without spaces.', 'theme-masters-elementor' ),
                'dynamic' => [
					'active' => true,
				],
                'show_label' => false,
                'label_block' => true
			]
		);
       
		$this->end_controls_section();
        
        // section start
		$this->start_controls_section(
			'section_btn_style',
			[
				'label' => esc_html__( 'Button', 'theme-masters-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a',
			]
		);
        
        $this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a',
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => esc_html__( 'Animation', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_btn_skins(),
			]
		);
        
        $this->add_control(
			'btn_hr_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);  
        
        $this->start_controls_tabs( 'tabs_button_style' );
        
        $this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a' => 'color: {{VALUE}};',
				]
			]
		);
        
        $this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a',
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a'
			]
		);
        
        $this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a,{{WRAPPER}} .tme-btn-wrapper a:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a'
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-btn-wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'theme-masters-elementor' ),
			]
		);
        
        $this->add_control(
			'text_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control(
			'bg_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_hover_gradient',
				'label' => esc_html__( 'Background', 'theme-masters-elementor' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a:hover',
			]
		);
        
        $this->add_control(
			'animation_color',
			[
				'label' => esc_html__( 'Animation Color', 'theme-masters-elementor' ),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:before' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'hover_border',
				'label' => esc_html__( 'Border', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a:hover'
			]
		);
        
        $this->add_responsive_control(
			'border_hover_radius',
			[
				'label' => esc_html__( 'Border Radius', 'theme-masters-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a:hover,{{WRAPPER}} .tme-btn-wrapper a:hover:before' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};border-bottom-left-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'border_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'theme-masters-elementor' ),
				'selector' => '{{WRAPPER}} .tme-btn-wrapper a:hover'
			]
		);

		$this->add_responsive_control(
			'padding_hover',
			[
				'label' => esc_html__( 'Padding', 'theme-masters-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
                    '{{WRAPPER}} .tme-btn-wrapper a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
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
			'btn_width',
			[
				'label' => esc_html__( 'Button Width', 'theme-masters-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .tme-btn-wrapper a' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);
        
        $this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings_for_display();
		$target = $settings['website_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['website_link']['nofollow'] ? ' rel="nofollow"' : '';
        $icon_position = $settings['icon_position'];
        ?>
        <?php if ($settings['image']['url']) { ?>
        <div class="tme-btn-wrapper">
            <a id="<?php echo esc_attr($settings['btn_id']); ?>" data-elementor-open-lightbox="yes" class="<?php echo esc_attr($settings['size']); ?> <?php echo esc_attr($settings['skin']); ?>" href="<?php echo esc_url($settings['image']['url']); ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?>>
				<?php 
				if ($settings['icon_switcher']) {
					if ($icon_position == 'before') {
						\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
						echo esc_html($settings['text']);
					} else {
						echo esc_html($settings['text']); 
						\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
					}
				} else {
					echo esc_html($settings['text']);
				} 
				?>
            </a>
        </div>
        <?php } else { ?>
        <div class="tme-btn-wrapper">
            <a id="<?php echo esc_attr($settings['btn_id']); ?>" class="<?php echo esc_attr($settings['size']); ?> <?php echo esc_attr($settings['skin']); ?>" href="<?php echo esc_url($settings['website_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>>
				<?php 
				if ($settings['icon_switcher']) {
					if ($icon_position == 'before') {
						\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
						echo esc_html($settings['text']);
					} else {
						echo esc_html($settings['text']); 
						\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
					}
				} else {
					echo esc_html($settings['text']);
				} 
				?>
            </a>
        </div>
        <?php } ?>
<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TMEA_Button() );