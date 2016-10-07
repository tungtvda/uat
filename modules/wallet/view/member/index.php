<?php if ($_SESSION['superid']=='1') { ?>
<table>
    <tr>
        <td>
        <?php for ($i=0; $i <$data['main_wallet']['count']; $i++) { ?>
          <?php echo $data['main_wallet'][$i]['Name']; ?>:&nbsp; <span>MYR <?php echo $data['main_wallet'][$i]['WalletTotal'];?></span><br />
        <?php } ?>
        </td>
    </tr>
</table>
<div id="table_wrapper">
<?php for ($z=0; $z<$data['content']['count']; $z++) { ?>
    <?php if ($data['content'][$z][0]['Type']!="Main Wallet" && $data['content'][$z][0]['Type']!="Dompet Utama" && $data['content'][$z][0]['Type']!="主要钱包") { ?>
    <h6>
        <?php echo $data['content'][$z][0]['Type']; ?>
    </h6>
    <?php if ($data['content_param']['count']>0) { ?>
        <div class="row bg_table hide-for-small-only" data-equalizer>
            <div class="small-12 medium-4 large-4 columns" data-equalizer-watch><?php echo Helper::translate("Product", "member-wallet-product"); ?></div>
            <div class="small-12 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php echo Helper::translate("Username", "member-wallet-username"); ?></div>
            <div class="small-12 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php echo Helper::translate("Password", "member-wallet-password"); ?></div>
            <div class="small-12 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php echo Helper::translate("Pin Number", "member-wallet-pinnumber"); ?></div>
            <div class="small-12 small-text-center medium-2 large-2 columns text_right" data-equalizer-watch><?php echo Helper::translate("Link", "member-wallet-link"); ?></div>
        </div>


          <?php if($data['content'][$z][0]['count']>0){ ?>
         <?php for ($i=0; $i<$data['content'][$z][0]['count']; $i++) { ?>
        <div class="row bg_table disappear show-for-small-only" data-equalizer>
            <div class="small-12 medium-4 large-4 columns"><?php echo $data['content'][$z][$i]['ProductID']; ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns disappear show-for-small-only" data-equalizer-watch><?php echo Helper::translate("Username", "member-wallet-username"); ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns disappear show-for-small-only" data-equalizer-watch><?php echo Helper::translate("Password", "member-wallet-password"); ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns disappear show-for-small-only" data-equalizer-watch><?php echo Helper::translate("Pin Number", "member-wallet-pinnumber"); ?></div>
        </div>
        <div class="row bg_table disappear show-for-small-only" data-equalizer>
            <div class="small-4 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php  if($data['content'][$z][$i]['Username']==""){ echo Helper::translate("Processing", "member-wallet-processing");}else{ echo $data['content'][$z][$i]['Username']; } ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php  if($data['content'][$z][$i]['Password']==""){ echo Helper::translate("Processing", "member-wallet-processing"); }else{ echo $data['content'][$z][$i]['Password'];} ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php  if($data['content'][$z][$i]['PIN']==""){ echo Helper::translate("Not Available", "member-wallet-notavailable");}else{ echo $data['content'][$z][$i]['PIN']; } ?></div>
            <div class="small-12 small-text-center medium-2 large-2 columns text_right" style="background-color: #FF0000;"><a onclick="openWin('<?php echo $data['content'][$z][$i]['PlayNow'][0]['PlayLink']; ?>');return false;"><?php echo Helper::translate("Play Now", "member-wallet-play"); ?></a></div>
        </div>
        <hr class="disappear show-for-small-only" />



        <div class="row bg_table hide-for-small-only" data-equalizer>
            <div class="small-12 medium-4 large-4 columns" data-equalizer-watch><?php echo $data['content'][$z][$i]['ProductID']; ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php  if($data['content'][$z][$i]['Username']==""){ echo Helper::translate("Processing", "member-wallet-processing");}else{ echo $data['content'][$z][$i]['Username']; } ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php  if($data['content'][$z][$i]['Password']==""){ echo Helper::translate("Processing", "member-wallet-processing"); }else{ echo $data['content'][$z][$i]['Password'];} ?></div>
            <div class="small-4 small-text-center medium-2 large-2 columns" data-equalizer-watch><?php  if($data['content'][$z][$i]['PIN']==""){ echo Helper::translate("Not Available", "member-wallet-notavailable");}else{ echo $data['content'][$z][$i]['PIN']; } ?></div>
            <div class="small-12 small-text-center medium-2 large-2 columns text_right" style="background-color: #FF0000;" data-equalizer-watch><a onclick="openWin('<?php echo $data['content'][$z][$i]['PlayNow'][0]['PlayLink']; ?>');return false;"><?php echo Helper::translate("Play Now", "member-wallet-play"); ?></a></div>
        </div>

              <?php } ?>
              <br />
            <?php } else { ?>
             <p><?php echo Helper::translate("No records.", "member-wallet-norecord"); ?></p>
             <?php } ?>
    <?php } ?>
    <?php } ?>
<?php } ?>
</div>
<?php } else { ?>
<table class="table_pet">
	<tr>
        <td style="vertical-align: top; background: none repeat scroll 0 0 #202020; padding: 5px 9px;">
      	<?php for ($i=0; $i <$data['main_wallet']['count']; $i++) { ?>
          <?php echo $data['main_wallet'][$i]['Name']; ?>:&nbsp; <span class="float-right">MYR <?php echo $data['main_wallet'][$i]['WalletTotal'];?></span><br />
      	<?php } ?>
        </td>
	</tr>
</table>
<br />
<?php //Debug::displayArray($data['content']); ?>
<?php for ($z=0; $z<$data['content']['count']; $z++) { ?>
<?php //echo $data['content'][$z][0]['Type']; ?>
    <?php if ($data['content'][$z][0]['Type']!="Main Wallet" && $data['content'][$z][0]['Type']!="Dompet Utama" && $data['content'][$z][0]['Type']!="主要钱包") { ?>
    <h6>
        <?php echo $data['content'][$z][0]['Type']; ?>
    </h6>
    <?php if ($data['content_param']['count']>0) { ?>
        <table class="admin_table" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th style="width:25%"><?php echo Helper::translate("Product", "member-wallet-product"); ?></th>
            <th style="width:15%"><?php echo Helper::translate("Username", "member-wallet-username"); ?></th>
            <th style="width:15%"><?php echo Helper::translate("Password", "member-wallet-password"); ?></th>
            <th style="width:15%"><?php echo Helper::translate("Pin Number", "member-wallet-pinnumber"); ?></th>
            <!-- <th style="width:15%" class="text_right">Total (MYR)</th> -->
          	<th style="width:15%" class="text_right"><?php echo Helper::translate("Link", "member-wallet-link"); ?></th>
          </tr>
          <?php if($data['content'][$z][0]['count']>0){ ?>
         <?php for ($i=0; $i<$data['content'][$z][0]['count']; $i++) { ?>


              <tr>
                <td><?php echo $data['content'][$z][$i]['ProductID']; ?></td>
                <td><?php  if($data['content'][$z][$i]['Username']==""){ echo Helper::translate("Processing", "member-wallet-processing");}else{ echo $data['content'][$z][$i]['Username']; } ?></td>
                <td><?php  if($data['content'][$z][$i]['Password']==""){ echo Helper::translate("Processing", "member-wallet-processing"); }else{ echo $data['content'][$z][$i]['Password'];} ?></td>
                <td><?php  if($data['content'][$z][$i]['PIN']==""){ echo Helper::translate("Not Available", "member-wallet-notavailable");}else{ echo $data['content'][$z][$i]['PIN']; } ?></td>
                <!-- <td class="text_right"><?php echo $data['content'][$z][$i]['Total']; ?></td> -->
                <td style="background-color: #FF0000;cursor:pointer;"><a onclick="openWin('<?php echo $data['content'][$z][$i]['PlayNow'][0]['PlayLink']; ?>');return false;"><?php echo Helper::translate("Play Now", "member-wallet-play"); ?></a></td>

              </tr>
              <?php } ?>
            <?php } else { ?>
             	<tr>
                <td colspan="6"><?php echo Helper::translate("No records.", "member-wallet-norecord"); ?></td>
                </tr>
             <?php } ?>

         </table>
    <?php } ?>
    <?php } ?>
    <br />
<?php } ?>

    
<?php } ?>    
