<?php if ($data['page']['menuitem_menuadd']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['menuitem_menuadd']['ok']==1) { ?>
    <div class="notify">Menu Item created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['menuitem_menuedit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['menuitem_menuedit']['ok']==1) { ?>
    <div class="notify">Menu Item edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/menuitem/menueditprocess/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Parent ID<span class="label_required">*</span></label></th>
      <td><input name="ParentID" type="text" class="validate[required]" value="<?php echo $data['content'][0]['ParentID']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Title']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Link URL<span class="label_required">*</span></label></th>
      <td><input name="LinkURL" type="text" class="validate[required]" value="<?php echo $data['content'][0]['LinkURL']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Position']; ?>" size="80" /></td>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menuitem/menuindex/<?php echo $data['parent']['id']; ?>">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
