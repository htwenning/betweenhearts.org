<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class plugin_ljqq {
	function __construct() {
		
	} 
	function global_footer() {
		global $_G;
		$config=$_G['cache']['plugin']['ljqq'];

		//$qq=explode('\n',str_replace('\r','',$config['qq']));
		$qqgroup = explode("\r\n", $config['qq']);
		//debug($qqgroup);
		if($qqgroup[0]=='') {
			$qqgroup = $newqq = '';
		}
		$wwgroup = explode("\r\n", $config['ww']);
		
		if($wwgroup[0]=='') {
			$wwgroup = $newww = '';
		} 
		
		$qqqgroup = explode("\r\n", $config['qqq']);
		//debug($qqgroup);
		if($qqqgroup[0]=='') {
			$qqqgroup = $newgroup = '';
		} else {
			foreach($qqqgroup as $key => $value) {
				$value=explode('|', $value);
				$newgroup[] = $value;
				
			}

		}
		$work = explode("|", $config['work']);
		include template('ljqq:qq');
		return $return;
		}
} 

?>