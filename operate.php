<?php
require 'config.php';
//mysqli连接
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
$mysqli->set_charset('utf8');
//检查登陆cookie 登陆数据解码 
$postStr = pack("H*", $_COOKIE["verify_request"]);
$postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '这里改为AppSecret', $postStr, MCRYPT_MODE_CBC, '这里改为AppID');
$postInfo = rtrim($postInfo);
$postArr = json_decode($postInfo,true);
if($postArr['visit_user']['userid'] == false){
	die("未获取到登录数据");
}

$oid = $_POST['id']; //订单id号
$uid = $postArr['visit_user']['userid']; //用户uid
if(@$_POST['action'] == 'done'){
	$sql = "update `dorm_order` set state = 1,RepairTime = ? where id = ? and uid = ?";
	//预处理
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('sss',date('Y-m-d H:i:s'),$oid,$uid);
	//执行预处理语句
	if($mysqli_stmt->execute()){
		echo 'success';
	}else{
		 echo $mysqli_stmt->error;
	}
}
if(@$_POST['action'] == 'cancle'){
	$sql = "update `dorm_order` set state = -1,RepairTime = ? where id = ? and uid = ?";
	//预处理
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('sss',date('Y-m-d H:i:s'),$oid,$uid);
	//执行预处理语句
	if($mysqli_stmt->execute()){
		echo 'success';
	}else{
		 echo $mysqli_stmt->error;
	}
}
?>