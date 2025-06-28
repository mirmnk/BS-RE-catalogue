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
 * Created on 2008.02.06
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 * @package TYPO3
 * @subpackage vv_reexport
 */
 
/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/

class tx_vvreexport_redb  {
	var $tblList = 'tx_vvrecatalog_land,tx_vvrecatalog_flat,tx_vvrecatalog_house,tx_vvrecatalog_homestead,tx_vvrecatalog_accommodation';
	var $arrTables = array(
		'flat' => 'tx_vvrecatalog_flat',
		'house' => 'tx_vvrecatalog_house',
		'land' => 'tx_vvrecatalog_land',
		'homestead' => 'tx_vvrecatalog_homestead',
		'accommodation' => 'tx_vvrecatalog_accommodation',
	);
	
	function tx_vvreexport_redb($lang=array()) {
		if(is_array($lang) && count($lang)) {
			$this->setLang($lang);
		} else {
			$this->setLang(array(0));			
		}
	}

	function setLang($arrLang) {
		$this->curLangs = $arrLang;
	}
	
	function getReport($reObjName, $reAction=0) {
		$content = '';
		if($this->arrTables[$reObjName]) {
			$this->loadTable($this->arrTables[$reObjName], $reAction);
#			print_r($this->data);
			$content = $this->makeTable($reObjName, $reAction);
		}
		return $content;
	}
	
	function makeTable($reObjName, $reAction=0) {
		$table = array();
		if($dcount = count($this->data)) {
			$tblName = $this->arrTables[$reObjName];
			$headerFields = t3lib_div::trimExplode(',',$this->getHeaderFields($tblName), 1);
			$table[] = $this->getHeader($tblName);
			$table[] = array(strtoupper($GLOBALS['LANG']->getLL('reexport_header_'.$reObjName.'_label').'-'.$GLOBALS['LANG']->getLL('reexport_header_action_'.$reAction.'_label')).' ('.$dcount.')');
			foreach($this->data as $row) {
				$table[] = $this->getRow($row, $headerFields, $tblName);
			}
		}
		return $table;
	}
	
	function getHeader($table) {
		$headerFields = t3lib_div::trimExplode(',',$this->getHeaderFields($table), 1);
		$header = array();
		foreach($headerFields as $field) {
			$header[] = $this->getFieldHeader($field);
		}
		return $header;
	}
	
	function getRow(&$arrRow, &$arrFields, $tblName) {
		$row = array();
		foreach($arrFields as $field) {
			$rowVal = $this->getFieldValue($field, $arrRow, $tblName);
			if(is_array($rowVal)) {
				foreach($rowVal as $rVal) {
					$row[] = $rVal;
				}
			} else {
				$row[] = $rowVal;
			}
		}
		
		return $row;
	}
	
	function getFieldValue($field, &$arrRow, $table) {
		switch($field) {
			case 'rajonas':
				$content = (t3lib_div::inList('tx_vvrecatalog_accommodation,tx_vvrecatalog_flat', $table))?array($arrRow['roomcount'],$arrRow['rajonas']):$arrRow['rajonas'];
			break;
			case 'gyvenviete':
				$content = $arrRow['gyvenviete'].(($arrRow['mikro_rajonas'] || $arrRow['mikro_rajonas2'])?' / '.(($arrRow['mikro_rajonas2'])?$arrRow['mikro_rajonas2']:$arrRow['mikro_rajonas']):'');
			break;

			case 'gatve':
				$rec = t3lib_BEfunc::getRecord('tx_vvrcar_gatve', $arrRow['gatve'], 'title');
				$content = $rec['title'];
			break;

			
			case 'btype_bdate':
				$rec = t3lib_BEfunc::getRecord('tx_vvrecatalog_building_type', $arrRow['building_type'], 'title');
				$content = $rec['title'].(($arrRow['bdate'])?' '.$arrRow['bdate']:'');
			break;

			case 'contacts':
				$rec = t3lib_BEfunc::getRecord('tt_address', $arrRow['employee'], 'mobile');
				$content = $rec['mobile'];
			break;
			
			case 'floors':
				switch($table) {
					case 'tx_vvrecatalog_flat':
					case 'tx_vvrecatalog_accommodation':
						$content = $arrRow['floor'].'/'.$arrRow['floorcount'];
					break;
					
					default:
						$content = $arrRow['floorcount'];
					break;						
				}
			break;

			case 'area':
				$content = $arrRow['area'];
			break;

			case 'land_area':
				$content = $arrRow['land_area'];
			break;

			case 'land_type':
				$content = t3lib_BEfunc::getProcessedValue($table,'land_type',$arrRow['land_type']);
			break;
			
			
			case 'descr':
				$tmp = array();
				if($arrRow['installation']) {
					$tmp[] = t3lib_BEfunc::getProcessedValue($table,'installation',$arrRow['installation']);
				}
				if($arrRow['state']) {
					$tmp[] = t3lib_BEfunc::getProcessedValue($table,'state',$arrRow['state']);
				}
				if($arrRow['special']) {
					$tmp[] = t3lib_BEfunc::getProcessedValue($table,'special',$arrRow['special']);
				}
				if($arrRow['com_sys']) {
					$tmp[] = t3lib_BEfunc::getProcessedValue($table,'com_sys',$arrRow['com_sys']);
				}
				if(isset($arrRow['land_pos']) && $arrRow['land_pos'] == 1) {
					$tmp[] = $GLOBALS['LANG']->getLL('reexport_land_pos_label');
				}
				
				$content = (count($tmp))?implode(', ', $tmp):'';
			break;

			case 'price':
				$content = $arrRow['price'];
			break;
			
			case 'crdate':
				$content = date('m-d',$arrRow['tstamp']);
			break;
			
			case 'gid':
				$content = $arrRow['gid'];
			break;

			case 'ext_pub':
				$content = t3lib_BEfunc::getProcessedValue($table,'ext_pub',$arrRow['ext_pub']);
				$tmp = t3lib_div::trimExplode(',', $content);
				for($i=0; $i < count($tmp); $i++) {
					$matches = array();
					if(preg_match('/\((.){1,2}\)/i', $tmp[$i], $matches)) {
						$tmp[$i] = $matches[1];
					}
				}
				$content = implode(';', $tmp);
			break;
			
			default:
				$content = '';//$arrRow[$field];
			break;			
		}
		
		return ($content)?$content:'&nbsp;';
		
	}
	
	function getFieldHeader($field) {
		switch($field) {
			default:
				$content = $GLOBALS['LANG']->getLL('reexport_header_'.$field.'_label');
			break;			
		}
		
		return $content;
	}
	
	function getHeaderFields($table) {
		$fields = 'rajonas,gyvenviete,gatve';
		switch($table) {
        	case 'tx_vvrecatalog_flat' :
        	case 'tx_vvrecatalog_accommodation' :
				$fields .=',btype_bdate,floors,area,descr,price,contacts,gid,ext_pub,crdate';
        	break;
			     	
        	case 'tx_vvrecatalog_land' :
				$fields .=',land_type,land_area,descr,price,contacts,gid,ext_pub,crdate';
        	break;

        	case 'tx_vvrecatalog_homestead' :
        	case 'tx_vvrecatalog_house' :			
				$fields .=',btype_bdate,floors,area,descr,land_area,price,contacts,gid,ext_pub,crdate';
        	break;
		}

		return $fields;
	}
	
	function loadTable($tblName, $reAction=0) {
		$query = $this->getSingleTableQuery($tblName, 0, $reAction);
		unset($this->data);
		$this->data = array();
#print_r($query);
    	if($res = $GLOBALS['TYPO3_DB']->sql_query($query)) {
            while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                $this->data[] = $row;
            }
        }
	}

	function load($tables='all') {

		$this->data = array();

		switch($tables) {
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
#		$limit = ($limit = intval($this->controller->configurations->get('display_number')))?$limit:100;
		$limit = 0;

		
		
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
		
#print_r($unionQuery);

            if($res = $GLOBALS['TYPO3_DB']->sql_query($unionQuery)) {
	            while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
	                    $this->appendExtraValues($row);
	                    $this->data[] = $row;
	            }
            }
            
        }
        
        
    function getSingleTableQuery($table, $limit=100, $action=0) {
       
        $query = $GLOBALS['TYPO3_DB']->SELECTquery(
        	$this->getTableSelectFields($table),
        	$table.' '.  
	        	'LEFT OUTER JOIN tx_vvrcar_mikro_rajonas2 ON '.$table.'.mikro_rajonas2 = tx_vvrcar_mikro_rajonas2.uid '.
			'LEFT OUTER JOIN tx_vvrcar_mikro_rajonas ON '.$table.'.mikro_rajonas = tx_vvrcar_mikro_rajonas.uid '.
			'INNER JOIN tx_vvrcar_rajonas ON '.$table.'.rajonas=tx_vvrcar_rajonas.uid '.
			'INNER JOIN tx_vvrcar_gyvenviete ON '.$table. '.gyvenviete = tx_vvrcar_gyvenviete.uid '	,
        		'1=1'. $this->getWhereActionPart($action).
        		$this->getWhereLangPart($table).
        		t3lib_BEfunc::deleteClause($table).
				t3lib_BEfunc::BEenableFields($table),
        	'',
        	$this->getOrderByPart($table),
        	(($limit)?$limit:'')
        );
        
#        print_r($query);
        return $query;
    }
        
    function getWhereLangPart($table='') {
		return ' AND '.(($table)?$table.'.':'').'sys_language_uid IN ('.implode(',', array_merge($this->curLangs,array(-1))).')';
    }

    function getOrderByPart($table) {
    	switch($table) {
        	case 'tx_vvrecatalog_flat' :
        	case 'tx_vvrecatalog_accommodation' :
    			$content = 'roomcount, rajonas, gyvenviete, mikro_rajonas, mikro_rajonas2';
        	break;
        	
        	default:
    			$content = 'rajonas, gyvenviete, mikro_rajonas,mikro_rajonas2';
        	break;
    	}
    	
    	return $content;
    }
    
    function getWhereActionPart($action=0) {
		$retVal = ' AND action IN (1,2)';
		if (1 == $action  || 2 == $action) {
			$retVal = ' AND action ='.$action; 
		}
		return $retVal;
    }
        
        function getTableSelectFields($table) {
        $fields = $table.'.uid,'.
        			$table.'.gid,'.
        			$table.'.tstamp,'.
        			$table.'.crdate,'.
        			$table.'.ext_pub,'.
        			$table.'.employee,'.
        			$table.'.action,'.
        			'tx_vvrcar_rajonas.title as rajonas, tx_vvrcar_gyvenviete.title as gyvenviete, tx_vvrcar_mikro_rajonas.title as mikro_rajonas, tx_vvrcar_mikro_rajonas2.title as mikro_rajonas2,'.
        			$table.'.gatve,'.
        			$table.'.price,'.
        			$table.'.images';
        switch($table) {
        	case 'tx_vvrecatalog_flat' :
        	case 'tx_vvrecatalog_accommodation' :
        		$fields .= ','.$table.'.roomcount,'.
        			$table.'.building_type,'.
        			$table.'.bdate,'.
        			$table.'.floor,'.
        			$table.'.floorcount,'.
        			$table.'.area,'.
        			$table.'.state,'.
        			$table.'.installation,'.
        			$table.'.special';
        	break;
        	
        	case 'tx_vvrecatalog_land' :
        		$fields .= ','.$table.'.land_pos,'.
	        		$table.'.land_type,'.
	        		$table.'.land_pos,'.
	        		$table.'.land_area,'.
	        		$table.'.special,'.
	        		$table.'.com_sys';
        	break;

        	case 'tx_vvrecatalog_homestead' :
        	case 'tx_vvrecatalog_house' :
        		$fields .= ','.$table.'.building_type,'.
	        		$table.'.bdate,'.
	        		$table.'.floorcount,'.
	        		$table.'.area,'.
	        		$table.'.land_area,'.
	        		$table.'.land_pos,'.
	        		$table.'.state,'.
	        		$table.'.installation,'.
	        		$table.'.special';
        	break;

        	default:
				$fields = '';        		
        	break;
        }
        
        return $fields;
    }
       
}
 
?>
