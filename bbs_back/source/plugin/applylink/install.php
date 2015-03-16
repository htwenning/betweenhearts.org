<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_alj_applylink` (
    `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `qq` int(10) unsigned NOT NULL,
  `caid` int(10) unsigned NOT NULL,
  `poster` varchar(255) NOT NULL,
  `intro` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
)
EOF;

runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_lj_attachment` (
  `aid` mediumint(8) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `attachment` varchar(255) NOT NULL default '',
  `remote` tinyint(1) unsigned NOT NULL default '0',
  `isimage` tinyint(1) NOT NULL default '0',
  `width` smallint(6) unsigned NOT NULL default '0',
  `thumb` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`aid`),
  KEY `uid` (`uid`)
)
EOF;

runquery($sql);
//finish to put your own code
$finish = TRUE;
?>