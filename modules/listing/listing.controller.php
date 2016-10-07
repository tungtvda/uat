<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('merchant');
Core::requireController('dealer');

class Listing extends BaseController
{
	protected $controller_name = "listing";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new ListingModel();
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
		
		if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
		
		if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
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
		if($this->section == "admin"){	
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		
		if($this->section == "merchant"){	
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,2);
		}
		
		if($this->section == "dealer"){	
		// Control Access
		Dealer::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,2);
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function AddProcess()
	{
		if($this->section == "admin"){	
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		if($this->section == "merchant"){	
		// Control Access
		Merchant::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		if($this->section == "dealer"){	
		// Control Access
		Dealer::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		if($this->section == "admin"){
			$_SESSION['admin']['listing_add'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/listing/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/listing/add/");
			}
		}
		
		if($this->section == "merchant"){
			$_SESSION['merchant']['listing_add'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/listing/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/listing/add/");
			}
		}
		
		if($this->section == "dealer"){
			$_SESSION['dealer']['listing_add'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/listing/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/listing/add/");
			}
		}
		
	}

	protected function Edit()
	{
		if($this->section == "admin"){
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
		}
		
		if($this->section == "merchant"){
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,3);
		}
		
		if($this->section == "dealer"){
		// Control Access
		Dealer::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,3);
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		if($this->section == "admin"){
	        if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/admin/listing/index");
	        }
		}
		
		if($this->section == "merchant"){
	        if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/merchant/listing/index");
	        }
		}
		
		if($this->section == "dealer"){
	        if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/dealer/listing/index");
	        }
		}
		
	}

	protected function EditProcess()
	{
		if($this->section == "admin"){
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		if($this->section == "merchant"){
		// Control Access
		Merchant::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		if($this->section == "dealer"){
		// Control Access
		Dealer::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		if($this->section == "admin"){

			$_SESSION['admin']['listing_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/listing/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/listing/edit/".$this->id);
			}
		
		}
		
		if($this->section == "merchant"){

			$_SESSION['merchant']['listing_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/listing/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/listing/edit/".$this->id);
			}
		
		}
		
		if($this->section == "dealer"){

			$_SESSION['dealer']['listing_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/listing/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/listing/edit/".$this->id);
			}
		
		}
		
	}

	protected function Delete()
	{
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		#Permission::Access($this->controller_name,4);
		}
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		#Permission::Access($this->controller_name,4);
		}
		
		if($this->section == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Check Access Permission
		#Permission::Access($this->controller_name,4);
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		if($this->section == "admin"){
			$_SESSION['admin']['listing_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/listing/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/listing/index");
			}
		}
		
		if($this->section == "merchant"){
			$_SESSION['merchant']['listing_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/listing/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/listing/index");
			}
		}
		
		if($this->section == "dealer"){
			$_SESSION['dealer']['listing_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/listing/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/listing/index");
			}
		}

	}

	protected function Sort()
    {
        // Control Access
        Staff::Access(1);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);
    }

	protected function Position()
    {
        // Control Access
        Staff::Access(1);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        echo $param;
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