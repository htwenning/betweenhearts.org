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
					$contentStr="感谢你的来稿。你的作品我们正在审核，我们会在《摄友的作品》一期中择优展出。谢谢！";
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
						$contentStr="最新一期是《";
						
						$article=Article::getLatest();
						if($article!=null){
							$contentStr.=$article->getValue('title')."》;现在一共有".$article->getValue('no')."期。可以回复数字或者关键词查看哦。";
						}else{
							$contentStr="还没做好。。。";
						}
						echo $article->getValue('id');
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					$articles=array();
					$article=Article::getArticleByNo($keyword);
					$articles[0]=$article;
					if($article==null or $article->getValue("title")==null){
						$contentStr="这一期还没出呢。";
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
						$contentStr = "CcForLove光影工作室欢迎您的到来，介于技术有限，您的信息可能无法第一时间得到订阅号公共端的回答，如需帮助请添加微信号ccmagical为好友，我们将为你一一解答，谢谢！
回复 数字 查看这一期的内容;
回复 任意文字 查看有这个标签的内容；
回复 简介 查看工作室简介；
回复 状况 查看工作室发展状况；
回复 展示 查看广大摄友作品展示；
回复 帮助 查看本消息；";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					if($keyword=="简介"){
						$contentStr = "/礼物我们是一群走在光影路上朝气蓬勃的青年，我们用快门定格人生，镜头审视世界。/礼物

/礼物追求用好作品打动每名观众使我们的梦想，欢饮各位为摄影而心动的朋友加入我们。/礼物
          
 CcForLove光影工作室
成立于2014.6.20。

核心成员7名：
Cc、靠得住、追光逐影、灵魂乐师、东东抢、『啵儿』宇；
程序员：文大师。 

CcForLove光影工作室欢迎大家的到来！/可爱";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					if($keyword=="状况"){
						$contentStr = "CcForLove光影工作室第一张作品展示至今，已有百余名摄友加入我们，在这里，Cc代表工作室全体感谢大家的支持！
我们会用最好的作品打动每一位观众，相信在大家的关注分享下，
CcForLove光影工作室会越做越好！
真心感谢大家！";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					if($keyword=="展示"){
						$contentStr = "正在制作中。。。。";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					if($keyword=="活动"){
						$contentStr = "工作室因为处于成立之初，急需各类优秀人才加入，加之优秀摄影作品一张难求，工作室需要大家的帮助，每名摄友可以发送自己的优秀摄影作品至公共账号端，待审核后，作品优秀者，我们会在征询本人同意下，吸收入会，你就可以成为主编啦！行动起来吧，分享你的作品，展示别样风采！";
						echo $this->sendText($postObj, $contentStr);
						exit;
					}
					//根据tags查找要反回的
					$articles=array();
                	list ( $articles, $totalRows )=Article::getArticlesByTags($keyword);
					$totalRows=count($articles);
					if($totalRows!=0){
						echo $this->sendPics($postObj,$articles);
						exit;
					}else{//没有找到指定的
						$contentStr = "没有找到相关内容";
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
                $contentStr = "您好，欢迎关注CcForLove光影工作室！
				回复 帮助 查看相应的提示;
				回复 数字或文字查看您感兴趣的内容。";
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
		$picTplH = "<xml>
		   <ToUserName><![CDATA[%s]]></ToUserName>
		   <FromUserName><![CDATA[%s]]></FromUserName>
		   <CreateTime>%s</CreateTime>
		   <MsgType><![CDATA[news]]></MsgType>
		   <ArticleCount>$totalRows</ArticleCount>
		   <Articles>";
		$picTplH=sprintf($picTplH, $object->FromUserName, $object->ToUserName,time());
		$picTplE="
		   </Articles>
		   </xml> ";
		foreach($articles as $one){
			$picTplM.="<item>
		   <Title><![CDATA[".$one->getValue("title")."]]></Title>
		   <Description><![CDATA[".$one->getValue("description")."]]></Description>
		   <PicUrl><![CDATA[".$image = $one->getValue("image")."]]></PicUrl>
		   <Url><![CDATA[".$one->getValue("url")."]]></Url>
		   </item>";
		}
		$resultStr=$picTplH.$picTplM.$picTplE;
		return $resultStr;
	}
}

?>