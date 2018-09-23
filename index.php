<?php
include_once('config.php');
if($_GET['act'] == 'login'){
   	header('location:你的易班登录回调地址');
}
 $verify_request = '';
    if(@$_COOKIE["verify_request"] == true || @$_GET["verify_request"] == true){
      if(@$_COOKIE["verify_request"]){
        $verify_request = $_COOKIE["verify_request"];
      }
      if(@$_GET["verify_request"]){
        $verify_request = $_GET["verify_request"];
      }

  }
  if($verify_request){
      $postStr = pack("H*", $verify_request);
      $postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '这里改为AppSecret', $postStr, MCRYPT_MODE_CBC, '这里改为AppID');
      $postInfo = rtrim($postInfo);
      $postArr = json_decode($postInfo,true);
      /** 解密verify_request后取得用户数据
      echo $postArr['visit_user']['userid'];
      echo $postArr['visit_user']['username'];
      **/
      //成功获取登录信息后保存到COOKIE
    
      if($_COOKIE['verify_request'] == false && $postArr['visit_user']['username'] == true){
        setcookie("verify_request", $_GET["verify_request"], time()+3600);
        setcookie("uid", $postArr['visit_user']['userid'], time()+3600);
      }
	  //else{
      //  die("<script>self.location='index.php?act=login'</script>");
      //}

}else{
    die("<script>alert('请先登录才能使用！');self.location='index.php?act=login'</script>");
}
            /********************
             ***  数据库操作  ***
             *******************/
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){ //连接成功errno应该为0
    die('Connect Error:'.$mysqli->connect_error);
}
//设置查询编码
$mysqli->set_charset('utf8');
$house = $mysqli->query('select * from dorm_house where ybuid = '.$postArr['visit_user']['userid']);
$myhouse = $house->fetch_all(MYSQLI_ASSOC);
if(count($myhouse) == 1){
  $process = $mysqli->query('select * from dorm_order where  state = 0  and (uid = '.$postArr['visit_user']['userid'].' or (floor = \''.$myhouse[0]['floor'].'\' and room = \''.$myhouse[0]['room'].'\'))');
  $dealing = $process->fetch_all(MYSQLI_ASSOC);

}else{
  $process = $mysqli->query('select * from dorm_order where  state = 0  and uid = '.$postArr['visit_user']['userid']);
  $dealing = $process->fetch_all(MYSQLI_ASSOC);

}
$process = $mysqli->query('select * from dorm_order where ( state = 1 or state = -1 ) and uid = '.$postArr['visit_user']['userid'].' order by `SubmitTime` desc limit 0,5');
$success = $process->fetch_all(MYSQLI_ASSOC);
//print_r($dealing);
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
	*{
	  font-size:13px;
	}
	.btn{
		display: inline;
	}
	</style>
</head>
<body scrollTop="0">
<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<a href="" class="navbar-brand">
			<img src="./logo.png" height="20px" width="20px">
			</a>
			<button class="navbar-toggle collapsed" data-toggle="collapse"  data-target="#mynavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
		</div>
		<div id="mynavbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li  class="active"><a href="#"><span class="glyphicon glyphicon-calendar"></span>&nbsp;我的报修</a></li>
				<li><a href="submit.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;申请报修</a></li>
				<li><a href="myhouse.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;我的宿舍</a></li>
				<li><a href="question.php"><span class="glyphicon glyphicon-envelope"></span>&nbsp;问题反馈</a></li>	
			</ul>
			<!-- 导航条中的下拉菜单 -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
                  	<?php if($postArr['visit_user']['username'] == true){  ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  &nbsp;<?php echo $postArr['visit_user']['username'].'(uid:'.$postArr['visit_user']['userid'].')';?></a>
                  	<?php }else{ ?>
                  	<a href="?state=login" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  &nbsp;请登录<span class="caret"></span></a>
                  	<ul class="dropdown-menu">
						<li><a href="index.php?act=login">登录</a></li>
                  	</ul>
                  	<?php }?>
					
				</li>
			</ul>
		</div>
</nav>
<div class="container">
	<!--<div class="col-md-8">-->
		<div class="panel panel-primary" id="table">
			<div class="panel-heading">
				<h4 class="panel-title">
					<b><span class="glyphicon glyphicon-list-alt"></span>&nbsp;报修中</b>
				</h4>
			</div>
			<div class="panel-body">
              <?php $num = count($dealing);
              	if($num == 0){
                  echo '<div class="alert alert-warning">没有待维修的订单，<a href="submit.php">提交一个？</a></div>';
                }
              	for($i=0;$i<$num;$i++){
              ?>
				<div class="alert alert-info">
                 
					<span class="label label-success"> 编号 <?php echo $dealing[$i]['id'];?></span>&nbsp;<span class="label label-primary">房间号 <?php echo $dealing[$i]['floor'].'-'.$dealing[$i]['room'];?></span>&nbsp;<span class="label label-warning"><?php echo $dealing[$i]['SubmitTime'];?></span><hr>
                  	故障类型：<?php echo $dealing[$i]['type'];?><br />
                  	具体描述：<?php echo $dealing[$i]['desc'];?><hr />
                  <p align='right'><?php if($dealing[$i]['uid'] == $postArr['visit_user']['userid']){ ?><a class="btn btn-danger btn-flat" href="javascript:Cancle(<?php echo $dealing[$i]['id'];?>);">取消订单</a>&nbsp;<a class="btn btn-success  btn-flat" href="javascript:Done(<?php echo $dealing[$i]['id'];?>);">维修完成</a><?php }else{echo '<font color="red">无权操作</font>';}?></p>
				</div>
              <?php } ?>
			</div>
		</div>
	<!--</div>-->
	<!--<div class="col-md-4">-->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title"><span class="glyphicon glyphicon-ok-sign"></span>&nbsp;<b>已完成</b></div>
			</div>
			<div class="panel-body">
				<?php $num_two = count($success);
              	if($num_two == 0){
                  echo '<div class="alert alert-warning">没有维修成功的订单</div>';
                }
              	for($i=0;$i<$num_two;$i++){
              ?>
				<div class="alert <?if($success[$i]['state'] == 1){ echo 'alert-success';}else{echo 'alert-danger';}?>">
                 
					<span class="label label-success"> 编号 <?php echo $success[$i]['id'];?></span>&nbsp;<span class="label label-primary">房间号 <?php echo $success[$i]['floor'].'-'.$success[$i]['room'];?></span>&nbsp;<span class="label label-warning"><?php echo $success[$i]['SubmitTime'];?></span><hr>
                  	故障类型：<?php echo $success[$i]['type'];?><br />
                  	具体描述：<?php echo $success[$i]['desc'];?><hr />
                  <p align='right'><?if($success[$i]['state'] == 1){ echo '维修成功';}else{echo '维修取消';}?></p>
				</div>
              <?php } ?>
			</div>
			<div class="panel-footer">
			&nbsp;Copyright &copy; 2018 Powered By  Rains
			</div>
		</div>
	<!--</div>-->
</div>
</body>
<script>
//传递确定订单数据
function Done(id){
	if(confirm("确定宿舍已经维修完成？")){
		$.ajax({
		async:false,
		url:"operate.php",
		type:"POST",
		data:{'id':id,'action':'done'},
		dataType:"TEXT",
		success:function(str){
		  if(str == "success"){
			alert("完成维修");
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
//传递取消订单数据
function Cancle(id){
	if(confirm("确定要取消订单？")){
		$.ajax({
		async:false,
		url:"operate.php",
		type:"POST",
		data:{'id':id,'action':'cancle'},
		dataType:"TEXT",
		success:function(str){
		  if(str == "success"){
			alert("取消成功");
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
</html>