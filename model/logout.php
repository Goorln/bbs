<?php

//注销的本质就是删除所有会话数据
//删除cookie数据，让他的值为空
setcookie('user_id','',time()-1,'/','bbs.com');

session_start();
unset($_SESSION['userInfo']);

//跳转到首页或者其他页面
header("location:../index.php");

//加载视图文件
include '../index.html';