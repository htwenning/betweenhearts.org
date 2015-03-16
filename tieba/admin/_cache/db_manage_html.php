<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title>数据管理_<?php
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
</a> &gt; <a href="./">管理中心</a> &gt; <b>数据管理</b></div><div id="B"><div id="L"><div class="nameleft">系统管理</div><div class="nameleftcont"><ul><li><a href="./set_site.php">基本设置</a><ul><li><a href="./set_site.php">站点设置</a></li><li><a href="./set_mail.php">邮件设置</a></li><li><a href="./set_secure.php">Cookie设置</a></li><li><a href="./set_links.php">友情链接</a></li></ul></li><li><a href="./user_list.php">会员管理</a><ul><li><a href="./user_group.php">用 户 组</a></li><li><a href="./user_list.php">全部会员</a></li><li><a href="./user_black.php">黑 名 单</a></li></ul></li><li><a href="./category.php">分类目录</a><ul><li><a href="./category.php">分类管理</a></li><li><a href="./forum_category.php">吧分类审核</a></li></ul></li><li><a href="./forum_list.php">贴吧管理</a><ul><li><a href="./forum_list.php">全部贴吧</a></li><li><a href="./forum_temp.php">新吧审核</a></li><li><a href="./bm_apply.php">吧主审核</a></li><li><a href="./bm_apply.php?list=resign">辞职申请</a></li><li><a href="./set_filter.php">字词屏蔽</a></li></ul></li><li><a href="./topic_list.php">帖子管理</a><ul><li><a href="./topic_list.php">主题管理</a></li><li><a href="./post_list.php">全帖管理</a></li><li><a href="./report_list.php">举报管理</a></li></ul></li><li><a href="./db_manage.php">数据管理</a><ul><li><a href="./db_export.php">数据备份</a></li><li><a href="./db_import.php">数据还原</a></li></ul></li></ul></div></div> <div id="R"><div class="nameset">数据管理</div><div class="namecont"><form name="Form1" id="Form1" method="post" target="sypost"><table width="100%" cellspacing="0" cellpadding="0"><tr class="tr1"><td class="td1" align="center" width="6%"><strong>&nbsp;</strong></td><td class="td1" align="left" width="23%"><strong>数据表</strong></td><td class="td1" align="left" width=""><strong>说明</strong></td><td class="td1" align="left" width="12%"><strong>记录数</strong></td><td class="td1" align="left" width="10%"><strong>索引尺寸</strong></td><td class="td1" align="left" width="12%"><strong>数据尺寸</strong></td></tr><?php
if (!empty($_obj['dbTable'])){
if (!is_array($_obj['dbTable']))
$_obj['dbTable']=array(array('dbTable'=>$_obj['dbTable']));
$_tmp_arr_keys=array_keys($_obj['dbTable']);
if ($_tmp_arr_keys[0]!='0')
$_obj['dbTable']=array(0=>$_obj['dbTable']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['dbTable'] as $rowcnt=>$v) {
if (is_array($v)) $dbTable=$v; else $dbTable=array();
$dbTable['ROWVAL']=$v;
$dbTable['ROWCNT']=$rowcnt;
$dbTable['ROWBIT']=$rowcnt%2;
$_obj=&$dbTable;
?><tr><td class="td2" align="center"><input type="checkbox" name="dbTable[]" value="<?php
echo $_obj['Name'];
?>
" checked /></td><td class="td2" align="left"><?php
echo $_obj['Name'];
?>
</td><td class="td2" align="left"><?php
echo $_obj['Comment'];
?>
</td><td class="td2" align="left"><?php
echo $_obj['Rows'];
?>
</td><td class="td2" align="left"><?php
echo $_obj['Index_length'];
?>
</td><td class="td2" align="left"><?php
echo $_obj['Data_length'];
?>
</td></tr><tr class="td3"><td colspan="6"></td></tr><?php
}
$_obj=$_stack[--$_stack_cnt];}
?><tr><td colspan="6" align="center"><select id="ActionType" name="ActionType"><option value="0">操作类型</option><option value="1">优化</option><option value="2">修复</option></select>&nbsp;<input type="submit" id="ActionDo" name="ActionDo" value="提 交" class="sub"></td></tr><tr><td colspan="6" class="td2">&nbsp;</td></tr></table></form><iframe scrolling=no width=0 height=0 src="javascript:void(0);" name="sypost" id="sypost" style="display: none"></iframe></div></div></div></div><div id="footer">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &#169; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.Com</a> All Rights Reserved.</div></body></html>