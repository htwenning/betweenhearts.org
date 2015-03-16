<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title>邮件设置_<?php
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
</a> &gt; <a href="./">管理中心</a> &gt; <b>邮件设置</b></div><div id="B"><div id="L"><div class="nameleft">系统管理</div><div class="nameleftcont"><ul><li><a href="./set_site.php">基本设置</a><ul><li><a href="./set_site.php">站点设置</a></li><li><a href="./set_mail.php">邮件设置</a></li><li><a href="./set_secure.php">Cookie设置</a></li><li><a href="./set_links.php">友情链接</a></li></ul></li><li><a href="./user_list.php">会员管理</a><ul><li><a href="./user_group.php">用 户 组</a></li><li><a href="./user_list.php">全部会员</a></li><li><a href="./user_black.php">黑 名 单</a></li></ul></li><li><a href="./category.php">分类目录</a><ul><li><a href="./category.php">分类管理</a></li><li><a href="./forum_category.php">吧分类审核</a></li></ul></li><li><a href="./forum_list.php">贴吧管理</a><ul><li><a href="./forum_list.php">全部贴吧</a></li><li><a href="./forum_temp.php">新吧审核</a></li><li><a href="./bm_apply.php">吧主审核</a></li><li><a href="./bm_apply.php?list=resign">辞职申请</a></li><li><a href="./set_filter.php">字词屏蔽</a></li></ul></li><li><a href="./topic_list.php">帖子管理</a><ul><li><a href="./topic_list.php">主题管理</a></li><li><a href="./post_list.php">全帖管理</a></li><li><a href="./report_list.php">举报管理</a></li></ul></li><li><a href="./db_manage.php">数据管理</a><ul><li><a href="./db_export.php">数据备份</a></li><li><a href="./db_import.php">数据还原</a></li></ul></li></ul></div></div> <div id="R"><div class="nameset">邮件设置</div><div class="namecont"><form name="setForm" id="setForm" method="post" target="sypost" action="./set_mail.php?action=update"><table width="90%" align="center" cellpadding="4" cellspacing="4" style="padding:20px 10px;"><tr><td height="30" colspan="2"></td></tr><tr><td align="right" width="30%">发送方式：</td><td><select name="T" /><option value="sendmail"<?php
if ($_obj['mailType'] == "sendmail"){
?> selected<?php
}
?>>sendmail</option><option value="smtp"<?php
if ($_obj['mailType'] == "smtp"){
?> selected<?php
}
?>>smtp</option></select></td></tr><tr><td align="right">发件人邮箱：</td><td><input type="text" name="E" class="inp" value="<?php
echo $_obj['sendEmail'];
?>
" /></td></tr><tr class="tr1"><td class="td1" colspan="2" align="center"><b>以下设置仅在发送方式为 smtp 时有效</b></td></tr><tr><td align="right">SMTP 服务器：</td><td><input type="text" name="S" class="inp" value="<?php
echo $_obj['smtpServer'];
?>
" /></td></tr><tr><td align="right">SMTP 端口：</td><td><input type="text" name="P" class="inp" value="<?php
echo $_obj['smtpPort'];
?>
" /></td></tr><tr><td align="right">SMTP 服务器要求身份验证：</td><td><input type="radio" name="A" value="true"<?php
if ($_obj['smtpAuth'] == "1"){
?> checked<?php
}
?> />是<input type="radio" name="A" value="false"<?php
if ($_obj['smtpAuth'] == "0"){
?> checked<?php
}
?> />否</td></tr><tr><td align="right">SMTP 用户：</td><td><input type="text" name="U" class="inp" value="<?php
echo $_obj['smtpUser'];
?>
" /></td></tr><tr><td align="right">SMTP 密码：</td><td><input type="text" name="W" class="inp" value="<?php
echo $_obj['smtpPassword'];
?>
" /></td></tr><tr><td></td><td><input type="submit" value="修改设置" class="sub"></td></tr><tr><td height="30" colspan="2"></td></tr></table></form><iframe scrolling=no width=0 height=0 src="javascript:void(0);" name="sypost" id="sypost" style="display: none"></iframe></div></div></div></div><div id="footer">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &#169; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.Com</a> All Rights Reserved.</div></body></html>