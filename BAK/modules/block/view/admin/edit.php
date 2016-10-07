<?php if ($data['page']['block_add']['error']['count']>0) { ?>    
<?php } else { ?>
    <?php if ($data['page']['block_add']['ok']==1) { ?>
    <div class="notify">Block created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['block_edit']['error']['count']>0) { ?>    
<?php } else { ?>
    <?php if ($data['page']['block_edit']['ok']==1) { ?>
    <div class="notify">Block edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <?php /*?><tr>
      <th scope="row"><label>User ID</label></th>
      <td><input name="UserID" type="text" class="validate[required]" value="<?php echo $data['content'][0]['UserID']; ?>" size="20" /></td>
    </tr><?php */?>
    <tr>
      <th scope="row"><label>Area</label></th>
      <td><select name="AreaID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['area_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['area_list'][$i]['ID']; ?>" <?php if ($data['content_param']['area_list'][$i]['ID']==$data['content'][0]['AreaID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['area_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['blocktype_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['blocktype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['blocktype_list'][$i]['ID']==$data['content'][0]['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['blocktype_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Content</label></th>
      <td><textarea name="Content" id="Content" class="validate[required] ckeditor" rows="15"><?php echo $data['content'][0]['Content']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Position']; ?>" size="5" /></td>
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
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
