<!-- Admin Navigation Menu -->
<ul class="sf-menu">
	<li class="current">
		<a href="#">Home</a>
		<ul>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/dashboard">Dashboard</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/profile">My Profile</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/password">Change Password</a>
			</li>
		</ul>
	</li>
	<?php if ($_SESSION['admin']['Profile']=='1') { ?>
	<!--<li>
		<a href="#">Content</a>
		<ul>
			<li>
				<a href="#">Pages</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/page/index?page=all">View Pages</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/page/add">Create Page</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Banners</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/banner/index?page=all">View Banners</a>
					</li>

					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/banner/add">Create Banner</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>-->
	<?php } ?>
	<li>
		<a href="#">Members</a>
		<ul>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/member/index?page=all">View Members</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/member/add">Create Member</a>
			</li>
		</ul>

	</li>
	<?php if ($_SESSION['admin']['Profile']=='1') { ?>
	<li>
		<a href="#">Products</a>
		<ul>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/index?page=all">View Products</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/product/add">Create Product</a>
			</li>
			<li>
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/producttype/index?page=all">View Product Types</a>
            </li>
            <li>
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/producttype/add">Create Product Type</a>
            </li>
		</ul>
	</li>
    <!--<li>
        <a href="#">Product Types</a>
        <ul>
            
        </ul>
    </li>-->
	<?php } ?>
	<li>
		<a href="#">Transactions</a>
		<ul>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/index?page=all">View Transactions</a>
			</li>
                        <?php if($_SESSION['admin']['Profile']!='2'){ ?>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/add">Create Transaction</a>
			</li>
                        <?php } ?>
		</ul>
	</li>
	<li>
		<a href="#">Wallets</a>
		<ul>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/index?page=all">View Wallets</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/wallet/add">Create Wallet</a>
			</li>
		</ul>
	</li>
        <?php if ($_SESSION['admin']['Profile']!='2') { ?>
	<li>
		<a href="#">Agent</a>
		<ul>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/index?page=all">View Agents</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/add">Create Agents</a>
			</li>
            <li>
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentcredit/index?page=all">Agents Credit Transactions</a>
            </li>
            <li>
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/agent">View Report By Agents</a>
            </li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/report">View Report By Month</a>
			</li>
                        <li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agenttype/index?page=all">View Agent Types</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/index?page=all">View Agent Promotions</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/add">Create Agent Promotion</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentblock/index?page=all">View Agent Blocks</a>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentblock/add">Create Agent Block</a>
			</li>
                        <li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/affiliatedreporting">View Affiliate Report</a>
			</li>
                        <li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/agentlist">View Agent List</a>
			</li>
		</ul>
                
	</li>
        
      <li><a href="#">Bankin Slips</a>
        <ul>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/bankinslip/index?page=all">View Bankin Slips</a></li>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/bankinslip/add">Create Bankin Slip</a></li>
        </ul>
      </li>
      <li><a href="#">Bank Infos</a>
        <ul>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/bankinfo/index?page=all">View Bank Infos</a></li>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/bankinfo/add">Create Bank Info</a></li>
        </ul>
      </li>
      <li><a href="#">Reject Messages</a>
        <ul>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/rejectmessage/index?page=all">View Reject Messages</a></li>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/rejectmessage/add">Create Reject Message</a></li>
        </ul>
      </li>
        <?php } ?>
	<!--<li>
		<a href="#">Messages</a>
		<ul>
			<li>
				<a href="#">Messages</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/index?page=all">View Messages</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/message/add">Create Message</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Message Statuses</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/messagestatus/index?page=all">View Message Statuses</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/messagestatus/add">Create Message Status</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>-->
    <?php if ($_SESSION['admin']['Profile']=='1') { ?>
	<li>
		<a href="#">Staff</a>
		<ul>
			<li>
				<a href="#">Staff</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/viewall/?page=all">View Staff</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/staff/add">Create Staff</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Profiles</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/profile/index?page=all">View Profiles</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/profile/add">Create Profile</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/permission/manage?page=all">Permissions</a>
			</li>
			<li>
				<a href="#">Announcements</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/announcement/index?page=all">View Announcements</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/announcement/add">Create Announcement</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/stafflog/index?page=all">Access Log</a>
			</li>
		</ul>
	</li>
        <li>
		<a href="#">Operator &AMP; Analyst</a>
		<ul>
			<li>
                            <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/operator/index?page=all">View Operator &AMP; Analyst</a>			
			</li>
                        <li>
                            <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/operator/add">Create Operator &AMP; Analyst</a>			
			</li>
                </ul>        
        </li>
        <?php if($_SERVER['REMOTE_ADDR'] == '60.53.223.103'){ ?>
        <li>
		<a href="#">Analyst</a>
		<ul>
			<li>
                            <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/analyst/index?page=all">View Analyst</a>			
			</li>
                        <li>
                            <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/analyst/add">Create Analyst</a>			
			</li>
                </ul>        
        </li>
    <?php } ?>
	<!--<li>
		<a href="#">Resources</a>
		<ul>
			<li>
				<a href="#">Countries</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/country/index?page=all">View Countries</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/country/add">Create Country</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">States</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/state/index?page=all">View States</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/state/add">Create State</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>-->
	<li>
		<a href="#">Theme Settings</a>
		<ul>
			<!--<li>
				<a href="#">Menu</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menu/index?page=all">View Menus</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/menu/add">Create Menu</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Themes</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/theme/index?page=all">View Themes</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/theme/add">Create Theme</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Templates</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/template/index?page=all">View Templates</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/template/add">Create Template</a>
					</li>
				</ul>
			</li>-->
			<li>
				<a href="#">Blocks</a>
				<ul>
					<li>
						<a href="#">Blocks</a>
						<ul>

							<li>
								<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/index?page=all">View Blocks</a>
							</li>

							<li>
								<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/block/add">Create Block</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Block Types</a>
						<ul>
							<li>
								<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/blocktype/index?page=all">View Block Types</a>
							</li>
							<li>
								<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/blocktype/add">Create Block Type</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Area</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/area/index?page=all">View Areas</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/area/add">Create Area</a>
					</li>
				</ul>
			</li>
		</ul>
	</li>
	<li>
		<a href="#">Site Settings</a>                
		<ul> 
                    <li>
				<a href="#">Announcement Ticker</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/announcementticker/index?page=all">View Announcement Ticker</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/announcementticker/add">Create Announcement Ticker</a>
					</li>
				</ul>
			</li>
                    <li>
				<a href="#">App</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/app/index?page=all">View Apps</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/app/add">Create App</a>
					</li>
				</ul>
			</li>
                    
			<li>
				<a href="#">Config</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/config/index?page=all">View Config</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/config/add">Create Config</a>
					</li>
				</ul>
			</li>
                        <li><a href="#">Guide Promotion</a>
                            <ul>
                              <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/guidepromotion/index?page=all">View Guide Promotion</a></li>
                              <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/guidepromotion/add">Create Guide Promotion</a></li>
                            </ul>
                        </li>
			<li>
				<a href="#">Modules</a>
				<ul>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/module/index?page=all">View Modules</a>
					</li>
					<li>
						<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/module/add">Create Module</a>
					</li>
				</ul>
			</li>
      <li><a href="#">Module Translations</a>
        <ul>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/index?page=all">View Module Translations</a></li>
          <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/moduletranslation/add">Create Module Translation</a></li>
        </ul>
      </li>
			<li>
				<a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/generator/index">Generator</a>
			</li>
                        <li>
                                <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/translation/index?page=all">Translation</a>
                        </li>
                        <li>
                                <a href="<?php echo $data['config']['SITE_URL']; ?>/admin/language/index?page=all">Language</a>
                        </li>
		</ul>
	</li>
	<?php } ?>
</ul>
<div class="clear"></div>