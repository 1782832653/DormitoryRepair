<?php
require_once('Loginverify.php');
require '../config.php';
if(@$_GET['act'] == 'logoff'){
   setcookie("admin_user",'',time()-3600*24);
   setcookie("admin_pwd",'',time()-3600*24);
   setcookie("permit",'', time()-3600*24);
   echo "<script>alert('已注销，下次进入需要重新登录');self.location='login.php';</script>"; 
}
$pages = @$_GET['pages']?@$_GET['pages']:1;
$previous = $pages - 1;
$next = $pages + 1;
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
/*****
 ** state 状态码设定 
 ** -1 订单取消 
 **　0 等待维修
 **  1 维修成功
*****/
//设置编码
$mysqli->set_charset('utf8');
//查询等待维修的记录
$query = $mysqli->query('select * from dorm_order where state = 0 order by `SubmitTime` DESC limit '.($previous * 5).',5');
$result = $query->fetch_all(MYSQLI_ASSOC);
//分页统计
//$querycount = $mysqli->query('select count(*) from dorm_order where state = -1 or state = 0');
//$Count = $querycount->fetch_all(MYSQLI_ASSOC);
//统计维修订单数量
$queryCount = $mysqli->query('select count(*) from dorm_order');
$count = $queryCount->fetch_all(MYSQLI_ASSOC);
//统计维修成功的数量
$querySuccess = $mysqli->query('select count(*) from dorm_order where state = 1');
$success = $querySuccess->fetch_all(MYSQLI_ASSOC);
//统计取消的订单
$queryDeal = $mysqli->query('select count(*) from dorm_order where state = -1');
$cancel = $queryDeal->fetch_all(MYSQLI_ASSOC);
//统计等待维修的订单 分页统计
$queryWait = $mysqli->query('select count(*) from dorm_order where state = 0');
$wait = $queryWait->fetch_all(MYSQLI_ASSOC);
//查询维修工人列表
$queryPerson = $mysqli->query('select name,tel from dorm_person');
$Person = $queryPerson->fetch_all(MYSQLI_ASSOC);
//print_r($Person);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>后台首页 - 后台管理</title>
    
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
					<li class="active">
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
					<i class="icon-home"></i>
					首页					
				</h1>
				
				<div class="stat-container">
										
					<div class="stat-holder">						
						<div class="stat">							
							<span><?php echo $count[0]['count(*)'];?></span>							
							报修总数						
						</div> <!-- /stat -->						
					</div> <!-- /stat-holder -->
					
					<div class="stat-holder">						
						<div class="stat">							
							<span><?php echo $success[0]['count(*)'];?></span>							
						   报修成功	
						</div> <!-- /stat -->						
					</div> <!-- /stat-holder -->
					
					<div class="stat-holder">						
						<div class="stat">							
							<span><?php echo $cancel[0]['count(*)'];?></span>							
							订单取消							
						</div> <!-- /stat -->						
					</div> <!-- /stat-holder -->
					
					<div class="stat-holder">						
						<div class="stat">							
							<span><?php echo $wait[0]['count(*)'];?></span>							
							等待维修						
						</div> <!-- /stat -->						
					</div> <!-- /stat-holder -->
					
				</div> <!-- /stat-container -->	
				<div class="row">
					<?php 
					if(count($result) == 0){
						echo '
							<div class="span9">
								<div class="widget">
									<div class="widget-content">
									<font color = "red" size = "5">暂时没有需要处理的维修订单哦！（‐＾▽＾‐）</font>
									</div>
								</div>
							</div>';
					}
					for($i=0;$i<count($result);$i++){ 
					?>
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
								/*
								if($result[$i]['state'] == 0){
									$state = '<span class="label label-info">等待维修</span>';
								}elseif($result[$i]['state'] == 1){
									$state = '<span class="label label-success">维修成功</span>';
								}elseif($result[$i]['state'] == -1){
									$state = '<span class="label label-danger">订单取消</span>';
								}else{
								}
								*/
								echo <<<str
								故障类型：{$result[$i]['type']}<hr />
								具体故障：{$result[$i]['desc']}<hr />
								联系电话：<span class="label label-default">{$result[$i]['tel']}</span><hr />
								无人时维修：{$access}<hr />
								订单创建时间：{$result[$i]['SubmitTime']}<hr />
								维修人/状态：<span class="label label-default">{$RepairPerson}</span> / {$state}
str;
?>
								<?php if($_COOKIE['permit'] == 0){ ?>
								<hr /><font color = "#7A378B"><b>维修订单操作：</b></font>
								
								<m class="dropdown">
									<button class = "btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">分配 <b class="caret"></b></button>
									

								<ul class="dropdown-menu">
										<?php for($n=0;$n<count($Person);$n++){ ?>
										<li>
											<a href="javascript:Operate(<?php echo $result[$i]['id'];?>,'<?php echo $Person[$n]['name'];?>','<?php echo $Person[$n]['tel'];?>','<?php echo $result[$i]['floor'];?>','<?php echo $result[$i]['room'];?>','<?php echo $result[$i]['type'];?>','<?php echo trim($result[$i]['desc']);?>');"><i class="icon-user"></i><?php echo $Person[$n]['name'];?></a>
										</li>
										<?php } ?>
									</ul>
								</m>
								<a class = "btn btn-success" href="javascript:Done(<?php echo $result[$i]['id'];?>);">完成</a>
								<a class = "btn btn-danger" href="javascript:Cancel(<?php echo $result[$i]['id'];?>);">取消</a>
								<?php } ?><!-- 权限判断花括号 -->
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
							echo '第 '.$pages.'/'.ceil(($wait[0]['count(*)'])/5).' 页';
                            echo '&emsp;<form action="" method="GET" style="display: inline;"><input type="text" name="pages" value="'.$pages.'" style="width:20px;">&nbsp;<input type="submit" value="跳页" ></form>';
							if($next > ceil(($wait[0]['count(*)'])/5)){
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
<script src="./js/excanvas.min.js"></script>
<script src="./js/jquery.flot.js"></script>
<script src="./js/jquery.flot.pie.js"></script>
<script src="./js/jquery.flot.orderBars.js"></script>
<script src="./js/jquery.flot.resize.js"></script>


<script src="./js/bootstrap.js"></script>
<script src="./js/charts/bar.js"></script>
<script>
function Operate(id,name,tel,floor,room,type,desc){
	$.ajax({
		async:false,
		url:"operate.php",
		type:"POST",
		data:{'name':name,'tel':tel,'id':id,'floor':floor,'room':room,'type':type,'desc':desc,'action':'repair'},
		dataType:"TEXT",
		success:function(str){
		  if(str == "success"){
			alert("已通知维修师傅 " + name + "进行维修");
			location.reload();
		  }else{
			  alert("处理失败，请重新处理");
		  }
		},
		error: function(XmlHttpRequest,textStatus, errorThrown){
			alert("网络似乎不太通畅，重新试试吧");
		}
	});
}
function Done(id){
	if(confirm("这个订单已维修完成？")){
		$.ajax({
		async:false,
		url:"operate.php",
		type:"POST",
		data:{'id':id,'action':'done'},
		dataType:"TEXT",
		success:function(str){
		  if(str == "success"){
			alert("维修完成");
			location.reload();
		  }else{
			  alert("处理失败，请重新处理");
		  }
		},
		error: function(XmlHttpRequest,textStatus, errorThrown){
			alert("网络似乎不太通畅，重新试试吧");
		}
	});
	}else{
		//return false;
	}
	
}
function Cancel(id){
	if(confirm("确定要取消这个订单？")){
		$.ajax({
		async:false,
		url:"operate.php",
		type:"POST",
		data:{'id':id,'action':'cancel'},
		dataType:"TEXT",
		success:function(str){
		  if(str == "success"){
			alert("订单取消成功");
			location.reload();
		  }else{
			  alert("处理失败，请重新处理");
		  }
		},
		error: function(XmlHttpRequest,textStatus, errorThrown){
			alert("网络似乎不太通畅，重新试试吧");
		}
	});
	}else{
		//return false;
	}
	
}
</script>
</body>
</html>