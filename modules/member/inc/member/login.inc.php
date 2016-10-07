<?php if ($_SESSION['superid']=='1') { ?>
<style type="text/css">
#member_login_wrapper {
}
#member_login_wrapper .forgot_password {
    margin-top:0.5rem;
    font-size:0.75rem;
    color:#555;
}

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

<style type="text/css">
#member_login_wrapper {
    border-radius:6px;
    padding:15px 20px;
}
#member_login_wrapper .subtext {
    font-size:11px;
    color:#555;
}
#member_login_wrapper .forgot_password {
    margin-top:7px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#login_form").validationEngine();
});
</script>

<?php } ?>