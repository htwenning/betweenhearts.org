<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_alj_eggs_log.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_alj_dc_log extends discuz_table
{
	public function __construct() {

		$this->_table = 'alj_dc_log';
		$this->_pk    = 'id';

		parent::__construct();
	}
}

?>