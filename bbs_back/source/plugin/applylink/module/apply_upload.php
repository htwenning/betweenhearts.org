<?php

/**
 *      [Sanree] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: apply_upload.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if (!$_G['uid']) {

	showmessage(lang('plugin/applylink','appply_upload1'), '', array(), array('login' => true));
	
}
$input_imagetip = lang('plugin/applylink','appply_upload2');
$input_imagetip = str_replace('{w}',intval('40'),$input_imagetip);
$input_imagetip = str_replace('{h}',intval('40'),$input_imagetip);

include template('applylink:upload');
?>