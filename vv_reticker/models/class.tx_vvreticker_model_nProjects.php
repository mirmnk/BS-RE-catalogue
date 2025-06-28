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
 
require_once('class.tx_vvreticker_model_vOffersNProjects.php');

class tx_vvreticker_model_nProjects extends tx_vvreticker_model_vOffersNProjects {

        function tx_vvreticker_model_nProjects($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
        }

        function getSingleTableQuery($table, $limit=100) {
        	$cObj = $this->controller->context->getContentObject();
        	
      	
        	$query = $GLOBALS['TYPO3_DB']->SELECTquery(
        		$this->getTableSelectFields($table),
        		$table,
        		'tx_vvreticker_np = 1 '.
        			$this->getWhereActionPart().
        			$this->getWhereLangPart().
        			$cObj->enableFields($table).
        			' AND pid IN ('.$this->pi_getPidList(
        				$this->controller->configurations->get('pages'),
        				$this->controller->configurations->get('recursive')
        			).')',
        		'',
        		'tstamp DESC',
        		(($limit)?$limit:'')
        	);
        	return $query;
        }
        
        
        function getTableSelectFields($table) {
        	$fields = 'uid, gid, tstamp, images, tx_vvreticker_nptext';
        	
        	return $fields;
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/models/class.tx_vvreticker_model_nProjects.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/models/class.tx_vvreticker_model_nProjects.php']);
}

?>