<?php

/**
 * 判断用户是否登陆
 *
 */

//判断用户是否登陆
session_start();
if(!isset($_SESSION['userInfo'])){
	//如果没有登陆就跳转到登陆页面
	header("refresh:2;url=./login.php");
	die("请您先登录！");
}
