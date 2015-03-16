<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_alj_weektopic_thread` (
  `id` int(10) NOT NULL auto_increment,
  `tid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);
EOF;

runquery($sql);
//finish to put your own code
$finish = TRUE;
?>