<?php
// Require required classes
error_reporting(0);
require_once('lib/phpmailer/class.phpmailer.php');

date_default_timezone_set('Asia/Kuala_Lumpur');
abstract class BaseModel

{

	protected $dbconnect;

    /*protected $hostname = 'localhost';
    protected $database = 'yessys33_coredb';
    protected $username = 'yessys33_coredb';
	protected $password = ',rS~ZfMr}To3';*/

    protected $hostname = DB_HOSTNAME;
    protected $database = DB_NAME;
    protected $username = DB_USER;
    protected $password = DB_PASSWORD;

	protected $config;

    protected $cookiekey = 'dMNj6CRNqEbzgqNc7a9uBTwq';



	public function __construct()
	{



		try

		{

			$this->dbconnect = new PDO("mysql:host=".$this->hostname.";dbname=".$this->database, $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

			#echo 'Connected to database<br />';

			/*$link = mysqli_connect("bacca001.mysql.guardedhost.com", "bacca001_coredb", "bacca.1235*", "bacca001_casino9club");*/

		    /*if(!empty($_POST)||!empty($_GET))
			{
			 Helper::filterData($_POST, $link);
			 Helper::filterData($_GET, $link);
			}*/

			// Set the error reporting attribute

			$this->dbconnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



			// Load configuration settings

			$sql = "SELECT * FROM config";



			// Save Configuration Settings into Session

			$this->config = array();

			foreach ($this->dbconnect->query($sql) as $row)

			{

				$this->config[$row['ConfigName']] = $row['ConfigValue'];

			}



			if ($this->config['DISPLAY_ERROR']==1)

			{

				#error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

			}

			else

			{

				#error_reporting(~E_ALL);

			}

            #error_reporting(~E_ALL);

			$this->config['TITLE'] = "";

			if ($this->config["SITE_NAME"]!="") {

				$this->config['TITLE'] .= " - ".$this->config['SITE_NAME'];

			}



			if ($this->config["SITE_SLOGAN"]!="") {

				$this->config['TITLE'] .= " - ".$this->config['SITE_SLOGAN'];

			}



			if (trim($this->config['SITE_DIR'])!="")

			{

				$this->config['SITE_DIR'] = "/".$this->config['SITE_DIR'];

			}



			$this->config['THEME_DIR_INC'] = "themes/".$this->config['THEME']."/";

			$this->config['THEME_DIR'] = $this->config['SITE_DIR']."/themes/".$this->config['THEME']."/";

		}

		catch(PDOException $e)

		{

			echo $e->getMessage();

		}



                    if(isset($_GET['language']) && $_GET['language']!='')
                    {
                        if($_GET['language'] == 'en' || $_GET['language'] == 'zh_CN' || $_GET['language'] == 'ms')
                        {
                            $_SESSION['language'] = "{$_GET['language']}";
                        }
                    }

                    if(isset($_GET['language'])===FALSE || $_GET['language'] == '')
                    {

                        if(isset($_SESSION['language']) && $_SESSION['language']!='')
                        {
                            //$_SESSION['language'] = "{$_GET['language']}";
                        }
                        else
                        {
                            $_SESSION['language'] = 'en';
                        }


                    }

                //echo $_SESSION['language'];
                //exit;

               $linkPiece = get_defined_constants(true);
               $registerloginlinkpiece = $linkPiece['user']['LOAD_SECTION'].'/'.$linkPiece['user']['LOAD_CONTROLLER'].'/'.$linkPiece['user']['LOAD_ACTION'];




                if(isset($_SESSION['member']['ID'])===TRUE && empty($_SESSION['member']['ID'])===FALSE) {
                    if(isset($_GET['rid'])===TRUE && empty($_GET['rid'])===FALSE) {
                    $rawResellerCode = urlencode(base64_encode($_SESSION['reseller_code']));
                        if($rawResellerCode != urlencode($_GET['rid'])) {
                            if($registerloginlinkpiece == 'member/member/register' || $registerloginlinkpiece == 'member/member/login')
                            {



                                    $oneAgent = new Helper();

                                    $_SESSION['oneAgentLink'] = $linkPiece['user']['LOAD_SECTION'].'/'.$linkPiece['user']['LOAD_CONTROLLER'].'/'.$linkPiece['user']['LOAD_ACTION'];
                                    $_SESSION['oneAgentLinkRid'] = $_GET['rid'];
                                    $oneAgent->redirect($this->config['SITE_DIR']."/member/member/oneagentlogout");


                            }
                        }
                    }

               }




	}

}



class Error

{

	public function showError($message)

	{

		// Include config functions

		require_once('modules/config/config.model.php');



		$config = new ConfigModel();

		$debug_on = $config->getConfigValue('DEBUG_MODE');



		if ($debug_on==1)

		{

			echo 'Error Message: '.$message;

			require('modules/debug/check.php');

		}

		else

		{

			Helper::redirect('/page-not-found');

		}



		exit();

	}

}



class Core

{

    // Load Controller

	public function getController($section='main', $controller='', $action='index' , $id = '', $execute=false)

	{

		$param['section'] = $section;

		$param['controller'] = $controller;

		$param['action'] = $action;

		$param['id'] = $id;



		$loader = new Loader($param);

		$controller = $loader->CreateController();



		if ($execute)

		{

			return $controller->ExecuteAction();

		}

		else

		{

			return $controller;

		}

	}



    // Require Controller Once

    public function requireController($module_name)

    {

        require_once('modules/'.$module_name.'/'.$module_name.'.controller.php');

    }



    // Require Model Once

    public function requireModel($module_name)

    {


        require_once('modules/'.$module_name.'/'.$module_name.'.model.php');

    }



    // Load Hook

    public function getHook($area)

    {

        Core::getController('core','hook','index',$area,true);

    }

}



class Debug

{

	public function displayArray($array)

	{

		echo '<pre>';

		print_r($array);

		echo '</pre>';



		return false;

	}

}



class Helper

{

	/*** Date Functions ***/

	// Display Friendly Date (dd-mm-yyyy)

	public function dateSQLToDisplay($param)

	{

		if ($param=="0000-00-00")

		{

			$result = "00-00-0000";

		}

		else

		{

			$result = date("d-m-Y", strtotime($param));

		}



		return $result;

	}

        public function agentOptionList($array, $sectionName)
	{

		if(is_array($array)===TRUE)
                {


                    for ($index = 0; $index < $array['count']; $index++) {

                           if ($array[$index]['ID']==$sectionName) {
                              $selected= 'selected="selected"';

                           }

                          $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Name'].' - '. $array[$index]['ID'].' | '.$array[$index]['Company'].'</option>';

                          echo $data;

                          unset($selected);
                          Helper::agentOptionList($array[$index]['Child'], $sectionName);
                    }


                }

	}

        public function agentUsernameOptionList($array, $sectionName)
	{

		if(is_array($array)===TRUE)
                {


                    for ($index = 0; $index < $array['count']; $index++) {

                           if ($array[$index]['ID']==$sectionName) {
                              $selected= 'selected="selected"';

                           }

                          $data= '<option style="padding-left:'.$array[$index]['Padding'].'px;" value="'. $array[$index]['ID'].'" '.$selected.'>'.$array[$index]['Username'].' - '. $array[$index]['ID'].'</option>';

                          echo $data;

                          unset($selected);
                          Helper::agentUsernameOptionList($array[$index]['Child'], $sectionName);
                    }


                }

	}


	/*public function filterData($data, $link)
   {
	   if (is_array($data)) {

			foreach ($data as $elem) {
				Helper::filterData($elem, $link);
			}

		} else {

			$data = trim(htmlentities($data));
			if (get_magic_quotes_gpc())
			{
			     stripslashes($data);
			}
//
			 mysqli_escape_string($data, $link);
//
		 }
//
//
     }*/



    // Display Friendly DateTime (dd-mm-yyyy HH:ii:ss)

    public function dateTimeSQLToDisplay($param)

    {

        if ($param=="0000-00-00 00:00:00")

        {

            $result = "00-00-0000 00:00:00";

        }

        else

        {

            $result = date("d-m-Y H:i:s", strtotime($param));

        }



        return $result;

    }



	// Display Friendly Date (Long) (Mmm d, YYYY)

	public function dateSQLToLongDisplay($param)

	{

		if ($param=="0000-00-00")

		{

			$result = "-";

		}

		else

		{

			$result = date("F j, Y", strtotime($param));

		}



		return $result;

	}



    // Display Friendly DateTime (Long) (Mmm d, YYYY at hh:ia)

    public function dateTimeSQLToLongDisplay($param)

    {

        if ($param=="0000-00-00 00:00:00")

        {

            $result = "-";

        }

        else

        {

            $result = date('F j, Y \a\t h:ia', strtotime($param));

        }



        return $result;

    }



	// Convert to SQL Date (yyyy-mm-dd)

	public function dateDisplaySQL($param)

	{

		if ($param!="")

		{

			$param = explode("-", $param);

			$result = $param[2]."-".$param[1]."-".$param[0];

		}

		else

		{

			$result = "";

		}



		return $result;

	}



    // Convert to SQL Date (yyyy-mm-dd hh:ii:ss)

    public function dateTimeDisplaySQL($param)

    {

        if ($param!="")

        {

            $param = explode(" ", $param);



            $date = $param[0];

            $time = $param[1];



            $date = explode("-", $date);

            $date = $date[2]."-".$date[1]."-".$date[0];



            $result = $date." ".$time;

        }

        else

        {

            $result = "";

        }



        return $result;

    }



	// Display Currency

	public function displayCurrency($param)

	{

		$result = number_format($param,2,".",",");



		return $result;

	}



	// Handles Redirects

	public function redirect($target)

	{

		header("Location: ".$target);

		exit();

	}



    // Handles 404 Redirects

    public function redirect404()

    {

        Helper::redirect($param['config']['SITE_DIR']."/page-not-found");

        exit();

    }



	// Strip String

	public function stripNLTags($string)

	{

		$string = str_replace("\r\n","",strip_tags($string));

		$result = $string;



		return $result;

	}



    // Reverse Escaped Characters

    public function unescape($param, $array = TRUE)

    {

        if (get_magic_quotes_gpc())

        {

            if ($array==TRUE)

            {

                foreach ($param as $key=>$value)

                {

                    $param[$key] = stripslashes($value);

                }



                $result = $param;

            }

            else

            {

                $result = stripslashes($param);

            }

        }

        else
        {
            $result = $param;
        }



        return $result;

    }



	// Export Array to CSV

	public function exportCSV($header = NULL, $content = NULL, $filename = NULL)

	{

		// Next we'll check to see if our $header variable exist and if it does we'll simply append them to output.

		if (isset($header))

		{

			$output .= $header;

			$output .= "\n";

		}



		if (isset($content)) {

		$output .= $content;

		}



        // Replace blank spaces with dashes

        $filename = str_replace(" ","-",$filename);



		// Now we're ready to create a file. This method generates a filename based on the current date & time.

		$filename = $filename."_".date("Y-m-d_H-i-s");



		// Generate the CSV file header

		header("Content-type: application/vnd.ms-excel");

		header("Content-disposition: csv" . date("Y-m-d") . ".csv");

		header("Content-disposition: filename=".$filename.".csv");



		// Print the contents of out to the generated file.

		print $output;



		// Exit the script

		return false;

	}



    // Truncates Strings

    public function truncate($string,$length)

    {

        if (strlen($string)>$length)

        {

            $result = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length-2));

            $result .= "...";

        }

        else

        {

            $result = $string;

        }



        return $result;

    }

    public function sendUserData()
    {

            $restapi = new RestAPI();

            $get = urlencode(json_encode($_GET));

            $getData = '&GETData='.$get;


            $post = urlencode(json_encode($_POST));

            $postData = '&POSTData='.$post;

            $url = urlencode($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
            $url = 'Site='.$url;


            list($section, $controller, $action, $id) = explode('&', $_SERVER['QUERY_STRING']);
            $section = explode('=', $section);
            $accessType = '&AccessType='.$section[1];


            $code = '&SiteCode='.AUDIT_SITE;

            $IPAddress = '&IPAddress='.urlencode($_SERVER['REMOTE_ADDR']);
            $data_string = $url.$postData.$getData.$code.$IPAddress.$accessType;
            //echo "http://www.security.allsys33.com/api/auditlog/createprocess?".$data_string;
            //exit;


            $restapi->makeRequest("http://security.allsys33.com/api/auditlog/createprocess", $data_string, "GET");

            /*echo '<pre>';
            print_r($result);
            echo '</pre>';
            exit;*/

    }


    public function requestAdminActivity($Username, $TAC)
        {

            $restapi = new RestAPI();


            $url = 'Site='.urlencode(AUDIT_SITE);
            $Username = '&Username='.urlencode($Username);
            $TAC = '&TAC='.urlencode($TAC);

            $data_string = $url.$Username.$TAC;
            //echo "http://www.security.allsys33.com/api/auditlog/createprocess?".$data_string;
            //exit;

            //echo $data_string;
            $message = $restapi->makeRequest("http://security.allsys33.com/api/siteuser/useractivity", $data_string, "GET");

            $message = json_decode($message);

            //print_r($message);
            //exit;
            return $message->Content;


        }

    public function updateAdminActivity($Username)
        {

            $restapi = new RestAPI();


            $url = 'Site='.urlencode(AUDIT_SITE);
            $username = '&Username='.urlencode($Username);

            $data_string = $url.$username;
            //echo "http://www.security.allsys33.com/api/auditlog/createprocess?".$data_string;
            //exit;


            $message = $restapi->makeRequest("http://security.allsys33.com/api/siteuser/useractivityupdate", $data_string, "GET");

            $message = json_decode($message);


            return $message->Content;


        }

    public function addDNSRecords($domain, $IP, $host, $parent)
    {



            //$domain = 'demo.suminamo.com';
            //$domain = 'dummy.com';


            /*$host = explode(".", $domain);

            $host['count'] = count($host);

            if($host['count']=='3')
            {
                $domain = $host[1].'.'.$host[2];
                $subdomain = $host[0];
            }

            if($host['count']=='2')
            {
                $domain = $host[0].'.'.$host[1];
                $subdomain = 'www';
            }*/


            //echo $subdomain;

            if($host=='')
            {
                $host = 'www';
            }

            $restapi = new RestAPI();

            $subAuthID = 42;
            $password = '12341234';

            $dnsStatus = Helper::addDNSZonesRecords($subAuthID, $password, $domain, $host, $IP, $parent);

            //Debug::displayArray($dnsStatus);
            //exit;

            if($dnsStatus['status']=='Failed' && $dnsStatus['statusDescription'] == 'Missing domain-name')
            {

                Helper::addDnsDomain($subAuthID, $password, $domain, "master");
                Helper::addDnsDelegate($subAuthID, $password, $domain);
                $statusMessage = Helper::addDNSZonesRecords($subAuthID, $password, $domain, $host, $IP, $parent);
                Helper::addDefaultDNSZonesRecords($subAuthID, $password, $domain, $host, $IP);

            }

            if(empty($statusMessage)===false){
                $dnsMessage = $statusMessage;
            }
            else
            {
                $dnsMessage = $dnsStatus;
            }

            return $dnsMessage;

            //exit('exit over here');
    }

    public function addDefaultDNSZonesRecords($subAuthID, $password, $domain, $host, $IP)
    {


            $restapi = new RestAPI();

            $record_type = 'A'; // A, AAAA, MX, CNAME, TXT, NS, SRV, WR, RP, SSHFP, ALIAS for domain names and NS and PTR for reversed zones.
            //$host = 'shamo';
            $record = $IP;
            $ttl = '60';


            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            $data_string .= '&record-type='.$record_type;
            $data_string .= '&host=';
            $data_string .= '&record='.$record;
            $data_string .= '&ttl='.$ttl;

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/add-record.json", $data_string, "GET");

            $dnsStatus = json_decode($param, TRUE);



            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            $data_string .= '&record-type='.$record_type;
            $data_string .= '&host=mail';
            $data_string .= '&record='.$record;
            $data_string .= '&ttl='.$ttl;

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/add-record.json", $data_string, "GET");

            $dnsStatus = json_decode($param, TRUE);


            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            $data_string .= '&record-type='.$record_type;
            $data_string .= '&host=*';
            $data_string .= '&record='.$record;
            $data_string .= '&ttl='.$ttl;

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/add-record.json", $data_string, "GET");

            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            $data_string .= '&record-type=MX';
            $data_string .= '&host=';
            $data_string .= '&priority=10';
            $data_string .= '&record=mail.'.$domain;
            $data_string .= '&ttl='.$ttl;

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/add-record.json", $data_string, "GET");

            $dnsStatus = json_decode($param, TRUE);

            return $dnsStatus;
    }

    public function addDNSZonesRecords($subAuthID, $password, $domain, $host, $IP, $parent)
    {


            $restapi = new RestAPI();

            $record_type = 'A'; // A, AAAA, MX, CNAME, TXT, NS, SRV, WR, RP, SSHFP, ALIAS for domain names and NS and PTR for reversed zones.
            //$host = 'shamo';
            $record = $IP;
            $ttl = '60';

            if($parent=='0')
            {
                $data_string = '';
                $data_string .= 'sub-auth-id='.$subAuthID;
                $data_string .= '&auth-password='.$password;
                $data_string .= '&domain-name='.$domain;
                $data_string .= '&record-type='.$record_type;
                $data_string .= '&host=www';
                $data_string .= '&record='.$record;
                $data_string .= '&ttl='.$ttl;

                $param = $restapi->makeRequest("https://api.cloudns.net/dns/add-record.json", $data_string, "GET");
            }
            else
            {

            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            $data_string .= '&record-type='.$record_type;
            $data_string .= '&host='.$host;
            $data_string .= '&record='.$record;
            $data_string .= '&ttl='.$ttl;

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/add-record.json", $data_string, "GET");
            }



            $dnsStatus = json_decode($param, TRUE);

            return $dnsStatus;
    }

    public function modifyDNSZonesRecords($domain, $host, $recordID, $IP)
    {


            $restapi = new RestAPI();

            /*$host = explode(".", $domain);

            $host['count'] = count($host);

            if($host['count']=='3')
            {
                $domain = $host[1].'.'.$host[2];
                $subdomain = $host[0];
            }

            if($host['count']=='2')
            {
                $domain = $host[0].'.'.$host[1];
                $subdomain = 'www';
            }*/

            $subAuthID = 42;
            $password = '12341234';

            $record_type = 'A'; // A, AAAA, MX, CNAME, TXT, NS, SRV, WR, RP, SSHFP, ALIAS for domain names and NS and PTR for reversed zones.
            //$host = 'shamo';
            $record = $IP;
            $ttl = '60';


            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&record-id='.$recordID;
            $data_string .= '&domain-name='.$domain;
            //$data_string .= '&record-type='.$record_type;
            $data_string .= '&host='.$host;
            $data_string .= '&record='.$record;
            $data_string .= '&ttl='.$ttl;
            //echo $data_string;
            //exit;
            $param = $restapi->makeRequest("https://api.cloudns.net/dns/mod-record.json", $data_string, "GET");

            $dnsStatus = json_decode($param, TRUE);



            return $dnsStatus;
    }


    public function deleteDNSZonesRecords($domain, $host, $recordID)
    {


            $restapi = new RestAPI();





            $subAuthID = 42;
            $password = '12341234';

            if($host!='')
            {

                $data_string = '';
                $data_string .= 'sub-auth-id='.$subAuthID;
                $data_string .= '&auth-password='.$password;
                $data_string .= '&record-id='.$recordID;
                $data_string .= '&domain-name='.$domain;


                $param = $restapi->makeRequest("https://api.cloudns.net/dns/delete-record.json", $data_string, "GET");

            }
            elseif($host=='')
            {

                $data_string = '';
                $data_string .= 'sub-auth-id='.$subAuthID;
                $data_string .= '&auth-password='.$password;
                $data_string .= '&domain-name='.$domain;


                $param = $restapi->makeRequest("https://api.cloudns.net/dns/delete.json", $data_string, "GET");


            }

            $dnsStatus = json_decode($param, TRUE);


            return $dnsStatus;
    }


    public function addDnsDomain($subAuthID, $password, $domainName, $zoneType)
    {

            $restapi = new RestAPI();


            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domainName;
            $data_string .= '&zone-type='.$zoneType;
            $data_string .= '&ns[]=ns21.cloudns.net&ns[]=ns22.cloudns.net&ns[]=ns23.cloudns.net&ns[]=ns24.cloudns.net&ns[]=pns21.cloudns.net&ns[]=pns22.cloudns.net&ns[]=pns23.cloudns.net&ns[]=pns25.cloudns.net&ns[]=pns26.cloudns.net&ns[]=pns27.cloudns.net&ns[]=pns28.cloudns.net&ns[]=pns29.cloudns.net&ns[]=pns30.cloudns.net';

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/register.json", $data_string, "GET");


            return $param;

    }

    public function updateListRecord($domain, $host, $IP, $newHost)
    {
             //echo 'hi';
             //exit;
            $restapi = new RestAPI();

            $subAuthID = 42;
            $password = '12341234';

            /*$host = explode(".", $domain);

            $host['count'] = count($host);

            if($host['count']=='3')
            {
                $domain = $host[1].'.'.$host[2];
                $subdomain = $host[0];
            }

            if($host['count']=='2')
            {
                $domain = $host[0].'.'.$host[1];
                $subdomain = 'www';
            }*/

            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            //$data_string .= '&zone-type='.$zoneType;
            //$data_string .= '&ns[]=';

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/records.json", $data_string, "GET");

            $records = json_decode($param, TRUE);

            foreach ($records as $record) {

                //if($subdomain!='www'){
                    if($record['host']==$host)
                    {
                        //echo 'hi';
                        $dnsStatusMessage = Helper::modifyDNSZonesRecords($domain, $newHost, $record['id'], $IP);
                    }
                    else
                    {
                        $dnsStatusMessage = 'No DNS record found';
                    }
                //}

            }

            /*echo '<pre>';
            print_r($records);



            echo '</pre>';
            exit;*/
            return $dnsStatusMessage;

    }

    public function deleteListRecord($domain, $host)
    {
             //echo 'hi';
             //exit;
            $restapi = new RestAPI();

            //$domainName = $domain;

            $subAuthID = 42;
            $password = '12341234';

            /*$host = explode(".", $domain);


            $host['count'] = count($host);

            if($host['count']=='3')
            {
                $domain = $host[1].'.'.$host[2];
                $subdomain = $host[0];
            }

            if($host['count']=='2')
            {
                $domain = $host[0].'.'.$host[1];
                $subdomain = 'www';
            }*/

            /*if($host!='')
            {
                echo 'Host is not empty';
            }

            if($host=='')
            {
                echo 'Host is empty';
            }
            exit;*/

            $data_string = '';
            $data_string .= 'sub-auth-id='.$subAuthID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&domain-name='.$domain;
            //$data_string .= '&zone-type='.$zoneType;
            //$data_string .= '&ns[]=';

            $param = $restapi->makeRequest("https://api.cloudns.net/dns/records.json", $data_string, "GET");

            $records = json_decode($param, TRUE);

            foreach ($records as $record) {
                if($host!='')
                {
                    if($record['host']==$host)
                    {
                        Helper::deleteDNSZonesRecords($domain, $host, $record['id']);
                    }

                }

                if($host=='')
                {

                        Helper::deleteDNSZonesRecords($domain, $host, $record['id']);


                }

            }

            /*echo '<pre>';
            print_r($records);



            echo '</pre>';
            exit;*/
            //return $param;

    }

    public function addDnsDelegate($subAuthID, $password, $domainName)
    {

            $restapi = new RestAPI();

            $ID = 740;

            $data_string = '';
            $data_string .= 'auth-id='.$ID;
            $data_string .= '&auth-password='.$password;
            $data_string .= '&id='.$subAuthID;
            $data_string .= '&zone='.$domainName;

            $param = $restapi->makeRequest("https://api.cloudns.net/sub-users/delegate-zone.json", $data_string, "GET");


    }

    public function sendAdminTac($Username, $TAC)
    {

            $restapi = new RestAPI();


            $url = 'Site='.urlencode(AUDIT_SITE);
            $Username = '&Username='.urlencode($Username);
            $TAC = '&TAC='.urlencode($TAC);

            $data_string = $url.$Username.$TAC;
            //echo "http://www.security.allsys33.com/api/auditlog/createprocess?".$data_string;
            //exit;


            $message = $restapi->makeRequest("http://security.allsys33.com/api/siteuser/verification", $data_string, "GET");

            $message = json_decode($message);

            return $message->Content;
            /*echo '<pre>';
            print_r($result);
            echo '</pre>';
            exit;*/

    }

    public function sendAgentTac($Username, $TAC, $agentURL)
    {

            $restapi = new RestAPI();


            $url = 'Site='.urlencode($agentURL);
            $Username = '&Username='.urlencode($Username);
            $TAC = '&TAC='.urlencode($TAC);

            $data_string = $url.$Username.$TAC;
            //echo "http://www.security.allsys33.com/api/auditlog/createprocess?".$data_string;
            //exit;


            $message = $restapi->makeRequest("http://security.allsys33.com/api/siteuser/verification", $data_string, "GET");

            $message = json_decode($message);

            return $message->Content;
            /*echo '<pre>';
            print_r($result);
            echo '</pre>';
            exit;*/

    }

    public function addHTTP($url)
    {
        $http_exists = substr_count($url,'http://', 0, 7);

        if ($http_exists!='1')
        {
            $url = 'http://'.$url;
        }

        return $url;
    }


    public function translate($original_text, $section)
    {

        $dbconnect;
        /*$hostname = 'localhost';
        $database = 'yessys33_coredb';
        $username = 'yessys33_coredb';
	$password = ',rS~ZfMr}To3';*/

        $hostname = DB_HOSTNAME;
        $database = DB_NAME;
        $username = DB_USER;
        $password = DB_PASSWORD;


        $dbconnect = new PDO("mysql:host=".$hostname.";dbname=".$database, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        $crud = new CRUD();

        #$sql = "SELECT * FROM translation WHERE OriginalText = '".$original_text."' AND Section = '".$section."' AND LanguageCode = '".$_SESSION['Language']."'";
        $sql = "SELECT * FROM translation WHERE OriginalText = '".$original_text."' AND Section = '".$section."' AND LanguageCode = '".$_SESSION['language']."'";
        /*echo $sql;
        exit;*/
        $result = array();
        $i = 0;
        foreach ($dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'LanguageCode' => $row['LanguageCode'],
            'Section' => $row['Section'],
            'OriginalText' => $row['OriginalText'],
            'TranslatedText' => $row['TranslatedText']);

            $i += 1;
        }

        if ($i==0)
        {
            $result = $original_text;
        }
        else
        {
            $result = $result[0]['TranslatedText'];
        }

        return $result;
    }

}



class Secure

{

	/*** HTTPS and Security Functions ***/

	// Redirects page to https and vice versa (TRUE - Secure Page, FALSE - Insecure Page)

	public function HTTPSRedirect($ssl_on,$secure)

	{

		if ($ssl_on=="1")

		{

			if ($secure==NULL)

            {

                // Inherits secure/non-secure status

            }

            else if ($secure==FALSE)

			{

				if($_SERVER['HTTPS']==TRUE)

				{

					$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

					Helper::redirect($redirect);

				}

			}

			else if ($secure==TRUE)

			{

				if($_SERVER['HTTPS']==FALSE)

				{

					$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

					Helper::redirect($redirect);

				}

			}

		}

		else

		{

			if($_SERVER['HTTPS']==TRUE)

			{

				$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

				Helper::redirect($redirect);

			}

		}

	}



    // Encrypt Function

    public function mcEncrypt($encrypt, $key, $array = false)

    {

        if ($array==true)

        {

            $encrypt = serialize($encrypt);

        }



        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM);

        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt, MCRYPT_MODE_CBC, $iv);

        $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);



        return $encoded;

    }



    // Decrypt Function

    public function mcDecrypt($decrypt, $key, $array = false)

    {

        $decrypt = explode('|', $decrypt);

        $decoded = base64_decode($decrypt[0]);

        $iv = base64_decode($decrypt[1]);

        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));



        if ($array==true)

        {

            $decrypted = unserialize($decrypted);

        }



        return $decrypted;

    }

}



class Bcrypt

{

    /*** Crypt with Blowfish ***/

    /*

     * Example:

     * $bcrypt = new Bcrypt(9); // Use 9 as default rounds of iteration

     * $hash = $bcrypt->hash('password');

     * $isGood = $bcrypt->verify('password', $hash);

     */



    private $rounds;

    public function __construct($rounds = 12)

    {

        if(CRYPT_BLOWFISH != 1)

        {

            throw new Exception("bcrypt not supported in this installation. See http://php.net/crypt");

        }



        $this->rounds = $rounds;

    }



    public function hash($input)

    {

        $hash = crypt($input, $this->getSalt());



        if(strlen($hash) > 13)

        {

            return $hash;

        }



        return false;

    }



    public function verify($input, $existingHash)

    {

        $hash = crypt($input, $existingHash);



        return $hash === $existingHash;

    }



    private function getSalt()

    {

        $salt = sprintf('$2a$%02d$', $this->rounds);



        $bytes = $this->getRandomBytes(16);



        $salt .= $this->encodeBytes($bytes);



        return $salt;

    }



    private $randomState;

    private function getRandomBytes($count)

    {

        $bytes = '';



        if (function_exists('openssl_random_pseudo_bytes')&&(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN'))

        { // OpenSSL slow on Win

            $bytes = openssl_random_pseudo_bytes($count);

        }



        if ($bytes === '' && is_readable('/dev/urandom') && ($hRand = @fopen('/dev/urandom', 'rb')) !== FALSE)

        {

            $bytes = fread($hRand, $count);

            fclose($hRand);

        }



        if (strlen($bytes) < $count)

        {

            $bytes = '';



            if ($this->randomState === null)

            {

                $this->randomState = microtime();

                if (function_exists('getmypid'))

                {

                    $this->randomState .= getmypid();

                }

            }



            for($i = 0; $i < $count; $i += 16)

            {

                $this->randomState = md5(microtime() . $this->randomState);



                if (PHP_VERSION >= '5')

                {

                    $bytes .= md5($this->randomState, true);

                }

                else

                {

                    $bytes .= pack('H*', md5($this->randomState));

                }

            }



            $bytes = substr($bytes, 0, $count);

        }



        return $bytes;

    }



    private function encodeBytes($input)

    {

        // The following is code from the PHP Password Hashing Framework

        $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';



        $output = '';

        $i = 0;

        do

        {

            $c1 = ord($input[$i++]);

            $output .= $itoa64[$c1 >> 2];

            $c1 = ($c1 & 0x03) << 4;

            if ($i >= 16)

            {

                $output .= $itoa64[$c1];

                break;

            }



            $c2 = ord($input[$i++]);

            $c1 |= $c2 >> 4;

            $output .= $itoa64[$c1];

            $c1 = ($c2 & 0x0f) << 2;



            $c2 = ord($input[$i++]);

            $c1 |= $c2 >> 6;

            $output .= $itoa64[$c1];

            $output .= $itoa64[$c2 & 0x3f];

        } while (1);



        return $output;

    }

}



class HTML

{

    /*** HTML Functions ***/

    // Parse template semantics

    public function parseHTML($param)

    {

        // Remove bracers

        $param = trim(str_replace(array("{","}"),"",$param));

        $param = explode(".",$param);



        if ($param[0]=='load') // LOAD variable

        {

            echo $this->load[$param[1]];

        }

        else if ($param[0]=='get') // GET variable

        {

            echo $_GET[$param[1]];

        }

    }



    // Generate Public Breadcrumb

    public function getBreadcrumb($module_name, $module_default_url, $section, $config, $title, $tier=1, $item_name='', $item_url='', $sub_module_name='', $sub_module_default_url='')

    {

        $divider = "<span class='breadcrumb_divider'>".$config['BREADCRUMB_DIVIDER']."</span>";



        $result = "<div class='breadcrumb_box'><a href='".$config['SITE_DIR']."/".$section."'>".Helper::translate("Home", "member-breadcrumb-home")."</a>";



        if ($tier==1)

        {

            if ($title!="")

            {

                $result .= $divider;

                $result .= "<a href='".$config['SITE_DIR'].$module_default_url."'>".$module_name."</a>";

                $result .= $divider;

                $result .= $title;

            }

            else

            {

                $result .= $divider;

                $result .= $module_name;

            }

        }

        else if ($tier==2)

        {

            if ($title!="")

            {

                $result .= $divider;

                $result .= "<a href='".$config['SITE_DIR'].$module_default_url."'>".$module_name."</a>";

                $result .= $divider;

                $result .= "<a href='".$config['SITE_DIR'].$item_url."'>".$item_name."</a>";

                $result .= $divider;

                $result .= "<a href='".$config['SITE_DIR'].$sub_module_default_url."'>".$sub_module_name."</a>";

                $result .= $divider;

                $result .= $title;

            }

            else

            {

                $result .= $divider;

                $result .= "<a href='".$config['SITE_DIR'].$module_default_url."'>".$module_name."</a>";

                $result .= $divider;

                $result .= "<a href='".$config['SITE_DIR'].$item_url."'>".$item_name."</a>";

                $result .= $divider;

                $result .= $sub_module_name;

            }

        }



        $result .= "</div>";



        return $result;

    }

}



class File

{

	/*** File Functions ***/

	// Uploads file

	public function uploadFile($file, $isImage=0, $maxSize=2, $destination)

	{

		// Uploads file to server

		$result = array();

		$result['error'] = "";



		if ($_FILES[$file]["error"]==4) // Empty file will not return an error

		{

			$result['upload']['status'] = "Empty";

		}

		else

		{

			$maxSize = $maxSize*1024*1024; // Convert MB to byte

			$destination = "upload/".$destination."/";



            if (!file_exists($destination)) {

                mkdir($destination, 0755, true);

            }



			// Determine allowed extensions

			if ($isImage==1)

			{

				$allowedExts = array("gif","jpg","jpeg","png");

			}

			else

			{

				$allowedExts = array("doc","docx","gif","jpg","jpeg","png","mpg","mpeg","mp3","odt","odp","ods","pdf","ppt","pptx","rar","tif","tiff","txt","xls","xlsx","wav","zip");

			}



			// Retrieve file extension from file name

			$extension = end(explode(".", $_FILES[$file]["name"]));



			if ($_FILES[$file]["size"] > $maxSize) // Check file size

			{

				$result['error'] = "File exceeds maximum size of ".($maxSize/1048576)."MB. File size is ".($_FILES[$file]["size"]/1048576)."MB.";

			}

			else if (!(in_array($extension, $allowedExts))) // Check extensions

			{

				$result['error'] = "The file extension (".$extension.") is not allowed.";

			}

			else // Check general errors

			{

				if ($_FILES[$file]["error"]>0)

				{

					$result['error'] = File::codeToMessage($_FILES[$file]["error"]);

				}

				else

				{

					require_once('lib/wideimage/WideImage.php');



					$result['upload']['name'] = $_FILES[$file]["name"];

					$result['upload']['type'] = $_FILES[$file]["type"];

					$result['upload']['size'] = ($_FILES[$file]["size"]/1024)."KB";

					$result['upload']['tmp'] = $_FILES[$file]["tmp_name"];



					// Rename file

					$filename = md5(uniqid().$_FILES[$file]["name"]);



					$destination_ori = $destination.$filename.".".$extension;



					// Check if file with same name exists in destination folder, append counter if exists

                    $counter = 0;

                    while (file_exists($destination_ori))

                    {

                        $new_filename = $filename.'_'.$counter;

                        $destination_ori = $destination.$new_filename.".".$extension;

                        $counter++;

                    }



					// Save file

					move_uploaded_file($_FILES[$file]["tmp_name"], $destination_ori);

					$result['upload']['destination'] = "/".$destination_ori;

					$result['upload']['status'] = "Uploaded";

				}

			}

		}



		return $result;

	}



    public function codeToMessage($code)

    {

        switch ($code) {

            case UPLOAD_ERR_INI_SIZE:

                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";

                break;

            case UPLOAD_ERR_FORM_SIZE:

                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";

                break;

            case UPLOAD_ERR_PARTIAL:

                $message = "The uploaded file was only partially uploaded";

                break;

            case UPLOAD_ERR_NO_FILE:

                $message = "No file was uploaded";

                break;

            case UPLOAD_ERR_NO_TMP_DIR:

                $message = "Missing a temporary folder";

                break;

            case UPLOAD_ERR_CANT_WRITE:

                $message = "Failed to write file to disk";

                break;

            case UPLOAD_ERR_EXTENSION:

                $message = "File upload stopped by extension";

                break;



            default:

                $message = "Unknown upload error";

                break;

        }



        return $message;

    }



    public function deleteFile($link)

    {

        $link = substr($link,1);



        if (file_exists($link))

        {

            unlink($link);

        }

    }

}



class Image

{

    public function generateImage($destination_ori,$target_width,$target_height,$label,$crop_x='center',$crop_y='center')

    {

        /*

         * $destination_ori - the original uploaded image URL

         * $target_width - desired image width

         * $target_height - desired image height

         * $label - label for this size e.g. medium, thumb, home

         */

        require_once('lib/wideimage/WideImage.php');



        $destination_ori = substr($destination_ori,1);



        // Get original image dimensions

        list($width, $height, $type, $attr) = getimagesize($destination_ori);



        // Separates original image URL into filename and extension

        $destination_array = explode(".",$destination_ori);



        // Builds new URL with desired label

        $destination_label = $destination_array[0]."-".$label.".".$destination_array[1];



        // Reszies and crops file into dsired size

        if (($width/$height)>($target_width/$target_height))

        {

            $resizeWidth = $width/($height/$target_height);

            $resizeHeight = $target_height;



            WideImage::load($destination_ori)->resize($resizeWidth,$resizeHeight)->crop($crop_x, $crop_y, $target_width, $target_height)->saveToFile($destination_label);

        }

        else if (($width/$height)<($target_width/$target_height))

        {

            $resizeWidth = $target_width;

            $resizeHeight = $height/($width/$target_width);



            WideImage::load($destination_ori)->resize($resizeWidth,$resizeHeight)->crop($crop_x, $crop_y, $target_width, $target_height)->saveToFile($destination_label);

        }

        else

        {

            WideImage::load($destination_ori)->resize($target_width, $target_height)->saveToFile($destination_label);

        }

    }



    public function getImage($link,$size)

    {

        $imageLink = explode(".",$link);



        $result = $imageLink[0]."-".$size.".".$imageLink[1];



        return $result;

    }



    public function deleteImage($link)

    {

        $link = substr($link,1);



        if (file_exists($link))

        {

            unlink($link);

        }

    }

}



class CRUD

{

	protected $query_counter = 0;



	/*** CRUD Functions***/



	// Check if field is unique

	public function isUnique($dbconnect,$table,$field,$param,$query_condition=NULL)

	{

		$query_count = "SELECT COUNT(*) AS num FROM `".$table."` WHERE `".$field."` = '".$param."' ".$query_condition;

		$result = $dbconnect->query($query_count)->fetchColumn();



		return $result;

	}



    // Make s value unique

    /*public function makeUnique($param,$field,$table,$query_condition=NULL)

    {

        $query_count = "SELECT COUNT(*) AS num FROM `".$table."` WHERE `".$field."` = '".$param."' ".$query_condition;

        $result = $this->dbconnect->query($query_count)->fetchColumn();



        return $result;

    }*/



	// Convert to Display for Fields with Yes/No Values

	public function isActive($param)

	{

		if ($param==1)

		{

		    $bg_color = "#17A647";

		    $color = "#fff";

            $status = "Yes";

		}

		else if ($param==0)

		{

            $bg_color = "#c00";

            $color = "#fff";

            $status = "No";

		}



        $result = "<span class='label' style='background-color:".$bg_color."; color:".$color."'>".$status."</span>";



		return $result;

	}



	// Get All Values for Fields with Yes/No Values

	public function getActiveList()

	{

		$result = array();



		$result[0] = array(

			'ID' => '1',

			'Value' => 'Yes');



		$result[1] = array(

			'ID' => '0',

			'Value' => 'No');



		$result['count'] = 2;



		return $result;

	}



	// Get Gender

	public function getGender($param)

	{

		if ($param=="0")

		{

			$result = "Unknown";

		}

		else if ($param=="1")

		{

			$result = "Male";

		}

		else if ($param=="2")

		{

			$result = "Female";

		}



		return $result;

	}



	// Get Gender List

	public function getGenderList()

	{

		$result = array();



		$result[0] = array(

			'ID' => '1',

			'Value' => 'Male');



		$result[1] = array(

			'ID' => '2',

			'Value' => 'Female');



		$result['count'] = 2;



		return $result;

	}

	public function queryCondition($column,$param,$operator,$initial='')
	{
		// $column is the corresponding column from database
		// $param is the parameter name from search form
		// $operator is operator type (= or LIKE or > or < or >= or <=)
		// $position of query (0=first, 1=others)

		$return = "";

        // Set initial counter number
        if ($initial!="")
        {
            $this->query_counter = $initial;
        }

		if ($param!="")
		{

			if ($this->query_counter==0)
			{
				$return .= " WHERE ";
				$this->query_counter += 1;
			}
			else if ($this->query_counter==1)
			{
				$return .= " AND ";
			}
			if ($operator=="LIKE")
			{
				$param = "%".$param."%";
			}

			$return .= "".$column." ".$operator." '".$param."'";
		}

		return $return;
	}

	public function paginate($targetpage,$total_pages,$limit,$stages,$page)

    {
        if ($_SESSION['superid']=='1')
        {
            $constant = get_defined_constants(true);

            // Initial page num setup
            if ($page == 0){$page = 1;}
            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total_pages/$limit);
            $LastPagem1 = $lastpage - 1;

            if (($constant['user']['LOAD_SECTION']=='admin')||($constant['user']['LOAD_SECTION']=='agent'))
            {
                $paginate = '';

                if ($lastpage > 1)
                {
                    $paginate .= "<div class='paginate'>";

                    // Previous
                    if ($page > 1)
                    {
                        $paginate.= "<a href='$targetpage?page=$prev'>previous</a>";
                    }
                    else
                    {
                        $paginate.= "<span class='disabled'>previous</span>";
                    }

                    // Pages
                    if ($lastpage < 7 + ($stages * 2)) // Not enough pages to breaking it up
                    {
                        for ($counter = 1; $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                            {
                                $paginate.= "<span class='current'>$counter</span>";
                            }
                            else
                            {
                                $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
                            }
                        }
                    }
                    else if ($lastpage > 5 + ($stages * 2)) // Enough pages to hide a few?
                    {
                        // Beginning only hide later pages
                        if ($page < 1 + ($stages * 2))
                        {
                            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
                            {
                                if ($counter == $page){
                                    $paginate.= "<span class='current'>$counter</span>";
                                }else{
                                    $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}
                            }
                            $paginate.= "...";
                            $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
                            $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
                        }
                        // Middle hide some front and some back
                        else if ($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
                        {
                            $paginate.= "<a href='$targetpage?page=1'>1</a>";
                            $paginate.= "<a href='$targetpage?page=2'>2</a>";
                            $paginate.= "...";

                            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
                            {
                                if ($counter == $page)
                                {
                                    $paginate.= "<span class='current'>$counter</span>";
                                }
                                else
                                {
                                    $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
                                }
                            }

                            $paginate.= "...";
                            $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
                            $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
                        }
                        // End only hide early pages
                        else
                        {
                            $paginate.= "<a href='$targetpage?page=1'>1</a>";
                            $paginate.= "<a href='$targetpage?page=2'>2</a>";
                            $paginate.= "...";

                            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
                            {
                                if ($counter == $page)
                                {
                                    $paginate.= "<span class='current'>$counter</span>";
                                }
                                else
                                {
                                    $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
                                }
                            }
                        }
                    }

                    // Next
                    if ($page < $counter - 1)
                    {
                        $paginate.= "<a href='$targetpage?page=$next'>next</a>";
                    }
                    else
                    {
                        $paginate.= "<span class='disabled'>next</span>";
                    }

                    $paginate.= "</div>";
                }
            }
            else
            {
                $paginate = '';

                if ($lastpage > 1)
                {
                    $paginate .= "<div class='pagination_wrapper right'><ul class='pagination'>";

                    // Previous
                    if ($page > 1)
                    {
                        $paginate.= "<li><a href='$targetpage?page=$prev'>Previous</a></li>";
                    }
                    else
                    {
                        $paginate.= "<li class='disabled'><a href='javascript:void(0);'>Previous</a></li>";
                    }

                    // Pages
                    if ($lastpage < 7 + ($stages * 2))  // Not enough pages to breaking it up
                    {
                        for ($counter = 1; $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                            {
                                $paginate.= "<li class='current'><a href='javascript:void(0);'>$counter</a></li>";
                            }
                            else
                            {
                                $paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
                            }
                        }
                    }
                    else if ($lastpage > 5 + ($stages * 2))   // Enough pages to hide a few?
                    {
                        // Beginning only hide later pages
                        if ($page < 1 + ($stages * 2))
                        {
                            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
                            {
                                if ($counter == $page)
                                {
                                    $paginate.= "<li class='current'><a href='javascript:void(0);'>$counter</a></li>";
                                }
                                else
                                {
                                    $paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
                                }
                            }

                            $paginate.= "<li class='dots'><a href='javascript:void(0);'>...</li>";
                            $paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
                            $paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";
                        }
                        // Middle hide some front and some back
                        else if ($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
                        {
                            $paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
                            $paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
                            $paginate.= "<li class='dots'><a href='javascript:void(0);'>...</li>";

                            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
                            {
                                if ($counter == $page)
                                {
                                    $paginate.= "<li class='current'><a href='javascript:void(0);'>$counter</a></li>";
                                }
                                else
                                {
                                    $paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
                                }
                            }

                            $paginate.= "<li class='dots'><a href='javascript:void(0);'>...</li>";
                            $paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
                            $paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";
                        }
                        // End only hide early pages
                        else
                        {
                            $paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
                            $paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
                            $paginate.= "<li class='dots'><a href='javascript:void(0);'>...</li>";
                            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
                            {
                                if ($counter == $page)
                                {
                                    $paginate.= "<li class='current'><a href='javascript:void(0);'>$counter</a></li>";
                                }
                                else
                                {
                                    $paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";
                                }
                            }
                        }
                    }

                    // Next
                    if ($page < $counter - 1)
                    {
                        $paginate.= "<li><a href='$targetpage?page=$next'>Next</a></li>";
                    }
                    else
                    {
                        $paginate.= "<li class='disabled'><a href='javascript:void(0);'>Next</a></li>";
                    }

                    $paginate.= "</ul><div class='clearfix'></div></div>";
                }
            }
        }
        else
        {

        // Initial page num setup

        if ($page == 0){$page = 1;}

        $prev = $page - 1;

        $next = $page + 1;

        $lastpage = ceil($total_pages/$limit);

        $LastPagem1 = $lastpage - 1;



        $paginate = '';

        if($lastpage > 1)

        {

            $paginate .= "<div class='paginate'>";

            // Previous

            if ($page > 1){

                $paginate.= "<a href='$targetpage?page=$prev'>previous</a>";

            }else{

                $paginate.= "<span class='disabled'>previous</span>";   }



            // Pages

            if ($lastpage < 7 + ($stages * 2))  // Not enough pages to breaking it up

            {

                for ($counter = 1; $counter <= $lastpage; $counter++)

                {

                    if ($counter == $page){

                        $paginate.= "<span class='current'>$counter</span>";

                    }else{

                        $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

                }

            }

            elseif($lastpage > 5 + ($stages * 2))   // Enough pages to hide a few?

            {

                // Beginning only hide later pages

                if($page < 1 + ($stages * 2))

                {

                    for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)

                    {

                        if ($counter == $page){

                            $paginate.= "<span class='current'>$counter</span>";

                        }else{

                            $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

                    }

                    $paginate.= "...";

                    $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

                    $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

                }

                // Middle hide some front and some back

                elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))

                {

                    $paginate.= "<a href='$targetpage?page=1'>1</a>";

                    $paginate.= "<a href='$targetpage?page=2'>2</a>";

                    $paginate.= "...";

                    for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)

                    {

                        if ($counter == $page){

                            $paginate.= "<span class='current'>$counter</span>";

                        }else{

                            $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

                    }

                    $paginate.= "...";

                    $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

                    $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

                }

                // End only hide early pages

                else

                {

                    $paginate.= "<a href='$targetpage?page=1'>1</a>";

                    $paginate.= "<a href='$targetpage?page=2'>2</a>";

                    $paginate.= "...";

                    for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)

                    {

                        if ($counter == $page){

                            $paginate.= "<span class='current'>$counter</span>";

                        }else{

                            $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

                    }

                }

            }



            // Next

            if ($page < $counter - 1)

            {

                $paginate.= "<a href='$targetpage?page=$next'>next</a>";

            }

            else

            {

                $paginate.= "<span class='disabled'>next</span>";

            }



            $paginate.= "</div>";



        }

        }



        // pagination

        return $paginate;

    }



	public function validateFormSubmit($value, $key = 'submit', $exit = NULL, $redirect_url = NULL)

	{

		// Checks if form is submitted

        if ($_POST[$key]!=$value)

        {

            if ($redirect==NULL)

            {

                $constant = get_defined_constants(true);

                $redirect_url = "/".$constant['user']['LOAD_SECTION'];

            }



            if ($exit==TRUE)

            {

                exit();

            }

            else

            {

                Helper::redirect($redirect_url);

            }

        }

	}

}

class RestAPI
{
    /*
     *  Custom REST API class for Vivace Framework
     */

    protected $method;
	protected $request_data;

    public function __construct()
    {
        // Determine HTTP method
        $this->verifyMethod();
    }

    // Functions for Making RESTful API Requests (text/json/xml)
    public function makeRequest($url, $data_string, $method="GET", $content_type="form")
    {
        $ch = curl_init();

        // GET Request via PHP Curl
        if ($method=='GET')
        {
            curl_setopt($ch, CURLOPT_URL, $url."?".$data_string);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }

        // POST Request via PHP Curl
        if ($method=='POST')
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Determine the correct content type
            if ($content_type=="form")
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/x-www-form-urlencoded')
                );
            }
            else if ($content_type=="json")
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );
            }
            else if ($content_type=="xml")
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: text/xml',
                    'Content-Length: ' . strlen($data_string))
                );
            }
            else
            {
                $this->setResponse('415', 'Unsupported Content Type');
            }
        }

        $result = curl_exec($ch);

        if (curl_errno($ch))
        {
            echo "CURL Error: ".curl_errno($ch);
            exit();
        }

        return $result;
    }

    // Functions for Receiving RESTful API Requests
    public function getMethod()
    {
        return $this->method;
    }

    public function getRequestData()
    {
        return $this->request_data;
    }

    public function verifyMethod()
    {
        // Set HTTP method of request
        if ($_SERVER['REQUEST_METHOD']=="GET")
        {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->request_data = $_GET;
        }
        else if ($_SERVER['REQUEST_METHOD']=="POST")
        {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->request_data = json_decode(file_get_contents("php://input"),1);
        }
        else
        {
            $this->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

    public function authenticate()
    {
        Core::requireModel('app');

        $app = new AppModel();
        $verify = $app->verifyCredentials($this->request_data);

        if ($verify['Status']=="OK")
        {
            return "OK";
        }
        else if ($verify['Status']=="INVALID_IP")
        {
            $this->setResponse('401', 'Invalid Client IP Address');
        }
        else if ($verify['Status']=="INVALID_REQUEST")
        {
            $this->setResponse('401', 'Invalid Request');
        }
        else if ($verify['Status']=="INVALID_APP")
        {
            $this->setResponse('401', 'Invalid App Credentials');
        }
    }

    public function setResponse($code, $message, $content=NULL, $exit=TRUE)
    {
        header('HTTP/1.1 '.$code.' '.$message);
        header('Content-Type: application/json; charset=utf-8');

        if ($code=="200")
        {
            // Return content
            echo $content;
        }
        else
        {
            // Return error
            $error = array("Code" => $code, "Message" => $message);
            $error = json_encode($error);

            echo $error;
        }

        if ($exit==TRUE)
        {
            exit();
        }
    }
}

class BaseMailer extends PHPMailer

{

    var $priority = 3;

    var $to_name;

    var $to_email;

    var $From = null;

    var $FromName = null;

    var $Sender = null;



    function smtp_mode($param)

    {

        // Comes from config.php $param array



        if($param['SMTP_MODE'] == 'enabled')

        {

            $this->Host = $param['SMTP_HOST'];

            $this->Port = $param['SMTP_PORT'];

            if($param['SMTP_USERNAME'] != '')

            {

                $this->SMTPAuth = true;

                $this->Username = $param['SMTP_USERNAME'];

                $this->Password = $param['SMTP_PASSWORD'];

            }

            $this->Mailer = "smtp";

        }

        if(!$this->From)

        {

            $this->From = $param['SITE_EMAIL'];

        }

        if(!$this->FromName)

        {

            $this-> FromName = $param['SMTP_WEBMASTER'];

        }

        if(!$this->Sender)

        {

            $this->Sender = $param['SITE_EMAIL'];

        }

        $this->Priority = $this->priority;

    }

}

?>