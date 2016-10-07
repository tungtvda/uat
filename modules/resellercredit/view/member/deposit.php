<p>Need help? <a style="text-decoration: underline" href="/main/page/how-to-deposit" target="_blank">Visit our tutorial on how to deposit here</a></p>
<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/depositprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Deposit Bank</label></th>
      <td><div style="float: left;"><label><input type="radio" name="bank" value="CIMB" id="cimb" checked=""><div id="CIMB"></div></label></div>
          <div style="float: left;"><label><input type="radio" name="bank" value="MayBank" id="maybank"><div id="MayBank"></div></label></div>
          <div style="float: left;"><label><input type="radio" name="bank" value="PublicBank" id="publicbank"><div id="PublicBank"></div></label></div>
          <div style="float: left;"><label><input type="radio" name="bank" value="HongLeong" id="hongleong"><div id="HongLeong"></div></label></div>
          <!-- <div style="float: left;"><label><input type="radio" name="bank" value="RHB" id="rhbbank"><div id="RHBBank"></div></label></div> -->
      </td>
    </tr>
    <tr>
      <th scope="row"><label>Deposit Details</label></th>
      <td><div id="CIMBDetails"><?php Core::getHook('block-bank-cimb'); ?></div>
          <div id="MayBankDetails" class="invisible"><?php Core::getHook('block-bank-mbb'); ?></div>
          <div id="PublicBankDetails" class="invisible"><?php Core::getHook('block-bank-pbe'); ?></div>
          <div id="HongLeongDetails" class="invisible"><?php Core::getHook('block-bank-hlb'); ?></div>
          <!-- <div id="RHBBankDetails" class="invisible"><?php Core::getHook('block-bank-rhb'); ?></div></td> -->
    </tr>
    <tr>
      <th scope="row"><label>Amount (MYR)<span class="label_required">*</span></label></th>
      <td><input name="Amount" id="Amount" class="validate[required, custom[number], min[10]]" value="" size="10" /></td>
    </tr>
     <tr>
      <th scope="row"><label>Deposit Channel<span class="label_required">*</span></label></th>
      <td><select name="DepositChannel">
            <option value="Internet Banking">Internet Banking</option>
            <option value="ATM Deposit">ATM Deposit</option>
            <option value="CTM Cash Deposit Machine">CTM Cash Deposit Machine</option>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Reference No<span class="label_required">*</span></label></th>
      <td><input name="ReferenceCode" class="validate[required]" value="" size="40" /></td>
    </tr>
     <tr>
      <th scope="row"><label>Date/Time of Deposit<span class="label_required">*</span></label></th>
      <td><input name="DateDeposit" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="25" maxlength="25" readonly/><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Promotion:</th>
      <td>
          <div class="promo_list"><label><input type="radio" name="PromoSpecial" value="None" checked="checked"> None</label></div>
          <?php for ($i=1; $i <= 10 ; $i++) { ?>
              <?php if ($data['content'][$i]!="") { ?>
              <div class="promo_list"><label><input type="radio" name="PromoSpecial" value="<?php Core::getHook('promo-deposit-'.$i); ?>"> <?php Core::getHook('promo-deposit-'.$i); ?></label></div>
              <?php } ?>
          <?php } ?>
      </td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td><label><input type="checkbox" name="promorules" class="validate[required]" value="promorules">&nbsp;&nbsp;I already understand the rules and Deposit Promo Rules if any</label></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Submit" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
<p style="margin: 15px 0;"><?php Core::getHook('block-deposit-bottom'); ?></p>