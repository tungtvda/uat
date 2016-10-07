<?php if ($data['page']['transaction_orderadd']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['transaction_orderadd']['ok']==1) { ?>
    <div class="notify">Transaction created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['transaction_orderedit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['transaction_orderedit']['ok']==1) { ?>
    <div class="notify">Transaction edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell" id="edit_form" enctype="multipart/form-data" action="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/ordereditprocess/<?php echo $data['parent']['id']; ?>,<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactiontype_list'][$i]['ID']==$data['content'][0]['TypeID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Amount<span class="label_required">*</span></label></th>
      <td><input name="Amount" type="text" class="validate[required]" value="<?php echo $data['content'][0]['Amount']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Payment Method</label></th>
      <td><select name="PaymentMethod" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['paymentmethod_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['paymentmethod_list'][$i]['ID']; ?>" <?php if ($data['content_param']['paymentmethod_list'][$i]['ID']==$data['content'][0]['PaymentMethod']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['paymentmethod_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['ID']==$data['content'][0]['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date Posted<span class="label_required">*</span></label></th>
      <td><input name="DatePosted" type="text" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo $data['content'][0]['DatePosted']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <?php /*?><tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['content'][0]['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/transaction/orderindex/<?php echo $data['parent']['id']; ?>">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
