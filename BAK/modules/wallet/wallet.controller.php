<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('reseller');
Core::requireController('member');
Core::requireController('agent');


class Wallet extends BaseController
{
	protected $controller_name = "wallet";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new WalletModel();
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
			Agent::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
		
		if ($this->section=='member')
		{
			// Control Access
			Member::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
                
                if ($this->section=='api')
		{
			
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

	protected function View()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
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
		Agent::Access(1);
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function AddProcess()
	{
            if ($this->section=='admin')
	    {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
            }
            
            if ($this->section=='agent')
	    {
                // Control Access
		Agent::Access(1);
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

	    if($this->section=='admin')
            {
                $_SESSION['admin']['wallet_add'] = $param['status'];
             
                
                if ($param['status']['ok']=="1")
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/edit/".$param['content_param']['newID']);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/add/");
                }
            }
            
            if($this->section=='agent')
            {
                $_SESSION['agent']['wallet_add'] = $param['status'];
             
                
                if ($param['status']['ok']=="1")
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/edit/".$param['content_param']['newID']);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/add/");
                }
            }
            
	}

	protected function Edit()
	{
            if($this->section=='admin')
            {    
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
            } 
            
            if($this->section=='agent')
            {    
		// Control Access
		Agent::Access(1);
		
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
                
            if($this->section=='admin')
            {    
                
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/index");
                }
            } 
            
            if($this->section=='agent')
            {    
                
                if ($param['content_param']['count']=="1")
                {
                    $this->ReturnView($param, true);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/index");
                }
            }
	}

	protected function EditProcess()
	{
            if($this->section=='admin')
            {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
            }
            
            if($this->section=='agent')
            {
		// Control Access
		Agent::Access(1);
		
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
            
            if($this->section=='admin')
            {    
		$_SESSION['admin']['wallet_edit'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/edit/".$this->id);
		}
            } 
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['wallet_edit'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/edit/".$this->id);
		}
            }
            
	}

	protected function Delete()
	{
            if($this->section=='admin')
            {
                // Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,4);
            }
            
            if($this->section=='agent')
            {
                // Control Access
		Agent::Access(1);

            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
            
            if($this->section=='admin')
            {    
                
		$_SESSION['admin']['wallet_delete'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/wallet/index");
		}
            }
            
            if($this->section=='agent')
            {    
                
		$_SESSION['agent']['wallet_delete'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/wallet/index");
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