<?php
// Require required models
Core::requireModel('product');

class ProductImageModel extends BaseModel
{
	private $output = array();
    private $module_name = "Product Image";
	private $module_dir = "modules/productimage/";
    private $module_default_url = "/main/productimage/index";
    private $module_default_admin_url = "/admin/productimage/index";
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function Index($param) 
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM product_image WHERE Enabled = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/main/productimage/index';
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
		
		$sql = "SELECT * FROM product_image WHERE Enabled = 1 ORDER BY ProductID ASC LIMIT $start, $limit";
		
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
			'ProductID' => $row['ProductID'],
			'ImageURL' => $cover_image,
			'Cover' => $row['Cover'],
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Product Images", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_url,"",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function View($param) 
	{
		$sql = "SELECT * FROM product_image WHERE ID = '".$param."' AND Enabled = 1";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => $row['ProductID'],
			'ImageURL' => $row['ImageURL'],
			'Cover' => $row['Cover'],
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/view.inc.php'),
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
			$_SESSION['productimage_'.__FUNCTION__] = "";
			
			$query_condition .= $crud->queryCondition("ProductID",$_POST['ProductID'],"=");
			$query_condition .= $crud->queryCondition("Cover",$_POST['Cover'],"=");
			
			$_SESSION['productimage_'.__FUNCTION__]['param']['ProductID'] = $_POST['ProductID'];
			$_SESSION['productimage_'.__FUNCTION__]['param']['Cover'] = $_POST['Cover'];
			
			// Set Query Variable
			$_SESSION['productimage_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['productimage_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['productimage_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['productimage_'.__FUNCTION__]))
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
		$query_count = "SELECT COUNT(*) AS num FROM product_image ".$_SESSION['productimage_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn(); 
		
		$targetpage = $data['config']['SITE_DIR'].'/admin/productimage/index';
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
		
		$sql = "SELECT * FROM product_image ".$_SESSION['productimage_'.__FUNCTION__]['query_condition']." ORDER BY ProductID ASC, Cover DESC, Position ASC LIMIT $start, $limit";
		
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
			'ProductID' => ProductModel::getProduct($row['ProductID']),
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Product Images", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'productimage_delete' => $_SESSION['admin']['productimage_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.productimage_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList(), 'sort' => $sort),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['productimage_delete']);
					
		return $this->output;
	}

	public function AdminAdd() 
	{
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Create Product Image", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'productimage_add' => $_SESSION['admin']['productimage_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.productimage_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Product Image"),
		'content_param' => array('enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));
				
		unset($_SESSION['admin']['productimage_add']);
					
		return $this->output;
	}

	public function AdminAddProcess()
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"productimage");
                
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
		
		$key = "(ProductID, ImageURL, Cover, Position)";
		$value = "('".$_POST['ProductID']."', '".$file_location['ImageURL']."', '".$_POST['Cover']."', '".$_POST['Position']."')";

		$sql = "INSERT INTO product_image ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Creating Product Image...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}

	public function AdminEdit($param) 
	{
		$sql = "SELECT * FROM product_image WHERE ID = '".$param."'";
	
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
			'ProductID' => $row['ProductID'],
			'ImageURLCover' => $cover_image,
			'ImageURL' => $row['ImageURL'],
			'Cover' => $row['Cover'],
			'Position' => $row['Position']);
			
			$i += 1;
		}

		$this->output = array( 
		'config' => $this->config,
		'page' => array(
					'title' => "Edit Product Image",
					'template' => 'admin.common.tpl.php',
					'custom_inc' => 'on',
					'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php',
					'productimage_add' => $_SESSION['admin']['productimage_add'], 
                    'productimage_edit' => $_SESSION['admin']['productimage_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.productimage_common.inc.php'),
		'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Product Image"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList(), 'product_list' => ProductModel::getProductList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['productimage_add']);
		unset($_SESSION['admin']['productimage_edit']);
					
		return $this->output;
	}

	public function AdminEditProcess($param) 
	{
		// Handle Image Upload
        $upload['ImageURL'] = File::uploadFile('ImageURL',1,2,"productimage");
                
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
		
		$sql = "UPDATE product_image SET ProductID='".$_POST['ProductID']."', ImageURL='".$file_location['ImageURL']."', Cover='".$_POST['Cover']."', Position='".$_POST['Position']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
					
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Editing Product Image...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));
					
		return $this->output;
	}
	
	public function AdminDelete($param) 
	{
		// Delete Images
        $crud = new CRUD();

        $sql = "SELECT * FROM product_image WHERE ID = '".$param."'";
        
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
		$sql = "DELETE FROM product_image WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);
		
		// Set Status
        $ok = ($count==1) ? 1 : "";
		
		$this->output = array( 
		'config' => $this->config,
		'page' => array('title' => "Deleting Product Image...", 'template' => 'admin.common.tpl.php'),
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
            $sql = "UPDATE product_image SET Position='".$i."' WHERE ID='".$id."'";
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

        $sql = "SELECT * FROM product_image WHERE ID = '".$param."'";
        
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

	public function getProductImageCover($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM product_image WHERE Cover = 1 AND ProductID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ImageURL' => Image::getImage($row['ImageURL']));
			
			$i += 1;
		}
		
		$result = $result[0]['ImageURL'];
		
		if ($result=="")
		{
			$sql = "SELECT * FROM product_image WHERE ProductID = '".$param."' ORDER BY Position ASC LIMIT 0,1";
			
			$result = array();
			$i = 0;
			foreach ($this->dbconnect->query($sql) as $row)
			{
				$result[$i] = array(
				'ID' => $row['ID'],
				'ImageURL' => Image::getImage($row['ImageURL']));
				
				$i += 1;
			}
			
			$result = $result[0]['ImageURL'];		
		}
		
		return $result;
	}
	
	// Get all active product images for a specific product
	public function getProductImageGroup($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM product_image WHERE ProductID = ".$param." ORDER BY Cover DESC, Position ASC, ID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ImageURL' => $row['ImageURL'],
			'ImageURLThumb' => Image::getImage($row['ImageURL'],'thumb'),
			'ImageURLMedium' => Image::getImage($row['ImageURL']));
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
	
	public function AdminExport($param) 
	{		
		$sql = "SELECT * FROM product_image ".$_SESSION['productimage_'.$param]['query_condition']." ORDER BY ProductID ASC";
		
		$result = array();
		
		$result['filename'] = $this->config['SITE_NAME']."_Product Image";
		$result['header'] = $this->config['SITE_NAME']." | Product Image (" . date('Y-m-d H:i:s') . ")\n\nID, Product, ImageURL, Cover, Position";
		$result['content'] = '';
		
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".ProductModel::getProduct($row['ProductID'])."\",";
			$result['content'] .= "\"".$row['ImageURL']."\",";
			$result['content'] .= "\"".CRUD::isActive($row['Cover'])."\",";
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

	public function getProductImage($param) 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM product_image WHERE ID = '".$param."'";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => ProductModel::getProduct($row['ProductID']),
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$result = $result[0]['ProductID'];
		
		return $result;
	}

	public function getProductImageList() 
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM product_image ORDER BY ProductID ASC";
		
		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'ProductID' => ProductModel::getProduct($row['ProductID']),
			'ImageURL' => $cover_image,
			'Cover' => CRUD::isActive($row['Cover']),
			'Position' => $row['Position']);
			
			$i += 1;
		}
		
		$result['count'] = $i;

		return $result;
	}
}
?>