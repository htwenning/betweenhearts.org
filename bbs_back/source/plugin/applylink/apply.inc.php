<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: apply.inc.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$modarray = array('index','upload','swfupload');
foreach($_GET as $k => $v) {
	$_G['lj_'.$k] = daddslashes($v); 
	
}

$mod = isset($_G['lj_mod']) ? $_G['lj_mod'] : '';
$mod = !in_array($mod, $modarray) ? 'index' : $mod;

require DISCUZ_ROOT.'./source/plugin/applylink/module/apply_'.$mod.'.php';




?>