<div class="bg-header">
	<div id="home-input" style="background: #efefef;padding: 5px 10px">
	<?php if($_SESSION['agent']['ID']=="") { ?>
	<?php } else { ?>
            
            <?php if($_SESSION['agent']['operator']['ProfileName']!='Analyst'){ ?>
            <div class="welcome">Welcome, <span id="nameBold"><?php if(isset($_SESSION['agent']['Name'])===TRUE && empty($_SESSION['agent']['Name'])===FALSE){ echo $_SESSION['agent']['Name'];?></span>.&nbsp;&nbsp;&nbsp;My Real Balance (MYR): <?php Core::getHook('Credit-Balance'); ?><?php }elseif(isset($_SESSION['agent']['operator']['ProfileID'])===TRUE && empty($_SESSION['agent']['operator']['ProfileID'])===FALSE){ echo $_SESSION['agent']['operator']['Username']; ?>&nbsp;&nbsp;&nbsp;<?php } ?></div>
        
        <div id="member_in_box"><a href="/agent/agent/dashboard">Dashboard</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/member/group?page=all">
        	
        	<?php if($_SESSION['agent']['AgentTypeID']== '1'){?>
            	Group Members</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/group?page=all">Group Transactions</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/wallet/index?page=all">Wallets</a>&nbsp;
            	<?php }else{?>
            	<!---->
            <?php } ?>
            
            
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/agentlist">Agent List</a>&nbsp;
            
            <?php if(isset($_SESSION['agent']['operator']['ProfileID'])===false && empty($_SESSION['agent']['operator']['ProfileID'])===true){ ?>   
            <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/downline">Downline Agents</a>&nbsp;
            <?php } ?>
                <?php if(isset($_SESSION['agent']['operator']['ProfileID'])===false && empty($_SESSION['agent']['operator']['ProfileID'])===true){ ?>
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting?page=all">Affiliate Report</a>&nbsp;
                
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/report?page=all">Monthly Report</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/agent?page=all">Agents Report</a>&nbsp; 
                <!--<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/bankinfo/index?page=all">Agent Bank Info</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentblock/index?page=all">Agent Blocks</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentpromotion/index?page=all">Promotion</a>&nbsp;-->
                
                <a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentcredit/group?page=all">Group Credit Balance</a>&nbsp;<!--<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/announcementticker/index?page=all">Announcement Ticker</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/guidepromotion/index?page=all">Guide Promotion</a>-->
                <?php } ?>
				
            <?php if($_SESSION['agent']['AgentTypeID']== '1'){?>
            	<a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/member/index?page=all">Personal Members</a>&nbsp;<a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index?page=all">Personal Transactions</a>&nbsp;
            	<?php }else{?>
            	<!--<a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/member/index?page=all">Personal Members</a>&nbsp;<a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index?page=all">Personal Transactions</a>&nbsp;-->
            <?php } ?>
                <?php if(isset($_SESSION['agent']['operator']['ProfileID'])===false && empty($_SESSION['agent']['operator']['ProfileID'])===true){ ?>
               <?php if($_SESSION['agent']['TypeID']=='1'){ ?><a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/operator/index?page=all">My Operator &AMP; Analysts</a><?php } ?>
                <?php } ?>
               
            <?php if($_SESSION['agent']['TypeID']=='1' || $_SESSION['agent']['TypeID']=='2'){ ?>
                <a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/profile">Profile</a>
                    <?php }else{ ?>
                <a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/profileview">Profile</a>
            <?php } ?>
                
            &nbsp;<?php if(isset($_SESSION['agent']['operator']['ProfileID'])===false && empty($_SESSION['agent']['operator']['ProfileID'])===true){ ?>
            <a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/password">Change Password</a>&nbsp;
            <?php } ?>
            <a class="personal" href="/agent/agent/logout">Log Out</a>
            <?php if(isset($_SESSION['agent']['operator']['ProfileID'])===false && empty($_SESSION['agent']['operator']['ProfileID'])===true){ ?>
                <a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agentcredit/index?page=all">Credit Balance</a>
                
            <?php } ?> 
            
               </div>
            <?php } elseif($_SESSION['agent']['operator']['ProfileName']=='Analyst') { ?>
            <div class="welcome">Welcome, <span id="nameBold"><?php if(isset($_SESSION['agent']['Name'])===TRUE && empty($_SESSION['agent']['Name'])===FALSE){ echo $_SESSION['agent']['Name'];?></span>.&nbsp;&nbsp;&nbsp;My Real Balance (MYR): <?php Core::getHook('Credit-Balance'); ?><?php }elseif(isset($_SESSION['agent']['operator']['ProfileID'])===TRUE && empty($_SESSION['agent']['operator']['ProfileID'])===FALSE){ echo $_SESSION['agent']['operator']['Username']; ?>&nbsp;&nbsp;&nbsp;<?php } ?></div>
        <div id="member_in_box"><a href="/agent/agent/dashboard">Dashboard</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/group?page=all">Group Transactions</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/agentlist">Agent List</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/affiliatedreporting?page=all">Affiliate Report</a>&nbsp;<a href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/report?page=all">Monthly Report</a>&nbsp;<a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/transaction/index?page=all">Personal Transactions</a>&nbsp;<a class="personal" href="<?php echo $data['config']['SITE_DIR']; ?>/agent/agent/profileview">Profile</a>&nbsp;<a class="personal" href="/agent/agent/logout">Log Out</a></div>
            <?php } ?>
	<?php } ?>
	</div>
</div>