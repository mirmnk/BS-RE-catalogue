<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_vverrorer_logentry"] = Array (
	"ctrl" => $TCA["tx_vverrorer_logentry"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "hidden,fe_group,ip,type,entry"
	),
	"feInterface" => $TCA["tx_vverrorer_logentry"]["feInterface"],
	"columns" => Array (
		"hidden" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.xml:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"fe_group" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.xml:LGL.fe_group",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("", 0),
					Array("LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login", -1),
					Array("LLL:EXT:lang/locallang_general.xml:LGL.any_login", -2),
					Array("LLL:EXT:lang/locallang_general.xml:LGL.usergroups", "--div--")
				),
				"foreign_table" => "fe_groups"
			)
		),
		"ip" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:vv_errorer/locallang_db.xml:tx_vverrorer_logentry.ip",		
			"config" => Array (
				"type" => "input",	
				"size" => "15",	
				"max" => "15",
			)
		),
		"type" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:vv_errorer/locallang_db.xml:tx_vverrorer_logentry.type",		
			"config" => Array (
				"type" => "input",
				"size" => "4",
				"max" => "4",
				"eval" => "int",
				"checkbox" => "0",
				"range" => Array (
					"upper" => "1000",
					"lower" => "10"
				),
				"default" => 0
			)
		),
		"entry" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:vv_errorer/locallang_db.xml:tx_vverrorer_logentry.entry",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",	
				"rows" => "5",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, ip, type, entry")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "fe_group")
	)
);
?>