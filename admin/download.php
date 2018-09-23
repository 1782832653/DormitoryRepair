<?php
require_once('Loginverify.php');
//导入文件
require_once '../config.php';
require_once '../class/export.php';
//mysqli连接
$mysqli = new mysqli($mysql_host,$mysql_user,$mysql_pwd,$mysql_db);
if($mysqli->connect_errno){
    die('Connect Error:'.$mysqli->connect_error);
}
//获取表单提交的参数

//获取表单提交过来的楼层
$floor = @$_POST['floor'];
//替换非法字符
$find = array(" ","'",";");
$floor = str_replace($find,'',$floor);
//设置编码
$mysqli->set_charset('utf8');
//分类导出所有数据
if(@$_GET['type'] == 'all'){
	if($floor == true){
		$query = $mysqli->query('select `id`,`room`,if(state=\'1\',\'完成\',if(state=\'0\',\'待处理\',\'失败\')) state,if(access=1,\'是\',\'否\') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where floor = \''.$floor.'\'');
	}else{
		$query = $mysqli->query('select `id`,`room`,if(state=\'1\',\'完成\',if(state=\'0\',\'待处理\',\'失败\')) state,if(access=1,\'是\',\'否\') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order');
	} 
  $list = $query->fetch_all(MYSQLI_ASSOC);
  exportExcel($list,"[所有维修订单]".date('YmdHis')."",array('id','floor','room','type','desc','access','tel','RepairPerson','state','SubmitTime'));
}elseif(@$_GET['type'] == 'week'){
  if($floor == true){
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where YEARWEEK(date_format(`RepairTime`,'%Y-%m-%d' ) ) = YEARWEEK(now()) and floor = '{$floor}'");
	}else{
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where YEARWEEK(date_format(`RepairTime`,'%Y-%m-%d' ) ) = YEARWEEK(now())");
	}
  $list = $query->fetch_all(MYSQLI_ASSOC);
  exportExcel($list,"[本周维修订单]".date('YmdHis')."",array('id','floor','room','type','desc','access','tel','RepairPerson','state','SubmitTime'));
}elseif(@$_GET['type'] == 'month'){
	if($floor == true){
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where DATE_FORMAT(`RepairTime`, '%Y%m' ) = DATE_FORMAT(CURDATE(),'%Y%m' ) and floor = '{$floor}'");
	}else{
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where DATE_FORMAT(`RepairTime`, '%Y%m' ) = DATE_FORMAT(CURDATE(),'%Y%m' )");
	}
  $list = $query->fetch_all(MYSQLI_ASSOC);
  exportExcel($list,"[本月维修订单]".date('YmdHis')."",array('id','floor','room','type','desc','access','tel','RepairPerson','state','SubmitTime'));
}elseif(@$_GET['type'] == 'today'){
	if($floor == true){
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where date_format(`SubmitTime`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') and floor = '{$floor}'");
	}else{
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where date_format(`SubmitTime`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')");
	}
  $list = $query->fetch_all(MYSQLI_ASSOC);
  exportExcel($list,"[今日提交订单]".date('YmdHis')."",array('id','floor','room','type','desc','access','tel','RepairPerson','state','SubmitTime'));
}elseif(@$_GET['type'] == 'todayDone'){
	if($floor == true){
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where date_format(`RepairTime`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') and floor = '{$floor}'");
	}else{
		$query = $mysqli->query("select `id`,`room`,if(state='1','完成',if(state='0','待处理','失败')) state,if(access=1,'是','否') access,`floor`,`type`,`desc`,`tel`,`RepairPerson`,`SubmitTime` from dorm_order where date_format(`RepairTime`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')");
	}
  $list = $query->fetch_all(MYSQLI_ASSOC);
  exportExcel($list,"[今日完成]".date('YmdHis')."",array('id','floor','room','type','desc','access','tel','RepairPerson','state','SubmitTime'));
}
?>