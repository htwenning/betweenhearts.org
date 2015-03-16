<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title>分类管理_<?php
echo $_obj['siteName'];
?>
</title><link href="./_static/style.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="../js/jquery.js"></script><script type="text/javascript" src="./_static/phpsay.js"></script><script language="javascript">$(document).ready(function(){$("form")[0].reset();});</script></head><body><div id="header"><div id="logo"><a href="./"><img src="../images/slogo.gif" alt="<?php
echo $_obj['siteName'];
?>
" title="<?php
echo $_obj['siteName'];
?>
" border="0" /></a></div><div id="info"><a href="http://www.phpsay.net/bar-1-1.html" target="_blank">站长交流</a>&nbsp;&nbsp;<a href="./" target="_top">管理中心首页</a>&nbsp;&nbsp;<a href="./?do=logout" target="_top">退出管理中心</a></div></div><div id="main"><div id="guid"><a href="../" target="_blank"><?php
echo $_obj['siteName'];
?>
</a> &gt; <a href="./">管理中心</a> &gt; <b>分类管理</b></div><div id="B"><div id="L"><div class="nameleft">系统管理</div><div class="nameleftcont"><ul><li><a href="./set_site.php">基本设置</a><ul><li><a href="./set_site.php">站点设置</a></li><li><a href="./set_mail.php">邮件设置</a></li><li><a href="./set_secure.php">Cookie设置</a></li><li><a href="./set_links.php">友情链接</a></li></ul></li><li><a href="./user_list.php">会员管理</a><ul><li><a href="./user_group.php">用 户 组</a></li><li><a href="./user_list.php">全部会员</a></li><li><a href="./user_black.php">黑 名 单</a></li></ul></li><li><a href="./category.php">分类目录</a><ul><li><a href="./category.php">分类管理</a></li><li><a href="./forum_category.php">吧分类审核</a></li></ul></li><li><a href="./forum_list.php">贴吧管理</a><ul><li><a href="./forum_list.php">全部贴吧</a></li><li><a href="./forum_temp.php">新吧审核</a></li><li><a href="./bm_apply.php">吧主审核</a></li><li><a href="./bm_apply.php?list=resign">辞职申请</a></li><li><a href="./set_filter.php">字词屏蔽</a></li></ul></li><li><a href="./topic_list.php">帖子管理</a><ul><li><a href="./topic_list.php">主题管理</a></li><li><a href="./post_list.php">全帖管理</a></li><li><a href="./report_list.php">举报管理</a></li></ul></li><li><a href="./db_manage.php">数据管理</a><ul><li><a href="./db_export.php">数据备份</a></li><li><a href="./db_import.php">数据还原</a></li></ul></li></ul></div></div> <div id="R"><div class="nameset">分类管理</div><div class="namecont"><table width="100%" cellspacing="0" cellpadding="0"><?php
if (!empty($_obj['category'])){
?><tr class="tr1"><td class="td1" width="20%" align="center"><u>父</u></td><td class="td1" width="20%" align="center"><u>子</u></td><td class="td1" width="15%" align="center"></td><td class="td1" width="15%" align="center"></td></tr><?php
if (!empty($_obj['category'])){
if (!is_array($_obj['category']))
$_obj['category']=array(array('category'=>$_obj['category']));
$_tmp_arr_keys=array_keys($_obj['category']);
if ($_tmp_arr_keys[0]!='0')
$_obj['category']=array(0=>$_obj['category']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['category'] as $rowcnt=>$v) {
if (is_array($v)) $category=$v; else $category=array();
$category['ROWVAL']=$v;
$category['ROWCNT']=$rowcnt;
$category['ROWBIT']=$rowcnt%2;
$_obj=&$category;
?><tr><td align="center"><b><?php
echo $_obj['name'];
?>
</b></td><td class="td2">&nbsp;</td><td align="center"><a href="#edit" onclick="updateCategory(<?php
echo $_obj['cid'];
?>
,0,'<?php
echo $_obj['name'];
?>
');">修改</a></td><td align="center"><a href="javascript:;" onclick="delCategory(<?php
echo $_obj['cid'];
?>
);">删除</a></td></tr><tr class="td3"><td colspan="4"></td></tr><?php
if (!empty($_obj['subcategory'])){
if (!is_array($_obj['subcategory']))
$_obj['subcategory']=array(array('subcategory'=>$_obj['subcategory']));
$_tmp_arr_keys=array_keys($_obj['subcategory']);
if ($_tmp_arr_keys[0]!='0')
$_obj['subcategory']=array(0=>$_obj['subcategory']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['subcategory'] as $rowcnt=>$v) {
if (is_array($v)) $subcategory=$v; else $subcategory=array();
$subcategory['ROWVAL']=$v;
$subcategory['ROWCNT']=$rowcnt;
$subcategory['ROWBIT']=$rowcnt%2;
$_obj=&$subcategory;
?><tr><td class="td2">&nbsp;</td><td align="center"><?php
echo $_obj['name'];
?>
</td><td align="center"><a href="#edit" onclick="updateCategory(<?php
echo $_obj['cid'];
?>
,<?php
echo $_obj['fid'];
?>
,'<?php
echo $_obj['name'];
?>
');">修改</a></td><td align="center"><a href="javascript:;" onclick="delCategory(<?php
echo $_obj['cid'];
?>
);">删除</a></td></tr><tr class="td3"><td colspan="4"></td></tr><?php
}
$_obj=$_stack[--$_stack_cnt];}
?><?php
}
$_obj=$_stack[--$_stack_cnt];}
?><?php
}
?><tr><td colspan="4" class="td2"><a name="#edit">&nbsp;</a></td></tr><tr><td colspan="4" align="center"><form name="cForm" id="cForm" method="post" target="sypost" action="./category.php?action=do"><select id="father" name="father"><option value="0">一级目录</option><?php
if (!empty($_obj['category'])){
if (!is_array($_obj['category']))
$_obj['category']=array(array('category'=>$_obj['category']));
$_tmp_arr_keys=array_keys($_obj['category']);
if ($_tmp_arr_keys[0]!='0')
$_obj['category']=array(0=>$_obj['category']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['category'] as $rowcnt=>$v) {
if (is_array($v)) $category=$v; else $category=array();
$category['ROWVAL']=$v;
$category['ROWCNT']=$rowcnt;
$category['ROWBIT']=$rowcnt%2;
$_obj=&$category;
?><option value="<?php
echo $_obj['cid'];
?>
"><?php
echo $_obj['name'];
?>
</option><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></select><input type="text" id="name" name="name" value="" maxlength="10" class="ipt"><input type="hidden" id="cid" name="cid" value="0"><input type="submit" value="新建分类" class="btn"></form><iframe scrolling=no width=0 height=0 src="javascript:void(0);" name="sypost" id="sypost" style="display: none"></iframe></td></tr><tr><td colspan="4" class="td2">&nbsp;</td></tr></table></div></div></div></div><div id="footer">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &#169; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.Com</a> All Rights Reserved.</div></body></html>