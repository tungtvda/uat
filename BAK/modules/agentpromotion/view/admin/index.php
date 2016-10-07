<?php if ($data['page']['agentpromotion_delete']['ok']==1) { ?>
<div class="notify">Agent Promotion deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Agent</label></th>
<!--	        <td><select name="AgentID" class="chosen_simple">
	            <option value="" selected="selected">All Agents</option>
	            <?php for ($i=0; $i<$data['content_param']['agent_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list'][$i]['ID']==$_SESSION['agentpromotion_AdminIndex']['param']['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list'][$i]['Name']; ?></option>
	            <?php } ?>
	          </select></td>-->
                  
                   <td>
                    <select name="AgentID" class="chosen_full">
                    <option value="">--Select All--</option> 
                    <?php for ($g=0; $g<$data['content_param']['agent_list1']['count']; $g++) { ?>
                    <option value="<?php echo $data['content_param']['agent_list1'][$g]['ID']; ?>" <?php if($data['content_param']['agent_list1'][$g]['ID']==$_SESSION['agentpromotion_AdminIndex']['param']['AgentID']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list1'][$g]['Name']; ?> - <?php echo $data['content_param']['agent_list1'][$g]['ID']; ?></option>
	            <?php Helper::agentOptionList($data['content_param']['agent_list1'][$g]['Child'], $_SESSION['agentpromotion_AdminIndex']['param']['AgentID']); ?>
                    <?php } ?>
                    <?php for ($i=0; $i<$data['content_param']['agent_list2']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_list2'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_list2'][$i]['ID']==$_SESSION['agentpromotion_AdminIndex']['param']['AgentID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_list2'][$i]['Name']; ?> - <?php echo $data['content_param']['agent_list2'][$i]['ID']; ?></option>
	            <?php } ?>
                    </select>
                </td>
                <td>&nbsp;</td>
<!--                <td>&nbsp;</td>
                <td>&nbsp;</td>-->
               <th>Agent Username</th>
                <td>
                    <select name="AgentUsernameID" class="chosen_full">
                    <option value="">--Select All--</option> 
                    <?php for ($g=0; $g<$data['content_param']['agent_username1']['count']; $g++) { ?>
                    <option value="<?php echo $data['content_param']['agent_username1'][$g]['ID']; ?>" <?php if($data['content_param']['agent_username1'][$g]['ID']==$_SESSION['agentpromotion_AdminIndex']['param']['AgentUsernameID']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['agent_username1'][$g]['Username']; ?> - <?php echo $data['content_param']['agent_username1'][$g]['ID']; ?></option>
	            <?php Helper::agentUsernameOptionList($data['content_param']['agent_username1'][$g]['Child'], $_SESSION['agentpromotion_AdminIndex']['param']['AgentUsernameID']); ?>
                    <?php } ?>
                    <?php for ($i=0; $i<$data['content_param']['agent_username2']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['agent_username2'][$i]['ID']; ?>" <?php if ($data['content_param']['agent_username2'][$i]['ID']==$_SESSION['agentpromotion_AdminIndex']['param']['AgentUsernameID']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['agent_username2'][$i]['Username']; ?> - <?php echo $data['content_param']['agent_username2'][$i]['ID']; ?></option>
	            <?php } ?>
                    </select>
                </td>     
	      </tr>
	      <tr>
                <th>Title</th>
            <td><input name="Title" type="text" value="<?php echo $_SESSION['agentpromotion_AdminIndex']['param']['Title']; ?>" /></td>
            <td>&nbsp;</td>
	        <th scope="row"><label>First</label></th>
	        <td><select name="First">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['Value']; ?>" <?php if ($_SESSION['agentpromotion_AdminIndex']['param']['First']==$data['content_param']['enabled_list'][$i]['Value']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>	        
	      </tr>
	      <tr>	        
	        <th><label>Enabled</label></th>
	        <td><select name="Enabled">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['agentpromotion_AdminIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/index?page=all">
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
    <?php if ($data['content_param']['count']>0) { ?>
    <div>Total Results: <?php echo $data['content_param']['total_results']; ?></div>
    <?php } ?>
  </div>
  <div class="results_right"><a href='/admin/agentpromotion/add/'><input type="button" class="button" value="Create Agent Promotion"></a><a href='/admin/agentpromotion/manage?page=all'><input type="button" class="button" value="Bulk Update"></a><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/export/AdminIndex'>
    <input type="button" class="button" value="Export to CSV">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" id="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Agent</th>
    <th>Username</th>
    <th>Title</th>
    <th>Position</th>
    <th>First</th>
    <th class="center">Enabled</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  <tbody <?php if ($data['content_param']['sort']==TRUE) { ?>class="sortable"<?php } ?>>
	<?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  	<tr data-id="<?php echo $data['content'][$i]['ID']; ?>">
    <td><?php echo $data['content'][$i]['AgentID']; ?></td>
    <td><?php echo $data['content'][$i]['AgentUsername']; ?></td>
    <td><?php echo $data['content'][$i]['Title']; ?></td>
    <td class="center"><span class="sortable_position" id="sortable_position_<?php echo $data['content'][$i]['ID']; ?>"><?php echo $data['content'][$i]['Position']; ?></span></td>
    <td><?php echo $data['content'][$i]['First']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
