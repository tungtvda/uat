<?php if ($data['page']['tax_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['tax_add']['ok']==1) { ?>
    <div class="notify">Tax created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['tax_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['tax_edit']['ok']==1) { ?>
    <div class="notify">Tax edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" enctype="multipart/form-data" action="<?php echo $data['config']['SITE_URL']; ?>/admin/tax/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Region</label></th>
      <td><select name="RegionID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['region_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['region_list'][$i]['ID']; ?>" <?php if ($data['content_param']['region_list'][$i]['ID']==$data['content'][0]['RegionID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['region_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Amount<span class="label_required">*</span></label></th>
      <td><input name="Amount" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Amount']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/tax/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
