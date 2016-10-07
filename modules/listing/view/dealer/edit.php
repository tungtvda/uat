<?php if ($data['page']['listing_add']['error']['count']>0) { ?>
    <?php if ($data['page']['listing_add']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['listing_add']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['listing_add']['ok']==1) { ?>
    <div class="notify">Listing created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['listing_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['listing_edit']['error']['ImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['listing_edit']['error']['ImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['listing_edit']['ok']==1) { ?>
    <div class="notify">Listing edited successfully.</div>
    <?php } ?>
<?php } ?>

<?php if ($data['page']['listing_add']['error']['count']>0) { ?>
    <?php if ($data['page']['listing_add']['error']['BrandImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['listing_add']['error']['BrandImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['listing_add']['ok']==1) { ?>
    <div class="notify">Listing created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['listing_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['listing_edit']['error']['BrandImageURL']!="") { ?>
    <div class="error">Image upload failed (Error: <?php echo $data['page']['listing_edit']['error']['BrandImageURL']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['listing_edit']['ok']==1) { ?>
    <div class="notify">Listing edited successfully.</div>
    <?php } ?>
<?php } ?>
<form action="<?php echo $data['config']['SITE_URL']; ?>/dealer/listing/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data" name="edit_form" class="admin_table_nocell"  id="edit_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Merchant</label></th>
      <td><select name="MerchantID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if($data['content_param']['merchant_list'][$i]['TypeID'] !=1){ ?><?php if ($data['content_param']['merchant_list'][$i]['ID']==$data['content'][0]['MerchantID']) { ?> selected="selected"<?php } ?><?php }else{ ?>disabled="disabled"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['ID']; ?> - <?php echo $data['content_param']['merchant_list'][$i]['Name']; ?> - <?php echo $data['content_param']['merchant_list'][$i]['TypeLabel']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['listingtype_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['listingtype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingtype_list'][$i]['ID']==$data['content'][0]['TypeID']) { ?> selected="selected"<?php } ?>><?php //echo $data['content_param']['listingtype_list'][$i]['ID']; ?><?php echo $data['content_param']['listingtype_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Filter</label></th>
      <td><select name="FilterID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['listingfilter_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['listingfilter_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingfilter_list'][$i]['ID']==$data['content'][0]['FilterID']) { ?> selected="selected"<?php } ?>><?php //echo $data['content_param']['listingfilter_list'][$i]['ID']; ?><?php echo $data['content_param']['listingfilter_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Filter Alt</label></th>
      <td><select name="Filter2ID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['listingfiltertwo_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listingfiltertwo_list'][$i]['ID']==$data['content'][0]['Filter2ID']) { ?> selected="selected"<?php } ?>><?php //echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?><?php echo $data['content_param']['listingfiltertwo_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="80" /></td>
    </tr> 
    <tr>
      <th scope="row"><label>Brand Name<span class="label_required">*</span></label></th>
      <td><input name="BrandName" type="text" class="validate[required]" value="<?php echo $data['content'][0]['BrandName']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Brand Image</label></th>
      <td><?php if ($data['content'][0]['BrandImageURL']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['BrandImageURLCover']; ?>" height="66" width="66" /><br />
        <label>
        <input name="BrandImageURLRemove" type="checkbox" id="BrandImageURLRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="BrandImageURLCurrent" value="<?php echo $data['content'][0]['BrandImageURL']; ?>" />
        <input name="BrandImageURL" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" rows="5"><?php echo $data['content'][0]['Description']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Image</label></th>
      <td><?php if ($data['content'][0]['ImageURL']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['ImageURLCover']; ?>" height="66" width="66" /><br />
        <label>
        <input name="ImageURLRemove" type="checkbox" id="ImageURLRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="ImageURLCurrent" value="<?php echo $data['content'][0]['ImageURL']; ?>" />
        <input name="ImageURL" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Street<span class="label_required">*</span></label></th>
      <td><input name="Street1" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Street1']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street Alt<span class="label_required">*</span></label></th>
      <td><input name="Street2" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Street2']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>City<span class="label_required">*</span></label></th>
      <td><input name="City" type="text" class="validate[required]" value="<?php echo $data['content'][0]['City']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Postcode<span class="label_required">*</span></label></th>
      <td><input name="Postcode" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Postcode']; ?>" size="20" /></td>
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
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Country']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Map X<span class="label_required">*</span></label></th>
      <td><input name="MapX" type="text" class="validate[required]" value="<?php echo $data['content'][0]['MapX']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Map Y<span class="label_required">*</span></label></th>
      <td><input name="MapY" type="text" class="validate[required]" value="<?php echo $data['content'][0]['MapY']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No<span class="label_required">*</span></label></th>
      <td><input name="PhoneNo" type="text" class="validate[custom[phoneNo],minSize[9]]" value="<?php echo $data['content'][0]['PhoneNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/listing/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
