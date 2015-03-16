<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$settingfile = DISCUZ_ROOT . './data/sysdata/cache_aljrq_setting.php';
if(file_exists($settingfile)){
	unlink($settingfile);
}
if(file_exists(DISCUZ_ROOT . './data/cache/cache_aljrq_setting.php')){
	$settingfile = DISCUZ_ROOT . './data/cache/cache_aljrq_setting.php';
	unlink($settingfile);
}
DB::query("delete FROM ".DB::table('common_session')." where ip1='0'");

runquery($sql);
$finish = TRUE;
?>