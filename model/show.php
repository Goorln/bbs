<?php

/*show.php是显示帖子详情的页面
* 根据pub_id从数据库中获取帖子的内容
* 得到一个资源结果集的数组
* 最后加载视图文件
*/

//1加载项目初始化文件
include '../init.php';

//2加载数据库文件
include DIR_CORE . 'MySQLDB.php';

//3接收pub_id
$pub_id = $_GET['pub_id'];

//6每点一次就要使当前楼主的pub_hits字段+1
if(!$_GET['action']){//表示从详情页跳转，如果没有得到action，pub_hits才加1
$sql = "update publish set pub_hits = pub_hits + 1 where pub_id = $pub_id";
my_query($sql);
}

#分页开始
//定义当前页(num代表当前访问的是哪一页)
$pageNum = isset($_GET['num']) ? $_GET['num'] : 1;

//定义每一页显示的记录数(每一页显示5条记录)
$rowsPerPage = 5;

//4提取楼主的资源结果集
$sql = "select * from publish left join user on pub_owner=user_name where pub_id = $pub_id";
$result = my_query($sql);//执行SQL语句,得到一个资源结果集
$row = mysql_fetch_assoc($result);//得到一个数组

#分页开始
//定义当前页(num代表当前访问的是哪一页)
$pageNum = isset($_GET['num']) ? $_GET['num'] : 1;

//定义每一页显示的记录数(每一页显示5条记录)
$rowsPerPage = 5;

//查询总记录数
$sql = "select count(*) as sum from reply where rep_pub_id = $pub_id";
$result = my_query($sql);
$row_num = mysql_fetch_assoc($result);
$rowCount = $row_num['sum'];//得到总记录数

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
		$strPage .= "<a href='./show.php?pub_id=$pub_id&action=reply&num=$i'><font color=red>$i</font></a>";
	}else{
		$strPage .= "<a href='./show.php?pub_id=$pub_id&action=reply&num=$i'>$i</a>";
	}
}

//拼凑下一页字符串
$nextNum = $pageNum == $pages ? $pages : $pageNum + 1;
$strPage .="<a href='./show.php?num=$nextNum'> 下一页>> </a>";

//拼凑尾页字符串
$strPage .= "<a href='./show.php?num=$pages'>尾页</a>";

#分页结束

//7提取回帖的资源结果集
$offset = $rowsPerPage*($pageNum - 1);
$rep_sql = "select * from reply left join user on rep_user=user_name where rep_pub_id = $pub_id order by rep_time limit {$offset},{$rowsPerPage}";
$rep_result = mysql_query($rep_sql);
// $rep_row = mysql_fetch_assoc($rep_result);

//帖子回复的数量统计
// $sql = "select * from reply where rep_pub_id = $pub_id";
// $res = my_query($sql);
// $row_rep_sum = mysql_num_rows($res);
$num_result = my_query("select * from reply where rep_pub_id = $pub_id");
$rep_num = mysql_num_rows($num_result);


//5加载视图文件
include DIR_VIEW . 'show.html';

