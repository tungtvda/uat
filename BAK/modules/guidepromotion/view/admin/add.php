<form action="<?php echo $data['config']['SITE_DIR']; ?>/admin/guidepromotion/addprocess" method="post" enctype="multipart/form-data" name="add_form" class="admin_table_nocell"  id="add_form">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Agent<span class="label_required">*</span></label></th>
      <td><select name="AgentID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list'][$i]['ID']==$_SESSION['bankinfo_AdminIndex']['param']['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>  
    <tr>
      <th scope="row"><label>Image<span class="label_required">*</span></label></th>
      <td><input name="ImageURL" type="file" class="validate[required]" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 709px x 1181px.)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>URL</label></th>
      <td><input name="Description" type="text" class="validate[]" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required,custom[integer]]" type="text" value="" size="3" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled<span class="label_required">*</span></label></th>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/guidepromotion/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
