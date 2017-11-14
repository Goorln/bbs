<?php

#项目初始化文件
// 1、设置文字编码（设置响应头信息）
header("content-type:text/html;charset=utf-8");
// 2、定义目录常量
//定义根目录常量
define("DIR_ROOT",str_replace('\\','/',__DIR__).'/');
// define("DIR_ROOT",__DIR__.DIRECTORY_SEPARATOR);
// echo DIR_ROOT;
//定义配置文件目录常量
define("DIR_CONFIG",DIR_ROOT.'config/');
//定义控制器目录常量
define("DIR_CON",DIR_ROOT.'controller/');
//定义核心目录常量
define("DIR_CORE",DIR_ROOT.'core/');
//定义模型目录常量
define("DIR_MODEL",DIR_ROOT.'model/');
//定义公开目录常量
define("DIR_PUBLIC",'/public/');//这里的‘/’代表网站根目录
//定义视图目录常量
define("DIR_VIEW",DIR_ROOT.'view/');