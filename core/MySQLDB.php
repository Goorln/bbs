<?php

#封装数据库连接函数
/**
 * 连接数据库
 * @param array $arr 数据库连接需要的函数
 */
function my_connect($arr){
	$host = isset($arr['host']) ? $arr['host'] : 'localhost';
	$port = isset($arr['port']) ? $arr['port'] : '3306';
	$user = isset($arr['user']) ? $arr['user'] : 'root';
	$pass = isset($arr['pass']) ? $arr['pass'] : '';
	$link = @ mysql_connect("$host:$port",$user,$pass);
	//判断是否连接成功
	if(!$link){
		//连接失败
		echo "数据库连接失败！ <br />";
		echo "错误编号：",mysql_errno(),'<br />';
		echo "错误信息：",mysql_error(),'<br />';
		//终止脚本运行
		die;
	}
}
/**
 * SQL语句的执行函数
 * @param string $sql 一条SQL语句
 * @return $result sql语句执行的结果
 */
function my_query($sql){
	//首先也要执行SQL语句
	$result = mysql_query($sql);
	//判断是否执行成功
	if(!$result){
		//执行失败
		//连接失败
		echo "SQL语句执行失败！ <br />";
		echo "错误编号：",mysql_errno(),'<br />';
		echo "错误信息：",mysql_error(),'<br />';
		//终止脚本运行
		die;
	}else{
		return $result;
	}
}
/**
 * 设置默认的字符集
 * @param string $charset 字符集
 */
function my_charset($charset){
	mysql_query("set names $charset");
}

/**
 * 选择默认的数据库
 * @param string $dbname 数据库的名字
 */
function my_dbname($dbname){
	mysql_query("use $dbname");
}

//加载配置文件
$config = include DIR_CONFIG . 'config.php';
my_connect($config['db']);
my_charset($config['db']['charset']);
my_dbname($config['db']['dbname']);