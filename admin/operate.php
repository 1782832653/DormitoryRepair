<?php
require_once('Loginverify.php');
require '../config.php';
require '../submail/app_config.php';    
require_once('../submail/SUBMAILAutoload.php');
$name = @$_POST['name'];
$tel = @$_POST['tel'];
$id = @$_POST['id'];
$floor = @$_POST['floor'];
$room = @$_POST['room'];
$type = @$_POST['type'];
$desc = @$_POST['desc'];
//mysqli连接
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
$mysqli->set_charset('utf8');
//分配工人

if(@$_POST['action'] == 'repair'){
	$sql = "update `dorm_order` set state = 0,RepairPerson = ? where id = ?";
	//预处理
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('si',$name,$id);
	//执行预处理语句
	if($mysqli_stmt->execute()){
      if($tel == true && strlen($tel) == 11){
          $submail=new MESSAGEXsend($message_configs);    
          $submail->setTo($tel);
          $submail->SetProject('模板ID');
          $submail->AddVar('floor',$floor);
          $submail->AddVar('no',$room);
          $submail->AddVar('type',$type);
          $submail->AddVar('desc',$desc);
          if($access == 1){
            $submail->AddVar('permit','允许无人时维修');
          }else{
            $submail->AddVar('permit','不允许无人时维修');
          }
          $xsend=$submail->xsend();
		  $time = date("Y-m-d H:i:s");
          
		  if($xsend['status'] == 'success'){
			  $log = "[".$time."]".$tel." status:".$xsend['status']." send_id:".$xsend['send_id']."\r\n";
		  }else{
			  $log = "[".$time."]".$tel." status:".$xsend['status']." 错误信息:".$xsend['msg']."\r\n";
		  }
          file_put_contents("../log.txt", $log,FILE_APPEND | LOCK_EX);
	  }
		echo 'success';
	}else{
		 echo $mysqli_stmt->error;
	}
}

if(@$_POST['action'] == 'done'){
	$sql = "update `dorm_order` set state = 1,RepairTime = ? where id = ?";
	//预处理
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('ss',date('Y-m-d H:i:s'),$id);
	//执行预处理语句
	if($mysqli_stmt->execute()){
		echo 'success';
	}else{
		 echo $mysqli_stmt->error;
	}
}
//状态码说明 0 等待维修  1 维修成功  -1 订单取消
if(@$_POST['action'] == 'cancel'){
	$sql = "update `dorm_order` set state = -1 where id = ?";
	//预处理
	$mysqli_stmt=$mysqli->prepare($sql);
	$mysqli_stmt->bind_param('s',$id);
	//执行预处理语句
	if($mysqli_stmt->execute()){
		echo 'success';
	}else{
		 echo $mysqli_stmt->error;
	}
}
?>