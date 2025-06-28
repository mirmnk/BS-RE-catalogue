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
 * Class that implements the controller "ticker" for tx_vvreticker.
 *
 * Main conroller for ads ticker plugin
 *
 *
 * @author	Miroslav Monkevic <m@dieta.lt>
 * @package	TYPO3
 * @subpackage	tx_vvreticker
 */

tx_div::load('tx_lib_controller');

class tx_vvreticker_controller_ticker extends tx_lib_controller {
	var $defaultAction = 'show';
	var $templatePathKey = 'phpTemplatePath';
	var $keyOfPathToLanguageFile = 'pathToLanguageFile';
	var $translatorClassName = 'tx_lib_translator';
	var $className = 'tx_vvreticker_controller_ticker';

	var $targetControllers = array();

    function tx_vvreticker_controller_ticker($parameter1 = null, $parameter2 = null) {
        parent::tx_lib_controller($parameter1, $parameter2);
        $this->setDefaultDesignator('tx-vvreticker');
    }

	function showAction() {
		$content = '';
#$this->configurations->dump();

		switch(intval($this->configurations->get('what_to_display'))) {
			case 1 :
				$content = $this->showNewsAction();
			break;

			case 2:
				$content = $this->showVOAction();
			break;	
			
			case 3:
				$content = $this->showNPAction();
			break;

			default:
				$content = $this->showNewsAction();
			break;
		}
		
		return '<div class="'.$this->getDefaultDesignator().'">'.$content.'</div>';
	}

	/**
	 * Implementation of showVOandNPAction()
	 */
    function showNewsAction() {
        $modelClassName = tx_div::makeInstanceClassName('tx_vvreticker_model_news');
        $viewClassName = tx_div::makeInstanceClassName('tx_vvreticker_view_news');
        
        $entryClassName = tx_div::makeInstanceClassName('tx_vvreticker_view_news_item');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
 
        $model = new $modelClassName($this);
        $model->load();
        $view = new $viewClassName($this);

        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }
        $view->setPathToTemplateDirectory($this->configurations->get('templatePath'));
        $template = ($this->configurations->get('display_layout') == 2)?'NewsVerticalView':'NewsHorizontalView';
        $view->render($template);
		$translator = new $translatorClassName($this, $view);
		$out = $translator->translateContent();
        return $out;
    }


	/**
	 * Implementation of showVOandNPAction()
	 */
    function showVOAction() {
        $modelClassName = tx_div::makeInstanceClassName('tx_vvreticker_model_vOffers');
        $viewClassName = tx_div::makeInstanceClassName('tx_vvreticker_view_vOffersNProjects');

        $entryClassName = tx_div::makeInstanceClassName('tx_vvreticker_view_vOffers_item');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');

        $model = new $modelClassName($this);
        $model->load();
        $view = new $viewClassName($this);

        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }
        $view->setPathToTemplateDirectory($this->configurations->get('templatePath'));
        $template = ($this->configurations->get('display_layout') == 2)?'VOverticalView':'VOhorizontalView';
        $view->render($template);
		$translator = new $translatorClassName($this, $view);
		$out = $translator->translateContent();
        return $out;
    }
    
	/**
	 * Implementation of showVOandNPAction()
	 */
    function showNPAction() {
        $modelClassName = tx_div::makeInstanceClassName('tx_vvreticker_model_nProjects');
        $viewClassName = tx_div::makeInstanceClassName('tx_vvreticker_view_vOffersNProjects');

        $entryClassName = tx_div::makeInstanceClassName('tx_vvreticker_view_nProjects_item');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');

        $model = new $modelClassName($this);
        $model->load();
        $view = new $viewClassName($this);

        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }
        $view->setPathToTemplateDirectory($this->configurations->get('templatePath'));
        $template = ($this->configurations->get('display_layout') == 2)?'NPverticalView':'NPhorizontalView';
        $view->render($template);
		$translator = new $translatorClassName($this, $view);
		$out = $translator->translateContent();
        return $out;
    }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/controllers/class.tx_vvreticker_controller_ticker.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reticker/controllers/class.tx_vvreticker_controller_ticker.php']);
}

?>