<form name="add_form" class="admin_table_nocell" id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/addprocess" enctype="multipart/form-data" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Agent</label></th>
      <td><select name="AgentID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>"><?php echo $data['content_param']['agent_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Position<span class="label_required">*</span></label></th>
      <td><input name="Position" class="validate[required]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>First</label></th>
      <td><select name="First" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['Value']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
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
      <input type="hidden" id="AddFormPost" name="AddFormPost" value="1" /> <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
