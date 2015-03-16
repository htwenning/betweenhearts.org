<?php
	include_once "./db/Article.php";
	
	if(isset($_GET['id']) && $_GET['id']!=null) $id=$_GET['id'];
	else{ echo "wrong";exit;}
	$article=Article::getArticleById($id);
	//xml
	/*
	$responseXml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<article>
	<id>%s</id>
	<title>%s</title>
	<description>%s</description>
	<url>%s</url>
	<image>%s</image>
	<tags>%s</tags>
	<no>%s</no>
	</article>";
	";
	$responseXml=sprintf($responseXml,$article->data['id'],$article->data['title'],$article->data['description'],$article->data['url'],$article->data['image'],$article->data['tags'],$article->data['no']);
	echo $responseXml;
	*/
	//json
	header("Content-Type: text/html;charset=utf-8");
	header("Cache-Control: no-cache");
	$jsonStr='{"id":"%s","title":"%s","description":"%s","url":"%s","image":"%s","tags":"%s","no":"%s"}';
	$jsonStr=sprintf($jsonStr,$article->getValue('id'),$article->getValue('title'),$article->getValue('description'),$article->getValue('url'),$article->getValue('image'),$article->getValue('tags'),$article->getValue('no'));
	echo $jsonStr;
?>