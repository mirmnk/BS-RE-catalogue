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

require_once('pi1/class.tx_vvrecatalog_utils.php');

class tx_vvrecatalog_tcemainprocdm {
	var $tblList = 'tx_vvrecatalog_land,tx_vvrecatalog_flat,tx_vvrecatalog_house,tx_vvrecatalog_homestead,tx_vvrecatalog_accommodation';

    function processDatamap_postProcessFieldArray ($status, $table, $id, &$fieldArray, &$pObj) {
    	global $TCA;
    	
        
        if ($status == 'new'  && t3lib_div::inList($this->tblList, $table)) {
	        $fieldArray['gid'] = tx_vvrecatalog_tcemainprocdm::nextSequence();
	    } 
	    	// if it's an update
	    if ($status == 'update'  && t3lib_div::inList($this->tblList, $table)){
			 // getting full record
	    	$row = t3lib_BEfunc::getRecordWSOL($table, $id);
	    	 // if it is an original rec in default language
	    	if(isset($row[$TCA[$table]['ctrl']['languageField']]) && $row[$TCA[$table]['ctrl']['languageField']] == 0) {
				   // getting translations for the record
				 $recs = t3lib_BEfunc::getRecordsByField(
								$table,
								$TCA[$table]['ctrl']['transOrigPointerField'],
								$id
							);
				if (is_array($recs) && count($recs)) {
					$fArray = array();
					foreach($fieldArray as $fieldName => $fieldValue) {
						if($TCA[$table]['columns'][$fieldName]['l10n_display'] == 'defaultAsReadonly' &&
							(!isset($TCA[$table]['columns'][$fieldName]['l10n_mode']) || 
							 t3lib_div::inList('exclude,noCopy', $TCA[$table]['columns'][$fieldName]['l10n_mode'])	) ||
							 $fieldName == $TCA[$table]['ctrl']['tstamp']
							) {
							$fArray[$fieldName]=$fieldValue;	
						}
					}
					foreach($recs as $rec) {
						$pObj->updateDB($table,$rec['uid'],$fArray);
						$pObj->placeholderShadowing($table,$rec['uid']);
					}
				}			
	    	}
	    }    
    }
	
	function nextSequence()	{
		$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_vvrecatalog_sequence', array('uid' => NULL));
		return mysql_insert_id();
	}
	
	function processDatamap_afterDatabaseOperations($status, $table, $id, &$fieldArray, &$pObj) {
	    // domoplius.lt real time syncronization
	    if(t3lib_div::inList($this->tblList, $table)) {
		    $id = ($status == 'new')?$pObj->substNEWwithIDs[$id]:$id;
	    	$row = t3lib_BEfunc::getRecordWSOL($table, $id);
	    	if(!$row['sys_language_uid']) {
		    	$this->updateDomoPlius($status, $table, $id, $fieldArray, $pObj);
	    	}
	    }
		
	}
	
	function processCmdmap_postProcess($command, $table, $id, $value, &$pObj) {

		if(($command === 'delete' || $command === 'undelete') && t3lib_div::inList($this->tblList, $table)) {
			 $recs = t3lib_BEfunc::getRecordsByField(
							$table,
							$GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField'],
							$id
						);
			if (is_array($recs) && count($recs)) {
				foreach($recs as $rec) {
					if ($command === 'delete') {
						$pObj->deleteAction($table, $rec['uid']);
					} elseif($command === 'undelete') {
						$pObj->undeleteRecord($table, $rec['uid']);
					}
				}
			}			
		}
		if($command === 'delete' && t3lib_div::inList($this->tblList, $table)) {
			$this->deleteDomoPlius($table, $id, $pObj);
		}
	}
	
	function showPriceInCurrency(&$PA, &$feObj) {
		#debug($PA);
		$rate = tx_vvrecatalog_utils::getCurLangCurrencyRate($PA['row']['sys_language_uid']);
		$content = '<input type="text" class="formField1" value="'.number_format(($PA['row']['price']/$rate), 2, '.', '').'" disabled="disabled" />';
		$content .= '<div class="typo3-TCEforms-originalLanguageValue">&nbsp;'.$PA['row']['price'].' LTL</div>';
		return $content;
	} 
	
 	function ntObjectLabel(&$row, &$PObj) {
		$rate = tx_vvrecatalog_utils::getCurLangCurrencyRate($row['row']['sys_language_uid']);
 		$table = $row['table'];
 		$row['title'] = $row['row']['gid'];
		$row['title'] .= ' - '.t3lib_BEfunc::getProcessedValue($table,'action',$row['row']['action'] ); 		
		$row['title'] .= ' - '.number_format(($row['row']['price']/$rate), 2, '.', '');
		$gTitle = t3lib_BEfunc::getRecord('tx_vvrcar_gatve',$row['row']['gatve'],'title');
		$row['title'] .= (isset($gTitle['title']))?' - '.$gTitle['title']:'';
 	}

	function updateDomoPlius($status, $table, $id, &$fieldArray, &$pObj) {
            return ;
		if ((($fieldCount = count($fieldArray)) > 1 ) || ($fieldCount == 1 && key($fieldArray) == 'tstamp')) {
			$this->rec = t3lib_BEfunc::getRecord($table, $id);
			$ad = array(
			  'type' => ($type = $this->getDomoPliusType($table)),
			  'domo_id' => intval($this->rec['domoplius_id']),
			  'data' => $this->getDomoPliusData($type)
			);
#			debug($ad);
			$url = 'http://domo.plius.lt/online_import/saveadd/';
			$out = $this->proccessDataPost($ad, $url);

			$this->registerDomoPliusResult($out,$table, $id, $pObj);
		}		
#		debug(array($status, $table, $id, $fieldArray));
	} 
	
	function deleteDomoPlius($table, $id, &$pObj) {
            return;
		$this->rec = t3lib_BEfunc::getRecord($table, $id, '*', '', false);
		if($this->rec['domoplius_id']) {			
			$url = 'http://domo.plius.lt/online_import/deleteadd';
			$ad = array(
			  'type' => ($type = $this->getDomoPliusType($table)),
			  'domo_id' => intval($this->rec['domoplius_id']),
			  'pardavejas' => $this->getFieldValue('pardavejas')
			);
			$out = $this->proccessDataPost($ad, $url);
			if($out) {
				$log = 'Deleted by '.$GLOBALS['BE_USER']->user['username'].' on '.date('Y-m-d H:i').'<br />';
				$pObj->updateDB($table,$id,array('domoplius_status' => $log.'<br />'.$this->rec['domoplius_status']));
			}
		}		
	}

	function registerDomoPliusResult(&$responce,  $table, $id, &$pObj) {
            return;
		if($responce['action']['id'] == 1 && $responce['action']['text'] == 'INSERT') {
			$log = 'Inserted by '.$GLOBALS['BE_USER']->user['username'].' on '.date('Y-m-d H:i').'<br />';
			$pObj->updateDB($table,$id,array('domoplius_id' => $responce['action']['inserted_id'], 'domoplius_status' => $log));
		} elseif ($responce['action']['id'] == 2 && $responce['action']['text'] == 'UPDATE') {
			$log = 'Updated by '.$GLOBALS['BE_USER']->user['username'].' on '.date('Y-m-d H:i').'<br />';
			$pObj->updateDB($table,$id,array('domoplius_status' => $log.'<br />'.$this->rec['domoplius_status']));
		} elseif ($responce['action']['id'] == 0 && $responce['action']['text'] == 'NONE') {
			$log = 'Update attempt by '.$GLOBALS['BE_USER']->user['username'].' on '.date('Y-m-d H:i').(($responce['number_errors'] && $responce['number_errors'] == 1)?' - 1 error':' - '.$responce['number_errors']. ' errors').'<br />';
			for($i=0;$i < $responce['number_errors'];$i++) {
				$log .= '&nbsp;&nbsp;&nbsp;'.($i+1).'. '.$responce['errors'][$i].'<br />';
			}
			$pObj->updateDB($table,$id,array('domoplius_status' => $log.'<br />'.$this->rec['domoplius_status']));
		}
	}
	
	function proccessDataPost( $sendData, $service_address ) {
            return;
		$data = t3lib_div::implodeArrayForUrl('', $sendData, '', 0, 1 );//Siun�iam� duomen� konvertavimas
	$context_options = array (
			'http' => array (
				'method' => 'POST',
				'header' => "Content-type: application/x-www-form-urlencoded\r\n".
				"Content-Length: " . strlen( $data ) . "\r\n",
				'content' => $data
			)
		);
		$context = stream_context_create( $context_options );
#		debug(array($context_options, $service_address, $context));
		$fp = fopen( $service_address, 'rb', false, $context );


		$res = '';
		while( !feof($fp) )	{
			$res .= fread( $fp, 4096 );
		}
		fclose( $fp );
#print_r($res);
		$result;

		eval('$result='.$res.';');
		return $result;
	}
	
	function getDomoPliusType($table) {		
            
		switch($table) {
			case 'tx_vvrecatalog_flat' :
				$retval = 0;
			break;

			case 'tx_vvrecatalog_house' :
				$retval = 1;
			break;

			case 'tx_vvrecatalog_land' :
				$retval = 7;
			break;
			
			case 'tx_vvrecatalog_accommodation' :
				$retval = 4;
			break;
			
			case 'tx_vvrecatalog_homestead' :
				$retval = 6;
			break;
		}
		
		return $retval;
	}
	
	function getDomoPliusData($type) {
            return;
		$fields = $this->getDomoPliusFields($type);
		$arrFields = t3lib_div::trimExplode(',', $fields);
		$data = array();
		$this->uploadPath = 'uploads/tx_vvrecatalog/';
		foreach($arrFields as $field) {
			$arrField = array(
				'field' => $field,
				'name' => $field,
				'value' => $this->getFieldValue($field, $type)
			);
			if(!empty($arrField['value'])) {
				if($arrField['value'] == -1 ) {
					if(intval($this->rec['domoplius_id'])) {
						$arrField['value'] = 0;
						$data[] = $arrField;
					}
				}else{
					$data[] = $arrField;
				}
				
			} 
		}
		
		return $data;
	}
	
	function getDomoPliusFields($type) {
		$fieldList = 'price_type, selling_price,rent_price,pardavejas, agentura, vieta_gatves_id, vieta_micro_districts_id, vieta_apskritys_id, vieta_miestai_rajonai_id, vieta_gyvenvietes_id, price_currencies_id,comments';
		switch($type) {
			case 0:
				$fieldList .= ',has_signalling,has_cable_tv,has_parking_place,has_internet,has_sandeliukas,has_phone,has_fire_place,has_furniture,has_balkonas,has_2_floor,has_armoured_door,has_loft,has_wardrobe,has_high_ceiling,has_code_lock,building_outer_walls_id,basement_size,flat_windows_id,building_heating_id,flat_floor, building_floors,flat_rooms, flat_size,build_date,photo_1,photo_2,photo_3,photo_4,photo_5,flat_situation_id';
			break;
			
			case 1:
				$fieldList .= ',flat_windows_id,site_size,has_tamsus_kambarys,has_balkonas,has_balcony,has_asphalt_approach,has_signalling,has_bathhouse,has_cable_tv,has_hearth,has_pool,has_phone,has_furniture,water_supply_id,building_outer_walls_id,rooms,garage_size,site_purposes_id,site_measures_id,building_heating_id,sewerage_id,building_situation_id,building_size, building_floors,build_date,photo_inside_1,photo_inside_2,photo_inside_3,photo_inside_4,photo_inside_5,photo_inside_6';
			break;
			
			case 7:
				$fieldList .= ',site_size,site_purposes_id,site_measures_id,gas_id,build_date,photo_1,photo_2,photo_3,photo_4,photo_5,site_measuring_types_id,water_supply_id,sewerage_id,has_electricity,has_asphalt_approach';
			break;
			
			case 4:
				$fieldList .= ',selling_price_type,has_shop_windows,has_telephone_line,has_balcony,has_internet,has_signalling,has_elevator,gas_id,water_supply_id,building_outer_walls_id,rooms,commercial_state_id,commercial_room_purpose_id,room_size,floor,building_heating_id,build_date,photo_1,photo_2,photo_3,photo_4,photo_5';
			break;
			
			case 6:
				$fieldList .= ',building_outer_walls_id,site_size,has_tamsus_kambarys,has_balkonas,has_balcony,has_electricity,has_asphalt_approach,has_signalling,has_bathhouse,has_cable_tv,has_hearth,has_pool,has_phone,has_furniture,flat_windows_id,rooms,garage_size,building_size,building_floors,site_purposes_id,site_measures_id,building_heating_id,sewerage_id,water_supply_id,building_situation_id,build_date,photo_plan_1,photo_plan_2,photo_plan_3,photo_plan_4,photo_plan_5';
			break;
			
		}
		
		return $fieldList;
	}
	
	function getFieldValue($field, $type=0) {
		$content = '';
		switch($field) {
			case 'price_type' :
				$content = ($this->rec['action'] > 0)?$this->rec['action']:'';
			break;

			case 'selling_price_type' :
				$content = ($this->rec['action'] > 0)?$this->rec['action']:'';
			break;

			case 'rent_price_type' :
				$content = ($this->rec['action'] == 2)?$this->rec['action']:'';
			break;
			
			case 'building_floors' :
			case 'floors' :
				$content = ($this->rec['floorcount'])?$this->rec['floorcount']:'';
			break;

			case 'building_size' :
				$content = ($this->rec['area'])?$this->rec['area']:'';
			break;

			case 'comments' :
				$content = ($this->rec['descr'])?str_replace('&nbsp;', ' ', $this->rec['descr']):'';
			break;
						
			case 'site_size' :
				$content = ($this->rec['land_area'])?$this->rec['land_area']:'';
			break;
			
			case 'water_supply_id' :
				// vandentiekis -> miesto vandetiekis
				if($type == 7 || $type == 6 || $type == 4 || $type == 1) {
					$content = ($this->rec['com_sys'] & 4)?56:-1;
				}
			break;

			case 'sewerage_id' :
				// kanalizacija -> miesto kanalizacija
				if($type == 7) {
					$content = ($this->rec['com_sys'] & 8)?54:-1;
				} elseif($type == 6 || $type == 1) {
					$content = ($this->rec['com_sys'] & 2)?54:-1;
				}
			break;

			case 'site_measures_id' :
				// arai
				$content = 174;
			break;

			case 'garage_size' :
				//Garazas
				if($type == 6 || $type == 1) {
					$content = ($this->rec['facilities'] & 256)?20:-1;
				}
			break;

			case 'basement_size' :
				//Rusys
				if($type == 0) {
					$content = ($this->rec['facilities'] & 16)?12:-1;
				}
			break;
			
			case 'gas_id' :
				// dujos -> gamtines
				if($type == 7) {
					$content = ($this->rec['com_sys'] & 4)?50:-1;
				} elseif($type == 4) {
					$content = ($this->rec['com_sys'] & 2)?50:-1;					
				}
			break;
			
			
			case 'flat_floor' :
			case 'floor' :
				$content = ($this->rec['floor'])?$this->rec['floor']:'';
			break;

			case 'flat_rooms' :
			case 'rooms' :
				$content = ($this->rec['roomcount'])?$this->rec['roomcount']:'';
			break;
			
			case 'flat_size' :
			case 'room_size' :
				$content = ($this->rec['area'])?$this->rec['area']:'';
			break;

			case 'flat_windows_id' :
				// langai su stiklopaketais -> plastikiniai
				if($type == 6 || $type == 1) {				
					$content = ($this->rec['equipment'] & 32)?41:-1;
					$content = ($this->rec['equipment'] & 64)?40:$content;										
				} elseif($type == 0) {
					// for flat
					$content = ($this->rec['special'] & 64)?40:-1;
				}
			break;
			
			case 'build_date' :
				$content = ($this->rec['bdate'])?$this->rec['bdate']:'';
			break;

			case 'site_measuring_types_id' :
				//�em�s sklypas suformuotas atliekant kadastrinius matavimus
				if($type == 7) {
					$content = ($this->rec['special'] & 32)?423:-1;
				}
			break;


			case 'has_electricity' :
				//Elektra
				if($type == 7 || $type == 6 || $type == 4) {
					$content = ($this->rec['com_sys'] & 1)?1:-1;
				}
			break;

			case 'has_internet' :
				//Internetas
				if($type == 4) {
					$content = ($this->rec['com_sys'] & 8)?1:-1;
				}elseif($type == 0) {
					$content = ($this->rec['com_sys'] & 1)?1:-1;				
				}
			break;

			case 'has_shop_windows' :
				//Vitrininiai langai
				if($type == 4) {
					$content = ($this->rec['special'] & 8)?1:-1;
				}
			break;
			
			case 'has_asphalt_approach' :
				//Geras privaziavimas
				if($type == 7) {
					$content = ($this->rec['special'] & 2)?1:-1;
				} elseif($type == 6 || $type == 1) {
					$content = ($this->rec['special'] & 4)?1:-1;					
				}
			break;
			
			case 'has_furniture' :
				//Su baldais
				if($type == 6 || $type == 1) {
					$content = ($this->rec['equipment'] & 2)?1:-1;
				}elseif($type == 0) {
					$content = ($this->rec['equipment'] & 4)?1:-1;					
				}
			break;
			
			case 'has_phone' :
			case 'has_telephone_line' :
				//Telefono linija
				if($type == 6 || $type == 4 || $type == 1) {
					$content = ($this->rec['com_sys'] & 16)?1:-1;
				}elseif($type == 0) {
					$content = ($this->rec['com_sys'] & 2)?1:-1;					
				}
			break;

			case 'has_pool' :
				//Baseinas
				if($type == 6 || $type == 1) {
					$content = ($this->rec['facilities'] & 16)?1:-1;
				}
			break;

			case 'has_elevator' :
				//Liftas
				if($type == 4) {
					$content = ($this->rec['special'] & 4)?1:-1;
				}
			break;
			
			case 'has_hearth' :
				//Zidinys
				if($type == 6 || $type == 1) {
					$content = ($this->rec['equipment'] & 16)?1:-1;
				}
			break;
			
			case 'has_cable_tv' :
				//Kabeline
				if($type == 6 || $type == 1) {
					$content = ($this->rec['com_sys'] & 32)?1:-1;
				}elseif($type == 0) {
					$content = ($this->rec['com_sys'] & 4)?1:-1;					
				}
			break;
			
			case 'has_bathhouse' :
				//Pirtis
				if($type == 6 || $type == 1) {
					$content = ($this->rec['facilities'] & 2)?1:-1;
				}
			break;

			case 'has_code_lock' :
				//Kodine laiptines sistema
				if($type == 0) {
					$content = ($this->rec['security'] & 16)?1:-1;
				}
			break;
			
			case 'has_high_ceiling' :
				//Aukstos lubos
				if($type == 0) {
					$content = ($this->rec['special'] & 4)?1:-1;
				}
			break;
			
			case 'has_parking_place' :
				//Vieta automobiliui
				if($type == 0) {
					$content = ($this->rec['facilities'] & 128)?1:-1;
				}
			break;
			
			case 'has_sandeliukas' :
				//Sandeliukas
				if($type == 0) {
					$content = ($this->rec['facilities'] & 2)?1:-1;
				}
			break;
			
			case 'has_fire_place' :
				//Zidinys
				if($type == 0) {
					$content = ($this->rec['equipment'] & 128)?1:-1;
				}
			break;
			
			case 'has_wardrobe' :
				//Sienine spinta
				if($type == 0) {
					$content = ($this->rec['facilities'] & 1)?1:-1;
				}
			break;
			
			case 'has_2_floor' :
				//Butas per 2 aukstus
				if($type == 0) {
					$content = ($this->rec['special'] & 16)?1:-1;
				}
			break;
			
			case 'has_loft' :
				//Butas palepeje
				if($type == 0) {
					$content = ($this->rec['special'] & 8)?1:-1;
				}
			break;
			
			case 'has_armoured_door' :
				//Butas palepeje
				if($type == 0) {
					$content = ($this->rec['security'] & 4)?1:-1;
				}
			break;
			
			case 'has_signalling' :
				//Signalizacija
				if($type == 6 || $type == 4 || $type == 1) {
					$content = ($this->rec['security'] & 4)?1:-1;
				}elseif($type == 0) {
					$content = ($this->rec['security'] & 2)?1:-1;					
				}
			break;
			
			case 'has_balkonas' :
				if($type == 6 || $type == 1) {
					$content = ($this->rec['facilities'] & 1)?1:-1;
				}elseif($type == 0) {
					$content = ($this->rec['facilities'] & 4)?1:-1;					
				}
			break;

			case 'has_balcony' :
				if($type == 6 || $type == 1) {
					$content = ($this->rec['facilities'] & 8)?1:-1;
				}elseif($type == 4) {
					$content = ($this->rec['facilities'] & 1)?1:-1;
					$content = ($this->rec['facilities'] & 256)?1:$content;
				}
				
			break;
				
			case 'has_tamsus_kambarys' :
				if($type == 6 || $type == 1) {
					$content = ($this->rec['facilities'] & 4)?1:-1;
				}
			break;
				
			case 'flat_situation_id' :
				
				switch($this->rec['state']) {
					//naujas
					case 1:
						// kita
						$content = 10;
						switch($this->rec['installation']) {
							//daline apdaila
							case 1:
								// daline apdaila
								$content = 5;
							break;
		                    // nebaigtas statyti 
							case 2:
								// statomas
								$content = 3;
							break;
							// neirengtas
							case 3:
								// neirengtas
								$content = 4;
							break;
							// Pilnai irengtas
							case 5:
								// Irengtas
								$content = 9;
							break;
							// Nera duomenu
							case 6:
								// Kita
								$content = 10;
							break;
						}
						
					break;
                    // renovuotas 
					case 2:
						// suremontuotas
						$content = 6;
					break;
					// renovuotinas
					case 3:
						// reikia remontuoti
						$content = 8;
					break;
					// tvarkingas
					case 4:
						// reikia kosmetinio remonto
						$content = 7;
						$content = 6;
					break;
				}
			break;

			case 'building_situation_id' :
				
				switch($this->rec['state']) {
					//naujas
					case 1:
						// kita
						$content = 319;
						switch($this->rec['installation']) {
							//daline apdaila
							case 1:
								// daline apdaila
								$content = 314;
							break;
		                    // nebaigtas statyti 
							case 2:
								// statomas
								$content = 312;
							break;
							// neirengtas
							case 3:
								// kita
								$content = 319;
							break;
							// Pilnai irengtas
							case 5:
								// Suremontuotas
								$content = 315;
							break;
							// Nera duomenu
							case 6:
								// Kita
								$content = 319;
							break;
							
						}
						
					break;
                    // renovuotas 
					case 2:
						// suremontuotas
						$content = 315;
					break;
					// renovuotinas
					case 3:
						// reikia remontuoti
						$content = 317;
					break;
					// tvarkingas
					case 4:
						// reikia kosmetinio remonto
						$content = 316;
						// suremontuotas
						$content = 315;
					break;
				}
			break;
			
			case 'commercial_state_id' :
				
				switch($this->rec['state']) {
					//naujas
					case 1:
						// kita
						$content = 233;
						switch($this->rec['installation']) {
							//daline apdaila
							case 1:
								// daline apdaila
								$content = 228;
							break;
		                    // nebaigtas statyti 
							case 2:
								// statomas
								$content = 226;
							break;
							// neirengtas
							case 3:
								// kita
								$content = 233;
							break;
							// Pilnai irengtas
							case 5:
								// Irengtas
								$content = 232;
							break;
							// Nera duomenu
							case 6:
								// Kita
								$content = 233;
							break;
							
						}
						
					break;
                    // renovuotas 
					case 2:
						// suremontuotas
						$content = 229;
					break;
					// renovuotinas
					case 3:
						// reikia remontuoti
						$content = 231;
					break;
					// tvarkingas
					case 4:
						// reikia kosmetinio remonto
						$content = 230;
						// suremontuotas
						$content = 229;
					break;
				}
			break;
			
			case 'building_heating_id':
				$htype = t3lib_BEfunc::getRecord('tx_vvrecatalog_heating_type', $this->rec['heating_type'], 'domoplius_id');
				$content = ($htype['domoplius_id'])?$htype['domoplius_id']:-1;				
			break;

			case 'commercial_room_purpose_id':
				$actype = t3lib_BEfunc::getRecord('tx_vvrecatalog_ac_type', $this->rec['ac_type'], 'domoplius_id');
				$content = ($actype['domoplius_id'])?$actype['domoplius_id']:-1;				
			break;

			case 'site_purposes_id':
				$ltype = t3lib_BEfunc::getRecord('tx_vvrecatalog_land_type', $this->rec['land_type'], 'domoplius_id');
				$content = ($ltype['domoplius_id'])?$ltype['domoplius_id']:-1;				
			break;

			case 'building_outer_walls_id':
				$ltype = t3lib_BEfunc::getRecord('tx_vvrecatalog_building_type', $this->rec['building_type'], 'domoplius_id');
				$content = ($ltype['domoplius_id'])?$ltype['domoplius_id']:-1;				
			break;
			
			case 'price' :
				$content = ($this->rec['price'])?$this->rec['price']:'';
			break;
			
			case 'selling_price' :
				$content = ($this->rec['action'] == 1)?$this->rec['price']:'';
			break;

			case 'rent_price' :
				$content = ($this->rec['action'] == 2)?$this->rec['price']:'';
			break;
			
			
			case 'price_currencies_id' :
				$content = 28;
			break;
			
			case 'photo_1':
			case 'photo_plan_1':
			case 'photo_inside_1':
			case 'photo_building_1':
				$images = t3lib_div::trimExplode(',', $this->rec['images'], 1);
				$content = (isset($images[0]))?$this->getFixedImageURL($this->uploadPath.$images[0]):'';
			break;

			case 'photo_2':
			case 'photo_plan_2':
			case 'photo_inside_2':
			case 'photo_building_2':
				$images = t3lib_div::trimExplode(',', $this->rec['images'], 1);
				$content = (isset($images[1]))?$this->getFixedImageURL($this->uploadPath.$images[1]):'';
			break;
			
			case 'photo_3':
			case 'photo_plan_3':
			case 'photo_inside_3':
			case 'photo_building_3':
				$images = t3lib_div::trimExplode(',', $this->rec['images'], 1);
				$content = (isset($images[2]))?$this->getFixedImageURL($this->uploadPath.$images[2]):'';
			break;
			
			case 'photo_4':
			case 'photo_plan_4':
			case 'photo_inside_4':
			case 'photo_building_4':
				$images = t3lib_div::trimExplode(',', $this->rec['images'], 1);
				$content = (isset($images[3]))?$this->getFixedImageURL($this->uploadPath.$images[3]):'';
			break;
			
			case 'photo_5':
			case 'photo_plan_5':
			case 'photo_inside_5':
			case 'photo_building_5':
				$images = t3lib_div::trimExplode(',', $this->rec['images'], 1);
				$content = (isset($images[4]))?$this->getFixedImageURL($this->uploadPath.$images[4]):'';
			break;

			case 'photo_6':
			case 'photo_plan_6':
			case 'photo_inside_6':
			case 'photo_building_6':
				$images = t3lib_div::trimExplode(',', $this->rec['images'], 1);
				$content = (isset($images[5]))?$this->getFixedImageURL($this->uploadPath.$images[5]):'';
			break;
			
			case 'pardavejas' :
				$employee = t3lib_BEfunc::getRecord('tt_address', $this->rec['employee'], 'mobile,tx_vvttaddress_dpregistered');
				if(!$employee['tx_vvttaddress_dpregistered']) {
					$content = '37052430500';					
				} else {
					preg_match('/([0-9+]{1,4}).([0-9]{3}).([0-9]{5})$/', $employee['mobile'], $matches);
					$content = '370'.$matches[2].$matches[3];
				}
			break;

			case 'agentura' :
				$content = '286559';
			break;

			case 'vieta_miestai_rajonai_id' :
				$rajonas = t3lib_BEfunc::getRecord('tx_vvrcar_rajonas', $this->rec['rajonas'], 'rcuid');
				$content = ($rajonas['rcuid'])?$rajonas['rcuid']:-1;
			break;
			
			case 'vieta_gyvenvietes_id' :
				$gyvenviete = t3lib_BEfunc::getRecord('tx_vvrcar_gyvenviete', $this->rec['gyvenviete'], 'rcuid');
				$content = ($gyvenviete['rcuid'])?$gyvenviete['rcuid']:-1;
			break;

			case 'vieta_apskritys_id' :
				$apskritis = t3lib_BEfunc::getRecord('tx_vvrcar_apskritis', $this->rec['apskritis'], 'rcuid');
				$content = ($apskritis['rcuid'])?$apskritis['rcuid']:-1;
			break;
			
			case 'vieta_micro_districts_id' :
				$mikro_rajonas = t3lib_BEfunc::getRecord('tx_vvrcar_mikro_rajonas', $this->rec['mikro_rajonas'], 'rcuid');
				$content = ($mikro_rajonas['rcuid'])?$mikro_rajonas['rcuid']:-1;
			break;

			case 'vieta_gatves_id' :
				$gatve = t3lib_BEfunc::getRecord('tx_vvrcar_gatve', $this->rec['gatve'], 'rcuid');
				$content = ($gatve['rcuid'])?$gatve['rcuid']:-1;
			break;
			
			
		}
		
		return $content;
	}
	
	function getFixedImageURL($filePath) {
		$filePath = $this->read_png_gif(t3lib_div::getFileAbsFileName($filePath));
		$relPath = t3lib_div::removePrefixPathFromList(array($filePath), t3lib_div::getIndpEnv('TYPO3_DOCUMENT_ROOT').'/');
		return t3lib_div::getIndpEnv('TYPO3_SITE_URL').$relPath[0]; 		
	}
	
	function read_png_gif($theFile)	{
		if ($GLOBALS['TYPO3_CONF_VARS']['GFX']['im'] && @is_file($theFile))	{
			$ext = strtolower(substr($theFile,-4,4));
			if ((string)$ext=='.jpg')	{
				return $theFile;
			} else {
				$newFile = PATH_site.'typo3temp/readPG_'.md5($theFile.'|'.filemtime($theFile)).'.jpg';
				exec($GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path'].'convert "'.$theFile.'" "'.$newFile.'"');
				if (@is_file($newFile))	return $newFile;
			}
		}
	}

	function showDomopliusURL(&$PA, &$fobj) {
#		return t3lib_div::view_array(array($PA, $fobj));
		$dType = $this->getDomoPliusType($PA['table']);
		$category = 'butai';
		switch($dType) {
			case 0:
			break;
			
			case 1:
				$category = 'namai';
			break;

			case 4:
				$category = 'komerciniai';
			break;
			
			case 6:
				$category = 'sodybos';
			break;
			

			case 7:
				$category = 'sklypai';
			break;
			
			
		}
		$url = 'http://domo.plius.lt/skelbimas_/skelbimas/?popup=1&kategorija='.$category.'&id='.$PA['row']['domoplius_id'];
		return '<a style="display: block; color: blue; margin: 1em 1em 1em 0; text-decoration: underline;" target="_blank" href="'.$url.'">'.$url.'</a>';
	}
} 

?>