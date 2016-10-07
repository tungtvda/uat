<?php if ($data['page']['booking_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['booking_add']['ok']==1) { ?>
    <div class="notify">Booking created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['booking_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['booking_edit']['ok']==1) { ?>
    <div class="notify">Booking edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$data['content'][0]['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Listing</label></th>
      <td><select name="ListingID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listing_list'][$i]['ID']==$data['content'][0]['ListingID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No<span class="label_required">*</span></label></th>
      <td><input name="MobileNo" type="text" class="validate[required]" value="<?php echo $data['content'][0]['MobileNo']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Pax<span class="label_required">*</span></label></th>
      <td><input name="Pax" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Pax']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Pass Code<span class="label_required">*</span></label></th>
      <td><input name="PassCode" type="text" class="validate[required]" value="<?php echo $data['content'][0]['PassCode']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Special Remarks</label></th>
      <td><textarea name="Remarks" id="Description" class="full_width" rows="5"><?php echo $data['content'][0]['Remarks']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Booked<span class="label_required">*</span></label></th>
      <td><input name="DateBooked" type="text" class="validate[required,custom[dmyDateTime]] disabled mask_date" value="<?php echo $data['content'][0]['DateBooked']; ?>" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Arrival<span class="label_required">*</span></label></th>
      <td><input name="DateArrival" type="text" class="validate[required,custom[dmyDateTime]] disabled mask_date" value="<?php echo $data['content'][0]['DateArrival']; ?>" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
