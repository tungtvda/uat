<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('permission');
Core::requireController('member');
Core::requireController('merchant');
Core::requireController('dealer');

class Order extends BaseController
{
	protected $controller_name = "order";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new OrderModel();
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

        if ($this->section=='member')
        {
            // Control Access
            Member::Access(1);
        }

        if ($this->section=='cart')
        {
        }
		
		if ($this->section=='merchant')
        {
            // Control Access
            Merchant::Access(1);
        }
		
		if ($this->section=='dealer')
        {
            // Control Access
            Dealer::Access(1);
        }

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);
	}

    protected function UpdateProcess()
    {
        if ($this->section=='cart')
        {
            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1','add_to_cart_trigger');

            // Ensure ProductID is in valid ID format and quantity is not zero
            if (($_POST['ProductID']<='0')||($_POST['Quantity']<='0'))
            {
                Helper::redirect($param['config']['SITE_URL']."/cart/order/index/");
            }
        }
        else
        {
            exit();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        if ($param['status']['ok']=="1")
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/index/");
        }
    }

    protected function Remove()
    {
        if ($this->section=='cart')
        {
            // Validate Genuine Form Submission
            CRUD::validateFormSubmit('1','delete_cart_item_trigger');

            // Ensure ProductID is in valid ID format and quantity is not zero
            if ($_POST['ProductID']<='0')
            {
                Helper::redirect($param['config']['SITE_URL']."/cart/order/index/");
            }
        }
        else
        {
            exit();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        $_SESSION['cart']['order_remove'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/index/");
        }
        else
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/index/");
        }
    }

    protected function Clear()
    {
        if ($this->section!='cart')
        {
            exit();
        }

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);

        Helper::redirect($param['config']['SITE_URL']."/cart/order/index/");
    }
	
	protected function PaymentBankIn()
    {
        // Control Access
        //Client::Access(1);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix . __FUNCTION__;
        $param = $start->$loadModel($this->id);
	   	unset($_SESSION['manualbankin']);
		unset($_SESSION['cart']);
		unset($_SESSION['DealerMerchant']);
        if ($param['content_param']['count']==1 && $param['ismerchant']=="0")
        {
        	$_SESSION['manual']['status'] = "1";
            Helper::redirect($param['config']['SITE_URL']."/dealer/order/index");
			
        } 
        elseif ($param['content_param']['count']==1 && $param['ismerchant']=="1") 
        {
        	$_SESSION['manual']['merchant']['status'] = "1";
            Helper::redirect($param['config']['SITE_URL']."/merchant/order/index");
        }
    }

    protected function PaymentCheque()
    {
        // Control Access
        //Client::Access(1);

        // Load Model
        $start = $this->Start();
        $loadModel = $this->prefix . __FUNCTION__;
        $param = $start->$loadModel($this->id);
	    unset($_SESSION['manualcheque']);
		unset($_SESSION['cart']);
		unset($_SESSION['DealerMerchant']);
        if ($param['content_param']['count']==1 && $param['ismerchant']=="0")
        {
        	$_SESSION['manual']['status'] = "1";
            Helper::redirect($param['config']['SITE_URL']."/dealer/order/index");
			
        } 
        elseif ($param['content_param']['count']==1 && $param['ismerchant']=="1") 
        {
        	$_SESSION['manual']['merchant']['status'] = "1";
            Helper::redirect($param['config']['SITE_URL']."/merchant/order/index");
        }
    }
	
	protected function Confirm() 
    {
        $_SESSION['cart']['RedirectURL'] = $_POST['RedirectURL'];
        
        // Control Access
        #Member::Access(1);
            
        if (!isset($_SESSION['cart']) && !isset($_SESSION['DealerMerchant']))
        {
            Helper::redirect($param['config']['SITE_URL']."/");
            exit();   
        }
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);         
        $this->ReturnView($param, true);
    }
	
	protected function ManualCheque() 
    {
        //$_SESSION['cart']['RedirectURL'] = $_POST['RedirectURL'];
        
        // Control Access
        #Member::Access(1);
            
        /*if ($_POST['OrderTrigger']!=1)
        {
            Helper::redirect($param['config']['SITE_URL']."/");
            exit();    
        }*/
        //unset($_SESSION['manualcheque']);
		//unset($_SESSION['manualbankin']);
		
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);         
        $this->ReturnView($param, true);
    }
	
	protected function ManualBankIn() 
    {
    	//unset($_SESSION['manualcheque']);
		//unset($_SESSION['manualbankin']);
        //$_SESSION['cart']['RedirectURL'] = $_POST['RedirectURL'];
        
        // Control Access
        #Member::Access(1);
            
        /*if ($_POST['OrderTrigger']!=1)
        {
            Helper::redirect($param['config']['SITE_URL']."/");
            exit();    
        }*/
        
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);         
        $this->ReturnView($param, true);
    }

    protected function Request() 
    {
        /*if ($_POST['RequestTrigger']!=1)
        {
            Helper::redirect($param['config']['SITE_URL']."/");
            exit();    
        }*/
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);         
        $this->ReturnView($param, true);
    }


	protected function PaymentCheck() 
    {
    	//echo 'hi';
		
		
        if ($_POST['RequestTrigger']!=1)
        {
            Helper::redirect($param['config']['SITE_URL']."/");
            exit();    
        }
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);         
		//Debug::displayArray($param);
			
		if ($param['payment_type']=="1")
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/request");
        } 
		elseif($param['payment_type']=="2") 
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/manualbankin/".$_SESSION['DealerMerchant']['ID']);
        }     
		elseif($param['payment_type']=="3") 
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/manualcheque/".$_SESSION['DealerMerchant']['ID']);
        }        
		   


    }

    protected function Response() 
    {
    	if(!isset($_SESSION['DealerMerchant'])){
	        if (($_SESSION['cart']['OrderNo']!=$_POST['custom0'])||($_SESSION['cart']['OrderKey']!=$_POST['custom1']))
	        {
	            Helper::redirect($param['config']['SITE_URL']."/");
	        }
		}else{
			if (($_SESSION['DealerMerchant']['OrderNo']!=$_POST['custom0'])||($_SESSION['DealerMerchant']['OrderKey']!=$_POST['custom1']))
	        {
	            Helper::redirect($param['config']['SITE_URL']."/");
	        }
		}

        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel();
	   
        if ($param['status']=="1")
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/complete/?sid=1&mid=".$param['delivery_method']."");
        } 
        else 
        {
            Helper::redirect($param['config']['SITE_URL']."/cart/order/complete/?sid=2");
        }
		
		
	
    }

    protected function Complete() 
    {
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);
		
			
		unset($_SESSION['DealerMerchant']);
		         
        $this->ReturnView($param, true);
		

		
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

		// Check Access Permission
		Permission::Access($this->controller_name,2);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel(), true);
	}

	protected function AddProcess()
	{
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Add');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['order_add'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/order/edit/".$param['content_param']['newID']);
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/order/add/");
		}
	}

	protected function Edit()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,3);

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
            Helper::redirect($param['config']['SITE_URL']."/admin/order/index");
        }
	}

	protected function EditProcess()
	{
		// Control Access
		Staff::Access(1);

		// Validate Genuine Form Submission
		CRUD::validateFormSubmit('Update');

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['order_edit'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/order/edit/".$this->id);
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/order/edit/".$this->id);
		}
	}

	protected function Delete()
	{
		// Control Access
		Staff::Access(1);

		// Check Access Permission
		Permission::Access($this->controller_name,4);

		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		$_SESSION['admin']['order_delete'] = $param['status'];

        if ($param['status']['ok']=="1")
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/order/index");
		}
		else
		{
			Helper::redirect($param['config']['SITE_URL']."/admin/order/index");
		}

	}

	protected function Export()
	{
		
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		
		if($this->section == "admin"){
			
			
		Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
		
		}
		
		if($this->section == "merchant"){
			
			
		//Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
		Helper::redirect($param['config']['SITE_URL']."/merchant/order/index");
		
		}
		
		if($this->section == "dealer"){
			
		
		//Helper::exportCSV($param['content']['header'], $param['content']['content'], $param['content']['filename']);
		
		Helper::redirect($param['config']['SITE_URL']."/dealer/order/index");
		
		}
		
		
		
	}
}
?>