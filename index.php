<?php include_once("index_header.php");
		$activeName="index";
		include_once("nav_bar.php");
		include_once("./db/ShowMessages.php");
?>
    <div>
    <p><br><br></p>
    </div>
    <div>
	<header class="jumbotron subhead" id="overview">
  		<div class="container">
        	<h1>首页</h1>
        	<p class="lead">今天是第<?php include_once("timer.php"); ?>天</p>
  		</div>
    </header>
    </div>
    <section>
    <div class="container">
        <div class="span9">      
            <section>
            <div class="bs-docs-example">
                  <div class="hero-unit">
                    <h1>在宁静的一念之间，</h1>
                    <p>我想脱离这恼人的尘世，在苍山残阳下，与你一同抓住天边的温暖，守住心中没有陨落的梦想。</p>
                    <p><a class="btn btn-primary btn-large" href="http://www.betweenhearts.org/blogs">进入博客</a></p>
                  </div>
              </div>
             </section>
        </div>
	</div>
    </section>
    <section>
    	<!--内容-->
		<?php
			if(isset($_POST["action"]) and $_POST["action"]=="writeMessage"){
				$_POST["action"]="";
				processForm();
				
			}else{
			}
			function processForm(){
				$requireFields=array("content","email");
				$missingFields=array();
				$errorMessages=array();
				if(!isset($_POST["content"])){
					echo '<p class="error">内容不能为空</p>';
					return;
				}
				$message=new Message(array("content"=>$_POST["content"],"email"=>isset($_POST["email"])?$_POST["email"]:""));
				$message->insert();
			}
		?>
		<div class="container">
			<!--<form class="form-horizontal pull-left" action="index.php" method="post" >-->
			<form class="form-horizontal pull-left" method="post" >
				<input type="hidden" name="action" value="writeMessage"/>
				<div class="control-group">
					<div class="controls">
						<textarea class="input-xlarge" name="content" cols="100" rows="3" placeholder="由于广告哥的行为，现在暂不能留言"></textarea>
					</div>
					<div class="controls pull-right">
						<button type="button" class="btn">Submit</button>
					</div>
				</div>
			</form>
			<br>
			<?php showMessages(); ?>
		</div>
    </section>
<?php include_once("index_footer.php") ?>