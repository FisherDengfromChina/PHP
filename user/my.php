<?php
	session_start();

	//检测是否登录，若没登录则转向登录界面
	if (!isset($_SESSION['userid'])) {
		header("localhost:login.html");
		exit();
	}

	//包含数据库连接文件
	include('conn.php');
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	$user_query = $conn -> query("SELECT * FROM USER WHERE UID = '$userid' LIMIT 1");
	$row = mysqli_fetch_array($user_query);
	echo '用户信息：<br/>';
	echo '用户ID：', $userid, '<br/>';
	echo '用户名：', $username, '<br/>';
	echo '邮箱：', $row['EMAIL'],'<br/>';
	echo '注册日期：',date('Y-m-d',$row['REGDATE']),'<br/>';
	echo '<a href="login.html?action=logout">注销</a>登录<br/>';
?>