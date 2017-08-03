<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<title>留言板</title>
</head>
<body>
	<h3>留言列表</h3>
	<?php
		//引用相关文件
		require("conn.php");
		require("config.php");

		//确定当前页数参数
		$p = $_GET['p']?$_GET['p']:1;
		//数据指针
		$offset = ($p-1)*$pagesize;

		$query_sql = "SELECT * FROM GUESTBOOK ORDER BY ID DESC LIMIT $offset, $pagesize";
		$result = $conn -> query($query_sql);
		//错误处理
		if (!$result) {
			exit("数据查询错误：".mysqli_error($conn));
		}

		//循环输出
		while ($gb_array = mysqli_fetch_array($result) {
			$content = nl2br($gb_array['CONTENT']);
			echo $gb_array['NICKNAME'],'&nbsp;';
		}

		//计算留言页数
		$count_result = $conn -> query("SELECT COUNT(*) AS COUNT FROM GUESTBOOK");
		$count_array = mysqli_fetch_array($count_result);
		$pagenum = ceil($count_result["COUNT"]/$pagesize);
	?>
</body>
</html>