<?php

//加载项目初始化文件
include '../init.php';

//加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

//接收表单数据
$title = addslashes(strip_tags(trim($_POST['title'])));
$content = addslashes(strip_tags(trim($_POST['content'])));

//判断提交数据合法性(判断数据是否为空)
if($title == '' || $content == ''){
	//非法的数据，跳转
	header("refresh:2;url = ./publish.php");
	die("标题和内容都不能为空，请重新输入");
}

//数据入库
// $pub_owner = "游客";
session_start();
$pub_owner = $_SESSION['userInfo']['user_name'];

$pub_time = time();
$sql = "insert into publish values(null,'$title','$content','$pub_owner',$pub_time,default)";
//执行
$result = my_query($sql);
//判断执行结果
if($result){
	header("location:./list_father.php");
	//发帖成功
}else{
	header("refresh:2;url = ./publish.php");
	die("发帖失败，请重新发帖");
}