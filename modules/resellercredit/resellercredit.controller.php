<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('member');
Core::requireController('reseller');

class ResellerCredit extends BaseController
{
	protected $controller_name = "resellercredit";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new ResellerCreditModel();
		return $model;
	}

	protected function Index()
	{

		if ($this->section=='member')
		{

			//Control Access


		Member::Access(1);

		}
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}
		if ($this->section=='reseller')
		{
			// Control Access
			Reseller::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function View()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}
	
	protected function BlockIndex() 
    {
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel(), false);
    }

	protected function Reseller()
	{

		if ($this->id=="")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/index");
		}

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

	protected function BlockAdd()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), false);
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

		$_SESSION['admin']['transaction_add'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/edit/".$param['content_param']['newID']);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/add/");
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/index");
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

		$_SESSION['admin']['transaction_edit'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/edit/".$this->id);
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

		$_SESSION['admin']['transaction_delete'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/resellercredit/index");
		}

	}

	protected function ResellerExport()
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

	protected function Deposit()
	{
		if ($this->section=='member')
		{
		Member::Access(1);


		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		//Check Access Permission
		Permission::Access($this->controller_name,2);
		}


		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function DepositProcess()
	{
		if ($this->section=='member')
		{
		Member::Access(1);


		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		//Check Access Permission
		Permission::Access($this->controller_name,2);
		}

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Submit');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		$_SESSION['admin']['transaction_add'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
            $message = "A new deposit has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message'];
            ResellerCredit::SendMail($message, $param);

			$param['status']['ok']="successd";
			Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/index/?param=".$param['status']['ok']);
		}
		else
		{
			$param['status']['ok']="failure";
			Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/index/?param=".$param['status']['ok']);
		}
	}

	protected function Transfer()
	{

		if ($this->section=='member')
		{
		Member::Access(1);


		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		//Check Access Permission
		Permission::Access($this->controller_name,2);
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function TransferProcess()
	{

		if ($this->section=='member')
		{
		Member::Access(1);


		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		//Check Access Permission
		Permission::Access($this->controller_name,2);
		}

		// // Validate Genuine Form Submission
		 CRUD::validateFormSubmit('Save');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		$_SESSION['admin']['transaction_add'] = $param['status'];

		// if ($param['valid']==='0') {
			// $param['status']['ok']="invalid";
			// Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/transfer/?param=".$param['status']['ok']);
		// }
        if ($param['status']['ok']=="1")
		{
	        $message = "A new transfer has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message'];
		    ResellerCredit::SendMail($message, $param);

			$param['status']['ok']="successt";
			Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/index/?param=".$param['status']['ok']);
		}
		else
		{
			$param['status']['ok']="failure";
			Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/index/?param=".$param['status']['ok']);
		}
	}

	protected function Withdrawal()
	{

		if ($this->section=='member')
		{
		Member::Access(1);


		}
        if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		//Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function WithdrawalProcess()
	{
		if ($this->section=='member')
		{
		Member::Access(1);


		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		//Check Access Permission
		Permission::Access($this->controller_name,2);
		}

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Submit');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		$_SESSION['admin']['transaction_add'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
            $message = "A new withdrawal has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message'];
            ResellerCredit::SendMail($message, $param);

			$param['status']['ok']="successw";
			Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/index/?param=".$param['status']['ok']);
		}
		else
		{
			$param['status']['ok']="failure";
			Helper::redirect($param['config']['SITE_DIR']."/member/resellercredit/index/?param=".$param['status']['ok']);
		}
	}

    protected function SendMail($message, $param)
    {
        $mailer = new BaseMailer();

        $mailer->From = $param['config']['EMAIL_SENDER'];
        $mailer->AddReplyTo($param['config']['TRX_EMAIL_TO'], $param['config']['COMPANY_NAME']);
        $mailer->FromName = $param['config']['COMPANY_NAME'];

        $mailer->Subject = '['.$param['config']['SITE_NAME'].'] ResellerCredit Request '.date('d-m-Y H:i:s');

        $mailer->AddAddress($param['config']['TRX_EMAIL_TO'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC1'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC2'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC3'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC4'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC5'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC6'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC7'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC8'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC9'], '');
        $mailer->AddAddress($param['config']['TRX_EMAIL_CC10'], '');
        #$mailer->AddCC('user@domain.com', 'User');
        #$mailer->AddBCC('abc@gmail.com', '');
        #$mailer->ConfirmReadingTo = 'user@domain.com';

        if ($param['content_param']['reseller_email']!="") {
            $mailer->AddAddress($param['content_param']['reseller_email'], '');
        }


        $mailer->IsHTML(true);
        $mailer->Body = $message;
        $mailer->AltBody = $message;

        $mailer->Send();

        $mailer->ClearAddresses();
        $mailer->ClearAttachments();
    }
}
?>