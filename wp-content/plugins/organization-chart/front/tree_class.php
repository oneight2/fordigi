<?php

class wpda_org_chart_front_tree_maker {

	private $tree_nodes, $theme_options, $popup_options, $ids;
	private $popup_default_theme_id;
	private static $popups = array();
	private static $id_for_tree = 0;
	private static $id_for_node = 0;
	private $hide_first_node = false;
	private $node_css = '';
	function __construct($atts) {
		$this->ids['tree'] = $this->ids['theme'] = 0;
		if (isset($atts['tree_id']))
			$this->ids['tree'] = $atts['tree_id'];
		if (isset($atts['theme_id']))
			$this->ids['theme'] = $atts['theme_id'];
	}

	public function controller() {
		if (!$this->ids['tree']) {
			return '<h2>Organization Chart tree id don\'t found</h2>';
		}
		$this->tree_nodes = $this->get_tree($this->ids['tree']);
		if ($this->tree_nodes == null) {
			return '<h2>Organization Chart don\'t found</h2>';
		}
		$this->tree_nodes = json_decode($this->tree_nodes->tree_nodes, true);
		$this->theme_options['default'] = $this->get_theme($this->ids['theme']);
		if ($this->theme_options['default'] == null) {
			return '<h2>Organization Chart theme don\'t found</h2>';
		}
		$this->theme_options['default'] = json_decode($this->theme_options['default']->option_value, true);
		$this->correct_gradients();
		$this->popup_default_theme_id = $this->get_def_popup_theme();
		return $this->tree_html();
	}

	public function tree_html() {
		self::$id_for_tree++;
		$this->hide_first_node = ($this->tree_nodes[0]['node_info']['image_url'] == '' && $this->tree_nodes[0]['node_info']['node_title'] == '' && $this->tree_nodes[0]['node_info']['node_description'] == '');
		$html = '<div class="wpdevart_org_chart"><div class="wpdevart_org_chart_container_parent" id="wpdevart_org_chart_container_parent_' . self::$id_for_tree . '"><div class="wpdevart_org_chart_container ' . ($this->hide_first_node ? 'first_child_hidden' : '') . '" id="wpdevart_org_chart_container_' . self::$id_for_tree . '">';
		$html .= $this->construct_nodes($this->tree_nodes);
		$html .= '</div></div></div>';
		return $html . $this->tree_js() . $this->tree_css();
	}

	public function tree_js() {
		$options['def_scroll'] = isset($this->theme_options['default']['scroll_position']) ? $this->theme_options['default']['scroll_position'] : '0';
		$options['zoomable'] = isset($this->theme_options['default']['zoomable']) ? $this->theme_options['default']['zoomable'] : 'disable';
		$options['draggable'] = isset($this->theme_options['default']['draggable']) ? $this->theme_options['default']['draggable'] : 'disable';
		$options['max_zoomable'] = isset($this->theme_options['default']['max_zoomable']) ? $this->theme_options['default']['max_zoomable'] : '1';
		$options['min_zoomable'] = isset($this->theme_options['default']['min_zoomable']) ? $this->theme_options['default']['min_zoomable'] : '10';
		$options['zoom_speed'] = isset($this->theme_options['default']['zoom_speed']) ? $this->theme_options['default']['zoom_speed'] : '10';
		$js = '<script>';
		$js_options = '{mobile_frendly:"' . $this->theme_options['default']["mobile_frendly"] . '",mobile_size:' . wpda_org_chart_responsive_sizes['mobile'] . ',def_scroll:' . $options['def_scroll'] . ', zoomable:"' . $options['zoomable'] . '", draggable:"' . $options['draggable'] . '", max_zoomable:"' . $options['max_zoomable'] . '", min_zoomable:"' . $options['min_zoomable'] . '", zoom_speed:"' . $options['zoom_speed'] . '"}';
		$js .= 'document.addEventListener("DOMContentLoaded", function(event) { ';
		$js .= 'var wpda_org_chart_' . self::$id_for_tree . '= new wpdevart_org_chart_front("wpdevart_org_chart_container_' . self::$id_for_tree . '",' . $js_options . ')';
		$js .= '});';
		$js .= '</script>';
		return $js;

	}

	private function construct_nodes($nods_info) {
		$html = '<ul>';
		foreach ($nods_info as $key => $node) {
			self::$id_for_node++;
			$link = $this->make_node_link($node);
			$popup = $this->make_popup($node, $link);
			$html .= '<li class="' . (count($node['chidrens']) > 0 ? 'has_children' : 'no_children') . ((isset($node['node_info']['node_responsive_after']) && ($node['node_info']['node_responsive_after'] == 'yes' || intval($node['node_info']['node_responsive_after']) == 1)) ? ' chart_wpda_mobile_before' : '') . ' ' . ((isset($nods_info[$key + 1]['chidrens']) && count($nods_info[$key + 1]['chidrens']) > 0) ? 'next_children' : 'next_no_children') . '" data-children=' . count($node['chidrens']) . '>';
			$html .= '<div class="wpda_tree_item_container" id="wpda_item_container_' . self::$id_for_node . '" >';
			$html .= '<span class="wpda_tree_line"></span>';
			if (!$this->hide_first_node) {
				$html .= '<div class="' . $popup['item'] . '">';
				if ($node['node_info']['image_url'] != '') {
					$html .= '<div class="wpda_tree_item_img_cont ' . $popup['image'] . '">' . '<img class="wpda_tree_item_img" src="' . $node['node_info']['image_url'] . '">' . $link['open_image'] . $link['close_image'] . '</div>';
				}
				$html .= '<div class="wpda_tree_item_title ' . $popup['title'] . '">' . htmlspecialchars_decode($node['node_info']['node_title']) . $link['open_title'] . $link['close_title'] . '</div>';
				$html .= '<div class="wpda_tree_item_desc" ' . $popup['desc'] . '>' . htmlspecialchars_decode($node['node_info']['node_description']) . $link['open_desc'] . $link['close_desc'] . '</div>';

				$html .= $link['open_item'] . $link['close_item'];
				$html .= $popup['html'];
				$html .= '</div>';
			}
			$this->hide_first_node = false;
			$html .= '</div>';
			if (count($node['chidrens']) > 0) {
				$html .= $this->construct_nodes($node['chidrens']);
			}
			$html .= '</li>';
		}
		$html .= '</ul>';
		$html .= $this->add_popup_theme_info();
		return $html;
	}

	private function make_node_link($node) {
		$link = array(
			'open_item' => '',
			'close_item' => '',
			'open_image' => '',
			'close_image' => '',
			'open_title' => '',
			'close_title' => '',
			'open_desc' => '',
			'close_desc' => '',
		);
		if (isset($node['node_info']['node_url']) && $node['node_info']['node_url'] != '') {
			$blank = '';
			if (isset($node['node_info']['node_url_o_n_t']) && $node['node_info']['node_url_o_n_t']) {
				$blank = 'target="_blank"';
			}
			$open_link = '<a class="wpda_tree_node_link" href="' . $node['node_info']['node_url'] . '" ' . $blank . '>';
			$close_link = '</a>';
			if ($node['node_info']['node_url_o_a']['item'] != '') {
				$link['open_item'] = $open_link;
				$link['close_item'] = $close_link;
				return $link;
			}
			if ($node['node_info']['node_url_o_a']['image'] != '') {
				$link['open_image'] = $open_link;
				$link['close_image'] = $close_link;
			}
			if ($node['node_info']['node_url_o_a']['title'] != '') {
				$link['open_title'] = $open_link;
				$link['close_title'] = $close_link;
			}
			if ($node['node_info']['node_url_o_a']['desc'] != '') {
				$link['open_desc'] = $open_link;
				$link['close_desc'] = $close_link;
			}
		}
		return $link;
	}

	private function make_popup($node, $link) {
		$popup = array(
			'html' => '',
			'item' => '',
			'image' => '',
			'title' => '',
			'desc' => '',
			'theme' => '0',
		);
		$url_exsist = isset($node['node_info']['node_url']);
		if($url_exsist){
			if($node['node_info']['node_url'] !=''){
				$url_exsist = true;
			}else{
				$url_exsist = false;
			}				
		}
		if (isset($node['node_info']['popup_html']) && $node['node_info']['popup_html'] != '') {
			if ($node['node_info']['popup_o_a']['item'] != '' && !($node['node_info']['node_url_o_a']['item'] != '' && $url_exsist)) {
				$popup['item'] = 'wpda_tree_open_popup_el';
			} else {
				if ($node['node_info']['popup_o_a']['image'] != '' && !($node['node_info']['node_url_o_a']['image'] != '' && $url_exsist)) {
					$popup['image'] = 'wpda_tree_open_popup_el';
				}
				if ($node['node_info']['popup_o_a']['title'] != '' && !($node['node_info']['node_url_o_a']['title'] != '' && $url_exsist)) {
					$popup['title'] = 'wpda_tree_open_popup_el';
				}
				if ($node['node_info']['popup_o_a']['desc'] != '' && !($node['node_info']['node_url_o_a']['desc'] != '' && $url_exsist)) {
					$popup['desc'] = 'wpda_tree_open_popup_el';
				}
			}
		}
		if ($popup['item'] != '' || $popup['image'] != '' || $popup['title'] != '' || $popup['desc'] != '') {
			if ((int)$node['node_info']['popup_theme'] == 0) {
				$node['node_info']['popup_theme'] = $this->popup_default_theme_id;
			}
			if (!in_array((int)$node['node_info']['popup_theme'], self::$popups)) {
				self::$popups[$node['node_info']['popup_theme']] = null;
			}
			$popup['html'] = '<div date-popup-theme = "' . $node['node_info']['popup_theme'] . '" class="wpda_tree_popup_content wpda_tree_element_hidden"><div class="wpda_popup_innerhtml">' . apply_filters('the_content', htmlspecialchars_decode($node['node_info']['popup_html'])) . '</div></div>';
		}

		return $popup;
	}

	private function tree_css() {
		$main_id = '#wpdevart_org_chart_container_' . self::$id_for_tree;
		$main_parent_id = '#wpdevart_org_chart_container_parent_' . self::$id_for_tree;
		$css = '<style>';
		if ($this->theme_options['default']['mobile_frendly'] !== 'mobile') {
			$css .= $main_parent_id . '{overflow-x:auto;}';
		}
		$border = $this->theme_options['default']['border_radius']['desktop'];
		if (is_numeric($this->theme_options['default']['border_radius']['desktop'])) {
			$border .= $this->theme_options['default']['border_radius']['metric_desktop'];
		}
		$css .= $main_id . '{
			background-image: linear-gradient(' . $this->theme_options['default']['background_color']['gradient'] . ', ' . $this->theme_options['default']['background_color']['color1'] . ', ' . $this->theme_options['default']['background_color']['color2'] . ');
			padding-top:' . $this->fixe_value('default', 'padding', 'desktop_top') . ';
			padding-right:' . $this->fixe_value('default', 'padding', 'desktop') . ';
			padding-bottom:' . $this->fixe_value('default', 'padding', 'desktop_bottom') . ';
			padding-left:' . $this->fixe_value('default', 'padding', 'desktop_left') . ';
			border-style: ' . $this->fixe_value('default', 'border_type') . ';
			border-color: ' . $this->fixe_value('default', 'border_color') . ';
			border-width: ' . $this->fixe_value('default', 'border_width') . ';
			border-radius: ' . $border . ';  
		}';
		// line color and line height
		//desktop
		$css .= $main_id . ' li{margin-top: ' . $this->theme_options['default']['line_height']['desktop'] . 'px;}';
		$css .= $main_id . ' ul ul::before{left: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
			border-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
			height: ' . (20 + $this->theme_options['default']['line_height']['desktop']) . 'px;
			top: 0px;
		}';
		$css .= $main_id . ' li::before, ' . $main_id . ' li::after{
			top: -' . $this->theme_options['default']['line_height']['desktop'] . 'px;
			right: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
			width: calc(50% + ' . ($this->theme_options['default']['line_height']['desktop']/*/2*/) . 'px);
			border-top: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
			height: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= $main_id . ' li:after{
			left: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
			border-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= $main_id . ' li:last-child::before{
			border-right: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= $main_id . ' li:first-child::before,
		' . $main_id . ' li:last-child::after {
		  border: 0 none;
		}';
		//tablet
		$css .= '@media screen and (max-width: 1000px) {';
		$css .= $main_id . '{
			padding-top:' . $this->fixe_value('default', 'padding', 'tablet_top') . ';
			padding-right:' . $this->fixe_value('default', 'padding', 'tablet_right') . ';
			padding-bottom:' . $this->fixe_value('default', 'padding', 'tablet_bottom') . ';
			padding-left:' . $this->fixe_value('default', 'padding', 'tablet_left') . ';		
		}';
		$css .= '}';

		// mobile line
		$css .= '@media screen and (max-width: 450px) {';
		$css .= $main_id . '{
			padding-top:' . $this->fixe_value('default', 'padding', 'mobile_top') . ';
			padding-right:' . $this->fixe_value('default', 'padding', 'mobile_right') . ';
			padding-bottom:' . $this->fixe_value('default', 'padding', 'mobile_bottom') . ';
			padding-left:' . $this->fixe_value('default', 'padding', 'mobile_left') . ';		
		}';
		$css .= '}';
		// responsive_after
		$css .=  $main_id . ' .chart_wpda_mobile_before.has_children > ul:before{
			top:-80px;
			left:0px;
			height:80px;
		}';
		$css .=  $main_id . ' .chart_wpda_mobile_before.has_children li .wpda_tree_item_container:after{
			border-top: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before.has_children li .wpda_tree_item_container:after{
			border-top: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .=  $main_id . ' .chart_wpda_mobile_before > ul li{
			border-left:' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .=  $main_id . ' .chart_wpda_mobile_before.has_children > .wpda_tree_item_container:before,'.$main_id . ' .chart_wpda_mobile_before li.has_children > .wpda_tree_item_container:before{
			content: "";
			border-left:' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before li{
			margin-top:0px;
		}';
		$css .=  $main_id . ' .chart_wpda_mobile_before > ul li:last-child{
			border-left: 0;
		}';
		$css .=  $main_id . ' .chart_wpda_mobile_before > ul li:last-child > div > span.wpda_tree_line{
			border-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .=  $main_id . ' .chart_wpda_mobile_before.has_children li .wpda_tree_item_container:after {
			top: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before li.has_children li .wpda_tree_item_container:after {
			top: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
		}';
		$css .= '.first_child_hidden' . $main_id . ' .chart_wpda_mobile_before > ul > li > ul > li:first-child::before{
			border-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
			top: 80px;
			height: calc(100% - 80px);
			left:0px;
			width:0px;
		}';
		$css .= '.first_child_hidden' . $main_id . ' .chart_wpda_mobile_before > ul > li > div.wpda_tree_item_container:before{
			border:none;
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before > ul li:last-child > .wpda_tree_item_container{
			padding-left: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before > ul li:last-child > .wpda_tree_item_container:after{
			width: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before > ul li:last-child > .wpda_tree_item_container:before{
			left: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before > ul li:last-child > ul{
			margin-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px;
		}';
		
		$css .= '.wpda_mobile' . $main_id . ' li.has_children > ul:before{
			top:-80px;
			left:0px;
			height:80px;
		}';
		$css .= '.wpda_mobile' . $main_id . ' li.has_children li .wpda_tree_item_container:after{
			border-top: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before li.has_children li .wpda_tree_item_container:after{
			border-top: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= '.wpda_mobile' . $main_id . ' > ul > li > ul li{
			border-left:' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= '.wpda_mobile' . $main_id . ' li.has_children > .wpda_tree_item_container:before{
			content: "";
			border-left:' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= '.wpda_mobile' . $main_id . ' li{
			margin-top:0px;
		}';
		$css .= '.wpda_mobile' . $main_id . ' > ul > li > ul li:last-child{
			border-left: 0;
		}';
		$css .= '.wpda_mobile' . $main_id . ' > ul > li > ul li:last-child > div > span.wpda_tree_line{
			border-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
		}';
		$css .= '.wpda_mobile' . $main_id . ' li.has_children li .wpda_tree_item_container:after {
			top: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
		}';
		$css .= $main_id . ' .chart_wpda_mobile_before li.has_children li .wpda_tree_item_container:after {
			top: calc(50% - ' . ($this->theme_options['default']['line_height']['desktop'] / 2) . 'px);
		}';
		$css .= '.wpda_mobile.first_child_hidden' . $main_id . ' > ul > li > ul > li:first-child::before{
			border-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px solid ' . $this->theme_options['default']['line_color'] . ';
			top: 80px;
			height: calc(100% - 80px);
			left:0px;
			width:0px;
		}';
		$css .= '.wpda_mobile.first_child_hidden' . $main_id . '  > ul > li > div.wpda_tree_item_container:before{
			border:none;
		}';
		$css .= '.wpda_mobile' . $main_id . '  > ul > li > ul li:last-child > .wpda_tree_item_container{
			padding-left: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= '.wpda_mobile' . $main_id . '  > ul > li > ul li:last-child > .wpda_tree_item_container:after{
			width: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= '.wpda_mobile' . $main_id . '  > ul > li > ul li:last-child > .wpda_tree_item_container:before{
			left: ' . ($this->theme_options['default']['line_height']['desktop'] + 20) . 'px;
		}';
		$css .= '.wpda_mobile' . $main_id . ' > ul > li > ul li:last-child >ul{
			margin-left: ' . $this->theme_options['default']['line_height']['desktop'] . 'px;
		}';
		$css .= '</style>';
		return $css;
	}


	private function correct_gradients($theme_id = "default") {
		$gradient_lists = ['background_color'];
		foreach ($gradient_lists as $gradient_elem) {
			if ($this->theme_options[$theme_id][$gradient_elem]['gradient'] == 'none') {
				$this->theme_options[$theme_id][$gradient_elem]['color2'] = $this->theme_options[$theme_id][$gradient_elem]['color1'];
				$this->theme_options[$theme_id][$gradient_elem]['gradient'] = 'to right';
			}
		}
	}

	private function fixe_value($theme_id = "default", $index, $responsive = 'desktop', $style = '') {
		$responsive_metric = str_replace('_top', '', $responsive);
		$responsive_metric = str_replace('_right', '', $responsive_metric);
		$responsive_metric = str_replace('_bottom', '', $responsive_metric);
		$responsive_metric = str_replace('_left', '', $responsive_metric);
		$res_metric = 'metric_' . $responsive_metric;
		$value = '';
		if(isset($this->theme_options[$theme_id][$index]) && !is_array($this->theme_options[$theme_id][$index])){
			if ($style != '')
				return $style . $value . ';';
			return $this->theme_options[$theme_id][$index];
		}
		if (!isset($this->theme_options[$theme_id][$index][$responsive])) {
			return '';
		}
		if ($this->theme_options[$theme_id][$index][$responsive] == '') {
			return '';
		}
		$value .= $this->theme_options[$theme_id][$index][$responsive];
		if (is_numeric($this->theme_options[$theme_id][$index][$responsive])) {
			$value .= $this->theme_options[$theme_id][$index][$res_metric];
		}
		if ($style != '')
			return $style . $value . ';';
		return $value;
	}
	
	private function toHex($color) {
		if (!(strpos($color, '#') === false)) {
			return $color;
		}
		$color1 = str_replace('rgba', '', $color);
		$color1 = str_replace('rgb', '', $color1);
		$color1 = str_replace('(', '', $color1);
		$color1 = str_replace(')', '', $color1);
		$color1 = explode(",", $color1);
		if (!is_array($color1)) {
			return $color;
		}
		if (count($color1) == 3 || count($color1) == 4) {
			if (intval($color1[0]) >= 0 && intval($color1[0]) <= 255 && intval($color1[1]) >= 0 && intval($color1[1]) <= 255 && intval($color1[2]) >= 0 && intval($color1[2]) <= 255) {
				$hex_1 = dechex(intval($color1[0]));
				$hex_2 = dechex(intval($color1[1]));
				$hex_3 = dechex(intval($color1[2]));
				if (strlen($hex_1 . "") < 2) {
					$hex_1 = "0" . $hex_1;
				}
				if (strlen($hex_2 . "") < 2) {
					$hex_2 = "0" . $hex_2;
				}
				if (strlen($hex_3 . "") < 2) {
					$hex_3 = "0" . $hex_3;
				}
				return '#' . $hex_1 . $hex_2 . $hex_3;
			}
		}
		return $color;
	}
	private function get_theme($id) {
		global $wpdb;
		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . wpda_org_chart_database::$table_names["theme"] . " WHERE `id`=%d", $id));
		if ($row == null) {
			$row = $wpdb->get_row("SELECT * FROM " . wpda_org_chart_database::$table_names["theme"] . " WHERE `default`=1");
		}
		return $row;
	}

	private function get_tree($id) {
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare("SELECT * FROM " . wpda_org_chart_database::$table_names["tree"] . " WHERE `id`=%d", $id));
	}

	private function get_def_popup_theme() {
		global $wpdb;
		$id = $wpdb->get_var("SELECT id FROM " . wpda_org_chart_database::$table_names["popup"] . " WHERE `default`=1");
		if ($id == null) {
			$id = $wpdb->get_var("SELECT id FROM " . wpda_org_chart_database::$table_names["popup"]);
			if ($id != null) {
				$wpdb->update(wpda_org_chart_database::$table_names['popup'], array('default' => 1), array('id' => $id));
			}
		}
		return $id;
	}
	private function add_popup_theme_info() {
		global $wpdb;
		$script = '';
		$keys_need_too_add = array();
		foreach (self::$popups as $key => $value) {
			if ($value == null) {
				$keys_need_too_add[] = $key;
			}
		}
		if (count($keys_need_too_add) > 0) {
			$script .= "\r\n<script>\r\n";
			if (count($keys_need_too_add) == count(self::$popups))
				$script .= "wpda_org_chart_popup_theme = new Array();\r\n";
			$results =  $wpdb->get_results("SELECT id,option_value FROM " . wpda_org_chart_database::$table_names["popup"] . " WHERE id IN(" . implode(',', $keys_need_too_add) . ")");
			foreach ($results as $key => $value) {
				self::$popups[$value->id] = $value->option_value;
				$script .= 'wpda_org_chart_popup_theme[' . $value->id . '] = ' . $value->option_value . "\r\n";
			}
			$script .= '</script>';
		}
		return $script;
	}
}
