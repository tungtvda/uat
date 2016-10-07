<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/agentlist" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Username</label></th>
	        <td><input name="Username" type="text" value="<?php echo $_SESSION['agent_AdminAgentList']['param']['Username']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row"><label>Name</label></th>
	        <td><input name="Name" type="text" id="Name" value="<?php echo $_SESSION['agent_AdminAgentList']['param']['Name']; ?>" size="" /></td>
	      </tr>
	      <tr>
	        <th scope="row">&nbsp;</th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <?php /*?><th>Enabled</th>
	        <td><select name="Enabled">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['agenttype_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr><?php */?>
	      <tr>
	        <th scope="row"><label></label></th>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td class="text_right"><input type="submit" name="submit" value="Search" class="button" />
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agent/agentlist?page=all">
	          <input type="button" value="Reset" class="button" />
	          </a></td>
	      </tr>
	    </table>
	  </form>
  </div>
</div>
<?php if ($data['decision']==0) { ?>
<?php if($data['parent']!='0'){ ?>
<a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/agent/agentlist/<?php echo $data['parent']; ?>">
    &laquo;Back To Parent
</a>
<br>&nbsp;
<?php }elseif($data['parent']=='0'){ ?>
<a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/agent/agentlist">
    &laquo;Back To Parent
</a>
<br>&nbsp;
<?php } ?>
<?php if ($data['content_param']['count']>0) { ?>
<div class="admin_results">
  <div class="results_left">
    <h2><?php echo $data['content_param']['query_title']; ?></h2>
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>

<table class="admin_table" border="0" Mobilespacing="0" Mobilepadding="0">
  <tr>
    <th class="center">Username</th>
    <th class="center">Name</th>
    <th class="text_right">PT (%)</th>
    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    <th class="center">Downline Agent</th>
    <th class="center">Own Member</th>
    <th class="center">Remark</th>
    <th class="center">Registered On</th>
    <th class="center">Status</th>
  </tr>

  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
      
    <td class="center">
      <?php if($data['content'][$i]['Downline']['count']>'0'){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/agent/agentlist/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Username']; ?></a>
      <?php }else{ ?> 
            <?php echo $data['content'][$i]['Username']; ?>
      <?php } ?> 
    </td>  
    <td class="center"><?php echo $data['content'][$i]['Name']; ?></td>  
    <td class="text_right"><?php echo $data['content'][$i]['Profitsharing']; ?></td>
    <td class="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
    <td class="center">
        <?php if($data['content'][$i]['Downline']['count']>'0'){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/agent/agentlist/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Downline']['count']; ?></a>
        <?php }else{ ?> 
            <?php echo $data['content'][$i]['Downline']['count']; ?>
        <?php } ?>
    </td> 
    <td class="center">
    <?php if($data['content'][$i]['Member']>'0'){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/member/agentmember/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Member']; ?></a>
        <?php }else{ ?>
        <?php echo $data['content'][$i]['Member']; ?>
        <?php } ?> 
    </td>
    <td class="center"><?php echo $data['content'][$i]['Remark']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Registered']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
  </tr>
  <?php } ?>
</table>
<br>

<?php } else { ?>
<p>No records.</p>
<?php } ?>


<?php }elseif($data['decision']==1){ ?>
    <p>Below are top-level agents.</p>
    <?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" Mobilespacing="0" Mobilepadding="0">
  <tr>
    <th class="center">Username</th>
    <th class="center">Name</th>
    <th class="text_right">PT (%)</th>
    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    <th class="center">Downline Agent</th>
    <th class="center">Own Member</th>
    <th class="center">Remark</th>
    <th class="center">Registered On</th>
    <th class="center">Status</th>
  </tr>

  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td class="center">
        <?php if($data['content'][$i]['Downline']['count']>'0'){ ?>
            <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/agent/agentlist/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Username']; ?></a>
        <?php }else{ ?> 
            <?php echo $data['content'][$i]['Username']; ?>
        <?php } ?>    
    </td>  
    <td class="center"><?php echo $data['content'][$i]['Name']; ?></td>  
    <td class="text_right"><?php echo $data['content'][$i]['Profitsharing']; ?></td>
    <td class="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
    <td class="center">
        <?php if($data['content'][$i]['Downline']['count']>'0'){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/agent/agentlist/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Downline']['count']; ?></a>
        <?php }else{ ?> 
            <?php echo $data['content'][$i]['Downline']['count']; ?>
        <?php } ?> 
    </td>  
    <td class="center">
        <?php if($data['content'][$i]['Member']>'0'){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/admin/member/agentmember/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Member']; ?></a>
        <?php }else{ ?>
        <?php echo $data['content'][$i]['Member']; ?>
        <?php } ?> 
    </td>
    <td class="center"><?php echo $data['content'][$i]['Remark']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Registered']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
  </tr>
  <?php } ?>
</table>
   
    
<?php } else { ?>
<p>No records.</p>
<?php } ?>
<?php } ?>