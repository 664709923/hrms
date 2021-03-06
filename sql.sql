create database hrms;

use hrms;

create table user (
	id int primary key auto_increment,
	worknumber char(6),
	name varchar(20),
	username varchar(20),
	passwd varchar(40) not null,
	email varchar(100),
	role int default 0
);

insert into user(name, username, worknumber, passwd, role) values('汪灿丰', 'wcf', '160000', sha1('admin'), 1);
insert into user(name, username, worknumber, passwd, role) values('孙子博', 'szb', '160001', sha1('admin'), 1);


create table vocation (
	id int primary key auto_increment,
	username varchar(20) not null,
	startTime varchar(20) not null,
	endTime varchar(20) not null,
	duration int,
	desp varchar(100),
	opTime varchar(50),
	type int,
	status int    /* 1:已提交 2:已同意 */
	/*foreign key(username) references user(username)*/
);

/*请假和报销系统公用的状态表*/
create table status(
	id int primary key auto_increment,
	info varchar(10)
);

insert into status(info) values('已提交'); /*id=1*/
insert into status(info) values('已审核'); /*id=2*/
insert into status(info) values('已完成'); /*id=3*/

create table vocation_type(
	id int primary key auto_increment,
	info varchar(10),
	days int
);

insert into vocation_type(info, days) values('事假', 14);	/*id=1*/
insert into vocation_type(info, days) values('病假', 30);	/*id=2*/
insert into vocation_type(info, days) values('公假', 365);	/*id=3*/
insert into vocation_type(info, days) values('工伤假', 365);	/*id=4*/
insert into vocation_type(info, days) values('婚假', 8);		/*id=5*/
insert into vocation_type(info, days) values('丧假', 8);		/*id=6*/
insert into vocation_type(info, days) values('产假', 60);	/*id=7*/


create table reimburse(
	id int primary key auto_increment,
	worknumber char(6),
	username varchar(20) not null,
	desp varchar(100),
	opTime varchar(50),
	amount int,
	type int,
	status int    /* 1:已提交 2:已同意 3:已完成 */
);

create table reimburse_type(
	id int primary key auto_increment,
	info varchar(10)
);

insert into reimburse_type(info) values('印刷费');	/*id=1*/
insert into reimburse_type(info) values('网络费');	/*id=2*/
insert into reimburse_type(info) values('差旅费');	/*id=3*/
insert into reimburse_type(info) values('培训费');	/*id=4*/
insert into reimburse_type(info) values('会议费');	/*id=5*/
insert into reimburse_type(info) values('制作费');	/*id=6*/
insert into reimburse_type(info) values('广告费');	/*id=7*/
