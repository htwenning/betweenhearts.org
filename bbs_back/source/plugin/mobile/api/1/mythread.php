<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mythread.php 27451 2012-02-01 05:48:47Z monkey $
 */
//note ����thread >> mythread(�ҵ�����) @ Discuz! X2.5

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'guide';
$_GET['view'] = 'my';
include_once 'forum.php';

class mobile_api {

	//note ����ģ��ִ��ǰ��Ҫ���еĴ���
	function common() {
	}

	//note ����ģ�����ǰ���еĴ���
	function output() {
		global $_G;
		$variable = array(
			'data' => array_values($GLOBALS['data']['my']['threadlist']),
			'perpage' => $GLOBALS['perpage'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>