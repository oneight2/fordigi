<?php

defined('ABSPATH') || exit;

class wpda_org_chart_library {

	/*############ Function for creating the admin tabs ##################*/	

	public static function create_tab($tab_titles, $tab_contents, $options = array()) {
		$tab_html = '';
		$standard_options = array(
			'theme' => 'wpda_blue',
			'title' => '',
		);

		$options = array_merge($standard_options, $options);
		// check if contents count and tabs count equal
		if (!is_array($tab_titles) || !is_array($tab_titles) || (count($tab_titles) != count($tab_contents) && count($tab_contents) != 0)) {
			$tab_html = '<div class="wpda_error">Tab creator error!</div>';
			return $tab_html;
		}
		$tab_html .= '<div class="wpda_tab_container ' . $options['theme'] . '">';
		$tab_html .= $options['title'] != '' ? '<h3>' . $options['title'] . '</h3>' : '';
		$tab_html .= '<div class="wpda_links_container">';
		$tab_html .= '<ul>';
		foreach ($tab_titles as $tab_title) {
			$tab_html .= '<li>' . $tab_title . '</li>';
		}
		$tab_html .= '</ul>';
		$tab_html .= '<div></div></div>';
		$tab_html .= '<div class="wpda_contents_container">';
		foreach ($tab_contents as $tab_content) {
			$tab_html .= '<div>' . $tab_content . '</div>';
		}
		$tab_html .= '</div>';
		$tab_html .= '</div>';
		return $tab_html;
	}

	/*############ Function for creating the settings ##################*/	
	
	public static function create_setting($args) {
		$html = '';
		$fn = $args['function_name'];
		if (is_callable('self::' . $fn)) {
			$html = self::$fn($args);
		}
		return $html;
	}
	// Return the HTML for option description
	public static function gen_desc_panel($args) {
		$html = '';
		$pro = '';
		if ((isset($args["pro"]) && $args["pro"] === true)) {
			$pro = '<span class="wpda_pro_feature">(pro)</span>';
		}
		$html .= '<div class="wpda_option_description">';
		$html .= '<span class="wpda_desc_title">' . $args['title'] . $pro . '</span>';

		if (isset($args['description']) && $args['description'] != "") {
			$html .= '<span class="wpda_info_container">?<span class="wpda_info">' . $args['description'] . '</span></span>';
		}
		$html .= '</div>';
		return $html;
	}
	// Return the HTML for simple input
	public static function simple_input($args) {
		$html = '';
		$pro_class = '';
		$show_when = array('class' => '', 'attr' => '');
		if ((isset($args["pro"]) && $args["pro"] === true)) {
			$pro_class = 'wpda_pro_option';
		}
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$html .= '<div ' . $show_when['attr'] . ' class="wpda_option wpda_simple_input ' . $show_when['class'] . '">';
		$html .= self::gen_desc_panel($args);
		$html .= '<div class="' . $pro_class . '">';
		$html .= self::input($args);
		$html .= '</div></div>';
		return $html;
	}
	// Return the HTML for margin padding inputs
	public static function margin_padding_input($args) {
		$html = '';
		$pro_class = '';
		if ((isset($args["pro"]) && $args["pro"] === true)) {
			$pro_class = 'wpda_pro_option';
		}
		$html .= '<div class="wpda_option wpda_margin_padding_input">';
		$html .= self::gen_desc_panel($args);
		$html .= '<div class="wpda_margin_padding_inputs_container ' . $pro_class . '">';
		$html .= self::margin_padding_inputs_helper($args);
		$html .= '</div></div>';
		return $html;
	}

	/*############ Function for the inputs ##################*/	
	
	public static function input($args) {
		$html = '';
		$size = '';
		$preview = array('class' => '', 'attr' => '');
		if (isset($args['preview'])) {
			$preview['attr'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action'] . '"';
			$preview['class'] = 'with_preview';
		}
		if (isset($args['size'])) {
			$size = 'size="' . $args['size'] . '"';
		}
		$metric = [];
		$metric['desktop'] = '';
		$metric['tablet'] = '';
		$metric['mobile'] = '';
		$disabled = '';

		// if isset metric for this input make a metric select box
		if (isset($args['metric'])) {
			if (count($args['metric']) == 1) {
				$disabled = 'disabled';
			}
			$metric_desktop_value = isset($args['value']['metric_desktop']) ? $args['value']['metric_desktop'] : '';
			$metric['desktop'] .= '<select ' . $disabled . ' class="wpda_input_metric metric_desktop" name="' . $args['name'] . '[metric_desktop]">';
			for ($i = 0; $i < count($args['metric']); $i++) {
				$metric['desktop'] .= '<option value="' . $args['metric'][$i] . '" ' . selected($args['metric'][$i], $metric_desktop_value, false) . '>' . $args['metric'][$i] . '</option>';
			}
			$metric['desktop'] .= '</select>';
			$metric_tablet_value = isset($args['value']['metric_tablet']) ? $args['value']['metric_tablet'] : '';
			$metric['tablet'] .= '<select ' . $disabled . ' class="wpda_input_metric metric_tablet" name="' . $args['name'] . '[metric_tablet]">';
			for ($i = 0; $i < count($args['metric']); $i++) {
				$metric['tablet'] .= '<option value="' . $args['metric'][$i] . '" ' . selected($args['metric'][$i], $metric_tablet_value, false) . '>' . $args['metric'][$i] . '</option>';
			}
			$metric['tablet'] .= '</select>';
			$metric_mobile_value = isset($args['value']['metric_mobile']) ? $args['value']['metric_mobile'] : '';
			$metric['mobile'] .= '<select ' . $disabled . ' class="wpda_input_metric metric_mobile" name="' . $args['name'] . '[metric_mobile]">';
			for ($i = 0; $i < count($args['metric']); $i++) {
				$metric['mobile'] .= '<option value="' . $args['metric'][$i] . '" ' . selected($args['metric'][$i], $metric_mobile_value, false) . '>' . $args['metric'][$i] . '</option>';
			}
			$metric['mobile'] .= '</select>';
		}
		$responsive_before = '';
		$responsive_after  = '';
		$responsive_checkbox = '';
		$second_input = '';
		$third_input = '';
		$small_text = '';
		if (isset($args['small_text']) && $args['small_text'] != '') {
			$small_text .= '<small>' . $args['small_text'] . '</small>';
		}
		// if isset responsive for this input make a another 2 inputs for and checkbox for show its
		if (isset($args['responsive'])) {
			$responsive_before .= '<div class="responsive_elements_coneitner">';
			$responsive_after .= '</div>';
			$responsive_checkbox .= '<select class="dashicons wpda_responsive_select" name="' . $args['name'] . '[responsive]">';
			$responsive_checkbox .= '<option value="desktop">&#xf472;</option>';
			$responsive_checkbox .= '<option value="tablet">&#xf471;</option>';
			$responsive_checkbox .= '<option value="mobile">&#xf470;</option>';
			$responsive_checkbox .= '</select>';
			$second_input = $responsive_before . '<input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['tablet'] . '" ' . $size . ' name="' . $args['name'] . '[tablet]">' . $metric['tablet'] . $small_text . $responsive_after;

			$third_input = $responsive_before . '<input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['mobile'] . '" ' . $size . ' name="' . $args['name'] . '[mobile]" >' . $metric['mobile'] . $small_text . $responsive_after;
		}
		$html .= $responsive_checkbox . $responsive_before . '<input class="' . $preview['class'] . '" ' . $preview['attr'] . ' type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['desktop'] . '" ' . $size . ' id="' . $args['name'] . '" name="' . $args['name'] . '[desktop]">' . $metric['desktop'] . $small_text . $responsive_after . $second_input . $third_input;
		return $html;
	}

	/*############ Function for the margin and padding settings ##################*/	
	
	public static function margin_padding_inputs_helper($args) {
		$html = '';
		$preview = array('class' => '', 'attr' => array('left' => '', 'right' => '', 'top' => '', 'bottom' => ''));
		if (isset($args['preview']) && isset($args['preview']['action']['left']) && isset($args['preview']['action']['right']) && isset($args['preview']['action']['top']) && isset($args['preview']['action']['bottom'])) {
			$preview['attr']['left'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action']['left'] . '"';
			$preview['attr']['right'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action']['right'] . '"';
			$preview['attr']['top'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action']['top'] . '"';
			$preview['attr']['bottom'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action']['bottom'] . '"';

			$preview['class'] = 'with_preview';
		}
		$metric = [];
		$metric['desktop'] = '';
		$metric['tablet'] = '';
		$metric['mobile'] = '';
		$disabled = '';
		// if isset metric for this input make a metric select box
		if (isset($args['metric'])) {
			if (count($args['metric']) == 1) {
				$disabled = 'disabled';
			}
			$metric_desktop_value = isset($args['value']['metric_desktop']) ? $args['value']['metric_desktop'] : '';
			$metric['desktop'] .= '<select ' . $disabled . ' class="wpda_input_metric metric_desktop" name="' . $args['name'] . '[metric_desktop]">';
			for ($i = 0; $i < count($args['metric']); $i++) {
				$metric['desktop'] .= '<option value="' . $args['metric'][$i] . '" ' . selected($args['metric'][$i], $metric_desktop_value, false) . '>' . $args['metric'][$i] . '</option>';
			}
			$metric['desktop'] .= '</select>';

			$metric_tablet_value = isset($args['value']['metric_tablet']) ? $args['value']['metric_tablet'] : '';
			$metric['tablet'] .= '<select ' . $disabled . ' class="wpda_input_metric metric_tablet" name="' . $args['name'] . '[metric_tablet]">';
			for ($i = 0; $i < count($args['metric']); $i++) {
				$metric['tablet'] .= '<option value="' . $args['metric'][$i] . '" ' . selected($args['metric'][$i], $metric_tablet_value, false) . '>' . $args['metric'][$i] . '</option>';
			}
			$metric['tablet'] .= '</select>';

			$metric_mobile_value = isset($args['value']['metric_mobile']) ? $args['value']['metric_mobile'] : '';
			$metric['mobile'] .= '<select ' . $disabled . ' class="wpda_input_metric metric_mobile" name="' . $args['name'] . '[metric_mobile]">';
			for ($i = 0; $i < count($args['metric']); $i++) {
				$metric['mobile'] .= '<option value="' . $args['metric'][$i] . '" ' . selected($args['metric'][$i], $metric_mobile_value, false) . '>' . $args['metric'][$i] . '</option>';
			}
			$metric['mobile'] .= '</select>';
		}
		$responsive_before = '';
		$responsive_after  = '';
		$responsive_checkbox = '';
		$second_input = '';
		$third_input = '';
		// if isset responsive for this input make a another 2 inputs for and checkbox for show its
		if (isset($args['responsive'])) {
			$responsive_before .= '<div class="responsive_elements_coneitner">';
			$responsive_after .= '</div>';
			$responsive_checkbox .= '<select class="dashicons wpda_responsive_select" name="' . $args['name'] . '[responsive]">';
			$responsive_checkbox .= '<option value="desktop">&#xf472;</option>';
			$responsive_checkbox .= '<option value="tablet">&#xf471;</option>';
			$responsive_checkbox .= '<option value="mobile">&#xf470;</option>';
			$responsive_checkbox .= '</select>';
			$top_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['tablet_top'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[tablet_top]"><span>Top</span></span>';
			$right_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['tablet_right'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[tablet_right]"><span>Right</span></span>';
			$bottom_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['tablet_bottom'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[tablet_bottom]"><span>Bottom</span></span>';
			$left_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['tablet_left'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[tablet_left]"><span>Left</span></span>';

			$second_input = $responsive_before . $top_input . $right_input . $bottom_input . $left_input . $metric['tablet'] . $responsive_after;

			$top_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['mobile_top'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[mobile_top]"><span>Top</span></span>';
			$right_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['mobile_right'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[mobile_right]"><span>Right</span></span>';
			$bottom_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['mobile_bottom'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[mobile_bottom]"><span>Bottom</span></span>';
			$left_input = '<span><input type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['mobile_left'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[mobile_left]"><span>Left</span></span>';

			$third_input = $responsive_before . $top_input . $right_input . $bottom_input . $left_input . $metric['mobile'] . $responsive_after;
		}
		$top_input = '<span><input class="' . $preview['class'] . '" ' . $preview['attr']['top'] . ' type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['desktop_top'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[desktop_top]"><span>Top</span></span>';
		$right_input = '<span><input class="' . $preview['class'] . '" ' . $preview['attr']['right'] . ' type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['desktop_right'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[desktop_right]"><span>Right</span></span>';
		$bottom_input = '<span><input class="' . $preview['class'] . '" ' . $preview['attr']['bottom'] . ' type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['desktop_bottom'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[desktop_bottom]"><span>Bottom</span></span>';
		$left_input = '<span><input class="' . $preview['class'] . '" ' . $preview['attr']['left'] . ' type="' . (isset($args['type']) ? $args['type'] : 'text') . '" value="' . $args['value']['desktop_left'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '[desktop_left]"><span>Left</span></span>';
		$html .= $responsive_checkbox . $responsive_before . $top_input . $right_input . $bottom_input . $left_input . $metric['desktop'] . $responsive_after . $second_input . $third_input;
		return $html;
	}
	// return html for radio
	public static function radio($args) {
		$html = '';
		$show_when = array('class' => '', 'attr' => '');
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$current_value = $args['value'];
		$counter = 0;
		$html .= '<div class="wpda_option wpda_radio' . $show_when['class'] . '"' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div>';
		$html .= '<div class="switch-field">';
		foreach ($args['values'] as $key => $value) {
			$counter++;
			$html .= '<input type="radio"  name="' . $args['name'] . '" id="' . $args['name'] . '_' . $counter . '" value="' . $key . '" ' . checked($key, $current_value, false) . ' />';
			$html .= '<label for="' . $args['name'] . '_' . $counter . '">' . $value . '</label>';
		}
		$html .= '</div></div></div>';
		return $html;
	}
	// return html for checkbox
	public static function checkbox($args) {
		$html = '';
		$show_when = array('class' => '', 'attr' => '');
		$draggable = array('class' => '', 'attr' => '');
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}

		if (isset($args['draggable']) && $args['draggable'] == true) {
			$draggable['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$draggable['class'] = ' condition_element';
		}
		$current_value = $args['value'];
		$counter = 0;
		$html .= "\r\n" . '<div class="wpda_option wpda_checkbox' . $show_when['class'] . '"' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div>';
		foreach ($args['values'] as $key => $value) {
			$counter++;
			if (isset($current_value[$key])) {
				$current_value[$key] = true;
			} else {
				$current_value[$key] = false;
			}
			$html .= '<div>';
			$html .= '<input type="checkbox"  name="' . $args['name'] . '[' . $key . ']" id="' . $args['name'] . '_' . $counter . '" value="' . $key . '" ' . checked(true, $current_value[$key], false) . ' />';
			$html .= '<label for="' . $args['name'] . '_' . $counter . '">' . $value . '</label>';
			$html .= '</div>';
		}
		$html .= '</div></div>' . "\r\n";
		return $html;
	}
	// return color input with gradient
	public static function gradient_color_input($args) {
		$html = '';
		$transparent = '';
		$show_when = array('class' => '', 'attr' => '');
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		if (isset($args['transparent'])) {
			$transparent = 'data-alpha="true"';
		}
		$html .= '<div class="wpda_option wpda_color_gradient' . $show_when['class'] . '"' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div>';
		$html .= '<input type="text" class="color" ' . $transparent . ' value="' . (isset($args['value']['color1']) ? $args['value']['color1'] : "") . '" data-default-color="' . (isset($args['value']['color1']) ? $args['value']['color1'] : "") . '" id="' . $args['name'] . '_color1" name="' . $args['name'] . '[color1]">';
		$html .= '<input type="text" class="color" ' . $transparent . ' value="' . (isset($args['value']['color2']) ? $args['value']['color2'] : "") . '" data-default-color="' . (isset($args['value']['color2']) ? $args['value']['color2'] : "") . '" id="' . $args['name'] . '_color2" name="' . $args['name'] . '[color2]">';
		$grad_dir = self::gradient_directions();
		$html .= '<select id="' . $args['name'] . '_select_grad" name="' . $args['name'] . '[gradient]">';
		for ($i = 0; $i < count($grad_dir); $i++) {
			$html .= '<option ' . selected(isset($args['value']['gradient']) && $args['value']['gradient'] == $grad_dir[$i]['key'], true, false) . ' value="' . $grad_dir[$i]['key'] . '">' . $grad_dir[$i]['val'] . '</option>';
		}
		$html .= '</select></div></div>';
		return $html;
	}
	// return range input
	public static function range_input($args) {
		$html = '';
		$preview = array('class' => '', 'attr' => '');
		$show_when = array('class' => '', 'attr' => '');

		if (isset($args['preview'])) {
			$preview['attr'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action'] . '"';
			$preview['class'] = 'with_preview';
		}
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$html .= '<div class="wpda_option wpda_range_input' . $show_when['class'] . '" ' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div>';
		$html .= '<input class="' . $preview['class'] . '" ' . $preview['attr'] . ' type="range" id="' . $args['name'] . '" name="' . $args['name'] . '" value="' . $args['value'] . '" ' . ((isset($args['min_value'])) ? ('min="' . $args['min_value'] . '"') : '') . " " . ((isset($args['max_value'])) ? ('max="' . $args['max_value'] . '"') : '') . '/>';
		if (isset($args['show_val']) && $args['show_val'] == true) {
			$html .= '<output id="' . $args['name'] . '_connect" >' . $args['value'] . '</output>';
		}
		if (isset($args['small_text']) && $args['small_text'] != '') {
			$html .= '<small>' . $args['small_text'] . '</small>';
		}
		$html .= '</div></div>';
		return $html;
	}
	// return color input
	public static function color_input($args) {
		$html = '';
		$pro_class = '';
		$show_when = array('class' => '', 'attr' => '');
		if ((isset($args["pro"]) && $args["pro"] === true)) {
			$pro_class = 'wpda_pro_option';
		}
		$preview = array('class' => '', 'attr' => '');
		$transparent = '';
		if (isset($args['preview'])) {
			$preview['attr'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action'] . '"';
			$preview['class'] = 'with_preview';
		}
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		if (isset($args['transparent'])) {
			$transparent = 'data-alpha="true"';
		}
		$html .= '<div class="wpda_option wpda_color_input' . $show_when['class'] . '" ' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div class="' . $pro_class . '">';
		$html .= '<input ' . $transparent . ' type="text" class="color ' . $preview['class'] . '" ' . $preview['attr'] . ' value="' . $args['value'] . '" data-default-color="' . $args["default_value"] . '" id="' . $args['name'] . '" name="' . $args['name'] . '">';
		$html .= '</div></div>';
		return 	$html;
	}

	public static function simple_select($args) {
		$html = '';
		$pro_class = '';
		$preview = array('class' => '', 'attr' => '');
		$show_when = array('class' => '', 'attr' => '');
		if ((isset($args["pro"]) && $args["pro"] === true)) {
			$pro_class = 'wpda_pro_option';
		}
		if (isset($args['preview'])) {
			$preview['attr'] = 'data-preview-id="' . $args['preview']['id'] . '" data-preview-action="' . $args['preview']['action'] . '"';
			$preview['class'] = 'with_preview';
		}
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$html .= '<div class="wpda_option wpda_select_input' . $show_when['class'] . '" ' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div class="' . $pro_class . '">';
		$html .= '<select ' . $preview['attr'] . ' class="' . $preview['class'] . '" id="' . $args['name'] . '" name="' . $args['name'] . '">';

		foreach ($args['values'] as $key => $value) {
			if (!is_array($value)) {
				$html .= '<option  value="' . $key . '" ' . selected($key, $args['value'], false) . ' >' . $value . '</option>';
			} else {
				$html .= '<optgroup label="' . str_replace("_", " ", $key) . '">';
				foreach ($value as $key => $value) {
					$html .= '<option value="' . $key . '" ' . selected($key, $args['value'], false) . '>' . $value . '</option>';
				}
				$html .= '</optgroup>';
			}
		}
		$html .= '</select></div></div>';
		return $html;
	}

	public static function popup($args) {
		$html = '';
		$pro_class = '';
		$show_when = array('class' => '', 'attr' => '');
		if ((isset($args["pro"]) && $args["pro"] === true)) {
			$pro_class = 'wpda_pro_option';
		}
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$inside_elements_args = $args['params'];
		$html .= '<div class="wpda_option wpda_popup' . $show_when['class'] . '"' . $show_when['attr'] . '>';
		$html .= self::gen_desc_panel($args);
		$html .= '<div class="' . $pro_class . '">';
		$html .= '<span class="wpda_popup_o_c_button dashicons dashicons-edit edit_font_button"></span>';
		$html .= '<div class="wpda_popup_window">';
		foreach ($inside_elements_args as $ins_elem_name => $ins_elem_args) {
			$ins_elem_args = array_merge(array("name" => $ins_elem_name, "heading_name" => $args['heading_name'], "heading_group" => $args['heading_group'],), $ins_elem_args);
			unset($ins_elem_args['description']);
			$html .= self::create_setting($ins_elem_args);
		}
		$html .= '</div></div></div>';
		return $html;
	}

	public static function demo_text($args) {
		$html = '';
		$show_when = array('class' => '', 'attr' => '');
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$html .= '<div class="wpda_option demo_text' . $show_when['class'] . '"' . $show_when['attr'] . '>';
		$html .= '<div id="' . $args['name'] . '">' . $args['title'] . '</div>';
		$html .= '</div>';
		return $html;
	}

	public static function demo_border($args) {
		$html = '';
		$show_when = array('class' => '', 'attr' => '');
		if (isset($args['show_when'])) {
			$show_when['attr'] = ' data-condition=\'' . json_encode($args['show_when']) . '\'';
			$show_when['class'] = ' condition_element';
		}
		$html .= '<div class="wpda_option demo_border' . $show_when['class'] . '"' . $show_when['attr'] . '>';
		$html .= '<div id="' . $args['name'] . '">' . $args['title'] . '</div>';
		$html .= '</div>';
		return $html;
	}

	/*for front end*/
	public static function hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';
		if (empty($color))
			return $default;
		if ($color[0] == '#')
			$color = substr($color, 1);
		if (strlen($color) == 6)
			$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		elseif (strlen($color) == 3)
			$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		else
			return $default;
		$rgb = array_map('hexdec', $hex);
		$opacity = min($opacity, 1);
		$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
		return $output;
	}

	private static function description_panel($title, $desc, $pro) {
		$pro_html = ($pro === true) ? '<span class="pro_feature">(pro)</span>' : '';
		$html = '<div class="wpda_option_description">';
		$html .= '<span class="wpdevart-title">' . $title . '</span>';
		$html .= $pro_html;
		$html .= $desc != '' ? '<span class="wpdevart-info-container">?<span class="wpdevart-info">' . $desc . '</span></span>' : '';
		$html .= '</div>';
		return $html;
	}

	private static function fill_empty_args($args) {
		$default_values = array('title' => '', 'description' => '', 'pro' => false);
		foreach ($default_values as $key => $value) {
			if (!isset($args[$key]))
				$args[$key] = $value;
		}
		return $args;
	}

	private static function popup_edit_elements($options_html, $results_inner_html = '') {
		$edit_button_class = 'dashicons dashicons-edit edit_font_button';
		$html = '<span class="' . $edit_button_class . '"></span>';
		$html .= '<div class="options_popup">';
		$html .= $options_html;
		$html .= '</div>';
		$html = '<span class="' . $edit_button_class . '">' . $results_inner_html . '</span>';
		return $html;
	}

	public static function fonts_select() {
		$font_choices['Arial,Helvetica Neue,Helvetica,sans-serif'] = 'Arial *';
		$font_choices['Arial Black,Arial Bold,Arial,sans-serif'] = 'Arial Black *';
		$font_choices['Arial Narrow,Arial,Helvetica Neue,Helvetica,sans-serif'] = 'Arial Narrow *';
		$font_choices['Courier,Verdana,sans-serif'] = 'Courier *';
		$font_choices['Georgia,Times New Roman,Times,serif'] = 'Georgia *';
		$font_choices['Times New Roman,Times,Georgia,serif'] = 'Times New Roman *';
		$font_choices['Trebuchet MS,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Arial,sans-serif'] = 'Trebuchet MS *';
		$font_choices['Verdana,sans-serif'] = 'Verdana *';
		$font_choices['American Typewriter,Georgia,serif'] = 'American Typewriter';
		$font_choices['Andale Mono,Consolas,Monaco,Courier,Courier New,Verdana,sans-serif'] = 'Andale Mono';
		$font_choices['Baskerville,Times New Roman,Times,serif'] = 'Baskerville';
		$font_choices['Bookman Old Style,Georgia,Times New Roman,Times,serif'] = 'Bookman Old Style';
		$font_choices['Calibri,Helvetica Neue,Helvetica,Arial,Verdana,sans-serif'] = 'Calibri';
		$font_choices['Cambria,Georgia,Times New Roman,Times,serif'] = 'Cambria';
		$font_choices['Candara,Verdana,sans-serif'] = 'Candara';
		$font_choices['Century Gothic,Apple Gothic,Verdana,sans-serif'] = 'Century Gothic';
		$font_choices['Century Schoolbook,Georgia,Times New Roman,Times,serif'] = 'Century Schoolbook';
		$font_choices['Consolas,Andale Mono,Monaco,Courier,Courier New,Verdana,sans-serif'] = 'Consolas';
		$font_choices['Constantia,Georgia,Times New Roman,Times,serif'] = 'Constantia';
		$font_choices['Corbel,Lucida Grande,Lucida Sans Unicode,Arial,sans-serif'] = 'Corbel';
		$font_choices['Franklin Gothic Medium,Arial,sans-serif'] = 'Franklin Gothic Medium';
		$font_choices['Garamond,Hoefler Text,Times New Roman,Times,serif'] = 'Garamond';
		$font_choices['Gill Sans MT,Gill Sans,Calibri,Trebuchet MS,sans-serif'] = 'Gill Sans MT';
		$font_choices['Helvetica Neue,Helvetica,Arial,sans-serif'] = 'Helvetica Neue';
		$font_choices['Hoefler Text,Garamond,Times New Roman,Times,sans-serif'] = 'Hoefler Text';
		$font_choices['Lucida Bright,Cambria,Georgia,Times New Roman,Times,serif'] = 'Lucida Bright';
		$font_choices['Lucida Grande,Lucida Sans,Lucida Sans Unicode,sans-serif'] = 'Lucida Grande';
		$font_choices['Palatino Linotype,Palatino,Georgia,Times New Roman,Times,serif'] = 'Palatino Linotype';
		$font_choices['Tahoma,Geneva,Verdana,sans-serif'] = 'Tahoma';
		$font_choices['Rockwell, Arial Black, Arial Bold, Arial, sans-serif'] = 'Rockwell';
		$font_choices['Segoe UI'] = 'Segoe UI';
		return $font_choices;
	}

	public static function must_showed_select($selected_values = array()) {
		if (!is_array($selected_values)) {
			$selected_values = array();
		}
		$output_html = "";
		$options_group = array(
			"pages" => "Pages",
			"posts" => "Posts",
			"categories" => "Categories",
			"custom_post_type" => "custom post type",
			"taxonomy" => "taxonomy",
			"other" => "other",
			"device" => "device",
			"user" => "user",
		);
		$options = array();
		add_filter('posts_fields', 'wpda_library::alter_fields_wpse_10888');
		add_filter('pages_fields', 'wpda_library::alter_fields_wpse_10888');
		$options["pages"] = self::get_pages();
		$options["posts"] = self::get_posts();
		$options["categories"] = self::get_categories();
		$options["custom_post_type"] = self::get_custom_post_type();
		$options["taxonomy"] = self::get_taxonomy();
		$options["other"] = self::get_other();
		$options["device"] = self::get_device();
		$options["user"] = self::get_user();

		foreach ($options_group as $group_key => $group_value) {
			$output_html .= '<optgroup label="' . $group_value . '">';
			foreach ($options[$group_key] as $options_key => $options_value) {

				$selected = in_array($options_key, $selected_values) ? 'selected="selected"' : '';
				$output_html .= '<option label="' . $group_value . '" value="' . $options_key . '" ' . $selected . '>' . $options_value . '</option>';
			}
			$output_html .= '</optgroup>';
		}
		return $output_html;
	}

	function alter_fields_wpse_108288($fields) {
		return 'ID,post_title'; // etc
	}

	private static function get_pages() {
		$pages = array();
		$pages_loc = get_pages(
			array(
				'sort_order'	 => 'ASC',
				'sort_column'	 => 'post_title',
				'number'		 => '',
				'post_type'		 => 'page',
				'post_status'	 => 'publish'
			)
		);
		$count = count($pages_loc);
		for ($i = 0; $i < $count; $i++) {
			$pages["page_" . $pages_loc[$i]->ID] = $pages_loc[$i]->post_title;
		}
		return $pages;
	}

	private static function get_posts() {
		$posts = array();
		$posts_loc =  get_posts(
			array(
				'sort_order'	 => 'ASC',
				'sort_column'	 => 'post_title',
				'number'		 => '',
				'post_type'		 => 'post',
				'post_status'	 => 'publish'
			)
		);
		$count = count($posts_loc);
		for ($i = 0; $i < $count; $i++) {
			$posts["post_" . $posts_loc[$i]->ID] = $posts_loc[$i]->post_title;
		}
		return $posts;
	}

	private static function get_categories() {
		$categories = array();
		$categories_loc = get_categories(
			array(
				'hide_empty' => false
			)
		);
		$count = count($categories_loc);
		for ($i = 0; $i < $count; $i++) {
			$categories["category_" . $categories_loc[$i]->cat_ID] = $categories_loc[$i]->cat_name;
		}
		return $categories;
	}

	private static function get_custom_post_type() {
		$custom_post_types = array();
		$custom_post_types_loc = get_post_types(
			array(
				'public' => true
			),
			'objects',
			'and'
		);
		foreach ($custom_post_types_loc as $key => $value) {
			$custom_post_types["custom_post_type_" . $value->name] = $value->label;
		}
		return $custom_post_types;
	}

	private static function get_taxonomy() {
		$taxonomies = array();
		$taxonomies_loc = get_taxonomies(
			array(
				'public' => true
			),
			'objects',
			'and'
		);
		foreach ($taxonomies_loc as $key => $value) {
			$taxonomies["taxonomy_" . $value->name] = $value->label;
		}
		return $taxonomies;
	}

	private static function get_other() {
		return array(
			'front_page'	 => 'Front Page',
			'blog_page'		 => 'Blog Page',
			'single_post'	 => 'Single Posts',
			'sticky_post'	 => 'Sticky Posts',
			'date_archive'	 => 'Date Archive',
			'author_archive' => 'Author Archive',
			'search_page'	 => 'Search Page',
			'404_page'		 => '404 Page'
		);
	}

	private static function get_device() {
		return array(
			'mobile'	 => 'Mobile',
			'desktop'	 => 'Desktop'
		);
	}

	private static function get_user() {
		return array(
			'logged_in'	 => 'Logged in users',
			'logged_out' => 'Logged out users'
		);
	}

	public static function darkest_color($color, $pracent) {
		$new_color = $color;
		if (!(strlen($new_color == 6) || strlen($new_color) == 7)) {
			return $color;
		}
		$color_with_hash = strpos($new_color, '#');
		if ($color_with_hash == false) {
			$new_color = str_replace('#', '', $new_color);
		}
		$color_part_1 = substr($new_color, 0, 2);
		$color_part_2 = substr($new_color, 2, 2);
		$color_part_3 = substr($new_color, 4, 2);
		$color_part_1 = dechex((int) (hexdec($color_part_1) - ((hexdec($color_part_1)) * $pracent / 100)));
		$color_part_2 = dechex((int) (hexdec($color_part_2)  - ((hexdec($color_part_2)) * $pracent / 100)));
		$color_part_3 = dechex((int) (hexdec($color_part_3) - ((hexdec($color_part_3)) * $pracent / 100)));
		$new_color = "#" . (strlen($color_part_1) > 1 ? $color_part_1 : "0" . $color_part_1) . (strlen($color_part_2) > 1 ? $color_part_2 : "0" . $color_part_2) . (strlen($color_part_3) > 1 ? $color_part_3 : "0" . $color_part_3);
		if ($color_with_hash == false) {
			return $new_color;
		} else {
			return '#' . $new_color;
		}
	}

	public static function is_plugin_active($plugin) {
		return in_array($plugin, (array) get_option('active_plugins', array())) || self::is_plugin_active_for_network($plugin);
	}

	public static function  is_plugin_active_for_network($plugin) {
		if (!is_multisite()) {
			return false;
		}
		$plugins = get_site_option('active_sitewide_plugins');
		if (isset($plugins[$plugin])) {
			return true;
		}
		return false;
	}

	public static function get_random_animation() {
		$anim_list = self::get_css_animations_list();
		return $anim_list[array_rand($anim_list)];
	}

	public static function get_css_animations_list() {
		return array(
			'bounce',
			'flash',
			'pulse',
			'rubberBand',
			'shake',
			'swing',
			'tada',
			'wobble',
			'bounceIn',
			'bounceInDown',
			'bounceInLeft',
			'bounceInRight',
			'bounceInUp',
			'fadeIn',
			'fadeInDown',
			'fadeInDownBig',
			'fadeInLeft',
			'fadeInLeftBig',
			'fadeInRight',
			'fadeInRightBig',
			'fadeInUp',
			'fadeInUpBig',
			'flip',
			'flipInX',
			'flipInY',
			'lightSpeedIn',
			'rotateIn',
			'rotateInDownLeft',
			'rotateInDownRight',
			'rotateInUpLeft',
			'rotateInUpRight',
			'rollIn',
			'zoomIn',
			'zoomInDown',
			'zoomInLeft',
			'zoomInRight',
			'zoomInUp'
		);
	}

	private static function gradient_directions() {
		return array(
			array(
				'key' => 'none',
				'val' => 'Without gradient',
			),
			array(
				'key' => 'to right',
				'val' => 'Right',
			),
			array(
				'key' => 'to left',
				'val' => 'Left',
			),
			array(
				'key' => 'to bottom',
				'val' => 'Bottom',
			),
			array(
				'key' => 'to top',
				'val' => 'Top',
			),
			array(
				'key' => 'to bottom right',
				'val' => 'Bottom Right',
			),
			array(
				'key' => 'to bottom left',
				'val' => 'Bottom Left',
			),
			array(
				'key' => 'to top right',
				'val' => 'Top Right',
			),
			array(
				'key' => 'to top left',
				'val' => 'Top Left',
			),
		);
	}

	private static function sanitize_color($color) {
		preg_match('/(?:rgb|rgba)[(][ ]{0,100}[0-9]{1,3}[ ]{0,100},[ ]{0,100}[0-9]{1,3}[ ]{0,100},[ ]{0,100}[0-9]{1,3}[ ]{0,100}[,]{0,1}[ ]{0,100}[0-1]{0,1}[.]{0,1}[0-9]{0,9}[)]/', $color, $matches);
		if ($matches) {
			return $color;
		}
		return sanitize_hex_color($color);
	}

	private static function get_simple_input_value($key = '', $args) {
		$parameter = array();
		if (isset($args['metric'])) {
			$parameter['metric_desktop'] = sanitize_text_field($_POST[$key]['metric_desktop']);
			if (isset($args['responsive'])) {
				$parameter['metric_tablet'] = sanitize_text_field($_POST[$key]['metric_tablet']);
				$parameter['metric_mobile'] = sanitize_text_field($_POST[$key]['metric_mobile']);
			}
		}
		$parameter['desktop'] = sanitize_text_field($_POST[$key]['desktop']);
		if (isset($args['responsive'])) {
			$parameter['tablet'] = sanitize_text_field($_POST[$key]['tablet']);
			$parameter['mobile'] = sanitize_text_field($_POST[$key]['mobile']);
		}
		return $parameter;
	}

	private static function get_margin_padding_input_value($key = '', $args) {
		$parameter = array();
		if (isset($args['metric'])) {
			$parameter['metric_desktop'] = sanitize_text_field($_POST[$key]['metric_desktop']);
			if (isset($args['responsive'])) {
				$parameter['metric_tablet'] = sanitize_text_field($_POST[$key]['metric_tablet']);
				$parameter['metric_mobile'] = sanitize_text_field($_POST[$key]['metric_mobile']);
			}
		}
		$parameter['desktop_top'] = intval($_POST[$key]['desktop_top']);
		$parameter['desktop_right'] = intval($_POST[$key]['desktop_right']);
		$parameter['desktop_bottom'] = intval($_POST[$key]['desktop_bottom']);
		$parameter['desktop_left'] = intval($_POST[$key]['desktop_left']);
		if (isset($args['responsive'])) {
			$parameter['tablet_top'] = intval($_POST[$key]['tablet_top']);
			$parameter['tablet_right'] = intval($_POST[$key]['tablet_right']);
			$parameter['tablet_bottom'] = intval($_POST[$key]['tablet_bottom']);
			$parameter['tablet_left'] = intval($_POST[$key]['tablet_left']);
			$parameter['mobile_top'] = intval($_POST[$key]['mobile_top']);
			$parameter['mobile_right'] = intval($_POST[$key]['mobile_right']);
			$parameter['mobile_bottom'] = intval($_POST[$key]['mobile_bottom']);
			$parameter['mobile_left'] = intval($_POST[$key]['mobile_left']);
		}
		return $parameter;
	}

	private static function get_gradient_color_input_value($key = '') {
		$parameter = array();
		$parameter['gradient'] = sanitize_text_field($_POST[$key]['gradient']);
		$parameter['color1'] = self::sanitize_color($_POST[$key]['color1']);
		$parameter['color2'] = self::sanitize_color($_POST[$key]['color2']);
		return $parameter;
	}

	private static function get_range_input_value($key = '') {
		return sanitize_text_field($_POST[$key]);
	}

	private static function get_radio_value($key = '') {
		return sanitize_text_field($_POST[$key]);
	}

	private static function get_checkbox_value($key = '') {
		if (!isset($_POST[$key]) && is_array($_POST[$key])) {
			return array();
		}
		$parameter = array();
		foreach ($_POST[$key] as $key_checkbox => $value) {
			$parameter[$key_checkbox] = sanitize_text_field($value);
		}
		return $parameter;
	}

	private static function get_color_input_value($key = '') {
		return self::sanitize_color($_POST[$key]);
	}

	private static function get_simple_select_value($key = '') {
		return sanitize_text_field($_POST[$key]);
	}

	public static function get_value_by_name($key = '', $args) {
		if (!isset($args['function_name']) || $key == '' || !isset($_POST[$key])) {
			return NULL;
		}
		if ($args['function_name'] == 'demo_text' || $args['function_name'] == 'demo_border') {
			return NULL;
		}
		if (isset($args['pro']) && $args['pro'] == true) {
			return NULL;
		}
		switch ($args['function_name']) {
			case 'simple_input':
				return self::get_simple_input_value($key, $args);
				break;
			case 'margin_padding_input':
				return self::get_margin_padding_input_value($key, $args);
				break;
			case 'gradient_color_input':
				return self::get_gradient_color_input_value($key);
				break;
			case 'range_input':
				return self::get_range_input_value($key);
				break;
			case 'radio':
				return self::get_radio_value($key);
				break;
			case 'checkbox':
				return self::get_checkbox_value($key);
				break;
			case 'color_input':
				return self::get_color_input_value($key);
				break;
			case 'simple_select':
				return self::get_simple_select_value($key);
				break;
			default:
				if (!isset($_POST[$key])) {
					return '';
				}
				if (is_array($_POST[$key])) {
					$param = array();
					foreach ($_POST[$key] as $post_key => $value) {
						$param[$post_key] = sanitize_text_field($value);
					}
					return $param;
				}
				return sanitize_text_field($_POST[$key]);
		}
	}
}
