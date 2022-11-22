wpdaAdminLibrary = {
	start: function () {
		var self = this;
		document.addEventListener("DOMContentLoaded", function (event) {
			self.initialWpdaColorGradient();
			self.initialColorInput();
			self.initialSimpleInput();
			self.initialRangeInput();
			self.wpdaMarginPaddingInput();
			self.initialWpdaTabs();
			self.initialPopups();
			self.initialPreviewElements()
			self.wpdaAddProFeature();
			self.wpdaShowHideByValue();
		});
	},

	initialWpdaColorGradient: function () {
		var elements = document.getElementsByClassName('wpda_option wpda_color_gradient');
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.gradientColorInput(elements[i]);
		}
	},

	initialColorInput: function () {
		var elements = document.getElementsByClassName('wpda_option wpda_color_input');
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.colorInput(elements[i]);
		}
	},

	initialPopups: function () {
		var elements = document.getElementsByClassName('wpda_option wpda_popup');
		if (typeof (elements[0]) === 'undefined') {
			return false;
		}
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.popup(elements[i]);
		}
	},

	initialWpdaTabs: function () {
		var elements = document.getElementsByClassName('wpda_tab_container');
		if (typeof (elements[0]) === 'undefined') {
			return false;
		}
		wpdaAdminLibraryHelper.wpdaTabs(elements[0]);
	},

	initialPreviewElements: function () {
		var elements = document.getElementsByClassName('with_preview');
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.connectElementToStyle(elements[i]);
		}
	},

	initialSimpleInput: function () {
		var elements = document.getElementsByClassName('wpda_option wpda_simple_input');
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.wpdaSimpleInput(elements[i]);
		}
	},

	initialRangeInput: function () {
		var elements = document.getElementsByClassName('wpda_option wpda_range_input');
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.wpdaRangeInput(elements[i]);
		}
	},

	wpdaMarginPaddingInput: function () {
		var elements = document.getElementsByClassName('wpda_option wpda_margin_padding_input');
		for (let i = 0; i < elements.length; i++) {
			wpdaAdminLibraryHelper.wpdaSimpleInput(elements[i]);
		}
	},

	wpdaAddProFeature: function () {
		var elements = document.getElementsByClassName('wpda_pro_option');
		for (let i = 0; i < elements.length; i++) {
			elements[i].addEventListener('click', function () {
				alert('If you want to use this feature upgrade to Organization Chart Pro');
				return false;
			})
		}
	},
	wpdaShowHideByValue: function () {
		var elements = document.getElementsByClassName('wpda_option condition_element');
		for (let i = 0; i < elements.length; i++) {
			let conditionElements = JSON.parse(elements[i].getAttribute('data-condition'));
			wpdaAdminLibraryHelper.wpdaConditionCheckElement(elements[i], conditionElements);
			wpdaAdminLibraryHelper.wpdaConditionElementOnchange(elements[i], conditionElements);
		}
	}

}

/*########################### Helper function for lib ################################*/
wpdaAdminLibraryHelper = {

	gradientColorInput: function (mainDiv) {
		// this function uses jquery
		jQuery(mainDiv).find('input.color').wpColorPicker();
		if (jQuery(mainDiv).find('select').eq(0).val() == 'none') {
			jQuery(mainDiv).find('select').eq(0).parent().children().eq(1).hide();
		}
		jQuery(mainDiv).find('select').eq(0).change(function () {
			if (jQuery(this).val() == 'none') {
				jQuery(this).parent().children().eq(1).hide();
			} else {
				jQuery(this).parent().children().eq(1).show();
			}
		});
	},

	colorInput: function (mainDiv) {
		jQuery(mainDiv).find('input.color').wpColorPicker({
			change: function (event, ui) {
				var color = ui.color.toString();
				if (jQuery(event.target).hasClass('with_preview')) {
					var targetElId = jQuery(event.target).attr('data-preview-id');
					var targetElCss = jQuery(event.target).attr('data-preview-action');
					jQuery('#' + targetElId).css(targetElCss, color);
				}
			},
		});
	},

	popup: function (mainDiv) {
		mainDiv.getElementsByClassName('wpda_popup_o_c_button')[0].addEventListener('click', function (e) {
			if (this.parentElement.getElementsByClassName('wpda_popup_window')[0].style.display == 'inline-block') {
				this.parentElement.getElementsByClassName('wpda_popup_window')[0].style.display = 'none';
			} else {
				this.parentElement.getElementsByClassName('wpda_popup_window')[0].style.display = 'inline-block';
			}
		})
	},

	wpdaTabs: function (mainDiv) {
		var linkElements = new Array();
		var tableElements = new Array();
		var currentAdminPage = window.location.search.replace('?', '').split('&')[0].split('=')[1];
		linkElements = filterByTag(filterByTag(filterByTag(mainDiv.children, 'div')[0].children, 'ul')[0].children, 'li');
		tableElements = filterByTag(filterByTag(mainDiv.children, 'div')[1].children, 'div');

		for (let i = 0; i < linkElements.length; i++) {
			linkElements[i].addEventListener('click', function () {
				for (let j = 0; j < linkElements.length; j++) {
					linkElements[j].classList.remove('active');
					tableElements[j].classList.remove('active');
				}
				linkElements[i].classList.add('active');
				tableElements[i].classList.add('active');
				saveLastOpenTab(i)
			})
		}
		openLastOpenTab();
		function saveLastOpenTab(tabIndex) {
			var storage = localStorage.getItem('wpdaLibraryTabs')
			if (storage != null) {
				storage = JSON.parse(storage);
				storage[currentAdminPage] = tabIndex;
			} else {
				storage = {};
				storage[currentAdminPage] = tabIndex;
			}
			localStorage.setItem('wpdaLibraryTabs', JSON.stringify(storage));
		}
		function openLastOpenTab() {
			var storage = JSON.parse(localStorage.getItem('wpdaLibraryTabs')), Index = 0;
			if (storage !== null && typeof (storage[currentAdminPage]) != 'undefined') {
				Index = storage[currentAdminPage];
			}
			mainDiv.getElementsByClassName('wpda_links_container')[0].getElementsByTagName('li')[Index].click();
		}
		function filterByTag(elements, tagName) {
			var filteredElements = new Array();
			for (var i = 0; i < elements.length; i++) {
				if (elements[i].tagName.toLowerCase() === tagName) {
					filteredElements.push(elements[i]);
				}
			}
			return filteredElements;
		}
	},

	connectElementToStyle: function (element) {
		var connectElemId = element.getAttribute('data-preview-id');
		var connectElemStyle = element.getAttribute('data-preview-action');
		connectElemStyleInJs = '';
		for (let i = 0; i < connectElemStyle.length; i++) {
			if (connectElemStyle[i] == '-') {
				connectElemStyle = connectElemStyle.slice(0, i) + connectElemStyle[i + 1].toUpperCase() + connectElemStyle.slice(i + 2);
			}
		}
		if (element.tagName == 'SELECT') {
			element.addEventListener('change', function () {
				document.getElementById(connectElemId).style[connectElemStyle] = element.value;
			})
			document.getElementById(connectElemId).style[connectElemStyle] = element.value;
		}
		if (element.tagName == 'INPUT' && !element.classList.contains("color")) {
			let metric = '';
			if (element.parentElement.getElementsByClassName('wpda_input_metric').length > 0) {
				let inputMetric = element.parentElement.getElementsByClassName('wpda_input_metric')[0];
				inputMetric.addEventListener('change', function () {
					if ((!isNaN(parseFloat(element.value)) && isFinite(element.value)) && element.value != '' && element.parentElement.getElementsByClassName('wpda_input_metric').length > 0) {
						metric = element.parentElement.getElementsByClassName('wpda_input_metric')[0].value;
					}
					document.getElementById(connectElemId).style[connectElemStyle] = element.value + metric;
				});
			}
			element.addEventListener('input', function () {
				let metric = '';
				if ((!isNaN(parseFloat(element.value)) && isFinite(element.value)) && element.value != '' && element.parentElement.getElementsByClassName('wpda_input_metric').length > 0) {
					metric = element.parentElement.getElementsByClassName('wpda_input_metric')[0].value;
				}
				document.getElementById(connectElemId).style[connectElemStyle] = element.value + metric;
			});
			if ((!isNaN(parseFloat(element.value)) && isFinite(element.value)) && element.value != '' && element.parentElement.getElementsByClassName('wpda_input_metric').length > 0) {
				metric = element.parentElement.getElementsByClassName('wpda_input_metric')[0].value;
			}
			document.getElementById(connectElemId).style[connectElemStyle] = element.value + metric;
		}
		if (element.classList.contains("color")) {
			document.getElementById(connectElemId).style[connectElemStyle] = element.value;
		}
	},

	wpdaSimpleInput: function (mainDiv) {
		if (mainDiv.getElementsByClassName('wpda_responsive_select').length > 0) {
			var responsiveSelect = mainDiv.getElementsByClassName('wpda_responsive_select')[0];
			let selectedIndex = 0;
			responsiveSelect.addEventListener('change', function () {
				let selectedIndex = 0;
				if (typeof (this.selectedIndex) != 'undefined') {
					selectedIndex = this.selectedIndex
				}
				showCurDeviceInput(selectedIndex);
			})
			showCurDeviceInput(selectedIndex);
		}

		function showCurDeviceInput(index) {
			let inputs = mainDiv.getElementsByClassName('responsive_elements_coneitner');
			for (let i = 0; i < inputs.length; i++) {
				inputs[i].style.display = 'none';
			}
			inputs[index].style.display = 'block';
		}
	},

	wpdaRangeInput: function (mainDiv) {
		mainDiv.getElementsByTagName('input')[0].addEventListener('input', function () {
			mainDiv.getElementsByTagName('output')[0].innerHTML = this.value;
		})
	},

	wpdaMarginPaddingInput: function (mainDiv) {
		if (mainDiv.getElementsByClassName('wpda_responsive_select').length > 0) {
			var responsiveSelect = mainDiv.getElementsByClassName('wpda_responsive_select')[0];
			let selectedIndex = 0;
			responsiveSelect.addEventListener('change', function () {
				let selectedIndex = 0;
				if (typeof (this.selectedIndex) != 'undefined') {
					selectedIndex = this.selectedIndex
				}
				showCurDeviceInput(selectedIndex);
			})
			showCurDeviceInput(selectedIndex);
		}

		function showCurDeviceInput(index) {
			let inputs = mainDiv.getElementsByClassName('responsive_elements_coneitner');
			for (let i = 0; i < inputs.length; i++) {
				inputs[i].style.display = 'none';
			}
			inputs[index].style.display = 'block';
		}
	},

	/*check condition*/
	wpdaConditionElementOnchange: function (element, conditions) {
		let self = this;
		for (const [key, value] of Object.entries(conditions)) {
			let checkedElement = document.getElementsByName(key);
			if (checkedElement[0] == null) {
				checkedElement = document.getElementsByName(key + '[desktop]');
			}
			if (checkedElement != null) {
				for (let j = 0; j < checkedElement.length; j++) {
					checkedElement[j].addEventListener('change', function () {
						self.wpdaConditionCheckElement(element, conditions);
					})
				}
			}
		}
	},

	wpdaConditionCheckElement: function (element, conditions) {
		let CheckElement = true;
		for (const [key, value] of Object.entries(conditions)) {
			let checkedElement = document.getElementsByName(key);
			if (checkedElement[0] == null) {
				checkedElement = document.getElementsByName(key + '[desktop]');
			}
			let checkedElementValue = '';
			if (checkedElement != null) {
				// if element radio or checkbox
				if (checkedElement.length > 1) {
					for (let j = 0; j < checkedElement.length; j++) {
						if (checkedElement[j].checked) {
							checkedElementValue = checkedElement[j].value;
						}
					}
				} else { // if element input(text number etc...) or select

					checkedElementValue = checkedElement[0].value;

				}
				if (Array.isArray(value)) {
					let cachedValue = false
					for (let k = 0; k < value.length; k++) {
						if (value[k].indexOf('!=') != -1) {
							if (checkedElementValue != value[k].replace('!=', '')) {
								cachedValue = true;
							}
						} else {
							if (checkedElementValue == value[k]) {
								cachedValue = true;
							}
						}
					}
					if (!cachedValue) {
						CheckElement = false;
						break;
					}

				} else {
					if (value.indexOf('!=') != -1) {
						if (checkedElementValue == value.replace('!=', '')) {
							CheckElement = false;
							break;
						}
					} else {
						if (checkedElementValue != value) {
							CheckElement = false;
							break;
						}
					}
				}
			}
		}
		if (CheckElement) {
			element.style.display = 'block';
		} else {
			element.style.display = 'none';
		}
	}
}
wpdaAdminLibrary.start();