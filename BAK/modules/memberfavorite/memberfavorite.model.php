<?php
// Require required models
Core::requireModel('member');
Core::requireModel('listing');
Core::requireModel('listingrating');

class MemberFavoriteModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['memberfavorite'] = array(
        'name' => "Member Favorite",
        'dir' => "modules/memberfavorite/",
        'default_url' => "/main/memberfavorite/index",
        'admin_url' => "/admin/memberfavorite/index");
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member_favorite WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/memberfavorite/index';
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

		$sql = "SELECT * FROM member_favorite WHERE Enabled = 1 ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberfavorite']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Member Favorites", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberfavorite']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM member_favorite WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberfavorite']['name'], "Link" => $this->module['memberfavorite']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['memberfavorite_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");

			$_SESSION['memberfavorite_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['memberfavorite_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];

			// Set Query Variable
			$_SESSION['memberfavorite_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['memberfavorite_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['memberfavorite_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['memberfavorite_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
            $sort = TRUE;
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM member_favorite ".$_SESSION['memberfavorite_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/memberfavorite/index';
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

		$sql = "SELECT * FROM member_favorite ".$_SESSION['memberfavorite_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"));

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberfavorite']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Member Favorites", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberfavorite']['dir'].'inc/admin/index.inc.php', 'memberfavorite_delete' => $_SESSION['admin']['memberfavorite_delete']),
		'block' => array('side_nav' => $this->module['memberfavorite']['dir'].'inc/admin/side_nav.memberfavorite_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberfavorite_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberfavorite']['name'], "Link" => $this->module['memberfavorite']['admin_url']),
            array("Title" => "Create Member Favorite", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Member Favorite", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberfavorite']['dir'].'inc/admin/add.inc.php', 'memberfavorite_add' => $_SESSION['admin']['memberfavorite_add']),
		'block' => array('side_nav' => $this->module['memberfavorite']['dir'].'inc/admin/side_nav.memberfavorite_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberfavorite_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(MemberID, ListingID)";
		$value = "('".$_POST['MemberID']."', '".$_POST['ListingID']."')";

		$sql = "INSERT INTO member_favorite ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Member Favorite...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM member_favorite WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['memberfavorite']['name'], "Link" => $this->module['memberfavorite']['admin_url']),
            array("Title" => "Edit Member Favorite", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Member Favorite", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['memberfavorite']['dir'].'inc/admin/edit.inc.php', 'memberfavorite_add' => $_SESSION['admin']['memberfavorite_add'], 'memberfavorite_edit' => $_SESSION['admin']['memberfavorite_edit']),
        'block' => array('side_nav' => $this->module['memberfavorite']['dir'].'inc/admin/side_nav.memberfavorite_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['memberfavorite_add']);
		unset($_SESSION['admin']['memberfavorite_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE member_favorite SET MemberID='".$_POST['MemberID']."', ListingID='".$_POST['ListingID']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Member Favorite...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM member_favorite WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Member Favorite...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	public function APIIndex($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                // Initialise query conditions
				$query_condition = "";
		
				$crud = new CRUD();
		
				if ($_POST['Trigger']=='search_form')
				{
					// Reset Query Variable
					$_SESSION['memberfavorite_'.__FUNCTION__] = "";
		
					$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=",1);
					$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
		
					$_SESSION['memberfavorite_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
					$_SESSION['memberfavorite_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
		
					// Set Query Variable
					$_SESSION['memberfavorite_'.__FUNCTION__]['query_condition'] = $query_condition;
					$_SESSION['memberfavorite_'.__FUNCTION__]['query_title'] = "Search Results";
				}
		
				// Reset query conditions
				if ($_GET['page']=="all")
				{
					$_GET['page'] = "";
					unset($_SESSION['memberfavorite_'.__FUNCTION__]);
				}
		
				// Determine Title
				if (isset($_SESSION['memberfavorite_'.__FUNCTION__]))
				{
					$query_title = "Search Results";
		            $search = "on";
				}
				else
				{
					$query_title = "All Results";
		            $search = "off";
		            $sort = TRUE;
				}
		
				// Prepare Pagination
				$query_count = "SELECT COUNT(*) AS num FROM member_favorite ".$_SESSION['memberfavorite_'.__FUNCTION__]['query_condition'];
				$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
				$targetpage = $data['config']['SITE_URL'].'/admin/memberfavorite/index';
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
		
				$sql = "SELECT * FROM member_favorite WHERE MemberID = '".$request_data['MemberID']."' ".$_SESSION['memberfavorite_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";
		
				$result = array();
				$i = 0;
				foreach ($this->dbconnect->query($sql) as $row)
				{
					$result[$i] = array(
					'ID' => $row['ID'],
					'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
					'AverageRating' =>ListingRatingModel::getAverageListingRating($row['ListingID']),
					'AverageMemberFavorite' => MemberFavoriteModel::getAverageMemberFavorite($row['ListingID']),
					//'ListingRating' => ListingRatingModel::getListingRating(),
					//'ListingImage' => ListingModel::getListing($row['ListingID'], "ImageURL"),
					'ListingID' => ListingModel::getListing($row['ListingID']));
		
					$i += 1;
				}

                $output['Count'] = $i;
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
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function APIUnlikeProcess($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
                $sql = "DELETE FROM member_favorite WHERE MemberID ='".$request_data['MemberID']."' AND ListingID ='".$request_data['ListingID']."'";
		        $count = $this->dbconnect->exec($sql);
				
				$output['Count'] = $count;
				$error_message = "Error ocurred";
                //$output['Content'] = ($output['Count'] == 1)?"Deleted":"Error ocurred";
                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode(array('Status' => "Unlike Successfully"));
                    $restapi->setResponse('200', 'OK', $result);
                }elseif($output['Count']==0){
                	
					$restapi->setResponse('400', $error_message);
					
                }else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function APILikeProcess($param)
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="POST")
        {
            // Get all request data
            $request_data = $restapi->getRequestData();

            // Authenticating request via provided app credentials
            $authenticate = $restapi->authenticate();

            if ($authenticate=="OK")
            {
            	
				$result = MemberFavoriteModel::getMemberFavoriteChecked($request_data['MemberID'], $request_data['ListingID']);
				
				if($result['count']== 0){
					
                $key = "(MemberID, ListingID)";
				$value = "('".$request_data['MemberID']."', '".$request_data['ListingID']."')";
		
				$sql = "INSERT INTO member_favorite ".$key." VALUES ". $value;
		        $count = $this->dbconnect->exec($sql);
				
				}else{
					
				$sql = "DELETE FROM member_favorite WHERE ListingID ='".$request_data['ListingID']."' AND MemberID = '".$request_data['MemberID']."'";
		        $count = $this->dbconnect->exec($sql);
					
					if($count == '1'){
						
						$count = "Unlike";
					}	
				}
				
				$output['Count'] = $count;
				$error_message = "Error ocurred";
                //$output['Content'] = ($output['Count'] == 1)?"Deleted":"Error ocurred";
                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode(array("Status"=>"Like Successfully"));
                    $restapi->setResponse('200', 'OK', $result);
                }elseif($output['Count']=="Unlike"){
                	
					$result = json_encode(array("Status"=>"Unlike Successfully"));
                    $restapi->setResponse('200', 'OK', $result);
					
                }
                elseif($output['Count']==0){
                	
					$restapi->setResponse('400', $error_message);
					
                }else
                {
                    $restapi->setResponse('404', 'Resource Not Found');
                }
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
    }

	public function getAverageMemberFavorite($param)
	{
		$crud = new CRUD();

		$sql = "SELECT COUNT(*) AS OverallMemberFavorite FROM member_favorite WHERE ListingID = '".$param."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$OverallMemberFavorite = $row['OverallMemberFavorite'];
		}	
		

		return $OverallMemberFavorite;
	}

	public function getMemberFavorite($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_favorite WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

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

	public function getMemberFavoriteByListingID($param)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_favorite WHERE ListingID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

			$i += 1;
		}

		$result = $i;

		return $result;
	}

	public function getMemberFavoriteChecked($memberID, $listingID)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_favorite WHERE MemberID = '".$memberID."' AND ListingID = '".$listingID."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

			$i += 1;
		}

		
        
        $result['count'] = $i;
        

		return $result;
	}
	
	public function getViewMemberFavoriteChecked($memberID, $listingID)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_favorite WHERE MemberID = '".$memberID."' AND ListingID = '".$listingID."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			

			$i += 1;
		}

		
        
        $result = $i;
        

		return $result;
	}

	public function getMemberFavoriteList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM member_favorite ORDER BY MemberID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM member_favorite ".$_SESSION['memberfavorite_'.$param]['query_condition']." ORDER BY MemberID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Member_Favorite";
		$result['header'] = $this->config['SITE_NAME']." | Member Favorite (" . date('Y-m-d H:i:s') . ")\n\nID, Member, Listing";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MemberModel::getMember($row['MemberID'])."\",";
			$result['content'] .= "\"".ListingModel::getListing($row['ListingID'])."\"\n";

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
}
?>