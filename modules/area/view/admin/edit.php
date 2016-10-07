<?php if ($data['page']['area_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['area_add']['ok']==1) { ?>
    <div class="notify">Area created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['area_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['area_edit']['ok']==1) { ?>
    <div class="notify">Area edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/area/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="validate[required] full_width" rows="5"><?php echo $data['content'][0]['Description']; ?></textarea></td>
    </tr>
    <?php /*?><tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/area/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
