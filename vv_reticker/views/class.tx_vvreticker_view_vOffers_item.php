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

require_once('class.tx_vvreticker_view_vOffersNProjects_item.php');

class tx_vvreticker_view_vOffers_item extends tx_vvreticker_view_vOffersNProjects_item {
	
	var $wrapDescr = '<p class="vv-reticker-vo-descr">|</p>';
	
	function printVOBlock() {
		$this->printVONPBlock();
	}
	
	function getDescription() {
		return $this->get('tx_vvreticker_votext');
	}

		
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/views/class.tx_vvreticker_view_vOffers_item.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/views/class.tx_vvreticker_view_vOffers_item.php']);
}

?>