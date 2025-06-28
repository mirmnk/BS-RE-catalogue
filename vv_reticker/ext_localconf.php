<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
require_once(t3lib_extMgm::extPath('div') . 'class.tx_div.php');
if(TYPO3_MODE == 'FE') tx_div::autoLoadAll($_EXTKEY);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:vv_reticker/lib/class.tx_vvreticker_hooks.php:&tx_vvreticker_hooks';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:vv_reticker/lib/class.tx_vvreticker_hooks.php:&tx_vvreticker_hooks';

?>