<?php if ($data['page']['translation_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['translation_add']['ok']==1) { ?>
    <div class="notify">Translation created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['translation_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['translation_edit']['ok']==1) { ?>
    <div class="notify">Translation edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/translation/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Language Code<span class="label_required">*</span></label></th>
      <td><input name="LanguageCode" type="text" class="validate[required]" value="<?php echo $data['content'][0]['LanguageCode']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Section<span class="label_required">*</span></label></th>
      <td><input name="Section" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Section']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Original Text<span class="label_required">*</span></label></th>
      <td><input name="OriginalText" type="text" class="validate[required]" value="<?php echo $data['content'][0]['OriginalText']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Translated Text<span class="label_required">*</span></label></th>
      <td><input name="TranslatedText" type="text" class="validate[required]" value="<?php echo $data['content'][0]['TranslatedText']; ?>" size="80" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr> -->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <input type="hidden" id="EditFormPost" name="EditFormPost" value="1" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/translation/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
