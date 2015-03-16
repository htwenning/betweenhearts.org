<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_alj_dc_log` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mydc` varchar(255) NOT NULL,
  `result` varchar(255) NOT NULL,
  `ret` varchar(255) NOT NULL,
  `mynum` int(10) NOT NULL,
  `dcnum` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  `isnot` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_alj_dc_user` (
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `anum` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  `lasttime` int(10) NOT NULL,
  PRIMARY KEY  (`uid`)
)
EOF;

runquery($sql);
//finish to put your own code
$finish = TRUE;
?>