<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderaddprocess/<?php echo $data['parent']['id']; ?>" enctype="multipart/form-data" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>"><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Amount<span class="label_required">*</span></label></th>
      <td><input name="Amount" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Payment Method</label></th>
      <td><select name="PaymentMethod" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['paymentmethod_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['paymentmethod_list'][$i]['ID']; ?>"><?php echo $data['content_param']['paymentmethod_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>"><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Posted<span class="label_required">*</span></label></th>
      <td><input name="DatePosted" class="validate[required,custom[dmyDate]] datepicker mask_date" type="text" value="" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <?php /*?><tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderindex/<?php echo $data['parent']['id']; ?>">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
