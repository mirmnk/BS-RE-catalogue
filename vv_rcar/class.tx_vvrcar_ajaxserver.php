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
 * Created on 2008.01.25
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 * @package
 * @subpackage 
 */
 
/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/
// TODO: find other solution than hardcoded path!?
define('TYPO3_MOD_PATH', '../typo3conf/ext/vv_rcar/');
$BACK_PATH = '../../../typo3/';

require ($BACK_PATH.'init.php');
require_once(PATH_t3lib.'class.t3lib_ajax.php');



class tx_vvrcar_ajaxserver {
	var $table; 			// To store the table which is to be checked
	var $evalField;			// Name of the field that is to be checked
	var $evalFieldValue; 	// The value of the field that is to be checked
	var $evalMode; 			// What has to be checked, e.g. uniqueInPid
	var $uid;				// The uid of the actual record
	var $pid; 				// The pid of the actual records in case we have to check in a specific pid only
	var $msgContainerId; 	// ID of HTML element which will be altered to show the eval result
	
	
	/*
	 * Function to set up the class variables & co.
	 * 
	 */
	function init() {
		
		// Get vars from XMLHttpRequest
		$this->table = t3lib_div::_GP('table');
		$this->evalField = t3lib_div::_GP('evalField');
		$this->evalFieldValue = t3lib_div::_GP('evalFieldValue');
		$this->valField = t3lib_div::_GP('valField');
		$this->labelField = t3lib_div::_GP('labelField');
		$this->updateField = t3lib_div::_GP('updateField');
		$this->localTable = t3lib_div::_GP('localTable');
		$this->mmTable = t3lib_div::_GP('mmTable');
		
	} 
	
	// TODO: Split up function main() in init(), main(), response(), etc.
	function main() {
		
	
	
#$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
		if($this->localTable && $this->mmTable) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query(
					$this->table.'.'.$this->valField.', '.$this->table.'.'.$this->labelField,
					$this->localTable,
					$this->mmTable,
					$this->table,
					t3lib_BEfunc::deleteClause($this->localTable).
						t3lib_BEfunc::BEenableFields($this->localTable).
						t3lib_BEfunc::deleteClause($this->table).
						t3lib_BEfunc::BEenableFields($this->table).					
						' AND uid_local='.$this->evalFieldValue,
					'',
					$this->table.'.'.$this->labelField
			);
		
			while($tempRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
					$rows[] = $tempRow;
			}
			
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		} else {
			$where = $this->evalField.' = \''.$this->evalFieldValue.'\'';
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
											$this->valField.','.$this->labelField, 
											$this->table, 
											$where.t3lib_BEfunc::deleteClause($this->table).
											t3lib_BEfunc::BEenableFields($this->table)
			);
		}		
		
		$return = array();
		$return[] = '<data>';
		$return[] = '<responseMsg>'.$this->getJSON($rows).'</responseMsg>';
		$return[] = '<updateField>'.$this->updateField.'</updateField>';
		$return[] = '</data>';
		
		$return = implode('',$return);
#$return = $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
		t3lib_ajax::outputXMLreply($return);
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
			require_once(PATH_typo3.'contrib/json/json.php');
			$GLOBALS['JSON'] = t3lib_div::makeInstance('Services_JSON');
		}
		return $GLOBALS['JSON']->encode($jsonArray);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_rcar/class.tx_vvrcar_ajaxserver.php']) {
        include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_rcar/class.tx_vvrcar_ajaxserver.php']);
}

// Make instance:
$SOBE = t3lib_div::makeInstance('tx_vvrcar_ajaxserver');
$SOBE->init();


$SOBE->main(); 
?>
