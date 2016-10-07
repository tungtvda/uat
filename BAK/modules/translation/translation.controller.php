<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class Translation extends BaseController 
{
	protected $controller_name = "translation";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new TranslationModel();
		return $model;
	}
        
        protected function Translated()
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
                else if ($this->section=='api')
                {
                }
                
                
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
        else if ($this->section=='api')
        {
        }
	}
        
        protected function ChangeLanguage()
    {
        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        //$start->$loadModel($this->id);
        $this->ReturnView($start->$loadModel($this->id), false);
        
        /*if ($this->section=='main')
        {
			
	    Helper::redirect($_SERVER['HTTP_REFERER']);
			
        }*/
        
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
			Permission::Access($this->controller_name,2);
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
        else if ($this->section=='api')
        {
        }
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
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'AddFormPost');
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
			$_SESSION['admin']['translation_add'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/translation/edit/".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/translation/add/");
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
			Permission::Access($this->controller_name,3);
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
	            Helper::redirect($param['config']['SITE_DIR']."/admin/translation/index");
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
            CRUD::validateFormSubmit('1', 'EditFormPost');
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
			$_SESSION['admin']['translation_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/translation/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/translation/edit/".$this->id);
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
			Permission::Access($this->controller_name,4);
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
			$_SESSION['admin']['translation_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/translation/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/translation/index");
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
}
?>