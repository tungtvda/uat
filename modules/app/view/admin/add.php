<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/app/addprocess" method="post" enctype="multipart/form-data">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>App Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>IP Address</th>
      <td><input name="IPAddress" class="validate[custom[ipv4]]" type="text" value="" size="20" /><span class="label_hint">(e.g. 127.0.0.1)</span><br /><span class="label_hint">(If entered, the system will only accept requests from this IP address)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
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
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/app/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
