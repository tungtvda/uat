<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('agent');

class GuidePromotion extends BaseController 
{
	protected $controller_name = "guidepromotion";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new GuidePromotionModel();
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
		$_SESSION['admin']['guidepromotion_add'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/add/");
		}
            }
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['guidepromotion_add'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/add/");
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
                    Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/index");
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
                    Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/index");
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
		$_SESSION['admin']['guidepromotion_edit'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/edit/".$this->id);
		}
            }
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['guidepromotion_edit'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/edit/".$this->id);
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
		$_SESSION['admin']['guidepromotion_delete'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/guidepromotion/index");
		}
            }
            
            if($this->section=='agent')
            {    
		$_SESSION['agent']['guidepromotion_delete'] = $param['status'];
        
                if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/agent/guidepromotion/index");
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