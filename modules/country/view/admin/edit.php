<?php if ($data['page']['country_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['country_add']['ok']==1) { ?>
    <div class="notify">Country created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['country_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['country_edit']['ok']==1) { ?>
    <div class="notify">Country edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/country/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/country/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
