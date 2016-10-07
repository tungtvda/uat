<?php if ($data['page']['announcement_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['announcement_add']['ok']==1) { ?>
    <div class="notify">Announcement created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['announcement_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['announcement_edit']['ok']==1) { ?>
    <div class="notify">Announcement edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/announcement/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Title']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Date of Article<span class="label_required">*</span></label></th>
      <td><input name="Date" type="text" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo $data['content'][0]['Date']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="validate[required] full_width" rows="5"><?php echo $data['content'][0]['Description']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Content</label></th>
      <td><textarea name="Content" id="Content" class="validate[required] ckeditor" rows="15"><?php echo $data['content'][0]['Content']; ?></textarea></td>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/announcement/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
