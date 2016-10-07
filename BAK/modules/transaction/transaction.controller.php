<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('member');
Core::requireController('agent');

class Transaction extends BaseController
{
	protected $controller_name = "transaction";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new TransactionModel();
		return $model;
	}

    protected function HTMLHeaderBottom()
	{
        if ($this->section=='api')
		{
		}
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
		if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);
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
        else if ($this->section=='member')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Index()
	{
        if ($this->section=='api')
		{
		}
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
		if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);
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
        else if ($this->section=='member')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

    protected function Group()
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
		if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

    protected function History()
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
		if ($this->section=='agent')
		{
			// Control Access
            Agent::Access(1);
		}

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
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function Reseller()
	{
		if ($this->id=="")
		{
			#Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index");
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

    protected function Agent()
	{
		if ($this->id=="")
		{
			#Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index");
		}

        if ($this->section=="admin")
        {
		    // Control Access
			Staff::Access(1);

		    // Check Access Permission
			Permission::Access($this->controller_name,1);
        }

        if ($this->section=="agent")
        {
            // Control Access
            Agent::Access(1);
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

    protected function AffiliatedReporting()
	{

		if ($this->id=="")
		{
			#Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index");
		}
        if ($this->section=="admin")
        {
            // Control Access
			Staff::Access(1);

            // Check Access Permission
			Permission::Access($this->controller_name,1);
        }
        if ($this->section=="agent")
        {
            // Control Access
            Agent::Access(1);
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function Add()
	{
        if ($this->section=="admin")
        {
    		// Control Access
    		Staff::Access(1);

    		// Check Access Permission
    		Permission::Access($this->controller_name,2);
        }
        if ($this->section=="agent")
        {
    		// Control Access
    		Agent::Access(1);
        }

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
        if ($this->section=="admin")
        {
    		// Control Access
    		Staff::Access(1);

    		// Validate Genuine Form Submission
    		CRUD::validateFormSubmit('Add');
        }

        if ($this->section=="agent")
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

        if ($this->section=="admin")
        {
    		$_SESSION['admin']['transaction_add'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/edit/".$param['content_param']['newID']);
    		}
    		else
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/add/");
    		}
        }

        if ($this->section=="agent")
        {
    		$_SESSION['agent']['transaction_add'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/edit/".$param['content_param']['newID'].'?apc='.$param['apc']);
    		}
    		else
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/add?apc=".$param['apc']);
    		}
        }
	}

	protected function Edit()
	{
        if ($this->section=="admin")
        {
    		// Control Access
    		Staff::Access(1);

    		// Check Access Permission
    		Permission::Access($this->controller_name,3);
        }

        if ($this->section=="agent")
        {
    		// Control Access
    		Agent::Access(1);
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=="admin")
        {
            if ($param['content_param']['count']=="1")
            {
                $this->ReturnView($param, true);
            }
            else
            {
                Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index");
            }
        }
        if ($this->section=="agent")
        {
            if ($param['content_param']['count']=="1")
            {
                $this->ReturnView($param, true);
            }
            else
            {
                Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/index");
            }
        }
	}

    protected function QuickEdit()
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
    		Agent::Access(1);
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), false);
	}

    protected function QuickEditProcess()
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
            Agent::Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('Update');
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

        if ($this->section=='admin')
        {
            if ($param['status']['ok']=="1")
            {
                $_SESSION['admin']['quick_edit'] = "succeed";

                Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index?page=".$param['pagination']."&#".$this->id);
            }
            else
            {
                $_SESSION['admin']['quick_edit'] = "failed";

                Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index?page=".$param['pagination']."&#".$this->id);
            }
        }

        if ($this->section=='agent')
        {
            if ($param['status']['ok']=="1")
            {
                $_SESSION['agent']['quick_edit'] = "succeed";

                if ($param['pagetype'] == 'index')
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/index?page=".$param['pagination']."&#".$this->id);
                }

                if ($param['pagetype'] == 'group')
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/group?page=".$param['pagination']."&#".$this->id);
                }
            }
            else
            {
                $_SESSION['agent']['quick_edit'] = "failed";

                if ($param['pagetype'] == 'index')
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/index?page=".$param['pagination']."&#".$this->id);
                }

                if ($param['pagetype'] == 'group')
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/group?page=".$param['pagination']."&#".$this->id);
                }
            }
        }
	}

	protected function EditProcess()
	{
        if ($this->section=="admin")
        {
    		// Control Access
    		Staff::Access(1);

    		// Validate Genuine Form Submission
    		CRUD::validateFormSubmit('Update');
        }

        if ($this->section=="agent")
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

        if ($this->section=="admin")
        {
    		$_SESSION['admin']['transaction_edit'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/edit/".$this->id);
    		}
    		else
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/edit/".$this->id);
    		}
        }

        if ($this->section=="agent")
        {
    		$_SESSION['agent']['transaction_edit'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/edit/".$this->id.'?apc='.$param['apc']);
    		}
    		else
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/edit/".$this->id.'?apc='.$param['apc']);
    		}
        }
	}

	protected function Delete()
	{
        if ($this->section=="admin")
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

        if ($this->section=="admin")
        {
            $_SESSION['admin']['transaction_delete'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index");
    		}
    		else
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/admin/transaction/index");
    		}
        }

        if ($this->section=="agent")
        {
    		$_SESSION['agent']['transaction_delete'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/index");
    		}
    		else
    		{
    			Helper::redirect($param['config']['SITE_DIR']."/agent/transaction/index");
    		}
        }
	}

	protected function ResellerExport()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
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

        if ($this->section=='api')
		{
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
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
        else if ($this->section=='api')
        {
        }
	}

    protected function Search()
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

        if ($this->section=='api')
		{
		}

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
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
        else if ($this->section=='api')
        {
        }
	}

	protected function DepositProcess()
	{
		if ($this->section=='member')
		{
    		Member::Access(1);

            // Validate Genuine Form Submission
    		CRUD::validateFormSubmit('1', 'DepositTrigger');

            if (($_POST['TransferAmount'] < '10')||($_POST['DepositAmount'] < '10'))
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=failure");
            }
		}

		if ($this->section=='admin')
		{
    		// Control Access
    		Staff::Access(1);

    		//Check Access Permission
    		Permission::Access($this->controller_name,2);
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
            $_SESSION['admin']['transaction_add'] = $param['status'];

            if ($_POST['TransferAmount']!='')
            {
                if ($param['status_deposit']['ok_deposit']=="1" && $param['status_transfer']['ok_transfer']=="1")
        		{
                    $message_deposit = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';
                    $message_transfer = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';

                    if ($param['agent_type'] == '1')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';
                    }
                    else if ($param['agent_type'] == '2')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';
                    }

                    $message_deposit .= "A new deposit has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message_deposit'].$message_deposit_account;

                    $message_transfer .= "A new transfer has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message_transfer'].$message_transfer_account;

                    Transaction::SendMail($message_deposit, $param);
                    Transaction::SendMail($message_transfer, $param);

                    $param['status_deposit']['ok_deposit']="successd";
                    $param['status_transfer']['ok_transfer']="successt";

                    Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                }

                if ($param['status_deposit']['ok_deposit']=="1" && $param['status_transfer']['ok_transfer']!="1")
                {
                    $message_deposit = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';
                    $message_transfer = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';

                    if ($param['agent_type'] == '1')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';
                    }
                    else if ($param['agent_type'] == '2')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;"     href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';
                    }

                    $message_deposit .= "A new deposit has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message_deposit'].$message_deposit_account;

                    Transaction::SendMail($message_deposit, $param);

                    $param['status_deposit']['ok_deposit']="successd";
                    $param['status_transfer']['ok_transfer']="failure";

                    Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                }

                if ($param['status_deposit']['ok_deposit']!="1" && $param['status_transfer']['ok_transfer']=="1")
                {
                    $message_deposit = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';
                    $message_transfer = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';

                    if ($param['agent_type'] == '1')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';
                    }
                    else if ($param['agent_type'] == '2')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';
                    }

                    $message_transfer .= "A new transfer has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message_transfer'].$message_transfer_account;

                    Transaction::SendMail($message_transfer, $param);

                    $param['status_deposit']['ok_deposit']="failure";
                    $param['status_transfer']['ok_transfer']="successt";

                    Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                }

        		if ($param['status_deposit']['ok_deposit']!="1" && $param['status_transfer']['ok_transfer']!="1")
        		{
                    $param['status_deposit']['ok_deposit']="failure";
                    $param['status_transfer']['ok_transfer']="failure";

                    Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit'].'&paramtransfer='.$param['status_transfer']['ok_transfer']);
                }
            }

            if ($_POST['TransferAmount']=='')
            {
                if ($param['status_deposit']['ok_deposit']=="1")
                {

                    $message_deposit = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';
                    $message_transfer = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';

                    if ($param['agent_type'] == '1')
                    {
                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';
                    }
                    else if ($param['agent_type'] == '2')
                    {

                        $message_deposit_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';

                        $message_transfer_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';
                    }

                    $message_deposit .= "A new deposit has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message_deposit'].$message_deposit_account;

                    Transaction::SendMail($message_deposit, $param);

                    $param['status_deposit']['ok_deposit']="successd";
                    Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit']);
        		}
        		else
        		{
                    $param['status_deposit']['ok_deposit']="failure";
                    Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramdeposit=".$param['status_deposit']['ok_deposit']);
                }
            }
        }

        if ($this->section=='api')
		{
        }
	}

	protected function Transfer()
	{
		if ($this->section=='member')
		{
			Member::Access(1);
 		}
 		if ($this->section=='api')
        {
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
		else if  ($this->section=='api')
        {
		}
	}

	protected function TransferProcess()
	{
        if ($this->section=='member')
        {
            Member::Access(1);

            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'TransferTrigger');

            // Transfer minimum amount is 10
            if ($_POST['Amount'] < '10')
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=failure");
            }

            // Disallow product to product
            if (($_POST['TransferFrom']!='30')&&( $_POST['TransferTo']!='30'))
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=failure");
            }

            // Disallow main wallet to main wallet
            if (($_POST['TransferFrom']=='30')&&( $_POST['TransferTo']=='30'))
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=failure");
            }

            // Disallow empty values
            if (($_POST['TransferFrom']=='')||( $_POST['TransferTo']!=''))
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=failure");
            }

            // Disallow same product to same product, MW to MW
            if ($_POST['TransferFrom']==$_POST['TransferTo'])
            {
                Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=failure");
            }
        }

        if ($this->section=='api')
        {
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
		$param = $start->$loadModel();

        if ($this->section=='member')
		{
            $_SESSION['admin']['transaction_add'] = $param['status'];

    		/*if ($param['valid']==='0') {
                $param['status']['ok']="invalid";
    			Helper::redirect($param['config']['SITE_DIR']."/member/transaction/transfer/?param=".$param['status']['ok']);
    		}*/

            if ($param['status']['ok']=="1")
            {
                $message = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';

                if ($param['agent_type'] == '1')
                {
                    $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';
                }
                else if ($param['agent_type'] == '2')
                {
                    $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';
                }

    	        $message .= "A new transfer has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message'].$message_account;

    		    Transaction::SendMail($message, $param);

    			$param['status']['ok']="successt";
    			Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=".$param['status']['ok']);
    		}
    		else
    		{
    			$param['status']['ok']="failure";
    			Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?paramtransfer=".$param['status']['ok']);
    		}
        }

        if ($this->section=='api')
		{
        }
	}

	protected function Withdrawal()
	{
        if ($this->section=='member')
        {
            Member::Access(1);
        }

        if ($this->section=='api')
        {
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
        else if ($this->section=='api')
        {
        }
	}

	protected function WithdrawalProcess()
	{
		if ($this->section=='member')
		{
    		Member::Access(1);

            // Validate Genuine Form Submission
    		CRUD::validateFormSubmit('1', 'WithdrawalTrigger');
		}

		if ($this->section=='admin')
		{
    		// Control Access
    		Staff::Access(1);

    		//Check Access Permission
    		Permission::Access($this->controller_name,2);
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
            $_SESSION['admin']['transaction_add'] = $param['status'];

            if ($param['status']['ok']=="1")
    		{
                $message = '<tr><td align="left"><img src="'.$param['config']['SITE_URL'].$_SESSION['agent']['Logo'].'" /></td></tr>';

                if ($param['agent_type'] == '1')
                {
                    $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['Company'].'">'.$param['agent']['Company'].'</a>.</td></tr>';
                }
                else if ($param['agent_type'] == '2')
                {
                    $message_account = '<tr><td>'.Helper::translate("To access your account, please visit", "member-mail-transaction").' <a style="color:#c00;" href="'.$param['agent']['agent_parent']['Company'].'">'.$param['agent']['agent_parent']['Company'].'</a>.</td></tr>';
                }

                $message .= "A new withdrawal has been requested. (Member: ".$_SESSION['member']['Name']." - ".$_SESSION['member']['Username'].")".$param['message'].$message_account;

                Transaction::SendMail($message, $param);

    			$param['status']['ok']="successw";
    			Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?param=".$param['status']['ok']);
    		}
    		else
    		{
    			$param['status']['ok']="failure";
    			Helper::redirect($param['config']['SITE_DIR']."/member/transaction/index/?param=".$param['status']['ok']);
    		}
        }

        if ($this->section=='api')
        {
        }
	}

    protected function SendMail($message, $param)
    {
        //Debug::displayArray($param);
        //exit;

        $param['agent']['Company'] = str_replace("http://", "", $param['agent']['Company']);
        $param['agent']['Company'] = str_replace("www.", "", $param['agent']['Company']);

        if ($param['agent_type'] == '2')
        {
            //Debug::displayArray($param);
            //exit;

            $mailer = new BaseMailer();
            $mailer->From = $param['agent']['Email'];
            $mailer->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['agent']['Name']);
            $mailer->FromName = $param['agent']['Company'];

            $mailer->Subject = 'Transaction Request '.date('d-m-Y H:i:s');

            //platform operator
            $mailer->AddAddress($param['agent_parent']['Email'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail1'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail2'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail3'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail4'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail5'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail6'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail7'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail8'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail9'], '');
            $mailer->AddAddress($param['agent_parent']['PlatformEmail10'], '');

            //normal operator
            $mailer->AddAddress($param['agent']['Email'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail1'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail2'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail3'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail4'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail5'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail6'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail7'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail8'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail9'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail10'], '');


            $mailer->IsHTML(true);
            $mailer->Body = $message;
            $mailer->AltBody = $message;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();
        }
        else if ($param['agent_type'] == '1')
        {
            $mailer = new BaseMailer();
            $mailer->From = $param['agent']['Email'];
            $mailer->AddReplyTo($param['config']['MEMBER_EMAIL_FROM'], $param['agent']['Name']);
            $mailer->FromName = $param['agent']['Company'];

            $mailer->Subject = 'Transaction Request '.date('d-m-Y H:i:s');

            $mailer->AddAddress($param['agent']['Email'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail1'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail2'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail3'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail4'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail5'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail6'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail7'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail8'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail9'], '');
            $mailer->AddAddress($param['agent']['PlatformEmail10'], '');

            $mailer->IsHTML(true);
            $mailer->Body = $message;
            $mailer->AltBody = $message;

            $mailer->Send();

            $mailer->ClearAddresses();
            $mailer->ClearAttachments();
        }

        /*$mailer = new BaseMailer();

        $mailer->From = $param['config']['EMAIL_SENDER'];
        $mailer->AddReplyTo($param['config']['TRX_EMAIL_TO'], $param['config']['COMPANY_NAME']);
        $mailer->FromName = $param['config']['COMPANY_NAME'];

        $mailer->Subject = '['.$param['config']['SITE_NAME'].'] Transaction Request '.date('d-m-Y H:i:s');

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


        if ($param['content_param']['agent_email']!="") {
            $mailer->AddAddress($param['content_param']['agent_email'], '');
        }


        $mailer->IsHTML(true);
        $mailer->Body = $message;
        $mailer->AltBody = $message;

        $mailer->Send();

        $mailer->ClearAddresses();
        $mailer->ClearAttachments();*/
    }
}
?>