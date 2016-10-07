<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class Generator extends BaseController 
{
	protected $controller_name = "generator";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new GeneratorModel();
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
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function Run()
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
		$param = $start->$loadModel();

		$_SESSION['admin']['page_run'] = $param['content_param']['page_run'];
		Helper::redirect($param['config']['SITE_DIR']."/admin/generator/index");
	}
}
?>