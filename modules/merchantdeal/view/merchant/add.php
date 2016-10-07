<form action="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchantdeal/addprocess" method="post" enctype="multipart/form-data" name="add_form" class="admin_table_nocell"  id="add_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Listing</label></th>
      <td><select name="ListingID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listing_list'][$i]['ID']==$_SESSION['merchantdeal_MerchantIndex']['param']['ListingID']) { ?> selected="selected"<?php } ?>><?php //echo $data['content_param']['listing_list'][$i]['ID']; ?><?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Image</label></th>
      <td><input name="ImageURL" type="file" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Expiry<span class="label_required">*</span></label></th>
      <td><input name="DateExpiry" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
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
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchantdeal/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
