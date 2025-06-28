<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrcar_apskritis=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrcar_rajonas=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrcar_gyvenviete=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrcar_mikro_rajonas=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_vvrcar_gatve=1
');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getSingleFieldClass'][] = 'EXT:vv_rcar/class.tx_vvrcar_hooks.php:&tx_vvrcar_hooks';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:vv_rcar/class.tx_vvrcar_hooks.php:&tx_vvrcar_hooks';

$TYPO3_CONF_VARS['BE']['XCLASS']['t3lib/class.t3lib_tceforms.php'] = t3lib_extMgm::extPath($_EXTKEY).'class.ux_t3lib_tceforms.php';
?>