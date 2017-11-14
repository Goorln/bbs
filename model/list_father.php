<?php

header("content-type:text/html;charset=utf-8");
/* 帖子列表页*/

//加载项目初始化文件
include '../init.php';

//加载数据库连接文件
include DIR_CORE . "MySQLDB.php";


#分页开始
//定义当前页(num代表当前访问的是哪一页)
$pageNum = isset($_GET['num']) ? $_GET['num'] : 1;

//定义每一页显示的记录数(每一页显示5条记录)
$rowsPerPage = 5;

//查询总记录数
$sql = "select count(*) as sum from publish";
$result = my_query($sql);
$row = mysql_fetch_assoc($result);
$rowCount = $row['sum'];//得到总记录数

//计算出总页数
$pages = ceil($rowCount/$rowsPerPage);

//拼凑页码字符串
$strPage = '';

//拼凑首页字符串
$strPage .= "<a href='./list_father.php?num=1'>首页</a>";

//拼凑上一页字符串
$preNum = $pageNum == 1 ? 1: $pageNum-1;
$strPage .="<a href='./list_father.php?num=$preNum'> <<上一页 </a>";

//拼凑中间字符串
//确定显示的初始页$startNum
if($pageNum <= 3){
	$startNum = 1;
}else{
	$startNum = $pageNum - 2;
}
//确定显示的初始页$startNum的最大值
if($startNum > $pages -4){
	$startNum = $pages - 4;
}
//防止页码出现负值
if($startNum <= 1){
	$startNum = 1;
}

//确定显示的最后页$endNum
$endNum = $startNum + 4;

//防止最后一页越界
if($endNum >= $pages){
	$endNum = $pages;
}
//拼凑中间字符串
for($i=$startNum;$i<=$endNum;$i++){
	if($i == $pageNum){
		$strPage .= "<a href='./list_father.php?num=$i'><font color=red>$i</font></a>";
	}else{
		$strPage .= "<a href='./list_father.php?num=$i'>$i</a>";
	}
}

//拼凑下一页字符串
$nextNum = $pageNum == $pages ? $pages : $pageNum + 1;
$strPage .="<a href='./list_father.php?num=$nextNum'> 下一页>> </a>";

//拼凑尾页字符串
$strPage .= "<a href='./list_father.php?num=$pages'>尾页</a>";

#分页结束

//提取帖子的内容    //设置偏移量（公差公式）an=a1+(n-1)d $offset=1+($pageNum-1)*$rowsPerPage
$offset = $rowsPerPage*($pageNum-1);
$sql = "select * from publish left join user on pub_owner=user_name order by pub_time desc limit {$offset},{$rowsPerPage}";
$result = my_query($sql);//得到了资源结果集
// $row = mysql_fetch_assoc($result);


//加载视图文件
include DIR_VIEW . 'list_father.html';