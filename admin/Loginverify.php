<?php
/************************
***   登录验证文件   ****
*************************/
include('admin.php');
if(isset($_COOKIE['admin_user']) == true && isset($_COOKIE['admin_user']) == true){
    if(($_COOKIE['admin_user'] == $username_1 || $_COOKIE['admin_user'] == $username_2) && ($_COOKIE['admin_pwd'] == $password_1 || $_COOKIE['admin_pwd'] == $password_2)){
        //登录成功
    }else{
      //帐号信息不符
        setcookie("admin_user",'',time()-600*24);
        setcookie("admin_pwd",'',time()-600*24);
		setcookie("permit",'',time()-600*24);
        echo "<script>alert('帐号信息不符，已注销');self.location='login.php';</script>";
        die();
    }
}else{
	echo "<script>alert('请先登录');self.location='login.php';</script>";
	die();
}
?>