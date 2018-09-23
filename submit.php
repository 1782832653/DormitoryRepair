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

 $dealing = $mysqli->query('select * from dorm_house where ybuid = '.$postArr['visit_user']['userid']);
 $result = $dealing->fetch_all(MYSQLI_ASSOC);
if($result == false){
	echo '<script>alert("请先设置你的寝室");self.location="myhouse.php";</script>';
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
				<li  class="active"><a href="submit.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;申请报修</a></li>
				<li><a href="myhouse.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;我的宿舍</a></li>
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
					填写报修信息
				</div>	
			</div>
		<div class="panel-body">
			<div class="alert alert-warning">
				 特别注意！！！本系统目前只支持贵州民族大学<u>新校区</u>的宿舍报修，老校区的报修系统暂未上线！
			</div>
			<br />
			<form class="form-horizontal" action="order.php" method="POST" onSubmit="return check();">
				<div class="form-group">
					<label class="col-md-2 control-label">联系电话:</label>
					<div class="col-md-10">
						<input class="form-control" name="tel" type="text" value="" placeholder="请填写你的电话号码" required="required" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">房间号:</label>
					<div class="col-md-5">
				  	<input class="form-control" name="floor" type="text" value="<?php echo $result[0]['floor']?>" required="required" readonly>
						<!--<select class="form-control" name="floor" id="select" readonly>
							<option value="A1">A1</option>
							<option value="A2">A2</option>
							<option value="A3">A3</option>
							<option value="A4">A4</option>
                            <option value="A5">A5</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
						</select>-->
					</div>
					<div class="col-md-5">
				        <input class="form-control" name="room_no" type="text" value="<?php echo $result[0]['room']?>" required="required" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">故障类型:</label>
					<div class="col-md-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="type[]" value="漏水">漏水&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="插座">插座&emsp;
							</label>
                            <label>
								<input type="checkbox" name="type[]" value="水龙头">水龙头&emsp;
							</label>
 
							<label>
								<input type="checkbox" name="type[]" value="厕所灯">厕所灯&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="厕所蓄水桶">厕所蓄水桶&emsp;
							</label>
                            <label>
								<input type="checkbox" name="type[]" value="顶灯">顶灯&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="宿舍门锁">宿舍门锁&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="进门灯">进门灯&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="洗手台水龙头">洗手台水龙头&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="洗手台下水阀">洗手台下水阀&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="电控盒">电控盒&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="阳台门">阳台门&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="阳台门把手">阳台门把手&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="阳台门合叶">阳台门合叶&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="阳台灯">阳台灯&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="阳台地漏">阳台地漏&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="床板">床板&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="床柜">床柜&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="床梯">床梯&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="椅子">椅子&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="墙上插座">墙上插座&emsp;
							</label>
                            <label>
								<input type="checkbox" name="type[]" value="下水道堵塞">下水道堵塞&emsp;
							</label>
                            <label>
								<input type="checkbox" name="type[]" value="玻璃">玻璃&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="卫生间下水">卫生间下水&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="卫生间灯">卫生间灯&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="卫生间合叶">卫生间合叶&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="卫生间门">卫生间门&emsp;
							</label>
                            <label>
								<input type="checkbox" name="type[]" value="卫生间门把手">卫生间门把手&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="浴室门">浴室门&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="浴室门把手">浴室门把手&emsp;
							</label>
							<label>
								<input type="checkbox" name="type[]" value="浴室灯">浴室灯&emsp;
							</label>
       					
	      <label>
	       <input type="checkbox" name="type[]" value="门插销">门插销&emsp;
							</label>
                            
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">故障描述:</label>
					<div class="col-md-10">
						<textarea name="description" class="form-control" required="required" placeholder="请详细描述故障信息，方便维修师傅携带工具"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">无人时维修:</label>
					<div class="col-md-10">
						<div class="radio">
							<label>
								<input type="radio" name="nobody" value="1" checked>允许&emsp;
							</label>
							<label>
								<input type="radio" name="nobody" value="0">不允许&emsp;
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-2">
					<label>
						<center><strong>
						<input type="checkbox" name="" id="accept">&emsp;<font color="red">我确认所填写信息无误，并申请报修！</font>&emsp;
						</center></strong>
					</label>
				</div>
				
				<div class="form-group">
					 <div class="col-md-12">
						<div class="col-md-6"><input id="submit" type="submit" name="submit" class="btn btn_form btn-primary" value="提交报修" disabled="disabled"> </div>
						<div class="col-md-6"><input type="reset" class="btn btn_form btn-danger" value="重新填写"> </div>
					 </div>
				</div>	
			</form>
		</div>
          	<div class="panel-footer">
				&nbsp;Copyright &copy; 2018 Powered By  Rains
			</div>
		</div>
</div>

</body>
<script>
$(function(){
	$("#accept").change(function(){
		if($("#accept").is(':checked') == true ){
			$("#submit").removeAttr("disabled");
		}else{
			$("#submit").attr({"disabled":"disabled"});
		}
	});
});
//检查复选框必须选择一个
function check(){
	var cbs = document.getElementsByName("type[]");
	var checkNum = 0;
	for (var i = 0; i < cbs.length; i++) {
		if (cbs[i].checked) {
			checkNum++;
		}
	}
	    //alert("选中数量=" + checkNum);
	if (checkNum > 0) {
		return true;
	}else{
		alert("故障类型必须选择一个，不在列表中的不支持报修");
		return false;
	}
}
</script>
</html>