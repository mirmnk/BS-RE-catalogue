<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Miroslav Monkevic <m@vektorius.lt>
*  All rights reserved
*
*  This script is free software; you can redistribute it and/or modify
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
 * Module: 
 * 
 * Created on 2008.01.31
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 * @package
 * @subpackage 
 */
 
/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/

// Exit, if script is called directly (must be included via eID in index_ts.php)
if (!defined ('PATH_typo3conf')) die ('Could not access this script directly!');



class tx_vvrcar_db {
	

	function &getApskritys() {
		$arrApskrytis = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'uid, title',
				'tx_vvrcar_apskritis',
				'tx_vvrcar_apskritis.deleted =0 AND tx_vvrcar_apskritis.hidden =0',
				'',
				'title'
		);
		
		return $arrApskrytis;
	}


	function &getRajonai($get5Cities=false) {
		$arrRajonai = array();
		if($get5Cities) {
			$arrRajonai['tx_vvrcar_rajonas_bigcities'] = $this->getGyvenvietes(0, '1,6,7,11,10');
		}
		
		if($get5Cities) {
			$arrRajonai['tx_vvrcar_rajonas_counties'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'uid, title',
				'tx_vvrcar_rajonas',
				'tx_vvrcar_rajonas.deleted =0 AND tx_vvrcar_rajonas.hidden =0',
				'',
				'title'
			);
		} else {
			$arrRajonai = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'uid, title',
				'tx_vvrcar_rajonas',
				'tx_vvrcar_rajonas.deleted =0 AND tx_vvrcar_rajonas.hidden =0',
				'',
				'title'
			);
		}
		
		return $arrRajonai;
	}

	function &getGyvenvietes($rUid,$strUid='') {
		$arrGyvenvietes = array();
		if($strUid) {
			$where = 'rcuid IN('.$strUid.')';
			$fields = 'CONCAT(\'-\', uid) as uid, title, FIND_IN_SET(rcuid, \''.$strUid.'\') as sort_column';
			$orderBy = 'sort_column';
		} elseif($rUid) {
			$where = 'ruid='.intval($rUid);
			$fields = 'uid, title';
			$orderBy = 'title';
		}
		if($strUid || $rUid) {
			$arrGyvenvietes = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					$fields,
					'tx_vvrcar_gyvenviete',
					$where.
						' AND tx_vvrcar_gyvenviete.deleted =0 AND tx_vvrcar_gyvenviete.hidden =0',
					'',
					$orderBy
			);
		}
		return $arrGyvenvietes;
	}

	function &getMikrorajonai($gUid) {
		$arrMikro = array();
		if($gUid) {
			$unionQuery = '('.$GLOBALS['TYPO3_DB']->SELECTquery(
					'uid, title',
					'tx_vvrcar_mikro_rajonas',
					'guid='.intval($gUid).
						' AND tx_vvrcar_mikro_rajonas.deleted =0 AND tx_vvrcar_mikro_rajonas.hidden =0'
			).')';
			$unionQuery .= ' UNION ';
			$unionQuery .= '('.$GLOBALS['TYPO3_DB']->SELECTquery(
					'CONCAT(\'-\', uid) as uid, title',
					'tx_vvrcar_mikro_rajonas2',
					'guid='.intval($gUid).
						' AND tx_vvrcar_mikro_rajonas2.deleted =0 AND tx_vvrcar_mikro_rajonas2.hidden =0'
			).')';
			$unionQuery = 'SELECT * FROM ('.$unionQuery.') AS t ORDER BY title';

            if($res = $GLOBALS['TYPO3_DB']->sql_query($unionQuery)) {
	            while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
	                    $arrMikro[] = $row;
	            }
	            $GLOBALS['TYPO3_DB']->sql_free_result($res);
            }
			
		}
		
		return $arrMikro;
	}

	function &getGatves($gUid, $mUid=0) {
		$arrGatves = array();
		$mUid = intval($mUid);
		if($mUid > 0) {
#$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
			$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query(
					'tx_vvrcar_gatve.uid, tx_vvrcar_gatve.title',
					'tx_vvrcar_mikro_rajonas',
					'tx_vvrcar_mikrorajonas_gatve_mm',
					'tx_vvrcar_gatve',
					' AND tx_vvrcar_gatve.deleted =0 AND tx_vvrcar_gatve.hidden =0'.
						' AND tx_vvrcar_mikro_rajonas.deleted =0 AND tx_vvrcar_mikro_rajonas.hidden =0'.
						' AND uid_local='.$mUid,
					'',
					'tx_vvrcar_gatve.title'
			);
#debug($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);			
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
					$arrGatves[] = $row;
			}

			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		} elseif($gUid) {
			$arrGatves = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid, title',
					'tx_vvrcar_gatve',
					'guid='.intval($gUid).
						' AND tx_vvrcar_gatve.deleted =0 AND tx_vvrcar_gatve.hidden =0',
					'',
					'title'
			);		
		}
		
		return $arrGatves;
	}


	
	/**
	 * Creates recursively a JSON literal from a mulidimensional associative array.
	 * Uses Services_JSON (http://mike.teczno.com/JSON/doc/)
	 *
	 * @param	array		$jsonArray: The array (or part of) to be transformed to JSON
	 * @return	string		If $level>0: part of JSON literal; if $level==0: whole JSON literal wrapped with <script> tags
	 */
	function getJSON($jsonArray) {
		if (!$GLOBALS['JSON']) {
			require_once(PATH_typo3.'contrib/json.php');
			$GLOBALS['JSON'] = t3lib_div::makeInstance('Services_JSON');
		}
		return $GLOBALS['JSON']->encode($jsonArray);
	}

	function initXAJAX() {
		 /**
         * Instantiate the xajax object and configure it
         */
        // Include xaJax
        require_once (t3lib_extMgm::extPath('xajax') . 'class.tx_xajax.php');
        // Make the instance
        $this->xajax = t3lib_div::makeInstance('tx_xajax');
        // Decode form vars from utf8 ???
        $this->xajax->decodeUTF8InputOn();
        // Encode of the response to utf-8 ???
        $this->xajax->setCharEncoding('utf-8');
        // To prevent conflicts, prepend the extension prefix
        $this->xajax->setWrapperPrefix('tx_vvrecatalog_pi1');
        $this->xajax->registerFunction(array('ajax_getRajonai', &$this, 'ajax_getRajonai'));
        $this->xajax->registerFunction(array('ajax_getGyvenvietes', &$this, 'ajax_getGyvenvietes'));
        $this->xajax->registerFunction(array('ajax_getMikrorajonai', &$this, 'ajax_getMikrorajonai'));
        $this->xajax->registerFunction(array('ajax_getGatves', &$this, 'ajax_getGatves'));
        // If this is an xajax request, call our registered function, send output and exit
        $this->xajax->processRequests();
	}
	
	function init() {
		tslib_eidtools::connectDB();
		$this->initXAJAX();
	}
	
	function ajax_getRajonai() {

        $objResponse = new tx_xajax_response();
        
        $content = $this->getItems($this->getRajonai(), 0, true);

        $objResponse->addAssign('test', 'innerHTML', $content);
        $objResponse->addAssign('test', 'disabled', '');

        return $objResponse->getXML();
	}

	function ajax_getGyvenvietes($data) {

        $objResponse = new tx_xajax_response();
        $selected = 0;
        $adjustRajonas = false;
        
        if($data < 0) {
#$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
        	$rec = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'ruid',
					'tx_vvrcar_gyvenviete',
					'uid = '.abs($data).
						' AND tx_vvrcar_gyvenviete.deleted =0 AND tx_vvrcar_gyvenviete.hidden =0'
			);
#debug($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);	
        	
        	if(is_array($rec) && ($ruid = intval($rec[0]['ruid']))) {
        		$selected = abs($data);
        		$data = $ruid;
        		$adjustRajonas = true;
        	}
        }
        $gyv = $this->getGyvenvietes(intval($data));
        $gyvCount = count($gyv);
        
        $content = $this->getItems($gyv, $selected, true);

        $objResponse->addAssign('cgyvenviete', 'innerHTML', '<select '.(($gyvCount)?'':'disabled="disabled"').' onchange="spinnerOn();tx_vvrecatalog_pi1ajax_getMikrorajonai(this.value)" id="gyvenviete" name="tx_vvrecatalog_pi1[gyvenviete]">'.$content.'</select>');
        if($adjustRajonas) {
        	$objResponse->addScript('changeSelectedOption(\'tx_vvrecatalog_pi1[rajonas]\','.$data.');');
        	$objResponse->addScript('tx_vvrecatalog_pi1ajax_getMikrorajonai('.$selected.');');
        } else {
        	$objResponse->addScript('spinnerOff();');        
        }
        
#        $objResponse->addAssign('gyvenviete', 'disabled', (($gyvCount)?'':'disabled'));

        return $objResponse->getXML();
	}


	function ajax_getMikrorajonai($data) {

        $objResponse = new tx_xajax_response();
        
        $micro = $this->getMikrorajonai(intval($data));
        $mCount = count($micro);
        $content = $this->getItems($micro, 0, true);
        
        $objResponse->addAssign('cmikrorajonas', 'innerHTML', '<select '.(($mCount)?'':'disabled="disabled"').' id="mikrorajonas" onchange="spinnerOn();tx_vvrecatalog_pi1ajax_getGatves(xajax.getFormValues(\'search-frm\'))" name="tx_vvrecatalog_pi1[mikro]">'.$content.'</select>');
#        $objResponse->addAssign('mikrorajonas', 'disabled', (($mCount)?'':'disabled'));

        $gatves = $this->getGatves(intval($data));
        $gCount = count($gatves);
        $content = $this->getItems($gatves, 0, true);
        
        $objResponse->addAssign('cgatve', 'innerHTML', '<select '.(($gCount)?'':'disabled="disabled"').' id="gatve" name="tx_vvrecatalog_pi1[gatve]">'.$content.'</select>');
        $objResponse->addScript('spinnerOff();');
#        $objResponse->addAssign('gatve', 'disabled', (($gCount)?'':'disabled'));


        return $objResponse->getXML();
	}

	function ajax_getGatves($data) {

        $objResponse = new tx_xajax_response();
        
        if(($mikro = intval($data['tx_vvrecatalog_pi1']['mikro'])) > 0) {
	        $gatves = $this->getGatves(0, $mikro);
        } else {
			$gatves = $this->getGatves(intval($data['tx_vvrecatalog_pi1']['gyvenviete']));        	
        }
        $gCount = count($gatves);
        $content = $this->getItems($gatves, 0, true);
        
        $objResponse->addAssign('cgatve', 'innerHTML', '<select '.(($gCount)?'':'disabled="disabled"').' id="gatve" name="tx_vvrecatalog_pi1[gatve]">'.$content.'</select>');
#        $objResponse->addAssign('gatve', 'disabled', (($gCount)?'':'disabled'));
        $objResponse->addScript('spinnerOff();');

        return $objResponse->getXML();
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
			$sel = ($selected == $value['uid'])?' selected="selected"':'';
			$content .='<option value="'.$value['uid'].'"'.$sel.'>'.$value['title'].'</option>';
		}
		return $content;
	}


}



if (t3lib_div::_GP('eID'))    { 
	$rcar_db = t3lib_div::makeInstance('tx_vvrcar_db');
	$rcar_db->init();
}	
 
?>
