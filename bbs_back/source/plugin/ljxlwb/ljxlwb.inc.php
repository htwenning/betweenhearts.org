<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
require_once DISCUZ_ROOT.'source/plugin/ljxlwb/saetv2.ex.class.php';
require_once DISCUZ_ROOT.'source/plugin/ljxlwb/config.php';
require_once DISCUZ_ROOT . 'source/plugin/ljxlwb/lj.class.php';
if($_GET['act']=='sina'){
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
	$code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
	dsetcookie('tid', $_GET[tid], 86400);
	dsetcookie('lid', $_GET[lid], 86400);
	header('Location:'.$code_url."&forcelogin=true&state=true");
	
}
$lj=new lj();
$uid=$_G['uid'];
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$che1=DB::fetch_first("select * from ".DB::table('plugin_lj_sina')." where  uid=".$uid);
if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		if(!function_exists('curl_init')){
			showmessage(lang('plugin/ljxlwb','lj_crul'),$_G[siteurl]);
		}
		$token = $o->getAccessToken( 'code', $keys ) ;

	} catch (OAuthException $e) {
	}
}

//数据库建表
//查询表记录确认是否绑定
//如果未绑定，直接出错提示(请先登录后绑定新浪微薄)

//如果未绑定，提示登录，登录后用户点击绑定按纽直接绑定，所谓绑定，技术上实现就是写入plugin_lj_sina表中，而后用户可以通过设置中的绑定菜单配置是否发贴同步信息、回贴同步信息
$op=$_GET['opp'];
if($op == 'in') {
	$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
	//debug($code_url);
	if($_GET['forcelogin']=='true'){
		header('Location:'.$code_url."&forcelogin=true");
	}else{
		header('Location:'.$code_url);
	}
	
}
if($op == 'config'){
	if(submitcheck('connectsubmit')) {
		$ispublishfeed=addslashes($_GET['ispublishfeed']);
		if(!$ispublishfeed){
			$ispublishfeed=0;
		}
		$ispublisht=addslashes($_GET['ispublisht']);
		if(!$ispublisht){
			$ispublisht=0;
		}
		
		$arr=array(
			'uid'=>$uid,	
			'sinauid'=>$token['uid'],	
			'fsign'=>$ispublishfeed,
			'hsign'=>$ispublisht,	
		);
		DB::query("update ".DB::table('plugin_lj_sina')." set fsign=$ispublishfeed,hsign=$ispublisht where uid=".$_G['uid']);
		//DB::update('plugin_lj_sina',$arr, array('uid' => $_G['uid'], 'sinauid' => $token['uid']));
		showmessage(lang('plugin/ljxlwb','lj_bccg'),'home.php?mod=spacecp&ac=plugin&id=ljxlwb:ljxlwb');
	}
}else if($op == 'unbind') {
	if(submitcheck('connectsubmit1')) {
		
		DB::query("delete from ".DB::table('plugin_lj_sina')." where uid=$uid ");
		showmessage(lang('plugin/ljxlwb','lj_jccg'),'home.php?mod=spacecp&ac=plugin&id=ljxlwb:ljxlwb');
	}
}
if($_GET['code']&&$uid&&!$token){
	header('Location:'.$_G[siteurl]);
}
if($token){
	//$_SESSION['token'] = $token;
	dsetcookie('sina_token', addslashes(serialize($token)), 86400);
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	$check=DB::fetch_first("select * from ".DB::table('plugin_lj_sina')." where  sinauid='".$token['uid']."'");
	if($uid){//只登录后绑定用
		$token1=serialize($token);
		$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token['access_token']);
		$user_message = $c -> show_user_by_id($token[uid]);
		$sinausername=$user_message['name'];
		if($_G['charset']=='gbk'){
			$sinausername=$lj->u2g($user_message['name']);	
		}
		//debug($sinausername);
		$arr=array(
			'uid'=>$uid,	
			'sinauid'=>$token['uid'],	
			'fsign'=>1,
			'hsign'=>1,
			'token'=>$token1,
			'sina_username'=>$sinausername,
		);
		if(!$check){
			DB::insert('plugin_lj_sina',$arr);
		}else{
			$username=DB::result_first("select username from ".DB::table('common_member')." where uid='".$check['uid']."'");
			showmessage(lang('plugin/ljxlwb','lj_1').$username.lang('plugin/ljxlwb','lj_2'));
		}
		if($_GET['state']=='true'){
			$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token['access_token']);
			$task=C::t('#seotask#alj_seotask')->fetch(intval($_G['cookie']['tid']));
			$weibocontent=$task['weibocontent'];
			if($_G['charset']=='gbk'){
				if(function_exists('mb_convert_encoding')) {
					$weibocontent=mb_convert_encoding($weibocontent, 'UTF-8', 'gbk');
				} else {
					$weibocontent=iconv('gbk','utf-8',$weibocontent);
				}	
			}
			$res=$c->update($weibocontent);
			if (isset($ret['error_code']) && isset($ret['error'])){
				echo ('Error_code: '.$ret['error_code'].';  Error: '.$ret['error'] );
				echo '<br/><a href="plugin.php?id=seotask&act=view&tid='.intval($_G['cookie']['tid']).'&lid='.intval($_G['cookie']['lid']).'">'.lang('plugin/seotask','s31').'</a>';
				exit;
			}
			C::t('#seotask#alj_seotask_log')->update_status_by_tid(intval($_G['cookie']['lid']),1);
			showmessage(lang('plugin/seotask','s14'),'plugin.php?id=seotask&act=view&tid='.intval($_G['cookie']['tid']).'&lid='.intval($_G['cookie']['lid']));
		}
		showmessage(lang('plugin/ljxlwb','lj_sinacg'),$_G['siteurl']);
	}
	$che=DB::fetch_first("select * from ".DB::table('plugin_lj_sina')." where  sinauid=".$token['uid']);
	
	if (!$che['uid']) {
		showmessage(lang('plugin/ljxlwb','lj_sinazh'),$_G[siteurl].'member.php?mod='.$_G['setting']['regname'].'&do=do');
	}else if(!$_G['uid']&&$che['sinauid']){
		$uid=$che['uid'];
		$member = getuserbyuid($uid);
		if(isset($member['_inarchive'])) {
			C::t('common_member_archive')->move_to_master($member['uid']);
		}
		require_once libfile('function/member');
		$cookietime = 1296000;
		setloginstatus($member, $cookietime);
		$params['mod'] = 'login';
		loadcache('usergroups');
		$param = array('username' => $member['username'], 'usergroup' => $_G['cache']['usergroups'][$member['groupid']]['grouptitle']);
		C::t('common_member_status')->update($member['uid'], array('lastip'=>$_G['clientip'], 'lastvisit'=>TIMESTAMP, 'lastactivity' => TIMESTAMP));
		$ucsynlogin = '';
		if($_G['setting']['allowsynlogin']) {
			loaducenter();
			$ucsynlogin = uc_user_synlogin($uid);
		}
		$token1=serialize($token);
		$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token['access_token']);
		$user_message = $c -> show_user_by_id($token[uid]);
		$sinausername=$user_message['name'];
		if($_G['charset']=='gbk'){
			$sinausername=$lj->u2g($user_message['name']);	
		}
		//debug($user_message);
		DB::update('plugin_lj_sina',array('token'=>$token1,'sina_username'=>$sinausername),"sinauid='".$token['uid']."'");
		showmessage('login_succeed', $_G['siteurl'], $param, array('extrajs' => $ucsynlogin));
	}	
}
$che=DB::fetch_first("select * from ".DB::table('plugin_lj_sina')." where  uid=".$_G['uid']);
$ispublishfeed=$che['fsign'];
$ispublisht=$che['hsign'];
$token1 = unserialize($che['token']);
if(!$che['sina_username']){
	$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token1['access_token']);
	$user_message = $c -> show_user_by_id($token1[uid]);
	//debug($user_message);
	$sinausername=$user_message['name'];
	if($_G['charset']=='gbk'){
		$sinausername=$lj->u2g($user_message['name']);	
	}
}else{
	$sinausername=$che['sina_username'];
}
$sinausername="<a target='_blank' style= 'color:#0072bc; text-decoration : underline ' href='http://weibo.com/u/".$token1[uid]."'>$sinausername</a>";
?>
