<?php if ($data['page']['memberwishlist_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['memberwishlist_add']['ok']==1) { ?>
    <div class="notify">Member Wishlist created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['memberwishlist_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['memberwishlist_edit']['ok']==1) { ?>
    <div class="notify">Member Wishlist edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/memberwishlist/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Product</label></th>
      <td><select name="ProductID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['product_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['product_list'][$i]['ID']; ?>" <?php if ($data['content_param']['product_list'][$i]['ID']==$data['content'][0]['ProductID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['product_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Posted<span class="label_required">*</span></label></th>
      <td><input name="DatePosted" type="text" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo $data['content'][0]['DatePosted']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr> -->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/memberwishlist/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
