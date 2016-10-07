<?php
// Require required models
Core::requireModel('state');
Core::requireModel('country');
Core::requireModel('product');
Core::requireModel('agent');
Core::requireModel('reseller');
Core::requireModel('bank');
Core::requireModel('bankinfo');
Core::requireModel('translation');
Core::requireModel('guidepromotion');
Core::requireModel('announcementticker');


class MemberModel extends BaseModel
{
	private $output = array();
    private $module_name = "Member";
	private $module_dir = "modules/member/";
    private $module_default_url = "/main/member/index";
    private $module_default_admin_url = "/admin/member/index";
    private $module_default_member_url = "/member/member/index";
    private $module_default_agentmember_url = "/agent/member/index";

	private $reseller_module_name = "Reseller";
    private $reseller_module_dir = "modules/reseller/";

    private $agent_module_name = "Agent";
    private $agent_module_dir = "modules/agent/";
    private $module_default_agent_url = "/agent/member/index";
    private $module_default_agentlist_url = "/agent/agent/agentlist";
    private $module_default_adminlist_url = "/admin/agent/agentlist";
    private $module_default_agentgroup_url = "/agent/member/group";

	public function __construct()
	{
		parent::__construct();
	}

	public function BlockHomeIndex(){
		$sql = "SELECT Total FROM wallet WHERE MemberID = '".$_SESSION['member']['ID']."' AND ProductID = '30'";
                //echo $sql;
                //exit;
		$res = $this->dbconnect->query($sql);
		$result = $res->fetchColumn();

        if($result=='')
        {
            $result = '0.00';
        }

        $this->output = array(
        'config' => $this->config,
        //'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

        return $this->output;
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/member/index';
		$limit = 5;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM member WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Members", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM member WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberActivation()
	{
	    $resent_time = $_SESSION['member']['activation_time'];
        $elapsed_time = time() - strtotime($resent_time);

		//unset($_SESSION['activated']);
		/*$sql = "SELECT * FROM member WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}*/

                if($_SESSION['language']=='en')
                {
                   $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
                }
                elseif($_SESSION['language']=='ms')
                {
                    $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
                }
                elseif($_SESSION['language']=='zh_CN')
                {
                    $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
                }

                $activation = Helper::translate("Activation", "member-mobilesms-title");

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "SMS ".$activation, 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/activation.inc.php'),
		'block' => array('common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,"SMS ".$activation),
		'content' => $result,
		'content_param' => array('count' => $i, 'elapsed_time' => $elapsed_time),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberActivationProcess()
	{


			$member = $this->getMember($_SESSION['member']['ID']);

			if($member[0]['ActivationCode'] == $_POST['ActivationCode']){


				$Activated = '1';

			}else{

				$Activated = '0';
			}


			if($Activated == '1'){

				$sql = "UPDATE member SET ActivationCode='1' WHERE ID='".$_SESSION['member']['ID']."'";

	            $count = $this->dbconnect->exec($sql);

	            // Set Status
	            $ok = ($count<=1) ? 1 : "";


			}



		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Member Activation Process", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/activation.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,"SMS Activation"),
		'activated' => $Activated,
		'content_param' => array('count' => $ok),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberResendActivationProcess()
	{
	    // Set latest resend time
	    $_SESSION['member']['activation_time'] = date('YmdHis');


        $activation_code = $this->getActivationCode($_SESSION['member']['ID']);
        $this->sendSMS($activation_code['code'], $_SESSION['member']['MobileNo']);

        #echo "Hello: ".$activation_code['code'];

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "SMS Activation", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/activation.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,"SMS Activation"),
		'status' => $ok,
		//'content_param' => array('count' => $ok),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function MemberUpdateActivationProcess()
	{
            $_POST['MobileNo'] = $_POST['MobilePrefix'].$_POST['MobileNo'];
        // Set latest resend time
        $_SESSION['member']['activation_time'] = date('YmdHis');

		//resend sms
		$sql = "UPDATE member SET MobileNo = '".$_POST['MobileNo']."' WHERE ID = '".$_SESSION['member']['ID']."'";

		$_SESSION['member']['MobileNo'] = $_POST['MobileNo'];

        $count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count<=1) ? 1 : "";

        $activation_code = $this->getActivationCode($_SESSION['member']['ID']);
        $this->sendSMS($activation_code['code'], $_SESSION['member']['MobileNo']);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "SMS Activation", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/activation.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,"SMS Activation"),
		'status' => $ok,
		//'content_param' => array('count' => $ok),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function MemberDashboard()
    {

        $product_list['casino'] = ProductModel::getProductListByType('1');

        $product_list['soccer'] = ProductModel::getProductListByType('2');

        $product_list['horse'] = ProductModel::getProductListByType('3');

        $product_list['poker'] = ProductModel::getProductListByType('6');

        $product_list['games'] = ProductModel::getProductListByType('7');

        $product_list['fourd'] = ProductModel::getProductListByType('8');

        $product_list['main'] = ProductModel::getProductListByType('5');

        if($_SESSION['language']=='en')
        {
           $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='ms')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='zh_CN')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => Helper::translate("Dashboard", "member-dashboard-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/dashboard.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config, Helper::translate("Dashboard", "member-dashboard-title")),
        'content2' => $product_list,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['member']['member_login']);

        return $this->output;
    }

    public function MemberProfile()
    {
        $sql = "SELECT * FROM member WHERE ID = '".$_SESSION['member']['ID']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'GenderID' => $row['GenderID'],
            'Name' => $row['Name'],
            'Company' => $row['Company'],
            'FacebookID' => $row['FacebookID'],
            'Bank' => $row['Bank'],
            'BankAccountNo' => $row['BankAccountNo'],
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'Nationality' => $row['Nationality'],
            'Username' => $row['Username'],
            'PhoneNo' => $row['PhoneNo'],
            'FaxNo' => $row['FaxNo'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email']);

            $i += 1;
        }

		// Debug::displayArray($result);
		// exit;

        if ($_SESSION['member']['member_profile_info']!="")
        {
            $form_input = $_SESSION['member']['member_profile_info'];

            // Unset temporary member info input
            unset($_SESSION['member']['member_profile_info']);
        }

        if($_SESSION['language']=='en')
        {
           $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='ms')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='zh_CN')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => Helper::translate("My Profile", "member-profile-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/profile.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/profile.bottom.inc.php', 'member_profile' => $_SESSION['member']['member_profile']),
        'block' => array('side_nav' => $this->module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("My Profile", "member-profile-title")),
        'content' => $result,
        'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['member']['member_profile']);

        return $this->output;
    }

    public function MemberProfileProcess()
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$_SESSION['member']['ID']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                #$i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."' AND ID != '".$_SESSION['member']['ID']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                #$i_passport += 1;
            }
        }

        $error['count'] = $i_nric + $i_passport;

        if ($error['count']>0)
        {
            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            $_SESSION['member']['member_profile_info'] = Helper::unescape($_POST);
        }
        else
        {
            $sql = "UPDATE member SET GenderID='".$_POST['GenderID']."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Company='".$_POST['Company']."', Nationality='".$_POST['Nationality']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', FacebookID='".$_POST['FacebookID']."' WHERE ID='".$_SESSION['member']['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Profile...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function MemberPassword()
    {
        if($_SESSION['language']=='en')
        {
           $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='ms')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='zh_CN')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => Helper::translate("Change Password", "member-password-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/password.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/password.bottom.inc.php', 'member_password' => $_SESSION['member']['member_password']),
        'block' => array('side_nav' => $this->module_dir.'inc/member/side_nav.member.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Change Password", "member-password-title")),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['member']['member_password']);

        return $this->output;
    }

    public function MemberPasswordProcess()
    {
        // Update new password if current password is entered correctly
        $bcrypt = new Bcrypt(9);
        $verify = $bcrypt->verify($_POST['Password'], $this->getHash($_SESSION['member']['ID']));

        if ($verify==1)
        {
            $hash = $bcrypt->hash($_POST['PasswordNew']);

            // Save new password and disable Prompt
            $sql = "UPDATE member SET Password='".$hash."', Prompt = 0 WHERE ID='".$_SESSION['member']['ID']."'";
            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Current password incorrect
            $error['count'] += 1;
            $error['Password'] = 1;
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Password...", 'template' => 'common.tpl.php'),
        'content_param' => array('count' => $count),
        'secure' => TRUE,
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function MemberIndex()
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Member Home", 'template' => 'common.tpl.php'),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function MemberRegister()
    {
        $tmp_time = time();
        $tmp_time += 3;
        $form_token = $tmp_time.'-'.time();
        $_SESSION['form_token'] = $form_token;

        if ($_SESSION['admin']['member_register_info']!="")
        {
            $form_input = $_SESSION['admin']['member_register_info'];

            // Unset temporary member info input
            unset($_SESSION['admin']['member_register_info']);
        }

        // Set reseller code session
        if ($_GET['rid']!="")
        {
            $reseller_id_list = ResellerModel::getResellerListArray();
            $decoded_reseller_code = base64_decode($_GET['rid']);

            if (is_numeric($decoded_reseller_code))
            {
                if (in_array($decoded_reseller_code, $reseller_id_list))
                {
                }
                else
                {
                    exit();
                }

                $_SESSION['reseller_code'] = $decoded_reseller_code;
            }
            else {
            	exit();
            }
        }

        if ($_SERVER['REMOTE_ADDR'] == '60.50.121.163') {
            echo $_SESSION['reseller_code'];
            print_r($reseller_id_list);

            if (in_array($decoded_reseller_code, $reseller_id_list))
            {
                echo "Found!";
            }
            else
            {
                echo "Not Found!";
            }
        }
		/*echo $_SESSION['reseller_code'];
		exit;*/

        $captcha[0] = rand(1,5);
        $captcha[1] = rand(1,4);

        if($_SESSION['language']=='en')
        {
           $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='ms')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='zh_CN')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }

        $_SESSION['agent']['BackgroundColour'] = AgentModel::getAgent($_SESSION['reseller_code'], "BackgroundColour");
        $_SESSION['agent']['FontColour'] = AgentModel::getAgent($_SESSION['reseller_code'], "FontColour");
        $_SESSION['agent']['Logo'] = AgentModel::getAgent($_SESSION['reseller_code'], "Logo");

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => Helper::translate("Register", "member-register-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/register.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/register.bottom.inc.php',  'member_register' => $_SESSION['member']['member_register']),
        'block' => array('side_nav' => $this->module_dir.'inc/member/side_nav.member_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Register", "member-register-title")),
        'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'bank_list' => BankModel::getBankList()),
        'form_param' => $form_input,
        'captcha' => $captcha,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['member']['member_register']);

        return $this->output;
    }

    public function MemberRegisterProcess()
    {

        if(is_array($_SESSION['member']['token'])===FALSE)
            {
               $_SESSION['member']['token'] = array();
            }

            if (in_array($_POST['form_token'], $_SESSION['member']['token'])===FALSE) {

                array_push($_SESSION['member']['token'], $_POST['form_token']);

                 /*Debug::displayArray($_SESSION['member']);
                 exit;*/
            /*if($_POST['form_token']==$_SESSION['form_token'])
            {*/

            $tmp_time = time();
            $tmp_time += 3;
            $form_token = $tmp_time.'-'.time();
            $_SESSION['form_token'] = $form_token;
            $_SESSION['form_token'] = $tmp_time.'-'.time();


        $_POST['MobileNo'] = $_POST['MobilePrefix'].$_POST['MobileNo'];

        // Set reseller code session
        $reseller_id_list = AgentModel::getAgentListArray();
        $decoded_reseller_code = $_SESSION['reseller_code'];

        if (is_numeric($decoded_reseller_code))
        {
            if (in_array($decoded_reseller_code, $reseller_id_list))
            {
            }
            else
            {
                exit();
            }
        }
        else {
            exit();
        }


        if($_POST['Username']=='')
        {
            //Empty username consider error
            $i_username = 1;
        }
        
        if($_POST['Email']=='')
        {
            //Empty username consider error
            $i_email = 1;
        }
        
        if($_POST['Username']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."' AND Agent = '".$_SESSION['reseller_code']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_username = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_username] = array(
                'Username' => $row['Username']);

                $i_username += 1;
            }

            
        }
        
         if($_POST['Email']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Agent = '".$_SESSION['reseller_code']."' AND Email = '".$_POST['Email']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_email = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_email] = array(
                'Email' => $row['Email']);

                $i_email += 1;
            }

            
        }


        // Check if security question is correct
        $i_security = 0;

        if ($_POST['C1']+$_POST['C2']!=$_POST['SQ'])
        {
            $i_security += 1;
        }

        
        
        if($_POST['BankAccountNo']!='' && $_POST['Bank']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Bank = '".$_POST['Bank']."' AND BankAccountNo = '".$_POST['BankAccountNo']."' AND Agent = '".$_SESSION['reseller_code']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_bank = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_bank] = array(
                'BankAccountNo' => $row['BankAccountNo']);

                $i_bank += 1;
            }

            
        }



        $error['count'] = $i_username + $i_security + $i_bank + $i_email;



        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_security>0)
            {
                $error['SQ'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }
            
            if ($i_email>0)
            {
                $error['Email'] = 1;
            }

            $_SESSION['admin']['member_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new member
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            $key = "(Agent, GenderID, Name, FacebookID, NRIC, Passport, Company, Bank, BankAccountNo, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, DateRegistered, Enabled)";
            $value = "('".$_SESSION['reseller_code']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['FacebookID']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '0', '".date('YmdHis')."', '1')";

            $sql = "INSERT INTO member ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Create all product wallets for new member
			//$Product = ProductModel::getProductList();

                        $Product = AgentModel::getAgentProducts($_SESSION['reseller_code']);
                        
                        //echo $Product;
                        //exit;

                        if($Product == 'Null')
                        {

                        }
                        else
                        {
                            /*$Product = explode(',', $Product);

                            $Product['count'] = count($Product);*/

                            for ($i=0; $i <$Product['count'] ; $i++)
                            {
                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                $value = "('0', '".$Product[$i]."', '".$_SESSION['reseller_code']."', '".$newID."', '1')";

                                $sql = "INSERT INTO wallet ".$key." VALUES ". $value;
                                //echo $sql;
                                //exit;
                                $this->dbconnect->exec($sql);
                            }
                        }

            // Insert new member's first address
            /*$key_address = "(MemberID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
            $value_address = "('".$newID."', 'My First Address', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '1')";

            $sql_address = "INSERT INTO member_address ".$key_address." VALUES ". $value_address;

            $count_address = $this->dbconnect->exec($sql_address);*/

            // Set Status
            $ok = ($count==1) ? 1 : "";

        }

            }
            else
            {

                $ok = "";
            }

        if ($ok=='1')
        {
            if($_SESSION['member']['ID']=='10695'){

            AgentModel::getloopAgentParent($_SESSION['reseller_code']);

            if($_SESSION['platform_agent'] == '54'){
                //Set latest resend time
                $_SESSION['member']['activation_time'] = date('YmdHis');


                $activation_code = $this->getActivationCode($newID);

                if ($this->config['SMS_VERIFY_ON']=='1')
                {
                    $this->sendSMS($activation_code['code'], $_POST['MobileNo']);
                }


            }

            unset($_SESSION['platform_agent']);



            // Set latest resend time
            //$_SESSION['member']['activation_time'] = date('YmdHis');

            #$status = $this->checkActivationCode($newID);
            //$activation_code = $this->getActivationCode($newID);

            //if ($this->config['SMS_VERIFY_ON']=='1')
            //{
                //$this->sendSMS($activation_code['code'], $_POST['MobileNo']);
            //}

            // Set latest resend time
            //$_SESSION['member']['activation_time'] = date('YmdHis');

            #$status = $this->checkActivationCode($newID);
            //$activation_code = $this->getActivationCode($newID);

            //$this->sendSMS($activation_code['code'], $_POST['MobileNo']);



            }

        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Registering...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'reseller' => AgentModel::getAgent($_SESSION['reseller_code']),
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function MemberLogin()
    {
        //if(empty($_SESSION['reseller_code'])===false && isset($_SESSION['reseller_code'])===true)
        //{

            //$_SESSION['agentlogout'] = true;
        //}
        //else
        //{

            if ($_SESSION['member']['member_login_info']!="")
            {
                $form_input = $_SESSION['member']['member_login_info'];

                // Unset temporary member info input
                unset($_SESSION['member']['member_login_info']);
            }


            // Set reseller code session
            if ($_GET['rid']!="")
            {
                $reseller_id_list = ResellerModel::getResellerListArray();
                $decoded_reseller_code = base64_decode($_GET['rid']);

                if (is_numeric($decoded_reseller_code))
                {
                    if (in_array($decoded_reseller_code, $reseller_id_list))
                    {
                    }
                    else
                    {
                        exit();
                    }

                    $_SESSION['reseller_code'] = $decoded_reseller_code;
                }
                else {
                    exit();
                }
            }
            
            
            //echo $_SESSION['reseller_code'];
            //exit;

            $_SESSION['agent']['BackgroundColour'] = AgentModel::getAgent($_SESSION['reseller_code'], "BackgroundColour");
            $_SESSION['agent']['FontColour'] = AgentModel::getAgent($_SESSION['reseller_code'], "FontColour");
            $_SESSION['agent']['Logo'] = AgentModel::getAgent($_SESSION['reseller_code'], "Logo");
            //Debug::displayArray($result);
            //exit;
        //}

        if($_SESSION['language']=='en')
        {
           $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='ms')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='zh_CN')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => Helper::translate("Member Login", "member-login-title"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/login.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/login.bottom.inc.php', 'member_login' => $_SESSION['member']['member_login'], 'member_logout' => $_SESSION['member']['member_logout'], 'member_password' => $_SESSION['member']['member_password'], 'member_register' => $_SESSION['member']['member_register'], 'member_forgotpassword' => $_SESSION['member']['member_forgotpassword']),
        'block' => array('side_nav' => $this->module_dir.'inc/member/side_nav.member_out.inc.php', 'common' => "false"),
        'agentblock' => AgentBlockModel::getAgentBlockByAgent($_SESSION['reseller_code'], "login"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"main",$this->config,Helper::translate("Login", "member-breadcrumb-login")),
        'content_param' => array('translate'=>TranslationModel),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['member']['member_login']);
        unset($_SESSION['member']['member_logout']);
        unset($_SESSION['member']['member_password']);
        unset($_SESSION['member']['member_register']);
        unset($_SESSION['member']['member_forgotpassword']);

        return $this->output;
    }

    public function MemberLoginProcess()
    {
        // Set reseller code session
        $reseller_id_list = ResellerModel::getResellerListArray();
        $decoded_reseller_code = $_SESSION['reseller_code'];

        if (is_numeric($decoded_reseller_code))
        {
            if (in_array($decoded_reseller_code, $reseller_id_list))
            {
            }
            else
            {
                exit();
            }
        }
        else {
            exit();
        }
        
        //$_SESSION['webExist'] = time().$_SESSION['reseller_code'];


        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."' AND Agent = '".$_SESSION['reseller_code']."' AND Username !='' AND Enabled = '1' AND Agent != ''";
        //echo $sql;
        //exit;

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
            'Prompt' => $row['Prompt']);

            $i += 1;
        }

        if ($i==1)
        {
            $bcrypt = new Bcrypt(9);
            $verify = $bcrypt->verify($_POST['Password'], $result[0]['Password']);

            // Set Status
            $ok = ($verify==1) ? 1 : "";

            if($_SESSION['member']['ID']=='10695')
            {

            AgentModel::getloopAgentParent($_SESSION['reseller_code']);

            if($_SESSION['platform_agent'] == '54'){

                $sql = "SELECT ActivationCode FROM member WHERE ID='".$result[0]['ID']."'";

            foreach ($this->dbconnect->query($sql) as $row)
	        {
	            $activationcode = $row['ActivationCode'];


	        }

            }
            else
            {
                    $activationcode = '1';

            }

            unset($_SESSION['platform_agent']);

            }



            // Set Status
            //$ok = ($count<=1) ? 1 : "";

            if ($verify!=1)
            {
                // Username and password do not match
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['member']['member_login_info'] = Helper::unescape($_POST);
            }
        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            $_SESSION['member']['member_login_info'] = Helper::unescape($_POST);
        }



        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'activation_code' => $activationcode,
        'content_param' => array('count' => $i),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }
    
    public function MemberOneAgentLogout()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey),
        'page' => array('title' => "Logging Out..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function MemberLogout()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey),
        'page' => array('title' => "Logging Out..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function MemberForgotPassword()
    {
        if ($_SESSION['member']['member_forgotpassword_info']!="")
        {
            $form_input = $_SESSION['member']['member_forgotpassword_info'];

            // Unset temporary member info input
            unset($_SESSION['member']['member_forgotpassword_info']);
        }
        
        // Set reseller code session
            if ($_GET['rid']!="")
            {
                $reseller_id_list = ResellerModel::getResellerListArray();
                $decoded_reseller_code = base64_decode($_GET['rid']);

                if (is_numeric($decoded_reseller_code))
                {
                    if (in_array($decoded_reseller_code, $reseller_id_list))
                    {
                    }
                    else
                    {
                        exit();
                    }

                    $_SESSION['reseller_code'] = $decoded_reseller_code;
                }
                else {
                    exit();
                }
            }

        if($_SESSION['language']=='en')
        {
           $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='ms')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }
        elseif($_SESSION['language']=='zh_CN')
        {
            $this->module_name = Helper::translate("Member", "member-breadcrumb-member");
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => Helper::translate("Forgot Your Password?", "member-login-forgotpassword"), 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/forgotpassword.inc.php', 'custom_bottom_inc' => 'on', 'custom_bottom_inc_loc' => $this->module_dir.'inc/member/forgotpassword.bottom.inc.php', 'member_forgotpassword' => $_SESSION['member']['member_forgotpassword']),
        'block' => array('side_nav' => $this->module_dir.'inc/member/side_nav.member_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_member_url,"",$this->config,Helper::translate("Forgot Password", "member-forgotpassword-title")),
        'content_param' => array('enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['member']['member_forgotpassword']);

        return $this->output;
    }

    public function MemberForgotPasswordProcess()
    {
        // Set reseller code session
        $reseller_id_list = ResellerModel::getResellerListArray();
        $decoded_reseller_code = $_SESSION['reseller_code'];

        if (is_numeric($decoded_reseller_code))
        {
            if (in_array($decoded_reseller_code, $reseller_id_list))
            {
            }
            else
            {
                exit();
            }
        }
        else {
            exit();
        }
        
       
        
        $sql = "SELECT * FROM member WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND Agent = '".$_SESSION['reseller_code']."' AND Agent != ''  LIMIT 0,1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Expiry' => $row['Expiry'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],

            'Prompt' => $row['Prompt']);

            $i += 1;
        }

        if ($i==1)
        {
            // Generate New Password
            $bcrypt = new Bcrypt(9);
            $new_password = uniqid();
            $hash = $bcrypt->hash($new_password);

            $sql = "UPDATE member SET Password='".$hash."', Prompt='1' WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND ID='".$result[0]['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Username and email do not match
            $error['count'] += 1;
            $error['NoMatch'] = 1;

            $_SESSION['member']['member_forgotpassword_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i, 'new_password' => $new_password),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function MemberAccess()
    {
        $sql = "SELECT Enabled FROM member WHERE ID = '".$_SESSION['member']['ID']."'";

        foreach ($this->dbconnect->query($sql) as $row) {


            $Enable = $row['Enabled'];

        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Checking Access..."),
        'content' => $Enable,
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function MemberAutologin()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Auto Logging In..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

	public function AgentIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['member_'.__FUNCTION__] = "";

			#$query_condition .= $crud->queryCondition("Reseller",$_POST['Reseller'],"=");
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=",1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("FacebookID",$_POST['FacebookID'],"LIKE");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
			$query_condition .= $crud->queryCondition("BankAccountNo",$_POST['BankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBank",$_POST['SecondaryBank'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBankAccountNo",$_POST['SecondaryBankAccountNo'],"LIKE");
			/*$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");*/
            $query_condition .= $crud->queryCondition("DateRegistered",Helper::dateTimeDisplaySQL($_POST['DateRegisteredFrom']),">=");
            $query_condition .= $crud->queryCondition("DateRegistered",Helper::dateTimeDisplaySQL($_POST['DateRegisteredTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			#$_SESSION['member_'.__FUNCTION__]['param']['Reseller'] = $_POST['Reseller'];
			$_SESSION['member_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['member_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['member_'.__FUNCTION__]['param']['FacebookID'] = $_POST['FacebookID'];
			$_SESSION['member_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['member_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['member_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
			$_SESSION['member_'.__FUNCTION__]['param']['BankAccountNo'] = $_POST['BankAccountNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['SecondaryBank'] = $_POST['SecondaryBank'];
			$_SESSION['member_'.__FUNCTION__]['param']['SecondaryBankAccountNo'] = $_POST['SecondaryBankAccountNo'];
			/*$_SESSION['member_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['member_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];*/
                        $_SESSION['member_'.__FUNCTION__]['param']['DateRegisteredFrom'] = $_POST['DateRegisteredFrom'];
			$_SESSION['member_'.__FUNCTION__]['param']['DateRegisteredTo'] = $_POST['DateRegisteredTo'];
			$_SESSION['member_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['member_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['member_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['member_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['member_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['member_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['member_'.__FUNCTION__]['query_condition'] = $query_condition;

            if ($_SESSION['member_'.__FUNCTION__]['query_condition']=="")
            {
                $separator = " WHERE ";
            }
            else
            {
                $separator = " AND ";
            }

            if ($_POST['Agent']=="None")
            {
                $reseller_query = $separator." ((Agent = '') OR (Agent IS NULL))";
            }
            else if ($_POST['Agent']=="")
            {
                $reseller_query = "";
            }
            else
            {
                $reseller_query = $separator." Agent = '".$_POST['Agent']."'";
            }

            $_SESSION['member_'.__FUNCTION__]['query_condition'] .= $reseller_query;

			$_SESSION['member_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['member_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['member_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member WHERE Agent = '".$_SESSION['agent']['ID']."' ".$_SESSION['member_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/agent/member/index';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM member WHERE Agent = '".$_SESSION['agent']['ID']."' ".$_SESSION['member_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC, Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => AgentModel::getAgentName($row['Agent']),
            'ResellerID' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
            'DateRegistered' => $row['DateRegistered'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $_SESSION['agent']['redirect'] = __FUNCTION__;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Members", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/index.inc.php', 'member_delete' => $_SESSION['admin']['member_delete']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentmember_url,"",$this->config,"Member"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['member_delete']);

		return $this->output;
	}

        public function AgentAgentMember($param)
	{
                $crud = new CRUD();

                $query_count = "SELECT COUNT(*) AS num FROM member WHERE Agent = '".$param."'";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/agent/member/agentmember/'.$param;
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);



		$sql = "SELECT * FROM member WHERE Agent = '".$param."' ORDER BY ID DESC, Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => AgentModel::getAgentName($row['Agent']),
                        'ResellerID' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
                        'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
                        'DateRegistered' => $row['DateRegistered'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;


		}

                $paramParent = AgentModel::getAgent($param, "ParentID");

                $paramName = AgentModel::getAgent($param, "Name");
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Members (".$paramName.")", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/agentmember.inc.php'),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->agent_module_name,$this->module_default_agentlist_url.'/'.$_SESSION['agent']['ID'],"",$this->config,"Agent Members"),
                'paramParent' => $paramParent,
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
	}

        public function AdminAgentMember($param)
	{
                $crud = new CRUD();

                $query_count = "SELECT COUNT(*) AS num FROM member WHERE Agent = '".$param."'";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/member/agentmember/'.$param;
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);


		$sql = "SELECT * FROM member WHERE Agent = '".$param."' ORDER BY ID DESC, Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => AgentModel::getAgentName($row['Agent']),
                        'ResellerID' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
                        'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
                        'DateRegistered' => $row['DateRegistered'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $paramParent = AgentModel::getAgent($param, "ParentID");

                $paramName = AgentModel::getAgent($param, "Name");


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Members (".$paramName.")", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/agentmember.inc.php'),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/admin/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->agent_module_name,$this->module_default_adminlist_url,"admin",$this->config,"Agent Members"),
                'paramParent' => $paramParent,
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
	}

        public function AgentGroup($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

                if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['member_'.__FUNCTION__] = "";
                        
                                           
                        $query_condition .= $crud->queryCondition("Agent",$_POST['Agent'],"=", 1);
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("FacebookID",$_POST['FacebookID'],"LIKE");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
			$query_condition .= $crud->queryCondition("BankAccountNo",$_POST['BankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBank",$_POST['SecondaryBank'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBankAccountNo",$_POST['SecondaryBankAccountNo'],"LIKE");
			//$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			//$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");
                        $query_condition .= $crud->queryCondition("DateRegistered",Helper::dateTimeDisplaySQL($_POST['DateRegisteredFrom']),">=");
                        $query_condition .= $crud->queryCondition("DateRegistered",Helper::dateTimeDisplaySQL($_POST['DateRegisteredTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['member_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['member_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['member_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['member_'.__FUNCTION__]['param']['FacebookID'] = $_POST['FacebookID'];
			$_SESSION['member_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['member_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['member_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
			$_SESSION['member_'.__FUNCTION__]['param']['BankAccountNo'] = $_POST['BankAccountNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['SecondaryBank'] = $_POST['SecondaryBank'];
			$_SESSION['member_'.__FUNCTION__]['param']['SecondaryBankAccountNo'] = $_POST['SecondaryBankAccountNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['DateRegisteredFrom'] = $_POST['DateRegisteredFrom'];
			$_SESSION['member_'.__FUNCTION__]['param']['DateRegisteredTo'] = $_POST['DateRegisteredTo'];
			$_SESSION['member_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['member_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['member_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['member_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['member_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['member_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['member_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['member_'.__FUNCTION__]['query_title'] = "Search Results";
                }


		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['member_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['member_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }


                $child = implode(',', $_SESSION['agentchild']);

                unset($_SESSION['agentchild']);
                
                
                
                if(isset($_SESSION['member_'.__FUNCTION__]['param']['Agent'])===true && empty($_SESSION['member_'.__FUNCTION__]['param']['Agent'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND Agent IN (".$child.")";
                }

                

                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM member WHERE TRUE = TRUE ".$query_part." ".$_SESSION['member_'.__FUNCTION__]['query_condition'];
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/member/group';
                    $limit = 10;
                    $stages = 3;
                    $page = mysql_escape_string($_GET['page']);
                    if ($page) {
                            $start = ($page - 1) * $limit;
                    } else {
                            $start = 0;
                    }

                    // Initialize Pagination
                    $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

                    $sql = "SELECT * FROM member WHERE TRUE = TRUE ".$query_part." ".$_SESSION['member_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC, Name ASC LIMIT $start, $limit";
            
                

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => AgentModel::getAgentName($row['Agent']),
            'ResellerID' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
            'DateRegistered' => $row['DateRegistered'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;

                $_SESSION['agent']['redirect'] = __FUNCTION__;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Group Members", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/group.inc.php', 'member_delete' => $_SESSION['admin']['member_delete']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentgroup_url,"",$this->config,"Group Members"),
                'agent' => $result2,
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'member_list' => AgentModel::getAgentMemberList(), 'agent_list' => AgentModel::getAgentListByParent($_SESSION['agent']['ID']), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['member_delete']);

		return $this->output;
	}

        public function AgentAdd()
	{
	    if ($_SESSION['agent']['member_add_info']!="")
        {
            $form_input = $_SESSION['agent']['member_add_info'];

            // Unset temporary member info input
            unset($_SESSION['agent']['member_add_info']);
        }

                    $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;

                if($_GET['apc'] == 'apcg')
                {
                    $breadcrumb = $this->module_default_agentgroup_url;
                }
                elseif($_GET['apc'] == 'apci')
                {
                    $breadcrumb = $this->module_default_agentmember_url;
                }
                else
                {
                    $breadcrumb = $this->module_default_agentmember_url;
                }




		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Member", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'member_add' => $_SESSION['agent']['member_add']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Create Member"),
                'back' => $_SESSION['agent']['redirect'],
                'content' => $result2,
                'apc' => $_GET['apc'],
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['member_add']);

		return $this->output;
	}


	public function AgentAddProcess()
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/

        $i_bank = 0;

        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {



        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);

            if($bankCount == '0')
            {

            }
            else
            {
                $i_bank += 1;
            }

        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['member_add_info'] = Helper::unescape($_POST);
        }
        else
        {
    	    $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

			// echo $_POST['SecondaryBank'];
			// echo $_POST['SecondaryBankAccountNo'];


    		$key = "(Agent, GenderID, Name, Company, Bank, FacebookID, BankAccountNo, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, DateRegistered, Enabled)";
    		$value = "('".$_POST['Agent']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['FacebookID']."', '".$_POST['BankAccountNo']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Prompt']."', '".date('YmdHis')."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO member ".$key." VALUES ". $value;
// echo $sql;
// exit;
    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();


					$Product = ProductModel::getProductList();

					for ($i=0; $i <$Product['count'] ; $i++) {
					$key = "(Total, ProductID, MemberID, Enabled)";
					$value = "('0', '".$Product[$i]['ID']."', '".$newID."', '1')";


					$sql = "INSERT INTO wallet ".$key." VALUES ". $value;
					//echo $sql;
					$this->dbconnect->exec($sql);
					}



            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Member...", 'template' => 'agent.common.tpl.php'),
		'content' => Helper::unescape($_POST),
                'apc' => $_POST['apc'],
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

         public function AgentGroupAdd()
	{
	    if ($_SESSION['agent']['member_add_info']!="")
        {
            $form_input = $_SESSION['agent']['member_add_info'];

            // Unset temporary member info input
            unset($_SESSION['agent']['member_add_info']);
        }

        $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Member", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'member_add' => $_SESSION['agent']['member_add']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentmember_url,"",$this->config,"Create Member"),
                'content' => $result2,
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['member_add']);

		return $this->output;
	}


	public function AgentGroupAddProcess()
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/

        $i_bank = 0;

        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {



        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);

            if($bankCount == '0')
            {

            }
            else
            {
                $i_bank += 1;
            }

        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['member_add_info'] = Helper::unescape($_POST);
        }
        else
        {
    	    $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

			// echo $_POST['SecondaryBank'];
			// echo $_POST['SecondaryBankAccountNo'];


    		$key = "(Agent, GenderID, Name, Company, Bank, FacebookID, BankAccountNo, SecondaryBank, SecondaryBankAccountNo, DOB, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
    		$value = "('".$_SESSION['agent']['ID']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['FacebookID']."', '".$_POST['BankAccountNo']."', '".$_POST['SecondaryBank']."', '".$_POST['SecondaryBankAccountNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO member ".$key." VALUES ". $value;
// echo $sql;
// exit;
    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();


					$Product = ProductModel::getProductList();

					for ($i=0; $i <$Product['count'] ; $i++) {
					$key = "(Total, ProductID, MemberID, Enabled)";
					$value = "('0', '".$Product[$i]['ID']."', '".$newID."', '1')";


					$sql = "INSERT INTO wallet ".$key." VALUES ". $value;
					//echo $sql;
					$this->dbconnect->exec($sql);
					}



            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Member...", 'template' => 'agent.common.tpl.php'),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentEdit($param)
	{
		$sql = "SELECT * FROM member WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'Agent' => $row['Agent'],
			'GenderID' => $row['GenderID'],
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        if ($_SESSION['agent']['member_edit_info']!="")
        {
            $form_input = $_SESSION['agent']['member_edit_info'];

            // Unset temporary member info input
            unset($_SESSION['agent']['member_edit_info']);
        }

        $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
                //echo $sql2;
                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }
                    //Debug::displayArray($result2);
                    //exit;
                    $result2['count'] = $z;

		/*Debug::displayArray($form_input);
		exit;*/


                if(isset($_GET['apc'])===true && $_GET['apc']=='apcg')
                {
                    $member_list = MemberModel::getMemberListByAgentAgent($_SESSION['agent']['ID']);
                    $breadcrumb = $this->module_default_agentgroup_url;
                }
                else
                {
                    $member_list = MemberModel::getMemberListByReseller($_SESSION['agent']['ID']);
                    $breadcrumb = $this->module_default_agent_url;
                }

                /*$bank_list = BankModel::getBankList();

                for ($i = 0; $i < $bank_list['count']; $i++) {
                    if($bank_list[$i]['Label'] == $result[0]['Bank'])
                    {
                        echo $result[0]['Bank'];
                    }
                }

                exit;*/


		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Member", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'member_add' => $_SESSION['agent']['member_add'], 'member_edit' => $_SESSION['agent']['member_edit']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Edit Member"),
		'content' => $result,
                'apc' => $_GET['apc'],
                'back' => $_SESSION['agent']['redirect'],
                'agent' => $result2,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['member_add']);
		unset($_SESSION['agent']['member_edit']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/

        $i_bank = 0;

        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {



        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);

            if($bankCount == '0')
            {

            }
            else
            {
                $i_bank += 1;
            }

        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['member_edit_info'] = Helper::unescape($_POST);
        }
        else
        {
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

    		$sql = "UPDATE member SET Agent='".$_POST['Agent']."', GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', FacebookID='".$_POST['FacebookID']."', Company='".$_POST['Company']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Member...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
                'apc' => $_POST['apc'],
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentGroupEdit($param)
	{
		$sql = "SELECT * FROM member WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => $row['Agent'],
			'GenderID' => $row['GenderID'],
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        if ($_SESSION['agent']['member_edit_info']!="")
        {
            $form_input = $_SESSION['agent']['member_edit_info'];

            // Unset temporary member info input
            unset($_SESSION['agent']['member_edit_info']);
        }
		/*Debug::displayArray($form_input);
		exit;*/
		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Member", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'member_add' => $_SESSION['agent']['member_add'], 'member_edit' => $_SESSION['agent']['member_edit']),
		'block' => array('side_nav' => $this->agent_module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentgroup_url,"",$this->config,"Edit Member"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['agent']['member_add']);
		unset($_SESSION['agent']['member_edit']);

		return $this->output;
	}

	public function AgentGroupEditProcess($param)
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/

        $i_bank = 0;

        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {



        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);

            if($bankCount == '0')
            {

            }
            else
            {
                $i_bank += 1;
            }

        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['member_edit_info'] = Helper::unescape($_POST);
        }
        else
        {
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

    		$sql = "UPDATE member SET Agent='".$_POST['Agent']."', GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', FacebookID='".$_POST['FacebookID']."', Company='".$_POST['Company']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', SecondaryBank='".$_POST['SecondaryBank']."', SecondaryBankAccountNo='".$_POST['SecondaryBankAccountNo']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Member...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AgentDelete($param)
	{
		$sql = "DELETE FROM member WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Member...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function AgentGroupDelete($param)
	{
		$sql = "DELETE FROM member WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Member...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['member_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("Agent",$_POST['Agent'],"=");
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("FacebookID",$_POST['FacebookID'],"LIKE");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
			$query_condition .= $crud->queryCondition("BankAccountNo",$_POST['BankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBank",$_POST['SecondaryBank'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBankAccountNo",$_POST['SecondaryBankAccountNo'],"LIKE");
			/*$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");*/
            $query_condition .= $crud->queryCondition("DateRegistered",Helper::dateTimeDisplaySQL($_POST['DateRegisteredFrom']),">=");
            $query_condition .= $crud->queryCondition("DateRegistered",Helper::dateTimeDisplaySQL($_POST['DateRegisteredTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['member_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['member_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['member_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['member_'.__FUNCTION__]['param']['FacebookID'] = $_POST['FacebookID'];
			$_SESSION['member_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['member_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['member_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
			$_SESSION['member_'.__FUNCTION__]['param']['BankAccountNo'] = $_POST['BankAccountNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['SecondaryBank'] = $_POST['SecondaryBank'];
			$_SESSION['member_'.__FUNCTION__]['param']['SecondaryBankAccountNo'] = $_POST['SecondaryBankAccountNo'];
			/*$_SESSION['member_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['member_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];*/
                        $_SESSION['member_'.__FUNCTION__]['param']['DateRegisteredFrom'] = $_POST['DateRegisteredFrom'];
                        $_SESSION['member_'.__FUNCTION__]['param']['DateRegisteredTo'] = $_POST['DateRegisteredTo'];
			$_SESSION['member_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['member_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['member_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['member_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['member_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['member_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['member_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['member_'.__FUNCTION__]['query_condition'] = $query_condition;

            if ($_SESSION['member_'.__FUNCTION__]['query_condition']=="")
            {
                $separator = " WHERE ";
            }
            else
            {
                $separator = " AND ";
            }

            if ($_POST['Agent']=="None")
            {
                $agent_query = $separator." ((Agent = '') OR (Agent IS NULL))";
            }
            else if ($_POST['Agent']=="")
            {
                $agent_query = "";
            }
            else
            {
                $agent_query = $separator." Agent = '".$_POST['Agent']."'";
            }

            $_SESSION['member_'.__FUNCTION__]['query_condition'] .= $agent_query;

			$_SESSION['member_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['member_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['member_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member ".$_SESSION['member_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/member/index';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM member ".$_SESSION['member_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC, Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => AgentModel::getAgentName($row['Agent']),
            'ResellerID' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
            'DateRegistered' => $row['DateRegistered'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

                $result2 = AgentModel::getAdminAgentAllParentChild();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Members", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'member_delete' => $_SESSION['admin']['member_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.member_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList(), 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['member_delete']);

		return $this->output;
	}

         public function APIRegisterProcess()
        {
         // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {

                if(AgentModel::getAgentID($request_data['Agent'])===FALSE){
                    $systemError = 1;
                }
                else
                {
                    $ID = AgentModel::getAgentID($request_data['Agent']);
                }


        if($request_data['Username']=='')
        {
            //Empty username consider error
            $i_username = 1;
        }
        
        if($request_data['Email']=='')
        {
            //Empty username consider error
            $i_email = 1;
        }
        
        if($request_data['Username']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Username = '".$request_data['Username']."' AND Agent = '".$ID."' AND Agent != '' AND Username != '' AND Enabled = '1'";
            //echo $sql;
            //exit;

            $result = array();
            $i_username = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_username] = array(
                'Username' => $row['Username']);

                $i_username += 1;
            }
        }
        
        if($request_data['Email']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Agent = '".$ID."' AND Email = '".$request_data['Email']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_email = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_email] = array(
                'Email' => $row['Email']);

                $i_email += 1;
            }

            
        }


        

        if($request_data['BankAccountNo']!='' && $request_data['Bank']!='')
        {
            
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Bank = '".$request_data['Bank']."' AND BankAccountNo = '".$request_data['BankAccountNo']."' AND Agent = '".$ID."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_bank = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_bank] = array(
                'BankAccountNo' => $row['BankAccountNo']);

                $i_bank += 1;
            }

            
        }



        $error['count'] = $i_username + $i_security + $i_bank + $i_email;
        //Debug::displayArray($error);
        //exit;
        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_security>0)
            {
                $error['SQ'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }
            
            if ($i_email>0)
            {
                $error['Email'] = 1;
            }

            $_SESSION['admin']['member_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new member
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($request_data['Password']);

            $key = "(Agent, GenderID, Name, FacebookID, NRIC, Passport, Company, Bank, BankAccountNo, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, DateRegistered, Enabled)";
            $value = "('".$ID."', '".$request_data['GenderID']."', '".$request_data['Name']."', '".$request_data['FacebookID']."', '".$request_data['NRIC']."', '".$request_data['Passport']."', '".$request_data['Company']."', '".$request_data['Bank']."', '".$request_data['BankAccountNo']."', '".Helper::dateDisplaySQL($request_data['DOB'])."', '".$request_data['Nationality']."', '".$request_data['Username']."', '".$hash."', '".$request_data['PhoneNo']."', '".$request_data['FaxNo']."', '".$request_data['MobileNo']."', '".$request_data['Email']."', '0', '".date('YmdHis')."', '1')";

            $sql = "INSERT INTO member ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Create all product wallets for new member
			//$Product = ProductModel::getProductList();

                        $Product = AgentModel::getAgentProducts($ID);

                        if($Product == 'Null')
                        {

                        }
                        else
                        {
                            /*$Product = explode(',', $Product);

                            $Product['count'] = count($Product);*/

                            for ($i=0; $i <$Product['count'] ; $i++)
                            {
                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                $value = "('0', '".$Product[$i]."', '".$ID."', '".$newID."', '1')";

                                $sql = "INSERT INTO wallet ".$key." VALUES ". $value;
                                //echo $sql;
                                //exit;
                                $this->dbconnect->exec($sql);
                            }
                        }



            // Set Status
            $ok = ($count==1) ? 1 : "";

            $reseller = AgentModel::getAgent($ID);

            $mailer = new BaseMailer();
            $mailer->CharSet = 'UTF-8';

            $mailer->From = $reseller['Email'];
            $mailer->AddReplyTo($this->config['MEMBER_EMAIL_FROM'], $reseller['Name']);
            $mailer->FromName = $reseller['Name'];

            $mailer->Subject = "Welcome to ".$reseller['Name']."!";

            $mailer->AddAddress($request_data['Email'], '');
            //$mailer->AddBCC($param['reseller']['Email'], '');
            $mailer->AddAddress($reseller['Email'], '');

            $mailer->IsHTML(true);

            ob_start();
            require_once('modules/member/mail/member.register_mobile.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/member/mail/member.register_mobile.txt.php');
            $txtBody = ob_get_contents();
            ob_end_clean();

            $mailer->IsHTML(true);
            $mailer->Body = $htmlBody;
            $mailer->AltBody = $txtBody;

            // For non-HTML (text) emails
            #$mailer->IsHTML(false);
            #$mailer->Body = $txtBody;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();


            $agentmail = new BaseMailer();
            $agentmail->CharSet = 'UTF-8';

            $agentmail->From = $reseller['Email'];
            $agentmail->AddReplyTo($this->config['MEMBER_EMAIL_FROM'], $reseller['Name']);
            $agentmail->FromName = $reseller['Name'];

            $agentmail->Subject = "Welcome to ".$reseller['Name']."!";


            $agentmail->AddAddress($reseller['PlatformEmail1'], '');
            $agentmail->AddAddress($reseller['PlatformEmail2'], '');
            $agentmail->AddAddress($reseller['PlatformEmail3'], '');
            $agentmail->AddAddress($reseller['PlatformEmail4'], '');
            $agentmail->AddAddress($reseller['PlatformEmail5'], '');
            $agentmail->AddAddress($reseller['PlatformEmail6'], '');
            $agentmail->AddAddress($reseller['PlatformEmail7'], '');
            $agentmail->AddAddress($reseller['PlatformEmail8'], '');
            $agentmail->AddAddress($reseller['PlatformEmail9'], '');
            $agentmail->AddAddress($reseller['PlatformEmail10'], '');

            $agentmail->IsHTML(true);

            ob_start();
            require_once('modules/member/mail/member.register.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/member/mail/member.register.txt.php');
            $txtBody = ob_get_contents();
            ob_end_clean();

            $agentmail->IsHTML(true);
            $agentmail->Body = $htmlBody;
            $agentmail->AltBody = $txtBody;

            // For non-HTML (text) emails
            #$mailer->IsHTML(false);
            #$mailer->Body = $txtBody;

            $agentmail->Send();

            $agentmail->ClearAddresses();
            $agentmail->ClearAttachments();



        }

        

           // Set output
                if ($ok=="1")
                {
                    AgentModel::getloopAgentParent($ID);

                    if($_SESSION['platform_agent'] == '54'){
                        //Set latest resend time
                        //$_SESSION['member']['activation_time'] = date('YmdHis');


                        $activation_code = $this->getActivationCode($newID);


                            $this->sendSMS($activation_code['code'], $request_data['MobileNo']);





                    }


                    unset($_SESSION['platform_agent']);

                    $result = json_encode(array('Status' => 'Registered Successfully'));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    
                    $_SESSION['language'] = $request_data['LanguageCode'];
                    
                    $registeredMessages = '';
                    
                    if ($i_username>0)
                    {
                        $registeredMessages .= Helper::translate("The username ", "member-register-username-1").' '.$request_data['Username'].' '.Helper::translate("is taken. Please try again with another username.", "member-register-username-2");
                    }

                    if ($i_security>0)
                    {
                        $registeredMessages .= Helper::translate("The Security Question is answered incorrectly. Please try again.", "member-register-security");
                        $error['SQ'] = 1;
                    }

                    if ($i_bank>0)
                    {
                        $registeredMessages .= Helper::translate("You had an existing account with us. Please contact our 24 hours service representative if you like to create additional account.", "member-register-bank-duplicated");
                    }

                    if ($i_email>0)
                    {
                        $registeredMessages .= Helper::translate("The email ", "member-register-username-1").' '.$request_data['Email'].' '.Helper::translate("is taken. Please try again with another email.", "member-register-username-2");
                    }
                    
                    
                    
                    unset($_SESSION['language']);
                    $restapi->setResponse('401', $registeredMessages);
                    
                }
                else if ($systemError>0)
                {
                    $restapi->setResponse('401', 'System Error');
                }

        }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }


    public function APIForgotPasswordProcess($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                $sql = "SELECT * FROM member WHERE Email = '".$request_data['Email']."' AND Username = '".$request_data['Username']."' LIMIT 0,1";

                $result = array();
                $i = 0;
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'Username' => $row['Username'],
                    'Email' => $row['Email'],
                    'Name' => $row['Name'],
                    'Prompt' => $row['Prompt']);

                    $i += 1;
                }

                $output['Count'] = $i;
                $output['Content'] = $result;
                $output['Status'] = "Password Reset Successful";

                if ($i==1)
                {
                    // Generate New Password
                    $bcrypt = new Bcrypt(9);
                    $new_password = uniqid();
                    $hash = $bcrypt->hash($new_password);

                    $sql = "UPDATE member SET Password='".$hash."', Prompt='1' WHERE Email = '".$request_data['Email']."' AND Username = '".$request_data['Username']."' AND ID='".$result[0]['ID']."'";

                    $count = $this->dbconnect->exec($sql);

                    // Set Status
                    $ok = ($count<=1) ? 1 : "";

                    // Send mail to user
                    $mailer = new BaseMailer();
                    $mailer->CharSet = 'UTF-8';

                    $mailer->From = $this->config['EMAIL_SENDER'];
                    $mailer->AddReplyTo($this->config['COMPANY_EMAIL'], $this->config['COMPANY_NAME']);
                    $mailer->FromName = $this->config['COMPANY_NAME'];

                    $mailer->Subject = "[".$this->config['SITE_NAME']."] New password request";

                    $mailer->AddAddress($request_data['Email'], '');
                    #$mailer->AddBCC('abc@gmail.com', '');

                    $mailer->IsHTML(true);

                    ob_start();
                    require_once('modules/member/mail/member.forgotpasswordprocess_sms.php');
                    $htmlBody = ob_get_contents();
                    ob_end_clean();

                    ob_start();
                    require_once('modules/member/mail/member.forgotpasswordprocess_sms.txt.php');
                    $txtBody = ob_get_contents();
                    ob_end_clean();

                    $mailer->IsHTML(true);
                    $mailer->Body = $htmlBody;
                    $mailer->AltBody = $txtBody;

                    $mailer->Send();

                    $mailer->ClearAddresses();
                    $mailer->ClearAttachments();

                }
                else
                {
                    // Username and email do not match
                    $error['count'] += 1;
                    $error['NoMatch'] = 1;
                }

                // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array("Status" => $output['Status']));
                    $restapi->setResponse('200', 'OK', $result, FALSE);


                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('404', 'Invalid Username Or Email');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

    public function APIPasswordProcess()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                // Update new password if current password is entered correctly
                $bcrypt = new Bcrypt(9);
                $verify = $bcrypt->verify($request_data['Password'], $this->getHash($request_data['memberID']));

                if ($verify==1)
                {
                    $hash = $bcrypt->hash($request_data['PasswordNew']);

                    // Save new password and disable Prompt
                    $sql = "UPDATE member SET Password='".$hash."', Prompt = 0 WHERE ID='".$request_data['memberID']."'";
                    $count = $this->dbconnect->exec($sql);

                    // Set Status
                    $ok = ($count<=1) ? 1 : "";
                }
                else
                {
                    // Current password incorrect
                    $error['count'] += 1;
                    $error['Password'] = 1;
                }
                //echo $ok;

                // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => 'Password Changed Successfully'));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    if ($error['Password']=="1")
                    {
                        $error_message = "Current Password Incorrect";
                    }

                    $restapi->setResponse('400', $error_message);
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

    public function APIProfileProcess($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                $error = array();
                $result = array();

                    if ($request_data['Nationality']==151)
                    {
                        $request_data['Passport'] = '';

                        // Check is NRIC exists
                        $sql = "SELECT * FROM member WHERE NRIC = '".$request_data['NRIC']."' AND ID != '".$request_data['memberID']."' AND Enabled = '1' AND ID != '' AND NRIC != ''";


                        $i_nric = 0;
                        foreach ($this->dbconnect->query($sql) as $row)
                        {
                            $result[$i_nric] = array(
                            'NRIC' => $row['NRIC']);

                            $i_nric += 1;
                        }
                    }
                    else
                    {
                        $request_data['NRIC'] = '';

                        // Check is Passport exists
                        $sql = "SELECT * FROM member WHERE Passport = '".$request_data['Passport']."' AND ID != '".$request_data['memberID']."' AND Enabled = '1' AND ID != '' AND Passport != ''";


                        $i_passport = 0;
                        foreach ($this->dbconnect->query($sql) as $row)
                        {
                            $result[$i_passport] = array(
                            'Passport' => $row['Passport']);

                            $i_passport += 1;
                        }
                    }

                    $error['count'] = $i_nric + $i_passport;

                    if ($error['count']>0)
                    {
                        if ($i_nric>0)
                        {
                            $error['NRIC'] = 1;
                        }

                        if ($i_passport>0)
                        {
                            $error['Passport'] = 1;
                        }
                    }
                    else
                    {
                        $sql = "UPDATE member SET GenderID='".$request_data['GenderID']."', Name='".$request_data['Name']."', NRIC='".$request_data['NRIC']."', Passport='".$request_data['Passport']."', Company='".$request_data['Company']."', DOB='".Helper::dateDisplaySQL($request_data['DOB'])."', Nationality='".$request_data['Nationality']."', PhoneNo='".$request_data['PhoneNo']."', FaxNo='".$request_data['FaxNo']."', MobileNo='".$request_data['MobileNo']."', Email='".$request_data['Email']."', FacebookID='".$request_data['FacebookID']."' WHERE ID='".$request_data['memberID']."'";

                        $count = $this->dbconnect->exec($sql);

                        // Set Status
                        $ok = ($count<=1) ? 1 : "";
                    }





                // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => 'member-profile-updated'));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if($error['count']>0)
                {
                    if ($error['NRIC']=="1")
                    {
                        $error_message = 'member-profile-nric-1';
                    }
                    else if ($error['Passport']=="1")
                    {
                        $error_message = array('member-profile-passport-1', 'member-profile-passport-2');
                    }

                    $restapi->setResponse('400', $error_message);
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }



    public function APIResendActivationProcess()
    {
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();


            if ($authenticate=="OK")
            {

            // Set latest resend time
	    $request_data['activation_time'] = date('YmdHis');


            $activation_code = $this->getActivationCode($request_data['memberID']);
            $this->sendSMS($activation_code['code'], $request_data['MobileNo']);

            $ok = '1';
            // Set output
                if ($ok=="1")
                {
                     $result = json_encode(array('Status' => 'Resent Successfully'));
                     $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }

    }


    public function APIProfile()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();
                       


        $sql = "SELECT * FROM member WHERE ID = '".$request_data['memberID']."' AND Enabled = '1'";

        $result = array();

        foreach ($this->dbconnect->query($sql) as $row)
        {

            $dataSet = array(
            'ID' => $row['ID'],
            'GenderID' => $row['GenderID'],
            'Name' => $row['Name'],
            'Company' => $row['Company'],
            'FacebookID' => $row['FacebookID'],
            'Bank' => $row['Bank'],
            'BankAccountNo' => $row['BankAccountNo'],
	    'NRIC' => $row['NRIC'],
            'Passport' => $row['Passport'],
            'Nationality' => $row['Nationality'],
            'Username' => $row['Username'],
            'PhoneNo' => $row['PhoneNo'],
            'FaxNo' => $row['FaxNo'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email']);
            array_push($result, $dataSet);

        }


            $output = array();

            $output['Count'] = 1;
            $output['Content'] = $result;
            $output['Country_List'] = CountryModel::getAPICountryList();

            // Set output
            if ($output['Count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }
    
    public function APIGuideImage()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();
                                  
            
            $output['GuidePromotion'] = GuidePromotionModel::getAPIGuidePromotionList($request_data['Agent']);
            $output['announcementTicker'] = AnnouncementTickerModel::getAPIAnnouncementTickerList($request_data['Agent']);
            $output['guidepromotionCount'] = count($output['GuidePromotion']);
            $output['announcementTickerCount'] = count($output['announcementTicker']);
            
            // Set output
            if ($output['guidepromotionCount']>0 || $output['announcementTickerCount']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

    public function APIBankList()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();


        $sql = "SELECT * FROM bank WHERE Enabled = '1'";

        $result = array();

        foreach ($this->dbconnect->query($sql) as $row)
        {

            $dataSet = array(
            'ID' => $row['ID'],
            'Label' => $row['Label']);
            array_push($result, $dataSet);

        }





            $output['Content'] = $result;
            $output['Count'] = count($output['Content']);
            //$output['Country_List'] = CountryModel::getAPICountryList();

            // Set output
            if ($output['Count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }


    public function APIUpdateActivationProcess()
	{


        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();


            if ($authenticate=="OK")
            {

            $request_data['MobileNo'] = $request_data['MobilePrefix'].$request_data['MobileNo'];
            // Set latest resend time
            $request_data['activation_time'] = date('YmdHis');

            //resend sms
            $sql = "UPDATE member SET MobileNo = '".$request_data['MobileNo']."' WHERE ID = '".$request_data['memberID']."'";

	    $request_data['MobileNo'] = $request_data['MobileNo'];

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";

            $activation_code = $this->getActivationCode($request_data['memberID']);
            $this->sendSMS($activation_code['code'], $request_data['MobileNo']);


            // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => 'Updated Successfully'));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }

	}

    public function APIActivationProcess()
    {

         $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();


            if ($authenticate=="OK")
            {


    $member = $this->getMember($request_data['memberID']);

			if($member[0]['ActivationCode'] == $request_data['ActivationCode']){


				$Activated = '1';

			}else{

				$Activated = '0';
			}


			if($Activated == '1'){

				$sql = "UPDATE member SET ActivationCode='1' WHERE ID='".$request_data['memberID']."'";

	            $count = $this->dbconnect->exec($sql);

	            // Set Status
	            $ok = ($count<=1) ? 1 : "";


			}

            // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => 'Account activation succeed'));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }

            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }

    }

        public function APILoginProcess()
    {
            //echo 'hi syah';
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                if(AgentModel::getAgentID($request_data['Agent'])===FALSE){
                    $systemError = 1;
                }
                else
                {
                    $ID = AgentModel::getAgentID($request_data['Agent']);
                }

            	 $sql = "SELECT * FROM member WHERE Username = '".$request_data['Username']."' AND Agent = '".$ID."' AND Username !='' AND Enabled = '1' AND Agent != ''";
        //echo $sql;
        //exit;
                 
        $_SESSION['agent']['ID'] = $ID;         

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Agent' => $row['Agent'],
            'Username' => $row['Username'],
            'AgentLink' => AgentModel::getAgent($row['Agent'], "Company"),  
            'AgentChat' => 'http://www.yessys33.com/main/agent/chat',    
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'ActivationCode' => $row['ActivationCode'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
            'Prompt' => $row['Prompt'],
            'SMSText_en' => "<!DOCTYPE html>
                                    <head>
                                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                    <meta name='viewport' content='width=device-width, initial-scale=1' />
                                    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                    <style type='text/css'>
                                    body{
                                        margin: 20px 20px;
                                        font-size: 80%;
                                        background-color: #ffff00 !important;
                                        color: #000 !important;
                                     }

                                    </style>
                                    </head>
                                    <body><p><b>For Existing Member Only :</b><br>
                            <b>First Time Activation Required :</b><br>
                            Please update your mobile number and click update.<br>
                            Once updated you will receive a<br>
                            SMS activation code immediately.<br>
                            Please key -in your SMS activation code and click 'Submit'.</p></body></html>",
            'SMSText_ms' => "<!DOCTYPE html>
                                    <head>
                                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                    <meta name='viewport' content='width=device-width, initial-scale=1' />
                                    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'>
                                    <style type='text/css'>
                                    body{
                                        margin: 20px 20px;
                                        font-size: 80%;
                                        background-color: #ffff00 !important;
                                        color: #000 !important;
                                     }

                                    </style>
                                    </head>
                                    <body><p><b>Bagi Ahli Sedia Ada Sahaja:</b><br>
                            <b>Pengaktifan Kali Pertama Diperlukan:</b><br>
                            Sila kemas kini telefon bimbit anda dan klik \"Update.<br>
                            Setelah dikemaskini anda akan menerima<br>
                            kod pengaktifan SMS segera.<br>
                            Sila taip kod pengaktifan SMS soda dan klik 'Submit'</p></body></html>");

            $i += 1;
        }
        
        /*if($this->config['SMS_VERIFY_ON']=='1')
        { */   

        if($result[0]['ActivationCode']=='1')
        {

                    $result[0]['Send'] = 0;

        }
        else
        {
                AgentModel::getloopAgentParent($ID);

                    if($_SESSION['platform_agent'] == '54'){


                         $send = 1;
                    }
                    else
                    {
                          $send = 0;
                    }

                    unset($_SESSION['platform_agent']);
                    
                    if($this->config['SMS_VERIFY_ON']=='1')
                    {
                       $result[0]['Send'] = $send;
                    }
                    else
                    {
                        $result[0]['Send'] = 0;
                    }    
                        
        }
        
        //}


        $output['Count'] = $i;
        $output['Content'] = $result;
        //$output['GuidePromotion'] = GuidePromotionModel::getAPIGuidePromotionList($ID);

        // Remove password from output
        unset($output['Content'][0]['Password']);

        if ($i==1)
        {
            $bcrypt = new Bcrypt(9);
            $verify = $bcrypt->verify($request_data['Password'], $result[0]['Password']);

            // Set Status
            $ok = ($verify==1) ? 1 : "";

            AgentModel::getloopAgentParent($request_data['Agent']);

            if($_SESSION['platform_agent'] == '54'){

                $sql = "SELECT ActivationCode FROM member WHERE ID='".$result[0]['ID']."'";

            foreach ($this->dbconnect->query($sql) as $row)
	        {
	            $activationcode = $row['ActivationCode'];


	        }

            }
            else
            {
                    $activationcode = '1';

            }

            unset($_SESSION['platform_agent']);



            // Set Status
            //$ok = ($count<=1) ? 1 : "";

            if ($verify!=1)
            {
                // Username and password do not match
                $error['count'] += 1;
                $error['Login'] = 1;

                //$_SESSION['member']['member_login_info'] = Helper::unescape($_POST);
            }
        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            //$_SESSION['member']['member_login_info'] = Helper::unescape($_POST);
        }

                // Set output
                if ($ok=="1")
                {


                    $result = json_encode($output);
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    $restapi->setResponse('401', 'Not Authorized');
                }
                else if ($systemError>0)
                {
                    $restapi->setResponse('401', 'System Error');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }



	public function AdminAdd()
	{
	    if ($_SESSION['admin']['member_add_info']!="")
        {
            $form_input = $_SESSION['admin']['member_add_info'];

            // Unset temporary member info input
            unset($_SESSION['admin']['member_add_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Member", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'member_add' => $_SESSION['admin']['member_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.member_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Member"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['member_add']);

		return $this->output;
	}


	public function AdminAddProcess()
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/

        $i_bank = 0;

        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {



        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);

            if($bankCount == '0')
            {

            }
            else
            {
                $i_bank += 1;
            }

        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['member_add_info'] = Helper::unescape($_POST);
        }
        else
        {
    	    $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

			// echo $_POST['SecondaryBank'];
			// echo $_POST['SecondaryBankAccountNo'];


    		$key = "(Agent, GenderID, Name, Company, Bank, FacebookID, BankAccountNo, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, DateRegistered, Enabled)";
    		$value = "('".$_POST['Agent']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['FacebookID']."', '".$_POST['BankAccountNo']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Prompt']."', '".date('YmdHis')."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO member ".$key." VALUES ". $value;
// echo $sql;
// exit;
    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();


                                        $Product = AgentModel::getAgentProduct($_POST['Agent']);

                                        $Product = explode(',', $Product);

                                        $Product['count'] = count($Product);

                                        for ($i=0; $i <$Product['count'] ; $i++)
                                        {
                                            $key = "(Total, AgentID, ProductID, MemberID, Enabled)";
                                            $value = "('0', '".$_POST['Agent']."', '".$Product[$i]."', '".$newID."', '1')";

                                            $sql = "INSERT INTO wallet ".$key." VALUES ". $value;
                                            $this->dbconnect->exec($sql);
                                        }


            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Member...", 'template' => 'admin.common.tpl.php'),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM member WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => $row['Agent'],
			'GenderID' => $row['GenderID'],
			'Name' => $row['Name'],
			'FacebookID' => $row['FacebookID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

        if ($_SESSION['admin']['member_edit_info']!="")
        {
            $form_input = $_SESSION['admin']['member_edit_info'];

            // Unset temporary member info input
            unset($_SESSION['admin']['member_edit_info']);
        }
		/*Debug::displayArray($form_input);
		exit;*/
		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Member", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'member_add' => $_SESSION['admin']['member_add'], 'member_edit' => $_SESSION['admin']['member_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.member.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Member"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'agent_list' => AgentModel::getAgentList(), 'bank_list' => BankModel::getBankList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['member_add']);
		unset($_SESSION['admin']['member_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM member WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM member WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/

        $i_bank = 0;

        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {



        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);

            if($bankCount == '0')
            {

            }
            else
            {
                $i_bank += 1;
            }

        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            $_SESSION['admin']['member_edit_info'] = Helper::unescape($_POST);
        }
        else
        {
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

    		$sql = "UPDATE member SET Agent='".$_POST['Agent']."', GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', FacebookID='".$_POST['FacebookID']."', Company='".$_POST['Company']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Member...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM member WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Member...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getAllMemberID(){
		$sql = "SELECT COUNT(ID) FROM member";
		$result = $this->dbconnect->query($sql);
		$result = $result->fetchColumn();
		if ($result==1) {
			$sql = "SELECT ID FROM member";
			$result = $this->dbconnect->query($sql);
			$result = $result->fetchColumn();
		} else {
			$sql = "SELECT ID FROM member";

			foreach($this->dbconnect->query($sql) as $row){
				$ID .= $row['ID'].',';
			}
			$ID = rtrim($ID,',');
			$result = '('.$ID.')';
		}

		return $result;

	}

	public function getMember($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'Agent' => $row['Agent'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'ActivationCode' => $row['ActivationCode'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		return $result;
	}

        public function getAPIMember($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member WHERE ID = '".$param."'";

		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$dataSet = array(
			'ID' => $row['ID'],
                        'Agent' => $row['Agent'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'ActivationCode' => $row['ActivationCode'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

                        array_push($result, $dataSet);

		}

		return $result;
	}

        public function getConcatMemberAgent($param)
	{


		$sql = "SELECT ID FROM member WHERE Agent = '".$param."' AND Enabled = '1'";

		$concat = '';
                $counter = 1;

                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $concat.=$row['ID'];
                            if($this->dbconnect->query($sql)->rowCount()!==$counter){
                                $concat.=',';
                            }

                         $counter+=1;
                    }


		return $result;
	}

        public function getConcatSpaceMemberAgent($param)
	{


		$sql = "SELECT ID FROM member WHERE Agent = '".$param."' AND Enabled = '1'";

		$concat = '';
                $counter = 1;

                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $concat.=$row['ID'];
                            if($this->dbconnect->query($sql)->rowCount()!==$counter){
                                $concat.=', ';
                            }

                         $counter+=1;
                    }


		return $result;
	}

        public function getMemberAgent($param)
	{

		$sql = "SELECT ID FROM member WHERE Agent = '".$param."' AND Enabled = '1'";
                //echo $sql;
                //exit;
                $result = array();
                $i = 0;

                foreach ($this->dbconnect->query($sql) as $row)
                {
                        $result[$i]['ID'] = $row['ID'];

                     $i+=1;
                }

                $result['count'] = $i;
                //Debug::displayArray($result);
                //exit;
		return $result;
	}

    public function getMemberByAgent($param)
    {

		$sql = "SELECT COUNT(*) AS memberCount FROM member WHERE Agent = '".$param."'";


                foreach ($this->dbconnect->query($sql) as $row)
                {
                        $result = $row['memberCount'];


                }

		return $result;
    }

    public function getMemberReseller($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM member WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Agent' => AgentModel::getAgentName($row['Agent']));

            $i += 1;
        }

        return $result[0]['Agent'];
    }
    
    public function getMemberResellerCompany($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM member WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Agent' => AgentModel::getAgent($row['Agent'], "Company"));

            $i += 1;
        }

        return $result[0]['Agent'];
    }
	
	 public function getMemberResellerCompanyType($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM member WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Type' => AgentModel::getAgent($row['Agent'], "TypeID"));

            $i += 1;
        }

        return $result[0]['Type'];
    }

    public function getMemberResellerID($param)
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM member WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Agent' => $row['Agent']);

            $i += 1;
        }

        return $result[0]['Agent'];
    }

	public function getMemberName($param)
	{
		$crud = new CRUD();

		$sql = "SELECT Name FROM member WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'Name' => $row['Name']);

			$i += 1;
		}
		$result = $result[0]['Name'];
		return $result;
	}

    public function getMemberUsername($param)
    {
        $crud = new CRUD();

        $sql = "SELECT Username FROM member WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'Username' => $row['Username']);

            $i += 1;
        }
        $result = $result[0]['Username'];
        return $result;
    }

	public function getMemberList()
	{
            //echo 'hi';
		$crud = new CRUD();

		$sql = "SELECT * FROM member ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => trim($row['Name']),
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => trim($row['Username']),
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}



	public function getMemberListByReseller($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member WHERE Agent = '".$param."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

        public function getMemberListByAgentAgent($param)
	{
                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $param);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($param);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($param);
                }


                $child = implode(',', $_SESSION['agentchild']);
                //echo $child;
                //exit;

                unset($_SESSION['agentchild']);

		$crud = new CRUD();

		$sql = "SELECT * FROM member WHERE Agent IN (".$child.") AND Enabled = '1' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Reseller' => $row['Reseller'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function getMemberCount(){

		$sql = "SELECT COUNT(ID) FROM member";

		$result = $this->dbconnect->query($sql);

		$result = $result->fetchColumn();

		return $result;

	}

	public function getActivationCode($param){

		$result = array();

		$result['code'] = rand(111111, 999999);

		$sql = "UPDATE member SET ActivationCode='".$result['code']."' WHERE ID = '".$param."'";

    	$count = $this->dbconnect->exec($sql);

            // Set Status
        $result['ok'] = ($count<=1) ? 1 : "";

		return $result;
	}

	public function checkActivationCode($param){

		$sql = "SELECT ActivationCode FROM member WHERE ID = '".$param."'";


		foreach ($this->dbconnect->query($sql) as $row)
		{
		  $result = $row['ActivationCode'];

		}


		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM member ".$_SESSION['member_'.$param]['query_condition']." ORDER BY Name ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Members";
		$result['header'] = $this->config['SITE_NAME']." | Members (" . date('Y-m-d H:i:s') . ")\n\nID, Agent, Gender, Name, Company, Bank, Bank Account No, DOB, NRIC, Passport, Nationality, Username, Password, Phone No, Fax No, Mobile No, Email, Prompt, Date Registered, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                        $agent = AgentModel::getAgent($row['Agent']);

                        if($row['Enabled']=='1')
                        {
                           $row['Enabled'] = 'Enabled';
                        }
                        else
                        {
                           $row['Enabled'] = 'Disabled';
                        }

			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$agent['Name']."\",";
			$result['content'] .= "\"".CRUD::getGender($row['GenderID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Company']."\",";
			$result['content'] .= "\"".$row['Bank']."\",";
			$result['content'] .= "\"".$row['BankAccountNo']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DOB'])."\",";
			$result['content'] .= "\"".$row['NRIC']."\",";
			$result['content'] .= "\"".$row['Passport']."\",";
			$result['content'] .= "\"".CountryModel::getCountry($row['Nationality'])."\",";
			$result['content'] .= "\"".$row['Username']."\",";
			$result['content'] .= "\"".$row['Password']."\",";
			$result['content'] .= "\"".$row['PhoneNo']."\",";
			$result['content'] .= "\"".$row['FaxNo']."\",";
			$result['content'] .= "\"".$row['MobileNo']."\",";
			$result['content'] .= "\"".$row['Email']."\",";
			$result['content'] .= "\"".$row['Prompt']."\",";
                        $result['content'] .= "\"".$row['DateRegistered']."\",";
			$result['content'] .= "\"".$row['Enabled']."\"\n";

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function getHash($param)
    {
        $sql = "SELECT Password FROM member WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Password' => $row['Password']);

            $i += 1;
        }

        return $result[0]['Password'];
    }

    public function sendSMS($activation_code, $recipient_mobile_no)
    {
        $restapi = new RestAPI();
        // JSON Post
        $data_string = array(
              "AppID" => '8bcee81cccecf76c07653065f60b358558a6f25e25fe9cdcb57bd7675fef6ec2',
              "AppSecret" => '$2a$09$5UfXEEFLDj0txWd7aGKbMOODvr7S5ePKrTocoLj02adjB7mGDom/a',
              "Text" => 'Your activation number is: '.$activation_code,
              #"DataCoding" => '8',
              #"Type" => 'longSMS',
              "Recipients" => array($recipient_mobile_no)
        );

        $data_string = json_encode($data_string);

        $param = $restapi->makeRequest("http://smsi.valse.com.my/api/message/index", $data_string, "POST", "json");
    }



    /*public function verifyCookie($cookie_data)
    {
        $cookie_data = json_decode($cookie_data['Value'],true);

        $sql = "SELECT * FROM member WHERE Username = '".$cookie_data['Username']."' AND CookieHash = '".$cookie_data['Hash']."' AND Enabled = 1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Email' => $row['Email'],
            'Name' => $row['Name']);

            $i += 1;
        }

        $result['count'] = $i;

        $this->output = array(
        'verify' => $result);

        return $this->output;
    }*/

}
?>