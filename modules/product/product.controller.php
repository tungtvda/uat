<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('member');

class Product extends BaseController 
{
	protected $controller_name = "product";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new ProductModel();
		return $model;
	}

	protected function Index() 
	{
		
		if ($this->section=='main')
		{

			//Control Access
			

		//Member::Access(1);
			
		}
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
		if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
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

	protected function AddProcess()
	{
		if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();
				
		$_SESSION['admin']['product_add'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/product/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/product/add/");
		}
	}

	protected function Edit() 
	{
		if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/product/index");
        }
	}

	protected function EditProcess() 
	{
		if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		$_SESSION['admin']['product_edit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/product/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/product/edit/".$this->id);
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

	protected function Delete() 
	{
		if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['product_delete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/product/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/product/index");
		}		
		
	}
	
	protected function Sort() 
    {
        if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
    }
    
	protected function Position() 
    {
        if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
        
        echo $param;
    }
	
	protected function Export() 
	{
		if ($this->section=='main')
		{

			//Control Access
			

		Member::Access(1);
			
		}
		if ($this->section=='admin')
		{
		// Control Access
		Staff::Access(1);
		
		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
	}
}
?>