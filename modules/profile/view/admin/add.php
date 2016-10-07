<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/profile/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Profile<span class="label_required">*</span></label></th>
      <td><input name="Profile" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/profile/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
