<?php if ($data['page']['agent_profile']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['agent_profile']['error']['NRIC']==1) { ?><li>The NRIC number <?php echo $data['form_param']['NRIC']; ?> exists in our records. Each member can only register once. Please try again with another NRIC number.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['Passport']==1) { ?><li>The Passport number <?php echo $data['form_param']['Passport']; ?> exists in our records. Each member can only register once. Please try again with another Passport number.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['Email']==1) { ?><li>The Email: <?php echo $data['form_param']['Email']; ?> exists in the database. Please try again with another email.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail1']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail1']; ?> exists in the database. Please try again with another platform email 1.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail2']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail2']; ?> exists in the database. Please try again with another platform email 2.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail3']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail3']; ?> exists in the database. Please try again with another platform email 3.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail4']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail4']; ?> exists in the database. Please try again with another platform email 4.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail5']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail5']; ?> exists in the database. Please try again with another platform email 5.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail6']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail6']; ?> exists in the database. Please try again with another platform email 6.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail7']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail7']; ?> exists in the database. Please try again with another platform email 7.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail8']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail8']; ?> exists in the database. Please try again with another platform email 8.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail9']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail9']; ?> exists in the database. Please try again with another platform email 9.</li><?php } ?>
            <?php if ($data['page']['agent_profile']['error']['PlatformEmail10']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail10']; ?> exists in the database. Please try again with another platform email 10.</li><?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <?php if ($data['page']['agent_profile']['ok']==1) { ?>
    <div class="notify">Profile updated successfully.</div>
    <?php } ?>
<?php } ?>
<form name="profile_form" class="admin_table_nocell"  id="profile_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/profileprocess/<?php echo $data['content'][0]['ID']; ?>" enctype="multipart/form-data" method="post">
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
          <td>
              <input type="checkbox" name="Product[]" value="<?php echo $data['content_param']['product_list'][$i]['ID']; ?>" disabled
              <?php for ($z=0; $z<$data['content_param']['product']['count']; $z++) {
              if($data['content_param']['product_list'][$i]['ID']==$data['content_param']['product'][$z]){ ?> 
                 
                 
                 checked="checked" 
            <?php } } ?>
                 
                 >&nbsp;<?php echo $data['content_param']['product_list'][$i]['Name']; ?>&nbsp;&nbsp;</td>
                    <?php if($i % 2!==0 && ($i!==0)){ ?>

                        </tr>               
                    <?php } ?>   
                       
            <?php } ?>            
          <?php } ?>
          </table>              
      </td> 
    </tr>
    <tr>
      <th scope="row"><label>Username</label></th>
      <td><input name="Username" type="text" class="validate[] disabled" value="<?php echo $data['content'][0]['Username']; ?>" size="20" readonly="readonly" /><span class="label_hint">(Your login username)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Profit Sharing</label></th>
      <td><input name="Profitsharing" type="text" class="validate[] disabled" value="<?php echo $data['content'][0]['Profitsharing']; ?>" size="20" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" size="40" /></td>
    </tr>
<!--    <tr>
      <th scope="row"><label>Gender</label></th>
      <td><select name="GenderID" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>"
              <?php if ($data['form_param']['GenderID']!="") { ?>
              <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['form_param']['GenderID']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>
              <?php if ($data['content_param']['gender_list'][$i]['ID']==$data['content'][0]['GenderID']) { ?>selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr>-->
<!--    <tr>
      <th scope="row"><label>Date of Birth</label></th>
      <td><input name="DOB" id="DOB" type="text" class="validate[custom[dmyDate]] datepicker" value="<?php echo (($data['form_param']['DOB']!="") ? $data['form_param']['DOB'] : $data['content'][0]['DOB']); ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>-->
<!--    <tr>
      <th scope="row"><label>Nationality</label></th>
      <td><select name="Nationality" id="Nationality" class="chosen">
          <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>"
              <?php if ($data['form_param']['Nationality']!="") { ?>
              <?php if ($data['content_param']['country_list'][$i]['ID']==$data['form_param']['Nationality']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>
              <?php if ($data['content_param']['country_list'][$i]['ID']==$data['content'][0]['Nationality']) { ?> selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['country_list'][$i]['Name']; ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>-->
<!--    <tbody id="nric_box"
        <?php if ($data['form_param']['Nationality']!="") { ?>
        <?php if ($data['form_param']['Nationality']!=151) { ?>class="invisible"<?php } ?>
        <?php } else { ?>
        <?php if ($data['content'][0]['Nationality']!=151) { ?>class="invisible"<?php } ?>
        <?php } ?>>
        <tr>
          <th scope="row"><label>NRIC</label></th>
          <td><input name="NRIC" id="NRIC" type="text" class="validate[custom[NRIC]]" value="<?php echo (($data['form_param']['NRIC']!="") ? $data['form_param']['NRIC'] : $data['content'][0]['NRIC']); ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
        </tr>
    </tbody>
    <tbody id="passport_box"
        <?php if ($data['form_param']['Nationality']!="") { ?>
        <?php if ($data['form_param']['Nationality']==151) { ?>class="invisible"<?php } ?>
        <?php } else { ?>
        <?php if ($data['content'][0]['Nationality']==151) { ?>class="invisible"<?php } ?>
        <?php } ?>>
        <tr>
          <th scope="row"><label>Passport</label></th>
          <td><input name="Passport" type="text" class="validate[]" value="<?php echo (($data['form_param']['Passport']!="") ? $data['form_param']['Passport'] : $data['content'][0]['Passport']); ?>" size="20" /></td>
        </tr>
    </tbody>-->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Company URL</label></th>
      <td><input name="Company" type="text" class="validate[] disabled" value="<?php echo (($data['form_param']['Company']!="") ? $data['form_param']['Company'] : $data['content'][0]['Company']); ?>" size="40" readonly="readonly" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Bank</label></th>
      <td><input name="Bank" type="text" class="validate[]" value="<?php echo (($data['form_param']['Bank']!="") ? $data['form_param']['Bank'] : $data['content'][0]['Bank']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Bank Account No</label></th>
      <td><input name="BankAccountNo" type="text" class="validate[]" value="<?php echo (($data['form_param']['BankAccountNo']!="") ? $data['form_param']['BankAccountNo'] : $data['content'][0]['BankAccountNo']); ?>" size="40" /></td>
    </tr>
<!--    <tr>
      <th scope="row"><label>Secondary Bank</label></th>
      <td><input name="SecondaryBank" type="text" class="validate[]" value="<?php echo (($data['form_param']['SecondaryBank']!="") ? $data['form_param']['SecondaryBank'] : $data['content'][0]['SecondaryBank']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Secondary Bank Account No</label></th>
      <td><input name="SecondaryBankAccountNo" type="text" class="validate[]" value="<?php echo (($data['form_param']['SecondaryBankAccountNo']!="") ? $data['form_param']['SecondaryBankAccountNo'] : $data['content'][0]['SecondaryBankAccountNo']); ?>" size="40" /></td>
    </tr>-->
    <tr>
      <th scope="row"><label>Mobile No</label></th>
      <td><input name="MobileNo" type="text" class="validate[custom[mobileNo],minSize[9]]" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Phone No</label></th>
      <td><input name="PhoneNo" type="text" class="validate[custom[phoneNo],minSize[9]]" value="<?php echo (($data['form_param']['PhoneNo']!="") ? $data['form_param']['PhoneNo'] : $data['content'][0]['PhoneNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No</label></th>
      <td><input name="FaxNo" type="text" class="validate[custom[faxNo],minSize[9]]" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Email<span class="label_required">*</span></label></th>
      <td><input name="weirdEmail" type="text" class="validate[required,custom[email]] disabled" value="<?php echo (($data['form_param']['Email']!="") ? $data['form_param']['Email'] : $data['content'][0]['Email']); ?>" size="30" readonly="readonly" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 1</label></th>
      <td><input name="PlatformEmail1" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail1']!="") ? $data['form_param']['PlatformEmail1'] : $data['content'][0]['PlatformEmail1']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 2</label></th>
      <td><input name="PlatformEmail2" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail2']!="") ? $data['form_param']['PlatformEmail2'] : $data['content'][0]['PlatformEmail2']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 3</label></th>
      <td><input name="PlatformEmail3" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail3']!="") ? $data['form_param']['PlatformEmail3'] : $data['content'][0]['PlatformEmail3']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 4</label></th>
      <td><input name="PlatformEmail4" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail4']!="") ? $data['form_param']['PlatformEmail4'] : $data['content'][0]['PlatformEmail4']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 5</label></th>
      <td><input name="PlatformEmail5" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail5']!="") ? $data['form_param']['PlatformEmail5'] : $data['content'][0]['PlatformEmail5']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 6</label></th>
      <td><input name="PlatformEmail6" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail6']!="") ? $data['form_param']['PlatformEmail6'] : $data['content'][0]['PlatformEmail6']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 7</label></th>
      <td><input name="PlatformEmail7" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail7']!="") ? $data['form_param']['PlatformEmail7'] : $data['content'][0]['PlatformEmail7']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 8</label></th>
      <td><input name="PlatformEmail8" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail8']!="") ? $data['form_param']['PlatformEmail8'] : $data['content'][0]['PlatformEmail8']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 9</label></th>
      <td><input name="PlatformEmail9" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail9']!="") ? $data['form_param']['PlatformEmail9'] : $data['content'][0]['PlatformEmail9']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Platform Email 10</label></th>
      <td><input name="PlatformEmail10" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail10']!="") ? $data['form_param']['PlatformEmail10'] : $data['content'][0]['PlatformEmail10']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Background Color</label></th>
      <td><input name="BackgroundColour" type="text" class="validate[] cpicker" value="<?php echo (($data['form_param']['BackgroundColour']!="") ? $data['form_param']['BackgroundColour'] : $data['content'][0]['BackgroundColour']); ?>" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Font Color</label></th>
      <td><input name="FontColour" type="text" class="validate[] cpicker" value="<?php echo (($data['form_param']['FontColour']!="") ? $data['form_param']['FontColour'] : $data['content'][0]['FontColour']); ?>" size="30" /></td>
    </tr>
    <!--<tr>
      <th scope="row"><label>Logo<span class="label_required">*</span></label></th>
      <td><input name="Logo" type="text" class="validate[required] cpicker" value="<?php echo (($data['form_param']['Colour']!="") ? $data['form_param']['Colour'] : $data['content'][0]['Colour']); ?>" size="30" /></td>
    </tr>-->
    <tr>
      <th scope="row"><label>Logo</label></th>
      <td><?php if ($data['content'][0]['Logo']=="") { ?>
        No image uploaded.
        <?php } else { ?>
        <img src="<?php echo $data['content'][0]['LogoCover']; ?>" height="66" width="66" /><br />
        <label>
        <input name="LogoRemove" type="checkbox" id="LogoRemove" value="1" />
        Remove this image</label>
        <br />
        <?php } ?>
        <br />
        <input type="hidden" name="LogoCurrent" value="<?php echo $data['content'][0]['Logo']; ?>" />
        <input name="Logo" type="file" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif)</span></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Update" class="button" /></td>
    </tr>
  </table>
</form>
