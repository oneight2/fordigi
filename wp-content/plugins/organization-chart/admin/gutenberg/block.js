(function (blocks, element) {
	var el = element.createElement;
	var icon_image = el('span', {
		className: "dashicons dashicons-networking"
	});
	blocks.registerBlockType('wpdevart-organization-chart/organization-chart', {
		title: 'WpDevArt organization chart',
		icon: icon_image,
		category: 'common',
		keywords: ['org', 'chart', 'organization'],
		attributes: {
			chart: {
				type: 'string',
				selector: 'select',
			},
			theme: {
				type: 'string',
				selector: 'select',
			}
		},
		edit: function (props) {
			var attributes = props.attributes;
			var chart_options = new Array(), theme_options = new Array();
			var selected_option = false;
			for (var key in wpda_chart_gutenberg["charts"]) {
				selected_option = false;
				if (typeof (attributes.chart) == "undefined") {
					props.setAttributes({ chart: key })
					attributes.chart = key;
				} else {
					if (props.attributes.chart == key) {
						selected_option = true;
					}
				}
				chart_options.push(el('option', { value: '' + key + '', selected: selected_option }, wpda_chart_gutenberg["charts"][key]))
			}
			for (var key in wpda_chart_gutenberg["themes"]) {
				selected_option = false;
				if (typeof (attributes.theme) == "undefined") {
					props.setAttributes({ theme: key })
					attributes.theme = key;
				} else {
					if (props.attributes.theme == key) {
						selected_option = true;
					}
				}
				theme_options.push(el('option', { value: '' + key + '', selected: selected_option }, wpda_chart_gutenberg["themes"][key]))
			}

			return (
				el('div', { className: props.className },
					el('div', { className: "wpdevart_gutenberg_chart_main_div" },
						el('span', {}, "Wpdevart organization chart"),
						el('div', { className: "wpdevart_gutenberg_chart_option_div" },
							el('label', {}, "Select a Tree"),
							el('select', { className: "wpdevart_gutenberg_chart_css", onChange: function (value) { var select = value.target; props.setAttributes({ chart: select.options[select.selectedIndex].value }) } }, chart_options),
						),
						el('div', { className: "wpdevart_gutenberg_chart_theme_option_div" },
							el('label', {}, "Select a Theme"),
							el('select', { className: "wpdevart_gutenberg_theme_css", onChange: function (value) { var select = value.target; props.setAttributes({ theme: select.options[select.selectedIndex].value }) } }, theme_options),
						)
					)
				)
			);

		},
		save: function (props) {
			return "[wpda_org_chart tree_id=" + props.attributes.chart + "  theme_id=" + props.attributes.theme + "]";
		}

	})
})(
	window.wp.blocks,
	window.wp.element
);

