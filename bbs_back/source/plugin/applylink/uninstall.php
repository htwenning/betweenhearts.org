<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `pre_alj_applylink`;
EOF;
runquery($sql);
$sql = <<<EOF
DROP TABLE IF EXISTS `pre_plugin_lj_attachment`;
EOF;
runquery($sql);

$finish = TRUE;
?>