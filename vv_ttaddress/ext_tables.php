<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"tx_vvttaddress_logo" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:vv_ttaddress/locallang_db.xml:tt_address.tx_vvttaddress_logo",		
		"config" => Array (
			"type" => "group",
			"internal_type" => "file",
			"allowed" => "gif,png,jpeg,jpg",	
			"max_size" => 150,	
			"uploadfolder" => "uploads/tx_vvttaddress",
			"show_thumbs" => 1,	
			"size" => 2,	
			"minitems" => 0,
			"maxitems" => 1,
		)
	),
	"tx_vvttaddress_dpregistered" => Array (		
		"exclude" => 1,
		"l10n_display" => "defaultAsReadonly",
		"label" => "LLL:EXT:vv_ttaddress/locallang_db.xml:tt_address.tx_vvttaddress_dpregistered",
		"config" => Array (
			"type" => "check",
			"items" => Array (
				Array("LLL:EXT:vv_ttaddress/locallang_db.xml:tt_address.tx_vvttaddress_dpregistered_yes"),
			),
		)
	),
	
);


t3lib_div::loadTCA("tt_address");
t3lib_extMgm::addTCAcolumns("tt_address",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tt_address","tx_vvttaddress_logo,tx_vvttaddress_dpregistered;;;;1-1-1",0,'after:image');
?>