<?php
require_once('Loginverify.php');
require '../config.php';
$pages = @$_GET['pages']?@$_GET['pages']:1;
$previous = $pages - 1;
$next = $pages + 1;
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
$mysqli->set_charset('utf8');
$query = $mysqli->query('select * from dorm_order order by `id` desc limit '.($previous * 5).',5');
$result = $query->fetch_all(MYSQLI_ASSOC);
//统计条数
$queryCount = $mysqli->query('select count(*) from dorm_order');
$Count = $queryCount->fetch_all(MYSQLI_ASSOC);
//print_r($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>历史记录 - 后台管理</title>
    
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
				
					<li class="active">
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
					<li>
						<a href="./changehouse.php">
							<i class="icon-th-large"></i>
							修改宿舍号
      					</a>
					</li>
				</ul>	
				<hr />
				
				<div class="sidebar-extra">
					<!--<p>这里是提示信息文字这里是提示信息文字这里是提示信息文字这里是提示信息文字这里是提示信息文字这里是提示信息文字这里是提示信息文字这里是提示信息文字.</p>-->
				</div> <!-- .sidebar-extra -->
				
				<br />
		
			</div> <!-- /span3 -->
			
			
			
			<div class="span9">
				
				<h1 class="page-title">
					<i class="icon-th-large"></i>
					宿舍报修历史记录				
				</h1>
				
				
				<div class="row">
				<!--<div class="span9"><div class="widget"><input type="text" value="" placeholder="输入关键字"/></div></div>-->
					<?php for($i=0;$i<count($result);$i++){ ?>
					<div class="span9">
				
						<div class="widget">
									
							<div class="widget-content">
								
								<h3><span class="label label-default">ID:<?php echo $result[$i]['id'];?></span>&nbsp;<span class="label label-info">UID:<?php echo $result[$i]['uid'];?></span>&nbsp;<?php echo $result[$i]['floor'].'-'.$result[$i]['room'];?></h3>
								<?php
								if($result[$i]['access'] == 1){
									$access = '<font color="green">允许无人时维修</font>';
								}else{
									$access = '<font color="red">不允许无人时维修</font>';
								}
								if($result[$i]['RepairPerson'] == false ){
									$RepairPerson = "等待分配";
								}else{
									$RepairPerson = $result[$i]['RepairPerson'];
								}
								switch($result[$i]['state']){
									case 0:
										$state = '<span class="label label-info">等待维修</span>';
										break;
									case 1:
										$state = '<span class="label label-success">维修成功</span>';
										break;
									case -1:
										$state = '<span class="label label-danger">订单取消</span>';
										break;
								}
								echo "
								故障类型：{$result[$i]['type']}<hr />
								具体故障：{$result[$i]['desc']}<hr />
								联系电话：<span class=\"label label-default\">{$result[$i]['tel']}</span><hr />
								无人时维修：{$access}<hr />
								订单创建时间：{$result[$i]['SubmitTime']}<hr />
								维修工人/状态：<span class=\"label label-default\">{$RepairPerson}</span> / {$state}";
								?>
							</div> <!-- /widget-content -->
							
						</div> <!-- /widget -->
						
					</div> <!-- /span9 -->
					<?php } ?>
					<div class="span9">
						<!-- 上下页 加previous next实现两端对齐  badge徽章-->
						<ul class="pager">
							<?php 
							if($previous <=0){
								echo '<li class="previous disabled"><a href="javascript:return false;">上一页</a></li>';
							}else{
								echo '<li class="previous"><a href="?pages='.$previous.'">上一页</a></li>';
							}
							echo '第 '.ceil(($Count[0]['count(*)'])/5).'/'.$pages.' 页';
							if($next > ceil(($Count[0]['count(*)'])/5)){
								echo '<li class="next disabled"><a href="javascript:return false;">下一页</a></li>';
							}else{
								echo '<li class="next"><a href="?pages='.$next.'">下一页</a></li>';
							}
							?>
							
						</ul>
					</div>
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