<?php

//加载项目初始化文件
include './init.php';

session_start();
//判断用户是否设置了7天免登录功能，如果设置了就自动创建一个会话数据区保存用户信息
if(isset($_COOKIE['user_id'])){

	include DIR_CORE . 'MySQLDB.php';
	$user_id = (int)$_COOKIE['user_id'];
	$sql = "select * from user where user_id = $user_id";
	$result = my_query($sql);
	$row = mysql_fetch_assoc($result);
	$_SESSION['userInfo'] = $row;
}



//加载视图文件
include DIR_VIEW.'index.html';
