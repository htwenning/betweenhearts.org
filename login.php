﻿<fieldset>
<legend>用户登录</legend>
<form name="LoginForm" method="post" action="login.php">
<p>
<label for="username" class="label">我叫什么:</label>
<input id="username" name="username" type="text" class="input" />
<p/>
<p>
<input type="submit" name="submit" value="  确 定  " class="left" />
</p>
</form>
</fieldset>
<?php
session_start();
	//登录
if(!isset($_POST['submit'])){
    exit('非法访问!');
}
$username = htmlspecialchars($_POST['username']);



//检测用户名及密码是否正确

if($username == "文宁"){
    //登录成功
    $_SESSION['username'] = $username;
    echo ' 欢迎你！<a href="http://www.betweenhearts.org"/>首页</a>';
    exit;
} else {
    exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
?>