<div class="common_block merchant_block">
    <h1>Customer Orders</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/order/index">Order History</a></li>
    </ul>
</div>
<div class="common_block merchant_block">
    <h1>My Store</h1>
    <ul>
    	<?php if($_SESSION['merchant']['Type'] != ''){ ?>
	        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/listing/index">Manage Directory Listings</a></li>
   
        <?php } ?>
        		
        <?php if($_SESSION['merchant']['Type'] == 2 || $_SESSION['merchant']['Type'] == 3){ ?>
	    		
	        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchantdeal/index">Manage Deals</a></li>
	        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/booking/index">Manage Bookings</a></li>
		        
	    <?php } ?>
            
        <?php if($_SESSION['merchant']['Type'] == 3){ ?>
	        	
	        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/ad/index">Manage Ads</a></li>
	    <?php } ?>
        	
        <?php if($_SESSION['merchant']['Type'] == 2){ ?>
        		
		    You need upgrade to Premier membership before you can use store paid Advertisement feature(s)
		<?php } ?>	
		
		<?php if($_SESSION['merchant']['Type'] == 1){ ?>
        		
		    You need upgrade to Standard or Premier membership before you can use store paid feature(s)
		<?php } ?>
		 
    </ul>
</div>



<!--<div class="common_block member_block">

    <h1>My Membership</h1>


    <div style="font-size:15px; font-family:'SourceSansProBold';"><?php echo $_SESSION['merchant']['Type']; ?></div>-->


    <?php //if ($_SESSION['merchant']['Type']=="1") { ?>


    <!--<form name="renewal_form" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm" method="post">


        <input type="hidden" name="OrderType" id="OrderType" value="Standard Membership" />


        <input type="hidden" name="OrderItem" id="OrderItem" value="Standard Membership Renewal - One Year" />


        <input type="hidden" name="OrderAmount" id="OrderAmount" value="<?php echo $data['config']['STANDARD_MEMBER_RENEWAL_FEE']; ?>" />


        <input type="hidden" name="OrderKey" id="OrderKey" value="aseanfnb" />


        <input type="hidden" name="OrderDelivery" id="OrderDelivery" value="standard-membership-renew" />


        <input type="hidden" name="OrderTrigger" id="OrderTrigger" value="1" />


        <input type="hidden" name="RedirectURL" id="RedirectURL" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />





        <?php if (date('Y-m-d')>$_SESSION['merchant']['Expiry']) { // If expired  ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day')); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />


        <p class="expiry_box">Expired on <?php echo $_SESSION['merchant']['ExpiryText']; ?>


            <span class="renew_button_box">(<input class="link_submit" type="submit" name="submit" value="Renew" />)</span>


        </p>


        <?php } else { ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day', strtotime($_SESSION['merchant']['ExpiryText']))); ?> to <?php echo date('d-m-Y',strtotime('+1 year', strtotime($_SESSION['merchant']['Expiry']))); ?>)" />


        <p class="expiry_box">Active until <?php echo $_SESSION['merchant']['ExpiryText']; ?>


            <?php if (strtotime($_SESSION['merchant']['Expiry'])<=strtotime('+30 days')) { ?>


            <span class="renew_button_box">(<input class="link_submit" type="submit" name="submit" value="Renew" />)</span>


            <?php } ?>


        </p>


        <?php } ?>        


    </form>


    <?php //} ?>


    <?php if ($_SESSION['merchant']['Type']=="0") { ?>


        <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/profileupgradeprocess">Upgrade to Member &raquo;</a>


    <?php } ?>


</div>-->













<?php if($this->action != "confirm"){ ?>
<div class="common_block merchant_block">
    <h1>My Membership</h1>
    
    	<a href="<?php echo $data['config']['SITE_URL']; ?>/main/staticpage/membershipcomparison">Compare Memberships</a>
    	<div style="font-size:15px; font-family:'SourceSansProBold';">
    		<?php if($_SESSION['merchant']['Type']=='2'){
    			
    		    echo 'Standard Membership';
				
			}elseif($_SESSION['merchant']['Type']=='3'){
				
				echo 'Premier Membership';
				
			}elseif($_SESSION['merchant']['Type']=='1'){
				
				echo 'Basic Membership';
				
			} 
    		?>
    	</div>


    <?php if ($_SESSION['merchant']['Type']=="2") { ?>

	<!--<a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/standardprofileupgradeprocess">Upgrade to Standrd Membership</a>-->
     
    <form name="renewal_form" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm" method="post">


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





        <?php if (date('Y-m-d')>$_SESSION['merchant']['Expiry']) { // If expired  ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Standard Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day')); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />


        <p class="expiry_box">Expired on <?php echo $_SESSION['merchant']['ExpiryText']; ?>


            <span class="renew_button_box">(<input class="link_submit" type="submit" name="submit" value="Renew" />)</span>


        </p>


        <?php } else { ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Standard Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['STANDARD_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day', strtotime($_SESSION['merchant']['ExpiryText']))); ?> to <?php echo date('d-m-Y',strtotime('+1 year', strtotime($_SESSION['merchant']['Expiry']))); ?>)" />


        <p class="expiry_box">Active until <?php echo $_SESSION['merchant']['ExpiryText']; ?>


            <?php if (strtotime($_SESSION['merchant']['Expiry'])<=strtotime('+30 days')) { ?>


            <span class="renew_button_box">(<input class="link_submit" type="submit" name="submit" value="Renew" />)</span>


            <?php } ?>


        </p>


        <?php } ?>        


    </form>

	<a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/premierprofileupgradeprocess">Upgrade to Premier Membership</a>
    <?php } ?>
    
    <?php if ($_SESSION['merchant']['Type']=="3") { ?>


    <form name="renewal_form" action="<?php echo $data['config']['SITE_URL']; ?>/cart/order/confirm" method="post">


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





        <?php if (date('Y-m-d')>$_SESSION['merchant']['Expiry']) { // If expired  ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Premier Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['PREMIER_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day')); ?> to <?php echo date('d-m-Y',strtotime('+1 year')); ?>)" />


        <p class="expiry_box">Expired on <?php echo $_SESSION['merchant']['ExpiryText']; ?>


            <span class="renew_button_box">(<input class="link_submit" type="submit" name="submit" value="Renew" />)</span>


        </p>


        <?php } else { ?>


        <input type="hidden" name="OrderDesc" id="OrderDesc" value="Premier Annual Membership Fee (RM<?php echo Helper::displayCurrency($data['config']['PREMIER_MEMBER_RENEWAL_FEE']); ?>) (Period: <?php echo date('d-m-Y',strtotime('+1 day', strtotime($_SESSION['merchant']['ExpiryText']))); ?> to <?php echo date('d-m-Y',strtotime('+1 year', strtotime($_SESSION['merchant']['Expiry']))); ?>)" />


        <p class="expiry_box">Active until <?php echo $_SESSION['merchant']['ExpiryText']; ?>


            <?php if (strtotime($_SESSION['merchant']['Expiry'])<=strtotime('+30 days')) { ?>


            <span class="renew_button_box">(<input class="link_submit" type="submit" name="submit" value="Renew" />)</span>


            <?php } ?>


        </p>


        <?php } ?>        


    </form>


    <?php } ?>


    <?php if ($_SESSION['merchant']['Type']=="1") { ?>


        <!--<a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/profileupgradeprocess">Upgrade to Member &raquo;</a>-->
        <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/standardprofileupgradeprocess">Upgrade to Standrd Membership</a>
        <a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/premierprofileupgradeprocess">Upgrade to Premier Membership</a>
       


    <?php } ?>

  
</div>
<?php } ?>  
<div class="common_block merchant_block">
    <h1>My Account</h1>
    <ul>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/dashboard">Dashboard</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/profile">My Profile</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchantaddress/index">My Addresses</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/password">Change Password</a></li>
        <li><a href="<?php echo $data['config']['SITE_URL']; ?>/merchant/merchant/logout">Log Out</a></li>
    </ul>
</div>
<?php Core::getHook('left-column'); ?>