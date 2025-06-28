<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Miroslav Monkevic <m@dieta.lt>
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
/*
unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');
*/

$LANG->includeLLFile('EXT:vv_reexport/mod1/locallang.xml');
require_once(PATH_t3lib.'class.t3lib_scbase.php');
require_once('class.tx_vvreexport_redb.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]

DEFINE('ACTION_SELL', 1);
DEFINE('ACTION_RENT', 2);

/**
 * Module 'RE Export' for the 'vv_reexport' extension.
 *
 * @author	Miroslav Monkevic <m@dieta.lt>
 * @package	TYPO3
 * @subpackage	tx_vvreexport
 */
class  tx_vvreexport_module1 extends t3lib_SCbase {
	var $pageinfo;
	

	/**
	 * Initializes the Module
	 * @return	void
	 */
	function init()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		parent::init();
		
		$this->repLayout['flat_'.ACTION_SELL] = '2|3';
		$this->repLayout['flat_'.ACTION_RENT] = '2|3';
		$this->repLayout['accommodation_'.ACTION_SELL] = '2|3';
		$this->repLayout['accommodation_'.ACTION_RENT] = '2|3';
		$this->repLayout['house_'.ACTION_SELL] = '4|5';
		$this->repLayout['house_'.ACTION_RENT] = '4|5';
		$this->repLayout['homestead_'.ACTION_SELL] = '4|5';
		$this->repLayout['homestead_'.ACTION_RENT] = '4|5';
		$this->repLayout['land_'.ACTION_SELL] = '6|7';	
		
		
		$this->include_once[] = PATH_t3lib.'class.t3lib_tceforms.php';

		$this->checkForExport();
		/*
		if (t3lib_div::_GP('clear_all_cache'))	{
			$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
		}
		*/
	}

	function checkForExport() {
		$E = t3lib_div::_GP('E');
		$this->e = $E;
		if(isset($E['lang'])) {
			$this->doExport($E['lang']);
		}
	}
	
	function doExport($lang=0) {
		$redb = t3lib_div::makeInstance('tx_vvreexport_redb');
		$redb->setLang(array(intval($lang)));
		$this->html['flat_'.ACTION_SELL] = $redb->getReport('flat', ACTION_SELL);
		$this->html['flat_'.ACTION_RENT] = $redb->getReport('flat', ACTION_RENT);
		$this->html['accommodation_'.ACTION_SELL] = $redb->getReport('accommodation', ACTION_SELL);
		$this->html['accommodation_'.ACTION_RENT] = $redb->getReport('accommodation', ACTION_RENT);
		$this->html['house_'.ACTION_SELL] = $redb->getReport('house', ACTION_SELL);
		$this->html['house_'.ACTION_RENT] = $redb->getReport('house', ACTION_RENT);
		$this->html['homestead_'.ACTION_SELL] = $redb->getReport('homestead', ACTION_SELL);
		$this->html['homestead_'.ACTION_RENT] = $redb->getReport('homestead', ACTION_RENT);
		$this->html['land_'.ACTION_SELL] = $redb->getReport('land', ACTION_SELL);	
	}
	
	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return	void
	 */
	function menuConfig()	{
		global $LANG;
		$this->MOD_MENU = Array (
			'function' => Array (
				'1' => $LANG->getLL('function1'),
				'2' => $LANG->getLL('function2'),
				'3' => $LANG->getLL('function3'),
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
	 * @return	[type]		...
	 */
	function main()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;

		if (1)	{

				// Draw the header.
			$this->doc = t3lib_div::makeInstance('mediumDoc');
			$this->doc->backPath = $BACK_PATH;
			$this->doc->form='<form action="" method="POST">';

				// JavaScript
			$this->doc->JScode = '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
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
			if ($BE_USER->mayMakeShortcut())	{
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
	 * @return	void
	 */
	function printContent()	{

		$this->content.=$this->doc->endPage();
		echo $this->content;
	}

	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent()	{
		switch((string)$this->MOD_SETTINGS['function'])	{
			case 1:
				
				if(t3lib_div::_GP('exportWord')) {
					$this->sendAsMSWord();
				}
		
				if(t3lib_div::_GP('exportPDF')) {
					$this->sendAsPDF();
				}

				if(t3lib_div::_GP('exportXLS')) {
					$this->sendAsXLS();
				}
				
				$content=$this->getLanguageExportForm();
				$this->content.=$this->doc->section($GLOBALS['LANG']->getLL('reexport_options_section_label'),$content,0,0,1);
				$this->content.=$this->doc->divider(15);
				
				$this->addReportHTML();
/*				$this->content.='<br /><br />'.
								'GET:'.t3lib_div::view_array($_GET).'<br />'.
								'POST:'.t3lib_div::view_array($_POST).'<br />'.
								'MOD_SETTINGS:'.t3lib_div::view_array($this->MOD_SETTINGS).'<br />'.
								'';*/
			break;
			case 2:
				$content='<div align=center><strong>Menu item #2...</strong></div>';
				$this->content.=$this->doc->section('Message #2:',$content,0,1);
			break;
			case 3:
				$content='<div align=center><strong>Menu item #3...</strong></div>';
				$this->content.=$this->doc->section('Message #3:',$content,0,1);
			break;
		}
	}

	function sendAsMSWord() {
					// Setting filename:
		$filename='BS_'.date('dmy-Hi').'.doc';

			// Creating output header:
		$mimeType = 'application/msword';
		Header('Content-Type: '.$mimeType.'; charset=utf-8');
		Header('Content-Disposition: attachment; filename='.$filename);
 			// Printing the content of the CSV lines:
 		$strHtml = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
 		$strHtml .= $this->getReportHTML();
 		$strHtml .= '</body></html>';
		
 		echo $strHtml;

			// Exits:
		exit; 
		
	}

	function sendAsPDF() {
					// Setting filename:
		$filename='BS_'.date('dmy-Hi').'.pdf';

			// Creating output header:
		$mimeType = 'application/pdf';
		Header('Content-Type: '.$mimeType.'; charset=utf-8');
		Header('Content-Disposition: attachment; filename='.$filename);
 			// Printing the content of the CSV lines:
 		require_once t3lib_extMgm::extPath('pt_html2pdf')."class.tx_pthtml2pdf.php";
 		$html2pdf = t3lib_div::makeInstance("tx_pthtml2pdf");

 		require_once(PATH_t3lib.'class.t3lib_cs.php');
		$cs = t3lib_div::makeInstance('t3lib_cs');
			
 		$strHtml = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1257" /></head><body>';
 		$strHtml .= $cs->utf8_decode($this->getReportHTML(), 'windows-1257');
 		$strHtml .= '</body></html>';
 		
 		echo $html2pdf->getPdf($strHtml);

			// Exits:
		exit; 
		
	}

	function sendAsXLS() {
					// Setting filename:
		$filename='BS_'.date('dmy-Hi').'.xls';

			// Creating output header:
		$mimeType = 'application/vnd.ms-excel';
		Header('Content-Type: '.$mimeType.'; charset=utf-8');
		Header('Content-Disposition: attachment; filename='.$filename);
 			// Printing the content of the CSV lines:
 		$strHtml = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
 		$strHtml .= $this->getReportHTML();
 		$strHtml .= '</body></html>';
		
 		echo $strHtml;
		

			// Exits:
		exit; 
		
	}
	
	function getReportHTML() {
		$content = '<h2>'.date("Y.m.d").' '.$GLOBALS['LANG']->getLL('reexport_header_label_1').'</h2>';;
		foreach($this->html as $key => $arrTable) {
			if(count($arrTable)) {
				list($layout,) = explode('|', $this->repLayout[$key]);
				$layout = ($layout)?$layout:2;
				$content .= $this->getTableData($arrTable, $layout);
				$content .= '<br /><br />';
			}
		}
		
		return $content;
	}
	
	function addReportHTML() {
		if(count($this->html)) {
			$this->content.='<input type="submit" name="exportWord" value="MSWord" />
			<input type="submit" name="exportPDF" value="PDF" /> <input type="submit" name="exportXLS" value="XLS" />';
			$this->content .=$this->doc->divider(15);
			$this->content .= '<h2>'.date("Y.m.d").' '.$GLOBALS['LANG']->getLL('reexport_header_label_1').'</h2>';
			foreach($this->html as $key => $arrTable) {
				if(count($arrTable)) {
					$this->content.=$this->doc->divider(15);
					list(,$layout) = explode('|', $this->repLayout[$key]);
					$layout = ($layout)?$layout:3;		
					$this->content.= $this->getTableData($arrTable, $layout);
				}
			}
		}		
	}
	
	function fillLanguagesSelect() {

		$arrLang = t3lib_TCEforms::getAvailableLanguages(0,0);

		$this->MOD_MENU['lang'][0] = 'Lt';
		while(list(,$aLang) = each($arrLang)) {
			$this->MOD_MENU['lang'][$aLang['uid']] = $aLang['title'];
		}

    }
	
	function getLanguageExportForm() {
		global $LANG;
		$this->fillLanguagesSelect();
		return 	$this->doc->menuTable(
			        		array(
			        			array(
				        			$LANG->getLL('reexport_options_languages_label').': ',
				        			$this->getFuncMenu("E[lang]",$this->e['lang'],$this->MOD_MENU["lang"])
			        			)
			        		),
			        		array(
			        			array(
				        			' ',
				        			'<input type="submit" name="doSave" value="Export" />'
			        			)
			        		)
	        			);
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

	function getTableData($arrData=array(), $layout=0) {
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
// #2 for flats and premises pdf, xls, doc
		array (
			'table'	 => array ('<table border="1" cellspacing="1" cellpadding="3" style="width:100%;">', '</table>'),
	
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
				'0' => array('<td class="bgColor2" colspan="2"><strong style="color: #000;">','</strong></td>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),				
			),
			'1' => array(
				'0' => array('<td colspan="13">','</td>')
			)
		),
// #3 for flats and premises html
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
				'0' => array('<td class="bgColor2" colspan="2"><strong style="color: #000;">','</strong></td>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),				
			),
			'1' => array(
				'0' => array('<td colspan="13">','</td>')
			)
			
		),
// #4 for houses,premises pdf, xls, doc
		array (
			'table'	 => array ('<table border="1" cellspacing="1" cellpadding="3" style="width:100%;">', '</table>'),
	
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
				'0' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),				
			),
			'1' => array(
				'0' => array('<td colspan="13">','</td>')
			)
		),
// #5 for houses,premises html
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
				'0' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),				
			),
			'1' => array(
				'0' => array('<td colspan="13">','</td>')
			)
		),
// #6 for land pdf, xls, doc
		array (
			'table'	 => array ('<table border="1" cellspacing="1" cellpadding="3" style="width:100%;">', '</table>'),
	
			'defRowOdd' => array (
				'tr'	 => array('<tr class="bgColor4">','</tr>'),
				'defCol' => array('<td>','</td>'),
				'5' => array('<td clospan="3">','</td>'),
			),

			'defRowEven' => array (
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'defCol' => array('<td>','</td>'),
				'5' => array('<td clospan="3">','</td>'),
			),
			'0' => array(
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),
				'5' => array('<td  class="bgColor2" clospan="3"><strong style="color: #000;">','</strong></td>'),				
			),
			'1' => array(
				'0' => array('<td colspan="11">','</td>')
			)
		),
// #7 for land html
		array (
			'table'	 => array ('<table border="0" cellspacing="1" cellpadding="3" style="width:100%;">', '</table>'),
	
			'defRowOdd' => array (
				'tr'	 => array('<tr class="bgColor4">','</tr>'),
				'defCol' => array('<td>','</td>'),
				'5' => array('<td clospan="3">','</td>'),
			),

			'defRowEven' => array (
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'defCol' => array('<td>','</td>'),
				'5' => array('<td clospan="3">','</td>'),
			),
			'0' => array(
				'tr'	 => array('<tr class="bgColor5">','</tr>'),
				'defCol' => array('<td class="bgColor2"><strong style="color: #000;">','</strong></td>'),
				'5' => array('<td  class="bgColor2" clospan="3"><strong style="color: #000;">','</strong></td>'),				
			),
			'1' => array(
				'0' => array('<td colspan="11">','</td>')
			)
		),		
		);

		$table = array();
		$tr = 0;
		
		$colsNum = 0;
		
		foreach($arrData as $trarr) {
			$intCount = count($trarr);
			$colsNum = ($colsNum < $intCount)?$intCount:$colsNum;
		}
		
		foreach($arrData as $trarr) {
			if (count($trarr)) {
				$table[$tr][0] = key($trarr);
				$table[$tr][1] = current($trarr);
				$tr++;
			}
		}
		return $this->doc->table($arrData, $tableLayout[$layout]);
	}
    

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reexport/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_reexport/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_vvreexport_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>