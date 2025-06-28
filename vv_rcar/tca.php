<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_vvrcar_apskritis"] = array (
	"ctrl" => $TCA["tx_vvrcar_apskritis"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,rcuid,title"
	),
	"feInterface" => $TCA["tx_vvrcar_apskritis"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_vvrcar_apskritis',
				'foreign_table_where' => 'AND tx_vvrcar_apskritis.pid=###CURRENT_PID### AND tx_vvrcar_apskritis.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"rcuid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_apskritis.rcuid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_apskritis.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, rcuid, title;;;;2-2-2")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_vvrcar_rajonas"] = array (
	"ctrl" => $TCA["tx_vvrcar_rajonas"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,rcuid,title,auid,rcauid"
	),
	"feInterface" => $TCA["tx_vvrcar_rajonas"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_vvrcar_rajonas',
				'foreign_table_where' => 'AND tx_vvrcar_rajonas.pid=###CURRENT_PID### AND tx_vvrcar_rajonas.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"rcuid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_rajonas.rcuid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_rajonas.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"auid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_rajonas.auid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"rcauid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_rajonas.rcauid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, rcuid, title;;;;2-2-2, auid;;;;3-3-3, rcauid")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_vvrcar_gyvenviete"] = array (
	"ctrl" => $TCA["tx_vvrcar_gyvenviete"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,rcuid,title,ruid,rcruid"
	),
	"feInterface" => $TCA["tx_vvrcar_gyvenviete"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_vvrcar_gyvenviete',
				'foreign_table_where' => 'AND tx_vvrcar_gyvenviete.pid=###CURRENT_PID### AND tx_vvrcar_gyvenviete.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"rcuid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gyvenviete.rcuid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gyvenviete.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"ruid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gyvenviete.ruid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"rcruid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gyvenviete.rcruid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, rcuid, title;;;;2-2-2, ruid;;;;3-3-3, rcruid")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_vvrcar_mikro_rajonas"] = array (
	"ctrl" => $TCA["tx_vvrcar_mikro_rajonas"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,rcuid,title,guid,rcguid"
	),
	"feInterface" => $TCA["tx_vvrcar_mikro_rajonas"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_vvrcar_mikro_rajonas',
				'foreign_table_where' => 'AND tx_vvrcar_mikro_rajonas.pid=###CURRENT_PID### AND tx_vvrcar_mikro_rajonas.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"rcuid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.rcuid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"guid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.guid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"rcguid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.rcguid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, rcuid, title;;;;2-2-2, guid;;;;3-3-3, rcguid")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);


$TCA["tx_vvrcar_mikro_rajonas2"] = array (
	"ctrl" => $TCA["tx_vvrcar_mikro_rajonas2"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,title,guid,rcguid"
	),
	"feInterface" => $TCA["tx_vvrcar_mikro_rajonas2"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_vvrcar_mikro_rajonas',
				'foreign_table_where' => 'AND tx_vvrcar_mikro_rajonas.pid=###CURRENT_PID### AND tx_vvrcar_mikro_rajonas.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"guid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.guid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"rcguid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_mikro_rajonas.rcguid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, guid;;;;3-3-3, rcguid")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_vvrcar_gatve"] = array (
	"ctrl" => $TCA["tx_vvrcar_gatve"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,rcuid,title,guid,rcguid"
	),
	"feInterface" => $TCA["tx_vvrcar_gatve"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_vvrcar_gatve',
				'foreign_table_where' => 'AND tx_vvrcar_gatve.pid=###CURRENT_PID### AND tx_vvrcar_gatve.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"rcuid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve.rcuid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"guid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve.guid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"rcguid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve.rcguid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"muid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve.muid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
		"rcmuid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:vv_rcar/locallang_db.xml:tx_vvrcar_gatve.rcmuid",		
			"config" => Array (
				"type"     => "input",
				"size"     => "6",
				"max"      => "6",
				"eval"     => "int",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, rcuid, title;;;;2-2-2, muid;;;;3-3-3, rcmuid, guid;;;;3-3-3, rcguid")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>