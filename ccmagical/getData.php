<?php
	include_once "./db/Article.php";
	
	if(isset($_GET['id']) && $_GET['id']!=null) $id=$_GET['id'];
	else{ echo "wrong";exit;}
	$article=Article::getArticleById($id);
	//json
	header("Content-Type: text/html;charset=utf-8");
	header("Cache-Control: no-cache");
	$jsonStr='{"id":"%s","title":"%s","description":"%s","url":"%s","image":"%s","tags":"%s","no":"%s"}';
	$jsonStr=sprintf($jsonStr,$article->getValue('id'),$article->getValue('title'),$article->getValue('description'),$article->getValue('url'),$article->getValue('image'),$article->getValue('tags'),$article->getValue('no'));
	echo $jsonStr;
?>