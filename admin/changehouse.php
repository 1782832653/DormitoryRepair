<?php
require_once('Loginverify.php');
require '../config.php';
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
$mysqli->set_charset('utf8');
//$query = $mysqli->query('select * from dorm_order order by `id` desc limit '.($previous * 5).',5');
//$result = $query->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>宿舍分配 - 后台管理</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />    
    
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/bootstrap-responsive.min.css" rel="stylesheet" />
    
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" />-->
    <link href="./css/font-awesome.css" rel="stylesheet" />
    
    <link href="./css/adminia.css" rel="stylesheet" /> 
    <link href="./css/adminia-responsive.css" rel="stylesheet" /> 
    
    <link href="./css/pages/dashboard.css" rel="stylesheet" /> 
    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
	
<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 				
			</a>
			
			<a class="brand" href="./">Rains</a>
			
			<div class="nav-collapse">
			
				<ul class="nav pull-right">
					
					<li class="divider-vertical"></li>
					
					<li class="dropdown">
						
						<a data-toggle="dropdown" class="dropdown-toggle " href="#">
							宿舍管理系统 <b class="caret"></b>							
						</a>
						
						<ul class="dropdown-menu">
							<li>
								<a href="index.php?act=logoff"><i class="icon-off"></i> 退出</a>
							</li>
						</ul>
					</li>
				</ul>
				
			</div> <!-- /nav-collapse -->
			
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->




<div id="content">
	
	<div class="container">
		
		<div class="row">
			
			<div class="span3">
				
				<div class="account-container">
				
					<div class="account-avatar">
						<img src="./img/headshot.jpg" alt="" class="thumbnail" />
					</div> <!-- /account-avatar -->
				
					<div class="account-details">
					
						<span class="account-name">管理账户</span>
						
						<span class="account-role">管理员</span>
					
					</div> <!-- /account-details -->
				
				</div> <!-- /account-container -->
				
				<hr />
				<ul id="main-nav" class="nav nav-tabs nav-stacked">					
					<li>
						<a href="./">
							<i class="icon-home"></i>
							后台首页
						</a>
					</li>
				
					<li>
						<a href="history.php">
							<i class="icon-th-large"></i>
							历史记录
						</a>
					</li>
                  
					<li>
						<a href="data.php">
							<i class="icon-th-large"></i>
							导出记录
						</a>
					</li>
                  
					<li>
						<a href="person.php">
							<i class="icon-th-large"></i>
							工人管理
						</a>
					</li>
					<li class="active">
						<a href="./changehouse.php">
							<i class="icon-th-large"></i>
							修改宿舍号
      					</a>
					</li>
				</ul>	
				<hr />
				
				<div class="sidebar-extra">

				</div> <!-- .sidebar-extra -->
				
				<br />
		
			</div> <!-- /span3 -->
			
			
			
			<div class="span9">
				
				<h1 class="page-title">
					<i class="icon-th-large"></i>
					修改用户信息
				</h1>
				
				
				<div class="row">
				</div> <!-- /widget-content -->
							
				</div> <!-- /widget -->
						
					</div> <!-- /span9 -->
				
				</div> <!-- /row -->
		
				
			</div> <!-- /span9 -->
			
			
		</div> <!-- /row -->
		
	</div> <!-- /container -->
	
</div> <!-- /content -->
					
	
<div id="footer">
	
	<div class="container">				
		<hr />
		<p>&copy; 2017 Rains.</p>
	</div> <!-- /container -->
	
</div> <!-- /footer -->


   

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="./js/jquery-1.7.2.min.js"></script>


<script src="./js/bootstrap.js"></script>

  </body>
</html>