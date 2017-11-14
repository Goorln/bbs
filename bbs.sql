
-- 1,创建数据库
create database bbs;

-- 2,选择默认的数据库
use bbs;

-- 3,创建用户表
create table user(
	user_id int primary key auto_increment comment '主键ID',
	user_name varchar(20) not null unique key comment '用户名',
	user_password char(32) not null comment '用户密码'
);

-- 4,创建帖子表
create table publish(
	pub_id int primary key auto_increment comment '主键ID',
	pub_title varchar(50) not null comment '帖子的标题',
	pub_content text not null comment '帖子的内容',
	pub_owner varchar(20) not null comment '发帖者(楼主)',
	pub_time int unsigned not null comment '发帖的时间戳',
	pub_hits int unsigned not null default 0 comment '浏览次数'
);

-- 5,创建回帖表
create table reply(
	rep_id int primary key auto_increment comment '主键ID',
	rep_pub_id int unsigned not null comment '楼主的帖子的ID',
	rep_user varchar(20) not null comment '回复者的名字',
	rep_content text not null comment '回复的内容',
	rep_time int unsigned not null comment '回帖的时间戳'
);