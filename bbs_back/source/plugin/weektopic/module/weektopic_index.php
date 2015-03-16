<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: weektopic_index.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_GET['action']=='showwindow'){
	if($_G['groupid']!=1){
		showmessage(lang('plugin/weektopic','bc1'));
	}
	if(!submitcheck('submit')){
		include template('weektopic:add');
	}else{
		 if(!$_G['uid']){
			showmessage(lang('plugin/weektopic','bc2'), '', array(), array('login' => true));
		 }
		if(!$_GET['tid']){
			showmessage(lang('plugin/weektopic','bc3'));
		 }
		 if(!$_GET['name']){
			showmessage(lang('plugin/weektopic','bc4'));
		 }
		 if(!$_GET['url']){
			showmessage(lang('plugin/weektopic','bc5'));
		 }
		$insertarray=array('name'=>$_GET['name'],'url'=>$_GET['url'],'tid'=>$_GET['tid']);
		C::t('#weektopic#alj_weektopic_thread')->insert($insertarray);
		showmessage(lang('plugin/weektopic','bc6'),$_G['siteurl']);
	}
}else if($_GET['action']=='reply'){
	if(!submitcheck('submit')){
		$tid=intval($_GET['tid']);
		include template('weektopic:reply');
	}else{
		 if(!$_G['uid']){
			showmessage(lang('plugin/weektopic','bc7'), '', array(), array('login' => true));
		 }
		 if(!$_GET['intro']){
			showmessage(lang('plugin/weektopic','bc8'));
		 }
		include_once 'source/plugin/weektopic/function/function_core.php';
		if($_GET['tid']){
			topicpost($_GET['intro'],$_G['uid'],$_GET['tid'],'','',$_G['clientip']);
			showmessage(lang('plugin/weektopic','bc9'),'forum.php?mod=viewthread&tid='.$_GET['tid'].'&goto=lastpost#lastpost');
		}else{
			showmessage(lang('plugin/weektopic','bc10'));
		}
		
	}
}


?>