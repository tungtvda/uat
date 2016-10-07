<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/orderitem/orderaddprocess/<?php echo $data['parent']['id']; ?>" enctype="multipart/form-data" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Price<span class="label_required">*</span></label></th>
      <td><input name="Price" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Quantity<span class="label_required">*</span></label></th>
      <td><input name="Quantity" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled"  class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr> -->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/orderitem/orderindex/<?php echo $data['parent']['id']; ?>"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
