<?php
if(!defined('IN_DISCUZ')){
	exit('Access Denied!');
}
$config=$_G['cache']['plugin']['aljhd'];
$navtitle = $config['title'];
$metakeywords =  $config['keywords'];
$metadescription = $config['description'];
$typelist = explode ("\n", str_replace ("\r", "", $config ['type']));
foreach($typelist as $key=>$value){
	$arr=explode('|',$value);
	$types[$arr[0]]=$arr[1];
}

$_G['setting']['switchwidthauto']=0;
$_G['setting']['allowwidthauto']=1;
$yhz=unserialize($config['yhz']);
if($_GET['act']=='add'){
	
	if(submitcheck('submit')){
		if(!in_array($_G['groupid'],$yhz)){
			debug('Access Denied!');
		}
		if($_FILES['logo']['tmp_name']) {
			$picname = $_FILES['logo']['name'];
			$picsize = $_FILES['logo']['size'];

			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
					showmessage('type error!');
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$logo = "source/plugin/aljhd/images/logo/". $pics;
				move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
			}
		}
		$insertarray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'title'=>$_GET['title'],
			'type'=>$_GET['type'],
			'url'=>$_GET['url'],
			'starttime'=>strtotime($_GET['starttime']),
			'endtime'=>strtotime($_GET['endtime']),
			'logo'=>$logo,
			'place'=>$_GET['place'],
			'desc'=>$_GET['desc'],
			'dateline'=>TIMESTAMP,
			'ym'=>gmdate('Y-m',strtotime($_GET['starttime'])+3600*8),
		);
		C::t('#aljhd#alj_hd')->insert($insertarray);
		showmessage(lang('plugin/aljhd','hd1'),'plugin.php?id=aljhd');
	}else{
		//debug(!submitcheck('act',1));
		if(!in_array($_G['groupid'],$yhz)||!submitcheck('act',1)){
			debug('Access Denied!');
		}
		if(preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) != preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])){
			debug('Access Denied!');
		}
		include template('aljhd:add');
		
	}
}else if($_GET['act']=='edit'){
	if(submitcheck('submit')){
		if($_FILES['logo']['tmp_name']) {
			$picname = $_FILES['logo']['name'];
			$picsize = $_FILES['logo']['size'];

			if ($picname != "") {
				$type = strstr($picname, '.');
				if ($type != ".gif" && $type != ".jpg"&& $type != ".png") {
					showmessage('type error!');
				}
				$rand = rand(100, 999);
				$pics = date("YmdHis") . $rand . $type;
				$logo = "source/plugin/aljhd/images/logo/". $pics;
				move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
			}
		}
		$updatearray=array(
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'title'=>$_GET['title'],
			'type'=>$_GET['type'],
			'url'=>$_GET['url'],
			'starttime'=>strtotime($_GET['starttime']),
			'endtime'=>strtotime($_GET['endtime']),
			'place'=>$_GET['place'],
			'desc'=>$_GET['desc'],
			'dateline'=>TIMESTAMP,
			'ym'=>gmdate('Y-m',strtotime($_GET['starttime'])+3600*8),
		);
		if($logo){
			$updatearray['logo']=$logo;
		}
		C::t('#aljhd#alj_hd')->update($_GET['hid'],$updatearray);
		showmessage(lang('plugin/aljhd','hd2'),'plugin.php?id=aljhd');
	}else{
		if($_G['groupid']!=1||!submitcheck('act',1)){
			debug('Access Denied!');
		}
		if(preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) != preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])){
			debug('Access Denied!');
		}
		$hd=C::t('#aljhd#alj_hd')->fetch($_GET['hid']);
		include template('aljhd:edit');
	}
}else if($_GET['act']=='delete'){
	if($_G['groupid']!=1||!submitcheck('act',1)){
		debug('Access Denied!');
	}
	if(preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) != preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])){
		debug('Access Denied!');
	}
	if($_GET['hid']){
		C::t('#aljhd#alj_hd')->delete($_GET['hid']);
	}
	showmessage(lang('plugin/aljhd','hd3'),'plugin.php?id=aljhd');
}else{
	$ymlist=C::t('#aljhd#alj_hd')->fetch_all_by_ym();
	$typelist=C::t('#aljhd#alj_hd')->fetch_all_by_type();
	
	$currpage=$_GET['page']?$_GET['page']:1;
	$perpage=$config['page'];
	$num=C::t('#aljhd#alj_hd')->count_by_ym_type_status($_GET['ym'],$_GET['type'],$_GET['status']);
	$start=($currpage-1)*$perpage;
	$hdlist=C::t('#aljhd#alj_hd')->fetch_all_by_ym_type_status($_GET['ym'],$_GET['type'],$_GET['status'],$start,$perpage);
	$paging = helper_page :: multi($num, $perpage, $currpage, 'plugin.php?id=aljhd&ym='.$_GET['ym'].'&type='.$_GET['type'].'&status='.$_GET['status'], 0, 11, false, false);
	
	include template('aljhd:index');
}


?>