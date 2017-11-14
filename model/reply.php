<?php

/**
 *
 *
 *
 *
 */
//加载初始化文件
include '../init.php';

//加载用户判断用户登陆页面
include DIR_MODEL . 'session_front.php';

//加载数据库文件
include DIR_CORE . 'MySQLDB.php';

//提取pub_id
$pub_id = $_GET['pub_id'];

//
$sql = "select * from publish where pub_id = $pub_id";
$result = my_query($sql);
$row = mysql_fetch_assoc($result);

//加载视图文件
include DIR_VIEW . 'reply.html';