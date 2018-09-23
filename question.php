<?php
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
	td,th{
		text-align:center;
	}
	th{
		background-color:#fff;
	}
	.select{
		width:100%;
		margin-bottom:10px;
		text-align:center;
		font-weight:bold;
		font-size:1em;
		border: 1px solid #000;
		border-radius:8px;
		background-color:#fff;
		height:32px;
	}
	input[type=submit]{
		text-align:center;
		font-weight:bold;
		font-size:1em;
		border-width:2;
		border-color:#000;
		border-radius:8px;
		width:100%;
		background-color:#fff;
		height:32px;
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
				<li><a href="myhouse.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;我的宿舍</a></li>
				<li class="active"><a href="question.php"><span class="glyphicon glyphicon-envelope"></span>&nbsp;问题反馈</a></li>	
			</ul>
			<!-- 导航条中的下拉菜单 -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  &nbsp;<?php echo $postArr['visit_user']['username'].'(uid:'.$postArr['visit_user']['userid'].')';?></a>
				</li>
			</ul>
		</div>
</nav>
<div class="container">
	<!--<div class="col-md-8">-->
		<div class="panel panel-primary" id="table">
			<div class="panel-heading">
				<h4 class="panel-title">
					<b><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;&nbsp;常见问题</b>
				</h4>
			</div>
			<div class="panel-body">
				<div class="alert alert-info">
					Q:为什么已完成的订单没有显示我所有的报修记录？<br />	A:由于考虑到页面的整洁，已完成的订单只会显示最新的5条的报修记录！
				</div>
							<div class="alert alert-info">
					Q:提交报修信息什么时候才能维修？<br />	A:在你提交报修订单后我们会尽快为你的订单分配维修师傅，分配维修师傅后将会短信通知你！
				</div>
							<div class="alert alert-info">
					Q:在使用本系统的过程中遇到问题怎么办？<br />	A:如果在使用本系统的过程中遇到bug，请及时截图并QQ联系客服说明具体问题。
				</div>
			</div>
		</div>
	<!--</div>-->
	<!--<div class="col-md-4">-->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;反馈问题</div>
			</div>
			<div class="panel-body">
				<div class="alert alert-warning">
                  <p>在使用本系统的过程中，如有遇到问题请与我们联系，感谢你的支持。</p>
                  <p>程序问题反馈联系QQ：1782832653</p>
                  <p>报修问题反馈联系QQ：1833358577（宿管委）</p>
                  <p>易班地址：贵州民族大学新校区学生活动中心二楼2002室</p>
				</div>
			</div>
			<div class="panel-footer">
			&nbsp;Copyright &copy; 2018 Powered By  Rains
			</div>
		</div>
	<!--</div>-->
</div>

</body>
</html>