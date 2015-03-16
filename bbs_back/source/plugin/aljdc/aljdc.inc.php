<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(empty($_G['uid'])){
	showmessage(lang('plugin/aljdc','dc1'));
}
$dc=array('big'=>lang('plugin/aljdc','dc2'),'small'=>lang('plugin/aljdc','dc3'),'baozi'=>lang('plugin/aljdc','dc4'));
$config=$_G['cache']['plugin']['aljdc'];
$check=C::t('#aljdc#alj_dc_user')->fetch($_G['uid']);
if(!$check&&$_G['uid']){
	C::t('#aljdc#alj_dc_user')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'anum'=>'anum+1','dateline'=>TIMESTAMP,'lasttime'=>TIMESTAMP));
}
$users=C::t('#aljdc#alj_dc_user')->range(0,8,'desc');
$count=DB::result_first("select count(*) from ".DB::table('alj_dc_log')." where uid=".$_G['uid']);
$_G['setting']['switchwidthauto']=0;
$_G['setting']['allowwidthauto']=1;

$mycredit=C::t('#aljdc#alj_dc_user')->fetch_extcredits($_G['uid'],$config['credit']);

$loglist=DB::fetch_all("select * from ".DB::table('alj_dc_log')." where uid=".$_G['uid']." order by id desc limit 0,8");
include template('aljdc:index');
?>