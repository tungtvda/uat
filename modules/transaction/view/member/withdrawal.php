<?php if($_SESSION['superid']=='1'){ ?>
<?php if ($data['config']['ANNOUNCEMENT_WITHDRAWAL']=='1') { ?>
<div id="announcement_popup" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    
    <?php if($_SESSION['language']=='en')
    {    
        //Core::getHook('block-withdrawal-bottom'); 
        echo $data['agentblock'][0]['Content'];
    }
    elseif($_SESSION['language']=='ms')
    {
        //Core::getHook('block-withdrawal-bottom-ms');
         echo $data['agentblock'][0]['Content']; 
    }
    elseif($_SESSION['language']=='zh_CN')
    {
        //Core::getHook('block-withdrawal-bottom-zh-cn');
        echo $data['agentblock'][0]['Content'];
    }
    ?>
    
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<?php } ?>
<br>
<div id="member_withdrawal_wrapper">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns">
            <img src="http://www.topsys777.com/images/bankinfo9a.jpg" width="0" height="0" />
        </div>
        <div class="small-12 medium-12 large-12 end columns">
            <form id="add_form" name="add_form" class="common_block common_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/withdrawalprocess">
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Balance" class="inline"><?php echo Helper::translate("Balance (MYR)", "member-withdrawal-balance"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="Balance" id="Balance" class="text-right disabled" value="<?php echo $data['content']['MainWallet']; ?>" readonly="readonly" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Amount" class="inline"><?php echo Helper::translate("Amount (MYR)", "member-withdrawal-amount"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="Amount" id="Amount" class="text-right validate[required,custom[number],max[<?php //echo $data['content']['MainWallet']; ?>]]" value="" maxlength="10" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="FullName" class="inline"><?php echo Helper::translate("Full Name", "member-withdrawal-fullname"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="FullName" id="FullName" class="disabled" value="<?php echo $_SESSION['member']['Name']; ?>" readonly="readonly" />
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Bank" class="inline"><?php echo Helper::translate("Bank", "member-withdrawal-bank"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="Bank" id="Bank" class="disabled" value="<?php echo $data['content'][0]['Bank']; ?>" readonly="readonly" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="BankAccountNo" class="inline"><?php echo Helper::translate("Bank Account No", "member-withdrawal-bankaccountno"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="BankAccountNo" id="BankAccountNo" class="disabled" value="<?php echo $data['content'][0]['BankAccountNo']; ?>" readonly="readonly" />
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="small-12 medium-12 large-9 large-offset-3 columns">
                        <input type="hidden" id="WithdrawalTrigger" name="WithdrawalTrigger" value="1" />
                        <input type="hidden" id="form_token" name="form_token" value="<?php echo $_SESSION['form_token']; ?>" />

                        <input class="button" type="submit" name="submit" id="submit" value="<?php echo Helper::translate("Submit", "member-withdrawal-submit"); ?>" />
                        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
                            <input type="button" id="Cancel" value="<?php echo Helper::translate("Cancel", "member-withdrawal-cancel"); ?>" class="button" />
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div>
    <?php echo $data['agentblock'][2]['Content']; ?>
</div>
<?php 

    if($_SESSION['language']=='en')
    {    
        //Core::getHook('block-withdrawal-bottom'); 
    }
    elseif($_SESSION['language']=='ms')
    {
        //Core::getHook('block-withdrawal-bottom-ms');
    }
    elseif($_SESSION['language']=='zh_CN')
    {
        //Core::getHook('block-withdrawal-bottom-zh-cn');
    }    

    //echo $data['agentblock'][1]['Content'];

?>
<?php } else { ?>

<br><?php echo $data['agentblock'][0]['Content']; ?><form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/withdrawalprocess" method="post">
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
      <td><input name="Bank" type="text" class="disabled" value="<?php echo $data['content'][0]['Bank']; ?>" class="" size="30" readonly="readonly" /></td>
      </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Bank Account No", "member-withdrawal-bankaccountno"); ?></label></th>
      <td><input name="BankAccountNo" class="disabled" type="text" value="<?php echo $data['content'][0]['BankAccountNo']; ?>" size="30" readonly="readonly" /></td>
    </tr>
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

<div>
    <?php echo $data['agentblock'][2]['Content']; ?>
</div>
<?php 

    if($_SESSION['language']=='en')
    {    
        //Core::getHook('block-withdrawal-bottom'); 
    }
    elseif($_SESSION['language']=='ms')
    {
        //Core::getHook('block-withdrawal-bottom-ms');
    }
    elseif($_SESSION['language']=='zh_CN')
    {
        //Core::getHook('block-withdrawal-bottom-zh-cn');
    }    

    echo $data['agentblock'][1]['Content'];

?>



<?php } ?>

