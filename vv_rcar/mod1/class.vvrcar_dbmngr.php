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

/**
 * Class 'DB manager' for the 'vv_lssfdb' extension.
 *
 * @author    Miroslav Monkevic <m@vektorius.lt>
 * @package    TYPO3
 * @subpackage    vv_lssfdb
 */

/**
* [CLASS/FUNCTION INDEX of SCRIPT]
*/

class vvrcar_dbmngr {
	var $cache = array();
	
	
	function checkDancers($arrUids) {
		$strUids = $this->compileDancersUidList($arrUids);
		if (!empty($strUids)) {
			$table = 'tx_vvlssfdb_person';
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'code,uid', 
				$table, 
				' code IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($strUids).')'.
				t3lib_BEfunc::deleteClause($table).
				t3lib_BEfunc::BEenableFields($table)
			);
			$intCouples = count($rows);
			if($intCouples) {
				for($i=0; $i < $intCouples; $i++) {
					$this->findAndRemoveUid($arrUids, $rows[$i]['code']);
					$this->putToCache('dancers',$rows[$i]['code'], $rows[$i]['uid']);					
				}
			}

		}
		return $arrUids;
	}
	
	function getDancerUid($code) {
		$uid = 0;
		if ($code) {
			$table = 'tx_vvlssfdb_person';
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'uid', 
				$table, 
				' code ='.$code.
				t3lib_BEfunc::deleteClause($table).
				t3lib_BEfunc::BEenableFields($table)
			);

			if(count($rows)) {
				$uid = $rows[0]['uid'];
				$this->putToCache('dancers',$code, $uid);
			}
		}
		return $uid;
	}
	
	function getCouplesClubUid($cUid) {
		$clubUid = 0;
		$table1 = 'tx_vvlssfdb_couple';
		$table2 = 'tx_vvlssfdb_danceclub';
		$table_mm = 'tx_vvlssfdb_couple_clubs_mm';
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query(
			$table1.'.uid',
			$table1,
			$table_mm,
			$table2,
			' AND '.$table2.'.is_lssf_member = 1 AND '.$table1.'.uid ='.intval($cUid) ,
			'',						// Group By
			'',            			// Order By
			1               		// Limit
		);
		if($clubRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
			$clubUid = $clubRow['uid'];
		}
		return $clubUid;
	}
	
	function getFromCache($cat, $index) {
		$value = 0;
		if(isset($this->cache[$cat][$index]) && !empty($this->cache[$cat][$index])) {
			$value = $this->cache[$cat][$index];
		}
		return $value;
	}
	
	function putToCache($cat, $index,$value) {
		$this->cache[$cat][$index] = $value;
	}
	
	function clearCache($cat) {
		if (isset($this->cache[$cat])) {
			unset($this->cache[$cat]);
		}
	}
	

	function getCoupleUid($arrCouple) {
		$uid = 0;
		$table1 = 'tx_vvlssfdb_couple';
		$table2 = 'tx_vvlssfdb_person';
		$table = $table1.' AS a, '.$table2.' AS b, '.$table2.' AS c';
		
		if($cachedUid = $this->getFromCache('couples', $arrCouple[0]['code'].'_'.$arrCouple[1]['code'])) {
			$uid = $cachedUid;
		} else {
			if (($mUid = $this->getFromCache('dancers', $arrCouple[0]['code'])) &&
				($fUid = $this->getFromCache('dancers', $arrCouple[1]['code'])) ) {
	
				$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'uid,qclass,qclass_st, qclass_la', 
					$table1, 
					' mpartner ='.$mUid.
					' AND fpartner = '.$fUid.
					t3lib_BEfunc::deleteClause($table1).
					t3lib_BEfunc::BEenableFields($table1)
				);
			} else { 
				$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'a.uid,a.qclass,a.qclass_st,a.qclass_la', 
					$table, 
					' a.mpartner =b.uid'.
					' AND a.fpartner = c.uid'.
					' AND b.code = '.$arrCouple[0]['code'].
					' AND c.code = '.$arrCouple[1]['code'].
					t3lib_BEfunc::deleteClause($table1,'a').
					str_replace($table1, 'a', t3lib_BEfunc::BEenableFields($table1)).
					t3lib_BEfunc::deleteClause($table2, 'b').
					str_replace($table2, 'b', t3lib_BEfunc::BEenableFields($table2)).
					t3lib_BEfunc::deleteClause($table2,'c').
					str_replace($table2, 'c', t3lib_BEfunc::BEenableFields($table2))
				);
			}
	
			if(count($rows)) {
#				debug(array($arrCouple, $rows));
				$uid = $rows[0]['uid'];
				$this->putToCache('couples',$uid, array('qclass' => $rows[0]['qclass'],'qclass_st' => $rows[0]['qclass_st'],'qclass_la' => $rows[0]['qclass_la']));
				$this->putToCache('couples',$arrCouple[0]['code'].'_'.$arrCouple[1]['code'], $uid);
			}
		}
		return $uid;
		
			
	}

	function getClubUid($uidCouple, $bolCheckLSSF) {
		$uid = 0;
		$table1 = 'tx_vvlssfdb_couple_clubs_mm';
		$table2 = 'tx_vvlssfdb_danceclub';
		
		if ($uidCouple) {

			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'a.uid_foreign', 
				$table1.' AS a, '.$table2.' AS b', 
				' a.uid_local ='.intval($uidCouple).
				' AND b.uid = a.uid_foreign'.
				(($bolCheckLSSF)?' AND b.is_lssf_member = 1':'').
				t3lib_BEfunc::deleteClause($table2, 'b').
				str_replace($table2, 'b', t3lib_BEfunc::BEenableFields($table2)),
				'', //group by
				'', // order
				1   // limit
			);
		}

		if(count($rows)) {
			$uid = $rows[0]['uid_foreign'];
		}
		return $uid;
	}


	function getCoupleInfo($cUid, $field='*') {
		$table1 = 'tx_vvlssfdb_couple';
		$table2 = 'tx_vvlssfdb_person';
		$rows = array();
		switch((string)$field) {
			case 'mpartner':
			case 'fpartner':		
				$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					'b.firstname, b.secondname, b.code', 
					$table1.' AS a, '.$table2.' AS b', 
					' a.uid ='.$cUid.
					' AND a.'.$field.' = b.uid'.
					t3lib_BEfunc::deleteClause($table1,'a').
					str_replace($table1, 'a', t3lib_BEfunc::BEenableFields($table1)).
					t3lib_BEfunc::deleteClause($table2, 'b').
					str_replace($table2, 'b', t3lib_BEfunc::BEenableFields($table2))
				);
			break;
			
			default:
				$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					$field, 
					$table1, 
					' uid ='.$cUid.
					t3lib_BEfunc::deleteClause($table1).
					t3lib_BEfunc::BEenableFields($table1)
				);

			break;
		}
		
		return $rows;
	}
	
	function getUniqueCoupleCode() {
		$uid = 0;
		$table = 'tx_vvlssfdb_couple';
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'MAX(uid) as maxcode', 
			$table,
			'1=1'
		);
		if(count($rows)) {
			$uid = $rows[0]['maxcode'];
		}
		return ++$uid;
		
	}
	
	function getUniqueCompCode() {
		$uid = 0;
		$table = 'tx_vvlssfdb_competition';
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'MAX(uid) as maxcode', 
			$table,
			'1=1'
		);
		if(count($rows)) {
			$uid = $rows[0]['maxcode'];
		}
		return ++$uid;		
	}

	
	function getAgeGroupUid($strTitle) {
		$uid = 0;
		$table = 'tx_vvlssfdb_agegroup';
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'uid', 
			$table,
			'title LIKE \'%'.$GLOBALS['TYPO3_DB']->escapeStrForLike($strTitle, $table).'%\''.
			t3lib_BEfunc::deleteClause($table).
			t3lib_BEfunc::BEenableFields($table)
			
		);
		if(count($rows)) {
			$uid = $rows[0]['uid'];
		}
		return $uid;
	}
	
	function getQClassUid($strTitle) {
		$uid = 0;
		$table = 'tx_vvlssfdb_qclass';
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'uid', 
			$table,
			'title LIKE \'%'.$GLOBALS['TYPO3_DB']->escapeStrForLike($strTitle, $table).'%\''.
			t3lib_BEfunc::deleteClause($table).
			t3lib_BEfunc::BEenableFields($table)
		);
		if(count($rows)) {
			$uid = $rows[0]['uid'];
		}
		return $uid;		
	}
	
	function getQClassesInfo($uidList) {
		$table = 'tx_vvlssfdb_qclass';
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'uid, title, code, sorting', 
			$table,
			'uid IN ('.$uidList.')'.
			t3lib_BEfunc::deleteClause($table).
			t3lib_BEfunc::BEenableFields($table),
			'',
			'',
			'',
			'uid'
		);
		return $rows;
	}
	
	function compileDancersUidList($arr) {
		$strUids = '';
		if(is_array($arr)) {
			$arrUids = array();
			foreach($arr as $comp) {
				if(is_array($comp)) {
					foreach($comp as $dgroup) {
						if(is_array($dgroup)) {
							foreach($dgroup as $result) {
								$arrUids[] = $result;
							}
						}
					}
				}
			}
			$strUids = implode(',', $arrUids);
		}
		return $strUids;
	}
	
	function findAndRemoveUid(&$arr, $uid) {
		if(is_array($arr)) {
			$arrUids = array();
			foreach($arr as $compk=>$compv) {
				if(is_array($compv)) {
					foreach($compv as $dgroupK=>$dgroupV) {
						if (!count($arr[$compk][$dgroupK])) {
							unset($arr[$compk][$dgroupK]);
						}
						if(is_array($dgroupV)) {
							foreach($dgroupV as $resultK=>$resultV) {
								if(t3lib_div::inList($resultV, $uid)) {
									$arr[$compk][$dgroupK][$resultK] = t3lib_div::rmFromList($uid, $resultV);
									if (empty($arr[$compk][$dgroupK][$resultK])) {
										unset($arr[$compk][$dgroupK][$resultK]);
									}
									if (empty($arr[$compk][$dgroupK])) {
										unset($arr[$compk][$dgroupK]);
									}
								}
							}
						}
					}
				}
			}
		}	
	}
	
	function createDancer($arrDancer, $pid) {
		$rec = array();
		$arrSex = array('male' => 1, 'female' => 2);
		$table = 'tx_vvlssfdb_person';
		$rec['pid'] = intval($pid);
		$rec['ptype'] = 'dancer';
		$rec['sex'] = $arrSex[trim($arrDancer['sex'])];
		$rec['firstname'] = $arrDancer['name'];
		$rec['secondname'] = $arrDancer['surname'];
		$rec['code'] = intval($arrDancer['code']);
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;
		
		
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);
		
		return $GLOBALS['TYPO3_DB']->sql_insert_id();
	}
	
	function createCouple($arrCouple, $pid) {
		$rec = array();

		$table = 'tx_vvlssfdb_couple';
		$rec['pid'] = intval($pid);
		$rec['code'] = intval($this->getUniqueCoupleCode());
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;
		$rec['couple_exists'] = 1;

		// Ids in cache are up to date
		$rec['mpartner'] = $this->getFromCache('dancers', $arrCouple[0]['code']);
		$rec['fpartner'] = $this->getFromCache('dancers', $arrCouple[1]['code']);

		// It is (should be) safe to use userdata from array. It should have been updated upon users creation. 	
		$rec['title_cache'] = $arrCouple[0]['surname'].', '.$arrCouple[0]['name'].' - '.
							$arrCouple[1]['surname'].', '.$arrCouple[1]['name'];
							
		$rec['agegroup'] = $this->getAgeGroupUid($arrCouple['dgroup']['agegroup']); 

		$qClass = $this->getQClassUid($arrCouple['dgroup']['qualificationclass']);
		if (trim(strtolower($arrCouple['dgroup']['dances'])) == 'st') {
			$rec['qclass_st'] = $qClass;
		} elseif(trim(strtolower($arrCouple['dgroup']['dances'])) == 'la') {
			$rec['qclass_la'] = $qClass;
		} else {
			$rec['qclass'] = $qClass;			
		}

		
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);

		return $GLOBALS['TYPO3_DB']->sql_insert_id();

	}
	
	function addCoupleToClub($cUid, $clubUid) {
		$rec = array();

		$table = 'tx_vvlssfdb_couple_clubs_mm';
		$rec['uid_local'] = intval($cUid);
		$rec['uid_foreign'] = intval($clubUid);
		$rec['sorting'] = 0;
		$rec['sorting_foreign'] = 99999;
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);
	}

	function updateCouple($cUid, $arrFields) {
		$table = 'tx_vvlssfdb_couple';
		$where = 'uid = '.intval($cUid);
		reset($arrFields);
		$key = key($arrFields);
		$arrFields[$key] = (is_string($arrFields[$key]))?$this->getQClassUid($arrFields[$key]):t3lib_div::intval_positive($arrFields[$key]);
#		debug(array('updateCouple' => array($cUid, $arrFields)));
		return $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $arrFields);
	}

	function createCompetition($arrCompetition, $pid) {
		$rec = array();

		$table = 'tx_vvlssfdb_competition';
		$rec['pid'] = intval($pid);
		$rec['code'] = intval($this->getUniqueCompCode());
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;

		// Ids in cache are up to date
		$rec['title'] = $arrCompetition['name'];
		$rec['city'] = $arrCompetition['city'];
		$rec['cdate'] = strtotime($arrCompetition['date']);

		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);

		return $GLOBALS['TYPO3_DB']->sql_insert_id();

	}

	
	function createDGroup($arrDGroup, $cUid, $pid) {
		$rec = array();
		$dances = array('st' => 2, 'la' => 3);

		$table = 'tx_vvlssfdb_dancegroup';
		$rec['pid'] = intval($pid);
		$rec['competition'] = intval($cUid);
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;

		$rec['agegroup'] = $this->getAgeGroupUid($arrDGroup['agegroup']);
		$rec['qclass'] = $this->getQClassUid($arrDGroup['qualificationclass']);
		$rec['program'] = (!empty($arrDGroup['dances']))?$dances[trim(strtolower($arrDGroup['dances']))]:1;
		$rec['dgdate'] = strtotime($arrDGroup['date']);

		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);

		return $GLOBALS['TYPO3_DB']->sql_insert_id();

	}

	function createDResult($arrCouple, $dUid, $pid) {
		$rec = array();

		$table = 'tx_vvlssfdb_cresult';
		$rec['pid'] = intval($pid);
		$rec['dgroup'] = intval($dUid);
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;

		$rec['couple'] = $this->getCoupleUid($arrCouple);
		$rec['place'] = intval($arrCouple['place']);

		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);

		return $GLOBALS['TYPO3_DB']->sql_insert_id();

	}
	
	function createRPoints($points, $rUid, $pid, $calcLog='') {
		$rec = array();

		$table = 'tx_vvlssfdb_rpoints';
		$rec['pid'] = intval($pid);
		$rec['tresult'] = intval($rUid);
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;
		$rec['points'] = intval($points);
		$rec['calc_log'] = $calcLog;


		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);

		return $GLOBALS['TYPO3_DB']->sql_insert_id();

	}

	function createKPoints($points, $rUid, $pid, $calcLog='') {
		$rec = array();

		$table = 'tx_vvlssfdb_qpoints';
		$rec['pid'] = intval($pid);
		$rec['tresult'] = intval($rUid);
		$rec['tstamp'] = mktime();
		$rec['crdate'] = $rec['tstamp'];
		$rec['cruser_id'] = 1;
		$rec['points'] = intval($points);
		$rec['calc_log'] = $calcLog;


		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $rec);

		return $GLOBALS['TYPO3_DB']->sql_insert_id();

	}

	function deleteRPoints($uidList) {
		$table = 'tx_vvlssfdb_rpoints';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);	
	}

	function deleteKPoints($uidList) {
		$table = 'tx_vvlssfdb_qpoints';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);	
	}
	
	function deleteDResult($uidList) {
		$table = 'tx_vvlssfdb_cresult';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);	
	}

	function deleteDancers($uidList) {
		$table = 'tx_vvlssfdb_person';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);	
	}


	function deleteCouples($uidList) {
		$table = 'tx_vvlssfdb_couple';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);	
	}

	function deleteCompetition($uidList) {
		$table = 'tx_vvlssfdb_competition';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);			
	}

	function deleteDGroup($uidList) {
		$table = 'tx_vvlssfdb_dancegroup';
		$GLOBALS['TYPO3_DB']->exec_DELETEquery(
								$table,
								'uid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($uidList).')'
		);			
	}

}
?>
