
<?php
$role = $this->session->login_user['role'];
if($role == 1){
	$role = '老板';
}else
{
	$role = '员工';
}
echo '你好! ' . $this->session->login_user['username'] . '(' . $this->session->login_user['worknumber'] . ',' . $role . ')';
?>

<a href="<?php echo site_url('user/vocation_main');?>">请假管理</a>

<a href="<?php echo site_url('user/reimburse_main');?>">报销管理</a>

<a href="<?php echo site_url('user/logout');?>">注销</a>

<a href="<?php echo site_url('user/edit');?>">修改个人信息</a>

<br/>

