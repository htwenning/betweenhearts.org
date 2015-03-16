<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `jinbi` int(10) NOT NULL,
  `alldays` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)
EOF;

runquery($sql);
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_plugin_daka_user` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `allday` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `day` int(11) NOT NULL,
  `fen` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
)
EOF;
runquery($sql);
//finish to put your own code
$finish = TRUE;
?>