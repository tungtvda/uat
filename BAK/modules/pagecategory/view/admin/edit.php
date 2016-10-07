<?php if ($data['page']['pagecategory_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['pagecategory_add']['ok']==1) { ?>
    <div class="notify">Page Category created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['pagecategory_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['pagecategory_edit']['ok']==1) { ?>
    <div class="notify">Page Category edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/pagecategory/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Parent</label></th>
      <td><select name="ParentID" class="chosen">
          <option value="" <?php if ($data['content_param']['pagecategory_list'][$i]['ID']=="") { ?> selected="selected"<?php } ?>>None</option>
          <?php for ($i=0; $i<$data['content_param']['pagecategory_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['pagecategory_list'][$i]['ID']; ?>" <?php if ($data['content_param']['pagecategory_list'][$i]['ID']==$data['content'][0]['ParentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['pagecategory_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Position']; ?>" size="10" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/pagecategory/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
