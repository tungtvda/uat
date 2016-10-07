<?php
// Require required models
Core::requireModel('state');
Core::requireModel('country');
Core::requireModel('bankinfo');
Core::requireModel('product');
Core::requireModel('transaction');
Core::requireModel('agenttype');
Core::requireModel('profile');
Core::requireModel('agentblock');
Core::requireModel('agentpromotion');


class AgentModel extends BaseModel
{
	private $output = array();
    private $module_name = "Agent";
	private $module_dir = "modules/agent/";
    private $module_default_url = "/main/agent/index";
    private $module_default_admin_url = "/admin/agent/index";
    private $module_default_agent_url = "/agent/agent/dashboard";
    private $module_default_agentlist_url = "/agent/agent/agentlist";
    private $module_default_adminlist_url = "/admin/agent/agentlist";
    private $module_default_downline_url = "/agent/agent/downline";
    private $module_default_editindex_url = "/agent/agent/editindex";


	public function __construct()
	{
		parent::__construct();
	}

	public function BlockHomeIndex(){
		$sql = "SELECT Total FROM wallet WHERE AgentID = '".$_SESSION['agent']['ID']."' AND ProductID = '30'";

		$res = $this->dbconnect->query($sql);
		$result = $res->fetchColumn();


        $this->output = array(
        'config' => $this->config,
        //'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
        'secure' => NULL,
        'meta' => array('active' => "on"));

        return $this->output;
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/agent/index';
		$limit = 5;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM agent WHERE Enabled = 1 ORDER BY Name ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agents", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function AgentChat()
	{
		$crud = new CRUD();
                
                $agentid = (int)$_GET['agentid'];
	
		$sql = "SELECT * FROM agent WHERE ID = '".$agentid."' AND Enabled = 1";

		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
                    
                    if($row['Chat']=='') {
                        $chat = '<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src=\'https://embed.tawk.to/5624b43b21bfee9647916237/default\';
s1.charset=\'UTF-8\';
s1.setAttribute(\'crossorigin\',\'*\');
s0.parentNode.insertBefore(s1,s0);
})();
</script>';
                   
                        
                    }
                    else
                    {
                        $chat = $row['Chat'];
                    }    
                    
			$result = array(
			'Chat' => $chat,
                        'BackgroundColour' => $row['BackgroundColour']);


		}
                
                           
                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Live Chat", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/chat.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function Chat()
	{
		$crud = new CRUD();
                
                $agentid = (int)$_GET['agentid'];
	
		$sql = "SELECT * FROM agent WHERE ID = '".$agentid."' AND Enabled = 1";

		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
                    
                    if($row['Chat']=='') {
                        $chat = '<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src=\'https://embed.tawk.to/5624b43b21bfee9647916237/default\';
s1.charset=\'UTF-8\';
s1.setAttribute(\'crossorigin\',\'*\');
s0.parentNode.insertBefore(s1,s0);
})();
</script>';
                   
                        
                    }
                    else
                    {
                        $chat = $row['Chat'];
                    }    
                    
			$result = array(
			'Chat' => $chat,
                        'BackgroundColour' => $row['BackgroundColour']);


		}
                
                           
                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agent Live Chat", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/chat.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminReport($param)
	{
		//Debug::displayArray($_POST);
            
		$filename = __FUNCTION__;

		$query_condition = "";

		$crud = new CRUD();

		// Reset Query Variable
		$_SESSION['agent_'.__FUNCTION__] = "";

		$_SESSION['agent_'.__FUNCTION__]['Agent'] = $_POST['Agent'];

		$_SESSION['agent_'.__FUNCTION__]['Month'] = $_POST['Month'];

		$_SESSION['agent_'.__FUNCTION__]['Year'] = $_POST['Year'];

		if($_POST['Trigger'] =='search_form' && $_POST['Month'] != '0'){
		// Initialise query conditions


			



		if ($_GET['page']=="all")
		{
			//echo $_GET['page'];
			//echo 'hi';
			$_GET['page'] = "";
			unset($_SESSION['agent_'.__FUNCTION__]);
			//unset($_SESSION['agent_'.__FUNCTION__]['Year']);
		}

		if ($_POST['Trigger'] =='search_form' && $_POST['Year'] != '' && $_POST['Month'] != '0' && $_POST['Agent'] == '')
		{



		// Reset query conditions


		// Determine Title
		if (isset($_SESSION['agent_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

        
	    $transaction = array();


		$sql_agents = "SELECT * FROM agent WHERE Enabled = 1";
		$agents = array();
		$j = 0;
                
                
                        $tier_agents = 1;
                        foreach ($this->dbconnect->query($sql_agents) as $row)
                        {
                                $agents[$j] = array(
                                        'ID' => $row['ID'],
                                        //'Child'=> AgentModel::getTopAgentChild($row['ID'], $tier_agents)
                                    );
                                        

                                $j += 1;
                        }

                        $agents['count'] = $j;
                        

                        //$set = array();
                        
                        //$ID = AgentModel::childAncestors($agents[0]['Child'], $set);
                        
                        //Debug::displayArray($ID);
                        //exit;
                        $ID['count'] = $j;
                        //$_SESSION['pad'] = array();
                        //array_walk($ID, 'AgentModel::getTest');

                        //$maxpadding = max($_SESSION['pad']);
                                               
			
                        
                        unset($_SESSION['pad']);
		//echo $agents['count'];

		for ($z=0; $z <$ID['count'] ; $z++) {

			

				//$transaction[$z] = array(
				//'Report' => AgentModel::getAgentAdminReport($ID[$z][0], $filename),
                                //'Padding' => $ID[$z][1] 
				//);
                                
                                
                                //echo $g;
                                $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $agents[$z]['ID']);

                                $count = AgentModel::getAgentChildExist($agents[$z]['ID']);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($agents[$z]['ID']);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';    
                                unset($_SESSION['agentchild']);
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                

                                $data = array();
                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $_POST['Month']);
                                 //}
                                 //Debug::displayArray($report);
                                 //exit;

                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                     
                                     unset($report[$r]['In']);
                                     unset($report[$r]['Out']);
                                     unset($report[$r]['Commission']);
                                     unset($report[$r]['Bonus']);
                                     unset($report[$r]['Profit']);
                                     unset($report[$r]['Profitsharing']);
                                     unset($report[$r]['Percentage']);

                                 }*/
                                 
                                 
                                
                                


                                 $transaction[$z]['Agent'] = AgentModel::getAgent($agents[$z]['ID'], "Name");
                                 
                                 //$monthsreport[$m][$g]['Agent'] = 
                                 $transaction[$z]['Padding'] = $ID[$z][1];
                                 $transaction[$z]['In'] = $data['In'];
                                 $transaction[$z]['Out'] = $data['Out'];
                                 $transaction[$z]['Commission'] = $data['Commission'];
                                 $transaction[$z]['Bonus'] = $data['Bonus'];
                                 $transaction[$z]['Profit'] = $data['Profit'];
                                 /*$transaction[$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $transaction[$z]['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);

		





		}

                    
                    $transaction['count'] = $ID['count'];
                    $transaction['Padding'] = $maxpadding;
		}

		}

		$month = array();

		$month[1] = 'January';
		$month[2] = 'February';
		$month[3] = 'March';
		$month[4] = 'April';
		$month[5] = 'May';
		$month[6] = 'June';
		$month[7] = 'July';
		$month[8] = 'August';
		$month[9] = 'September';
		$month[10] = 'October';
		$month[11] = 'November';
		$month[12] = 'December';

		$month['count'] = '12';



		$years = array();
		$startyear =  '2013';
		$currentyear = date("Y");
		if($startyear == $currentyear){

		  	$years[0] = $startyear;
			$years['count'] = 1;
		}else{

		  $yeardifference = $currentyear - $startyear;
		  //echo $yeardifference.'<br />';

			for ($z=0; $z <= $yeardifference; $z++) {
				//echo 'hi <br />';
			$years[$z] = $startyear + $z;

		    }
   			$years['count'] = $z;
		}

		if($_POST['Trigger'] =='search_form' && $_POST['Month'] == '0' && $_POST['Agent'] == ''){
                          //echo 'hi';              
                        $sql2 = "SELECT * FROM agent WHERE Enabled = 1";
                        //echo $sql2;
                        //exit;
                        $result2 = array();
                        $z = 0;
                        //$tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        //'Child'=> AgentModel::getTopAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;
                        
                        /*$_SESSION['agentchild'] = array();
                        array_push($_SESSION['agentchild'], $ID[$z][0]);
                        //Debug::displayArray($_SESSION['agentchild']);
                        //exit;
                        $count = AgentModel::getAgentChildExist($ID[$z][0]);

                        if($count>'0')
                        {
                            AgentModel::getAgentAllChild($ID[$z][0]);
                        }


                        $child = implode(',', $_SESSION['agentchild']);

                        unset($_SESSION['agentchild']);*/
                        
                        //Debug::displayArray($result2);
                        //exit;

                        //$set = array();
                        
                        //$ID = AgentModel::childAncestors($result2[0]['Child'], $set);
                    
                        //$_SESSION['pad'] = array();
                        //array_walk($ID, 'AgentModel::getTest');

                        //$maxpadding = max($_SESSION['pad']);
                        
                        $ID['count'] = count($result2);
                        //Debug::displayArray($result2); 
                        //exit;
                        $report = array();
                        $monthsreport = array();
                        
                        for ($m = 1; $m <= 12; $m++) {
                            
                        
                        
                            for ($g = 0; $g < $result2['count']; $g++) {

                                //echo $g;
                                $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $result2[$g]['ID']);

                                $count = AgentModel::getAgentChildExist($result2[$g]['ID']);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($result2[$g]['ID']);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';  
                                //exit;
                                unset($_SESSION['agentchild']);
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                switch ($m) {
                                    case 1:
                                        $M = "January";
                                        break;
                                    case 2:
                                        $M = "February";
                                        break;
                                    case 3:
                                        $M = "March";
                                        break;
                                    case 4:
                                        $M = "April";
                                        break;
                                    case 5:
                                        $M = "May";
                                        break;
                                    case 6:
                                        $M = "June";
                                        break;
                                    case 7:
                                        $M = "July";
                                        break;
                                    case 8:
                                        $M = "August";
                                        break;
                                    case 9:
                                        $M = "September";
                                        break;
                                    case 10:
                                        $M = "October";
                                        break;
                                    case 11:
                                        $M = "November";
                                        break;
                                    case 12:
                                        $M = "December";
                                        break;
                                }

                                $data = array();
                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $M);
                                 //}
                                 //Debug::displayArray($report);
                                 //exit;

                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                     
                                     unset($report[$r]['In']);
                                     unset($report[$r]['Out']);
                                     unset($report[$r]['Commission']);
                                     unset($report[$r]['Bonus']);
                                     unset($report[$r]['Profit']);
                                     unset($report[$r]['Profitsharing']);
                                     unset($report[$r]['Percentage']);

                                 }*/
                                 
                                 
                                
                                $monthsreport[$m]['Month'] = $M;


                                 $monthsreport[$m][$g]['Agent'] = AgentModel::getAgent($result2[$g]['ID'], "Name");
                                 
                                 //$monthsreport[$m][$g]['Agent'] = 
                                 $monthsreport[$m][$g]['Padding'] = $ID[$g][1];
                                 $monthsreport[$m][$g]['In'] = $data['In'];
                                 $monthsreport[$m][$g]['Out'] = $data['Out'];
                                 $monthsreport[$m][$g]['Commission'] = $data['Commission'];
                                 $monthsreport[$m][$g]['Bonus'] = $data['Bonus'];
                                 $monthsreport[$m][$g]['Profit'] = $data['Profit'];
                                 /*$monthsreport[$m][$g]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $monthsreport[$m][$g]['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);
                                 
                                 //Debug::displayArray($monthsreport);



                            }
                        
                        }
                        //Debug::displayArray($monthsreport);
                        //exit;
                        $monthsreport['year'] = $_SESSION['agent_'.$filename]['Year'];
                        $monthsreport['padding'] = $maxpadding;
                        $monthsreport['count'] = $result2['count'];
                        //Debug::displayArray($monthsreport);
                        
                        //exit;
                                               
			//$monthsreport = AgentModel::getFrontAgentsMonthsReport($filename, $agent, $ID, $maxpadding);
                        
                        unset($_SESSION['pad']);
                        
                        //}
                        
                        
		}elseif($_POST['Trigger'] =='search_form' && $_POST['Month'] != '0'  && $_POST['Agent'] != ''){
			
			//$agentmonthsreport = AgentModel::getAgentMonthsReport($filename, $_POST['Agent']);
			$agentmonthsreport = array();
                        $report = array();
                        $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $_POST['Agent']);

                                $count = AgentModel::getAgentChildExist($_POST['Agent']);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($_POST['Agent']);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';
                                //echo $child.'<br>';  
                                //exit;
                                unset($_SESSION['agentchild']);
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                
                                $data = array();

                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $_POST['Month']);
                                 //}
                                 
                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                                                         

                                 }*/
                                                                                                                                             

                                 $agentmonthsreport['Agent'] = AgentModel::getAgent($_POST['Agent'], "Name");
                                                                  
                                 $agentmonthsreport['In'] = $data['In'];
                                 $agentmonthsreport['Out'] = $data['Out'];
                                 $agentmonthsreport['Commission'] = $data['Commission'];
                                 $agentmonthsreport['Bonus'] = $data['Bonus'];
                                 $agentmonthsreport['Profit'] = $data['Profit'];
                                 /*$agentmonthsreport['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $agentmonthsreport['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);
                                 
                                 $agentmonthsreport['count'] = 1;
                                 $agentmonthsreport['month'] = $_POST['Month'];
                                 $agentmonthsreport['year'] = $_POST['Year'];
                        
		}elseif($_POST['Trigger'] =='search_form' && $_POST['Month'] == '0'  && $_POST['Agent'] != ''){
                    $agentallmonthsreport = array(); 
                    
                    for ($m = 1; $m <= 12; $m++) {


                                //echo $g;
                                $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $_POST['Agent']);

                                $count = AgentModel::getAgentChildExist($_POST['Agent']);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($_POST['Agent']);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';    
                                unset($_SESSION['agentchild']);
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                switch ($m) {
                                    case 1:
                                        $M = "January";
                                        break;
                                    case 2:
                                        $M = "February";
                                        break;
                                    case 3:
                                        $M = "March";
                                        break;
                                    case 4:
                                        $M = "April";
                                        break;
                                    case 5:
                                        $M = "May";
                                        break;
                                    case 6:
                                        $M = "June";
                                        break;
                                    case 7:
                                        $M = "July";
                                        break;
                                    case 8:
                                        $M = "August";
                                        break;
                                    case 9:
                                        $M = "September";
                                        break;
                                    case 10:
                                        $M = "October";
                                        break;
                                    case 11:
                                        $M = "November";
                                        break;
                                    case 12:
                                        $M = "December";
                                        break;
                                }

                                $data = array();
                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $M);
                                 //}
                                 //Debug::displayArray($report);
                                 //exit;

                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                     
                                     unset($report[$r]['In']);
                                     unset($report[$r]['Out']);
                                     unset($report[$r]['Commission']);
                                     unset($report[$r]['Bonus']);
                                     unset($report[$r]['Profit']);
                                     unset($report[$r]['Profitsharing']);
                                     unset($report[$r]['Percentage']);

                                 }*/
                                 
                                 
                                
                                $agentallmonthsreport[$m]['month'] = $M;


                                 $agentallmonthsreport[$m]['Agent'] = AgentModel::getAgent($_POST['Agent'], "Name");
                                 
                                
                                 $agentallmonthsreport[$m]['In'] = $data['In'];
                                 $agentallmonthsreport[$m]['Out'] = $data['Out'];
                                 $agentallmonthsreport[$m]['Commission'] = $data['Commission'];
                                 $agentallmonthsreport[$m]['Bonus'] = $data['Bonus'];
                                 $agentallmonthsreport[$m]['Profit'] = $data['Profit'];
                                 /*$agentallmonthsreport[$m]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $agentallmonthsreport[$m]['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);
                                 
                                 //Debug::displayArray($monthsreport);



                            
                        
                        }
                        $agentallmonthsreport['year'] = $_POST['Year'];
                        $agentallmonthsreport['count'] = count($agentallmonthsreport);
                    
			//$agentallmonthsreport = AgentModel::getFrontAgentAllMonthsReport($_POST['Agent']);

		}
		
                $result2 = AgentModel::getAdminAgentAllParentChild();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Report By Month", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/report.inc.php', 'agent_delete' => $_SESSION['admin']['agent_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agent_common.inc.php'),
		//'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Dashboard"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"View Report By Month"),
		'content' => $transaction,
		'months' => $monthsreport,
		'agentmonths' => $agentmonthsreport,
		'agentallmonths' => $agentallmonthsreport,
		'filters' => array('years' => array_reverse($years), 'months' => $month),
		'content_param' => array('query_title' => $query_title, 'search' => $search, 'agent_list' => AgentModel::getAgentList(), 'enabled_list' => CRUD::getActiveList(), 'agent_list1' => $result2['result2'], 'agent_list2' => $result2['result3']),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agent_delete']);

		return $this->output;
	}
        
        public function APIGetAgentData($param)
        {
            // Initiate REST API class
            $restapi = new RestAPI();

            // Get method
            $method = $restapi->getMethod();

            if ($method=="GET")
            {
                // Get all request data
                $request_data = $restapi->getRequestData();
                
                $urlDecodedDomain = urldecode($_GET['domain']);
                
                $result = AgentModel::getDomainWithSubdomain($urlDecodedDomain);
                //echo '<pre>';
                //print_r($result);
                //echo '</pre>';
                //exit;
                
                if($result[0]['subdomainStatus']=='None')
                {
                    
                    $result = AgentModel::getDomain($urlDecodedDomain);
                    
                }    

                $output['Count'] = 1;
                $output['Content'] = $result;

                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode($output);
                    $restapi->setResponse('200', 'OK', $result);
                }
                else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
            else
            {
                $restapi->setResponse('405', 'HTTP Method Not Accepted');
            }
        }
        
        
        public function AgentReport($param)
	{
            
            //Debug::displayArray($_POST);
            
		$filename = __FUNCTION__;

		$query_condition = "";

		$crud = new CRUD();

		// Reset Query Variable
		$_SESSION['agent_'.__FUNCTION__] = "";

		$_SESSION['agent_'.__FUNCTION__]['Agent'] = $_POST['Agent'];

		$_SESSION['agent_'.__FUNCTION__]['Month'] = $_POST['Month'];

		$_SESSION['agent_'.__FUNCTION__]['Year'] = $_POST['Year'];

		if($_POST['Trigger'] =='search_form' && $_POST['Month'] != '0'){
		// Initialise query conditions


			



		if ($_GET['page']=="all")
		{
			//echo $_GET['page'];
			//echo 'hi';
			$_GET['page'] = "";
			unset($_SESSION['agent_'.__FUNCTION__]);
			//unset($_SESSION['agent_'.__FUNCTION__]['Year']);
		}

		if ($_POST['Trigger'] =='search_form' && $_POST['Year'] != '' && $_POST['Month'] != '0' && $_POST['Agent'] == '')
		{



		// Reset query conditions


		// Determine Title
		if (isset($_SESSION['agent_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

        
	    $transaction = array();


		$sql_agents = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
		$agents = array();
		$j = 0;
                
                
                        $tier_agents = 1;
                        foreach ($this->dbconnect->query($sql_agents) as $row)
                        {
                                $agents[$j] = array(
                                        'Child'=> AgentModel::getTopAgentChild($row['ID'], $tier_agents)
                                    );
                                        

                                $j += 1;
                        }

                        $agents['count'] = $j;
                        

                        $set = array();
                        
                        $ID = AgentModel::childAncestors($agents[0]['Child'], $set);
                        
                        //Debug::displayArray($ID);
                        //exit;
                        $ID['count'] = count($ID);
                        $_SESSION['pad'] = array();
                        array_walk($ID, 'AgentModel::getTest');

                        $maxpadding = max($_SESSION['pad']);
                                               
			
                        
                        unset($_SESSION['pad']);
		//echo $agents['count'];

		for ($z=0; $z <$ID['count'] ; $z++) {

			

				//$transaction[$z] = array(
				//'Report' => AgentModel::getAgentAdminReport($ID[$z][0], $filename),
                                //'Padding' => $ID[$z][1] 
				//);
                                
                                
                                //echo $g;
                                $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $ID[$z][0]);
                                //Debug::displayArray($_SESSION['agentchild']);
                                //exit;
                                $count = AgentModel::getAgentChildExist($ID[$z][0]);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($ID[$z][0]);
                                }


                                $child = implode(',', $_SESSION['agentchild']);
                                //echo $child;
                                //exit;

                                unset($_SESSION['agentchild']);
                                                       
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                
                                $data = array();    

                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $_POST['Month']);
                                 //}
                                 //Debug::displayArray($report);
                                 //exit;

                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                     
                                     unset($report[$r]['In']);
                                     unset($report[$r]['Out']);
                                     unset($report[$r]['Commission']);
                                     unset($report[$r]['Bonus']);
                                     unset($report[$r]['Profit']);
                                     unset($report[$r]['Profitsharing']);
                                     unset($report[$r]['Percentage']);

                                 }*/
                                 
                                 
                                
                                

                                   
                                 $transaction[$z]['Agent'] = AgentModel::getAgent($ID[$z][0], "Name");
                                 
                                 //$monthsreport[$m][$g]['Agent'] = 
                                 $transaction[$z]['Padding'] = $ID[$z][1];
                                 $transaction[$z]['In'] = $data['In'];
                                 $transaction[$z]['Out'] = $data['Out'];
                                 $transaction[$z]['Commission'] = $data['Commission'];
                                 $transaction[$z]['Bonus'] = $data['Bonus'];
                                 $transaction[$z]['Profit'] = $data['Profit'];
                                 /*$transaction[$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $transaction[$z]['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 //unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);

		





		}

                    
                    $transaction['count'] = $z;
                    $transaction['Padding'] = $maxpadding;
		}

		}

		$month = array();

		$month[1] = 'January';
		$month[2] = 'February';
		$month[3] = 'March';
		$month[4] = 'April';
		$month[5] = 'May';
		$month[6] = 'June';
		$month[7] = 'July';
		$month[8] = 'August';
		$month[9] = 'September';
		$month[10] = 'October';
		$month[11] = 'November';
		$month[12] = 'December';

		$month['count'] = '12';



		$years = array();
		$startyear =  '2013';
		$currentyear = date("Y");
		if($startyear == $currentyear){

		  	$years[0] = $startyear;
			$years['count'] = 1;
		}else{

		  $yeardifference = $currentyear - $startyear;
		  //echo $yeardifference.'<br />';

			for ($z=0; $z <= $yeardifference; $z++) {
				//echo 'hi <br />';
			$years[$z] = $startyear + $z;

		    }
   			$years['count'] = $z;
		}

		if($_POST['Trigger'] =='search_form' && $_POST['Month'] == '0' && $_POST['Agent'] == ''){
                          //echo 'hi';              
                        $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
                        //echo $sql2;
                        //exit;
                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getTopAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }

                        $result2['count'] = $z;
                        
                        /*$_SESSION['agentchild'] = array();
                        array_push($_SESSION['agentchild'], $ID[$z][0]);
                        //Debug::displayArray($_SESSION['agentchild']);
                        //exit;
                        $count = AgentModel::getAgentChildExist($ID[$z][0]);

                        if($count>'0')
                        {
                            AgentModel::getAgentAllChild($ID[$z][0]);
                        }


                        $child = implode(',', $_SESSION['agentchild']);

                        unset($_SESSION['agentchild']);*/
                        
                        //Debug::displayArray($result2);
                        //exit;

                        $set = array();
                        
                        $ID = AgentModel::childAncestors($result2[0]['Child'], $set);
                    
                        $_SESSION['pad'] = array();
                        array_walk($ID, 'AgentModel::getTest');

                        $maxpadding = max($_SESSION['pad']);
                        
                        $ID['count'] = count($ID);
                                                                   
                        $report = array();
                        $monthsreport = array();
                        
                        for ($m = 1; $m <= 12; $m++) {
                            
                        
                        
                            for ($g = 0; $g < $ID['count']; $g++) {

                                //echo $g;
                                $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $ID[$g][0]);

                                $count = AgentModel::getAgentChildExist($ID[$g][0]);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($ID[$g][0]);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';    
                                unset($_SESSION['agentchild']);
                                $IDarray = explode(",", $child);
                                //unset($child);
                                $IDarray['count'] = count($IDarray);
                                
                                switch ($m) {
                                    case 1:
                                        $M = "January";
                                        break;
                                    case 2:
                                        $M = "February";
                                        break;
                                    case 3:
                                        $M = "March";
                                        break;
                                    case 4:
                                        $M = "April";
                                        break;
                                    case 5:
                                        $M = "May";
                                        break;
                                    case 6:
                                        $M = "June";
                                        break;
                                    case 7:
                                        $M = "July";
                                        break;
                                    case 8:
                                        $M = "August";
                                        break;
                                    case 9:
                                        $M = "September";
                                        break;
                                    case 10:
                                        $M = "October";
                                        break;
                                    case 11:
                                        $M = "November";
                                        break;
                                    case 12:
                                        $M = "December";
                                        break;
                                }

                                $data = array();    

                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $M);    
                               
                                     //$report[$c] = AgentModel::getNewFrontAgentsMonthsReport($filename, $IDarray[$c], $M);
                                 //}
                                 //Debug::displayArray($report);
                                 //exit;

                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                     
                                     unset($report[$r]['In']);
                                     unset($report[$r]['Out']);
                                     unset($report[$r]['Commission']);
                                     unset($report[$r]['Bonus']);
                                     unset($report[$r]['Profit']);
                                     unset($report[$r]['Profitsharing']);
                                     unset($report[$r]['Percentage']);

                                 }*/
                                 
                                 
                                
                                $monthsreport[$m]['Month'] = $M;

                                
                                 $monthsreport[$m][$g]['Agent'] = AgentModel::getAgent($ID[$g][0], "Name");
                                 
                                 //$monthsreport[$m][$g]['Agent'] = 
                                 $monthsreport[$m][$g]['Padding'] = $ID[$g][1];
                                 $monthsreport[$m][$g]['In'] = $data['In'];
                                 $monthsreport[$m][$g]['Out'] = $data['Out'];
                                 $monthsreport[$m][$g]['Commission'] = $data['Commission'];
                                 $monthsreport[$m][$g]['Bonus'] = $data['Bonus'];
                                 $monthsreport[$m][$g]['Profit'] = $data['Profit'];
                                 /*$monthsreport[$m][$g]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $monthsreport[$m][$g]['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);
                                 
                                 //Debug::displayArray($monthsreport);



                            }
                        
                        }
                        $monthsreport['year'] = $_SESSION['agent_'.$filename]['Year'];
                        $monthsreport['padding'] = $maxpadding;
                        $monthsreport['count'] = $ID['count'];
                        //Debug::displayArray($monthsreport);
                        
                        //exit;
                                               
			//$monthsreport = AgentModel::getFrontAgentsMonthsReport($filename, $agent, $ID, $maxpadding);
                        
                        unset($_SESSION['pad']);
                        
                        //}
                        
                        
		}elseif($_POST['Trigger'] =='search_form' && $_POST['Month'] != '0'  && $_POST['Agent'] != ''){
			
			//$agentmonthsreport = AgentModel::getAgentMonthsReport($filename, $_POST['Agent']);
			$agentmonthsreport = array();
                        $report = array();
                        $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $_POST['Agent']);

                                $count = AgentModel::getAgentChildExist($_POST['Agent']);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($_POST['Agent']);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';    
                                unset($_SESSION['agentchild']);
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                
                                $data = array();

                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $_POST['Month']);
                                 //}
                                 
                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                                                         

                                 }*/
                                                                                                                                             

                                 $agentmonthsreport['Agent'] = AgentModel::getAgent($_POST['Agent'], "Name");
                                                                  
                                 $agentmonthsreport['In'] = $data['In'];
                                 $agentmonthsreport['Out'] = $data['Out'];
                                 $agentmonthsreport['Commission'] = $data['Commission'];
                                 $agentmonthsreport['Bonus'] = $data['Bonus'];
                                 $agentmonthsreport['Profit'] = $data['Profit'];
                                 /*$agentmonthsreport['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $agentmonthsreport['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);
                                 
                                 $agentmonthsreport['count'] = 1;
                                 $agentmonthsreport['month'] = $_POST['Month'];
                                 $agentmonthsreport['year'] = $_POST['Year'];
                        
		}elseif($_POST['Trigger'] =='search_form' && $_POST['Month'] == '0'  && $_POST['Agent'] != ''){
                    $agentallmonthsreport = array(); 
                    
                    for ($m = 1; $m <= 12; $m++) {


                                //echo $g;
                                $_SESSION['agentchild'] = array();
                                array_push($_SESSION['agentchild'], $_POST['Agent']);

                                $count = AgentModel::getAgentChildExist($_POST['Agent']);

                                if($count>'0')
                                {
                                    AgentModel::getAgentAllChild($_POST['Agent']);
                                }


                                $child = implode(',', $_SESSION['agentchild']);


                                //echo $child.'<br>';    
                                unset($_SESSION['agentchild']);
                                //$IDarray = explode(",", $child);
                                //unset($child);
                                //$IDarray['count'] = count($IDarray);
                                
                                switch ($m) {
                                    case 1:
                                        $M = "January";
                                        break;
                                    case 2:
                                        $M = "February";
                                        break;
                                    case 3:
                                        $M = "March";
                                        break;
                                    case 4:
                                        $M = "April";
                                        break;
                                    case 5:
                                        $M = "May";
                                        break;
                                    case 6:
                                        $M = "June";
                                        break;
                                    case 7:
                                        $M = "July";
                                        break;
                                    case 8:
                                        $M = "August";
                                        break;
                                    case 9:
                                        $M = "September";
                                        break;
                                    case 10:
                                        $M = "October";
                                        break;
                                    case 11:
                                        $M = "November";
                                        break;
                                    case 12:
                                        $M = "December";
                                        break;
                                }

                                $data = array();
                                //for ($c = 0; $c < $IDarray['count']; $c++) {
                                     $data = AgentModel::getNewFrontAgentsMonthsReport($filename, $child, $M);
                                 //}
                                 //Debug::displayArray($report);
                                 //exit;

                                 /*$report['count'] = count($report);
                                 $In = 0;
                                 $Out = 0;
                                 $Commission = 0;
                                 $Bonus = 0;
                                 $Profit = 0;
                                 $Profitsharing = 0;
                                 $Percentage = 0;
                                 
                                 for ($r = 0; $r < $report['count']; $r++) {
                                     
                                     $In += $report[$r]['In'];
                                     $Out += $report[$r]['Out'];
                                     $Commission += $report[$r]['Commission'];
                                     $Bonus += $report[$r]['Bonus'];
                                     $Profit += $report[$r]['Profit'];
                                     $Profitsharing += $report[$r]['Profitsharing'];
                                     $Percentage += $report[$r]['Percentage'];
                                     
                                     unset($report[$r]['In']);
                                     unset($report[$r]['Out']);
                                     unset($report[$r]['Commission']);
                                     unset($report[$r]['Bonus']);
                                     unset($report[$r]['Profit']);
                                     unset($report[$r]['Profitsharing']);
                                     unset($report[$r]['Percentage']);

                                 }*/
                                 
                                 
                                
                                $agentallmonthsreport[$m]['month'] = $M;


                                 $agentallmonthsreport[$m]['Agent'] = AgentModel::getAgent($_POST['Agent'], "Name");
                                 
                                
                                 $agentallmonthsreport[$m]['In'] = $data['In'];
                                 $agentallmonthsreport[$m]['Out'] = $data['Out'];
                                 $agentallmonthsreport[$m]['Commission'] = $data['Commission'];
                                 $agentallmonthsreport[$m]['Bonus'] = $data['Bonus'];
                                 $agentallmonthsreport[$m]['Profit'] = $data['Profit'];
                                 /*$agentallmonthsreport[$m]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                                 $agentallmonthsreport[$m]['Percentage'] = Helper::displayCurrency($Percentage);*/

                                 //Debug::displayArray($monthsreport);
                                 //exit;
                                 unset($report);
                                 unset($profit);
                                 unset($In);
                                 unset($Out);
                                 unset($Commission);
                                 unset($Bonus);
                                 unset($Total);
                                 unset($Percentage);
                                 unset($IDarray);
                                 
                                 //Debug::displayArray($monthsreport);



                            
                        
                        }
                        $agentallmonthsreport['year'] = $_POST['Year'];
                        $agentallmonthsreport['count'] = count($agentallmonthsreport);
                    
			//$agentallmonthsreport = AgentModel::getFrontAgentAllMonthsReport($_POST['Agent']);

		}


                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }

                    $result2['count'] = $z;
                                       
   
                    

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "View Report By Month", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/report.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		//'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Dashboard"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"View Report By Month"),
                'agent' => $result2,
		'content' => $transaction,
		'months' => $monthsreport,
		'agentmonths' => $agentmonthsreport,
		'agentallmonths' => $agentallmonthsreport,
		'filters' => array('years' => array_reverse($years), 'months' => $month),
		'content_param' => array('query_title' => $query_title, 'search' => $search, 'agent_list' => AgentModel::getAgentListByParent($_SESSION['agent']['ID']), 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));


		return $this->output;
	}
        
        
        public function AgentDownline($param) 
	{		
		// Initialise query conditions
		$query_condition = "";
		
		$crud = new CRUD();
		
		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['agent_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE", 1);
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			
			$_SESSION['agent_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			
			// Set Query Variable
			$_SESSION['agent_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agent_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agent_'.__FUNCTION__]);			
		}

		// Determine Title
		if (isset($_SESSION['agent_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent WHERE ID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agent_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/agent/agent/downline';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM agent WHERE ID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agent_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
                //echo $sql;
                //exit;
		
		$result = array();
		$i = 0;
                
                $tier = 1;
                
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'Child' => $this->getAgentChild($row['ID'], $tier),
			'Name' => $row['Name'],
			'Description' => $row['Description']);
			
			$i+=1;
		}
                $result['count'] = $i;
                
                $_SESSION['agent']['redirect'] = __FUNCTION__;
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "My Agents", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/downline.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Downline"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		
					
		return $this->output;
	}
        	
	public function View($param)
	{
		$sql = "SELECT * FROM agent WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToLongDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => $row['Nationality'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function AgentDashboard()
    {
    	//unset($_SESSION['agent']['Credit']);
        $product_list['casino'] = ProductModel::getProductListByType('1');

        $product_list['soccer'] = ProductModel::getProductListByType('2');

        $product_list['horse'] = ProductModel::getProductListByType('3');

        $product_list['main'] = ProductModel::getProductListByType('5');

		AgentModel::getAgentCredit($_SESSION['agent']['ID']);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Dashboard", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/dashboard.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Dashboard"),
        'content2' => $product_list,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['agent']['agent_login']);
		/*Debug::displayArray($this->output['breadcrumb']);
		exit;*/
        return $this->output;
    }
    
    public function AgentDelete($param)
	{
                $company = $this->getAgent($param, "Company");
                $host = $this->getAgent($param, "Host");
        
                $sql2 = "DELETE FROM wallet WHERE AgentID ='".$param."'";
		$count2 = $this->dbconnect->exec($sql2);
            
		$sql = "DELETE FROM agent WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
                
                $sql3 = "DELETE FROM agent_promotion WHERE AgentID ='".$param."'";
		$count3 = $this->dbconnect->exec($sql3);
                
                $sql4 = "DELETE FROM agent_block WHERE AgentID ='".$param."'";
		$count4 = $this->dbconnect->exec($sql4);
                
                $sql5 = "DELETE FROM bank_info WHERE AgentID ='".$param."'";
		$count5 = $this->dbconnect->exec($sql5);
                
                Helper::deleteListRecord($company, $host);

        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Agent...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function AgentProfile()
    {
        $sql = "SELECT * FROM agent WHERE ID = '".$_SESSION['agent']['ID']."'";
		/*echo $sql;
		exit;*/
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            if ($row['Logo']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['Logo'],'thumb');
            }
            
            $result[$i] = array(
            'ID' => $row['ID'],
            'Profitsharing' => $row['Profitsharing'],
            'Name' => $row['Name'],
            'Company' => $row['Company'],
            'Bank' => $row['Bank'],
            'BankAccountNo' => $row['BankAccountNo'],
            'Username' => $row['Username'],
            'PhoneNo' => $row['PhoneNo'],
            'FaxNo' => $row['FaxNo'],
            'MobileNo' => $row['MobileNo'],
            'Email' => $row['Email'],
            'PlatformEmail1' => $row['PlatformEmail1'],
            'PlatformEmail2' => $row['PlatformEmail2'],
            'PlatformEmail3' => $row['PlatformEmail3'],
            'PlatformEmail4' => $row['PlatformEmail4'],    
            'PlatformEmail5' => $row['PlatformEmail5'],
            'PlatformEmail6' => $row['PlatformEmail6'],
            'PlatformEmail7' => $row['PlatformEmail7'],
            'PlatformEmail8' => $row['PlatformEmail8'],
            'PlatformEmail9' => $row['PlatformEmail9'],
            'PlatformEmail10' => $row['PlatformEmail10'],    
            'BackgroundColour' => $row['BackgroundColour'], 
            'FontColour' => $row['FontColour'],
            'LogoCover' => $cover_image,
            'Logo' => $row['Logo']);
            
            $product = explode(',', $row['Product']);
                     
                     $product['count'] = count($product);
                      
                     $_SESSION['ParentID'] = $row['ParentID'];

            $i += 1;
        }

		// Debug::displayArray($result);
		// exit;

        if ($_SESSION['agent']['agent_profile_info']!="")
        {
            $form_input = $_SESSION['agent']['agent_profile_info'];

            // Unset temporary agent info input
            unset($_SESSION['agent']['agent_profile_info']);
        }

		AgentModel::getAgentCredit($_SESSION['agent']['ID']);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "My Profile", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/profile.inc.php', 'agent_profile' => $_SESSION['agent']['agent_profile']),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"My Profile"),
        'content' => $result,
        'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'product_list' => ProductModel::getProductList(), 'product' => $product),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['agent']['agent_profile']);

        return $this->output;
    }

    public function AgentProfileProcess($param)
    {
        $error = array();
                               
        $emailDiff = AgentModel::getAgent($param, "Email");

        if (strcasecmp($emailDiff, $_POST['Email']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentEmail = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['Email']);

            if($agentEmailCount>'0')
            {
                $i_agentEmail += 1;
            } 



            $error['count'] += $i_agentEmail; 

        }
        
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail1");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail1']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail1 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail1']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail1 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail1;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail2");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail2']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail2 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail2']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail2 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail2;

        }
        
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail3");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail3']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail3 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail3']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail3 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail3;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail4");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail4']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail4 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail4']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail4 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail4;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail5");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail5']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail5 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail5']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail5 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail5;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail6");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail6']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail6 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail6']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail6 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail6;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail7");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail7']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail7 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail7']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail7 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail7;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail8");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail8']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail8 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail8']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail8 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail8;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail9");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail9']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail9 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail9']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail9 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail9;

        }
        
        $emailDiff = AgentModel::getAgent($param, "PlatformEmail10");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail10']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail10 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail10']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail10 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail10;

        }
        
        
        // Handle Image Upload
        $upload['Logo'] = File::uploadFile('Logo',1,2,"agent");

        if ($upload['Logo']['upload']['status']=="Empty")
        {
            if ($_POST['LogoRemove']==1)
            {
                $file_location['Logo'] = "";
                Image::deleteImage($_POST['LogoCurrent']);
                Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'cover'));
            }
            else
            {
                $file_location['Logo'] = $_POST['LogoCurrent'];
            }
        }
        else if ($upload['Logo']['upload']['status']=="Uploaded")
        {
            $file_location['Logo'] = $upload['Logo']['upload']['destination'];
            Image::generateImage($file_location['Logo'],66,66,'thumb');
            Image::generateImage($file_location['Logo'],145,145,'cover');
            Image::generateImage($file_location['Logo'],300,300,'medium');
            Image::deleteImage($_POST['LogoCurrent']);
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['Logo'] = $upload['Logo']['error'];

            $file_location['Logo'] = "";
        }
        
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM agent WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$_SESSION['agent']['ID']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                #$i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM agent WHERE Passport = '".$_POST['Passport']."' AND ID != '".$_SESSION['agent']['ID']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                #$i_passport += 1;
            }
        }

        //$error['count'] = $i_nric + $i_passport;

        if ($error['count']>0)
        {
            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }
            
            if ($i_agentEmail>0)
            {
                $error['Email'] = 1;
            }
            
            if ($i_agentPlatformEmail1>0)
            {
                $error['PlatformEmail1'] = 1;
            }
            
            if ($i_agentPlatformEmail2>0)
            {
                $error['PlatformEmail2'] = 1;
            }
            
            if ($i_agentPlatformEmail3>0)
            {
                $error['PlatformEmail3'] = 1;
            }
            
            if ($i_agentPlatformEmail4>0)
            {
                $error['PlatformEmail4'] = 1;
            }
            
            if ($i_agentPlatformEmail5>0)
            {
                $error['PlatformEmail5'] = 1;
            }
            
            if ($i_agentPlatformEmail6>0)
            {
                $error['PlatformEmail6'] = 1;
            }
            
            if ($i_agentPlatformEmail7>0)
            {
                $error['PlatformEmail7'] = 1;
            }
            
            if ($i_agentPlatformEmail8>0)
            {
                $error['PlatformEmail8'] = 1;
            }
            
            if ($i_agentPlatformEmail9>0)
            {
                $error['PlatformEmail9'] = 1;
            }
            
            if ($i_agentPlatformEmail10>0)
            {
                $error['PlatformEmail10'] = 1;
            }
                      
            $_SESSION['agent']['agent_profile_info'] = Helper::unescape($_POST);
        }
        else
        {
            
            $concat = '';
                 
            
            $_POST['Product']['count'] = count($_POST['Product']);

            for ($i=0; $i<$_POST['Product']['count']; $i++) {

                    $concat.=$_POST['Product'][$i];
                    $z = $i + 1;
                    if($z===$_POST['Product']['count']){



                    }
                    else 
                    {
                        $concat.=',';
                    }
                    
                   

            }
            
            
            $member = MemberModel::getMemberAgent($_SESSION['agent']['ID']);
            //Debug::displayArray($member);
            
            $prod = array();
            
            for ($i=0; $i<$_POST['Product']['count']; $i++) {
                array_push($prod, $_POST['Product'][$i]);
            }
            
           
            
            $ProductList = AgentModel::getAgentProduct($_SESSION['agent']['ID']);
                        
            $ProductList = explode(',', $ProductList);

            $ProductList['count'] = count($ProductList);
            
            $intersect = array_intersect($prod, $ProductList);
            
            $intersect = array_values($intersect);
            
            if(empty($concat)===TRUE)
            {
                
                $sql = "DELETE FROM wallet WHERE AgentID = '".$_SESSION['agent']['ID']."'";
                
		$count = $this->dbconnect->exec($sql);
            }
            else 
            {                           
                if(empty($intersect)===TRUE){

                    $sql = "DELETE FROM wallet WHERE AgentID = '".$_SESSION['agent']['ID']."'";

                    $count = $this->dbconnect->exec($sql);
                    
                     
                    
                    for ($i=0; $i<$_POST['Product']['count']; $i++) {
                        
                        for ($z=0; $z <$member['count']; $z++)
                        {
                            $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                            $value = "('0', '".$_POST['Product'][$i]."', '".$_SESSION['agent']['ID']."', '".$member[$z]['ID']."', '1')";

                            $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;
                            //echo $sql2;
                            //exit;
                            $this->dbconnect->exec($sql2);
                        }
                    }
                    

                }elseif(empty($intersect)===FALSE){
                    //echo 'hi';
                    //exit;
                    //Debug::displayArray($intersect);
                    //exit;
                    $productdeleted = implode(',', $intersect);
                    //Debug::displayArray($productdeleted);
                    //exit;
                    
                    $sql = "DELETE FROM wallet WHERE AgentID = '".$_SESSION['agent']['ID']."' AND ProductID NOT IN (".$productdeleted.")";
                    //echo $sql;
                    //exit;
                    $count = $this->dbconnect->exec($sql);
                    
                    $newProductList = AgentModel::getAgentProduct($_SESSION['agent']['ID']);
                    $newProductList = explode(',', $newProductList);
                    
                    //Debug::displayArray($prod);
                    //Debug::displayArray($newProductList);
                    //exit;
                                       
                    $newProd = array_diff($prod, $newProductList);
                    
                    //Debug::displayArray($newProd);
                    //exit;
                    if(empty($newProd)===TRUE)
                    {
                        
                    }
                    else
                    {
                        $newProd = array_values($newProd);
                        $newProd['count'] = count($newProd);
                        
                        for ($i=0; $i<$newProd['count']; $i++) {
                        
                            for ($z=0; $z <$member['count']; $z++)
                            {
                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                $value = "('0', '".$newProd[$i]."', '".$_SESSION['agent']['ID']."', '".$member[$z]['ID']."', '1')";

                                $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;
                                //echo $sql2;
                                //exit;
                                $this->dbconnect->exec($sql2);
                            }
                        }
                        
                    }    
                    
                }
            }
            
            
            
            $sql = "UPDATE agent SET Name='".$_POST['Name']."', Product='".$concat."', Company='".$_POST['Company']."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', MobileNo='".$_POST['MobileNo']."', PlatformEmail1='".$_POST['PlatformEmail1']."', PlatformEmail2='".$_POST['PlatformEmail2']."', PlatformEmail3='".$_POST['PlatformEmail3']."', PlatformEmail4='".$_POST['PlatformEmail4']."', PlatformEmail5='".$_POST['PlatformEmail5']."', PlatformEmail6='".$_POST['PlatformEmail6']."', PlatformEmail7='".$_POST['PlatformEmail7']."', PlatformEmail8='".$_POST['PlatformEmail8']."', PlatformEmail9='".$_POST['PlatformEmail9']."', PlatformEmail10='".$_POST['PlatformEmail10']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', BackgroundColour='".$_POST['BackgroundColour']."', FontColour='".$_POST['FontColour']."', Logo='".$file_location['Logo']."' WHERE ID='".$_SESSION['agent']['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Profile...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function AgentPassword()
    {
    	AgentModel::getAgentCredit($_SESSION['agent']['ID']);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Change Password", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/password.inc.php', 'agent_password' => $_SESSION['agent']['agent_password']),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Change Password"),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['agent']['agent_password']);

        return $this->output;
    }

    public function AgentPasswordProcess()
    {
        // Update new password if current password is entered correctly
        $bcrypt = new Bcrypt(9);
        $verify = $bcrypt->verify($_POST['Password'], $this->getHash($_SESSION['agent']['ID']));

        if(isset($_SESSION['agent']['operator']['ProfileID'])===TRUE && empty($_SESSION['agent']['operator']['ProfileID'])===FALSE)
        {   
            if ($verify==1)
            {
                $hash = $bcrypt->hash($_POST['PasswordNew']);

                // Save new password and disable Prompt
                $sql = "UPDATE operator SET Password='".$hash."' WHERE ID='".$_SESSION['agent']['operator']['RowID']."'";
                $count = $this->dbconnect->exec($sql);

                // Set Status
                $ok = ($count<=1) ? 1 : "";
            }
            else
            {
                // Current password incorrect
                $error['count'] += 1;
                $error['Password'] = 1;
            }
        }
        else
        {
            if ($verify==1)
            {
                $hash = $bcrypt->hash($_POST['PasswordNew']);

                // Save new password and disable Prompt
                $sql = "UPDATE agent SET Password='".$hash."', Prompt = 0 WHERE ID='".$_SESSION['agent']['ID']."'";
                $count = $this->dbconnect->exec($sql);

                // Set Status
                $ok = ($count<=1) ? 1 : "";
            }
            else
            {
                // Current password incorrect
                $error['count'] += 1;
                $error['Password'] = 1;
            }
        }    

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Updating Password...", 'template' => 'common.tpl.php'),
        'content_param' => array('count' => $count),
        'secure' => TRUE,
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function AgentIndex()
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Agent Home", 'template' => 'agent.common.tpl.php'),
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        return $this->output;
    }
    
    public function AgentAgentList($param)
    {
        
        if(empty($param)===true)
        {
            $param = $_SESSION['agent']['ID'];
            $title = "Agent List";
        }
        else
        {
            $title = 'Agent: '.AgentModel::getAgent($param, "Name");
        }   
        
        $result = array();
        $firstChildren = array();
        
        $firstChildren = AgentModel::getAgentFirstChildrenDetails($param);
        
        for ($i = 0; $i < $firstChildren['count']; $i++) {
            
            $result[$i]['ID'] = $firstChildren[$i]['ID'];
            $result[$i]['Username'] = $firstChildren[$i]['Username'];
            $result[$i]['Name'] = $firstChildren[$i]['Name'];
            $result[$i]['Registered'] = $firstChildren[$i]['Registered'];
            $result[$i]['Enabled'] = $firstChildren[$i]['Enabled'];
            $result[$i]['Profitsharing'] = $firstChildren[$i]['Profitsharing'];
            $result[$i]['Downline'] = AgentModel::getAgentFirstChildren($firstChildren[$i]['ID']);
            $result[$i]['Member'] = MemberModel::getMemberByAgent($firstChildren[$i]['ID']);
            
        }
        
        $result['count'] = $i;
        
            $parentID = AgentModel::getAgent($param, "ParentID");
        
            $this->output = array(
		'config' => $this->config,
		'page' => array('title' => $title, 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/agentlist.inc.php'),
                'parent' => $parentID,
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),   
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agentlist_url.'/'.$_SESSION['agent']['ID'],"",$this->config,"Agent List"),
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
                'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));
                
		return $this->output;
    }
    
    public function AdminAgentList($param)
    {
       // Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['agent_'.__FUNCTION__] = "";

			
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
            $query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			

			
			$_SESSION['agent_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
            $_SESSION['agent_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			

			// Set Query Variable
			$_SESSION['agent_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agent_'.__FUNCTION__]['query_title'] = "Search Results";
		}
		
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agent_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agent_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}
		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent ".$_SESSION['agent_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/agent/agentlist';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM agent ".$_SESSION['agent_'.__FUNCTION__]['query_condition']." ORDER BY ID ASC LIMIT $start, $limit";
		//echo $sql;
                //exit;
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
			'Username' => $row['Username']);

			$i += 1;
		}

            if(empty($param)===TRUE)
            {

                //$decision = FALSE;
                $result = array();
                $i = 0;

                $sql = "SELECT * FROM agent WHERE Enabled = 1 AND ParentID = '0'";

                foreach($this->dbconnect->query($sql) as $row)
                {
                    $result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
                        'Username' => $row['Username'],
                        'Profitsharing' => $row['Profitsharing'],
                        'Registered' => $row['Registered'],
                        'Enabled' => CRUD::isActive($row['Enabled']));

                    $i += 1;
                }

                $result['count'] = $i;

                for ($z = 0; $z < $result['count']; $z++) {

                    $result[$z]['ID'] = $result[$z]['ID'];
                    $result[$z]['Username'] = $result[$z]['Username'];
                    $result[$z]['Name'] = $result[$z]['Name'];
                    $result[$z]['Registered'] = $result[$z]['Registered'];
                    $result[$z]['Enabled'] = $result[$z]['Enabled'];
                    $result[$z]['Profitsharing'] = $result[$z]['Profitsharing'];
                    $result[$z]['Downline'] = AgentModel::getAgentFirstChildren($result[$z]['ID']);
                    $result[$z]['Member'] = MemberModel::getMemberByAgent($result[$z]['ID']);

                }

                $result['count'] = $z;



                $title = "Agent List";
            }

            if(empty($param)===FALSE)
            {

                $result = array();
                $firstChildren = array();

                $firstChildren = AgentModel::getAgentFirstChildrenDetails($param);

                for ($i = 0; $i < $firstChildren['count']; $i++) {

                    $result[$i]['ID'] = $firstChildren[$i]['ID'];
                    $result[$i]['Username'] = $firstChildren[$i]['Username'];
                    $result[$i]['Name'] = $firstChildren[$i]['Name'];
                    $result[$i]['Registered'] = $firstChildren[$i]['Registered'];
                    $result[$i]['Enabled'] = $firstChildren[$i]['Enabled'];
                    $result[$i]['Profitsharing'] = $firstChildren[$i]['Profitsharing'];
                    $result[$i]['Downline'] = AgentModel::getAgentFirstChildren($firstChildren[$i]['ID']);
                    $result[$i]['Member'] = MemberModel::getMemberByAgent($firstChildren[$i]['ID']);

                }

                $result['count'] = $i;


                /*$sql2 = "SELECT * FROM agent WHERE ID = '".$param."' AND Enabled = '1'";

		$currentAgent = array();

		foreach ($this->dbconnect->query($sql2) as $row2)
		{
			$currentAgent[0] = array(
			'ID' => $row2['ID'],
			'Name' => $row2['Name'],
                        'Username' => $row2['Username'],
                        'Profitsharing' => $row2['Profitsharing'],
                        'Registered' => $row2['Registered'],
                        'Enabled' => CRUD::isActive($row2['Enabled']));


		}

                $currentAgent[0]['ID'] = $currentAgent[0]['ID'];
                $currentAgent[0]['Username'] = $currentAgent[0]['Username'];
                $currentAgent[0]['Name'] = $currentAgent[0]['Name'];
                $currentAgent[0]['Registered'] = $currentAgent[0]['Registered'];
                $currentAgent[0]['Enabled'] = $currentAgent[0]['Enabled'];
                $currentAgent[0]['Profitsharing'] = $currentAgent[0]['Profitsharing'];
                $currentAgent[0]['Downline'] = AgentModel::getAgentFirstChildren($currentAgent[0]['ID']);
                $currentAgent[0]['Member'] = MemberModel::getMemberByAgent($currentAgent[0]['ID']);*/
                $title = 'Agent: '.AgentModel::getAgent($param, "Name");

            }

            $parentID = AgentModel::getAgent($param, "ParentID");

            $this->output = array(
		'config' => $this->config,
		'page' => array('title' => $title, 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/agentlist.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_adminlist_url,"admin",$this->config,"Agent List"),
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
                'content' => $result,
                'parent' => $parentID,
                'decision' => empty($param),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
    }

    public function AgentRegister()
    {
        if ($_SESSION['admin']['agent_register_info']!="")
        {
            $form_input = $_SESSION['admin']['agent_register_info'];

            // Unset temporary agent info input
            unset($_SESSION['admin']['agent_register_info']);
        }

        $captcha[0] = rand(1,5);
        $captcha[1] = rand(1,4);

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Register", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/register.inc.php', 'agent_register' => $_SESSION['agent']['agent_register']),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent_out.inc.php', 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Register"),
        'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'state_list' => StateModel::getStateList(), 'country_list' => CountryModel::getCountryList()),
        'form_param' => $form_input,
        'captcha' => $captcha,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['admin']['agent_register']);

        return $this->output;
    }

    public function AgentRegisterProcess()
    {
        if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM agent WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                #$i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM agent WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                #$i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM agent WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        // Check if security question is correct
        $i_security = 0;

        if ($_POST['C1']+$_POST['C2']!=$_POST['SQ'])
        {
            $i_security += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport + $i_security;

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }

            if ($i_security>0)
            {
                $error['SQ'] = 1;
            }

            $_SESSION['admin']['agent_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new agent
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            $key = "(GenderID, Name, NRIC, Passport, Company, Bank, BankAccountNo, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, Enabled)";
            $value = "('".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '0', '1')";

            $sql = "INSERT INTO agent ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Create all product wallets for new agent
			$Product = ProductModel::getProductList();

			for ($i=0; $i <$Product['count'] ; $i++)
			{
    			$key = "(Total, ProductID, AgentID, Enabled)";
    			$value = "('0', '".$Product[$i]['ID']."', '".$newID."', '1')";

    			$sql = "INSERT INTO wallet ".$key." VALUES ". $value;
                $this->dbconnect->exec($sql);
			}

            // Insert new agent's first address
            /*$key_address = "(AgentID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
            $value_address = "('".$newID."', 'My First Address', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '1')";

            $sql_address = "INSERT INTO agent_address ".$key_address." VALUES ". $value_address;

            $count_address = $this->dbconnect->exec($sql_address);*/

            // Set Status
            $ok = ($count==1) ? 1 : "";
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Registering...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

    public function AgentLogin()
    {
        if ($_SESSION['agent']['agent_login_info']!="")
        {
            $form_input = $_SESSION['agent']['agent_login_info'];

            // Unset temporary agent info input
            unset($_SESSION['agent']['agent_login_info']);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Agent Login", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/member/login.inc.php', 'agent_login' => $_SESSION['agent']['agent_login'], 'agent_logout' => $_SESSION['agent']['agent_logout'], 'agent_password' => $_SESSION['agent']['agent_password'], 'agent_register' => $_SESSION['agent']['agent_register'], 'agent_forgotpassword' => $_SESSION['agent']['agent_forgotpassword']),
        'block' => array(/*'side_nav' => $this->module_dir.'inc/member/side_nav.agent_out.inc.php',*/ 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Login"),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['agent']['agent_login']);
        unset($_SESSION['agent']['agent_logout']);
        unset($_SESSION['agent']['agent_password']);
        unset($_SESSION['agent']['agent_register']);
        unset($_SESSION['agent']['agent_forgotpassword']);

        return $this->output;
    }

    public function AgentLoginProcess()
    {
        $sql = "SELECT * FROM agent WHERE Enabled = 1 AND Username = '".$_POST['Username']."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'TypeID' => $row['TypeID'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],
            'Prompt' => $row['Prompt']);

            $i += 1;
        }
        
        if($i!=1)
        {    
        
            $sql = "SELECT * FROM operator WHERE Enabled = 1 AND Username = '".$_POST['Username']."' AND ProfileID = '2'";



            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i] = array(
                'ID' => $row['AgentID'],
                'OperatorType' => AgentModel::getAgent($row['AgentID'], "TypeID"),   
                'rowID' => $row['ID'],
                'operator' => $row['Username'],    
                'Password' => $row['Password'],    
                'ProfileID' => $row['ProfileID']);

                $i += 1;
            }
        
        }
        
        if($i!=1)
        {    
        
            $sql = "SELECT * FROM operator WHERE Enabled = 1 AND Username = '".$_POST['Username']."' AND ProfileID = '4'";



            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i] = array(
                'ID' => $row['AgentID'],
                'OperatorType' => AgentModel::getAgent($row['AgentID'], "TypeID"),   
                'rowID' => $row['ID'],
                'operator' => $row['Username'],    
                'Password' => $row['Password'],    
                'ProfileID' => $row['ProfileID']);

                $i += 1;
            }
        
        }
        
        

        
        /*elseif($i!==1)
        {
            $sql = "SELECT * FROM operator WHERE Enabled = 1 AND Username = '".$_POST['Username']."'";
            
            $result = array();
            $i = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i] = array(
                'ID' => $row['AgentID'],
                'OperatorType' => AgentModel::getAgent($row['AgentID'], "TypeID"),   
                'rowID' => $row['ID'],
                'operator' => $row['Username'],    
                'Password' => $row['Password'],    
                'ProfileID' => $row['ProfileID']);

                $i += 1;
            }
            
            $bcrypt = new Bcrypt(9);
            $verify = $bcrypt->verify($_POST['Password'], $result[0]['Password']);

            // Set Status
            $ok = ($verify==1) ? 1 : "";

            if ($verify!=1)
            {
                // Username and password do not match
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['agent']['agent_login_info'] = Helper::unescape($_POST);
            }
            
        }*/
        if ($i==1)
        {
            $bcrypt = new Bcrypt(9);
            $verify = $bcrypt->verify($_POST['Password'], $result[0]['Password']);

            // Set Status
            $ok = ($verify==1) ? 1 : "";

            if ($verify!=1)
            {
                // Username and password do not match
                $error['count'] += 1;
                $error['Login'] = 1;

                $_SESSION['agent']['agent_login_info'] = Helper::unescape($_POST);
            }
        }
        else
        {
            // Invalid username
            $error['count'] += 1;
            $error['Login'] = 1;

            $_SESSION['agent']['agent_login_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function AgentLogout()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey),
        'page' => array('title' => "Logging Out..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function AgentForgotPassword()
    {
        if ($_SESSION['agent']['agent_forgotpassword_info']!="")
        {
            $form_input = $_SESSION['agent']['agent_forgotpassword_info'];

            // Unset temporary agent info input
            unset($_SESSION['agent']['agent_forgotpassword_info']);
        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Forgot Your Password?", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/forgotpassword.inc.php', 'agent_forgotpassword' => $_SESSION['agent']['agent_forgotpassword']),
        'block' => array(/*'side_nav' => $this->module_dir.'inc/agent/side_nav.agent_out.inc.php',*/ 'common' => "false"),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_agent_url,"",$this->config,"Forgot Password"),
        'content_param' => array('enabled_list' => CRUD::getActiveList()),
        'form_param' => $form_input,
        'secure' => TRUE,
        'meta' => array('active' => "on"));

        unset($_SESSION['agent']['agent_forgotpassword']);

        return $this->output;
    }

    public function AgentForgotPasswordProcess()
    {
        $sql = "SELECT * FROM agent WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' LIMIT 0,1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Expiry' => $row['Expiry'],
            'Username' => $row['Username'],
            'Password' => $row['Password'],
            'CookieHash' => $row['CookieHash'],
            'Email' => $row['Email'],
            'Name' => $row['Name'],

            'Prompt' => $row['Prompt']);

            $i += 1;
        }

        if ($i==1)
        {
            // Generate New Password
            $bcrypt = new Bcrypt(9);
            $new_password = uniqid();
            $hash = $bcrypt->hash($new_password);

            $sql = "UPDATE agent SET Password='".$hash."', Prompt='1' WHERE Email = '".$_POST['Email']."' AND Username = '".$_POST['Username']."' AND ID='".$result[0]['ID']."'";

            $count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
        }
        else
        {
            // Username and email do not match
            $error['count'] += 1;
            $error['NoMatch'] = 1;

            $_SESSION['agent']['agent_forgotpassword_info'] = Helper::unescape($_POST);
        }

        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Logging In..."),
        'content' => $result,
        'content_param' => array('count' => $i, 'new_password' => $new_password),
        'status' => array('ok' => $ok, 'error' => $error),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function AgentAccess()
    {
        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Checking Access..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }

    public function AgentAutologin()
    {
        $this->output = array(
        'config' => $this->config,
        'cookie' => array('key' => $this->cookiekey, 'hash' => $result[0]['CookieHash']),
        'page' => array('title' => "Auto Logging In..."),
        'secure' => TRUE,
        'meta' => array('active' => "off"));

        return $this->output;
    }
    
    public function AgentEdit($param)
	{
		$sql = "SELECT * FROM agent WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    	if ($row['Logo']=='')
                        {
                            $cover_image = '';
                        }
                        else
                        {
                            $cover_image = Image::getImage($row['Logo'],'thumb');
                        }
                    
			$result[$i] = array(
			'ID' => $row['ID'],
                        'ParentID' => $row['ParentID'],
                        'TypeID' => $row['TypeID'],
                        'Type' => ($row['TypeID']=='1') ? 'Platform': 'Normal',  
			'Name' => $row['Name'],
                        'Remark' => $row['Remark'],    
			'Profitsharing' => $row['Profitsharing'],
			'Company' => $row['Company'],
                        'Host' => $row['Host'],    
			'Credit' => $row['Credit'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
                        'IPAddress' => $row['IPAddress'],
                        'Chat' => stripslashes($row['Chat']),     
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'PlatformEmail1' => $row['PlatformEmail1'],
                        'PlatformEmail2' => $row['PlatformEmail2'],
                        'PlatformEmail3' => $row['PlatformEmail3'],
                        'PlatformEmail4' => $row['PlatformEmail4'],    
                        'PlatformEmail5' => $row['PlatformEmail5'],
                        'PlatformEmail6' => $row['PlatformEmail6'],
                        'PlatformEmail7' => $row['PlatformEmail7'],
                        'PlatformEmail8' => $row['PlatformEmail8'],
                        'PlatformEmail9' => $row['PlatformEmail9'],
                        'PlatformEmail10' => $row['PlatformEmail10'],    
                        'BackgroundColour' => $row['BackgroundColour'], 
                        'FontColour' => $row['FontColour'],
                        'LogoCover' => $cover_image,
                        'Logo' => $row['Logo'], 
			'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
                                              
                     $product = explode(',', $row['Product']);
                     
                     $product['count'] = count($product);
                      
                     $_SESSION['ParentID'] = $row['ParentID'];
		}
                
                
                //exit;
                
                //Debug::displayArray($product);
                //exit;
                
                
                $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";
                //echo $sql2;
                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }
                    //Debug::displayArray($result2); 
                    //exit;
                    $result2['count'] = $z;

                if($_SESSION['agent']['redirect'] == 'AgentEditIndex')
                {    
                    $breadcrumb = $this->module_default_editindex_url; 
                }
                elseif($_SESSION['agent']['redirect'] == 'AgentDownline')
                {
                    $breadcrumb = $this->module_default_downline_url;
                }  
                else 
                {
                    $breadcrumb = $this->module_default_editindex_url;
                }
                
                if ($_SESSION['agent']['agent_edit_info']!="")
                {
                    $form_input = $_SESSION['agent']['agent_edit_info'];

                    // Unset temporary agent info input
                    unset($_SESSION['agent']['agent_edit_info']);
                }

		$this->output = array(
		'config' => $this->config,
                'agent' => $result2,    
		'page' => array('title' => "Edit Agent", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/edit.inc.php', 'agent_add' => $_SESSION['agent']['agent_add'], 'agent_edit' => $_SESSION['agent']['agent_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Edit Agent"),
		'content' => $result,
                'back' => $_SESSION['agent']['redirect'],   
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'agent_list' => AgentModel::getNotAgentList($param), 'bank_list' => BankModel::getBankList(), 'agenttype_list' => AgentTypeModel::getAgentTypeList(), 'product_list' => ProductModel::getProductListByAgent(), 'product' => $product),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));
                
                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['agent_add']);
		unset($_SESSION['agent']['agent_edit']);

		return $this->output;
	}
        
       public function AgentProfileView($param)
	{
		$sql = "SELECT * FROM operator WHERE ID = '".$_SESSION['agent']['operator']['RowID']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    	
                    
			$result[$i] = array(
			'Username' => $row['Username'],
                        'Profile' => ProfileModel::getProfile($row['ProfileID'], "Profile"));

			$i += 1;
                                              
                    
		}               
               
                    

		$this->output = array(
		'config' => $this->config,
                'agent' => $result2,    
		'page' => array('title' => "Profile", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'off'),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"View Profile"),
		'content' => $result,
                'back' => $_SESSION['agent']['redirect'],   
		'content_param' => array('count' => $i),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));
          

		return $this->output;
	} 

	public function AdminIndex($param)
	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['agent_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("Agent",$_POST['Agent'],"=", 1);
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                        $query_condition .= $crud->queryCondition("Remark",$_POST['Remark'],"LIKE");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
                        $query_condition .= $crud->queryCondition("Host",$_POST['Host'],"=");
			$query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
			$query_condition .= $crud->queryCondition("BankAccountNo",$_POST['BankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBank",$_POST['SecondaryBank'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBankAccountNo",$_POST['SecondaryBankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail1",$_POST['PlatformEmail1'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail2",$_POST['PlatformEmail2'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail3",$_POST['PlatformEmail3'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail4",$_POST['PlatformEmail4'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail5",$_POST['PlatformEmail5'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail6",$_POST['PlatformEmail6'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail7",$_POST['PlatformEmail7'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail8",$_POST['PlatformEmail8'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail9",$_POST['PlatformEmail9'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail10",$_POST['PlatformEmail10'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			$_SESSION['agent_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
			$_SESSION['agent_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['Remark'] = $_POST['Remark'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['Host'] = $_POST['Host'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
			$_SESSION['agent_'.__FUNCTION__]['param']['BankAccountNo'] = $_POST['BankAccountNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['SecondaryBank'] = $_POST['SecondaryBank'];
			$_SESSION['agent_'.__FUNCTION__]['param']['SecondaryBankAccountNo'] = $_POST['SecondaryBankAccountNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['agent_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['agent_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail1'] = $_POST['PlatformEmail1'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail2'] = $_POST['PlatformEmail2'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail3'] = $_POST['PlatformEmail3'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail4'] = $_POST['PlatformEmail4'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail5'] = $_POST['PlatformEmail5'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail6'] = $_POST['PlatformEmail6'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail7'] = $_POST['PlatformEmail7'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail8'] = $_POST['PlatformEmail8'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail9'] = $_POST['PlatformEmail9'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail10'] = $_POST['PlatformEmail10'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agent_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agent_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agent_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agent_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM agent WHERE TRUE = TRUE ".$_SESSION['agent_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/agent/index';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM agent WHERE TRUE = TRUE ".$_SESSION['agent_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
                //echo $sql;
                //exit;

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Profitsharing' => number_format((float)$row['Profitsharing'], 2, '.', '')/*AgentModel::getAgentOwnReport($row['ID'], $filename)*/,
			'Name' => $row['Name'],
                        'Remark' => $row['Remark'],    
			'Company' => $row['Company'],
                        'Host' => $row['Host'],   
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],			
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'PlatformEmail1' => $row['PlatformEmail1'],
                        'PlatformEmail2' => $row['PlatformEmail2'],
                        'PlatformEmail3' => $row['PlatformEmail3'], 
                        'PlatformEmail4' => $row['PlatformEmail4'],
                        'PlatformEmail5' => $row['PlatformEmail5'],
                        'PlatformEmail6' => $row['PlatformEmail6'],
                        'PlatformEmail7' => $row['PlatformEmail7'],
                        'PlatformEmail8' => $row['PlatformEmail8'],
                        'PlatformEmail9' => $row['PlatformEmail9'],
                        'PlatformEmail10' => $row['PlatformEmail10'],    
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		/*Debug::displayArray($result);
		exit;*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agents", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'agent_delete' => $_SESSION['admin']['agent_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agent_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'bank_list' => BankModel::getBankList(), 'test' => AgentModel::getAdminAgentAllParentChild()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agent_delete']);

		return $this->output;
	}



	public function AdminAdd()
	{
	    if ($_SESSION['admin']['agent_add_info']!="")
        {
            $form_input = $_SESSION['admin']['agent_add_info'];

            // Unset temporary agent info input
            unset($_SESSION['admin']['agent_add_info']);
        }
            //$_SESSION['agentstack'] = array();
            //AgentModel::getAgentHierarchyList();
            //Debug::displayArray($_SESSION['agentstack']);
            //exit;
            
                 
                $result = AgentModel::getAdminAgentAllParentChild();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Agent", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'admin_add' => $_SESSION['admin']['agent_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agent_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Agent"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'bank_list' => BankModel::getBankList(), 'agent_list' => $this->getAgentList(), 'agenttype_list' => AgentTypeModel::getAgentTypeList(), 'product_list' => ProductModel::getProductList(), 'agent_hierarchy' => $result), /*'country_list' => CountryModel::getCountryList()),*/
		'form_param' => $form_input,    
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agent_add']);

		return $this->output;
	}

	public function AdminAddProcess()
	{
            
            
            $allowedHost = array('mail','*','www','ftp');
            
	   /* if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM agent WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM agent WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM agent WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/
        
        
        $error = array();
        
        $error['count'] = 0;   

        $i_agentEmail = 0;

        $agentEmailCount = $this->getAgentUniqueEmail($_POST['Email']);

        if($agentEmailCount>'0')
        {
            $i_agentEmail += 1;
        }
        
        $i_agentPlatformEmail1 = 0;

        $agentPlatformEmail1Count = $this->getAgentUniqueEmail($_POST['PlatformEmail1']);

        if($agentPlatformEmail1Count>'0')
        {
            $i_agentPlatformEmail1 += 1;
        }
        
        $i_agentPlatformEmail2 = 0;

        $agentPlatformEmail2Count = $this->getAgentUniqueEmail($_POST['PlatformEmail2']);

        if($agentPlatformEmail2Count>'0')
        {
            $i_agentPlatformEmail2 += 1;
        }
        
        $i_agentPlatformEmail3 = 0;

        $agentPlatformEmail3Count = $this->getAgentUniqueEmail($_POST['PlatformEmail3']);

        if($agentPlatformEmail3Count>'0')
        {
            $i_agentPlatformEmail3 += 1;
        }
        
        $i_agentPlatformEmail4 = 0;

        $agentPlatformEmail4Count = $this->getAgentUniqueEmail($_POST['PlatformEmail4']);

        if($agentPlatformEmail4Count>'0')
        {
            $i_agentPlatformEmail4 += 1;
        }
        
        $i_agentPlatformEmail5 = 0;

        $agentPlatformEmail5Count = $this->getAgentUniqueEmail($_POST['PlatformEmail5']);

        if($agentPlatformEmail5Count>'0')
        {
            $i_agentPlatformEmail5 += 1;
        }
        
        $i_agentPlatformEmail6 = 0;

        $agentPlatformEmail6Count = $this->getAgentUniqueEmail($_POST['PlatformEmail6']);

        if($agentPlatformEmail6Count>'0')
        {
            $i_agentPlatformEmail6 += 1;
        }
        
        $i_agentPlatformEmail7 = 0;

        $agentPlatformEmail7Count = $this->getAgentUniqueEmail($_POST['PlatformEmail7']);

        if($agentPlatformEmail7Count>'0')
        {
            $i_agentPlatformEmail7 += 1;
        }
        
        $i_agentPlatformEmail8 = 0;

        $agentPlatformEmail8Count = $this->getAgentUniqueEmail($_POST['PlatformEmail8']);

        if($agentPlatformEmail8Count>'0')
        {
            $i_agentPlatformEmail8 += 1;
        }
        
        $i_agentPlatformEmail9 = 0;

        $agentPlatformEmail9Count = $this->getAgentUniqueEmail($_POST['PlatformEmail9']);

        if($agentPlatformEmail9Count>'0')
        {
            $i_agentPlatformEmail9 += 1;
        }
        
        $i_agentPlatformEmail10 = 0;

        $agentPlatformEmail10Count = $this->getAgentUniqueEmail($_POST['PlatformEmail10']);

        if($agentPlatformEmail10Count>'0')
        {
            $i_agentPlatformEmail10 += 1;
        }

        // Check is username exists
        $sql = "SELECT COUNT(*) AS agentCompany FROM agent WHERE CONCAT_WS('.', Host, Company) = '".$_POST['Host'].'.'.$_POST['Company']."' AND Enabled = '1'";

        $i_agentCompany = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $agentCompany = $row['agentCompany'];

            
        }
        
        if($agentCompany>'0')
        {
            $i_agentCompany += 1;
        }
        
        
        
        if (in_array($_POST['Host'], $allowedHost)) {
            $i_host = 1;
        }
        
        $pattern = '/[^a-zA-Z]/';
        $exist = preg_match($pattern, $_POST['Host']);
        
        if ($exist===1) {
            $i_host = 1;
        }


        $error['count'] = $i_agentEmail + $i_agentPlatformEmail1 + $i_agentPlatformEmail2 + $i_agentPlatformEmail3 + $i_agentPlatformEmail4 + $i_agentPlatformEmail5 + $i_agentPlatformEmail6 + $i_agentPlatformEmail7 + $i_agentPlatformEmail8 + $i_agentPlatformEmail9 + $i_agentPlatformEmail10 + $i_agentCompany + $i_host;
        
        if($error['count']==0)
        { 
                
            $dnsStatusMessage = Helper::addDNSRecords($_POST['Company'], $_POST['IPAddress'], $_POST['Host'], $_POST['ParentID']);
            
                

            if($dnsStatusMessage['status']=='Failed')
            {
                $DNS += 1;
                $error['count'] += $DNS;
            }
        }
        
        
            
        $upload['Logo'] = File::uploadFile('Logo',1,2,"agent");

        if ($upload['Logo']['upload']['status']=="Empty")
        {
            $file_location['Logo'] = "";
        }
        else if ($upload['Logo']['upload']['status']=="Uploaded")
        {
            $file_location['Logo'] = $upload['Logo']['upload']['destination'];
            Image::generateImage($file_location['Logo'],66,66,'thumb');
            Image::generateImage($file_location['Logo'],145,145,'cover');
            Image::generateImage($file_location['Logo'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['Logo'] = $upload['Logo']['error'];

            $file_location['Logo'] = "";
        }    
            
        
            
        $i_bank = 0;
        
        
        
        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {
            
            
            
        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);
        
            if($bankCount == '0')
            {
                
            }
            else
            {
                $i_bank += 1;
            } 
            
                
            
            
            
        }     

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }
                       
            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }
            
            if ($i_agentEmail>0)
            {
                $error['Email'] = 1;
            }
            
            if ($i_agentEmail>0)
            {
                $error['Email'] = 1;
            }
            
            if ($i_agentPlatformEmail1>0)
            {
                $error['PlatformEmail1'] = 1;
            }
            
            if ($i_agentPlatformEmail2>0)
            {
                $error['PlatformEmail2'] = 1;
            }
            
            if ($i_agentPlatformEmail3>0)
            {
                $error['PlatformEmail3'] = 1;
            }
            
            if ($i_agentPlatformEmail4>0)
            {
                $error['PlatformEmail4'] = 1;
            }
            
            if ($i_agentPlatformEmail5>0)
            {
                $error['PlatformEmail5'] = 1;
            }
            
            if ($i_agentPlatformEmail6>0)
            {
                $error['PlatformEmail6'] = 1;
            }
            
            if ($i_agentPlatformEmail7>0)
            {
                $error['PlatformEmail7'] = 1;
            }
            
            if ($i_agentPlatformEmail8>0)
            {
                $error['PlatformEmail8'] = 1;
            }
            
            if ($i_agentPlatformEmail9>0)
            {
                $error['PlatformEmail9'] = 1;
            }
            
            if ($i_agentPlatformEmail10>0)
            {
                $error['PlatformEmail10'] = 1;
            }
            
            if ($i_agentCompany>0)
            {
                $error['Company'] = 1;
            }
            
            if ($i_host>0)
            {
                $error['Host'] = 1;
            }
            
            
             
            //$dnsStatusMessage = Helper::addDNSRecords($_POST['Company'], $_POST['IPAddress'], $_POST['Host']);
            
           
            if($DNS>0)
            {
                $error['DNS'] = 1;
            }

            $_SESSION['admin']['agent_add_info'] = $_POST;
        }
        else
        {
            
            
    	    $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

			// echo $_POST['SecondaryBank'];
			// echo $_POST['SecondaryBankAccountNo'];
            
                $concat = '';
                 
                //Debug::displayArray($_POST['Product']);
                //exit;
                $_POST['Product']['count'] = count($_POST['Product']);
                
                for ($i=0; $i<$_POST['Product']['count']; $i++) {
                        
                        $concat.=$_POST['Product'][$i];
                        $z = $i + 1;
                        if($z===$_POST['Product']['count']){
                            
                            
                            
                        }
                        else 
                        {
                            $concat.=',';
                        }
                                         
                }
                
                if($_POST['TypeID']=='2')
                {
                    if($_POST['ParentID']!='0')
                    {

                        if($_FILES['Logo']['size']=='0')
                        {
                            $this->getloopAgentParent($_POST['ParentID']);
                            $logo = AgentModel::getAllAgent($_SESSION['platform_agent'], "Logo");
                            unset($_SESSION['platform_agent']);
                        }
                        else
                        {
                            $logo = $file_location['Logo'];
                        }    

                    }
                }
                 
                
                $_POST['Chat'] = addslashes($_POST['Chat']); 
                
                $uniqueCode = time();
                $uniqueCode = substr($uniqueCode, -4); 
                $rand = rand(10, 99);
                $uniqueCode .= $rand;
                
                    

    		$key = "(UniqueCode, Remark, Credit, Product, TypeID, Name, ParentID, Profitsharing, Company, Host, Bank, BankAccountNo, Username, Password, PhoneNo, FaxNo, IPAddress, Chat, MobileNo, Email, PlatformEmail1, PlatformEmail2, PlatformEmail3, PlatformEmail4, PlatformEmail5, PlatformEmail6, PlatformEmail7, PlatformEmail8, PlatformEmail9, PlatformEmail10, BackgroundColour, FontColour, Logo, Registered, Prompt, Enabled)";
    		$value = "('".$uniqueCode."', '".$_POST['Remark']."', '".$_POST['Credit']."', '".$concat."', '".$_POST['TypeID']."', '".$_POST['Name']."', '".$_POST['ParentID']."', '".$_POST['Profitsharing']."', '".$_POST['Company']."', '".$_POST['Host']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['IPAddress']."', '".$_POST['Chat']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['PlatformEmail1']."', '".$_POST['PlatformEmail2']."', '".$_POST['PlatformEmail3']."', '".$_POST['PlatformEmail4']."', '".$_POST['PlatformEmail5']."', '".$_POST['PlatformEmail6']."', '".$_POST['PlatformEmail7']."', '".$_POST['PlatformEmail8']."', '".$_POST['PlatformEmail9']."', '".$_POST['PlatformEmail10']."', '".$_POST['BackgroundColour']."', '".$_POST['FontColour']."', '".$logo."', '".date("Y-m-d h:i:s")."', '".$_POST['Prompt']."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO agent ".$key." VALUES ". $value;
// echo $sql;
// exit;
    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();
                
                
                
                $agentCodeStatus = AgentModel::getAgentUniqueCode($uniqueCode, $newID);
                
                
            // Set Status
            $ok = ($count==1) ? 1 : "";
            
            if($_POST['TypeID']=='2')
            {
                if($_POST['ParentID']!='0')
                {    
                    $this->getloopAgentParent($_POST['ParentID']);
                    
                    $agentBlockList = AgentBlockModel::getAgentBlockByAgentID($_SESSION['platform_agent']);
                    //Debug::displayArray($agentBlockList);
                    //exit;
                    $agentPromotionList = AgentPromotionModel::getAgentPromotionListByAgentID($_SESSION['platform_agent']);
                    $agentBankInfoList = BankInfoModel::getBankInfoListByAgent($_SESSION['platform_agent']);
                    //echo $_SESSION['platform_agent'];
                    //exit;
                    unset($_SESSION['platform_agent']);
            
                    for ($p = 0; $p < $agentBlockList['count']; $p++) {

                        $key = "(AgentID, Name, Content, Position, Enabled)";
                        $value = "('".$newID."', '".$agentBlockList[$p]['Name']."', '".$agentBlockList[$p]['Content']."', '".$agentBlockList[$p]['Position']."', '".$agentBlockList[$p]['Enabled']."')";

                        $sql = "INSERT INTO agent_block ".$key." VALUES ". $value;
                        
                        //echo $sql;
                        //exit;

                        $count = $this->dbconnect->exec($sql);

                    }
                    
                    
                    for ($l = 0; $l < $agentPromotionList['count']; $l++) {
                                               
                        $key = "(AgentID, Title, Position, First, Enabled)";
                        $value = "('".$newID."', '".$agentPromotionList[$l]['Title']."', '".$agentPromotionList[$l]['Position']."', '".$agentPromotionList[$l]['First']."', '".$agentPromotionList[$l]['Enabled']."')";

                        $sql = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                    for ($a = 0; $a < $agentBankInfoList['count']; $a++) {
                       
                        $key = "(AgentID, Name, ImageURL, Description)";
                        $value = "('".$newID."', '".$agentBankInfoList[$a]['Name']."', '".$agentBankInfoList[$a]['ImageURL']."', '".$agentBankInfoList[$a]['Description']."')";

                        $sql = "INSERT INTO bank_info ".$key." VALUES ". $value;
                                                
                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                }
            }
            else   
            {
            
                $Position = array(0 => "Login", 1 => "Withdrawal Top", 2 => "Withdrawal Bottom", 3 => "Deposit Top", 4 => "Deposit Bottom", 5 => "Deposit Popup", 6 => "Transfer Popup", 7 => "Withdrawal Popup");

                $Position['count'] = count($Position);

                for ($p = 0; $p < $Position['count']; $p++) {

                    $key = "(AgentID, Name, Content, Position, Enabled)";
                    $value = "('".$newID."', '', '', '".$Position[$p]."', '')";

                    $sql = "INSERT INTO agent_block ".$key." VALUES ". $value;

                    $count = $this->dbconnect->exec($sql);


                }
            }
            
            
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Agent...", 'template' => 'admin.common.tpl.php'),
		'content' => $_POST,
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error, 'dnsMessage' => $dnsStatusMessage),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function AgentAdd()
	{
	    if ($_SESSION['agent']['agent_add_info']!="")
        {
            $form_input = $_SESSION['agent']['agent_add_info'];

            // Unset temporary agent info input
            unset($_SESSION['agent']['agent_add_info']);
        }
        
        $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                    $result2 = array();
                    $z = 0;
                    $tier = 1;
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $result2[$z] = array(
                                    'ID' => $row2['ID'],
                                    'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                    'Name' => $row2['Name'],
                                    'Company' => $row2['Company']);

                            $z += 1;
                    }

                    $result2['count'] = $z;
                    
                if($_SESSION['agent']['redirect'] == 'AgentEditIndex')
                {    
                    $breadcrumb = $this->module_default_editindex_url; 
                }
                elseif($_SESSION['agent']['redirect'] == 'AgentDownline')
                {
                    $breadcrumb = $this->module_default_downline_url;
                }  
                else 
                {
                    $breadcrumb = $this->module_default_editindex_url;
                }
                
                

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Agent", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/add.inc.php', 'agent_add' => $_SESSION['agent']['agent_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
                'back' => $_SESSION['agent']['redirect'],
                'domain' => AgentModel::getAgent($_SESSION['agent']['ID'], "Company"),    
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$breadcrumb,"",$this->config,"Create Agent"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'bank_list' => BankModel::getBankList(), 'agent_list' => $this->getAgentList(), 'agenttype_list' => AgentTypeModel::getAgentTypeList(), 'product_list' => ProductModel::getProductListByAgent()), /*'country_list' => CountryModel::getCountryList()),*/
                'content' => $result2,
		'form_param' => $form_input,
                'IPAddress' => AgentModel::getAllAgent($_SESSION['agent']['ID'], "IPAddress"),                 
		'secure' => TRUE,
		'meta' => array('active' => "on"));
                
                unset($_SESSION['agent']['redirect']);
		unset($_SESSION['agent']['agent_add']);

		return $this->output;
	}

	public function AgentAddProcess()
	{
            $allowedHost = array('mail','*', 'www', 'ftp');
            
            $_POST['TypeID'] = '2';
                     
            //if()
            //{    
                $this->getloopAgentParent($_POST['ParentID']);
                $_POST['Company'] = AgentModel::getAllAgent($_SESSION['platform_agent'], "Company");


                $this->getloopAgentParent($_POST['ParentID']);
                $_POST['IPAddress'] = AgentModel::getAllAgent($_SESSION['platform_agent'], "IPAddress");

                unset($_SESSION['platform_agent']);
            
            //}
            
            
            
	   /* if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM agent WHERE NRIC = '".$_POST['NRIC']."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM agent WHERE Passport = '".$_POST['Passport']."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM agent WHERE Username = '".$_POST['Username']."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/
                                     
        $error = array();
        $error['count'] = 0;
        
        $i_agentEmail = 0;

        $agentEmailCount = $this->getAgentUniqueEmail($_POST['Email']);

        if($agentEmailCount>'0')
        {
            $i_agentEmail += 1;
        }
        
        $i_agentPlatformEmail1 = 0;

        $agentPlatformEmail1Count = $this->getAgentUniqueEmail($_POST['PlatformEmail1']);

        if($agentPlatformEmail1Count>'0')
        {
            $i_agentPlatformEmail1 += 1;
        }
        
        $i_agentPlatformEmail2 = 0;

        $agentPlatformEmail2Count = $this->getAgentUniqueEmail($_POST['PlatformEmail2']);

        if($agentPlatformEmail2Count>'0')
        {
            $i_agentPlatformEmail2 += 1;
        }
        
        $i_agentPlatformEmail3 = 0;

        $agentPlatformEmail3Count = $this->getAgentUniqueEmail($_POST['PlatformEmail3']);

        if($agentPlatformEmail3Count>'0')
        {
            $i_agentPlatformEmail3 += 1;
        }
        
        $i_agentPlatformEmail4 = 0;

        $agentPlatformEmail4Count = $this->getAgentUniqueEmail($_POST['PlatformEmail4']);

        if($agentPlatformEmail4Count>'0')
        {
            $i_agentPlatformEmail4 += 1;
        }
        
        $i_agentPlatformEmail5 = 0;

        $agentPlatformEmail5Count = $this->getAgentUniqueEmail($_POST['PlatformEmail5']);

        if($agentPlatformEmail5Count>'0')
        {
            $i_agentPlatformEmail5 += 1;
        }
        
        $i_agentPlatformEmail6 = 0;

        $agentPlatformEmail6Count = $this->getAgentUniqueEmail($_POST['PlatformEmail6']);

        if($agentPlatformEmail6Count>'0')
        {
            $i_agentPlatformEmail6 += 1;
        }
        
        $i_agentPlatformEmail7 = 0;

        $agentPlatformEmail7Count = $this->getAgentUniqueEmail($_POST['PlatformEmail7']);

        if($agentPlatformEmail7Count>'0')
        {
            $i_agentPlatformEmail7 += 1;
        }
        
        $i_agentPlatformEmail8 = 0;

        $agentPlatformEmail8Count = $this->getAgentUniqueEmail($_POST['PlatformEmail8']);

        if($agentPlatformEmail8Count>'0')
        {
            $i_agentPlatformEmail8 += 1;
        }
        
        $i_agentPlatformEmail9 = 0;

        $agentPlatformEmail9Count = $this->getAgentUniqueEmail($_POST['PlatformEmail9']);

        if($agentPlatformEmail9Count>'0')
        {
            $i_agentPlatformEmail9 += 1;
        }
        
        $i_agentPlatformEmail10 = 0;

        $agentPlatformEmail10Count = $this->getAgentUniqueEmail($_POST['PlatformEmail10']);

        if($agentPlatformEmail10Count>'0')
        {
            $i_agentPlatformEmail10 += 1;
        }

        // Check is username exists
        $sql = "SELECT COUNT(*) AS agentCompany FROM agent WHERE CONCAT_WS('.', Host, Company) = '".$_POST['Host'].'.'.$_POST['Company']."' AND Enabled = '1'";

        $i_agentCompany = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $agentCompany = $row['agentCompany'];

            
        }
        
        if($agentCompany>'0')
        {
            $i_agentCompany += 1;
        }
        
        if (in_array($_POST['Host'], $allowedHost)) {
            $i_host = 1;
        }
        
        $pattern = '/[^a-zA-Z]/';
        $exist = preg_match($pattern, $_POST['Host']);
        
        if ($exist===1) {
            $i_host = 1;
        }
        

        $error['count'] = $i_agentEmail + $i_agentPlatformEmail1 + $i_agentPlatformEmail2 + $i_agentPlatformEmail3 + $i_agentPlatformEmail4 + $i_agentPlatformEmail5 + $i_agentPlatformEmail6 + $i_agentPlatformEmail7 + $i_agentPlatformEmail8 + $i_agentPlatformEmail9 + $i_agentPlatformEmail10 + $i_agentCompany + $i_host;
        
        if($error['count']==0)
        {    
            $dnsStatusMessage = Helper::addDNSRecords($_POST['Company'], $_POST['IPAddress'], $_POST['Host'], $_POST['ParentID']);

            if($dnsStatusMessage['status']=='Failed')
            {
                $DNS += 1;
                $error['count'] += $DNS;
            }
        }
        
        

         
            
         // Handle Image Upload
        $upload['Logo'] = File::uploadFile('Logo',1,2,"agent");

        if ($upload['Logo']['upload']['status']=="Empty")
        {
            $file_location['Logo'] = "";
        }
        else if ($upload['Logo']['upload']['status']=="Uploaded")
        {
            $file_location['Logo'] = $upload['Logo']['upload']['destination'];
            Image::generateImage($file_location['Logo'],66,66,'thumb');
            Image::generateImage($file_location['Logo'],145,145,'cover');
            Image::generateImage($file_location['Logo'],300,300,'medium');
                    }
        else
        {
            $error['count'] += 1;
            $error['Logo'] = $upload['Logo']['error'];

            $file_location['Logo'] = "";
        }   
            
        $i_bank = 0;
        
        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {
            
            
            
        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);
        
            if($bankCount == '0')
            {
                
            }
            else
            {
                $i_bank += 1;
            } 
            
        }     

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }
                       
            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }
            
            if ($i_agentEmail>0)
            {
                $error['Email'] = 1;
            }
            
            if ($i_agentPlatformEmail1>0)
            {
                $error['PlatformEmail1'] = 1;
            }
            
            if ($i_agentPlatformEmail2>0)
            {
                $error['PlatformEmail2'] = 1;
            }
            
            if ($i_agentPlatformEmail3>0)
            {
                $error['PlatformEmail3'] = 1;
            }
            
            if ($i_agentPlatformEmail4>0)
            {
                $error['PlatformEmail4'] = 1;
            }
            
            if ($i_agentPlatformEmail5>0)
            {
                $error['PlatformEmail5'] = 1;
            }
            
            if ($i_agentPlatformEmail6>0)
            {
                $error['PlatformEmail6'] = 1;
            }
            
            if ($i_agentPlatformEmail7>0)
            {
                $error['PlatformEmail7'] = 1;
            }
            
            if ($i_agentPlatformEmail8>0)
            {
                $error['PlatformEmail8'] = 1;
            }
            
            if ($i_agentPlatformEmail9>0)
            {
                $error['PlatformEmail9'] = 1;
            }
            
            if ($i_agentPlatformEmail10>0)
            {
                $error['PlatformEmail10'] = 1;
            }
            
            if ($i_agentCompany>0)
            {
                $error['Company'] = 1;
            }
            
            if ($i_host>0)
            {
                $error['Host'] = 1;
            }
            
            
            
            
                       
           
            if($dnsStatusMessage['status']=='Failed')
            {
                $error['DNS'] = 1;
            }   
            
            

            $_SESSION['agent']['agent_add_info'] = $_POST;
        }
        else
        {
    	    $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }

			// echo $_POST['SecondaryBank'];
			// echo $_POST['SecondaryBankAccountNo'];
            
                $concat = '';
                 
                //Debug::displayArray($_POST['Product']);
                //exit;
                $_POST['Product']['count'] = count($_POST['Product']);
                
                for ($i=0; $i<$_POST['Product']['count']; $i++) {
                        
                        $concat.=$_POST['Product'][$i];
                        $z = $i + 1;
                        if($z===$_POST['Product']['count']){
                            
                            
                            
                        }
                        else 
                        {
                            $concat.=',';
                        }
                                         
                }
                
                if($_POST['TypeID']=='2')
                {
                    if($_POST['ParentID']!='0')
                    {
                        
                        if($_FILES['Logo']['size']=='0')
                        {
                            //echo 'hi';
                            
                            $this->getloopAgentParent($_POST['ParentID']);
                            $logo = AgentModel::getAllAgent($_SESSION['platform_agent'], "Logo");
                            //echo $logo;
                            //exit;
                            unset($_SESSION['platform_agent']);
                        }
                        else
                        {
                            $logo = $file_location['Logo'];
                        }    

                    }
                }
                
                
                $_POST['Chat'] = addslashes($_POST['Chat']);
                
                $uniqueCode = time();
                $uniqueCode = substr($uniqueCode, -4); 
                $rand = rand(10, 99);
                $uniqueCode .= $rand;
                
                

    		$key = "(UniqueCode, Credit, Product, TypeID, Name, Remark, ParentID, Profitsharing, Company, Host, Bank, BankAccountNo, Username, Password, PhoneNo, FaxNo, IPAddress, Chat, MobileNo, Email, PlatformEmail1, PlatformEmail2, PlatformEmail3, PlatformEmail4, PlatformEmail5, PlatformEmail6, PlatformEmail7, PlatformEmail8, PlatformEmail9, PlatformEmail10, BackgroundColour, FontColour, Logo, Registered, Enabled)";
    		$value = "('".$uniqueCode."', '".$_POST['Credit']."', '".$concat."', '".$_POST['TypeID']."', '".$_POST['Name']."', '".$_POST['Remark']."', '".$_POST['ParentID']."', '".$_POST['Profitsharing']."', '".$_POST['Company']."', '".$_POST['Host']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['IPAddress']."', '".$_POST['Chat']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '".$_POST['PlatformEmail1']."', '".$_POST['PlatformEmail2']."', '".$_POST['PlatformEmail3']."', '".$_POST['PlatformEmail4']."', '".$_POST['PlatformEmail5']."', '".$_POST['PlatformEmail6']."', '".$_POST['PlatformEmail7']."', '".$_POST['PlatformEmail8']."', '".$_POST['PlatformEmail9']."', '".$_POST['PlatformEmail10']."', '".$_POST['BackgroundColour']."', '".$_POST['FontColour']."', '".$logo."', '".date("Y-m-d h:i:s")."', '".$_POST['Enabled']."')";

    		$sql = "INSERT INTO agent ".$key." VALUES ". $value;
 //echo $sql;
 //exit;
    		$count = $this->dbconnect->exec($sql);
    		$newID = $this->dbconnect->lastInsertId();
                
                $agentCodeStatus = AgentModel::getAgentUniqueCode($uniqueCode, $newID);
                
                
                
                
                

            // Set Status
            $ok = ($count==1) ? 1 : "";
                        
            if($_POST['TypeID']=='2')
            {
                if($_POST['ParentID']!='0')
                {    
                    $this->getloopAgentParent($_POST['ParentID']);
                    
                    $agentBlockList = AgentBlockModel::getAgentBlockByAgentID($_SESSION['platform_agent']);
                    $agentPromotionList = AgentPromotionModel::getAgentPromotionListByAgentID($_SESSION['platform_agent']);
                    $agentBankInfoList = BankInfoModel::getBankInfoListByAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);
            
                    for ($p = 0; $p < $agentBlockList['count']; $p++) {

                        $key = "(AgentID, Name, Content, Position, Enabled)";
                        $value = "('".$newID."', '".$agentBlockList[$p]['Name']."', '".$agentBlockList[$p]['Content']."', '".$agentBlockList[$p]['Position']."', '".$agentBlockList[$p]['Enabled']."')";

                        $sql = "INSERT INTO agent_block ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);

                    }
                    
                    
                    for ($l = 0; $l < $agentPromotionList['count']; $l++) {
                                               
                        $key = "(AgentID, Title, Position, First, Enabled)";
                        $value = "('".$newID."', '".$agentPromotionList[$l]['Title']."', '".$agentPromotionList[$l]['Position']."', '".$agentPromotionList[$l]['First']."', '".$agentPromotionList[$l]['Enabled']."')";

                        $sql = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                    for ($a = 0; $a < $agentBankInfoList['count']; $a++) {
                       
                        $key = "(AgentID, Name, ImageURL, Description)";
                        $value = "('".$newID."', '".$agentBankInfoList[$a]['Name']."', '".$agentBankInfoList[$a]['ImageURL']."', '".$agentBankInfoList[$a]['Description']."')";

                        $sql = "INSERT INTO bank_info ".$key." VALUES ". $value;
                                                
                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                }
            }
            else
            {    
            
                $Position = array(0 => "Login", 1 => "Withdrawal Top", 2 => "Withdrawal Bottom", 3 => "Deposit Top", 4 => "Deposit Bottom", 5 => "Deposit Popup", 6 => "Transfer Popup", 7 => "Withdrawal Popup");

                $Position['count'] = count($Position);

                for ($p = 0; $p < $Position['count']; $p++) {

                    $key = "(AgentID, Name, Content, Position, Enabled)";
                    $value = "('".$newID."', '', '', '".$Position[$p]."', '')";

                    $sql = "INSERT INTO agent_block ".$key." VALUES ". $value;

                    $count = $this->dbconnect->exec($sql);

                }
            
            }
            
                
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Agent...", 'template' => 'agent.common.tpl.php'),
		'content' => $_POST,
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error, 'dnsMessage' => $dnsStatusMessage),
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        public function AgentEditIndex($param)
	{
		$filename = __FUNCTION__;
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		//if ($_POST['Trigger']=='search_form')
		//{
			// Reset Query Variable
			$_SESSION['agent_'.__FUNCTION__] = "";
                        
                        /*if($_POST['Agent']!=='' && isset($_POST['Agent'])===TRUE)
                        {    
                            $query_condition .= $crud->queryCondition("ID",$_POST['ID'],"LIKE");
                        }
                        
                        if(isset($_POST['Agent'])===FALSE)
                        {
                             $query_condition .= $crud->queryCondition("ID",$_POST['ID'],"LIKE",1);
                        }
                        
                        if($_POST['Agent']==='' && isset($_POST['Agent'])===TRUE)
                        {
                             $query_condition .= $crud->queryCondition("ID",$_POST['ID'],"LIKE",1);
                        }*/

			
			$query_condition .= $crud->queryCondition("GenderID",$_POST['GenderID'],"=", 1);
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                        $query_condition .= $crud->queryCondition("Remark",$_POST['Remark'],"LIKE");
			$query_condition .= $crud->queryCondition("Username",$_POST['Username'],"LIKE");
			$query_condition .= $crud->queryCondition("Company",$_POST['Company'],"LIKE");
                        $query_condition .= $crud->queryCondition("Host",$_POST['Host'],"=");
			$query_condition .= $crud->queryCondition("Bank",$_POST['Bank'],"LIKE");
			$query_condition .= $crud->queryCondition("BankAccountNo",$_POST['BankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBank",$_POST['SecondaryBank'],"LIKE");
			$query_condition .= $crud->queryCondition("SecondaryBankAccountNo",$_POST['SecondaryBankAccountNo'],"LIKE");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBFrom']),">=");
			$query_condition .= $crud->queryCondition("DOB",Helper::dateDisplaySQL($_POST['DOBTo']),"<=");
			$query_condition .= $crud->queryCondition("NRIC",$_POST['NRIC'],"LIKE");
			$query_condition .= $crud->queryCondition("Passport",$_POST['Passport'],"LIKE");
			$query_condition .= $crud->queryCondition("Nationality",$_POST['Nationality'],"=");
			$query_condition .= $crud->queryCondition("PhoneNo",$_POST['PhoneNo'],"LIKE");
			$query_condition .= $crud->queryCondition("FaxNo",$_POST['FaxNo'],"LIKE");
			$query_condition .= $crud->queryCondition("MobileNo",$_POST['MobileNo'],"LIKE");
			$query_condition .= $crud->queryCondition("Email",$_POST['Email'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail1",$_POST['PlatformEmail1'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail2",$_POST['PlatformEmail2'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail3",$_POST['PlatformEmail3'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail4",$_POST['PlatformEmail4'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail5",$_POST['PlatformEmail5'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail6",$_POST['PlatformEmail6'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail7",$_POST['PlatformEmail7'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail8",$_POST['PlatformEmail8'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail9",$_POST['PlatformEmail9'],"LIKE");
                        $query_condition .= $crud->queryCondition("PlatformEmail10",$_POST['PlatformEmail10'],"LIKE");
			$query_condition .= $crud->queryCondition("Prompt",$_POST['Prompt'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

			
			$_SESSION['agent_'.__FUNCTION__]['param']['GenderID'] = $_POST['GenderID'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['Remark'] = $_POST['Remark'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Username'] = $_POST['Username'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Company'] = $_POST['Company'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['Host'] = $_POST['Host'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Bank'] = $_POST['Bank'];
			$_SESSION['agent_'.__FUNCTION__]['param']['BankAccountNo'] = $_POST['BankAccountNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['SecondaryBank'] = $_POST['SecondaryBank'];
			$_SESSION['agent_'.__FUNCTION__]['param']['SecondaryBankAccountNo'] = $_POST['SecondaryBankAccountNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['DOBFrom'] = $_POST['DOBFrom'];
			$_SESSION['agent_'.__FUNCTION__]['param']['DOBTo'] = $_POST['DOBTo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['NRIC'] = $_POST['NRIC'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Passport'] = $_POST['Passport'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Nationality'] = $_POST['Nationality'];
			$_SESSION['agent_'.__FUNCTION__]['param']['PhoneNo'] = $_POST['PhoneNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['FaxNo'] = $_POST['FaxNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['MobileNo'] = $_POST['MobileNo'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Email'] = $_POST['Email'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail1'] = $_POST['PlatformEmail1'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail2'] = $_POST['PlatformEmail2'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail3'] = $_POST['PlatformEmail3'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail4'] = $_POST['PlatformEmail4'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail5'] = $_POST['PlatformEmail5'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail6'] = $_POST['PlatformEmail6'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail7'] = $_POST['PlatformEmail7'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail8'] = $_POST['PlatformEmail8'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail9'] = $_POST['PlatformEmail9'];
                        $_SESSION['agent_'.__FUNCTION__]['param']['PlatformEmail10'] = $_POST['PlatformEmail10'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Prompt'] = $_POST['Prompt'];
			$_SESSION['agent_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

			// Set Query Variable
			$_SESSION['agent_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agent_'.__FUNCTION__]['query_title'] = "Search Results";
		//}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agent_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['agent_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
                        $search = "on";
		}
		else
		{
			$query_title = "All Results";
                        $search = "off";
		}
                
                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                
                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }
                
                
                $child = implode(',', $_SESSION['agentchild']);
                
                unset($_SESSION['agentchild']);
                
                

                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent WHERE ID IN (".$child.") ".$_SESSION['agent_'.__FUNCTION__]['query_condition'];
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn();

                    $targetpage = $data['config']['SITE_DIR'].'/agent/agent/editindex';
                    $limit = 10;
                    $stages = 3;
                    $page = mysql_escape_string($_GET['page']);
                    if ($page) {
                            $start = ($page - 1) * $limit;
                    } else {
                            $start = 0;
                    }

                    // Initialize Pagination
                    $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

                    $sql = "SELECT * FROM agent WHERE ID IN (".$child.") ".$_SESSION['agent_'.__FUNCTION__]['query_condition']." ORDER BY ID DESC LIMIT $start, $limit";
                                                                                          

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Profitsharing' => number_format((float)$row['Profitsharing'], 2, '.', '') /*AgentModel::getAgentReport($row['ID'], $filename)*/,
			'Name' => $row['Name'],
                        'Remark' => $row['Remark'],    
			'Company' => $row['Company'],
                        'Host' => $row['Host'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'PlatformEmail1' => $row['PlatformEmail1'],
                        'PlatformEmail2' => $row['PlatformEmail2'],
                        'PlatformEmail3' => $row['PlatformEmail3'], 
                        'PlatformEmail4' => $row['PlatformEmail4'],
                        'PlatformEmail5' => $row['PlatformEmail5'],
                        'PlatformEmail6' => $row['PlatformEmail6'],
                        'PlatformEmail7' => $row['PlatformEmail7'],
                        'PlatformEmail8' => $row['PlatformEmail8'],
                        'PlatformEmail9' => $row['PlatformEmail9'],
                        'PlatformEmail10' => $row['PlatformEmail10'],    
			'Prompt' => CRUD::isActive($row['Prompt']),
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		/*Debug::displayArray($result);
		exit;*/
                
                $_SESSION['agent']['redirect'] = __FUNCTION__;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Agents", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/editindex.inc.php', 'agent_delete' => $_SESSION['admin']['agent_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.agent.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_editindex_url,"",$this->config,"Agent"),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'country_list' => CountryModel::getCountryList(), 'bank_list' => BankModel::getBankList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agent_delete']);

		return $this->output;
	}

	public function AgentEditProcess($param)
	{
            $allowedHost = array('mail','*', 'www', 'ftp');
            
               
            
            $this->getloopAgentParent($param);
            $_POST['Company'] = AgentModel::getAllAgent($_SESSION['platform_agent'], "Company");
            
            $this->getloopAgentParent($param);
            $_POST['IPAddress'] = AgentModel::getAllAgent($_SESSION['platform_agent'], "IPAddress");
            
            if($param!=$_SESSION['platform_agent'])
            {    
            
                $_POST['TypeID'] = '2';
            
            }
            else
            {
                $_POST['TypeID'] = '1';
            } 
            
            unset($_SESSION['platform_agent']);
            
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM agent WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM agent WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM agent WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/
        
            
            
            
        
        
        $error = array();
                
        $error['count'] = 0; 
        
        $emailDiff = AgentModel::getAllAgent($param, "Email");

        if (strcasecmp($emailDiff, $_POST['Email']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentEmail = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['Email']);

            if($agentEmailCount>'0')
            {
                $i_agentEmail += 1;
            } 



            $error['count'] += $i_agentEmail; 

        }
        
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail1");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail1']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail1 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail1']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail1 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail1;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail2");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail2']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail2 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail2']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail2 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail2;

        }
        
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail3");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail3']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail3 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail3']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail3 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail3;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail4");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail4']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail4 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail4']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail4 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail4;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail5");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail5']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail5 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail5']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail5 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail5;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail6");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail6']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail6 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail6']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail6 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail6;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail7");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail7']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail7 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail7']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail7 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail7;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail8");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail8']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail8 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail8']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail8 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail8;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail9");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail9']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail9 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail9']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail9 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail9;

        }
        
        if (in_array($_POST['Host'], $allowedHost)) {
            $error['count'] += 1;
        }
        
        $pattern = '/[^a-zA-Z]/';
        $exist = preg_match($pattern, $_POST['Host']);
        
        if ($exist===1) {
            $error['count'] += 1;
        }
        
        
        
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail10");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail10']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail10 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail10']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail10 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail10;

        }
        
        
        
        // Check is username exists
        $sql = "SELECT COUNT(*) AS agentCompany FROM agent WHERE ID != '".$param."' AND CONCAT_WS('.', Host, Company) = '".$_POST['Host'].'.'.$_POST['Company']."' AND Enabled = '1'";

        $i_agentCompany = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $agentCompany = $row['agentCompany'];

            
        }
        
        if($agentCompany>'0')
        {
            $i_agentCompany += 1;
            $error['count'] += $i_agentCompany;
        }
        
        
               
            
        // Handle Image Upload
        $upload['Logo'] = File::uploadFile('Logo',1,2,"agent");

        if ($upload['Logo']['upload']['status']=="Empty")
        {
            if ($_POST['LogoRemove']==1)
            {
                $file_location['Logo'] = "";
                Image::deleteImage($_POST['LogoCurrent']);
                Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'cover'));
            }
            else
            {
                $file_location['Logo'] = $_POST['LogoCurrent'];
            }
        }
        else if ($upload['Logo']['upload']['status']=="Uploaded")
        {
            $file_location['Logo'] = $upload['Logo']['upload']['destination'];
            Image::generateImage($file_location['Logo'],66,66,'thumb');
            Image::generateImage($file_location['Logo'],145,145,'cover');
            Image::generateImage($file_location['Logo'],300,300,'medium');
            Image::deleteImage($_POST['LogoCurrent']);
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['Logo'] = $upload['Logo']['error'];

            $file_location['Logo'] = "";
        }
            
        $i_bank = 0;
        
        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {
            
            
            
        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);
        
            if($bankCount == '0')
            {
                
            }
            else
            {
                $i_bank += 1;
            } 
            
        }
        
        $agentHost = $this->getAllAgent($param, "Host");
        
        if($error['count']==0)
        {    
        
            $dnsMessage = Helper::updateListRecord($_POST['Company'], $agentHost, $_POST['IPAddress'], $_POST['Host']);
        
        }
            
        if($dnsMessage['status']=='Failed')
        {
            $error['count'] += 1;
        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }
            
            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }
            
            if ($i_agentEmail>0)
            {
                $error['Email'] = 1;
            }
            
            if ($i_agentPlatformEmail1>0)
            {
                $error['PlatformEmail1'] = 1;
            }
            
            if ($i_agentPlatformEmail2>0)
            {
                $error['PlatformEmail2'] = 1;
            }
            
            if ($i_agentPlatformEmail3>0)
            {
                $error['PlatformEmail3'] = 1;
            }
            
            if ($i_agentPlatformEmail4>0)
            {
                $error['PlatformEmail4'] = 1;
            }
            
            if ($i_agentPlatformEmail5>0)
            {
                $error['PlatformEmail5'] = 1;
            }
            
            if ($i_agentPlatformEmail6>0)
            {
                $error['PlatformEmail6'] = 1;
            }
            
            if ($i_agentPlatformEmail7>0)
            {
                $error['PlatformEmail7'] = 1;
            }
            
            if ($i_agentPlatformEmail8>0)
            {
                $error['PlatformEmail8'] = 1;
            }
            
            if ($i_agentPlatformEmail9>0)
            {
                $error['PlatformEmail9'] = 1;
            }
            
            if ($i_agentPlatformEmail10>0)
            {
                $error['PlatformEmail10'] = 1;
            }
            
            if ($i_agentCompany>0)
            {
                $error['Company'] = 1;
            }
            
            if ($i_host>0)
            {
                $error['Host'] = 1;
            }
            
            
            if($dnsMessage['status']=='Failed')
            {
                $error['DNS'] = 1;
            }
            

            $_SESSION['agent']['agent_edit_info'] = Helper::unescape($_POST);
        }
        else
        {
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }
            
            $concat = '';
                 
            
            $_POST['Product']['count'] = count($_POST['Product']);

            for ($i=0; $i<$_POST['Product']['count']; $i++) {

                    $concat.=$_POST['Product'][$i];
                    $z = $i + 1;
                    if($z===$_POST['Product']['count']){



                    }
                    else 
                    {
                        $concat.=',';
                    }
                    
                   

            }
            
            
            $member = MemberModel::getMemberAgent($param);
            //Debug::displayArray($member);
            
            $prod = array();
            
            for ($i=0; $i<$_POST['Product']['count']; $i++) {
                array_push($prod, $_POST['Product'][$i]);
            }
            
           
            
            $ProductList = AgentModel::getAgentProduct($param);
                        
            $ProductList = explode(',', $ProductList);

            $ProductList['count'] = count($ProductList);
            
            $intersect = array_intersect($prod, $ProductList);
            
            $intersect = array_values($intersect);
            
            if(empty($concat)===TRUE)
            {
                
                $sql = "DELETE FROM wallet WHERE AgentID = '".$param."'";
                
		$count = $this->dbconnect->exec($sql);
            }
            else 
            {                           
                if(empty($intersect)===TRUE){

                    $sql = "DELETE FROM wallet WHERE AgentID = '".$param."'";

                    $count = $this->dbconnect->exec($sql);
                    
                     
                    
                    for ($i=0; $i<$_POST['Product']['count']; $i++) {
                        
                        for ($z=0; $z <$member['count']; $z++)
                        {
                            $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                            $value = "('0', '".$_POST['Product'][$i]."', '".$param."', '".$member[$z]['ID']."', '1')";

                            $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;
                            //echo $sql2;
                            //exit;
                            $this->dbconnect->exec($sql2);
                        }
                    }
                    

                }elseif(empty($intersect)===FALSE){
                    //echo 'hi';
                    //exit;
                    //Debug::displayArray($intersect);
                    //exit;
                    $productdeleted = implode(',', $intersect);
                    //Debug::displayArray($productdeleted);
                    //exit;
                    
                    $sql = "DELETE FROM wallet WHERE AgentID = '".$param."' AND ProductID NOT IN (".$productdeleted.")";
                    //echo $sql;
                    //exit;
                    $count = $this->dbconnect->exec($sql);
                    
                    $newProductList = AgentModel::getAgentProduct($param);
                    $newProductList = explode(',', $newProductList);
                    
                    //Debug::displayArray($prod);
                    //Debug::displayArray($newProductList);
                    //exit;
                                       
                    $newProd = array_diff($prod, $newProductList);
                    
                    //Debug::displayArray($newProd);
                    //exit;
                    if(empty($newProd)===TRUE)
                    {
                        
                    }
                    else
                    {
                        $newProd = array_values($newProd);
                        $newProd['count'] = count($newProd);
                        
                        for ($i=0; $i<$newProd['count']; $i++) {
                        
                            for ($z=0; $z <$member['count']; $z++)
                            {
                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                $value = "('0', '".$newProd[$i]."', '".$param."', '".$member[$z]['ID']."', '1')";

                                $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;
                                //echo $sql2;
                                //exit;
                                $this->dbconnect->exec($sql2);
                            }
                        }
                        
                    }    
                    
                }
            }
            
            
            $agentTypeId = $this->getAllAgent($param, "TypeID");
            
            $agentParentId = $this->getAllAgent($param, "ParentID");
            
            if($agentTypeId=='2' && $agentParentId!='0')
            {    
            
                if($_POST['TypeID']=='1' && $_POST['ParentID']=='0')
                {

                    $sql3 = "DELETE FROM agent_promotion WHERE AgentID ='".$param."'";
                    $count3 = $this->dbconnect->exec($sql3);

                    $sql4 = "DELETE FROM agent_block WHERE AgentID ='".$param."'";
                    $count4 = $this->dbconnect->exec($sql4);

                    $sql5 = "DELETE FROM bank_info WHERE AgentID ='".$param."'";
                    $count5 = $this->dbconnect->exec($sql5);

                }
            }
                $_POST['Chat'] = addslashes($_POST['Chat']);
                
                    
                
    		$sql = "UPDATE agent SET Credit='".$_POST['Credit']."', Product='".$concat."', TypeID='".$_POST['TypeID']."', Remark='".$_POST['Remark']."', ParentID='".$_POST['ParentID']."', Name='".$_POST['Name']."', Profitsharing='".$_POST['Profitsharing']."', Company='".$_POST['Company']."', Host='".$_POST['Host']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', IPAddress='".$_POST['IPAddress']."', Chat='".$_POST['Chat']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', PlatformEmail1='".$_POST['PlatformEmail1']."', PlatformEmail2='".$_POST['PlatformEmail2']."', PlatformEmail3='".$_POST['PlatformEmail3']."', PlatformEmail4='".$_POST['PlatformEmail4']."', PlatformEmail5='".$_POST['PlatformEmail5']."', PlatformEmail6='".$_POST['PlatformEmail6']."', PlatformEmail7='".$_POST['PlatformEmail7']."', PlatformEmail8='".$_POST['PlatformEmail8']."', PlatformEmail9='".$_POST['PlatformEmail9']."', PlatformEmail10='".$_POST['PlatformEmail10']."', BackgroundColour='".$_POST['BackgroundColour']."', FontColour='".$_POST['FontColour']."', Logo='".$file_location['Logo']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";
			//echo $sql;
			//exit;
    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
            
            
            
            
            if($_POST['TypeID']=='2')
            {
                if($_POST['ParentID']!='0')
                {
                    $this->getloopAgentParent($_POST['ParentID']);
                    $agentBlockCount = AgentBlockModel::getAgentBlockByAgentCount($_SESSION['platform_agent']);
                    $agentPromotionCount = AgentPromotionModel::getAgentPromotionListByAgentCount($_SESSION['platform_agent']);
                    $agentBankInfoCount = BankInfoModel::getBankInfoListByAgentCount($_SESSION['platform_agent']);
                    
                    $tCount = $agentBlockCount + $agentPromotionCount + $agentBankInfoCount;
                    if($tCount == '0')
                    {    
                        
                    
                    
                    $agentBlockList = AgentBlockModel::getAgentBlockByAgentID($_SESSION['platform_agent']);
                    $agentPromotionList = AgentPromotionModel::getAgentPromotionListByAgentID($_SESSION['platform_agent']);
                    $agentBankInfoList = BankInfoModel::getBankInfoListByAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);
            
                    for ($p = 0; $p < $agentBlockList['count']; $p++) {

                        $key = "(AgentID, Name, Content, Position, Enabled)";
                        $value = "('".$param."', '".$agentBlockList[$p]['Name']."', '".$agentBlockList[$p]['Content']."', '".$agentBlockList[$p]['Position']."', '".$agentBlockList[$p]['Enabled']."')";

                        $sql = "INSERT INTO agent_block ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);

                    }
                    
                    
                    for ($l = 0; $l < $agentPromotionList['count']; $l++) {
                                               
                        $key = "(AgentID, Title, Position, First, Enabled)";
                        $value = "('".$param."', '".$agentPromotionList[$l]['Title']."', '".$agentPromotionList[$l]['Position']."', '".$agentPromotionList[$l]['First']."', '".$agentPromotionList[$l]['Enabled']."')";

                        $sql = "INSERT INTO agent_promotion ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                    for ($a = 0; $a < $agentBankInfoList['count']; $a++) {
                       
                        $key = "(AgentID, Name, ImageURL, Description)";
                        $value = "('".$param."', '".$agentBankInfoList[$a]['Name']."', '".$agentBankInfoList[$a]['ImageURL']."', '".$agentBankInfoList[$a]['Description']."')";

                        $sql = "INSERT INTO bank_info ".$key." VALUES ". $value;
                                                
                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                }
                
                unset($_SESSION['platform_agent']);
                }
            }
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Agent...", 'template' => 'agent.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error, 'dnsMessage' => $dnsMessage),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM agent WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
                    if ($row['Logo']=='')
                    {
                        $cover_image = '';
                    }
                    else
                    {
                        $cover_image = Image::getImage($row['Logo'],'thumb');
                    }
                    
			$result[$i] = array(
			'ID' => $row['ID'],
                        'ParentID' => $row['ParentID'],
                        'TypeID' => $row['TypeID'],
			'Name' => $row['Name'],
                        'Remark' => $row['Remark'],    
			'Profitsharing' => $row['Profitsharing'],
			'Company' => $row['Company'],
                        'Host' => $row['Host'],    
			'Credit' => $row['Credit'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],			
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
                        'IPAddress' => $row['IPAddress'], 
                        'Chat' => stripslashes($row['Chat']),    
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'], 
                        'PlatformEmail1' => $row['PlatformEmail1'],
                        'PlatformEmail2' => $row['PlatformEmail2'],
                        'PlatformEmail3' => $row['PlatformEmail3'],
                        'PlatformEmail4' => $row['PlatformEmail4'],    
                        'PlatformEmail5' => $row['PlatformEmail5'],
                        'PlatformEmail6' => $row['PlatformEmail6'],
                        'PlatformEmail7' => $row['PlatformEmail7'],
                        'PlatformEmail8' => $row['PlatformEmail8'],
                        'PlatformEmail9' => $row['PlatformEmail9'],
                        'PlatformEmail10' => $row['PlatformEmail10'],    
                        'BackgroundColour' => $row['BackgroundColour'], 
                        'FontColour' => $row['FontColour'],
                        'LogoCover' => $cover_image,
                        'Logo' => $row['Logo'],    
			'Prompt' => $row['Prompt'],
			'Enabled' => $row['Enabled']);

			$i += 1;
                        
                        $product = explode(',', $row['Product']);
                     
                        $product['count'] = count($product);
		}

        if ($_SESSION['admin']['agent_edit_info']!="")
        {
            $form_input = $_SESSION['admin']['agent_edit_info'];

            // Unset temporary agent info input
            unset($_SESSION['admin']['agent_edit_info']);
        }

		$this->output = array(
		'config' => $this->config,
		'parent' => array('id' => $param),
		'page' => array('title' => "Edit Agent", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'admin_add' => $_SESSION['admin']['agent_add'], 'admin_edit' => $_SESSION['admin']['agent_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.agent_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Agent"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'gender_list' => CRUD::getGenderList(), 'agent_list' => AgentModel::getNotAgentList($param), 'bank_list' => BankModel::getBankList(), 'agenttype_list' => AgentTypeModel::getAgentTypeList(), 'product_list' => ProductModel::getProductList(), 'product' => $product),
		'form_param' => $form_input,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['agent_add']);
		unset($_SESSION['admin']['agent_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
            $allowedHost = array('mail','*', 'www', 'ftp');
            
	    /*if ($_POST['Nationality']==151)
        {
            $_POST['Passport'] = '';

            // Check is NRIC exists
            $sql = "SELECT * FROM agent WHERE NRIC = '".$_POST['NRIC']."' AND ID != '".$param."'";

            $result = array();
            $i_nric = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_nric] = array(
                'NRIC' => $row['NRIC']);

                $i_nric += 1;
            }
        }
        else
        {
            $_POST['NRIC'] = '';

            // Check is Passport exists
            $sql = "SELECT * FROM agent WHERE Passport = '".$_POST['Passport']."' AND ID != '".$param."'";

            $result = array();
            $i_passport = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_passport] = array(
                'Passport' => $row['Passport']);

                $i_passport += 1;
            }
        }

        // Check is username exists
        $sql = "SELECT * FROM agent WHERE Username = '".$_POST['Username']."' AND ID != '".$param."'";

        $result = array();
        $i_username = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i_username] = array(
            'Username' => $row['Username']);

            $i_username += 1;
        }

        $error['count'] = $i_username + $i_nric + $i_passport;*/
            
        $error = array();    
        $error['count'] = 0;               
            
        $emailDiff = AgentModel::getAllAgent($param, "Email");



        if (strcasecmp($emailDiff, $_POST['Email']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentEmail = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['Email']);

            if($agentEmailCount>'0')
            {
                $i_agentEmail += 1;
            } 



            $error['count'] += $i_agentEmail;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail1");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail1']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail1 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail1']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail1 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail1;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail2");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail2']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail2 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail2']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail2 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail2;

        }
        
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail3");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail3']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail3 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail3']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail3 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail3;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail4");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail4']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail4 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail4']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail4 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail4;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail5");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail5']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail5 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail5']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail5 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail5;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail6");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail6']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail6 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail6']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail6 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail6;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail7");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail7']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail7 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail7']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail7 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail7;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail8");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail8']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail8 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail8']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail8 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail8;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail9");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail9']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail9 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail9']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail9 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail9;

        }
        
        $emailDiff = AgentModel::getAllAgent($param, "PlatformEmail10");



        if (strcasecmp($emailDiff, $_POST['PlatformEmail10']) == 0) {
            $emailUnique = '1';
        }
        else
        {
            $emailUnique = '0';
        }    

        if($emailUnique=='0')
        {    

            $i_agentPlatformEmail10 = 0;

            $agentEmailCount = $this->getAgentUniqueEmail($_POST['PlatformEmail10']);

            if($agentEmailCount>'0')
            {
                $i_agentPlatformEmail10 += 1;
            } 



            $error['count'] += $i_agentPlatformEmail10;

        }
        
        if (in_array($_POST['Host'], $allowedHost)) {
            $error['count'] += 1;
        }
        
        $pattern = '/[^a-zA-Z]/';
        $exist = preg_match($pattern, $_POST['Host']);
        
        if ($exist===1) {
            $error['count'] += 1;
        }
        
        
        
        
        
        // Check is username exists
        $sql = "SELECT COUNT(*) AS agentCompany FROM agent WHERE ID != '".$param."' AND CONCAT_WS('.', Host, Company) = '".$_POST['Host'].'.'.$_POST['Company']."' AND Enabled = '1'";

        $i_agentCompany = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $agentCompany = $row['agentCompany'];

            
        }
        
        if($agentCompany>'0')
        {
            $i_agentCompany += 1;
            $error['count'] += $i_agentCompany;
        }
        
        
            
        $upload['Logo'] = File::uploadFile('Logo',1,2,"agent");

        if ($upload['Logo']['upload']['status']=="Empty")
        {
            if ($_POST['LogoRemove']==1)
            {
                $file_location['Logo'] = "";
                Image::deleteImage($_POST['LogoCurrent']);
                Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'cover'));
            }
            else
            {
                $file_location['Logo'] = $_POST['LogoCurrent'];
            }
        }
        else if ($upload['Logo']['upload']['status']=="Uploaded")
        {
            $file_location['Logo'] = $upload['Logo']['upload']['destination'];
            Image::generateImage($file_location['Logo'],66,66,'thumb');
            Image::generateImage($file_location['Logo'],145,145,'cover');
            Image::generateImage($file_location['Logo'],300,300,'medium');
            Image::deleteImage($_POST['LogoCurrent']);
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'thumb'));
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'cover'));
            Image::deleteImage(Image::getImage($_POST['LogoCurrent'],'medium'));
        }
        else
        {
            $error['count'] += 1;
            $error['Logo'] = $upload['Logo']['error'];

            $file_location['Logo'] = "";
        }    
            
        $i_bank = 0;
        
        if($_POST['BankAccountNo'] == '' || $_POST['Bank'] == '')
        {
            
            
            
        }
        else
        {
            $bankCount = BankInfoModel::getUniqueBank($_POST['Bank'], $_POST['BankAccountNo']);
        
            if($bankCount == '0')
            {
                
            }
            else
            {
                $i_bank += 1;
            } 
            
        }
        
        $agentHost = $this->getAllAgent($param, "Host");
        
        if($error['count']==0)
        {    
        
            $dnsMessage = Helper::updateListRecord($_POST['Company'], $agentHost, $_POST['IPAddress'], $_POST['Host']);
        
        }
            
        if($dnsMessage['status']=='Failed')
        {
            $error['count'] += 1;
        }

        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_nric>0)
            {
                $error['NRIC'] = 1;
            }
            
            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }

            if ($i_passport>0)
            {
                $error['Passport'] = 1;
            }
            
            if ($i_agentEmail>0)
            {
                $error['Email'] = 1;
            }
            
            if ($i_agentPlatformEmail1>0)
            {
                $error['PlatformEmail1'] = 1;
            }
            
            if ($i_agentPlatformEmail2>0)
            {
                $error['PlatformEmail2'] = 1;
            }
            
            if ($i_agentPlatformEmail3>0)
            {
                $error['PlatformEmail3'] = 1;
            }
            
            if ($i_agentPlatformEmail4>0)
            {
                $error['PlatformEmail4'] = 1;
            }
            
            if ($i_agentPlatformEmail5>0)
            {
                $error['PlatformEmail5'] = 1;
            }
            
            if ($i_agentPlatformEmail6>0)
            {
                $error['PlatformEmail6'] = 1;
            }
            
            if ($i_agentPlatformEmail7>0)
            {
                $error['PlatformEmail7'] = 1;
            }
            
            if ($i_agentPlatformEmail8>0)
            {
                $error['PlatformEmail8'] = 1;
            }
            
            if ($i_agentPlatformEmail9>0)
            {
                $error['PlatformEmail9'] = 1;
            }
            
            if ($i_agentPlatformEmail10>0)
            {
                $error['PlatformEmail10'] = 1;
            }
            
            if ($i_agentCompany>0)
            {
                $error['Company'] = 1;
            }
            
            if (in_array($_POST['Host'], $allowedHost)) {
                $error['Host'] = 1;
            }
            
            
            if($dnsMessage['status']=='Failed')
            {
                $error['DNS'] = 1;
            }
            

            $_SESSION['admin']['agent_edit_info'] = Helper::unescape($_POST);
        }
        else
        {
            if ($_POST['NewPassword']==1)
            {
                $bcrypt = new Bcrypt(9);
                $hash = $bcrypt->hash($_POST['Password']);
            }
            else
            {
                $hash = $this->getHash($param);
            }

            if ($_POST['Nationality']==151)
            {
                $_POST['Passport'] = '';
            }
            else
            {
                $_POST['NRIC'] = '';
            }
            
            $concat = '';
                 
            
            $_POST['Product']['count'] = count($_POST['Product']);

            for ($i=0; $i<$_POST['Product']['count']; $i++) {

                    $concat.=$_POST['Product'][$i];
                    $z = $i + 1;
                    if($z===$_POST['Product']['count']){



                    }
                    else 
                    {
                        $concat.=',';
                    }
                    
                   

            }
            
            
            $member = MemberModel::getMemberAgent($param);
            //Debug::displayArray($member);
            
            $prod = array();
            
            for ($i=0; $i<$_POST['Product']['count']; $i++) {
                array_push($prod, $_POST['Product'][$i]);
            }
            
           
            
            $ProductList = AgentModel::getAgentProduct($param);
                        
            $ProductList = explode(',', $ProductList);

            $ProductList['count'] = count($ProductList);
            
            $intersect = array_intersect($prod, $ProductList);
            
            $intersect = array_values($intersect);
            
            if(empty($concat)===TRUE)
            {
                
                $sql = "DELETE FROM wallet WHERE AgentID = '".$param."'";
                
		$count = $this->dbconnect->exec($sql);
            }
            else 
            {                           
                if(empty($intersect)===TRUE){

                    $sql = "DELETE FROM wallet WHERE AgentID = '".$param."'";

                    $count = $this->dbconnect->exec($sql);
                    
                     
                    
                    for ($i=0; $i<$_POST['Product']['count']; $i++) {
                        
                        for ($z=0; $z <$member['count']; $z++)
                        {
                            $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                            $value = "('0', '".$_POST['Product'][$i]."', '".$param."', '".$member[$z]['ID']."', '1')";

                            $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;
                            //echo $sql2;
                            //exit;
                            $this->dbconnect->exec($sql2);
                        }
                    }
                    

                }elseif(empty($intersect)===FALSE){
                    //echo 'hi';
                    //exit;
                    //Debug::displayArray($intersect);
                    //exit;
                    $productdeleted = implode(',', $intersect);
                    //Debug::displayArray($productdeleted);
                    //exit;
                    
                    $sql = "DELETE FROM wallet WHERE AgentID = '".$param."' AND ProductID NOT IN (".$productdeleted.")";
                    //echo $sql;
                    //exit;
                    $count = $this->dbconnect->exec($sql);
                    
                    $newProductList = AgentModel::getAgentProduct($param);
                    $newProductList = explode(',', $newProductList);
                    
                    //Debug::displayArray($prod);
                    //Debug::displayArray($newProductList);
                    //exit;
                                       
                    $newProd = array_diff($prod, $newProductList);
                    
                    //Debug::displayArray($newProd);
                    //exit;
                    if(empty($newProd)===TRUE)
                    {
                        
                    }
                    else
                    {
                        $newProd = array_values($newProd);
                        $newProd['count'] = count($newProd);
                        
                        for ($i=0; $i<$newProd['count']; $i++) {
                        
                            for ($z=0; $z <$member['count']; $z++)
                            {
                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                $value = "('0', '".$newProd[$i]."', '".$param."', '".$member[$z]['ID']."', '1')";

                                $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;
                                //echo $sql2;
                                //exit;
                                $this->dbconnect->exec($sql2);
                            }
                        }
                        
                    }    
                    
                }
            }
            
            $agentTypeId = $this->getAllAgent($param, "TypeID");
            
            $agentParentId = $this->getAllAgent($param, "ParentID");
            
            if($agentTypeId=='2' && $agentParentId!='0')
            {    
            
                if($_POST['TypeID']=='1' && $_POST['ParentID']=='0')
                {

                    $sql3 = "DELETE FROM agent_promotion WHERE AgentID ='".$param."'";
                    $count3 = $this->dbconnect->exec($sql3);

                    $sql4 = "DELETE FROM agent_block WHERE AgentID ='".$param."'";
                    $count4 = $this->dbconnect->exec($sql4);

                    $sql5 = "DELETE FROM bank_info WHERE AgentID ='".$param."'";
                    $count5 = $this->dbconnect->exec($sql5);

                }
            }
                $_POST['Chat'] = addslashes($_POST['Chat']);
                
                

    		$sql = "UPDATE agent SET Credit='".$_POST['Credit']."', Product='".$concat."', TypeID='".$_POST['TypeID']."', ParentID='".$_POST['ParentID']."', Name='".$_POST['Name']."', Remark='".$_POST['Remark']."', Profitsharing='".$_POST['Profitsharing']."', Company='".$_POST['Company']."', Host='".$_POST['Host']."', Bank='".$_POST['Bank']."', BankAccountNo='".$_POST['BankAccountNo']."', Username='".$_POST['Username']."', Password='".$hash."', PhoneNo='".$_POST['PhoneNo']."', FaxNo='".$_POST['FaxNo']."', IPAddress='".$_POST['IPAddress']."', Chat='".$_POST['Chat']."', MobileNo='".$_POST['MobileNo']."', Email='".$_POST['Email']."', PlatformEmail1='".$_POST['PlatformEmail1']."', PlatformEmail2='".$_POST['PlatformEmail2']."', PlatformEmail3='".$_POST['PlatformEmail3']."', PlatformEmail4='".$_POST['PlatformEmail4']."', PlatformEmail5='".$_POST['PlatformEmail5']."', PlatformEmail6='".$_POST['PlatformEmail6']."', PlatformEmail7='".$_POST['PlatformEmail7']."', PlatformEmail8='".$_POST['PlatformEmail8']."', PlatformEmail9='".$_POST['PlatformEmail9']."', PlatformEmail10='".$_POST['PlatformEmail10']."', BackgroundColour='".$_POST['BackgroundColour']."', FontColour='".$_POST['FontColour']."', Logo='".$file_location['Logo']."', Prompt='".$_POST['Prompt']."', Enabled='".$_POST['Enabled']."' WHERE ID='".$param."'";
			//echo $sql;
			//exit;
    		$count = $this->dbconnect->exec($sql);

            // Set Status
            $ok = ($count<=1) ? 1 : "";
            
            if($_POST['TypeID']=='2')
            {
                if($_POST['ParentID']!='0')
                {    
                    $this->getloopAgentParent($_POST['ParentID']);          
                    $agentBlockCount = AgentBlockModel::getAgentBlockByAgentCount($_SESSION['platform_agent']);
                    $agentPromotionCount = AgentPromotionModel::getAgentPromotionListByAgentCount($_SESSION['platform_agent']);
                    $agentBankInfoCount = BankInfoModel::getBankInfoListByAgentCount($_SESSION['platform_agent']);
                    
                    $tCount = $agentBlockCount + $agentPromotionCount + $agentBankInfoCount;
                    if($tCount == '0')
                    {
                    
                    $agentBlockList = AgentBlockModel::getAgentBlockByAgentID($_SESSION['platform_agent']);
                    $agentPromotionList = AgentPromotionModel::getAgentPromotionListByAgentID($_SESSION['platform_agent']);
                    $agentBankInfoList = BankInfoModel::getBankInfoListByAgent($_SESSION['platform_agent']);
                    unset($_SESSION['platform_agent']);
            
                    for ($p = 0; $p < $agentBlockList['count']; $p++) {

                        $key = "(AgentID, Name, Content, Position, Enabled)";
                        $value = "('".$param."', '".$agentBlockList[$p]['Name']."', '".$agentBlockList[$p]['Content']."', '".$agentBlockList[$p]['Position']."', '".$agentBlockList[$p]['Enabled']."')";

                        $sql = "INSERT INTO agent_block ".$key." VALUES ". $value;

                        $count = $this->dbconnect->exec($sql);

                    }
                    
                    
                    for ($l = 0; $l < $agentPromotionList['count']; $l++) {
                                               
                        $key = "(AgentID, Title, Position, First, Enabled)";
                        $value = "('".$param."', '".$agentPromotionList[$l]['Title']."', '".$agentPromotionList[$l]['Position']."', '".$agentPromotionList[$l]['First']."', '".$agentPromotionList[$l]['Enabled']."')";

                        $sql = "INSERT INTO agent_promotion ".$key." VALUES ". $value;
                        //echo $sql;
                        //exit;
                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                    for ($a = 0; $a < $agentBankInfoList['count']; $a++) {
                       
                        $key = "(AgentID, Name, ImageURL, Description)";
                        $value = "('".$param."', '".$agentBankInfoList[$a]['Name']."', '".$agentBankInfoList[$a]['ImageURL']."', '".$agentBankInfoList[$a]['Description']."')";

                        $sql = "INSERT INTO bank_info ".$key." VALUES ". $value;
                                                
                        $count = $this->dbconnect->exec($sql);
                        

                    }
                    
                } 
                
                unset($_SESSION['platform_agent']);
                }
            }
            
                
            
            
        }

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Agent...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error, 'dnsMessage' => $dnsMessage),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
                $company = $this->getAgent($param, "Company");
                $host = $this->getAgent($param, "Host");
            
                $sql2 = "DELETE FROM wallet WHERE AgentID ='".$param."'";
		$count2 = $this->dbconnect->exec($sql2);
            
		$sql = "DELETE FROM agent WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
                
                $sql3 = "DELETE FROM agent_promotion WHERE AgentID ='".$param."'";
		$count3 = $this->dbconnect->exec($sql3);
                
                $sql4 = "DELETE FROM agent_block WHERE AgentID ='".$param."'";
		$count4 = $this->dbconnect->exec($sql4);
                
                $sql5 = "DELETE FROM bank_info WHERE AgentID ='".$param."'";
		$count5 = $this->dbconnect->exec($sql5);
                
                Helper::deleteListRecord($company, $host);
                
                
                
        // Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Agent...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
        'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getAllAgentID(){
		$sql = "SELECT COUNT(ID) FROM agent";
		$result = $this->dbconnect->query($sql);
		$result = $result->fetchColumn();
		if ($result==1) {
			$sql = "SELECT ID FROM agent";
			$result = $this->dbconnect->query($sql);
			$result = $result->fetchColumn();
		} else {
			$sql = "SELECT ID FROM agent";

			foreach($this->dbconnect->query($sql) as $row){
				$ID .= $row['ID'].',';
			}
			$ID = rtrim($ID,',');
			$result = '('.$ID.')';
		}

		return $result;

	}
        
        public function getAgentID($param){
            
		$sql = "SELECT COUNT(*) AS agentCount FROM agent WHERE UniqueCode = '".$param."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$count = $row['agentCount'];
		}
                
                if($count=='1')
                {    
                
                    $sql = "SELECT ID FROM agent WHERE UniqueCode = '".$param."'";

                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $result = $row['ID'];
                    }
                }
                else
                {
                    $result = FALSE;
                }    

		return $result;

	}

	public function getAgentCredit()
	{

		$sql = "SELECT * FROM agent WHERE ID = '".$_SESSION['agent']['ID']."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array('Credit' => $row['Credit']);
		}
		$_SESSION['agent']['Credit'] = $result[0]['Credit'];
	}
        
        public function familyTree($array, $data)
	{
            
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                        $space = '';
                        
                        for ($index1 = 0; $index1 < $array[$index]['Padding']; $index1++) {
                            
                            $space.='&nbsp;';
                            
                        }
                            $data.= '<option value="/agent/transaction/agent/'. $array[$index]['ID'].'?page=all"';    

                            if ($array[$index]['ID']==$_GET['id']) { 
                                $data.= 'selected="selected"'; 

                            } 

                            $data.='>';

                            $data.= $space.$array[$index]['Name'].' ('. $array[$index]['Company'].')</option>';
                            

                            AgentModel::familyTree($array[$index]['Child'], $data);
                      }
                     
                  
                }
                
        }
        
        public function getChildAncestors($array, $data)
	{
            
                if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                        $space = '';
                        
                        for ($index1 = 0; $index1 < $array[$index]['Padding']; $index1++) {
                            
                            $space.='&nbsp;';
                            
                        }
                            $data.= '<option value="/agent/transaction/agent/'. $array[$index]['ID'].'?page=all"';    

                            if ($array[$index]['ID']==$_GET['id']) { 
                                $data.= 'selected="selected"'; 

                            } 

                            $data.='>';

                            $data.= $space.$array[$index]['Name'].' ('. $array[$index]['Company'].')</option>';
                            

                            AgentModel::familyTree($array[$index]['Child'], $data);
                      }
                     
                  
                }
                
        }
        
        public function childAncestors($array, $set)
	{
             //Debug::displayArray($array);
             //exit; 
           
            if(is_array($array)===TRUE)
                {   

                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          
                            array_push($set, array($array[$index]['ID'], $array[$index]['Padding']));                                              
                                
                               
                            if(is_array($array[$index]['Child'])===TRUE)
                            {   
                                $set = AgentModel::childAncestors($array[$index]['Child'], $set);
                            }
                            //return $ID;
                      }
                     
                  
                }
                  
                
                
                   
             
             return $set;   
        } 
        
             

	public function getAgent($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent WHERE ID = '".$param."' AND Enabled = '1'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
                        'Profitsharing' => $row['Profitsharing'],   
                        'TypeID' => $row['TypeID'],    
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Credit' => $row['Credit'],
			'Company' => $row['Company'],
                        'Host' => $row['Host'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'PlatformEmail1' => $row['PlatformEmail1'],
                        'PlatformEmail2' => $row['PlatformEmail2'],
                        'PlatformEmail3' => $row['PlatformEmail3'],
                        'PlatformEmail4' => $row['PlatformEmail4'],    
                        'PlatformEmail5' => $row['PlatformEmail5'],
                        'PlatformEmail6' => $row['PlatformEmail6'],
                        'PlatformEmail7' => $row['PlatformEmail7'],
                        'PlatformEmail8' => $row['PlatformEmail8'],
                        'PlatformEmail9' => $row['PlatformEmail9'],
                        'PlatformEmail10' => $row['PlatformEmail10'],    
                        'BackgroundColour' => $row['BackgroundColour'],
                        'FontColour' => $row['FontColour'],
                        'Logo' => $row['Logo'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}
                
                // Determine if get all fields or one specific field
                if ($column!="")
                {
                    $result = $result[0][$column];
                }
                else
                {
                    $result = $result[0];
                }



		return $result;
	}
        
        public function getAllAgent($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
                        'Profitsharing' => $row['Profitsharing'],   
                        'TypeID' => $row['TypeID'],    
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Credit' => $row['Credit'],
			'Company' => $row['Company'],
                        'Host' => $row['Host'],
			'Bank' => $row['Bank'],
                        'IPAddress' => $row['IPAddress'],    
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
                        'PlatformEmail1' => $row['PlatformEmail1'],
                        'PlatformEmail2' => $row['PlatformEmail2'],
                        'PlatformEmail3' => $row['PlatformEmail3'],
                        'PlatformEmail4' => $row['PlatformEmail4'],    
                        'PlatformEmail5' => $row['PlatformEmail5'],
                        'PlatformEmail6' => $row['PlatformEmail6'],
                        'PlatformEmail7' => $row['PlatformEmail7'],
                        'PlatformEmail8' => $row['PlatformEmail8'],
                        'PlatformEmail9' => $row['PlatformEmail9'],
                        'PlatformEmail10' => $row['PlatformEmail10'],    
                        'BackgroundColour' => $row['BackgroundColour'],
                        'FontColour' => $row['FontColour'],
                        'Logo' => $row['Logo'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}
                
                // Determine if get all fields or one specific field
                if ($column!="")
                {
                    $result = $result[0][$column];
                }
                else
                {
                    $result = $result[0];
                }



		return $result;
	}
        
        public function getDomainWithSubdomain($domain)
	{
		$crud = new CRUD();
                
                $result = array();
                $i = 0;

		$sql = "SELECT COUNT(*) AS agentDomain FROM agent WHERE Host !='' AND CONCAT_WS('.', Host, Company) = '".$domain."' AND Enabled = '1'";
                
                foreach ($this->dbconnect->query($sql) as $row)
		{
                    $agentCount = $row['agentDomain'];
                }
                
                if($agentCount>'0')
                {    
                
                    $sql = "SELECT * FROM agent WHERE Host !='' AND CONCAT_WS('.', Host, Company) = '".$domain."' AND Enabled = '1'";

                    
                    foreach ($this->dbconnect->query($sql) as $row)
                    { 
                            
                        
                            $result[$i] = array(
                            'RegisterLink' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/member/member/register?rid='.urlencode(base64_encode($row['ID'])),                               
                            'MemberLink' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/member/member/login?rid='.urlencode(base64_encode($row['ID'])), 
                            'ForgotLink' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/member/member/forgotpassword?rid='.urlencode(base64_encode($row['ID'])),     
                            'IPAddress' => $row['IPAddress'],
                            'Chat' => stripslashes($row['Chat']),
                            'subdomainStatus' => 'Exist');

                            $i += 1;
                    }
                
                }
                elseif($agentCount=='0')
                {
                    
                    $result[0] = array(
                            'systemNotFound' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/main/content/systemnotfound', 
                            'Chat' => '<script type="text/javascript">
                             var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                             (function(){
                             var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                             s1.async=true;
                             s1.src=\'https://embed.tawk.to/5624b43b21bfee9647916237/default\';
                             s1.charset=\'UTF-8\';
                             s1.setAttribute(\'crossorigin\',\'*\');
                             s0.parentNode.insertBefore(s1,s0);
                             })();
                             </script>',
                            'subdomainStatus' => 'None');
                } 



		return $result;
	}
        
        public function getDomain($domain)
	{
		$crud = new CRUD();

		$sql = "SELECT COUNT(*) AS agentDomain FROM agent WHERE Company = '".$domain."' AND Enabled = '1' AND Host = ''";
                //echo $sql;
                //exit;
                
                foreach ($this->dbconnect->query($sql) as $row)
		{
                    $agentCount = $row['agentDomain'];
                }
                
                if($agentCount>'0')
                {    
                
                    $sql = "SELECT * FROM agent WHERE Company = '".$domain."' AND Enabled = '1' AND Host = ''";

                    $result = array();
                    $i = 0;
                    foreach ($this->dbconnect->query($sql) as $row)
                    { 
                            
                        
                            $result[$i] = array(
                            'RegisterLink' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/member/member/register?rid='.urlencode(base64_encode($row['ID'])),                               
                            'MemberLink' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/member/member/login?rid='.urlencode(base64_encode($row['ID'])),
                            'ForgotLink' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/member/member/forgotpassword?rid='.urlencode(base64_encode($row['ID'])),   
                            'IPAddress' => $row['IPAddress'],
                            'Chat' => stripslashes($row['Chat']),
                            'subdomainStatus' => 'Exist');

                            $i += 1;
                    }
                
                }
                elseif($agentCount=='0')
                {
                    
                    $result[0] = array(
                            'systemNotFound' => $this->config['SITE_URL'].$this->config['SITE_DIR'].'/main/content/systemnotfound', 
                            'Chat' => '<script type="text/javascript">
                             var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                             (function(){
                             var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                             s1.async=true;
                             s1.src=\'https://embed.tawk.to/5624b43b21bfee9647916237/default\';
                             s1.charset=\'UTF-8\';
                             s1.setAttribute(\'crossorigin\',\'*\');
                             s0.parentNode.insertBefore(s1,s0);
                             })();
                             </script>',
                            'subdomainStatus' => 'None');
                } 



		return $result;
	}
        

	public function getAgentNameWithoutKey($param)
	{

		$sql = "SELECT Name FROM agent WHERE ID = '".$param."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['Name'];
		}

		return $result;
	}
        
        
        public function getAgentUniqueEmail($param)
	{
            if(empty($param)===FALSE)
            {    

		$sql = "SELECT COUNT(*) AS agentEmail FROM agent WHERE BINARY `Email` = '".$param."' OR BINARY `PlatformEmail1` = '".$param."' OR BINARY `PlatformEmail2` = '".$param."' OR BINARY `PlatformEmail3` = '".$param."' OR BINARY `PlatformEmail4` = '".$param."' OR BINARY `PlatformEmail5` = '".$param."' OR BINARY `PlatformEmail6` = '".$param."' OR BINARY `PlatformEmail7` = '".$param."' OR BINARY `PlatformEmail8` = '".$param."' OR BINARY `PlatformEmail9` = '".$param."' OR BINARY `PlatformEmail10` = '".$param."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['agentEmail'];
		}
                
            }
            else
            {
                $result = '0';
            }    

		return $result;
	}
        
        public function getAdminAgentUniqueEmail($param, $platformAgentEmail)
	{

		$sql = "SELECT COUNT(*) AS agentEmail FROM agent WHERE BINARY Email = '".$param."'";
                
                

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['agentEmail'];
		}
                
                if($result=='1')
                {
                    
                    $sql = "SELECT Email FROM agent WHERE ID = '".$platformAgentEmail."'";
 
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $result = $row['Email'];
                    }
                    
                    if (strcasecmp($result, $param) == 0) {
                        $result = '1';
                    }
                    else
                    {
                        $result = '0';
                    } 
                }
                else
                {
                    $result = '0';
                }    

		return $result;
	}

	public function getAgentAdminReport($param, $filename)
	{
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$Profitsharing = $row['Profitsharing'];
				//$i += 1;


			}


		$month = date('m', strtotime($_SESSION['agent_'.$filename]['Month']));

		$year = $_SESSION['agent_'.$filename]['Year'];
		//echo $param;

		/*if ($_POST['Month']=='') {
		    $DateFrom = "";
		} else {
		    $DateFrom = " AND t.Date BETWEEN '".$_POST['Month']."'";
		}

		if ($_POST['Year']=='') {
		    $DateTo = "";
		} else {
		    $DateTo = " AND '".$_POST['Year']."'";
		}*/


			$sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$param."' AND t.MemberID = m.ID AND t.Date >= '{$year}-{$month}-01 00:00:00' and t.Date <= '{$year}-{$month}-31 23:59:59' AND t.Status = '2'";
			/*echo $sql;
			exit;*/
			$result = array();
			//$transaction['count'] = $result['count'];
			//$i = 0;



			foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$In += $row['t_Debit'];
				$Out += $row['t_Credit'];
				$Bonus += $row['t_Bonus'];
				$Commission += $row['t_Commission'];
				//$i += 1;


			}


			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			/*if($In != 0){

			$Total = $Total/$In;

			$Percentage = $Total * 100;

			}*/
			$Percentage = $profit * ($Profitsharing/100);

			$result = array('Agent' => AgentModel::getAgent($param),'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));
			/*Debug::displayArray($result);
			exit;*/


		unset($profit);
		unset($In);
		unset($Out);
		unset($Total);
		unset($Percentage);

		return $result;
	}

    public function getAgentsMonthsReport($filename, $agent)
	{
		$result = array();

		$year = $_SESSION['agent_'.$filename]['Year'];
		/*echo $year;
		exit;*/

		$sql = "SELECT group_concat(`ID` separator ',') AS IDs FROM agent";

		foreach ($this->dbconnect->query($sql) as $row){

			$IDs = $row['IDs'];

		}
		//echo $IDs;
		$ID = explode(",", $IDs);
		$ID['count'] = count($ID);

		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			       }
            $result[$i]['month'] = "January";
			$result[$i]['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){



		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}    //break;

			$result[$i]['month'] = 'February';
			$result[$i]['year'] = $year;

				    }elseif($i == 3){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			}

			$result[$i]['month'] = 'March';
			$result[$i]['year'] = $year;

				    }elseif($i == 4){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}

			$result[$i]['month'] = 'April';
			$result[$i]['year'] = $year;

					}elseif($i == 5){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			  }

				$result[$i]['month'] = 'May';
				$result[$i]['year'] = $year;

					}elseif($i == 6){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				    $result[$i]['month'] = 'June';
					$result[$i]['year'] = $year;

					}elseif($i == 7){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}
				     $result[$i]['month'] = 'July';
					 $result[$i]['year'] = $year;

					}elseif($i == 8){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

					$result[$i]['month'] = 'August';
					$result[$i]['year'] = $year;

					}elseif($i == 9){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

				   $result[$i]['month'] = 'September';
				   $result[$i]['year'] = $year;

					}elseif($i == 10){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				        //break;
				    $result[$i]['month'] = 'October';
					$result[$i]['year'] = $year;

					}elseif($i == 11){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				               }

					$result[$i]['month'] = 	'November';
					$result[$i]['year'] = $year;

					}elseif($i == 12){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				}
				$result[$i]['month'] = 'December';
				$result[$i]['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = $ID['count'];
		return $result;

	}
        
       
        
        
        public function getFrontAgentsMonthsReport($filename, $agent, $ID, $padding)
	{
  
		$result = array();

		$year = $_SESSION['agent_'.$filename]['Year'];
		
		$ID['count'] = count($ID);

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {


			for ($z=0; $z < $ID['count']; $z++) {
                                                        

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			       }
            $result[$i]['month'] = "January";
			$result[$i]['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){



		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}    //break;

			$result[$i]['month'] = 'February';
			$result[$i]['year'] = $year;

				    }elseif($i == 3){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			}

			$result[$i]['month'] = 'March';
			$result[$i]['year'] = $year;

				    }elseif($i == 4){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}

			$result[$i]['month'] = 'April';
			$result[$i]['year'] = $year;

					}elseif($i == 5){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			  }

				$result[$i]['month'] = 'May';
				$result[$i]['year'] = $year;

					}elseif($i == 6){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				    $result[$i]['month'] = 'June';
					$result[$i]['year'] = $year;

					}elseif($i == 7){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}
				     $result[$i]['month'] = 'July';
					 $result[$i]['year'] = $year;

					}elseif($i == 8){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

					$result[$i]['month'] = 'August';
					$result[$i]['year'] = $year;

					}elseif($i == 9){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

				   $result[$i]['month'] = 'September';
				   $result[$i]['year'] = $year;

					}elseif($i == 10){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				        //break;
				    $result[$i]['month'] = 'October';
					$result[$i]['year'] = $year;

					}elseif($i == 11){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				               }

					$result[$i]['month'] = 	'November';
					$result[$i]['year'] = $year;

					}elseif($i == 12){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = $ID[$z][1];
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				}
				$result[$i]['month'] = 'December';
				$result[$i]['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['padding'] = $padding;
        $result['count'] = $ID['count'];
		return $result;

	}



        public function getNewFrontAgentsMonthsReport($filename, $ID, $m)
	{
  
		$result = array();

		$year = $_SESSION['agent_'.$filename]['Year'];
			
		$crud = new CRUD();
                
                
                                   
                
                        /*$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID."'";

                        foreach ($this->dbconnect->query($sql) as $row)
                        {
                            $Profitsharing = $row['Profitsharing'];

                        }*/
                
                                $In = 0;
                                $Out = 0;
                                $Bonus = 0;
                                $Commission = 0;

                        $sql = "SELECT SUM(t.Debit) as t_Debit, SUM(t.Credit) as t_Credit, SUM(t.Bonus) as t_Bonus, SUM(t.Commission) as t_Commission FROM transaction AS t, member AS m WHERE m.Agent IN (".$ID.") AND t.MemberID = m.ID AND monthname(t.Date) = '{$m}' AND year(t.Date) = '{$year}' AND t.Status = '2'";
                        
                        //echo $sql;
                        //exit;
                        //echo $sql.'<br />';
                        foreach ($this->dbconnect->query($sql) as $row)
                        {


                                $In = $row['t_Debit'];
                                $Out = $row['t_Credit'];
                                $Bonus = $row['t_Bonus'];
                                $Commission = $row['t_Commission'];
                                //$i += 1;


                        }



                        $profit = $In -  $Out - $Bonus - $Commission;

                        //$Total = $In - $Out - $Bonus - $Commission;

                        //$Percentage = $profit * ($Profitsharing/100);

                        
                        //$result['Agent'] = AgentModel::getAgent($ID, "Name");                        
                        $result['In'] = Helper::displayCurrency($In);
                        $result['Out'] = Helper::displayCurrency($Out);
                        $result['Bonus'] = Helper::displayCurrency($Bonus);
                        $result['Commission'] = Helper::displayCurrency($Commission);
                        $result['Profit'] = Helper::displayCurrency($profit);
                        /*$result['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
                        $result['Percentage'] = Helper::displayCurrency($Percentage);*/

                        unset($profit);
                        unset($In);
                        unset($Out);
                        unset($Commission);
                        unset($Bonus);
                        unset($Total);
                        /*unset($Percentage);
                        unset($Profitsharing);*/


                        
                
                
                
                
                return $result;
                //exit;
               

	}


        

	public function getAgentMonthsReport($filename, $agent)
	{
		$result = array();

		$year = $_SESSION['agent_'.$filename]['Year'];
		$month = $_SESSION['agent_'.$filename]['Month'];
		/*echo $month;
		exit;*/

		/*$sql = "SELECT group_concat(`ID` separator ',') AS IDs FROM agent";

		foreach ($this->dbconnect->query($sql) as $row){

			$IDs = $row['IDs'];

		}
		//echo $IDs;
		$ID = explode(",", $IDs);
		$ID['count'] = count($ID);*/

		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {
		/*echo $agent;
		exit;*/


		$crud = new CRUD();







				if($month == 'January') {





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


            $result['0']['month'] = "January";
			$result['0']['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($month == 'February'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			    //break;

			$result['0']['month'] = 'February';
			$result['0']['year'] = $year;

				    }elseif($month == 'March'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);




			$result['0']['month'] = 'March';
			$result['0']['year'] = $year;

				    }elseif($month == 'April'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			/*Debug::displayArray($result);
			exit;*/
			//$result['0']['month'] = 'April';
			//$result['0']['year'] = $year;

					}elseif($month == 'May'){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result['0']['month'] = 'May';
				$result['0']['year'] = $year;

					}elseif($month == 'June'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				    $result['0']['month'] = 'June';
					$result['0']['year'] = $year;

					}elseif($month == 'July'){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				     $result['0']['month'] = 'July';
					 $result['0']['year'] = $year;

					}elseif($month == 'August'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result['0']['month'] = 'August';
					$result['0']['year'] = $year;

					}elseif($month == 'September'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				   $result['0']['month'] = 'September';
				   $result['0']['year'] = $year;

					}elseif($month == 'October'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				        //break;
				    $result['0']['month'] = 'October';
					$result['0']['year'] = $year;

					}elseif($month == 'November'){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result['0']['month'] = 	'November';
					$result['0']['year'] = $year;

					}elseif($month == 'December'){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result['0']['Agent'] = AgentModel::getAgent($agent);
			$result['0']['In'] = Helper::displayCurrency($In);
			$result['0']['Out'] = Helper::displayCurrency($Out);
			$result['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result['0']['Commission'] = Helper::displayCurrency($Commission);
			$result['0']['Profit'] = Helper::displayCurrency($profit);
			$result['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result['0']['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result['0']['month'] = 'December';
				$result['0']['year'] = $year;

				}



			//}


        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = count($result);
		return $result;

	}

	public function getAgentAllMonthsReport($agent)
	{
		$result = array();

		$year = $_SESSION['agent_AdminReport']['Year'];
		/*echo $year;
		exit;*/


		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


            $result[$i]['0']['month'] = "January";
			$result[$i]['0']['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			   //break;

			$result[$i]['0']['month'] = 'February';
			$result[$i]['0']['year'] = $year;

				    }elseif($i == 3){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);




			$result[$i]['0']['month'] = 'March';
			$result[$i]['0']['year'] = $year;

				    }elseif($i == 4){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			$result[$i]['0']['month'] = 'April';
			$result[$i]['0']['year'] = $year;

					}elseif($i == 5){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result[$i]['0']['month'] = 'May';
				$result[$i]['0']['year'] = $year;

					}elseif($i == 6){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				    $result[$i]['0']['month'] = 'June';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 7){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				     $result[$i]['0']['month'] = 'July';
					 $result[$i]['0']['year'] = $year;

					}elseif($i == 8){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result[$i]['0']['month'] = 'August';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 9){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				   $result[$i]['0']['month'] = 'September';
				   $result[$i]['0']['year'] = $year;

					}elseif($i == 10){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				        //break;
				    $result[$i]['0']['month'] = 'October';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 11){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result[$i]['0']['month'] = 	'November';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 12){



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result[$i]['0']['month'] = 'December';
				$result[$i]['0']['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = count($result);
		return $result;

	}
        
        public function getFrontAgentAllMonthsReport($agent)
	{
		$result = array();

		$year = $_SESSION['agent_AgentReport']['Year'];
		/*echo $year;
		exit;*/


		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


            $result[$i]['0']['month'] = "January";
			$result[$i]['0']['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			   //break;

			$result[$i]['0']['month'] = 'February';
			$result[$i]['0']['year'] = $year;

				    }elseif($i == 3){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);




			$result[$i]['0']['month'] = 'March';
			$result[$i]['0']['year'] = $year;

				    }elseif($i == 4){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			$result[$i]['0']['month'] = 'April';
			$result[$i]['0']['year'] = $year;

					}elseif($i == 5){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result[$i]['0']['month'] = 'May';
				$result[$i]['0']['year'] = $year;

					}elseif($i == 6){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				    $result[$i]['0']['month'] = 'June';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 7){




		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				     $result[$i]['0']['month'] = 'July';
					 $result[$i]['0']['year'] = $year;

					}elseif($i == 8){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result[$i]['0']['month'] = 'August';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 9){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				   $result[$i]['0']['month'] = 'September';
				   $result[$i]['0']['year'] = $year;

					}elseif($i == 10){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				        //break;
				    $result[$i]['0']['month'] = 'October';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 11){





		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



					$result[$i]['0']['month'] = 	'November';
					$result[$i]['0']['year'] = $year;

					}elseif($i == 12){



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$agent."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$agent."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i]['0']['Agent'] = AgentModel::getAgent($agent);
			$result[$i]['0']['In'] = Helper::displayCurrency($In);
			$result[$i]['0']['Out'] = Helper::displayCurrency($Out);
			$result[$i]['0']['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i]['0']['Commission'] = Helper::displayCurrency($Commission);
			$result[$i]['0']['Profit'] = Helper::displayCurrency($profit);
			$result[$i]['0']['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i]['0']['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);



				$result[$i]['0']['month'] = 'December';
				$result[$i]['0']['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['count'] = count($result);
		return $result;

	}

	public function getAgentReport($param, $filename)
	{
		$crud = new CRUD();
                
                
                //Debug::displayArray($filename);
                //exit;

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}

                if(isset($_SESSION['transaction_'.$filename]['param']['t.Status'])===true && $_SESSION['transaction_'.$filename]['param']['t.Status']!='2')
                {
                    $query_part = "";
                }
                
                if($_SESSION['transaction_'.$filename]['param']['t.Status']=='')
                {
                    $query_part = "AND t.Status = '2'";
                }
                
                
                if(isset($_SESSION['transaction_'.$filename]['param']['m.Agent'])===true && empty($_SESSION['transaction_'.$filename]['param']['m.Agent'])===false)
                {
                    $agent_query_part = "";
                }
                else
                {
                    $agent_query_part = "AND m.Agent = '".$param."'";
                }
                

                    $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$agent_query_part." ".$query_part." ".$_SESSION['transaction_'.$filename]['query_condition'];
                    //echo $sql;
                    //exit;

                    //echo $sql;
                    //exit;
		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			$Commission = $row['t_Commission'];
			$Bonus = $row['t_Bonus'];
            
		}

		$profit = $In - $Out - $Commission - $Bonus;
		$Total = $In - $Out - $Commission - $Bonus;

		$Percentage = $profit * ($Profitsharing/100);
		//double

		$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Commission'=> Helper::displayCurrency($Commission),'Bonus'=> Helper::displayCurrency($Bonus), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));

		#Debug::displayArray($result);

		unset($profit);
		unset($In);
		unset($Out);
                unset($Commission);
                unset($Bonus);
		unset($Total);
		unset($Percentage);

		return $result;
	}
        
        public function getAgentOwnReport($param, $filename)
	{
		$crud = new CRUD();
                
                
                //Debug::displayArray($filename);
                //exit;

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}

                if(isset($_SESSION['agent_'.$filename]['param']['t.Status'])===true && $_SESSION['agent_'.$filename]['param']['t.Status']!='2')
                {
                    $query_part = "";
                }
                
                if(isset($_SESSION['transaction_'.$filename]['param']['t.Status'])===false)
                {
                    $query_part = "AND t.Status = '2'";
                }
                
                
                if(isset($_SESSION['agent_'.$filename]['param']['m.Agent'])===true && empty($_SESSION['agent_'.$filename]['param']['m.Agent'])===false)
                {
                    $agent_query_part = "";
                }
                else
                {
                    $agent_query_part = "AND m.Agent = '".$param."'";
                }
                

                    $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$agent_query_part." ".$query_part." ".$_SESSION['agent_'.$filename]['query_condition'];
                    //echo $sql;
                    //exit;

                    //echo $sql;
                    //exit;
		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			$Commission = $row['t_Commission'];
			$Bonus = $row['t_Bonus'];
            
		}

		$profit = $In - $Out - $Commission - $Bonus;
		$Total = $In - $Out - $Commission - $Bonus;

		$Percentage = $profit * ($Profitsharing/100);
		//double

		$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Commission'=> Helper::displayCurrency($Commission),'Bonus'=> Helper::displayCurrency($Bonus), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));

		#Debug::displayArray($result);

		unset($profit);
		unset($In);
		unset($Out);
                unset($Commission);
                unset($Bonus);
		unset($Total);
		unset($Percentage);

		return $result;
	}
        
        
        /*public function getAgentGroupReport($param, $filename)
	{
            
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}
                
                if(isset($_SESSION['transaction_'.$filename]['param']['t.Status'])===TRUE)
                {    
                    $sql = "SELECT SUM(t.Bonus) as t_Bonus, SUM(t.Commission) as t_Commission, SUM(t.Debit) as t_Debit, SUM(t.Credit) as t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.$filename]['query_condition']." AND m.Agent = '".$param."'";
                }
                
                if(isset($_SESSION['transaction_'.$filename]['param']['t.Status'])===FALSE) 
                {
                    $sql = "SELECT SUM(t.Bonus) as t_Bonus, SUM(t.Commission) as t_Commission, SUM(t.Debit) as t_Debit, SUM(t.Credit) as t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$_SESSION['transaction_'.$filename]['query_condition']." AND m.Agent = '".$param."' AND t.Status = '2'";
                }
              
		$result = array();

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In += $row['t_Debit'];
			$Out += $row['t_Credit'];
			$Commission += $row['t_Commission'];
			$Bonus += $row['t_Bonus'];
            
		}

		$profit = $In - $Out - $Commission - $Bonus;
		$Total = $In - $Out - $Commission - $Bonus;

		$Percentage = $profit * ($Profitsharing/100);
		//double

		$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Commission'=> Helper::displayCurrency($Commission),'Bonus'=> Helper::displayCurrency($Bonus), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));

		#Debug::displayArray($result);

		unset($profit);
		unset($In);
		unset($Out);
                unset($Commission);
                unset($Bonus);
		unset($Total);
		unset($Percentage);

		return $result;
	}*/
        
        public function getAgentGroupReport($param, $filename)
	{
            
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}
    
                if(isset($_SESSION['transaction_'.$filename]['param']['t.Status'])===true && $_SESSION['transaction_'.$filename]['param']['t.Status']!='2')
                {
                    $query_part = "";
                }
                
                if($_SESSION['transaction_'.$filename]['param']['t.Status']=='')
                {
                    $query_part = "AND t.Status = '2'";
                }
                
                
                if(isset($_SESSION['transaction_'.$filename]['param']['m.Agent'])===true && empty($_SESSION['transaction_'.$filename]['param']['m.Agent'])===false)
                {
                    $agent_query_part = "";
                }
                else
                {
                    $agent_query_part = "AND m.Agent IN (".$param.")";
                }
                

                    $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID ".$agent_query_part." ".$query_part." ".$_SESSION['transaction_'.$filename]['query_condition'];
                //echo $sql;
                //exit;
              
		$result = array();
                
                $In = 0;
                $Out = 0;
                $Commission = 0;
                $Bonus = 0;

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			$Commission = $row['t_Commission'];
			$Bonus = $row['t_Bonus'];
            
		}

		$profit = $In - $Out - $Commission - $Bonus;
		//$Total = $In - $Out - $Commission - $Bonus;

		//$Percentage = $profit * ($Profitsharing/100);
		//double

		//$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Commission'=> Helper::displayCurrency($Commission),'Bonus'=> Helper::displayCurrency($Bonus), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));
                
                $result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Commission'=> Helper::displayCurrency($Commission),'Bonus'=> Helper::displayCurrency($Bonus), 'Profit' => Helper::displayCurrency($profit));

		#Debug::displayArray($result);

		/*unset($profit);
		unset($In);
		unset($Out);
                unset($Commission);
                unset($Bonus);
		unset($Total);
		unset($Percentage);*/

		return $result;
	}
        
         public function getAgentAffiliatedReporting($param, $agentProfitSharing, $filename)
	{
              $dateFrom = Helper::dateTimeDisplaySQL($_SESSION[$filename]['DateFrom']);
              $dateTo = Helper::dateTimeDisplaySQL($_SESSION[$filename]['DateTo']);
             
             
              $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $param);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($param);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($param);
                }


                $child = implode(',', $_SESSION['agentchild']);
               

                unset($_SESSION['agentchild']);
                                   
                
             
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}
                
                if(empty($_SESSION[$filename]['DateFrom'])===TRUE && empty($_SESSION[$filename]['DateTo'])===FALSE)
                {
                    $dateQuery = "AND t.Date <= '".$dateTo."'";
                }
                elseif(empty($_SESSION[$filename]['DateTo'])===TRUE && empty($_SESSION[$filename]['DateFrom'])===FALSE)
                {
                    $dateQuery = "AND t.Date >= '".$dateFrom."'";
                }
                elseif(empty($_SESSION[$filename]['DateTo'])===TRUE && empty($_SESSION[$filename]['DateFrom'])===TRUE)
                {
                    $dateQuery = "";
                }
                else
                {
                    $dateQuery = "AND t.Date >= '".$dateFrom."' AND t.Date <= '".$dateTo."'";
                }    
                

                $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent IN (".$child.") AND t.Status = '2' ".$dateQuery;
                //echo $sql;
                //exit;
                
              
		$result = array();
                
                $In = 0;
                $Out = 0;
                $Bonus = 0;
                           
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			
                        $Bonus = $row['t_Commission'] + $row['t_Bonus'];
		}
                
                
                
                $Percentage = 0;
                $winLose = 0;

		$Percentage = $In - $Out - $Bonus;
                $winLose = $In - $Out;
                
                
                
                $result['First'] = array('In'=> $In,'Out'=> $Out, 'Bonus'=> $Bonus, 'Profit' => $Percentage, 'winLose' => $winLose, 'Profitsharing' => $Profitsharing);
                
                $secProfitsharing = 0;
                $secProfit = 0;
                $secPromotion = 0;
                $secTotal = 0;
                
                $secProfitsharing = $agentProfitSharing - $Profitsharing;
                               
                $secProfit = $winLose * ($Profitsharing/100);
                $secPromotion = $Bonus * ($Profitsharing/100);
                $secTotal = $secProfit - $secPromotion;
                
                
                $result['Sec'] = array('In'=> $secProfit, 'Bonus'=> $secPromotion, 'Profit' => $secTotal, 'Profitsharing' => $secProfitsharing);
                
                $thirdProfitSharing = 0;
                $thirdProfit = 0;
                $thirdPromotion = 0;
                $thirdTotal = 0;
                
                 $thirdProfitSharing = 100 - $agentProfitSharing;
                
                
                $thirdProfit = $winLose * ($secProfitsharing/100);
                $thirdPromotion = $Bonus * ($secProfitsharing/100);
                $thirdTotal = $thirdProfit - $thirdPromotion;
                
                
                $result['Third'] = array('In'=> $thirdProfit, 'Bonus'=> $thirdPromotion, 'Profit' => $thirdTotal, 'Profitsharing' => $thirdProfitSharing);
                
                $fourProfit = 0;
                $fourTotal = 0;
                $fourPromotion = 0;
                $fourProfitSharing = 0;
                
                $fourProfitSharing = $thirdProfitSharing;
                
                $fourProfit = $winLose * ($fourProfitSharing/100);
                $fourPromotion = $Bonus * ($fourProfitSharing/100);
                $fourTotal = $fourProfit - $fourPromotion;
                
                
                $result['Fourth'] = array('In'=> $fourProfit, 'Bonus'=> $fourPromotion, 'Profit' => $fourTotal);
                
                               
                $result['Name'] = AgentModel::getAgent($param, "Name");
                $result['ID'] = $param;
		return $result;
	}
        
        public function getSelfAgentAffiliatedReporting($param, $agentProfitSharing, $filename)
	{
            
            $dateFrom = Helper::dateTimeDisplaySQL($_SESSION[$filename]['DateFrom']);
            $dateTo = Helper::dateTimeDisplaySQL($_SESSION[$filename]['DateTo']);
                                      
             
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}
                
                //echo $agentProfitSharing;
                //echo $Profitsharing;
                //exit;
                
                
                if(empty($_SESSION[$filename]['DateFrom'])===TRUE && empty($_SESSION[$filename]['DateTo'])===FALSE)
                {
                    $dateQuery = "AND t.Date <= '".$dateTo."'";
                }
                elseif(empty($_SESSION[$filename]['DateTo'])===TRUE && empty($_SESSION[$filename]['DateFrom'])===FALSE)
                {
                    $dateQuery = "AND t.Date >= '".$dateFrom."'";
                }
                elseif(empty($_SESSION[$filename]['DateTo'])===TRUE && empty($_SESSION[$filename]['DateFrom'])===TRUE)
                {
                    $dateQuery = "";
                }
                else
                {
                    $dateQuery = "AND t.Date >= '".$dateFrom."' AND t.Date <= '".$dateTo."'";
                }    
                

                $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent = '".$param."' AND t.Status = '2' ".$dateQuery;
                //echo $sql;
                //exit;
                
                $In = 0;
                $Out = 0;
                $Bonus = 0;
              
		$result = array();
                           
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			$Bonus = $row['t_Bonus'] + $row['t_Commission'];
            
		}
                
                $Percentage = 0;
                $winLose = 0;

		$Percentage = $In - $Out - $Bonus;
                $winLose = $In - $Out;
                
                
                
                $result['First'] = array('In'=> $In,'Out'=> $Out, 'Bonus'=> $Bonus, 'Profit' => $Percentage, 'winLose' => $winLose, 'Profitsharing' => $Profitsharing);
                
                $secProfitsharing = 0;
                $secProfit = 0;
                $secPromotion = 0;
                $secTotal = 0;
                
                $secProfitsharing = $agentProfitSharing - $Profitsharing;
                               
                $secProfit = $winLose * ($secProfitsharing/100);
                $secPromotion = $Bonus * ($secProfitsharing/100);
                $secTotal = $secProfit - $secPromotion;
                
                
                $result['Sec'] = array('In'=> $secProfit, 'Bonus'=> $secPromotion, 'Profit' => $secTotal, 'Profitsharing' => $secProfitsharing);
                
                $thirdProfitSharing = 0;
                $thirdProfit = 0;
                $thirdPromotion = 0;
                $thirdTotal = 0;
                
                 $thirdProfitSharing = $agentProfitSharing;
                
                
                $thirdProfit = $winLose * ($thirdProfitSharing/100);
                $thirdPromotion = $Bonus * ($thirdProfitSharing/100);
                $thirdTotal = $thirdProfit - $thirdPromotion;
                
                
                $result['Third'] = array('In'=> $thirdProfit, 'Bonus'=> $thirdPromotion, 'Profit' => $thirdTotal, 'Profitsharing' => $thirdProfitSharing);
                
                
                $fourProfitSharing = 0;
                $fourProfit = 0;
                $fourTotal = 0;
                $fourPromotion = 0;
                
                $fourProfitSharing = 100 - $thirdProfitSharing;
                
                $fourProfit = $winLose * ($fourProfitSharing/100);
                $fourPromotion = $Bonus * ($fourProfitSharing/100);
                $fourTotal = $fourProfit - $fourPromotion;
                
                
                $result['Fourth'] = array('In'=> $fourProfit, 'Bonus'=> $fourPromotion, 'Profit' => $fourTotal);
                
                               
                $result['Name'] = AgentModel::getAgent($param, "Name");
                $result['ID'] = $param;
		return $result;
	}
        
        public function getCreditSelfAgentAffiliatedReporting($param, $agentProfitSharing)
	{
                        
            
            /*$_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $param);
                
                $count = AgentModel::getAgentChildExist($param);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($param);
                }


                $child = implode(',', $_SESSION['agentchild']);
               

                unset($_SESSION['agentchild']);
                                      
             
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}
                                                  

                $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent IN (".$child.") AND t.Status = '2'";
                
                
                
                $In = 0;
                $Out = 0;
                $Bonus = 0;
              
		$result = array();
                           
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			$Bonus = $row['t_Bonus'] + $row['t_Commission'];
            
		}
                
                $Percentage = 0;
                $winLose = 0;

		$Percentage = $In - $Out - $Bonus;
                $winLose = $In - $Out;
                
                
                
                $result['First'] = array('In'=> $In,'Out'=> $Out, 'Bonus'=> $Bonus, 'Profit' => $Percentage, 'winLose' => $winLose, 'Profitsharing' => $Profitsharing);
                
                $secProfitsharing = 0;
                $secProfit = 0;
                $secPromotion = 0;
                $secTotal = 0;
                
                $secProfitsharing = $agentProfitSharing - $Profitsharing;
                               
                $secProfit = $winLose * ($secProfitsharing/100);
                $secPromotion = $Bonus * ($secProfitsharing/100);
                $secTotal = $secProfit - $secPromotion;
                
                
                $result['Sec'] = array('In'=> $secProfit, 'Bonus'=> $secPromotion, 'Profit' => $secTotal, 'Profitsharing' => $secProfitsharing);
                
                $thirdProfitSharing = 0;
                $thirdProfit = 0;
                $thirdPromotion = 0;
                $thirdTotal = 0;
                
                 $thirdProfitSharing = $agentProfitSharing;
                
                
                $thirdProfit = $winLose * ($thirdProfitSharing/100);
                $thirdPromotion = $Bonus * ($thirdProfitSharing/100);
                $thirdTotal = $thirdProfit - $thirdPromotion;
                
                
                $result['Third'] = array('In'=> $thirdProfit, 'Bonus'=> $thirdPromotion, 'Profit' => $thirdTotal, 'Profitsharing' => $thirdProfitSharing);
                
                
                $fourProfitSharing = 0;
                $fourProfit = 0;
                $fourTotal = 0;
                $fourPromotion = 0;
                
                $fourProfitSharing = 100 - $thirdProfitSharing;
                
                $fourProfit = $winLose * ($fourProfitSharing/100);
                $fourPromotion = $Bonus * ($fourProfitSharing/100);
                $fourTotal = $fourProfit - $fourPromotion;
                
                
                $result['Fourth'] = array('In'=> $fourProfit, 'Bonus'=> $fourPromotion, 'Profit' => $fourTotal);
                
                               
                $result['Name'] = AgentModel::getAgent($param, "Name");
                $result['ID'] = $param;
		return $result;*/
            
            $count = AgentModel::getAgentChildExist($param);
                $report = array();
                $result = array();
                $total = array();
                
                $profitSharing = AgentModel::getAgent($param, "Profitsharing");

                if($count>'0')
                {
                    $firstChildren = AgentModel::getAgentFirstChildren($param);

                    


                    $In = 0;
                    $Out = 0;
                    $Bonus = 0;
                    $winLose = 0;
                    $Profit = 0;

                    $SecIn = 0;
                    $SecBonus = 0;
                    $SecProfit = 0;

                    $ThirdIn = 0;
                    $ThirdBonus = 0;
                    $ThirdProfit = 0;

                    $FourthIn = 0;
                    $FourthBonus = 0;
                    $FourthProfit = 0;

                    for ($i = 0; $i < $firstChildren['count']; $i++) {


                        $result[$i] = AgentModel::getAgentAffiliatedReporting($firstChildren[$i]['ID'], $profitSharing, 'Fake');

                        $In += $result[$i]['First']['In'];
                        $Out += $result[$i]['First']['Out'];
                        $Bonus += $result[$i]['First']['Bonus'];
                        $winLose += $result[$i]['First']['winLose'];
                        $Profit += $result[$i]['First']['Profit'];

                        $SecIn += $result[$i]['Sec']['In'];
                        $SecBonus += $result[$i]['Sec']['Bonus'];
                        $SecProfit += $result[$i]['Sec']['Profit'];

                        $ThirdIn += $result[$i]['Third']['In'];
                        $ThirdBonus += $result[$i]['Third']['Bonus'];
                        $ThirdProfit += $result[$i]['Third']['Profit'];

                        $FourthIn += $result[$i]['Fourth']['In'];
                        $FourthBonus += $result[$i]['Fourth']['Bonus'];
                        $FourthProfit += $result[$i]['Fourth']['Profit'];
                         //Debug::displayArray($data[$i]);
                    }

                    $total['Total']['In'] = $In;
                    $total['Total']['Out'] = $Out;
                    $total['Total']['Bonus'] = $Bonus;
                    $total['Total']['winLose'] = $winLose;

                    $total['Total']['Profit'] = $Profit;

                    $total['Total']['SecIn'] = $SecIn;
                    $total['Total']['SecBonus'] = $SecBonus;
                    $total['Total']['SecProfit'] = $SecProfit;


                    $total['Total']['ThirdIn'] = $ThirdIn;
                    $total['Total']['ThirdBonus'] = $ThirdBonus;
                    $total['Total']['ThirdProfit'] = $ThirdProfit;
                    //$_SESSION['yourself'] = $ThirdProfit;


                    $total['Total']['FourthIn'] = $FourthIn;
                    $total['Total']['FourthBonus'] = $FourthBonus;
                    $total['Total']['FourthProfit'] = $FourthProfit;




                    $result['count'] = count($result);
                    
                    
                }
                
                $In = 0;
                $Out = 0;
                $Bonus = 0;
                $winLose = 0;
                $Profit = 0;

                $SecIn = 0;
                $SecBonus = 0;
                $SecProfit = 0;

                $ThirdIn = 0;
                $ThirdBonus = 0;
                $ThirdProfit = 0;

                $FourthIn = 0;
                $FourthBonus = 0;
                $FourthProfit = 0;
                
                
                $sql2 = "SELECT * FROM agent WHERE ID = '".$param."' AND Enabled = '1'";

                $currentAgent = array();
                foreach ($this->dbconnect->query($sql2) as $row2)
                {
                        $currentAgent[0] = array(
                        'ID' => $row2['ID'],
                        'Name' => $row2['Name'],
                        'Profitsharing' => $row2['Profitsharing']);
                }
                
                        //$currentAgent[0] = AgentModel::getAgentAffiliatedReporting($currentAgent[0]['ID'], $profitSharing);
                        
                        $currentAgent[0] = AgentModel::getSelfAgentAffiliatedReporting($currentAgent[0]['ID'], $profitSharing, 'Fake');
                        //exit;

                        $In += $currentAgent[0]['First']['In'];
                        $Out += $currentAgent[0]['First']['Out'];
                        $Bonus += $currentAgent[0]['First']['Bonus'];
                        $winLose += $currentAgent[0]['First']['winLose'];
                        $Profit += $currentAgent[0]['First']['Profit'];

                        $SecIn += $currentAgent[0]['Sec']['In'];
                        $SecBonus += $currentAgent[0]['Sec']['Bonus'];
                        $SecProfit += $currentAgent[0]['Sec']['Profit'];

                        $ThirdIn += $currentAgent[0]['Third']['In'];
                        $ThirdBonus += $currentAgent[0]['Third']['Bonus'];
                        $ThirdProfit += $currentAgent[0]['Third']['Profit'];

                        $FourthIn += $currentAgent[0]['Fourth']['In'];
                        $FourthBonus += $currentAgent[0]['Fourth']['Bonus'];
                        $FourthProfit += $currentAgent[0]['Fourth']['Profit'];
                
                
                        if(isset($total)===TRUE && empty($total)===FALSE)
                        {    
                        
                            $total['Total']['In'] += $In;
                            $total['Total']['Out'] += $Out;
                            $total['Total']['Bonus'] += $Bonus;
                            $total['Total']['winLose'] += $winLose;
                            $total['Total']['Profit'] += $Profit;

                            $total['Total']['SecIn'] += $SecIn;
                            $total['Total']['SecBonus'] += $SecBonus;
                            $total['Total']['SecProfit'] += $SecProfit;


                            $total['Total']['ThirdIn'] += $ThirdIn;
                            $total['Total']['ThirdBonus'] += $ThirdBonus;
                            $total['Total']['ThirdProfit'] += $ThirdProfit;


                            $total['Total']['FourthIn'] += $FourthIn;
                            $total['Total']['FourthBonus'] += $FourthBonus;
                            $total['Total']['FourthProfit'] += $FourthProfit;
                        
                        }
                        
                       $currentAgent['count'] = count($currentAgent);
            
                       return $total['Total']['ThirdProfit'];
            
            
	}
        
        
        
        public function getTopSelfAgentAffiliatedReporting($param, $agentProfitSharing, $filename)
	{
                                                                             
                $dateFrom = Helper::dateTimeDisplaySQL($_SESSION[$filename]['DateFrom']);
                $dateTo = Helper::dateTimeDisplaySQL($_SESSION[$filename]['DateTo']);
                
             
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$param."'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}
                
                //echo $agentProfitSharing;
                //echo $Profitsharing;
                //exit;
                
                $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $param);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($param);

                if($count>'0')
                {
                    AgentModel::getAgentAllChild($param);
                }


                $child = implode(',', $_SESSION['agentchild']);
               

                unset($_SESSION['agentchild']);
                
                
                if(empty($_SESSION[$filename]['DateFrom'])===TRUE && empty($_SESSION[$filename]['DateTo'])===FALSE)
                {
                    $dateQuery = "AND t.Date <= '".$dateTo."'";
                }
                elseif(empty($_SESSION[$filename]['DateTo'])===TRUE && empty($_SESSION[$filename]['DateFrom'])===FALSE)
                {
                    $dateQuery = "AND t.Date >= '".$dateFrom."'";
                }
                elseif(empty($_SESSION[$filename]['DateTo'])===TRUE && empty($_SESSION[$filename]['DateFrom'])===TRUE)
                {
                    $dateQuery = "";
                }
                else
                {
                    $dateQuery = "AND t.Date >= '".$dateFrom."' AND t.Date <= '".$dateTo."'";
                }    
                
                //echo $child;
                //exit;
                $sql = "SELECT SUM(t.Bonus) AS t_Bonus, SUM(t.Commission) AS t_Commission, SUM(t.Debit) AS t_Debit, SUM(t.Credit) AS t_Credit FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent IN (".$child.") AND t.Status = '2' ".$dateQuery;
                //echo $sql;
                //exit;
                
                $In = 0;
                $Out = 0;
                $Bonus = 0;
                
		$result = array();
                           
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$In = $row['t_Debit'];
			$Out = $row['t_Credit'];
			$Bonus = $row['t_Bonus'] + $row['t_Commission'];
            
		}
                
                $Percentage = 0;
                $winLose = 0;

		$Percentage = $In - $Out - $Bonus;
                $winLose = $In - $Out;
                
                
                
                $result['First'] = array('In'=> $In,'Out'=> $Out, 'Bonus'=> $Bonus, 'Profit' => $Percentage, 'winLose' => $winLose, 'Profitsharing' => $Profitsharing);
                
                $secProfitsharing = 0;
                $secProfit = 0;
                $secPromotion = 0;
                $secTotal = 0;
                
                $secProfitsharing = $agentProfitSharing;
                               
                $secProfit = $winLose * ($secProfitsharing/100);
                $secPromotion = $Bonus * ($secProfitsharing/100);
                $secTotal = $secProfit - $secPromotion;
                
                
                $result['Sec'] = array('In'=> $secProfit, 'Bonus'=> $secPromotion, 'Profit' => $secTotal, 'Profitsharing' => $secProfitsharing);
                
                $thirdProfitSharing = 0;
                $thirdProfit = 0;
                $thirdPromotion = 0;
                $thirdTotal = 0;
                
                 $thirdProfitSharing = 100 - $agentProfitSharing;
                
                
                $thirdProfit = $winLose * ($thirdProfitSharing/100);
                $thirdPromotion = $Bonus * ($thirdProfitSharing/100);
                $thirdTotal = $thirdProfit - $thirdPromotion;
                
                
                $result['Third'] = array('In'=> $thirdProfit, 'Bonus'=> $thirdPromotion, 'Profit' => $thirdTotal, 'Profitsharing' => $thirdProfitSharing);
                
                $fourProfit = 0;
                $fourTotal = 0;
                $fourPromotion = 0;
                
                $fourProfitSharing = 0;
                
                $fourProfit = $winLose * ($fourProfitSharing/100);
                $fourPromotion = $Bonus * ($fourProfitSharing/100);
                $fourTotal = $fourProfit - $fourPromotion;
                
                
                $result['Fourth'] = array('In'=> $fourProfit, 'Bonus'=> $fourPromotion, 'Profit' => $fourTotal);
                
                               
                $result['Name'] = AgentModel::getAgent($param, "Name");
                $result['ID'] = $param;
		return $result;
	}
        

	public function getAgentCreditReport($filename)
	{
                if(isset($_SESSION['agentcredit_'.$filename]['param']['Status'])===FALSE)
                {    
                    $sql = "SELECT SUM(Debit) AS Gain, SUM(Credit) AS Loss FROM agent_credit WHERE AgentID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agentcredit_'.$filename]['query_condition']." AND Status = '2'";
                    
                }
                
                if(isset($_SESSION['agentcredit_'.$filename]['param']['Status'])===TRUE)
                {    
                    $sql = "SELECT SUM(Debit) AS Gain, SUM(Credit) AS Loss FROM agent_credit WHERE AgentID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agentcredit_'.$filename]['query_condition'];
                }
		

		foreach ($this->dbconnect->query($sql) as $row)
                {
                       $In = $row['Gain'];
                       $Out = $row['Loss']; 
                       

                }

		$balance = $In - $Out;


		$report = array('TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($balance));
		
		return $report;
	}
        
        public function getGroupAgentCreditReport($filename)
	{
                
            if(empty($_SESSION['agentcredit_'.$filename]['param']['AgentID'])===TRUE)
            {    
                $sql = "SELECT SUM(Debit) AS Gain, SUM(Credit) AS Loss FROM agent_credit WHERE Status = '2' AND AgentID = '".$_SESSION['agent']['ID']."' ".$_SESSION['agentcredit_'.$filename]['query_condition']; 
            }
            
            if(empty($_SESSION['agentcredit_'.$filename]['param']['AgentID'])===FALSE)
            {    
                $sql = "SELECT SUM(Debit) AS Gain, SUM(Credit) AS Loss FROM agent_credit WHERE TRUE = TRUE ".$_SESSION['agentcredit_'.$filename]['query_condition']." AND Status = '2'"; 
            }
		

		foreach ($this->dbconnect->query($sql) as $row)
                {
                       $In = $row['Gain'];
                       $Out = $row['Loss']; 
                       

                }

		$balance = $In - $Out;


		$report = array('TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($balance));
		
		return $report;
	}

	public function getAgentAdminCreditReport()
	{
		$crud = new CRUD();

		// Initialise query conditions
		$query_condition = "";

		//if ($_POST['Trigger']=='search_form'){
			// Reset Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("TypeID",$_POST['TypeID'],"=", 1);
			$query_condition .= $crud->queryCondition("AgentID",$_POST['AgentID'],"=");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("RejectedRemark",$_POST['RejectedRemark'],"LIKE");
			$query_condition .= $crud->queryCondition("Date",Helper::dateTimeDisplaySQL($_POST['DateFrom']),">=");
			$query_condition .= $crud->queryCondition("Date",($_POST['DateTo']!="") ? Helper::dateTimeDisplaySQL($_POST['DateTo']) : Helper::dateTimeDisplaySQL($_POST['DateTo']),"<=");
			$query_condition .= $crud->queryCondition("Debit",$_POST['In'],"LIKE");
			$query_condition .= $crud->queryCondition("Credit",$_POST['Out'],"LIKE");
			//$query_condition .= $crud->queryCondition("Status",$_POST['Status'],"LIKE");

			$_SESSION['agentcredit_'.__FUNCTION__]['param']['TypeID'] = $_POST['TypeID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['AgentID'] = $_POST['AgentID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['RejectedRemark'] = $_POST['RejectedRemark'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateFrom'] = Helper::dateTimeDisplaySQL($_POST['DateFrom']);
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['DateTo'] = Helper::dateTimeDisplaySQL($_POST['DateTo']);
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Debit'] = $_POST['Debit'];
			$_SESSION['agentcredit_'.__FUNCTION__]['param']['Credit'] = $_POST['Credit'];
			//$_SESSION['agentcredit_'.__FUNCTION__]['param']['Status'] = $_POST['Status'];

			// Set Query Variable
			$_SESSION['agentcredit_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['agentcredit_'.__FUNCTION__]['query_title'] = "Search Results";

		//}
		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['agentcredit_'.__FUNCTION__]);
		}


		if ($_SESSION['agentcredit_'.__FUNCTION__]['param']['t.DateFrom']=='')
		{
		    $DateFrom = "";
		}
		else
		{
		    $DateFrom = " AND t.Date >= '".$_SESSION['agentcredit_'.__FUNCTION__]['param']['t.DateFrom']."'";
		}

        // Set Date To
		if ($_SESSION['agentcredit_'.__FUNCTION__]['param']['t.DateTo']=='')
		{
		    $DateTo = "";
		}
		else
		{
		    $DateTo = " AND t.Date <='".$_SESSION['agentcredit_'.__FUNCTION__]['param']['t.DateTo']."'";
		}

		$sql = "SELECT * FROM agent_credit WHERE Status = '2' ".$_SESSION['agentcredit_'.__FUNCTION__]['query_condition']."  Order By Date DESC";
		/*echo $sql;
		exit;
		/*foreach ($this->dbconnect->query($sql) as $row)
		{
			$Profitsharing = $row['Profitsharing'];
		}*/

        // Set Date From

		$result = array();

		$i = 0;

		foreach ($this->dbconnect->query($sql) as $row)
			{

				$transaction[$i] = array(
				'ID' => $row['ID'],
				'TypeID' => TransactionTypeModel::getTransactionType($row['TypeID']),
				'Report' => AgentModel::getAgentReport($_SESSION['agent']['ID'], $filename),
				'MemberID' => MemberModel::getMemberName($row['MemberID']),
				'Description' => $row['Description'],
				'RejectedRemark' => $row['RejectedRemark'],
				'Date' => Helper::dateTimeSQLToDisplay($row['Date']),
				'TransferTo' => $row['TransferTo'],
				'TransferFrom' => $row['TransferFrom'],
				'DepositBonus' => $row['DepositBonus'],
				'DepositChannel' => $row['DepositChannel'],
				'ReferenceCode' => $row['ReferenceCode'],
	            'Bank' => $row['Bank'],
				'In' => $row['Debit'],
				'Out' => $row['Credit'],
				'Amount' => $row['Amount'],
				'Status' => TransactionStatusModel::getTransactionStatus($row['Status']));

				$In += $transaction[$i]['In'];
			    $Out += $transaction[$i]['Out'];

				$i += 1;

			}

		$balance = $In - $Out;


		$report =array('TotalIn' => Helper::displayCurrency($In), 'TotalOut' => Helper::displayCurrency($Out), 'Balance' => Helper::displayCurrency($balance));

		#Debug::displayArray($result);

		/*unset($profit);
		unset($In);
		unset($Out);
        unset($Commission);
        unset($Bonus);
		unset($Total);
		unset($Percentage);*/

		return $report;
	}

	public function getAgentMemberReport($param)
	{
		$crud = new CRUD();

		$sql = "SELECT Profitsharing FROM agent WHERE ID = '".$_SESSION['agent']['ID']."'";
		foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$Profitsharing = $row['Profitsharing'];
				//$i += 1;


			}

		if ($_POST['DateFrom']=='') {
		    $DateFrom = "";
		} else {
		    $DateFrom = " AND t.Date BETWEEN '".$_POST['DateFrom']."'";
		}

		if ($_POST['DateTo']=='') {
		    $DateTo = "";
		} else {
		    $DateTo = " AND '".$_POST['DateTo']."'";
		}

			$sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE t.MemberID = '".$param."' AND t.Status = '2'".$DateFrom.$DateTo;
			//echo $sql;
			//exit;
			$result = array();
			//$transaction['count'] = $result['count'];
			//$i = 0;



			foreach ($this->dbconnect->query($sql) as $row)
			{

				//$result[$i] = array('In' => Helper::displayCurrency($row['t_Debit']),'Out' => Helper::displayCurrency($row['t_Credit']));
				$In += $row['t_Debit'];
				$Out += $row['t_Credit'];
				$Bonus += $row['t_Bonus'];
				$Commission += $row['t_Commission'];
				//$i += 1;


			}


			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			/*if($In != 0){

			$Total = $Total/$In;

			$Percentage = $Total * 100;

			}*/
			$Percentage = $profit * ($Profitsharing/100);

			$result = array('In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' =>Helper::displayCurrency($Percentage));



		unset($profit);
		unset($In);
		unset($Out);
		unset($Total);
		unset($Percentage);

		return $result;
	}


	public function getAgentName($param)
	{
		$crud = new CRUD();

		$sql = "SELECT Name FROM agent WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'Name' => $row['Name']);

			$i += 1;
		}
		$result = $result[0]['Name'];
		return $result;
	}

        public function getAgentProduct($param)
	{		
		$sql = "SELECT Product FROM agent WHERE ID = '".$param."' AND Enabled = '1'";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['Product'];

		}
		
		return $result;
	}
        
        public function getAgentBulkProducts($param)
	{		
		$sql = "SELECT Product FROM agent WHERE ID = '".$param."' AND Enabled = '1'";
		
                
		foreach ($this->dbconnect->query($sql) as $row)
		{
                            
			$result = $row['Product'];
                        

		}
		
		return $result;
	}
        
        public function getAgentProducts($param)
	{		
		$sql = "SELECT Product FROM agent WHERE ID = '".$param."' AND Enabled = '1'";
                //echo $sql;
                //exit;
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['Product'];

		}
                
                
                if($result != 'Null')
                {    
                    $result = explode(',', $result);
                    $result['count'] = count($result);
                }
                else
                {
                    $result = 'Null'; 
                }
		
                //Debug::displayArray($result);
                //exit;
                
		return $result;
	}
        
        public function getAgentProductDetails($param)
	{		
		$sql = "SELECT Product FROM agent WHERE ID = '".$param."' AND Enabled = '1'";
                //echo $sql;
                //exit;
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['Product'];

		}
                
                
                if($result != 'Null')
                {    
                    $sql = "SELECT * FROM product WHERE ID IN (".$result.")";
                    
                    $result = array();

                    $i = 0;

                    foreach ($this->dbconnect->query($sql) as $row)
                    {

                            $result[$i] = array(
                            'ID' => $row['ID'],
                            'Name' => $row['Name']);

                            $i += 1;

                    }
                    
                    $result['count'] = $i;
                    
                }
                else
                {
                    $result = 'Null'; 
                }
		
                //Debug::displayArray($result);
                //exit;
                
		return $result;
	}
        
	public function getAgentList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'ParentID' => $row['ParentID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
        
        public function getAgentUniqueCode($code, $agent)
	{

		$sql = "SELECT COUNT(*) AS codeCount FROM agent WHERE UniqueCode = '".$code."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['codeCount'];
		}
                
                AgentModel::updateAgentUniqueCode($result);
                
                    

	}
        
        public function updateAgentUniqueCode($count)
	{

		if($count>='1'){
                    
                    $sql2 = "SELECT UNIX_TIMESTAMP(NOW()) AS currentTimeStamp";
                    
                    foreach ($this->dbconnect->query($sql2) as $row2)
                    {
                            $currentTimestamp = $row2['currentTimeStamp'];
                    }
                    
                    $uniqueTimestamp = substr($currentTimestamp, -4); 
                    $rand = rand(10, 99);
                    $uniqueTimestamp .= $rand;
                                                          
                    $sql3 = "UPDATE agent SET UniqueCode='".$uniqueTimestamp."' WHERE ID='".$agent."'";
			
                        $count = $this->dbconnect->exec($sql3);
                        return TRUE;
                    
                }
                else
                {
                        return TRUE;           
                }    

	}
        
        public function getNotAgentList($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent WHERE ID != '".$param."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'ParentID' => $row['ParentID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
        
        public function getAgentHierarchyList()
	{
		$crud = new CRUD();
                
                
                $tier = 1;
                              

		$sql = "SELECT * FROM agent WHERE Enabled = '1' ORDER BY ID ASC";
                
		$result = array();
                $i = 0;
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
                        
                    
			
                        $count = AgentModel::getAgentChildExist($row['ID']);
                        if($count>'0')
                        {

                            $result[$i] = array(
                            'ID' => $row['ID'],                                
                            'Name' => $row['Name']);
                            AgentModel::getAgentChildHierarchy($row['ID'], $tier);
                             
                        }
                        
                        $count2 = AgentModel::getAgentParentChildExist($row['ID']);   
                        if($count2===2){
                        $result[$i] = array(
                                            'ID' => $row['ID'],                                               
                                            'Name' => $row['Name']);
                            
                        
                            
                        }
                                
                    $i+=1;
		}


		;
	}
        
        public function getAgentChild($param, $tier)
	{
                $padding = $tier * 35;
                
                $tier+=1;
                
		$sql = "SELECT * FROM agent WHERE Enabled = 1 AND ParentID = '".$param."'";
                
		$result = array();
		$i = 0;
                $count = AgentModel::getAgentChildExist($param);
                if($count>'0'){
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $result[$i] = array(
                                                'ID' => $row['ID'],    
                                                'Child'=> AgentModel::getAgentChild($row['ID'], $tier),
                                                'Name' => $row['Name'],
                                                'Username' => $row['Username'],    
                                                'Company' => $row['Company'],
                                                'Padding' => $padding);

                            $i += 1;
                    }
                } 
                    
                $result['count'] = count($result);
                    

		return $result;
	}
        
        public function getAgentChildHierarchy($param, $tier)
	{
        
        
            $padding = $tier * 10;
                
            $tier+=1;

            $sql = "SELECT * FROM agent WHERE Enabled = 1 AND ParentID = '".$param."'";

            $result = array();
            $i = 0;
            
           
            $count = AgentModel::getAgentChildExist($param); 
            if($count>'0')
            {
                //if($this->dbconnect->query($sql)->rowCount()!==0){
                foreach ($this->dbconnect->query($sql) as $row)
                {
                     
                        
                    
                            $result[$i] = array(
                                                'ID' => $row['ID'],    
                                                'Child'=> AgentModel::getAgentChildHierarchy($row['ID'], $tier),
                                                'Name' => $row['Name'],
                                                'Company' => $row['Company'],
                                                'Padding' => $padding);






                            
                        
                        $i += 1;
                }
                    
            
            
            $result['count'] = $i;
            }
            else
            {
                $result['count'] = 0;
            }    
            
            


            return $result;
                
	}
        
        public function getTopAgentChild($param, $tier)
	{
                $padding = $tier * 10;
                
                $tier+=1;
                
		$sql = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$param."'";
                
		$result = array();
		$i = 0;
                //if($this->dbconnect->query($sql)->rowCount()!==0){
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $result[$i] = array(
                                                'ID' => $row['ID'],    
                                                'Child'=> AgentModel::getAgentChild($row['ID'], $tier),
                                                'Name' => $row['Name'],
                                                'Company' => $row['Company'],
                                                'Padding' => $padding);

                            $i += 1;
                    }
                    
                    $result['count'] = $i;
                /*}
                else
                {
                       $result = 0;
                }*/    

		return $result;
	}
                
        public function getAgentChildExist($param)
	{               
		$sql = "SELECT COUNT(*) AS agentChild FROM agent WHERE Enabled = 1 AND ParentID = '".$param."'";
                
                foreach ($this->dbconnect->query($sql) as $row)
                {
                        $result = $row['agentChild'];

                }                   

		return $result;
	}
        
        public function getAgentFirstChildren($param)
	{               
		$crud = new CRUD();

		$result = array();
                $i = 0; 
                
                $sql = "SELECT * FROM agent WHERE ParentID = '".$param."' AND Enabled = '1' ORDER BY Name ASC";
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
                        'Profitsharing' => $row['Profitsharing']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
        
        public function getAgentFirstChildrenDetails($param)
	{               
		$crud = new CRUD();
                                          

		$sql = "SELECT * FROM agent WHERE ParentID = '".$param."' ORDER BY Name ASC";

                $result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Name' => $row['Name'],
                        'Username' => $row['Username'],    
                        'Profitsharing' => $row['Profitsharing'],
                        'Registered' => $row['Registered'],   
                        'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
        
        public function getAgentParentChildExist()
	{ 
            $result = array();

            

                //No Parent
		$sql = "SELECT ID FROM agent WHERE Enabled = 1 AND ParentID = '0'";
                
                foreach ($this->dbconnect->query($sql) as $row)
                {
                        $count = AgentModel::getAgentChildExist($row['ID']);
                        
                        if($count=='0')
                        {
                           array_push($result, $row['ID']);
                            
                        }    
                        

                        
                }
                
                
                //Debug::displayArray($result);
                //exit;

		return $result;
	}
        
        public function getAgentParentdExist($ID)
	{ 
            
               
		$sql = "SELECT COUNT(*) AS parentCount FROM agent WHERE Enabled = 1 AND ParentID != '0' AND ID = '".$ID."'";
                //echo $sql;
                //exit;
                foreach ($this->dbconnect->query($sql) as $row)
                {
                            
                        $parentCount = $row['parentCount'];
                        
                }
               

		return $parentCount;
	}
        
        public function getAdminAgentAllParentChild()
	{
                $data = AgentModel::getAgentParentChildExist();
            
                 $comma_separated = implode(", ", $data);
                 
                 $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID NOT IN (".$comma_separated.") AND ParentID = '0'";

                        $result2 = array();
                        $g = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$g] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $g += 1;
                        }
                        
                 $sql3 = "SELECT * FROM agent WHERE Enabled = 1 AND ID IN (".$comma_separated.")";

                        $result3 = array();
                        $z = 0;

                        foreach ($this->dbconnect->query($sql3) as $row3)
                        {
                                $result3[$z] = array(
                                        'ID' => $row3['ID'],
                                        'Name' => $row3['Name'],
                                        'Company' => $row3['Company']);

                                $z += 1;
                        }       


                        $result2['count'] = $g;
                        $result3['count'] = $z;
                        
                        $data = array("result2" => $result2, "result3" => $result3);
                        
                        return $data;
        }  
        
        public function getUsernameAdminAgentAllParentChild()
	{
                $data = AgentModel::getAgentParentChildExist();
            
                 $comma_separated = implode(", ", $data);
                 
                 $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID NOT IN (".$comma_separated.") AND ParentID = '0'";

                        $result2 = array();
                        $g = 0;
                        $tier = 1;
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$g] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Username' => $row2['Username'],
                                        'Company' => $row2['Company']);

                                $g += 1;
                        }
                        
                 $sql3 = "SELECT * FROM agent WHERE Enabled = 1 AND ID IN (".$comma_separated.")";

                        $result3 = array();
                        $z = 0;

                        foreach ($this->dbconnect->query($sql3) as $row3)
                        {
                                $result3[$z] = array(
                                        'ID' => $row3['ID'],
                                        'Name' => $row3['Name'],
                                        'Username' => $row3['Username'],
                                        'Company' => $row3['Company']);

                                $z += 1;
                        }       


                        $result2['count'] = $g;
                        $result3['count'] = $z;
                        
                        $data = array("result2" => $result2, "result3" => $result3);
                        
                        return $data;
        } 
        
        public function getAgentAllChild($param)
	{
            
		$sql = "SELECT * FROM agent WHERE Enabled = 1 AND ParentID = '".$param."'";
                
 
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    array_push($_SESSION['agentchild'], $row['ID']);
                    
                    $count = AgentModel::getAgentChildExist($row['ID']);
                    if($count>'0')
                    {
                        AgentModel::getAgentAllChild($row['ID']);
                    }    

                        
                }
 
	}
        
        public function getloopAgentParent($parent)
	{
                                          
		$sql = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$parent."'";
                                
                foreach ($this->dbconnect->query($sql) as $row)
                {
                    
                       if($row['TypeID']=='2')
                       {
                           //echo 'hi';
                           AgentModel::getloopAgentParent($row['ParentID']);
                       }
                       elseif($row['TypeID']=='1')
                       {    
                       
                           $_SESSION['platform_agent'] = $row['ID'];
                       }    
                           
                           
                        
                }
                    
                                  
                    
	}
        
        public function getDownlineAgentChild($param, $tier = 0)
	{
                               
                $tier+=1;
                
		$sql = "SELECT * FROM agent WHERE Enabled = 1 AND ParentID = '".$param."'";

		$result = array();
		$i = 0;
                //if($this->dbconnect->query($sql)->rowCount()!==0){
                    foreach ($this->dbconnect->query($sql) as $row)
                    {
                            $result[$i] = array(
                                                'ID' => $row['ID'],    
                                                'Child'=> AgentModel::getDownlineAgentChild($row['ID'], $tier),
                                                'Name' => $row['Name'],
                                                'Company' => $row['Company'],
                                                'Tier' => $tier);

                            $i += 1;
                    }
                    
                    $result['count'] = $i;
                /*}
                else
                {
                       $result = 0;
                }*/    

		return $result;
	}
        
         
                                          
        public function getAgentListByParent($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM agent WHERE ParentID = '".$param."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'ParentID' => $row['ParentID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			#'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}
        
        public function getFormattedAgentListByParent($param)
	{
                      
		$crud = new CRUD();

		$sql = "SELECT * FROM agent WHERE ParentID = '".$param."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
                        'Company' => $row['Company'],
                        'Child' => AgentModel::getAgentChild($row['ID'], $tier),
			'Name' => $row['Name'],
			'Description' => $row['Description']);
			
			$i+=1;
		}
                $result['count'] = $i;
                
                 

		return $result;
	}

    public function getAgentListArray()
    {
        $crud = new CRUD();

        $sql = "SELECT * FROM agent";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = $row['ID'];

            $i += 1;
        }

        return $result;
    }

	public function getAgentMemberList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member WHERE Agent = '".$_SESSION['agent']['ID']."' ORDER BY Name ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'Agent' => $row['Agent'],
			'GenderID' => CRUD::getGender($row['GenderID']),
			'Name' => $row['Name'],
			'Company' => $row['Company'],
			'Bank' => $row['Bank'],
			'BankAccountNo' => $row['BankAccountNo'],
			'SecondaryBank' => $row['SecondaryBank'],
			'SecondaryBankAccountNo' => $row['SecondaryBankAccountNo'],
			'DOB' => Helper::dateSQLToDisplay($row['DOB']),
			'NRIC' => $row['NRIC'],
			'Passport' => $row['Passport'],
			'Nationality' => CountryModel::getCountry($row['Nationality']),
			'Username' => $row['Username'],
			'Password' => $row['Password'],
			'PhoneNo' => $row['PhoneNo'],
			'FaxNo' => $row['FaxNo'],
			'MobileNo' => $row['MobileNo'],
			'Email' => $row['Email'],
			'Prompt' => $row['Prompt'],
			'Enabled' => CRUD::isActive($row['Enabled']));

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function getAgentCount(){
		$sql = "SELECT COUNT(ID) FROM agent";
		$result = $this->dbconnect->query($sql);
		$result = $result->fetchColumn();
		return $result;
	}
        
        public function getTest($item2, $key){
            array_push($_SESSION['pad'], $item2[1]);
            
            
            
	}

        public function CheckChildExist($array)
	{  
            $space = '';
            for ($index1 = 0; $index1 < $array[$index]['Padding']; $index1++) {
                $space.='&nbsp;';
            }   
                //Debug::displayArray($array['count']);
                //exit;
                if(is_array($array)===TRUE)
                {   
                  //foreach($array[0]['Child'] as $key) {
                      
                      for ($index = 0; $index < $array['count']; $index++) {
                          echo $space.'-'.$array[$index]['Name'];
                          //Debug::displayArray();
                          //exit;
                          CheckChildExist($array[$index]['Child']);
                      }
                     
                  //} 
                }
           
        
           
        }

	public function AdminReportExport($param)
	{
		//$sql = "SELECT * FROM agent ORDER BY Name ASC";

		//$month = date('m', strtotime($_SESSION['agent_'.__FUNCTION__]['Month']));
		//$month = date_parse($month);
	    //Debug::displayArray($_SESSION['agent_AdminReport']['Month']);
	    //Debug::displayArray($_SESSION['agent_AdminReport']['Year']);
		//exit;


		$sql_agents = "SELECT * FROM agent ORDER BY Name ASC";
		$agents = array();
		$j = 0;

		foreach ($this->dbconnect->query($sql_agents) as $row)
		{
			$agents[$j] = array('ID' => $row['ID']);

			$j += 1;
		}

		$agents['count'] = $j;


		$result = array();
		$Report  = array();

		$result['content'] = '';
		$result['filename'] = $this->config['SITE_NAME']."_Agents";



		$result['header'] .= $this->config['SITE_NAME']." | Agents (" . date('Y-m-d H:i:s') . ")\n\n";
		$result['header'] .= "\"Search filter\",";
		$result['header'] .= "\"Month\":,";
		$result['header'] .= "\"".$_SESSION['agent_AdminReport']['Month']."\",";
		$result['header'] .= "\"Year\":,";
		$result['header'] .= "\"".$_SESSION['agent_AdminReport']['Year']."\"";

		//echo $agents['count'];

		$result['content'].="\nAgent, In (MYR), Out (MYR), Bonus (MYR), Commission (MYR), Profit (MYR), Profit Sharing (%), Profit Sharing(MYR)\n\n";
		//$transaction = array();
		for ($z=0; $z <$agents['count'] ; $z++) {

			//$sql = "SELECT t.ID AS t_ID, t.TypeID AS t_TypeID, t.MemberID AS t_MemberID, t.Description AS t_Description, t.Date AS t_Date, t.TransferTo AS t_TransferTo, t.TransferFrom AS t_TransferFrom, t.DepositBonus as t_DepositBonus, t.DepositChannel as t_DepositChannel, t.ReferenceCode as t_ReferenceCode, t.Bank as t_Bank, t.Debit as t_Debit, t.Credit as t_Credit, t.Amount as t_Amount, t.Status as t_Status FROM transaction AS t, member AS m WHERE t.MemberID = m.ID AND m.Agent = '".$agents[$z]['ID']."' AND t.Date >= '{$_POST['Year']}/{$month}/01' and Date <= '{$_POST['Year']}/{$month}/31' AND t.Status = '2'";
			//echo $sql.'<br />';

			//$transaction['count'] = $result['count'];
			//$i = 0;

			//foreach ($this->dbconnect->query($sql) as $row)
			//{


				$Report = AgentModel::getAgentAdminReport($agents[$z]['ID'],$param);


				//$i += 1;


				/*$i = 0;
				/*foreach ($this->dbconnect->query($sql) as $row)
				{*/
					//$result['content'] .= "\"".$row['ID']."\",";
					$result['content'] .= "\"".$Report['Agent'][0]['Name']."\",";
					$result['content'] .= "\"".$Report['In']."\",";
					$result['content'] .= "\"".$Report['Out']."\",";
					$result['content'] .= "\"".$Report['Bonus']."\",";
					$result['content'] .= "\"".$Report['Commission']."\",";
					/*$result['content'] .= "\"".$row['Company']."\",";
					$result['content'] .= "\"".$row['Bank']."\",";
					$result['content'] .= "\"".$row['BankAccountNo']."\",";
					$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DOB'])."\",";
					$result['content'] .= "\"".$row['NRIC']."\",";
					$result['content'] .= "\"".$row['Passport']."\",";
					$result['content'] .= "\"".CountryModel::getCountry($row['Nationality'])."\",";
					$result['content'] .= "\"".$row['Username']."\",";
					$result['content'] .= "\"".$row['Password']."\",";
					$result['content'] .= "\"".$row['PhoneNo']."\",";
					$result['content'] .= "\"".$row['FaxNo']."\",";
					$result['content'] .= "\"".$row['MobileNo']."\",";
					$result['content'] .= "\"".$row['Email']."\",";
					$result['content'] .= "\"".$row['Prompt']."\",";*/
					$result['content'] .= "\"".$Report['Profit']."\",";
					$result['content'] .= "\"".$Report['Profitsharing']."\",";
					$result['content'] .= "\"".$Report['Percentage']."\"\n";

					//$i += 1;
				//}


			//}





		}
		//$transaction['count'] = $z;

		//Helper::exportCSV($result['header'], $result['content'], $result['filename']);

		//Debug::displayArray($result['content']);
		//exit;


		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}
        
        
        public function AdminManage($param) 
    {       
        // Initialise query conditions
        $query_condition = "";
        
        $crud = new CRUD();
        
        if ($_POST['Trigger']=='search_form')
        {
                // Reset Query Variable
                $_SESSION['agent_'.__FUNCTION__] = "";

                $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=");
                $query_condition .= $crud->queryCondition("Product",$_POST['Product'],"LIKE");
                $query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                $query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

                $_SESSION['agent_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
                $_SESSION['agent_'.__FUNCTION__]['param']['Product'] = $_POST['Product'];
                $_SESSION['agent_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                $_SESSION['agent_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

                // Set Query Variable
                $_SESSION['agent_'.__FUNCTION__]['query_condition'] = $query_condition;
                $_SESSION['agent_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['agent_'.__FUNCTION__]);           
        }

        // Determine Title
        if (isset($_SESSION['agent_'.__FUNCTION__]))
        {
            $query_title = "Search Results";
            $search = "on";
        }
        else
        {
            $query_title = "All Results";
            $search = "off";
        }

        // Prepare Pagination
        #$query_count = "SELECT COUNT(*) AS num FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition'];
        
        $query_count = "SELECT COUNT(*) AS num FROM agent ".$_SESSION['agent_'.__FUNCTION__]['query_condition'];
        
        /*echo $query_count;
        exit();*/
        
        #echo $query_count;
        $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
        
        $targetpage = $data['config']['SITE_DIR'].'/admin/agent/manage';
        $limit = 10;
        $stages = 3;
        $page = mysql_escape_string($_GET['page']);
        if ($page) {
            $start = ($page - 1) * $limit; 
        } else {
            $start = 0; 
        }   
        
        // Initialize Pagination
        $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
        
        #$sql = "SELECT * FROM permission ".$_SESSION['permission_'.__FUNCTION__]['query_condition']." ORDER BY ProfileID ASC LIMIT $start, $limit";
        
        $sql = "SELECT * FROM agent ".$_SESSION['agent_'.__FUNCTION__]['query_condition']." ORDER BY Name ASC LIMIT $start, $limit";
        //echo $sql;
        //exit;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Product' => ProductModel::getAgentProductList($row['Product']),
            'Enabled' => CRUD::isActive($row['Enabled']));
            
            $i += 1;
        }
        
        $result2 = AgentModel::getAdminAgentAllParentChild();
        
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "Bulk Update", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/manage.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.permission_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
        'content' => $result,
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList(), 'test1' => $result2['result2'], 'test2' => $result2['result3']),
        'secure' => TRUE,
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }
    
    public function AgentManage($param) 
    {       
        // Initialise query conditions
        $query_condition = "";
        
        $crud = new CRUD();
        
        if ($_POST['Trigger']=='search_form')
        {
                // Reset Query Variable
                $_SESSION['agent_'.__FUNCTION__] = "";

                $query_condition .= $crud->queryCondition("ID",$_POST['Agent'],"=", 1);
                $query_condition .= $crud->queryCondition("Product",$_POST['Product'],"LIKE");
                $query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
                $query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");

                $_SESSION['agent_'.__FUNCTION__]['param']['Agent'] = $_POST['Agent'];
                $_SESSION['agent_'.__FUNCTION__]['param']['Product'] = $_POST['Product'];
                $_SESSION['agent_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
                $_SESSION['agent_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];

                // Set Query Variable
                $_SESSION['agent_'.__FUNCTION__]['query_condition'] = $query_condition;
                $_SESSION['agent_'.__FUNCTION__]['query_title'] = "Search Results";
        }

        // Reset query conditions
        if ($_GET['page']=="all")
        {
            $_GET['page'] = "";
            unset($_SESSION['agent_'.__FUNCTION__]);           
        }

        // Determine Title
        if (isset($_SESSION['agent_'.__FUNCTION__]))
        {
            $query_title = "Search Results";
            $search = "on";
        }
        else
        {
            $query_title = "All Results";
            $search = "off";
        }

        $_SESSION['agentchild'] = array();
                array_push($_SESSION['agentchild'], $_SESSION['agent']['ID']);
                //Debug::displayArray($_SESSION['agentchild']);
                //exit;
                $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                
                if($count>'0')
                {
                    AgentModel::getAgentAllChild($_SESSION['agent']['ID']);
                }
                
                
                $child = implode(',', $_SESSION['agentchild']);
                
                unset($_SESSION['agentchild']);
                
                if(isset($_SESSION['agent_'.__FUNCTION__]['param']['Agent'])===true && empty($_SESSION['agent_'.__FUNCTION__]['param']['Agent'])===false)
                {
                    $query_part = "";
                }
                else
                {
                    $query_part = "AND ID IN (".$child.")";
                }
                
                               
                
                    
                    // Prepare Pagination
                    $query_count = "SELECT COUNT(*) AS num FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agent_'.__FUNCTION__]['query_condition'];
                    //echo $query_count;
                    //exit;
                    $total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 

                    $targetpage = $data['config']['SITE_DIR'].'/agent/agent/manage';
                    $limit = 10;
                    $stages = 3;
                    $page = mysql_escape_string($_GET['page']);
                    if ($page) {
                            $start = ($page - 1) * $limit; 
                    } else {
                            $start = 0;	
                    }	

                    // Initialize Pagination
                    $paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

                    $sql = "SELECT * FROM agent WHERE TRUE = TRUE ".$query_part." ".$_SESSION['agent_'.__FUNCTION__]['query_condition']." ORDER BY Name DESC LIMIT $start, $limit";
        //echo $sql;
        //exit;
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Name' => $row['Name'],
            'Product' => ProductModel::getAgentProductList($row['Product']),
            'Enabled' => CRUD::isActive($row['Enabled']));
            
            $i += 1;
        }
        
         $sql2 = "SELECT * FROM agent WHERE Enabled = 1 AND ID = '".$_SESSION['agent']['ID']."'";

                        $result2 = array();
                        $z = 0;
                        $tier = 1;
                        $count = AgentModel::getAgentChildExist($_SESSION['agent']['ID']);
                        if($count>'0')
                        {   
                        foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Child'=> AgentModel::getAgentChild($row2['ID'], $tier),
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        }
                        }
                        else
                        {
                           foreach ($this->dbconnect->query($sql2) as $row2)
                        {
                                $result2[$z] = array(
                                        'ID' => $row2['ID'],
                                        'Name' => $row2['Name'],
                                        'Company' => $row2['Company']);

                                $z += 1;
                        } 
                        }    

                        $result2['count'] = $z;
        
        $this->output = array( 
        'config' => $this->config,
        'page' => array('title' => "Bulk Update", 'template' => 'agent.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/agent/manage.inc.php'),
        'block' => array('side_nav' => $this->module_dir.'inc/agent/side_nav.permission_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_editindex_url,"",$this->config,"Manage"),
        'content' => $result,
        'agent' => $result2,     
        'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList(), 'agent_list' => AgentModel::getAgentList()),
        'secure' => TRUE,
        'meta' => array('active' => "on"));
                    
        return $this->output;
    }
    
    public function AdminBulkUpdate() 
    {
        
         //Debug::displayArray($_POST);
         //exit;
        
         if(empty($_POST['Agent'])===FALSE)
         {
             
            //Check agent exist    

            foreach ($_POST['Agent'] as $resellerID) {
                //Get each agent ID   

                if(empty($_POST['Product'][$resellerID])===FALSE)
                {
                    //Check if Product empty    

                    foreach ($_POST['Product'] as $Agent => $Product) {

                    //Separate and get each part of product                           

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $productCount = count($_POST['Product'][$Agent]);




                            for ($i=0; $i<$productCount; $i++) {

                                    $concat.=$_POST['Product'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$productCount){



                                     }
                                     else 
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $prod = array();

                            for ($i=0; $i<$productCount; $i++) {
                                array_push($prod, $_POST['Product'][$Agent][$i]);
                            }



                            // Get Agent product created before this process
                            $ProductList = AgentModel::getAgentProduct($Agent);

                            $ProductList = explode(',', $ProductList);

                            $ProductList['count'] = count($ProductList);
                            
                            
                            //Reason to use array_diff and array_intersect are to prevent wallet duplications
                            
                            //Get products similarity between selected and created
                            
                            $intersect = array_intersect($prod, $ProductList);

                            $intersect = array_values($intersect);
                            
                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM wallet WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else 
                            {    
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM wallet WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$productCount; $i++) {

                                        for ($z=0; $z <$member['count']; $z++)
                                        {
                                            $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                            $value = "('0', '".$_POST['Product'][$Agent][$i]."', '".$Agent."', '".$member[$z]['ID']."', '1')";

                                            $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;

                                            $this->dbconnect->exec($sql2);
                                        }
                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $productdeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM wallet WHERE AgentID = '".$Agent."' AND ProductID NOT IN (".$productdeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newProductList = AgentModel::getAgentBulkProducts($Agent);

                                    $newProductList = explode(',', $newProductList);


                                    // Get selected products not included in created products     
                                    $newProd = array_diff($prod, $newProductList);

                                    if(empty($newProd)===TRUE)
                                    {
                                        

                                    }
                                    else
                                    {
                                        $newProd = array_values($newProd);
                                        $newProd['count'] = count($newProd);

                                        for ($i=0; $i<$newProd['count']; $i++) {

                                            for ($z=0; $z <$member['count']; $z++)
                                            {
                                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                                $value = "('0', '".$newProd[$i]."', '".$Agent."', '".$member[$z]['ID']."', '1')";

                                                $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;


                                                $this->dbconnect->exec($sql2);
                                            }
                                        }

                                    }    

                                }
                            }
                   

                            $sql6 = "UPDATE agent SET Product='".$concat."' WHERE ID='".$Agent."'";			
                            $this->dbconnect->exec($sql6);




                      } 
                    }       
                }
                else 
                {
                    //echo 'hi<br>';
                    
                    
                    $sql = "UPDATE agent SET Product='Null' WHERE ID='".$resellerID."'";			
                    $this->dbconnect->exec($sql);
                    //echo $sql.'<br>';
                    
                    $sql2 = "DELETE FROM wallet WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }  
        }

    }
    
    public function AgentBulkUpdate() 
    {
        
         if(empty($_POST['Agent'])===FALSE)
         {
             
            //Check agent exist    

            foreach ($_POST['Agent'] as $resellerID) {
                //Get each agent ID   

                if(empty($_POST['Product'][$resellerID])===FALSE)
                {
                    //Check if Product empty    

                    foreach ($_POST['Product'] as $Agent => $Product) {

                    //Separate and get each part of product                           

                        if (in_array($Agent, $_POST['Agent'])) {

                            //concatenate products

                            $concat = '';

                            $productCount = count($_POST['Product'][$Agent]);




                            for ($i=0; $i<$productCount; $i++) {

                                    $concat.=$_POST['Product'][$Agent][$i];
                                    $z = $i + 1;
                                    if($z===$productCount){



                                     }
                                     else 
                                     {
                                         $concat.=',';
                                     }



                             }



                            //Get all agent members
                            $member = MemberModel::getMemberAgent($Agent);

                            //Generate selected product array
                            $prod = array();

                            for ($i=0; $i<$productCount; $i++) {
                                array_push($prod, $_POST['Product'][$Agent][$i]);
                            }



                            // Get Agent product created before this process
                            $ProductList = AgentModel::getAgentProduct($Agent);

                            $ProductList = explode(',', $ProductList);

                            $ProductList['count'] = count($ProductList);
                            
                            
                            //Reason to use array_diff and array_intersect are to prevent wallet duplications
                            
                            //Get products similarity between selected and created
                            
                            $intersect = array_intersect($prod, $ProductList);

                            $intersect = array_values($intersect);
                            
                            //concatenate selected products
                            if(empty($concat)===TRUE)
                            {

                                $sql = "DELETE FROM wallet WHERE AgentID = '".$Agent."'";

                                $count = $this->dbconnect->exec($sql);
                            }
                            else 
                            {    
                                //If no similarity between selected and created products
                                if(empty($intersect)===TRUE){

                                    $sql = "DELETE FROM wallet WHERE AgentID = '".$Agent."'";

                                    $count = $this->dbconnect->exec($sql);



                                    for ($i=0; $i<$productCount; $i++) {

                                        for ($z=0; $z <$member['count']; $z++)
                                        {
                                            $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                            $value = "('0', '".$_POST['Product'][$Agent][$i]."', '".$Agent."', '".$member[$z]['ID']."', '1')";

                                            $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;

                                            $this->dbconnect->exec($sql2);
                                        }
                                    }


                                }elseif(empty($intersect)===FALSE){

                                    $productdeleted = implode(',', $intersect);


                                    $sql = "DELETE FROM wallet WHERE AgentID = '".$Agent."' AND ProductID NOT IN (".$productdeleted.")";

                                    $count = $this->dbconnect->exec($sql);

                                    $newProductList = AgentModel::getAgentBulkProducts($Agent);

                                    $newProductList = explode(',', $newProductList);


                                    // Get selected products not included in created products     
                                    $newProd = array_diff($prod, $newProductList);

                                    if(empty($newProd)===TRUE)
                                    {
                                        

                                    }
                                    else
                                    {
                                        $newProd = array_values($newProd);
                                        $newProd['count'] = count($newProd);

                                        for ($i=0; $i<$newProd['count']; $i++) {

                                            for ($z=0; $z <$member['count']; $z++)
                                            {
                                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                                $value = "('0', '".$newProd[$i]."', '".$Agent."', '".$member[$z]['ID']."', '1')";

                                                $sql2 = "INSERT INTO wallet ".$key." VALUES ". $value;


                                                $this->dbconnect->exec($sql2);
                                            }
                                        }

                                    }    

                                }
                            }
                   

                            $sql6 = "UPDATE agent SET Product='".$concat."' WHERE ID='".$Agent."'";			
                            $this->dbconnect->exec($sql6);




                      } 
                    }       
                }
                else 
                {
                    //echo 'hi<br>';
                    
                    
                    $sql = "UPDATE agent SET Product='Null' WHERE ID='".$resellerID."'";			
                    $this->dbconnect->exec($sql);
                    //echo $sql.'<br>';
                    
                    $sql2 = "DELETE FROM wallet WHERE AgentID = '".$resellerID."'";
                    //echo $sql2.'<br>';
                    //exit;
                    $count = $this->dbconnect->exec($sql2);
                }
            }  
        }

    }

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM agent ".$_SESSION['agent_'.$param]['query_condition']." ORDER BY Name ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Agents";
		$result['header'] = $this->config['SITE_NAME']." | Agents (" . date('Y-m-d H:i:s') . ")\n\nID, Credit, Gender, Name, Company, Bank, Bank Account No, DOB, NRIC, Passport, Nationality, Username, Phone No, Fax No, Mobile No, Email, Prompt, Enabled";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
            $result['content'] .= "\"".$row['Credit']."\",";
			$result['content'] .= "\"".CRUD::getGender($row['GenderID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['Company']."\",";
			$result['content'] .= "\"".$row['Bank']."\",";
			$result['content'] .= "\"".$row['BankAccountNo']."\",";
			$result['content'] .= "\"".Helper::dateSQLToDisplay($row['DOB'])."\",";
			$result['content'] .= "\"".$row['NRIC']."\",";
			$result['content'] .= "\"".$row['Passport']."\",";
			$result['content'] .= "\"".CountryModel::getCountry($row['Nationality'])."\",";
			$result['content'] .= "\"".$row['Username']."\",";
			$result['content'] .= "\"".$row['PhoneNo']."\",";
			$result['content'] .= "\"".$row['FaxNo']."\",";
			$result['content'] .= "\"".$row['MobileNo']."\",";
			$result['content'] .= "\"".$row['Email']."\",";
			$result['content'] .= "\"".$row['Prompt']."\",";
			$result['content'] .= "\"".$row['Enabled']."\"\n";

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}

    public function getHash($param)
    {
        $sql = "SELECT Password FROM agent WHERE ID = '".$param."'";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Password' => $row['Password']);

            $i += 1;
        }

        return $result[0]['Password'];
    }


    public function verifyCookie($cookie_data)
    {
        $cookie_data = json_decode($cookie_data['Value'],true);

        $sql = "SELECT * FROM agent WHERE Username = '".$cookie_data['Username']."' AND CookieHash = '".$cookie_data['Hash']."' AND Enabled = 1";

        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Username' => $row['Username'],
            'Email' => $row['Email'],
            'Name' => $row['Name']);

            $i += 1;
        }

        $result['count'] = $i;

        $this->output = array(
        'verify' => $result);

        return $this->output;
    }

}
?>