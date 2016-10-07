<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <?php /*?><tr>
      <th scope="row"><label>User ID</label></th>
      <td><input name="UserID" class="validate[required]" type="text" value="" size="20" /></td>
    </tr><?php */?>
    <tr>
      <th scope="row"><label>Area</label></th>
      <td><select name="AreaID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['area_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['area_list'][$i]['ID']; ?>"><?php echo $data['content_param']['area_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['blocktype_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['blocktype_list'][$i]['ID']; ?>"><?php echo $data['content_param']['blocktype_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Content</label></th>
      <td><textarea name="Content" id="Content" class="validate[required] ckeditor" rows="15"></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required]" type="text" value="" size="5" /></td>
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
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
