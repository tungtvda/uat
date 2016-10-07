<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/dealeraddprocess/<?php echo $data['parent']['id']; ?>" enctype="multipart/form-data" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" class="validate[required]" type="text" value="" size="60" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Street<span class="label_required">*</span></label></th>
      <td><input name="Street" class="validate[required]" type="text" value="" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Street (Additional Line)</label></th>
      <td><input name="Street2" class="validate[]" type="text" value="" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>City<span class="label_required">*</span></label></th>
      <td><input name="City" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Postcode<span class="label_required">*</span></label></th>
      <td><input name="Postcode" class="validate[required, custom[integer], minSize[5]]" type="text" value="" size="10" maxlength="5" /><span class="label_hint">(e.g. 50000)</span></td>
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
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No<span class="label_required">*</span></label></th>
      <td><input name="PhoneNo" class="validate[custom[phoneNo],minSize[9]]" type="text" value="" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No<span class="label_required">*</span></label></th>
      <td><input name="FaxNo" class="validate[custom[faxNo],minSize[9]]" type="text" value="" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" class="validate[required,custom[email]]" type="text" value="" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <?php /* ?><tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled"  class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */ ?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/dealeraddress/dealerindex/<?php echo $data['parent']['id']; ?>"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
