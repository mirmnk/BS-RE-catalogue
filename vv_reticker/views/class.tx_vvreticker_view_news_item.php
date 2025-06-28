<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Miroslav Monkevic <m@dieta.lt>
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
 * Class that implements the view for news item.
 *
 * View for news item
 *
 *
 * @author	Miroslav Monkevic <m@dieta.lt>
 * @package	TYPO3
 * @subpackage	tx_vvreticker
 */

tx_div::load('tx_lib_phpTemplateEngine');
require_once(PATH_t3lib.'class.t3lib_befunc.php');

class tx_vvreticker_view_news_item extends tx_lib_phpTemplateEngine {
	var $table = '';
	
	function tx_vvreticker_view_news_item($controller=null, $parameter=null) {
		parent::tx_lib_object($controller, $parameter);
		$this->loadTcaAdditions(array('vv_rcar'));
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
	
	function printNewsBlock() {
		$this->cObj = $this->controller->context->getContentObject();
		
		$content  = $this->getBlockHeader();

		$decr = $this->getDescription();

		$content .= $this->getImageTag($decr);

		$content .= $this->cObj->TEXT(array('value' => $decr, 'crop' => '250|...|1', 'wrap' => '<p class="vv-reticker-newsblock-descr">|</p>'));
		$content .= $this->getPrice(); 
		
		$link = tx_div::makeInstance('tx_lib_link');
		$link->designator('tx_vvrecatalog_pi1');
		$link->parameters(array('showUid' => $this->get('gid')));
		$link->title($decr);

		switch($this->controller->configurations->get('display_layout')) {
			case 1:
			  $urlType = 3; // popup
			break;
			
			case 2:
			  $urlType = 4; // nonpopup
			break;
			
			default:
			  $urlType = 3; // popup
			break;
		}
		
		$link->destination($this->getDestination().','.$urlType);		

		if($urlType == 3) {
			$popUrl = $link->makeUrl(); 
			$retVal ='<a href="#" onclick="'.
					htmlspecialchars('vHWin=window.open(\''.$GLOBALS['TSFE']->baseUrlWrap($popUrl).'\',\''.(md5($popUrl)).'\',\'width=612,height=587,status=0,menubar=0,scrollbars=1,resizable=1\');vHWin.focus();return false;').
					'">'.$content.'</a>';
		} elseif($urlType == 4) {
			$link->label($content, true);
			$retVal = $link->makeTag();
		}
		
		print $retVal;

	}
	
	function getPrice() {
		$this->determinTable();
		$rate = tx_vvrecatalog_utils::getCurLangCurrencyRate($GLOBALS['TSFE']->sys_language_uid);
		$content = number_format(($this->get('price')/$rate), 2, '.', ' ');
		
		return '<p class="vv-reticker-newsblock-price">'.$content.' %%%vvreticker_news_currency%%%</p>';		
	}
	
	function determinTable() {
		if (empty($this->table)) {
			switch($this->get('source')) {
				case 'flat' :
					$table = 'tx_vvrecatalog_flat'; 
				break;
	
				case 'land' :
					$table = 'tx_vvrecatalog_land';
				break;
	
				case 'house' :
					$table = 'tx_vvrecatalog_house';
				break;
	
				case 'accommodation' :
					$table = 'tx_vvrecatalog_accommodation';
				break;
	
				case 'homestead' :
					$table = 'tx_vvrecatalog_homestead';
				break;
			}
			$this->table = $table;
		}
	}
	
	function getDescription() {
		$content  = array();
		$standardFields = 'gyvenviete, mikro_rajonas, gatve';
		$this->determinTable();
		$table = $this->table;

		$content = $this->getFieldsValues($table, $standardFields);
		$content .= ($extra = $this->getFieldsValues($table, $this->getExtraFieldsList()))?', '.$extra:''; 

		return $content;
	}

    function getExtraFieldsList() {
    	$extra = t3lib_div::trimExplode(',', $this->get('extra_fields'));
    	$fList = '';
    	foreach($extra as $field) {
    		if($field) {
        		list($fieldName, $fieldValue) = t3lib_div::trimExplode('|', $field);
        		$fList .= $fieldName.',';
    		}
    	}
    	return t3lib_div::rm_endcomma($fList); 
    }


	function getFieldsValues($table, $fList) {
		$arrFields = t3lib_div::trimExplode(',', $fList, 1);
		$content = '';
		foreach($arrFields as $field) {
			$value = $this->get($field);
			if(!empty($value)) {
				$content .= $this->getProcessedValue($table, $field, $value);
			}			
		}
		return t3lib_div::rm_endcomma($content);
	}
	
	function getProcessedValue($table, $field, $value) {
		$retValue = $this->getBEProcessedValue($table, $field, $value);
		$postValue = '';
		$preValue = ' ';

		switch($field) {
			case 'area' :
				$postValue = '%%%vvreticker_news_adblock_descr_area_units%%%,';
			break;

			case 'land_area' :
				$postValue = '%%%vvreticker_news_adblock_descr_landarea_units%%%,';
			break;


			case 'floor' :
				$postValue = ' %%%vvreticker_news_adblock_descr_floor_label%%%';
				$postValue = '';
			break;

			case 'floorcount' :
				if($this->get('source') == 'flat' || $this->get('source') == 'accommodation') {
					$preValue = '%%%vvreticker_news_adblock_descr_floorcount_prelabel%%%';
					$postValue = ',';				
				} elseif($this->get('source') == 'house' || $this->get('source') == 'homestead') {
					$postValue = ' %%%vvreticker_news_adblock_descr_floorcounthouse_postlabel%%%,';
				} else {
					$preValue = '';
					$postValue = '%%%vvreticker_news_adblock_descr_floorcount_postlabel%%%,';
				}
			break;
			
			case 'gatve':
				$retValue = $this->getRecordTitle('tx_vvrcar_gatve', $value);
			break;

			case 'mikro_rajonas':
				$retValue = $this->getRecordTitle('tx_vvrcar_mikro_rajonas', $value);
				$postValue = ',';
			break;
			
			
			default:
				$postValue = ',';
			break;
		}
		
		return $preValue.$retValue.$postValue;
	}

	function getRecordTitle($table, $uid) {
		$content = '';
		switch($table) {
			case 'tx_vvrcar_mikro_rajonas':
				if($this->get('mikro_rajonas2')) {
					$table = 'tx_vvrcar_mikro_rajonas2';
					$uid = $this->get('mikro_rajonas2');
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
	function getBlockHeader() {
		$content = '';
		switch($this->get('source')) {
			case 'flat' :
				$content = '%%%vvreticker_news_ad_type_flat_'.($this->get('action')).'%%%';
			break;

			case 'land' :
				$content = '%%%vvreticker_news_ad_type_land_'.($this->get('action')).'%%%';
			break;

			case 'house' :
				$content = '%%%vvreticker_news_ad_type_house_'.($this->get('action')).'%%%';
			break;

			case 'accommodation' :
				$content = '%%%vvreticker_news_ad_type_accomodation_'.($this->get('action')).'%%%';
			break;

			case 'homestead' :
				$content = '%%%vvreticker_news_ad_type_homestead_'.($this->get('action')).'%%%';
			break;

		}
		return '<h3>'.$content.'</h3>';
	}
	function getImageTag($alt = '') {
		$imageClassName = tx_div::makeInstanceClassName('tx_lib_image');
		$image = new $imageClassName();
		$image->alt($alt);

		$widthKey = ($this->controller->configurations->get('display_layout') == 2)?'newsBlock2ImageWidth':'newsBlockImageWidth';
		$heightKey = ($this->controller->configurations->get('display_layout') == 2)?'newsBlock2ImageHeight':'newsBlockImageHeight';

		$width = ($width = $this->controller->configurations->get($widthKey))?$width:'130c';
		$height = ($height = $this->controller->configurations->get($heightKey))?$height:'80c';
		
		
		$uplodPath = 'uploads/tx_vvrecatalog/';
		$images = t3lib_div::trimExplode(',', $this->get('images'), 1);
		
		$image->width($width);
		$image->height($height);
		$image->path((empty($images[0]))?t3lib_extMgm::siteRelPath('vv_recatalog').'pi1/bs_logo_big.gif':$uplodPath.$images[0]);
		return $image->make();		
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/views/class.tx_vvreticker_view_news.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/views/class.tx_vvreticker_view_news.php']);
}

?>