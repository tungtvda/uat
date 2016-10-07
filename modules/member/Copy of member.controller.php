<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('reseller');

class Member extends BaseController
{
	protected $controller_name = "member";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new MemberModel();
		return $model;
	}

	protected function Index()
	{
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}

        if ($this->section=='member')
        {
            // Control Access
            $this->Access(1);

            Helper::redirect($param['config']['SITE_DIR']."/member/member/dashboard");
        }

		if ($this->section=='reseller')
        {
            // Control Access
            Reseller::Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/member/reseller/dashboard");
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}


	protected function BlockHomeIndex()
    {
        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel($this->id), false);
    }


	protected function View()
	{
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
            Helper::redirect404();
        }
	}

    protected function Dashboard()
    {
    	/*echo "hi";
		exit;*/
    	if($this->section == 'member'){
        // Control Access
        $this->Access(1);
		}

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

        $_SESSION['member']['member_profile'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['member']['Name'] = $param['content']['Name'];

            Helper::redirect($param['config']['SITE_DIR']."/member/member/profile");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/member/member/profile");
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

        $_SESSION['member']['member_password'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            Helper::redirect($param['config']['SITE_DIR']."/member/member/logout");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/member/member/password");
        }
    }

    protected function Register()
    {
    	if($_GET['rid']==''){

			Helper::redirect404();
    	}

        // Control Access
        $this->Access(0);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function RegisterProcess()
    {
        // Control Access
        $this->Access(0);

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit('Submit');

		//$_SESSION['activation_code'] = '0';

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();


        $_SESSION['member']['member_register'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Send mail to user
            $mailer = new BaseMailer();

            $mailer->From = $param['config']['EMAIL_SENDER'];
            $mailer->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['config']['COMPANY_NAME']);
            $mailer->FromName = $param['config']['COMPANY_NAME'];

            $mailer->Subject = "[".$param['config']['SITE_NAME']."] Welcome to ".$param['config']['COMPANY_NAME']."!";

            $mailer->AddAddress($param['content']['Email'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC1'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC2'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC3'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC4'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC5'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC6'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC7'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC8'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC9'], '');
            $mailer->AddAddress($param['config']['MEMBER_EMAIL_CC10'], '');

            $mailer->IsHTML(true);

            ob_start();
            require_once('modules/member/mail/member.register.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/member/mail/member.register.txt.php');
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

            // Redirect User to Login Page
            Helper::redirect($param['config']['SITE_DIR']."/member/member/login/");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/member/member/register/");
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

        $_SESSION['member']['member_login'] = $param['status'];


        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['member']['ID'] = $param['content'][0]['ID'];
            $_SESSION['member']['Username'] = $param['content'][0]['Username'];
            $_SESSION['member']['Name'] = $param['content'][0]['Name'];
            $_SESSION['member']['Prompt'] = $param['content'][0]['Prompt'];
		    $_SESSION['member']['MobileNo'] = $param['content'][0]['MobileNo'];

            if ($param['activation_code']!='1')
            {
                $_SESSION['member']['activation_code'] = 'Unverified';

                // Redirect to activation
                Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");
            }

            // Redirect to original destination URL if available
            else if ($_SESSION['member']['redirect_url']!="")
            {
                $redirect_url = $_SESSION['member']['redirect_url'];
                unset($_SESSION['member']['redirect_url']);

                // Redirect to original destination URL
                Helper::redirect($redirect_url);
            }
            else
            {
				// Redirect to dashboard
                Helper::redirect($param['config']['SITE_DIR']."/member/wallet/index");
            }
        }
        else
        {
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/login?username=".$param['login_param']['username']."&autologin=".$param['login_param']['autologin']);

            Helper::redirect($param['config']['SITE_DIR']."/member/member/login");
        }

    }

	protected function Activation()
    {
    	/*echo 'hi';
		exit;*/
        // Control Access
        //$this->Access(0);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);

        /*$_SESSION['member']['member_login'] = $param['status'];

        if ($param['activated']=="1")
        {

                // Redirect to dashboard
                Helper::redirect($param['config']['SITE_DIR']."/member/member/dashboard");

        }
        else
        {
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/login?username=".$param['login_param']['username']."&autologin=".$param['login_param']['autologin']);

            Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");
        }*/

    }

    protected function ActivationProcess()
    {
        // Control Access
        //$this->Access(0);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Submit');

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        //$_SESSION['member']['member_login'] = $param['status'];

        if ($param['activated']=="1")
        {

                // Redirect to dashboard
                unset($_SESSION['member']['activation_code']);
                Helper::redirect($param['config']['SITE_DIR']."/member/member/dashboard");

        }
        else
        {
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/login?username=".$param['login_param']['username']."&autologin=".$param['login_param']['autologin']);
		     $_SESSION['member']['activation_code_incorrect'] = '1';
            Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");
        }

    }

	protected function ResendActivationProcess()
    {
        // Control Access
        //$this->Access(0);

        // Validate Genuine Form Submission
		#CRUD::validateFormSubmit('Send');

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['resend'] = "1";
        Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");


    }

	protected function UpdateActivationProcess()
    {
        // Control Access
        //$this->Access(0);

        // Validate Genuine Form Submission
		//CRUD::validateFormSubmit('Update');

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['update'] = $param['status'];
        Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");


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
        CRUD::validateFormSubmit('','HPot',TRUE);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['member']['member_forgotpassword'] = $param['status'];

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
            require_once('modules/member/mail/member.forgotpasswordprocess.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/member/mail/member.forgotpasswordprocess.txt.php');
            $txtBody = ob_get_contents();
            ob_end_clean();

            $mailer->IsHTML(true);
            $mailer->Body = $htmlBody;
            $mailer->AltBody = $txtBody;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();

            Helper::redirect($param['config']['SITE_DIR']."/member/member/login");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/member/member/forgotpassword");
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
        if ($_SESSION['member']['member_password']!="")
        {
            $member_password = $_SESSION['member']['member_password'];
        }

        // Destroy member session
        unset($_SESSION['member']);

        if ($member_password!="")
        {
            $_SESSION['member']['member_password'] = $member_password;
        }
        else
        {
            $_SESSION['member']['member_logout']['ok'] = 1;
        }

        Helper::redirect($param['config']['SITE_DIR']."/member/member/login");
    }

    public function Access($access)
    {
        require_once('modules/member/member.model.php');

        // Load Model
        $start = Member::Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        // 0 for public page, 1 for private page
        if ($access==0)
        {
        	#$exist = array_key_exists('activation_code', $_SESSION);

            if ($_SESSION['member']['ID']!="")
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/member/dashboard");
            }
        }
        else if ($access==1)
        {
            if ($_SESSION['member']['ID']=="")
            {
                // Store destination URL
                $_SESSION['member']['redirect_url'] = $_SERVER["REQUEST_URI"];

                // Sends user to login page if autologin cookie is verified? - Not implemented
                Helper::redirect($param['config']['SITE_DIR']."/member/member/login");
            }
            else
            {
                $constant = get_defined_constants(true);

                // Redirect if user is in Member section but not in Password page
                if (($_SESSION['member']['activation_code']=='Unverified')&&($constant['user']['LOAD_ACTION']!="activation")&&($constant['user']['LOAD_ACTION']!="activationprocess")&&($constant['user']['LOAD_ACTION']!="updateactivationprocess")&&($constant['user']['LOAD_ACTION']!="resendactivationprocess")&&($constant['user']['LOAD_ACTION']!="logout"))
                {
                    Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");
                }

                // Force password change if Prompt is enabled

                // Redirect if user is in Member section but not in Password page
                if (($_SESSION['member']['Prompt']==1)&&($constant['user']['LOAD_ACTION']!="password")&&($constant['user']['LOAD_ACTION']!="passwordprocess")&&($constant['user']['LOAD_ACTION']!="logout"))
                {
                    Helper::redirect($param['config']['SITE_DIR']."/member/member/password");
                }
            }
        }
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

        $_SESSION['admin']['member_add'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/member/edit/".$param['content_param']['newID']);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/member/add/");
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/member/index");
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

		$_SESSION['admin']['member_edit'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/member/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/member/edit/".$this->id);
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

        $_SESSION['admin']['member_delete'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/member/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/member/index");
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