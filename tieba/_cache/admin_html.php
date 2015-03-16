<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="keywords" content="<?php
echo $_obj['siteName'];
?>
, PhpSay, 贴吧, 说吧" /><meta name="description" content="<?php
echo $_obj['siteName'];
?>
, PhpSay, 贴吧, 说吧" /><title>系统管理员登录_<?php
echo $_obj['siteName'];
?>
</title><link rel="stylesheet" type="text/css" href="./css/w3c.css" /><link rel="stylesheet" type="text/css" href="./css/div.css" /><script type="text/javascript" src="./js/jquery.js"></script><script type="text/javascript" src="./js/phpsay.js"></script></head><body><div class="admin_div"><form name="login-form" id="login-form" onsubmit="return false;"><ul><li>请输入您的密码：<input type="password" name="login-pwd" id="login-pwd" maxlength="18" class="btn_input" value="" onkeydown="if(event.keyCode==13)admin()" />&nbsp;<input type="button" value="登 录" class="btn_login" onclick="admin();"></li></ul></form></div><div class="k"></div><div id="footer" class="center blue" style="padding:10px 0 4px 0;">Powered by <a href="http://www.phpsay.com" target="_blank"><?php
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