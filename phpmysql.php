<?php
	$mysqli = new mysqli("localhost","root","91392821","WordPress");
	$result = $mysqli -> query("SELECT * FROM wp_users");
	$row = $result -> fetch_assoc();
	echo htmlentities($row["user_pass"]);
?>