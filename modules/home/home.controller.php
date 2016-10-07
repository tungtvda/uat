<?php
class Home extends BaseController
{
	protected $controller_name = "home";

	protected function Start()
	{
		$model = new HomeModel();
		return $model;
	}

	protected function Index()
	{
		// Load Model
		$start = $this->Start();
		$loadModel = $this->prefix.__FUNCTION__;
		$param = $start->$loadModel();

		if ($this->section=='admin')
		{
			Helper::redirect($param['config']['SITE_DIR']."/admin/staff/dashboard");
		}
		else if ($this->section=='member')
		{
            Helper::redirect($param['config']['SITE_DIR']."/member/wallet/index");
        }
		else if ($this->section=='main')
		{
            Helper::redirect($param['config']['SITE_DIR']."/member/member/login/?rid=".urlencode(base64_encode($_SESSION['reseller_code'])));
        }
		else if ($this->section=='reseller')
		{
            Helper::redirect($param['config']['SITE_DIR']."/reseller/reseller/dashboard");
        }
        else if ($this->section=='agent')
		{
            Helper::redirect($param['config']['SITE_DIR']."/agent/agent/dashboard");
        }
        else
		{
			$this->ReturnView($param, true);
		}
	}
}
?>