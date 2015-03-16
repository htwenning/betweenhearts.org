<?php
require_once 'db/DataObject.class.php';
require_once 'db/config.php';
class Book extends DataObject {
	protected $data=array(
		"id"=>"",
		"name"=>"",
		"info"=>"",
		"url"=>"",
		"img_url"=>"",
	);
	public static function getBooks($startRow,$numRows,$order){
		$conn=parent::connect2();
		$sql="select SQL_CALC_FOUND_ROWS * from books order by $order desc limit $startRow,$numRows";
		try{
			$result=mysql_query($sql,$conn);
			$books=array();
			while($arr=mysql_fetch_assoc($result)){
				$books[]=new Book($arr);
			}
			$result2=mysql_query("select found_rows() as totalRows",$conn);
			$row=mysql_fetch_assoc($result2);
			parent::disconnect2($conn);
			return array($books,$row["totalRows"]);
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	public function insert(){
		$conn=parent::connect2();
		mysql_query("SETNAMES 'UTF8'");
		$sql="insert into books(name,info,url,img_url) values(\"".$this->data['name']."\",\"".$this->data['info']."\",\"".$this->data['url']."\",\"".$this->data['img_url']."\")";
		//$sql="insert into books (name,info,url,img_url) values("."\"".$this->data['name']."\"".",\"".$this->data['info']."\")";
		echo $sql;
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "insert success";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
}

?>