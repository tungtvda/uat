<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');

class StaffLog extends BaseController 
{
	protected $controller_name = "stafflog";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new StaffLogModel();
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