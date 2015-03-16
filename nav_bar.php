<?php
	function isActive($str){
		global $activeName;
		if(isset($activeName) and $str==$activeName){
			echo "class=\"active\"";
		}else{
			echo "";
		}
	}
?>
<div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">吴俊和我</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?php isActive("index") ?>>
                <a href="./index.html">首页</a>
              </li>
			  <li <?php isActive("books") ?>>
                <a href="./books.html">读书</a>
              </li>
			  <li <?php isActive("bbs") ?>>
                <a href="./bbs/forum.html">论坛</a>
              </li>
			  <li <?php isActive("about") ?>>
                <a href="./about.html">关于</a>
              </li>
			  <!--
              <li class="">
                <a href="#" class="bootstro" data-bootstro-title="" data-bootstro-placement="bottom" data-bootstro-step="0">起步</a>
              </li>
              <li class="">
                <a href="#">关于</a>
              </li>
			  -->
            </ul>
          </div>
        
      </div>
    </div>
</div>