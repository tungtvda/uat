<?php if($_SESSION['superid']=='1'){ ?>
<?php if ($data['config']['ANNOUNCEMENT_DEPOSIT']=='1') { ?>

<div id="announcement_popup" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    
    <?php if($_SESSION['language']=='en')
    {    
        //Core::getHook('block-deposit-bottom'); 
        echo $data['agentblock'][0]['Content'];
    }
    elseif($_SESSION['language']=='ms')
    {
        //Core::getHook('block-deposit-bottom-ms');
         echo $data['agentblock'][0]['Content'];
    }   
    elseif($_SESSION['language']=='zh_CN')
    {
        //Core::getHook('block-deposit-bottom-zh-cn');
         echo $data['agentblock'][0]['Content'];
    }
    ?>
    
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<?php } ?>
<br><!-- <p>Need help? <a style="text-decoration: underline" href="/main/page/how-to-deposit" target="_blank">Visit our tutorial on how to deposit here</a></p> -->
<div id="member_deposit_wrapper">
    <div class="row">
<!--        <div class="small-12 medium-12 large-12 columns">
            
            <img src="http://www.topsys777.com/images/cimb8.gif" width="100" height="100" />
        </div>-->
        <div class="small-12 medium-12 large-12 end columns">
            <form id="add_form" name="add_form" class="common_block common_form" method="post" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/depositprocess">
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="bank" class="inline"><?php echo Helper::translate("Deposit Bank", "member-deposit-depositbank"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <?php if($data['content_param']['bank_info']['count'] > 0){ ?>
                        <?php for ($i = 0; $i < $data['content_param']['bank_info']['count']; $i++) { ?>
                            <div style="float: left;"><label><input type="radio" name="bank" value="<?php echo $data['content_param']['bank_info'][$i]['Name']; ?>" id="<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?>" <?php if($i===0){ ?>checked=""<?php } ?>><div class="BankImage"><img src="<?php echo $data['content_param']['bank_info'][$i]['ImageURL']; ?>"></div></label></div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Amount" class="inline"><br /><?php echo Helper::translate("Deposit Details", "member-deposit-details"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <?php if($data['content_param']['bank_info']['count'] > 0){ ?>
                        <?php for ($i = 0; $i < $data['content_param']['bank_info']['count']; $i++) { ?>
                            <div class="<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?> <?php if($i!==0){ ?>disappear<?php } ?>"><?php echo $data['content_param']['bank_info'][$i]['Description']; ?></div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="DepositAmount" class="inline"><?php echo Helper::translate("Amount", "member-deposit-amount"); ?> (MYR)<span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="DepositAmount" id="DepositAmount" class="validate[required, custom[number], min[10]]" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="Bank" class="inline"><?php echo Helper::translate("Deposit Channel", "member-deposit-channel"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <select name="DepositChannel" class="validate[required]">
                            <option value="">- <?php echo Helper::translate("Please select one", "member-deposit-selectone"); ?> -</option>
                            <option value="Internet Banking"><?php echo Helper::translate("Internet Banking", "member-deposit-internetbanking"); ?></option>
                            <option value="ATM Deposit"><?php echo Helper::translate("ATM Deposit", "member-deposit-atmdeposit"); ?></option>
                            <option value="CTM Cash Deposit Machine"><?php echo Helper::translate("CTM Cash Deposit Machine", "member-deposit-ctmcashdepositmachine"); ?></option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="ReferenceCode" class="inline"><?php echo Helper::translate("Reference No", "member-deposit-referenceno"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="ReferenceCode" id="ReferenceCode" class="validate[required]" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="DateDeposit" class="inline"><?php echo Helper::translate("Date/Time of Deposit", "member-deposit-datetime"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="DateDeposit" id="DateDeposit" class="validate[required,custom[dmyDateTime]] datepicker mask_date" placeholder="(dd-mm-yyyy hh:mm:ss)" maxlength="25" readonly="readonly" style="background-color: #fff !important;" />
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        &nbsp;
                    </div>
                    <div class="small-12 medium-8 large-6 end columns yellow">
                        <?php echo Helper::translate("For fast processing, please select your choice of bank slip submit to us as below", "member-deposit-fastprocessnote"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="SecondaryBankAccountNo" class="inline"><?php echo Helper::translate("Submit Bank Slip Through", "member-deposit-bankinslip"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <select name="BankSlip" id="BankSlip" class="chosen_simple">
                            <option value="">- <?php echo Helper::translate("Please select one", "member-deposit-selectone"); ?> -</option>
                            <?php for ($i=0; $i<$data['content_param']['bank_slip']['count']; $i++) { ?>
                            <option value="<?php echo $data['content_param']['bank_slip'][$i]['Label']; ?>"><?php //echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?><?php echo $data['content_param']['bank_slip'][$i]['Label']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="ReferenceCode" class="inline"><?php echo Helper::translate("Promotion:", "member-deposit-promotion"); ?><span class="label_required">*</span></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <select name="PromoSpecial">
                            <option value="None"><?php echo Helper::translate("None", "member-deposit-none"); ?></option>                                                           
                            <?php for ($i=0; $i<$data['content_param']['promotion_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['promotion_list'][$i]['Title']; ?>"><?php echo $data['content_param']['promotion_list'][$i]['Title']; ?></option>
                <?php } ?>                                                   
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        &nbsp;
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <label><input type="checkbox" name="promorules" class="validate[required]" value="promorules">&nbsp;&nbsp;<?php echo Helper::translate("I already understand the rules and Deposit Promo Rules if any", "member-deposit-rule"); ?></label>
                    </div>
                </div>
                <hr />
                <div id="transferheader"><?php echo Helper::translate("Transfer", "member-deposit-transfer"); ?><br />&nbsp;</div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="TransferTo" class="inline"><label><?php echo Helper::translate("Transfer To", "member-transfer-to"); ?></label></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <select class="nonmainwallet" id="TransferTo" name="TransferTo">
                            <?php for ($i=0; $i<$data['nonmainwallet']['count']; $i++) { ?>
                            <option value="<?php echo $data['nonmainwallet'][$i]['ID']; ?>"><?php echo $data['nonmainwallet'][$i]['Name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-12 large-3 columns">
                        <label for="TransferAmount" class="inline"><?php echo Helper::translate("Amount (MYR)", "member-transfer-amount"); ?></label>
                    </div>
                    <div class="small-12 medium-8 large-6 end columns">
                        <input type="text" name="TransferAmount" id="TransferAmount" class="validate[custom[number], min[10]]" placeholder="<?php echo Helper::translate("(Minimum MYR 10.00)", "member-transfer-minimum-amount"); ?>" />
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="small-12 medium-12 large-9 large-offset-3 columns">
                        <input type="hidden" id="DepositTrigger" name="DepositTrigger" value="1" />
                        <input type="hidden" id="form_token" name="form_token" value="<?php echo $_SESSION['form_token']; ?>" />

                        <input class="button" type="submit" name="submit" id="Submit" value="<?php echo Helper::translate("Save", "member-transfer-save"); ?>" />
                        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
                            <input type="button" id="Cancel" value="<?php echo Helper::translate("Cancel", "member-transfer-cancel"); ?>" class="button" />
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

<p style="margin: 15px 0;"><?php //Core::getHook('block-deposit-bottom'); ?>
<?php 

     
    
    //echo $data['agentblock'][1]['Content'];


?>
</p>
<?php } else { ?>
<br><?php echo $data['agentblock'][0]['Content']; ?><!-- <p>Need help? <a style="text-decoration: underline" href="/main/page/how-to-deposit" target="_blank">Visit our tutorial on how to deposit here</a></p> -->
<div id="depositformcontainer">
<?php //echo $_SESSION['language']; ?>
   
<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/depositprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row" style="vertical-align: top;"><label><?php echo Helper::translate("Deposit Bank", "member-deposit-depositbank"); ?></label></th>
      <td>
          <?php if($data['content_param']['bank_info']['count'] > 0){ ?>
              <?php for ($i = 0; $i < $data['content_param']['bank_info']['count']; $i++) { ?>                              
                <div style="float: left;"><label><input type="radio" name="bank" value="<?php echo $data['content_param']['bank_info'][$i]['Name']; ?>" id="<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?>" <?php if($i===0){ ?>checked=""<?php } ?>><div class="BankImage"><img src="<?php echo $data['content_param']['bank_info'][$i]['ImageURL']; ?>"></div></label></div>
              <?php } ?>
          <?php } ?>                    
      </td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align: top;"><label><?php echo Helper::translate("Deposit Details", "member-deposit-details"); ?></label></th>
      <td>
          <?php if($data['content_param']['bank_info']['count'] > 0){ ?>
              <?php for ($i = 0; $i < $data['content_param']['bank_info']['count']; $i++) { ?>                              
          <div class="<?php echo str_replace(' ', '', $data['content_param']['bank_info'][$i]['Name']); ?><?php if($i!==0){ ?> invisible<?php } ?>"><?php echo $data['content_param']['bank_info'][$i]['Description']; ?></div>
              <?php } ?>
          <?php } ?></td>
          
          
<!--          <div id="CIMBDetails"><?php Core::getHook('block-bank-cimb'); ?></div>
          <div id="MayBankDetails" class="invisible"><?php Core::getHook('block-bank-mbb'); ?></div>
          <div id="PublicBankDetails" class="invisible"><?php Core::getHook('block-bank-pbe'); ?></div>
          <div id="HongLeongDetails" class="invisible"><?php Core::getHook('block-bank-hlb'); ?></div>-->
          <?php /*if($data['config']['BANK_LOGO_1'] == '1'){ ?>

          <div id="Bank1Details" class="invisible"><?php Core::getHook('block-bank-1'); ?></div>
          <?php } ?>
          <?php if($data['config']['BANK_LOGO_2'] == '1'){ ?>

          <div id="Bank2Details" class="invisible"><?php Core::getHook('block-bank-2'); ?></div>
          <?php } ?>
          <?php if($data['config']['BANK_LOGO_3'] == '1'){ ?>
          <div id="Bank3Details" class="invisible"><?php Core::getHook('block-bank-3'); ?></div>
          <?php } ?>
          <?php if($data['config']['BANK_LOGO_4'] == '1'){ ?>
          <div id="RHBBankDetails" class="invisible"><?php Core::getHook('block-bank-rhb'); ?></div></td>
          <?php }*/ ?>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Amount", "member-deposit-amount"); ?> (MYR)<span class="label_required">*</span></label></th>
      <td><input name="DepositAmount" id="DepositAmount" class="validate[required, custom[number], min[10]]" value="" size="10" /><span class="label_hint">(Minimum MYR 30.00)</span></td>
    </tr>
     <tr>
      <th scope="row"><label><?php echo Helper::translate("Deposit Channel", "member-deposit-channel"); ?><span class="label_required">*</span></label></th>
      <td><select name="DepositChannel" class="validate[required]">
            <option value="">- <?php echo Helper::translate("Please select one", "member-deposit-selectone"); ?> -</option>
            <option value="Internet Banking"><?php echo Helper::translate("Internet Banking", "member-deposit-internetbanking"); ?></option>
            <option value="ATM Deposit"><?php echo Helper::translate("ATM Deposit", "member-deposit-atmdeposit"); ?></option>
            <option value="CTM Cash Deposit Machine"><?php echo Helper::translate("CTM Cash Deposit Machine", "member-deposit-ctmcashdepositmachine"); ?></option>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label><?php echo Helper::translate("Reference No", "member-deposit-referenceno"); ?><span class="label_required">*</span></label></th>
      <td><input name="ReferenceCode" class="validate[required]" value="" size="40" /></td>
    </tr>
     <tr>
      <th scope="row"><label><?php echo Helper::translate("Date/Time of Deposit", "member-deposit-datetime"); ?><span class="label_required">*</span></label></th>
      <td><input name="DateDeposit" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="25" maxlength="25" readonly/><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
        <th scope="row">&nbsp;</th>
        <td class="yellow"><?php echo Helper::translate("For fast processing, please select your choice of bank slip submit to us as below", "member-deposit-fastprocessnote"); ?></td>
       
    </tr> 
    
        <tr>
      <th scope="row"><label><?php echo Helper::translate("Submit Bank Slip Through", "member-deposit-bankinslip"); ?><span class="label_required">*</span></label></th>
      <td><select name="BankSlip" id="BankSlip" class="chosen_simple">
              <option value="">- <?php echo Helper::translate("Please select one", "member-deposit-selectone"); ?> -</option>    
          <?php for ($i=0; $i<$data['content_param']['bank_slip']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['bank_slip'][$i]['Label']; ?>"><?php //echo $data['content_param']['listingfiltertwo_list'][$i]['ID']; ?><?php echo $data['content_param']['bank_slip'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><?php echo Helper::translate("Promotion:", "member-deposit-promotion"); ?></th>
      <td>
          <!-- <div class="promo_list"><label><input type="radio" name="PromoSpecial" value="None" checked="checked"> None</label></div>
          <?php #for ($i=1; $i <= 10 ; $i++) { ?>
              <?php #if ($data['content'][$i]!="") { ?>
              <div class="promo_list"><label><input type="radio" name="PromoSpecial" value="<?php #Core::getHook('promo-deposit-'.$i); ?>"> <?php #Core::getHook('promo-deposit-'.$i); ?></label></div>
              <?php #} ?>
          <?php #} ?> -->
          <select name="PromoSpecial">
              <option value="None"><?php echo Helper::translate("None", "member-deposit-none"); ?></option>
              <?php //for ($i=1; $i <= 10 ; $i++) { ?>
                <?php //if ($data['content'][$i]!="") { ?>
                <!--<option value="<?php //Core::getHook('promo-deposit-'.$i.'-'.$_SESSION['language']); ?>"><?php //Core::getHook('promo-deposit-'.$i.'-'.$_SESSION['language']); ?></option>-->
                <?php //} ?>
              <?php //} ?>
                <?php for ($i=0; $i<$data['content_param']['promotion_list']['count']; $i++) { ?>
                <option value="<?php echo $data['content_param']['promotion_list'][$i]['Title']; ?>"><?php echo $data['content_param']['promotion_list'][$i]['Title']; ?></option>
                <?php } ?>
          </select>
      </td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"></th>
      <td><label><input type="checkbox" name="promorules" class="validate[required]" value="promorules">&nbsp;&nbsp;<?php echo Helper::translate("I already understand the rules and Deposit Promo Rules if any", "member-deposit-rule"); ?></label></td>
    </tr>
    <tr>
        <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
        <th scope="row" id="transferheader"><?php echo Helper::translate("Transfer", "member-deposit-transfer"); ?></th>
    </tr>
    <tr>
        <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
        
      <th scope="row"><label><?php echo Helper::translate("Transfer To", "member-transfer-to"); ?></label></th>
      <td>
          <select class="nonmainwallet" id="TransferTo" name="TransferTo">
            <?php for ($i=0; $i<$data['nonmainwallet']['count']; $i++) { ?>
            <option value="<?php echo $data['nonmainwallet'][$i]['ID']; ?>"><?php echo $data['nonmainwallet'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
     <tr>
      <th scope="row"><label><?php echo Helper::translate("Amount (MYR)", "member-transfer-amount"); ?></label></th>
      <td><input name="TransferAmount" id="TransferAmount" class="validate[custom[number], min[10]]" value="" size="10" /> <?php echo Helper::translate("(Minimum MYR 10.00)", "member-transfer-minimum-amount"); ?></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <input type="hidden" id="DepositTrigger" name="DepositTrigger" value="1" />
      <input type="hidden" id="form_token" name="form_token" value="<?php echo $_SESSION['form_token']; ?>" />
      <td><input type="submit" id="Submit" name="submit" value="<?php echo Helper::translate("Save", "member-transfer-save"); ?>" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
        <input type="button" id="Cancel" value="<?php echo Helper::translate("Cancel", "member-transfer-cancel"); ?>" class="button" />
        </a></td>
    </tr>        
  </table>
</form>
</div> 
<div>
    <?php echo $data['agentblock'][2]['Content']; ?>
</div>

<p style="margin: 15px 0;"><?php //Core::getHook('block-deposit-bottom'); ?>
<?php 

    if($_SESSION['language']=='en')
    {    
        //Core::getHook('block-deposit-bottom'); 
    }
    elseif($_SESSION['language']=='ms')
    {
        //Core::getHook('block-deposit-bottom-ms');
    }
    elseif($_SESSION['language']=='zh_CN')
    {
        //Core::getHook('block-deposit-bottom-zh-cn');
    } 
    
    echo $data['agentblock'][1]['Content'];


?>
</p>


<?php } ?>
