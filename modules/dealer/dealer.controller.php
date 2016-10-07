<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class Dealer extends BaseController
{
	protected $controller_name = "dealer";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new DealerModel();
		return $model;
	}

	protected function Index()
	{
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,1);
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(1);

            Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/dashboard");
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function View()
	{
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            Helper::redirect404();
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
        }
        else if ($this->section=='api')
        {
        }
	}

    protected function Dashboard()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(1);
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function Profile()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(1);
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function ProfileProcess()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('Update');
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $_SESSION['dealer']['dealer_profile'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                // Set session data
                $_SESSION['dealer']['Name'] = $param['content']['Name'];

                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/profile");
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/profile");
            }
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function Password()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(1);
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function PasswordProcess()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('Submit');
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $_SESSION['dealer']['dealer_password'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/logout");
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/password");
            }
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function Register()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(0);
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function RegisterProcess()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(0);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('Submit');
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $_SESSION['dealer']['dealer_register'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                // Send mail to user
                $mailer = new BaseMailer();

                $mailer->From = "no-reply@valse.com.my";
                $mailer->AddReplyTo($param['config']['COMPANY_EMAIL'], $param['config']['COMPANY_NAME']);
                $mailer->FromName = $param['config']['COMPANY_NAME'];

                $mailer->Subject = "[".$param['config']['SITE_NAME']."] Welcome to ".$param['config']['COMPANY_NAME']."!";

                $mailer->AddAddress($param['content']['Email'], '');
                #$mailer->AddBCC('kenan.ng@valse.com.my', '');

                $mailer->IsHTML(true);

                ob_start();
                require_once('modules/dealer/mail/dealer.register.php');
                $htmlBody = ob_get_contents();
                ob_end_clean();

                ob_start();
                require_once('modules/dealer/mail/dealer.register.txt.php');
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
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/login/");
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/register/");
            }
        }
        else if ($this->section=='api')
        {
            if ($param['status']['ok']=="1")
            {
                // Send mail to user
                $mailer = new BaseMailer();

                $mailer->From = "no-reply@valse.com.my";
                $mailer->AddReplyTo($param['config']['COMPANY_EMAIL'], $param['config']['COMPANY_NAME']);
                $mailer->FromName = $param['config']['COMPANY_NAME'];

                $mailer->Subject = "[".$param['config']['SITE_NAME']."] Welcome to ".$param['config']['COMPANY_NAME']."!";

                $mailer->AddAddress($param['content']['Email'], '');
                #$mailer->AddBCC('kenan.ng@valse.com.my', '');

                $mailer->IsHTML(true);

                ob_start();
                require_once('modules/dealer/mail/dealer.register.php');
                $htmlBody = ob_get_contents();
                ob_end_clean();

                ob_start();
                require_once('modules/dealer/mail/dealer.register.txt.php');
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

                exit();
            }
        }
    }

    protected function Login()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(0);
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function LoginProcess()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            //$this->Access(0);
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $_SESSION['dealer']['dealer_login'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                // Set session data
                $_SESSION['dealer']['ID'] = $param['content'][0]['ID'];
                $_SESSION['dealer']['Username'] = $param['content'][0]['Username'];
                $_SESSION['dealer']['Name'] = $param['content'][0]['Name'];
                $_SESSION['dealer']['Prompt'] = $param['content'][0]['Prompt'];

                /*// Set autologin cookie
                require_once("lib/securecookie/class.securecookie.php");
                $cookie = new SecureCookie($param['cookie']['key'],'VALSE_AUTOLOGIN',time()+5184000,'/','mvc.valse.com.my');

                if ($param['login_param']['autologin']==1)
                {
                    $cookie_value = array('Username' => $param['content'][0]['Username'], 'Hash' => $param['cookie']['hash']);
                    $cookie_value = json_encode($cookie_value);

                    $cookie->Set('Value',$cookie_value);
                }
                else // Delete the cookie
                {
                    $cookie->Del('Value');
                }*/

                // Redirect to original destination URL if available
                if ($_SESSION['dealer']['redirect_url']!="")
                {
                    $redirect_url = $_SESSION['dealer']['redirect_url'];
                    unset($_SESSION['dealer']['redirect_url']);

                    // Redirect to original destination URL
                    Helper::redirect($redirect_url);
                }
                else
                {
                    // Redirect to dashboard
                    Helper::redirect($param['config']['SITE_URL']."/dealer/");
                }
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/login");
            }
        }
        else if ($this->section=='api')
        {
        }

    }

    protected function ForgotPassword()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Control Access
            $this->Access(0);
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
    }

    protected function ForgotPasswordProcess()
    {
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='dealer')
        {
            // Validate Genuine Form Submission
            CRUD::validateFormSubmit(1,'FPTrigger');

            // Honey Pot Captcha
            CRUD::validateFormSubmit('','HPot',TRUE);
        }
        else if ($this->section=='api')
        {
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='dealer')
        {
            $_SESSION['dealer']['dealer_forgotpassword'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                // Send mail to user
                $mailer = new BaseMailer();

                $mailer->From = "no-reply@valse.com.my";
                $mailer->AddReplyTo($param['config']['COMPANY_EMAIL'], $param['config']['COMPANY_NAME']);
                $mailer->FromName = $param['config']['COMPANY_NAME'];

                $mailer->Subject = "[".$param['config']['SITE_NAME']."] New password request";

                $mailer->AddAddress($param['content'][0]['Email'], '');
                #$mailer->AddBCC('kenan.ng@valse.com.my', '');

                $mailer->IsHTML(true);

                ob_start();
                require_once('modules/dealer/mail/dealer.forgotpasswordprocess.php');
                $htmlBody = ob_get_contents();
                ob_end_clean();

                ob_start();
                require_once('modules/dealer/mail/dealer.forgotpasswordprocess.txt.php');
                $txtBody = ob_get_contents();
                ob_end_clean();

                $mailer->IsHTML(true);
                $mailer->Body = $htmlBody;
                $mailer->AltBody = $txtBody;

                $mailer->Send();

                $mailer->ClearAddresses();
                $mailer->ClearAttachments();

                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/login");
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/forgotpassword");
            }
        }
        else if ($this->section=='api')
        {
            if ($param['status']['ok']=="1")
            {
                // Send mail to user
                $mailer = new BaseMailer();

                $mailer->From = "no-reply@valse.com.my";
                $mailer->AddReplyTo($param['config']['COMPANY_EMAIL'], $param['config']['COMPANY_NAME']);
                $mailer->FromName = $param['config']['COMPANY_NAME'];

                $mailer->Subject = "[".$param['config']['SITE_NAME']."] New password request";

                $mailer->AddAddress($param['content'][0]['Email'], '');
                #$mailer->AddBCC('kenan.ng@valse.com.my', '');

                $mailer->IsHTML(true);

                ob_start();
                require_once('modules/dealer/mail/dealer.forgotpasswordprocess.php');
                $htmlBody = ob_get_contents();
                ob_end_clean();

                ob_start();
                require_once('modules/dealer/mail/dealer.forgotpasswordprocess.txt.php');
                $txtBody = ob_get_contents();
                ob_end_clean();

                $mailer->IsHTML(true);
                $mailer->Body = $htmlBody;
                $mailer->AltBody = $txtBody;

                $mailer->Send();

                $mailer->ClearAddresses();
                $mailer->ClearAttachments();

                exit();
            }
        }
    }

    protected function Logout()
    {
        // Control Access
        $this->Access(1);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        // Preserve notification sessions variables
        if ($_SESSION['dealer']['dealer_password']!="")
        {
            $dealer_password = $_SESSION['dealer']['dealer_password'];
        }

        // Destroy dealer session
        unset($_SESSION['dealer']);

        if ($dealer_password!="")
        {
            $_SESSION['dealer']['dealer_password'] = $dealer_password;
        }
        else
        {
            $_SESSION['dealer']['dealer_logout']['ok'] = 1;
        }

        /*require_once("lib/securecookie/class.securecookie.php");

        $cookie = new SecureCookie($param['cookie']['key'],'VALSE_AUTOLOGIN',time()+5184000,'/','mvc.valse.com.my');
        $cookie->Del('Value');*/

        Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/login");
    }

    public function Access($access)
    {
        require_once('modules/dealer/dealer.model.php');

        // Load Model
        $start = dealer::Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        // 0 for public page, 1 for private page
        if ($access==0)
        {
            if ($_SESSION['dealer']['ID']!="")
            {
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/dashboard");
            }
        }
        else if ($access==1)
        {
            if ($_SESSION['dealer']['ID']=="")
            {
                // Store destination URL
                $_SESSION['dealer']['redirect_url'] = $_SERVER["REQUEST_URI"];

                // Sends user to login page if autologin cookie is verified? - Not implemented
                Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/login");
            }
            else
            {
                // Force password change if Prompt is enabled
                $constant = get_defined_constants(true);

                // Redirect if user is in dealer section but not in Password page
                if (($_SESSION['dealer']['Prompt']==1)&&($constant['user']['LOAD_ACTION']!="password")&&($constant['user']['LOAD_ACTION']!="passwordprocess")&&($constant['user']['LOAD_ACTION']!="logout"))
                {
                    Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/password");
                }
            }
        }
    }

    /*public function Autologin()
    {
        #echo $_SERVER['HTTP_USER_AGENT'];

        if ((constant("LOAD_SECTION")=='main')||(constant("LOAD_SECTION")=='dealer'))
        {
            if ($_SESSION['dealer']['ID']=="")
            {
                require_once('modules/dealer/dealer.model.php');

                // Load Model
                $start = dealer::Start();
                $loadModel = $this->prefix.__FUNCTION__;
                $param = $start->$loadModel($this->id);

                // Log user in if autologin cookie exists
                require_once("lib/securecookie/class.securecookie.php");

                $cookie = new SecureCookie($param['cookie']['key'],'VALSE_AUTOLOGIN',time()+5184000,'/','mvc.valse.com.my');
                $cookie_data = $cookie->GetObject();

                $start_verify = $this->Start();
                $param_verify = $start_verify->verifyCookie($cookie_data);

                if ($param_verify['verify']['count']==1)
                {
                    // Login user if autologin cookie is verified
                    // Set session data
                    $_SESSION['dealer']['ID'] = $param_verify['verify'][0]['ID'];
                    $_SESSION['dealer']['Username'] = $param_verify['verify'][0]['Username'];
                    $_SESSION['dealer']['Name'] = $param_verify['verify'][0]['Name'];
                    $_SESSION['dealer']['Prompt'] = $param_verify['content'][0]['Prompt'];


                    // Redirect to dashboard
                    Helper::redirect($param['config']['SITE_URL']."/dealer/");
                }
            }
        }
    }*/

	protected function Add()
	{
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,2);
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function AddProcess()
	{
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('Add');
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $_SESSION['admin']['dealer_add'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/edit/".$param['content_param']['newID']);
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/add/");
            }
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Edit()
	{
	    if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,3);
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            if ($param['content_param']['count']=="1")
            {
                $this->ReturnView($param, true);
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/index");
            }
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function EditProcess()
	{
	    if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('Update');
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $_SESSION['admin']['dealer_edit'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/edit/".$this->id);
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/edit/".$this->id);
            }
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Delete()
	{
	    if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,4);
        }
        else if ($this->section=='dealer')
        {
            Helper::redirect404();
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $_SESSION['admin']['dealer_delete'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/index");
            }
            else
            {
                Helper::redirect($param['config']['SITE_URL']."/admin/dealer/index");
            }
        }
        else if ($this->section=='dealer')
        {
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Export()
	{
		if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,1);
        }
        else if ($this->section=='dealer')
        {
            Helper::redirect404();
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
        }
        else if ($this->section=='dealer')
        {
        }
        else if ($this->section=='api')
        {
        }
	}
}
?>