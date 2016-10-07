<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class Theme extends BaseController 
{
	protected $controller_name = "theme";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new ThemeModel();
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
		#Staff::Access(1);

		// Check Access Permission
		#Permission::Access($this->controller_name,2);

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
				
		$_SESSION['admin']['theme_add'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/theme/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/theme/add/");
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/theme/index");
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
		
		$_SESSION['admin']['theme_edit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/theme/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/theme/edit/".$this->id);
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

		$_SESSION['admin']['theme_delete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/theme/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/theme/index");
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