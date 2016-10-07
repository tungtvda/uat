<div id="product_view_wrapper">
  <?php if ($data['content']['count']>0) { ?>
        <?php if($this->id == '2'){
        Core::getHook('soccer-bottom-block');
     } ?>

  <div class="product_view_box">
  	<?php for ($i=0; $i<$data['content']['count']; $i++) { ?>
  	<div class="product-frame">
  		<div class="product-button">
  		<div class="product-title-style"><?php echo $data['content'][$i]['Name']; ?></div>
  		<a <?php //if(isset($_SESSION['member']['ID'])){ echo "onlick=\"_blank\"";}?><?php if(isset($_SESSION['member']['ID'])){?>onclick="openWin('<?php echo $data['content'][$i]['PlayLink'];?>');return false;"<?php }elseif(!isset($_SESSION['member']['ID'])){ ?><?php echo 'href="'.$data['config']['SITE_URL'].'/member/member/register"'; ?><?php } ?>>
  		    <?php if($this->id == '8') { ?>
            <img src="/themes/custom/img/betnow4d.png" />
  		    <?php } else { ?>
            <img src="/themes/custom/img/playnow.png" />
  		    <?php } ?>
	    </a>
  		<script>

		function openWin(url)
		{
		var PlayLinkWindow = window.open(url,"","width=1300,height=700");

		}
		</script>

  		<?php if ($_SESSION['member']['ID']!="") { ?>
  		<div style="margin-left:7px;">

            <span><?php if(!empty($data['content'][$i]['WalletProfile'][1]['Username'])){ echo 'Username: '.$data['content'][$i]['WalletProfile'][1]['Username'];}else{echo 'Username: Processing';} ?></span><br />
            <span><?php if(!empty($data['content'][$i]['WalletProfile'][1]['Password'])){ echo 'Password: '.$data['content'][$i]['WalletProfile'][1]['Password'];}else{ echo 'Password: Processing';} ?></span><br />
            <span><?php if(!empty($data['content'][$i]['WalletProfile'][1]['PIN'])){ echo 'PIN: '.$data['content'][$i]['WalletProfile'][1]['PIN'];}else{ echo 'PIN: Not Available';} ?></span>	

        </div>
  		<?php } elseif($_SESSION['member']['ID']=="") { ?>
  		<!-- <a onclick="openWin('<?php echo $data['content'][$i]['DemoLink'];?>');return false;"><img src="/themes/custom/img/viewdemo.png" /></a> -->
        <a href="/member/member/register"><img src="/themes/custom/img/viewdemo.png" /></a>
  		<script>
		function openWin(url)
		{
		var DemoLinkWindow = window.open(url,"","width=1300,height=700");
		}
		</script>

  		<?php } ?>

  		</div>
  		<div class="product-frame-img"><img src="<?php echo $data['config']['SITE_URL'].$data['content'][$i]['ImageURL']; ?>" /></div>

  	</div>
  	<?php } ?>
  </div>
<?php if($this->id == '8'){
        Core::getHook('4D-bottom-block');
     } ?>
  <?php } else { ?>

  <p>Product not found.</p>

  <?php } ?>
</div>

