<?php
class HomeModel extends BaseModel
{
	private $output = array();
    private $module_name = "Home";
	private $module_dir = "modules/home/";
    private $module_default_url = "/main/home/index";
    private $module_default_admin_url = "/admin/home/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function Index()
	{
            //$this->getSubdomain();
            
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Home", 'template' => 'home.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'meta' => array('active' => "on", 'author' => $this->config['META_AUTHOR'], 'keywords' => $this->config['META_KEYWORDS'], 'description' => $this->config['META_DESCRIPTION'], 'robots' => $this->config['META_ROBOTS']));

		return $this->output;
	}
        
         public function getSubdomain()
    {
        $restapi = new RestAPI();
        $subdomain = $_GET['subdomain'];
        // JSON Post
        $data_string = array(
              "AppID" => '8bcee81cccecf76c07653065f60b358558a6f25e25fe9cdcb57bd7675fef6ec2',
              "AppSecret" => '$2a$09$5UfXEEFLDj0txWd7aGKbMOODvr7S5ePKrTocoLj02adjB7mGDom/a',
              "Text" => 'Your activation number is: '.$activation_code,
              #"DataCoding" => '8',
              #"Type" => 'longSMS',
              "Recipients" => array($recipient_mobile_no)
        );

        $data_string = json_encode($data_string);
        

        //$param = $restapi->makeRequest("https://smsi.valse.com.my/api/message/index", $data_string, "GET", "json");
        
        Debug::displayArray($data_string);
        exit;
    }
}
?>