<?php
// Require required models
Core::requireModel('state');
Core::requireModel('country');

class DealerModel extends BaseModel
{
	private $output = array();
    private $module = array();
	//private $module_default_merchant_url = "/dealer/dealer/index";

	public function __construct()
	{
		parent::__construct();

        $this->module['dealer'] = array(
        'name' => "Dealer",
        'dir' => "modules/dealer/",
        'default_url' => "/main/dealer/index",
        'dealer_url' => "/dealer/dealer/index",
        'admin_url' => "/admin/dealer/index");
		
		$this->module['merchant'] = array(
        'name' => "Merchant",
        'dir' => "modules/merchant/",
        'default_url' => "/main/merchant/index",
        'merchant_url' => "/merchant/merchant/index",
        'admin_url' => "/admin/merchant/index");
		
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM dealer WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/dealer/index';
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

		$sql = "SELECT * FROM dealer WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dealers", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM dealer WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function DealerDashboard($param)
    {
    	unset($_SESSION['merchant']);
		unset($_SESSION['cart']);
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "Dashboard", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Dashboard", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/dealer/dashboard.inc.php'),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['dealer']['dealer_login']);

        return $this->output;
    }

    public function DealerProfile($param)
    {
        $sql = "SELECT * FROM dealer WHERE ID = '".$_SESSION['dealer']['ID']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'GenderID' => $row['GenderID'],
            'Name' => $row['Name'],

            'Company' => $row['Company'],
            'DOB' => Helper::dateSQLToDisplay($row['DOB']),
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


        if ($_SESSION['dealer']['dealer_profile_info']!="")
        {
            $form_input = $_SESSION['dealer']['dealer_profile_info'];

            // Unset temporary dealer info input
            unset($_SESSION['dealer']['dealer_profile_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "My Profile", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "My Profile", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/dealer/profile.inc.php', 'dealer_profile' => $_SESSION['dealer']['dealer_profile']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content' => $result,
        'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['dealer']['dealer_profile']);

        return $this->output;
    }

    public function DealerProfileProcess($param)
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM dealer WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$_SESSION['dealer']['ID']."'";

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
            $sql = "SELECT * FROM dealer WHERE Passport = '".$_POST['Passport']."' AND ID != '".$_SESSION['dealer']['ID']."'";

            $result = array();
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

            $_SESSION['dealer']['dealer_profile_info'] = Helper::unescape($_POST);
        }
        else
        {
            $sql = "UPDATE dealer SET GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Company='".$_POST['Company']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', Nationality='".$_POST['Nationality']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."' WHERE ID='".$_SESSION['dealer']['ID']."'";

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

    public function DealerPassword($param)
    {
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "Change Password", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Change Password", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/dealer/password.inc.php', 'dealer_password' => $_SESSION['dealer']['dealer_password']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['dealer']['dealer_password']);

        return $this->output;
    }

    public function DealerPasswordProcess($param)
    {
        // Update new password if current password is entered correctly
        $bcrypt = new Bcrypt(9);
        $verify = $bcrypt->verify($_POST['Password'], $this->getHash($_SESSION['dealer']['ID']));

        if ($verify==1)
        {
            $hash = $bcrypt->hash($_POST['PasswordNew']);

            // Save new password and disable Prompt
            $sql = "UPDATE dealer SET Password='".$hash."', Prompt = 0 WHERE ID='".$_SESSION['dealer']['ID']."'";
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

    public function DealerIndex($param)
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Dealer Home", 'template' => 'common.tpl.php'),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function DealerRegister($param)
    {
        if ($_SESSION['admin']['dealer_register_info']!="")
        {
            $form_input = $_SESSION['admin']['dealer_register_info'];

            // Unset temporary dealer info input
            unset($_SESSION['admin']['dealer_register_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "Register", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Register", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/dealer/register.inc.php', 'dealer_register' => $_SESSION['dealer']['dealer_register']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['admin']['dealer_register']);

        return $this->output;
    }

    public function DealerRegisterProcess($param)
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM dealer WHERE NRIC = '".$_POST['NRIC']."'";

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
            $sql = "SELECT * FROM dealer WHERE Passport = '".$_POST['Passport']."'";

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
        $sql = "SELECT * FROM dealer WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;

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

            $_SESSION['admin']['dealer_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new dealer
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            $key = "(GenderID, Name, NRIC, Passport, Company, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
            $value = "('".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Company']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '0', '1')";

            $sql = "INSERT INTO dealer ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Insert new dealer's first address
            $key_address = "(DealerID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
            $value_address = "('".$newID."', 'My First Address', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '1')";

            $sql_address = "INSERT INTO dealer_address ".$key_address." VALUES ". $value_address;

            $count_address = $this->dbconnect->exec($sql_address);

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Registering...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function DealerLogin($param)
    {
        if ($_SESSION['dealer']['dealer_login_info']!="")
        {
            $form_input = $_SESSION['dealer']['dealer_login_info'];

            // Unset temporary dealer info input
            unset($_SESSION['dealer']['dealer_login_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "Dealer Login", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Dealer Login", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/dealer/login.inc.php', 'dealer_login' => $_SESSION['dealer']['dealer_login'], 'dealer_logout' => $_SESSION['dealer']['dealer_logout'], 'dealer_password' => $_SESSION['dealer']['dealer_password'], 'dealer_register' => $_SESSION['dealer']['dealer_register'], 'dealer_forgotpassword' => $_SESSION['dealer']['dealer_forgotpassword']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['dealer']['dealer_login']);
        unset($_SESSION['dealer']['dealer_logout']);
        unset($_SESSION['dealer']['dealer_password']);
        unset($_SESSION['dealer']['dealer_register']);
        unset($_SESSION['dealer']['dealer_forgotpassword']);

        return $this->output;
    }

    public function DealerLoginProcess($param)
    {
        $sql = "SELECT * FROM dealer WHERE Enabled = 1 AND Username = '".$_POST['Username']."'";

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
            'Prompt' => $row['Prompt']);

            $i += 1;
        }

        if ($i==1)
        {
            $bcrypt = new Bcrypt(9);
            $verify = $bcrypt->verify($_POST['Password'], $result[0]['Password']);

            // Set Status
            $ok = ($verify==1) ? 1 : "";

            if ($verify!=1)
            {
                // Username and password do not match
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['dealer']['dealer_login_info'] = Helper::unescape($_POST);
            }
        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            $_SESSION['dealer']['dealer_login_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function DealerLogout($param)
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey),
        'page' => array('title' => "Logging Out..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function DealerForgotPassword($param)
    {
        if ($_SESSION['dealer']['dealer_forgotpassword_info']!="")
        {
            $form_input = $_SESSION['dealer']['dealer_forgotpassword_info'];

            // Unset temporary dealer info input
            unset($_SESSION['dealer']['dealer_forgotpassword_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => "Forgot Your Password?", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Forgot Your Password?", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/dealer/forgotpassword.inc.php', 'dealer_forgotpassword' => $_SESSION['dealer']['dealer_forgotpassword']),
        'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content_param' => array('enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['dealer']['dealer_forgotpassword']);

        return $this->output;
    }

    public function DealerForgotPasswordProcess($param)
    {
        $sql = "SELECT * FROM dealer WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' LIMIT 0,1";

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

            $sql = "UPDATE dealer SET Password='".$hash."', Prompt='1' WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND ID='".$result[0]['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Username and email do not match
            $error['count'] += 1;
            $error['NoMatch'] = 1;

            $_SESSION['dealer']['dealer_forgotpassword_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Resetting Password..."),
        'content' => $result,
        'content_param' => array('count' => $i, 'new_password' => $new_password),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function DealerAccess($param)
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Checking Access..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    /*public function DealerAutologin()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Auto Logging In..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }*/

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['dealer_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['dealer_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['dealer_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['dealer_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['dealer_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['dealer_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['dealer_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM dealer ".$_SESSION['dealer_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/dealer/index';
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

		$sql = "SELECT * FROM dealer ".$_SESSION['dealer_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
            'NationalityID' => $row['Nationality'],
			'Nationality' => CountryModel::getCountry($row['Nationality'], "Name"),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dealers", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/admin/index.inc.php', 'dealer_delete' => $_SESSION['admin']['dealer_delete']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/admin/side_nav.dealer_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealer_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
	    if ($_SESSION['admin']['dealer_add_info']!="")
        {
            $form_input = $_SESSION['admin']['dealer_add_info'];

            // Unset temporary dealer info input
            unset($_SESSION['admin']['dealer_add_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['admin_url']),
            array("Title" => "Dealer Login", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Dealer", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/admin/add.inc.php', 'dealer_add' => $_SESSION['admin']['dealer_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/admin/side_nav.dealer_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealer_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
	    if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM dealer WHERE NRIC = '".$_POST['NRIC']."'";

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
            $sql = "SELECT * FROM dealer WHERE Passport = '".$_POST['Passport']."'";

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
        $sql = "SELECT * FROM dealer WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;

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

            $_SESSION['admin']['dealer_add_info'] = Helper::unescape($_POST);
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

    		$key = "(GenderID, Name, Company, DOB, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
    		$value = "('".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['Company']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO dealer ".$key." VALUES ". $value;

    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Dealer...", 'template' => 'admin.common.tpl.php'),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM dealer WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => $row['GenderID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
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

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['admin_url']),
            array("Title" => "Edit Dealer", "Link" => "")
        );

        if ($_SESSION['admin']['dealer_edit_info']!="")
        {
            $form_input = $_SESSION['admin']['dealer_edit_info'];

            // Unset temporary dealer info input
            unset($_SESSION['admin']['dealer_edit_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Dealer", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['dealer']['dir'].'inc/admin/edit.inc.php', 'dealer_add' => $_SESSION['admin']['dealer_add'], 'dealer_edit' => $_SESSION['admin']['dealer_edit']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/admin/side_nav.dealer.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['dealer_add']);
		unset($_SESSION['admin']['dealer_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM dealer WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

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
            $sql = "SELECT * FROM dealer WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

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
        $sql = "SELECT * FROM dealer WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;

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

            $_SESSION['admin']['dealer_edit_info'] = Helper::unescape($_POST);
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

    		$sql = "UPDATE dealer SET GenderID='".$_POST['GenderID']."', Name='".$_POST['Name']."', Company='".$_POST['Company']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Dealer...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM dealer WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Dealer...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function AdminExport($param)
    {
        $sql = "SELECT * FROM dealer ".$_SESSION['dealer_'.$param]['query_condition']." ORDER BY Name ASC";

        $result = array();

        $result['filename'] = $this->config['SITE_NAME']."_Dealers";
        $result['header'] = $this->config['SITE_NAME']." | Dealers (" . date('Y-m-d H:i:s') . ")\n\nID, Gender, Name, Company, DOB, NRIC, Passport, Nationality, Username, Password, Phone No, Fax No, Mobile No, Email, Prompt, Enabled";
        $result['content'] = '';

        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result['content'] .= "\"".$row['ID']."\",";
            $result['content'] .= "\"".CRUD::getGender($row['GenderID'])."\",";
            $result['content'] .= "\"".$row['Name']."\",";
            $result['content'] .= "\"".$row['Company']."\",";
            $result['content'] .= "\"".Helper::dateSQLToDisplay($row['DOB'])."\",";
            $result['content'] .= "\"".$row['NRIC']."\",";
            $result['content'] .= "\"".$row['Passport']."\",";
            $result['content'] .= "\"".CountryModel::getCountry($row['Nationality'], "Name")."\",";
            $result['content'] .= "\"".$row['Username']."\",";
            $result['content'] .= "\"".$row['Password']."\",";
            $result['content'] .= "\"".$row['PhoneNo']."\",";
            $result['content'] .= "\"".$row['FaxNo']."\",";
            $result['content'] .= "\"".$row['MobileNo']."\",";
            $result['content'] .= "\"".$row['Email']."\",";
            $result['content'] .= "\"".$row['Prompt']."\",";
            $result['content'] .= "\"".CRUD::isActive($row['Enabled'])."\"\n";

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

    public function APIProfile($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                $sql = "SELECT * FROM dealer WHERE Enabled = 1 AND ID = '".$param."'";

                $result = array();
                $i = 0;
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'GenderID' => CRUD::getGender($row['GenderID']),
                    'Name' => $row['Name'],
                    'Company' => $row['Company'],
                    'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
                    'NRIC' => $row['NRIC'],
                    'Passport' => $row['Passport'],
                    'Nationality' => $row['Nationality'],
                    'Username' => $row['Username'],
                    'PhoneNo' => $row['PhoneNo'],
                    'FaxNo' => $row['FaxNo'],
                    'MobileNo' => $row['MobileNo'],
                    'Email' => $row['Email'],
                    'Prompt' => $row['Prompt']);

                    $i += 1;
                }

                $output['Count'] = $i;
                $output['Content'] = $result;

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
                if ($request_data['Nationality']==151)
                {
                    $request_data['Passport'] = '';

                    // Check is NRIC exists
                    $sql = "SELECT * FROM dealer WHERE NRIC = '".$request_data['NRIC']."' AND ID != '".$request_data['dealerID']."'";

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
                    $request_data['NRIC'] = '';

                    // Check is Passport exists
                    $sql = "SELECT * FROM dealer WHERE Passport = '".$request_data['Passport']."' AND ID != '".$request_data['dealerID']."'";

                    $result = array();
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
                    $sql = "UPDATE dealer SET GenderID='".$request_data['GenderID']."', Name='".$request_data['Name']."', NRIC='".$request_data['NRIC']."', Passport='".$request_data['Passport']."', Company='".$request_data['Company']."', DOB='".Helper::dateDisplaySQL($request_data['DOB'])."', Nationality='".$request_data['Nationality']."', PhoneNo='".$request_data['PhoneNo']."', FaxNo='".$request_data['FaxNo']."', MobileNo='".$request_data['MobileNo']."', Email='".$request_data['Email']."' WHERE ID='".$request_data['dealerID']."'";

                    $count = $this->dbconnect->exec($sql);

                    // Set Status
                    $ok = ($count<=1) ? 1 : "";
                }

                // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => 'Profile Updated Successfully'));
                    $restapi->setResponse('200', 'OK', $result);
                }
                else if ($error['count']>0)
                {
                    if ($error['NRIC']=="1")
                    {
                        $error_message = "NRIC Already Exists";
                    }
                    else if ($error['Passport']=="1")
                    {
                        $error_message = "Passport Already Exists";
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

    public function APIPasswordProcess($param)
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
                $verify = $bcrypt->verify($request_data['Password'], $this->getHash($request_data['dealerID']));

                if ($verify==1)
                {
                    $hash = $bcrypt->hash($request_data['PasswordNew']);

                    // Save new password and disable Prompt
                    $sql = "UPDATE dealer SET Password='".$hash."', Prompt = 0 WHERE ID='".$request_data['dealerID']."'";
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

    public function APIRegisterProcess($param)
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
                if ($request_data['Nationality']==151)
                {
                    $request_data['Passport'] = '';

                    // Check is NRIC exists
                    $sql = "SELECT * FROM dealer WHERE NRIC = '".$request_data['NRIC']."'";

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
                    $request_data['NRIC'] = '';

                    // Check is Passport exists
                    $sql = "SELECT * FROM dealer WHERE Passport = '".$request_data['Passport']."'";

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
                $sql = "SELECT * FROM dealer WHERE Username = '".$request_data['Username']."'";

                $result = array();
                $i_username = 0;
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $result[$i_username] = array(
                    'Username' => $row['Username']);

                    $i_username += 1;
                }

                $error['count'] = $i_username + $i_nric + $i_passport;

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
                }
                else
                {
                    // Insert new dealer
                    $bcrypt = new Bcrypt(9);
                    $hash = $bcrypt->hash($request_data['Password']);

                    $key = "(GenderID, Name, NRIC, Passport, Company, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
                    $value = "('".$request_data['GenderID']."', '".$request_data['Name']."', '".$request_data['NRIC']."', '".$request_data['Passport']."', '".$request_data['Company']."', '".Helper::dateDisplaySQL($request_data['DOB'])."', '".$request_data['Nationality']."', '".$request_data['Username']."', '".$hash."', '".$request_data['PhoneNo']."', '".$request_data['FaxNo']."', '".$request_data['MobileNo']."', '".$request_data['Email']."', '0', '1')";

                    $sql = "INSERT INTO dealer ".$key." VALUES ". $value;

                    $count = $this->dbconnect->exec($sql);
                    $newID = $this->dbconnect->lastInsertId();

                    // Insert new dealer's first address
                    $key_address = "(DealerID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
                    $value_address = "('".$newID."', 'My First Address', '".$request_data['Street']."', '".$request_data['Street2']."', '".$request_data['City']."', '".$request_data['State']."', '".$request_data['Postcode']."', '".$request_data['Country']."', '".$request_data['PhoneNo']."', '".$request_data['FaxNo']."', '".$request_data['Email']."', '1')";

                    $sql_address = "INSERT INTO dealer_address ".$key_address." VALUES ". $value_address;

                    $count_address = $this->dbconnect->exec($sql_address);

                    // Set Status
                    $ok = ($count==1) ? 1 : "";
                }

                // Set output
                if ($ok=="1")
                {
                    $result = json_encode(array('Status' => 'Registration Successful'));
                    $restapi->setResponse('200', 'OK', $result, FALSE);

                    $this->output = array(
                    'config' => $this->config,
                    'page' => array('title' => "Registering..."),
                    'content' => Helper::unescape($request_data),
                    'content_param' => array('count' => $count, 'newID' => $newID),
                    'status' => array('ok' => $ok, 'error' => $error),
                    'meta' => array('active' => "on"));

                    return $this->output;
                }
                else if ($error['count']>0)
                {
                    if ($error['Username']=="1")
                    {
                        $error_message .= "Username Already Exists";
                    }
                    else if ($error['NRIC']=="1")
                    {
                        $error_message = "NRIC Already Exists";
                    }
                    else if ($error['Passport']=="1")
                    {
                        $error_message = "Passport Already Exists";
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

    public function APILoginProcess($param)
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
                $sql = "SELECT * FROM dealer WHERE Enabled = 1 AND Username = '".$request_data['Username']."'";

                $result = array();
                $i = 0;
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'Username' => $row['Username'],
                    'Email' => $row['Email'],
                    'Name' => $row['Name'],
                    'Password' => $row['Password'],
                    'CookieHash' => $row['CookieHash'],
                    'Prompt' => $row['Prompt']);

                    $i += 1;
                }

                $output['Count'] = $i;
                $output['Content'] = $result;

                // Remove password from output
                unset($output['Content'][0]['Password']);

                if ($i==1)
                {
                    $bcrypt = new Bcrypt(9);
                    $verify = $bcrypt->verify($request_data['Password'], $result[0]['Password']);

                    // Set Status
                    $ok = ($verify==1) ? 1 : "";

                    if ($verify!=1)
                    {
                        // Username and password do not match
                        $error['count'] += 1;
                        $error['Login'] = 1;
                    }
                }
                else
                {
                    // Invalid username
                    $error['count'] += 1;
                    $error['Login'] = 1;
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
                $sql = "SELECT * FROM dealer WHERE Email = '".$request_data['Email']."' AND Username = '".$request_data['Username']."' LIMIT 0,1";

                $result = array();
                $i = 0;
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    $result[$i] = array(
                    'ID' => $row['ID'],
                    'Expiry' => $row['Expiry'],
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

                    $sql = "UPDATE dealer SET Password='".$hash."', Prompt='1' WHERE Email = '".$request_data['Email']."' AND Username = '".$request_data['Username']."' AND ID='".$result[0]['ID']."'";

                    $count = $this->dbconnect->exec($sql);

                    // Set Status
                    $ok = ($count<=1) ? 1 : "";
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

                    $this->output = array(
                    'config' => $this->config,
                    'page' => array('title' => "Resetting Password..."),
                    'content' => $output['Content'],
                    'content_param' => array('count' => $i, 'new_password' => $new_password),
                    'status' => array('ok' => $ok, 'error' => $error),
                    'secure' => TRUE,
                    'meta' => array('active' => "off"));

                    return $this->output;
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

	public function getDealer($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM dealer WHERE ID = '".$param."'";
		//echo $sql;
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality'], "Name"),
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

		// Determine if get all fields or one specific field
        if ($column!="")
        {
            $result = $result[0][$column];
        }
        else
        {
            $result = $result[0];
        }

		return $result;
	}

	public function getDealerName($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM dealer WHERE ID = '".$param."'";
		//echo $sql;
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'Username' => $row['Username']);

			$i += 1;
		}

		return $result;
	}

	public function getDealerList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM dealer ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality'], "Name"),
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

		$result['count'] = $i;

		return $result;
	}

    public function getHash($param)
    {
        $sql = "SELECT Password FROM dealer WHERE ID = '".$param."'";

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

    /*public function verifyCookie($cookie_data)
    {
        $cookie_data = json_decode($cookie_data['Value'],true);

        $sql = "SELECT * FROM dealer WHERE Username = '".$cookie_data['Username']."' AND CookieHash = '".$cookie_data['Hash']."' AND Enabled = 1";

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