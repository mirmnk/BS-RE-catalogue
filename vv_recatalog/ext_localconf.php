<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_heating_type=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_land_pos=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_city=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_district=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_building_type=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_land=1
');
t3lib_extMgm::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_vvrecatalog_land", field "descr"
	# ***************************************************************************************
RTE.config.tx_vvrecatalog_land.descr {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_ac_type=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_land_type=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_flat=1
');
t3lib_extMgm::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_vvrecatalog_flat", field "descr"
	# ***************************************************************************************
RTE.config.tx_vvrecatalog_flat.descr {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_homestead=1
');
t3lib_extMgm::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_vvrecatalog_homestead", field "descr"
	# ***************************************************************************************
RTE.config.tx_vvrecatalog_homestead.descr {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_house=1
');
t3lib_extMgm::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_vvrecatalog_house", field "descr"
	# ***************************************************************************************
RTE.config.tx_vvrecatalog_house.descr {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrecatalog_accommodation=1
');
t3lib_extMgm::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_vvrecatalog_accommodation", field "descr"
	# ***************************************************************************************
RTE.config.tx_vvrecatalog_accommodation.descr {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');

  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY,'editorcfg','
	tt_content.CSS_editor.ch.tx_vvrecatalog_pi1 = < plugin.tx_vvrecatalog_pi1.CSS_editor
',43);


$TYPO3_CONF_VARS['EXTCONF']['cms']['db_layout']['addTables']['tx_vvrecatalog_flat'][0] = array(
    'fList' => 'gid',
    'icon' => TRUE
);

$TYPO3_CONF_VARS['EXTCONF']['cms']['db_layout']['addTables']['tx_vvrecatalog_house'][0] = array(
    'fList' => 'gid',
    'icon' => TRUE
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:vv_recatalog/class.tx_vvrecatalog_tcemainprocdm.php:&tx_vvrecatalog_tcemainprocdm';

t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_vvrecatalog_pi1.php','_pi1','list_type',0);


t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_vvrecatalog_flat = < plugin.'.t3lib_extMgm::getCN($_EXTKEY).'_pi1
	tt_content.shortcut.20.0.conf.tx_vvrecatalog_flat.CMD = singleView
',43);

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['rcardb'] = 'EXT:vv_rcar/lib/class.tx_vvrcar_db.php';

?>