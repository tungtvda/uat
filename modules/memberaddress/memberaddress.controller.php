<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('member');

class MemberAddress extends BaseController 
{
	protected $controller_name = "memberaddress";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new MemberAddressModel();
		return $model;
	}

	protected function Index() 
	{
		if ($this->section=='admin') 
		{
			// Control Access
			Staff::Access(1);
		}

        if ($this->section=='member') 
        {
            // Control Access
            Member::Access(1);
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
        }

        if ($this->section=='member') 
        {
            // Control Access
            Member::Access(1);
        }
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();
				
		$_SESSION['admin']['memberaddress_add'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/edit/".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/add/");
		}
	}

	protected function Edit() 
	{
	    if ($this->section=='admin') 
        {
            // Control Access
            Staff::Access(1);
        }

        if ($this->section=='member') 
        {
            // Control Access
            Member::Access(1);
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/index");
        }
	}

	protected function EditProcess() 
	{
		if ($this->section=='admin') 
        {
            // Control Access
            Staff::Access(1);
        }

        if ($this->section=='member') 
        {
            // Control Access
            Member::Access(1);
        }
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		$_SESSION['admin']['memberaddress_edit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/edit/".$this->id);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/edit/".$this->id);
		}
	}

	protected function Delete() 
	{
		if ($this->section=='admin') 
        {
            // Control Access
            Staff::Access(1);
        }

        if ($this->section=='member') 
        {
            // Control Access
            Member::Access(1);
        }

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['memberaddress_delete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/index");
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/index");
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
	
	protected function MemberIndex() 
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

	protected function MemberAdd() 
	{
		// Control Access
		Staff::Access(1);

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

	protected function MemberAddProcess()
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
				
		$_SESSION['admin']['memberaddress_memberadd'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberedit/".$param['parent']['id'].",".$param['content_param']['newID']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberadd/");
		}
	}

	protected function MemberEdit() 
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
            Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberindex/".$param['parent']['id']);
        }
	}

	protected function MemberEditProcess() 
	{
		// Control Access
		Staff::Access(1);
		
		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		$_SESSION['admin']['memberaddress_memberedit'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberedit/".$param['parent']['id'].",".$param['current']['id']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberedit/".$param['parent']['id'].",".$param['current']['id']);
		}
	}

	protected function MemberDelete() 
	{
		// Control Access
		Staff::Access(1);

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['memberaddress_memberdelete'] = $param['status'];
        
        if ($param['status']['ok']=="1") 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberindex/".$param['parent']['id']);
		} 
		else 
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/memberaddress/memberindex/".$param['parent']['id']);
		}		
		
	}	
}
?>