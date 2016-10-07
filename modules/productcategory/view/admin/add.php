<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/productcategory/addprocess" enctype="multipart/form-data" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Parent</label></th>
      <td><select name="ParentID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['productcategory_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['productcategory_list'][$i]['ID']; ?>" ><?php echo $data['content_param']['productcategory_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required] friendly_url" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Friendly URL</label></th>
      <td><input name="FriendlyURL" id="FriendlyURL" class="validate[required,custom[alphaNumDash]]" type="text" value="" size="80" /><a href="javascript:void(0);" class="friendly_url">Generate &raquo;</a></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="validate[required] full_width" rows="15"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Image</label></th>
      <td><input name="ImageURL" type="file" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
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
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/productcategory/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
