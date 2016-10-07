<?php
class Loader
{
	private $section;
	private $controller;
	private $action;
    private $id;
	private $urlvalues;

	// Store the URL values on object creation
	public function __construct($param, $parent_page = FALSE)
	{
                
		// Start Session
		//session_start();

		$this->urlvalues = $param;

		// Determine Section
		if ($this->urlvalues['section'] == "")
		{
			$this->section = "main";
		}
		else
		{
			$this->section = $this->urlvalues['section'];
		}

		// Determine Controller
		if ($this->urlvalues['controller'] == "")
		{
			$this->controller = "home";
		}
		else if ($this->urlvalues['controller'] == "content")
		{
			$this->controller = "staticpage";
		}
		else
		{
			$this->controller = $this->urlvalues['controller'];
		}


		// Determine Action
		if ($this->urlvalues['action'] == "")
		{
			$this->action = "index";
		}
		else
		{
			$this->action = $this->urlvalues['action'];
		}

        // Determine ID
        $this->id = $this->urlvalues['id'];

		$model_location = "modules/".$this->controller."/".$this->controller.".model.php";
		$controller_location = "modules/".$this->controller."/".$this->controller.".controller.php";

        // Define Page Constants
        if ($parent_page==TRUE)
        {
            define("LOAD_SECTION", $this->section);
            define("LOAD_CONTROLLER", $this->controller);
            define("LOAD_ACTION", $this->action);
            define("LOAD_ID", $this->id);
        }

		// Check if model exist
		if (file_exists($model_location)==1)
		{
			//require the model classes
			require_once($model_location);
		}
		else
		{
			return Error::showError("Model not found");
		}

		// Check if controller exist
		if (file_exists($controller_location)==1)
		{
			//require the controller classes
			require_once($controller_location);
		}
		else
		{
			return Error::showError("Controller not found");
		}
	}

	//establish the requested controller as an object
	public function CreateController()
	{
		//does the class exist?
		if (class_exists($this->controller))
		{
			$parents = class_parents($this->controller);

			//does the class extend the controller class?
			if (in_array("BaseController", $parents))
			{
				//does the class contain the requested method?
				if (method_exists($this->controller ,$this->action))
				{
					return new $this->controller($this->section, $this->controller, $this->action, $this->id, $this->urlvalues);
				} else {
					//bad method error
					return Error::showError("Method does not exist");
				}
			} else {
				//bad controller error
				return Error::showError("Class does not extend base controller");
			}
		} else {
			//bad controller error
			return Error::showError("Class does not exist");
		}
	}
}
?>