<?php if ($data['page']['state_countryadd']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['state_countryadd']['ok']==1) { ?>
    <div class="notify">State created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['state_countryedit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['state_countryedit']['ok']==1) { ?>
    <div class="notify">State edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" enctype="multipart/form-data" action="<?php echo $data['config']['SITE_URL']; ?>/admin/state/countryeditprocess/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/state/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
