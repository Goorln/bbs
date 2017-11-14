<?php

header("content-type:text/html;charset=utf-8");
//加载项目初始化文件
include '../init.php';

//加载数据库文件
include DIR_CORE . 'MySQLDB.php';

//接收数据
$pub_id = $rep_pub_id = $_POST['pub_id'];
$content = $rep_content = addslashes(strip_tags(trim($_POST['content'])));

//判断回复的内容的合法性
if($rep_content == ''){
	header("refresh:2;url=./reply.php?pub_id=$pub_id");
	die("回复的内容不能为空。。。");
}

//数据入库（reply表）
// $rep_user = "游客";
session_start();
$rep_user = $_SESSION['userInfo']['user_name'];

$rep_time = time();
$sql = "insert into reply values(null,$rep_pub_id,'$rep_user','$rep_content',$rep_time,default,default)";
$result = my_query($sql);//布尔值

//判断
if($result){
	// $pub_id = $row['pub_id'];
	$sql = "select * from reply where rep_pub_id = $pub_id";
    $res = my_query($sql);
    $row_rep_sum = mysql_num_rows($res);
	//回复成功，跳转,action=reply是标记，表示从此处跳转pub_hits才加1
	header("location:./show.php?pub_id=$pub_id&action=reply");
}else{
	//回复失败
	header("refresh:2;url=./reply.php?pub_id=$pub_id");
	die("发生未知错误，请重新回复！");
}
