<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/region/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']=='151') { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>State</label></th>
      <td><select name="State" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>"><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option><?php } ?>
            </select></td>
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
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/region/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
