<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/menuitem/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Menu</label></th>
      <td><select name="MenuID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['menu_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['menu_list'][$i]['ID']; ?>"><?php echo $data['content_param']['menu_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td></td>
    </tr>
    <tr>
      <th scope="row"><label>Parent ID<span class="label_required">*</span></label></th>
      <td><input name="ParentID" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Link URL<span class="label_required">*</span></label></th>
      <td><input name="LinkURL" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required]" type="text" value="" size="20" /></td>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menuitem/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
