<?php
	session_start();
	//未登录则重定向到登录页面
	//echo $_SESSION['username'].'<br/>';
	if (!isset($_SESSION['username'])) {
		header("Location: http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']),'/\\')."/login.php");
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<title>留言管理</title>
</head>
<body>
<?php
	require("conn.php");
	require("config.php");

	@$p = $_GET['p']?$_GET['p']:1;
	$offset = ($p-1)*$pagesize;
	$query_sql = "SELECT * FROM GUESTBOOK ORDER BY ID DESC LIMIT $offset, $pagesize";
	$result = mysqli_query($conn, $query_sql);
	if (!$result) {
		exit('查询数据错误：'.mysqli_error($conn));
	}

	//循环输出当页显示数据
	while ($gb_array = mysqli_fetch_array($result)) {
		echo $gb_array['NICKNAME'],'&nbsp;';
		echo '发表于：',date("Y-m-d H:i:s", $gb_array['CREATETIME']);
		echo ' ID号：',$gb_array['ID'],'<br/>';
		echo '内容：',$gb_array['CONTENT'],'<br/>';
		?>
		<div id="reply">
			<form id="form1" name="form1" method="post" action="reply.php">
				<p>
					<label for="reply">回复本条留言：</label>
				</p>
				<textarea id="reply" name="reply" cols="40" rows="5"><?=$gb_array['REPLY']?></textarea>
				<p>
					<input type="hidden" name="id" value="<?=$gb_array['ID']?>" />
					<input type="submit" name="submit" value="回复留言" />
					<a href="reply.php?action=delete&id=<?=$gb_array['ID']?>">删除留言</a>
				</p>
			</form>
		</div>
		<?php
			echo "<hr/>";
		}

	//计算留言页数
	$count_result = mysqli_query($conn,"SELECT count(*) AS COUNT FROM GUESTBOOK");
	$count_array = mysqli_fetch_array($count_result);
	$pagenum=ceil($count_array['COUNT']/$pagesize);
	echo '共 ',$count_array['COUNT'],' 条留言';
	if ($pagenum > 1) {
		for($i=1;$i<=$pagenum;$i++) {
			if($i==$p) {
				echo '&nbsp;[',$i,']';
			} else {
				echo '&nbsp;<a href="admin.php?p=',$i,'">'.$i.'</a>';
			}
		}
	}
?>
</body>
</html>