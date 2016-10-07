<?php if ($data['page']['config_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['config_add']['ok']==1) { ?>
    <div class="notify">Config created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['config_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['config_edit']['ok']==1) { ?>
    <div class="notify">Config edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/config/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Config Name</label></th>
      <td><input name="ConfigName" type="text" class="validate[required]" value="<?php echo $data['content'][0]['ConfigName']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Config Value</label></th>
      <td><input name="ConfigValue" type="text" value="<?php echo $data['content'][0]['ConfigValue']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/config/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
