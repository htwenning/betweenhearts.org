<?php
 include "./db/Article.php";
 ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>
ccmagical
</title>

</head>
<body>
<a href="./add_article.html">发布（修改）文章<a><br><br>
<a href="./showPics.html">查看来稿<a>
<section>
	<br> <br>
	<div>

	<?php
	$start = isset ( $_GET ["start"] ) ? ( int ) $_GET ["start"] : 0;
	list ( $articles, $totalRows ) = Article::getArticles ( $start, ( int ) PAGE_SIZE, "id" );
	$rowCount = 0;
	echo '<center><table  width="400" border="1" cellspacing="0" cellpadding="0"><tr>';
	echo "<td>id</td><td>期号</td><td>标题</td><td>简介</td><td>文章链接</td><td>图片链接</td><td>标签</td></tr>";
	foreach ( $articles as $one ) {
		$rowCount++;
		
		echo "<tr>";
		echo "<td>".$one->getValue("id")."</td>";
		echo "<td>".$one->getValue("no")."</td>";
		echo "<td>".$one->getValue("title")."</td>";
		echo "<td>".$one->getValue("description")."</td>";
		echo "<td>".$one->getValue("url")."</td>";
		echo "<td>".$one->getValue("image")."</td>";
		echo "<td>".$one->getValue("tags")."</td>";
		echo	"</tr>";
	}
	echo "</table></center>";
	?>
	<center><div sytle="width: 30em; margin-top: 20px; text-align: center;">
	<?php if($start>0){ ?>
		<a href="index-<?php echo max($start-PAGE_SIZE,0);?>.html">上一页</a>
	<?php }
	 if($start+PAGE_SIZE<$totalRows){ ?>
		<a href="index-<?php echo min($start+PAGE_SIZE,$totalRows); ?>.html">下一页</a>
	</div></center>
	<?php } ?>


</body>
</html>