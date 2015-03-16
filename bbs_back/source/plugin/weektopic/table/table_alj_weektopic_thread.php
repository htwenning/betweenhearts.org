<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_alj_weektopic_thread.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_alj_weektopic_thread extends discuz_table
{
	public function __construct() {

		$this->_table = 'alj_weektopic_thread';
		$this->_pk    = 'id';

		parent::__construct();
	}
	public function fetch_all_post_by_tid($tid){
		return DB::fetch_all('select * from %t where tid=%d and first!=1',array('forum_post',$tid));
	}
}


?>