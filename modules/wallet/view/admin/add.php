<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_full">
            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>"><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Product Wallet<span class="label_required">*</span></label></th>
      <td><select name="ProductID" class="chosen">
            <?php for ($i=0; $i<$data['content']['count']; $i++) { ?>
            <option value="<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent</label></th>
      <td><select name="AgentID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>"><?php echo $data['content_param']['agent_list'][$i]['Name']; ?> | <?php echo $data['content_param']['agent_list'][$i]['Company']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Pin Number</label></th>
      <td><input name="PIN" id="PIN" class="validate[]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Username</label></th>
      <td><input name="Username" class="validate[]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Password</label></th>
      <td><input name="Password" id="Password" class="validate[]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Total (MYR)<span class="label_required">*</span></label></th>
      <td><input name="Total" class="validate[required, custom[number]]" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
