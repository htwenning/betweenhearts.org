<?php
	if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
$web_root=$_G['siteurl'];
if(substr($web_root,-1)!='/'){
	$web_root=$web_root.'/';
}
//header('Content-Type: text/html; charset=UTF-8');
$config = $_G ['cache'] ['plugin'] ['ljxlwb'];
$AppKey = $config ['AppKey'];
$AppSecret = $config ['AppSecret'];
define( "WB_AKEY" , $AppKey );
define( "WB_SKEY" , $AppSecret );
define( "WB_CALLBACK_URL" , $web_root.'plugin.php?id=ljxlwb' );
?>