<?php

//加载项目初始化文件
include '../init.php';

//加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

//加载上传函数的文件
include DIR_CORE . 'upload.php';

$file = $_FILES['image'];
// var_dump($file);die;
$allow_ext=array('jpg','png','gif');
$allow_size=2;
$root_dir='../uploads/images';
$result = upload($file,$allow_ext,$allow_size,$root_dir);
// var_dump($result);die;
if($result){
	//上传成功
	session_start();
	$user_name = $_SESSION['userInfo']['user_name'];
	$old_name = $_SESSION['userInfo']['user_image'];
	// $old_sql = "select user_image from user where user_name = $user_name";
	// $old_result = my_query($old_sql);
	// $old_row = mysql_fetch_assoc($old_result);
	// $old_name = $old_row['user_image'];
	//入库，更新
	$sql = "update user set user_image='$result' where user_name='$user_name'";
	$res = mysql_query($sql);
	if($res){
		unlink($old_name);
		$old_name = $_SESSION['userInfo']['user_image'];
		echo "<script>alert('上传成功！')</script>";
		header("refresh:5;url=./list_father.php");
	}
}