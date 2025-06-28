<?php

########################################################################
# Extension Manager/Repository config file for ext: "vv_reexport"
#
# Auto generated 05-02-2008 15:27
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'RE Catalog Export',
	'description' => 'Module for exporting RE ads from the catalogue',
	'category' => 'module',
	'author' => 'Miroslav Monkevic',
	'author_email' => 'm@dieta.lt',
	'shy' => '',
	'dependencies' => 'vv_recatalog,vv_rcar',
	'conflicts' => '',
	'priority' => '',
	'module' => 'mod1',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'vv_recatalog' => '',
			'vv_rcar' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:12:{s:9:"ChangeLog";s:4:"c6d9";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:14:"ext_tables.php";s:4:"1a98";s:19:"doc/wizard_form.dat";s:4:"4a12";s:20:"doc/wizard_form.html";s:4:"0ab3";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"0a52";s:14:"mod1/index.php";s:4:"0c02";s:18:"mod1/locallang.xml";s:4:"434f";s:22:"mod1/locallang_mod.xml";s:4:"595f";s:19:"mod1/moduleicon.gif";s:4:"8074";}',
);

?>