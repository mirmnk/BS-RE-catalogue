<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007  <>
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


    // DEFAULT initialization of a module [BEGIN]
#unset($MCONF);
#require_once('conf.php');
#require_once($BACK_PATH.'init.php');
#require_once($BACK_PATH.'template.php');

$LANG->includeLLFile('EXT:vv_recatalog/mod1/locallang.xml');
require_once(PATH_t3lib.'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);    // This checks permissions and exits if the users has no permission for entry.
    // DEFAULT initialization of a module [END]



/**
 * Module 'REOptions' for the 'vv_recatalog' extension.
 *
 * @author     <>
 * @package    TYPO3
 * @subpackage    tx_vvrecatalog
 */
class  tx_vvrecatalog_module1 extends t3lib_SCbase {
	var $pageinfo;
	
	/**
	 * Initializes the Module
	 * @return    void
	 */
	function init()    {
	    global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
	
	    parent::init();

		$this->include_once[] = PATH_t3lib.'class.t3lib_tceforms.php';
		
		$this->saveOptions();
		$this->loadOptonsTable();
			
	    /*
	    if (t3lib_div::_GP('clear_all_cache'))    {
	        $this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
	    }
	    */
	}
	
	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return    void
	 */
	function menuConfig()    {
	    global $LANG;
	    $this->MOD_MENU = Array (
	        'function' => Array (
	            '1' => $LANG->getLL('function1'),
#	            '2' => $LANG->getLL('function2'),
#	            '3' => $LANG->getLL('function3'),
	        ),
	        'currency' => array(
	        	'' => '',
	        	'eur' => $LANG->getLL('currency_euro')
	        ),
	        'lang' => array(
	         
	        )
	    );
	    parent::menuConfig();
	}
	
	/**
	 * Main function of the module. Write the content to $this->content
	 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	 *
	 * @return    [type]        ...
	 */
	function main()    {
	    global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
	
	    // Access check!
	    // The page will show only if there is a valid page and if this page may be viewed by the user
	    $this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
	    $access = is_array($this->pageinfo) ? 1 : 0;
	
	    if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))    {
	
	            // Draw the header.
	        $this->doc = t3lib_div::makeInstance('mediumDoc');
	        $this->doc->backPath = $BACK_PATH;
	        $this->doc->form='<form action="" method="POST">';
	
	            // JavaScript
	        $this->doc->JScode = '
	            <script language="javascript" type="text/javascript">
	                script_ended = 0;
	                function jumpToUrl(URL)    {
	                    document.location = URL;
	                }
	            </script>
	        ';
	        $this->doc->postCode='
	            <script language="javascript" type="text/javascript">
	                script_ended = 1;
	                if (top.fsMod) top.fsMod.recentIds["web"] = 0;
	            </script>
	        ';
	
	        $headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']);
	
	        $this->content.=$this->doc->startPage($LANG->getLL('title'));
	        $this->content.=$this->doc->header($LANG->getLL('title'));
	        $this->content.=$this->doc->spacer(5);
	        $this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
	        $this->content.=$this->doc->divider(5);
	
	
	        // Render content:
	        $this->moduleContent();
	
	
	        // ShortCut
	        if ($BE_USER->mayMakeShortcut())    {
	            $this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
	        }
	
	        $this->content.=$this->doc->spacer(10);
	    } else {
	            // If no access or if ID == zero
	
	        $this->doc = t3lib_div::makeInstance('mediumDoc');
	        $this->doc->backPath = $BACK_PATH;
	
	        $this->content.=$this->doc->startPage($LANG->getLL('title'));
	        $this->content.=$this->doc->header($LANG->getLL('title'));
	        $this->content.=$this->doc->spacer(5);
	        $this->content.=$this->doc->spacer(10);
	    }
	}
	
	/**
	 * Prints out the module HTML
	 *
	 * @return    void
	 */
	function printContent()    {
	
	    $this->content.=$this->doc->endPage();
	    echo $this->content;
	}
	
	/**
	 * Generates the module content
	 *
	 * @return    void
	 */
	function moduleContent()    {
		global $LANG;
		
	    switch((string)$this->MOD_SETTINGS['function'])    {
	        case 1:
	        	$this->fillLanguagesSelect();
	        	$content .= $this->doc->section($LANG->getLL('currency_language_currency_label'), $this->getLanguageCurrencyTable(), 0, 0, 1);
	        	$content .= $this->getLanguageCurrencyForm();
				
				$content .=$this->doc->divider(15);      	
	        	$content .= $this->doc->section($LANG->getLL('currency_currency_rates_label'), $this->getCurrencyRatesForm(), 0, 0, 1);
				$content .=$this->doc->divider(15);
					        	
	            $this->content.=$content;
	        break;
        }
    }

	function getCurrencyRatesForm() {
		$curRates = array();
		foreach($this->MOD_MENU['currency'] as $currency => $label) {
			if(!empty($currency)) {
				$curRates[0][] = array('1&nbsp;', $label);
				$curRates[1][] = array($GLOBALS['LANG']->getLL('currency_currency_rates_is_label').'&nbsp;', '<input type="text" name="C[currency_'.$currency.']" size="8" value="'.((isset($this->options['currency_'.$currency]))?$this->options['currency_'.$currency]['value']:'').'" /> LTL');
				$curRates[2][] = array('', '');
			}
		}
		if(count($curRates)) {
				$curRates[0][] = array('', '');
				$curRates[1][] = array('', '');
				$curRates[2][] = array('', '<input type="submit" name="doSave" value="Save" />');				
		}
		return $this->doc->section(
					$GLOBALS['LANG']->getLL('currency_sitting_currency_rates_label'),
					$this->doc->menuTable($curRates[0], $curRates[1], $curRates[2]),
					1
				);
	}
	
	function getLanguageCurrencyForm() {
		global $LANG;
		return $this->doc->section( 
						$GLOBALS['LANG']->getLL('currency_language_currency_form_settings_label'),
						$this->doc->menuTable(
			        		array(
			        			array(
				        			$LANG->getLL('currency_lang_label'),
				        			$this->getFuncMenu("C[lang]",array(),$this->MOD_MENU["lang"])
			        			)
			        		),
			        		array(
			        			array(
				        			$LANG->getLL('currency_currency_label'),
				        			$this->getFuncMenu("C[currency]",array(),$this->MOD_MENU["currency"])
			        			)
			        		),
			        		array(
			        			array(
				        			' ',
				        			'<input type="submit" name="doSave" value="Save" />'
			        			)
			        		)
	        			),
	        			1
	        	);
	}
    
    function getLanguageCurrencyTable() {
    	$content = $this->doc->section(
    		$GLOBALS['LANG']->getLL('currency_language_currency_current_settings_label'),
    		$this->doc->menuTable(
	        		array(
	        			array($this->getCurrencyLangTable() 
						)
					)
				),
			1
		);
		return $content;
    }
    function fillLanguagesSelect() {

		$arrLang = t3lib_TCEforms::getAvailableLanguages(0,0);

		$this->MOD_MENU['lang'][0] = '';
		while(list(,$aLang) = each($arrLang)) {
			$this->MOD_MENU['lang'][$aLang['uid']] = $aLang['title'];
		}

    }
    
	function getTableData($arrData, $layout=0) {
		$tableLayout = array( 
			array (
			'table'	 => array ('<table border="0" cellspacing="1" cellpadding="3" style="width:100%;">', '</table>'),
	
			'defRowOdd' => array (
				'tr'	 => array('<tr class="bgColor4">','</tr>'),
				'0'		 => array('<td class="bgColor2" style="width:50%;"><strong style="color: #000;">','</strong></td>'),
				'defCol' => array('<td>','</td>'),
			),

			'defRowEven' => array (
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'0'		 => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),
				'defCol' => array('<td>','</td>'),
			)
		),

		array (
			'table'	 => array ('<table border="0" cellspacing="1" cellpadding="3" style="width:100%;">', '</table>'),
	
			'defRowOdd' => array (
				'tr'	 => array('<tr class="bgColor4">','</tr>'),
				'defCol' => array('<td>','</td>'),
			),

			'defRowEven' => array (
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'defCol' => array('<td>','</td>'),
			),
			'0' => array(
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),				
			)
		),
		
		);

		$table = array();
		$tr = 0;
		
		foreach($arrData as $trarr) {
			if (count($trarr)) {
				$table[$tr][0] = key($trarr);
				$table[$tr][1] = current($trarr);
				$tr++;
			}
		}
		return $this->doc->table($table, $tableLayout[$layout]);
	}
	
	function loadOptonsTable() {
		$this->options = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'*',
			'tx_vvrecatalog_options',
			'', '', '', '',
			'opt'
		);
		if(!is_array($this->options)) {
			$this->options = array();
		};
	}
	
	function getCurrencyLangTable() {
		if (!count($this->options)) {
			$this->loadOptonsTable();
		}
		
		$curLang = array();
		foreach($this->options as $option => $value) {
			if(strpos($option, 'currency_lang') !== false) {
				list(,,$lang) = explode('_', $option);
				$curLang[] = array($this->MOD_MENU['lang'][$lang] => $this->MOD_MENU['currency'][$value['value']]);
			}
		}
		return $this->getTableData($curLang);
	}
	
	function updateOptionsTable($option, $value) {
		$table = 'tx_vvrecatalog_options';
		$query = 'REPLACE INTO '.$table.' SET opt='.
		$GLOBALS['TYPO3_DB']->fullQuoteStr($option, $table).', value='.
		$GLOBALS['TYPO3_DB']->fullQuoteStr($value, $table);
		$GLOBALS['TYPO3_DB']->sql_query($query);
	}
	
	function getFuncMenu($elementName,$currentValue,$menuItems)	{
		if (is_array($menuItems))	{

			$options = array();
			foreach($menuItems as $value => $label)	{
				$options[] = '<option value="'.htmlspecialchars($value).'"'.(!strcmp($currentValue,$value)?' selected="selected"':'').'>'.
								t3lib_div::deHSCentities(htmlspecialchars($label)).
								'</option>';
			}
			if (count($options))	{
				return '

					<!-- Function Menu of module -->
					<select name="'.$elementName.'">
						'.implode('
						',$options).'
					</select>
							';
			}
		}
	}
	
	function saveOptions() {
		$data = t3lib_div::_POST('C');
		if (isset($data['lang']) && !empty($data['lang']) 
		    && isset($data['currency']) && !empty($data['currency'])
		) {
			$this->updateOptionsTable('currency_lang_'.intval($data['lang']), $data['currency']);
		}
		
		foreach($this->MOD_MENU['currency'] as $currency => $label) {
			if (isset($data['currency_'.$currency]) && !empty($data['currency_'.$currency])) {
				$this->updateOptionsTable('currency_'.$currency, $data['currency_'.$currency]);				
			}
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_recatalog/mod1/index.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_recatalog/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_vvrecatalog_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)    include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>