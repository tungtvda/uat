<?php if ($data['page']['order_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['order_add']['ok']==1) { ?>
    <div class="notify">Order created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['order_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['order_edit']['ok']==1) { ?>
    <div class="notify">Order edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_URL']; ?>/admin/order/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Merchant</label></th>
      <td><select name="MerchantID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($data['content_param']['merchant_list'][$i]['ID']==$data['content'][0]['MerchantID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <!--<tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Name']; ?>" size="50" /></td>
    </tr>-->
    <tr>
      <th scope="row"><label>Item<span class="label_required">*</span></label></th>
      <td><input name="Item" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Item']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" rows="5"><?php echo $data['content'][0]['Description']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Subtotal<span class="label_required">*</span></label></th>
      <td><input name="Subtotal" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Subtotal']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Discounts<span class="label_required">*</span></label></th>
      <td><input name="Discounts" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Discounts']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Charges<span class="label_required">*</span></label></th>
      <td><input name="Charges" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Charges']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Shipping<span class="label_required">*</span></label></th>
      <td><input name="Shipping" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Shipping']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Tax<span class="label_required">*</span></label></th>
      <td><input name="Tax" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Tax']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Total<span class="label_required">*</span></label></th>
      <td><input name="Total" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Total']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Dealer Total<span class="label_required">*</span></label></th>
      <td><input name="DealerTotal" class="validate[required]" type="text" value="<?php echo $data['content'][0]['DealerTotal']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Dealer Discount<span class="label_required">*</span></label></th>
      <td><input name="DealerDiscount" class="validate[required]" type="text" value="<?php echo $data['content'][0]['DealerDiscount']; ?>" size="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Order Date<span class="label_required">*</span></label></th>
      <td><input name="OrderDate" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo $data['content'][0]['OrderDate']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Delivery Method</label></th>
      <td><select name="DeliveryMethod" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['deliverymethod_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['deliverymethod_list'][$i]['ID']; ?>" <?php if ($data['content_param']['deliverymethod_list'][$i]['ID']==$data['content'][0]['DeliveryMethod']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['deliverymethod_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Remarks</label></th>
      <td><input name="Remarks" class="validate[required]" type="text" value="<?php echo $data['content'][0]['Remarks']; ?>" size="80" /></td>
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
          <?php for ($i=0; $i<$data['content_param']['orderstatus_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['orderstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['orderstatus_list'][$i]['ID']==$data['content'][0]['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['orderstatus_list'][$i]['Label']; ?></option>
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
        <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/order/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
