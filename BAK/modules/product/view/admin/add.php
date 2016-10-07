<form name="add_form" class="admin_table_nocell" enctype="multipart/form-data" id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['producttype_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['producttype_list'][$i]['ID']; ?>"><?php echo $data['content_param']['producttype_list'][$i]['Label']; ?></option><?php } ?></select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required] friendly_url" type="text" value="" size="20" /></td>
    </tr>
    <!-- <tr>      <th scope="row"><label>Image</label></th>      <td><input name="ImageURL" type="file" /><br />      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>    </tr> -->
    <tr>
      <th scope="row"><label>Play Link<span class="label_required">*</span></label></th>
      <td><input name="PlayLink" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Demo Link<span class="label_required">*</span></label></th>
      <td><input name="DemoLink" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>      <th scope="row"><label>Enabled</label></th>      <td><select name="Enabled">          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>          <?php } ?>        </select></td>    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
