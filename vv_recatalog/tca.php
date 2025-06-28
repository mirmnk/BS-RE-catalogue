<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
if (TYPO3_MODE=="BE") include_once(t3lib_extMgm::extPath('vv_recatalog').'pi1/class.tx_vvrecatalog_utils.php');

$TCA["tx_vvrecatalog_heating_type"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_heating_type"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_heating_type"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_heating_type',
				'foreign_table_where' => 'AND tx_vvrecatalog_heating_type.pid=###CURRENT_PID### AND tx_vvrecatalog_heating_type.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_heating_type.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"aruodas_title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_heating_type.aruodas_title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"edomus_title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_heating_type.edomus_title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"domoplius_id" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",			
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_heating_type.domoplius_id",		
			"config" => Array (
				"type" => "input",	
				"size" => "5",	
				"eval" => "trim",
			)
		),
		
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, aruodas_title;;;;2-2-2, edomus_title;;;;2-2-2,domoplius_id")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);

$TCA["tx_vvrecatalog_land_pos"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_land_pos"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_land_pos"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_land_pos',
				'foreign_table_where' => 'AND tx_vvrecatalog_land_pos.pid=###CURRENT_PID### AND tx_vvrecatalog_land_pos.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_pos.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"edomus_title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_pos.edomus_title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2,edomus_title")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_vvrecatalog_city"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_city"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_city"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_city',
				'foreign_table_where' => 'AND tx_vvrecatalog_city.pid=###CURRENT_PID### AND tx_vvrecatalog_city.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_city.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"aruodas_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_city.aruodas_uid",		
			"config" => Array (
				"type" => "input",	
				"size" => "3",	
				"eval" => "int,trim",
			)
		),
		"aruodas_did" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_city.aruodas_did",		
			"config" => Array (
				"type" => "input",	
				"size" => "3",	
				"eval" => "int,trim",
			)
		),
		"city24_city" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_city.city24_city",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"city24_county" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_city.city24_county",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, aruodas_uid;;;;2-2-2, aruodas_did;;;;2-2-2, city24_city;;;;2-2-2, city24_county;;;;2-2-2")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_vvrecatalog_district"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_district"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,city,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_district"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_district',
				'foreign_table_where' => 'AND tx_vvrecatalog_district.pid=###CURRENT_PID### AND tx_vvrecatalog_district.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"city" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_district.city",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_city",	
				"foreign_table_where" => "AND tx_vvrecatalog_city.pid=###CURRENT_PID### ORDER BY tx_vvrecatalog_city.sorting",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_city",
							"pid" => "###CURRENT_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			),
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_district.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"aruodas_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_district.aruodas_uid",		
			"config" => Array (
				"type" => "input",	
				"size" => "3",	
				"eval" => "int,trim",
			)
		),
		"city24_val" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_district.city24_val",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),	
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, city,title;;;;2-2-2,aruodas_uid;;;;2-2-2,city24_val;;;;2-2-2")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_vvrecatalog_building_type"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_building_type"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_building_type"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_building_type',
				'foreign_table_where' => 'AND tx_vvrecatalog_building_type.pid=###CURRENT_PID### AND tx_vvrecatalog_building_type.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_building_type.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"aruodas_title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_building_type.aruodas_title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"edomus_title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_building_type.edomus_title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"domoplius_id" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",			
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_building_type.domoplius_id",		
			"config" => Array (
				"type" => "input",	
				"size" => "5",	
				"eval" => "trim",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, aruodas_title;;;;2-2-2, edomus_title;;;;2-2-2,domoplius_id")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);





$TCA["tx_vvrecatalog_land"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_land"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,action,gid,price,city,district,street,land_type,land_area,land_pos,images,descr,employee"
	),
	"feInterface" => $TCA["tx_vvrecatalog_land"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_land',
				'foreign_table_where' => 'AND tx_vvrecatalog_land.pid=###CURRENT_PID### AND tx_vvrecatalog_land.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"action" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.action",		
			"config" => Array (
				"type" => "radio",
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.action.I.1", "1"),
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.action.I.2", "2"),
				),
			)
		),
	   "ext_pub" => Array (        
	        "exclude" => 1,        
	        "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub",        
	        "config" => Array (
	            "type" => "check",
	            "cols" => 1,
	            "items" => Array (
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.0", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.1", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.2", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.3", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.4", ""),
	            ),
	        )
	    ),
		"gid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.gid",		
			"config" => Array (
				"type" => "none",
				"pass_content" => 1,
			)
		),
		"price" => Array (		
			"exclude" => 1,		
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.price",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,double2,nospace",
			)
		),
		'price_eur' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.price_eur",
			'config' => Array (
				'type' => 'user',
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showPriceInCurrency',
			)
		),
		"city" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.city",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_city",	
				"foreign_table_where" => "AND tx_vvrecatalog_city.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_city.sorting",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_city",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"district" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.district",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_district",	
				"foreign_table_where" => "AND tx_vvrecatalog_district.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_district.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_district",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"street" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.street",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"objnumber" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.number",		
			"config" => Array (
				"type" => "input",	
				"size" => "8",	
				"eval" => "trim",
			)
		),
		"land_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.land_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_land_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_land_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_land_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_land_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"land_pos" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.land_pos",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_land_pos",	
				"foreign_table_where" => "AND tx_vvrecatalog_land_pos.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_land_pos.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_land_pos",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"land_area" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.land_area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"images" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.images",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_vvrecatalog",
				"show_thumbs" => 1,	
				"size" => 6,	
				"minitems" => 0,
				"maxitems" => 6,
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.descr",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"employee" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.employee",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tt_address",	
				"foreign_table_where" => "AND tt_address.pid=###STORAGE_PID### ORDER BY tt_address.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tt_address",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"special" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_land_special_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_land_special_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_land_special_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_land_special_I_8"),
				),
			)
		),
		"com_sys" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_com_sys_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_com_sys_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_6"),
				),
			)
		),
		"domoplius_id" => Array (        
            "exclude" => 1,
			"l10n_display" => "defaultAsReadonly",        
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_id",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 1,
		    )
	    ),
		"domoplius_status" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_status",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 10,
		    )
	    ),
		"domoplius_url" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
	    	'displayCond' => 'FIELD:domoplius_id:REQ:true',
            "label" => "Domoplius.lt URL",        
            "config" => Array (
	            "type" => "user",
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showDomopliusURL',
		    )
	    ),
	),
	"types" => Array (
		"0" => Array("showitem" => "l18n_diffsource, hidden;;1, action, gid, price, price_eur, objnumber, land_type;;;;1-1-1, land_area, land_pos, images;;;;1-1-1, descr;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_vvrecatalog/rte/], employee, --div--;LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label, special, com_sys,--div--;LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.settings_tab, ext_pub;;;;1-1-1, --div--;LLL:EXT:vv_recatalog/locallang_db.xml:tt_content.tx_vvrecatalog.tab.domoplius.title, domoplius_id, domoplius_status,domoplius_url")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group, sys_language_uid, l18n_parent")
	)
);



$TCA["tx_vvrecatalog_ac_type"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_ac_type"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_ac_type"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_ac_type',
				'foreign_table_where' => 'AND tx_vvrecatalog_ac_type.pid=###CURRENT_PID### AND tx_vvrecatalog_ac_type.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_ac_type.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"edomus_title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_ac_type.edomus_title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"domoplius_id" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",			
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_ac_type.domoplius_id",		
			"config" => Array (
				"type" => "input",	
				"size" => "5",	
				"eval" => "trim",
			)
		),
	
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2,edomus_title,domoplius_id")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_vvrecatalog_land_type"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_land_type"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,title"
	),
	"feInterface" => $TCA["tx_vvrecatalog_land_type"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_land_type',
				'foreign_table_where' => 'AND tx_vvrecatalog_land_type.pid=###CURRENT_PID### AND tx_vvrecatalog_land_type.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_type.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"city24_land_type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_type.city24_land_type",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"edomus_land_type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_type.edomus_land_type",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"domoplius_id" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",			
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land_type.domoplius_id",		
			"config" => Array (
				"type" => "input",	
				"size" => "5",	
				"eval" => "trim",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, city24_land_type,edomus_land_type,domoplius_id")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_vvrecatalog_flat"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_flat"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,action,gid,price,city,district,street,building_type,bdate,heating_type,area,images,roomcount,floor,floorcount,descr,employee"
	),
	"feInterface" => $TCA["tx_vvrecatalog_flat"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'type' => 'passthrough',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_flat',
				'foreign_table_where' => 'AND tx_vvrecatalog_flat.pid=###CURRENT_PID### AND tx_vvrecatalog_flat.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"action" => Array (		
			"exclude" => 1,	
#			"l10n_mode" => "mergeIfNotBlank",
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.action",		
			"config" => Array (
				"type" => "radio",
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.action.I.1", "1"),
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.action.I.2", "2"),
				),
				"eval" => "required",
			)
		),
	   "ext_pub" => Array (        
	        "exclude" => 1,        
	        "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub",        
	        "config" => Array (
	            "type" => "check",
	            "cols" => 1,
	            "items" => Array (
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.0", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.1", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.2", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.3", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.4", ""),
	            ),
	        )
	    ),
		"gid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.gid",		
			"config" => Array (
				"type" => "none",
				"pass_content" => 1,
			)
		),
		"price" => Array (		
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.price",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,double2,nospace",
			)
		),
		'price_eur' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.price_eur",
			'config' => Array (
				'type' => 'user',
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showPriceInCurrency',
			)
		),
		"city" => Array (		
			"exclude" => 1,		
#			"l10n_mode" => "mergeIfNotBlank",
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.city",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_city",	
				"foreign_table_where" => "AND tx_vvrecatalog_city.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_city.sorting",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_city",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"district" => Array (		
			"exclude" => 1,		
#			"l10n_mode" => "mergeIfNotBlank",
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.district",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_district",	
				"foreign_table_where" => "AND tx_vvrecatalog_district.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_district.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_district",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"street" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.street",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"objnumber" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.number",		
			"config" => Array (
				"type" => "input",	
				"size" => "8",	
				"eval" => "trim",
			)
		),
		"building_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.building_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_building_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_building_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_building_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_building_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"bdate" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.bdate",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"heating_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.heating_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_heating_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_heating_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_heating_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_heating_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"area" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"images" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.images",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_vvrecatalog",
				"show_thumbs" => 1,	
				"size" => 6,	
				"minitems" => 0,
				"maxitems" => 6,
			)
		),
		"roomcount" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.roomcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "required,int",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"floor" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.floor",		
			"config" => Array (
				"type" => "input",
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "required,int",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"floorcount" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.floorcount",		
			"config" => Array (
				"type" => "input",
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "required,int",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.descr",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"employee" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.employee",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tt_address",	
				"foreign_table_where" => "AND tt_address.pid=###STORAGE_PID### ORDER BY tt_address.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tt_address",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"installation" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_4", 4),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_5", 5),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_6", 6),
				),
			)
		),
		"state" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_4", 4),
				),
			)
		),
		"special" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_8"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_9"),
				),
			)
		),
		"facilities" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_8"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_9"),
				),
			)
		),
		"equipment" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_8"),
				),
			)
		),
		"com_sys" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_2"),
				),
			)
		),
		"security" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_4"),
				),
			)
		),
		"domoplius_id" => Array (        
            "exclude" => 1,
			"l10n_display" => "defaultAsReadonly",        
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_id",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 1,
		    )
	    ),
		"domoplius_status" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_status",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 10,
		    )
	    ),
		"domoplius_url" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
	    	'displayCond' => 'FIELD:domoplius_id:REQ:true',
            "label" => "Domoplius.lt URL",        
            "config" => Array (
	            "type" => "user",
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showDomopliusURL',
		    )
	    ),
	),
	"types" => Array (
		"0" => Array("showitem" => "l18n_diffsource, hidden;;1, action, gid, price, price_eur, objnumber, building_type;;;;1-1-1, bdate, heating_type, installation;;;;1-1-1, state, area;;;;1-1-1, roomcount, floor, floorcount, images;;;;1-1-1, descr;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_vvrecatalog/rte/], employee, --div--;LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label, special,facilities,equipment, com_sys,security, --div--;LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.settings_tab, ext_pub;;;;1-1-1, --div--;LLL:EXT:vv_recatalog/locallang_db.xml:tt_content.tx_vvrecatalog.tab.domoplius.title, domoplius_id, domoplius_status,domoplius_url ")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group,sys_language_uid, l18n_parent")
	)
);



$TCA["tx_vvrecatalog_homestead"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_homestead"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,action,gid,price,city,district,street,building_type,bdate,heating_type,area,roomcount,land_type,land_pos,floorcount,images,descr,land_area,employee"
	),
	"feInterface" => $TCA["tx_vvrecatalog_homestead"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_homestead',
				'foreign_table_where' => 'AND tx_vvrecatalog_homestead.pid=###CURRENT_PID### AND tx_vvrecatalog_homestead.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"action" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.action",		
			"config" => Array (
				"type" => "radio",
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.action.I.1", "1"),
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.action.I.2", "2"),
				),
			)
		),
	   "ext_pub" => Array (        
	        "exclude" => 1,        
	        "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub",        
	        "config" => Array (
	            "type" => "check",
	            "cols" => 1,
	            "items" => Array (
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.0", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.1", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.2", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.3", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.4", ""),
	            ),
	        )
	    ),
		"gid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.gid",		
			"config" => Array (
				"type" => "none",
				"pass_content" => 1,
			)
		),
		"price" => Array (		
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.price",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,double2,nospace",
			)
		),
		'price_eur' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.price_eur",
			'config' => Array (
				'type' => 'user',
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showPriceInCurrency',
			)
		),
		"city" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.city",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_city",	
				"foreign_table_where" => "AND tx_vvrecatalog_city.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_city.sorting",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_city",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"district" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.district",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_district",	
				"foreign_table_where" => "AND tx_vvrecatalog_district.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_district.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_district",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"street" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.street",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"objnumber" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.number",		
			"config" => Array (
				"type" => "input",	
				"size" => "8",	
				"eval" => "trim",
			)
		),
		"building_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.building_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_building_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_building_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_building_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_building_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"bdate" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.bdate",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"heating_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.heating_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_heating_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_heating_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_heating_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_heating_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"area" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"roomcount" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.roomcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"land_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.land_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_land_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_land_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_land_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_land_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"land_pos" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.land_pos",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_land_pos",	
				"foreign_table_where" => "AND tx_vvrecatalog_land_pos.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_land_pos.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_land_pos",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"floorcount" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.floorcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.descr",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"land_area" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.land_area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"images" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.images",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_vvrecatalog",
				"show_thumbs" => 1,	
				"size" => 6,	
				"minitems" => 0,
				"maxitems" => 6,
			)
		),
		"employee" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_homestead.employee",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tt_address",	
				"foreign_table_where" => "AND tt_address.pid=###STORAGE_PID### ORDER BY tt_address.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tt_address",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"installation" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_4", 4),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_5", 5),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_6", 6),
				),
			)
		),
		"state" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_4", 4),
				),
			)
		),
		"special" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_5"),
				),
			)
		),
		"facilities" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_8"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_5"),
				),
			)
		),
		"equipment" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_equipment_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_equipment_I_6"),
				),
			)
		),
		"com_sys" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_2"),
				),
			)
		),
		"security" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_security_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_3"),
				),
			)
		),
		"domoplius_id" => Array (        
            "exclude" => 1,
			"l10n_display" => "defaultAsReadonly",        
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_id",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 1,
		    )
	    ),
		"domoplius_status" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_status",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 10,
		    )
	    ),
		"domoplius_url" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
	    	'displayCond' => 'FIELD:domoplius_id:REQ:true',
            "label" => "Domoplius.lt URL",        
            "config" => Array (
	            "type" => "user",
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showDomopliusURL',
		    )
	    ),	
	),
	"types" => Array (
		"0" => Array("showitem" => "l18n_diffsource, hidden;;1, action, gid, price, price_eur, objnumber, building_type;;;;1-1-1, bdate, heating_type, installation;;;;1-1-1, state, area;;;;1-1-1, roomcount, land_type, land_pos, floorcount, images;;;;1-1-1,descr;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_vvrecatalog/rte/], land_area, employee, --div--;LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label, special, facilities,equipment,com_sys,security,--div--;LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.settings_tab, ext_pub;;;;1-1-1, --div--;LLL:EXT:vv_recatalog/locallang_db.xml:tt_content.tx_vvrecatalog.tab.domoplius.title, domoplius_id, domoplius_status,domoplius_url")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group, sys_language_uid, l18n_parent")
	)
);



$TCA["tx_vvrecatalog_house"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_house"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,action,gid,price,city,district,street,images,roomcount,building_type,bdate,heating_type,area,floorcount,land_area,land_type,land_pos,descr,employee"
	),
	"feInterface" => $TCA["tx_vvrecatalog_house"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_house',
				'foreign_table_where' => 'AND tx_vvrecatalog_house.pid=###CURRENT_PID### AND tx_vvrecatalog_house.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"action" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.action",		
			"config" => Array (
				"type" => "radio",
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.action.I.1", "1"),
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.action.I.2", "2"),
				),
			)
		),
	   "ext_pub" => Array (        
	        "exclude" => 1,        
	        "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub",        
	        "config" => Array (
	            "type" => "check",
	            "cols" => 1,
	            "items" => Array (
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.0", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.1", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.2", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.3", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.4", ""),
	            ),
	        )
	    ),
		"gid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.gid",		
			"config" => Array (
				"type" => "none",
				"pass_content" => 1,
			)
		),
		"price" => Array (		
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.price",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,double2,nospace",
			)
		),
		'price_eur' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.price_eur",
			'config' => Array (
				'type' => 'user',
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showPriceInCurrency',
			)
		),
		"city" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.city",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_city",	
				"foreign_table_where" => "AND tx_vvrecatalog_city.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_city.sorting",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_city",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"district" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.district",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_district",	
				"foreign_table_where" => "AND tx_vvrecatalog_district.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_district.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_district",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"street" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.street",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"objnumber" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.number",		
			"config" => Array (
				"type" => "input",	
				"size" => "8",	
				"eval" => "trim",
			)
		),
		"images" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.images",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_vvrecatalog",
				"show_thumbs" => 1,	
				"size" => 6,	
				"minitems" => 0,
				"maxitems" => 6,
			)
		),
		"roomcount" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.roomcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"building_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.building_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_building_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_building_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_building_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_building_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"bdate" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.bdate",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"heating_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.heating_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_heating_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_heating_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_heating_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_heating_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"area" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"floorcount" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.floorcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"land_area" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.land_area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"land_type" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.land_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_land_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_land_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_land_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_land_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"land_pos" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.land_pos",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_land_pos",	
				"foreign_table_where" => "AND tx_vvrecatalog_land_pos.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_land_pos.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_land_pos",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.descr",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"employee" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_house.employee",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tt_address",	
				"foreign_table_where" => "AND tt_address.pid=###STORAGE_PID### ORDER BY tt_address.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tt_address",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"installation" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_4", 4),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_5", 5),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_6", 6),
				),
			)
		),
		"state" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_4", 4),
				),
			)
		),
		"special" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_5"),
				),
			)
		),
		"facilities" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_8"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_5"),
				),
			)
		),
		"equipment" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_equipment_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_equipment_I_6"),
				),
			)
		),
		"com_sys" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_2"),
				),
			)
		),
		"security" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_security_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_3"),
				),
			)
		),
		"domoplius_id" => Array (        
            "exclude" => 1,
			"l10n_display" => "defaultAsReadonly",        
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_id",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 1,
		    )
	    ),
		"domoplius_status" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_status",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 10,
		    )
	    ),
		"domoplius_url" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
	    	'displayCond' => 'FIELD:domoplius_id:REQ:true',
            "label" => "Domoplius.lt URL",        
            "config" => Array (
	            "type" => "user",
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showDomopliusURL',
		    )
	    ),	
		
	),
	"types" => Array (
		"0" => Array("showitem" => "l18n_diffsource, hidden;;1, action, gid, price, price_eur, objnumber, roomcount;;;;1-1-1, floorcount, building_type, bdate, heating_type,installation;;;;1-1-1, state, area;;;;1-1-1, land_area, land_type,land_pos, images;;;;1-1-1, descr;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_vvrecatalog/rte/], employee, --div--;LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label, special,facilities, equipment,com_sys,security,--div--;LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.settings_tab, ext_pub;;;;1-1-1, --div--;LLL:EXT:vv_recatalog/locallang_db.xml:tt_content.tx_vvrecatalog.tab.domoplius.title, domoplius_id, domoplius_status,domoplius_url")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime,sys_language_uid, l18n_parent")
	)
);



$TCA["tx_vvrecatalog_accommodation"] = Array (
	"ctrl" => $TCA["tx_vvrecatalog_accommodation"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,action,gid,price,city,district,street,building_type,bdate,heating_type,area,roomcount,floorcount,images,descr,ac_type,floor,employee"
	),
	"feInterface" => $TCA["tx_vvrecatalog_accommodation"]["feInterface"],
	"columns" => Array (
		'sys_language_uid' => Array (		
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_vvrecatalog_accommodation',
				'foreign_table_where' => 'AND tx_vvrecatalog_accommodation.pid=###CURRENT_PID### AND tx_vvrecatalog_accommodation.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (		
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"endtime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.php:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.php:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.php:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"action" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.action",		
			"config" => Array (
				"type" => "radio",
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.action.I.1", "1"),
					Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.action.I.2", "2"),
				),
			)
		),
	   "ext_pub" => Array (        
	        "exclude" => 1,        
	        "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub",        
	        "config" => Array (
	            "type" => "check",
	            "cols" => 1,
	            "items" => Array (
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.0", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.1", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.2", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.3", ""),
	                Array("LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.ext_pub.I.4", ""),
	            ),
	        )
	    ),
		"gid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.gid",		
			"config" => Array (
				"type" => "none",
				"pass_content" => 1,
			)
		),
		"price" => Array (		
			'displayCond' => 'FIELD:sys_language_uid:=:0',
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.price",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,double2,nospace",
			)
		),
		'price_eur' => Array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.price_eur",
			'config' => Array (
				'type' => 'user',
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showPriceInCurrency',
			)
		),
		"city" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.city",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_city",	
				"foreign_table_where" => "AND tx_vvrecatalog_city.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_city.sorting",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_city",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"district" => Array (		
			"exclude" => 1,		
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.district",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_district",	
				"foreign_table_where" => "AND tx_vvrecatalog_district.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_district.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_district",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"street" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.street",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "trim",
			)
		),
		"building_type" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.building_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_building_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_building_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_building_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_building_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"bdate" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.bdate",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"heating_type" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.heating_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_heating_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_heating_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_heating_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_heating_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"area" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.area",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"eval" => "required,double2,nospace",
			)
		),
		"roomcount" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.roomcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"floorcount" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.floorcount",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"images" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_land.images",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_vvrecatalog",
				"show_thumbs" => 1,	
				"size" => 6,	
				"minitems" => 0,
				"maxitems" => 6,
			)
		),
		"descr" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.descr",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					"RTE" => Array(
						"notNewRecords" => 1,
						"RTEonly" => 1,
						"type" => "script",
						"title" => "Full screen Rich Text Editing|Formatteret redigering i hele vinduet",
						"icon" => "wizard_rte2.gif",
						"script" => "wizard_rte.php",
					),
				),
			)
		),
		"ac_type" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.ac_type",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tx_vvrecatalog_ac_type",	
				"foreign_table_where" => "AND tx_vvrecatalog_ac_type.pid=###STORAGE_PID### ORDER BY tx_vvrecatalog_ac_type.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_vvrecatalog_ac_type",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"floor" => Array (		
			"exclude" => 1,	
			"l10n_display" => "defaultAsReadonly",	
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.floor",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "required,int",
				"range" => Array (
					"upper" => "1000",
					"lower" => "1"
				),
			)
		),
		"employee" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_accommodation.employee",		
			"config" => Array (
				"type" => "select",	
				"items" => Array (
					Array("",0),
				),
				"itemsProcFunc" => "tx_vvrecatalog_utils->user_selproc",
				"foreign_table" => "tt_address",	
				"foreign_table_where" => "AND tt_address.pid=###STORAGE_PID### ORDER BY tt_address.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tt_address",
							"pid" => "###STORAGE_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"installation" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_4", 4),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_5", 5),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_installation_I_6", 6),
				),
			)
		),
		"state" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_label",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_1", 1),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_2", 2),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_3", 3),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_state_I_4", 4),
				),
			)
		),
		"special" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_special_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_special_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_special_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_special_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_special_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_special_I_7"),
				),
			)
		),
		"facilities" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_4"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_facilities_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_facilities_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_facilities_I_9"),
				),
			)
		),
		"equipment" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_7"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_equipment_I_8"),
				),
			)
		),
		"com_sys" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_com_sys_I_3"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_com_sys_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_accomodation_com_sys_I_6"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_com_sys_I_1"),
				),
			)
		),
		"security" => Array (		
			"exclude" => 1,
			"l10n_display" => "defaultAsReadonly",
			"label" => "LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_label",
			"config" => Array (
				"type" => "check",
				"cols" => 3,
				"items" => Array (
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_house_security_I_5"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_0"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_1"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_2"),
					Array("LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_security_I_3"),
				),
			)
		),
		"domoplius_id" => Array (        
            "exclude" => 1,
			"l10n_display" => "defaultAsReadonly",        
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_id",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 1,
		    )
	    ),
		"domoplius_status" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
            "label" => "LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat_domoplius_status",        
            "config" => Array (
	            "type" => "none",
				"pass_content" => 1,
				"rows" => 10,
		    )
	    ),
		"domoplius_url" => Array (        
            "exclude" => 1,        
			"l10n_display" => "defaultAsReadonly",
	    	'displayCond' => 'FIELD:domoplius_id:REQ:true',
            "label" => "Domoplius.lt URL",        
            "config" => Array (
	            "type" => "user",
				'userFunc' => 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm->showDomopliusURL',
		    )
	    ),	
	),
	"types" => Array (
		"0" => Array("showitem" => "l18n_diffsource, hidden;;1, action, gid, price, price_eur, building_type;;;;1-1-1, bdate, heating_type,ac_type,installation;;;;1-1-1, state, area;;;;1-1-1, roomcount, floorcount, floor,images;;;;1-1-1,descr;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_vvrecatalog/rte/], employee, --div--;LLL:EXT:vv_recatalog/pi1/locallang.xml:tx_vvrecatalog_flat_special_label, special,facilities, com_sys,security,--div--;LLL:EXT:vv_recatalog/locallang_db.xml:tx_vvrecatalog_flat.settings_tab, ext_pub;;;;1-1-1, --div--;LLL:EXT:vv_recatalog/locallang_db.xml:tt_content.tx_vvrecatalog.tab.domoplius.title, domoplius_id, domoplius_status,domoplius_url")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime, fe_group, sys_language_uid, l18n_parent")
	)
);
?>