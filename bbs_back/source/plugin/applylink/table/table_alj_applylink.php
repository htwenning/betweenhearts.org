<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_alj_applylink.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_alj_applylink extends discuz_table
{
	public function __construct() {

		$this->_table = 'alj_applylink';
		$this->_pk    = 'id';

		parent::__construct();
	}

}


?>