<?php
class Hook extends BaseController 
{
	protected $controller_name = "hook";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new HookModel();
		return $model;
	}

	protected function Index() 
	{
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		if ($param['content_param']['count']>0)
		{ 
			for ($i=0; $i<$param['content_param']['count']; $i++)
			{ 
				if ($param['content'][$i]['TypeID']==1) 
				{
					$cparam = explode(',',$param['content'][$i]['Content']);			
					Core::getController($cparam[0],$cparam[1],$cparam[2])->ExecuteAction();
				}
				else if ($param['content'][$i]['TypeID']==2)
				{
					echo $param['content'][$i]['Content'];
				}
			} 
		} 
	}
}
?>