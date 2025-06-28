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

class tx_vvreticker_view_vOffersNProjects_item extends tx_lib_phpTemplateEngine {
	var $cropChars = 250; 
	var $wrapDescr = '<p class="vv-reticker-newsblock-descr">|</p>';
	
	function printVONPBlock() {

		$this->cObj = $this->controller->context->getContentObject();
		$decr = $this->getDescription();

		$content = $this->getImageTag($decr);
		$content .= $this->cObj->TEXT(array('value' => $decr, 'crop' => $this->cropChars.'|...|1', 'wrap' => $this->wrapDescr));		
		
		
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
	
	function getDescription() {
		return $this->get('tx_vvreticker_votext');
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


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/views/class.tx_vvreticker_view_vOffersNProjects_item.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/views/class.tx_vvreticker_view_vOffersNProjects_item.php']);
}

?>