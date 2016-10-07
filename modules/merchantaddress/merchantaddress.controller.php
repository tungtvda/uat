<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('merchant');

class MerchantAddress extends BaseController 
{
	protected $controller_name = "merchantaddress";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new MerchantAddressModel();
		return $model;
	}

	protected function Index() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}
        else if ($this->section=='api')
        {
        	Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }
        
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);

        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='merchant')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function View() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
        	Helper::redirect404();
        }
        else if ($this->section=='merchant')
        {
        	Helper::redirect404();
        }
        else if ($this->section=='api')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='merchant')
        {
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Add() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,2);
		}
        else if ($this->section=='api')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='merchant')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function AddProcess()
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Add');
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Add');
		}
        else if ($this->section=='api')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
			$_SESSION['admin']['merchantaddress_add'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/edit/".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/add/");
			}
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Edit() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
		}
        else if ($this->section=='api')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/index");
	        }
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function EditProcess() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Update');
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Update');
		}
        else if ($this->section=='api')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
			$_SESSION['admin']['merchantaddress_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/edit/".$this->id);
			}
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function Delete() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);
	
			// Check Access Permission
			//Permission::Access($this->controller_name,4);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);
	
			// Check Access Permission
			//Permission::Access($this->controller_name,4);
		}
        else if ($this->section=='api')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
			$_SESSION['admin']['merchantaddress_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/index");
			}
        }
        else if ($this->section=='api')
        {
        }
	}
	
	protected function Export() 
	{
        if ($this->section=='main')
        {
            Helper::redirect404();
        }
        else if ($this->section=='admin')
        {
            // Control Access
            Staff::Access(1);

            // Check Access Permission
            Permission::Access($this->controller_name,1);
        }
        else if ($this->section=='api')
        {
            Helper::redirect404();
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
        }
        else if ($this->section=='admin')
        {
            Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
        }
        else if ($this->section=='api')
        {
        }
	}
	
	protected function MerchantIndex() 
	{
		if ($this->section=='admin') 
		{
			// Control Access
			Staff::Access(1);
		}

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function MerchantAdd() 
	{
		// Control Access
		Staff::Access(1);

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function MerchantAddProcess()
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
				
		$_SESSION['admin']['merchantaddress_merchantadd'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantedit/".$param['parent']['id'].",".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantadd/");
		}
	}

	protected function MerchantEdit() 
	{
		// Control Access
		Staff::Access(1);

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
            Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantindex/".$param['parent']['id']);
        }
	}

	protected function MerchantEditProcess() 
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		$_SESSION['admin']['merchantaddress_merchantedit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantedit/".$param['parent']['id'].",".$param['current']['id']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantedit/".$param['parent']['id'].",".$param['current']['id']);
		}
	}

	protected function MerchantDelete() 
	{
		// Control Access
		Staff::Access(1);

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['merchantaddress_merchantdelete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantindex/".$param['parent']['id']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/merchantaddress/merchantindex/".$param['parent']['id']);
		}		
		
	}	
}
?>