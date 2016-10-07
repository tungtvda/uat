<img src="http://www.oksys77.com/images/bankinfo9a.jpg" width="800" height="438" /><form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/withdrawalprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Balance (MYR)", "member-withdrawal-balance"); ?></label></th>
      <td><input name="Balance" type="text" class="text_right" value="<?php echo $data['content']['MainWallet']; ?>" size="8" maxlength="10" readonly /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Amount (MYR)", "member-withdrawal-amount"); ?></label></th>
      <td><input name="Amount" class="text_right validate[required,custom[number],max[<?php //echo $data['content']['MainWallet']; ?>]]" type="text" value="" size="8" maxlength="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Full Name", "member-withdrawal-fullname"); ?></label></th>
      <td><input name="FullName" class="disabled" type="text" value="<?php echo $_SESSION['member']['Name']; ?>" readonly="readonly" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank", "member-withdrawal-bank"); ?></label></th>
      <td><input name="Bank" type="text" value="<?php echo $data['content'][0]['Bank']; ?>" class="" size="30" /></td>
      </tr>
    <!-- <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" value="<?php //echo $_SESSION['member']['Username']; ?>" size="10" maxlength="10" readonly/></td>
    </tr>
    <tr>
      <th scope="row"><label>Full Name<span class="label_required">*</span></label></th>
      <td><input name="FullName" type="text" value="<?php //echo $_SESSION['member']['Name']; ?>" size="80" readonly/></td>
    </tr> -->
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank Account No", "member-withdrawal-bankaccountno"); ?></label></th>
      <td><input name="BankAccountNo" type="text" value="<?php echo $data['content'][0]['BankAccountNo']; ?>" class="" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Secondary Bank", "member-withdrawal-secondarybank"); ?></label></th>
      <td><input name="SecondaryBank" type="text" value="<?php echo $data['content'][0]['SecondaryBank']; ?>" class="" size="30" /></td>
      </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank Account No", "member-withdrawal-secondarybankaccountno"); ?></label></th>
      <td><input name="SecondaryBankAccountNo" type="text" value="<?php echo $data['content'][0]['SecondaryBankAccountNo']; ?>" class="" size="30" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Description<span class="label_required">*</span></label></th>
      <td><input name="description" class="validate[required]" value="" size="50" maxlength="50" /></td>
    </tr> -->



    <!-- <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>"><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr> -->
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
      <input type="hidden" id="WithdrawalTrigger" name="WithdrawalTrigger" value="1" />
      <input type="hidden" id="form_token" name="form_token" value="<?php echo $_SESSION['form_token']; ?>" />
      <td><input type="submit" id="Submit" name="submit" value="<?php echo Helper::translate("Submit", "member-withdrawal-submit"); ?>" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
        <input type="button" id="Cancel" value="<?php echo Helper::translate("Cancel", "member-withdrawal-cancel"); ?>" class="button" />
        </a></td>
    </tr>
  </table>
</form>
<?php 

    if($_SESSION['language']=='en')
    {    
        Core::getHook('block-withdrawal-bottom'); 
    }
    elseif($_SESSION['language']=='ms')
    {
        Core::getHook('block-withdrawal-bottom-ms');
    }
    elseif($_SESSION['language']=='zh_CN')
    {
        Core::getHook('block-withdrawal-bottom-zh-cn');
    }    


?>
