<?php

//加载项目初始化文件
include '../init.php';

//加载视图文件
include DIR_VIEW . 'register.html';

//连接数据库
$link = mysql_connect('localhost','root','root');

