<?php if ($data['page']['metadata_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['metadata_add']['ok']==1) { ?>
    <div class="notify">Meta Data created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['metadata_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['metadata_edit']['ok']==1) { ?>
    <div class="notify">Meta Data edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Module</label></th>
      <td><select name="ModuleID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['module_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['module_list'][$i]['ID']; ?>" <?php if ($data['content_param']['module_list'][$i]['ID']==$data['content'][0]['ModuleID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['module_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Section<span class="label_required">*</span></label></th>
      <td><input name="Section" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Section']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Controller<span class="label_required">*</span></label></th>
      <td><input name="Controller" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Controller']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Action<span class="label_required">*</span></label></th>
      <td><input name="Action" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Action']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Key<span class="label_required">*</span></label></th>
      <td><input name="Key" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Key']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Value<span class="label_required">*</span></label></th>
      <td><input name="Value" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Value']; ?>" size="80" /></td>
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/metadata/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
