<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(empty($_G['uid'])){
	showmessage(lang('plugin/aljdc','dc1'));
}
$dc=array('big'=>lang('plugin/aljdc','dc2'),'small'=>lang('plugin/aljdc','dc3'),'baozi'=>lang('plugin/aljdc','dc4'));
$config=$_G['cache']['plugin']['aljdc'];
$count=DB::result_first("select count(*) from ".DB::table('alj_dc_log')." where from_unixtime(dateline,'%Y%m%d')='".gmdate('Ymd',TIMESTAMP+3600*8)."' and uid=".$_G['uid']);
if($count>=$config['num']){
	showmessage(lang('plugin/aljdc','dc5').$config['num'].lang('plugin/aljdc','dc6'));
}

$mycredit=C::t('#aljdc#alj_dc_user')->fetch_extcredits($_G['uid'],$config['credit']);

$ante=intval($_GET['ante']);
$dctype=$_GET['dctype'];
if($mycredit<$ante){
	showmessage(lang('plugin/aljdc','dc7'));
}
if($config['min']>$ante){
	showmessage(lang('plugin/aljdc','dc8').$config['min']);
}
if($config['max']<$ante){
	showmessage(lang('plugin/aljdc','dc9').$config['max']);
}
if(submitcheck('mysubmit')){
	$rand_a = array(mt_rand(1,6),mt_rand(1,6),mt_rand(1,6));
	$rand_n = array_sum($rand_a);
	$rate	= -1;
	if ($rand_n > 10 && $rand_n < 18) {
		$result = 'big';
		if($dctype==$result){
			$sign=1;
			$add=$config['drate']*$ante;
			updatemembercount($_G['uid'],array($config['credit']=>$add));
			$ret=lang('plugin/aljdc','dc10').$dc['big'].lang('plugin/aljdc','dc11').$dc['big'].lang('plugin/aljdc','dc12').$add.lang('plugin/aljdc','dc13');
		}
	} elseif ($rand_n > 3 && $rand_n < 11) {
		$result = 'small';
		if($dctype==$result){
			$sign=1;
			$add=$config['drate']*$ante;
			updatemembercount($_G['uid'],array($config['credit']=>$add));
			$ret=lang('plugin/aljdc','dc10').$dc['small'].lang('plugin/aljdc','dc11').$dc['small'].lang('plugin/aljdc','dc12').$add.lang('plugin/aljdc','dc13');
		}
	} else {
		$result = 'baozi';
		if($dctype==$result){
			$sign=1;
			$add=$config['brate']*$ante;
			updatemembercount($_G['uid'],array($config['credit']=>$add));
			$ret=lang('plugin/aljdc','dc13').$add.lang('plugin/aljdc','dc13');
		}
	}
	if(empty($sign)){
		$sign=0;
		$add=intval('-'.$ante);
		updatemembercount($_G['uid'],array($config['credit']=>$add));
		$ret=lang('plugin/aljdc','dc15').$dc[$dctype].lang('plugin/aljdc','dc16').$dc[$result].lang('plugin/aljdc','dc17').$ante.lang('plugin/aljdc','dc13');
	}
	C::t('#aljdc#alj_dc_log')->insert(array('uid'=>$_G['uid'],'username'=>$_G['username'],'mydc'=>$dctype,'result'=>$result,'ret'=>$ret,'mynum'=>$ante,'dcnum'=>$add,'dateline'=>TIMESTAMP,'isnot'=>$sign));
	showmessage($ret,'plugin.php?id=aljdc');
	
}



?>