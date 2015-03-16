<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_alj_eggs_user.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_alj_dc_user extends discuz_table
{
	public function __construct() {

		$this->_table = 'alj_dc_user';
		$this->_pk    = 'uid';

		parent::__construct();
	}
	public function fetch_extcredits($uid,$id){
		return DB::result_first("select extcredits".$id." from ".DB::table('common_member_count')." where uid=".$uid);
	}
}

?>