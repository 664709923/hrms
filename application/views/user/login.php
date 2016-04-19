<?php echo validation_errors(); ?>

<?php echo form_open('user/login'); ?>

  <table class="f-login-table">
      <tr>
        <td colspan="2">登陆</td>
      </tr>
      <tr>
        <td style="width: 20%">用户名</td>
        <td><input type="text" name="username" value="<?php echo set_value('username'); ?>" /></td>
      </tr>
      <tr>
        <td>密码</td>
        <td><input type="password" name="passwd" value="<?php echo set_value('passwd'); ?>"/></td>
      </tr>
      <tr>
        <td colspan="2">
        <input type="button" style="width:40%" value="注册" onclick="register()"/>
        <input type="submit" style="width:40%" value="登陆"></input>
        </td>
      </tr>
      <tr><td colspan="2"><?php echo $error;?></td></tr>
 </table>

</form>

<script type="text/javascript">
  function register()
  {
    window.location.href="<?php echo site_url('user/register');?>";
  }

</script>