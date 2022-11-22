<?php

class UniteCreatetorParamsProcessorMultisource{
	
	private $objProcessor;
	private $addon;
	
	
	/**
	 * 
	 * init the class
	 */
	public function init($objProcessor){
		
		$this->objProcessor = $objProcessor;
		$this->addon = $objProcessor->getAddon();
		
	}
	
	
	/**
	 * get multisource data
	 */
	public function getMultisourceSettingsData($value, $name, $processType, $param, $data){
		
		$itemsSource = UniteFunctionsUC::getVal($value, $name."_source");
		
		$response = null;
		
		$imageSize = null;
		if($itemsSource != "items")
			$imageSize = $this->objProcessor->getProcessedItemsData_getImageSize($processType);
		
		$this->itemsImageSize = $imageSize;
		
		switch($itemsSource){
			case "items":
				
				$response = "uc_items";
				
			break;
			case "posts":
				
				//get data from the image size param
				
				$paramPosts = $param;
				$namePosts = $name."_posts";
				
				$paramPosts["name"] = $namePosts;
				$paramPosts["name_listing"] = $name;
				$paramPosts["use_for_listing"] = true;
				
				$dataResponse = $this->objProcessor->getPostListData($value, $paramPosts["name"], $processType, $paramPosts, $data);
				
				$arrPosts = UniteFunctionsUC::getVal($dataResponse, $name."_items");
				
				//shoe meta fields
				$isShowMeta =  UniteFunctionsUC::getVal($value, $name."_show_metafields"); 
				$isShowMeta = UniteFunctionsUC::strToBool($isShowMeta);

				if($isShowMeta == true)
					HelperUC::$operations->putPostsCustomFieldsDebug($arrPosts);
				
				$response = $this->getMultisourceItems_posts($arrPosts, $namePosts, $value);
				
			break;
			case "repeater":
								
				$response = $this->getMultisourceItems_currentPostRepeater($name, $value);
				
			break;
			default:
				UniteFunctionsUC::throwError("Wrong multisource source: $itemsSource");
			break;
		}
		
		$data[$name] = $response;
				
		return($data);
	}
	
	
	/**
	 * add item dafault fields
	 */
	private function getMultisourceItems_posts__add_default_fields($item, $arrItemParams, $arrUsedParams){
		
			foreach($arrItemParams as $param){
				
				$paramName = UniteFunctionsUC::getVal($param, "name");
			
				if(isset($arrUsedParams[$paramName]))
					continue;
				
				$value = UniteFunctionsUC::getVal($param, "default_value");
								
				$item[$paramName] = $value;
				
				$item = $this->objProcessor->getProcessedParamData($item, $value, $param, UniteCreatorParamsProcessorWork::PROCESS_TYPE_OUTPUT);
				
			}
		
		return($item);
	}
	
	
	/**
	 * modify multisource posts items
	 */
	private function getMultisourceItems_posts($arrPosts, $namePosts, $arrValues){
		
		if(empty($arrPosts))
			return(array());
		
		$arrFields = $this->modifyMultisourceItems_getFields($arrValues, $namePosts);
		
		$arrItemParams = $this->addon->getParamsItems();
		
		$arrItemParams = UniteFunctionsUC::arrayToAssoc($arrItemParams,"name");
		
		$arrItems = array();
		
		$arrImageSizes = null;
		if(!empty($this->itemsImageSize))
			$arrImageSizes = array("desktop"=>$this->itemsImageSize);
		
		
		foreach($arrPosts as $index => $post){
			
			$postData = $this->objProcessor->getPostDataByObj($post, null, $arrImageSizes);
			
			$item = array();
			
			$arrUsedParams = array();
			
			foreach($arrFields as $fieldKey => $source){
				
				$paramName = str_replace($namePosts."_field_source_", "", $fieldKey);
				
				$param = UniteFunctionsUC::getVal($arrItemParams, $paramName);
				
				$item = $this->modifyMultisourceItems_getFieldDataFromPost($item, $source, $paramName, $postData, $param, $namePosts, $arrValues, "post");
				
				$arrUsedParams[$paramName] = true;
				
			}
			
			//add other default fields
			
			$item = $this->getMultisourceItems_posts__add_default_fields($item, $arrItemParams);
			
			//add extra fields
			
			$postID = UniteFunctionsUC::getVal($postData, "id");
			
			$item["item_postid"] = $postID;
			
			$arrItems = $this->getMultisourceItems_posts__addItem($arrItems, $item, "post");
			
		}
		
		
		return($arrItems);
	}
	
	/**
	 * get all fields from the values
	 */
	private function modifyMultisourceItems_getFields($arrValues, $namePosts){
		
		$arrFields = array();
		
		foreach($arrValues as $key => $value){
			
			$prefix = $namePosts."_field_source_";
			
			$pos = strpos($key, $prefix);
			
			if($pos === false)
				continue;
			
			$arrFields[$key] = $value;
		}
		
		return($arrFields);
	}
	
	
	/**
	 * modify param value
	 */
	private function modifyMultisourceItems_modifyParamValue($value, $param){
		
		$paramType = UniteFunctionsUC::getVal($param, "type");

		switch($paramType){
			case UniteCreatorDialogParam::PARAM_NUMBER:
			case UniteCreatorDialogParam::PARAM_SLIDER:
				
				//protection - set to default if not numeric
				if(is_string($value) && is_numeric($value) == false){
					
					if(empty($value))
						$value = 0;
					else
						$value = UniteFunctionsUC::getVal($param, "default_value");
					
				}
										
			break;
		}
		
		return($value);
	}
	
	
	/**
	 * get post data by source, modify item
	 */
	private function modifyMultisourceItems_getFieldDataFromPost($item, $source, $fieldName, $postData, $param, $namePosts, $arrValues, $sourceType){
		
		//set as default value
		
		$defaultValue = UniteFunctionsUC::getVal($param, "default_value");
		
		$item[$fieldName] = $defaultValue;
		
		if($source == "default")
			return($item);

		if(empty($postData))
			return($item);
		
		if(!is_array($postData))
			return($item);
		

		//process meta field
			
		$isProcessReturn = false;
			
		if($source == "meta_field"){
			
			$metaField = $namePosts."_field_meta_{$fieldName}";
			
			$metaKey = UniteFunctionsUC::getVal($arrValues, $metaField);
											
			$postID = UniteFunctionsUC::getVal($postData, "id");
			
			$value = $defaultValue;
			
			if(!empty($metaKey)){
				
				$value = UniteFunctionsWPUC::getPostCustomField($postID, $metaKey);
				
			}
				
			$isProcessReturn = true;
		}
		
		if($source == "static_value"){
			
			$staticValueKey = $namePosts."_field_value_{$fieldName}";
			
			$value = UniteFunctionsUC::getVal($arrValues, $staticValueKey);
				
			$isProcessReturn = true;
		}
		
		
		//return the static value or meta field
		
		if($isProcessReturn == true){
			
			$value = $this->modifyMultisourceItems_modifyParamValue($value, $param);
			
			$item[$fieldName] = $value;
			
			//modify the image size
			
			$type = UniteFunctionsUC::getVal($param, "type");
			
			if($type == UniteCreatorDialogParam::PARAM_IMAGE && !empty($this->itemsImageSize)){
				$param["add_image_sizes"] = true;
				$param["value_size"] = $this->itemsImageSize;
				
			}
						
			$item = $this->objProcessor->getProcessedParamData($item, $value, $param, UniteCreatorParamsProcessorWork::PROCESS_TYPE_OUTPUT);
			
			return($item);
		}
		
		//get the source name for field 
		if($source == "field")
			$source = UniteFunctionsUC::getVal($arrValues, $namePosts."_field_name_".$fieldName);

		
		//post values source
		
		foreach($postData as $name => $value){
			
			//if equal - just copy the data
			
			if($name === $source){
				
				$value = $this->modifyMultisourceItems_modifyParamValue($value, $param);
				
				$item[$fieldName] = $value;
				
				$item = $this->objProcessor->getProcessedParamData($item, $value, $param, UniteCreatorParamsProcessorWork::PROCESS_TYPE_OUTPUT);
				
				continue;
			}
						
			//get children fields values
			
			if(strpos($name, $source."_") === 0){
				
				$suffix = substr($name, strlen($source));
				
				$item[$fieldName.$suffix] = $value;				
			}
				
		}
		
		
		
		return($item);
	}
	
	/**
	 * add the item to items list
	 */
	private function getMultisourceItems_posts__addItem($arrItems, $item, $type){
			
			//add extra fields
						
			$item["item_source"] = $type;
			
			//add extra fields
			$elementorID = UniteFunctionsUC::getRandomString(5);
			$item["item_repeater_class"] = "elementor-repeater-item-".$elementorID;
		    
			$arrItems[] = array("item" => $item);
		
		return($arrItems);
	}
	
	
	/**
	 * get data from current post data repeater
	 */
	private function getMultisourceItems_currentPostRepeater($name, $arrValues){
		
		//debug meta
		
		$isShowMeta = UniteFunctionsUC::getVal($arrValues, $name."_show_current_meta");
		$isShowMeta = UniteFunctionsUC::strToBool($isShowMeta);
		
		$post = get_post();
		
		if(empty($post))
			return(false);
			
		$postID = $post->ID;
		
		if($isShowMeta == true){
			HelperUC::$operations->putPostCustomFieldsDebug($postID, true);
		}
		
		$nameParamRepeater = $name."_repeater";
		
		
		
		$repeaterName = UniteFunctionsUC::getVal($arrValues, $name."_repeater_name");
		
		if(empty($repeaterName)){
			
			dmp("items from repeater: please enter repeater name");
			return(array());
		}

		//get the data from repeater
		
		$arrCustomFields = UniteFunctionsWPUC::getPostCustomFields($postID, false);
		
		$arrRepeaterItems = UniteFunctionsUC::getVal($arrCustomFields, $repeaterName);
		
		if(empty($arrRepeaterItems)){
			
			$previewID = UniteFunctionsUC::getGetVar("preview_id","",UniteFunctionsUC::SANITIZE_TEXT_FIELD);

			if(!empty($previewID)){
				dmp("preview data from repeater: you are under elementor preview, the output may be wrong. Please open the post without the preview");
			}
			
			return(array());
		}
		
		if(is_array($arrRepeaterItems) == false)
			return(array());
		
		
		//output the items
		
		$arrItems = array();
		
		$arrFields = $this->modifyMultisourceItems_getFields($arrValues, $nameParamRepeater);
		
		$arrItemParams = $this->addon->getParamsItems();
		$arrItemParams = UniteFunctionsUC::arrayToAssoc($arrItemParams,"name");
		
		foreach($arrRepeaterItems as $index => $repaterItem){
									
			$item = array();
			
			$arrUsedParams = array();
			
			
			foreach($arrFields as $fieldKey => $source){
								
				$paramName = str_replace($nameParamRepeater."_field_source_", "", $fieldKey);
				
				$param = UniteFunctionsUC::getVal($arrItemParams, $paramName);
								
				$item = $this->modifyMultisourceItems_getFieldDataFromPost($item, $source, $paramName, $repaterItem, $param, $nameParamRepeater, $arrValues,"repeater");
				
				$arrUsedParams[$paramName] = true;
				
			}
			
			$item = $this->getMultisourceItems_posts__add_default_fields($item, $arrItemParams, $arrUsedParams);
			
			
			//add the item to items array
			
			$arrItems = $this->getMultisourceItems_posts__addItem($arrItems, $item, "repeater");
			
			
		}
		
		
		return($arrItems);
		
	}
	
	
	
}
