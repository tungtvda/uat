<?php if ($data['page']['ad_add']['error']['count']>0) { ?>
    <?php if ($data['page']['ad_add']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['ad_add']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['ad_add']['ok']==1) { ?>
    <div class="notify">Ad Type created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['ad_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['ad_edit']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['ad_edit']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['ad_edit']['ok']==1) { ?>
    <div class="notify">Ad Type edited successfully.</div>
    <?php } ?>
<?php } ?>
<form action="<?php echo $data['config']['SITE_URL']; ?>/merchant/ad/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data" name="edit_form" class="admin_table_nocell"  id="edit_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['adtype_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['adtype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['adtype_list'][$i]['ID']==$data['content'][0]['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['adtype_list'][$i]['ID']; ?> - <?php echo $data['content_param']['adtype_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Ad Link<span class="label_required">*</span></label></th>
      <td><input name="AdLink" class="validate[required]" type="text" value="<?php echo $data['content'][0]['AdLink']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Image</label></th>
      <td><?php if ($data['content'][0]['ImageURL']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['ImageURLCover']; ?>" height="66" width="66" /><br />
        <label>
        <input name="ImageURLRemove" type="checkbox" id="ImageURLRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="ImageURLCurrent" value="<?php echo $data['content'][0]['ImageURL']; ?>" />
        <input name="ImageURL" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Expiry<span class="label_required">*</span></label></th>
      <td><input name="DateExpiry" type="text" class="validate[required,custom[dmyDateTime]] datepicker mask_date" value="<?php echo $data['content'][0]['DateExpiry']; ?>" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr> -->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/ad/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
