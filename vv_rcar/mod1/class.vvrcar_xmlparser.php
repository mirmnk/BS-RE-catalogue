<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Miroslav Monkevic <m@vektorius.lt>
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

require_once('class.vvrcar_dbmngr.php');

/**
 * Class 'XML parser' for the 'vv_lssfdb' extension.
 *
 * @author    Miroslav Monkevic <m@vektorius.lt>
 * @package    TYPO3
 * @subpackage    vv_lssfdb
 */

/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/

class vvrcar_xmlparser {
	
	var $lfdb = null;					// DB manager object. Utility class in fact...

	var $arrAR = array();				// XML import data parsed into array
	var $errors = array();				// Error messages, if any
	
	var $arrNewDancers = array();   	// Dancers that were not found in the lssfdb at import point
	var $arrNewCouples = array();   	// Couples that did not exist in the lssfdb
	var $stepComplete = array();    	// Wizard steps completeness state. 1 - complete, 0 - not.
	var $createdDancers = array();  	// Dancers that were created during import
	var $createdCouples = array();  	// Couples that were created during import process.
	var $createdLFDBrecords = array();  // Internal LFDB records that were created during import process.
	var $couples = array();  // All couples
	var $clubs = array();  // All clubs			
	
	
	
	function parseFile(&$xmlFile) {
		/*
		if(!is_array($this->arrAR = t3lib_div::xml2tree($xmlFile))) {
			$this->addError('XML parser', $this->arrAR);
			$this->arrAR = array();
		}*/

		if(!is_object($this->lfdb)) {
			$this->lfdb = t3lib_div::makeInstance('vvrcar_dbmngr');
		}	
		$tmpArr = explode('region><region', $xmlFile);
		$intCount = count($tmpArr);
		$pre = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?><registras><region';
		$post = 'region></registras>';

		for($i=0; $i < $intCount; $i++) {
			if($i == 0) {
				$tmpArr[$i] = $tmpArr[$i].$post;				
			} elseif($i == ($intCount-1)) {
				$tmpArr[$i] = $pre.$tmpArr[$i];				
			} else {
				$tmpArr[$i] = $pre.$tmpArr[$i].$post;				
			}			
		}
		debug(t3lib_div::xml2tree($tmpArr[25]));
	}

	function vvrcar_xmlparser() {
		if(!is_object($this->lfdb)) {
			$this->lfdb = t3lib_div::makeInstance('vvrcar_dbmngr');
		}	
	}
	
	function setStepState($step, $state) {
		$this->stepComplete[$step] = $state;
	}
	
	function getStepState($step) {
		return intval($this->stepComplete[$step]);
	}
	
	function createCompetition($intComp = 0, $pid, $isChampionship = 0, $bolCalculateQPoints=1, $bolCheckQClass=1) {
		$content = '';
		$calc = t3lib_div::makeInstance('vvlssfdb_pointscalc');
		$calc->setChampionship($isChampionship);

		$arrCouplesCount = $this->compTotalCouplesCount(0);
		$arrClubsCount = $this->compTotalClubsCount(0);

		$intCouplesCount = $arrCouplesCount[0];
		$intClubsCount = $arrClubsCount[0];
		$intCouplesCount = $intCouplesCount - (count($arrClubsCount[1]['lssf']) + count($arrClubsCount[1]['noatall']));
		$listNotLssf = implode(',',$arrClubsCount[1]['lssf']);
		$listNoClub = implode(',',$arrClubsCount[1]['noatall']);

		if ($intComp < $this->getCompetitionResultCount() &&
		   !(is_array($this->createdLFDBrecords[$intComp]) && count($this->createdLFDBrecords[$intComp])) 
		){
			$arrCompInf = $this->getCompetitionResultInfo($intComp);
			$cUid = $this->lfdb->createCompetition($arrCompInf, $pid);
			$this->createdLFDBrecords[$intComp][$cUid] = array();
			$intDGroups = $this->getDanceGroupCount($intComp);
			for($y=0;$y < $intDGroups; $y++) {
				$arrDGroup = $this->getDanceGroupInfo($intComp, $y);
				$dUid = $this->lfdb->createDGroup($arrDGroup, $cUid, $pid);
				$this->createdLFDBrecords[$intComp][$cUid][$y][$dUid]= array();
				$intCouples = $this->getCouplesCount($intComp, $y);
				for($z=0;$z < $intCouples;$z++) {
					$arrCouple = $this->getCoupleInfo($intComp, $y, $z);	
					$rUid = $this->lfdb->createDResult($arrCouple, $dUid, $pid);
					  // checking if couple's q. class matches group's q. class
					$intQClassInfo = $this->getCoupleQClassInfo($arrCouple, $arrDGroup, $bolCheckQClass);
					$coupleUid = $this->lfdb->getCoupleUid($arrCouple);
					$bolDGroupInRanking = (strtolower(trim($this->getDGroupAttrValue('ranking',$intComp, $y))) == 'true');

					if($bolDGroupInRanking && (t3lib_div::inList($listNotLssf, $coupleUid) || t3lib_div::inList($listNoClub, $coupleUid))) {
						$rPointsUid = $this->lfdb->createRPoints(0, $rUid, $pid, 'Klubas ne LSSF narys arba nera klubo - 0 tasku.');
						$this->registerNonRankingCouple($arrDGroup, $arrCouple);
					} elseif($intQClassInfo !== -1 && $bolDGroupInRanking) {
						// if danced in higher class - update couple's class to higher
						if($intQClassInfo === 1) {
							$this->updateCoupleQClass($arrCouple, $arrDGroup);
						}
						
						$cPlace = $this->calculateCouplePlace($arrDGroup, $arrCouple);
						// if couple danced in her or higher class				
						$rPoints = $calc->calculateRPoints(
								$cPlace,
								$this->compGroupCouplesCount($y),
								$this->compGroupClubsCount($y)
						);
						if ($cPlace != $arrCouple['place']) {
							$calc->addToLog_placeCorrection($arrCouple['place'], $cPlace);
						}
						$rPointsUid = $this->lfdb->createRPoints($rPoints, $rUid, $pid, $calc->calcLog);
					} elseif($intQClassInfo === -1 && $bolDGroupInRanking) {
						// if couple danced in lower class						
						$rPointsUid = $this->lfdb->createRPoints(0, $rUid, $pid, 'Soko zemesnioje kv. klaseje - 0 tasku.');
						$this->registerNonRankingCouple($arrDGroup, $arrCouple);
					} else {
						// non ranking competition
						$rPointsUid = 0;
					}
					if($bolCalculateQPoints) {	
						// if danced in higher qclass and this is not ranking competition
						$bolDancedInHigherQClass =(($intQClassInfo === 1) && (!$bolDGroupInRanking))?true:false;			
						$kPoints = $calc->calculateKPoints(
								$arrCouple['place'],
								$this->compGroupCouplesCount($y),
								$isChampionship,
								$bolDancedInHigherQClass
						);					
						$kPointsUid = $this->lfdb->createKPoints($kPoints, $rUid, $pid, $calc->calcLog);
					} else {
						$kPointsUid = 0;
					}		
					$this->createdLFDBrecords[$intComp][$cUid][$y][$dUid][$z][$rUid]= array(
						'r' => $rPointsUid,
						'k' => $kPointsUid
					);				
				}
			}
		}
	}
	
	function registerNonRankingCouple($arrDGroup, $arrCouple) {
		$strDGrTitle = $arrDGroup['qualificationclass'].'_'.$arrDGroup['agegroup'].'_'.$arrDGroup['dances'];
		$arrNRanking = $this->lfdb->getFromCache('non_ranking', $strDGrTitle);
		if(!is_array($arrNRanking)) {$arrNRanking = array();};
		$arrNRanking[$arrCouple['place']][] = $this->lfdb->getCoupleUid($arrCouple);
		$this->lfdb->putToCache('non_ranking', $strDGrTitle,$arrNRanking);						
	}

	function calculateCouplePlace($arrDGroup, $arrCouple) {
		$strDGrTitle = $arrDGroup['qualificationclass'].'_'.$arrDGroup['agegroup'].'_'.$arrDGroup['dances'];
		$arrNRanking = $this->lfdb->getFromCache('non_ranking', $strDGrTitle);
		$cCount = 0;
		if(is_array($arrNRanking)) {
			foreach($arrNRanking as $place => $value) {
				if($place < $arrCouple['place']) {
					$cCount++;
				}
			}
		}
		
		return 	($arrCouple['place'] - $cCount);
	}

	
	function getCoupleQClassInfo($arrCouple, $arrDGroup) {
		$groupClass = strtolower(trim($arrDGroup['qualificationclass']));
		$groupDances = strtolower(trim($arrDGroup['dances']));

		$cUid = $this->lfdb->getCoupleUid($arrCouple);
		$arrCQInfo = $this->lfdb->getFromCache('couples', $cUid);
		$retVal = FALSE;  
		
		switch($groupDances) {
			case 'st':
				$retVal = $this->compareQClases($groupClass, $arrCQInfo['qclass_st']);
			break;
			
			case 'la':
				$retVal = $this->compareQClases($groupClass, $arrCQInfo['qclass_la']);
			break;

			default:
				$retVal = $this->compareQClases($groupClass, $arrCQInfo['qclass']);
			break;
		}
#		debug(array('getCoupleQClassInfo' => array($arrCouple, $arrDGroup, $cUid, $arrCQInfo,$retVal, $this->lfdb->getCoupleInfo($cUid))));		
		return $retVal;
		
	}
	
	function compareQClases($classOne, $classTwo, $bolCheckQClass) {
		if ($bolCheckQClass) {
			$classOne = (!is_numeric($classOne))?$this->lfdb->getQClassUid($classOne):t3lib_div::intval_positive($classOne);
			$classTwo = (!is_numeric($classTwo))?$this->lfdb->getQClassUid($classTwo):t3lib_div::intval_positive($classTwo);
			$retVal = FALSE;
			if($classOne && $classTwo) {
				$arrInfo = $this->lfdb->getQClassesInfo($classOne.','.$classTwo);
				if(is_array($arrInfo) && isset($arrInfo[$classOne]) && isset($arrInfo[$classTwo])) {
					if($arrInfo[$classOne]['sorting'] < $arrInfo[$classTwo]['sorting']) {
						$retVal = -1;
					} elseif($arrInfo[$classOne]['sorting'] == $arrInfo[$classTwo]['sorting']) {
						$retVal = 0;
					} elseif($arrInfo[$classOne]['sorting'] > $arrInfo[$classTwo]['sorting']) {
						$retVal = 1;
					}
				}
			}
		} else {
			$retVal = 0;
		}
		
		return $retVal;
	}
	
	function updateCoupleQClass($arrCouple, $arrDGroup) {
		$groupClass = strtolower(trim($arrDGroup['qualificationclass']));
		$groupDances = strtolower(trim($arrDGroup['dances']));
		
		$cUid = $this->lfdb->getCoupleUid($arrCouple);
		$retVal = FALSE;  
		$arrFields = array();
		
		switch($groupDances) {
			case 'st':
				$arrFields['qclass_st'] = $groupClass;
				$retVal = $this->lfdb->updateCouple($cUid, $arrFields);
			break;
			
			case 'la':
				$arrFields['qclass_la'] = $groupClass;
				$retVal = $this->lfdb->updateCouple($cUid, $arrFields);
			break;

			default:
				$arrFields['qclass'] = $groupClass;
				$retVal = $this->lfdb->updateCouple($cUid, $arrFields);
			break;
		}
		
		return $retVal;		
	}
	
	function compTotalCouplesCount($intComp) {
		$intCouples = $intNoCouples = 0;
		$this->lfdb->clearCache('couples');
		$arrNoCouples = array();
		if ($intComp < $this->getCompetitionResultCount()){
			$intDGroups = $this->getDanceGroupCount($intComp);
			$arrCouples = array();
			for($y=0;$y < $intDGroups; $y++) {
				$intCouples = $this->getCouplesCount($intComp, $y);
				for($z=0;$z < $intCouples;$z++) {				
					if ($cUid = $this->checkCouple($intComp, $y, $z)) {
						$arrCouples[$cUid] = 1; 
					} else {
						$arrCouple = $this->getCoupleInfo($intComp, $y, $z);
						$arrNoCouples[$arrCouple[0]['code'].'_'.$arrCouple[1]['code']] = 1;
					}
				}
			}
			$intCouples = count($arrCouples);
			$intNoCouples = count($arrNoCouples);
		}
		return array($intCouples, $intNoCouples);
	}
	function compGroupCouplesCount($intGroup, $intComp = 0) {
		$intCouples = $this->getCouplesCount($intComp, $intGroup);
		$arrCouples = array();
		for($z=0;$z < $intCouples;$z++) {				
			if ($cUid = $this->checkCouple($intComp, $intGroup, $z)) {
				$arrCouples[$cUid] = 1; 
			}
		}	
		return count($arrCouples);
	}
	
	function compTotalClubsCount($intComp) {
		$intClubs = $intNoClubs = 0;
		$arrNoClubs = array('lssf' => array(), 'noatall' => array(), 'noexistent' => array());		
		if ($intComp < $this->getCompetitionResultCount()){
			$intDGroups = $this->getDanceGroupCount($intComp);
			$arrCouples = array();
			for($y=0;$y < $intDGroups; $y++) {
				$intCouples = $this->getCouplesCount($intComp, $y);
				for($z=0;$z < $intCouples;$z++) {				
					if ($cUid = $this->checkClub($intComp, $y, $z)) {
						$arrClubs[$cUid] = 1; 
					} else {
						$cUid = $this->checkClub($intComp, $y, $z, 0);
						$arrCouple = $this->getCoupleInfo($intComp, $y, $z);
						if($cUid) {
						  $arrNoClubs['lssf'][$arrCouple[0]['code'].'_'.$arrCouple[1]['code']] = $this->checkCouple($intComp, $y, $z);							
						} else {
	  						$arrCouple = $this->getCoupleInfo($intComp, $y, $z);
							if($cUid = $this->checkCouple($intComp, $y, $z)) {
								$arrNoClubs['noatall'][$arrCouple[0]['code'].'_'.$arrCouple[1]['code']] = $cUid;
							} else {							
								$arrNoClubs['noexistent'][$arrCouple[0]['code'].'_'.$arrCouple[1]['code']] = 1;
							}							
						}
					}
				}
			}
			$intClubs = count($arrClubs);
		}
		return array($intClubs, $arrNoClubs);
	}
	
	function compGroupClubsCount($intGroup, $intComp=0) {
		$intCouples = $this->getCouplesCount($intComp, $intGroup);
		$arrClubs = array();
		for($z=0;$z < $intCouples;$z++) {				
			if ($cUid = $this->checkClub($intComp, $intGroup, $z)) {
				$arrClubs[$cUid] = 1; 
			}
		}
		return count($arrClubs);		
	}
	
	function getCompetitionUid($intComp) {
		$uid = 0;
		if (is_array($this->createdLFDBrecords[$intComp]) && 
		    count($this->createdLFDBrecords[$intComp])) {
		    reset($this->createdLFDBrecords[$intComp]);
			$uid = key($this->createdLFDBrecords[$intComp]);
		}
		return $uid;
	}
	
	
	function processNewDancers(){
		if ($compCount = $this->getCompetitionResultCount()){
			$this->arrNewDancers = array();
			for($i=0; $i < $compCount; $i++) {
				$intDGroups = $this->getDanceGroupCount($i);
				for($y=0;$y < $intDGroups; $y++) {
					$arrNewUids = $this->lfdb->checkDancers(
						$this->getDGroupDancersUidArr($i, $y)
					);
					$this->arrNewDancers = t3lib_div::array_merge_recursive_overrule(
						$this->arrNewDancers,
						$arrNewUids,
						0,
						1
					);
				}
			}
		}
	}

	function processNewCouples(){
		if (!count($this->arrNewCouples) && $compCount = $this->getCompetitionResultCount()){
			$this->arrNewCouples = array();
			for($i=0; $i < $compCount; $i++) {
				$intDGroups = $this->getDanceGroupCount($i);
				for($y=0;$y < $intDGroups; $y++) {
					$intCouples = $this->getCouplesCount($i, $y);
					for($z=0;$z < $intCouples;$z++) {
						$cUid = $this->checkCouple($i, $y, $z);
						$arrCouple = $this->getCoupleInfo($i, $y, $z);
						$this->couples[$arrCouple[0]['code'].'_'.$arrCouple[1]['code']] = $cUid;
						if (!$cUid) {
							$this->arrNewCouples[$i][$y][$z] = 1; 
						}
					}
				}
			}
		}
	}
	
	function cleanData() {
       	$this->setStepState(0,0);
       	$this->setStepState(1,0);
       	$this->setStepState(2,0);
       	$this->setStepState(3,0);
       	$this->setStepState(4,0);
       	$this->setStepState(5,0);

		if(is_object($this->lfdb)) {
			$this->deleteCreatedDancers();
			$this->deleteCreatedCouples();
			$this->deleteCreatedCompetitions();
		}
	}
	
	
	function deleteCreatedDancers() {
		if (is_array($this->createdDancers) && count($this->createdDancers)) {
			$this->lfdb->deleteDancers($this->implodeMulti($this->createdDancers));
		}
	}
	
	function deleteCreatedCouples() {
		if (is_array($this->createdCouples) && count($this->createdCouples)) {
			$this->lfdb->deleteCouples($this->implodeMulti($this->createdCouples));
		}		
	}
	
	function cleanCreatedData() {
		unset($this->createdDancers);
		unset($this->createdCouples);
		unset($this->createdLFDBrecords);
	}
	
	function deleteCreatedCompetitions() {
		if (is_array($this->createdLFDBrecords) && count($this->createdLFDBrecords)) {
			foreach($this->createdLFDBrecords as $compRec) {
				foreach($compRec as $compUid => $dGroups) {
					$this->lfdb->deleteCompetition($compUid);
					$this->deleteCreatedDGroups($dGroups);
				}
			}
		}	
	}
	
	function deleteCreatedDGroups($arrDGroups) {
		if (is_array($arrDGroups) && count($arrDGroups)) {
			foreach($arrDGroups as $dRec) {
				foreach($dRec as $dUid => $cResultss) {
					$this->lfdb->deleteDGroup($dUid);
					$this->deleteCreatedDResults($cResultss);				
				}
			}				
		}	
	}
	
	function deleteCreatedDResults($arrResults) {
		if (is_array($arrResults) && count($arrResults)) {
			foreach($arrResults as $dRes) {
				foreach($dRes as $rUid => $points) {
					$this->lfdb->deleteDResult($rUid);	
					$this->deleteCreatedPoints($points);	
				}
			}				
		}			
	}
	
	function deleteCreatedPoints($points) {
		if(isset($points['r']) && !empty($points['r'])) {
			$this->lfdb->deleteRPoints($points['r']);
		}
		if(isset($points['k']) && !empty($points['k'])) {
			$this->lfdb->deleteKPoints($points['k']);
		}
	}
	
	function implodeMulti($arr) {
		$arrUids = array();
		foreach($arr as $val) {
			$arrUids[] = implode(',', $val);
		}
		return implode(',', $arrUids);
	}
	
	function checkCouple($intComp, $intDGroup, $intRes) {
	
		$arrCouple = $this->getCoupleInfo($intComp, $intDGroup, $intRes);
		return $this->lfdb->getCoupleUid($arrCouple);
	}

	function checkClub($intComp, $intDGroup, $intRes, $bolChekLSSF=1) {
	
		$cUid = $this->checkCouple($intComp, $intDGroup, $intRes);
		return $this->lfdb->getClubUid($cUid, $bolChekLSSF);
	}
	
	function getCoupleInfo($intComp, $intDGroup, $intRes) {
		$arrResult = $this->getResult($intComp, $intDGroup, $intRes);

		$arrCouple = array();
		$arrCouple[0] = array(
			'code' => $arrResult['maleDancer'][0]['ch']['code'][0]['values'][0],
			'name' => $arrResult['maleDancer'][0]['ch']['name'][0]['values'][0],
			'surname' => $arrResult['maleDancer'][0]['ch']['surname'][0]['values'][0],
			'sex' => 'male'
		);
		$arrCouple[1] = array(
			'code' => $arrResult['femaleDancer'][0]['ch']['code'][0]['values'][0],
			'name' => $arrResult['femaleDancer'][0]['ch']['name'][0]['values'][0],
			'surname' => $arrResult['femaleDancer'][0]['ch']['surname'][0]['values'][0],
			'sex' => 'female'
		);

		$arrCouple['dgroup'] = $this->getDanceGroupInfo($intComp, $intDGroup); 
		$arrCouple['place'] = $arrResult['place'][0]['values'][0];
		return $arrCouple;		
	}
	
	function getDancerUid($code){
		return $this->lfdb->getDancerUid(intval($code));	
	}
	
	function getAgeGroupUid($strTitle) {
		return $this->lfdb->getAgeGroupUid($strTitle);
	}

	function getQClassUid($strTitle) {
		return $this->lfdb->getQClassUid($strTitle);
	}

	
	function createDancers($arr, $pid) {

		$arrSex = array('male' => 1, 'female' => 2);
		foreach($arr as $code) {
			if(!$this->getDancerUid($code)) {
				$arrDancer = $this->getDancerInfo($code);
				$rec = array();
				$rec['pid'] = intval($pid);
				$rec['ptype'] = 'dancer';
				$rec['sex'] = $arrSex[trim($arrDancer['sex'])];
				$rec['firstname'] = $arrDancer['name'];
				$rec['secondname'] = $arrDancer['surname'];
				$rec['code'] = intval($arrDancer['code']);
#				$dUid = $this->lfdb->createDancer($this->getDancerInfo($code), $pid);
				$data['tx_vvlssfdb_person']['NEW_'.intval($arrDancer['code'])] = $rec;
			}
		}

		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		$tce->stripslashes_values = 0;
		$tce->start($data,array());
		$tce->process_datamap();

		foreach($tce->substNEWwithIDs as $NEW => $dUid) {
			list(,$code) = t3lib_div::intExplode('_', $NEW);
			$this->createdDancers[$code][] = $dUid;
		};
	}
	
	function createCouples($arr, $pid) {
		if(is_array($arr) && count($arr)) {
			foreach($arr as $result) {
				$arrResult = explode('_', $result);
				if(count($arrResult) == 3) {
					$arrCouple = $this->getCoupleInfo($arrResult[0], $arrResult[1], $arrResult[2]);
					$strCouple = $arrCouple[0]['code'].'_'.$arrCouple[1]['code'];
					if(!is_array($this->createdCouples[$strCouple]) || 
						(!count($this->createdCouples[$strCouple]))) {
						$cUid = $this->lfdb->createCouple($arrCouple, $pid);
						$this->lfdb->addCoupleToClub($cUid, 247);
						$this->createdCouples[$strCouple][] = $cUid;
						$this->couples[$strCouple] = $cUid;
						$this->clubs[$strCouple] = $this->getCouplesClubUid($cUid);
					}
				}
			}
		}
	}

	/**
	 * Changes couple information in the internal results array with new one (existing in LSSFDB) 
	 *
	 * @param	string		$firsrPartnerCode	code of one of the partners
	 * @param	string		$secondPartnerCode	code of one of the partners
	 * @param	integer		$coupleUid	 		uid of the couple in LSSFDB
	 * 
	 * @return	void		Returns nothing
	 */	
	function exchangeCouple($firsrPartnerCode, $secondPartnerCode, $coupleUid) {
		foreach($this->arrNewCouples as $x => $arrDGroup) {
			foreach($arrDGroup as $y => $arrResult) {
				foreach ($arrResult as $z => $value) {
					$arrCouple = $this->getCoupleInfo($x, $y, $z);
					if (($arrCouple[0]['code'] == $firsrPartnerCode && $arrCouple[1]['code'] == $secondPartnerCode) ||
						($arrCouple[1]['code'] == $firsrPartnerCode && $arrCouple[0]['code'] == $secondPartnerCode)
					) {
						$this->updateCoupleInfo($x, $y, $z, $coupleUid);
					}
				}
			}
		}
		
	}

	/**
	 * Update couple information in internal array with info from LSSFDB 
	 *
	 * @param	integer		$intComp	index of competition element in the array
	 * @param	integer		$intDGroup	index of dance group element in the competition sub array
	 * @param	integer		$intRes		index of result element in the dance goroup sub array
	 * @param	integer		$coupleUid	 		uid of the couple in LSSFDB
	 * 
	 * @return	void		Returns nothing
	 */	
	function updateCoupleInfo($intComp, $intDGroup, $intRes, $coupleUid) {
		$arrResult = $this->getResult($intComp, $intDGroup, $intRes);
		
		$arrMale = $this->lfdb->getCoupleInfo($coupleUid, 'mpartner');
		$arrFemale = $this->lfdb->getCoupleInfo($coupleUid, 'fpartner');
		if (count($arrMale) && count($arrFemale)) {
			$arrResult['maleDancer'][0]['ch']['code'][0]['values'][0] = $arrMale[0]['firstname'];
			$arrResult['maleDancer'][0]['ch']['name'][0]['values'][0] = $arrMale[0]['secondname'];
			$arrResult['maleDancer'][0]['ch']['surname'][0]['values'][0] = $arrMale[0]['code'];
	
			$arrResult['femaleDancer'][0]['ch']['code'][0]['values'][0] = $arrFemale[0]['firstname'];
			$arrResult['femaleDancer'][0]['ch']['name'][0]['values'][0] = $arrFemale[0]['secondname'];
			$arrResult['femaleDancer'][0]['ch']['surname'][0]['values'][0] = $arrFemale[0]['code'];
	
			unset($this->arrNewCouples[$intComp][$intDGroup][$intRes]);
		}
		
	}
	
	function getNewCoupleCode() {
		return $this->lfdb->getUniqueCoupleCode();
	}
	
	function getCouplesClubUid($cUid) {
		return $this->lfdb->getCouplesClubUid($cUid);
	}
	
	function thereAreNewDancers($intComp, $intDGroup='', $intRes='') {
		$result = false;
		if($intDGroup === '' && $intRes === '') {
			$result = (bool)(isset($this->arrNewDancers[$intComp]) && is_array($this->arrNewDancers[$intComp]));
		} elseif($intRes === '') {
			$result = (bool)(isset($this->arrNewDancers[$intComp][$intDGroup]) && is_array($this->arrNewDancers[$intComp][$intDGroup])); 
		} else {
			$result = (bool)(isset($this->arrNewDancers[$intComp][$intDGroup][$intRes]) && !empty($this->arrNewDancers[$intComp][$intDGroup][$intRes]));
		}
		return $result;
	}

	function thereAreNewCouples($intComp, $intDGroup='', $intRes='') {
		$result = false;
		if($intDGroup === '' && $intRes === '') {
			$result = (bool)(isset($this->arrNewCouples[$intComp]) && is_array($this->arrNewCouples[$intComp]));
		} elseif($intRes === '') {
			$result = (bool)(isset($this->arrNewCouples[$intComp][$intDGroup]) && is_array($this->arrNewCouples[$intComp][$intDGroup])); 
		} else {
			$result = (bool)(isset($this->arrNewCouples[$intComp][$intDGroup][$intRes]) && !empty($this->arrNewCouples[$intComp][$intDGroup][$intRes]));
		}
		return $result;
		
	}
	
	function getNewDancersInfo($intComp, $intDGroup, $intRes) {
		$arrDUids = t3lib_div::intExplode(',',$this->arrNewDancers[$intComp][$intDGroup][$intRes]);
		$arrDancers = array();
		foreach($arrDUids as $intDUid) {
			$arrDancers[] = $this->getDancerInfo($intDUid,$intComp, $intDGroup, $intRes);
		}
		return $arrDancers;
	}
	
	function _getDancerInfo($code,$intComp, $intDGroup, $intRes) {
		$arrResult = $this->getResult($intComp, $intDGroup, $intRes);
		$arrDancer = array();
		if($code == $arrResult['maleDancer'][0]['ch']['code'][0]['values'][0]) {
			$arrDancer['name'] = $arrResult['maleDancer'][0]['ch']['name'][0]['values'][0];
			$arrDancer['surname'] = $arrResult['maleDancer'][0]['ch']['surname'][0]['values'][0];
			$arrDancer['code'] = $code;
			$arrDancer['sex'] = 'male';			  
		} elseif($code == $arrResult['femaleDancer'][0]['ch']['code'][0]['values'][0]) {
			$arrDancer['name'] = $arrResult['femaleDancer'][0]['ch']['name'][0]['values'][0];
			$arrDancer['surname'] = $arrResult['femaleDancer'][0]['ch']['surname'][0]['values'][0];
			$arrDancer['code'] = $code;
			$arrDancer['sex'] = 'female';			  			
		}
		return $arrDancer;
	}
	
	function getDancerInfo($code,$intComp='', $intDGroup='', $intRes='') {
		if($intComp==='' &&  $intDGroup==='' && $intRes==='') {
			$compCount = $this->getCompetitionResultCount();
			for($i=0; $i < $compCount; $i++) {
				$intDGroups = $this->getDanceGroupCount($i);
				for($y=0;$y < $intDGroups; $y++) {
					$intCouples = $this->getCouplesCount($i, $y);
					for($z=0;$z < $intCouples;$z++) {
						if($arrDancer = $this->_getDancerInfo($code,$i, $y, $z) ) {
							return $arrDancer;
						}
					}
				}
			}
			
		} else {
			return $this->_getDancerInfo($code,$intComp, $intDGroup, $intRes);
		}
	}
	
	function countNewUids($intComp, $intDGroup) {
		$intUids = 0;
		if($this->thereAreNewDancers($intComp, $intDGroup)) {
			foreach($this->arrNewDancers[$intComp][$intDGroup] as $resultNr=>$uidList) {
				$intUids += count(explode(',', $uidList));
			}
			
		}
		return $intUids;	
	}

	function addError($source,$str) {
		$this->errors[$source] = $str;
	}
	
	function getErrors(){
		return $this->errors;
	}

	function error(){
		return count($this->errors);
	}
	
	function getCompetitionResultCount() {
		
		if (count($this->arrComp)) {
		  return count($this->arrComp['competitionResult']);	
		}
	}

	function getDanceGroupCount($intComp=0) {
		
		if (count($this->arrComp)) {
		  return count($this->arrComp['competitionResult'][$intComp]['ch']['danceGroup']);	
		}
	}


	function getCouplesCount($intComp=0, $intDGroup=0) {
		
		if (count($this->arrComp)) {
		  return count($this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch']['result']);	
		}
	}


	function &getCompetitionResult($intComp=0) {
		
		if ($this->getCompetitionResultCount()) {
		  return $this->arrComp['competitionResult'][$intComp]['ch'];	
		}
	}

	function &getDanceGroup($intComp=0, $intDGroup=0) {
		
		if ($this->getCompetitionResultCount()) {
		  return $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch'];	
		}
	}

	function &getResult($intComp=0, $intDGroup=0, $intRes=0) {
		
		if ($this->getCompetitionResultCount()) {
		  return $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch']['result'][$intRes]['ch'];	
		}
	}
	
	function getDGroupAttrValue($attrName, $intComp=0, $intDGroup=0) {
		$retVal = '';
		if(isset($this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['attrs'][$attrName])) {
			$retVal = $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['attrs'][$attrName];
		}
		return $retVal;
	}

	function getCompetitionResultInfo($intComp=0) {
		
		$arrInfo = array();
		if ($intComp < $this->getCompetitionResultCount()) {
		  $arrInfo['name'] = $this->arrComp['competitionResult'][$intComp]['ch']['name'][0]['values'][0];	
		  $arrInfo['city'] = $this->arrComp['competitionResult'][$intComp]['ch']['city'][0]['values'][0];
		  $arrInfo['date'] = $this->arrComp['competitionResult'][$intComp]['ch']['date'][0]['values'][0];		  		  
		}
		return $arrInfo;
	}

	function getDanceGroupInfo($intComp=0, $intDGroup=0) {
		
		$arrInfo = array();
		if (($intComp < $this->getCompetitionResultCount()) && ($intDGroup < $this->getDanceGroupCount($intComp))) {
		  $arrInfo['agegroup'] = $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch']['ageGroup'][0]['values'][0];	
		  $arrInfo['qualificationclass'] = $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch']['qualificationClass'][0]['values'][0];
		  $arrInfo['dances'] = $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch']['dances'][0]['values'][0];
		  $arrInfo['date'] = $this->arrComp['competitionResult'][$intComp]['ch']['danceGroup'][$intDGroup]['ch']['date'][0]['values'][0];		  		  
		}
		return $arrInfo;
	}

	function getResultDancersUidList($intComp=0, $intDGroup=0,$intRes=0){
		$uidList = '';
		$arrResult = $this->getResult($intComp, $intDGroup, $intRes);
		if (is_array($arrResult)) {
			$uidList = $arrResult['maleDancer'][0]['ch']['code'][0]['values'][0].','.
			$arrResult['femaleDancer'][0]['ch']['code'][0]['values'][0];
		}
		return $uidList;
	}
	
	function getDGroupDancersUidArr($intComp=0, $intDGroup=0){

		$arrUids = array();
		$intCouples = $this->getCouplesCount($intComp, $intDGroup);

		for($i=0; $i < $intCouples;$i++) {
			$arrUids[$intComp][$intDGroup][$i] = $this->getResultDancersUidList($intComp, $intDGroup,$i);
		}
		return $arrUids;
	}
	
}
?>
