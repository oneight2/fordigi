<?php
add_shortcode('tmebtn', 'tmebtn');

add_filter("the_content", "tme_content_filter");

function tme_content_filter($content) {
 
	// array of custom shortcodes requiring the fix 
	$block = join("|",array("tmebtn"));
 
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
	return $rep;
 
}

if ( ! function_exists( 'tmebtn' ) ) {
    function tmebtn($atts, $content = null) {
        extract(shortcode_atts(array(
            "url" => 'url',
            "style" => 'style',
            "target" => 'target'
        ), $atts));
        return '<a href="' . esc_url($url) . '" target="' . esc_attr($target) . '" class="tmebtn tmebtn-' . esc_attr($style) . '">' . esc_html($content) . '</a>';
    }
}