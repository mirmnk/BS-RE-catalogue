#
# Table structure for table 'tx_vvrecatalog_heating_type'
#
CREATE TABLE tx_vvrecatalog_heating_type (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	aruodas_title varchar(255) DEFAULT '' NOT NULL,	
	edomus_title varchar(255) DEFAULT '' NOT NULL,
	domoplius_id int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);


#
# Table structure for table 'tx_vvrecatalog_land_pos'
#
CREATE TABLE tx_vvrecatalog_land_pos (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	edomus_title varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_city'
#
CREATE TABLE tx_vvrecatalog_city (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	aruodas_uid int(11) DEFAULT '0' NOT NULL,	
	aruodas_did int(11) DEFAULT '0' NOT NULL,	
	city24_city varchar(255) DEFAULT '' NOT NULL,
	city24_county varchar(255) DEFAULT '' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,	
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_district'
#
CREATE TABLE tx_vvrecatalog_district (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	city int(11) DEFAULT '0' NOT NULL,
	aruodas_uid int(11) DEFAULT '0' NOT NULL,	
	city24_val varchar(255) DEFAULT '' NOT NULL,		
	title varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_building_type'
#
CREATE TABLE tx_vvrecatalog_building_type (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	aruodas_title varchar(255) DEFAULT '' NOT NULL,	
	edomus_title varchar(255) DEFAULT '' NOT NULL,
	domoplius_id int(11) DEFAULT '0' NOT NULL,

	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_sequence'
#
CREATE TABLE tx_vvrecatalog_sequence (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_land'
#
CREATE TABLE tx_vvrecatalog_land (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	domoplius_id varchar(255) DEFAULT '' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	action int(11) DEFAULT '0' NOT NULL,
	gid int(11) DEFAULT '0' NOT NULL,
	price double(10,2) DEFAULT '0.00' NOT NULL,
	city int(11) DEFAULT '0' NOT NULL,
	district int(11) DEFAULT '0' NOT NULL,
	land_pos int(11) DEFAULT '0' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	objnumber varchar(255) DEFAULT '' NOT NULL,
	land_type int(11) DEFAULT '0' NOT NULL,
	land_area double(10,2) DEFAULT '0.00' NOT NULL,
	images blob NOT NULL,
	descr text NOT NULL,
	employee int(11) DEFAULT '0' NOT NULL,
	ext_pub int(11) DEFAULT '0' NOT NULL,
	special int(11) DEFAULT '0' NOT NULL,
	com_sys int(11) DEFAULT '0' NOT NULL,
	domoplius_status text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_ac_type'
#
CREATE TABLE tx_vvrecatalog_ac_type (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	edomus_title varchar(255) DEFAULT '' NOT NULL,
	domoplius_id int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_land_type'
#
CREATE TABLE tx_vvrecatalog_land_type (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	city24_land_type varchar(255) DEFAULT '' NOT NULL,
	edomus_land_type varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	domoplius_id int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_flat'
#
CREATE TABLE tx_vvrecatalog_flat (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	domoplius_id varchar(255) DEFAULT '' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	action int(11) DEFAULT '0' NOT NULL,
	gid int(11) DEFAULT '0' NOT NULL,
	price double(10,2) DEFAULT '0.00' NOT NULL,
	city int(11) DEFAULT '0' NOT NULL,
	district int(11) DEFAULT '0' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	objnumber varchar(255) DEFAULT '' NOT NULL,
	building_type int(11) DEFAULT '0' NOT NULL,
	bdate int(11) DEFAULT '0' NOT NULL,
	heating_type int(11) DEFAULT '0' NOT NULL,
	area double(10,2) DEFAULT '0.00' NOT NULL,
	images blob NOT NULL,
	roomcount int(11) DEFAULT '0' NOT NULL,
	floor varchar(50) DEFAULT '' NOT NULL,
	floorcount int(11) DEFAULT '0' NOT NULL,
	descr text NOT NULL,
	employee int(11) DEFAULT '0' NOT NULL,
	ext_pub int(11) DEFAULT '0' NOT NULL,
	state int(11) DEFAULT '0' NOT NULL,
	installation int(11) DEFAULT '0' NOT NULL,
	special int(11) DEFAULT '0' NOT NULL,
	facilities int(11) DEFAULT '0' NOT NULL,
	equipment int(11) DEFAULT '0' NOT NULL,
	com_sys int(11) DEFAULT '0' NOT NULL,
	security int(11) DEFAULT '0' NOT NULL,
	domoplius_status text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_homestead'
#
CREATE TABLE tx_vvrecatalog_homestead (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	domoplius_id varchar(255) DEFAULT '' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	action int(11) DEFAULT '0' NOT NULL,
	gid int(11) DEFAULT '0' NOT NULL,
	price double(10,2) DEFAULT '0.00' NOT NULL,
	city int(11) DEFAULT '0' NOT NULL,
	district int(11) DEFAULT '0' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	objnumber varchar(255) DEFAULT '' NOT NULL,
	building_type int(11) DEFAULT '0' NOT NULL,
	bdate int(11) DEFAULT '0' NOT NULL,
	images blob NOT NULL,
	heating_type int(11) DEFAULT '0' NOT NULL,
	area double(10,2) DEFAULT '0.00' NOT NULL,
	roomcount int(11) DEFAULT '0' NOT NULL,
	land_type int(11) DEFAULT '0' NOT NULL,
	land_pos int(11) DEFAULT '0' NOT NULL,
	floorcount int(11) DEFAULT '0' NOT NULL,
	descr text NOT NULL,
	land_area double(10,2) DEFAULT '0.00' NOT NULL,
	employee int(11) DEFAULT '0' NOT NULL,
	ext_pub int(11) DEFAULT '0' NOT NULL,
	state int(11) DEFAULT '0' NOT NULL,
	installation int(11) DEFAULT '0' NOT NULL,
	special int(11) DEFAULT '0' NOT NULL,
	facilities int(11) DEFAULT '0' NOT NULL,
	equipment int(11) DEFAULT '0' NOT NULL,
	com_sys int(11) DEFAULT '0' NOT NULL,
	security int(11) DEFAULT '0' NOT NULL,
	domoplius_status text,

	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_house'
#
CREATE TABLE tx_vvrecatalog_house (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	domoplius_id varchar(255) DEFAULT '' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	action int(11) DEFAULT '0' NOT NULL,
	gid int(11) DEFAULT '0' NOT NULL,
	price double(10,2) DEFAULT '0.00' NOT NULL,
	city int(11) DEFAULT '0' NOT NULL,
	district int(11) DEFAULT '0' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	objnumber varchar(255) DEFAULT '' NOT NULL,
	images blob NOT NULL,
	roomcount int(11) DEFAULT '0' NOT NULL,
	building_type int(11) DEFAULT '0' NOT NULL,
	bdate int(11) DEFAULT '0' NOT NULL,
	heating_type int(11) DEFAULT '0' NOT NULL,
	area double(10,2) DEFAULT '0.00' NOT NULL,
	floorcount int(11) DEFAULT '0' NOT NULL,
	land_area double(10,2) DEFAULT '0.00' NOT NULL,
	land_type int(11) DEFAULT '0' NOT NULL,
	land_pos int(11) DEFAULT '0' NOT NULL,
	descr text NOT NULL,
	employee int(11) DEFAULT '0' NOT NULL,
	ext_pub int(11) DEFAULT '0' NOT NULL,
	state int(11) DEFAULT '0' NOT NULL,
	installation int(11) DEFAULT '0' NOT NULL,
	special int(11) DEFAULT '0' NOT NULL,
	facilities int(11) DEFAULT '0' NOT NULL,
	equipment int(11) DEFAULT '0' NOT NULL,
	com_sys int(11) DEFAULT '0' NOT NULL,
	security int(11) DEFAULT '0' NOT NULL,
	domoplius_status text,

	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_vvrecatalog_accommodation'
#
CREATE TABLE tx_vvrecatalog_accommodation (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	domoplius_id varchar(255) DEFAULT '' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	action int(11) DEFAULT '0' NOT NULL,
	gid int(11) DEFAULT '0' NOT NULL,
	price double(10,2) DEFAULT '0.00' NOT NULL,
	city int(11) DEFAULT '0' NOT NULL,
	district int(11) DEFAULT '0' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	building_type int(11) DEFAULT '0' NOT NULL,
	bdate int(11) DEFAULT '0' NOT NULL,
	heating_type int(11) DEFAULT '0' NOT NULL,
	area double(10,2) DEFAULT '0.00' NOT NULL,
	roomcount int(11) DEFAULT '0' NOT NULL,
	floorcount int(11) DEFAULT '0' NOT NULL,
	images blob NOT NULL,
	descr text NOT NULL,
	ac_type int(11) DEFAULT '0' NOT NULL,
	floor varchar(50) DEFAULT '' NOT NULL,
	employee int(11) DEFAULT '0' NOT NULL,
	ext_pub int(11) DEFAULT '0' NOT NULL,
	state int(11) DEFAULT '0' NOT NULL,
	installation int(11) DEFAULT '0' NOT NULL,
	special int(11) DEFAULT '0' NOT NULL,
	facilities int(11) DEFAULT '0' NOT NULL,
	equipment int(11) DEFAULT '0' NOT NULL,
	com_sys int(11) DEFAULT '0' NOT NULL,
	security int(11) DEFAULT '0' NOT NULL,
	domoplius_status text,

	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_vvrecatalog_options'
#
CREATE TABLE tx_vvrecatalog_options (
    opt varchar(255) DEFAULT '' NOT NULL,
    value varchar(255) DEFAULT '' NOT NULL,
    
    PRIMARY KEY (opt),
);