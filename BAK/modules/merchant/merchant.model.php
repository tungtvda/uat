<?php
// Require required models
Core::requireModel('state');
Core::requireModel('country');
Core::requireModel('dealer');
Core::requireModel('merchanttype');
Core::requireModel('merchantdeal');

class MerchantModel extends BaseModel
{
	private $output = array();
    private $module = array();
    private $module_default_merchant_url = "/merchant/merchant/index";

	public function __construct()
	{
		parent::__construct();

        $this->module['merchant'] = array(
        'name' => "Merchant",
        'dir' => "modules/merchant/",
        'default_url' => "/main/merchant/index",
        'merchant_url' => "/merchant/merchant/index",
        'admin_url' => "/admin/merchant/index",
		'dealer_url' => "/dealer/merchant/index");
		
		$this->module['dealer'] = array(
        'name' => "Dealer",
        'dir' => "modules/dealer/",
        'default_url' => "/main/dealer/index",
        'dealer_url' => "/dealer/dealer/index",
        'admin_url' => "/admin/dealer/index");
		
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM merchant WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/merchant/index';
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

		$sql = "SELECT * FROM merchant WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'TypeID' => $row['TypeID'],
			'DealerID' => $row['DealerID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Expiry' => Helper::dateSQLToLongDisplay($row['Expiry']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
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
            array("Title" => $this->module['merchant']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Merchants", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM merchant WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Expiry' => Helper::dateSQLToLongDisplay($row['Expiry']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
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
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['default_url']),
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

	public function QRView($param)
	{
		$merchantID = $_GET['MerchantID'];
		$Size = $_GET['Size'];
		require_once('lib/qrcode/qrlib.php');
		
		$sql = "SELECT * FROM merchant WHERE ID = '".$merchantID."' AND Enabled = 1";
		
		$tempDir = '/home/aseanfnb/public_html/upload/qrcode/'; 

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Expiry' => Helper::dateSQLToLongDisplay($row['Expiry']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
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
		
		$result = $result[0]['PhoneNo'];
		
		// generating 
	    $result = QRcode::png($result, $tempDir.'qr_1.png', QR_ECLEVEL_L, 8); 
		/*Debug::displayArray($result);
		exit;*/
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
		'content' => $result,
		
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function MerchantDashboard()
    {
    	
		unset($_SESSION['dealer']);
		unset($_SESSION['DealerMerchant']);
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => "Dashboard", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Dashboard", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/merchant/dashboard.inc.php'),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['merchant']['merchant_login']);

        return $this->output;
    }

    public function MerchantProfile()
    {
        $sql = "SELECT * FROM merchant WHERE ID = '".$_SESSION['merchant']['ID']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
            'GenderID' => $row['GenderID'],
			'Expiry' => Helper::dateSQLToDisplay($row['Expiry']),
            'Name' => $row['Name'],
            'Company' => $row['Company'],
            'AccountNo' => $row['AccountNo'],
            'Bank' => $row['Bank'],
			'CompanyRegNo' => $row['CompanyRegNo'],
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


        if ($_SESSION['merchant']['merchant_profile_info']!="")
        {
            $form_input = $_SESSION['merchant']['merchant_profile_info'];

            // Unset temporary merchant info input
            unset($_SESSION['merchant']['merchant_profile_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => "My Profile", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "My Profile", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/merchant/profile.inc.php', 'merchant_profile' => $_SESSION['merchant']['merchant_profile']),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content' => $result,
        'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'dealer_list' => DealerModel::getDealerList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['merchant']['merchant_profile']);

        return $this->output;
    }

    public function MerchantProfileProcess()
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM merchant WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$_SESSION['merchant']['ID']."'";

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
            $sql = "SELECT * FROM merchant WHERE Passport = '".$_POST['Passport']."' AND ID != '".$_SESSION['merchant']['ID']."'";

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

            $_SESSION['merchant']['merchant_profile_info'] = Helper::unescape($_POST);
        }
        else
        {
            $sql = "UPDATE merchant SET MerchantID='".$_POST['MerchantID']."', GenderID='".$_POST['GenderID']."', Expiry='".Helper::dateDisplaySQL($_POST['Expiry'])."', Name='".$_POST['Name']."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Company='".$_POST['Company']."', Bank='".$_POST['Bank']."', AccountNo='".$_POST['AccountNo']."', CompanyRegNo='".$_POST['CompanyRegNo']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', Nationality='".$_POST['Nationality']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."' WHERE ID='".$_SESSION['merchant']['ID']."'";
			/*echo $sql;
			exit;*/
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

    public function MerchantPassword($param)
    {
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => "Change Password", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Change Password", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/merchant/password.inc.php', 'merchant_password' => $_SESSION['merchant']['merchant_password']),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['merchant']['merchant_password']);

        return $this->output;
    }

    public function MerchantPasswordProcess($param)
    {
        // Update new password if current password is entered correctly
        $bcrypt = new Bcrypt(9);
        $verify = $bcrypt->verify($_POST['Password'], $this->getHash($_SESSION['merchant']['ID']));

        if ($verify==1)
        {
            $hash = $bcrypt->hash($_POST['PasswordNew']);

            // Save new password and disable Prompt
            $sql = "UPDATE merchant SET Password='".$hash."', Prompt = 0 WHERE ID='".$_SESSION['merchant']['ID']."'";
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

    public function MerchantIndex($param)
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Merchant Home", 'template' => 'common.tpl.php'),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function MerchantRegister()
    {
    	$Dealer = $_GET['dealer'];
        if ($_SESSION['merchant']['merchant_register_info']!="")
        {
            $form_input = $_SESSION['merchant']['merchant_register_info'];

            // Unset temporary merchant info input
            unset($_SESSION['merchant']['merchant_register_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => "Change Password", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Register", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/merchant/register.inc.php', 'merchant_register' => $_SESSION['merchant']['merchant_register']),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList(), 'dealer_list' => DealerModel::getDealerList()),
        'form_param' => $form_input,
        'dealer' => $Dealer,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['merchant']['merchant_register']);

        return $this->output;
    }

    public function MerchantRegisterProcess($param)
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM merchant WHERE NRIC = '".$_POST['NRIC']."'";

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
            $sql = "SELECT * FROM merchant WHERE Passport = '".$_POST['Passport']."'";

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
        $sql = "SELECT * FROM merchant WHERE Username = '".$_POST['Username']."'";

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

            $_SESSION['merchant']['merchant_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new merchant
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            $key = "(DealerID, GenderID, Name, NRIC, Passport, Company, CompanyRegNo, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
            $value = "('".$_POST['DealerID']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Company']."', '".$_POST['CompanyRegNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '0', '1')";

            $sql = "INSERT INTO merchant ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Insert new merchant's first address
            $key_address = "(MerchantID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
            $value_address = "('".$newID."', 'My First Address', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '1')";

            $sql_address = "INSERT INTO merchant_address ".$key_address." VALUES ". $value_address;

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

    public function MerchantLogin()
    {
        if ($_SESSION['merchant']['merchant_login_info']!="")
        {
            $form_input = $_SESSION['merchant']['merchant_login_info'];

            // Unset temporary merchant info input
            unset($_SESSION['merchant']['merchant_login_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => "Merchant Login", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Merchant Login", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/merchant/login.inc.php', 'merchant_login' => $_SESSION['merchant']['merchant_login'], 'merchant_logout' => $_SESSION['merchant']['merchant_logout'], 'merchant_password' => $_SESSION['merchant']['merchant_password'], 'merchant_register' => $_SESSION['merchant']['merchant_register'], 'merchant_forgotpassword' => $_SESSION['merchant']['merchant_forgotpassword']),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['merchant']['merchant_login']);
        unset($_SESSION['merchant']['merchant_logout']);
        unset($_SESSION['merchant']['merchant_password']);
        unset($_SESSION['merchant']['merchant_register']);
        unset($_SESSION['merchant']['merchant_forgotpassword']);

        return $this->output;
    }

    public function MerchantLoginProcess($param)
    {
        $sql = "SELECT * FROM merchant WHERE Enabled = 1 AND Username = '".$_POST['Username']."'";
		
        $result = array();
        $i = 0;
		 $column = "Username";
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'DealerID' => DealerModel::getDealer($row['DealerID'],$column),
            'TypeID' => $row['TypeID'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Expiry' => $row['Expiry'],
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

                $_SESSION['merchant']['merchant_login_info'] = Helper::unescape($_POST);
            }
        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            $_SESSION['merchant']['merchant_login_info'] = Helper::unescape($_POST);
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

    public function MerchantLogout($param)
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey),
        'page' => array('title' => "Logging Out..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function MerchantForgotPassword($param)
    {
        if ($_SESSION['merchant']['merchant_forgotpassword_info']!="")
        {
            $form_input = $_SESSION['merchant']['merchant_forgotpassword_info'];

            // Unset temporary merchant info input
            unset($_SESSION['merchant']['merchant_forgotpassword_info']);
        }

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['merchant_url']),
            array("Title" => "Forgot Your Password?", "Link" => "")
        );

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Forgot Your Password?", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/merchant/forgotpassword.inc.php', 'merchant_forgotpassword' => $_SESSION['merchant']['merchant_forgotpassword']),
        'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/merchant/side_nav.merchant_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
        'content_param' => array('enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['merchant']['merchant_forgotpassword']);

        return $this->output;
    }

    public function MerchantForgotPasswordProcess($param)
    {
        $sql = "SELECT * FROM merchant WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' LIMIT 0,1";

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

            $sql = "UPDATE merchant SET Password='".$hash."', Prompt='1' WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND ID='".$result[0]['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Username and email do not match
            $error['count'] += 1;
            $error['NoMatch'] = 1;

            $_SESSION['merchant']['merchant_forgotpassword_info'] = Helper::unescape($_POST);
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

    public function MerchantAccess($param)
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Checking Access..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }
	
	 public function MerchantStandardProfileUpgradeProcess($param) {
	
	
	
    $this->output = array(
      'config' => $this->config,
      'page' => array('title' => "Processing Profile Upgrade Request...", 'template' => 'common.tpl.php'),
      'content_param' => array('count' => $status),
      'content' => $param,
      'meta' => array('active' => "on"));



    return $this->output;
  }
	 
	 public function MerchantPremierProfileUpgradeProcess($param) {
	
	
    $this->output = array(
      'config' => $this->config,
      'page' => array('title' => "Processing Profile Upgrade Request...", 'template' => 'common.tpl.php'),
      'content_param' => array('count' => $status),
      'content' => $param,
      'meta' => array('active' => "on"));



    return $this->output;
  }
	 
public function DealerStandardProfileUpgradeProcess($param) {
	
	$result = array();
	if($param != ''){
			
		$result = MerchantModel::getMerchant($param);
		$_SESSION['DealerMerchant'] = $result;
		
	}
	
	/*Debug::displayArray($_SESSION['dealer'][ID]);
	exit;*/
	
    $this->output = array(
      'config' => $this->config,
      'page' => array('title' => "Processing Profile Upgrade Request...", 'template' => 'common.tpl.php'),
      'content_param' => array('count' => $status),
      'content' => $param,
      'meta' => array('active' => "on"));



    return $this->output;
  }
	 
	 public function DealerPremierProfileUpgradeProcess($param) {
	$result = array();
	if($param != ''){
			
		$result = MerchantModel::getMerchant($param);
		$_SESSION['DealerMerchant'] = $result;
		
	}
	//Debug::displayArray($_SESSION['DealerMerchant']);
	//exit;
    $this->output = array(
      'config' => $this->config,
      'page' => array('title' => "Processing Profile Upgrade Request...", 'template' => 'common.tpl.php'),
      'content_param' => array('count' => $status),
      'content' => $param,
      'meta' => array('active' => "on"));



    return $this->output;
  }	 
	 
  public function DealerIndex($param)
	{
		unset($_SESSION['DealerMerchant']);
		//echo 'hi';
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['merchant_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=",1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Expiry",Helper::dateDisplaySQL($_POST['ExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("Expiry",Helper::dateDisplaySQL($_POST['ExpiryTo']),"<=");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"LIKE");
			$query_condition .= $crud->queryCondition("CompanyRegNo",$_POST['CompanyRegNo'],"LIKE");
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

			$_SESSION['merchant_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['ExpiryFrom'] = $_POST['ExpiryFrom'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['ExpiryTo'] = $_POST['ExpiryTo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['CompanyRegNo'] = $_POST['CompanyRegNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['merchant_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchant_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchant_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['merchant_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant WHERE DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['merchant_'.__FUNCTION__]['query_condition'];
		//echo $query_count;
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/dealer/merchant/index';
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

		$sql = "SELECT * FROM merchant WHERE DealerID = '".$_SESSION['dealer']['ID']."' ".$_SESSION['merchant_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
		//echo $sql;
		//exit;
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'TypeID' => $row['TypeID'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
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
			'Expiry' => $row['Expiry'],
			'ExpiryText' => Helper::dateSQLToDisplay($row['Expiry']),
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['merchant']['name'], "Link" => ""),
            //array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Merchants", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/dealer/index.inc.php', 'merchant_delete' => $_SESSION['dealer']['merchant_delete']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'merchanttype_list'=> MerchantTypeModel::getMerchantTypeList(), 'merchant_list' => MerchantModel::getDealerMerchantList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['merchant_delete']);

		return $this->output;
	}

	public function DealerAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['dealer_url']),
            array("Title" => "Add", "Link" => "")
        );

	    if ($_SESSION['dealer']['merchant_add_info']!="")
        {
            $form_input = $_SESSION['dealer']['merchant_add_info'];

            // Unset temporary merchant info input
            unset($_SESSION['dealer']['merchant_add_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Merchant", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/dealer/add.inc.php', 'merchant_add' => $_SESSION['dealer']['merchant_add']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(),'merchanttype_list'=>MerchantTypeModel::getMerchantTypeList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['merchant_add']);

		return $this->output;
	}

	public function DealerAddProcess($param)
	{
	    if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM merchant WHERE NRIC = '".$_POST['NRIC']."'";

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
            $sql = "SELECT * FROM merchant WHERE Passport = '".$_POST['Passport']."'";

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
        $sql = "SELECT * FROM merchant WHERE Username = '".$_POST['Username']."'";

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

            $_SESSION['dealer']['merchant_add_info'] = Helper::unescape($_POST);
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

    		$key = "(GenderID, DealerID, TypeID, Name, Expiry, Company, CompanyRegNo, DOB, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
    		$value = "('".$_POST['GenderID']."', '".$_SESSION['dealer']['ID']."', '".$_POST['TypeID']."', '".$_POST['Name']."', '".Helper::dateDisplaySQL($_POST['Expiry'])."', '".$_POST['Company']."', '".$_POST['CompanyRegNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO merchant ".$key." VALUES ". $value;

    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Merchant...", 'template' => 'common.tpl.php'),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerEdit($param)
	{
		$sql = "SELECT * FROM merchant WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => $row['GenderID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Expiry' => $row['Expiry'],
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
            array("Title" => $this->module['dealer']['name'], "Link" => $this->module['dealer']['dealer_url']),
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['dealer_url']),
            array("Title" => "Edit", "Link" => "")
        );

        if ($_SESSION['dealer']['merchant_edit_info']!="")
        {
            $form_input = $_SESSION['dealer']['merchant_edit_info'];

            // Unset temporary merchant info input
            unset($_SESSION['dealer']['merchant_edit_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Merchant", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/dealer/edit.inc.php', 'merchant_add' => $_SESSION['dealer']['merchant_add'], 'merchant_edit' => $_SESSION['dealer']['merchant_edit']),
		'block' => array('side_nav' => $this->module['dealer']['dir'].'inc/dealer/side_nav.dealer.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(),'merchanttype_list'=>MerchantTypeModel::getMerchantTypeList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['dealer']['merchant_add']);
		unset($_SESSION['dealer']['merchant_edit']);

		return $this->output;
	}

	public function DealerEditProcess($param)
	{
	    if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM merchant WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

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
            $sql = "SELECT * FROM merchant WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

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
        $sql = "SELECT * FROM merchant WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

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

            $_SESSION['dealer']['merchant_edit_info'] = Helper::unescape($_POST);
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

    		$sql = "UPDATE merchant SET GenderID='".$_POST['GenderID']."', TypeID='".$_POST['TypeID']."', Name='".$_POST['Name']."', Expiry='".Helper::dateDisplaySQL($_POST['Expiry'])."', Company='".$_POST['Company']."', CompanyRegNo='".$_POST['CompanyRegNo']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Merchant...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function DealerDelete($param)
	{
		$sql = "DELETE FROM merchant WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Merchant...", 'template' => 'common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}	
		 
  

    /*public function MerchantAutologin()
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
			$_SESSION['merchant_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("DealerID",$_POST['DealerID'],"=");
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("Expiry",Helper::dateDisplaySQL($_POST['ExpiryFrom']),">=");
			$query_condition .= $crud->queryCondition("Expiry",Helper::dateDisplaySQL($_POST['ExpiryTo']),"<=");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"LIKE");
			$query_condition .= $crud->queryCondition("CompanyRegNo",$_POST['CompanyRegNo'],"LIKE");
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

			$_SESSION['merchant_'.__FUNCTION__]['param']['DealerID'] = $_POST['DealerID'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['ExpiryFrom'] = $_POST['ExpiryFrom'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['ExpiryTo'] = $_POST['ExpiryTo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['CompanyRegNo'] = $_POST['CompanyRegNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['merchant_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['merchant_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['merchant_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['merchant_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['merchant_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM merchant ".$_SESSION['merchant_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/merchant/index';
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

		$sql = "SELECT * FROM merchant ".$_SESSION['merchant_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => DealerModel::getDealer($row['DealerID'], "Name"),
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Expiry' => Helper::dateSQLToDisplay($row['Expiry']),
			'TypeID' => $row['TypeID'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
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
            array("Title" => $this->module['merchant']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Merchants", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/admin/index.inc.php', 'merchant_delete' => $_SESSION['admin']['merchant_delete']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/admin/side_nav.merchant_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'dealer_list' => DealerModel::getDealerList(), /*'merchanttype_list'=>*/),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchant_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['admin_url']),
            array("Title" => "Create Merchant", "Link" => "")
        );

	    if ($_SESSION['admin']['merchant_add_info']!="")
        {
            $form_input = $_SESSION['admin']['merchant_add_info'];

            // Unset temporary merchant info input
            unset($_SESSION['admin']['merchant_add_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Merchant", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/admin/add.inc.php', 'merchant_add' => $_SESSION['admin']['merchant_add']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/admin/side_nav.merchant_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(),'merchanttype_list'=> MerchantTypeModel::getMerchantTypeList(), 'dealer_list' => DealerModel::getDealerList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchant_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
	    if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM merchant WHERE NRIC = '".$_POST['NRIC']."'";

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
            $sql = "SELECT * FROM merchant WHERE Passport = '".$_POST['Passport']."'";

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
        $sql = "SELECT * FROM merchant WHERE Username = '".$_POST['Username']."'";

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

            $_SESSION['admin']['merchant_add_info'] = Helper::unescape($_POST);
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
			
			

    		$key = "(DealerID, GenderID, TypeID, Name, Company, Expiry, CompanyRegNo, DOB, NRIC, Passport, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
    		$value = "('".$_POST['DealerID']."', '".$_POST['GenderID']."', '".$_POST['TypeID']."', '".$_POST['Name']."', '".$_POST['Company']."', '".Helper::dateDisplaySQL($_POST['Expiry'])."', '".$_POST['CompanyRegNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO merchant ".$key." VALUES ". $value;

    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Merchant...", 'template' => 'admin.common.tpl.php'),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM merchant WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
			'GenderID' => $row['GenderID'],
			'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Expiry' => Helper::dateSQLToDisplay($row['Expiry']),
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
            array("Title" => $this->module['merchant']['name'], "Link" => $this->module['merchant']['admin_url']),
            array("Title" => "Edit Merchant", "Link" => "")
        );

        if ($_SESSION['admin']['merchant_edit_info']!="")
        {
            $form_input = $_SESSION['admin']['merchant_edit_info'];

            // Unset temporary merchant info input
            unset($_SESSION['admin']['merchant_edit_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Merchant", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['merchant']['dir'].'inc/admin/edit.inc.php', 'merchant_add' => $_SESSION['admin']['merchant_add'], 'merchant_edit' => $_SESSION['admin']['merchant_edit']),
		'block' => array('side_nav' => $this->module['merchant']['dir'].'inc/admin/side_nav.merchant.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(),'merchanttype_list'=> MerchantTypeModel::getMerchantTypeList(), 'dealer_list' => DealerModel::getDealerList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['merchant_add']);
		unset($_SESSION['admin']['merchant_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM merchant WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

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
            $sql = "SELECT * FROM merchant WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

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
        $sql = "SELECT * FROM merchant WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

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

            $_SESSION['admin']['merchant_edit_info'] = Helper::unescape($_POST);
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
			
			
			
    		$sql = "UPDATE merchant SET DealerID='".$_POST['DealerID']."', GenderID='".$_POST['GenderID']."', TypeID='".$_POST['TypeID']."', Name='".$_POST['Name']."', Company='".$_POST['Company']."', CompanyRegNo='".$_POST['CompanyRegNo']."', DOB='".Helper::dateDisplaySQL($_POST['DOB'])."', Expiry='".Helper::dateDisplaySQL($_POST['Expiry'])."', NRIC='".$_POST['NRIC']."', Passport='".$_POST['Passport']."', Nationality='".$_POST['Nationality']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Merchant...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM merchant WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Merchant...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function MerchantControl()
	{
		$crud = new CRUD();
		
		$sql = "SELECT TypeID FROM merchanT WHERE ID = '".$_SESSION['merchant']['ID']."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['TypeID'];
		}
		
		return $result;
	}

	public function getMerchant($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Expiry' => Helper::dateSQLToDisplay($row['Expiry']),
			'TypeID' => $row['TypeID'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'AccountNo' => $row['AccountNo'],
			'CompanyRegNo' => $row['CompanyRegNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
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

	public function updateMerchant($param, $message)
	{
	    /*Debug::displayArray($param);
		Debug::displayArray($message);*/
		
		$crud = new CRUD();
		
		$message = explode("-", $message);
		
		$type = strstr($message[0], ' ', true);
		
		/*echo $message[1].'<br />';
		echo $param.'<br />';
		echo $type;*/
		
		
		if($type == "Standard"){
		
		$expiry = date('Ymd', strtotime("+{$message[1]} year", time()));
		
		$sql = "UPDATE merchant SET TypeID='2', Expiry='".$expiry."' WHERE ID='".$param."'";
        //echo $sql.'<br />';	
    	$count = $this->dbconnect->exec($sql);
		
		}
		
		if($type == "Premier"){
				
			
		$expiry = date('Ymd', strtotime("+{$message[1]} year", time()));
		
		$sql = "UPDATE merchant SET TypeID='3', Expiry='".$expiry."' WHERE ID='".$param."'";
		//echo $sql;	
    	$count = $this->dbconnect->exec($sql);
		
		}
		

	
	}

	public function MerchantChanged()
	{
		

		$sql = "UPDATE merchant SET Updated = '1' WHERE ID = '".$_SESSION['DealerMerchant']['ID']."'";

		$count = $this->dbconnect->exec($sql);
		
		//$result = ($count==1) ? "ok" : "";
		
		
		
	}
	
	public function MerchantManualChanged($param)
	{
		

		$sql = "UPDATE merchant SET Updated = '1' WHERE ID = '".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		//$result = ($count==1) ? "ok" : "";
		
		
		
	}

	public function MerchantCheck()
	{
		

		$sql = "SELECT Updated FROM merchant WHERE ID = '".$_SESSION['merchant']['ID']."'";
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array('Updated'=>$row['Updated']);
		}
		
		if($result[$i]['Updated'] == '1'){
			//if($_SESSION['merchant']['ID']!=""){
			$sql = "UPDATE merchant SET Updated = '0' WHERE ID = '".$_SESSION['merchant']['ID']."'";
			//echo $sql;
			//exit;

		    $count = $this->dbconnect->exec($sql);
			Helper::redirect($this->config['SITE_URL']."/merchant/merchant/logout");
			//}
			
		}
		
		//$result = ($count==1) ? "ok" : "";
		
		/*if($result == 1){
			
		    Helper::redirect($this['config']['SITE_DIR']."/merchant/merchant/logout");
			
		}*/
		
	}

	public function getMerchantList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'DealerID' => $row['DealerID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Expiry' => Helper::dateSQLToDisplay($row['Expiry']),
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));
			$result[$i]['Limit'] = MerchantDealModel::getMerchantDealLimitStatus($row['ID']);
			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
	
	public function getDealerMerchantList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM merchant WHERE DealerID = '".$_SESSION['dealer']['ID']."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Expiry' => Helper::dateSQLToDisplay($row['Expiry']),
			'Company' => $row['Company'],
			'CompanyRegNo' => $row['CompanyRegNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'TypeID' => $row['TypeID'],
			'TypeLabel' => MerchantTypeModel::getMerchantType($row['TypeID'], "Label"),
			'Enabled' => CRUD::isActive($row['Enabled']));
			$result[$i]['Limit'] = MerchantDealModel::getMerchantDealLimitStatus($row['ID']);
			
			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
	

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM merchant ".$_SESSION['merchant_'.$param]['query_condition']." ORDER BY Name ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Merchants";
		$result['header'] = $this->config['SITE_NAME']." | Merchants (" . date('Y-m-d H:i:s') . ")\n\nID, Dealer, Gender, Name, Expiry, Company, Company Reg No, DOB, NRIC, Passport, Nationality, Username, Password, Phone No, Fax No, Mobile No, Email, Prompt, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".DealerModel::getDealer($row['DealerID'])."\",";
			$result['content'] .= "\"".CRUD::getGender($row['GenderID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['Expiry'])."\",";
			$result['content'] .= "\"".$row['Company']."\",";
			$result['content'] .= "\"".$row['CompanyRegNo']."\",";
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

	public function CronCheck() 
    {
        // Downgrade Expired Members
        $crud = new CRUD();
		//date('Ymd', strtotime("+{$_SESSION['cart']['SubYear']} year"));
		$last15days = date('Ymd', strtotime('+15 days'));
		$sql = "SELECT * FROM merchant WHERE TypeID = '2' OR TypeID = '3' AND Expiry < '".$last15days."'";
        
        //echo $sql;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Email' => $row['Email'],
            'DealerName' => DealerModel::getDealer($row['DealerID'], "Name"),
            'DealerEmail' => DealerModel::getDealer($row['DealerID'], "Email"),
            'Expiry' => $row['Expiry']);
            
            $i += 1;
        }
		/*Debug::displayArray($result);
		exit;*/
        
        for ($j=0; $j < $i; $j++)
        { 
            if ($j==0)
            {
                $query .= "(ID = '".$result[$j]['ID']."')";
            }
            else
            {
                $query .= " OR (ID = '".$result[$j]['ID']."')";
            }
        }
        
        if ($j>0)
        {
            $query_start = "WHERE (";
            $query = $query_start.$query;
            $query = $query.")";
    
            $sql = "UPDATE merchant SET TypeID='1' ".$query;
            $count = $this->dbconnect->exec($sql);
            
            echo "Updated: ".$sql;
        }
        else
        {
            echo "No changes made.";
        }
		
        
        /*// Notify Expiring Members
        $crud = new CRUD();

        $sql = "SELECT * FROM merchant WHERE TypeID = '2' AND Expiry < '".date('Y-m-d', strtotime('+30 days'))."'";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'FirstName' => $row['FirstName'],
            'Email' => $row['Email'],
            'Expiry' => $row['Expiry']);
            
            $i += 1;
        }*/
        
        for ($j=0; $j < $i; $j++)
        {
            //require_once('classes/class.mailer.php');
			
			
                
            // Send Mail
            $mailer = new BaseMailer();
			echo $result[$j]['Email'] . '<br />';
            $mailer->From = "no-reply@aseanfnb.com.my";
            $mailer->AddReplyTo = "admin@aseanfnb.com.my";
            $mailer->FromName = "aseanF&B";
    
            $mailer->Subject = "[aseanF&B] Your Membership is Expiring on ".Helper::dateSQLToLongDisplay($result[$j]['Expiry']);
    
            $mailer->AddAddress($result[$j]['Email'], '');
            //$mailer->AddBCC('general@valse.com.my', '');
    
            $mailer->IsHTML(true);
    
            $mailer->Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>Expiration</title>
              
              <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">
              <table style="font-family:Arial,sans-serif; font-size:12px;
                color:#333; width: 550px;">
                <tbody>
                  <tr>
                    <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://chopinsociety.com.my/themes/valse/img/logo.png" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left">Hello <strong style="color:#FB7D00;">'.$result[$j]['Name'].'</strong>,<br /><br />Please be reminded that your membership is expiring on '.Helper::dateSQLToLongDisplay($result[$j]['Expiry']).' To renew, please login to your account at <a href="http://aseanfnb.com.my">http://aseanfnb.com.my</a>. Thank you for your continuous support.</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>';
    
            $days = (strtotime($result[$j]['Expiry']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
            
            if (($days=='15')||($days=='7')||($days=='3')||($days=='1'))
            {
                $mailer->Send();
            }
			
			//require_once('classes/class.mailer.php');

                
            // Send Mail
            $mailer2 = new BaseMailer();
            $mailer2->From = "no-reply@aseanfnb.com.my";
            $mailer2->AddReplyTo = "admin@aseanfnb.com.my";
            $mailer2->FromName = "aseanF&B";
    
            $mailer2->Subject = "[aseanF&B] Your Member: ".$result[$j]['Name']."  is expiring on ".Helper::dateSQLToLongDisplay($result[$j]['Expiry']);
    
            $mailer2->AddAddress($result[$j]['DealerEmail'], '');
            //$mailer->AddBCC('decweng.chan@valse.com.my', '');
    
            $mailer2->IsHTML(true);
    
            $mailer2->Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>Member(s) Expiration</title>
              
              <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">
              <table style="font-family:Arial,sans-serif; font-size:12px;
                color:#333; width: 550px;">
                <tbody>
                  <tr>
                    <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://chopinsociety.com.my/themes/valse/img/logo.png" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left">Hello <strong style="color:#FB7D00;">'.$result[$j]['DealerName'].'</strong>,<br /><br />Please be reminded that your member <strong style="color:#FB7D00;">'.$result[$j]['Name'].'</strong> is expiring on '.Helper::dateSQLToLongDisplay($result[$j]['Expiry']).' To renew, please login to your account at <a href="http://aseanfnb.com.my">http://aseanfnb.com.my</a>. Thank you for your continuous support.</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">aseanF&B</a>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>';
    
            $days = (strtotime($result[$j]['Expiry']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
            
            if (($days=='15')||($days=='7')||($days=='3')||($days=='1'))
            {
                $mailer2->Send();
            }
			
			
			
        }
        
        /*if ($j>0)
        {
            echo "<br />Expiring members: ".$j;
        }
        else
        {
            echo "<br />No expiring members.";
        }*/
            
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "Editing Member...", 'template' => 'common.tpl.php'),
        'content_param' => array('count' => $count),
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }

    public function getHash($param)
    {
        $sql = "SELECT Password FROM merchant WHERE ID = '".$param."'";

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

        $sql = "SELECT * FROM merchant WHERE Username = '".$cookie_data['Username']."' AND CookieHash = '".$cookie_data['Hash']."' AND Enabled = 1";

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