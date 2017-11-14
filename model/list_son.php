<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . "MySQLDB.php";

# 以下的代码都和分页相关

// (1) 定义当前选中的页码数
$pageNum = isset($_GET['num']) ? $_GET['num'] : 1;

// (2) 定义每一页显示的记录数
$rowsPerPage = 5;

// (3) 查询总记录
$keyword = addslashes(strip_tags(trim($_GET['keyword'])));
// $sql = "select count(*) as sum from publish where pub_title like '%{$keyword}%' or pub_content like '%{$keyword}%' ";
$sql = "select count(*) as sum from publish where pub_title like '%{$keyword}%'";
$result = my_query($sql);
$row = mysql_fetch_assoc($result);
$rowCount = $row['sum']; // 得到总记录数

// (4) 计算总页数
$pages = ceil($rowCount/$rowsPerPage); // 得到总页数

// (5)拼凑页码字符串
$strPage = '';//页码字符串
// 拼凑出首页
$strPage .= "<a href='./list_father.php?num=1'>首页</a>";

// 拼凑出上一页
$preNum = $pageNum == 1 ? 1 : $pageNum - 1;
$strPage .=  "<a href='./list_father.php?num=$preNum'><<上一页</a>";

// 拼凑出中间的页码
// 确定显示的初始页$startNum
if($pageNum <= 3) {
	$startNum = 1;
}else {
	$startNum = $pageNum - 2;
}
// 确定显示的初始页$startNum的最大值
if($startNum > $pages - 4) {
	$startNum = $pages - 4;
} 
// 防止页码出现负值
if($startNum <= 1) {
	$startNum = 1;
}

// 确定显示的最后一页$endNum
$endNum = $startNum + 4;

// 防止最后一页越界
if($endNum >= $pages) {
	$endNum = $pages;
}

// 拼凑出中间的页码
for($i=$startNum;$i<=$endNum;$i++) {
	// 如果$i刚好是选中的当前页，标红
	if($i == $pageNum) {
		$strPage .=  "<a href='./list_father.php?num=$i'><font color='red'>$i</font></a>";
	}else {
		$strPage .=  "<a href='./list_father.php?num=$i'>$i</a>";
	}
}

//拼凑下一页字符串
$nextNum = $pageNum == $pages ? $pages : $pageNum + 1;
$strPage .=  "<a href='./list_father.php?num=$nextNum'>下一页>></a>";

// 拼凑出尾页
$strPage .=  "<a href='./list_father.php?num=$pages'>尾页</a>";

// 拼凑出总页数
$strPage .= "总页数:$pages";
# 分页到此结束

// 3, 提取帖子的结果集
$offset = $rowsPerPage*($pageNum - 1);
$sql = "select * from publish left join user on pub_owner=user_name where pub_title like '%{$keyword}%'order by pub_time desc limit {$offset},{$rowsPerPage}";
$result = my_query($sql); // 得到了资源结果集
// $row = mysql_fetch_assoc($result);








//加载视图文件
include DIR_VIEW . 'list_son.html';