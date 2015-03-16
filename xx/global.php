<?php
error_reporting(E_ALL);

require(dirname(__FILE__)."/database/config_mysql.php");

require(dirname(__FILE__)."/class/class_Mysql.php");

$DB = new DB_MySQL;
?>