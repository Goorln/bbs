<?php

//加载项目初始化文件
include '../init.php';

//加载数据库连接文件
include DIR_CORE . "MySQLDB.php";

//接收表单数据
$username = trim($_POST['username']);
$password = trim($_POST['password']);

//验证用户和密码的合法性
//验证用户名是否存在
$sql = "select * from user where user_name = '$username'";
$result = my_query($sql);
if(!mysql_num_rows($result)){
    //用户名不存在
    //非法，跳转
    header("refresh:2;url = ./login.php");
    die("您输入的用户名不存在，请重新输入");
}
//验证密码是否正确
$row = mysql_fetch_assoc($result);
$user_password = $row['user_password'];
if($user_password === md5($password)){
	//验证成功
	//判断用户是否选择了七天免登陆
	if(isset($_POST['remember'])){
		setcookie('user_id',$row['user_id'],time()+86400,'/','bbs.com');
	}
	//用户验证成功，将用户的信息保存在session会话区中
	session_start();
	$_SESSION['userInfo'] = $row;

	header("refresh:1;url = ./publish.php");
	die("登陆成功，2秒后自动跳转到发帖页面");
}else{
	//验证失败
	//非法，跳转
	header("refresh:2;url = ./login.php");
	die("登陆失败，2秒后跳转到登陆页面");
}

