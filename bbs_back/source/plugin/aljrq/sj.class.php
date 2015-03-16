<?php
	if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
class mobileplugin_aljrq {
	function global_header_mobile() {
		global $onlinenum,$onlineinfo,$membercount,$guestcount,$_G,$todayposts,$postdata,$posts;
		$config = $_G ['cache'] ['plugin'] ['aljrq'];
		if(!$config['iskaiqi']){
			return;
		}
		$all=explode('|',$config['suoyou']);
		//debug($all);
		
		if($all[0]>$todayposts){
			$todyas=1;
		}
		//debug(empty($todyas));
		//今日
		$todayposts = empty($all[0])?$todayposts:$all[0]+$todayposts;
		//昨日
		$postdata[0] = empty($all[1])?$postdata[0]:$all[1]+$postdata[0];
		//帖子
		$posts = empty($all[2])?$posts:$all[2]+$posts;
		//会员
		$_G['cache']['userstats']['totalmembers'] = empty($all[3])?$_G['cache']['userstats']['totalmembers']:$all[3]+$_G['cache']['userstats']['totalmembers'];
		
		
	}
}
?>