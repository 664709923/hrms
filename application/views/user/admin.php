
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

<!--
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

<br/>

<a href="<?php echo site_url('user/logout');?>">注销</a>
<br/>

筛选
<?php echo form_open('user/vocation'); ?>

年份:<select name="year">
	<option value="">全部</option>
	<?php
	$year = date('Y');
	for($i = 2010;$i <= $year; $i ++)
	{
		if(set_value("year") == $i)
		{
			echo "<option value ='$i' selected>$i</option>";

		}else
		{
			echo "<option value ='$i'>$i</option>";
		}
	}
	?>
</select>

请假类型:<select name="type">
	<option value="">全部</option>
	<?php
	$types = $this->session->vocation_types;
	foreach($types as $type)
	{
		if(set_value("type") == $type['id'])
		{
			echo "<option value =" . $type['id'] . " selected>" . $type['info'] . "</option>";

		}else
		{
			echo "<option value =" . $type['id'] . ">" . $type['info'] . "</option>";
		}
	}
	?>
</select>

状态:<select name="status">
	<option value="">全部</option>
	<?php
	$status = $this->session->status;
	foreach($status as $st)
	{
		if(set_value("status") == $st['id'])
		{
			echo "<option value =" . $st['id'] . " selected>" . $st['info'] . "</option>";

		}else
		{
			echo "<option value =" . $st['id'] . ">" . $st['info'] . "</option>";
		}
	}
	?>
</select>


<input type="text" name="user" placeholder="输入用户名" value="<?php echo set_value('user');?>"></input>

<input type="submit" class="submit" value="确定"/>

</form>

<table class="table-border">

<tr>
	<td>编号</td>
	<td>用户名</td>
	<td>开始时间</td>
	<td>结束时间</td>
	<td>天数</td>
	<td>原因</td>
	<td>申请时间</td>
	<td>请假类型</td>
	<td>状态</td>
	<td>操作</td>
</tr>

<?php
for ($i = 0; $i < count($vocations);$i++) {
	$vocation = $vocations[$i];
?>
	<tr>
	<td><?=$i+1;?></td>
	<td><?=$vocation['username'];?></td>
	<td><?=$vocation['startTime'];?></td>
	<td><?=$vocation['endTime'];?></td>
	<td><?=$vocation['duration'];?></td>
	<td><?=$vocation['desp'];?></td>
	<td><?=$vocation['opTime'];?></td>
	<td><?=$vocation['type']['info'];?></td>
	<td><?=$vocation['status']['info'];?></td>

	<td>
	<?php echo form_open('vocation/accept'); ?>
	<input type="hidden" name="id" value="<?=$vocation['id'];?>"/>
	<input type="hidden" name="username" value="<?=set_value('user');?>"/>
	<input type="hidden" name="year" value="<?=set_value('year');?>"/>
	<input type="hidden" name="type" value="<?=set_value('type');?>"/>
	<input type="hidden" name="status" value="<?=set_value('status');?>"/>
	<input type="submit" value="通过" <?php if($vocation['status']['id'] > 1){echo 'disabled';} ?> onclick="return confirm('确定批准？')"/>

	</form>
	</td>

 </tr>
<?php
}
?>
</table>
-->