<?php if ($data['page']['product_add']['error']['count']>0) { ?>
    <?php if ($data['page']['product_add']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['product_add']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['product_add']['ok']==1) { ?>
    <div class="notify">Product created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['product_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['product_edit']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['product_edit']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['product_edit']['ok']==1) { ?>
    <div class="notify">Product edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell" enctype="multipart/form-data" id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['producttype_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['producttype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['producttype_list'][$i]['ID']==$data['content'][0]['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['producttype_list'][$i]['Label']; ?></option><?php } ?></select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required] friendly_url"  type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="20" /></td>
    </tr>
    <!-- <tr>
    <tr>
      <th scope="row"><label>Play Link<span class="label_required">*</span></label></th>
      <td><input name="PlayLink" class="validate[required]"  type="text" value="<?php echo $data['content'][0]['PlayLink']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Demo Link<span class="label_required">*</span></label></th>
      <td><input name="DemoLink" class="validate[required]"  type="text" value="<?php echo $data['content'][0]['DemoLink']; ?>" size="20" /></td>
    </tr>
    <tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>