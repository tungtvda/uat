<?php if ($data['page']['banner_add']['error']['count']>0) { ?>
    <?php if ($data['page']['banner_add']['error']['ImageURL']!="") { ?>
    <div class="error">Banner Image upload failed (Error: <?php echo $data['page']['banner_add']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['banner_add']['ok']==1) { ?>
    <div class="notify">Banner created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['banner_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['banner_edit']['error']['ImageURL']!="") { ?>
    <div class="error">Banner Image upload failed (Error: <?php echo $data['page']['banner_edit']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['banner_edit']['ok']==1) { ?>
    <div class="notify">Banner edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/banner/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Banner Image</label></th>
      <td><?php if ($data['content'][0]['ImageURL']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['ImageURLBanner']; ?>" height="160" width="480" /><br />
        <label>
        <input name="ImageURLRemove" type="checkbox" id="ImageURLRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="ImageURLCurrent" value="<?php echo $data['content'][0]['ImageURL']; ?>" />
        <input name="ImageURL" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must be 980px x 295px.)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Link</label></th>
      <td><input name="Link" type="text" value="<?php echo $data['content'][0]['Link']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Alternate Title<span class="label_required">*</span></label></th>
      <td><input name="AltTitle" class="validate[required]" type="text" value="<?php echo $data['content'][0]['AltTitle']; ?>" size="40" /><br />
      <span class="label_hint">(This title will show in case the image could not load.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>New Window<span class="label_required">*</span></label></th>
      <td><select name="Target" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['target_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['target_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Target']==$data['content_param']['target_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['target_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required,custom[integer]]" type="text" value="<?php echo $data['content'][0]['Position']; ?>" size="2" /></td>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/banner/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
