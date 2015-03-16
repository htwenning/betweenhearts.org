<?php
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_topic.php";
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_member.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title>主题帖管理_<?php
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
</a> &gt; <a href="./">管理中心</a> &gt; <b>主题帖管理</b></div><div id="B"><div id="L"><div class="nameleft">系统管理</div><div class="nameleftcont"><ul><li><a href="./set_site.php">基本设置</a><ul><li><a href="./set_site.php">站点设置</a></li><li><a href="./set_mail.php">邮件设置</a></li><li><a href="./set_secure.php">Cookie设置</a></li><li><a href="./set_links.php">友情链接</a></li></ul></li><li><a href="./user_list.php">会员管理</a><ul><li><a href="./user_group.php">用 户 组</a></li><li><a href="./user_list.php">全部会员</a></li><li><a href="./user_black.php">黑 名 单</a></li></ul></li><li><a href="./category.php">分类目录</a><ul><li><a href="./category.php">分类管理</a></li><li><a href="./forum_category.php">吧分类审核</a></li></ul></li><li><a href="./forum_list.php">贴吧管理</a><ul><li><a href="./forum_list.php">全部贴吧</a></li><li><a href="./forum_temp.php">新吧审核</a></li><li><a href="./bm_apply.php">吧主审核</a></li><li><a href="./bm_apply.php?list=resign">辞职申请</a></li><li><a href="./set_filter.php">字词屏蔽</a></li></ul></li><li><a href="./topic_list.php">帖子管理</a><ul><li><a href="./topic_list.php">主题管理</a></li><li><a href="./post_list.php">全帖管理</a></li><li><a href="./report_list.php">举报管理</a></li></ul></li><li><a href="./db_manage.php">数据管理</a><ul><li><a href="./db_export.php">数据备份</a></li><li><a href="./db_import.php">数据还原</a></li></ul></li></ul></div></div> <div id="R"><div class="nameset">当前共找到 <?php
echo $_obj['topicArr']['Total'];
?>
 篇主题帖</div><div class="namecont"><table width="100%" cellspacing="0" cellpadding="0"><tr><td colspan="5" class="td4"><form name="soForm" id="soForm" method="get"><input type="text" id="wd" name="wd" value="" maxlength="15" class="ipt"><input type="submit" value="搜索" class="btn"></form></td></tr><tr class="tr1"><td class="td1" width="30" align="center"><a href="javascript:selectAll();">全</a>|<a href="javascript:toggleSelect();">反</a></td><td class="td1" width="80">点击/回复</td><td class="td1" width="*">标题</td><td class="td1" width="85"><u>作者</u></td><td class="td1" width="135"><u>最后回复</u></td></tr><?php
if (!empty($_obj['topicArr']['Topic'])){
if (!is_array($_obj['topicArr']['Topic']))
$_obj['topicArr']['Topic']=array(array('Topic'=>$_obj['topicArr']['Topic']));
$_tmp_arr_keys=array_keys($_obj['topicArr']['Topic']);
if ($_tmp_arr_keys[0]!='0')
$_obj['topicArr']['Topic']=array(0=>$_obj['topicArr']['Topic']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['topicArr']['Topic'] as $rowcnt=>$v) {
if (is_array($v)) $Topic=$v; else $Topic=array();
$Topic['ROWVAL']=$v;
$Topic['ROWCNT']=$rowcnt;
$Topic['ROWBIT']=$rowcnt%2;
$_obj=&$Topic;
?><tr><td class="td2" align="center"><input type="checkbox" class="operchk" value="<?php
echo $_obj['tid'];
?>
" /></td><td class="td2"><?php
echo $_obj['views'];
?>
/<?php
echo $_obj['replies'];
?>
</td><td class="td2"><a href="<?php
echo phpsay_rewrite_topic($_obj['tid']);
?>
" title="<?php
echo $_obj['title'];
?>
" target="_blank"><?php
echo $_obj['subject'];
?>
</a></td><td class="td2"><?php
if ($_obj['authorid'] > "0"){
?><a href="<?php
echo phpsay_rewrite_member($_obj['authorid']);
?>
" target="_blank"><?php
echo $_obj['author'];
?>
</a><?php
} else {
?><?php
echo $_obj['author'];
?>
<?php
}
?></td><td class="td2"><?php
echo $_obj['lasttime'];
?>
&nbsp;/&nbsp;<?php
if ($_obj['lastauthorid'] > "0"){
?><a href="<?php
echo phpsay_rewrite_member($_obj['lastauthorid']);
?>
" target="_blank"><?php
echo $_obj['lastauthor'];
?>
</a><?php
} else {
?><?php
echo $_obj['lastauthor'];
?>
<?php
}
?></td></tr><tr class="td3"><td colspan="5"></td></tr><?php
}
$_obj=$_stack[--$_stack_cnt];}
?><tr><td class="td2" align="center"><a href="javascript:delSelItems();">删除</a></td><td colspan="4" class="td4" align="center"><?php
echo $_obj['topicArr']['Page']['pageList'];
?>
</td></tr></table></div></div></div></div><div id="footer">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &#169; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.Com</a> All Rights Reserved.</div></body></html>