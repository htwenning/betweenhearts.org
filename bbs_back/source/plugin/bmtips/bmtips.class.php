<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: bmtips.class.php liangjian $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_bmtips {

}
class plugin_bmtips_forum extends plugin_bmtips {
	function forumdisplay_thread_subject_output(){
		global $_G;
		$config=$_G['cache']['plugin']['bmtips'];
		$forums=unserialize($config['forums']);
		if(!$forums||in_array($_G['fid'],$forums)){
			foreach($_G['forum_threadlist'] as $key => $value){
				$moderators=explode("\t", $_G['forum']['moderators']);
				if(!in_array($value['author'],$moderators)){
					foreach($moderators as $moderator){
						$authorid=C::t('common_member')->fetch_uid_by_username($moderator);
						$count=C::t('forum_post')->count_by_tid_authorid($value['tid'],$authorid);
						if($count){
							$list[$key]='<img alt="'.lang('plugin/bmtips','bmtips').'" src="source/plugin/bmtips/images/editor_rep.gif">';
						}
					}
				}
			}
		}
		return $list;
	}

}
?>