<?php
require_once('Loginverify.php');
require '../config.php';
//mysqli连接
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
$mysqli->set_charset('utf8');
$query = $mysqli->query('select * from dorm_person');
$result = $query->fetch_all(MYSQLI_ASSOC);
//print_r($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>添加工人 - 后台管理</title>
    
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
	<style>
		.modal{
			width:275px;
		}
	</style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>

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
                  
					<li class="active">
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
					宿舍报修系统 - 工人管理					
				</h1>
				
				<div class="widget widget-table">
										
					<div class="widget-header">
						<i class="icon-th-list"></i>
						<h3>维修工人列表</h3> 
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
					
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>编号</th>
									<th>姓名</th>
									<th>性别</th>
									<th>负责区域</th>
									<th>手机号码</th>
									<th class="action-td">
										<a href="javascript:;" class="btn btn-small btn-success" data-toggle="modal" data-target="#addPerson">
											<!--<i class="icon-plus"></i>--> Add
										</a>
									</th>
								</tr>
							</thead>
							
							<tbody>
								<?php 
								for($i=0;$i<count($result);$i++){
								?>
								<tr>
									<td><?php echo $result[$i]['id'];?></td>
									<td><?php echo $result[$i]['name'];?></td>
									<td><?php echo $result[$i]['sex'];?></td>
									<td><?php echo $result[$i]['area'];?></td>
									<td><?php echo $result[$i]['tel'];?></td>
									
									<td class="action-td">
										<!-- <a href="javascript:;" class="btn btn-small btn-warning">
											<i class="icon-pencil"></i>								
										</a> -->				
										<a href="javascript:delData(<?php echo $result[$i]['id'];?>);" class="btn btn-small btn-danger">
											<!--<i class="icon-remove"></i>--> Del
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					
					</div> <!-- /widget-content -->
					
				</div> <!-- /widget -->
				
			</div> <!-- /span9 -->

		</div> <!-- /row -->
		

	</div> <!-- /container -->
	
</div> <!-- /content -->
		<!-- 模态框（Modal） -->
		<div class="modal fade" id="addPerson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="myModalLabel">
							添加维修工人
						</h4>
					</div>
					<div class="modal-body">
					<form>
						<div class="form-group">
							<div class="input-group input-group-md">
								<label>姓名</label>
								<input type="text" name="name" class="form-control" id="name" placeholder="维修工人姓名">
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group input-group-md">
								<label>电话</label>
								<input type="text" name="tel" class="form-control" id="tel" placeholder="维修工人电话">
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group input-group-md">
								<label>性别</label>
								<select class="form-control" name="sex" id = "sex">
									  <option value = "男" selected>男</option>
									  <option value = "女">女</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group input-group-md">
								<label>负责楼层</label>
								<select class="form-control" name="floor" id = "floor">
									  <option value = "A1">A1</option>
									  <option value = "A2">A2</option>
									  <option value = "A3">A3</option>
									  <option value = "A4">A4</option>
									  <option value = "A5">A5</option>
									  <option value = "B1">B1</option>
									  <option value = "B2">B2</option>
								</select>
							</div>
						</div>
					</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭
						</button>
						<button type="button" class="btn btn-primary" onclick="addPerson()">添加</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal -->
		</div>
		<!-- 模态框结束 -->					
	
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
var name;
var tel;
var sex;
function addPerson(){
	name = $("#name").val();
	tel = $("#tel").val();
	sex = $("#sex").val();
	area = $("#floor").val();
	if(name == false || tel == false){
		alert('以上输入框均为必填!');
	}else{
		addPersonData();
	}
}
function addPersonData(){
	$.ajax({
		async:false,
		url:"addPerson.php",
		type:"POST",
		data:{'name':name,'tel':tel,'sex':sex,'area':area},
		dataType:"TEXT",
		success:function(str){
		  if(str == "success"){
			alert("添加成功");
			location.reload();
		  }else{
			  alert("添加失败。请重新添加");
		  }
		},
		error: function(XmlHttpRequest,textStatus, errorThrown){
			alert("网络似乎不太通畅，重新试试吧");
		}
	});
}
function delData(id){
	if(confirm("确定要删除编号为"+id+"的维修人员信息？")){
		$.ajax({
			async:false,
			url:"deletePerson.php",
			type:"POST",
			data:{'id':id},
			dataType:"TEXT",
			success:function(str){
			  if(str == "success"){
				  alert("删除成功");
				  location.reload();
			  }else{
				  alert("删除失败");
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