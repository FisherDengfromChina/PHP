<?php
	$conn = new mysqli("localhost","root","91392821","php");
	if (!$conn) {
		die("数据库连接失败：".mysql_error());
	}
	$conn -> query("SET CHARACTER SET 'utf8'");
?>