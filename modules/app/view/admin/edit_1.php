<?php if ($data['page']['app_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['app_add']['ok']==1) { ?>
    <div class="notify">App created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['app_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['app_edit']['ok']==1) { ?>
    <div class="notify">App edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/app/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>App Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>IP Address</th>
      <td><input name="IPAddress" type="text" class="validate[custom[ipv4]]" value="<?php echo $data['content'][0]['IPAddress']; ?>" size="20" /><span class="label_hint">(e.g. 127.0.0.1)</span><br /><span class="label_hint">(If entered, the system will only accept requests from this IP address)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><label><input name="NewCredentials" id="NewCredentials" type="checkbox" value="1" /> Regenerate app ID and app secret</label><br /><span class="label_hint">(Beware: This action cannot be undone)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/app/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
