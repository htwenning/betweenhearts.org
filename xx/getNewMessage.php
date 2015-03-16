<?php
	require(dirname(__FILE__)."/global.php");

	//1.链接数据库
	$DB->connect($mysql_host,$mysql_user,$mysql_pass,$mysql_dbname);
	//2.获取未读信息
	$username=$_POST['username'];
	$query1="select sender,content,date from xx_messages where username=\"$username\";";
	$result=$DB->query($query1);
	$messages=array();
	$flag=0;
	while($arr=mysql_fetch_assoc($result)){
		//print_r($arr);
		$content=$arr['content'];
		$date=$arr['date'];
		$sender=$arr['sender'];
		//将得到的信息返回
		//echo '{s}'.$sender.'{/s}{u}'.$username.'{/u}{c}'.$content.'{/c}{d}'.$date.'{/d}\n';
		//以xml格式传回数据.
		if($flag==0) echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><messages>";
		echo "<message><sender>$sender</sender><username>$username</username><content>$content</content><date>$date</date></message>";
		//将信息放入历史信息中
		$query2="insert into xx_history_messages(username,content,date,sender) values('$username','$content','$date','$sender');";
		$DB->query($query2);
		//删除收件箱里的信息
		$query3="delete from xx_messages where username=\"$username\";";
		$DB->query($query3);
		$flag++;
	}
	echo "</messages>";
	


