<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class Currency extends BaseController 
{
	protected $controller_name = "currency";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new CurrencyModel();
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

	protected function AddProcess()
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
				
		$_SESSION['admin']['currency_add'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/add/");
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
            Helper::redirect($param['config']['SITE_URL']."/admin/currency/index");
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
		
		$_SESSION['admin']['currency_edit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/edit/".$this->id);
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

		$_SESSION['admin']['currency_delete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/index");
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

	protected function CountryIndex() 
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

	protected function CountryAdd() 
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

	protected function CountryAddProcess()
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
				
		$_SESSION['admin']['currency_countryadd'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryedit/".$param['parent']['id'].",".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryadd/");
		}
	}

	protected function CountryEdit() 
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
            Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryindex/".$param['parent']['id']);
        }
	}

	protected function CountryEditProcess() 
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		$_SESSION['admin']['currency_countryedit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryedit/".$param['parent']['id'].",".$param['current']['id']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryedit/".$param['parent']['id'].",".$param['current']['id']);
		}
	}

	protected function CountryDelete() 
	{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,4);

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['currency_countrydelete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryindex/".$param['parent']['id']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/currency/countryindex/".$param['parent']['id']);
		}		
		
	}
}
?>