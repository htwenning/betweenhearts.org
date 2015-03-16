<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");

include_once "./db/Article.php";
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$RX_TYPE = trim($postObj->MsgType);
				if($RX_TYPE=="event"){//接收到的是事件
					$resultStr = $this->receiveEvent($postObj);
					echo $resultStr;
					exit;
				}
				if($RX_TYPE=="image"){
					$contentStr="感谢您的来稿。";
					echo $this->sendText($postObj, $contentStr);
					$PicUrl=$postObj->PicUrl;
					$data=array(
					"id"=>"",
					"image"=>"",
					"time"=>""
					);
					$data['image']=$PicUrl;
					$pic=new Pic($data);
					$pic->insert();
					exit;
				}
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
				
				if(isset( $keyword ) and is_numeric($keyword))//直接返回要看的期数
				{
					if($keyword==999){//查看管理说明文章
						$data = array (
							"title" => "开发模式如何管理文章？",
							"description" => "开发模式搭建完成了，管理员们看看如何管理每期的内容。",
							"url" => 'http://mp.weixin.qq.com/s?__biz=MzAwMDAwMDg2MA==&mid=201604918&idx=1&sn=1133ea617152bdbbd09021c06c1a27e0#rd',
							"image" =>'https://mmbiz.qlogo.cn/mmbiz/dLAwneDacwIBoI2I5uFrV0KtGY8chJ10XttfWllSwagfFNQ3P9m53fxFosWrgDkDH3IPKe7lia0y1gFNUqS8qrQ/0',
							"tags"=>"",
							"no"=>999
						);
						$articles=array();
						$articles[0]=new Article($data);
						echo $this->sendPics($postObj,$articles);
						exit;
					}
					if($keyword==0){//显示最近状况
						$articles=array();
						$contentStr="最新一期是内容有";
						$latestNo=Article::getLatestNo();
						list($articles,$count)=Article::getArticleByNo($latestNo);
						if($articles[0]!=null){
							foreach($articles as $article){
								$contentStr.="\"".$article->getValue('title')."\";";
							}
							$contentStr.="一共有".$latestNo."期。可以回复你感兴趣的内容看看。";
						}else{
							$contentStr="还没做好。。。";
						}
						echo $article->getValue('id');
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					$articles=array();
					list($articles,$totalRows)=Article::getArticleByNo($keyword);
					//$articles[0]=$article;
					if($articles[0]==null or $articles[0]->getValue("title")==null){
						$contentStr="这一期还没出呢。发送小一点儿的数字或者0试试吧";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					echo $this->sendPics($postObj,$articles);
					exit;
                }else{//非数字
					$reg="/(\d+)[^0-9]+(\d+)/i";
					if(preg_match($reg,$keyword,$res)){//如果是区间
						$num1=$res[1];
						$num2=$res[2];
						//echo transmitText($postObj,"test");
						//exit;
						$articles=array();
						list($articles,$totalRows)=Article::getArticlesByRange($num1,$num2);
						$totalRows=count($articles);
						if($articles!=null and $totalRows>0){
							echo $this->sendPics($postObj,$articles);
						}
						exit;
					}
					//根据关键词反回
					if($keyword=="帮助"){
						$contentStr = "陕师大思政1班欢迎您，
回复 数字 查看这一期的内容;
回复 任意文字 查看相关内容；
回复 简介 查看班级简介；
回复 帮助 查看本消息；
您也可以发送有趣的图片给我们哦";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					if($keyword=="简介"){
						$contentStr = "这是陕师大2013级思政1班的微信订阅号，欢迎您的订阅。";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					
					//根据tags查找要反回的
					$articles=array();
                	list ( $articles, $totalRows )=Article::getArticlesByTags($keyword);
					$totalRows=count($articles);
					if($totalRows!=0){
						if($totalRows<11){
							echo $this->sendPics($postObj,$articles);
							exit;
						}else{
							echo $this->sendPics($postObj,$articles);
							exit;
						}
					}else{//没有找到指定的
						$contentStr = "没有找到相关内容。输入其它内容试试。";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	private function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "您好，欢迎关注陕西师范大学2013级思政1班！
				回复 帮助 查看相应的提示；回复数字或文字看看相关内容。";
                break;
        }
        $resultStr = $this->sendText($object, $contentStr);
        return $resultStr;
    }
	private function sendText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }
	private function sendPics($object,$articles){
		$totalRows=count($articles);
		if(totalRows<11) $count=$totalRows;
		else $count=10;
		$picTplH = "<xml>
		   <ToUserName><![CDATA[%s]]></ToUserName>
		   <FromUserName><![CDATA[%s]]></FromUserName>
		   <CreateTime>%s</CreateTime>
		   <MsgType><![CDATA[news]]></MsgType>
		   <ArticleCount>$count</ArticleCount>
		   <Articles>";
		$picTplH=sprintf($picTplH, $object->FromUserName, $object->ToUserName,time());
		$picTplE="
		   </Articles>
		   </xml> ";
		if($totalRows<11){
			foreach($articles as $one){
				$picTplM.="<item>
			   <Title><![CDATA[".$one->getValue("title")."]]></Title>
			   <Description><![CDATA[".$one->getValue("description")."]]></Description>
			   <PicUrl><![CDATA[".$image = $one->getValue("image")."]]></PicUrl>
			   <Url><![CDATA[".$one->getValue("url")."]]></Url>
			   </item>";
			}
		}else{//内容过多，发送最新的10期
			for($i=0;$i<10;$i++){
				$one=$articles[--$totalRows];
				$picTplM.="<item>
			   <Title><![CDATA[".$one->getValue("title")."]]></Title>
			   <Description><![CDATA[".$one->getValue("description")."]]></Description>
			   <PicUrl><![CDATA[".$image = $one->getValue("image")."]]></PicUrl>
			   <Url><![CDATA[".$one->getValue("url")."]]></Url>
			   </item>";
			}
		}
		$resultStr=$picTplH.$picTplM.$picTplE;
		return $resultStr;
	}
}

?>