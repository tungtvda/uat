<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/orderstatus/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Label<span class="label_required">*</span></label></th>
      <td><input name="Label" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Background Color<span class="label_required">*</span></label></th>
      <td><input name="BGColor" class="validate[required] cpicker" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Color<span class="label_required">*</span></label></th>
      <td><input name="Color" class="validate[required] cpicker" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/orderstatus/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
