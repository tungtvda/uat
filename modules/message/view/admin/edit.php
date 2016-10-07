<?php if ($data['page']['message_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['message_add']['ok']==1) { ?>
    <div class="notify">Message created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['message_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['message_edit']['ok']==1) { ?>
    <div class="notify">Message edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required] disabled" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="40" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Company<span class="label_required">*</span></label></th>
      <td><input name="Company" class="validate[required] disabled" type="text" value="<?php echo $data['content'][0]['Company']; ?>" size="40" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Contact No<span class="label_required">*</span></label></th>
      <td><input name="ContactNo" class="validate[required] disabled" type="text" value="<?php echo $data['content'][0]['ContactNo']; ?>" size="20" maxlength="15" readonly="readonly" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" class="validate[required] disabled" type="text" value="<?php echo $data['content'][0]['Email']; ?>" size="30" readonly="readonly" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Subject<span class="label_required">*</span></label></th>
      <td><input name="Subject" class="validate[required] disabled" type="text" value="<?php echo $data['content'][0]['Subject']; ?>" size="60" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Message<span class="label_required">*</span></label></th>
      <td><textarea name="Message" rows="4" class="validate[required] full_width disabled" readonly="readonly"><?php echo $data['content'][0]['Message']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Date Posted<span class="label_required">*</span></label></th>
      <td><input name="DatePosted" class="validate[required,custom[dmyDateTime]] disabled mask_date" value="<?php echo $data['content'][0]['DatePosted']; ?>" size="25" maxlength="19" readonly="readonly" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['messagestatus_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['messagestatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['messagestatus_list'][$i]['ID']==$data['content'][0]['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['messagestatus_list'][$i]['Label']; ?></option>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
