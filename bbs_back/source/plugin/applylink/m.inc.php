<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: m.class.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
foreach($_GET as $k => $v) {
	$_G['lj_'.$k] = daddslashes($v); 
}
if($_G['lj_act']=='delete'){
	C::t('#applylink#alj_applylink')->delete($_G['lj_id']);
	cpmsg(lang('plugin/applylink','m1'),"action=plugins&operation=config&do=".$_G['lj_do']."&identifier=applylink&pmod=m");
}else{
	include_once libfile('function/discuzcode');
	$currpage=$_G['lj_page']?$_G['lj_page']:1;
	$perpage=10;
	$start=($currpage-1)*$perpage;
	$num=C::t('#applylink#alj_applylink')->count();
	$linklist=C::t('#applylink#alj_applylink')->range($start,$perpage,'desc');
	$paging = helper_page :: multi($num, $perpage, $currpage, "admin.php?action=plugins&operation=config&do=".$_G['lj_do']."&identifier=applylink&pmod=m", 0, 10, false, false);
	$picpre=$_G['setting']['attachurl'].'category/';
	include template('applylink:m');
}

?>