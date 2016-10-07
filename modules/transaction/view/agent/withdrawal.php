<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/withdrawalprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Balance (MYR)</label></th>
      <td><input name="Balance" type="text" class="text_right" value="<?php echo $data['content']['MainWallet']; ?>" size="8" maxlength="10" readonly /></td>
    </tr>
    <tr>
      <th scope="row"><label>Amount (MYR)</label></th>
      <td><input name="Amount" class="text_right validate[required,custom[number],max[<?php //echo $data['content']['MainWallet']; ?>]]" type="text" value="" size="8" maxlength="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Full Name</label></th>
      <td><input name="FullName" class="" type="text" value="<?php echo $_SESSION['member']['Name']; ?>" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Bank</label></th>
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
      <th scope="row"><label>Bank Account No</label></th>
      <td><input name="BankAccountNo" type="text" value="<?php echo $data['content'][0]['BankAccountNo']; ?>" class="" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Secondary Bank</label></th>
      <td><input name="SecondaryBank" type="text" value="<?php echo $data['content'][0]['SecondaryBank']; ?>" class="" size="30" /></td>
      </tr>
    <tr>
      <th scope="row"><label>Secondary Bank Account No</label></th>
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
      <td><input type="submit" name="submit" value="Submit" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
<?php Core::getHook('block-withdrawal-bottom'); ?>
