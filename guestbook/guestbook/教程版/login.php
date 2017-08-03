<?php
/*****************************
*login.php 登录验证处理文件
*****************************/
session_start();
/*
// 如果检测到已登录，直接跳转至管理页面
if(isset($_SESSION["username"])){
	header("Location: http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/admin.php");
	exit;
}
*/
if($_POST){
	require("./conn.php");
	$username = $_POST['username'];
	$password = MD5(trim($_POST['password']));
	$check_result = mysql_query("SELECT uid FROM user WHERE username = '$username' AND password = '$password'");
	if(mysql_fetch_array($check_result)){
		session_register("username");
		header("Location: http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/admin.php");
		exit;
	} else {
		echo '密码错误！';
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>留言管理登录</title>
<script language="JavaScript">
<!--

function InputCheck(form1)
{
  if (form1.password.value == "")
  {
    alert("请输入密码。");
    form1.password.focus();
    return (false);
  }
}
//--!>
</script>
</head>
<body>
<h3>请输入管理密码</h3>
<div class="form">
<form id="form1" name="form1" method="post" action="login.php" onSubmit="return InputCheck(this)">
<p>
<input type="hidden" name="username" value="admin" />
<label for="password">密 码:</label>
<input id="password" name="password" type="password" />
</p>
<input type="submit" name="submit" value=" 确 定 " />
</form>
</div>