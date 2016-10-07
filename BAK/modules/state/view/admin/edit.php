<?php if ($data['page']['state_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['state_add']['ok']==1) { ?>
    <div class="notify">State created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['state_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['state_edit']['ok']==1) { ?>
    <div class="notify">State edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/state/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="CountryID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['CountryID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/state/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
