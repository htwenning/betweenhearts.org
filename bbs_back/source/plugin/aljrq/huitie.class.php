<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_aljrq{
	function __construct() {
		include_once DISCUZ_ROOT.'/source/plugin/aljrq/function_aljrq.php';
		if(function_exists('discuz_uc_avatar')==false&&$_GET['inajax']!=1&&$_GET['mod']!='medal'){
			include_once libfile ( 'function/forum' );
		}
		
	}
	function global_footerlink(){
		global $_G;
		$config = $_G['cache']['plugin']['aljrq'];
		$settingfile = DISCUZ_ROOT . './data/sysdata/cache_aljrq_setting.php';
		if(file_exists($settingfile)){
			include $settingfile;
		}
		if(file_exists(DISCUZ_ROOT . './data/cache/cache_aljrq_setting.php')){
			$settingfile = DISCUZ_ROOT . './data/cache/cache_aljrq_setting.php';
			include DISCUZ_ROOT . './data/cache/cache_aljrq_setting.php';
		}
		$isnot=$config['isnot'];
		$uidlist=$config['uidlist'];
		$autocontent=$config['autocontent'];
		$fid=$config['bankuai'];
		$x_timestamp=time();
		$fid = unserialize ($fid);
		$fid = $fid[array_rand (  $fid )];
		if($fid){
		$globaltime=$config['globaltime'];
		$huitiesj=$config['huitiesj'];
		$cishu=$config['cishu'];
		if($cishu>5){
			$cishu=5;
		}
		
		$time=$wcache['value'];
if($isnot){
	if($x_timestamp>($time+$huitiesj)&&$_GET['mod']!='medal'&&$_GET['inajax']!=1){
		$arr=DB::fetch_first("SELECT tid,fid,subject,replies,authorid FROM ".DB::table('forum_thread')." where displayorder<>'-1' AND displayorder<>'-2' AND displayorder<>'-3' AND displayorder<>'-4' and replies<=$cishu and fid =$fid and (dateline+$globaltime*60*60)>$x_timestamp");
		//debug($arr);
		$tid=$arr['tid'];
		if($tid){
		$x_fid=$arr['fid'];
		$subject=$arr['subject'];
		if($config['istixing']){$authorid=$arr['authorid'];}
		$rautocontent=str_replace ( "\r", "", $config['autocontent'] );
		$rautocontent=explode("\n",$rautocontent);
		$rautocontentid=array_rand($rautocontent);
		$autocontent=$rautocontent[$rautocontentid];
		if($autocontent){
		$rarray=explode(',',$uidlist);
		$x_uid=array_rand($rarray);
		$x_uid=$rarray[$x_uid];
		$x_user=DB::result_first("SELECT username FROM ".DB::table('common_member')." where uid=$x_uid");
		if(!$x_user){
			return;
		}
		$groupid=DB::result_first("SELECT groupid FROM ".DB::table('common_member')." where uid=$x_uid");
		$x_useip="202.".rand(96,184).".".rand(124,127).".".rand(9,200);
		
		$pid = insertpost(array('fid' => $x_fid,'tid' => $tid,'first' => '0','author' => $x_user,'authorid' => $x_uid,'subject' => '','dateline' => $x_timestamp,'message' => $autocontent,'useip' => $x_useip,'invisible' => '0','anonymous' => '0','usesig' => $Signiture,'htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
		
		$x_lastpost = "$tid\t".addslashes($subject)."\t$x_timestamp\t$x_user";
		updatemembercount($x_uid, array('extcredits2 '=> 1));
		DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$x_uid'", 'UNBUFFERED');
		DB::query("UPDATE ".DB::table('common_member_status')." SET lastip='$x_useip',lastvisit='$x_timestamp',lastactivity='$x_timestamp',lastpost='$x_timestamp' WHERE uid='$x_uid'", 'UNBUFFERED');
		DB::query("UPDATE ".DB::table('forum_forum')." SET posts=posts+1,todayposts=todayposts+1,lastpost='$x_lastpost' WHERE fid='$x_fid'", 'UNBUFFERED');
		DB::query("UPDATE ".DB::table('forum_thread')." SET replies=replies+1,views=views+1,lastposter='$x_user', lastpost='$x_timestamp' WHERE tid='$tid'", 'UNBUFFERED');
			if(!empty($x_uid) && $x_uid != $_G['uid']) {
				mynotification_add_aljrq($authorid, 'post', 'reppost_noticeauthor', array(
					'tid' => $tid,
					'subject' => $subject,
					'fid' => $x_fid,
					'pid' => $pid,
					'from_id' => $tid,
					'from_idtype' => 'post',
				),0,$x_uid,$x_user);
			}
			$wcache['value']=$x_timestamp;
			require_once libfile('function/cache');
			writetocache('aljrq_setting', getcachevars(array('wcache' => $wcache)));//将管理中心配置项写入缓存
				
				//虚拟在线部分处理代码
							if(DB::result_first("SELECT uid FROM ".DB::table('common_session')." WHERE uid = ".$x_uid)){
								return;
							}else{
								$randtime = mt_rand(100, 1800);
								$onlinetime = $_G['timestamp'] - $randtime;
								$insertarray = array(
								'sid' => random(6),
								'ip1' => '0',
								'groupid' => $groupid,
								'lastactivity' => $onlinetime,
								'action' => 0,
								'fid' => 0,
								'uid' => $x_uid,
								'username' => $x_user,
								);
								
								DB::insert('common_session', $insertarray);
							}
					//虚拟在线部分处理代码
						}
					}
				}
			}
		}
	}
}

class plugin_aljrq_forum extends plugin_aljrq {

	
	function index_aljrq_output() {
		global $onlinenum,$onlineinfo,$membercount,$guestcount,$_G,$todayposts,$postdata,$posts;
		$config=$_G['cache']['plugin']['aljrq'];
		if(!$config['isrq']){
			return;
		}
		$onlineinfo[0]=$config['high'];
		$onlineinfo[1]=$config['time'];
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
	
	function index_aljrq() {
		global $_G;
		$config=$_G['cache']['plugin']['aljrq'];
		if($config['isrq']){
			$timeout = $_G['timestamp'] - 1800;	
			DB::delete('common_session',"ip1='0' AND lastactivity <='$timeout'");
			$config=$_G['cache']['plugin']['aljrq'];
			$onlinenum = DB::result_first("SELECT count(*) FROM ".DB::table('common_session'));
			$randnum=rand($config[m],$config[mm]);
			$yrandnum=rand($config[m],$config[mm]);
			$count=DB::result_first("select count(*) from ".DB::table('common_member'));
			$start=rand(0,$count);
			$query = DB::query("SELECT * FROM ".DB::table('common_member')."  LIMIT $start, $randnum");
			while($row=DB::fetch($query)){
				$members[]=$row;
			}
			if($onlinenum<$config['lt']){
				for($i=1;$i<$yrandnum;$i++){
					$randtime = mt_rand(100, 1800);
					$onlinetime = $_G['timestamp'] - $randtime;
					$insertarray = array(
					'sid' => random(6),
					'ip1' => '0',
					'groupid' => 7,
					'lastactivity' => $onlinetime,
					'action' => 2,
					'fid' => 0,
					);
						
					DB::insert('common_session', $insertarray);
				}
				foreach($members as $member){
					if(DB::result_first("SELECT uid FROM ".DB::table('common_session')." WHERE uid = ".$member['uid'])){
						continue;
					}else{
						$randtime = mt_rand(100, 1800);
						$onlinetime = $_G['timestamp'] - $randtime;
						$insertarray = array(
						'sid' => random(6),
						'ip1' => '0',
						'groupid' => $member[groupid],
						'lastactivity' => $onlinetime,
						'action' => 0,
						'fid' => 0,
						'uid' => $member['uid'],
						'username' => $member['username'],
						);
						
						DB::insert('common_session', $insertarray);
					}
				}
			}
		}else{
			DB::query("delete FROM ".DB::table('common_session')." where ip1='0'");
		}
	}
}

?>