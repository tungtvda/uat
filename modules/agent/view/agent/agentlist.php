<?php if ($data['content_param']['count']>0) { ?>
<?php if($data['parent']!='0'){ ?>
<a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/agent/agentlist/<?php echo $data['parent']; ?>">
    &laquo; Back To Parent
</a>
<br>&nbsp;
<?php } ?>

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
        <?php if($data['content'][$i]['Downline']['count']){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/agent/agentlist/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Username']; ?></a>
        <?php }else{ ?>
        <?php echo $data['content'][$i]['Username']; ?>
        <?php } ?>
    </td>  
    <td class="center"><?php echo $data['content'][$i]['Name']; ?></td>  
    <td class="text_right"><?php echo $data['content'][$i]['Profitsharing']; ?></td>
    <td class="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
    <td class="center">
        <?php if($data['content'][$i]['Downline']['count']){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/agent/agentlist/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Downline']['count']; ?></a>
        <?php }else{ ?>
        <?php echo $data['content'][$i]['Downline']['count']; ?>
        <?php } ?>
    </td>  
    <td class="center">
        <?php if($data['content'][$i]['Member']){ ?>
        <a href="<?php echo $data['config']['SITE_URL'].$data['config']['SITE_DIR']; ?>/agent/member/agentmember/<?php echo $data['content'][$i]['ID'];  ?>"><?php echo $data['content'][$i]['Member']; ?></a>
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
