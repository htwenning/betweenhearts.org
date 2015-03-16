<?php 
	require_once "DataObject.class.php";
	class Message extends DataObject{
		protected $data=array(
			"id"=>"",
			"content"=>"",
			"email"=>"",
			"date"=>""
		);
		public static function getMessages($startRow, $numRows, $order){
			$conn=parent::connect();
			$sql="select SQL_CALC_FOUND_ROWS * FROM " . "W_messages" . " ORDER BY $order desc LIMIT :startRow, :numRows";
			try{
				$st=$conn->prepare($sql);
				$st->bindValue(":startRow", $startRow, PDO::PARAM_INT);
				$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
				$st->execute();
				$messages=array();
				foreach( $st->fetchAll() as $row ){
					$messages[] = new Message( $row );
				}
				$st = $conn->query("select found_rows() as totalRows");
				$row = $st->fetch();
				parent::disconnect($conn);
				return array($messages, $row["totalRows"]);
			} catch(PDOException $e){
				parent::disconnect($conn);
				die("Query failed: " . $e->getMessage());
			}
		}
		public static function getMessage($id){
			$conn=parent::connect();
			$sql="select * from " . "W_messages". " where id = :id";
			try{
				$st=$conn->prepare($sql);
				$st->bindValue(":id",$id,PDO::PARAM_INT);
				$st->execute();
				$row=$st->fetch();
				parent::disconnect($conn);
				if($row) return new Message($row);
			} catch(PDOException $e){
				parent::disconnect($conn);
				die("Query failed: " . $e->getMessage());
			}
		}
		public function insert(){
			$conn=parent::connect();
			$sql="insert into W_messages (content,email) values(:content,:email)";
			try{
				$st=$conn->prepare($sql);
				$st->bindValue(":content",$this->data["content"],PDO::PARAM_STR);
				$st->bindValue(":email",$this->data["email"],PDO::PARAM_STR);
				$st->execute();
				parent::disconnect($conn);
				
			} catch(PDOException $e){
				parent::disconnect($conn);
				echo $e->getMessage();
			}
		}
		
	}