<?php if ($data['page']['wallet_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['wallet_add']['ok']==1) { ?>
    <div class="notify">Wallet created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['wallet_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['wallet_edit']['ok']==1) { ?>
    <div class="notify">Wallet edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_full">
          <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$data['content'][0]['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Product Wallet<span class="label_required">*</span></label></th>
      <td><select name="ProductID">
      	<?php for ($i=0; $i<$data['content'][0]['ProductList']['count']; $i++) { ?>
          <option value="<?php echo $data['content'][0]['ProductList'][$i]['ID']; ?>" <?php if ($data['content'][0]['ProductID']==$data['content'][0]['ProductList'][$i]['ID']) { ?> selected="selected"<?php } ?>><?php echo $data['content'][0]['ProductList'][$i]['Name']; ?></option>
          <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent</label></th>
      <td><select name="AgentID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list'][$i]['ID']==$data['content'][0]['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?> | <?php echo $data['content_param']['agent_list'][$i]['Company']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Pin Number</label></th>
      <td><input name="PIN" id="PIN" type="text" class="validate[]" value="<?php echo $data['content'][0]['PIN'] ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Username</label></th>
      <td><input name="Username" type="text" class="validate[]" value="<?php echo (($data['form_param']['Username']!="") ? $data['form_param']['Username'] : $data['content'][0]['Username']); ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Password</label></th>
      <td><input name="Password" id="Password" type="text" class="validate[]" value="<?php echo $data['content'][0]['Password'] ?>" size="20" /></td>
    </tr>
    <!-- <tr>
      <th scope="row">&nbsp;</th>
      <td><label><input name="NewPassword" id="NewPassword" type="checkbox" value="1" /> Create a new password</label></td>
    </tr>
    <tbody id="NewPasswordBox" class="invisible">
    <tr>
      <th scope="row"><label>New Password<span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" type="password" class="validate[required,minSize[8]]" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm Password<span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required,equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    </tbody> -->
    <tr>
      <th scope="row"><label>Total (MYR)<span class="label_required">*</span></label></th>
      <td><input name="Total" type="text" class="validate[required, custom[number]]" value="<?php echo $data['content'][0]['Total']; ?>" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
