<?php
require 'config.php';
//mysqli连接
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
 $mysqli->set_charset('utf8');
 $verify_request = @$_COOKIE['verify_request'];
 $postStr = pack("H*", $verify_request);
 $postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '这里改为AppSecret', $postStr, MCRYPT_MODE_CBC, '这里改为AppID');
 $postInfo = rtrim($postInfo);
 $postArr = json_decode($postInfo,true);
 if($postArr['visit_user']['username'] == false){
   die("<script>alert('请登录！');self.location = 'index.php';</script>");
 }
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8"> 
	<title>宿舍在线报修系统</title>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style>
	p{
		text-indent:2em;
	} 
	.panel-primary>.panel-heading{
		color:#fff;
		background-color: #00a65a;
		border-color:#00a65a;
	}
	.navbar-inverse .navbar-nav >li>a:focus, .navbar-inverse .navbar-nav>li>a:hover{
		background-color:transparent;
		color: #fff;
	}
	.navbar-inverse{
		background-color:#3c8dbc;
		border-color:#3c8dbc;
		color: #fff;
	}
	.navbar-inverse .navbar-nav>li>a{
		color:#fff;
	}
	.navbar-inverse .navbar-toggle:focus, .navbar-inverse .navbar-toggle:hover{
		background-color: #3c8dbc;
	}
	.navbar-inverse .navbar-toggle {
    	border-color: #fff;
	}
	   .col-md-8,.col-md-4{
		padding-right:5px;
		padding-left:5px;
	}
	.navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.open>a:focus, .navbar-inverse .navbar-nav>.open>a:hover {
		color: #fff;
		background-color: rgba(40, 98, 130, 0.32);
	}
	.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover {
		color: #fff;
		background-color: rgba(40, 98, 130, 0.32);
	}
	.navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
		color: #c0dcd8;
	}
     .panel{
		margin:0 auto; 
		max-width:700px;
	}
	.alert{
		margin:0 auto;
		margin-top:5px;
		max-width:700px;
		height:80px;
	}
	.div-img{
	    background-color: rgba(255, 255, 255, 0.3);
		display: block;
		padding: 10px;
	}
	.box-text {
		border: 1px solid white;
		color: blue;
		font-style: italic;
		width: 100%;
		height: 100%;
	}
	.title-text {
		font-size: 3.8em;
		padding-top: 20px;
		padding-bottom: 25px;
		text-align: center;
	}
	.btn_form{
		width:100%;
		margin-top:4px;
	}
	.panel-title{
		text-align:center;
	}
	.warning{
		color: #8a6d3b;
		border-radius:3px;
		background-color: #fcf8e3;
		border-color: #faebcc;
		padding:13px;
	}
	.alert {
		margin: 0 auto;
		margin-top: 5px;
		max-width: 700px;
		height: auto;
	}
      *{
        font-size:13px;
      }
	</style>
</head>
<body scrollTop="0">
<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<a href="index.php" class="navbar-brand">
			<img src="./logo.png"  height="20px" width="20px">
			</a>
			<button class="navbar-toggle collapsed" data-toggle="collapse"  data-target="#mynavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
		</div>
		<div id="mynavbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-calendar"></span>&nbsp;我的报修</a></li>
				<li><a href="submit.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;申请报修</a></li>
				<li class="active"><a href="myhouse.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;我的宿舍</a></li>
				<li><a href="question.php"><span class="glyphicon glyphicon-envelope"></span>&nbsp;问题反馈</a></li>	
			</ul>
			<!-- 导航条中的下拉菜单 -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  &nbsp;<?php echo $postArr['visit_user']['username'].'(uid:'.$postArr['visit_user']['userid'].')';?></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?act=login">登录</a></li>											</ul>
				</li>
			</ul>
		</div>
</nav>
<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					设置基本用户信息
				</div>	
			</div>
		<div class="panel-body">
			<div class="alert alert-warning">
				 特别注意！！！宿舍楼层和房间号码只能设置一次且不能修改。<b>房间号只需要输入3位纯数字宿舍号<b>.
			</div>
			<br />
			<form class="form-horizontal" action="" method="POST">
				<div class="form-group">
					<label class="col-md-2 control-label">姓名:</label>
					<div class="col-md-10">
						<input class="form-control" name="name" type="text" value="" placeholder="真实姓名" required="required" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">房间:</label>
					<div class="col-md-5">
						<select class="form-control" name="floor">
							<option value="A1">A1</option>
							<option value="A2">A2</option>
							<option value="A3">A3</option>
							<option value="A4">A4</option>
                            <option value="A5">A5</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
						</select>
					</div>
					<div class="col-md-5">
				        <input class="form-control" name="room" type="text" value="" placeholder="房间号" required="required" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9]+/,'');}).call(this)" onblur="this.v();" />
					</div>
				</div>
				
				
				
				<div class="form-group">
					 <div class="col-md-12">
						<div class="col-md-offset-2 col-md-10"><input id="submit" type="submit" name="submit" class="btn btn_form btn-primary" value="保存信息"> </div>
					 </div>
				</div>
			</form>
		</div>
          	<div class="panel-footer">
				&nbsp;Copyright &copy; 2018 Powered By  Rains
			</div>
		</div>
</div>
<?php

$uid = $postArr['visit_user']['userid']; //用户uid
$name = $_POST['name'];
$floor = $_POST['floor'];
$room = $_POST['room'];
if(@$_POST['submit'] == true){
	$sql = "insert into  `dorm_house` (ybuid,name,floor,room) values(?,?,?,?)";
	//预处理
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('issi',$uid,$name,$floor,$room);
	//执行预处理语句
	if($mysqli_stmt->execute()){
		echo '<script>alert("设置成功");</script>';
	}else{
		echo '<script>alert("你已经设置过了");</script>';
	}
}
?>
</body>

</html>