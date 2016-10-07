<?php 
function familyTree($array)
	{
           
           
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                             if ($array[$index]['ID']==$_SESSION['operator_AgentIndex']['param']['AgentID']) { 
                                $selected= 'selected="selected"'; 

                             }                     
                            
                            $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].'</option>';    
                       
                            echo $data;
           
                            unset($selected);
                           familyTree($array[$index]['Child']);
                      }
                     
                  
                }
                
        }
                               
?>
<?php if ($data['page']['operator_delete']['ok']==1) { ?>
<div class="notify">Operator deleted successfully.</div>
<?php } ?>
<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_URL']; ?>/agent/operator/index" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row"><label>Agent</label></th>
	      	<td>
                    <select name="AgentID" class="chosen_full">
                    <option value="<?php echo $data['agent'][0]['ID']; ?>" <?php if($data['agent'][0]['ID']==$_SESSION['operator_AgentIndex']['param']['Agent']){ ?><?php } ?>><?php echo $data['agent'][0]['Name']; ?> - <?php echo $data['agent'][0]['ID']; ?></option>
	            <?php familyTree($data['agent'][0]['Child']); ?>
                    </select>
                </td>
	        <td>&nbsp;</td>
	        <th>Profile</th>
	        <td><select name="ProfileID">
	            <option value="" selected="selected">All Profiles</option>
	            <?php for ($i=0; $i<$data['content_param']['profile_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['profile_list'][$i]['ID']; ?>" <?php if ($_SESSION['operator_AgentIndex']['param']['ProfileID']==$data['content_param']['profile_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['profile_list'][$i]['Profile']; ?></option>
	            <?php } ?>
	          </select></td>
	      </tr>
	      <tr>
                <th scope="row"><label>Username</label></th>
	        <td><input name="Username" type="text" value="<?php echo $_SESSION['operator_AgentIndex']['param']['Username']; ?>" size="" /></td>
	        <td>&nbsp;</td>
	        <th scope="row">Enabled</th>
	        <td><select name="Enabled">
	            <option value="" selected="selected">All Status</option>
	            <?php for ($i=0; $i<$data['content_param']['enabled_list']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['enabled_list'][$i]['ID']; ?>" <?php if ($_SESSION['operator_AgentIndex']['param']['Enabled']==$data['content_param']['enabled_list'][$i]['ID']) { ?>selected="selected"<?php } ?>><?php echo $data['content_param']['enabled_list'][$i]['Value']; ?></option>
	            <?php } ?>
	          </select></td>	   
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
	          <a href="<?php echo $data['config']['SITE_URL']; ?>/agent/operator/index?page=all">
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
  <div class="results_right">
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>  
        <a href='/agent/operator/add/'>
        <input type="button" class="button" value="Create Operator &AMP; Analysts">
        </a>
    <?php } ?> 
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>  
        <a href='/agent/operator/add/'>
        <input type="button" class="button" value="Create Operator &AMP; Analysts">
        </a>
    <?php } ?>   
    <?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<table class="admin_table" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Agent</th>
    <th>Profile</th>
    <th>Username</th>
    <th class="center">Enabled</th>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <th>&nbsp;</th>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <th>&nbsp;</th>
    <?php } ?>
    <?php } ?>
  </tr>
  <?php for ($i=0; $i<$data['content_param']['count']; $i++) { ?>
  <tr>
    <td><?php echo $data['content'][$i]['AgentID']; ?></td>
    <td><?php echo $data['content'][$i]['ProfileID']; ?></td>
    <td><?php echo $data['content'][$i]['Username']; ?></td>
    <td class="center"><?php echo $data['content'][$i]['Enabled']; ?></td>
    <?php if($_SESSION['agent']['TypeID']=='1'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/agent/operator/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/agent/operator/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='2' || $_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/agent/operator/edit/<?php echo $data['content'][$i]['ID']; ?>'>Edit</a></div></td>
    <?php if($_SESSION['agent']['operator']['ProfileID']=='3'){ ?>
    <td><div align="center"><a href='<?php echo $data['config']['SITE_URL']; ?>/agent/operator/delete/<?php echo $data['content'][$i]['ID']; ?>' onclick='return call_confirm()'>Delete</a></div></td>
    <?php } ?>
    <?php } ?>   
  </tr>
  <?php } ?>
</table>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
