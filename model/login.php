<?php

//加载项目初始化文件
include '../init.php';

session_start();
//判断是否设置了cookie变量user_id
if(isset($_COOKIE['user_id']) && isset($_SESSION['userInfo'])){
	//用户设置了七天免登录功能，直接跳转到发帖页面
	header("location:./publish.php");
}

//加载视图文件
include DIR_VIEW . "login.html";