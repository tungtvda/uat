<?php if ($_SESSION['superid']=='1') { ?>
<style>
    .common_block {
	padding:0.8rem 1.6rem;
        <?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
        background:<?php echo $_SESSION['agent']['BackgroundColour']; ?>;
        <?php } else { ?>
	background-color: #691111;
        <?php } ?>
	height: inherit;
	margin-bottom: 0.67rem;
}
    	
</style>
<?php } else { ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#forgotpassword_form").validationEngine();
});
</script>

<style>
    <?php if(empty($_SESSION['agent']['FontColour'])===FALSE || empty($_SESSION['agent']['BackgroundColour'])===FALSE || empty($_SESSION['agent']['Logo'])===FALSE){ ?>
    
    
    body{
       background-color: <?php echo $_SESSION['agent']['BackgroundColour']; ?>;
       
       color: <?php echo $_SESSION['agent']['FontColour']; ?> !important; 
    }
    
    .button{
       color: <?php echo $_SESSION['agent']['FontColour']; ?> !important; 
    }
    
    h1, h2, h3, h4, h5, h6, span, a, .common_block h1{
       color: <?php echo $_SESSION['agent']['FontColour']; ?> !important; 
    }

<?php } ?>
</style>  
<?php } ?>