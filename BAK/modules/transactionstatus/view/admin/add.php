<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/transactionstatus/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Label<span class="label_required">*</span></label></th>
      <td><input name="Label" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Background Color<span class="label_required">*</span></label></th>
      <td><input name="BGColor" class="validate[required] cpicker" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Color<span class="label_required">*</span></label></th>
      <td><input name="Color" class="validate[required] cpicker" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr> -->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/transactionstatus/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>