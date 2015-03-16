<?php 
	require_once("./db/Message.class.php");
	require_once("./db/config.php");
	function showMessages(){ 
?>
	<table class="table table-hover">
		<tr>
		<td width="4">#</td>
		<td width="50">content</td>
		<td width="20">email</td>
		</tr>
<?php 
	$start=isset($_GET["start"])?(int)$_GET["start"]:0;
	list($messages,$totalRows)=Message::getMessages($start,(int)PAGE_SIZE,"id");
	$rowCount=0;
	foreach($messages as $one){
		$rowCount++;
		echo "<tr>\n";
		echo "<td>" . $one->getValue("id") . "</td>";
		echo "<td>" . $one->getValue("content") . "</td>";
		echo "<td>" . $one->getValue("email") . "</td>";
		echo "</tr>\n";
	}
?>
</table>
<div sytle="width: 30em; margin-top: 20px; text-align: center;">
	<?php if($start>0){ ?>
		<a href="index-<?php echo max($start-PAGE_SIZE,0);?>.html"><i class="icon-chevron-left"></i></a>
	<?php }
	 if($start+PAGE_SIZE<$totalRows){ ?>
		<a href="index-<?php echo min($start+PAGE_SIZE,$totalRows); ?>.html"><i class="icon-chevron-right"></i></a>
</div>	
</div>
<?php }} ?>
