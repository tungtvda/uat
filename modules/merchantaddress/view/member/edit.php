<?php if ($data['page']['merchantaddress_add']==1) { ?>
<div class="notify">Merchant Address created successfully.</div>
<?php } ?>
<?php if ($data['page']['merchantaddress_edit']==1) { ?>
<div class="notify">Merchant Address edited successfully.</div>
<?php } ?>
<?php if ($data['page']['merchantaddress_edit']==2) { ?>
<div class="notify">Merchant Address edited, but no changes were made.</div>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantaddress/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Merchant</label></th>
      <td><select name="MerchantID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($data['content_param']['merchant_list'][$i]['ID']==$data['content'][0]['MerchantID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['FirstName']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Title']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street<span class="label_required">*</span></label></th>
      <td><input name="Street" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Street']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street 2<span class="label_required">*</span></label></th>
      <td><input name="Street2" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Street2']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>City<span class="label_required">*</span></label></th>
      <td><input name="City" type="text" class="validate[required]" value="<?php echo $data['content'][0]['City']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>State</label></th>
      <td><select name="State" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>" <?php if ($data['content_param']['state_list'][$i]['ID']==$data['content'][0]['State']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Postcode<span class="label_required">*</span></label></th>
      <td><input name="Postcode" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Postcode']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Country']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No<span class="label_required">*</span></label></th>
      <td><input name="PhoneNo" type="text" class="validate[custom[phoneNo],minSize[9]]" value="<?php echo $data['content'][0]['PhoneNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No<span class="label_required">*</span></label></th>
      <td><input name="FaxNo" type="text" class="validate[custom[faxNo],minSize[9]]" value="<?php echo $data['content'][0]['FaxNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" type="text" class="validate[required,custom[email]]" value="<?php echo $data['content'][0]['Email']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled"  class="chosen_simple">
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantaddress/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
