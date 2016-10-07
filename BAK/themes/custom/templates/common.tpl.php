<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >
<head>
<!-- Meta Tags START -->
<?php include($data['config']['THEME_DIR_INC'].'inc/meta_common.inc.php'); ?>
<!-- Meta Tags END -->
<title><?php include($data['config']['THEME_DIR_INC'].'inc/title.inc.php'); ?></title>
<!-- Common Scripts START -->
<?php include($data['config']['THEME_DIR_INC'].'inc/scripts_common.inc.php'); ?>
<!-- Common Scripts END -->
<?php if($_GET['section']!='main' && $_GET['controller']!='staticpage' && $_GET['action']!='javascriptdisabled'){ ?>
<noscript>
  <meta http-equiv="refresh" content="0;url=<?php echo $data['config']['SITE_DIR']; ?>/main/staticpage/javascriptdisabled">
</noscript>
<?php } ?> 
<style>
    div.chzn-container span {
       color: #000 !important;
    }
</style>
</head>
<body>
<?php if($_SESSION['superid']=='1'){ ?>    
<div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
    <!-- Header START -->
    <?php include($data['config']['THEME_DIR_INC'].'inc/header.inc.php'); ?>
    <!-- Header END -->
    <!-- Main Navigation Menu START -->
    <?php #include($data['config']['THEME_DIR_INC'].'inc/nav_main.inc.php'); ?>
    <!-- Main Navigation Menu END -->
    <div class="row" id="main_wrapper">
        <main class="small-12 medium-12 large-12 columns">
            <?php echo $data['breadcrumb']; ?>
            <div id="main_content_wrapper">
                <h1><?php echo $data['page']['title']; ?></h1>
                <!-- Main Content START -->
                <?php require($this->view_location); ?>
                <!-- Main Content END -->
            </div>
        </main>
        <?php /* ?>
        <aside class="small-12 medium-4 large-4 columns">
            <!-- Right Content START -->
            <?php (($data['block']['side_nav']!="") ? include($data['block']['side_nav']) : ""); ?>
            <?php (($data['block']['common']!="false") ? include($data['config']['THEME_DIR_INC'].'inc/side_nav.common.inc.php') : ""); ?>
            <!-- Right Content END -->
        </aside><?php */ ?>
    </div>
    <!-- Footer START -->
    <?php //include($data['config']['THEME_DIR_INC'].'inc/footer.inc.php'); ?>
    <!-- Footer END -->
    <!-- Bottom Scripts START -->
    <?php include($data['config']['THEME_DIR_INC'].'inc/scripts_bottom.inc.php'); ?>
    <!-- Bottom Scripts END -->
    <a class="exit-off-canvas"></a>
  </div>
</div>
<?php } else { ?> 
<div class="off-canvas-wrap" data-offcanvas>
  <div class="inner-wrap">
    <!-- Header START -->
    <?php include($data['config']['THEME_DIR_INC'].'inc/header.inc.php'); ?>
    <!-- Header END -->
    <!-- Main Navigation Menu START -->
    <?php #include($data['config']['THEME_DIR_INC'].'inc/nav_main.inc.php'); ?>
    <!-- Main Navigation Menu END -->
    <div class="row" id="main_wrapper">
        <main class="small-12 medium-8 large-8 columns">
            <?php echo $data['breadcrumb']; ?>
            <div id="main_content_wrapper">
                <h1><?php echo $data['page']['title']; ?></h1>
                <!-- Main Content START -->
                <?php require($this->view_location); ?>
                <!-- Main Content END -->
            </div>
        </main>
        <aside class="small-12 medium-4 large-4 columns">
            <!-- Right Content START -->
            <?php (($data['block']['side_nav']!="") ? include($data['block']['side_nav']) : ""); ?>
            <?php (($data['block']['common']!="false") ? include($data['config']['THEME_DIR_INC'].'inc/side_nav.common.inc.php') : ""); ?>
            <!-- Right Content END -->
        </aside>
    </div>
    <!-- Footer START -->
    <?php #include($data['config']['THEME_DIR_INC'].'inc/footer.inc.php'); ?>
    <!-- Footer END -->
    <!-- Bottom Scripts START -->
    <?php #include($data['config']['THEME_DIR_INC'].'inc/scripts_bottom.inc.php'); ?>
    <!-- Bottom Scripts END -->
    <a class="exit-off-canvas"></a>
  </div>
</div>    
    
<?php } ?>    
</body>
</html>
