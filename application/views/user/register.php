

<?php echo form_open('user/register'); ?>
	<table class="f-login-table">
   		<tr>
     		<td colspan="2">注册</td>
   		</tr>

      <tr>
        <td style="width: 20%">姓名</td>
        <td><input type="text" name="name" value="<?php echo set_value('name'); ?>"/></td>
      </tr>

   		<tr>
     		<td>用户名</td>
     		<td><input type="text" name="username" value="<?php echo set_value('username'); ?>"/></td>
     	</tr>

   		<tr>
     		<td>密码</td>
     		<td><input type="password" name="passwd" value="<?php echo set_value('passwd'); ?>"/></td>
     	</tr>

      <tr>
        <td>确认密码</td>
        <td><input type="password" name="passwd2" value="<?php echo set_value('passwd2'); ?>"/></td>
      </tr>

      <tr>
        <td>E-mail</td>
        <td><input type="email" name="email" value="<?php echo set_value('email'); ?>"/></td>
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
    window.location.href="<?php echo site_url('user/login');?>";
  }

</script>