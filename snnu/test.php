<?php
	$reg="/(\d+)[^0-9]+(\d+)/i";
	if(preg_match($reg,$str,$res)){//如果是区间
			$num1=$res[1];
						$num2=$res[2];