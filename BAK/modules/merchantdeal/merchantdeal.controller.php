<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('merchant');
Core::requireController('dealer');

class MerchantDeal extends BaseController
{
	protected $controller_name = "merchantdeal";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new MerchantDealModel();
		return $model;
	}

	protected function Index()
	{
		//require_once('modules/merchantdeal/merchantdeal.model.php');
		
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}
		
		if ($this->section=='merchant')
		{
			/*$TypeID = MerchantDealModel::MerchantDealControl();
			
			if($TypeID == '1'){
				
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/dashboard");
			}*/
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
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,2);
		}
		
		if($this->section == 'dealer'){
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
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		if($this->section == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		if($this->section == 'admin'){
			$_SESSION['admin']['merchantdeal_add'] = $param['status'];
			
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/add/");
			}
		}
		
		if($this->section == 'merchant'){
			$_SESSION['merchant']['merchantdeal_add'] = $param['status'];
			
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/add/");
			}
		}
		
		if($this->section == 'dealer'){
			$_SESSION['dealer']['merchantdeal_add'] = $param['status'];
			
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/edit/".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/add/");
			}
		}
		
		
	}

	protected function Edit()
	{
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
      	}	
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,3);
      	}
		
		if($this->section == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,3);
      	}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		if($this->section == 'admin'){
	        if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/index");
	        }
		}
		
		if($this->section == 'merchant'){
			if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/index");
	        }
			
			
		}
		
		if($this->section == 'dealer'){
			if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/index");
	        }
			
			
		}
		
	}

	protected function EditProcess()
	{
		if($this->seciton == 'admin'){
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		if($this->seciton == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		if($this->seciton == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		if($this->section == 'admin'){
			$_SESSION['admin']['merchantdeal_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/edit/".$this->id);
			}
		}
		
		if($this->section == 'merchant'){
			$_SESSION['merchant']['merchantdeal_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/edit/".$this->id);
			}
		}
		
		if($this->section == 'dealer'){
			$_SESSION['dealer']['merchantdeal_edit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/edit/".$this->id);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/edit/".$this->id);
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
			$_SESSION['admin']['merchantdeal_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/index");
			}
		}
		
		if($this->section == "merchant"){
			$_SESSION['merchant']['merchantdeal_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/index");
			}
		}
		
		if($this->section == "dealer"){
			$_SESSION['dealer']['merchantdeal_delete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/index");
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/index");
			}
		}

	}

	protected function ListingIndex()
	{
		//require_once('modules/merchantdeal/merchantdeal.model.php');
		
		if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			Permission::Access($this->controller_name,1);
		}
		
		if ($this->section=='merchant')
		{
			/*$TypeID = MerchantDealModel::MerchantDealControl();
			
			if($TypeID == '1'){
				
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchant/dashboard");
			}*/
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

	protected function ListingAdd()
	{
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,2);
		}
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,2);
		}
		
		if($this->section == 'dealer'){
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

	protected function ListingAddProcess()
	{
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		if($this->section == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		if($this->section == 'admin'){
			$_SESSION['admin']['merchantdeal_listingadd'] = $param['status'];
			
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingedit/".$param['parent']['id'].",".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingadd/");
			}
		}
		
		if($this->section == 'merchant'){
			$_SESSION['merchant']['merchantdeal_listingadd'] = $param['status'];
			
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingedit/".$param['parent']['id'].",".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingadd/");
			}
		}
		
		if($this->section == 'dealer'){
			$_SESSION['dealer']['merchantdeal_listingadd'] = $param['status'];
			
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingedit/".$param['parent']['id'].",".$param['content_param']['newID']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingadd/");
			}
		}
		
		
	}

	protected function ListingEdit()
	{
		if($this->section == 'admin'){
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);
      	}	
		
		if($this->section == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,3);
      	}
		
		if($this->section == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Check Access Permission
		//Permission::Access($this->controller_name,3);
      	}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		if($this->section == 'admin'){
	        if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingindex/".$param['parent']['id']);
	        }
		}
		
		if($this->section == 'merchant'){
			if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingindex/".$param['parent']['id']);
	        }
			
			
		}
		
		if($this->section == 'dealer'){
			if ($param['content_param']['count']=="1")
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingindex/".$param['parent']['id']);
	        }
			
			
		}
		
	}

	protected function ListingEditProcess()
	{
		if($this->seciton == 'admin'){
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		if($this->seciton == 'merchant'){
		// Control Access
		Merchant::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		if($this->seciton == 'dealer'){
		// Control Access
		Dealer::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');
		}
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		if($this->section == 'admin'){
			$_SESSION['admin']['merchantdeal_listingedit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
		}
		
		if($this->section == 'merchant'){
			$_SESSION['merchant']['merchantdeal_listingedit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
		}
		
		if($this->section == 'dealer'){
			$_SESSION['dealer']['merchantdeal_listingedit'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
		}
		
	}

	protected function ListingDelete()
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
			$_SESSION['admin']['merchantdeal_listingdelete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingindex/".$param['parent']['id']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/merchantdeal/listingindex/".$param['parent']['id']);
			}
		}
		
		if($this->section == "merchant"){
			$_SESSION['merchant']['merchantdeal_listingdelete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingindex/".$param['parent']['id']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/merchantdeal/listingindex/".$param['parent']['id']);
			}
		}
		
		if($this->section == "dealer"){
			$_SESSION['dealer']['merchantdeal_listingdelete'] = $param['status'];
	
	        if ($param['status']['ok']=="1")
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingindex/".$param['parent']['id']);
			}
			else
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/merchantdeal/listingindex/".$param['parent']['id']);
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