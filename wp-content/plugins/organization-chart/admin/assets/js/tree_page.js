var wpda_chart_content_loaded = false;
var params_for_chart = {}
var wpdevart_chart = {
	ids: { 'tree': 'wpdevart_tree', 'editor_parent': 'org_chart_tinymce_container', 'editor': 'org_chart_tinymce', 'editorhtml': 'org_chart_tinymce-html', 'editortmce': 'org_chart_tinymce-tmce' },
	initial_tree_string: "{}",
	default_info: { "image_url": wpdaTreePageInfo['plug_url'] + 'admin/assets/images/staff-icon.jpg', "node_title": "Title", "node_description": "Description", "theme": "0" },
	themes_select: '',
	popup_select: '',
	current_edited_element: null,

	start: function () {
		var first_element_add_button = document.getElementById("wpdevart_tree").getElementsByClassName('wpdevart_tree_node')[0].getElementsByTagName('button')[0];
		var first_edit_icon = document.getElementById("wpdevart_tree").getElementsByClassName('wpdevart_tree_node')[0].getElementsByClassName('edit_tree_node')[0];
		this.initial_tree_string = window.wpdaTreePageInfo['initial_tree_string'];
		this.themes_select = window.wpdaTreePageInfo['themes_select'];
		this.popup_select = window.wpdaTreePageInfo['popup_select'];
		this.edit_node_functionality(first_edit_icon);
		this.add_node_functionality(first_element_add_button);
		this.initial_existing_tree();
	},

	initial_existing_tree: function () {
		var self = this;
		var tree_info = self.initial_tree_string;
		var main_node_info = self.default_info;
		if (Object.keys(tree_info).length == 0) {
			return false;
		} else {
			if (Object.keys(tree_info[0]['node_info']).length != 0) {
				main_node_info = tree_info[0]['node_info'];
			}
			document.getElementById(self.ids.tree).getElementsByClassName('wpdevart_node_info')[0].value = JSON.stringify(main_node_info);
			document.getElementById(self.ids.tree).getElementsByClassName('wpdevart_tree_node')[0].getElementsByTagName('img')[0].setAttribute('src', main_node_info['image_url']);
			document.getElementById(self.ids.tree).getElementsByClassName('node_title')[0].innerHTML = main_node_info['node_title'];
			document.getElementById(self.ids.tree).getElementsByClassName('node_desc')[0].innerHTML = main_node_info['node_description'];
			this.updatePopupLinkIcons(document.getElementById("wpdevart_tree").getElementsByClassName('wpdevart_tree_node')[0], main_node_info);
			self.make_tree_by_object(tree_info[0].chidrens, document.getElementById(self.ids.tree).children[0].children[0]);
		}
	},
	// recursive function 
	make_tree_by_object: function (node_info, parent_element) {
		var self = this, element_to_appended;
		var count_elements = Object.keys(node_info).length;
		for (var i = 0; i < count_elements; i++) {
			if (i == 0) {
				element_to_appended = self.tree_node_element(true, node_info[i]['node_info']);
				parent_element.appendChild(element_to_appended)
			} else {
				element_to_appended = self.tree_node_element(false, node_info[i]['node_info']);
				parent_element.getElementsByTagName('ul')[0].appendChild(element_to_appended)
			}
			if (Object.keys(node_info[i].chidrens).length != 0) {
				if (i == 0) {
					self.make_tree_by_object(node_info[i].chidrens, element_to_appended.children[0])
				} else {
					self.make_tree_by_object(node_info[i].chidrens, element_to_appended)
				}
			}
		}
	},

	add_node_functionality: function (add_button_node) {
		var self = this;
		add_button_node.addEventListener("click", function () {
			var appended_node = this.parentNode.parentNode.getElementsByTagName('ul')[0];
			if (typeof (appended_node) != 'undefined' && appended_node != null) {
				this.parentNode.parentNode.getElementsByTagName('ul')[0].appendChild(self.tree_node_element(false));
			} else {
				this.parentNode.parentNode.appendChild(self.tree_node_element(true));
			}

		});
	},

	add_brother_node_functionality: function (add_button_node, left = true) {
		var self = this;
		add_button_node.addEventListener("click", function () {
			var target_element = this.parentNode.parentNode;
			if (left) {
				target_element.parentNode.insertBefore(self.tree_node_element(false), target_element);
			} else {
				target_element.parentNode.insertBefore(self.tree_node_element(false), target_element.nextSibling);
			}
		});
	},

	remove_node_functionality: function (node) {
		node.addEventListener("click", function () {
			var conf_answer;
			if (node.parentNode.parentNode.getElementsByTagName('ul').length > 0) {
				var conf_answer = confirm("Important! If you delete this element, then other elements under the following element will be removed as well.");
				if (conf_answer == false)
					return false;
			}
			parentNodeUl = node.parentNode.parentNode.parentNode;
			if (parentNodeUl.getElementsByTagName('li').length == 1) {
				parentNodeUl.parentNode.removeChild(parentNodeUl)
			} else {
				parentNodeUl.removeChild(node.parentNode.parentNode);
			}
		});
	},

	edit_node_functionality: function (node) {
		var self = this;
		node.addEventListener("click", function () {
			self.current_edited_element = this.parentNode;
			self.wpdevart_create_popup();
		});
	},

	wpdevart_create_popup: function () {
		var self = this;
		var overlay = this.createHtmlElement('div', { 'class': 'wpdevart_overlay' });
		var container = this.createHtmlElement('div', { 'class': 'wpdevart_popup_container' });
		var header_line = this.createHtmlElement('div', { 'class': 'wpdevart_popup_header_line' });
		var header_line_text = this.createHtmlElement('span', {}, 'Edit the element information');
		var close_button = this.createHtmlElement('button', {}, 'x');

		//connect elements together		
		document.body.appendChild(container);
		document.body.appendChild(overlay);
		container.appendChild(header_line);
		header_line.appendChild(header_line_text);
		header_line.appendChild(close_button);
		container.appendChild(self.createPopupInnerHtml());

		//set functionality		
		close_button.addEventListener('click', function () {
			self.wpdevart_remove_popup();
		});
		overlay.addEventListener('click', function () {
			self.wpdevart_remove_popup();
		});
		self.add_tab_functionality();
		var mediaUploader;
		document.getElementById('wpdevart_upload_button_image_for_tree').addEventListener('click', function (e) {
			e.preventDefault();
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}
			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				}, multiple: false
			});
			mediaUploader.on('select', function () {
				var attachment = mediaUploader.state().get('selection').first().toJSON();
				document.getElementById('wpdevart_upload_image_for_tree').value = attachment.url;
			});
			mediaUploader.open();
		});
		document.getElementById('node_url_all_item').addEventListener('click', function (e) {
			if (document.getElementById('node_url_all_item').checked) {
				document.getElementById('node_url_image').checked = true;
				document.getElementById('node_url_title').checked = true;
				document.getElementById('node_url_description').checked = true;
			}
		});
		document.getElementById('node_popup_all_item').addEventListener('click', function (e) {
			if (document.getElementById('node_popup_all_item').checked) {
				document.getElementById('node_popup_image').checked = true;
				document.getElementById('node_popup_title').checked = true;
				document.getElementById('node_popup_description').checked = true;
			}
		});
		document.getElementById('wpdevart_update_tree_info').addEventListener('click', function (e) {
			self.update_tree_node_info();
			self.wpdevart_remove_popup();
		});

		self.write_node_info_inside_popup();
		// switch from textarea to html in tinymce
		this.goEditorToTMCE();
	},

	createPopupInnerHtml: function () {
		var self = this;
		let tabsContainer = this.createHtmlElement('div', { 'id': 'wpdevart-popup-tabs-container', 'class': 'div-for-clear' });
		let tabsLinksContainer = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tabs', 'class': 'div-for-clear' });
		let tabsLinkInfo = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tab-info', 'class': 'wpdevart_tab show' }, "Information");
		let tabsLinkPopup = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tab-popup', 'class': 'wpdevart_tab' }, "Popup");
		let tabsLinkStyle = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tab-style', 'class': 'wpdevart_tab' }, "Styling");
		let tabsContentsContainer = this.createHtmlElement('div', { 'id': 'wpdevart-tabs-item-container', 'class': 'div-for-clear' });
		let tabsContentInfo = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tab-info_container', 'class': 'wpdevart_container wpdevart-item-section', 'style': 'display: block' });
		let tabsContentPopup = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tab-popup_container', 'class': 'wpdevart_container wpdevart-item-section' });
		let tabsContentStyle = this.createHtmlElement('div', { 'id': 'wpdevart_popup-tab-style_container', 'class': 'wpdevart_container wpdevart-item-section' });
		// Image parameter
		let infoParamImg = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamImgDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamImgDescSpan = this.createHtmlElement('span', {}, 'Type the URL');
		let infoParamImgParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamImgParamInput = this.createHtmlElement('input', { 'id': 'wpdevart_upload_image_for_tree', 'type': 'text' });
		let infoParamImgParamButton = this.createHtmlElement('button', { 'id': 'wpdevart_upload_button_image_for_tree', 'class': 'button' }, 'Upload');
		infoParamImg.appendChild(infoParamImgDesc);
		infoParamImg.appendChild(infoParamImgParam);
		infoParamImgDesc.appendChild(infoParamImgDescSpan);
		infoParamImgParam.appendChild(infoParamImgParamInput);
		infoParamImgParam.appendChild(infoParamImgParamButton);
		// Title parameter		
		let infoParamTitle = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamTitleDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamTitleDescSpan = this.createHtmlElement('span', {}, 'Type the title');
		let infoParamTitleParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamTitleParamInput = this.createHtmlElement('input', { 'id': 'node_title', 'type': 'text', 'class': 'title_input' });
		infoParamTitle.appendChild(infoParamTitleDesc);
		infoParamTitle.appendChild(infoParamTitleParam);
		infoParamTitleDesc.appendChild(infoParamTitleDescSpan);
		infoParamTitleParam.appendChild(infoParamTitleParamInput);
		// Description parameter
		let infoParamDescription = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamDescriptionDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamDescriptionDescSpan = this.createHtmlElement('span', {}, 'Type the description');
		let infoParamDescriptionParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamDescriptionParamTextarea = this.createHtmlElement('textarea', { 'id': 'node_description' });
		infoParamDescription.appendChild(infoParamDescriptionDesc);
		infoParamDescription.appendChild(infoParamDescriptionParam);
		infoParamDescriptionDesc.appendChild(infoParamDescriptionDescSpan);
		infoParamDescriptionParam.appendChild(infoParamDescriptionParamTextarea);
		// Link parameter
		let infoParamUrl = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamUrlDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamUrlDescSpan = this.createHtmlElement('span', {}, 'Type a Url');
		let infoParamUrlParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamUrlParamInput = this.createHtmlElement('input', { 'id': 'node_url', 'type': 'text', 'class': 'title_input' });
		infoParamUrl.appendChild(infoParamUrlDesc);
		infoParamUrl.appendChild(infoParamUrlParam);
		infoParamUrlDesc.appendChild(infoParamUrlDescSpan);
		infoParamUrlParam.appendChild(infoParamUrlParamInput);
		// Link area parameter
		let infoParamLinkArea = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamLinkAreaDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamLinkAreaDescSpan = this.createHtmlElement('span', {}, 'Select the link area');
		let infoParamLinkAreaParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamLinkAreaParamCheckboxAll = this.createHtmlElement('input', { 'id': 'node_url_all_item', 'type': 'checkbox', 'value': 'all' });
		let infoParamLinkAreaParamLabelAll = this.createHtmlElement('label', { 'for': 'node_url_all_item' }, 'All item');
		let infoParamLinkAreaParamCheckboxImage = this.createHtmlElement('input', { 'id': 'node_url_image', 'type': 'checkbox', 'value': 'image' });
		let infoParamLinkAreaParamLabelImage = this.createHtmlElement('label', { 'for': 'node_url_image' }, 'Image');
		let infoParamLinkAreaParamCheckboxTitle = this.createHtmlElement('input', { 'id': 'node_url_title', 'type': 'checkbox', 'value': 'title' });
		let infoParamLinkAreaParamLabelTitle = this.createHtmlElement('label', { 'for': 'node_url_title' }, 'Title');
		let infoParamLinkAreaParamCheckboxDesc = this.createHtmlElement('input', { 'id': 'node_url_description', 'type': 'checkbox', 'value': 'description' });
		let infoParamLinkAreaParamLabelDesc = this.createHtmlElement('label', { 'for': 'node_url_description' }, 'Description');
		infoParamLinkArea.appendChild(infoParamLinkAreaDesc);
		infoParamLinkArea.appendChild(infoParamLinkAreaParam);
		infoParamLinkAreaDesc.appendChild(infoParamLinkAreaDescSpan);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamCheckboxAll);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamLabelAll);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamCheckboxImage);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamLabelImage);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamCheckboxTitle);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamLabelTitle);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamCheckboxDesc);
		infoParamLinkAreaParam.appendChild(infoParamLinkAreaParamLabelDesc);
		// Link in new tab parameter
		let infoParamLinkNewTab = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamLinkNewTabDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamLinkNewTabDescSpan = this.createHtmlElement('span', {}, 'Open the URL in a new tab');
		let infoParamLinkNewTabParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamLinkNewTabParamCheckbox = this.createHtmlElement('input', { 'id': 'node_url_open_new_tab', 'type': 'checkbox', 'value': 'yes' });
		let infoParamLinkNewTabParamLabel = this.createHtmlElement('label', { 'for': 'node_url_open_new_tab' }, 'Yes');
		infoParamLinkNewTab.appendChild(infoParamLinkNewTabDesc);
		infoParamLinkNewTab.appendChild(infoParamLinkNewTabParam);
		infoParamLinkNewTabDesc.appendChild(infoParamLinkNewTabDescSpan);
		infoParamLinkNewTabParam.appendChild(infoParamLinkNewTabParamCheckbox);
		infoParamLinkNewTabParam.appendChild(infoParamLinkNewTabParamLabel);
		// responsive after element
		let infoParamResponsiveAfterElement = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let infoParamResponsiveAfterElementDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let infoParamResponsiveAfterElementDescSpan = this.createHtmlElement('span', {}, 'Responsive view after this element');
		let infoParamResponsiveAfterElementParam = this.createHtmlElement('div', { 'class': 'param' });
		let infoParamResponsiveAfterElementParamCheckbox = this.createHtmlElement('input', { 'id': 'node_responsive_after_element', 'type': 'checkbox', 'value': 'yes' });
		let infoParamResponsiveAfterElementParamLabel = this.createHtmlElement('label', { 'for': 'node_responsive_after_element' }, 'Yes');
		infoParamResponsiveAfterElement.appendChild(infoParamResponsiveAfterElementDesc);
		infoParamResponsiveAfterElement.appendChild(infoParamResponsiveAfterElementParam);
		infoParamResponsiveAfterElementDesc.appendChild(infoParamResponsiveAfterElementDescSpan);
		infoParamResponsiveAfterElementParam.appendChild(infoParamResponsiveAfterElementParamCheckbox);
		infoParamResponsiveAfterElementParam.appendChild(infoParamResponsiveAfterElementParamLabel);
		this.setElementPro(infoParamResponsiveAfterElementParamCheckbox);
		// Popup area parameter
		let popupParamPopupArea = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let popupParamPopupAreaDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let popupParamPopupAreaDescSpan = this.createHtmlElement('span', {}, 'Select the Popup area');
		let popupParamPopupAreaParam = this.createHtmlElement('div', { 'class': 'param' });
		let popupParamPopupAreaParamCheckboxAll = this.createHtmlElement('input', { 'id': 'node_popup_all_item', 'type': 'checkbox', 'value': 'all' });
		let popupParamPopupAreaParamLabelAll = this.createHtmlElement('label', { 'for': 'node_popup_all_item' }, 'All item');
		let popupParamPopupAreaParamCheckboxImage = this.createHtmlElement('input', { 'id': 'node_popup_image', 'type': 'checkbox', 'value': 'image' });
		let popupParamPopupAreaParamLabelImage = this.createHtmlElement('label', { 'for': 'node_popup_image' }, 'Image');
		let popupParamPopupAreaParamCheckboxTitle = this.createHtmlElement('input', { 'id': 'node_popup_title', 'type': 'checkbox', 'value': 'title' });
		let popupParamPopupAreaParamLabelTitle = this.createHtmlElement('label', { 'for': 'node_popup_title' }, 'Title');
		let popupParamPopupAreaParamCheckboxDesc = this.createHtmlElement('input', { 'id': 'node_popup_description', 'type': 'checkbox', 'value': 'description' });
		let popupParamPopupAreaParamLabelDesc = this.createHtmlElement('label', { 'for': 'node_popup_description' }, 'Description');
		popupParamPopupArea.appendChild(popupParamPopupAreaDesc);
		popupParamPopupArea.appendChild(popupParamPopupAreaParam);
		popupParamPopupAreaDesc.appendChild(popupParamPopupAreaDescSpan);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamCheckboxAll);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamLabelAll);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamCheckboxImage);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamLabelImage);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamCheckboxTitle);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamLabelTitle);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamCheckboxDesc);
		popupParamPopupAreaParam.appendChild(popupParamPopupAreaParamLabelDesc);
		// popup theme
		let popupParamSelectTheme = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let popupParamSelectThemeDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let popupParamSelectThemeSpan = this.createHtmlElement('span', {}, 'Select the popup theme');
		let popupParamSelectThemeParam = this.createHtmlElement('div', { 'class': 'param' });
		popupParamSelectTheme.appendChild(popupParamSelectThemeDesc);
		popupParamSelectTheme.appendChild(popupParamSelectThemeParam);
		popupParamSelectThemeDesc.appendChild(popupParamSelectThemeSpan);
		popupParamSelectThemeParam.innerHTML = self.popup_select;

		// Popup html parameter
		let popupParamHtml = this.createHtmlElement('div', { 'class': 'parameter_line param_line_full_width' });
		let popupParamHtmlDesc = this.createHtmlElement('div', { 'class': 'param_desc param_desc_top' });
		let popupParamHtmlDescSpan = this.createHtmlElement('span', {}, 'Popup message');
		let popupParamHtmlParam = this.createHtmlElement('div', { 'id': 'org_chart_popup_popup_param_container', 'class': 'param' });
		let popupParamHtmlParamTextarea = this.getTemporaryEditor();
		popupParamHtml.appendChild(popupParamHtmlDesc);
		popupParamHtml.appendChild(popupParamHtmlParam);
		popupParamHtmlDesc.appendChild(popupParamHtmlDescSpan);
		popupParamHtmlParam.appendChild(popupParamHtmlParamTextarea);

		// theme parameter
		let styleParamSelectTheme = this.createHtmlElement('div', { 'class': 'parameter_line' });
		let styleParamSelectThemeDesc = this.createHtmlElement('div', { 'class': 'param_desc' });
		let styleParamSelectThemeSpan = this.createHtmlElement('span', {}, 'Select the theme');
		let styleParamSelectThemeParam = this.createHtmlElement('div', { 'class': 'param' });
		styleParamSelectTheme.appendChild(styleParamSelectThemeDesc);
		styleParamSelectTheme.appendChild(styleParamSelectThemeParam);
		styleParamSelectThemeDesc.appendChild(styleParamSelectThemeSpan);
		styleParamSelectThemeParam.innerHTML = self.themes_select;
		//button for update
		let updateButtonContainer = this.createHtmlElement('div');
		let updateButtonButton = this.createHtmlElement('button', { 'id': 'wpdevart_update_tree_info', 'class': 'button-primary action wpdevart_popup_update' }, 'Update');
		updateButtonContainer.appendChild(updateButtonButton);
		// connect elements together
		tabsContainer.appendChild(tabsLinksContainer);
		tabsContainer.appendChild(tabsContentsContainer);
		tabsLinksContainer.appendChild(tabsLinkInfo);
		tabsLinksContainer.appendChild(tabsLinkPopup);
		tabsLinksContainer.appendChild(tabsLinkStyle);
		tabsContentsContainer.appendChild(tabsContentInfo);
		tabsContentsContainer.appendChild(tabsContentPopup);
		tabsContentsContainer.appendChild(tabsContentStyle);
		tabsContentInfo.appendChild(infoParamImg);
		tabsContentInfo.appendChild(infoParamTitle);
		tabsContentInfo.appendChild(infoParamDescription);
		tabsContentInfo.appendChild(infoParamUrl);
		tabsContentInfo.appendChild(infoParamLinkArea);
		tabsContentInfo.appendChild(infoParamLinkNewTab);
		tabsContentInfo.appendChild(infoParamResponsiveAfterElement);
		tabsContentPopup.appendChild(popupParamPopupArea);
		tabsContentPopup.appendChild(popupParamSelectTheme);
		tabsContentPopup.appendChild(popupParamHtml);
		tabsContentStyle.appendChild(styleParamSelectTheme);
		tabsContentsContainer.appendChild(updateButtonContainer);
		return tabsContainer;
	},
	// fill info form node to popup for editing node
	write_node_info_inside_popup: function () {
		var self = this, title = 'Title', desc = 'Description', image_url = this.default_info.image_url, theme = '0', node_url = '', node_url_open_area = { 'item': false, 'image': false, 'title': false, 'desc': false }, popup_html = '', popup_area = { 'item': false, 'image': false, 'title': false, 'desc': false }, popup_theme = '0', node_responsive_after_element = false, node_url_open_new_tab = false;
		if (self.current_edited_element != null) {
			var info_string = self.current_edited_element.getElementsByClassName('wpdevart_node_info')[0].value;
			if (info_string != '') {
				var info_obj = JSON.parse(info_string)
				title = info_obj['node_title']
				desc = info_obj['node_description']
				image_url = info_obj['image_url']
				theme = info_obj['theme']
				//check link in tree info
				if ('node_url' in info_obj) {
					node_url = info_obj['node_url']
				}
				//check link area in tree info
				if ('node_url_o_a' in info_obj) {
					if ('item' in info_obj['node_url_o_a'])
						node_url_open_area['item'] = info_obj['node_url_o_a']['item'];
					if ('image' in info_obj['node_url_o_a'])
						node_url_open_area['image'] = info_obj['node_url_o_a']['image'];
					if ('title' in info_obj['node_url_o_a'])
						node_url_open_area['title'] = info_obj['node_url_o_a']['title'];
					if ('desc' in info_obj['node_url_o_a'])
						node_url_open_area['desc'] = info_obj['node_url_o_a']['desc'];
				}
				//check link in new tab in tree info
				if ('node_url_o_n_t' in info_obj) {
					node_url_open_new_tab = info_obj['node_url_o_n_t']
				}
				//check link in new tab in tree info
				if ('node_responsive_after' in info_obj) {
					node_responsive_after_element = info_obj['node_responsive_after']
				}
				//check link in new tab in tree info
				if ('popup_o_a' in info_obj) {
					if ('item' in info_obj['popup_o_a'])
						popup_area['item'] = info_obj['popup_o_a']['item'];
					if ('image' in info_obj['popup_o_a'])
						popup_area['image'] = info_obj['popup_o_a']['image'];
					if ('title' in info_obj['popup_o_a'])
						popup_area['title'] = info_obj['popup_o_a']['title'];
					if ('desc' in info_obj['popup_o_a'])
						popup_area['desc'] = info_obj['popup_o_a']['desc'];
				}
				//check link in tree info
				if ('popup_html' in info_obj) {
					popup_html = info_obj['popup_html']
				}
				if ('popup_theme' in info_obj) {
					popup_theme = info_obj['popup_theme']
				}

			}
		}
		document.getElementById('wpdevart_upload_image_for_tree').value = image_url;
		document.getElementById('node_title').value = title;
		document.getElementById('node_description').value = desc;
		document.getElementById('node_url').value = node_url;
		//check already checked link area
		if (node_url_open_area['item'] === "1" || node_url_open_area['item'] === true)
			document.getElementById('node_url_all_item').checked = true;
		if (node_url_open_area['image'] === "1" || node_url_open_area['image'] === true)
			document.getElementById('node_url_image').checked = true;
		if (node_url_open_area['title'] === "1" || node_url_open_area['title'] === true)
			document.getElementById('node_url_title').checked = true;
		if (node_url_open_area['desc'] === "1" || node_url_open_area['desc'] === true)
			document.getElementById('node_url_description').checked = true;
		if (node_url_open_new_tab === "1" || node_url_open_new_tab === true)
			document.getElementById('node_url_open_new_tab').checked = true;
		if (node_responsive_after_element === "1" || node_responsive_after_element === true)
			document.getElementById('node_responsive_after_element').checked = true;
		//check already checked popup area
		if (popup_area['item'] === "1" || popup_area['item'] === true)
			document.getElementById('node_popup_all_item').checked = true;
		if (popup_area['image'] === "1" || popup_area['image'] === true)
			document.getElementById('node_popup_image').checked = true;
		if (popup_area['title'] === "1" || popup_area['title'] === true)
			document.getElementById('node_popup_title').checked = true;
		if (popup_area['desc'] === "1" || popup_area['desc'] === true)
			document.getElementById('node_popup_description').checked = true;
		this.setTemporaryEditorValue(popup_html);
		document.getElementById('node_theme').value = theme;
		document.getElementById('node_popup_theme').value = popup_theme;
	},
	// update node information coming from popup
	update_tree_node_info: function () {
		var self = this, info_array = {};
		info_array['image_url'] = document.getElementById('wpdevart_upload_image_for_tree').value;
		info_array['node_title'] = document.getElementById('node_title').value;
		info_array['node_description'] = document.getElementById('node_description').value;
		info_array['node_url'] = document.getElementById('node_url').value;
		//o_a is open area
		info_array['node_url_o_a'] = {};
		info_array['node_url_o_a']['item'] = document.getElementById('node_url_all_item').checked;
		info_array['node_url_o_a']['image'] = document.getElementById('node_url_image').checked;
		info_array['node_url_o_a']['title'] = document.getElementById('node_url_title').checked;
		info_array['node_url_o_a']['desc'] = document.getElementById('node_url_description').checked;
		//o_a for popup		
		info_array['popup_o_a'] = {};
		info_array['popup_o_a']['item'] = document.getElementById('node_popup_all_item').checked;
		info_array['popup_o_a']['image'] = document.getElementById('node_popup_image').checked;
		info_array['popup_o_a']['title'] = document.getElementById('node_popup_title').checked;
		info_array['popup_o_a']['desc'] = document.getElementById('node_popup_description').checked;
		info_array['popup_html'] = self.getTemporaryEditorValue();
		info_array['popup_theme'] = document.getElementById('node_popup_theme').value;

		info_array['node_url_o_n_t'] = document.getElementById('node_url_open_new_tab').checked;
		info_array['node_responsive_after'] = document.getElementById('node_responsive_after_element').checked;
		info_array['theme'] = document.getElementById('node_theme').value;

		self.current_edited_element.getElementsByTagName('img')[0].setAttribute('src', info_array['image_url']);
		self.current_edited_element.getElementsByClassName('node_title')[0].innerHTML = info_array['node_title'];
		self.current_edited_element.getElementsByClassName('node_desc')[0].innerHTML = info_array['node_description'];
		self.current_edited_element.getElementsByClassName('wpdevart_node_info')[0].value = JSON.stringify(info_array);
		this.updatePopupLinkIcons(self.current_edited_element, info_array);
	},
	//popup tab functionality
	add_tab_functionality: function () {
		var tabs = document.getElementById('wpdevart_popup-tabs').children;
		for (var i = 0; i < tabs.length; i++) {
			tabs[i].addEventListener('click', function () {
				var container_id = '';
				for (var j = 0; j < tabs.length; j++) {
					tabs[j].setAttribute('class', 'wpdevart_tab');
					container_id = tabs[j].getAttribute('id') + '_container';
					document.getElementById(container_id).style.display = 'none';
				}
				this.setAttribute('class', 'wpdevart_tab show');
				container_id = this.getAttribute('id') + '_container';
				document.getElementById(container_id).style.display = 'block';
			})
		}
	},
	// remove popup
	wpdevart_remove_popup: function () {
		this.removeTemporaryEditor();
		document.getElementsByClassName('wpdevart_overlay')[0].parentNode.removeChild(document.getElementsByClassName('wpdevart_overlay')[0])
		document.getElementsByClassName('wpdevart_popup_container')[0].parentNode.removeChild(document.getElementsByClassName('wpdevart_popup_container')[0]);
		this.current_edited_element = null;
	},
	// make new node
	tree_node_element: function (with_ul = true, info = null) {
		var self = this;
		if (info == null || Object.keys(info).length == 0) {
			info = self.default_info;
		}
		var Ul = this.createHtmlElement('ul');
		var li = this.createHtmlElement('li');
		var Div = this.createHtmlElement('div', { 'class': 'wpdevart_tree_node' });
		var Img = this.createHtmlElement('img', { 'src': info['image_url'] });
		var imgSpan = this.createHtmlElement('span', { 'class': 'node_img' });
		var Br = this.createHtmlElement('br');
		var Button = this.createHtmlElement('button', { 'class': 'add_child_button', 'type': 'button' });
		var Button_bro_right = this.createHtmlElement('button', { 'class': 'add_bro_right', 'type': 'button' });
		var Button_bro_left = this.createHtmlElement('button', { 'class': 'add_bro_left', 'type': 'button' });
		var trash_icon = this.createHtmlElement('span', { 'class': 'dashicons dashicons-trash remove_tree_node' });
		var edit_icon = this.createHtmlElement('span', { 'class': 'dashicons dashicons-edit edit_tree_node' });
		var info_for_node = this.createHtmlElement('input', { 'class': 'wpdevart_node_info', 'type': 'hidden', 'value': JSON.stringify(info) });
		var title = this.createHtmlElement('div', { 'class': 'node_title' }, info['node_title']);
		var description = this.createHtmlElement('div', { 'class': 'node_desc' }, info['node_description']);
		Ul.appendChild(li);
		li.appendChild(Div);
		imgSpan.appendChild(Img);
		Div.appendChild(imgSpan);
		Div.appendChild(Br);
		self.add_brother_node_functionality(Button_bro_right, false);
		self.add_brother_node_functionality(Button_bro_left, true);
		self.add_node_functionality(Button);
		self.remove_node_functionality(trash_icon);
		self.edit_node_functionality(edit_icon);
		Div.appendChild(Button);
		Div.appendChild(Button_bro_right);
		Div.appendChild(Button_bro_left);
		Div.appendChild(trash_icon);
		Div.appendChild(edit_icon);
		Div.appendChild(title);
		Div.appendChild(description);
		Div.appendChild(info_for_node);
		this.updatePopupLinkIcons(Div, info);
		if (with_ul)
			return Ul
		return li
	},
	/*Save*/
	make_from_tree_json: function () {
		var tree = {}, self = this;
		tree_start_node = document.getElementById(self.ids.tree).children[0].children[0].children[0];
		tree = self.get_all_childs(tree_start_node, tree);
		return tree
	},

	get_all_childs: function (node, tree_json) {
		var tree_childs = node.parentNode.parentNode.children, value = '', self = this;
		for (var i = 0; i < tree_childs.length; i++) {
			tree_json[i] = {};
			var node_info = tree_childs[i].children[0].getElementsByClassName('wpdevart_node_info')[0].value;
			if (node_info != '')
				tree_json[i]['node_info'] = JSON.parse(node_info);
			else
				tree_json[i]['node_info'] = {};
			if (typeof (tree_childs[i].children[1]) != 'undefined') {
				tree_json[i]['chidrens'] = self.get_all_childs(tree_childs[i].children[1].children[0].children[0], {});
			} else {
				tree_json[i]['chidrens'] = {};
			}
		}
		return tree_json;
	},
	//editor functions
	checkEditor: function () {
		if (document.getElementById(this.ids.editor) == null || document.getElementById(this.ids.editorhtml) == null || document.getElementById(this.ids.editortmce) == null || typeof (tinymce) == 'undefined') {
			return false;
		}
		return true;
	},

	goEditorToTMCE: function () {
		if (this.checkEditor()) {
			document.getElementById(this.ids.editortmce).click();
		}
	},

	getTemporaryEditor: function () {
		if (!this.checkEditor()) {
			document.getElementById(this.ids.editor_parent).children[0].remove();
			return this.createHtmlElement('textarea', { 'id': this.ids.editor });
		}
		tinymce.remove('#' + this.ids.editor);
		document.getElementById(this.ids.editorhtml).click();
		return document.getElementById('org_chart_tinymce_container').children[0];
	},

	getTemporaryEditorValue: function () {
		if (!this.checkEditor()) {
			return document.getElementById(this.ids.editor).value;
		}
		tinymce.get(this.ids.editor).save();
		return document.getElementById(this.ids.editor).value;
	},

	setTemporaryEditorValue: function (value) {
		if (!this.checkEditor()) {
			document.getElementById(this.ids.editor).value = value
			return null;
		}
		if (tinymce.get(this.ids.editor) == null) {
			document.getElementById(this.ids.editor).value = value
			return null;
		}
		tinymce.get(this.ids.editor).setContent(value);
		tinymce.get(this.ids.editor).save()
	},

	removeTemporaryEditor() {
		document.getElementById(this.ids.editor).value = '';
		if (!this.checkEditor()) {
			return null;
		}
		if (document.getElementById(this.ids.editor).parentElement.parentElement.getAttribute('id') == 'wp-' + this.ids.editor + '-wrap') {
			tinymce.get(this.ids.editor).setContent('');
			tinymce.get(this.ids.editor).save()
			tinymce.remove('#' + this.ids.editor);
			document.getElementById(this.ids.editorhtml).click();
			document.getElementById(this.ids.editor_parent).appendChild(document.getElementById(this.ids.editor).parentElement.parentElement);
		}
	},
	updatePopupLinkIcons: function (node, nodeinfo) {
		this.removeVisualIcon(node);
		if (nodeinfo['popup_html'] != null && nodeinfo['popup_html'] != '') {
			if (nodeinfo['popup_o_a']['item'] == '1' || nodeinfo['popup_o_a']['item'] == true) {
				var popup_icon = this.createHtmlElement('span', { 'class': 'node_popup_icon all_item' });
				node.appendChild(popup_icon);
			}
			if (popup_icon == null) {
				if ((nodeinfo['popup_o_a']['image'] == '1' || nodeinfo['popup_o_a']['image'] == true)) {
					var popup_icon_img = this.createHtmlElement('span', { 'class': 'node_popup_icon img_item' });
					node.getElementsByClassName('node_img')[0].appendChild(popup_icon_img);
				}
				if ((nodeinfo['popup_o_a']['title'] == '1' || nodeinfo['popup_o_a']['title'] == true)) {
					var popup_icon_title = this.createHtmlElement('span', { 'class': 'node_popup_icon title_item' });
					node.getElementsByClassName('node_title')[0].appendChild(popup_icon_title);
				}
				if ((nodeinfo['popup_o_a']['item'] == '1' || nodeinfo['popup_o_a']['desc'] == true)) {
					var popup_icon_description = this.createHtmlElement('span', { 'class': 'node_popup_icon description_item' });
					node.getElementsByClassName('node_desc')[0].appendChild(popup_icon_description);
				}
			}
		}
		if (nodeinfo['node_url'] != null && nodeinfo['node_url'] != '') {
			var additionalClass = '';
			if (nodeinfo['node_url_o_a']['item'] == '1' || nodeinfo['node_url_o_a']['item'] == true) {
				if (popup_icon != null)
					additionalClass = ' move_link_right';
				var link_icon = this.createHtmlElement('span', { 'class': 'node_link_icon all_item' + additionalClass });
				node.appendChild(link_icon);
				additionalClass = '';
			}
			if (link_icon == null) {
				if ((nodeinfo['node_url_o_a']['image'] == '1' || nodeinfo['node_url_o_a']['image'] == true)) {
					if (popup_icon_img != null)
						additionalClass = ' move_link_right';
					var link_icon_img = this.createHtmlElement('span', { 'class': 'node_link_icon img_item' + additionalClass });
					console.log(link_icon_img)
					console.log(node.getElementsByClassName('node_img')[0])
					node.getElementsByClassName('node_img')[0].appendChild(link_icon_img);
					additionalClass = '';
				}
				if ((nodeinfo['node_url_o_a']['title'] == '1' || nodeinfo['node_url_o_a']['title'] == true)) {
					if (popup_icon_title != null)
						additionalClass = ' move_link_right';
					var link_icon_title = this.createHtmlElement('span', { 'class': 'node_link_icon title_item' + additionalClass });
					node.getElementsByClassName('node_title')[0].appendChild(link_icon_title);
					additionalClass = '';
				}
				if ((nodeinfo['node_url_o_a']['item'] == '1' || nodeinfo['node_url_o_a']['desc'] == true)) {
					if (popup_icon_description != null)
						additionalClass = ' move_link_right';
					var link_icon_description = this.createHtmlElement('span', { 'class': 'node_link_icon description_item' + additionalClass });
					node.getElementsByClassName('node_desc')[0].appendChild(link_icon_description);
				}
			}
		}
	},
	removeVisualIcon: function (node) {
		let popup_icons = node.getElementsByClassName('node_popup_icon');
		let link_icons = node.getElementsByClassName('node_link_icon');
		if (popup_icons != null) {
			let count = popup_icons.length;
			for (let i = 0; i < count; i++) {
				popup_icons[0].remove();
			}
		}
		if (link_icons != null) {
			let count = link_icons.length;
			for (let i = 0; i < count; i++) {
				link_icons[0].remove();
			}
		}
	},
	/*###################### HELPER FUNCTIONS ###########################*/
	createHtmlElement: function (tag = "", attr = {}, innerHTML = "") {
		let el = document.createElement(tag);
		for (const key in attr) {
			el.setAttribute(key, attr[key]);
		}
		if (innerHTML != '') {
			el.innerHTML = innerHTML;
		}
		return el;
	},

	setElementPro: function (element) {
		proElementText = this.createHtmlElement('span',{'class':'wpda_pro_feature'},' (Pro)')
		element.parentElement.parentElement.getElementsByClassName('param_desc')[0].appendChild(proElementText);
		element.addEventListener('mousedown', function () {
			alert('If you want to use this feature upgrade to Organization Chart Pro');
			return false;
		})
	}
}



function submitButton(value) {
	if (!wpda_chart_content_loaded) {
		alert('please wait until content load');
		return;
	}
	document.getElementById("adminForm").setAttribute("action", document.getElementById("adminForm").getAttribute("action") + "&task=" + value);
	document.getElementById("wpdevart_chart_tree_all_info").value = JSON.stringify(wpdevart_chart.make_from_tree_json());
	document.getElementById("adminForm").submit();
}

document.addEventListener('DOMContentLoaded', function () {
	wpdevart_chart.start();
	wpda_chart_content_loaded = true;
})
