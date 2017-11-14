<?php

//加载项目初始化文件
include '../init.php';

//加载项目核心函数文件
include DIR_CORE . "MySQLDB.php";

//接收数据
$user_name = trim($_POST['user_name']);
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);
$vcode = trim($_POST['vcode']);

//判断验证码的合法性
session_start();
if(strtolower($vcode) != strtolower($_SESSION['captcha'])){
	header("refresh:2;url=./register.php");
	die("验证码不正确，请您重新注册！");
}

//判断数据的合法性
//判断用户名密码是否为空
if($user_name == '' || $password1 == '' || $password2 == '' ){
	//非法，跳转
    header("refresh:2;url = ./register.php");
    die("您输入的用户名和密码都不能为空，请重新输入");
}

//判断用户两次输入的密码是否一致
if($password1 !== $password2){
 	//非法，跳转
 	header("refresh:2;url = ./register.php");
 	die("两次输入的密码不一致，请重新输入");
}

//判断用户名是否已经存在
$sql = "select * from user where user_name = '$user_name'";
$result = my_query($sql);
if(mysql_num_rows($result) > 0){
	//说明用户已经存在
 	//非法，跳转
 	header("refresh:2;url = ./register.php");
 	die("您输入的用户名已存在，请您重新输入");
}

//验证结束，把用户的注册信息写入数据库（入库）
$password = md5($password1);
$sql = "insert into user values(null,'$user_name','$password',default)";
$result = my_query($sql);
//跳转到首页或者登陆页面
if($result){
 	//注册成功，跳转到登陆页面
	header("refresh:2;url = ./login.php ");
	die("注册成功，2秒后跳转到登陆页面");
}else{
	 //插入记录失败
	header("refresh:2;url = ./register.php");
	die("注册失败，2秒后跳转到注册页面");
}
