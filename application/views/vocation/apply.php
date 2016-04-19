<?php echo validation_errors(); ?>

<?php echo form_open('vocation/apply'); ?>

	<table class="f-login-table">
   		<tr>
        <td colspan="2">请假</td>
      </tr>
      <tr>
        <td style="width: 20%">开始时间</td>
        <td><input type="date" name="startTime" value="<?php
         $st = set_value('startTime');
         if($st != NULL)
          {
            echo $st;
          }else
          {
            echo date('Y-m-d');
          } 

          ?>" /></td>
      </tr>
      <tr>
        <td>结束时间</td>
        <td><input type="date" name="endTime" value="<?php
         $end = set_value('endTime');
         if($end != NULL)
          {
            echo $end;
          }else
          {
            echo date('Y-m-d');
          } 

          ?>"/></td>
      </tr>

      <tr>
        <td>类型</td>
        <td>

        <select name="type">
        
        <?php
          $types = $this->session->vocation_types;
          foreach($types as $type)// = 0;$i < count($types); $i ++)
          {
            //$type = $types[$i];
            if(set_value("type") == $type['id'])
            {
              echo "<option value =" . $type['id'].  " selected>" . $type['info'] . "(剩余天数:" . $rest[$type['id']] . ")</option>";
            }else
            {
              echo "<option value =" . $type['id'].  ">" . $type['info'] . "(剩余天数:" . $rest[$type['id']] . ")</option>";
            }
          }
        ?>
        </select>

        </td>
      </tr>

      <tr>
        <td>描述</td>
        <td>
        <input type="text" name="desp" value="<?php echo set_value('desp'); ?>"/>
        </td>
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
    window.location.href="<?php echo site_url('user/vocation_main');?>";
  }

</script>