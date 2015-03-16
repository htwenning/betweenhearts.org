<?php
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_category.php";
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_member.php";
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_forum.php";
include "/home/betweenh/domains/betweenhearts.org/public_html/tieba/class/phpSayTemplateExtensions/rewrite_topic.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title><?php
echo $_obj['ForumArr']['name'];
?>
_<?php
echo $_obj['siteName'];
?>
</title><meta name="keywords" content="<?php
echo $_obj['ForumArr']['name'];
?>
, <?php
echo $_obj['siteName'];
?>
, PhpSay, 贴吧, 小组" /><meta name="description" content="<?php
echo $_obj['ForumArr']['synopsis'];
?>
 - <?php
echo $_obj['ForumArr']['name'];
?>
" /><link rel="alternate" type="application/rss+xml" href="./rss.php?fid=<?php
echo $_obj['ForumArr']['fid'];
?>
" title="<?php
echo $_obj['ForumArr']['name'];
?>
_<?php
echo $_obj['siteName'];
?>
" /><link rel="stylesheet" type="text/css" href="./css/w3c.css" /><link rel="stylesheet" type="text/css" href="./css/bar.css" /><link rel="stylesheet" type="text/css" href="./css/thickbox.css" /><script type="text/javascript" src="./js/jquery.js"></script><script type="text/javascript" src="./js/form.js"></script><script type="text/javascript" src="./js/thickbox.js"></script><script type="text/javascript" src="./js/phpsay.js?v2"></script></head><body><div id="header"><div class="k"></div><form name="searchForm" method="get" action="./search.php" onsubmit="return SearchSubmit(this)"><ul class="search"><li><a href="./"><img src="./images/slogo.gif" alt="" title="到首页" border="0" class="logo ft_l" /></a></li><li style="margin-top:9px;"><input type="text" id="kw" name="wd" maxlength="100" value="<?php
echo $_obj['searchWord'];
?>
" class="s disableAutoComplete" /><br /><label for="proto1"><input type="radio"<?php
if ($_obj['searchType'] == "1"){
?> checked="checked"<?php
}
?> value="1" name="tb" id="proto1" />进入吧</label><label for="proto2"><input type="radio"<?php
if ($_obj['searchType'] == "2"){
?> checked="checked"<?php
}
?> value="2" name="tb" id="proto2" />帖子</label><label for="proto3"><input type="radio"<?php
if ($_obj['searchType'] == "3"){
?> checked="checked"<?php
}
?> value="3" name="tb" id="proto3" />作者</label></li><li style="margin-top:9px;"><input type="submit" value="搜 索" class="bt" /></li><li style="margin-top:9px;"><dl><?php
if ($_obj['loginArr']['state'] == "1"){
?><?php
if ($_obj['loginArr']['group'] == "6"){
?><dd><a href="./admin.php" target="_blank">系统管理</a></dd><?php
}
?><dd><a href="./profile.php" target="_top">个人中心</a></dd><dd><a href="./login.php?do=logout" target="_top">退出</a></dd><?php
} else {
?><dd><a href="./register.php?height=216&width=296&modal=true" class="thickbox">注册</a></dd><dd><a href="./login.php?height=142&width=308" class="thickbox" title="登录到<?php
echo $_obj['siteName'];
?>
">登录</a></dd><dd><a href="./recoverpass.php?height=175&width=282&modal=true" class="thickbox">忘记密码</a></dd><?php
}
?></dl></li></ul><div id="mask" class="mask"></div></form></div><div class="k"></div><div id="main"><div class="guid"><a href="./"><?php
echo $_obj['siteName'];
?>
</a><?php
if ($_obj['ForumArr']['classid'] > "0"){
?> &gt; <a href="<?php
echo phpsay_rewrite_category($_obj['ForumArr']['catalogid']);
?>
"><?php
echo $_obj['ForumArr']['catalogname'];
?>
</a> &gt; <a href="<?php
echo phpsay_rewrite_category($_obj['ForumArr']['classid']);
?>
"><?php
echo $_obj['ForumArr']['classname'];
?>
</a><?php
}
?></div><div id="leftmain"><div class="barInfo"><div class="ft_l"><strong class="fs_14 p_b"><?php
echo $_obj['ForumArr']['name'];
?>
</strong> </div><div class="ft_r fs_14"><?php
if (!empty($_obj['ForumArr']['moderator'])){
?><span class="bar_host">&nbsp;</span>吧主：<?php
if (!empty($_obj['ForumArr']['moderator'])){
if (!is_array($_obj['ForumArr']['moderator']))
$_obj['ForumArr']['moderator']=array(array('moderator'=>$_obj['ForumArr']['moderator']));
$_tmp_arr_keys=array_keys($_obj['ForumArr']['moderator']);
if ($_tmp_arr_keys[0]!='0')
$_obj['ForumArr']['moderator']=array(0=>$_obj['ForumArr']['moderator']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['ForumArr']['moderator'] as $rowcnt=>$v) {
if (is_array($v)) $moderator=$v; else $moderator=array();
$moderator['ROWVAL']=$v;
$moderator['ROWCNT']=$rowcnt;
$moderator['ROWBIT']=$rowcnt%2;
$_obj=&$moderator;
?><a href="<?php
echo phpsay_rewrite_member($_obj['uid']);
?>
" target="_blank"><?php
echo $_obj['name'];
?>
</a>&nbsp;&nbsp;<?php
}
$_obj=$_stack[--$_stack_cnt];}
?><?php
}
?><?php
if ($_obj['isModerator'] == "1"){
?><a href="./forum_set.php?fid=<?php
echo $_obj['ForumArr']['fid'];
?>
" style="margin-left:30px">[吧务管理]</a><?php
} else {
?><a href="./apply.php?fid=<?php
echo $_obj['ForumArr']['fid'];
?>
&height=159&width=305" class="thickbox" style="margin-left:30px" rel="nofollow">[申请做吧主]</a><?php
}
?></div><div class="k"></div></div><div class="barFun"><div class="ft_l"><a class="btn_new" href="#say">发表新帖</a></div><div class="pagecontent ft_r"><?php
if (!empty($_obj['TopicArr']['Page']['pagePre'])){
?><span class="pgpre"><?php
echo $_obj['TopicArr']['Page']['pagePre'];
?>
</span><?php
}
?><span class="pg"><?php
if (!empty($_obj['TopicArr']['Page']['pageFirst'])){
?><?php
echo $_obj['TopicArr']['Page']['pageFirst'];
?>
<span class="pge">...</span><?php
}
?><?php
if (!empty($_obj['TopicArr']['Page']['pageList'])){
?><?php
echo $_obj['TopicArr']['Page']['pageList'];
?>
<?php
}
?><?php
if (!empty($_obj['TopicArr']['Page']['pageLast'])){
?><span class="pge">...</span><?php
echo $_obj['TopicArr']['Page']['pageLast'];
?>
<?php
}
?></span><?php
if (!empty($_obj['TopicArr']['Page']['pageNext'])){
?><span class="pgnext"><?php
echo $_obj['TopicArr']['Page']['pageNext'];
?>
</span><?php
}
?></div><div class="k"></div></div><div class="barList"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr class="bg2"><td class="wh_1">点击</td><td class="wh_2">回复</td><td class="title"><div class="bar_lei"><?php
if ($_obj['Digest'] == "true"){
?><a href="<?php
echo phpsay_rewrite_forum($_obj['ForumArr']['fid']);
?>
">全部帖子</a> <span class="ft_l tpl_top">|</span> <a href="<?php
echo $_obj['siteCatalog'];
?>
forum.php?fid=<?php
echo $_obj['ForumArr']['fid'];
?>
&digest=1" class="on">加精帖</a><?php
} else {
?><a href="<?php
echo phpsay_rewrite_forum($_obj['ForumArr']['fid']);
?>
" class="on">全部帖子</a> <span class="ft_l tpl_top">|</span> <a href="<?php
echo $_obj['siteCatalog'];
?>
forum.php?fid=<?php
echo $_obj['ForumArr']['fid'];
?>
&digest=1">加精帖</a><?php
}
?></div></td><td width="90"><div class="wh_3">作者</div></td><td width="140"><div class="wh_4">最后回复</div></td></tr><?php
if (!empty($_obj['TopicArr']['Topic'])){
if (!is_array($_obj['TopicArr']['Topic']))
$_obj['TopicArr']['Topic']=array(array('Topic'=>$_obj['TopicArr']['Topic']));
$_tmp_arr_keys=array_keys($_obj['TopicArr']['Topic']);
if ($_tmp_arr_keys[0]!='0')
$_obj['TopicArr']['Topic']=array(0=>$_obj['TopicArr']['Topic']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['TopicArr']['Topic'] as $rowcnt=>$v) {
if (is_array($v)) $Topic=$v; else $Topic=array();
$Topic['ROWVAL']=$v;
$Topic['ROWCNT']=$rowcnt;
$Topic['ROWBIT']=$rowcnt%2;
$_obj=&$Topic;
?><tr<?php
if ($_obj['ROWBIT'] == "1"){
?> class="bg1"<?php
}
?>><td><?php
echo $_obj['views'];
?>
</td><td><?php
echo $_obj['replies'];
?>
</td><td class="title"><?php
if ($_obj['isdigest'] == ""){
?><?php
if ($_obj['stick'] > "0"){
?><span class="icon_ding" title="置顶帖">&nbsp;</span><?php
}
?><?php
}
?><a href="<?php
echo phpsay_rewrite_topic($_obj['tid']);
?>
" title="<?php
echo $_obj['title'];
?>
" target="_blank" class="blue"><?php
echo $_obj['subject'];
?>
</a><?php
if ($_obj['digest'] == "1"){
?> <span class="icon_jing" title="精华帖">&nbsp;</span><?php
}
?><?php
if ($_obj['replies'] > "50"){
?> <span class="icon_hot" title="热帖">&nbsp;</span><?php
}
?></td><td><?php
if ($_obj['authorid'] > "0"){
?><a href="<?php
echo phpsay_rewrite_member($_obj['authorid']);
?>
" target="_blank"><?php
echo $_obj['author'];
?>
</a><?php
if ($_obj['authorico'] == "3"){
?><span class="icon_vip mgt hand" title="VIP会员">&nbsp;</span><?php
} elseif ($_obj['authorico'] == "4"){
?><span class="icon_bazhu mgt" title="吧主">&nbsp;</span><?php
} elseif ($_obj['authorico'] == "5"){
?><span class="icon_generalAdmin mgt" title="普通管理员">&nbsp;</span><?php
} elseif ($_obj['authorico'] == "6"){
?><span class="icon_highAdmin mgt" title="高级管理员">&nbsp;</span><?php
}
?><?php
} else {
?><?php
echo $_obj['author'];
?>
<?php
}
?></td><td><?php
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
if ($_obj['lastauthorico'] == "3"){
?><span class="icon_vip mgt hand" title="VIP会员">&nbsp;</span><?php
} elseif ($_obj['lastauthorico'] == "4"){
?><span class="icon_bazhu mgt" title="吧主">&nbsp;</span><?php
} elseif ($_obj['lastauthorico'] == "5"){
?><span class="icon_generalAdmin mgt" title="普通管理员">&nbsp;</span><?php
} elseif ($_obj['lastauthorico'] == "6"){
?><span class="icon_highAdmin mgt" title="高级管理员">&nbsp;</span><?php
}
?><?php
} else {
?><?php
echo $_obj['lastauthor'];
?>
<?php
}
?></td></tr><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></table></div><div class="barPage"><div class="pagecontent ft_r"><?php
if (!empty($_obj['TopicArr']['Page']['pagePre'])){
?><span class="pgpre"><?php
echo $_obj['TopicArr']['Page']['pagePre'];
?>
</span><?php
}
?><span class="pg"><?php
if (!empty($_obj['TopicArr']['Page']['pageFirst'])){
?><?php
echo $_obj['TopicArr']['Page']['pageFirst'];
?>
<span class="pge">...</span><?php
}
?><?php
if (!empty($_obj['TopicArr']['Page']['pageList'])){
?><?php
echo $_obj['TopicArr']['Page']['pageList'];
?>
<?php
} else {
?><b>1</b><?php
}
?><?php
if (!empty($_obj['TopicArr']['Page']['pageLast'])){
?><span class="pge">...</span><?php
echo $_obj['TopicArr']['Page']['pageLast'];
?>
<?php
}
?></span><?php
if (!empty($_obj['TopicArr']['Page']['pageNext'])){
?><span class="pgnext"><?php
echo $_obj['TopicArr']['Page']['pageNext'];
?>
</span><?php
}
?></div><div class="k"></div></div><div class="bar_new" onkeyup="quick_send(event);"><h3>发表新帖<a name="say" style="visibility:hide">&nbsp;</a></h3><div class="bar_new_con fs_14"><form id="submit_form" name="submit_form"><input type="hidden" name="do" id="do" value="Topic" /><input type="hidden" name="fid" id="fid" value="<?php
echo $_obj['ForumArr']['fid'];
?>
" /><ul><?php
if ($_obj['loginArr']['state'] == "1"){
?><li><label>&nbsp;</label><?php
echo $_obj['loginArr']['name'];
?>
，<?php
if ($_obj['loginArr']['group'] > "2"){
?>您是<?php
echo $_obj['groupArr']['name'];
?>
<?php
} else {
?>您已登录<?php
}
?>。<?php
if ($_obj['postAnonymous'] == "1"){
?>&nbsp;&nbsp;<input name="anony" type="checkbox" value="" tabindex="999" />匿名发表</li><?php
}
?><?php
} else {
?><li><label>&nbsp;</label><span id="loginStateInfo"><?php
if (!empty($_obj['loginArr']['name'])){
?><?php
echo $_obj['loginArr']['name'];
?>
，您未登录。<?php
} else {
?>您未登录，帖子将以匿名发表。<?php
}
?></span><a href="./anonymity.php?height=139&width=303" class="thickbox" title="游客昵称设置">设置昵称</a> | <a href="./login.php?height=142&width=308" class="thickbox" title="登录到<?php
echo $_obj['siteName'];
?>
">登录</a> | <a href="./register.php?height=216&width=296&modal=true" class="thickbox">注册</a></li><?php
}
?><li><label>帖子标题：</label><input type="text" id="title" name="title" maxlength="32" class="bar_inp" style="color:#666;" value="至少3个字符，不超过32个字符" onfocus="if (this.value=='至少3个字符，不超过32个字符') this.value='';this.style.color='';" /></li><li><label>帖子内容：</label><div class="ft_l"><div class="bar_text"><div class="bar_new_opera"><div id="ed_ins_face" class="face img"></div><div id="ed_ins_pic" class="pic img"></div><div id="ed_ins_vid" class="video img"></div></div><textarea name="content" id="ed_text_area" rows="11"<?php
if ($_obj['groupArr']['verify'] == "1"){
?> onfocus="show_verify_image('topic');"<?php
}
?>></textarea></div><div class="bar_text_opera"><span class="ft_r"><span id="ed_more_rows" class="add">加大</span><span id="ed_less_rows" class="plus">减小</span></span></div></div></li><?php
if ($_obj['groupArr']['verify'] == "1"){
?><li id="verify_div" style="clear:both;display:none"><label>验 证 码：</label><table width="230" cellpadding="0" cellspacing="0" class="bar_codet"><tr><td colspan="2" valign="middle"><input type="text" name="verifyNum" class="disableAutoComplete bar_code" style="color:#666;" value="输入图中字符，不区分大小写" onfocus="if (this.value.length != 4) this.value='';this.style.color='';" /></td></tr><tr><td width="138" valign="middle" id="verify_cell"></td><td valign="middle" id="retry_cell"></td></tr></table></li><?php
}
?><li class="bd_t1" style="clear:left"><label>&nbsp;</label><input type="submit" id="btn" name="btn" class="btn_sub" value="确认发布" /><span class="bar_new_txt">快捷键：Ctrl+Enter</span></li></ul></form><div class="k"></div></div></div></div><div id="rightmain"><div class="bd_l2"><input name="dingyue" type="button" value="" class="dingyue" onclick="barRss(<?php
echo $_obj['ForumArr']['fid'];
?>
);" /> <h1>本吧信息</h1> <ul><li><?php
if (!empty($_obj['ForumArr']['synopsis'])){
?>吧简介：<?php
echo $_obj['ForumArr']['synopsis'];
?>
<?php
}
?></li><li>帖子数：<?php
echo $_obj['TopicNum'];
?>
</li><li>回复数：<?php
echo $_obj['ReplyNum'];
?>
</li> </ul> <?php
if (!empty($_obj['ForumArr']['friend'])){
?><h1>同盟吧</h1><ul><?php
if (!empty($_obj['ForumArr']['friend'])){
if (!is_array($_obj['ForumArr']['friend']))
$_obj['ForumArr']['friend']=array(array('friend'=>$_obj['ForumArr']['friend']));
$_tmp_arr_keys=array_keys($_obj['ForumArr']['friend']);
if ($_tmp_arr_keys[0]!='0')
$_obj['ForumArr']['friend']=array(0=>$_obj['ForumArr']['friend']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['ForumArr']['friend'] as $rowcnt=>$v) {
if (is_array($v)) $friend=$v; else $friend=array();
$friend['ROWVAL']=$v;
$friend['ROWCNT']=$rowcnt;
$friend['ROWBIT']=$rowcnt%2;
$_obj=&$friend;
?><li><a href="<?php
echo phpsay_rewrite_forum($_obj['fid']);
?>
" target="_blank"><?php
echo $_obj['name'];
?>
</a></li><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></ul> <?php
}
?> <?php
if (!empty($_obj['NewTopic'])){
?><h2>最新主题</h2><ul><?php
if (!empty($_obj['NewTopic'])){
if (!is_array($_obj['NewTopic']))
$_obj['NewTopic']=array(array('NewTopic'=>$_obj['NewTopic']));
$_tmp_arr_keys=array_keys($_obj['NewTopic']);
if ($_tmp_arr_keys[0]!='0')
$_obj['NewTopic']=array(0=>$_obj['NewTopic']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['NewTopic'] as $rowcnt=>$v) {
if (is_array($v)) $NewTopic=$v; else $NewTopic=array();
$NewTopic['ROWVAL']=$v;
$NewTopic['ROWCNT']=$rowcnt;
$NewTopic['ROWBIT']=$rowcnt%2;
$_obj=&$NewTopic;
?><li><a href="<?php
echo phpsay_rewrite_topic($_obj['tid']);
?>
" title="<?php
echo $_obj['title'];
?>
" target="_blank"><?php
echo $_obj['subject'];
?>
</a></li><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></ul> <?php
}
?></div></div></div><div id="insert_face" class="bar_pop"><h4><a class="ft_r bar_new_close" href="javascript:;" onclick="closeInsert('insert_face');"></a><div class="icon_face"></div><strong>插入表情</strong></h4><div class="bar_sel_con"><ul class="barface"><?php
if (!empty($_obj['faceArr'])){
if (!is_array($_obj['faceArr']))
$_obj['faceArr']=array(array('faceArr'=>$_obj['faceArr']));
$_tmp_arr_keys=array_keys($_obj['faceArr']);
if ($_tmp_arr_keys[0]!='0')
$_obj['faceArr']=array(0=>$_obj['faceArr']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['faceArr'] as $rowcnt=>$v) {
if (is_array($v)) $faceArr=$v; else $faceArr=array();
$faceArr['ROWVAL']=$v;
$faceArr['ROWCNT']=$rowcnt;
$faceArr['ROWBIT']=$rowcnt%2;
$_obj=&$faceArr;
?><li><img src="<?php
echo $_obj['img'];
?>
" alt="<?php
echo $_obj['name'];
?>
" title="<?php
echo $_obj['name'];
?>
" /></li><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></ul></div></div><div id="insert_pic" class="bar_pop"><h4><a class="ft_r bar_new_close" href="javascript:;" onclick="closeInsert('insert_pic');"></a><div class="icon_pic"></div><strong>插入图片</strong></h4><?php
if ($_obj['groupArr']['upload'] == "1"){
?><div id="selPic1" style="display:none;"><ul class="bar_sel_nav"><li onclick="$('#selPic1').hide();$('#selPic2').show();">网络图片</li><li class="on">本地上传</li></ul><div class="bar_sel_con"><div class="ft_l">选择图片：<br /><form id="imgUploadForm" target="imgUploadForm" method="post" enctype="multipart/form-data" action="./upload.php"><input type="file" id="fileToUpload" name="upImg" class="bar_sel_inp2" onchange="uploadImage();" /><br/></form><span class="p_6">图片大小不超过200K，格式为jpg、jpeg、gif、png。</span><br /><span id="upload_status"></span><input type="button" class="bar_sel_btn confirmbtn" value="插入图片" onclick="insertImage();" /></div></div></div><?php
}
?><div id="selPic2"><ul class="bar_sel_nav"><li class="on">网络图片</li><?php
if ($_obj['groupArr']['upload'] == "1"){
?><li onclick="$('#selPic1').show();$('#selPic2').hide();">本地上传</li><?php
} else {
?><li style="color:#999;cursor:default;">本地上传(<?php
if ($_obj['loginArr']['state'] == "1"){
?>没有权限<?php
} else {
?>需登陆<?php
}
?>)</li><?php
}
?></ul><div class="bar_sel_con"><div class="ft_l">图片链接：</div><div class="ft_l p_6"><input type="text" id="outer_imgurl" class="bar_sel_inp" value="" /><br /><span class="p_6">图片链接以 http:// 开头。</span><br /><span id="urlcheck_status_1"></span><input type="button" class="bar_sel_btn confirmbtn" value="插入图片" onclick="insertImage();" /></div></div></div></div><div id="insert_video" class="bar_pop"><h4><a class="ft_r bar_new_close" href="javascript:;" onclick="closeInsert('insert_video');"></a><div class="icon_vid"></div><strong>插入视频</strong></h4><div class="bar_sel_con"><div class="ft_l">视频链接：</div><div class="ft_l p_6"><input id="vid_url" type="text" class="bar_sel_inp3" /><br /><span class="p_6">支持优酷、土豆、酷6、56、六间房、搜狐、新浪、YouTube等多家视频网站</span><br /><span id="video_status"></span><input type="button" name="" class="bar_sel_btn" value="插入视频" onclick="insertVideo();" /></div></div></div><script type="text/javascript">$(function(){postBind();});</script><div class="k"></div><div id="footer" class="center blue" style="padding:10px 0 4px 0;">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
echo $_obj['codeName'];
?>
</a> <?php
echo $_obj['codeVersion'];
?>
, Copyright &copy; 2006～2010 <a href="http://www.phpsay.com" target="_blank">PHPSay.com</a> 版权所有<?php
if (!empty($_obj['siteIcp'])){
?> <a href="http://www.miibeian.gov.cn/" target="_blank"><?php
echo $_obj['siteIcp'];
?>
</a><?php
}
?><script type="text/javascript"> var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-6933823-13']); _gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();</script></div></body></html>