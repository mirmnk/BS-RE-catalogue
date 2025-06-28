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
 * Created on 2008.01.24
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 * @package
 * @subpackage 
 */
 
/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/

class tx_vvrcar_hooks {
	function getSingleField_postProcess($table, $field, $row, $out, $PA, $pObj) {
#		debug(array($table, $field, $row, $out, $PA, $pObj));
	}
	
	function processDatamap_postProcessFieldArray ($status, $table, $id, &$fieldArray, &$pObj) {
#		debug(array($status, $table, $id, &$fieldArray));
 #       $tblList = 'tx_vvrecatalog_land,tx_vvrecatalog_flat,tx_vvrecatalog_house,' .
#        			'tx_vvrecatalog_homestead,tx_vvrecatalog_accommodation';
#		if 
	}
	
	function user_process_gatve(&$items, &$pObj) {
		if($micro = intval($items['row']['mikro_rajonas'])) {
			$fConf['config'] = $items['config'];

			$items['items'] = $pObj->initItemArray(array('config' => $items['config']));

			$foreighTable =$items['config']['itemsProcFunc_conf']['foreign_table'];
			$mmTable = $items['config']['itemsProcFunc_conf']['MM'];
			$localTable = 'tx_vvrcar_mikro_rajonas';
#$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
			$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query(
					$foreighTable.'.title, '.$foreighTable.'.uid, \'\'',
					$localTable,
					$mmTable,
					$foreighTable,
					t3lib_BEfunc::deleteClause($localTable).
						t3lib_BEfunc::BEenableFields($localTable).
						t3lib_BEfunc::deleteClause($foreighTable).
						t3lib_BEfunc::BEenableFields($foreighTable).					
						' AND uid_local='.$items['row']['mikro_rajonas'],
					'',
					$foreighTable.'.title'
			);
#debug($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);			
			while($tempRow = $GLOBALS['TYPO3_DB']->sql_fetch_row($res))	{
					$items['items'][] = $tempRow;
			}
			
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		} else {
			$fConf['config'] = $items['config'];
			$fConf['config']['foreign_table'] = $items['config']['itemsProcFunc_conf']['foreign_table'];
			$fConf['config']['foreign_table_where'] = $items['config']['itemsProcFunc_conf']['foreign_table_where'];
			$items['items'] = $pObj->addSelectOptionsToItemArray(
									$pObj->initItemArray(array('config' => $items['config'])),
									$fConf,
									$pObj->setTSconfig($items['table'],$items['row']),
									$items['field']
							);
		}
#		debug($fConf);
#		debug(array($items));
	}
} 
?>
