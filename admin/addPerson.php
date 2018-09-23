<?php
require_once('Loginverify.php');
require '../config.php';
$name = @$_POST['name'];
$tel = @$_POST['tel'];
$sex = @$_POST['sex'];
$area = @$_POST['area'];
//mysqli连接
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//设置编码
$mysqli->set_charset('utf8');
$sql = "insert into `dorm_person` (`name`,`tel`,`sex`,`area`)values(?,?,?,?)";
//预处理
$mysqli_stmt=$mysqli->prepare($sql);
$mysqli_stmt->bind_param('ssss',$name,$tel,$sex,$area);
//执行预处理语句
if($mysqli_stmt->execute()){
	echo 'success';
}else{
	 echo $mysqli_stmt->error;
}
?>