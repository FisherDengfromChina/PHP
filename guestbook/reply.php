<?php
	session_start();
	//echo $_SESSION['username'];

	if (!isset($_SESSION['username'])) {
		header("Location: http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/login.php");
		//header("Location: http://www.baidu.com");
		exit;
	}


	require("conn.php");
	if($_POST){
		if (get_magic_quotes_gpc()) {
			$reply = htmlspecialchars(trim($_POST['reply']));
		} else {
			$reply = addslashes(htmlspecialchars(trim($_POST['reply'])));
		}
	}

	//回复为空时，将回复时间置为空
	$replytime = $reply?time():'NULL';
	$update_sql = "UPDATE GUESTBOOK SET REPLY = '$reply', REPLYTIME = $replytime WHERE id = ".$_POST['id'];
	//$update_sql = "UPDATE GUESTBOOK SET REPLY = '".$reply."', REPLYTIME = ".$replytime." WHERE ID = '1'";
	//$update_sql = "UPDATE GUESTBOOK SET REPLY = 'HELLO', REPLYTIME = NULL WHERE ID = 1 ";
	if (mysqli_query($conn, $update_sql)) {
		exit('<script language="javascript">alert("回复成功！");self.location = "admin.php";</script>');
	} else {
		exit('留言失败：'.mysqli_error($conn).'[ <a href="javascript:history.back()">返 回</a> ]');
	}

	//删除留言
	if ($_GET['action'] == 'delete') {
		//$delete_sql = "DELETE FROM GUESTBOOK WHERE ID = $_GET['id']";
		$delete_sql = "DELETE FROM GUESTBOOK WHERE ID = '1'";
		if (mysqli_query($conn, $delete_sql)) {
			exit('<script language="javascript">alert("删除成功！");self.location = "admin.php";</script>');
		} else {
			exit('留言失败：'.mysql_error().'[ <a href="javascript:history.back()">返 回</a> ]');
		}
	}
?>