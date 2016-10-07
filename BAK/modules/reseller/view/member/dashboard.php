<div id="member_dashboard">
    <p>Welcome to your dashboard! Here you can view and manage all aspects of your account.</p>
    <table class="table_pet">
    	<!-- <tr>
    		<th>Main Wallet</th>
    	</tr> -->
    	<tr>
            <td style="vertical-align: top;">
          	<?php for ($i=0; $i <$data['content2']['main']['count']; $i++) { ?>
              <?php echo $data['content2']['main'][$i]['Name']; ?>:&nbsp; <span class="float-right">MYR <?php echo $data['content2']['main'][$i]['WalletTotal'];?></span><br />
          	<?php } ?>
            </td>
    	</tr>
    </table>
    <br />
    <table class="table_pet" style="width:100%">
  <tr>
      <th>Online Casino</th>
      <th>Soccer</th>
      <th>Horse Racing</th>
      
  </tr>
  <tr>
      <td style="vertical-align: top;">
          <?php for ($i=0; $i <$data['content2']['casino']['count']; $i++) { ?>
              <?php echo $data['content2']['casino'][$i]['Name']; ?>: <span class="float-right">MYR <?php echo $data['content2']['casino'][$i]['WalletTotal'];?></span><br />
          <?php } ?>
      </td>
      <td style="vertical-align: top;">
          <?php for ($i=0; $i <$data['content2']['soccer']['count']; $i++) { ?>
              <?php echo $data['content2']['soccer'][$i]['Name']; ?>: <span class="float-right">MYR <?php echo $data['content2']['soccer'][$i]['WalletTotal'];?></span><br />
          <?php } ?>
      </td>
      <td style="vertical-align: top;">
          <?php for ($i=0; $i <$data['content2']['horse']['count']; $i++) { ?>
              <?php echo $data['content2']['horse'][$i]['Name']; ?>: <span class="float-right">MYR <?php echo $data['content2']['horse'][$i]['WalletTotal'];?></span><br />
          <?php } ?>
      </td>
      
  </tr>
</table>
<br /><br />
    <div id="member_dashboard_box">
    	<div class="member_dashboard_box">
        <h2>Manage My Account</h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/reseller/dashboard">Dashboard</a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/reseller/profile">My Profile</a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/member/reseller/password">Change Password</a></li>
        </ul>
    </div>
    <div class="member_dashboard_box">
        <h2>View My Members and Member Transactions</h2>
        <ul>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/transfer">My Members</a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/withdrawal">My Members' Wallet</a></li>
            <li><a href="<?php echo $data['config']['SITE_DIR']; ?>/reseller/transaction/index">My Members' Transaction</a></li>
        </ul>
    </div>
    </div>
</div>
<p>&nbsp;</p>