

<?php echo form_open('user/edit'); ?>
	<table class="f-login-table">
   		<tr>
     		<td colspan="2">修改个人信息</td>
   		</tr>

      <tr>
        <td style="width: 20%">姓名</td>
        <td><input type="text" name="name" value="<?=$this->session->login_user['name']; ?>"/></td>
      </tr>

   		<tr>
     		<td>用户名</td>
     		<td><input type="text" name="username" value="<?=$this->session->login_user['username']; ?>"/></td>
     	</tr>

   		<tr>
     		<td>密码</td>
     		<td><input type="password" name="passwd" value=""/></td>
     	</tr>

      <tr>
        <td>确认密码</td>
        <td><input type="password" name="passwd2" value=""/></td>
      </tr>

      <tr>
        <td>E-mail</td>
        <td><input type="email" name="email" value="<?=$this->session->login_user['email']; ?>"/></td>
      </tr>

   		<tr>
     		<td colspan="2">
        <input type="submit" style="width:40%" value="确认"/>
        <input type="button" style="width:40%" value="取消" onclick="cancel()"/>
        </td>
     	</tr>
      <tr><td colspan="2"><?php echo validation_errors(); ?></td></tr>
 </table>

</form>

<script type="text/javascript">
  function cancel()
  {
    window.location.href="<?php echo site_url('user/main');?>";
  }

</script>