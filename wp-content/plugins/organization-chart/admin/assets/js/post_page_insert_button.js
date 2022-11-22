(function($) {
	tinymce.PluginManager.add('wpda_org_chart', function( editor, url ) {
		let nonce = window.wpda_org_chart_insert_post_shortcode_nonce || wpda_org_chart_insert_post_shortcode_nonce;
		var sh_tag = 'wpda_org_chart';
		//helper functions 
		function getAttr(s, n) {
			n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
			return n ?  window.decodeURIComponent(n[1]) : '';
		};

		function html( cls, data ) {
			var placeholder = url.replace('/js','/images') + '/content_icon.png';
			data = window.encodeURIComponent( data );			
			return '<img src="' + placeholder + '" class="mceItem ' + cls + '" ' + 'data-wpda_org_chart-attr="' + data + '" data-mce-resize="false" data-mce-placeholder="1" />';
		}

		function replaceShortcodes( content ) {
			return content.replace( /\[wpda_org_chart([^\]]*)\]/g, function( all,attr) {
				return html( 'wp-wpda_org_chart', attr );
			});
		}

		function restoreShortcodes( content ) {
			return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
				var data = getAttr( image, 'data-wpda_org_chart-attr' );				
				if ( data ) {
					return '<p>[' + sh_tag + data + ']</p>';
				}
				return match;
			});
		}
		//add popup
		editor.addCommand('wpda_org_chart_popup', function() {
			//setup defaults
	
            var   button_object = {};
			var   editor_loc_object = {};
			if(typeof(title)=="undefined"){
				var title="";
			}
			button_object = {
				title: 'WpDevArt Organization Chart', 
				file:  document.location.origin+ajaxurl + '?action=wpda_org_chart_post_page_content&wpda_org_chart_insert_post_shortcode_nonce='+nonce+'&chart_id='+getAttr(title,'tree_id')+'&theme_id='+getAttr(title,'theme_id'),    
				width: 400, 
				height: 200,   
				id : 'my-custom-wpdialog',
				inline: 1          					
			};
		   editor_loc_object={
				editor: editor,  
				jquery: $,  								
				plugin_url : url
				//php_version: php_version   
			};		  
			editor.windowManager.open( button_object,  editor_loc_object);			
		});

		//add button
		editor.addButton('wpda_org_chart', {			
			icon: 'wpdevart_org_chart dashicons dashicons-networking',
			tooltip: 'WpDevArt Organization Chart',
			onclick: function() {	
				editor.execCommand('wpda_org_chart_popup','',{});
			}
		});

		//replace from shortcode to an image placeholder
		editor.on('BeforeSetcontent', function(e){ 
			e.content = replaceShortcodes( e.content );
		});

		//replace from image placeholder to shortcode
		editor.on('GetContent', function(e){
			e.content = restoreShortcodes(e.content);
		});

		//open popup on placeholder on click
		editor.on('Click',function(e) {
			var cls  = e.target.className.indexOf('wp-wpda_org_chart');
			if ( e.target.nodeName == 'IMG' && e.target.className.indexOf('wp-wpda_org_chart') > -1 ) {
				var title = e.target.attributes['data-wpda_org_chart-attr'].value;
				title = window.decodeURIComponent(title);
				var button_object = {};
				var editor_loc_object = {};			  
				button_object ={ord :getAttr(title,'ord'),
					title: 'WpDevArt Organization Chart', 
					file:  document.location.origin+ajaxurl + '?action=wpda_org_chart_post_page_content&wpda_org_chart_insert_post_shortcode_nonce='+nonce+'&chart_id='+getAttr(title,'tree_id')+'&theme_id='+getAttr(title,'theme_id'),    
					width: 400, 
					height: 200,   
					id : 'wpda_org_chart_popup_dialog',
					inline: 1          					
				};
				editor_loc_object={
					editor: editor,  
					jquery: $,  										
					plugin_url : url
					//php_version: php_version   
				};			  
				editor.windowManager.open( button_object,  editor_loc_object);
			}
		});
	});
})(jQuery);