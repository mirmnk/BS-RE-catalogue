<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_vverrorer_logentry"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:vv_errorer/locallang_db.xml:tx_vverrorer_logentry',		
		'label' => 'uid',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		"default_sortby" => "ORDER BY crdate DESC",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vverrorer_logentry.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, fe_group, ip, type, entry",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';

t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:vv_errorer/flexform_ds.xml');


t3lib_extMgm::addPlugin(Array('LLL:EXT:vv_errorer/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');
?>