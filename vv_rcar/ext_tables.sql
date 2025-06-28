#
# Table structure for table 'tx_vvrcar_apskritis'
#
CREATE TABLE tx_vvrcar_apskritis (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	rcuid int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);



#
# Table structure for table 'tx_vvrcar_rajonas'
#
CREATE TABLE tx_vvrcar_rajonas (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	rcuid int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	auid int(11) DEFAULT '0' NOT NULL,
	rcauid int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);



#
# Table structure for table 'tx_vvrcar_gyvenviete'
#
CREATE TABLE tx_vvrcar_gyvenviete (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	rcuid int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	ruid int(11) DEFAULT '0' NOT NULL,
	rcruid int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);



#
# Table structure for table 'tx_vvrcar_mikro_rajonas'
#
CREATE TABLE tx_vvrcar_mikro_rajonas (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	rcuid int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	guid int(11) DEFAULT '0' NOT NULL,
	rcguid int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);

#
# Table structure for table 'tx_vvrcar_mikro_rajonas2'
#
CREATE TABLE tx_vvrcar_mikro_rajonas2 (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	ruid int(11) DEFAULT '0' NOT NULL,
	rcruid int(11) DEFAULT '0' NOT NULL,
	guid int(11) DEFAULT '0' NOT NULL,
	rcguid int(11) DEFAULT '0' NOT NULL,

	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);


#
# Table structure for table 'tx_vvrcar_mikrorajonas_gatve_mm'
# 
#
CREATE TABLE tx_vvrcar_mikrorajonas_gatve_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_vvrcar_gatve'
#
CREATE TABLE tx_vvrcar_gatve (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	rcuid int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	guid int(11) DEFAULT '0' NOT NULL,
	rcguid int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid)
);

CREATE TABLE tx_vvrecatalog_flat (
	apskritis int(11) DEFAULT '0' NOT NULL,
	rajonas int(11) DEFAULT '0' NOT NULL,
	gyvenviete int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas2 int(11) DEFAULT '0' NOT NULL,
	gatve int(11) DEFAULT '0' NOT NULL
);

CREATE TABLE tx_vvrecatalog_land (
	apskritis int(11) DEFAULT '0' NOT NULL,
	rajonas int(11) DEFAULT '0' NOT NULL,
	gyvenviete int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas2 int(11) DEFAULT '0' NOT NULL,
	gatve int(11) DEFAULT '0' NOT NULL
);

CREATE TABLE tx_vvrecatalog_homestead (
	apskritis int(11) DEFAULT '0' NOT NULL,
	rajonas int(11) DEFAULT '0' NOT NULL,
	gyvenviete int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas2 int(11) DEFAULT '0' NOT NULL,
	gatve int(11) DEFAULT '0' NOT NULL
);

CREATE TABLE tx_vvrecatalog_house (
	apskritis int(11) DEFAULT '0' NOT NULL,
	rajonas int(11) DEFAULT '0' NOT NULL,
	gyvenviete int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas2 int(11) DEFAULT '0' NOT NULL,
	gatve int(11) DEFAULT '0' NOT NULL
);

CREATE TABLE tx_vvrecatalog_accommodation (
	apskritis int(11) DEFAULT '0' NOT NULL,
	rajonas int(11) DEFAULT '0' NOT NULL,
	gyvenviete int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas int(11) DEFAULT '0' NOT NULL,
	mikro_rajonas2 int(11) DEFAULT '0' NOT NULL,
	gatve int(11) DEFAULT '0' NOT NULL
);