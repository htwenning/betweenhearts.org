<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: apply.class.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_applylink{
	function global_footerlink(){
		return '<a style="cursor:pointer" onclick=\'showWindow("apply","plugin.php?id=applylink:apply&action=showwindow")\' href="#"><font color="red">'.lang('plugin/applylink','apply1').'</font></a>';
	}

}



?>