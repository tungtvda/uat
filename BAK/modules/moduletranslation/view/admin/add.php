<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Module</label></th>
      <td><select name="ModuleID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['module_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['module_list'][$i]['ID']; ?>"><?php echo $data['content_param']['module_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Language</label></th>
      <td><select name="LanguageID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['language_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['language_list'][$i]['ID']; ?>"><?php echo $data['content_param']['language_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Row ID<span class="label_required">*</span></label></th>
      <td><input name="RowID" class="validate[required]" type="text" value="" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Content</label></th>
      <td><textarea name="Content" id="Content" class="full_width" rows="5"></textarea></td>
    </tr>
    <?php /*?><tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
        <input type="hidden" id="AddFormPost" name="AddFormPost" value="1" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
