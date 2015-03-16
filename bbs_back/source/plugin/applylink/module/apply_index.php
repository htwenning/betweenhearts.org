<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: apply_index.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_G['lj_action']=='showwindow'){
	$config=$_G['cache']['plugin']['applylink'];
	$tips=$config['tips'];
	include template('applylink:apply');
}else if($_G['lj_action']=='apply'){
	if(!$_G['lj_name']||!$_G['lj_url']||!$_G['lj_qq']){
		showmessage(lang('plugin/applylink','appply_index1'));
	}
	$insertarray=array(
		'name'=>$_GET['name'],	
		'url'=>$_GET['url'],	
		'qq'=>$_GET['qq'],	
		'intro'=>$_GET['intro'],	
		'caid'=>$_GET['caid'],	
		'poster'=>$_GET['poster'],	
	);
	C::t('#applylink#alj_applylink')->insert($insertarray);
	$notification = lang('plugin/applylink','appply_index2')."<a href=\"".$_G['lj_url']."\">".$_G['lj_name']."</a> ".lang('plugin/applylink','appply_index3')."&nbsp; <a class=\"lit\" target=\"_blank\" href=\"admin.php?action=plugins&amp;operation=config&amp;do=".$_G['lj_do']."&amp;identifier=applylink&pmod=m\">".lang('plugin/applylink','appply_index4')."</a>";
	$notification = nl2br(str_replace(':', '&#58;', $notification));
	notification_add(1, 'post',$notification );
	showmessage(lang('plugin/applylink','appply_index5'),$_G['siteurl']);
}


?>