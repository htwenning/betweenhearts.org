<?php

/**
 *      [Sanree] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: apply_swfupload.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}


 
$_G['uid'] = intval($_G['uid']);
if((empty($_G['uid']) && $_GET['operation'] != 'upload') || $_POST['hash'] != md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])) {
	exit();
} else {
	if($_G['uid']) {
		$_G['member'] = getuserbyuid($_G['uid']);
	}
	$_G['groupid'] = $_G['member']['groupid'];
	loadcache('usergroup_'.$_G['member']['groupid']);
	$_G['group'] = $_G['cache']['usergroup_'.$_G['member']['groupid']];
}

if($_GET['operation'] == 'upload') {

	if($_FILES['Filedata']['error']==0){
		$tmpavatar = $_FILES['Filedata']['tmp_name'];
		list($width, $height, $type, $attr) = getimagesize($tmpavatar);
		$imgtype = array(1, 2, 3, 6);
		if (!in_array($type, $imgtype)) {
			file_exists($tmpavatar) && @unlink($tmpavatar);
			$type= intval($type);
			echo 'DISCUZUPLOAD|1|4|'.$type.'|0|0|0|0';
			exit();			
		}
	} else {
		echo 'DISCUZUPLOAD|1|-1|0|0|0|0|0';
		exit();		
	}
	
	require_once(DISCUZ_ROOT.'./source/plugin/applylink/class/forum_upload.php');		
	new apply_forum_upload();
	
} 
?>