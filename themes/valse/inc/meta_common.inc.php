<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php if ($data['meta']['active']=='on') { ?>
    <?php if ($data['meta']['keywords']!="") { ?>
    <meta name="keywords" content="<?php echo $data['meta']['keywords']; ?>" />
    <?php } ?>
    <?php if ($data['meta']['description']!="") { ?>
    <meta name="description" content="<?php echo $data['meta']['description']; ?>" />
    <?php } ?>
    <?php if ($data['meta']['author']!="") { ?>
    <meta name="author" content="<?php echo $data['meta']['author']; ?>" />
    <?php } ?>
    <?php if ($data['meta']['robots']!="") { ?>
    <meta name="robots" content="<?php echo $data['meta']['robots']; ?>" />
    <?php } ?>
<?php } ?>