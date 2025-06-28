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
 * Created on 2008.01.25
 *
 * @author	Miroslav Monkevic <m@vektorius.lt>
 * @package TYPO3
 * @subpackage vv_rcar
 */
 
/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/
class ux_t3lib_TCEforms extends t3lib_TCEforms {
	/**
	 * Rendering a single item for the form
	 *
	 * @param	string		Table name of record
	 * @param	string		Fieldname to render
	 * @param	array		The record
	 * @param	array		parameters array containing a lot of stuff. Value by Reference!
	 * @return	string		Returns the item as HTML code to insert
	 * @access private
	 * @see getSingleField(), getSingleField_typeFlex_draw()
	 */
	function getSingleField_SW($table,$field,$row,&$PA)	{
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['form_type'] ? $PA['fieldConf']['config']['form_type'] : $PA['fieldConf']['config']['type'];	// Using "form_type" locally in this script

		switch($PA['fieldConf']['config']['form_type'])	{
			case 'input':
				$item = $this->getSingleField_typeInput($table,$field,$row,$PA);
			break;
			case 'text':
				$item = $this->getSingleField_typeText($table,$field,$row,$PA);
			break;
			case 'check':
				$item = $this->getSingleField_typeCheck($table,$field,$row,$PA);
			break;
			case 'radio':
				$item = $this->getSingleField_typeRadio($table,$field,$row,$PA);
			break;
			case 'select':
				$config = $PA['fieldConf']['config'];
				if(is_array($config['ajax_select_update']) && count($config['ajax_select_update'])) {
					$count = 0;
					foreach($config['ajax_select_update'] as $aconf) {
						$ajaxPhpActionFile = $aconf['ajax_server'];
						$dbTable = $aconf['db_foreign_table'];
						$dbLTable = $aconf['db_local_table'];
						$dbMMTable = $aconf['db_mm_table'];
						$dbField = $aconf['db_foreign_field'];
						$dbValField = $aconf['db_valueFieldName'];
						$dbLabelField = $aconf['db_labelFieldName'];
						$updateFieldName = $aconf['update_field_name'];
						$ifCond = $aconf['ifvalue'];
						$negate = $aconf['negate'];
						$evalFieldName = $aconf['evalField']?'document.getElementsByName(\'data['.$table.']['.$row['uid'].']['.$aconf['evalField'].']\')[0]':'this';
						if(!$this->ajax_update_added) {
							$this->addJS($ajaxPhpActionFile);
							$this->ajax_update_added = true;
						}
							
						$PA['fieldChangeFunc']['ajax_select_update'.t3lib_div::shortMD5($updateFieldName.$count++)] = '; ajax_evalField(\''.$dbTable.'\', '.$evalFieldName.',\''.$dbField.'\',\''.$dbValField.'\',\''.$dbLabelField.'\',\'data['.$table.']['.$row['uid'].']['.$updateFieldName.']\',\''.$dbLTable.'\',\''.$dbMMTable.'\',\''.$ifCond.'\',\''.$negate.'\',this)';
					}
					
				}

				$item = $this->getSingleField_typeSelect($table,$field,$row,$PA);
			break;
			case 'group':
				$item = $this->getSingleField_typeGroup($table,$field,$row,$PA);
			break;
			case 'inline':
				$item = $this->inline->getSingleField_typeInline($table,$field,$row,$PA);
			break;
			case 'none':
				$item = $this->getSingleField_typeNone($table,$field,$row,$PA);
			break;
			case 'user':
				$item = $this->getSingleField_typeUser($table,$field,$row,$PA);
			break;
			case 'flex':
				$item = $this->getSingleField_typeFlex($table,$field,$row,$PA);
			break;
			default:
				$item = $this->getSingleField_typeUnknown($table,$field,$row,$PA);
			break;
		}

		return $item;
	}	
	
	function addJS($ajaxPhpActionFile) {
		// Add the JS function stuff
	
		$this->additionalJS_pre[] = t3lib_ajax::getJScode('ajax_handleEvalResponse', '', 0);
		$this->additionalJS_pre[] = "

// Trigger function that is called on event in field
function ajax_evalField(table, evalField, dbFieldName, dbValField, dbLabelField, updateFieldName, localTable, mmTable, ifvalue, negate,iffield) {
	if(ifvalue) {
		if(negate) {
			if(iffield.value == ifvalue) return true;		  
		} else {
			if(iffield.value != ifvalue) return true;
		}
	}
	var url = '".$ajaxPhpActionFile."?table=' + table;
	url = url + '&evalField=' + dbFieldName;
	url = url + '&evalFieldValue=' + evalField.value;
	url = url + '&valField=' + dbValField;
	url = url + '&labelField=' + dbLabelField;
	url = url + '&updateField=' + updateFieldName;
	url = url + '&localTable=' + localTable;			
	url = url + '&mmTable=' + mmTable;			
			
	updateField = document.getElementsByName(updateFieldName)[0];		
	updateField.disabled = true;
	ajax_doRequest(url);
}
			";
		$this->additionalJS_pre[] = " 
		function ajax_handleEvalResponse(t3ajax) {  
			  
			if (t3ajax.getElementsByTagName('data')[0]) {  
				  
				var data = t3ajax.getElementsByTagName('data')[0];  
				var responseMsg = data.getElementsByTagName('responseMsg')[0];
				responseMsg = (responseMsg.text)?responseMsg.text:responseMsg.textContent;		
				var elementName = data.getElementsByTagName('updateField')[0].firstChild.data;
		        var data2 = eval('('+responseMsg+')'); 
	            var uElement = document.getElementsByName(elementName)[0];
	            		

		        $(uElement).update(''); 
		        $(uElement).appendChild(new Option('', 0)) ;
		        for(i=0;i < data2.length;i++) {
					if (navigator.appName == 'Microsoft Internet Explorer') {
        				uElement.add(new Option(data2[i]['title'], data2[i]['uid']));
			        }else{      
		          		$(uElement).appendChild(new Option(data2[i]['title'], data2[i]['uid']));
					}						          							  
		        }
		        if(data2.length) {
		        	uElement.disabled = false;
		        }		
			}  
		} 
";
		
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_rcar/class.ux_t3lib_TCEforms.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vv_rcar/class.ux_t3lib_TCEforms.php']);
}
	 
 
?>
