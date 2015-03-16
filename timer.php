<?php 
	$timer1= strtotime(date("Y-m-d"));
	$timer2=strtotime("2013-10-3");
	$sub2=ceil(($timer1-$timer2)/86400);
	echo $sub2;
?>