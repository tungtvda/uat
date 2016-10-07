<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('agent');

class BankInfo extends BaseController 
{
	protected $controller_name = "bankinfo";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new BankInfoModel();
		return $model;
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
            Agent::Access(1);

            
        }
    
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
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
        Agent::Access(1);


        }

        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $this->ReturnView($start->$loadModel($this->id), true);
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
                
                if($this->section=='agent')
                {    
                    // Control Access
                    Agent::Access(1);

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

	protected function Add() 
	{
            if($this->section=='admin')
            {    
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
            } 
            
            if($this->section=='agent')
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
            if($this->section=='admin')
            {
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
            } 
            
            if($this->section=='agent')
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
		
            if($this->section=='admin')
            {    
		$_SESSION['admin']['bankinfo_add'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/add/");
		}
            }
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['bankinfo_add'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/add/");
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
                    Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/index");
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
                    Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/index");
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
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
                
            }
            
		
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section=='admin')
            {    
		$_SESSION['admin']['bankinfo_edit'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/edit/".$this->id);
		}
            }
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['bankinfo_edit'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/edit/".$this->id);
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
		$_SESSION['admin']['bankinfo_delete'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/bankinfo/index");
		}
            }
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['bankinfo_delete'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/bankinfo/index");
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