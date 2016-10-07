<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/country/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/country/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
