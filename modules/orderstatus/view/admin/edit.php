<?php if ($data['page']['orderstatus_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['orderstatus_add']['ok']==1) { ?>
    <div class="notify">Order Status created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['orderstatus_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['orderstatus_edit']['ok']==1) { ?>
    <div class="notify">Order Status edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/orderstatus/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Label<span class="label_required">*</span></label></th>
      <td><input name="Label" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Label']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Background Color<span class="label_required">*</span></label></th>
      <td><input name="BGColor" type="text" class="validate[required] cpicker" value="<?php echo $data['content'][0]['BGColor']; ?>" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Color<span class="label_required">*</span></label></th>
      <td><input name="Color" type="text" class="validate[required] cpicker" value="<?php echo $data['content'][0]['Color']; ?>" size="10" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/orderstatus/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
