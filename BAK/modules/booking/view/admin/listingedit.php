<?php if ($data['page']['booking_listingadd']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['booking_listingadd']['ok']==1) { ?>
    <div class="notify">Booking created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['booking_listingedit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['booking_listingedit']['ok']==1) { ?>
    <div class="notify">Booking edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/booking/listingeditprocess/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$data['content'][0]['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?></option>
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
      <th scope="row"><label>Special Remarks</label></th>
      <td><textarea name="Remarks" id="Description" class="full_width" rows="5"><?php echo $data['content'][0]['Remarks']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['bookingstatus_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['bookingstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['bookingstatus_list'][$i]['ID']==$data['content'][0]['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['bookingstatus_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Booked<span class="label_required">*</span></label></th>
      <td><input name="DateBooked" type="text" class="datepicker validate[required,custom[dmyDateTime]] disabled mask_date" value="<?php echo $data['content'][0]['DateBooked']; ?>" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Arrival<span class="label_required">*</span></label></th>
      <td><input name="DateArrival" type="text" class="datepicker validate[required,custom[dmyDateTime]] disabled mask_date" value="<?php echo $data['content'][0]['DateArrival']; ?>" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/booking/listingindex/<?php echo $data['parent']['id']; ?>">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
