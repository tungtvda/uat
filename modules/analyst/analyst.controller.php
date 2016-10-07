<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('agent');
Core::requireController('permission');

class Analyst extends BaseController
{
	protected $controller_name = "analyst";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new AnalystModel();
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
		$this->ReturnView($start->$loadModel($this->id), true);
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
		#CRUD::validateFormSubmit('Add');
            }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

            if($this->section=='admin')
            {
                $_SESSION['admin']['analyst_add'] = $param['status'];
                $_SESSION['admin']['analyst_form'] = $param['form'];

                if ($param['status']['ok']=="1")
                {
                    Helper::redirect($param['config']['SITE_URL']."/admin/analyst/edit/".$param['content_param']['newID']);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_URL']."/admin/analyst/add/");
                }
            }

            if($this->section=='agent')
            {
                $_SESSION['agent']['analyst_add'] = $param['status'];

                if ($param['status']['ok']=="1")
                {
                    Helper::redirect($param['config']['SITE_URL']."/agent/analyst/edit/".$param['content_param']['newID']);
                }
                else
                {
                    Helper::redirect($param['config']['SITE_URL']."/agent/analyst/add/");
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
                    Helper::redirect($param['config']['SITE_URL']."/admin/analyst/index");
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
                    Helper::redirect($param['config']['SITE_URL']."/agent/analyst/index");
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
		$_SESSION['admin']['analyst_edit'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/analyst/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/analyst/edit/".$this->id);
		}
            }

            if($this->section=='agent')
            {
		$_SESSION['agent']['analyst_edit'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/agent/analyst/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/agent/analyst/edit/".$this->id);
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
		$_SESSION['admin']['analyst_delete'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/analyst/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/analyst/index");
		}
            }

            if($this->section=='agent')
            {
		$_SESSION['agent']['analyst_delete'] = $param['status'];

                if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/agent/analyst/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/agent/analyst/index");
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