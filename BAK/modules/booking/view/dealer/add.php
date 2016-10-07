<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>"><?php echo $data['content_param']['member_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Listing</label></th>
      <td><select name="ListingID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>"><?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No<span class="label_required">*</span></label></th>
      <td><input name="MobileNo" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Pax<span class="label_required">*</span></label></th>
      <td><input name="Pax" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Pass Code<span class="label_required">*</span></label></th>
      <td><input name="PassCode" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Special Remarks</label></th>
      <td><textarea name="Remarks" id="Description" class="full_width" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Booked<span class="label_required">*</span></label></th>
      <td><input name="DateBooked" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Arrival<span class="label_required">*</span></label></th>
      <td><input name="DateArrival" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="20" maxlength="40" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/booking/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
