<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title>用户组_<?php
echo $_obj['siteName'];
?>
</title><link href="./_static/style.css" rel="stylesheet" type="text/css" /></head><body><div id="header"><div id="logo"><a href="./"><img src="../images/slogo.gif" alt="<?php
echo $_obj['siteName'];
?>
" title="<?php
echo $_obj['siteName'];
?>
" border="0" /></a></div><div id="info"><a href="http://www.phpsay.net/bar-1-1.html" target="_blank">站长交流</a>&nbsp;&nbsp;<a href="./" target="_top">管理中心首页</a>&nbsp;&nbsp;<a href="./?do=logout" target="_top">退出管理中心</a></div></div><div id="main"><div id="guid"><a href="../" target="_blank"><?php
echo $_obj['siteName'];
?>
</a> &gt; <a href="./">管理中心</a> &gt; <b>用户组</b></div><div id="B"><div id="L"><div class="nameleft">系统管理</div><div class="nameleftcont"><ul><li><a href="./set_site.php">基本设置</a><ul><li><a href="./set_site.php">站点设置</a></li><li><a href="./set_mail.php">邮件设置</a></li><li><a href="./set_secure.php">Cookie设置</a></li><li><a href="./set_links.php">友情链接</a></li></ul></li><li><a href="./user_list.php">会员管理</a><ul><li><a href="./user_group.php">用 户 组</a></li><li><a href="./user_list.php">全部会员</a></li><li><a href="./user_black.php">黑 名 单</a></li></ul></li><li><a href="./category.php">分类目录</a><ul><li><a href="./category.php">分类管理</a></li><li><a href="./forum_category.php">吧分类审核</a></li></ul></li><li><a href="./forum_list.php">贴吧管理</a><ul><li><a href="./forum_list.php">全部贴吧</a></li><li><a href="./forum_temp.php">新吧审核</a></li><li><a href="./bm_apply.php">吧主审核</a></li><li><a href="./bm_apply.php?list=resign">辞职申请</a></li><li><a href="./set_filter.php">字词屏蔽</a></li></ul></li><li><a href="./topic_list.php">帖子管理</a><ul><li><a href="./topic_list.php">主题管理</a></li><li><a href="./post_list.php">全帖管理</a></li><li><a href="./report_list.php">举报管理</a></li></ul></li><li><a href="./db_manage.php">数据管理</a><ul><li><a href="./db_export.php">数据备份</a></li><li><a href="./db_import.php">数据还原</a></li></ul></li></ul></div></div> <div id="R"><div class="nameset">用户组</div><div class="namecont"><form name="groupForm" id="groupForm" method="post" target="sypost" action="./user_group.php?action=update"><table width="100%" cellspacing="0" cellpadding="0"><tr class="tr1"><td class="td1" align="center"><strong>&nbsp;</strong></td><td width="30%" align="center"><strong>用户组名称</strong></td><td width="15%" align="center"><strong>允许主题帖</strong></td><td width="15%" align="center"><strong>允许回帖</strong></td><td width="15%" align="center"><strong>发帖验证码</strong></td><td width="15%" align="center"><strong>上传图片</strong></td></tr><?php
if (!empty($_obj['userGroup'])){
if (!is_array($_obj['userGroup']))
$_obj['userGroup']=array(array('userGroup'=>$_obj['userGroup']));
$_tmp_arr_keys=array_keys($_obj['userGroup']);
if ($_tmp_arr_keys[0]!='0')
$_obj['userGroup']=array(0=>$_obj['userGroup']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['userGroup'] as $rowcnt=>$v) {
if (is_array($v)) $userGroup=$v; else $userGroup=array();
$userGroup['ROWVAL']=$v;
$userGroup['ROWCNT']=$rowcnt;
$userGroup['ROWBIT']=$rowcnt%2;
$_obj=&$userGroup;
?><tr><td class="td2" align="center"><input type="text" name="ID[]" value="<?php
echo $_obj['ROWCNT'];
?>
" class="ipt" readonly style="width:25px;background:#f0f0f0;"></td><td align="center"><input type="text" name="NAME[]" value="<?php
echo $_obj['name'];
?>
" maxlength="6" class="ipt"<?php
if ($_obj['ROWCNT'] >= "4"){
?> readonly<?php
}
?> style="width:95px;<?php
if ($_obj['ROWCNT'] >= "4"){
?>background:#f0f0f0;<?php
}
?>"></td><td align="center"><select name="TOPIC[]"><option value="1"<?php
if ($_obj['topic'] == "1"){
?> selected<?php
}
?>>允许</option><option value="0"<?php
if ($_obj['topic'] == "0"){
?> selected<?php
}
?>>禁止</option></select></td><td align="center"><select name="REPLY[]"><option value="1"<?php
if ($_obj['reply'] == "1"){
?> selected<?php
}
?>>允许</option><option value="0"<?php
if ($_obj['reply'] == "0"){
?> selected<?php
}
?>>禁止</option></select></td><td align="center"><select name="VERIFY[]"><option value="1"<?php
if ($_obj['verify'] == "1"){
?> selected<?php
}
?>>开启</option><option value="0"<?php
if ($_obj['verify'] == "0"){
?> selected<?php
}
?>>关闭</option></select></td><td align="center"><select name="UPLOAD[]"><option value="1"<?php
if ($_obj['upload'] == "1"){
?> selected<?php
}
?>>允许</option><option value="0"<?php
if ($_obj['upload'] == "0"){
?> selected<?php
}
?>>禁止</option></select></td></tr><tr class="td3"><td colspan="5"></td></tr><?php
}
$_obj=$_stack[--$_stack_cnt];}
?><tr><td colspan="5" align="center"><input type="submit" value="修 改" class="sub"></td></tr><tr><td colspan="5" class="td2">&nbsp;</td></tr></table></form><iframe scrolling=no width=0 height=0 src="javascript:void(0);" name="sypost" id="sypost" style="display: none"></iframe></div></div></div></div><div id="footer">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &#169; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.Com</a> All Rights Reserved.</div></body></html>