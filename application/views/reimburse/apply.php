<?php echo validation_errors(); ?>

<?php echo form_open('reimburse/apply'); ?>

	<table class="f-login-table">
   		<tr>
        <td colspan="2">报销:</td>
      </tr>

      <tr>
        <td style="width: 20%">工号</td>
        <td><input type="text" disabled  name="worknumber" value="<?=$this->session->login_user['worknumber']; ?>" /></td>
      </tr>

      <tr>
        <td>用户名</td>
        <td><input type="text" disabled name="username" value="<?=$this->session->login_user['username']; ?>" /></td>
      </tr>

      <tr>
        <td>日期</td>
        <td><input type="date" name="opTime" value="<?php echo set_value('opTime'); ?>" /></td>
      </tr>
      <tr>
        <td>金额</td>
        <td><input type="text" name="amount" value="<?php echo set_value('amount'); ?>"/></td>
      </tr>

      <tr>
        <td>类型</td>
        <td>

        <select name="type">
        
        <?php
          $types = $this->session->reimburse_types;
          foreach($types as $type)
          {
            if(set_value("type") == $type['id'])
            {
              echo "<option value =" . $type['id'].  " selected>" . $type['info'] . "</option>";
            }else
            {
              echo "<option value =" . $type['id'].  ">" . $type['info'] . "</option>";
            }
          }
        ?>
        </select>

        </td>
      </tr>
	<tr>
        <td>备注</td>
        <td><input type="text" name="desp" value="<?php echo set_value('desp'); ?>"/></td>
      </tr>

   		<tr>
     		<td colspan="2">
        <input type="submit" style="width:40%" value="确定"/>
        <input type="button" style="width:40%" value="取消" onclick="cancel()"></input>
        </td>
     	</tr>
      <tr><td colspan="2"><?php echo $error;?></td></tr>
 </table>

</form>

<script type="text/javascript">
  function cancel()
  {
    window.location.href="<?php echo site_url('user/reimburse_main');?>";
  }

</script>
