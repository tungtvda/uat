<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class Agent extends BaseController
{
	protected $controller_name = "agent";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new AgentModel();
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

        if ($this->section=='agent')
        {
            // Control Access
            $this->Access(1);

            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/dashboard");
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}
        
        protected function BulkUpdate()
    {
        if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,3);
        }
        
        if ($this->section=='agent')
        {
            // Control Access
            $this->Access(1);

            
        }
    
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
    }
        
        protected function Chat()
	{
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}

        if ($this->section=='agent')
        {
            // Control Access
            //$this->Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/agent/agent/chat");
        }
        
        if ($this->section=='main')
        {
            // Control Access
            //$this->Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/agent/agent/chat");
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}
        
        
        protected function Manage() 
    {
        if ($this->section=='admin') 
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,1);
        }
        
        if ($this->section=='agent')
        {
        // Control Access
        $this->Access(1);


        }

        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel($this->id), true);
    }
        
         protected function GetAgentData()
	{
	    if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
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
        else if ($this->section=='api')
        {
        }
	}
        
        protected function AgentList()
	{
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}

        if ($this->section=='agent')
        {
            // Control Access
            $this->Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/agent/agent/dashboard");
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}
        
        protected function Downline()
	{
            if ($this->section=='admin')
            {
                Helper::redirect404();
            }

            if ($this->section=='agent')
            {
                // Control Access
                $this->Access(1);


            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}
        
        protected function ProfileView()
	{
            if ($this->section=='admin')
            {
                Helper::redirect404();
            }

            if ($this->section=='agent')
            {
                // Control Access
                $this->Access(1);


            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function Report()
	{
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}

		if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}

        if ($this->section=='member')
        {
            // Control Access
            $this->Access(1);

            Helper::redirect($param['config']['SITE_DIR']."/member/agent/dashboard");
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

        $_SESSION['agent']['agent_profile'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['agent']['Name'] = $param['content']['Name'];

            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/profile");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/profile");
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

        $_SESSION['agent']['agent_password'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/logout");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/password");
        }
    }

    protected function Register()
    {
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

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['agent']['member_register'] = $param['status'];

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
            require_once('modules/agent/mail/agent.register.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/agent/mail/agent.register.txt.php');
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
            Helper::redirect($param['config']['SITE_DIR']."/member/agent/login/");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/member/agent/register/");
        }
    }

    protected function Login()
    {
        // Control Access
        //$this->Access(0);
        
        if($this->section == 'agent'){
            // Control Access
            $this->Access(0);
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function LoginProcess()
    {
        if($this->section == 'agent'){
            // Control Access
            $this->Access(0);
       
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        $_SESSION['agent']['agent_login'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['agent']['ID'] = $param['content'][0]['ID'];
            $_SESSION['agent']['Username'] = $param['content'][0]['Username'];
            $_SESSION['agent']['Name'] = $param['content'][0]['Name'];
            $_SESSION['agent']['TypeID'] = $param['content'][0]['TypeID'];
            $_SESSION['agent']['Prompt'] = $param['content'][0]['Prompt'];
            $_SESSION['agent']['operator']['ProfileID'] = $param['content'][0]['ProfileID'];
            if($_SESSION['agent']['operator']['ProfileID'] == '2')
            {
                $_SESSION['agent']['operator']['ProfileName'] = 'Operator';
            }
            elseif($_SESSION['agent']['operator']['ProfileID'] == '4')
            {
                $_SESSION['agent']['operator']['ProfileName'] = 'Analyst';
            }    
            
            $_SESSION['agent']['operator']['RowID'] = $param['content'][0]['rowID'];
            $_SESSION['agent']['operator']['Username'] = $param['content'][0]['operator'];
            $_SESSION['agent']['operator']['OperatorType'] = $param['content'][0]['OperatorType'];

            // Redirect to original destination URL if available
            if ($_SESSION['agent']['redirect_url']!="")
            {
                $redirect_url = $_SESSION['agent']['redirect_url'];
                unset($_SESSION['agent']['redirect_url']);

                // Redirect to original destination URL
                Helper::redirect($redirect_url);
            }
            else
            {
                // Redirect to dashboard
                Helper::redirect($param['config']['SITE_DIR']."/agent/");
            }
        }
        else
        {
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/login?username=".$param['login_param']['username']."&autologin=".$param['login_param']['autologin']);

            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/login");
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
        $param = $start->$loadModel();

        $_SESSION['agent']['agent_forgotpassword'] = $param['status'];

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
            require_once('modules/agent/mail/agent.forgotpasswordprocess.php');
            $htmlBody = ob_get_contents();
            ob_end_clean();

            ob_start();
            require_once('modules/agent/mail/agent.forgotpasswordprocess.txt.php');
            $txtBody = ob_get_contents();
            ob_end_clean();

            $mailer->IsHTML(true);
            $mailer->Body = $htmlBody;
            $mailer->AltBody = $txtBody;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();

            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/login");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/forgotpassword");
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
        if ($_SESSION['agent']['agent_password']!="")
        {
            $agent_password = $_SESSION['agent']['agent_password'];
        }

        // Destroy member session
        unset($_SESSION['agent']);

        if ($agent_password!="")
        {
            $_SESSION['agent']['agent_password'] = $agent_password;
        }
        else
        {
            $_SESSION['agent']['agent_logout']['ok'] = 1;
        }

        Helper::redirect($param['config']['SITE_DIR']."/agent/agent/login");
    }

    public function Access($access)
    {
        require_once('modules/agent/agent.model.php');

        // Load Model
        $start = Agent::Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
        // 0 for public page, 1 for private page
        if ($access==0)
        {
            if ($_SESSION['agent']['ID']!="")
            {
                Helper::redirect($param['config']['SITE_DIR']."/agent/agent/dashboard");
            }
        }
        else if ($access==1)
        {
            if ($_SESSION['agent']['ID']=="")
            {
                // Store destination URL
                $_SESSION['agent']['redirect_url'] = $_SERVER["REQUEST_URI"];

                // Sends user to login page if autologin cookie is verified? - Not implemented
                Helper::redirect($param['config']['SITE_DIR']."/agent/agent/login");
            }
            else
            {
                // Force password change if Prompt is enabled
                $constant = get_defined_constants(true);

                // Redirect if user is in Member section but not in Password page
                if (($_SESSION['agent']['Prompt']==1)&&($constant['user']['LOAD_ACTION']!="password")&&($constant['user']['LOAD_ACTION']!="passwordprocess")&&($constant['user']['LOAD_ACTION']!="logout"))
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/agent/password");
                }
            }
        }
    }

	protected function Add()
	{
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
                
                if ($this->section=='agent')
		{
		// Control Access
		$this->Access(1);

		
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function AddProcess()
	{	if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
                
                if ($this->section=='agent')
		{
                    // Control Access
                    $this->Access(1);

                    // Validate Genuine Form Submission
                    CRUD::validateFormSubmit('Add');
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();
            if ($this->section=='admin')
            {        
                    $_SESSION['admin']['agent_add'] = $param['status'];

                    if ($param['status']['ok']=="1")
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/admin/agent/edit/".$param['content_param']['newID']);
                    }
                    else
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/admin/agent/add/");
                    }
            }
            
            if ($this->section=='agent')
            {        
                    $_SESSION['agent']['agent_add'] = $param['status'];

                    if ($param['status']['ok']=="1")
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/edit/".$param['content_param']['newID']);
                    }
                    else
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/add/");
                    }
            } 
	}

	protected function Edit()
	{
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
		}
                
                if ($this->section=='agent')
		{
		// Control Access
		$this->Access(1);

		
		}
                
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
            if ($this->section=='admin')
            {
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/agent/index");
                }
            }
            
            if ($this->section=='agent')
            {
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/agent/editindex");
                }
            }
	}
        
        protected function EditIndex()
	{
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
		}
                
                if ($this->section=='agent')
		{
		// Control Access
		$this->Access(1);

		}
                
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        
            $this->ReturnView($param, true);
        
            
        
	}

	protected function EditProcess()
	{
        if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
                
                if ($this->section=='agent')
		{
		// Control Access
		$this->Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
                
                if($this->section == 'agent'){

                    $_SESSION['agent']['agent_edit'] = $param['status'];

                    if ($param['status']['ok']=="1")
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/edit/".$this->id);
                    }
                    else
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/edit/".$this->id);
                    }
                }
                
                if($this->section == 'admin'){

                    $_SESSION['admin']['agent_edit'] = $param['status'];

                    if ($param['status']['ok']=="1")
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/admin/agent/edit/".$this->id);
                    }
                    else
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/admin/agent/edit/".$this->id);
                    }
                }
	}

	protected function Delete()
	{
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,4);
		}
                
                if ($this->section=='agent')
		{
		// Control Access
		$this->Access(1);
		
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        $_SESSION['admin']['agent_delete'] = $param['status'];

            if ($this->section=='admin')
            {
                    if ($param['status']['ok']=="1")
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/admin/agent/index");
                    }
                    else
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/admin/agent/index");
                    }
            }
            
            if ($this->section=='agent')
            {
                    if ($param['status']['ok']=="1")
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/editindex");
                    }
                    else
                    {
                            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/editindex");
                    }
            }
	}

	protected function ReportExport()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		//echo $this->prefix.__FUNCTION__;
		//exit;
		$param = $start->$loadModel($this->id);

		Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
	}

	protected function Export()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
	}

	/*protected function BlockHomeIndex()
    {
        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel($this->id), false);
    }*/

}
?>