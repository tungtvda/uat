<?php if ($data['page']['merchant_delete']['ok']==1) { ?>
<div class="notify">Merchant deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_noMobile"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" Mobilespacing="0" Mobilepadding="0">
	      <tr>
	        <th scope="row"><label>Name</label></th>
	        <td><select name="MerchantID" class="chosen_simple">
	            <option value="" selected="selected">All Name</option>
	            <?php for ($i=0; $i<$data['content_param']['merchant_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['merchant_list'][$i]['ID']; ?>" <?php if ($_SESSION['merchant_DealerIndex']['param']['MerchantID']==$data['content_param']['merchant_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['merchant_list'][$i]['Name']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Email</label></th>
	        <td><input name="Email" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['Email']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Company</label></th>
            <td><input name="Company" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['Company']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Mobile No</label></th>
	        <td><input name="MobileNo" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['MobileNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Gender</label></th>
	        <td><select name="GenderID" class="chosen_simple">
	            <option value="" selected="selected">All Gender</option>
	            <?php for ($i=0; $i<$data['content_param']['gender_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['gender_list'][$i]['ID']; ?>" <?php if ($_SESSION['merchant_DealerIndex']['param']['GenderID']==$data['content_param']['gender_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['gender_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Profile Type</label></th>
	        <td><select name="TypeID" class="chosen_simple">
	            <option value="" selected="selected">All Profile</option>
	            <?php for ($i=0; $i<$data['content_param']['merchanttype_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['merchanttype_list'][$i]['ID']; ?>" <?php if ($_SESSION['merchant_DealerIndex']['param']['TypeID']==$data['content_param']['merchanttype_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['merchanttype_list'][$i]['Label']; ?></option>
	            <?php } ?>
	        </select></td>
	        
	      </tr>
	      <tr>
	        <th scope="row"><label>Date of Birth (From)</label></th>
	        <td><input name="DOBFrom" class="datepicker" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['DOBFrom']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Fax No</label></th>
	        <td><input name="FaxNo" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['FaxNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>Date of Birth (To)</label></th>
	        <td><input name="DOBTo" class="datepicker" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['DOBTo']; ?>" size="10" />
	          (dd-mm-yyyy)</td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Nationality</label></th>
	        <td><select name="Nationality" class="chosen_full">
	            <option value="" selected="selected">All Nationality</option>
	            <?php for ($i=0; $i<$data['content_param']['country_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['country_list'][$i]['ID']; ?>" <?php if ($data['content_param']['country_list'][$i]['ID']==$_SESSION['merchant_DealerIndex']['param']['Nationality']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['country_list'][$i]['NameShort']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
	        <th scope="row"><label>NRIC</label></th>
	        <td><input name="NRIC" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['NRIC']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Passport</label></th>
	        <td><input name="Passport" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['Passport']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th>Enabled</th>
	        <td><select name="Enabled" class="chosen_simple">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['merchant_DealerIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	        </select></td>
            <td>&nbsp;</td>
            <th scope="row"><label>Phone No</label></th>
	        <td><input name="PhoneNo" type="text" value="<?php echo $_SESSION['merchant_DealerIndex']['param']['PhoneNo']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	      </tr>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/index?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <div><strong>Dealer ID: <?php echo $_SESSION['dealer']['ID']; ?></strong></div>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><a href='/dealer/merchant/add/'>
    <input type="button" class="button" value="Create Merchant">
    </a><a href='<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/register/?dealer=<?php echo $_SESSION['dealer']['ID']; ?>'>
    <input type="button" class="button" value="Register for merchant">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="member_table" border="0" Mobilespacing="0" Mobilepadding="0">
  <tr>
    <th>Name</th>
    <th>Information</th>
    <th>Pay / Renew</th>
    <th class="center">Prompt</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td style="vertical-align: top"><div><span class="merchant_title"><?php echo $data['content'][$i]['Name']; ?></span><span class="merchant_dob">(<?php echo $data['content'][$i]['GenderID']; ?>)</span></div>
        <strong>Username:</strong><br /><?php echo $data['content'][$i]['Username']; ?><br /><br />
        <strong>Company:</strong><br /><?php echo $data['content'][$i]['Company']; ?>
    </td>
    <td style="vertical-align: top">
        <span class="merchant_inner_header">Date of Birth:</span> <?php echo $data['content'][$i]['DOB']; ?><br />
        <span class="merchant_inner_header">Nationality:</span> <?php echo $data['content'][$i]['Nationality']; ?><br />
        <?php if ($data['content'][$i]['NationalityID']=='151') { ?>
        <span class="merchant_inner_header">NRIC No:</span> <?php echo $data['content'][$i]['NRIC']; ?><br />
        <?php } else { ?>
        <span class="merchant_inner_header">Passport No:</span> <?php echo $data['content'][$i]['Passport']; ?><br />
        <?php } ?>
        <br />
        <span class="merchant_inner_header">Mobile No:</span> <?php echo $data['content'][$i]['MobileNo']; ?><br />
        <span class="merchant_inner_header">Phone No:</span> <?php echo $data['content'][$i]['PhoneNo']; ?><br />
        <span class="merchant_inner_header">Fax No:</span> <?php echo $data['content'][$i]['FaxNo']; ?><br />
        <span class="merchant_inner_header">Email:</span> <?php echo $data['content'][$i]['Email']; ?><br />
        <?php //if (strtotime($data['content'][$i]['Expiry'])<=strtotime('+30 days')) { ?>
        <span class="merchant_inner_header">Subscription:</span><?php if (strtotime($data['content'][$i]['Expiry'])<=strtotime('+30 days')) { ?>Expire soon<?php }else{ ?>Still look good
        	<?php } ?></td>
        
        
        
        <td>
        <a href="<?php echo $data['config']['SITE_URL']; ?>/main/staticpage/membershipcomparison">Compare Memberships</a><hr />
    	<div style="font-size:15px; font-family:'SourceSansProBold';">
    		<?php if($data['content'][$i]['TypeID']=='2'){
    			
    		    echo 'Standard Membership';
				
			}elseif($data['content'][$i]['TypeID']=='3'){
				
				echo 'Premier Membership';
				
			}elseif($data['content'][$i]['TypeID']=='1'){
				
				echo 'Basic Membership';
				
			} 
    		?>
    	</div>
    	<hr />
        <?php if ($data['content'][$i]['TypeID'] =="2") { ?>

	<!--<a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/standardprofileupgradeprocess">Upgrade to Standrd Membership</a>-->
     
    <form name="renewal_form" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm/<?php echo $data['content'][$i]['ID']; ?>" method="post">


        <input type="hidden" name="OrderType" id="OrderType" value="Standard Membership" />


        <input type="hidden" name="OrderItem" id="OrderItem" value=" Standard Membership Renewal" />


        <input type="hidden" name="OrderAmount" id="OrderAmount" value="<?php echo $data['config']['STANDARD_MEMBER_RENEWAL_FEE']; ?>" />


        <input type="hidden" name="OrderKey" id="OrderKey" value="aseanfnb" />


        <input type="hidden" name="OrderDelivery" id="OrderDelivery" value="standard-membership-renew" />


        <input type="hidden" name="OrderTrigger" id="OrderTrigger" value="1" />
        
        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_FEE']); ?>) (Period: <?php echo date('d-m-Y'); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />
    <input type="hidden" name="OrderDesc2" id="OrderDesc2" value="Two Year Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['TWO_STANDARD_MEMBER_FEE']); ?>) (Period: <?php echo date('d-m-Y'); ?> to <?php echo date('d-m-Y',strtotime('+2 year')); ?>)" />
    <input type="hidden" name="OrderAmount" id="OrderAmount" value="<?php echo $data['config']['STANDARD_MEMBER_FEE']; ?>" />
    <input type="hidden" name="OrderAmount2" id="OrderAmount2" value="<?php echo $data['config']['TWO_STANDARD_MEMBER_FEE']; ?>" />


        <input type="hidden" name="RedirectURL" id="RedirectURL" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />





        <?php if (date('Y-m-d')>$data['content'][$i]['Expiry']) { // If expired  ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Standard Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day')); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />


        Expired on <?php echo $data['content'][$i]['ExpiryText']; ?>


            (<input class="link_submit" type="submit" name="submit" value="Renew" />)


        


        <?php } else { ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Standard Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day', strtotime($_SESSION['merchant']['ExpiryText']))); ?> to <?php echo date('d-m-Y',strtotime('+1 year', strtotime($_SESSION['merchant']['Expiry']))); ?>)" />


        Active until <?php echo $data['content'][$i]['ExpiryText']; ?>


            <?php if (strtotime($data['content'][$i]['Expiry'])<=strtotime('+30 days')) { ?>


            (<input class="link_submit" type="submit" name="submit" value="Renew" />)


            <?php } ?>


        


        <?php } ?>        


    </form>
	
	<a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/premierprofileupgradeprocess/<?php echo $data['content'][$i]['ID']; ?>">Upgrade to Premier Membership</a>
    <?php } ?>
    
    <?php if ($data['content'][$i]['TypeID'] =="3") { ?>


    <form name="renewal_form" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm/<?php echo $data['content'][$i]['ID']; ?>" method="post">


        <input type="hidden" name="OrderType" id="OrderType" value="Premier Membership" />


        <input type="hidden" name="OrderItem" id="OrderItem" value="Premier Membership Renewal - One Year" />


        <input type="hidden" name="OrderAmount" id="OrderAmount" value="<?php echo $data['config']['PREMIER_MEMBER_RENEWAL_FEE']; ?>" />


        <input type="hidden" name="OrderKey" id="OrderKey" value="aseanfnb" />


        <input type="hidden" name="OrderDelivery" id="OrderDelivery" value="premier-membership-renew" />


        <input type="hidden" name="OrderTrigger" id="OrderTrigger" value="1" />
        
        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['PREMIER_MEMBER_FEE']); ?>) (Period: <?php echo date('d-m-Y'); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />
    <input type="hidden" name="OrderDesc2" id="OrderDesc2" value="Two Year Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['TWO_PREMIER_MEMBER_FEE']); ?>) (Period: <?php echo date('d-m-Y'); ?> to <?php echo date('d-m-Y',strtotime('+2 year')); ?>)" />
    <input type="hidden" name="OrderAmount" id="OrderAmount" value="<?php echo $data['config']['PREMIER_MEMBER_FEE']; ?>" />
    <input type="hidden" name="OrderAmount2" id="OrderAmount2" value="<?php echo $data['config']['TWO_PREMIER_MEMBER_FEE']; ?>" />


        <input type="hidden" name="RedirectURL" id="RedirectURL" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />





        <?php if (date('Y-m-d')>$data['content'][$i]['Expiry']) { // If expired  ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Premier Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['PREMIER_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day')); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />


        Expired on <?php echo $data['content'][$i]['ExpiryText']; ?>


            (<input class="link_submit" type="submit" name="submit" value="Renew" />)


        


        <?php } else { ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Premier Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['PREMIER_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day', strtotime($_SESSION['merchant']['ExpiryText']))); ?> to <?php echo date('d-m-Y',strtotime('+1 year', strtotime($_SESSION['merchant']['Expiry']))); ?>)" />


        Active until <?php echo $data['content'][$i]['ExpiryText']; ?>


            <?php if (strtotime($data['content'][$i]['Expiry'])<=strtotime('+30 days')) { ?>


            (<input class="link_submit" type="submit" name="submit" value="Renew" />)


            <?php } ?>


        


        <?php } ?>        


    </form>


    <?php } ?>
        
    <?php if ($data['content'][$i]['TypeID']=="1") { ?>


        <!--<a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/profileupgradeprocess">Upgrade to Member &raquo;</a>-->
        <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/standardprofileupgradeprocess/<?php echo $data['content'][$i]['ID']; ?>">Upgrade to Standrd Membership</a><hr />
        <a href="<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/premierprofileupgradeprocess/<?php echo $data['content'][$i]['ID']; ?>">Upgrade to Premier Membership</a><hr />


    <?php } ?>
        
  
</div>
  
        
     </td>   
        
        
        
    <td class="center"><?php echo $data['content'][$i]['Prompt']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/dealer/merchant/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
