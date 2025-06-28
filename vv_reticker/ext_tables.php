<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_mvc1']='layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_mvc1']='pi_flexform';


t3lib_extMgm::addStaticFile('vv_reticker', './configurations/mvc1', 'RE Catalog ticker');


t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_mvc1', 'FILE:EXT:vv_reticker/configurations/mvc1/flexform.xml');


t3lib_extMgm::addPlugin(array('LLL:EXT:vv_reticker/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_mvc1'),'list_type');


if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_vvreticker_mvc1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'configurations/mvc1/class.tx_vvreticker_mvc1_wizicon.php';

$tempColumns = Array (
	"tx_vvreticker_vo" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo.I.0", ""),
			),
		)
	),
	"tx_vvreticker_votext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_votext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_vo:REQ:true',
	),

	"tx_vvreticker_np" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np.I.0", ""),
			),
		)
	),
	"tx_vvreticker_nptext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_nptext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_np:REQ:true',
	),

);


t3lib_div::loadTCA("tx_vvrecatalog_flat");
t3lib_extMgm::addTCAcolumns("tx_vvrecatalog_flat",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_vvrecatalog_flat","tx_vvreticker_vo;;;;1-1-1, tx_vvreticker_votext,tx_vvreticker_np;;;;1-1-1, tx_vvreticker_nptext", '', 'after:ext_pub');
$TCA['tx_vvrecatalog_flat']['ctrl']['requestUpdate'] .= ',tx_vvreticker_vo,tx_vvreticker_np';


$tempColumns = Array (
	"tx_vvreticker_vo" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo.I.0", ""),
			),
		)
	),
	"tx_vvreticker_votext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_votext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_vo:REQ:true',
	),

	"tx_vvreticker_np" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np.I.0", ""),
			),
		)
	),
	"tx_vvreticker_nptext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_nptext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_np:REQ:true',
	),

);


t3lib_div::loadTCA("tx_vvrecatalog_homestead");
t3lib_extMgm::addTCAcolumns("tx_vvrecatalog_homestead",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_vvrecatalog_homestead","tx_vvreticker_vo;;;;1-1-1, tx_vvreticker_votext,tx_vvreticker_np;;;;1-1-1, tx_vvreticker_nptext", '', 'after:ext_pub');
$TCA['tx_vvrecatalog_homestead']['ctrl']['requestUpdate'] .= ',tx_vvreticker_vo,tx_vvreticker_np';

$tempColumns = Array (
	"tx_vvreticker_vo" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo.I.0", ""),
			),
		)
	),
	"tx_vvreticker_votext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_votext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_vo:REQ:true',
	),

	"tx_vvreticker_np" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np.I.0", ""),
			),
		)
	),
	"tx_vvreticker_nptext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_nptext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_np:REQ:true',
	),

);


t3lib_div::loadTCA("tx_vvrecatalog_house");
t3lib_extMgm::addTCAcolumns("tx_vvrecatalog_house",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_vvrecatalog_house","tx_vvreticker_vo;;;;1-1-1, tx_vvreticker_votext,tx_vvreticker_np;;;;1-1-1, tx_vvreticker_nptext", '', 'after:ext_pub');
$TCA['tx_vvrecatalog_house']['ctrl']['requestUpdate'] .= ',tx_vvreticker_vo,tx_vvreticker_np';

$tempColumns = Array (
	"tx_vvreticker_vo" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo.I.0", ""),
			),
		)
	),
	"tx_vvreticker_votext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_votext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_vo:REQ:true',
	),

	"tx_vvreticker_np" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np.I.0", ""),
			),
		)
	),
	"tx_vvreticker_nptext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_nptext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_np:REQ:true',
	),

);


t3lib_div::loadTCA("tx_vvrecatalog_land");
t3lib_extMgm::addTCAcolumns("tx_vvrecatalog_land",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_vvrecatalog_land","tx_vvreticker_vo;;;;1-1-1, tx_vvreticker_votext,tx_vvreticker_np;;;;1-1-1, tx_vvreticker_nptext", '', 'after:ext_pub');
$TCA['tx_vvrecatalog_land']['ctrl']['requestUpdate'] .= ',tx_vvreticker_vo,tx_vvreticker_np';

$tempColumns = Array (
	"tx_vvreticker_vo" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_vo.I.0", ""),
			),
		)
	),
	"tx_vvreticker_votext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_votext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_vo:REQ:true',
	),

	"tx_vvreticker_np" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np",		
		"config" => Array (
			"type" => "check",
			"cols" => 1,
			"items" => Array (
				Array("LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_np.I.0", ""),
			),
		)
	),
	"tx_vvreticker_nptext" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_reticker/locallang_db.xml:tx_vvrecatalog_flat.tx_vvreticker_nptext",		
		"config" => Array (
			"type" => "text",
			"cols" => "30",	
			"rows" => "2",
		),
		'displayCond' => 'FIELD:tx_vvreticker_np:REQ:true',
	),

);


t3lib_div::loadTCA("tx_vvrecatalog_accommodation");
t3lib_extMgm::addTCAcolumns("tx_vvrecatalog_accommodation",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_vvrecatalog_accommodation","tx_vvreticker_vo;;;;1-1-1, tx_vvreticker_votext,tx_vvreticker_np;;;;1-1-1, tx_vvreticker_nptext", '', 'after:ext_pub');
$TCA['tx_vvrecatalog_accommodation']['ctrl']['requestUpdate'] .= ',tx_vvreticker_vo,tx_vvreticker_np';
?>