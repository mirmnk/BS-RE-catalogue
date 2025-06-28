<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Miroslav Monkevič <m@dieta.lt>
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
/*unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');*/

$LANG->includeLLFile('EXT:vv_rcar/mod1/locallang.xml');
$LANG->includeLLFile('EXT:vv_rcar/locallang_db.xml');

require_once(PATH_t3lib.'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'RC AR import' for the 'vv_rcar' extension.
 *
 * @author	Miroslav Monkevič <m@dieta.lt>
 * @package	TYPO3
 * @subpackage	tx_vvrcar
 */
class  tx_vvrcar_module1 extends t3lib_SCbase {
	var $pageinfo;
	var $tables = 'tx_vvrcar_apskritis,tx_vvrcar_rajonas,tx_vvrcar_gyvenviete,tx_vvrcar_mikro_rajonas,tx_vvrcar_gatve';
	var $DPLGMdata = array(); 
	var $pid = 32;
	var $doSyncTable = '';
	var $xajaxOn = false;
	var $xajax;
	
	/**
	 * Initializes the Module
	 * @return	void
	 */
	function init()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
	
		parent::init();

		$this->debugOn = FALSE;            
		$this->MCONF = $GLOBALS['MCONF'];
		$this->processParameters();
	
		/*
		if (t3lib_div::_GP('clear_all_cache'))	{
			$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
		}
		*/
	}
	
	function processParameters() {
		switch((string)$this->MOD_SETTINGS['function'])	{
			case 1:
				$SYNC = t3lib_div::_GP('SYNC');
				if(is_array($SYNC) && count($SYNC) && ($table = key($SYNC)) && $SYNC[$table]) {
					$this->doSyncTable = $table;
					if(t3lib_div::inList('tx_vvrcar_gyvenviete,tx_vvrcar_mikro_rajonas,tx_vvrcar_gatve', $table)) {
			
					}
				}
				$this->xajaxInit();	
			break;
			case 2:
				$this->fileUpload = (intval(t3lib_div::_GP('file')) == 1)?TRUE:FALSE;
			break;
		}		
	}
	
	function xajaxInit() {
		$this->xajaxOn = true;
		require_once(t3lib_extMgm::extPath("xajax")."class.tx_xajax.php");
		$this->xajax = new tx_xajax();	
#		$this->xajax->debugOn ();
		
        $this->xajax->registerFunction(array("tx_vvrcar_sync_tx_vvrcar_gyvenviete",&$this,"sync_tx_vvrcar_gyvenviete"));
        $this->xajax->registerFunction(array("tx_vvrcar_sync_tx_vvrcar_mikro_rajonas",&$this,"sync_tx_vvrcar_mikro_rajonas"));
        $this->xajax->registerFunction(array("tx_vvrcar_sync_tx_vvrcar_gatve",&$this,"sync_tx_vvrcar_gatve"));
        $this->xajax->registerFunction(array("tx_vvrcar_sync_tx_vvrcar_micro_gatve",&$this,"sync_tx_vvrcar_micro_gatve"));        
        	
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
#				'3' => $LANG->getLL('function3'),
			),
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
	
		if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{
	
				// Draw the header.
			$this->doc = t3lib_div::makeInstance('mediumDoc');
			$this->doc->backPath = $BACK_PATH;
			$this->doc->form='<form action="" method="POST">';
			$this->doc->form = '<form action="" method="post" name="editform" enctype="'.$TYPO3_CONF_VARS['SYS']['form_enctype'].'">';
	
				// JavaScript
			$this->doc->JScode = '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
				</script>
			';
			if($this->xajaxOn) {
				$this->doc->JScode .= $this->xajax->getJavascript(t3lib_extMgm::extRelPath('xajax'));    // Add xajaxs javascriptcode to the header'
			}

			$this->doc->postCode='
				<script language="javascript" type="text/javascript">
					script_ended = 1;
					if (top.fsMod) top.fsMod.recentIds["web"] = 0;
				</script>
			';
	
			$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);
	
			$this->content.=$this->doc->startPage($LANG->getLL('title'));
			$this->content.=$this->doc->header($LANG->getLL('title'));
			$this->content.=$this->doc->spacer(5);
			$this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
			$this->content.=$this->doc->divider(5);
	
	
			// Render content:
			$this->moduleContent();
            $this->debugContent();			
	
	
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
		
		if($this->xajaxOn) {
			$this->xajax->processRequests();    // Before your script sends any output, have xajax handle any requests
		}
	
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

/*				$zipCont = t3lib_div::getUrl('http://www.aruodas.lt/import/registras.zip');
				$tmpName = t3lib_div::tempnam('test.zip');
				t3lib_div::writeFileToTypo3tempDir($tmpName, $zipCont);
				$this->xmlparser->parseFile($this->unzipFile($tmpName));
				t3lib_div::unlink_tempfile($tmpName);*/

				$this->execSYNC();		
				$content .= $this->getTableRecCountTable();
				$this->content.=$this->doc->section('Message #1:',$content,0,1);
			break;
			case 2:
				if ($this->fileUpload) {
					$content = $this->uploadProcessing();
				} else {
					$content = $this->uploadForm();
				}
				$this->content.=$this->doc->section('Message #2:',$content,0,1);
			break;
			case 3:
				$content='<div align=center><strong>Menu item #3...</strong></div>';
				$this->content.=$this->doc->section('Message #3:',$content,0,1);
				break;
		}
		$this->debug('GET:', $_GET);		
		$this->debug('POST:', $_POST);
		$this->debug('FILES:', $_FILES);
		$this->debug('MOD_SETTINGS:', $this->MOD_SETTINGS);
		$this->debug('MOD_MENU:', $this->MOD_MENU);
		$this->debug('MCONF:', $GLOBALS['MCONF']);					

	}
	
	function execSYNC() {
		if(!(empty($this->doSyncTable))) {
			$this->syncTable($this->doSyncTable);
		}	
	}
	
	function syncTable($table) {
		$this->debug('syncTable', array($table));
		switch($table) {
			case 'tx_vvrcar_apskritis':
				$this->sync_tx_vvrcar_apskritis();
			break;

			case 'tx_vvrcar_rajonas':
				$this->sync_tx_vvrcar_rajonas();
			break;

			case 'tx_vvrcar_gyvenviete':
				$this->sync_tx_vvrcar_gyvenviete();
			break;

			case 'tx_vvrcar_mikro_rajonas':
				$this->sync_tx_vvrcar_mikro_rajonas();
			break;

			case 'tx_vvrcar_gatve':
				$this->sync_tx_vvrcar_gatve();
			break;


		}
	}
	
	function sync_tx_vvrcar_apskritis() {
		$this->getDPLGMdata('vieta_apskritys');
		foreach($this->DPLGMdata as $row) {
			$rcuid = intval($row['id']);
			if(!$this->recExists('tx_vvrcar_apskritis', 'rcuid', $rcuid)) {
				$data['tx_vvrcar_apskritis']['NEW'.$rcuid] = array(
					'title' => $row['title'],
					'rcuid' => $rcuid,
					'pid' => $this->pid
				);
			}
		};
		$this->debug('TCEmain', $data);
		$this->process_datamap($data);
	}

	function sync_tx_vvrcar_rajonas() {
		$rcUidCounty = $this->getRCuidArr('tx_vvrcar_apskritis');
		foreach($rcUidCounty as $auid => $rcCUid) {
			$this->getDPLGMdata('vieta_miestai_rajonai', $rcCUid);			
			foreach($this->DPLGMdata as $row) {
				$rcuid = intval($row['id']);
				if(!$this->recExists('tx_vvrcar_rajonas', 'rcuid', $rcuid)) {
					$data['tx_vvrcar_rajonas']['NEW'.$rcuid] = array(
						'title' => $row['title'],
						'rcuid' => $rcuid,
						'pid' => $this->pid,
						'auid' => $auid,
						'rcauid' => $rcCUid
					);
				}
			};
		}
		$this->debug('TCEmain', $data);
		$this->process_datamap($data);
	}

	function sync_tx_vvrcar_gyvenviete($arg) {

		$my_vars = $GLOBALS["BE_USER"]->getSessionData("tx_vvrcar");
		if(isset($my_vars['r_array'])) {
			$rcUidDistr = unserialize($my_vars['r_array']);
			if(!is_array($rcUidDistr)) {
				$rcUidDistr = $this->getRCuidArr('tx_vvrcar_rajonas');				
			}
		}
		if($rCount = count($rcUidDistr)) {
			$ruid = key($rcUidDistr);
			$rcDUid = $rcUidDistr[$ruid];
			unset($rcUidDistr[$ruid]);
			
			$this->getDPLGMdata('vieta_gyvenvietes', $rcDUid);			
			foreach($this->DPLGMdata as $row) {
				$rcuid = intval($row['id']);
				if(!$this->recExists('tx_vvrcar_gyvenviete', 'rcuid', $rcuid)) {
					$data['tx_vvrcar_gyvenviete']['NEW'.$rcuid] = array(
						'title' => $row['title'],
						'rcuid' => $rcuid,
						'pid' => $this->pid,
						'ruid' => $ruid,
						'rcruid' => $rcDUid
					);
				}
			};
			$this->process_datamap($data);
		}

		$my_vars['r_array'] = serialize($rcUidDistr);
		$GLOBALS["BE_USER"]->setAndSaveSessionData ('tx_vvrcar', $my_vars);
		
	    // Instantiate the tx_xajax_response object
		$objResponse = new tx_xajax_response();
		$objResponse->addAssign("count-tx_vvrcar_gyvenviete","innerHTML", $this->getTableRecCount('tx_vvrcar_gyvenviete'));
		$objResponse->addAssign("sync-tx_vvrcar_gyvenviete","value", (($rCount-1)?'Liko '.($rCount-1):'Synchronize'));
		if($rCount-1) {
			$objResponse->addScriptCall('xajax_tx_vvrcar_sync_tx_vvrcar_gyvenviete', 'hi');
		}				

        //return the XML response generated by the tx_xajax_response object
       return $objResponse->getXML();
	}

	function sync_tx_vvrcar_mikro_rajonas($arg) {

		$my_vars = $GLOBALS["BE_USER"]->getSessionData("tx_vvrcar");
		if(isset($my_vars['g_array'])) {
			$rcUidStlm = unserialize($my_vars['g_array']);
			if(!is_array($rcUidStlm)) {
#				$rcUidStlm = $this->getRCuidArr('tx_vvrcar_gyvenviete');
// Vilnius ir Kaunas
				$rcUidStlm = $this->getRCuidArr('tx_vvrcar_gyvenviete', 'rcuid IN (43,6)');			
			}
		}
		if($gCount = count($rcUidStlm)) {
			$hasDistr = false;
			$gCount2 = ($gCount > 100)?$gCount-100:0;
			while(!$hasDistr && ($gCount-$gCount2)) {
				$gCount--;
				$guid = key($rcUidStlm);
				$rcGUid = $rcUidStlm[$guid];
				unset($rcUidStlm[$guid]);		
				$this->getDPLGMdata('vieta_micro_districts', $rcGUid);	
				$hasDistr = is_array($this->DPLGMdata);
			}
			if(is_array($this->DPLGMdata)) {		
				foreach($this->DPLGMdata as $row) {
					$rcuid = intval($row['id']);
					if(!$this->recExists('tx_vvrcar_mikro_rajonas', 'rcuid', $rcuid)) {
						$data['tx_vvrcar_mikro_rajonas']['NEW'.$rcuid] = array(
							'title' => $row['title'],
							'rcuid' => $rcuid,
							'pid' => $this->pid,
							'guid' => $guid,
							'rcguid' => $rcGUid
						);
					}
				};
				$this->process_datamap($data);
			}
		}

		$my_vars['g_array'] = serialize($rcUidStlm);
		$GLOBALS["BE_USER"]->setAndSaveSessionData ('tx_vvrcar', $my_vars);
		
	    // Instantiate the tx_xajax_response object
		$objResponse = new tx_xajax_response();
		$objResponse->addAssign("count-tx_vvrcar_mikro_rajonas","innerHTML", $this->getTableRecCount('tx_vvrcar_mikro_rajonas'));
		$objResponse->addAssign("sync-tx_vvrcar_mikro_rajonas","value", (($gCount)?'Liko '.($gCount):'Synchronize'));
		if($gCount) {
			$objResponse->addScriptCall('xajax_tx_vvrcar_sync_tx_vvrcar_mikro_rajonas', 'hi');
		}				


        //return the XML response generated by the tx_xajax_response object
       return $objResponse->getXML();
	}

	function sync_tx_vvrcar_gatve($arg) {

		$my_vars = $GLOBALS["BE_USER"]->getSessionData("tx_vvrcar");
		if(isset($my_vars['str_array'])) {
			$rcUidStlm = unserialize($my_vars['str_array']);
			if(!is_array($rcUidStlm) || !count($rcUidStlm)) {
				$rcUidStlm = $this->getRCuidArr('tx_vvrcar_gyvenviete');
			}
		}
		if($gCount = count($rcUidStlm)) {
			$hasStreets = false;
			$gCount2 = ($gCount > 100)?$gCount-100:0;
			while(!$hasStreets && ($gCount-$gCount2)) {
				$gCount--;
				$guid = key($rcUidStlm);
				$rcGUid = $rcUidStlm[$guid];
				unset($rcUidStlm[$guid]);		
				$this->getDPLGMdata('vieta_gatves', $rcGUid);	
				$hasStreets = is_array($this->DPLGMdata);
			}
			if(is_array($this->DPLGMdata)) {		
				foreach($this->DPLGMdata as $row) {
					$rcuid = intval($row['id']);
					if(!$this->recExists('tx_vvrcar_gatve', 'rcuid', $rcuid)) {
						$data['tx_vvrcar_gatve']['NEW'.$rcuid] = array(
							'title' => $row['title'],
							'rcuid' => $rcuid,
							'pid' => $this->pid,
							'guid' => $guid,
							'rcguid' => $rcGUid
						);
					}
				};
				$this->process_datamap($data);
			}
		}

		$my_vars['str_array'] = serialize($rcUidStlm);
		$GLOBALS["BE_USER"]->setAndSaveSessionData ('tx_vvrcar', $my_vars);
		
	    // Instantiate the tx_xajax_response object
		$objResponse = new tx_xajax_response();
		$objResponse->addAssign("count-tx_vvrcar_gatve","innerHTML", $this->getTableRecCount('tx_vvrcar_gatve'));
		$objResponse->addAssign("sync-tx_vvrcar_gatve","value", (($gCount)?'Liko '.($gCount):'Synchronize'));
		if($gCount) {
			$objResponse->addScriptCall('xajax_tx_vvrcar_sync_tx_vvrcar_gatve', 'hi');
		} else {
			$objResponse->addScriptCall('xajax_tx_vvrcar_sync_tx_vvrcar_micro_gatve', 'hi');			
		}			


        //return the XML response generated by the tx_xajax_response object
       return $objResponse->getXML();
	}
	
	function sync_tx_vvrcar_micro_gatve($arg) {
		$my_vars = $GLOBALS["BE_USER"]->getSessionData("tx_vvrcar");
		if(isset($my_vars['m_str_array'])) {
			$rcUidMicro = unserialize($my_vars['m_str_array']);
			if(!is_array($rcUidMicro) || !count($rcUidMicro)) {
				$rcUidMicro = $this->getRCuidAndGuidArr('tx_vvrcar_mikro_rajonas');
			}
		}

		if($gCount = count($rcUidMicro)) {
			$gCount--;
			$micro_uid = key($rcUidMicro);
			$rc_micro_Uid = $rcUidMicro[$micro_uid]['rcuid'];
			$gUid = $rcUidMicro[$micro_uid]['guid'];
			$RCgUid = $rcUidMicro[$micro_uid]['rcguid'];
			
			unset($rcUidMicro[$micro_uid]);		
			$this->getDPLGMdata('vieta_gatves', $RCgUid, null, $rc_micro_Uid);
			
			if(is_array($this->DPLGMdata)) {		
				foreach($this->DPLGMdata as $row) {
					$rcuid = intval($row['id']);
					if($strUid = $this->getStreetUid($rcuid)) {
						$fieldsArray = array(
							'uid_local' => $micro_uid,
							'uid_foreign' => $strUid
						);
						$GLOBALS['TYPO3_DB']->exec_INSERTquery(
							'tx_vvrcar_mikrorajonas_gatve_mm',
							$fieldsArray
						);
					}
				};
			}
		}

		$my_vars['m_str_array'] = serialize($rcUidMicro);
		$GLOBALS["BE_USER"]->setAndSaveSessionData ('tx_vvrcar', $my_vars);
		
	    // Instantiate the tx_xajax_response object
		$objResponse = new tx_xajax_response();
		$objResponse->addAssign("count-tx_vvrcar_gatve","innerHTML", $this->getTableRecCount('tx_vvrcar_gatve'));
		$objResponse->addAssign("sync-tx_vvrcar_gatve","value", (($gCount)?'Liko '.($gCount):'Synchronize'));
		if($gCount) {
			$objResponse->addScriptCall('xajax_tx_vvrcar_sync_tx_vvrcar_micro_gatve', 'hi');			
		}			

        //return the XML response generated by the tx_xajax_response object
       return $objResponse->getXML();	
	}

	function getStreetUid($rcuid) {
		$uid = 0;
		$table = 'tx_vvrcar_gatve';
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
		    'uid',
			$table,
			'rcuid='.intval($rcuid).t3lib_BEfunc::deleteClause($table).
			t3lib_BEfunc::BEenableFields($table)
		);
		if(count($rows)) {
			foreach($rows as $row) {
				$uid = $row['uid'];					
			}
		}
		return $uid;		
	}

	/**
	 * Returns an <input> button with the $onClick action and $label
	 *
	 * @param	string		The value of the onclick attribute of the input tag (submit type)
	 * @param	string		The label for the button (which will be htmlspecialchar'ed)
	 * @return	string		A <input> tag of the type "submit"
	 */
	function t3Button($onClick,$label, $id='')	{
		$button = '<input type="submit" '.(($id)?'id="'.$id.'" ':'').'onclick="'.htmlspecialchars($onClick).'; return false;" value="'.htmlspecialchars($label).'" />';
		return $button;
	}

	function getRCuidArr($table, $where = '1=1') {
		$uidList = array();
		if(t3lib_div::inList($this->tables, $table)) {
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			    'uid, rcuid',
				$table,
				$where.t3lib_BEfunc::deleteClause($table).
				t3lib_BEfunc::BEenableFields($table)
			);
			if(count($rows)) {
				foreach($rows as $row) {
					$uidList[$row['uid']] = $row['rcuid'];					
				}
			}
		}		
		return $uidList;
	}

	function getRCuidAndGuidArr($table, $where = '1=1') {
		$uidList = array();
		if(t3lib_div::inList($this->tables, $table)) {
			$uidList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			    'uid, rcuid,guid, rcguid',
				$table,
				$where.t3lib_BEfunc::deleteClause($table).
				t3lib_BEfunc::BEenableFields($table),
				'',
				'',
				'',
				'uid'
				
			);
		}		
		return $uidList;
	}

	
	function process_datamap(&$data) {
		require_once (PATH_t3lib."class.t3lib_tcemain.php");
		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		$tce->stripslashes_values = 0;
   		$tce->start($data,array());
		$tce->process_datamap();
	}
	
	function recExists($table, $field, $value) {
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
		    'COUNT(*) as count',
			$table,
			$field.' = '.$value.
			t3lib_BEfunc::deleteClause($table).
			t3lib_BEfunc::BEenableFields($table)
		);
		return $row[0]['count'];
	} 
	
	function getDPLGMdata($act, $p=null, $type=null, $micro=null) {

		$data = array( 
			'act' => $act,
			'parent' => $p,
			'type' => $type,
			'micro' => $micro
		);
		$url = 'http://domo.plius.lt/online_import/?'.t3lib_div::implodeArrayForUrl('', $data);
		$return = t3lib_div::getURL($url);
		unset($this->DPLGMdata); 
		eval('$this->DPLGMdata = '.$return.';');
		
	}
	
	function getTableRecCountTable() {
		$tblArr = t3lib_div::trimExplode(',', $this->tables);
		$arrTable = array();
		foreach($tblArr as $table) {
			$onClick = (t3lib_div::inList('tx_vvrcar_gyvenviete,tx_vvrcar_mikro_rajonas,tx_vvrcar_gatve', $table))?'xajax_tx_vvrcar_sync_'.$table.'("hi")':'jumpToUrl(\''.$this->MCONF['_'].'&SYNC['.$table.']=1\')';
			$arrTable[] = array($GLOBALS['LANG']->getLL($table),'<span id="count-'.$table.'">'.$this->getTableRecCount($table).'</span>',$this->t3Button($onClick,'Sinchronize','sync-'.$table));
		}	
		return $this->getTableData($arrTable);	
	}
	
	function getTableRecCount($table) {
		$count = 0;
		if(t3lib_div::inList($this->tables, $table)) {
			$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			    'COUNT(*) as count',
				$table,
				'1=1'.t3lib_BEfunc::deleteClause($table).
				t3lib_BEfunc::BEenableFields($table)
			);
			if(count($row)) {
				$count = $row[0]['count'];
			}
		}
		return $count;			
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
		
		foreach($arrData as $row) {
			for($i=0;$i<count($row);$i++) {
				$table[$tr][$i] = $row[$i];
			}
			$tr++;
		}
		return $this->doc->table($table, $tableLayout[$layout]);
	}	
	function unzipFile($filename) {
		$zip = zip_open($filename);
		$buf = '';
		if ($zip) {
		    while ($zip_entry = zip_read($zip)) {
		
		        if (zip_entry_open($zip, $zip_entry, "r")) {
		            $buf .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
		            zip_entry_close($zip_entry);
		        }
		    }
		    zip_close($zip);

		}
		return $buf;	
	}
	
	function isZipped($file)    {
        // Handle ZIP Extensions
        if (eregi('\.zip$', $file)) {
            return true;
        }
        
        return false;
    }
    
    function isXML($file)    {
        // Handle ZIP Extensions
        if (eregi('\.xml$', $file)) {
            return true;
        }
        
        return false;
    }
    
	function debugContent() {
		if ($this->debugOn && count($this->debugData)) {
            $this->content.=$this->doc->spacer(5);
            ksort($this->debugData);
            $this->debugCont .= implode(' ', $this->debugData);
	        $this->content.=$this->doc->section('Debug info:',$this->debugCont.$this->doc->divider(10),0,1,1);
		}
	}
	
	function debug($str, $data) {
		if ($this->debugOn) {
			$ms = t3lib_div::milliseconds();
			$this->debugData[$ms] .= $this->innerSection(
									$str.' ('.($ms-$GLOBALS['PARSETIME_START']).'ms)',
										t3lib_div::view_array($data),
										1
									); 
		}
	}

	function innerSection($label, $sContent='', $icon=0, $divider=0) {

		$content = $this->sectionHeader($this->doc->icons($icon).$label,1);
		$content .= $sContent;
		if($divider) {
			$content .= $this->divider($divider); 
		}
		;
		return '<div>'.$content.'</div>';
	}

	/**
	 * Inserts a divider image
	 * Ends a section (if open) before inserting the image
	 *
	 * @param	integer		The margin-top/-bottom of the <hr> ruler.
	 * @return	string		HTML content
	 */
	function divider($dist)	{
		$dist = intval($dist);
		$str='

	<hr style="margin-top: '.$dist.'px; margin-bottom: '.$dist.'px;" />
';
		return $str;
	}
	
	/**
	 * Make a section header.
	 * Begins a section if not already open.
	 *
	 * @param	string		The label between the <h3> or <h4> tags. (Allows HTML)
	 * @param	boolean		If set, <h3> is used, otherwise <h4>
	 * @param	string		Additional attributes to h-tag, eg. ' class=""'
	 * @return	string		HTML content
	 */
	function sectionHeader($label,$sH=FALSE,$addAttrib='')	{
		$tag = ($sH?'h3':'h4');
		$str='

	<'.$tag.$addAttrib.'>'.$label.'</'.$tag.'>
';
		return $str;
	}
	
####### Function 2 ##########

	/**
	 * Rendering the upload file form fields
	 *
	 * @return	string		HTML content
	 */
	function uploadForm()	{
		global $LANG;

		$content =  $this->doc->spacer(10);

		//
		// Output upload form
		//
		
		$code .='' .
		'<div id="c-upload">
			<label for="upload_1">'.$LANG->getLL('upload_form_upload_lable').'</label><br /><input type="file" name="upload_1"'.$this->doc->formWidth(35).' size="50" />' .
			'<input type="hidden" name="file" value="1" /><br />';


		if ($upload_max_filesize = $this->getMaxUploadSize()) {
			$code .= '
				<input type="hidden" name="MAX_FILE_SIZE" value="'.$upload_max_filesize.'" />
				<p class="typo3-dimmed">'.sprintf($LANG->getLL('tx_dam_file_upload.maxSizeHint',1), t3lib_div::formatSize($upload_max_filesize)).'</p>
			';
		}


		$code .= '
			</div>
		';
		
		$code .= '<br /><br />'.$GLOBALS['LANG']->getLL('function2_input1_label').'&nbsp;'.'<input type="text" name="import[ruid]" size="8" value="" /><br /><br />';
		$code .= $GLOBALS['LANG']->getLL('function2_input1_labe2').'&nbsp;'.'<input type="text" name="import[guid]" size="8" value="" />';		

		$code .=  $this->doc->spacer(10);
			// Submit button:
		$code .= '
			<div id="c-submit" style="text-align: right;">
				<input type="button" value="'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:file_upload.php.submit',1).'" onclick=" this.form.submit();" />
			</div>
		';

		$content .= $code;
		$content .= $this->doc->divider(15);

		return $content;
	}

	/**
	 * Return max upload file size
	 *
	 * @return integer Maximum file size for uploads in bytes
	 */
	function getMaxUploadSize() {
		$upload_max_filesize = ini_get('upload_max_filesize');
		$match = array();
		if (preg_match('#(M|MB)$#i', $upload_max_filesize, $match)) {
			$upload_max_filesize = intval($upload_max_filesize)*1048576;
		} elseif (preg_match('#(k|kB)$#i', $upload_max_filesize, $match)) {
			$upload_max_filesize = intval($upload_max_filesize)*1024;
		}

		$maxFileSize = intval($GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'])*1024;

		if (min($maxFileSize, $upload_max_filesize)==0) {
			$upload_max_filesize = max($maxFileSize, $upload_max_filesize);
		} else {
			$upload_max_filesize = min($maxFileSize, $upload_max_filesize);
		}
		return $upload_max_filesize;
	}
	
	/**
	 * Processing the upload and display information
	 *
	 * @return	string		HTML content
	 */
	function uploadProcessing()	{

		$content = '';
		$arrFile = array();
		if ($intErr = $_FILES['upload_1']['error']) {
			
			$arrFile = array(
				array('File upload error:' , $this->getFileUploadErrMess($intErr)) 
			);
			$content  = $this->getTableData($arrFile);
		} else {
			$theFile = $_FILES['upload_1']['tmp_name'];				// filename of the uploaded file
			$theFileSize = $_FILES['upload_1']['size'];				// filesize of the uploaded file
			$theName = stripslashes($_FILES['upload_1']['name']);	// The original filename
			if (is_uploaded_file($theFile) && $theName)	{	// Check the file
				$arrFile = array(
					array('File' , $this->doc->getFileheader($theName,$theName,'gfx/fileicons/xls.gif')),
					array('Size' , htmlspecialchars(t3lib_div::formatSize($theFileSize))),
					array('Type' , $this->doc->dfw($_FILES['upload_1']['type'])),
					array('Error' , $_FILES['upload_1']['error']),
					array('Records' , $this->importMicroCSV($theFile)),
				);
				$content  = $this->getTableData($arrFile);
				$content  .= $this->doc->spacer(10);
				$content  .= $this->doc->t3button('return true;', 'OK');
				$content  .= $this->doc->divider(10);
			}
		}
		return $content;
	}
	
	function importMicroCSV($filePath) {
		$import = t3lib_div::_GP("import");
		$ruid = intval($import['ruid']);
		$guid = intval($import['guid']);
		
		$rec = t3lib_BEfunc::getRecord('tx_vvrcar_rajonas', $ruid, 'rcuid');
		if(is_array($rec)) {
			$rajonasRCUID = $rec['rcuid'];
		}

		$rec = t3lib_BEfunc::getRecord('tx_vvrcar_gyvenviete', $ruid, 'rcuid');
		if(is_array($rec)) {
			$gyvenvieteRCUID = $rec['rcuid'];
		}
		
		$data = file($filePath);
		if(file_exists($filePath)) unlink($filePath);
		reset($data);
		$intCount = 0;
		foreach($data as $row) {
			$fields = array();
			$intCount++;
			if($intCount > 1) {
				$cels = t3lib_div::trimExplode(';', $row);
				$fields = array(
					'pid' => $this->pid,
					'title' => str_replace('"', '', $cels[1]),
					'ruid' => $ruid,
					'guid' => $guid,
					'rcruid' => $rajonasRCUID,
					'rcguid' => $gyvenvieteRCUID,
				);
				$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_vvrcar_mikro_rajonas2', $fields);
			}
		}
		return ($intCount-1);
	}
	
	function getFileUploadErrMess($intErr) {
		$message = '';
		switch (intval($intErr)) {
		   case UPLOAD_ERR_OK:
		       break;
		   case UPLOAD_ERR_INI_SIZE:
		       $message = "The uploaded file exceeds the upload_max_filesize directive (".ini_get("upload_max_filesize").") in php.ini.";
		       break;
		   case UPLOAD_ERR_FORM_SIZE:
		       $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form (".$this->getMaxUploadSize().").";
		       break;
		   case UPLOAD_ERR_PARTIAL:
		       $message = "The uploaded file was only partially uploaded.";
		       break;
		   case UPLOAD_ERR_NO_FILE:
		       $message = "No file was uploaded.";
		       break;
		   case UPLOAD_ERR_NO_TMP_DIR:
		       $message = "Missing a temporary folder.";
		       break;
		   case UPLOAD_ERR_CANT_WRITE:
		       $message = "Failed to write file to disk";
		       break;
		   default:
		       $message = "Unknown File Error";
		}
		return $message;
	}
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_rcar/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_rcar/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_vvrcar_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>