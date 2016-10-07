<?php
// Require required models
Core::requireModel('profile');

class StaffModel extends BaseModel
{
	private $output = array();
    private $module_name = "Staff";
	private $module_dir = "modules/staff/";
    private $module_default_url = "/main/staff/index";
    private $module_default_admin_url = "/admin/staff/viewall";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Redirecting..."),
		'meta' => array('active' => "off"));

		return $this->output;
	}

	public function AdminDashboard()
	{
                $_SESSION['admin']['DEFAULT_LANGUAGE'] = $this->config['DEFAULT_LANGUAGE'];

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Dashboard", 'template' => 'admin.common.tpl.php', 'permission_access' => $_SESSION['admin']['permission_access']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_dashboard.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Dashboard"),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['permission_access']);

		return $this->output;
	}

    public function AdminProfile()
    {
        $sql = "SELECT * FROM staff WHERE ID = '".$_SESSION['admin']['ID']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email'],
            'Password' => $row['Password'],
            'Profile' => $row['Profile'],
            'Prompt' => $row['Prompt'],
            'Enabled' => $row['Enabled']);

            $i += 1;
        }


        if ($_SESSION['admin']['staff_profile_info']!="")
        {
            $form_input = $_SESSION['admin']['staff_profile_info'];

            // Unset temporary staff info input
            unset($_SESSION['admin']['staff_profile_info']);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "My Profile", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/profile.inc.php', 'staff_profile' => $_SESSION['admin']['staff_profile']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_profile.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"My Profile"),
        'content' => $result,
        'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['admin']['staff_profile']);

        return $this->output;
    }

    public function AdminProfileProcess()
    {
        // Check is email exists
        $sql = "SELECT * FROM staff WHERE Email = '".$_POST['Email']."' AND ID != '".$_SESSION['admin']['ID']."'";

        $result = array();
        $i_email = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_email] = array(
            'Username' => $row['Username']);

            $i_email += 1;
        }

        $error['count'] = $i_email;

        if ($error['count']>0)
        {
            if ($i_email>0)
            {
                $error['Email'] = 1;
            }

            $_SESSION['admin']['staff_profile_info'] = Helper::unescape($_POST);
        }
        else
        {
            $sql = "UPDATE staff SET Name='".$_POST['Name']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."' WHERE ID='".$_SESSION['admin']['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Profile..."),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

	public function AdminPassword()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Change Password", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/password.inc.php', 'staff_password' => $_SESSION['admin']['staff_password']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_profile.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Change Password"),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['admin_password']);

		return $this->output;
	}

	public function AdminPasswordProcess()
	{
	    // Update new password if current password is entered correctly
        $bcrypt = new Bcrypt(9);
        $verify = $bcrypt->verify($_POST['Password'], $this->getHash($_SESSION['admin']['ID']));

        if ($verify==1)
        {
            $hash = $bcrypt->hash($_POST['PasswordNew']);

            // Save new password and disable Prompt
            $sql = "UPDATE staff SET Password='".$hash."', Prompt = 0 WHERE ID='".$_SESSION['admin']['ID']."'";
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
		'page' => array('title' => "Updating Password...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'secure' => TRUE,
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminIndex()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Staff Home", 'template' => 'admin.common.tpl.php'),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminLogin()
	{
	    if ($_SESSION['admin']['staff_login_info']!="")
        {
            $form_input = $_SESSION['admin']['staff_login_info'];

            // Unset temporary staff info input
            unset($_SESSION['admin']['staff_login_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Administrator Panel - Login", 'template' => 'admin.common_out.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/login.inc.php', 'staff_login' => $_SESSION['admin']['staff_login'], 'staff_logout' => $_SESSION['admin']['staff_logout'], 'staff_password' => $_SESSION['admin']['staff_password'], 'staff_forgotpassword' => $_SESSION['admin']['staff_forgotpassword']),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['staff_login']);
        unset($_SESSION['admin']['staff_logout']);
        unset($_SESSION['admin']['staff_password']);
        unset($_SESSION['admin']['staff_forgotpassword']);

		return $this->output;
	}

	public function AdminLoginProcess()
	{
		$sql = "SELECT * FROM staff WHERE Enabled = 1 AND Username = '".$_POST['Username']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email'],
            'Password' => $row['Password'],
            'Profile' => $row['Profile'],
            'Prompt' => $row['Prompt'],
            'Enabled' => $row['Enabled']);

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

                $_SESSION['admin']['staff_login_info'] = Helper::unescape($_POST);
            }

            if ($verify==1){

                $message = Helper::sendAdminTac($_POST['Username'], $_POST['TAC']);

            }

            if($message=='Invalid')
            {
                // Invalid TAC
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['admin']['staff_login_info'] = Helper::unescape($_POST);
            }

            if($message=='used')
            {
                // Invalid TAC
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['admin']['staff_login_info'] = Helper::unescape($_POST);
            }

            if($message=='not approved')
            {
                // Invalid TAC
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['admin']['staff_login_info'] = Helper::unescape($_POST);
            }

        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            $_SESSION['admin']['staff_login_info'] = Helper::unescape($_POST);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "off"));

		return $this->output;
	}

	public function AdminLogout()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Logging Out..."),
		'meta' => array('active' => "off"));

		return $this->output;
	}

    public function AdminForgotPassword()
    {
        if ($_SESSION['admin']['staff_forgotpassword_info']!="")
        {
            $form_input = $_SESSION['admin']['staff_forgotpassword_info'];

            // Unset temporary staff info input
            unset($_SESSION['admin']['staff_forgotpassword_info']);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Forgot Your Password?", 'template' => 'admin.common_out.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/forgotpassword.inc.php', 'staff_forgotpassword' => $_SESSION['admin']['staff_forgotpassword']),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_common.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Forgot Password"),
        'content_param' => array('enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['admin']['staff_forgotpassword']);

        return $this->output;
    }

    public function AdminForgotPasswordProcess()
    {
        $sql = "SELECT * FROM staff WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' LIMIT 0,1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email'],
            'Password' => $row['Password'],
            'Profile' => $row['Profile'],
            'Prompt' => $row['Prompt'],
            'Enabled' => $row['Enabled']);

            $i += 1;
        }

        if ($i==1)
        {
            // Generate New Password
            $bcrypt = new Bcrypt(9);
            $new_password = uniqid();
            $hash = $bcrypt->hash($new_password);

            $sql = "UPDATE staff SET Password='".$hash."', Prompt='1' WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND ID='".$result[0]['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Username and email do not match
            $error['count'] += 1;
            $error['NoMatch'] = 1;

            $_SESSION['admin']['staff_forgotpassword_info'] = Helper::unescape($_POST);
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

	public function AdminAccess()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Checking Access..."),
		'meta' => array('active' => "off"));

		return $this->output;
	}

	public function AdminViewAll($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['staff_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("ID",$_POST['ID'],"=");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
			$query_condition .= $crud->queryCondition("Profile",$_POST['Profile'],"=");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['staff_'.__FUNCTION__]['param']['ID'] = $_POST['ID'];
			$_SESSION['staff_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['staff_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
			$_SESSION['staff_'.__FUNCTION__]['param']['Profile'] = $_POST['Profile'];
			$_SESSION['staff_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['staff_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['staff_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['staff_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['staff_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM staff ".$_SESSION['staff_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/staff/viewall';
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

		$sql = "SELECT * FROM staff ".$_SESSION['staff_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email'],
            'Password' => $row['Password'],
            'Profile' => ProfileModel::getProfile($row['Profile']),
            'Prompt' => CRUD::isActive($row['Prompt']),
            'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Staff", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/viewall.inc.php', 'staff_delete' => $_SESSION['admin']['staff_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['staff_delete']);

		return $this->output;
	}

	public function AdminAdd()
	{
	    if ($_SESSION['admin']['staff_add_info']!="")
        {
            $form_input = $_SESSION['admin']['staff_add_info'];

            // Unset temporary staff info input
            unset($_SESSION['admin']['staff_add_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Staff", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'staff_add' => $_SESSION['admin']['staff_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Staff"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['staff_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
        // Check is username exists
        $sql = "SELECT * FROM staff WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        // Check is email exists
        $sql = "SELECT * FROM staff WHERE Email = '".$_POST['Email']."'";

        $result = array();
        $i_email = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_email] = array(
            'Email' => $row['Email']);

            $i_email += 1;
        }

        $error['count'] = $i_username + $i_email;

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_email>0)
            {
                $error['Email'] = 1;
            }

            $_SESSION['admin']['staff_add_info'] = Helper::unescape($_POST);
        }
        else
        {
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

    		$key = "(Username, Name, MobileNo, Email, Password, Profile, Prompt, Enabled)";
    		$value = "('".$_POST['Username']."', '".$_POST['Name']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$hash."', '".$_POST['Profile']."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO staff ".$key." VALUES ". $value;

    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Staff..."),
		'content' => Helper::unescape($_POST),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM staff WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Username' => $row['Username'],
            'Name' => $row['Name'],
            'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Password' => $row['Password'],
			'Profile' => $row['Profile'],
            'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
		}

		if ($_SESSION['admin']['staff_edit_info']!="")
        {
            $form_input = $_SESSION['admin']['staff_edit_info'];

            // Unset temporary staff info input
            unset($_SESSION['admin']['staff_edit_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Staff", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'staff_add' => $_SESSION['admin']['staff_add'], 'staff_edit' => $_SESSION['admin']['staff_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.staff_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Staff"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'profile_list' => ProfileModel::getProfileList()),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['staff_add']);
		unset($_SESSION['admin']['staff_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
	    // Check is username exists
        $sql = "SELECT * FROM staff WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        // Check is email exists
        $sql = "SELECT * FROM staff WHERE Email = '".$_POST['Email']."' AND ID != '".$param."'";

        $result = array();
        $i_email = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_email] = array(
            'Username' => $row['Username']);

            $i_email += 1;
        }

        $error['count'] = $i_username + $i_email;

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_email>0)
            {
                $error['Email'] = 1;
            }

            $_SESSION['admin']['staff_edit_info'] = Helper::unescape($_POST);
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

    		$sql = "UPDATE staff SET Username='".$_POST['Username']."', Name='".$_POST['Name']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', Password='".$hash."', Profile='".$_POST['Profile']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Staff..."),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM staff WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Staff...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getStaff($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM staff WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Username' => $row['Username'],
			'Email' => $row['Email'],
			'Profile' => ProfileModel::getProfile($row['Profile']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result = $result[0]['Username'];

		return $result;
	}

        public function getStaffDetails($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM staff WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Username' => $row['Username'],
			'Email' => $row['Email'],
			'Profile' => ProfileModel::getProfile($row['Profile']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}



		return $result;
	}

	public function getStaffList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM staff ORDER BY Username ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Username' => $row['Username'],
			'Email' => $row['Email'],
			'Profile' => ProfileModel::getProfile($row['Profile']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM staff ".$_SESSION['staff_'.$param]['query_condition']." ORDER BY Username ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Staff";
		$result['header'] = $this->config['SITE_NAME']." | Staff (" . date('Y-m-d H:i:s') . ")\n\nID, Username, Name, MobileNo, Email, Password, Profile, Prompt, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['Username']."\",";
            $result['content'] .= "\"".$row['Name']."\",";
            $result['content'] .= "\"".$row['MobileNo']."\",";
			$result['content'] .= "\"".$row['Email']."\",";
			$result['content'] .= "\"".$row['Password']."\",";
			$result['content'] .= "\"".$row['Profile']."\",";
            $result['content'] .= "\"".CRUD::isActive($row['Prompt'])."\",";
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

    public function getHash($param)
    {
        $sql = "SELECT Password FROM staff WHERE ID = '".$param."'";

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
}
?>