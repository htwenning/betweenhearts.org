<?php include_once 'index_header.php';
$activeName = "books";
include_once 'nav_bar.php';
?>
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
			var url="./getData.php?name="+$("name").value;
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
			var name=jsonObject.name;
			var info=jsonObject.info;
			var url=jsonObject.url;
			
			$("name").value=name;
			$("info").value=info;
			$("url").value=url;
		}
	}
</script>
<br><br>
	<form method="post" enctype="multipart/form-data" action='add_book.php'>
	<input type="hidden" name="action" value="insert" /> 书名：<input
		type="text" name="name" size="40"> 简介：<input type="text" name="info"
		size="40"> 下载链接：<input type="text" name="url" size="40"> 图片：<input
		type='file' name='upload_file'> <input type="submit" name="submit"
		value="submit">
</form>
<form method="post" action='add_book.php'>
	<p>修改信息(“根据书名”)</p>
	<input type="hidden" name="action" value="update" /> 书名：<input
		type="text" name="name" id="name" size="40"><input type="button" value="获得信息" onclick="getData();"/><br>
		简介：<input type="text" name="info" id="info" 
		size="40"> 下载链接:<input type="text" name="url" id="url" size="40"> <input
		type="submit" name="submit" value="submit">
</form>
<br>
<form method="post" name="delete" action='add_book.php'>
	<p>删除(“根据书名”)</p>
	<input type="hidden" name="action" value="delete" /> 书名：<input
		type="text" name="name" size="40"> <input type="submit" name="submit"
		value="submit">
</form>
<?php
include_once "db/Book.php";

try {
	if (isset ( $_POST ['action'] ) && $_POST ['action'] == "insert") {
		$info = $_REQUEST ['info'];
		$book_name = $_REQUEST ['name'];
		$url = $_REQUEST ['url'];
		$uploaddir = "books/img/";
		$type = array (
				"jpg",
				"gif",
				"bmp",
				"jpeg",
				"png"
		);
		$a = strtolower ( fileext ( $_FILES ['upload_file'] ['name'] ) );
		if (! in_array ( strtolower ( fileext ( $_FILES ['upload_file'] ['name'] ) ), $type )) {
			$text = implode ( ",", $type );
			echo "只允许一下格式", $text, "<br>";
		} else {
			$filename = explode ( ".", $_FILES ['upload_file'] ['name'] );
			do {
				$filename [0] = random ( 10 );
				$name = implode ( ".", $filename );
				$uploadfile = $uploaddir . $name;
				// echo $uploadfile;
			} while ( file_exists ( $uploadfile ) );

			if (move_uploaded_file ( $_FILES ['upload_file'] ['tmp_name'], $uploadfile )) {
				if (is_uploaded_file ( $_FILES ['upload_file'] ['tmp_name'] ))
					echo "上传失败";
				else {
					echo "<center>预览</center><br><center><img src='$uploadfile'></center>";
					echo "<br><center><a href='#'>继续下载</a></center>";
				}
			}
		}
		$data = array (
				"name" => $book_name,
				"info" => $info,
				"url" => $url,
				"img_url" => $uploadfile
		);
		$book = new Book ( $data );
		$book->insert ();
	} elseif (isset ( $_POST ['action'] ) && $_POST ['action'] == "update") {
		$data = array (
				"name" => $book_name,
				"info" => $info,
				"url" => $url,
				"img_url" => $uploadfile
		);
		$book = new Book ( $data );
		$book->updateByName ();
	} elseif (isset ( $_POST ['action'] ) && $_POST ['action'] == "delete") {
		$name = $_REQUEST ['name'];
		Book::deleteByName ( $name );
	}
} catch ( Exception $e ) {
	die ( "error: " . $e->getMessage () );
}
function fileext($filename) {
	return substr ( strrchr ( $filename, "." ), 1 );
}
function random($length) {
	$hash = "CR-";
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen ( $chars ) - 1;
	mt_srand ( ( double ) microtime () * 1000000 );
	for($i = 0; $i < $length; $i ++) {
		$hash .= $chars [mt_rand ( 0, $max )];
	}
	return $hash;
}
?>
</body>
</html>
