<?php if ($data['page']['merchantaddress_merchantadd']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['merchantaddress_merchantadd']['ok']==1) { ?>
    <div class="notify">Address created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['merchantaddress_merchantedit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['merchantaddress_merchantedit']['ok']==1) { ?>
    <div class="notify">Address edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" enctype="multipart/form-data" action="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantaddress/merchanteditprocess/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Title']; ?>" size="60" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Street<span class="label_required">*</span></label></th>
      <td><input name="Street" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Street']; ?>" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street (Additional Line)</label></th>
      <td><input name="Street2" type="text" class="validate[]" value="<?php echo $data['content'][0]['Street2']; ?>" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>City<span class="label_required">*</span></label></th>
      <td><input name="City" type="text" class="validate[required]" value="<?php echo $data['content'][0]['City']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Postcode<span class="label_required">*</span></label></th>
      <td><input name="Postcode" type="text" class="validate[required, custom[integer], minSize[5]]" value="<?php echo $data['content'][0]['Postcode']; ?>" size="10" maxlength="5" /><span class="label_hint">(e.g. 50000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>State</label></th>
      <td><select name="State" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['state_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['state_list'][$i]['ID']; ?>" <?php if ($data['content_param']['state_list'][$i]['ID']==$data['content'][0]['State']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['state_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>    <tr>
      <th scope="row"><label>Country<span class="label_required">*</span></label></th>
      <td><select name="Country" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Country']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
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
    <?php /* ?><tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled"  class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */ ?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/merchantaddress/merchantindex/<?php echo $data['parent']['id']; ?>">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
