<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('agent');
//Core::requireController('agent');

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

        if ($this->section=='api')
        {
            //echo 'hi api';
        }

		if ($this->section=='agent')
        {
            // Control Access
            Agent::Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/member/reseller/dashboard");
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
                else if ($this->section=='agent')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='api')
                {
                }

	}
        
        protected function BankList()
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

        if ($this->section=='api')
        {
            //echo 'hi api';
        }

		if ($this->section=='agent')
        {
            // Control Access
            Agent::Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/member/reseller/dashboard");
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
                else if ($this->section=='agent')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='api')
                {
                }

	}

        protected function AgentMember()
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

		if ($this->section=='agent')
        {
            // Control Access
            Agent::Access(1);

            //Helper::redirect($param['config']['SITE_DIR']."/member/reseller/dashboard");
        }



		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

        protected function Group()
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
        if($this->section == 'member'){

            // Control Access
            $this->Access(1);

        }

        if($this->section == 'agent'){

            // Control Access
            Agent::Access(1);

        }


        if($this->section == 'api'){

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        //$this->ReturnView($start->$loadModel(), true);

        $param = $start->$loadModel();

                if ($this->section=='main')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='admin')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='member')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='agent')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='api')
                {
                }


    }
    
    protected function GuideImage()
    {
        if($this->section == 'member'){

            // Control Access
            $this->Access(1);

        }

        if($this->section == 'agent'){

            // Control Access
            Agent::Access(1);

        }


        if($this->section == 'api'){

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        //$this->ReturnView($start->$loadModel(), true);

        $param = $start->$loadModel();

                if ($this->section=='main')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='admin')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='member')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='agent')
                {
                    $this->ReturnView($param, true);
                }
                else if ($this->section=='api')
                {
                }


    }

    protected function ProfileProcess()
    {
        if($this->section == 'member')
        {
            // Control Access
            $this->Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'ProfileTrigger');
        }

        if($this->section == 'api')
        {

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if($this->section == 'member')
        {

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

        if($this->section == 'api')
        {


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
        if($this->section=='member')
        {
            // Control Access
            $this->Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'PasswordTrigger');

        }

        if($this->section=='api')
        {


        }



        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if($this->section=='member')
        {

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

        if($this->section=='api')
        {


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
        if ($this->section=='member')
        {

            // Control Access
            $this->Access(0);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'RegisterTrigger');

        }

        if ($this->section=='api')
        {

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if ($this->section=='member')
        {

        $_SESSION['member']['member_register'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            //Debug::displayArray($param);
            //exit;
            // Send mail to user
            $mailer = new BaseMailer();
            $mailer->CharSet = 'UTF-8';

            $mailer->From = $param['reseller']['Email'];
            $mailer->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['reseller']['Name']);
            $mailer->FromName = $param['reseller']['Name'];

            $mailer->Subject = "Welcome to ".$param['reseller']['Name']."!";

            $mailer->AddAddress($param['content']['Email'], '');
            //$mailer->AddBCC($param['reseller']['Email'], '');
            $mailer->AddAddress($param['reseller']['Email'], '');

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


            $agentmail = new BaseMailer();
            $agentmail->CharSet = 'UTF-8';

            $agentmail->From = $param['reseller']['Email'];
            $agentmail->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['reseller']['Name']);
            $agentmail->FromName = $param['reseller']['Name'];

            $agentmail->Subject = "Welcome to ".$param['reseller']['Name']."!";


            $agentmail->AddAddress($param['reseller']['PlatformEmail1'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail2'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail3'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail4'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail5'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail6'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail7'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail8'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail9'], '');
            $agentmail->AddAddress($param['reseller']['PlatformEmail10'], '');

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

            // Redirect User to Login Page
            Helper::redirect($param['config']['SITE_URL']."/member/member/login/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
        }
        else
        {
            Helper::redirect($param['config']['SITE_URL']."/member/member/register/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
        }

        }

        if ($this->section=='api')
        {

        }
    }

    protected function Login()
    {
        /*if($_SERVER['REMOTE_ADDR']=='60.53.185.116'){
           echo urlencode($_GET['rid']);
        }*/
        //Debug::displayArray(urlencode($_GET['rid']));
        //exit;

        //if(isset($_SESSION['reseller_code'])===TRUE && empty($_SESSION['member']['ID'])===FALSE)
        //{

            //unset($_SESSION['member']);
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/login/?rid=".urlencode($_GET['rid']));
        //}

        // Control Access
        $this->Access(0);

        if($_GET['rid']=='')
        {
            exit();
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function LoginProcess()
    {

        if ($this->section=='member')
        {

        // Validate Genuine Form Submission
        CRUD::validateFormSubmit(1,'LoginTrigger');

        // Control Access
        $this->Access(0);

        }

        if ($this->section=='api')
        {



        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if ($this->section=='member')
        {

        $_SESSION['member']['member_login'] = $param['status'];


        if ($param['status']['ok']=="1")
        {
            // Set session data
            $_SESSION['member']['ID'] = $param['content'][0]['ID'];
            $_SESSION['member']['Username'] = $param['content'][0]['Username'];
            $_SESSION['member']['Name'] = $param['content'][0]['Name'];
            $_SESSION['member']['Prompt'] = $param['content'][0]['Prompt'];
		    $_SESSION['member']['MobileNo'] = $param['content'][0]['MobileNo'];

            if($_SESSION['member']['ID']=='10695'){

                if ($param['activation_code']!='1')
                {
                    $_SESSION['member']['activation_code'] = 'Unverified';

                    // Redirect to activation
                    Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");
                }

                // Redirect to original destination URL if available
                elseif ($_SESSION['member']['redirect_url']!="")
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
                /*if ($param['activation_code']!='1')
                {
                    $_SESSION['member']['activation_code'] = 'Unverified';

                    // Redirect to activation
                    Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");
                }

                // Redirect to original destination URL if available
                else*/if ($_SESSION['member']['redirect_url']!="")
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

        }
        else
        {
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/login?username=".$param['login_param']['username']."&autologin=".$param['login_param']['autologin']);
            //Helper::redirect($param['config']['SITE_DIR']."/member/member/register/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
            //echo  $_SESSION['reseller_code'];
            //exit;
            Helper::redirect($param['config']['SITE_DIR']."/member/member/login/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
        }

        }

        if ($this->section=='api')
        {



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

        if($this->section=='member')
        {

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('1','SubmitTrigger');
        }

        if($this->section=='api')
        {

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        //$_SESSION['member']['member_login'] = $param['status'];
        if($this->section=='member')
        {

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

        if($this->section=='api')
        {

        }

    }

	protected function ResendActivationProcess()
    {
        if($this->section=='member')
        {
            // Control Access
            //$this->Access(0);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'ResendActivationTrigger');

        }

        if($this->section=='api')
        {

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if($this->section=='member')
        {

            $_SESSION['resend'] = "1";
            Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");

        }

        if($this->section=='api')
        {

        }


    }

	protected function UpdateActivationProcess()
    {
        if($this->section=='member')
        {
            // Control Access
            //$this->Access(0);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1','UpdateTrigger');

        }

        if($this->section=='api')
        {

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if($this->section=='member')
        {

            $_SESSION['update'] = $param['status'];
            Helper::redirect($param['config']['SITE_DIR']."/member/member/activation");

        }

        if($this->section=='api')
        {

        }


    }

    protected function ForgotPassword()
    {
        // Control Access
        $this->Access(0);
        
        if($_GET['rid']=='')
        {
            exit();
            Helper::redirect404();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), true);
    }

    protected function ForgotPasswordProcess()
    {
        if($this->section=='member')
        {

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit(1,'FPTrigger');

            // Honey Pot Captcha
            CRUD::validateFormSubmit('','HPot',TRUE);
        }

        if($this->section=='api')
        {

        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();

        if($this->section=='member')
        {

            $_SESSION['member']['member_forgotpassword'] = $param['status'];

            if ($param['status']['ok']=="1")
            {
                // Send mail to user
                $mailer = new BaseMailer();
                $mailer->CharSet = 'UTF-8';

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

                Helper::redirect($param['config']['SITE_DIR']."/member/member/login/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
            }
            else
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/member/forgotpassword?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
                
            }

        }

        if($this->section=='api')
        {


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
        //unset($_SESSION['reseller_code']);

        if ($member_password!="")
        {
            $_SESSION['member']['member_password'] = $member_password;
        }
        else
        {
            $_SESSION['member']['member_logout']['ok'] = 1;
        }

        Helper::redirect($param['config']['SITE_DIR']."/member/member/login/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
    }
    
    protected function OneAgentLogout()
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
        //unset($_SESSION['webExist']);
        //unset($_SESSION['reseller_code']);

        if ($member_password!="")
        {
            $_SESSION['member']['member_password'] = $member_password;
        }
        else
        {
            $_SESSION['member']['member_logout']['ok'] = 1;
        }
        $oneAgentLink = $_SESSION['oneAgentLink'];
        $oneAgentLinkRid = urlencode($_SESSION['oneAgentLinkRid']);
        unset($_SESSION['oneAgentLink']);
        unset($_SESSION['oneAgentLinkRid']);

        Helper::redirect($param['config']['SITE_DIR'].'/'.$oneAgentLink."/?rid=".$oneAgentLinkRid);
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
                Helper::redirect($param['config']['SITE_DIR']."/member/member/login/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
            }
            else
            {
                if($param['content']=='0')
                {
                    // Destroy member session
                    unset($_SESSION['member']);
                    // Store destination URL
                    $_SESSION['disabled'] = '1';
                    Helper::redirect($param['config']['SITE_DIR']."/member/member/login");
                }

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
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
            }

            if($this->section == 'agent')
            {
		// Control Access
		Agent::Access(1);


            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function AddProcess()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
            }

            if($this->section == 'agent')
            {
		// Control Access
		Agent::Access(1);

                // Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');


            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();
                if($this->section == 'admin')
                {
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

                if($this->section == 'agent')
                {
                        $_SESSION['agent']['member_add'] = $param['status'];

                        if ($param['status']['ok']=="1")
                        {
                                Helper::redirect($param['config']['SITE_DIR']."/agent/member/edit/".$param['content_param']['newID'].'?apc='.$param['apc']);
                        }
                        else
                        {
                                Helper::redirect($param['config']['SITE_DIR']."/agent/member/add".'?apc='.$param['apc']);
                        }
                }
	}

        protected function GroupAdd()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function GroupAddProcess()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();
                if($this->section == 'admin')
                {
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

                if($this->section == 'agent')
                {
                        $_SESSION['agent']['member_add'] = $param['status'];

                        if ($param['status']['ok']=="1")
                        {
                                Helper::redirect($param['config']['SITE_DIR']."/agent/member/groupedit/".$param['content_param']['newID']);
                        }
                        else
                        {
                                Helper::redirect($param['config']['SITE_DIR']."/agent/member/groupadd/");
                        }
                }
	}


	protected function Edit()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
            }

            if($this->section == 'agent')
            {
		// Control Access
		Agent::Access(1);


            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section == 'admin')
            {
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/member/index");
                }
            }

            if($this->section == 'agent')
            {
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/member/index");
                }
            }
	}

	protected function EditProcess()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
            }

            if($this->section == 'agent')
            {
		// Control Access
		Agent::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section == 'admin')
            {
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

            if($this->section == 'agent')
            {
		$_SESSION['agent']['member_edit'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/edit/".$this->id.'?apc='.$param['apc']);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/edit/".$this->id.'?apc='.$param['apc']);
		}
            }
	}

        protected function GroupEdit()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section == 'admin')
            {
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/member/index");
                }
            }

            if($this->section == 'agent')
            {
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/member/group");
                }
            }
	}

	protected function GroupEditProcess()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section == 'admin')
            {
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

            if($this->section == 'agent')
            {
		$_SESSION['agent']['member_edit'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/groupedit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/groupedit/".$this->id);
		}
            }
	}

	protected function Delete()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,4);
            }

            if($this->section == 'agent')
            {
		// Control Access
		Agent::Access(1);


            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section == 'admin')
            {
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

            if($this->section == 'agent')
            {
                $_SESSION['agent']['member_delete'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/index");
		}
            }
	}

        protected function GroupDelete()
	{
            if($this->section == 'admin')
            {
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,4);
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section == 'admin')
            {
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

            if($this->section == 'agent')
            {
                $_SESSION['agent']['member_delete'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/group");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/member/group");
		}
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