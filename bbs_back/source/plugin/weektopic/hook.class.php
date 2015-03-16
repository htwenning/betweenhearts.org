<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class plugin_weektopic {
	function __construct() {
		
	} 
} 
class plugin_weektopic_forum extends plugin_weektopic {
	function index_top(){
		global $_G;
		$topic=C::t('#weektopic#alj_weektopic_thread')->range(0,1,'desc');
		foreach($topic as $v){
			$topic=$v;
		}
		$posts=C::t('#weektopic#alj_weektopic_thread')->fetch_all_post_by_tid($topic['tid']);
		include_once libfile('function/discuzcode');
		foreach($posts as $key=>$post){
			$posts[$key]['message']=discuzcode($post['message']);
		}
		include template('weektopic:index');
		return $return;
	}	
}
?>