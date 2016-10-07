<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('agent');

class AgentBlock extends BaseController 
{
	protected $controller_name = "agentblock";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new AgentBlockModel();
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
            else if ($this->section=='agent')
            {
                    // Control Access
                    Agent::Access(1);


            }        
            else if ($this->section=='member')
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
                $this->ReturnView($param, true);
            }
            else if ($this->section=='agent')
            {
                $this->ReturnView($param, true);
            }
            else if ($this->section=='member')
            {
            }
            else if ($this->section=='api')
            {
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
        if ($this->section=='main')
        {
        }
        else if ($this->section=='admin')
        {
        	Helper::redirect404();
        }
        else if ($this->section=='member')
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
			$this->ReturnView($param, true);
        }
        else if ($this->section=='admin')
        {
        }
        else if ($this->section=='member')
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
        else if ($this->section=='member')
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
            $this->ReturnView($param, true);
        }
        else if ($this->section=='member')
        {
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
            CRUD::validateFormSubmit('1', 'AddFormPost');
		}
        else if ($this->section=='member')
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
			$_SESSION['admin']['agentblock_add'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/edit/".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/add/");
			}
		}
        else if ($this->section=='member')
        {
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
        else if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);
			
			
		}        
        else if ($this->section=='member')
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
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/index");
	        }
		}
        else if ($this->section=='agent')
        {
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_DIR']."/agent/agentblock/index");
	        }
		}                        
        else if ($this->section=='member')
        {
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
        else if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);
			
			// Validate Genuine Form Submission
            CRUD::validateFormSubmit('1', 'EditFormPost');
		}        
        else if ($this->section=='member')
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
			$_SESSION['admin']['agentblock_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/edit/".$this->id);
			}
		}
        else if ($this->section=='agent')
        {
			$_SESSION['agent']['agentblock_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/agent/agentblock/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/agent/agentblock/edit/".$this->id);
			}
		}        
        else if ($this->section=='member')
        {
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
        else if ($this->section=='agent')
		{
			// Control Access
			Agent::Access(1);
			
		}        
        else if ($this->section=='member')
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
			$_SESSION['admin']['agentblock_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/admin/agentblock/index");
			}		
        }
        else if ($this->section=='agent')
        {
			$_SESSION['agent']['agentblock_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_DIR']."/agent/agentblock/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_DIR']."/agent/agentblock/index");
			}		
        }
        else if ($this->section=='member')
        {
        }
        else if ($this->section=='api')
        {
        }
	}
	
	protected function BlockIndex() 
    {
        if ($this->section=='main')
        {
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
	        $this->ReturnView($param, false);
	    }
        else if ($this->section=='admin')
        {
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