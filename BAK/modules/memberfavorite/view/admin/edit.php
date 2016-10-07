<?php if ($data['page']['memberfavorite_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['memberfavorite_add']['ok']==1) { ?>
    <div class="notify">Member Favorite created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['memberfavorite_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['memberfavorite_edit']['ok']==1) { ?>
    <div class="notify">Member Favorite edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/memberfavorite/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>" <?php if ($data['content_param']['member_list'][$i]['ID']==$data['content'][0]['MemberID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['member_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Listing</label></th>
      <td><select name="ListingID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>" <?php if ($data['content_param']['listing_list'][$i]['ID']==$data['content'][0]['ListingID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/memberfavorite/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
