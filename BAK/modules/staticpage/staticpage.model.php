<?php
// Require required models
Core::requireModel('app');

class StaticPageModel extends BaseModel
{
	private $output = array();
    private $module_name = "Static Page";
	private $module_dir = "modules/staticpage/";

	public function __construct()
	{
		parent::__construct();
	}

	public function Contact()
	{
        $captcha[0] = rand(1,5);
        $captcha[1] = rand(1,4);

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Contact Us", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/contact.inc.php', 'staticpage_contact' => $_SESSION['main']['staticpage_contact']),
		'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.contact.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb("Contact Us","","",$this->config,""),
        'captcha' => $captcha,
		'meta' => array('active' => "on"));

		unset($_SESSION['main']['staticpage_contact']);

		return $this->output;
	}

	public function ContactProcess()
	{
	    // Stores contact messages
	    $key = "(Name, Company, ContactNo, Email, Subject, Message, DatePosted, Status)";
        $value = "('".$_POST['Name']."', '".$_POST['Company']."', '".$_POST['ContactNo']."', '".$_POST['Email']."','".$_POST['Subject']."', '".$_POST['Message']."', '".date('YmdHis')."', '1')";

        $sql = "INSERT INTO message ".$key." VALUES ". $value;

        $count = $this->dbconnect->exec($sql);
        $newID = $this->dbconnect->lastInsertId();

        // Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Processing..."),
		'form_param' => Helper::unescape($_POST),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function PageNotFound()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Page Not Found", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/pagenotfound.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb("Page Not Found","","",$this->config,""),
		'meta' => array('active' => "on"));

		return $this->output;
	}

        public function JavascriptDisabled()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Disabled Javascript", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/javascriptdisabled.inc.php'),
                 'block' => array('', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb("Disabled Javascript","","main",$this->config,""),
		'meta' => array('active' => "on"));

		return $this->output;
	}


    public function SystemNotFound()
	{
		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "System Not Found", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/systemnotfound.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb("System Not Found","","main",$this->config,""),
                'block' => array('', 'common' => "false"),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function TestDNS()
    {
        echo "Response:<br />";

        AppModel::DNSLogin();
    }
}
?>