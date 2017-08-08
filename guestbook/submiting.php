<?php
	//禁止非POST方式访问
	if (!isset($_POST['submit'])) {
		exit('非法访问！');
	}

	//表单信息处理
	/*
	addslashes()函数：用于对特殊字符加上转义字符；
	get_magic_quotes_gpc()函数：返回PHP指令的magic_quotes_gpc值，默认情况下为ON，即会自动对所有的GET、POST和COOKIE 数据自动运行addslashes()；
	*/
	if (get_magic_quotes_gpc()) {
		$nickname = htmlspecialchars(trim($_POST['nickname']));
		$email = htmlspecialchars(trim($_POST['emial']));
		$content = htmlspecialchars(trim($_POST['content']));
	} else {
		$nickname = addslashes(htmlspecialchars(trim($_POST['nickname'])));
		$email = addslashes(htmlspecialchars(trim($_POST['email'])));
		$content = addslashes(htmlspecialchars(trim($_POST['content'])));
	}

	if (strlen($nickname)>16) {
		exit('错误：昵称不得超过16个字符串 [ <a href="javascript:history.back()">返 回</a> ]');
	}

	if (strlen($email)>60) {
		exit('错误：邮箱不得超过60个字符串 [ <a href="javascript:history.back()">返 回</a> ]');
	}

	//数据提交
	require("conn.php");
	$createtime = time();
	$insert_sql = "INSERT INTO GUESTBOOK(NICKNAME, EMAIL, CONTENT, CREATETIME) VALUES ('$nickname','$email','$content','$createtime')";

	if (mysqli_query($conn,$insert_sql)) {
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta http-equiv="Refresh" content="2;url=index.php">
			<title>留言成功</title>
		</head>
		<body>
			<div class = "refresh">
				<p>留言成功！非常感谢您的留言。<br/>请稍后，页面正在返回...</p>
			</div>
		</body>
		</html>
		<?php
	} else {
		echo '留言失败：', mysqli_error($conn), '[ <a href = "javascript:history.back()">返 回<a/> ]';
	}
?>