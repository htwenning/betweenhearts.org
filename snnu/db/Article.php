<?php
require_once './db/DataObject.class.php';
require_once './db/config.php';
class Article extends DataObject {
	protected $data=array(
		"id"=>"",
		"title"=>"",
		"description"=>"",
		"url"=>"",
		"image"=>"",
		"tags"=>"",
		"no"=>""
	);
	public static function getArticles($startRow,$numRows,$order){
		$conn=parent::connect2();
		$sql="select SQL_CALC_FOUND_ROWS * from snnu_articles order by $order desc limit $startRow,$numRows";
		try{
			$result=mysql_query($sql,$conn);
			$articles=array();
			while($arr=mysql_fetch_assoc($result)){
				$articles[]=new Article($arr);
			}
			$result2=mysql_query("select found_rows() as totalRows",$conn);
			$row=mysql_fetch_assoc($result2);
			parent::disconnect2($conn);
			return array($articles,$row["totalRows"]);
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	public static function getArticlesByTags($tags){
		if($tags==null) return;
		$conn=parent::connect2();
		$sql="select * from snnu_articles";
		$count=0;
		try{
			$result=mysql_query($sql,$conn);
			$articles=array();
			while($arr=mysql_fetch_assoc($result)){
				//echo " * ".$arr["tags"]."?".$tags."<br>";
				if(strstr($arr["tags"],$tags)){
					$articles[]=new Article($arr);
					$count++;
				}
			}
			parent::disconnect2($conn);
			return array($articles,$count);
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	public static function getArticlesByRange($num1,$num2){
		if($num1>$num2){
			$tmp=$num1;
			$num1=$num2;
			$num2=$tmp;
		}
		$count=$num2-$num1+1;
		$num1--;
		$conn=parent::connect2();
		$sql="select SQL_CALC_FOUND_ROWS * from snnu_articles order by 'id' desc limit $num1,$count";
		try{
			$result=mysql_query($sql,$conn);
			$articles=array();
			while($arr=mysql_fetch_assoc($result)){
				$articles[]=new Article($arr);
			}
			$result2=mysql_query("select found_rows() as totalRows",$conn);
			$row=mysql_fetch_assoc($result2);
			parent::disconnect2($conn);
			return array($articles,$row["totalRows"]);
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	public static function getArticleById($id){
		$conn=parent::connect2();
		$sql="select * from snnu_articles where id=".$id;
		try{
			if($result=mysql_query($sql,$conn)){
			
			$arr=mysql_fetch_assoc($result);
			$article=new Article($arr);
			parent::disconnect2($conn);
			return $article;}
			else{
				$article=null;
				return $article;
			}
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	public static function getArticleByNo($id){
		$conn=parent::connect2();
		$sql="select * from snnu_articles where no=".$id;
		$count=0;
		try{
			$result=mysql_query($sql,$conn);
			$articles=array();
			while($arr=mysql_fetch_assoc($result)){
				//echo " * ".$arr["tags"]."?".$tags."<br>";
				$articles[]=new Article($arr);
				$count++;
				
			}
			parent::disconnect2($conn);
			return array($articles,$count);
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	//获取最新一期内容
	public static function getLatest(){
		$conn=parent::connect2();
		/*
		//where用作在聚集（group by ）前，having用在聚集后
		$sql="select * from articles having id=max(id);";
		*/
		$sql="select max(no) as latestNo from snnu_articles";
		$result=mysql_query($sql,$conn);
		$arr=mysql_fetch_assoc($result);
		$latestNo=$arr['latestNo'];
		$sql="select * from snnu_articles where id='$latestNo'";
		try{
			$articles=array();
			if($result=mysql_query($sql,$conn)){
				$count=0;
				
				while($arr=mysql_fetch_assoc($result)){
					$articles[]=new Article($arr);
					$count++;
				}
				parent::disconnect2($conn);
				return array($articles,$count);
			}
			else{
				$articles=null;
				return array($articles,$count);
			}
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		} 
	}
	public static function getLatestNo(){
		$conn=parent::connect2();
		$sql="select max(no) as latestNo from snnu_articles";
		$result=mysql_query($sql,$conn);
		$arr=mysql_fetch_assoc($result);
		$latestNo=$arr['latestNo'];
		return $latestNo; 
	}
	
	public function insert(){
		$conn=parent::connect2();
		mysql_query("SETNAMES 'UTF8'");
		$sql="insert into snnu_articles(title,description,url,image,tags,no) values(\"".$this->data['title']."\",\"".$this->data['description']."\",\"".$this->data['url']."\",\"".$this->data['image']."\",\"".$this->data['tags']."\",\"".$this->data['no']."\")";
		//$sql="insert into books (name,info,url,img_url) values("."\"".$this->data['name']."\"".",\"".$this->data['info']."\")";
		//echo $sql;
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "插入成功";
			else echo "failed";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
	public function deleteById($id){
		$conn=parent::connect2();
		//删除
		$sql="delete from snnu_articles where id='$id'";
		//echo $sql;
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "删除成功";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
	public function updateByTitle(){
		$conn=parent::connect2();
		//删除图片
		$sql1="select * from snnu_aritcles where title=\"".$this->data['title']."\"";
		$res=mysql_query($sql1,$conn);
		$row=mysql_fetch_array($res);
		//
		
		$sql="update snnu_articles set url=\"".$this->data['url']."\",\"description=\"".$this->data['description']."\",image=\"".$this->data['image']."\" where title=\"".$title."\"";
		echo $sql;
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "update success";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
	public function updateById($id){
		$conn=parent::connect2();	
		$sql="update snnu_articles set url=\"".$this->data['url']."\",description=\"".$this->data['description']."\",image=\"".$this->data['image']."\",title=\"".$this->data['title']."\",no=\"".$this->data['no']."\",tags=\"".$this->data['tags']."\" where id=\"".$id."\"";
		//echo $sql;
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "修改成功";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
}
class Pic extends DataObject {
	protected $data=array(
		"id"=>"",
		"image"=>"",
		"time"=>""
	);

	public function insert(){
		$conn=parent::connect2();
		mysql_query("SETNAMES 'UTF8'");
		$sql="insert into snnu_pics(image) values(\"".$this->data['image']."\")";
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "insert success";
			else echo "failed";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
	public static function getPics($startRow,$numRows,$order){
		$conn=parent::connect2();
		$sql="select SQL_CALC_FOUND_ROWS * from snnu_pics order by $order desc limit $startRow,$numRows";
		try{
			$result=mysql_query($sql,$conn);
			$pics=array();
			while($arr=mysql_fetch_assoc($result)){
				$pics[]=new Pic($arr);
			}
			$result2=mysql_query("select found_rows() as totalRows",$conn);
			$row=mysql_fetch_assoc($result2);
			parent::disconnect2($conn);
			return array($pics,$row["totalRows"]);
		}catch (Exception $e){
			parent::disconnect2($conn);
			die("query failed:".$e->getMessage());
		}
	}
	public static function deleteAll(){
		$conn=parent::connect2();
		//删除
		$sql="delete from snnu_pics";
		try{
			$result=mysql_query($sql,$conn);
			if($result) echo "删除成功";
			parent::disconnect2($conn);
		}catch(Exception $e){
			die("error:".$e->getMessage());
		}
	}
}
?>