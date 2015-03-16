<?php
	if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}

class plugin_ljdaka {
	var $uid;
	var	$config;
	var	$weizhi;
	var	$xianshi;
	var	$sql;
	var	$check;
	function __construct(){
		global $_G;
		$this->uid=$_G['uid'];
		$this->config = $_G['cache']['plugin']['ljdaka'];
		$this->weizhi=$this->config['weizhi'];
		$this->xianshi=$this->config['xianshi'];
		$this->isqz=$this->config['isqz'];
		$this->sql="select count(*) from ".DB::table('plugin_daka')." where uid=".$this->uid." and curdate()=FROM_UNIXTIME(timestamp,'%Y-%m-%d')";
		$this->check=DB::result_first($this->sql);
	}
	function global_header() {
			if(!$this->check&&$this->isqz&&$this->uid){
				$return='<script stype="text/javascript">showWindow("ljdaka","plugin.php?id=ljdaka")</script>';
			}
			return $return;
	}
	function global_usernav_extra1() {
		if($this->weizhi==1&&$this->uid){
			if(!$this->check||!empty($this->xianshi)){
				include template('ljdaka:daka');
			}
			return $return;
		}
	}
	function global_cpnav_extra1() {
	if($this->weizhi==2&&$this->uid){
			if(!$this->check||!empty($this->xianshi)){
				include template('ljdaka:daka');
			}
			return $return;
		}
	}
	function global_cpnav_extra2() {
		if($this->weizhi==3&&$this->uid){
			if(!$this->check||!empty($this->xianshi)){
				include template('ljdaka:daka');
			}
			return $return;
		}
	}
	function global_usernav_extra2() {
		if($this->weizhi==4&&$this->uid){
			if(!$this->check||!empty($this->xianshi)){
				include template('ljdaka:daka');
			}
			return $return;
		}
	}
	function global_usernav_extra3() {
	if($this->weizhi==5&&$this->uid){
			if(!$this->check||!empty($this->xianshi)){
				include template('ljdaka:daka');
			}
			return $return;
		}
	}
	function global_usernav_extra4() {
		if($this->weizhi==6&&$this->uid){
			if(!$this->check||!empty($this->xianshi)){
				include template('ljdaka:daka');
			}
			return $return;
		}
	}
	}
?>