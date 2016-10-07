<?php
// Require required controllers
Core::requireController('staff');
Core::requireController('merchant');
Core::requireController('dealer');

class Booking extends BaseController 
{
	protected $controller_name = "booking";

	protected function Start()
	{
		// Determines Prefix for Loading Section Model Method
		if ($this->section!='main') {
			$this->prefix = $this->section;
		}

		$model = new BookingModel();
		return $model;
	}

	protected function Index() 
	{
        if ($this->section=='main')
        {
        	//Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
        else if ($this->section=='api')
        {
        	//Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }
        
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);

        if ($this->section=='main')
        {
        	//$this->ReturnView($param, true);
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
		else if ($this->section=='merchant')
        {
            $this->ReturnView($param, true);
        }
		else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}


	protected function View() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
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
        }
        else if ($this->section=='admin')
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
			//Permission::Access($this->controller_name,2);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,2);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,2);
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
		else if ($this->section=='merchant')
        {
            $this->ReturnView($param, true);
        }
		else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
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
			//CRUD::validateFormSubmit('Add');
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Add');
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Add');
		}
        else if ($this->section=='api')
        {
        	//Helper::redirect404();
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
			$_SESSION['admin']['booking_add'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/edit/".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/add/");
			}
        }
		else if ($this->section=='merchant')
        {
			$_SESSION['merchant']['booking_add'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/edit/".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/add/");
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['booking_add'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/edit/".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/add/");
			}
        }
        else if ($this->section=='api')
        {
        }
	}
	
	protected function Logout()
	{
        

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);
		
		unset($_SESSION['passcode']);
		Helper::redirect($param['config']['SITE_URL']."/main/booking/index/".$param['listingID']);

       
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
			//Permission::Access($this->controller_name,3);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
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
	            Helper::redirect($param['config']['SITE_URL']."/admin/booking/index");
	        }
        }
		else if ($this->section=='merchant')
        {
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/merchant/booking/index");
	        }
        }
		else if ($this->section=='dealer')
        {
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/dealer/booking/index");
	        }
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
			//CRUD::validateFormSubmit('Update');
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Update');
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Update');
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
			$_SESSION['admin']['booking_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/edit/".$this->id);
			}
        }
		else if ($this->section=='merchant')
        {
			$_SESSION['merchant']['booking_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/edit/".$this->id);
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['booking_edit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/edit/".$this->id);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/edit/".$this->id);
			}
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
			//Permission::Access($this->controller_name,4);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);
	
			// Check Access Permission
			//Permission::Access($this->controller_name,4);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);
	
			// Check Access Permission
			//Permission::Access($this->controller_name,4);
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
			$_SESSION['admin']['booking_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/index");
			}
        }
		else if ($this->section=='merchant')
        {
			$_SESSION['merchant']['booking_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/index");
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['booking_delete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/index");
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/index");
			}
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function DeleteProcess() 
	{
        if ($this->section=='main')
        {
        	Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			Helper::redirect404();
		}
		else if ($this->section=='merchant')
		{
			Helper::redirect404();
		}
		else if ($this->section=='dealer')
		{
			Helper::redirect404();
		}
        else if ($this->section=='api')
        {
        	
        }
        else
        {
            Helper::redirect404();
        }

		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel($this->id);

		if ($this->section=='api')
        {
        }
	}

	protected function ListingIndex() 
	{
        if ($this->section=='main')
        {
        	//Helper::redirect404();
        }
		else if ($this->section=='admin')
		{
			// Control Access
			Staff::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,1);
		}
        else if ($this->section=='api')
        {
        	//Helper::redirect404();
        }
        else
        {
            Helper::redirect404();
        }
        
		// Load Model
		$start = $this->Start();				
		$loadModel = $this->prefix.__FUNCTION__;
		$this->ReturnView($start->$loadModel($this->id), true);

        if ($this->section=='main')
        {
        	//$this->ReturnView($param, true);
        }
        else if ($this->section=='admin')
        {
            $this->ReturnView($param, true);
        }
		else if ($this->section=='merchant')
        {
            $this->ReturnView($param, true);
        }
		else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function ListingAdd() 
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
			//Permission::Access($this->controller_name,2);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,2);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,2);
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
		else if ($this->section=='merchant')
        {
            $this->ReturnView($param, true);
        }
		else if ($this->section=='dealer')
        {
            $this->ReturnView($param, true);
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function ListingAddProcess()
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
			//CRUD::validateFormSubmit('Add');
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Add');
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Add');
		}
        else if ($this->section=='api')
        {
        	//Helper::redirect404();
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
			$_SESSION['admin']['booking_listingadd'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingedit/".$param['parent']['id'].",".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingadd/");
			}
        }
		else if ($this->section=='merchant')
        {
			$_SESSION['merchant']['booking_listingadd'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingedit/".$param['parent']['id'].",".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingadd/");
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['booking_listingadd'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingedit/".$param['parent']['id'].",".$param['content_param']['newID']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingadd/");
			}
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function ListingEdit() 
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
			//Permission::Access($this->controller_name,3);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Check Access Permission
			//Permission::Access($this->controller_name,3);
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
	            Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingindex/".$param['parent']['id']);
	        }
        }
		else if ($this->section=='merchant')
        {
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingindex/".$param['parent']['id']);
	        }
        }
		else if ($this->section=='dealer')
        {
	        if ($param['content_param']['count']=="1") 
	        {
	            $this->ReturnView($param, true);
	        }
	        else
	        {
	            Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingindex/".$param['parent']['id']);
	        }
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function ListingEditProcess() 
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
			//CRUD::validateFormSubmit('Update');
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Update');
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);

			// Validate Genuine Form Submission
			//CRUD::validateFormSubmit('Update');
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
			$_SESSION['admin']['booking_listingedit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
        }
		else if ($this->section=='merchant')
        {
			$_SESSION['merchant']['booking_listingedit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['booking_listingedit'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingedit/".$param['parent']['id'].",".$param['current']['id']);
			}
        }
        else if ($this->section=='api')
        {
        }
	}

	protected function ListingDelete() 
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
			//Permission::Access($this->controller_name,4);
		}
		else if ($this->section=='merchant')
		{
			// Control Access
			Merchant::Access(1);
	
			// Check Access Permission
			//Permission::Access($this->controller_name,4);
		}
		else if ($this->section=='dealer')
		{
			// Control Access
			Dealer::Access(1);
	
			// Check Access Permission
			//Permission::Access($this->controller_name,4);
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
			$_SESSION['admin']['booking_listingdelete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingindex/".$param['parent']['id']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/admin/booking/listingindex/".$param['parent']['id']);
			}
        }
		else if ($this->section=='merchant')
        {
			$_SESSION['merchant']['booking_listingdelete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingindex/".$param['parent']['id']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/merchant/booking/listingindex/".$param['parent']['id']);
			}
        }
		else if ($this->section=='dealer')
        {
			$_SESSION['dealer']['booking_listingdelete'] = $param['status'];
	        
	        if ($param['status']['ok']=="1") 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingindex/".$param['parent']['id']);
			} 
			else 
			{
				Helper::redirect($param['config']['SITE_URL']."/dealer/booking/listingindex/".$param['parent']['id']);
			}
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
	
	protected function CronCheck() 
    {
        if ($_GET['key']!="aseanfnb")
        {
            exit();
			
        }
        
        // Load Model
        $start = $this->Start();                
        $loadModel = $this->prefix.__FUNCTION__;
        $param = $start->$loadModel($this->id);        
    }	
}
?>