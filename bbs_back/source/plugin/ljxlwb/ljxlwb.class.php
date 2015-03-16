<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Deined');
} 

require_once DISCUZ_ROOT . 'source/plugin/ljxlwb/saetv2.ex.class.php';
require_once DISCUZ_ROOT . 'source/plugin/ljxlwb/config.php';
require_once DISCUZ_ROOT . 'source/plugin/ljxlwb/lj.class.php';
require_once libfile('function/discuzcode');
// debug(WB_CALLBACK_URL);
class plugin_ljxlwb {
	function global_login_extra() {
		$o = new SaeTOAuthV2(WB_AKEY , WB_SKEY);
		$code_url = $o -> getAuthorizeURL(WB_CALLBACK_URL);
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljxlwb'];
		$isindex = $config ['isindex'];
		if($isindex){
			return '<div style="margin-right: 10px; padding-right: 10px" class="fastlg_fm y">
	<p><a href="' . $code_url . '"><img src="source/plugin/ljxlwb/img/weibo_login.png" title="'.lang('plugin/ljxlwb','lj_sqym').'" alt="'.lang('plugin/ljxlwb','lj_sqym').'" border="0" /></a></p>
	<p style="padding-top: 2px;" class="hm xg1">'.lang('plugin/ljxlwb','lj_ksks').'</p>
	</div>';
		}else{
			return '';
		}
	} 
	function global_cpnav_extra1() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljxlwb'];
		$xluid = $config ['xluid'];
		$gzwz = $config ['gzwz'];
		$isgz = $config ['isgz'];
		if ($isgz) {
			if ($gzwz == 1) {
				return '<iframe allowtransparency="true" scrolling="no" border="0" width="120" height="24" style="  padding:4px 0 0 0" class="z" frameborder="0"   src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&width=136&height=24&uid=' . $xluid . '&style=2&btn=light&dpc=1"></iframe>';
			} 
		} 
	} 
	function global_nav_extra() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljxlwb'];
		$xluid = $config ['xluid'];
		$gzwz = $config ['gzwz'];
		$isgz = $config ['isgz'];
		if ($isgz) {
			if ($gzwz == 2) {
				return '<iframe allowtransparency="true" scrolling="no" border="0" width="120" height="24" style=" float: right; padding:4px 0 0 0" class="z" frameborder="0"   src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&width=136&height=24&uid=' . $xluid . '&style=2&btn=light&dpc=1"></iframe>';
			} 
		} 
	} 
	function index_status_extra() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljxlwb'];
		$xluid = $config ['xluid'];
		$gzwz = $config ['gzwz'];
		$isgz = $config ['isgz'];
		if ($isgz) {
			if ($gzwz == 3) {
				return '<style>#connectlike{ float:left;width:140px}</style><iframe allowtransparency="true" scrolling="no" border="0" width="120" height="24" style=" padding:4px 0 0 0" class="z" frameborder="0"   src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&width=136&height=24&uid=' . $xluid . '&style=2&btn=light&dpc=1"></iframe>';
			} 
		} 
	} 
	function global_cpnav_extra2() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['ljxlwb'];
		$xluid = $config ['xluid'];
		$gzwz = $config ['gzwz'];
		$isgz = $config ['isgz'];
		if ($isgz) {
			if ($gzwz == 4) {
				return '<iframe allowtransparency="true" scrolling="no" border="0" width="220" height="24"  class="z" frameborder="0"   src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&width=136&height=24&uid=' . $xluid . '&style=3&btn=light&dpc=1"></iframe>';
			} 
		} 
	}
	function global_usernav_extra1() {
		global $_G;
		$check = DB :: result_first("select count(*) from " . DB :: table('plugin_lj_sina') . " where  uid=" . $_G['uid']);

		if (!$check) {
			return '<span class="pipe">|</span><a href="' . $_G['siteurl'] . 'home.php?mod=spacecp&ac=plugin&id=ljxlwb:ljxlwb&opp=in&forcelogin=true" target="_blank" style="margin-right:5px"><img class="qq_bind" align="absmiddle" src="source/plugin/ljxlwb/img/weibo_bind.png"></a>';
		} 
		// return "http://widget.weibo.com/relationship/followbutton.php?btn=red&style=2&uid=2991975565&width=136&height=24&language=zh_cn";
	} 
	function global_login_text() {//帖内登录
		global $_G;
		$o = new SaeTOAuthV2(WB_AKEY , WB_SKEY);
		$code_url = $o -> getAuthorizeURL(WB_CALLBACK_URL);
			return '&nbsp;<a rel="nofollow" target="_top" href="'.$code_url.'"><img class="vm" src="source/plugin/ljxlwb/img/weibo_login.png"></a>';
		// return "http://widget.weibo.com/relationship/followbutton.php?btn=red&style=2&uid=2991975565&width=136&height=24&language=zh_cn";
	} 
	 
} 
class plugin_ljxlwb_member extends plugin_ljxlwb{
		//member.php?mod=logging&action=login&loginsubmit=yes&loginhash=Lk5U9

		function logging_ljxlwb_output(){
			global $_G,$ctl_obj;
			$token = dunserialize($_G['cookie']['sina_token']);
			if($token&&$_GET['do']=='yy'){
			
			$_SERVER['HTTP_REFERER']=$_G[siteurl];
			$_G[setting][regname]=$_G['setting']['regname'].'&do=do';
			$_G[setting]['reglinkname']=lang('plugin/ljxlwb','lj_wszh');
		}
		}
		function logging_top(){
			global $_G,$ctl_obj;
			$token = dunserialize($_G['cookie']['sina_token']);
			if($token&&$_GET['do']=='yy'){
			
				return '<div id="connect_member_loginbind_tip" class="rfm"><table><tbody><tr><th><img class="mtn" alt="sina" src="source/plugin/ljxlwb/img/sina_logo_1.png"></th><td>'.lang('plugin/ljxlwb','lj_bind').'</td></tr></tbody></table></div>';
			}

		}
		function register_logging_method(){
		global $_G;

		$o = new SaeTOAuthV2(WB_AKEY , WB_SKEY);
		$code_url = $o -> getAuthorizeURL(WB_CALLBACK_URL);
			
		//include template('mpage_weibo:logging_method');
		return '<a rel="nofollow" target="_top" href="'.$code_url.'"><img class="vm" src="source/plugin/ljxlwb/img/weibo_login.png"></a>';
		
	}
	function logging_method(){
		global $_G;
		$o = new SaeTOAuthV2(WB_AKEY , WB_SKEY);
		$code_url = $o -> getAuthorizeURL(WB_CALLBACK_URL);
		return '<a rel="nofollow" target="_top" href="'.$code_url.'"><img class="vm" src="source/plugin/ljxlwb/img/weibo_login.png"></a>';
	}
	function register_ljxlwb_output(){
		global $_G,$ctl_obj;
		$token = dunserialize($_G['cookie']['sina_token']);
		if($token&&$_GET['do']=='do'){
			$ctl_obj->setting['reglinkname']=lang('plugin/ljxlwb','lj_wszh');
		}
	}
	function register_top(){
		global $_G,$ctl_obj;
		$token = dunserialize($_G['cookie']['sina_token']);
		if($token&&$_GET['do']=='do'){
			return '<div style="display:block;" id="connect_member_register_tip" class="rfm"><table><tbody><tr><th><img class="mtn" alt="sina" src="source/plugin/ljxlwb/img/sina_logo_1.png"></th><td>'.lang('plugin/ljxlwb','lj_bindyy').'<a href="'.$_G[siteurl].'member.php?mod=logging&action=login&do=yy" >'.lang('plugin/ljxlwb','lj_yybind').'</a></td></tr></tbody></table></div>';
		}
	}
	function register_bottom(){//注册
		
			/*global $_G,$ctl_obj;
			$o = new SaeTOAuthV2(WB_AKEY , WB_SKEY);
		$code_url = $o -> getAuthorizeURL(WB_CALLBACK_URL);
		if($_GET['do']!='do'){
			return '<a rel="nofollow" target="_top" href="'.$code_url.'"><img class="vm" src="source/plugin/ljxlwb/img/weibo_login.png"></a>';
		}	*/
	}
	
	function logging_ljxlwb_message($param){
		//debug($_SESSION['token']);
		global $_G;
		//debug($_G['cookie']['sina_token']);
		$config = $_G['cache']['plugin']['ljxlwb'];
		$sinamessage = $config ['sinamessage'];
		$token = dunserialize($_G['cookie']['sina_token']);
		if($param['param'][0] == 'location_login_succeed' && $token){
			$lj=new lj();
		$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token['access_token']);
		$user_message = $c -> show_user_by_id($token['uid']); //根据ID获取用户等基本信息
		$sinausername=$user_message['name'];
		if($_G['charset']=='gbk'){
			$sinausername=$lj->u2g($user_message['name']);	
		}
		//debug($user_message);
		dsetcookie('sina_token', addslashes(serialize($token)), 86400);
			setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
			$check=DB::result_first("select count(*) from ".DB::table('plugin_lj_sina')." where  uid='".$_G['uid']."'");
			//debug($uid&&!$check);
			if($_G['uid']){
				$token1=serialize($token);
				$arr=array(
					'uid'=>$_G['uid'],	
					'sinauid'=>$token['uid'],	
					'fsign'=>1,
					'hsign'=>1,	
					'token'=>$token1,
					'sina_username'=>$sinausername,
				);
			if(!$check){
				DB::insert('plugin_lj_sina',$arr);
			}else{
				DB::update('plugin_lj_sina',$arr,"uid='".$_G['uid']."'");
			}
				//showmessage('绑定新浪微博成功！',$_G['siteurl']);
			}
		}
	}
	function register_ljxlwb_message($param){
		global $_G;
		$token = dunserialize($_G['cookie']['sina_token']);
		if($param['param'][0] == 'register_succeed' && $token){
				
			$lj=new lj();
			$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token['access_token']);
			$config = $_G['cache']['plugin']['ljxlwb'];
			$sinamessage = $config ['sinamessage'];
			$user_message = $c -> show_user_by_id($token['uid']); //根据ID获取用户等基本信息
			$sinausername=$user_message['name'];
			if($_G['charset']=='gbk'){
				$sinausername=$lj->u2g($user_message['name']);	
			}
			dsetcookie('sina_token', addslashes(serialize($token)), 86400);
			setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
			$check=DB::result_first("select count(*) from ".DB::table('plugin_lj_sina')." where  uid='".$_G['uid']."'");
			if($_G['uid']){
				$token1=serialize($token);
				$arr=array(
					'uid'=>$_G['uid'],	
					'sinauid'=>$token['uid'],	
					'fsign'=>1,
					'hsign'=>1,	
					'token'=>$token1,
					'sina_username'=>$sinausername,
				);
				if(!$check){
					DB::insert('plugin_lj_sina',$arr);
				}else{
					DB::update('plugin_lj_sina',$arr,"uid='".$_G['uid']."'");
				}
			}
		}
	}
}
class plugin_ljxlwb_forum extends plugin_ljxlwb {
	function post_checkreply_message($param) {
		global $_G;
		$config = $_G['cache']['plugin']['ljxlwb'];
		$web_root = $_G['siteurl'];
		if (substr($web_root, -1) != '/') {
			$web_root = $web_root . '/';
		} 
		$lj=new lj();
		$che = DB :: fetch_first("select * from " . DB :: table('plugin_lj_sina') . " where  uid=" . $_G['uid']);
		$fsign = $che['fsign'];
		$hsign = $che['hsign'];
		$token1 = unserialize($che['token']);
		$token = dunserialize($_G['cookie']['sina_token']);
		if ($token) {
			$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token['access_token']);
		} else {
			$c = new SaeTClientV2(WB_AKEY , WB_SKEY , $token1['access_token']);
		} 
		if ($param ['param'] [0] == "post_reply_succeed") {
			// 某某贴子有新的主题
			
				if ($_GET['ht']) {
					$fid = $param ['param'] [2][fid];

					$tid = $param ['param'] [2][tid];
					$pid = $param ['param'] [2][pid];
					$url = $web_root . "forum.php?mod=viewthread&tid=$tid";
					$message = DB :: result_first("select message from " . DB :: table('forum_post') . " where pid=$pid");
					$subject = DB :: result_first("select subject from " . DB :: table('forum_post') . " where tid=$tid and first=1");
					$message = lang('plugin/ljxlwb','lj_pl1') . $subject . lang('plugin/ljxlwb','lj_pl2') . $message;
					$message = discuzcode($message);
					$message = strip_tags($message);
					if($_G['charset']=='gbk'){
					if (!$lj->is_utf8($message)) {
						$message = $lj->g2u($message);
					} 
					}
					$length = 280 - ceil(strlen(urlencode($url)) * 0.5);

					$message = mb_substr($message, 0, $length); 
					// $o->update($message, NULL, NULL, NULL);
					// $length = 140 - ceil(strlen( urlencode($url) ) * 0.5);
					// $message = substr($message, $length);
					$message .= $url;

					$ret = $c -> update($message);
				} 
			 
		} 
		if ($param ['param'] [0] == "post_newthread_succeed") {
			// debug($param);
			// 某某版块有新的贴子
			
				if ($_GET['ft']) {
					$fid = $param ['param'] [2][fid];
					$tid = $param ['param'] [2][tid];
					$url = $web_root . "forum.php?mod=viewthread&tid=$tid";
					$mes = DB :: fetch_first("select subject,message from " . DB :: table('forum_post') . " where tid=$tid and first=1");
					$message = $mes['message'];
					preg_match_all("/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]|\[img=\d{1,4}[x|\,]\d{1,4}\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is",
	$message, $image1, PREG_SET_ORDER);
					$subject = $mes['subject'];
					$message = preg_replace('/\[attach\].+\[\/attach\]/is', '', $message);
					$message = preg_replace('/\[hide\].*?\[\/hide\]/is', '', $message);
					$message = preg_replace('/\{\:soso_e(\d+)\:\}/is', '', $message);
					$message = discuzcode($message);
					$message = strip_tags($message); 
					$message = str_replace('&nbsp;','', $message);
					// debug($message);
					
					$message=lang('plugin/ljxlwb','lj_pl3').$subject.lang('plugin/ljxlwb','lj_pl4').$message;
					if($_G['charset']=='gbk'){
					if (!$lj->is_utf8($message)) {
						$message = $lj->g2u($message);
					} 
					}
					$length = 300 - ceil(strlen(urlencode($url)) * 0.5);

					$message = mb_substr($message, 0, $length);

					$message .= $url; 
					// debug($message);
					// $ret = $c->update( $message );
					// debug($message);
					$tableid = DB :: result_first("select tableid from %t where tid=%d",array('forum_attachment',$tid));
					
					if($tableid){
						$t = "forum_attachment_" . $tableid;
						$turl = DB :: result_first("select attachment from %t where tid=%d and isimage='1'",array($t,$tid));
					}
					if ($turl||$image1) {
						if($turl){
							$furl=$web_root . 'data/attachment/forum/' .$turl;
						}else{
							if(count($image1)==1){
								$furl=$image1[0][1];
							}else{
								$furl=$image1[0][2];
							}
						}
						if($config ['isgj']){
							$ret = $c -> upload_url_text($message, $furl);
						}else{
							$ret = $c ->upload($message, $furl, $lat = NULL, $long = NULL );	
						}
					} else {
							$ret = $c -> update($message);	
					} 
					//$ret = $c -> update($message);
				} 
			
		} 
	} 

	function post_btn_extra() {
		// include template('ljtieziyj:tieziyj');
		global $_G;
		$che = DB :: fetch_first("select * from " . DB :: table('plugin_lj_sina') . " where  uid=" . $_G['uid']);
		$check=$che[sinauid];
		$fsign=$che[fsign];
		if ($check&&$fsign) {
			$biaoshi="checked ='checked'";
			$f="<input name='ft' type='checkbox' value='1'  $biaoshi />".lang('plugin/ljxlwb','lj_ft')."&nbsp;&nbsp;";
		}
		return $f;
		
	} 
	function viewthread_fastpost_btn_extra() {
		// include template('ljtieziyj:tieziyj');
		global $_G;
		$che = DB :: fetch_first("select * from " . DB :: table('plugin_lj_sina') . " where  uid=" . $_G['uid']);
		$check=$che[sinauid];
		$hsign=$che[hsign];
		if ($check&&$hsign) {
			$biaoshi="checked ='checked'";
			$h="<input name='ht' type='checkbox' value='1'  $biaoshi />".lang('plugin/ljxlwb','lj_ht')."&nbsp;&nbsp;";
		}
		return $h;
		
	} 
} 

?>