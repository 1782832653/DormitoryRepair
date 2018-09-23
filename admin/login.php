<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>管理员登录页面</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />    
    
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/bootstrap-responsive.min.css" rel="stylesheet" />
    
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" />-->
    <link href="./css/font-awesome.css" rel="stylesheet" />
    
    <link href="./css/adminia.css" rel="stylesheet" /> 
    <link href="./css/adminia-responsive.css" rel="stylesheet" /> 
    
    <link href="./css/pages/login.css" rel="stylesheet" /> 

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
	
<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 				
			</a>
			
			<a class="brand" href="./">宿舍管理系统</a>
			
			<div class="nav-collapse">
			
				<ul class="nav pull-right">
					
					<li class="">
						
						<a href="./"><i class="icon-chevron-left"></i> 返回首页</a>
					</li>
				</ul>
				
			</div> <!-- /nav-collapse -->
			
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->


<div id="login-container">
	
	
	<div id="login-header">
		
		<h3>管理员登录</h3>
		
	</div> <!-- /login-header -->
	
	<div id="login-content" class="clearfix">
 <?php
include('admin.php');
//echo md5('rains1782832653');
if(@$_GET['submit'] == '登录'){
  if( $username_1 == $_GET['username'] && md5('rains'.$_GET['password']) == $password_1){
    setcookie("admin_user",$_GET['username'], time()+3600*24);
    setcookie("admin_pwd",md5('rains'.$_GET['password']), time()+3600*24);
	if($_GET['username'] == 'admin'){
		setcookie("permit",0, time()+3600*24);
	}elseif($_GET['username'] == 'manage'){
		setcookie("permit",1, time()+3600*24);
	}else{}
    echo '<script>alert("登录成功");self.location="index.php";</script>';
  }elseif($username_2 == $_GET['username'] && md5('rains'.$_GET['password']) == $password_2){
	setcookie("admin_user",$_GET['username'], time()+3600*24);
    setcookie("admin_pwd",md5('rains'.$_GET['password']), time()+3600*24);
	if($_GET['username'] == 'admin'){
		setcookie("permit",0, time()+3600*24);
	}elseif($_GET['username'] == 'manage'){
		setcookie("permit",1, time()+3600*24);
	}else{}
	echo '<script>alert("登录成功");self.location="index.php";</script>';
  }else{
 	echo '<div class="alert alert-danger">登录失败</div>';   
  }
}
?>
	<form action="" method="GET"/>
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="username">用户名</label>
						<div class="controls">
							<input type="text" class="" name="username" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="password">密码</label>
						<div class="controls">
							<input type="password" class="" name="password" />
						</div>
					</div>
				</fieldset>
				
				<div id="remember-me" class="pull-left">
					<input type="checkbox" name="remember" value="on" id="remember" checked disabled/>
					<label id="remember-label" for="remember">记住密码</label>
				</div>
				
				<div class="pull-right">
					<button type="submit"  name="submit" value="登录" class="btn btn-warning btn-large">
						登录
					</button>
				</div>
			</form>
			
		</div> <!-- /login-content -->

		
		<!-- <div id="login-extra">
			
			<p>还没有账号? <a href="javascript:;">马上注册.</a></p>-->
<!--			找回密码  -->
<!--			<p>忘记密码? <a href="forgot_password.html">发送邮件.</a></p>-->
			
		<!-- </div>  /login-extra -->
	
</div> <!-- /login-wrapper -->

    

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="./js/jquery-1.7.2.min.js"></script>


<script src="./js/bootstrap.js"></script>

  </body>
</html>