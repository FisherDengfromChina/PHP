<?php
	$conn = new mysqli("localhost","root","91392821","php");
	if (!$conn) {
		die("数据库连接出错：".mysqli_connect_error());
	}
	$conn -> query("set character set 'utf8'");
?>