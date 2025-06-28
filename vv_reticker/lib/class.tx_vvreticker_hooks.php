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


class tx_vvreticker_hooks {

    function processDatamap_postProcessFieldArray ($status, $table, $id, &$fieldArray, &$pObj) {
    	
        $tblList = 'tx_vvrecatalog_land,tx_vvrecatalog_flat,tx_vvrecatalog_house,' .
        			'tx_vvrecatalog_homestead,tx_vvrecatalog_accommodation';
	    	// if it's an update
	    if ($status == 'update'  && t3lib_div::inList($tblList, $table)){
			// list of field that shoul not trigger tstamp update
			$nonUfields = 'tx_vvreticker_vo,tx_vvreticker_votext,tx_vvreticker_np,tx_vvreticker_nptext,l18n_diffsource,tstamp';
			$doNotUpdateTS = true;
			foreach($fieldArray as $field => $value) {
				if(!t3lib_div::inList($nonUfields,$field)) {
					$doNotUpdateTS = false;
				}
			}		
			if($doNotUpdateTS) {
				$fieldArray['tstamp'] = $pObj->checkValue_currentRecord['tstamp'];
			}
	    }
    }

} 

?>