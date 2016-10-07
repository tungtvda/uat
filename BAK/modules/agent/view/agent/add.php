<?php 
function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                                                 
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].'</option>';    
                       
                            echo $data;
                            
                            
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
                               
?>
<?php if ($data['page']['agent_add']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['agent_add']['error']['Username']==1) { ?><li>The username "<?php echo $data['form_param']['Username']; ?>" is taken. Please try again with another username.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['NRIC']==1) { ?><li>The NRIC number <?php echo $data['form_param']['NRIC']; ?> exists in the database. Each agent can only register once. Please try again with another NRIC number.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['Passport']==1) { ?><li>The Passport number <?php echo $data['form_param']['Passport']; ?> exists in the database. Each agent can only register once. Please try again with another Passport number.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['Bank']==1) { ?><li>The Bank <?php echo $data['form_param']['Bank']; ?> exists in the database. Please try again with another bank.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['Email']==1) { ?><li>The Email: <?php echo $data['form_param']['Email']; ?> exists in the database. Please try again with another email.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail1']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail1']; ?> exists in the database. Please try again with another platform email 1.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail2']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail2']; ?> exists in the database. Please try again with another platform email 2.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail3']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail3']; ?> exists in the database. Please try again with another platform email 3.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail4']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail4']; ?> exists in the database. Please try again with another platform email 4.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail5']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail5']; ?> exists in the database. Please try again with another platform email 5.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail6']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail6']; ?> exists in the database. Please try again with another platform email 6.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail7']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail7']; ?> exists in the database. Please try again with another platform email 7.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail8']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail8']; ?> exists in the database. Please try again with another platform email 8.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail9']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail9']; ?> exists in the database. Please try again with another platform email 9.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['PlatformEmail10']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail10']; ?> exists in the database. Please try again with another platform email 10.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['Company']==1) { ?><li>The Company URL: <?php echo $data['form_param']['Company']; ?> exists in the database. Please try again with another Company URL.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['Host']==1) { ?><li>The Host: <?php echo $data['form_param']['Host']; ?> was invalid.</li><?php } ?>
            <?php if ($data['page']['agent_add']['error']['DNS']==1) { ?><li>Failed to added DNS record, status message: <?php echo $data['page']['agent_add']['dnsMessage']['statusDescription']; ?>.</li><?php } ?>
        </ul>
    </div>
<?php } ?>    
<form name="add_form" class="admin_table_noMobile" id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/addprocess" enctype="multipart/form-data" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">

    <tr>
      <th scope="row"><label>Product</label></th>
      <td>
          <table>
          <?php if($data['content_param']['product_list']['count']>'0'){ ?>
          
            <?php for ($i=0; $i<$data['content_param']['product_list']['count']; $i++) { ?>
              <?php if($i % 2==0){ ?>

                        <tr>               
                    <?php } ?> 
              
                        <td><input type="checkbox" name="Product[]" value="<?php echo $data['content_param']['product_list'][$i]['ID']; ?>" checked>&nbsp;<?php echo $data['content_param']['product_list'][$i]['Name']; ?>&nbsp;&nbsp;</td>
                    <?php if($i % 2!==0 && ($i!==0)){ ?>

                        </tr>               
                    <?php } ?>             
            <?php } ?>            
          <?php }else{ ?>
                None        
          <?php } ?>              
          </table>              
      </td>
    </tr>

    <tr>
      <th scope="row"><label>Full Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo $data['form_param']['Name']; ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Profit Sharing<span class="label_required">*</span></label></th>
      <td><input name="Profitsharing" class="validate[required, custom[number]]" type="text" value="<?php echo $data['form_param']['Profitsharing']; ?>" size="10" /><span class="label_hint">(e.g. 10.00)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Parent</label></th>
      <td><select name="ParentID" class="validate[] chosen">
                        <option value="<?php echo $data['content'][0]['ID']; ?>"><?php echo $data['content'][0]['Name']; ?> - <?php echo $data['content'][0]['ID']; ?></option>  
                        <?php familyTree($data['content'][0]['Child']); ?>
                  </select>
          </td>
    </tr>
    <tr>
      <th scope="row"><label>Type<span class="label_required">*</span></label></th>     
      <td><input name="TypeID" type="text" class="validate[]" value="Normal" size="40" disabled/></td>
    </tr>
<!--<tr>
      <th scope="row"><label>Gender</label></th>
      <td><select name="GenderID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Date of Birth</label></th>
      <td><input name="DOB" class="validate[custom[dmyDate]] datepicker mask_date" type="text" value="<?php echo $data['form_param']['DOB']; ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>-->
    <!--<tr>
      <th scope="row"><label>Nationality</label></th>
      <td><select name="Nationality" id="Nationality" class="chosen">
            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" 
                <?php if ($data['form_param']['Nationality']=="") { ?>                
                <?php if ($data['content_param']['country_list'][$i]['ID']==151) { ?> selected="selected"<?php } ?>
                <?php } else { ?>
                <?php if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Nationality']) { ?> selected="selected"<?php } ?>
                <?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tbody id="nric_box" <?php if (($data['form_param']['Nationality']!=151)&&($data['form_param']['Nationality']!='')) { ?>class="invisible"<?php } ?>>
        <tr>
          <th scope="row"><label>NRIC</label></th>
          <td><input name="NRIC" class="validate[custom[NRIC]] mask_nric" type="text" value="<?php echo $data['form_param']['NRIC']; ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody>
    <tbody id="passport_box" <?php if (($data['form_param']['Nationality']==151)||($data['form_param']['Nationality']=='')) { ?>class="invisible"<?php } ?>>
        <tr>
          <th scope="row"><label>Passport</label></th>
          <td><input name="Passport" class="validate[]" type="text" value="<?php echo $data['form_param']['Passport']; ?>" size="20" /></td>
        </tr>
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>-->      
    <tr>
      <th scope="row"><label>Domain<span class="label_required">*</span></label></th>
      <td><input name="Company" class="validate[required]" type="text" value="<?php echo (isset($data['form_param']['Company'])===true && empty($data['form_param']['Company'])===false)?$data['form_param']['Company']:$data['domain']; ?>" size="40" disabled="disabled" /><span class="label_hint">(Please input only allowed formats, e.g. youtube.com, facebook.com. You shouldn't include www or http://www in front of domain)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Host</label></th>
      <td><input name="Host" class="validate[maxSize[6]]" type="text" value="<?php echo $data['form_param']['Host']; ?>" size="40" /><span class="label_hint">(Please input only allowed formats, e.g. <strong>sub1</strong>.domain.com, <strong>sub2</strong>.domain.com, <strong>sub3</strong>.domain.com, only the subdomain part is need)</span></td>
    </tr>
    <!--<tr>
      <th scope="row"><label>Credit</label></th>
      <td><input name="Credit" class="validate[custom[number]]" type="text" value="<?php echo $data['form_param']['Credit']; ?>" size="20" /></td>
    </tr>-->   
    <tr>
      <th scope="row"><label>Bank</label></th>
      <td><select name="Bank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if($data['form_param']['Bank']==$data['content_param']['bank_list'][$i]['Label']){ ?> selected="selected" <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select></td>
    </tr>    
    <tr>
      <th scope="row"><label>Bank Account No</label></th>
      <td><input name="BankAccountNo" class="validate[custom[integer], minsize[2]]" type="text" value="<?php echo $data['form_param']['BankAccountNo']; ?>" size="40" /></td>
    </tr>
<!--<tr>
      <th scope="row"><label>Secondary Bank</label></th>
      <td><select name="SecondaryBank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if($data['form_param']['SecondaryBank']==$data['content_param']['bank_list'][$i]['Label']){ ?> selected="selected" <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
          </td>
    </tr>    
    <tr>
      <th scope="row"><label>Secondary Bank Account No</label></th>
      <td><input name="SecondaryBankAccountNo" class="validate[custom[integer], minsize[2]]" type="text" value="<?php echo $data['form_param']['BankAccountNo']; ?>" size="40" /></td>
    </tr>-->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Username<span class="label_required">*</span></label></th>
      <td><input name="Username" class="validate[required]" type="text" value="<?php echo $data['form_param']['Username']; ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>New Password<span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" class="validate[required,minSize[8]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm Password<span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required,equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Mobile No</label></th>
      <td><input name="MobileNo" class="validate[custom[mobileNo],minSize[9]]" type="text" value="<?php echo $data['form_param']['MobileNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No</label></th>
      <td><input name="PhoneNo" class="validate[custom[phoneNo],minSize[9]]" type="text" value="<?php echo $data['form_param']['PhoneNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No</label></th>
      <td><input name="FaxNo" class="validate[custom[faxNo],minSize[9]]" type="text" value="<?php echo $data['form_param']['FaxNo']; ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>IP Address<span class="label_required">*</span></label></th>
      <td><input name="IPAddress" type="text" class="validate[required]" value="<?php echo ($data['form_param']['IPAddress']!='')?$data['form_param']['IPAddress']:$data['IPAddress']; ?>" size="20" disabled="disabled" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Chat</label></th>
      <td><textarea name="Chat" rows="4" class="validate[] full_width"><?php echo $data['form_param']['Chat']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Remark</label></th>
      <td><textarea name="Remark" rows="4" class="validate[] full_width"><?php echo $data['form_param']['Remark']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="Email" type="text" class="validate[required,custom[email]]" value="<?php echo $data['form_param']['Email']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 1</label></th>
      <td><input name="PlatformEmail1" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail1']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 2</label></th>
      <td><input name="PlatformEmail2" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail2']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 3</label></th>
      <td><input name="PlatformEmail3" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail3']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 4</label></th>
      <td><input name="PlatformEmail4" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail4']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 5</label></th>
      <td><input name="PlatformEmail5" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail5']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 6</label></th>
      <td><input name="PlatformEmail6" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail6']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 7</label></th>
      <td><input name="PlatformEmail7" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail7']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 8</label></th>
      <td><input name="PlatformEmail8" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail8']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 9</label></th>
      <td><input name="PlatformEmail9" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail9']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 10</label></th>
      <td><input name="PlatformEmail10" type="text" class="validate[custom[email]]" value="<?php echo $data['form_param']['PlatformEmail10']; ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Background Color</label></th>
      <td><input name="BackgroundColour" type="text" class="validate[] cpicker" value="<?php echo $data['form_param']['Colour']; ?>" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Font Color</label></th>
      <td><input name="FontColour" type="text" class="validate[] cpicker" value="<?php echo $data['form_param']['Colour']; ?>" size="30" /></td>
    </tr>
<!--    <tr>
      <th scope="row"><label>Logo<span class="label_required">*</span></label></th>
      <td><input name="Logo" type="text" class="validate[required] cpicker" value="<?php echo $data['form_param']['Colour']; ?>" size="30" /></td>
    </tr>-->
    <tr>
      <th scope="row"><label>Logo</label></th>
      <td><input name="Logo" type="file" value="<?php echo $data['Logo']; ?>" /><br />
      <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif.)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($data['form_param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Add" class="button" />
      
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/editindex">
        <input type="button" value="Cancel" class="button" />
        </a>  
       
      </td>
    </tr>
  </table>
</form>
