<?php

//加载项目初始化文件
include '../init.php';

//判断用户是否登陆（加载session_front.php文件）
include DIR_MODEL . 'session_front.php';

//加载数据库文件
include DIR_CORE . 'MySQLDB.php';

//接收数据
$num = $rep_num = $_GET['num'];
$pub_id = $rep_pub_id = $_GET['pub_id'];
$rep_id = $rep_quote_id = $_GET['rep_id'];
$content = $rep_content = addslashes(strip_tags(trim($_POST['content'])));

//判断数据的合法性
if($rep_content == ''){
	header("refresh:2;url=./quote.php?num=$num&pub_id=$pub_id&rep_id=$rep_id");
	die("回复的内容不能为空！");
}

//数据入库
$rep_user = $_SESSION['userInfo']['user_name'];
$rep_time = time();
$sql = "insert into reply values(null,$rep_pub_id,'$rep_user','$rep_content','$rep_time',$rep_num,$rep_quote_id)";
$result = mysql_query($sql);

//判断是否执行成功
if(!$result){
	header("refresh:2;url=./quote.php?num=$num&pub_id=$pub_id&rep_id=$rep_id");
	die("发生未知错误");
}else{
	header("refresh:0;url=./show.php?pub_id=$pub_id&action=reply");
}