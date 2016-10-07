<div id="search_box"<?php if ($data['content_param']['search']=="off") { ?>class="search_initial"<?php } ?>>
  <h2>Search</h2><span id="search_trigger_box">(<a id="search_trigger" href="javascript:void(0);">click to show/hide</a>)</span>
  <div id="search_content" <?php if ($data['content_param']['search']=="off") { ?>class="invisible"<?php } ?>>
	  <p>Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.</p>
	  <form name="search_form" class="admin_table_nocell"  id="search_form" action="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/manage" method="post">
	    <input name="Trigger" type="hidden" value="search_form" />
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <th scope="row">Agent</th>
	        <td>
                    <select name="Agent" class="chosen_full">
                    <option value="">--Select All--</option> 
                    <?php for ($g=0; $g<$data['content_param']['test1']['count']; $g++) { ?>
                    <option value="<?php echo $data['content_param']['test1'][$g]['ID']; ?>" <?php if($data['content_param']['test1'][$g]['ID']==$_SESSION['agentpromotion_AdminManage']['param']['Agent']){ ?>selected="selected"<?php } ?>><?php echo $data['content_param']['test1'][$g]['Name']; ?> - <?php echo $data['content_param']['test1'][$g]['ID']; ?></option>
	            <?php Helper::agentOptionList($data['content_param']['test1'][$g]['Child'], $_SESSION['agentpromotion_AdminManage']['param']['Agent']); ?>
                    <?php } ?>
                    <?php for ($i=0; $i<$data['content_param']['test2']['count']; $i++) { ?>
	            <option value="<?php echo $data['content_param']['test2'][$i]['ID']; ?>" <?php if ($data['content_param']['test2'][$i]['ID']==$_SESSION['agentpromotion_AdminManage']['param']['Agent']) { ?> selected="selected"<?php } ?>><?php echo $data['content_param']['test2'][$i]['Name']; ?> - <?php echo $data['content_param']['test2'][$i]['ID']; ?></option>
	            <?php } ?>
                    </select>
                </td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
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
	          <a href="<?php echo $data['config']['SITE_DIR']; ?>/admin/agentpromotion/manage?page=all">
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
  <div class="results_right"><a href='/admin/agentpromotion/index?page=all'>
    <input type="button" class="button" value="Back to Index">
    </a><?php echo $data['content_param']['paginate']; ?></div>
  <div class="clear"></div>
</div>
<?php if ($data['content_param']['count']>0) { ?>
<form id="manage_form">
    <table class="admin_table" border="0" cellspacing="0" cellpadding="0">
      <tr>           
         <th>Agent</th>
        <th class="center">Promotion</th>
        <th class="center">Enabled</th>
      </tr>
      <tr>
        <th></th>
        <th class="center"><input type="checkbox" id="first" name=""> First column&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="second" name=""> Second column</th>
        <th></th>
      </tr>
      <?php for ($g=0; $g<$data['content_param']['count']; $g++) { ?>
      <tr>
        <td>
            <input type="checkbox" id="agent" name="Agent[]" value="<?php echo $data['content'][$g]['ID']; ?>">
             <?php echo $data['content'][$g]['Name']; ?>
        </td>  
        <td>
          <table class="admin_table" border="0" cellspacing="0" cellpadding="0">
          <?php if($data['content'][$g]['Agentpromotion']['count']>'0'){ ?>    
          <?php if($data['content'][$g]['agentpromotion_list']['count']>'0'){ ?>
          
            <?php for ($i=0; $i<$data['content'][$g]['agentpromotion_list']['count']; $i++) { ?>
                            
                  <?php if($i % 2==0){ ?>

                        <tr>               
                    <?php } ?> 
          <td>
              <input <?php if($i % 2==0){ ?>class="first"<?php } ?><?php if($i % 2!==0 && ($i!==0)){ ?>class="second"<?php } ?> type="checkbox" name="Agentpromotion[<?php echo $data['content'][$g]['ID']; ?>][]" value="<?php echo $data['content'][$g]['agentpromotion_list'][$i]; ?>" 
              <?php for ($z=0; $z<$data['content'][$g]['Agentpromotion']['count']; $z++) {
              if($data['content'][$g]['agentpromotion_list'][$i]==$data['content'][$g]['Agentpromotion'][$z]){ ?> 
                 
                 
                 checked="checked" 
            <?php } } ?>
                 
                 >&nbsp;<?php echo $data['content'][$g]['agentpromotion_list'][$i]; ?>&nbsp;&nbsp;</td>
                    <?php if($i % 2!==0 && ($i!==0)){ ?>

                        </tr>               
                    <?php } ?>   
                       
            <?php } ?>            
          <?php } ?>
         <?php } else { ?>
 
                        <tr style="height: 100px;"><td class="center"><?php echo 'Empty'; ?></td></tr>
          
         <?php } ?>               
          </table>              
      </td>
      <td class="center"><?php echo $data['content'][$g]['Enabled']; ?></td>
      </tr>
          
      <?php } ?>

    </table>
</form>
<div class="results_right" align="right">
    <br>
    <input type="button" class="button" value="Update" id="buttonUpdatePermission">
</div>
<?php } else { ?>
<p>No records.</p>
<?php } ?>
<div id="dialog" title="Complete" class="invisible">
<p><span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>Agent promotion(s) have been saved.</p>
</div>

     
