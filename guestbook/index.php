<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<title>留言板</title>
	<script type="text/javascript">
		function InputCheck(form1){
  			if (form1.nickname.value == ""){
    			alert("请输入您的昵称。");
    			form1.nickname.focus();
    			return (false);
  			}
  			if (form1.content.value == ""){
    			alert("留言内容不可为空。");
    			form1.content.focus();
    			return (false);
  			}
		}
	</script>
</head>
<body>
	<h3>留言列表</h3>
	<?php
		//引用相关文件
		require("conn.php");
		require("config.php");

		//确定当前页数参数
		@$p = $_GET['p']?$_GET['p']:1;

		//数据指针
		$offset = ($p-1)*$pagesize;

		$query_sql = "SELECT * FROM GUESTBOOK ORDER BY ID DESC LIMIT $offset, $pagesize";
		$result = $conn -> query($query_sql);
		//错误处理
		if (!$result) {
			exit("数据查询错误：".mysqli_error($conn));
		}

		//循环输出
		while ($gb_array = mysqli_fetch_array($result)) {
			$content = nl2br($gb_array['CONTENT']);
			echo $gb_array['NICKNAME'],'&nbsp;';
			echo '发表于：'.date('Y-m-d H:i',$gb_array['CREATETIME']).'<br/>';
			echo '内容：'.$content.'<br/><br/>';

			if (!empty($gb_array['REPLYTIME'])) {
				echo '---------------------------------<br/>';
				echo '管理员回复于：'.date('Y-m-d H:i',$gb_array['REPLYTIME']).'<br/>';
				echo nl2br($gb_array['REPLY']).'<br/><br/>';
			}
			echo '<hr/>';
		}

		//计算留言页数
		$count_result = $conn -> query("SELECT COUNT(*) AS COUNT FROM GUESTBOOK");
		$count_array = mysqli_fetch_array($count_result);
		$pagenum = ceil(mysqli_fetch_array($count_result)/$pagesize);
		echo '共 '.$count_array['COUNT'].' 条留言';
		if ($pagenum > 1) {
			for ($i=1; $i < $pagenum; $i++) { 
				if ($i = $p) {
					echo '&nbsp;['.$i.']';
				} else {
					echo '&nbsp;<a href = "index.php?p='.$i.'">'.$i.'</a>';
				}
			}
		}
	?>

	<div class = 'form'>
		<form id = "form1" name = "form1" method="post" action="submiting.php" onSubmit="return InputCheck(this)">
			<h3>发表留言</h3>
				<p>
					<label for="title">昵&nbsp;&nbsp;&nbsp;&nbsp;称:</label>
					<input type="text" name="nickname" id="nickname" /><span>(必须填写，不超过16个字符)</span>
				</p>
				<p>
					<label for="title">电子邮件</label>
					<input type="text" name="email" id="email" /><span>(非必须，不超过60个字符)</span>
				</p>
				<p>
					<label for="title">留言内容:</label>
					<textarea id="content" name="content" cols="50" rows="8"></textarea>
				</p>
				<p>
					<input type="submit" name="submit" value="  确 定  " />
				</p>
		</form>
	</div>
</body>
</html>