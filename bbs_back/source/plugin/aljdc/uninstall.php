<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
DROP TABLE IF EXISTS `pre_alj_dc_log`;
DROP TABLE IF EXISTS `pre_alj_dc_user`;
EOF;
runquery($sql);
//finish to put your own code
$finish = TRUE;
?>