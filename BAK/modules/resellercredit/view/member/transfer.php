<?php if($_GET['param']==="invalid"){ ?>
<div class="error">The amount specified is less than the available balance in the selected wallet. Please try again.</div>
<?php } ?>
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
<table class="table_pet" style="width:100%; margin-bottom:15px;">
  <tr>
      <th style="width:33%">Online Casino</th>
      <th style="width:33%">Soccer</th>
      <th style="width:33%">Horse Racing</th>

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
    <table class="table_pet" style="width:100%">
  <tr>
      <th style="width:33%">Poker</th>
      <th style="width:33%">Games</th>
      <th style="width:33%">4D</th>

  </tr>
  <tr>
      <td style="vertical-align: top;">
          <?php for ($i=0; $i <$data['content2']['poker']['count']; $i++) { ?>
              <?php echo $data['content2']['poker'][$i]['Name']; ?>: <span class="float-right">MYR <?php echo $data['content2']['poker'][$i]['WalletTotal'];?></span><br />
          <?php } ?>
      </td>
      <td style="vertical-align: top;">
          <?php for ($i=0; $i <$data['content2']['games']['count']; $i++) { ?>
              <?php echo $data['content2']['games'][$i]['Name']; ?>: <span class="float-right">MYR <?php echo $data['content2']['games'][$i]['WalletTotal'];?></span><br />
          <?php } ?>
      </td>
      <td style="vertical-align: top;">
          <?php for ($i=0; $i <$data['content2']['fourd']['count']; $i++) { ?>
              <?php echo $data['content2']['fourd'][$i]['Name']; ?>: <span class="float-right">MYR <?php echo $data['content2']['fourd'][$i]['WalletTotal'];?></span><br />
          <?php } ?>
      </td>

  </tr>

  <!-- <?php	for ($j=0; $j <$data['ProductType']['count'] ; $j++) { ?>
  	<tr><th><?php echo $data['ProductType'][$j]['Label']; ?> Wallet</th></tr>
	<?php for ($i=0; $i <$data['ProductType'][$j]['Product']['count']; $i++) { ?>

		 <tr><td><?php echo $data['ProductType'][$j]['Product'][$i]['Name']; ?>
			<?php for ($k=0; $k < $data['ProductType'][$j]['Product'][$i]['Wallet']['count']; $k++) { ?>
				<?php echo 'Wallet Total: '.$data['ProductType'][$j]['Product'][$i]['Wallet']['Total'];?></td></tr>
			<?php } ?>
		<?php } ?>
	<?php } ?>
  	<tr><th>All Wallet Total:</th></tr>
  	<tr><td><?php echo $data['WalletTotal'] ?></td></tr> -->
    <!-- <td style="white-space:nowrap"><?php if(isset($data['WalletTotal'])){ echo $data['WalletTotal'];} ?></td> -->
    <!-- <td style="white-space:nowrap"><?php //echo $data['content'][$i]['MemberID']; ?></td> -->
    <!-- <td style="white-space:nowrap"><?php //echo $data['content'][$i]['Description']; ?></td> -->
    <!--<td style="white-space:nowrap"><?php //echo $data['content'][$i]['Debit']; ?></td>-->
    <!-- <td style="white-space:nowrap"><?php //echo $data['content'][$i]['Credit']; ?></td> -->
    <!-- <td class="center"><?php //echo $data['content'][$i]['Status']; ?></td> -->
    <!-- <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/transaction/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td> -->


</table>
<br /><br />
<form name="add_form" class="admin_table_nocell"  id="add_form" action="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/transferprocess" method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"><label>Transfer From</label></th>
      <td><select id="TransferFrom" name="TransferFrom">
            <?php for ($i=0; $i<$data['Product']['count']; $i++) { ?>
            <option value="<?php echo $data['Product'][$i]['ID']; ?>"><?php echo $data['Product'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
    <tr>
      <th scope="row"><label>Transfer To</label></th>
      <td><select class="mainwallet invisible" id="TransferTo" name="TransferTo">
            <?php for ($i=0; $i<$data['mainwallet']['count']; $i++) { ?>
            <option value="<?php echo $data['mainwallet'][$i]['ID']; ?>"><?php echo $data['mainwallet'][$i]['Name']; ?></option>
            <?php } ?>
          </select>
          <select class="nonmainwallet" id="TransferTo" name="TransferTo">
            <?php for ($i=0; $i<$data['nonmainwallet']['count']; $i++) { ?>
            <option value="<?php echo $data['nonmainwallet'][$i]['ID']; ?>"><?php echo $data['nonmainwallet'][$i]['Name']; ?></option>
            <?php } ?>
          </select></td>
    </tr>
     <tr>
      <th scope="row"><label>Amount (MYR)</label></th>
      <td><input name="Amount" id="Amount" class="validate[required, custom[number], min[10]]" value="" size="10" /> (Minimum MYR 10.00)</td>
    </tr>
    <!-- <tr>
      <th scope="row"><label>Description<span class="label_required">*</span></label></th>
      <td><input name="description" class="validate[required]" value="" size="50" maxlength="50" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Date<span class="label_required">*</span></label></th>
      <td><input name="Date" class="validate[required,custom[dmyDate]] datepicker mask_date" type="text" value="" size="10" maxlength="10" /><span class="label_hint">(dd-mm-yyyy)</span></td>
    </tr>
    <tr>
      <th scope="row"><label>Debit<span class="label_required">*</span></label></th>
      <td><input name="Debit" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Credit<span class="label_required">*</span></label></th>
      <td><input name="Credit" class="validate[required]" type="text" value="" size="80" /></td>
    </tr>
    <tr>
      <th scope="row"><label>Status</label></th>
      <td><select name="Status" class="chosen_simple">
            <?php for ($i=0; $i<$data['content_param']['transactionstatus_list']['count']; $i++) { ?>
            <option value="<?php echo $data['content_param']['transactionstatus_list'][$i]['ID']; ?>"><?php echo $data['content_param']['transactionstatus_list'][$i]['Label']; ?></option>
            <?php } ?>
          </select></td>
    </tr> -->
    <?php /*?><tr>
      <th scope="row"><label>Enabled</label></th>
      <td><select name="Enabled" class="chosen_simple">
          <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
          <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>"><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
          <?php } ?>
        </select></td>
    </tr><?php */?>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td><input type="submit" name="submit" value="Save" class="button" />
        <a href="<?php echo $data['config']['SITE_DIR']; ?>/member/transaction/index">
        <input type="button" value="Cancel" class="button" />
        </a></td>
    </tr>
  </table>
</form>
<br /><br />