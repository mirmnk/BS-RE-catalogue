<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 UAB Verslo vektorius (info@vektorius.lt)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Plugin 'RE catalog' for the 'vv_recatalog' extension.
 *
 * @author	UAB Verslo vektorius <info@vektorius.lt>
 */
#$GLOBALS['TYPO3_DB']->debugOutput = 1;

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once('class.tx_vvrecatalog_utils.php');

class tx_vvrecatalog_pi1 extends tslib_pibase {
	var $tblList = 'tx_vvrecatalog_land,tx_vvrecatalog_flat,tx_vvrecatalog_house,tx_vvrecatalog_homestead,tx_vvrecatalog_accommodation';	
	var $prefixId = 'tx_vvrecatalog_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_vvrecatalog_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'vv_recatalog';	// The extension key.
	var $uplodPath = 'uploads/tx_vvrecatalog/';
	var $pi_checkCHash = TRUE;
	var $arrTables = array( 0 => '',
		1 => 'tx_vvrecatalog_flat',
		2 => 'tx_vvrecatalog_house',
		3 => 'tx_vvrecatalog_land',
		4 => 'tx_vvrecatalog_accommodation',
		5 => 'tx_vvrecatalog_homestead',
	);
	var $arrREObject = array(
		1 => 'flat',
		2 => 'house',
		3 => 'land',
		4 => 'premises',
		5 => 'messuages',
	);

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @param	[type]		$conf: ...
	 * @return	[type]		...
	 */
	function main($content,$conf)	{
			
		$this->conf=$conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_initPIflexForm(); // Init and get the flexform data of the plugin
		$this->pi_loadLL();		// Loading the LOCAL_LANG values

		$this->action = t3lib_div::intInRange($this->piVars['action'], 1, 2, $this->pi_getFFvalue($this->cObj->data['pi_flexform'], "action", "sDEF"));
		$this->REobj  = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], "what_to_display", "sDEF");
		
		 // determin table. showUid is gid.
		if($GLOBALS['TSFE']->type == 3 || $GLOBALS['TSFE']->type == 4) {
			$arrConfig = $this->getByGID();
			$this->piVars['showUid'] = $arrConfig['uid'];
			$this->REobj = $arrConfig['tbl'];
			$this->theTable = $this->arrTables[$this->REobj];
			$this->action = $arrConfig['action'];
		} else {
			$this->theTable =$this->arrTables[$this->REobj];
			if (strstr($this->cObj->currentRecord,'tt_content'))	{
				$this->conf['pidList'] = $this->cObj->data['pages'];
				$this->conf['recursive'] = $this->cObj->data['recursive'];
			}
		}
		return $this->pi_wrapInBaseClass($this->listView($content));
	}

	function getByGID() {
		$gid = $this->piVars['GID'] = intval($this->piVars['showUid']);
		$query = array();
		$retVal = array();
		$uidField = ($GLOBALS['TSFE']->sys_language_content)?'l18n_parent as uid':'uid';
		foreach($this->arrTables as $tId => $table) {
			if($tId) {
				$query[] = '(SELECT '.$uidField.', action, \''.$tId.'\' AS tbl FROM '.$table.' WHERE gid='.$gid.$this->cObj->enableFields($table).')';
			}
		}
		
		$sql = implode(' UNION ', $query);
		
        if($res = $GLOBALS['TYPO3_DB']->sql_query($sql)) {
            $retVal = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
        }
		return $retVal;
	}
	
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @return	[type]		cccc
	 */
	function listView($content)	{
		$lConf = $this->conf['listView.'];	// Local settings for the listView function
		if ($this->piVars['showUid'])	{	// If a single element should be displayed:
			$this->internal['currentTable'] = $this->theTable;
			$strWhere = ($GLOBALS['TSFE']->sys_language_content)?'l18n_parent='.$this->piVars['showUid'].' AND sys_language_uid = '.$GLOBALS['TSFE']->sys_language_content:'uid='.$this->piVars['showUid'];
			$strWhere = ' AND '.$strWhere;
			$this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($this->pi_exec_query($this->theTable,0, $strWhere));
			return $this->singleView($content);
		} else {
			if (!isset($this->piVars['pointer']))	$this->piVars['pointer']=0;
			if (!isset($this->piVars['mode']))	$this->piVars['mode']=1;

				// Initializing the query parameters:
			list($this->internal['orderBy'],$this->internal['descFlag']) = explode(':',$this->piVars['sort']);
			$this->internal['results_at_a_time']=t3lib_div::intInRange($lConf['results_at_a_time'],0,1000,10);		// Number of results to show in a listing.
			$this->internal['maxPages']=t3lib_div::intInRange($lConf['maxPages'],0,1000,1000);		// The maximum number of "pages" in the browse-box: "Page 1", "Page 2", etc.
			$this->internal['searchFieldList']='price,street,city,bdate,roomcnt,afrom,ato';
			$this->internal['orderByList']='price DESC';

			$arrSort = explode("|", $this->piVars['sort']);
			$this->sort = array();
			$sOrderBy = '';
			$arrOrder = array(' ASC', ' DESC');
			$arrOrderBy = array();
			foreach($arrSort as $sItem)
			{
				if(!empty($sItem)) {
					$arrItem = explode(':', $sItem);
					$this->sort[$arrItem[0]] = $arrItem[1];
					$arrOrderBy[] = $arrItem[0].$arrOrder[$arrItem[1]];
				}
			}
			if(!count($this->sort)) {
				$arrOrderBy[] = 'price ASC';
				$this->sort['price'] = 0;
			}

			$sOrderBy .= implode(',', $arrOrderBy);

			$strWhere =	' AND action='.$this->action.
						' AND (sys_language_uid='.$GLOBALS['TSFE']->sys_language_content.' OR sys_language_uid = -1)';
			$strWhere .=(empty($this->piVars['gid']))?$this->getWhere($this->piVars):$this->getWhere(array('gid' => $this->piVars['gid']));

				
			$res = $this->pi_exec_query(
								$this->theTable, 
								1, 
								$strWhere, 
								'', 
								'', 
								$sOrderBy
						);

			list($this->internal['res_count']) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);

			$arrUids = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
												($GLOBALS['TSFE']->sys_language_content)?'l18n_parent AS uid':'uid',
												$this->theTable,
												'1=1'.$strWhere.$this->cObj->enableFields($this->theTable),
												'',
												$sOrderBy
											);
			$GLOBALS["TSFE"]->fe_user->setKey(
										'ses',
										$this->extKey, 
										array('searchResUids' => $arrUids)
							);

				// Make listing query, pass query to SQL database:
			$queryParts = $this->pi_list_query(
									$this->theTable,
									0, 
									$strWhere, 
									'',
									'', 
									$sOrderBy,
									'', 
									TRUE
								);

			if ($GLOBALS['TSFE']->sys_language_content) {
				$queryParts['SELECT'] .= ',l18n_parent AS uid';
			}
#$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
			$res =$GLOBALS['TYPO3_DB']->exec_SELECT_queryArray($queryParts);
			$this->internal['currentTable'] = $this->theTable;
#debug($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);
				// Put the whole list together:
			$fullTable='';	// Clear var;


				// Adds the search box:
			$fullTable.=$this->pi_list_searchBox();


			if(empty($this->internal['res_count'])) {
				$fullTable.=$this->pi_getLL('listFieldHeader_empty');
			} else {

				// Adds the whole list table
				$fullTable.=$this->pi_list_makelist($res);

				$wrapper['disabledLinkWrap'] = '<span class="disabled">|</span>';
				$wrapper['inactiveLinkWrap'] = '<span class="inactive">|</span>';
				$wrapper['activeLinkWrap']	 = '<span class="active">|</span>';
				$wrapper['browseLinksWrap']	 = '<div class="browseresults">|</div>';
				$wrapper['showResultsWrap']	 = '<p>|</p>';
				$wrapper['browseBoxWrap']	 = '';

				$fullTable.=$this->pi_list_browseresults(1, '', $wrapper);
			}

				// Returns the content from the plugin.
			return $fullTable;
		}
	}



	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function getGPSRArr()
	{
		$arrGPSR = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'storage_pid',
			'pages',
			'uid IN ('.$this->cObj->data['pages'].')'.$this->cObj->enableFields('pages')
		);
		$arrPid = array();
		if(is_array($arrGPSR)) {
			foreach($arrGPSR as $pidItem) {
				$arrPid[] = $pidItem['storage_pid'];
			}
		}
		return $arrPid;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$index: ...
	 * @param	[type]		$arrItems: ...
	 * @return	[type]		...
	 */
	function generateJScase($index, $arrItems)
	{
		$content = '';
		$city = $index;
		$content .= chr(10).'case "'.$city.'" :'.chr(10);
		$content .= chr(10).'elDistr.disabled = ""'.chr(10);
		$content .= 'elDistr.options[0] = new Option("", "0")'.chr(10);
		if(!isset($this->piVars['distr'])) {
			$content .= 'elDistr.options[0].selected = true'.chr(10);
		}
		foreach($arrItems as $distr) {
			$content .= 'elDistr.options[elDistr.options.length] = new Option("'.$distr['title'].'", "'.$distr['uid'].'")'.chr(10);
			if($distr['uid'] == $this->piVars['distr'])	{
				$content .= 'elDistr.options[elDistr.options.length-1].selected = true'.chr(10);
			}
		}
		$content .= 'break;';
		return $content;
	}


	function getUidFieldName() {
		return ($GLOBALS['TSFE']->sys_language_content)?'l18n_parent AS uid':'uid';
	}
	
	/**
	 * [Describe function...]
	 *
	 * @return	[type]		...
	 */
	function pi_list_searchBox() {

			// Search box design:
		$arrPid = $this->getGPSRArr();
		
		$newSearch = ($GLOBALS['TSFE']->beUserLogin && ($GLOBALS['BE_USER']->user['username'] == 'mirmnk' || $GLOBALS['BE_USER']->user['username'] == 'vytautas'));
		$newSearch = true;
		
		if($newSearch) {
			require_once(t3lib_extMgm::extPath('vv_rcar').'lib/class.tx_vvrcar_db.php');
			$rcar_db = t3lib_div::makeInstance('tx_vvrcar_db');
		}
		// getting sities
		$arrCities = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$this->pi_prependFieldsWithTable('tx_vvrecatalog_city',$this->getUidFieldName().',title'),
			'tx_vvrecatalog_city',
			'pid IN ('.implode(',',$arrPid ).') AND sys_language_uid='.$GLOBALS['TSFE']->sys_language_content.$this->cObj->enableFields('tx_vvrecatalog_city'),
			'',
			'sorting'
		);

		// getting DISTINCT rooms number among search results
		$arrRooms = array();
                if($this->theTable != 'tx_vvrecatalog_land') {
                    $arrRooms = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                            'DISTINCT roomcount',
                            $this->theTable, 'pid IN ('.$this->cObj->data['pages'].') AND sys_language_uid='.$GLOBALS['TSFE']->sys_language_content.$this->cObj->enableFields($this->theTable),
                            '',
                            'roomcount ASC'
                    );
                }
		$arrLType = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$this->pi_prependFieldsWithTable('tx_vvrecatalog_land_type',$this->getUidFieldName().',title'),
			'tx_vvrecatalog_land_type',
			'pid IN ('.implode(',',$arrPid ).') AND sys_language_uid='.$GLOBALS['TSFE']->sys_language_content.$this->cObj->enableFields('tx_vvrecatalog_land_type'),
			'',
			'sorting'
		);

		$arrLPos = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$this->pi_prependFieldsWithTable('tx_vvrecatalog_land_pos',$this->getUidFieldName().',title'),
			'tx_vvrecatalog_land_pos',
			'pid IN ('.implode(',',$arrPid ).') AND sys_language_uid='.$GLOBALS['TSFE']->sys_language_content.$this->cObj->enableFields('tx_vvrecatalog_land_pos'),
			'',
			'sorting'
		);

		$arrRoomCount = ArraY(Array('uid'=>0, 'title' => strtoupper($this->pi_getLL('choose'))));
		if (is_array($arrRooms)) {
			foreach($arrRooms as $roomCount)
			{
				$arrRoomCount[]=array('uid'=>$roomCount['roomcount'], 'title' => $roomCount['roomcount']);
			}
		}
		$districts = array();
		for($i=0;$i<count($arrCities);$i++) {
			$districts[$arrCities[$i]['uid']] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				$this->pi_prependFieldsWithTable('tx_vvrecatalog_district',$this->getUidFieldName().',title'),
				'tx_vvrecatalog_district',
				'pid IN ('.implode(',',$arrPid ).') AND sys_language_uid='.$GLOBALS['TSFE']->sys_language_content.$this->cObj->enableFields('tx_vvrecatalog_district').' AND city='.$arrCities[$i]['uid'],
				'',
				'title ASC'
			);
		}
		$strCase = 'switch(elem.options[elem.selectedIndex].value)
{';
		foreach($districts as $city =>$distr) {
			if(!empty($distr)) {
				$strCase .= $this->generateJScase($city, $distr);
			}
		}
		$strCase .= ' default:
		elDistr.disabled = "disabled";
		}';

		//after calling fillMarkers we know count and can fill the corresponding js var
		$header  = '<script type="text/javascript" language="javascript">'.chr(10);
		$header .= '<!--'.chr(10);
/*		$header .= '
		window.onload = init;
		
		
		function resetForm(objReset)
		{
			var objForm = objReset.form;
			for(var i=0; i < objForm.elements.length;i++)
			{
				switch(objForm.elements[i].type)
				{
					case "select-one":
						objForm.elements[i].selectedIndex = 0;
						break;
					case "text":
						objForm.elements[i].value = "";
						break;
				}
			}
			return false;
		}
	';*/
	$header .='	
		function changeSelectedOption(elName, selectVal) {
			var objEl = document.forms["search_frm"].elements[elName];
			var selected = 0;
			
			for (var i=0; i < objEl.options.length; i++) {
			    if(selectVal == objEl.options[i].value) {
			    	selected = i;
			    	break;
			    }
			}
			
			objEl.selectedIndex = selected;
		}
	
	
		function spinnerOn() {
			xajax.$(\'srspinner\').style.visibility = \'visible\';
		}

		function spinnerOff() {
			xajax.$(\'srspinner\').style.visibility = \'hidden\';
		}
		
		
	';
/*	$header .='
		function init()
		{
		    select_district(document.forms["search_frm"].elements["'.$this->prefixId.'[city]"])
		}

function select_district(elem){
    var elDistr = elem.form.elements["'.$this->prefixId.'[distr]"];
    for (var i = elDistr.options.length; i > 0; i--) elDistr.options[i] = null;
	if (elem.selectedIndex != -1){
		'.$strCase.'
	}
}';*/
		$header .= '// -->'.chr(10);
		$header .= '</script>'.chr(10);
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = $header;
		
#		t3lib_div::loadTCA($this->theTable);
		$arr = $this->initBEItemArray($GLOBALS['TCA'][$this->theTable]['columns']['installation']);
		$arrInstall = $this->initItemArray($arr);

		$arr = $this->initBEItemArray($GLOBALS['TCA'][$this->theTable]['columns']['state']);
		$arrState = $this->initItemArray($arr);
		
		if($newSearch) {
			$templateCode = $this->cObj->fileResource($this->conf['displayList.']['templates.']['search2']);			
		} else {
			$templateCode = $this->cObj->fileResource($this->conf['displayList.']['templates.']['search']);
		}
		$template = $this->cObj->getSubpart($templateCode, '###TEMPLATE_SEARCH_'.strtoupper($this->arrREObject[$this->REobj]).'###');

		$markerArray = Array (
			'###SEARCH_DIV_CLASS###' => $this->pi_classParam('searchbox'),
			'###SEARCH_FORM_ACTION###' => $this->pi_linkTP_keepPIvars_url(),
			'###HIDDEN_FIELDS###' => '<input type="hidden" name="no_cache" value="1" /><input type="hidden" name="'.$this->prefixId.'[pointer]" value="" />',

			//searchform elements labels

			'###CITY_LABEL###' 		=> $this->pi_getLL('listFieldHeader_city'),
			'###DISTRICT_LABEL###' 	=> $this->pi_getLL('listFieldHeader_district'),
			'###STREET_LABEL###' 	=> $this->pi_getLL('listFieldHeader_street'),
			'###GID_LABEL###' 		=> $this->pi_getLL('listFieldHeader_gid'),

			'###BDATE_LABEL###' 	=> $this->pi_getLL('listFieldHeader_bdate'),
			'###LAND_AREA_LABEL###' => $this->pi_getLL('listFieldHeader_land_area'),
			'###LAND_TYPE_LABEL###' => $this->pi_getLL('listFieldHeader_land_type'),
			'###AREA_LABEL###' 		=> $this->pi_getLL('listFieldHeader_area'),
			'###HOUSE_AREA_LABEL###' => $this->pi_getLL('listFieldHeader_house_area'),
			'###FLOOR_LABEL###' 	=> $this->pi_getLL('listFieldHeader_floor'),
			'###LAND_POS_LABEL###' 	=> $this->pi_getLL('listFieldHeader_land_pos'),
			'###ROOMCOUNT_LABEL###' => $this->pi_getLL('listFieldHeader_roomcount'),
			'###PRICE_LABEL###' 	=> $this->pi_getLL('listFieldHeader_price'),
			'###IRENGIMAS_LABEL###' 	=> $this->pi_field_label('installation'),
			'###BUKLE_LABEL###' 	=> $this->pi_field_label('state'),
		

			//searchform elements


			'###CITY_ELEMENT###' 		=> '<select onchange="select_district(this);" name="'.$this->prefixId.'[city]">'.$this->getItems($arrCities,$this->piVars['city']).'</select>',
			'###LAND_POS_ELEMENT###' 		=> '<select name="'.$this->prefixId.'[land_pos]">'.$this->getItems($arrLPos,$this->piVars['land_pos']).'</select>',
			'###DISTRICT_ELEMENT###' 	=> '<select name="'.$this->prefixId.'[distr]"><option></option></select>',
			'###IRENGIMAS_ELEMENT###' 	=> '<select name="'.$this->prefixId.'[installation]">'.$this->getItems($arrInstall,$this->piVars['installation']).'</select>',
			'###BUKLE_ELEMENT###' 	=> '<select name="'.$this->prefixId.'[state]">'.$this->getItems($arrState,$this->piVars['state']).'</select>',
			'###STREET_ELEMENT###' 		=> '<input type="input" name="'.$this->prefixId.'[street]" value="'.htmlspecialchars($this->piVars['street']).'"'.$this->pi_classParam('searchbox-input').' />',
			'###GID_ELEMENT###' 		=> '<input type="input" name="'.$this->prefixId.'[gid]" value="'.htmlspecialchars($this->piVars['gid']).'"'.$this->pi_classParam('searchbox-input').' />',
			'###BDATE_ELEMENT###' 		=> '<input type="input" name="'.$this->prefixId.'[bdate]" value="'.htmlspecialchars($this->piVars['bdate']).'"'.$this->pi_classParam('searchbox-input').' />',
			'###LAND_TYPE_ELEMENT###' 		=> '<select name="'.$this->prefixId.'[land_type]">'.$this->getItems($arrLType,$this->piVars['land_type']).'</select>',
			'###FLOOR_ELEMENT###' 		=> '<input type="input" name="'.$this->prefixId.'[floor]" value="'.htmlspecialchars($this->piVars['floor']).'"'.$this->pi_classParam('searchbox-input').' />',
			'###LAND_AREA_ELEMENT###' 		=> '<span class="label">'.$this->pi_getLL('listFieldHeader_area_from').'</span> <input type="input" name="'.$this->prefixId.'[lafrom]" value="'.htmlspecialchars($this->piVars['lafrom']).'"'.$this->pi_classParam('searchbox-input-small').' /> <span class="label">'.$this->pi_getLL('listFieldHeader_area_to').'</span> <input type="input" name="'.$this->prefixId.'[lato]" value="'.htmlspecialchars($this->piVars['lato']).'"'.$this->pi_classParam('searchbox-input-small').' />',
			'###AREA_ELEMENT###' 		=> '<span class="label">'.$this->pi_getLL('listFieldHeader_area_from').'</span> <input type="input" name="'.$this->prefixId.'[afrom]" value="'.htmlspecialchars($this->piVars['afrom']).'"'.$this->pi_classParam('searchbox-input-small').' /> <span class="label">'.$this->pi_getLL('listFieldHeader_area_to').'</span> <input type="input" name="'.$this->prefixId.'[ato]" value="'.htmlspecialchars($this->piVars['ato']).'"'.$this->pi_classParam('searchbox-input-small').' />',
			'###ROOMCOUNT_ELEMENT###' 	=> '<select name="'.$this->prefixId.'[roomcnt]" >'.$this->getItems($arrRoomCount,$this->piVars['roomcnt']).'</select>',
			'###PRICE_ELEMENT###' 		=> '<span class="label">'.$this->pi_getLL('listFieldHeader_area_from').'</span> <input type="input" name="'.$this->prefixId.'[pfrom]" value="'.htmlspecialchars($this->piVars['pfrom']).'"'.$this->pi_classParam('searchbox-input-small').' /> <span class="label">'.$this->pi_getLL('listFieldHeader_area_to').'</span> <input type="input" name="'.$this->prefixId.'[pto]" value="'.htmlspecialchars($this->piVars['pto']).'"'.$this->pi_classParam('searchbox-input-small').' />',

			'###SUBMIT_BUTTON_VALUE###' => $this->pi_getLL('pi_list_searchBox_search','Search',TRUE),
			'###SUBMIT_BUTTON_CLASS###' => $this->pi_classParam('searchbox-submit'),
			'###RESET_BUTTON_VALUE###' => $this->pi_getLL('pi_list_searchBox_reset','Reset',TRUE),
			'###RESET_BUTTON_CLASS###' => $this->pi_classParam('searchbox-reset').' onclick="return resetForm(this)"',
		);

		if($newSearch) {
			$this->initXAJAX($rcar_db);
			$markerArray['###SAVIVALDYBE_ELEMENT###'] = '<select onchange="spinnerOn();tx_vvrecatalog_pi1ajax_getGyvenvietes(this.value);" name="'.$this->prefixId.'[rajonas]">'.$this->getItems($rcar_db->getRajonai(true), $this->piVars['rajonas'], true).'</select>';
			$markerArray['###SAVIVALDYBE_LABEL###'] = $this->pi_getLL('listFieldHeader_savivaldybe','County',TRUE);		
			$arrItems = $rcar_db->getGyvenvietes($this->piVars['rajonas']);
			$markerArray['###GYVENVIETE_ELEMENT###'] = '<select '.((count($arrItems))?'':'disabled="disabled"').' onchange="spinnerOn();tx_vvrecatalog_pi1ajax_getMikrorajonai(this.value)" id="gyvenviete" name="'.$this->prefixId.'[gyvenviete]">'.$this->getItems($arrItems, $this->piVars['gyvenviete'], true).'</select>';
			$markerArray['###GYVENVIETE_LABEL###'] = $this->pi_getLL('listFieldHeader_gyvenviete','Settlement',TRUE);
			$arrItems = $rcar_db->getMikrorajonai($this->piVars['gyvenviete']);
			$markerArray['###DISTRICT_ELEMENT###'] 	= '<select '.((count($arrItems))?'':'disabled="disabled"').' id="mikrorajonas" onchange="spinnerOn();tx_vvrecatalog_pi1ajax_getGatves(xajax.getFormValues(\'search-frm\'))" name="'.$this->prefixId.'[mikro]">'.$this->getItems($arrItems, $this->piVars['mikro'], true).'</select>';
			$arrItems = $rcar_db->getGatves($this->piVars['gyvenviete'], $this->piVars['mikro']);
			$markerArray['###GATVE_ELEMENT###'] 	= '<select '.((count($arrItems))?'':'disabled="disabled"').' id="gatve" name="'.$this->prefixId.'[gatve]">'.$this->getItems($arrItems, $this->piVars['gatve'], true).'</select>';
		}

		return $this->cObj->substituteMarkerArrayCached($template, $markerArray, array(), array());
	}

	
	function initBEItemArray($fieldValue)	{
		$items = array();
		if (is_array($fieldValue['config']['items']))	{
			reset ($fieldValue['config']['items']);
			while (list($itemName,$itemValue) = each($fieldValue['config']['items']))	{
				$items[] = array($GLOBALS['TSFE']->sL($itemValue[0]), $itemValue[1], $itemValue[2]);
			}
		}
		return $items;
	}
	

	function initItemArray($arr) {
		reset($arr);
		$outArr = array();
		foreach($arr as $item) {
			$outArr[] = array('title' => $item[0], 'uid' => $item[1]);
		}
		
		return $outArr;
	}
	function initXAJAX(&$respObj) {

		 /**
         * Instantiate the xajax object and configure it
         */
        // Include xaJax
        require_once (t3lib_extMgm::extPath('xajax') . 'class.tx_xajax.php');
        // Make the instance
        $this->xajax = t3lib_div::makeInstance('tx_xajax');
        // nothing to set, we send to the same URI
         $this->xajax->setRequestURI('/'.$this->pi_getPageLink($GLOBALS['TSFE']->id,'',array('eID' => 'rcardb')));
        // Decode form vars from utf8 ???
        $this->xajax->decodeUTF8InputOn();
        // Encode of the response to utf-8 ???
        $this->xajax->setCharEncoding('utf-8');
        // To prevent conflicts, prepend the extension prefix
        $this->xajax->setWrapperPrefix($this->prefixId);
        // Do you wnat messages in the status bar?
        $this->xajax->statusMessagesOn();
        // Turn only on during testing
        #$this->xajax->debugOn();
        // Register the names of the PHP functions you want to be able to call through xajax
        // $xajax->registerFunction(array('functionNameInJavascript', &$object, 'methodName'));
        $this->xajax->registerFunction(array('ajax_getRajonai', &$respObj, 'ajax_getRajonai'));
        $this->xajax->registerFunction(array('ajax_getGyvenvietes', &$respObj, 'ajax_getGyvenvietes'));
        $this->xajax->registerFunction(array('ajax_getMikrorajonai', &$respObj, 'ajax_getMikrorajonai'));
        $this->xajax->registerFunction(array('ajax_getGatves', &$respObj, 'ajax_getGatves'));
        // Else create javascript and add it to the header output
        $GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] = $this->xajax->getJavascript(t3lib_extMgm::siteRelPath('xajax'));
	}
	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$arrItems: ...
	 * @param	[type]		$selected: ...
	 * @return	[type]		...
	 */
	function getItems($arrItems, $selected=0, $addBlank = false)
	{
		$content = ($addBlank)?'<option value="0"></option>':'';
		while(list($key,$value)= each($arrItems)) {
			if(is_array($value) && !isset($value['uid'])) {
				$content .= '<optgroup label="'.$GLOBALS['TSFE']->sL('LLL:EXT:vv_rcar/llxml/locallang_rcar.xml:'.$key).'">'.$this->getItems($value, $selected).'</optgroup>';	
			} else {
				$sel = ($selected == $value['uid'])?' selected="selected"':'';
				$content .='<option value="'.$value['uid'].'"'.$sel.'>'.$value['title'].'</option>';
			}
		}
		return $content;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$arrFields: ...
	 * @return	[type]		...
	 */
	function getWhere($arrFields)
	{
		$content = '';
		foreach($arrFields as $key=>$value)
		{
			$value = trim($value);
			if(!empty($value)) {
				switch($key)
				{
					case 'pto':
						$rate = tx_vvrecatalog_utils::getCurLangCurrencyRate($GLOBALS['TSFE']->sys_language_uid);					
						$content .= ' AND price <= '.$value*$rate.'';
					break;
					case 'pfrom':
						$rate = tx_vvrecatalog_utils::getCurLangCurrencyRate($GLOBALS['TSFE']->sys_language_uid);
						$content .= ' AND price >= '.$value*$rate.'';
					break;
					case 'street':
						$charset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] ? $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] : $GLOBALS['TSFE']->defaultCharSet;
						$valueASCII = $GLOBALS['TSFE']->csConvObj->specCharsToASCII($charset,$value);
						$content .= ' AND ('.$key.' LIKE \'%'.$value.'%\' OR '.$key.' LIKE \'%'.$valueASCII.'%\')';
					break;
					case 'distr':
						$strDistr = $this->getRecOverlay('tx_vvrecatalog_district', $value);
						if(!strstr($strDistr, '--')) {
							$content .= ' AND district = \''.$value.'\'';
						}
					break;
					case 'land_type':
						$strLType = $this->getRecOverlay('tx_vvrecatalog_land_type', $value);
						if(!strstr($strLType, '--')) {
							$content .= ' AND land_type = \''.$value.'\'';
						}
					break;
					case 'land_pos':
						$strLType = $this->getRecOverlay('tx_vvrecatalog_land_pos', $value);
						if(!strstr($strLType, '--')) {
							$content .= ' AND land_pos = \''.$value.'\'';
						}
					break;
					case 'city':
						$strCity = $this->getRecOverlay('tx_vvrecatalog_city', $value);
						if(!strstr($strCity, '--')) {
							$content .= ' AND '.$key.' = \''.$value.'\'';
						}
					break;
					case 'bdate':
#						$content .= ' AND DATE_FORMAT(FROM_UNIXTIME('.$key.'),\'%Y\') = \''.$value.'\'';
						$content .= ' AND '.$key.' >= \''.$value.'\'';
					break;
					case 'roomcnt':
						if(is_numeric($value)) {
							$content .= ' AND roomcount = \''.$value.'\'';
						}
					break;
					case 'gid':
						$content .= ' AND '.$key.' = \''.$value.'\'';
					break;
					case 'afrom':
						$content .= ' AND area >= '.$value.'';
					break;
					case 'ato':
						$content .= ' AND area <= '.$value.'';
					break;
					
					case 'rajonas':
						$content .= ' AND '.$key.' = '.intval($value);					
					break;

					case 'gyvenviete':
						$content .= ($arrFields['mikro'] < 0)?'':' AND '.$key.' = '.intval($value);					
					break;

					case 'mikro':
						$value = intval($value);
						$content .= ($value < 0)?' AND mikro_rajonas2 = '.abs($value):' AND mikro_rajonas = '.$value;					
					break;

					case 'gatve':
					case 'installation':
					case 'state':
						$content .= ' AND '.$key.' = '.intval($value);					
					break;

					

				}
			}
		}
		return $content;
	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$content: ...
	 * @return	[type]		...
	 */
	function singleView($content)	{

		$templateCode = $this->cObj->fileResource($this->conf['displayList.']['templates.']['single_view']);
		$template = $this->cObj->getSubpart($templateCode, '###TEMPLATE_POPUP_'.strtoupper($this->arrREObject[$this->REobj]).'###');
		$tmplImages = $this->cObj->getSubpart($template, '###IMAGE_BLOCK###');
		$tmplData = $this->cObj->getSubpart($template, '###DATA_BLOCK###');
		$arrImg = t3lib_div::trimExplode(',', $this->internal['currentRow']['images'], 1);
		$intImg = count($arrImg);

		if ($this->piVars['bigimg']) {
			$SuperImg = $this->makeSuperImages($arrImg);
			$SuperImg = '<div class="single-view-super-images">'.$SuperImg.'</div>';
			$GLOBALS['TSFE']->setCSS($this->prefixId.'_zoomout', 'DIV.tx-vvrecatalog-pi1 TD.link-enlarge-img A {background: url(\'uploads/tf/icon_zoomout.gif\') top left no-repeat;}');
		} else {
			$bigImg = '';
			if (is_array($arrImg)) {
				$iConf = $iConf2 = $this->conf['displaySingle.']['bigImg_stdWrap.'];
				$iConf['file'] = $iConf2['file'] = $this->uplodPath.$arrImg[0];				
				unset($iConf2['file.']['width']);
				$tmpArr = $this->cObj->getImgResource($this->uplodPath.$arrImg[0], $iConf2['file.']);

				if($tmpArr[0] > $iConf['file.']['width']) {
					$iConf['file'] = $tmpArr[3];
					$iConf['file.']['width'] .= 'c';				
				} else {
					unset($iConf['file.']['width']);
				}

				$iConf['params'] = 'name="bigimg"';
				$bigImg = $this->cObj->IMAGE($iConf);
			}
	
			$smImg = '';
			$arrBigImg = array();
			unset($iConf['file.']);
			$iConf['file.']['width']=($intImg < 3)?'154c':'98c';
			$iConf['file.']['height']=($intImg < 3)?'120c':'77c';
			$iBConf = $iBConf2 = $iBConf3 = $this->conf['displaySingle.']['bigImg_stdWrap.'];
			unset($iBConf['file.']['width']);
			$iBConf3['file.']['width'] .='c';
			for($i=0;$i<$intImg;$i++) {
				$iBConf['file'] = $this->uplodPath.$arrImg[$i];
				$arrBigImg[$i] = $this->cObj->getImgResource($iBConf['file'], $iBConf['file.']);

				if($arrBigImg[$i][0] > $iBConf2['file.']['width']) {
					$tmpFile = $arrBigImg[$i][3];
					$arrBigImg[$i] = $this->cObj->getImgResource($arrBigImg[$i][3], $iBConf3['file.']);
					t3lib_div::unlink_tempfile(t3lib_div::getFileAbsFileName($tmpFile));					
				}

				$iConf['file'] = $this->uplodPath.$arrImg[$i];
				$iConf['params'] = 'onmouseover="document.images[\'bigimg\'].src=\''.$arrBigImg[$i][3].'\';document.images[\'bigimg\'].width=\''.$arrBigImg[$i][0].'\'"';
				$arrImg[$i]= $this->cObj->IMAGE($iConf);
	
			}
		}		
		
		if($GLOBALS['TSFE']->type !== 3 && $GLOBALS['TSFE']->type !== 4) {
			if (is_array($arrSess = $GLOBALS["TSFE"]->fe_user->getKey('ses',$this->extKey))) {
				$arrUids = $arrSess['searchResUids'];
			}
			$intPrev = $intnext = '';
			for($i=0;$i<count($arrUids);$i++)
			{
				if($arrUids[$i]['uid'] == $this->piVars['showUid']) {
					$intPrev = $arrUids[$i-1]['uid'];
					$intNext = $arrUids[$i+1]['uid'];
					break;
				}
			}
		}
		$marksArray = Array(
			'###BIG_IMAGE###' => '',
			'###SMALL_GALLERY###' => '',
			'###ACTION_LABEL###' => $this->pi_field_label('action'),
			'###ACTION_VALUE###' => $this->getFieldContent('action'),
			'###PRICE_LABEL###'  => $this->pi_field_label('price'),
			'###PRICE_VALUE###'  => $this->getFieldContent('price'),
			'###RE_OBJECT_TYPE_LABEL###' => $this->cObj->stdWrap($this->pi_getLL('listFieldHeader_object_type'), $this->conf['displaySingle.']['fieldLbl_stdWrap.']),
			'###RE_OBJECT_TYPE_VALUE###' => $this->pi_getLL('pi_'.strtolower($this->arrREObject[$this->REobj])),
			'###GID_LABEL###'  => $this->pi_field_label('gid'),
			'###GID_VALUE###'  => $this->getFieldContent('gid'),
			'###CITY_LABEL###' => $this->pi_field_label('city'),
			'###CITY_VALUE###' => $this->getFieldContent('city'),
			'###LAND_POS_LABEL###' 	=> $this->pi_field_label('land_pos'),			
			'###LAND_POS_VALUE###' => $this->getFieldContent('land_pos'),	
			'###AREA_LABEL###' => $this->pi_field_label('area'),
			'###AREA_VALUE###' => $this->getFieldContent('area'),
			'###HOUSE_AREA_LABEL###' => $this->pi_field_label('house2_area'),
			'###LAND_AREA_LABEL###' => $this->pi_field_label('land_area'),
			'###LAND_AREA_VALUE###' => $this->getFieldContent('land_area'),
			'###LAND_TYPE_LABEL###' => $this->pi_field_label('land_type'),
			'###LAND_TYPE_VALUE###' => $this->getFieldContent('land_type'),
			'###AC_TYPE_LABEL###' => $this->pi_field_label('ac_type'),
			'###AC_TYPE_VALUE###' => $this->getFieldContent('ac_type'),
			'###DISTRICT_LABEL###' => $this->pi_field_label('district'),
			'###DISTRICT_VALUE###' => $this->getFieldContent('district'),
			'###ROOMCOUNT_LABEL###' => $this->pi_field_label('roomcount'),
			'###ROOMCOUNT_VALUE###' => $this->getFieldContent('roomcount'),
			'###STREET_LABEL###' => $this->pi_field_label('street'),
			'###STREET_VALUE###' => $this->getFieldContent('street'),
			'###FLOOR_LABEL###' => $this->pi_field_label('floor'),
			'###FLOOR_VALUE###' => $this->getFieldContent('floor'),
			'###INSTALLATION_LABEL###' => $this->pi_field_label('installation'),
			'###INSTALLATION_VALUE###' => $this->getFieldContent('installation'),
			'###STATE_LABEL###' => $this->pi_field_label('state'),
			'###STATE_VALUE###' => $this->getFieldContent('state'),
			'###SPECIAL_LABEL###' => $this->pi_field_label('special'),
			'###SPECIAL_VALUE###' => $this->getFieldContent('special'),
			'###BTYPE_LABEL###' => $this->pi_field_label('building_type'),
			'###BTYPE_VALUE###' => $this->getFieldContent('building_type'),
			'###FLOORCOUNT_LABEL###' => $this->pi_field_label('floorcount'),
			'###FLOORCOUNT_VALUE###' => $this->getFieldContent('floorcount'),
			'###BYEAR_LABEL###' => $this->pi_field_label('bdate2'),
			'###BYEAR_VALUE###' => $this->getFieldContent('bdate'),
			'###HEATING_LABEL###' => $this->pi_field_label('heating_type'),
			'###HEATING_VALUE###' => $this->getFieldContent('heating_type'),
			'###DESCR_LABEL###' => $this->pi_field_label('descr'),
			'###DESCR_VALUE###' => $this->getFieldContent('descr'),
			'###EMPLOYEE_LABEL###' => $this->pi_field_label('employee'),
			'###EMPLOYEE_VALUE###' => '<div class="emp-contacts">'.$this->getFieldContent('employee').'</div>',
			'###PREV_LINK###' => ((!empty($intPrev))?$this->pi_linkToPage($this->pi_getLL('pi_single_browseresults_prev'), $GLOBALS['TSFE']->id, '_self', array('type' => 2, $this->prefixId => array('showUid' => $intPrev))):''),
			'###NEXT_LINK###' => ((!empty($intNext))?$this->pi_linkToPage($this->pi_getLL('pi_single_browseresults_next'), $GLOBALS['TSFE']->id, '_self',array('type' => 2, $this->prefixId => array('showUid' => $intNext))):''),
			'###PRINT_LINK###' => '<a href="javascript:(void)" onclick="self.print()">'.$this->pi_getLL('pi_single_browseresults_print').'</a>',
			'###TIP_LINK###' => $this->cObj->typolink($this->pi_getLL('pi_single_browseresults_tipafriend'), array('parameter' => '62,2')),
			'###CLOSE_LINK###' => '<a href="javascript:(void)" onclick="self.close();">'.$this->pi_getLL('pi_single_browseresults_close').'</a>',
			'###POP_CONTAINER_CLASS###' => $this->pi_classParam('singleView-block'),
			'###IMG_ENLARGE_URL###' => (($intImg)?$this->pi_linkToPage($this->pi_getLL(((!$this->piVars['bigimg'])?'pi_single_show_superimages':'pi_single_show_normalimages')), $GLOBALS['TSFE']->id, $GLOBALS['TSFE']->intTarget, array('type' => $GLOBALS['TSFE']->type, $this->prefixId => array('bigimg' => intval(!$this->piVars['bigimg']), 'showUid' => (($GLOBALS['TSFE']->type==3 || $GLOBALS['TSFE']->type==4)?$this->piVars['GID']:$this->piVars['showUid'])))):''),
		);

		if (!$this->piVars['bigimg']) {
			$marksArray['###BIG_IMAGE###'] = $bigImg;
			$marksArray['###SMALL_GALLERY###'] = '<table cellpadding="0" cellspacing="0" border="0"><tr><td>'.(($intImg>1)?$arrImg[0]:'').'</td><td>'.$arrImg[1].'</td><td>'.$arrImg[2].'</td></tr><tr><td>'.$arrImg[3].'</td><td>'.$arrImg[4].'</td><td>'.$arrImg[5].'</td></tr></table>';
			
		}
		$subpartsArray = Array(
			'###DATA_BLOCK###' => $this->cObj->substituteMarkerArrayCached($tmplData, $marksArray),
		);

		$subpartsArray['###IMAGE_BLOCK###'] = ($this->piVars['bigimg'])?$SuperImg:$this->cObj->substituteMarkerArrayCached($tmplImages, $marksArray);

		return $this->cObj->substituteMarkerArrayCached($template, $marksArray, $subpartsArray);
	}
	
	function makeSuperImages($arrImg) {
		$superImg = '';
		if (is_array($arrImg) && $intImg = count($arrImg)) {
			for($i=0;$i<$intImg;$i++) {
				$iConf = $this->conf['displaySingle.']['superImg_stdWrap.'];
				$iConf['file'] = $this->uplodPath.$arrImg[$i];
				$iConf['params'] = 'class="superImg"';
				$superImg .= $this->cObj->IMAGE($iConf).'<br />';
			}
		}
		return $superImg;
	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$field: ...
	 * @return	[type]		...
	 */
	function pi_field_label($field)	{
		return $this->cObj->stdWrap($this->getFieldHeader($field), $this->conf['displaySingle.']['fieldLbl_stdWrap.']);
	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$c: ...
	 * @return	[type]		...
	 */
	function pi_list_row($c) {
		$editPanel = $this->pi_getEditPanel();
		if ($editPanel)	$editPanel='<TD>'.$editPanel.'</TD>';

		$templateCode = $this->cObj->fileResource($this->conf['displayList.']['templates.']['search']);
		$template = $this->cObj->getSubpart($templateCode, '###TEMPLATE_ROW_'.strtoupper($this->arrREObject[$this->REobj]).'###');

		$markerArray = array (
			'###VALUE_IMAGES###' => $this->getFieldContent('images'),
			'###VALUE_ADDRESS###' => $this->getFieldContent('address'),
			'###VALUE_ROOMCOUNT###' => $this->getFieldContent('roomcount'),
			'###VALUE_AREA###' => $this->getFieldContent('area'),
			'###VALUE_FLOOR_FLOORCOUNT###' => $this->getFieldContent('floor_floorcount'),
			'###VALUE_BUILDING_TYPE###' => $this->getFieldContent('building_type'),
			'###VALUE_BDATE###' => $this->getFieldContent('bdate'),
			'###VALUE_PRICE###' => $this->getFieldContent('price'),
			'###VALUE_HEATING_TYPE###' => $this->getFieldContent('heating_type'),
			'###VALUE_FLOORCOUNT###' => $this->getFieldContent('floorcount'),
			'###VALUE_LAND_TYPE###' => $this->getFieldContent('land_type'),
			'###VALUE_AC_TYPE###' => $this->getFieldContent('ac_type'),
			'###VALUE_FLOOR###' => $this->getFieldContent('floor'),
			'###VALUE_LAND_AREA###' => $this->getFieldContent('land_area'),
			'###LIST_ROW_CLASS###' => ($c%2 ? $this->pi_classParam('listrow-odd') : ''),
		);
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray);
	}

	/**
	 * [Put your description here]
	 *
	 * @return	[type]		...
	 */
	function pi_list_header() {
		$templateCode = $this->cObj->fileResource($this->conf['displayList.']['templates.']['search']);
		$template = $this->cObj->getSubpart($templateCode, '###TEMPLATE_HEADER_'.strtoupper($this->arrREObject[$this->REobj]).'###');

		$markerArray = array (
			'###HEAD_IMAGES###' => $this->getFieldHeader('images'),
			'###HEAD_ADDRESS###' => $this->getFieldHeader('address'),
			'###HEAD_ROOMCOUNT###' => $this->getFieldHeader('roomcount', 1),
			'###HEAD_AREA###' => $this->getFieldHeader_sortLink('area'),
			'###HEAD_FLOOR_FLOORCOUNT###' => $this->getFieldHeader('floor_floorcount'),
			'###HEAD_BUILDING_TYPE###' => $this->getFieldHeader('building_type'),
			'###HEAD_BDATE###' => $this->getFieldHeader_sortLink('bdate', 1),
			'###HEAD_PRICE###' => $this->getFieldHeader_sortLink('price'),
			'###HEAD_HEATING_TYPE###' => $this->getFieldHeader('heating_type'),
			'###HEAD_FLOORCOUNT###' => $this->getFieldHeader('floorcount'),
			'###HEAD_FLOORCOUNT_SHORT###' => $this->getFieldHeader('floorcount_short'),
			'###HEAD_LAND_TYPE###' => $this->getFieldHeader('land_type'),
			'###HEAD_AC_TYPE###' => $this->getFieldHeader('ac_type'),
			'###HEAD_FLOOR###' => $this->getFieldHeader('floor'),
			'###HEAD_LAND_AREA###' => $this->getFieldHeader('land_area'),
			'###LIST_HEAD_CLASS###' => $this->pi_classParam('listrow-header'),
		);
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray);
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$uid: ...
	 * @return	[type]		...
	 */
	function getLWhere($uid) {
		return ($GLOBALS['TSFE']->sys_language_uid)?'sys_language_uid = '.$GLOBALS['TSFE']->sys_language_uid.' AND l18n_parent='.$uid:'uid='.$uid;
	}

	/**
	 * [Describe function...]
	 *
	 * @param	[type]		$table: ...
	 * @param	[type]		$uid: ...
	 * @return	[type]		...
	 */
	function getRecOverlay($table, $uid) {
		$retVlue = '';
		if (t3lib_div::testInt($uid)) {
			$strWhere = $this->getLWhere($uid);
			$value = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('title', $table, $strWhere.$this->cObj->enableFields($table));
			if (empty($value[0]['title'])) {
				$value[0] = $this->pi_getRecord($table, $uid);
			}
			$retValue = $value[0]['title'];
		}
		return $retValue;
	}
	
	function getRecordTitle($table, $uid) {
		$content = '';
		switch($table) {
			case 'tx_vvrcar_mikro_rajonas':
				if($this->internal['currentRow']['mikro_rajonas2']) {
					$table = 'tx_vvrcar_mikro_rajonas2';
					$uid = $this->internal['currentRow']['mikro_rajonas2'];
				}
				$rec = t3lib_BEfunc::getRecord($table, $uid, 'title');
				if (is_array($rec) && isset($rec['title'])) {
					$content = $rec['title'];
				}
			break;
			default:
				$rec = t3lib_BEfunc::getRecord($table, $uid, 'title');
				if (is_array($rec) && isset($rec['title'])) {
					$content = $rec['title'];
				}
			break;
		}
		
		return $content;
	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
	 */
	function getFieldContent($fN)	{
		$retVal = '';
		switch($fN) {
			case 'uid':
				$retVal = $this->pi_list_linkSingle($this->internal['currentRow'][$fN],$this->internal['currentRow']['uid'],1);	// The "1" means that the display of single items is CACHED! Set to zero to disable caching.
			break;
			case "bdate":
					// For a numbers-only date, use something like: %d-%m-%y
				$retVal = $this->internal['currentRow']['bdate'];
			break;
			case "roomcount":
				$retVal = $this->internal['currentRow']['roomcount'];
			break;
			case "price":
				$rate = tx_vvrecatalog_utils::getCurLangCurrencyRate($GLOBALS['TSFE']->sys_language_uid);
				$retVal = number_format(($this->internal['currentRow']['price']/$rate), 2, '.', '');
			break;
			case 'installation':
			case 'state':			
				$retVal = $this->getBEProcessedValue($this->theTable, $fN, $this->internal['currentRow'][$fN]);
			break;
			
			case 'special':
				$retVal = $this->getBEProcessedValue($this->theTable, $fN, $this->internal['currentRow'][$fN]);
				if($this->internal['currentRow']['facilities']) {
					$retVal .= "<br /><strong>".$this->getFieldHeader('facilities').'</strong>: '.$this->getBEProcessedValue($this->theTable, 'facilities', $this->internal['currentRow']['facilities']);
				}
				if($this->internal['currentRow']['equipment']) {
					$retVal .= "<br /><strong>".$this->getFieldHeader('equipment').'</strong>: '.$this->getBEProcessedValue($this->theTable, 'equipment', $this->internal['currentRow']['equipment']);
				}
				if($this->internal['currentRow']['com_sys']) {
					$retVal .= "<br /><strong>".$this->getFieldHeader('com_sys').'</strong>: '.$this->getBEProcessedValue($this->theTable, 'com_sys', $this->internal['currentRow']['com_sys']);
				}
				if($this->internal['currentRow']['security']) {
					$retVal .= "<br /><strong>".$this->getFieldHeader('security').'</strong>: '.$this->getBEProcessedValue($this->theTable, 'security', $this->internal['currentRow']['security']);
				}

			break;
			
			case "floor":
				$retVal = $this->internal['currentRow']['floor'];
			break;
			case "floor_floorcount":
				$retVal = $this->internal['currentRow']['floor'].'/'.
					$this->internal['currentRow']['floorcount'];
			break;
			case "action":
			$retVal =	$GLOBALS['TSFE']->sL('LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.action.I.'.$this->action);
			break;
			case "ac_type":
				$retVal = $this->getRecOverlay('tx_vvrecatalog_ac_type', $this->internal['currentRow']['ac_type']);
			break;
			case "building_type":
				$retVal = $this->getRecOverlay('tx_vvrecatalog_building_type', $this->internal['currentRow']['building_type']);
			break;
			case "land_type":
				$retVal = $this->getRecOverlay('tx_vvrecatalog_land_type', $this->internal['currentRow']['land_type']);
			break;
			case "land_pos":
				$retVal = $this->getRecOverlay('tx_vvrecatalog_land_pos', $this->internal['currentRow']['land_pos']);
			break;
			case "heating_type":
				$retVal = $this->getRecOverlay('tx_vvrecatalog_heating_type', $this->internal['currentRow']['heating_type']);
			break;
			case "city":
#				$retVal = $this->getRecOverlay('tx_vvrecatalog_city', $this->internal['currentRow']['city']);
				$retVal = $this->getRecordTitle('tx_vvrcar_gyvenviete', $this->internal['currentRow']['gyvenviete']);
			break;
			case "district":
#				$retVal = $this->getRecOverlay('tx_vvrecatalog_district', $this->internal['currentRow']['district']);
				$retVal = ($this->internal['currentRow']['mikro_rajonas2'])?$this->getRecordTitle('tx_vvrcar_mikro_rajonas2', $this->internal['currentRow']['mikro_rajonas2']):$this->getRecordTitle('tx_vvrcar_mikro_rajonas', $this->internal['currentRow']['mikro_rajonas']);
			break;
			case "street":
				$retVal = $this->getRecordTitle('tx_vvrcar_gatve', $this->internal['currentRow']['gatve']);
			break;
			case "employee":
				$employee = $this->pi_getRecord('tt_address', $this->internal['currentRow']['employee']);
				$emailConf['value'] = $emailConf['typolink.']['parameter'] = $employee['email'];
				if($employee['tx_vvttaddress_logo']) {
					$this->loadTcaAdditions(array('vv_ttaddress'));
					$imageLogoConf = array('file.' => array(
											'import' => $GLOBALS['TCA']['tt_address']['columns']['tx_vvttaddress_logo']['config']['uploadfolder'].'/',
											'import.' => array(
														'dataWrap' => $employee['tx_vvttaddress_logo'],
														'listNum' => 0
														),
											'width' => '160m',
											'height' => '45m'
											),
										'altText' => $employee['company'],
										'titleText' => $employee['company'],
										'params' => 'class="logo-image"',
								);
					
				}
				

				if($employee['image']) {
					t3lib_div::loadTCA('tt_address');
					$retVal = $employee['name'].
							(($employee['title'])?'<BR />'.$employee['title']:'').
							(($employee['tx_vvttaddress_logo'])?'<BR />'.$this->cObj->IMAGE($imageLogoConf):'').
							(($employee['company'])?'<BR />'.$employee['company']:'').
							(($employee['address'] && $employee['city'])?'<BR />'.$employee['address'].', '.(($employee['zip'])?$employee['zip'].' ':'').$employee['city']:'').
							(($employee['phone'])?'<BR />'.$this->pi_getLL('tt_address.phone').' '.$employee['phone']:'').
							(($employee['fax'])?'<BR />'.$this->pi_getLL('tt_address.fax').' '.$employee['fax']:'').
							(($employee['mobile'])?'<BR />'.$this->pi_getLL('tt_address.mobile').' '.$employee['mobile']:'').
							(($employee['email'])?'<BR />'.$this->pi_getLL('tt_address.email').' '.$this->cObj->TEXT($emailConf):'').
							(($employee['www'])?'<BR />'.$this->cObj->typolink($employee['www'], array('parameter' => $employee['www'], 'extTarget' => '_blank')):'').	
							(($employee['description'])?'<BR /><strong>'.$employee['description'].'<strong>':'');
					
					$imageConf = array('file.' => array(
											'import' => $GLOBALS['TCA']['tt_address']['columns']['image']['config']['uploadfolder'].'/',
											'import.' => array(
														'dataWrap' => $employee['image'],
														'listNum' => 0
														),
											'width' => '90c',
											'height' => 120
											),
										'altText' => $employee['name'],
										'titleText' => $employee['name'],
										'params' => 'class="contacts-image"',
								);
					$imgHTML = $this->cObj->IMAGE($imageConf);
					$retVal = $imgHTML.'<div>'.$retVal.'</div>';
				} else {
					$retVal = $employee['name'].
							(($employee['title'])?'<BR />'.$employee['title']:'').
							(($employee['tx_vvttaddress_logo'])?'<BR />'.$this->cObj->IMAGE($imageLogoConf):'').
							(($employee['company'])?'<BR />'.$employee['company']:'').
							(($employee['address'] && $employee['city'])?'<BR />'.$employee['address'].', '.(($employee['zip'])?$employee['zip'].' ':'').$employee['city']:'').
							'<BR />'.t3lib_div::rm_endcomma((($employee['phone'])?$this->pi_getLL('tt_address.phone').' '.$employee['phone'].', ':'').
							(($employee['fax'])?$this->pi_getLL('tt_address.fax').' '.$employee['fax'].', ':'').
							(($employee['mobile'])?$this->pi_getLL('tt_address.mobile').' '.$employee['mobile']:'')).
							(($employee['email'])?'<BR />'.$this->pi_getLL('tt_address.email').' '.$this->cObj->TEXT($emailConf):'').
							(($employee['www'])?'<BR />'.$this->cObj->typolink($employee['www'], array('parameter' => $employee['www'], 'extTarget' => '_blank')):'').	
							(($employee['description'])?'<BR /><strong>'.$employee['description'].'<strong>':'');			
				}
			break;
			case "address":
#				$city = $this->getRecOverlay('tx_vvrecatalog_city', $this->internal['currentRow']['city']);
				$rajonas = $this->getRecordTitle('tx_vvrcar_rajonas', $this->internal['currentRow']['rajonas']);
				$rajonas = ($rajonas)?$rajonas.'<br />':'';
				$city = $this->getRecordTitle('tx_vvrcar_gyvenviete', $this->internal['currentRow']['gyvenviete']);
				$city = ($city)?$city.'<br />':'';				
#				$distr = $this->getRecOverlay('tx_vvrecatalog_district', $this->internal['currentRow']['district']);
				$distr = ($this->internal['currentRow']['mikro_rajonas2'])?$this->getRecordTitle('tx_vvrcar_mikro_rajonas2', $this->internal['currentRow']['mikro_rajonas2']):$this->getRecordTitle('tx_vvrcar_mikro_rajonas', $this->internal['currentRow']['mikro_rajonas']);
				$distr = ($distr)?$distr.'<br />':'';
				$street_conf = $this->conf['displayList.']['street_stdWrap.'];
#				$street_conf['value'] = $this->internal['currentRow']['street'];
				$street_conf['value'] = $this->getRecordTitle('tx_vvrcar_gatve', $this->internal['currentRow']['gatve']);
				$retVal =  $rajonas.$city.$distr.$this->cObj->TEXT($street_conf);
			break;
			case "images":
				$images = explode(',', $this->internal['currentRow']['images']);
				$this->conf['displayList.']['image.']['file'] = (empty($images[0]))?t3lib_extMgm::siteRelPath('vv_recatalog').'pi1/bs_logo_big.gif':$this->uplodPath.$images[0];
				$imgConf = $this->conf['displayList.']['image.'];
				$linkConf['typolink.']['parameter'] = $GLOBALS['TSFE']->id.',2';
				$linkConf['typolink.']['additionalParams'] = '&'.$this->prefixId.'[showUid]='.$this->internal['currentRow']['uid'];
				$linkConf['value'] = $this->cObj->IMAGE($imgConf).'<br />'.$this->pi_getLL('listFieldHeader_more');
				$altLinkConf = $linkConf;
				$altLinkConf['typolink.']['parameter'] = $GLOBALS['TSFE']->id;
				$retVal = t3lib_div::deHSCentities($this->pi_openAtagHrefInJSwindow($this->cObj->TEXT($linkConf), '','width=612,height=587,status=0,menubar=0,scrollbars=1,resizable=1', $this->cObj->typoLink_URL($altLinkConf['typolink.'])));
#				$retVal = $this->cObj->IMAGE($imgConf);
			break;
			case "descr":
				$retVal = $this->pi_RTEcssText($this->internal['currentRow']['descr']);
			break;
			default:
				$retVal = $this->internal['currentRow'][$fN];
			break;
		}
		return (!empty($retVal)?$retVal:'&nbsp;');
	}
	
	/**
	 * Will change the href value from <a> in the input string and turn it into an onclick event that will open a new window with the URL
	 *
	 * @param	string		The string to process. This should be a string already wrapped/including a <a> tag which will be modified to contain an onclick handler. Only the attributes "href" and "onclick" will be left.
	 * @param	string		Window name for the pop-up window
	 * @param	string		Window parameters, see the default list for inspiration
	 * @return	string		The processed input string, modified IF a <a> tag was found
	 */
	function pi_openAtagHrefInJSwindow($str,$winName='',$winParams='width=670,height=500,status=0,menubar=0,scrollbars=1,resizable=1', $altUrl='')	{
		if (preg_match('/(.*)(<a[^>]*>)(.*)/i',$str,$match))	{
			$aTagContent = t3lib_div::get_tag_attributes($match[2]);
			$match[2]='<a href="'.(($altUrl)?$altUrl:'#').'" onclick="'.
				htmlspecialchars('vHWin=window.open(\''.$GLOBALS['TSFE']->baseUrlWrap($aTagContent['href']).'\',\''.($winName?$winName:md5($aTagContent['href'])).'\',\''.$winParams.'\');vHWin.focus();return false;').
				'">';
			$str=$match[1].$match[2].$match[3];
		}
		return $str;
	}
	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
	 */
	function getFieldHeader($fN, $short=0)	{
		$fN = ($short)?$fN.'_short':$fN;
		$retval = '';
		switch($fN) {
			case "floor_floorcount":
				$retval = $this->pi_getLL('listFieldHeader_floor').'/<br />'.
					$this->pi_getLL('listFieldHeader_floorcount','['.$fN.']');
			break;
			case 'installation':
			case 'state':
			case 'special':
			case 'facilities':
			case 'equipment':
			case 'com_sys':
			case 'security':
				$retval = $this->pi_getLL('tx_vvrecatalog_flat_'.$fN.'_label');
			break;
			default:
				$retval = $this->pi_getLL('listFieldHeader_'.$fN,'['.$fN.']');
			break;
		}
		return $retval;
	}

	/**
	 * [Put your description here]
	 *
	 * @param	[type]		$fN: ...
	 * @return	[type]		...
	 */
	function getFieldHeader_sortLink($fN, $short=0)	{
		list($field,$val) = explode(':', $this->piVars['sort']);
		$img = ($field == $fN)?'<img src="'.(($this->sort[$fN])?'uploads/tf/sort_desc.gif':'uploads/tf/sort_asc.gif').'" border="0" /> ':'';
		if (empty($field) && $fN=='price') {
			$img = '<img src="uploads/tf/sort_asc.gif" border="0" /> ';
		}
	 	$this->sort[$fN] = ($this->sort[$fN])?0:1;
		$tArr = array();
		foreach($this->sort as $key => $value)
		{
			$tArr[] = $key.':'.$value;
		}
		return $img.$this->pi_linkTP_keepPIvars($this->getFieldHeader($fN, $short),array('sort'=> $fN.':'.$this->sort[$fN]));
	}
	
	/*
	 * XML Export functions
	 */
	function vv_recatalog($content,$conf) {
		$this->conf=$conf;		// Setting the TypoScript passed to this function in $this->conf
		$this->pi_setPiVarDefaults();
		$this->pi_initPIflexForm(); // Init and get the flexform data of the plugin
		$this->pi_loadLL();		// Loading the LOCAL_LANG values

		$REobj  = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], "what_to_display", "sDEF");

		$objVVREC = t3lib_div::makeInstance('tx_vvrecatalog_pi1');
		$theTable =$this->arrTables[$REobj];

		return $theTable; 
	}
	
	function getFFvalue($content, $conf) {
		$this->pi_initPIflexForm(); // Init and get the flexform data of the plugin
		return $this->pi_getFFvalue($this->cObj->data['pi_flexform'], $conf['field'], $conf['sheet']);
	}

/**
	 * Returns a human readable output of a value from a record
	 * For instance a database record relation would be looked up to display the title-value of that record. A checkbox with a "1" value would be "Yes", etc.
	 * $table/$col is tablename and fieldname
	 * REMEMBER to pass the output through htmlspecialchars() if you output it to the browser! (To protect it from XSS attacks and be XHTML compliant)
	 * Usage: 24
	 *
	 * @param	string		Table name, present in TCA
	 * @param	string		Field name, present in TCA
	 * @param	string		$value is the value of that field from a selected record
	 * @param	integer		$fixed_lgd_chars is the max amount of characters the value may occupy
	 * @param	boolean		$defaultPassthrough flag means that values for columns that has no conversion will just be pass through directly (otherwise cropped to 200 chars or returned as "N/A")
	 * @param	boolean		If set, no records will be looked up, UIDs are just shown.
	 * @param	integer		uid of the current record
	 * @param	boolean		If t3lib_BEfunc::getRecordTitle is used to process the value, this parameter is forwarded.
	 * @return	string
	 */
	function getBEProcessedValue($table,$col,$value,$fixed_lgd_chars=0,$defaultPassthrough=0,$noRecordLookup=FALSE,$uid=0,$forceResult=TRUE)	{
		global $TCA;
		global $TYPO3_CONF_VARS;
			// Load full TCA for $table
		t3lib_div::loadTCA($table);
			// Check if table and field is configured:
		if (is_array($TCA[$table]) && is_array($TCA[$table]['columns'][$col]))	{
				// Depending on the fields configuration, make a meaningful output value.
			$theColConf = $TCA[$table]['columns'][$col]['config'];

				/*****************
				 *HOOK: pre-processing the human readable output from a record
				 ****************/
			if (is_array ($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['preProcessValue'])) {
			foreach ($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['preProcessValue'] as $_funcRef) {
					t3lib_div::callUserFunction($_funcRef,$theColConf,$this);
				}
			}

			$l='';
			switch((string)$theColConf['type'])	{
				case 'radio':
					$l=t3lib_BEfunc::getLabelFromItemlist($table,$col,$value);
					$l=$GLOBALS['TSFE']->sL($l);
				break;
				case 'select':
					if ($theColConf['MM'])	{
						// Display the title of MM related records in lists
						if ($noRecordLookup)	{
							$MMfield = $theColConf['foreign_table'].'.uid';
						} else	{
							$MMfields = array($theColConf['foreign_table'].'.'.$TCA[$theColConf['foreign_table']]['ctrl']['label']);
							foreach (t3lib_div::trimExplode(',', $TCA[$theColConf['foreign_table']]['ctrl']['label_alt'], 1) as $f)	{
								$MMfields[] = $theColConf['foreign_table'].'.'.$f;
							}
							$MMfield = join(',',$MMfields);
						}

						$dbGroup = t3lib_div::makeInstance('t3lib_loadDBGroup');
						$dbGroup->start($value, $theColConf['foreign_table'], $theColConf['MM'], $uid, $table, $theColConf);
						$selectUids = $dbGroup->tableArray[$theColConf['foreign_table']];

						if (is_array($selectUids) && count($selectUids)>0) {
							$MMres = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
								'uid, '.$MMfield,
								$theColConf['foreign_table'],
								'uid IN ('.implode(',', $selectUids).')'
							);
							while($MMrow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($MMres))	{
								$mmlA[] = ($noRecordLookup?$MMrow['uid']:t3lib_BEfunc::getRecordTitle($theColConf['foreign_table'], $MMrow, FALSE, $forceResult));
							}
							if (is_array($mmlA)) {
								$l=implode('; ',$mmlA);
							} else {
								$l = '';
							}
						} else {
							$l = 'n/A';
						}
					} else {
						$l = t3lib_BEfunc::getLabelFromItemlist($table,$col,$value);
						$l = $GLOBALS['TSFE']->sL($l);
						if ($theColConf['foreign_table'] && !$l && $TCA[$theColConf['foreign_table']])	{
							if ($noRecordLookup)	{
								$l = $value;
							} else {
								$rParts = t3lib_div::trimExplode(',',$value,1);
								reset($rParts);
								$lA = array();
								while(list(,$rVal)=each($rParts))	{
									$rVal = intval($rVal);
									if ($rVal>0) {
										$r=t3lib_BEfunc::getRecordWSOL($theColConf['foreign_table'],$rVal);
									} else {
										$r=t3lib_BEfunc::getRecordWSOL($theColConf['neg_foreign_table'],-$rVal);
									}
									
									if (is_array($r))	{
										if($GLOBALS['TSFE']->sys_language_content) {
											$r2 = t3lib_BEfunc::getRecordsByField($theColConf['foreign_table'], 'l18n_parent', $rVal, t3lib_BEfunc::BEenableFields($theColConf['foreign_table']));
											#debug(array($r, $r2));
											if(is_array($r2) && count($r2)) {
												$r = $r2[0];
											}
										}
										$lA[]=$GLOBALS['TSFE']->sL($rVal>0?$theColConf['foreign_table_prefix']:$theColConf['neg_foreign_table_prefix']).t3lib_BEfunc::getRecordTitle($rVal>0?$theColConf['foreign_table']:$theColConf['neg_foreign_table'],$r,FALSE,$forceResult);
									} else {
										$lA[]=$rVal?'['.$rVal.'!]':'';
									}
								}
								$l = implode(', ',$lA);
							}
						}
					}
				break;
				case 'group':
					$l = implode(', ',t3lib_div::trimExplode(',',$value,1));
				break;
				case 'check':
					if (!is_array($theColConf['items']) || count($theColConf['items'])==1)	{
						$l = $value ? 'Yes' : '';
					} else {
						reset($theColConf['items']);
						$lA=Array();
						while(list($key,$val)=each($theColConf['items']))	{
							if ($value & pow(2,$key))	{$lA[]=$GLOBALS['TSFE']->sL($val[0]);}
						}
						$l = implode(', ',$lA);
					}
				break;
				case 'input':
					if ($value)	{
						if (t3lib_div::inList($theColConf['eval'],'date'))	{
							$l = t3lib_BEfunc::date($value).' ('.(time()-$value>0?'-':'').t3lib_BEfunc::calcAge(abs(time()-$value), $GLOBALS['TSFE']->sL('LLL:EXT:lang/locallang_core.php:labels.minutesHoursDaysYears')).')';
						} elseif (t3lib_div::inList($theColConf['eval'],'time'))	{
							$l = t3lib_BEfunc::time($value);
						} elseif (t3lib_div::inList($theColConf['eval'],'datetime'))	{
							$l = t3lib_BEfunc::datetime($value);
						} else {
							$l = $value;
						}
					}
				break;
				case 'flex':
					$l = strip_tags($value);
				break;
				default:
					if ($defaultPassthrough)	{
						$l=$value;
					} elseif ($theColConf['MM'])	{
						$l='N/A';
					} elseif ($value)	{
						$l=t3lib_div::fixed_lgd_cs(strip_tags($value),200);
					}
				break;
			}

				/*****************
				 *HOOK: post-processing the human readable output from a record
				 ****************/
			if (is_array ($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['postProcessValue'])) {
			foreach ($TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['postProcessValue'] as $_funcRef) {
					$params = array(
						'value' => $l,
						'colConf' => $theColConf
					);
					$l = t3lib_div::callUserFunction($_funcRef,$params,$this);
				}
			}

			if ($fixed_lgd_chars)	{
				return t3lib_div::fixed_lgd_cs($l,$fixed_lgd_chars);
			} else {
				return $l;
			}
		}
	}	
	
	function loadTcaAdditions($ext_keys){
		global $_EXTKEY, $TCA;

	       //Merge all ext_keys
		if (is_array($ext_keys))	{
			for($i = 0; $i < sizeof($ext_keys); $i++)	{
				//Include the ext_table
				$_EXTKEY = $ext_keys[$i];
				include(t3lib_extMgm::extPath($ext_keys[$i]).'ext_tables.php');
			}
		}
	}
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_recatalog/pi1/class.tx_vvrecatalog_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_recatalog/pi1/class.tx_vvrecatalog_pi1.php']);
}

?>