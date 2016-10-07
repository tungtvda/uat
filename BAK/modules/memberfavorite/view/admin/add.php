<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/memberfavorite/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>"><?php echo $data['content_param']['member_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Listing</label></th>
      <td><select name="ListingID" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['listing_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['listing_list'][$i]['ID']; ?>"><?php echo $data['content_param']['listing_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" /> <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/memberfavorite/index"><input type="button" value="Cancel" class="button" /></a></td>
    </tr>
  </table>
</form>
