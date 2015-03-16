<?php
	include_once "./db/Book.php";
	
	if(isset($_GET['name']) && $_GET['name']!=null) $name=$_GET['name'];
	else{ echo "wrong";exit;}
	$book=Book::getBookByName($name);
	if($book==null) echo "null";
	//json
	header("Content-Type: text/html;charset=utf-8");
	header("Cache-Control: no-cache");
	$jsonStr='{"name":"%s","info":"%s","url":"%s"}';
	$jsonStr=sprintf($jsonStr,$book->getValue('name'),$book->getValue('info'),$book->getValue('url'));
	echo $jsonStr;
?>