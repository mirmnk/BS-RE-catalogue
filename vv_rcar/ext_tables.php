<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE')	{
		
	t3lib_extMgm::addModule('user','txvvrcarM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}

$TCA["tx_vvrcar_apskritis"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_apskritis',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY title",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_vvrcar_apskritis.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, rcuid, title",
	)
);

$TCA["tx_vvrcar_rajonas"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_rajonas',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY rcuid",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_vvrcar_rajonas.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, rcuid, title, auid, rcauid",
	)
);

$TCA["tx_vvrcar_gyvenviete"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gyvenviete',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY ruid",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_vvrcar_gyvenviete.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, rcuid, title, ruid, rcruid",
	)
);

$TCA["tx_vvrcar_mikro_rajonas"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_vvrcar_mikro_rajonas.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, rcuid, title, guid, rcguid",
	)
);

$TCA["tx_vvrcar_mikro_rajonas2"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas2',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_vvrcar_mikro_rajonas.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, title, guid, rcguid",
	)
);


$TCA["tx_vvrcar_gatve"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY guid",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_vvrcar_gatve.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, rcuid, title, guid, rcguid",
	)
);

$tempColumns = Array (
	"apskritis" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_apskritis",		
		"config" => Array (
			"type" => "select",	
			"items" => Array (
				Array("",0),
			),
			"foreign_table" => "tx_vvrcar_apskritis",	
			"foreign_table_where" => " ORDER BY tx_vvrcar_apskritis.title",	
			"size" => 1,	
			"minitems" => 0,
			"maxitems" => 1,
			"ajax_select_update" => array(
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_rajonas',
					'db_foreign_field' => 'auid',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'rajonas'
				),
			),	
		)
	),
	"rajonas" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_rajonas",		
		"config" => Array (
			"type" => "select",	
			"items" => Array (
				Array("",0),
			),
			"foreign_table" => "tx_vvrcar_rajonas",	
			"foreign_table_where" => " AND tx_vvrcar_rajonas.auid= ###REC_FIELD_apskritis### ORDER BY tx_vvrcar_rajonas.title",	
			"size" => 1,	
			"minitems" => 0,
			"maxitems" => 1,
			"ajax_select_update" => array(
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_gyvenviete',
					'db_foreign_field' => 'ruid',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'gyvenviete'
				),
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_mikro_rajonas2',
					'db_foreign_field' => 'ruid',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'mikro_rajonas2' 
				),
			),	
		),
	), 
	"gyvenviete" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gyvenviete",		
		"config" => Array (
			"type" => "select",	
			"items" => Array (
				Array("",0),
			),
			"foreign_table" => "tx_vvrcar_gyvenviete",	
			"foreign_table_where" => " AND tx_vvrcar_gyvenviete.ruid= ###REC_FIELD_rajonas### ORDER BY tx_vvrcar_gyvenviete.title",	
			"size" => 1,	
			"minitems" => 0,
			"maxitems" => 1,
			"ajax_select_update" => array(
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_mikro_rajonas',
					'db_foreign_field' => 'guid',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'mikro_rajonas'
				),
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_gatve',
					'db_foreign_field' => 'guid',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'gatve'
				),
			),	
		),
	),
	"mikro_rajonas" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas",		
		"config" => Array (
			"type" => "select",	
			"items" => Array (
				Array("",0),
			),
			"foreign_table" => "tx_vvrcar_mikro_rajonas",	
			"foreign_table_where" => " AND tx_vvrcar_mikro_rajonas.guid= ###REC_FIELD_gyvenviete### ORDER BY tx_vvrcar_mikro_rajonas.title",
			"size" => 1,	
			"minitems" => 0,
			"maxitems" => 1,	
			"ajax_select_update" => array(
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_gatve',
					'db_local_table' => 'tx_vvrcar_mikro_rajonas',
					'db_mm_table' => 'tx_vvrcar_mikrorajonas_gatve_mm',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'gatve',
					'ifvalue' => '0',
					'negate' => 1
				),
				array(
					'ajax_server' => t3lib_extmgm::extRelPath('vv_rcar').'class.tx_vvrcar_ajaxserver.php',
					'db_foreign_table' => 'tx_vvrcar_gatve',
					'evalField' => 'gyvenviete',
					'db_foreign_field' => 'guid',
					'db_valueFieldName' => 'uid',
					'db_labelFieldName' => 'title',
					'update_field_name' => 'gatve',
					'ifvalue' => '0',
				),
			),	
		),
	),
	"mikro_rajonas2" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas2",		
		"config" => Array (
			"type" => "select",	
			"items" => Array (
				Array("",0),
			),
			"foreign_table" => "tx_vvrcar_mikro_rajonas2",	
			"foreign_table_where" => " AND tx_vvrcar_mikro_rajonas2.guid= ###REC_FIELD_gyvenviete### ORDER BY tx_vvrcar_mikro_rajonas2.title",
			"size" => 1,	
			"minitems" => 0,
			"maxitems" => 1,	
		),
	),
	
	"gatve" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve",		
		"config" => Array (
			"type" => "select",	
			"items" => Array (
				Array("",0),
			),
			"itemsProcFunc_conf" => array(
				"foreign_table" => "tx_vvrcar_gatve",	
				"foreign_table_where" => " AND tx_vvrcar_gatve.guid = ###REC_FIELD_gyvenviete### ORDER BY tx_vvrcar_gatve.title",
				"MM" => "tx_vvrcar_mikrorajonas_gatve_mm",
			),
			"itemsProcFunc" => 'EXT:vv_rcar/class.tx_vvrcar_hooks.php:&tx_vvrcar_hooks->user_process_gatve',	
			"size" => 1,	
			"minitems" => 0,
			"maxitems" => 1,
		),
	),
);

$tableName = "tx_vvrecatalog_flat";

t3lib_div::loadTCA($tableName);
t3lib_extMgm::addTCAcolumns($tableName,$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes($tableName,"apskritis;;;;1-1-1, rajonas,gyvenviete,mikro_rajonas,mikro_rajonas2,gatve", 0, 'after:price');


$tableName = "tx_vvrecatalog_land";

t3lib_div::loadTCA($tableName);
t3lib_extMgm::addTCAcolumns($tableName,$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes($tableName,"apskritis;;;;1-1-1, rajonas,gyvenviete,mikro_rajonas,mikro_rajonas2,gatve", 0, 'after:price');


$tableName = "tx_vvrecatalog_homestead";

t3lib_div::loadTCA($tableName);
t3lib_extMgm::addTCAcolumns($tableName,$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes($tableName,"apskritis;;;;1-1-1, rajonas,gyvenviete,mikro_rajonas,mikro_rajonas2,gatve", 0, 'after:price');


$tableName = "tx_vvrecatalog_house";

t3lib_div::loadTCA($tableName);
t3lib_extMgm::addTCAcolumns($tableName,$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes($tableName,"apskritis;;;;1-1-1, rajonas,gyvenviete,mikro_rajonas,mikro_rajonas2,gatve", 0, 'after:price');


$tableName = "tx_vvrecatalog_accommodation";

t3lib_div::loadTCA($tableName);
t3lib_extMgm::addTCAcolumns($tableName,$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes($tableName,"apskritis;;;;1-1-1, rajonas,gyvenviete,mikro_rajonas,mikro_rajonas2,gatve", 0, 'after:price');

?>