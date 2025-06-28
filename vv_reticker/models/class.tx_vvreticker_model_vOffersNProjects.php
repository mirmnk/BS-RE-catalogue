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
 * Class that implements the model for table vOffersNProjects.
 *
 * Model for valuable offers and new projects
 *
 *
 * @author	Miroslav Monkevic <m@dieta.lt>
 * @package	TYPO3
 * @subpackage	tx_vvreticker
 */

class tx_vvreticker_model_vOffersNProjects extends tx_lib_object {

		var $tblList = 'tx_vvrecatalog_land,tx_vvrecatalog_flat,tx_vvrecatalog_house,tx_vvrecatalog_homestead,tx_vvrecatalog_accommodation';

        function tx_vvreticker_model_vOffersNProjects($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
        }

		function load() {
			switch($tables = (string)$this->controller->configurations->get('re_objects')) {
				case 'all' :
					$this->loadAll(t3lib_div::trimExplode(',', $this->tblList));
				break;
				
				default:
					$this->loadAll(t3lib_div::trimExplode(',', $tables));
				break;
			}
		}
		
        function loadAll($arrTables) {
			$unionQuery = '';
			$limit = ($limit = intval($this->controller->configurations->get('display_number')))?$limit:100;
			$rotateFromSubset = false;
			$rotate = ($this->controller->configurations->get('controller') == 'ticker2')?true:false;
			$rlimit = 0;

			if($rotate) {
				$rlimit = $limit;
				$limit = intval($this->controller->configurations->get('rotate_from'));
			}

			$arr = array();
			foreach($arrTables as $table) {
				$arr[] = '(' .$this->getSingleTableQuery($table, $limit).')';
			}

			if(count($arr) > 1) {
				$unionQuery = implode(' UNION ', $arr);
				$unionQuery .= ' ORDER BY tstamp DESC'.(($limit)?' LIMIT '.$limit:'');
			} else {
				$unionQuery = $arr[0];
			}			

			if($rotate) {
				$unionQuery = 'SELECT * FROM '.$unionQuery.' AS t ORDER BY RAND() LIMIT '.$rlimit;
			}	

            if($res = $GLOBALS['TYPO3_DB']->sql_query($unionQuery)) {
	            while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
	                    $entry = new tx_lib_object($row);
	                    $this->append($entry);
	            }
            }
#            $this->dump();
            
        }
        
       
        function getSingleTableQuery($table, $limit=100) {
        	$cObj = $this->controller->context->getContentObject();
        	
        	switch($this->controller->configurations->get('what_to_display')) {
        		case 2:
        			$atype = 1;
        		break;
        		case 3:
        			$atype = 2;
        		break;
        	}
        	
        	$query = $GLOBALS['TYPO3_DB']->SELECTquery(
        		$this->getTableSelectFields($table),
        		$table,
        		'(tx_vvreticker_atype & '.$atype.') > 0 '.
        			$this->getWhereActionPart().
        			$this->getWhereLangPart().
        			$cObj->enableFields($table).
        			' AND pid IN ('.$this->pi_getPidList(
        				$this->controller->configurations->get('pages'),
        				$this->controller->configurations->get('recursive')
        			).')',
        		'',
        		'tstamp DESC',
        		$limit
        	);
        	return $query;
        }
        
        function getWhereLangPart() {
			$sys_language_content = intval($GLOBALS['TSFE']->sys_language_content).',-1';
			return ' AND sys_language_uid IN ('.$sys_language_content.')';
        }

        function getWhereActionPart() {
			$action = intval($this->controller->configurations->get('re_action'));
			$retVal = ' AND action IN (1,2)';
			if (1 == $action  || 2 == $action) {
				$retVal = ' AND action ='.$action; 
			}
			return $retVal;
        }
        
        function getTableSelectFields($table) {
        	$fields = 'uid, gid, tstamp, action, city, district, street, price, images, tx_vvreticker_atext';
        	
        	return $fields;
        }
        
	/**
	 * Returns a commalist of page ids for a query (eg. 'WHERE pid IN (...)')
	 *
	 * @param	string		$pid_list is a comma list of page ids (if empty current page is used)
	 * @param	integer		$recursive is an integer >=0 telling how deep to dig for pids under each entry in $pid_list
	 * @return	string		List of PID values (comma separated)
	 */
	function pi_getPidList($pid_list,$recursive=0)	{
		if (!strcmp($pid_list,''))	$pid_list = $GLOBALS['TSFE']->id;
		$recursive = t3lib_div::intInRange($recursive,0);

		$pid_list_arr = array_unique(t3lib_div::trimExplode(',',$pid_list,1));
		$pid_list = array();
		
		$cObj = $this->controller->context->getContentObject();

		foreach($pid_list_arr as $val)	{
			$val = t3lib_div::intInRange($val,0);
			if ($val)	{
				$_list = $cObj->getTreeList(-1*$val, $recursive);
				if ($_list)		$pid_list[] = $_list;
			}
		}

		return implode(',', $pid_list);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/models/class.tx_vvreticker_model_vOffersNProjects.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/models/class.tx_vvreticker_model_vOffersNProjects.php']);
}

?>