<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_alj_hd` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `starttime` int(10) NOT NULL,
  `endtime` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  `ym` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);
EOF;

runquery($sql);
//finish to put your own code
$finish = TRUE;
?>