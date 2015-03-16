<?php
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
drop table IF EXISTS `pre_plugin_lj_sina`;
EOF;
runquery($sql);
$finish = TRUE;

?>