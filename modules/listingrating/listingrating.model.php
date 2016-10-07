<?php
// Require required models
Core::requireModel('member');
Core::requireModel('listing');

class ListingRatingModel extends BaseModel
{
	private $output = array();
    private $module = array();

	public function __construct()
	{
		parent::__construct();

        $this->module['listingrating'] = array(
        'name' => "Listing Rating",
        'dir' => "modules/listingrating/",
        'default_url' => "/main/listingrating/index",
        'admin_url' => "/admin/listingrating/index");
	}

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM listing_rating WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/main/listingrating/index';
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

		$sql = "SELECT * FROM listing_rating WHERE Enabled = 1 ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingrating']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listing Ratings", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingrating']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM listing_rating WHERE ID = '".$param."' AND Enabled = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingrating']['name'], "Link" => $this->module['listingrating']['default_url']),
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
			$_SESSION['listingrating_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("MemberID",$_POST['MemberID'],"=");
			$query_condition .= $crud->queryCondition("ListingID",$_POST['ListingID'],"=");
			$query_condition .= $crud->queryCondition("Rating",$_POST['Rating'],"=");

			$_SESSION['listingrating_'.__FUNCTION__]['param']['MemberID'] = $_POST['MemberID'];
			$_SESSION['listingrating_'.__FUNCTION__]['param']['ListingID'] = $_POST['ListingID'];
			$_SESSION['listingrating_'.__FUNCTION__]['param']['Rating'] = $_POST['Rating'];

			// Set Query Variable
			$_SESSION['listingrating_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['listingrating_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['listingrating_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['listingrating_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM listing_rating ".$_SESSION['listingrating_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_URL'].'/admin/listingrating/index';
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

		$sql = "SELECT * FROM listing_rating ".$_SESSION['listingrating_'.__FUNCTION__]['query_condition']." ORDER BY MemberID ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => MemberModel::getMember($row['MemberID'], "Name"),
			'ListingID' => ListingModel::getListing($row['ListingID'], "Name"),
			'Rating' => $row['Rating']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingrating']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Listing Ratings", 'template' => 'admin.common.tpl.php',  'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingrating']['dir'].'inc/admin/index.inc.php', 'listingrating_delete' => $_SESSION['admin']['listingrating_delete']),
		'block' => array('side_nav' => $this->module['listingrating']['dir'].'inc/admin/side_nav.listingrating_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingrating_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingrating']['name'], "Link" => $this->module['listingrating']['admin_url']),
            array("Title" => "Create Listing Rating", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Listing Rating", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingrating']['dir'].'inc/admin/add.inc.php', 'listingrating_add' => $_SESSION['admin']['listingrating_add']),
		'block' => array('side_nav' => $this->module['listingrating']['dir'].'inc/admin/side_nav.listingrating_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingrating_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(MemberID, ListingID, Rating)";
		$value = "('".$_POST['MemberID']."', '".$_POST['ListingID']."', '".$_POST['Rating']."')";

		$sql = "INSERT INTO listing_rating ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Listing Rating...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM listing_rating WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['listingrating']['name'], "Link" => $this->module['listingrating']['admin_url']),
            array("Title" => "Edit Listing Rating", "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Listing Rating", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['listingrating']['dir'].'inc/admin/edit.inc.php', 'listingrating_add' => $_SESSION['admin']['listingrating_add'], 'listingrating_edit' => $_SESSION['admin']['listingrating_edit']),
        'block' => array('side_nav' => $this->module['listingrating']['dir'].'inc/admin/side_nav.listingrating_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'member_list' => MemberModel::getMemberList(), 'listing_list' => ListingModel::getListingList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['listingrating_add']);
		unset($_SESSION['admin']['listingrating_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE listing_rating SET MemberID='".$_POST['MemberID']."', ListingID='".$_POST['ListingID']."', Rating='".$_POST['Rating']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Listing Rating...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM listing_rating WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Listing Rating...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}
	
	
	public function APIRatingProcess($param)
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
            	
				$result = ListingRatingModel::getListingRated($request_data['MemberID'], $request_data['ListingID']); 
				//echo $result['count'];
				//exit;
				if($result['count'] == 0){
					
                $key = "(MemberID, ListingID, Rating)";
				$value = "('".$request_data['MemberID']."', '".$request_data['ListingID']."', '".$request_data['Rating']."')";
		
				$sql = "INSERT INTO listing_rating ".$key." VALUES ". $value;
		        $count = $this->dbconnect->exec($sql);
				
				}else{
					
				$sql = "UPDATE listing_rating SET MemberID='".$request_data['MemberID']."', ListingID='".$request_data['ListingID']."', Rating='".$request_data['Rating']."' WHERE MemberID='".$request_data['MemberID']."' AND ListingID='".$request_data['ListingID']."'";

		
		        $count = $this->dbconnect->exec($sql);	
					
				}
				
				$output['Count'] = $count;
				$error_message = "Error ocurred";
                //$output['Content'] = ($output['Count'] == 1)?"Deleted":"Error ocurred";
                // Set output
                if ($output['Count']>0)
                {
                    $result = json_encode(array('Status'=> 'Rated successfully'));
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

	public function getAverageListingRating($param)
	{
		$crud = new CRUD();

		$sql = "SELECT COUNT(*) AS AverageRating FROM listing_rating WHERE ListingID = '".$param."'";

		foreach ($this->dbconnect->query($sql) as $row)
		{
			$average = $row['AverageRating'];
		}	
		/*echo $sql;
		exit;*/
		$sql = "SELECT SUM(Rating) AS SumRating FROM listing_rating WHERE ListingID = '".$param."'";
		//$result = array();
		
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result = $row['SumRating'];
		}
		if($average !=0){
			
		   $AverageRating = $result/$average;
		}elseif($average ==0){
			
		   $AverageRating = '0';
		}
		
		return $AverageRating;
	}

	public function getListingRating($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_rating WHERE ID = '".$param."'";
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

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
	
	public function getListingRatingByListingID($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_rating WHERE ListingID = '".$param."'";
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

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

	


	public function getListingRated($memberID, $listingID)
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_rating WHERE ListingID = '".$listingID."' AND MemberID = '".$memberID."'";
		/*echo $sql;
		exit;*/
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

			$i += 1;
		}

		
        $result['count'] = $i; 

		return $result;
	}

	

	public function getListingRatingList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM listing_rating ORDER BY MemberID ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'MemberID' => $row['MemberID'],
			'ListingID' => $row['ListingID'],
			'Rating' => $row['Rating']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM listing_rating ".$_SESSION['listingrating_'.$param]['query_condition']." ORDER BY MemberID ASC";

		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Listing_Rating";
		$result['header'] = $this->config['SITE_NAME']." | Listing Rating (" . date('Y-m-d H:i:s') . ")\n\nID, Member, Listing, Rating";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".MemberModel::getMember($row['MemberID'])."\",";
			$result['content'] .= "\"".ListingModel::getListing($row['ListingID'])."\",";
			$result['content'] .= "\"".$row['Rating']."\"\n";

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