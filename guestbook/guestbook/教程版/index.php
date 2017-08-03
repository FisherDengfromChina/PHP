<?php
/***********************************************************
* 程序说明
* 5idev 留言板教程版
* 本留言板程序为 www.5idev.com 提供，供留言板教程使用
* 本站对该程序不保留任何权利，可自由修改传播使用
* 本留言板教程地址：http://www.5idev.com/p-php_guestbook.shtml
***********************************************************/
/***********************************************************
* index.php 留言板主页面文件
***********************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>请您留言</title>
<script language="JavaScript">
function InputCheck(form1)
{
  if (form1.nickname.value == "")
  {
    alert("请输入您的昵称。");
    form1.nickname.focus();
    return (false);
  }
  if (form1.content.value == "")
  {
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
/*****************************
*index.php 主页面文件
*****************************/
// 引用相关文件
require("./conn.php");
require("./config.php");

// 确定当前页数 $p 参数
$p = $_GET['p']?$_GET['p']:1;
// 数据指针
$offset = ($p-1)*$pagesize;

$query_sql = "SELECT * FROM guestbook ORDER BY id DESC LIMIT  $offset , $pagesize";
$result = mysql_query($query_sql);
// 如果出现错误并退出
if(!$result) exit('查询数据错误：'.mysql_error());

// 循环输出
while($gb_array = mysql_fetch_array($result)){
	$content = nl2br($gb_array['content']);
	echo $gb_array['nickname'],'&nbsp;';
	echo '发表于：'.date("Y-m-d H:i", $gb_array['createtime']).'<br />';
	echo '内容：',nl2br($gb_array['content']),'<br /><br />';
	
	if(!empty($gb_array['replytime'])) {
		echo '----------------------------<br />';
		echo '管理员回复于：',date("Y-m-d H:i", $gb_array['replytime']),'<br />';
		echo nl2br($gb_array['reply']),'<br /><br />';
	}
	echo '<hr />';
}

//计算留言页数
$count_result = mysql_query("SELECT count(*) FROM guestbook");
$count_array = mysql_fetch_array($count_result);
$pagenum=ceil($count_array['count(*)']/$pagesize);
echo '共 ',$count_array['count(*)'],' 条留言';
if ($pagenum > 1) {
	for($i=1;$i<=$pagenum;$i++) {
		if($i==$p) {
			echo '&nbsp;[',$i,']';
		} else {
			echo '&nbsp;<a href="index.php?p=',$i,'">'.$i.'</a>';
		}
	}
}
?>
<div class="form">
<form id="form1" name="form1" method="post" action="submiting.php" onSubmit="return InputCheck(this)">
<h3>发表留言</h3>
<p>
<label for="title">昵&nbsp;&nbsp;&nbsp;&nbsp;称:</label>
<input id="nickname" name="nickname" type="text" /><span>(必须填写，不超过16个字符串)</span>
</p>
<p>
<label for="title">电子邮件:</label>
<input id="email" name="email" type="text" /><span>(非必须，不超过60个字符串)</span>
</p>
<p>
<label for="title">留言内容:</label>
<textarea id="content" name="content" cols="50" rows="8"></textarea>
</p>
<input type="submit" name="submit" value="  确 定  " />
</form>
</div>
</body>
</html>