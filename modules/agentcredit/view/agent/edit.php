<?php 
function familyTree($array, $parentID)
	{
            //global $data;
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                             
                             if ($array[$index]['ID']==$parentID) { 
                                $selected= 'selected="selected"'; 

                             }                     
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '. $array[$index]['Company'].'</option>';    
                       
                            echo $data;
                            unset($selected);
                            
                           familyTree($array[$index]['Child'], $parentID);
                      }
                     
                  
                }
                
        }
                               
?>
<?php if ($data['page']['agentcredit_add']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['agentcredit_add']['ok']==1) { ?>
    <div class="notify">Transaction created successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['agentcredit_edit']['error']['count']>0) { ?>
<?php } else { ?>
    <?php if ($data['page']['agentcredit_edit']['ok']==1) { ?>
    <div class="notify">Transaction edited successfully.</div>
    <?php } ?>
<?php } ?>
<form name="edit_form" class="admin_table_nocell"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentcredit/editprocess/<?php echo $data['content'][0]['ID']; ?>" method="post">
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
      <th scope="row"><label>Agent</label></th>
      <td><select name="AgentID" class="validate[] chosen">
                        <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['content'][0]['AgentID']==$data['agent'][0]['ID']){ ?> selected="selected" <?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option>    
                        <?php familyTree($data['agent'][0]['Child'], $data['content'][0]['AgentID']); ?>
                  </select>
          </td>
    </tr>
    <tr>
      <th scope="row"><label>Description</label></th>
      <td><textarea name="Description" id="Description" class="full_width" style="width:450px;" rows="5"><?php echo $data['content'][0]['Description']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Rejected Remark</label></th>
      <td><textarea name="RejectedRemark" id="RejectedRemark" class="full_width" style="width:450px;" rows="5"><?php echo $data['content'][0]['RejectedRemark']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Date/Time<span class="label_required">*</span></label></th>
      <td><input name="Date" type="text" class="validate[required,custom[dmyDateTime]] datepicker mask_date" value="<?php echo $data['content'][0]['Date']; ?>" size="25" maxlength="25" readonly="readonly" /><span class="label_hint">(dd-mm-yyyy hh:mm:ss)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer To</label></th>
      <td><input name="TransferTo" type="text" class="validate[]" value="<?php echo $data['content'][0]['TransferTo']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer From</label></th>
      <td><input name="TransferFrom" type="text" class="validate[]" value="<?php echo $data['content'][0]['TransferFrom']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>In (MYR)</label></th>
      <td><input name="Debit" type="text" class="validate[custom[number]]" value="<?php echo $data['content'][0]['In']; ?>" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Out (MYR)</label></th>
      <td><input name="Credit" type="text" class="validate[custom[number]]" value="<?php echo $data['content'][0]['Out']; ?>" size="10" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer (MYR)</label></th>
      <td><input name="Amount" type="text" class="validate[custom[number]]" value="<?php echo $data['content'][0]['Amount']; ?>" size="10" /></td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Deposit Bonus<span class="label_required">*</span></label></th>
      <td><input name="DepositBonus" type="text" class="validate[required]" value="<?php echo $data['content'][0]['DepositBonus']; ?>" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Deposit Channel<span class="label_required">*</span></label></th>
      <td><input name="DepositChannel" type="text" class="validate[required]" value="<?php echo $data['content'][0]['DepositChannel']; ?>" size="80" /></td>
    </tr> -->
    <tr>
      <th scope="row"><label>Reference Code</label></th>
      <td><input name="ReferenceCode" type="text" class="validate[]" value="<?php echo $data['content'][0]['ReferenceCode']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Bank</label></th>
      <td>
          <select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if($data['content'][0]['Bank']==$data['content_param']['bank_list'][$i]['Label']){ ?> selected="selected" <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
          </td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Staff</label></th>
      <td><select name="StaffID" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['staff_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['staff_list'][$i]['ID']; ?>" <?php if ($data['content_param']['staff_list'][$i]['ID']==$data['content'][0]['StaffID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['staff_list'][$i]['Username']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Modified Date<span class="label_required">*</span></label></th>
      <td><input name="ModifiedDate" type="text" class="validate[required,custom[dmyDate]] datepicker mask_date" value="<?php echo $data['content'][0]['ModifiedDate']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr> -->
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>" <?php if ($data['content_param']['transactionstatus_list'][$i]['Label']==$data['content'][0]['Status']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
          <?php } ?>
        </select></td>
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
        <?php if($data['back']=='AgentGroup'){ ?>   
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentcredit/group">
        <input type="button" value="Cancel" class="button" />
        </a>
       <?php }elseif($data['back']=='AgentIndex'){ ?>
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentcredit/index">
        <input type="button" value="Cancel" class="button" />
        </a>  
       <?php }else{ ?>
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentcredit/index">
        <input type="button" value="Cancel" class="button" />
        </a>
       <?php } ?></td>
    </tr>
  </table>
</form>
