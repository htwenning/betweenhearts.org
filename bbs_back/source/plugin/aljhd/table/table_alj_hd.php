<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_alj_hd.php liangjian $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_alj_hd extends discuz_table
{
	public function __construct() {

		$this->_table = 'alj_hd';
		$this->_pk    = 'id';

		parent::__construct();
	}
	public function count_by_ym_type_status($ym,$type,$status){
		$where=' where 1';
		if($ym){
			$where.=' and ym='.addslashes($ym);
		}
		if($type){
			$where.=' and type='.intval($type);
		}
		if($status==1){
			$where.=' and starttime<'.TIMESTAMP.' and endtime>'.TIMESTAMP;
		}
		if($status==2){
			$where.=' and endtime<'.TIMESTAMP;
		}
		return DB::result_first('select count(*) from %t '.$where,array($this->_table));
	}
	public function fetch_all_by_ym_type_status($ym,$type,$status,$start,$perpage){
		$where=' where 1';
		if($ym){
			$where.=" and ym='".addslashes($ym)."'";
		}
		if($type){
			$where.=' and type='.intval($type);
		}
		if($status==1){
			$where.=' and starttime<='.TIMESTAMP.' and endtime>='.TIMESTAMP;
		}
		if($status==2){
			$where.=' and endtime<'.TIMESTAMP;
		}
		$where.=' order by endtime desc';
		if($perpage){
			$where.=" limit $start,$perpage";
		}
		return DB::fetch_all('select * from %t '.$where,array($this->_table));
	}
	public function fetch_all_by_ym(){
		return DB::fetch_all('select ym,count(*) num from %t group by ym order by ym desc',array($this->_table));
	}
	public function fetch_all_by_type(){
		return DB::fetch_all('select type,count(*) num from %t group by type',array($this->_table));
	}
}

?>