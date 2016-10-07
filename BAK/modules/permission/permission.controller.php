<?php
// Require required controllers
Core::requireController('staff');

class Permission extends BaseController 
{
	protected $controller_name = "permission";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new PermissionModel();
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

    protected function Manage() 
    {
        if ($this->section=='admin') 
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,1);
        }

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
				
		$_SESSION['admin']['permission_add'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			$_SESSION['admin']['permission_add'] = 1;
			Helper::redirect($param['config']['SITE_DIR']."/admin/permission/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			$_SESSION['admin']['permission_add'] = 2;
			Helper::redirect($param['config']['SITE_DIR']."/admin/permission/add/");
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/permission/index");
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
		
		$_SESSION['admin']['permission_edit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/permission/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/permission/edit/".$this->id);
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

		$_SESSION['admin']['permission_delete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/permission/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/permission/index");
		}		
		
	}

    protected function BulkUpdate()
    {
        // Control Access
        Staff::Access(1);

        // Check Access Permission
        Permission::Access($this->controller_name,3);
    
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
    }
    
	public function Access($controller,$mode) 
	{
		require_once('modules/permission/permission.model.php');

		// Load Model
		$start = new PermissionModel();				
		$param = $start->accessCheck($controller,$mode);
		
		$_SESSION['admin']['permission_access'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
        {
            // Do nothing, allow access
		}
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/admin/staff/dashboard");
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