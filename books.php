<?php
include_once 'index_header.php';
$activeName = "books";
include_once 'nav_bar.php';
require_once 'db/Book.php';
require_once 'db/config.php';
?>
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
<section>
	<br> <br>
	<div>
	<a href="./add_book.html">编辑书目</a>
	<?php
	$start = isset ( $_GET ["start"] ) ? ( int ) $_GET ["start"] : 0;
	list ( $books, $totalRows ) = Book::getBooks ( $start, ( int ) PAGE_SIZE, "id" );
	$rowCount = 0;
	echo "<center><table class=\"table table-hover\">";
	foreach ( $books as $one ) {
		$rowCount++;
		
		echo "<tr><td><img src=\"".$one->getValue("img_url"). "\" onload=\"DrawImage(this)\"></td>";
		echo "	<td>
					<table>
						<tr>";
		echo "<td>".$one->getValue("name")."</td>
							<td></td>
						</tr>
						<tr>";
		echo	"<td>".$one->getValue("info")."</td>";
		echo		"<td><a href=\"".$one->getValue("name")."\">下载</a></td>
						</tr>
					</table>
				</td></tr>"
			;
	}
	echo "</table></center>";
	?>
	<center><div sytle="width: 30em; margin-top: 20px; text-align: center;">
	<?php if($start>0){ ?>
		<a href="books-<?php echo max($start-PAGE_SIZE,0);?>.html">上一页</a>
	<?php }
	 if($start+PAGE_SIZE<$totalRows){ ?>
		<a href="books-<?php echo min($start+PAGE_SIZE,$totalRows); ?>.html">下一页</a>
	</div></center>
	<?php } ?>
<?php include_once 'index_footer.php';?>