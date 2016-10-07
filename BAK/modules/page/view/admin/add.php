<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/page/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
  	<tr>
      <th scope="row"><label>Category</label></th>
      <td><select name="CategoryID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['pagecategory_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['pagecategory_list'][$i]['ID']; ?>"><?php echo $data['content_param']['pagecategory_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" class="validate[required] friendly_url" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Meta Keyword<span class="label_required">*</span></label></th>
      <td><input name="MetaKeyword" class="validate[required] friendly_url" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Heading<span class="label_required">*</span></label></th>
      <td><input name="Heading" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Friendly URL</label></th>
      <td><input name="FriendlyURL" id="FriendlyURL" class="validate[required,custom[alphaNumDash]]" type="text" value="" size="80" /><a href="javascript:void(0);" class="friendly_url">Generate &raquo;</a></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="validate[required] full_width" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Content</label></th>
      <td><textarea name="Content" id="Content" class="validate[required] ckeditor" rows="15"></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Template</label></th>
      <td><select name="TemplateID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['template_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['template_list'][$i]['ID']; ?>"><?php echo $data['content_param']['template_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Posted<span class="label_required">*</span></label></th>
      <td><input name="DatePosted" class="validate[required,custom[dmyDate]] datepicker mask_date" type="text" value="<?php echo date("d-m-Y"); ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['pagestatus_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['pagestatus_list'][$i]['ID']; ?>"><?php echo $data['content_param']['pagestatus_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <?php /*?><tr>
      <th scope="row"><label>Last Updated</label></th>
      <td><input name="LastUpdated" class="validate[required] datepicker" type="text" value="" size="10" readonly="readonly" />
      (dd-mm-yyyy)</td>
    </tr><?php*/ ?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/page/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
