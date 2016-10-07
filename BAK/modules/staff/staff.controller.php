<?php
// Require required controllers
Core::requireController('permission');

class Staff extends BaseController
{
	protected $controller_name = "staff";
	private $prefix = "";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new StaffModel();
		return $model;
	}

	protected function Index()
	{
	    if ($this->section=='admin')
	    {
	        // Control Access
            Staff::Access(1);

            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/dashboard");
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();
	}

	protected function Dashboard()
	{
		// Control Access
		$this->Access(1);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

    protected function Profile()
    {
        // Control Access
        $this->Access(1);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function ProfileProcess()
    {
        // Control Access
        $this->Access(1);

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit('Update');

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['admin']['staff_profile'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['staff']['Name'] = $param['content']['Name'];

            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/profile");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/profile");
        }
    }

	protected function Password()
	{
		// Control Access
		$this->Access(1);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function PasswordProcess()
	{
		// Control Access
		$this->Access(1);

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit('Submit');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		$_SESSION['admin']['staff_password'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/logout");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/password");
		}
	}

	protected function Login()
	{
		// Control Access
		$this->Access(0);

		// Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
	}

	protected function LoginProcess()
	{
		// Control Access
		$this->Access(0);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		$_SESSION['admin']['staff_login'] = $param['status'];

        if ($param['status']['ok']=="1" && $param['status']['error']['count'] == 0)
        {
			$_SESSION['admin']['ID'] = $param['content'][0]['ID'];
			$_SESSION['admin']['Username'] = $param['content'][0]['Username'];
            $_SESSION['admin']['Name'] = $param['content'][0]['Name'];
            $_SESSION['admin']['Profile'] = $param['content'][0]['Profile'];
            $_SESSION['admin']['Prompt'] = $param['content'][0]['Prompt'];

            // Redirect to original desitnation URL if available
            if ($_SESSION['admin']['redirect_url']!="")
            {
                $redirect_url = $_SESSION['admin']['redirect_url'];
                unset($_SESSION['admin']['redirect_url']);

                // Redirect to original destination URL
                Helper::redirect($redirect_url);
            }
            else
            {
                // Redirect to dashboard
                Helper::redirect($param['config']['SITE_DIR']."/admin/");
            }
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/login");
		}
	}

    protected function ForgotPassword()
    {
        // Control Access
        $this->Access(0);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function ForgotPasswordProcess()
    {
        // Validate Genuine Form Submission
        CRUD::validateFormSubmit(1,'FPTrigger');

        // Honey Pot Captcha
        CRUD::validateFormSubmit("",'HPot',TRUE);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['admin']['staff_forgotpassword'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Send mail to user
            $mailer = new BaseMailer();

            $mailer->From = $param['config']['EMAIL_SENDER'];
            $mailer->AddReplyTo($param['config']['COMPANY_EMAIL'], $param['config']['COMPANY_NAME']);
            $mailer->FromName = $param['config']['COMPANY_NAME'];

            $mailer->Subject = "[".$param['config']['SITE_NAME']."] New password request";

            $mailer->AddAddress($param['content'][0]['Email'], '');
            #$mailer->AddBCC('abc@gmail.com', '');

            $mailer->IsHTML(true);

            ob_start();
            require_once('modules/staff/mail/staff.forgotpasswordprocess.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/staff/mail/staff.forgotpasswordprocess.txt.php');
            $txtBody = ob_get_contents();
            ob_end_clean();

            $mailer->IsHTML(true);
            $mailer->Body = $htmlBody;
            $mailer->AltBody = $txtBody;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();

            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/login");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/forgotpassword");
        }
    }

	protected function Logout()
	{
		// Control Access
		$this->Access(1);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

        // Preserve notification sessions variables
        if ($_SESSION['admin']['staff_password']!="")
        {
            $staff_password = $_SESSION['admin']['staff_password'];
        }

        // Destroy staff session
		unset($_SESSION['admin']);

        if ($staff_password!="")
        {
            $_SESSION['admin']['staff_password'] = $staff_password;
        }
        else
        {
            $_SESSION['admin']['staff_logout']['ok'] = 1;
        }

		Helper::redirect($param['config']['SITE_DIR']."/admin/staff/login");
	}

	public function Access($access)
	{
		require_once('modules/staff/staff.model.php');

		// Load Model
		$start = Staff::Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		// 0 for public page, 1 for private page
		if ($access==0)
		{
			if ($_SESSION['admin']['ID']!="")
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/staff/dashboard");
			}
		}
		else if ($access==1)
		{
		    // Force change passwords
		    /*if ($_SESSION['force_change']=="")
            {
                unset($_SESSION['admin']);
                $_SESSION['force_change'] == "Done";
                echo $_SESSION['force_change'];
                #exit();

                //Helper::redirect($param['config']['SITE_DIR']."/admin/staff/login");
            }*/

			if ($_SESSION['admin']['ID']=="")
			{
			    // Store destination URL
			    $_SESSION['admin']['redirect_url'] = $_SERVER["REQUEST_URI"];

				Helper::redirect($param['config']['SITE_DIR']."/admin/staff/login");
            }
            else
            {
                // Force password change if Prompt is enabled
                $constant = get_defined_constants(true);

                // Redirect if user is in Member section but not in Password page
                if (($_SESSION['admin']['Prompt']==1)&&($constant['user']['LOAD_ACTION']!="password")&&($constant['user']['LOAD_ACTION']!="passwordprocess")&&($constant['user']['LOAD_ACTION']!="logout"))
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/staff/password");
                }
            }
		}
	}

	protected function ViewAll()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,1);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function Add()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function AddProcess()
	{
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		$_SESSION['admin']['staff_add'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/edit/".$param['content_param']['newID']);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/add/");
		}
	}

	protected function Edit()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($param['content_param']['count']=="1")
        {
            $this->ReturnView($param, true);
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/index");
        }
	}

	protected function EditProcess()
	{
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        $_SESSION['admin']['staff_edit'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/edit/".$this->id);
		}
	}

	protected function Delete()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,4);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        $_SESSION['admin']['staff_delete'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/viewall");
		}
		else
		{
            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/viewall");
		}
	}

	protected function Export()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
	}
}
?>