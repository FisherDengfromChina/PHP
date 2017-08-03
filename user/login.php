<?php
	session_start();

	//注销登录
	if ($_GET['action'] == "logout") {
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		echo '注销登录成功！点击此处 <a href = "login.html">登录</a>';
		exit;
	}
	if (!$_GET['action']){
		exit;
	}

	//登录
	if (!isset($_POST['submit'])) {
		exit("非法访问！");
	}
	$username = htmlspecialchars($_POST['username']);
	$password = md5($_POST['password']);

	//包含数据库连接文件
	include('conn.php');
	//检查用户名及密码是否正确
	$check_query = $conn -> query("SELECT UID FROM USER WHERE USERNAME = '$username' AND PASSWORD = '$password' LIMIT 1");
	if ($result = mysqli_fetch_array($check_query)) {
		//登录成功
		$_SESSION['username'] = $username;
		$_SESSION['userid'] = $result['UID'];
		echo $username, ' 欢迎你！进入 <a href = "my.php">用户中心</a><br/>';
		echo '点击此处 <a href = "login.php?action=logout">注销</a>登录！<br/>';
		exit;
	}else{
		exit('登录失败！点击此处 <a href = "javascript:history.back(-1)">返回</a>重试');
	}
?>