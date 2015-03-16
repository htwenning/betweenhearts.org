<?php
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_forum.php";
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_member.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title>申请审核_<?php
echo $_obj['siteName'];
?>
</title><link href="./_static/style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="../js/jquery.js"></script><script type="text/javascript" src="./_static/phpsay.js"></script></head><body><div id="header"><div id="logo"><a href="./"><img src="../images/slogo.gif" alt="<?php
echo $_obj['siteName'];
?>
" title="<?php
echo $_obj['siteName'];
?>
" border="0" /></a></div><div id="info"><a href="http://www.phpsay.net/bar-1-1.html" target="_blank">站长交流</a>&nbsp;&nbsp;<a href="./" target="_top">管理中心首页</a>&nbsp;&nbsp;<a href="./?do=logout" target="_top">退出管理中心</a></div></div><div id="main"><div id="guid"><a href="../" target="_blank"><?php
echo $_obj['siteName'];
?>
</a> &gt; <a href="./">管理中心</a> &gt; <b>申请审核</b></div><div id="B"><div id="L"><div class="nameleft">系统管理</div><div class="nameleftcont"><ul><li><a href="./set_site.php">基本设置</a><ul><li><a href="./set_site.php">站点设置</a></li><li><a href="./set_mail.php">邮件设置</a></li><li><a href="./set_secure.php">Cookie设置</a></li><li><a href="./set_links.php">友情链接</a></li></ul></li><li><a href="./user_list.php">会员管理</a><ul><li><a href="./user_group.php">用 户 组</a></li><li><a href="./user_list.php">全部会员</a></li><li><a href="./user_black.php">黑 名 单</a></li></ul></li><li><a href="./category.php">分类目录</a><ul><li><a href="./category.php">分类管理</a></li><li><a href="./forum_category.php">吧分类审核</a></li></ul></li><li><a href="./forum_list.php">贴吧管理</a><ul><li><a href="./forum_list.php">全部贴吧</a></li><li><a href="./forum_temp.php">新吧审核</a></li><li><a href="./bm_apply.php">吧主审核</a></li><li><a href="./bm_apply.php?list=resign">辞职申请</a></li><li><a href="./set_filter.php">字词屏蔽</a></li></ul></li><li><a href="./topic_list.php">帖子管理</a><ul><li><a href="./topic_list.php">主题管理</a></li><li><a href="./post_list.php">全帖管理</a></li><li><a href="./report_list.php">举报管理</a></li></ul></li><li><a href="./db_manage.php">数据管理</a><ul><li><a href="./db_export.php">数据备份</a></li><li><a href="./db_import.php">数据还原</a></li></ul></li></ul></div></div> <div id="R"><div class="nameset">申请审核</div><div class="namecont"><table width="100%" cellspacing="0" cellpadding="0"><tr class="tr1"><td width="11%"></td><td class="td1" width="10%" align="center">类型</td><td class="td1" width="15%">贴吧</td><td class="td1" width="12%">申请人</td><td class="td1">申请理由</td><td class="td1" width="12%" align="right">申请时间</td></tr><?php
if (!empty($_obj['applyArr']['Apply'])){
if (!is_array($_obj['applyArr']['Apply']))
$_obj['applyArr']['Apply']=array(array('Apply'=>$_obj['applyArr']['Apply']));
$_tmp_arr_keys=array_keys($_obj['applyArr']['Apply']);
if ($_tmp_arr_keys[0]!='0')
$_obj['applyArr']['Apply']=array(0=>$_obj['applyArr']['Apply']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['applyArr']['Apply'] as $rowcnt=>$v) {
if (is_array($v)) $Apply=$v; else $Apply=array();
$Apply['ROWVAL']=$v;
$Apply['ROWCNT']=$rowcnt;
$Apply['ROWBIT']=$rowcnt%2;
$_obj=&$Apply;
?><tr><td class="td2" align="center"><a href="javascript:;" onclick="applyAuditing(<?php
echo $_obj['aid'];
?>
,1);">通过</a>&nbsp;&nbsp;<a href="javascript:;" onclick="applyAuditing(<?php
echo $_obj['aid'];
?>
,0);">删除</a></td><td class="td2" align="center"><?php
if ($_obj['type'] == "1"){
?>申请吧主<?php
} else {
?>吧主辞职<?php
}
?></td><td class="td2"><a href="<?php
echo phpsay_rewrite_forum($_obj['fid']);
?>
" target="_blank"><?php
echo $_obj['fname'];
?>
</a></td><td class="td2"><a href="<?php
echo phpsay_rewrite_member($_obj['uid']);
?>
" target="_blank"><?php
echo $_obj['uname'];
?>
</a></td><td class="td2"><?php
echo $_obj['message'];
?>
</td><td class="td2" align="right"><?php
echo $_obj['dateline'];
?>
</td></tr><tr class="td3"><td colspan="6"></td></tr><?php
}
$_obj=$_stack[--$_stack_cnt];}
?><?php
if ($_obj['applyArr']['Page']['pageTotal'] > "1"){
?><tr><td colspan="6" class="td4" align="center"><?php
echo $_obj['applyArr']['Page']['pageList'];
?>
</td></tr><?php
}
?></table></div></div></div></div><div id="footer">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &#169; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.Com</a> All Rights Reserved.</div></body></html>