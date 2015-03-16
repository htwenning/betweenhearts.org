<?php
 include_once "./db/Article.php";
 ?>
 <html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>
查看来稿
</title>


<script type="text/javascript">
	var flag=false;
	function DrawImage(image){
		//var tmp=new Image();
		//var iwidth=50;
		var maxWidth=100;
		//var iheigt=50;
		var maxHeight=100;
		if(image.width>=maxWidth){
			image.height=image.height*maxWidth/image.width;
			image.width=maxWidth;
		}else if(image.height>=maxHeight){
			image.width=image.width*maxHeight/image.height;
			image.height=maxHeight;
		}
	}
</script>
</head>
<body>
<a href="http://www.betweenhearts.org/snnu/index.html">返回首页</a><br>
<form method="post" enctype="multipart/form-data" action='showPics.html'>
	<input type="hidden" name="action" value="delete" /> <input type="submit" name="submit"
		value="清除照片"><br>
</form>
<section>
<?php
	if (isset ( $_POST ['action'] ) && $_POST ['action'] == "delete") {
		
		Pic::deleteAll();
	}
?>

	<?php
	$start = isset ( $_GET ["start"] ) ? ( int ) $_GET ["start"] : 0;
	list ( $pics, $totalRows ) = Pic::getPics ( $start, ( int ) PIC_PAGE_SIZE, "id" );
	$rowCount = 0;
	echo "<center><table>";
	
	foreach ( $pics as $one ) {
		$rowCount++;
		echo "<tr><td><img src=\"".$one->getValue("image"). "\" onload=\"DrawImage(this)\"></td>";
		echo "<td>".$one->getValue("time")."</td></tr>";
		
	}
	echo "</table></center>";
	?>
	<center><div sytle="width: 30em; margin-top: 20px; text-align: center;">
	<?php if($start>0){ ?>
		<a href="showPics-<?php echo max($start-PIC_PAGE_SIZE,0);?>.html">上一页</a>
	<?php }
	 if($start+PIC_PAGE_SIZE<$totalRows){ ?>
		<a href="showPics-<?php echo min($start+PIC_PAGE_SIZE,$totalRows); ?>.html">下一页</a>
	</div></center>
	<?php } ?>
	</body>
	</html>