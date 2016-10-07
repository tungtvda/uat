<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('dealer');

class Merchant extends BaseController
{
	protected $controller_name = "merchant";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new MerchantModel();
		return $model;
	}

	protected function Index()
	{
        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}
        else if ($this->section=='merchant')
		{
            // Control Access
            $this->Access(1);

            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/dashboard");
        }
		else if ($this->section=='dealer')
		{
			// Control Access
            //Dealer::Access(0);

            //Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/dashboard");
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
            $this->ReturnView($param, true);
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='merchant')
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
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='merchant')
        {
            Helper::redirect404();
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
            if ($param['content_param']['count']=="1")
            {
                $this->ReturnView($param, true);
            }
            else
            {
                Helper::redirect404();
            }
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='merchant')
        {
        }
        else if ($this->section=='api')
        {
        }
	}
	
	
	protected function QRView()
	{
		if ($_GET['key']!='aseanfnb')
        {
        	Helper::redirect404();
        }
		
		
        if ($this->section=='main')
        {
        	
        }
        else if ($this->section=='admin')
        {
            Helper::redirect404();
        }
        else if ($this->section=='merchant')
        {
            Helper::redirect404();
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
            if ($param['content_param']['count']=="1")
            {
                $this->ReturnView($param, FALSE);
            }
            else
            {
                Helper::redirect404();
            }
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='merchant')
        {
        }
        else if ($this->section=='api')
        {
        }
	}
	
	protected function StandardProfileUpgradeProcess() 

    {                               

        // Control Access

        #$this->Access(1);

        

        // Load Model

        $start = $this->Start();                

        $loadModel = $this->prefix.__FUNCTION__;

        $param = $start->$loadModel($this->id);



        $this->ReturnView($param, true);

    }
	
	protected function PremierProfileUpgradeProcess() 

    {                               

        // Control Access

        #$this->Access(1);

        

        // Load Model

        $start = $this->Start();                

        $loadModel = $this->prefix.__FUNCTION__;

        $param = $start->$loadModel($this->id);



        $this->ReturnView($param, true);

    }

    protected function Dashboard()
    {
    	unset($_SESSION['DealerMerchant']);
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
        $param = $start->$loadModel($this->id);

        $_SESSION['merchant']['merchant_profile'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['merchant']['Name'] = $param['content']['Name'];

            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/profile");
        }
        else
        {
            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/profile");
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
        $param = $start->$loadModel($this->id);

        $_SESSION['merchant']['merchant_password'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/logout");
        }
        else
        {
            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/password");
        }
    }

    protected function Register()
    {
        // Disallow merchant self registration
        if($this->section == 'merchant'){
        //exit();

        // Control Access
        //$this->Access(0);
		}
		if($this->section == 'admin'){
        //exit();

        // Control Access
        //Staff::Access(0);
		}
		if($this->section == 'dealer'){
        //exit();

        // Control Access
        //$this->Access(0);
		}
        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function RegisterProcess()
    {
    	if($this->section == 'admin'){
        // Control Access
        $this->Access(0);

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit('Submit');
		}

		if($this->section == 'merchant'){
        // Control Access
        //Merchant::Access(0);

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit('Submit');
		}
		
		if($this->section == 'dealer'){
        // Control Access
        Dealer::Access(0);

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit('Submit');
		}
		
        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        $_SESSION['merchant']['merchant_register'] = $param['status'];

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
            require_once('modules/merchant/mail/merchant.register.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/merchant/mail/merchant.register.txt.php');
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
            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/login/");
        }
        else
        {
            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/register/");
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
        $param = $start->$loadModel($this->id);

        $_SESSION['merchant']['merchant_login'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['merchant']['ID'] = $param['content'][0]['ID'];
            $_SESSION['merchant']['Username'] = $param['content'][0]['Username'];
			$_SESSION['merchant']['DealerID'] = $param['content'][0]['DealerID'];
            $_SESSION['merchant']['Name'] = $param['content'][0]['Name'];
			$_SESSION['merchant']['Type'] = $param['content'][0]['TypeID'];
            $_SESSION['merchant']['Prompt'] = $param['content'][0]['Prompt'];
			$_SESSION['merchant']['Expiry'] = $param['content'][0]['Expiry'];
            $_SESSION['merchant']['ExpiryText'] = Helper::dateSQLToDisplay($param['content'][0]['Expiry']);            


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
            if ($_SESSION['merchant']['redirect_url']!="")
            {
                $redirect_url = $_SESSION['merchant']['redirect_url'];
                unset($_SESSION['merchant']['redirect_url']);

                // Redirect to original destination URL
                Helper::redirect($redirect_url);
            }
            else
            {
                // Redirect to dashboard
                Helper::redirect($param['config']['SITE_URL']."/merchant/");
            }
        }
        else
        {
            //Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/login?username=".$param['login_param']['username']."&autologin=".$param['login_param']['autologin']);

            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/login");
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
        CRUD::validateFormSubmit('','HPot',TRUE);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        $_SESSION['merchant']['merchant_forgotpassword'] = $param['status'];

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
            require_once('modules/merchant/mail/merchant.forgotpasswordprocess.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/merchant/mail/merchant.forgotpasswordprocess.txt.php');
            $txtBody = ob_get_contents();
            ob_end_clean();

            $mailer->IsHTML(true);
            $mailer->Body = $htmlBody;
            $mailer->AltBody = $txtBody;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();

            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/login");
        }
        else
        {
            Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/forgotpassword");
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
        if ($_SESSION['merchant']['merchant_password']!="")
        {
            $merchant_password = $_SESSION['merchant']['merchant_password'];
        }

        // Destroy merchant session
        unset($_SESSION['merchant']);

        if ($merchant_password!="")
        {
            $_SESSION['merchant']['merchant_password'] = $merchant_password;
        }
        else
        {
            $_SESSION['merchant']['merchant_logout']['ok'] = 1;
        }

        /*require_once("lib/securecookie/class.securecookie.php");

        $cookie = new SecureCookie($param['cookie']['key'],'VALSE_AUTOLOGIN',time()+5184000,'/','mvc.valse.com.my');
        $cookie->Del('Value');*/

        Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/login");
    }

    public function Access($access)
    {
        require_once('modules/merchant/merchant.model.php');

        // Load Model
        $start = Merchant::Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        // 0 for public page, 1 for private page
        if ($access==0)
        {
            if ($_SESSION['merchant']['ID']!="")
            {
                Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/dashboard");
            }
        }
        else if ($access==1)
        {
            if ($_SESSION['merchant']['ID']=="")
            {
                // Store destination URL
                $_SESSION['merchant']['redirect_url'] = $_SERVER["REQUEST_URI"];

                // Sends user to login page if autologin cookie is verified? - Not implemented
                Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/login");
            }
            else
            {
                // Force password change if Prompt is enabled
                $constant = get_defined_constants(true);

                // Redirect if user is in Merchant section but not in Password page
                if (($_SESSION['merchant']['Prompt']==1)&&($constant['user']['LOAD_ACTION']!="password")&&($constant['user']['LOAD_ACTION']!="passwordprocess")&&($constant['user']['LOAD_ACTION']!="logout"))
                {
                    Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/password");
                }
            }
        }
    }

    /*public function Autologin()
    {
        #echo $_SERVER['HTTP_USER_AGENT'];

        if ((constant("LOAD_SECTION")=='main')||(constant("LOAD_SECTION")=='merchant'))
        {
            if ($_SESSION['merchant']['ID']=="")
            {
                require_once('modules/merchant/merchant.model.php');

                // Load Model
                $start = Merchant::Start();
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
                    $_SESSION['merchant']['ID'] = $param_verify['verify'][0]['ID'];
                    $_SESSION['merchant']['Username'] = $param_verify['verify'][0]['Username'];
                    $_SESSION['merchant']['Name'] = $param_verify['verify'][0]['Name'];
                    $_SESSION['merchant']['Prompt'] = $param_verify['content'][0]['Prompt'];


                    // Redirect to dashboard
                    Helper::redirect($param['config']['SITE_URL']."/merchant/");
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
		else if ($this->section=='dealer')
		{
			// Control Access
			//Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,2);
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
		 else if ($this->section=='dealer')
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
		else if ($this->section=='dealer')
        {
            // Control Access
            //Dealer::Access(1);

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
	        $_SESSION['admin']['merchant_add'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchant/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchant/add/");
			}
        }
		else if ($this->section=='dealer')
        {
	        $_SESSION['dealer']['merchant_add'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchant/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchant/add/");
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
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
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
	            Helper::redirect($param['config']['SITE_URL']."/admin/merchant/index");
	        }
        }
		else if ($this->section=='dealer')
        {
	        if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/dealer/merchant/index");
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
		else if ($this->section=='dealer')
		{
			// Control Access
			//Dealer::Access(1);

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
			$_SESSION['admin']['merchant_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchant/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchant/edit/".$this->id);
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['merchant_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchant/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchant/edit/".$this->id);
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
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,4);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,4);
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
	        $_SESSION['admin']['merchant_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchant/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchant/index");
			}
        }
		else if ($this->section=='merchant')
        {
	        $_SESSION['merchant']['merchant_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/index");
			}
        }
		else if ($this->section=='dealer')
        {
	        $_SESSION['dealer']['dealer_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/dealer/index");
			}
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
        else if ($this->section=='api')
        {
        }
	}
	
	
	protected function CronCheck() 
    {
        if ($_GET['key']!="aseanfnb")
        {
            exit();
			
        }
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);        
    }
	
}
?>