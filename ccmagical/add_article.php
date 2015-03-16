<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>
add
</title>
<script type="text/javascript">
	//创建ajax引擎
	function getXmlHttpObject(){
		var xmlHttp=null;
		try{
			//firefox,Opera 8.0+,Safari
			xmlHttp=new XMLHttpRequest();
		}
		catch(e){
			//Internet Explorer
			try{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e){
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return xmlHttp;
	}
	var myXmlHttpRequest="";
	function $(id){
		return document.getElementById(id);
	}
	function getData(){
		myXmlHttpRequest=getXmlHttpObject();
		if(myXmlHttpRequest){
			//window.alert("创建ajax引擎成功");
			var url="./getData.php?id="+$("id").value;
			myXmlHttpRequest.open("get",url,true);
			//指定回调函数
			myXmlHttpRequest.onreadystatechange=action;
			//get方法，填null
			//如果是post填入实际的数据
			myXmlHttpRequest.send(null);
		}else{
			window.alert("创建ajax引擎失败");
		}
		
		
	}
	function action(){
		if(myXmlHttpRequest.readyState==4){
			var jsonText=myXmlHttpRequest.responseText;
			//window.alert(jsonText);
			var jsonObject=eval("("+jsonText+")");
			var id=jsonObject.id;
			var title=jsonObject.title;
			var description=jsonObject.description;
			var url=jsonObject.url;
			var image=jsonObject.image;
			var tags=jsonObject.tags;
			var no=jsonObject.no;
			
			$("title").value=title;
			$("description").value=description;
			$("url").value=url;
			$("image").value=image;
			$("tags").value=tags;
			$("no").value=no;
		}
	}
</script>
</head>
</head>
<body>
<h3>新增</h3>
<form method="post" enctype="multipart/form-data" action='add_article.php'>
	<input type="hidden" name="action" value="insert" /> 期号：<input
		type="text" name="no" size="40"><br>标题：<input
		type="text" name="title" size="40"><br> 简介：<input type="text" name="description"
		size="40"><br> 文章链接：<input type="text" name="url" size="40"> <br>图片链接：<input
		type='text' name='image'><br>标签： 
		<input
		type='text' name='tags'> 
		<br><input type="submit" name="submit"
		value="提交"><br>
</form>
<br><br><h3>修改</h3>根据id号来修改，每个必须填
<form method="post" enctype="multipart/form-data" action='add_article.php'>
	<input type="hidden" name="action" value="update" /> id：<input
		type="text" name="id" id="id" size="40"><input type="button" value="获取数据" onclick="getData();"/><br>期号：<input
		type="text" name="no" id="no" size="40"><br>标题：<input
		type="text" name="title" id="title" size="40"><br> 简介：<input type="text" id="description" name="description"
		size="40"><br> 文章链接：<input type="text" name="url" id="url" size="40"> <br>图片链接：<input
		type='text' name='image' id="image"><br>标签： 
		<input
		type='text' name='tags' id="tags"> 
		<br><input type="submit" name="submit"
		value="修改"><br>
</form>
<br><br><h3>删除</h3>
<form method="post" enctype="multipart/form-data" action='add_article.php'>
	<input type="hidden" name="action" value="delete" /> id：<input
		type="text" name="id" size="40">
		<br><input type="submit" name="submit"
		value="删除"><br>
</form>

<a href="index.html">返回</a>
<?php
include "is_login.php";
include_once "./db/Article.php";

try {
	if (isset ( $_POST ['action'] ) && $_POST ['action'] == "insert") {//插入
		$title = $_REQUEST ['title'];
		$description = $_REQUEST ['description'];
		$url = $_REQUEST ['url'];
		$image = $_REQUEST ['image'];
		$tags = $_REQUEST ['tags'];
		$no=$_REQUEST ['no'];
		$data = array (
				"title" => $title,
				"description" => $description,
				"url" => $url,
				"image" => $image,
				"tags"=>$tags,
				"no"=>$no
		);
		$article = new Article ( $data );
		$article->insert ();
	} elseif (isset ( $_POST ['action'] ) && $_POST ['action'] == "update") {//修改
		$title = $_REQUEST ['title'];
		$description = $_REQUEST ['description'];
		$url = $_REQUEST ['url'];
		$image = $_REQUEST ['image'];
		$tags = $_REQUEST ['tags'];
		$no=$_REQUEST ['no'];
		$id=$_REQUEST ['id'];
		$data = array (
				"title" => $title,
				"description" => $description,
				"url" => $url,
				"image" => $image,
				"tags"=>$tags,
				"no"=>$no
		);
		$article = new Article ( $data );
		$article->updateById ($id);
	} elseif (isset ( $_POST ['action'] ) && $_POST ['action'] == "delete") {//删除
		$id = $_REQUEST ['id'];
		Article::deleteById ( $id );
	}
} catch ( Exception $e ) {
	die ( "error: " . $e->getMessage () );
}

?>
</body>
</html>