<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/banner/addprocess" method="post" enctype="multipart/form-data">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Banner Image</label></th>
      <td><input name="ImageURL" type="file" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must be 980px x 295px.)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Link</label></th>
      <td><input name="Link" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Alternate Title<span class="label_required">*</span></label></th>
      <td><input name="AltTitle" class="validate[required]" type="text" value="" size="40" /><br />
      <span class="label_hint">(This title will show in case the image could not load.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>New Window<span class="label_required">*</span></label></th>
      <td><select name="Target" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['target_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['target_list'][$i]['ID']; ?>"><?php echo $data['content_param']['target_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required,custom[integer]]" type="text" value="" size="2" /></td>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/banner/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
