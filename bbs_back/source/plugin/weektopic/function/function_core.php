<?php
function topicpost($huitie,$uid,$tid,$fid,$Signiture,$ip,$username){
	global $_G;
	include_once libfile('function/forum');
	include_once libfile('function/post');
	if(!$username){
		$username = DB :: result_first('SELECT username FROM %t where uid=%d',array('common_member',$uid));
	}
	if(!$ip){
		$clientip="202.".rand(96,184).".".rand(124,127).".".rand(9,200);
	}
	if(!$fid){
		$fid=DB::result_first('SELECT fid FROM %t where tid=%d',array('forum_thread',$tid));
	}
	$pid = insertpost(array('fid' => $fid, 'tid' => $tid, 'first' => '0', 'author' => $username, 'authorid' => $uid, 'subject' => '', 'dateline' => $_G['timestamp'], 'message' => $huitie, 'useip' => $clientip, 'invisible' => '0', 'anonymous' => '0', 'usesig' => $Signiture, 'htmlon' => '0', 'bbcodeoff' => '0', 'smileyoff' => '0', 'parseurloff' => '0', 'attachment' => '0',)); 									
	$lastpost = "$tid\t" . addslashes($huitie) . "\t$_G[timestamp]\t$username";
	DB :: query('UPDATE %t SET posts=posts+1 WHERE uid=%d',array('common_member_count',$uid));
	DB :: query('UPDATE %t SET lastip=%s,lastvisit=%d,lastactivity=%d,lastpost=%d WHERE uid=%d',array('common_member_status',$clientip,$_G['timestamp'],$_G['timestamp'],$_G['timestamp'],$uid));
	DB :: query('UPDATE %t SET posts=posts+1,todayposts=todayposts+1,lastpost=%s WHERE fid=%d',array('forum_forum',$lastpost,$fid));
	$max=DB::result_first('select position from %t where pid=%d',array('forum_post',$pid));
	DB :: query('UPDATE %t SET replies=replies+1,views=views+1,lastposter=%s, lastpost=%d,maxposition=%d WHERE tid=%d',array('forum_thread',$username,$_G['timestamp'],$max,$tid));
	if (!empty($uid) && $uid != $_G['uid']) {
		$notification = "<a href=\"home.php?mod=space&amp;uid=$uid\">$username</a> 回复了您的帖子 <a target=\"_blank\" href=\"forum.php?mod=redirect&amp;goto=findpost&amp;ptid=$tid&amp;pid=$pid\">$subject</a> &nbsp; <a class=\"lit\" target=\"_blank\" href=\"forum.php?mod=redirect&amp;goto=findpost&amp;pid=$pid&amp;ptid=$tid\">查看</a>";
		$notification = nl2br(str_replace(':', '&#58;', $notification));
		notification_add($authorid, 'post',$notification );
	}

}


?>