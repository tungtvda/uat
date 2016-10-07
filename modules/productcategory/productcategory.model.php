<?php
// Require required models
Core::requireModel('productcategory');

class ProductCategoryModel extends BaseModel
{
	private $output = array();
    private $module_name = "Product Category";
	private $module_dir = "modules/productcategory/";
    private $module_default_url = "/main/productcategory/index";
    private $module_default_admin_url = "/admin/productcategory/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM product_category WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_DIR'].'/main/productcategory/index';
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
		
		$sql = "SELECT * FROM product_category WHERE Enabled = 1 ORDER BY ParentID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Product Categories", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.productcategory.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM product_category WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURL' => $row['ImageURL'],
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
		'block' => array('side_nav' => $this->module_dir.'inc/main/side_nav.productcategory.inc.php', 'common' => "false"),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,$result[0]['Title']),
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
			$_SESSION['productcategory_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ParentID",$_POST['ParentID'],"=");
			$query_condition .= $crud->queryCondition("Name",$_POST['Name'],"LIKE");
			$query_condition .= $crud->queryCondition("FriendlyURL",$_POST['FriendlyURL'],"LIKE");
			$query_condition .= $crud->queryCondition("Description",$_POST['Description'],"LIKE");
			$query_condition .= $crud->queryCondition("Enabled",$_POST['Enabled'],"=");
			
			$_SESSION['productcategory_'.__FUNCTION__]['param']['ParentID'] = $_POST['ParentID'];
			$_SESSION['productcategory_'.__FUNCTION__]['param']['Name'] = $_POST['Name'];
			$_SESSION['productcategory_'.__FUNCTION__]['param']['FriendlyURL'] = $_POST['FriendlyURL'];
			$_SESSION['productcategory_'.__FUNCTION__]['param']['Description'] = $_POST['Description'];
			$_SESSION['productcategory_'.__FUNCTION__]['param']['Enabled'] = $_POST['Enabled'];
			
			// Set Query Variable
			$_SESSION['productcategory_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['productcategory_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['productcategory_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['productcategory_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM product_category ".$_SESSION['productcategory_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/productcategory/index';
		$limit = 100000;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;	
		}	
		
		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);
		
		$sql = "SELECT * FROM product_category ".$_SESSION['productcategory_'.__FUNCTION__]['query_condition']." ORDER BY ParentID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => ProductCategoryModel::getProductCategory($row['ParentID']),
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Product Categories", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'productcategory_delete' => $_SESSION['admin']['productcategory_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.productcategory_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'productcategory_list' => ProductCategoryModel::getProductCategoryList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['productcategory_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Product Category", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'productcategory_add' => $_SESSION['admin']['productcategory_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.productcategory_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Product Category"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'productcategory_list' => ProductCategoryModel::getProductCategoryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['productcategory_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"productcategory");
                
        if ($upload['ImageURL']['upload']['status']=="Empty") 
        {
            $file_location['ImageURL'] = "";
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded") 
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],100,100,'cover');
        }
        else
        {
            $error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];
				
            $file_location['ImageURL'] = "";
        }
		
		$key = "(ParentID, Name, FriendlyURL, Description, ImageURL, Enabled, Position)";
		$value = "('".$_POST['ParentID']."', '".$_POST['Name']."', '".$_POST['FriendlyURL']."', '".$_POST['Description']."', '".$file_location['ImageURL']."', '".$_POST['Enabled']."', '".$_POST['Position']."')";

		$sql = "INSERT INTO product_category ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Product Category...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM product_category WHERE ID = '".$param."'";
	
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
            {
                $cover_image = '';
            }
            else
            {
                $cover_image = Image::getImage($row['ImageURL'],'cover');
            }
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Enabled' => $row['Enabled'],
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Edit Product Category", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'productcategory_add' => $_SESSION['admin']['productcategory_add'], 'productcategory_edit' => $_SESSION['admin']['productcategory_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.productcategory_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Product Category"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'productcategory_list' => ProductCategoryModel::getProductCategoryList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['productcategory_add']);
		unset($_SESSION['admin']['productcategory_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"productcategory");
                
        if ($upload['ImageURL']['upload']['status']=="Empty") 
        {
            if ($_POST['ImageURLRemove']==1)
            {
                $file_location['ImageURL'] = "";
                Image::deleteImage($_POST['ImageURLCurrent']);
                Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
            }
            else
            {
                $file_location['ImageURL'] = $_POST['ImageURLCurrent'];
            }
        }
        else if ($upload['ImageURL']['upload']['status']=="Uploaded") 
        {
            $file_location['ImageURL'] = $upload['ImageURL']['upload']['destination'];
            Image::generateImage($file_location['ImageURL'],100,100,'cover');
            Image::deleteImage($_POST['ImageURLCurrent']);
            Image::deleteImage(Image::getImage($_POST['ImageURLCurrent'],'cover'));
        }
        else
        {
        	$error['count'] += 1;
            $error['ImageURL'] = $upload['ImageURL']['error'];
			
            $file_location['ImageURL'] = "";
        }
		
		$sql = "UPDATE product_category SET ParentID='".$_POST['ParentID']."', Name='".$_POST['Name']."', FriendlyURL='".$_POST['FriendlyURL']."', Description='".$_POST['Description']."', ImageURL='".$file_location['ImageURL']."', Enabled='".$_POST['Enabled']."', Position='".$_POST['Position']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count<=1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Product Category...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM product_category WHERE ID = '".$param."'";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'ImageURL' => $row['ImageURL']);
            
            $i += 1;
        }
        
        Image::deleteImage($result[0]['ImageURL']);
        Image::deleteImage(Image::getImage($result[0]['ImageURL'],'cover'));

		// Delete entry from table
		$sql = "DELETE FROM product_category WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Product Category...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminSort() 
    {  
        $param = explode(",",$_POST['param']);
        
        $i = 0;
        foreach($param as $id) 
        {
            $sql = "UPDATE product_category SET Position='".$i."' WHERE ID='".$id."'";
            $count = $this->dbconnect->exec($sql);
            
            $i++;
        }

        $result = $i;
                    
        return $result;
    }
    
    public function AdminPosition() 
    {
        $param = $_POST['param']; 
       
        $crud = new CRUD();

        $sql = "SELECT * FROM product_category WHERE ID = '".$param."'";
        
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'Position' => $row['Position']);
            
            $i += 1;
        }
        
        $result = $result[0]['ID'].",".$result[0]['Position'];
        
        return $result;
    }
	
	public function getProductCategory($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM product_category WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => ProductCategoryModel::getProductCategory($row['ParentID']),
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$result = $result[0]['Name'];
		
		return $result;
	}

	public function getProductCategoryList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM product_category ORDER BY Name ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => ProductCategoryModel::getProductCategory($row['ParentID']),
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$result['count'] = $i;
		
		return $result;
	}
	
	public function BlockIndex($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM product_category WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();
		
		$targetpage = $data['config']['SITE_DIR'].'/main/productcategory/index';
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
		
		$sql = "SELECT * FROM product_category WHERE Enabled = 1 ORDER BY ParentID ASC LIMIT $start, $limit";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			if ($row['ImageURL']=='')
			{
				$cover_image = $this->config['THEME_DIR'].'img/no_image.png';
			}
			else
			{
				$cover_image = Image::getImage($row['ImageURL'],'cover');
			}
			
			$result[$i] = array(
			'ID' => $row['ID'],
			'ParentID' => $row['ParentID'],
			'Name' => $row['Name'],
			'FriendlyURL' => $row['FriendlyURL'],
			'Description' => $row['Description'],
			'ImageURL' => $cover_image,
			'Enabled' => CRUD::isActive($row['Enabled']),
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Product Categories", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM product_category ".$_SESSION['productcategory_'.$param]['query_condition']." ORDER BY ParentID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Product_Categories";
		$result['header'] = $this->config['SITE_NAME']." | Product Categories (" . date('Y-m-d H:i:s') . ")\n\nID, Parent, Name, Friendly URL, Description, Image URL, Enabled, Position";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ProductCategoryModel::getProductCategory($row['ParentID'])."\",";
			$result['content'] .= "\"".$row['Name']."\",";
			$result['content'] .= "\"".$row['FriendlyURL']."\",";
			$result['content'] .= "\"".$row['Description']."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Enabled'])."\",";
			$result['content'] .= "\"".$row['Position']."\"\n";

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