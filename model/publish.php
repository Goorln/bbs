<?php

//加载项目初始化文件
include '../init.php';


//加载用户判断用户登陆页面
include DIR_MODEL . 'session_front.php';

//判断用户是否登陆
// session_start();
// if(!isset($_SESSION['userInfo'])){
// 	//如果没有登陆就跳转到登陆页面
// 	header("refresh:2;url=./login");
// 	die("请您先登录！");
// }

//加载视图文件
include DIR_VIEW . 'publish.html';