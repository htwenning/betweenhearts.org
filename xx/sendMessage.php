<?php
	require(dirname(__FILE__)."/global.php");

	//1.链接数据库
	$DB->connect($mysql_host,$mysql_user,$mysql_pass,$mysql_dbname);

	//2.将发送的消息传入
	$query="insert into xx_messages(sender,username,content,date) values(\"".$_POST['sender']."\",\"".$_POST['username']."\",\"".$_POST['content']."\",now());";
	$res=$DB->query($query);
	//3.执行
	if(!$res) echo "send failed";
	$DB->close();