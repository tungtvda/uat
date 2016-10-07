<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Company<span class="label_required">*</span></label></th>
      <td><input name="Company" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Contact No<span class="label_required">*</span></label></th>
      <td><input name="ContactNo" class="validate[required,custom[phoneNo],minSize[9]]" type="text" value="" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" class="validate[required,custom[email]]" type="text" value="" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Subject<span class="label_required">*</span></label></th>
      <td><input name="Subject" class="validate[required]" type="text" value="" size="60" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Message<span class="label_required">*</span></label></th>
      <td><textarea name="Message" rows="4" class="validate[required] full_width"></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Date Posted<span class="label_required">*</span></label></th>
      <td><input name="DatePosted" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="25" maxlength="19" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['messagestatus_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['messagestatus_list'][$i]['ID']; ?>"><?php echo $data['content_param']['messagestatus_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
