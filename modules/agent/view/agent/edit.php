<?php
function familyTree($array, $ParentID)
	{

           //echo $ParentID;
           //exit;
                if(is_array($array)===TRUE)
                {


                      for ($index = 0; $index < $array['count']; $index++) {


                             if ($array[$index]['ID']==$ParentID) {
                                $selected = 'selected="selected"';
                                //echo 'hi';
                             }

                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '.$array[$index]['Company'].'</option>';
                            unset($selected);
                            echo $data;


                           familyTree($array[$index]['Child'], $_SESSION['ParentID']);
                      }


                }

        }

?>
<?php if ($data['page']['agent_add']['error']['count']>0) { ?>
    <?php if ($data['page']['agent_add']['error']['Logo']!="") { ?>
    <div class="error">Logo upload failed (Error: <?php echo $data['page']['agent_add']['error']['Logo']; ?>)</div>
    <?php } ?>
<?php } else { ?>
<?php } ?>
<?php if ($data['page']['agent_edit']['error']['count']>0) { ?>
    <?php if ($data['page']['agent_edit']['error']['Logo']!="") { ?>
    <div class="error">Logo upload failed (Error: <?php echo $data['page']['agent_edit']['error']['Logo']; ?>)</div>
    <?php } ?>
<?php } else { ?>
    <?php if ($data['page']['agent_edit']['ok']==1) { ?>
    <div class="notify">Agent edited successfully.</div>
    <?php } ?>
<?php } ?>
<?php if ($data['page']['agent_add']['ok']==1) { ?>
<div class="notify">Agent created successfully.</div>
<?php } ?>
<?php if ($data['page']['agent_edit']['error']['count']>0) { ?>
    <div class="error">
        <ul>
            <?php if ($data['page']['agent_edit']['error']['Username']==1) { ?><li>The username "<?php echo $data['form_param']['Username']; ?>" is taken. Please try again with another username.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['NRIC']==1) { ?><li>The NRIC number <?php echo $data['form_param']['NRIC']; ?> exists in the database. Each agent can only register once. Please try again with another NRIC number.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['Passport']==1) { ?><li>The Passport number <?php echo $data['form_param']['Passport']; ?> exists in the database. Each agent can only register once. Please try again with another Passport number.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['Bank']==1) { ?><li>The Bank <?php echo $data['form_param']['Bank']; ?> exists in the database. Please try again with another Bank.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['Email']==1) { ?><li>The Email: <?php echo $data['form_param']['Email']; ?> exists in the database. Please try again with another email.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail1']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail1']; ?> exists in the database. Please try again with another Agent Email 1.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail2']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail2']; ?> exists in the database. Please try again with another Agent Email 2.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail3']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail3']; ?> exists in the database. Please try again with another Agent Email 3.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail4']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail4']; ?> exists in the database. Please try again with another Agent Email 4.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail5']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail5']; ?> exists in the database. Please try again with another Agent Email 5.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail6']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail6']; ?> exists in the database. Please try again with another Agent Email 6.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail7']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail7']; ?> exists in the database. Please try again with another Agent Email 7.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail8']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail8']; ?> exists in the database. Please try again with another Agent Email 8.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail9']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail9']; ?> exists in the database. Please try again with another Agent Email 9.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['PlatformEmail10']==1) { ?><li>The Email: <?php echo $data['form_param']['PlatformEmail10']; ?> exists in the database. Please try again with another Agent Email 10.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['Company']==1) { ?><li>The Company URL: <?php echo $data['form_param']['Company']; ?> exists in the database. Please try again with another Company URL.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['Host']==1) { ?><li>The host <?php echo $data['form_param']['Host']; ?> is invalid.</li><?php } ?>
            <?php if ($data['page']['agent_edit']['error']['DNS']==1) { ?><li>Failed to edited DNS record, status message: <?php echo $data['page']['agent_edit']['dnsMessage']['statusDescription']; ?>.</li><?php } ?>
        </ul>
    </div>
<?php } else { ?>

<?php } ?>

<form name="edit_form" class="admin_table_noMobile"  id="edit_form" action="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/editprocess/<?php echo $data['content'][0]['ID']; ?>" enctype="multipart/form-data" method="post">
  <table border="0" Mobilespacing="0" Mobilepadding="0">
    <?php /* ?>
    <tr>
      <th scope="row"><label>Register Link</label></th>
      <td><a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/register?rid=<?php echo urlencode(base64_encode($data['content'][0]['ID'])); ?>" target="_blank"><?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/register?rid=<?php echo urlencode(base64_encode($data['content'][0]['ID'])); ?></a></td>
    </tr>
    <tr>
      <th scope="row"><label>Member Link</label></th>
      <td><a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/login?rid=<?php echo urlencode(base64_encode($data['content'][0]['ID'])); ?>" target="_blank"><?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/member/member/login?rid=<?php echo urlencode(base64_encode($data['content'][0]['ID'])); ?></a></td>
    </tr>
    <?php */ ?>
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
              <input type="checkbox" name="Product[]" value="<?php echo $data['content_param']['product_list'][$i]['ID']; ?>"
              <?php for ($z=0; $z<$data['content_param']['product']['count']; $z++) {
              if($data['content_param']['product_list'][$i]['ID']==$data['content_param']['product'][$z]){ ?>


                 checked="checked"
            <?php } } ?>  onclick="return false;" onkeydown="return false;"

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
      <th scope="row"><label>Full Name<span class="label_required">*</span></label></th>
      <td><input name="Name" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Name']!="") ? $data['form_param']['Name'] : $data['content'][0]['Name']); ?>" size="40" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Profit Sharing (%)<span class="label_required">*</span></label></th>
      <td><input name="Profitsharing" type="text" class="validate[required, custom[onlyNumberSp], min[0], max[100]]" value="<?php echo (($data['form_param']['Profitsharing']!="") ? $data['form_param']['Profitsharing'] : $data['content'][0]['Profitsharing']); ?>" size="10" /><span class="label_hint">(min = 0, max = 100)</span></td>
    </tr>
    <?php if($data['content'][0]['ParentID']!='0'){ ?>
    <tr>
      <th scope="row"><label>Parent</label></th>
      <td><select name="ParentID" class="validate[] chosen">
 <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['content'][0]['ParentID']==$data['agent'][0]['ID']){ ?> selected="selected" <?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?> | <?php echo $data['agent'][0]['Company']; ?></option>
                        <?php familyTree($data['agent'][0]['Child'], $_SESSION['ParentID']); ?>
                  </select>
          </td>
    </tr>
    <?php } ?>
    <tr>
      <th scope="row"><label>Type<span class="label_required">*</span></label></th>
      <td><input name="TypeID" type="text" class="validate[]" value="<?php echo $data['content'][0]['Type'];?>" size="40" disabled/></td>
    </tr>
<!--<tr>
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
<!--<tr>
      <th scope="row"><label>Date of Birth</label></th>
      <td><input name="DOB" type="text" class="validate[custom[dmyDate]] datepicker mask_date" value="<?php echo (($data['form_param']['DOB']!="") ? $data['form_param']['DOB'] : $data['content'][0]['DOB']); ?>" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>-->
    <!--<tr>
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
    </tr>
    <tbody id="nric_box"
        <?php if ($data['form_param']['Nationality']!="") { ?>
        <?php if ($data['form_param']['Nationality']!=151) { ?>class="invisible"<?php } ?>
        <?php } else { ?>
        <?php if ($data['content'][0]['Nationality']!=151) { ?>class="invisible"<?php } ?>
        <?php } ?>>
        <tr>
          <th scope="row"><label>NRIC</label></th>
          <td><input name="NRIC" type="text" class="validate[custom[NRIC]] mask_nric" value="<?php echo (($data['form_param']['NRIC']!="") ? $data['form_param']['NRIC'] : $data['content'][0]['NRIC']); ?>" size="20" /><span class="label_hint">(e.g. 880101-14-5566)</span></td>
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
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>-->
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row" style="vertical-align: top"><label>Domain<span class="label_required">*</span></label></th>
      <td>
          <input name="Host" type="text" class="validate[required,maxSize[6]]" value="<?php echo (($data['form_param']['Host']!="") ? $data['form_param']['Host'] : $data['content'][0]['Host']); ?>" size="8" maxlength='6' />.<?php echo $data['content'][0]['Domain']; ?>
          <!-- <input name="Company" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Company']!="") ? $data['form_param']['Company'] : $data['content'][0]['Company']); ?>" size="20" disabled="disabled" />-->

          <span class="label_hint">(Please input only allowed formats, e.g. <strong>host123</strong>.domain.com, only the subdomain part is need)</span>
          <!--<br />
          <span class="label_hint">(Domain: Please input only allowed formats, e.g. youtube.com, facebook.com. You shouldn't include www or http://www in front of domain)</span>--></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <!--<tr>
      <th scope="row"><label>Host</label></th>
      <td><span class="label_hint">(Please input only allowed formats, e.g. <strong>sub1</strong>.domain.com, <strong>sub2</strong>.domain.com, <strong>sub3</strong>.domain.com, only the subdomain part is need)</span></td>
    </tr>
    tr>
      <th scope="row"><label>Credit</label></th>
      <td><input name="Credit" class="validate[custom[number]]" type="text" value="<?php echo (($data['form_param']['Credit']!="") ? $data['form_param']['Credit'] : $data['content'][0]['Credit']); ?>" size="20" /></td>
    </tr>-->
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
    <tr>
      <th scope="row"><label>Bank Account No</label></th>
      <td><input name="BankAccountNo" type="text" class="validate[custom[integer], minsize[2]]" value="<?php echo (($data['form_param']['BankAccountNo']!="") ? $data['form_param']['BankAccountNo'] : $data['content'][0]['BankAccountNo']); ?>" size="40" /></td>
    </tr>
<!--<tr>
      <th scope="row"><label>Secondary Bank</label></th>
      <td>
          <select name="SecondaryBank" class="validate[] chosen">
                        <option value="">--Please select one--</option>
                        <?php for ($i=0; $i<$data['content_param']['bank_list']['count']; $i++) { ?>
                        <option value="<?php echo $data['content_param']['bank_list'][$i]['Label']; ?>" <?php if($data['content'][0]['SecondaryBank']==$data['content_param']['bank_list'][$i]['Label']){ ?> selected="selected" <?php } ?>><?php echo $data['content_param']['bank_list'][$i]['Label']; ?></option>
                        <?php } ?>
                  </select>
         </td>
    </tr>-->
<!--<tr>
      <th scope="row"><label>Secondary Bank Account No</label></th>
      <td><input name="SecondaryBankAccountNo" type="text" class="validate[custom[integer], minsize[2]]" value="<?php echo (($data['form_param']['SecondaryBankAccountNo']!="") ? $data['form_param']['SecondaryBankAccountNo'] : $data['content'][0]['SecondaryBankAccountNo']); ?>" size="40" /></td>
    </tr>-->
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Username<span class="label_required">*</span></label></th>
      <td><input name="Username" type="text" class="validate[required]" value="<?php echo (($data['form_param']['Username']!="") ? $data['form_param']['Username'] : $data['content'][0]['Username']); ?>" size="20" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><label><input name="NewPassword" id="NewPassword" type="checkbox" value="1" /> Create a new password</label></td>
    </tr>
    <tbody id="NewPasswordBox" class="invisible">
    <tr>
      <th scope="row"><label>New Password<span class="label_required">*</span></label></th>
      <td><input name="Password" id="Password" type="password" class="validate[required,minSize[8]]" value="" size="20" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Confirm Password<span class="label_required">*</span></label></th>
      <td><input name="PasswordConfirm" id="PasswordConfirm" class="validate[required,equals[Password]]" type="password" value="" size="20" /></td>
    </tr>
    </tbody>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <?php if(isset($_SESSION['agent']['Name'])===TRUE && empty($_SESSION['agent']['Name'])===FALSE){ ?>
    <tr>
      <th scope="row"><label>Mobile No</label></th>
      <td><input name="MobileNo" type="text" class="validate[custom[mobileNo],minSize[9]]" value="<?php echo (($data['form_param']['MobileNo']!="") ? $data['form_param']['MobileNo'] : $data['content'][0]['MobileNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0192255667)</span>


          <input name="PhoneNo" type="hidden" value="<?php echo (($data['form_param']['PhoneNo']!="") ? $data['form_param']['PhoneNo'] : $data['content'][0]['PhoneNo']); ?>" />
          <input name="FaxNo" type="hidden" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" />
          <input name="Chat" type="hidden" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['Chat'] : $data['content'][0]['Chat']); ?>" />
          <input name="Remark" type="hidden" value="<?php echo (($data['form_param']['Remark']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['Remark']); ?>" />

      </td>
    </tr>
    <?php } ?>
    <?php /* ?>
    <tr>
      <th scope="row"><label>Phone No</label></th>
      <td><input name="PhoneNo" type="text" class="validate[custom[phoneNo],minSize[9]]" value="<?php echo (($data['form_param']['PhoneNo']!="") ? $data['form_param']['PhoneNo'] : $data['content'][0]['PhoneNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Fax No</label></th>
      <td><input name="FaxNo" type="text" class="validate[custom[faxNo],minSize[9]]" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" size="20" maxlength="15" /><span class="label_hint">(e.g. 0320540000)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>IP Address<span class="label_required">*</span></label></th>
      <td><input name="IPAddress" type="text" class="validate[required]" value="<?php echo (($data['form_param']['IPAddress']!="") ? $data['form_param']['IPAddress'] : $data['content'][0]['IPAddress']); ?>" size="20" disabled="disabled" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Chat</label></th>
      <td><textarea name="Chat" rows="4" class="validate[] full_width"><?php echo (($data['form_param']['Chat']!="") ? $data['form_param']['Chat'] : $data['content'][0]['Chat']); ?></textarea></td>
    </tr>
    <?php */ ?>
    <tr>
      <th scope="row"><label>Remark</label></th>
      <td><textarea name="Remark" rows="4" class="validate[] full_width"><?php echo (($data['form_param']['Remark']!="") ? $data['form_param']['Remark'] : $data['content'][0]['Remark']); ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email<span class="label_required">*</span></label></th>
      <td><input name="Email" type="text" class="validate[required,custom[email]]" value="<?php echo (($data['form_param']['Email']!="") ? $data['form_param']['Email'] : $data['content'][0]['Email']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 1</label></th>
      <td><input name="PlatformEmail1" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail1']!="") ? $data['form_param']['PlatformEmail1'] : $data['content'][0]['PlatformEmail1']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 2</label></th>
      <td><input name="PlatformEmail2" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail2']!="") ? $data['form_param']['PlatformEmail2'] : $data['content'][0]['PlatformEmail2']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 3</label></th>
      <td><input name="PlatformEmail3" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail3']!="") ? $data['form_param']['PlatformEmail3'] : $data['content'][0]['PlatformEmail3']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 4</label></th>
      <td><input name="PlatformEmail4" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail4']!="") ? $data['form_param']['PlatformEmail4'] : $data['content'][0]['PlatformEmail4']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 5</label></th>
      <td><input name="PlatformEmail5" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail5']!="") ? $data['form_param']['PlatformEmail5'] : $data['content'][0]['PlatformEmail5']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 6</label></th>
      <td><input name="PlatformEmail6" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail6']!="") ? $data['form_param']['PlatformEmail6'] : $data['content'][0]['PlatformEmail6']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 7</label></th>
      <td><input name="PlatformEmail7" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail7']!="") ? $data['form_param']['PlatformEmail7'] : $data['content'][0]['PlatformEmail7']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 8</label></th>
      <td><input name="PlatformEmail8" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail8']!="") ? $data['form_param']['PlatformEmail8'] : $data['content'][0]['PlatformEmail8']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 9</label></th>
      <td><input name="PlatformEmail9" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail9']!="") ? $data['form_param']['PlatformEmail9'] : $data['content'][0]['PlatformEmail9']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Agent Email 10</label></th>
      <td><input name="PlatformEmail10" type="text" class="validate[custom[email]]" value="<?php echo (($data['form_param']['PlatformEmail10']!="") ? $data['form_param']['PlatformEmail10'] : $data['content'][0]['PlatformEmail10']); ?>" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span></td>
    </tr>
    <?php /* >
    <tr>
      <th scope="row"><label>Background Color</label></th>
      <td><input name="BackgroundColour" type="text" class="validate[] cpicker disabled" readonly="readonly" value="<?php echo (($data['form_param']['BackgroundColour']!="") ? $data['form_param']['BackgroundColour'] : $data['content'][0]['BackgroundColour']); ?>" size="30" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Font Color</label></th>
      <td><input name="FontColour" type="text" class="validate[] cpicker disabled" readonly="readonly" value="<?php echo (($data['form_param']['FontColour']!="") ? $data['form_param']['FontColour'] : $data['content'][0]['FontColour']); ?>" size="30" /></td>
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
        <input name="Logo" type="file" class="disabled" readonly="readonly" />
        <br />
        <span class="label_hint">(Only images are allowed: .jpg, .jpeg, .png, .gif)</span></td>
    </tr><?php */ ?>
    <tr>
      <th scope="row">
          <input name="BackgroundColour" type="hidden" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['FaxNo'] : $data['content'][0]['FaxNo']); ?>" />
          <input name="FontColour" type="hidden" value="<?php echo (($data['form_param']['FaxNo']!="") ? $data['form_param']['Chat'] : $data['content'][0]['Chat']); ?>" />
      </th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"
              <?php if ($data['form_param']['Enabled']!="") { ?>
              <?php if ($data['content_param']['enabled_list'][$i]['ID']==$data['form_param']['Enabled']) { ?>selected="selected"<?php } ?>
              <?php } else { ?>
              <?php if ($data['content_param']['enabled_list'][$i]['ID']==$data['content'][0]['Enabled']) { ?>selected="selected"<?php } ?>
              <?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
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

        <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/editindex">
        <input type="button" value="Cancel" class="button" />
        </a>
       </td>
    </tr>
  </table>
</form>
