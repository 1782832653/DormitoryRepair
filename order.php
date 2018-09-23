<?php
/*
*	保存用户提交的报修信息
*/
require 'config.php';
require './submail/app_config.php';    
require_once('./submail/SUBMAILAutoload.php');
date_default_timezone_set('Asia/Shanghai'); 

$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){ //连接成功errno应该为0
    die('Connect Error:'.$mysqli->connect_error);
}
$mysqli->set_charset('utf8');
//print_r($_POST);
if(@$_POST['submit'] == '提交报修'){
	$tel = $_POST['tel']; //联系电话
    $room = $_POST['room_no']; //房间号
	$floor = $_POST['floor']; //楼栋
    $desc = $_POST['description']; //故障描述
    $access = $_POST['nobody']; //允许无人时维修
	$type = '';  //故障类型
	$time = date("Y-m-d H:i:s"); // 获取当前时间
	foreach($_POST['type'] as $val){
		if($type == true){
			$sign = ',';
		}else{
			$sign = '';
		}
		$type = $type.$sign.$val;
	}
	$process = $mysqli->query('select * from dorm_person where area = \''.$floor.'\';');
	$person = $process->fetch_all(MYSQLI_ASSOC);
	//print_r($person);
	if($person[0]['name'] == true){
		$RepairPerson = $person[0]['name'];
	}else{
		$RepairPerson = null;
	}
	$sql = "insert into `dorm_order` (`type`,`room`,`desc`,`tel`,`access`,`SubmitTime`,`uid`,`floor`,`RepairPerson`)values(?,?,?,?,?,?,?,?,?)";
	$mysqli_stmt=$mysqli->prepare($sql);
	//第一个参数表明变量类型，有i(int),d(double),s(string),b(blob)
	$mysqli_stmt->bind_param('ssssissss',$type,$room,$desc,$tel,$access,$time,$_COOKIE['uid'],$floor,$RepairPerson);
	//执行预处理语句
	if($mysqli_stmt->execute()){
      //检查待发送通知的手机号码
      	if($person[0]['tel'] == true && strlen($person[0]['tel']) == 11){
          $submail=new MESSAGEXsend($message_configs);    
          $submail->setTo($person[0]['tel']);
          $submail->SetProject('rDvju3');
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
		  if($xsend['status'] == 'success'){
			  $log = "[".$time."]".$person[0]['tel']." status:".$xsend['status']." send_id:".$xsend['send_id']."\r\n";
		  }else{
			  $log = "[".$time."]".$person[0]['tel']." status:".$xsend['status']." 错误信息:".$xsend['msg']."\r\n";
		  }
          file_put_contents("log.txt", $log,FILE_APPEND | LOCK_EX);
        }
		echo "<script>alert('报修信息提交成功，维修完成后请尽快点击确认完成按钮');self.location='index.php';</script>";
	}else{
	 	echo $mysqli_stmt->error;
	}
}
?>