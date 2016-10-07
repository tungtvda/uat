<?php if ($data['page']['permission_access']['error']['count']>0) { ?>
    <?php if ($data['page']['permission_access']['Permission']=="Denied") { ?>
    <div class="error">You do not have permission to access this area.</div>
    <?php } ?>
<?php } ?>