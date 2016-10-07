<?php if ($data['page']['news_add']['error']['count']>0) { ?>
    <?php if ($data['page']['news_add']['error']['CoverImage']!="") { ?>
    <div class="error">Cover Image upload failed (Error: <?php echo $data['page']['news_add']['error']['CoverImage']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['news_add']['ok']==1) { ?>
    <div class="notify">News created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['news_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['news_edit']['error']['CoverImage']!="") { ?>
    <div class="error">Cover Image upload failed (Error: <?php echo $data['page']['news_edit']['error']['CoverImage']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['news_edit']['ok']==1) { ?>
    <div class="notify">News edited successfully.</div>
    <?php } ?>
<?php } ?>
<?php echo Debug::displayArray($data['test']); ?>    
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/news/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post" enctype="multipart/form-data">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Title<span class="label_required">*</span></label></th>
      <td><input name="Title" type="text" class="validate[required] friendly_url" value="<?php echo $data['content'][0]['Title']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Friendly URL<span class="label_required">*</span></label></th>
      <td><input name="FriendlyURL" id="FriendlyURL" type="text" class="validate[required,custom[alphaNumDash]]" value="<?php echo $data['content'][0]['FriendlyURL']; ?>" size="80" /><a href="javascript:void(0);" class="friendly_url">Generate &raquo;</a></td>
    </tr>
    <tr>
      <th scope="row"><label>Date of Article<span class="label_required">*</span></label></th>
      <td><input name="Date" type="text" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo $data['content'][0]['Date']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Source<span class="label_required">*</span></label></th>
      <input name="Language" class="" type="hidden" value="<?php echo $data['config']['DEFAULT_LANGUAGE']; ?>" size="10" />
      <td><input name="Source" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Source']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Cover Image</label></th>
      <td><?php if ($data['content'][0]['CoverImage']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['CoverImageCover']; ?>" height="100" width="100" /><br />
        <label>
        <input name="CoverImageRemove" type="checkbox" id="CoverImageRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="CoverImageCurrent" value="<?php echo $data['content'][0]['CoverImage']; ?>" />
        <input name="CoverImage" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif. For best quality, image must at least be 100px x 100px.)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" rows="5"><?php echo $data['content'][0]['Description']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Content</label></th>
      <td><textarea name="Content" id="Content" class="validate[required] ckeditor" rows="15"><?php echo $data['content'][0]['Content']; ?></textarea></td>
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
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/news/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
    <div id="test"></div>    
    
