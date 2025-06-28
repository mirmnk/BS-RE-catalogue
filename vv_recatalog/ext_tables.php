<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_vvrecatalog_heating_type"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_heating_type",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"sortby" => "sorting",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_heating_type.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title, aruodas_title, edomus_title",
	)
);

$TCA["tx_vvrecatalog_land_pos"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_pos",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"sortby" => "sorting",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_land_pos.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title",
	)
);

$TCA["tx_vvrecatalog_city"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_city",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		'copyAfterDuplFields' => 'sys_language_uid',
        'useColumnsForDefaultValues' => 'sys_language_uid',
		"sortby" => "sorting",		
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_city.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title, aruodas_uid, 	aruodas_did, city24_city, city24_county",
	)
);

$TCA["tx_vvrecatalog_district"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_district",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY city",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_district.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, city,title,aruodas_uid, city24_val",
	)
);

$TCA["tx_vvrecatalog_building_type"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_building_type",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"sortby" => "sorting",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_building_type.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title, aruodas_title, edomus_title",
	)
);

$TCA["tx_vvrecatalog_land"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land",		
		"label" => "gid",	
		'label_alt'	=> 'action,price,gatve',
		'label_alt_force' => 1,	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY gid DESC",	
		"delete" => "deleted",	
		"dividers2tabs" => 1,
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		'label_userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->ntObjectLabel',
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_land.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, action, gid, price, city, district, street, land_type, land_area, land_pos, images, descr, employee",
	)
);

$TCA["tx_vvrecatalog_ac_type"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_ac_type",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"sortby" => "sorting",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_ac_type.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title",
	)
);

$TCA["tx_vvrecatalog_land_type"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_type",		
		"label" => "title",	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"sortby" => "sorting",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_land_type.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, title, city24_land_type",
	)
);

$TCA["tx_vvrecatalog_flat"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat",		
		"label" => "gid",	
		'label_alt'	=> 'action,price,gatve',
		'label_alt_force' => 1,	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"versioning" => "1",
		"thumbnail"  => "images",
		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
#		'setToDefaultOnCopy' => 'city',
		"dividers2tabs" => 1,
		"default_sortby" => "ORDER BY gid DESC",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		'label_userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->ntObjectLabel',
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_flat.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, action, gid, price, city, district, street, building_type, bdate, heating_type, area, images, roomcount, floor, floorcount, descr, employee",
	)
);

$TCA["tx_vvrecatalog_homestead"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead",		
		"label" => "gid",	
		'label_alt'	=> 'action,price,gatve',
		'label_alt_force' => 1,	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY gid",	
		"delete" => "deleted",	
		"dividers2tabs" => 1,
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		'label_userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->ntObjectLabel',
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_homestead.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, action, gid, price, city, district, street, building_type, bdate, heating_type, area, roomcount, land_type, land_pos, floorcount, images,descr, land_area, employee",
	)
);

$TCA["tx_vvrecatalog_house"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house",		
		"label" => "gid",	
		'label_alt'	=> 'action,price,gatve',
		'label_alt_force' => 1,	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"versioning" => "1",	
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY gid",	
		"delete" => "deleted",	
		"dividers2tabs" => 1,
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",
		),
		'label_userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->ntObjectLabel',
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_house.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, action, gid, price, city, district, street, images, roomcount, building_type, bdate, heating_type, area, floorcount, land_area, land_type, land_pos, descr, employee",
	)
);

$TCA["tx_vvrecatalog_accommodation"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation",		
		"label" => "gid",	
		'label_alt'	=> 'action,price,gatve',
		'label_alt_force' => 1,	
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"versioning" => "1",	
		"languageField" => "sys_language_uid",	
		"transOrigPointerField" => "l18n_parent",	
		"transOrigDiffSourceField" => "l18n_diffsource",	
		"default_sortby" => "ORDER BY gid",	
		"delete" => "deleted",	
		"dividers2tabs" => 1,
		"enablecolumns" => Array (		
			"disabled" => "hidden",	
			"starttime" => "starttime",	
			"endtime" => "endtime",	
			"fe_group" => "fe_group",
		),
		'label_userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->ntObjectLabel',
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_vvrecatalog_accommodation.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, action, gid, price, city, district, street, building_type, bdate, heating_type, area, roomcount, floorcount, images, descr, ac_type, floor, employee",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';

t3lib_extMgm::addPlugin(Array('LLL:EXT:vv_recatalog/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');

t3lib_extMgm::addStaticFile($_EXTKEY,'pi1/static/','RE catalog');


if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_vvrecatalog_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_vvrecatalog_pi1_wizicon.php';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] ='pi_flexform'; 
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:vv_recatalog/flexform_ds_pi1.xml');

if (TYPO3_MODE == 'BE')    {      
    t3lib_extMgm::addModule('user','txvvrecatalogM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}


?>