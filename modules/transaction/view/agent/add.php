<?php 
function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                                                 
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '. $array[$index]['Company'].'</option>';    
                       
                            echo $data;
           
                            
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
                              
?>
<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/addprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
<!--    <tr>
      <th scope="row"><label>Agent</label></th>
      <td><select name="AgentID" class="chosen">
              <option value="<?php echo $data['agent'][0]['ID']; ?>"><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option>  
            <?php familyTree($data['agent'][0]['Child']); ?>
          </select></td>
    </tr>  -->
    <tr>
      <th scope="row"><label>Type</label></th>
      <td><select name="TypeID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['transactiontype_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['transactiontype_list'][$i]['ID']; ?>"><?php echo $data['content_param']['transactiontype_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Member</label></th>
      <td><select name="MemberID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['member_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['member_list'][$i]['ID']; ?>"><?php echo $data['content_param']['member_list'][$i]['Name']; ?> | <?php echo $data['content_param']['member_list'][$i]['Username']; ?> | <?php echo $data['content_param']['member_list'][$i]['AgentURL']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" style="width:450px;" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Promotion</label></th>
      <td><input name="PromoSpecial" class="validate[]" type="text" value="" size="50" />
      </td>
    </tr>
    <tr>
      <th scope="row"><label>Bank Slip</label></th>
      <td><textarea name="BankSlip" id="Description" class="full_width" style="width:450px;" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Rejected Remark</label></th>
      <td><textarea name="RejectedRemark" id="RejectedRemark" class="full_width" style="width:450px;" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Date/Time<span class="label_required">*</span></label></th>
      <td><input name="Date" class="validate[required,custom[dmyDateTime]] datepicker mask_date" type="text" value="" size="25" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer To</label></th>
      <td><input name="TransferTo" class="validate[]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer From</label></th>
      <td><input name="TransferFrom" class="validate[]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>In (MYR)</label></th>
      <td><input name="Debit" class="validate[custom[number]]" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Out (MYR)</label></th>
      <td><input name="Credit" class="validate[custom[number]]" type="text" value="" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer (MYR)</label></th>
      <td><input name="Amount" class="validate[custom[number]]" type="text" value="" size="10" /></td>
    </tr>
    <!--<tr>
      <th scope="row"><label>Product</label></th>
      <td>
          <select class="ProductID" id="ProductID" name="ProductID">
            <?php for ($i=0; $i<$data['nonmainwallet']['count']; $i++) { ?>
            <option value="<?php echo $data['nonmainwallet'][$i]['ID']; ?>"><?php echo $data['nonmainwallet'][$i]['Name']; ?></option>
            <?php } ?>
          </select>
      </td>
    </tr>-->
    <tr>
      <th scope="row"><label>Bonus (MYR)</label></th>
      <td><input name="Bonus" id="Bonus" class="validate[custom[number]]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Commission (MYR)</label></th>
      <td><input name="Commission" id="Commission" class="validate[custom[number]]" type="text" value="" size="20" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Deposit Bonus<span class="label_required">*</span></label></th>
      <td><input name="DepositBonus" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Deposit Channel<span class="label_required">*</span></label></th>
      <td><input name="DepositChannel" class="validate[required]" type="text" value="" size="80" /></td>
    </tr> -->
    <tr>
      <th scope="row"><label>Reference Code</label></th>
      <td><input name="ReferenceCode" class="validate[]" type="text" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Bank</label></th>
      <td><select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>"><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Staff</label></th>
      <td><select name="StaffID" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['staff_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['staff_list'][$i]['ID']; ?>"><?php echo $data['content_param']['staff_list'][$i]['Username']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Modified Date<span class="label_required">*</span></label></th>
      <td><input name="ModifiedDate" class="validate[required,custom[dmyDate]] datepicker mask_date" type="text" value="" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr> -->
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>"><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <input type="hidden" name="apc" value="<?php echo $data['apc']; ?>">
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
        <?php if($data['apc']=='apcg'){ ?>   
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/group">
        <input type="button" value="Cancel" class="button" />
        </a>
       <?php }elseif($data['apc']=='apci'){ ?>
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index">
        <input type="button" value="Cancel" class="button" />
        </a>  
       <?php }else{ ?>
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index">
        <input type="button" value="Cancel" class="button" />
        </a>
       <?php } ?></td>
    </tr>
  </table>
</form>
