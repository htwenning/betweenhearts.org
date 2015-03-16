<?php
	if(isset($_GET['action']) && $_GET['action']=='test'){ 
		echo "test content:".$_GET['testContent'];
	}else{
		echo "error!";
	}