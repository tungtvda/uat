<form action="<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/addprocess" method="post" enctype="multipart/form-data" name="add_form" class="admin_table_nocell"  id="add_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Merchant</label></th>
      <td><select name="MerchantID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>"><?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['listingtype_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['listingtype_list'][$i]['ID']; ?>"><?php //echo $data['content_param']['listingtype_list'][$i]['ID']; ?><?php echo $data['content_param']['listingtype_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Filter</label></th>
      <td><select name="FilterID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['listingfilter_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['listingfilter_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingfilter_list'][$i]['ID']==$_SESSION['listing_AdminIndex']['param']['FilterID']) { ?> selected="selected"<?php } ?>><?php //echo $data['content_param']['listingfilter_list'][$i]['ID']; ?><?php echo $data['content_param']['listingfilter_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Filter Alt</label></th>
      <td><select name="Filter2ID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['listingfiltertwo_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingfiltertwo_list'][$i]['ID']==$_SESSION['listing_AdminIndex']['param']['Filter2ID']) { ?> selected="selected"<?php } ?>><?php //echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?><?php echo $data['content_param']['listingfiltertwo_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Brand Name<span class="label_required">*</span></label></th>
      <td><input name="BrandName" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Brand Image</label></th>
      <td><input name="BrandImageURL" type="file" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Image</label></th>
      <td><input name="ImageURL" type="file" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Street<span class="label_required">*</span></label></th>
      <td><input name="Street1" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street Alt<span class="label_required">*</span></label></th>
      <td><input name="Street2" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>City<span class="label_required">*</span></label></th>
      <td><input name="City" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Postcode<span class="label_required">*</span></label></th>
      <td><input name="Postcode" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>State</label></th>
      <td><select name="State" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>"><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']=='151') { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Map X<span class="label_required">*</span></label></th>
      <td><input name="MapX" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Map Y<span class="label_required">*</span></label></th>
      <td><input name="MapY" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No<span class="label_required">*</span></label></th>
      <td><input name="PhoneNo" class="validate[custom[phoneNo],minSize[9]]" type="text" value="" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
