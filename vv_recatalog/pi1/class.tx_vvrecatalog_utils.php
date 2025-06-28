<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Miroslav Monkevic (m@vektorius.lt)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license 
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * TCE form postprocessing hook
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 */
 
 class tx_vvrecatalog_utils {
   function user_selproc(&$items, &$pObj) {
/*	   $tblForeign = $items['config']['foreign_table'];
	   $row = t3lib_BEfunc::getRecord($tblForeign,$items["row"][$items["field"]]);
	   if(is_array($row) && isset($row["sys_language_uid"]) && $row["sys_language_uid"] != $items["row"]["sys_language_uid"]) {
		 $newRec = t3lib_BEfunc::getRecordRaw($tblForeign,'l18n_parent = '.$row["uid"].' AND sys_language_uid='.$items["row"]["sys_language_uid"]);
		 $items["row"][$items["field"]] = $newRec["uid"];
		 $GLOBALS['TYPO3_DB']->exec_UPDATEquery($items["table"],"uid = ".$items['row']['uid'], array($items["field"]=>$newRec["uid"]));
		$newItems = Array();
		foreach($items['items'] as $key => $value) {
			if ($value[1] == 0) {
				$newItems[] = $value;
			} elseif($value[1]) { 
				$rec = t3lib_BEfunc::getRecord($tblForeign, $value[1]);
				if ($rec["sys_language_uid"] == $items["row"]["sys_language_uid"]) {
					$newItems[] = $value;
				}
			}
		}
		$items['items'] = $newItems;
//	    t3lib_div::debug($items);
	   }*/
//t3lib_div::debug($items);
/*	   $tblForeign = $items['config']['foreign_table'];
	   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,title', $tblForeign, ' sys_language_uid=0'.t3lib_BEfunc::BEenableFields($tblForeign),'','sorting');
		$newItems = Array();
		while($item = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
		{
			$newItems[] = array( $item['title'], $item['uid']);
		}
	   if($items["row"]["sys_language_uid"]) {
		   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,l18n_parent,title', $tblForeign, ' sys_language_uid='.$items["row"]["sys_language_uid"].t3lib_BEfunc::BEenableFields($tblForeign));
	   
			$arr118n = array();
			while($item = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	
			{
				$arr118n[$item['l18n_parent']] = $item['title'];
			}
			foreach($newItems as $key => $value) {
				$newItems[$key][0]=$arr118n[$key];
			}
			$items['items'] = $newItems;
		}*/
//t3lib_div::debug($items);
	   $tblForeign = $items['config']['foreign_table'];
		$newItems = Array();
		foreach($items['items'] as $key => $value) {
			if ($value[1] == 0) {
				$newItems[] = $value;
			} elseif($value[1]) { 
				$rec = t3lib_BEfunc::getRecord($tblForeign, $value[1]);
				if (empty($rec["sys_language_uid"])) {
					$newItems[] = $value;
				}
			}
		}

	   if($items["row"]["sys_language_uid"] && $tblForeign != 'tt_address') {
	   $GLOBALS['TYPO3_DB']->debugOutput = 1;
		   $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,l18n_parent,title', $tblForeign, ' sys_language_uid='.$items["row"]["sys_language_uid"].t3lib_BEfunc::BEenableFields($tblForeign));
	   
			$arr118n = array();
			while($item = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	
			{
				$arr118n[$item['l18n_parent']] = $item['title'];
			}
			foreach($newItems as $key => $value) {
				if(isset($arr118n[$newItems[$key][1]])) {
					$newItems[$key][0]=$arr118n[$newItems[$key][1]];
				}
			}
		}
		$items['items'] = $newItems;
	}
	
	function getCurLangCurrencyRate($sys_lang_uid) {
		$table ='tx_vvrecatalog_options';
		$retVal = 1;
		
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'value',
			$table,
			' opt='.$GLOBALS['TYPO3_DB']->fullQuoteStr('currency_lang_'.$sys_lang_uid, $table)
		);
		if(is_array($row) && count($row)) {
			$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'value',
				$table,
				' opt='.$GLOBALS['TYPO3_DB']->fullQuoteStr('currency_'.$row[0]['value'], $table)
			);

			if(is_array($row) && count($row)) {
				$retVal = $row[0]['value'];
			}
			
		}
		
		return $retVal;
	}
	
	function op_and($content, $conf) {
		$bit = intval($conf['bit']);
#		debug(array('bit' => $bit, 'content' => $content, 'pow' => (pow(2, $bit)), 'result' => (intval($content) & (pow(2, $bit)))));
		if($bit && (intval($content) & (pow(2, $bit)))) {
			return 1;
		}
		
		return 0;
	}
	
	function user_str_replace($content, $conf) {
		$search = $conf['search'];
		$replace = $conf['replace'];
		if($search && $replace) {
			$content = str_replace($search, $replace, $content); 
		}
		return $content; 
	}
	
	function get_timestamp($content, $conf) {
		return time();
	}
	
	function remove_brackets($content, $conf) {
		return str_replace("(", "", str_replace(")", "", str_replace("-", "", $content)));
	}

}
 
 ?>