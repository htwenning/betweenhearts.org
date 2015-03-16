<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: weektopic.inc.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$modarray = array('index');

$mod = isset($_GET['mod']) ? $_GET['mod'] : '';
$mod = !in_array($mod, $modarray) ? 'index' : $mod;

require DISCUZ_ROOT.'./source/plugin/weektopic/module/weektopic_'.$mod.'.php';




?>