<?php if ($data['page']['region_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['region_add']['ok']==1) { ?>
    <div class="notify">region created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['region_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['region_edit']['ok']==1) { ?>
    <div class="notify">Region edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/region/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Country']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <th scope="row"><label>State</label></th>
      <td><select name="State" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>" <?php if ($data['content_param']['state_list'][$i]['ID']==$data['content'][0]['State']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select>
      </td>
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/region/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
