<?php

//加载项目初始化文件
include '../init.php';

//加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

//接收数据
$num = $_GET['num'];
$pub_id = $_GET['pub_id'];
$rep_id = $_GET['rep_id'];

//提取楼主的帖子的信息
$sql = "select * from publish where pub_id=$pub_id";
$result = my_query($sql);
$row = mysql_fetch_assoc($result);

//提取被引用的帖子的信息
$rep_sql = "select * from reply where rep_id=$rep_id";
$rep_result = my_query($rep_sql);
$rep_row = mysql_fetch_assoc($rep_result);

//加载视图文件
include DIR_VIEW . 'quote.html';

