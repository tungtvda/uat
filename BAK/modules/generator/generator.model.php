<?php
// Require required models
Core::requireModel('pagecategory');

class GeneratorModel extends BaseModel
{
	private $output = array();
    private $module_name = "Generator";
	private $module_dir = "modules/generator/";
    private $module_default_url = "/main/generator/index";
    private $module_default_admin_url = "/admin/generator/index";

	public function __construct()
	{
		parent::__construct();
	}

	public function AdminIndex()
	{

		// Page
		$sql = "SELECT * FROM page ORDER BY Title ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result_page[$i] = array(
			'ID' => $row['ID'],
			'CategoryID' => PageCategoryModel::getPageCategory($row['CategoryID']),
			'Title' => $row['Title'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Link' => $this->config['SITE_URL'].$this->config['SITE_DIR']."/main/page/".$row['FriendlyURL']);

			$i += 1;
		}

		$result_page['count'] = $i;

		// News
		$sql = "SELECT * FROM news ORDER BY Title ASC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result_news[$i] = array(
			'ID' => $row['ID'],
			'Title' => $row['Title'],
			'FriendlyURL'=> $row['FriendlyURL'],
			'Link' => $this->config['SITE_URL'].$this->config['SITE_DIR']."/main/news/".$row['ID']."-".$row['FriendlyURL']);

			$i += 1;
		}

		$result_news['count'] = $i;

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Htaccess Generator", 'template' => 'admin.common.tpl.php', 'page_run' => $_SESSION['admin']['page_run'], 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php'),
		'content' => array('page' => $result_page, 'news' => $result_news, 'blog' => $result_blog, 'event' => $result_event, 'forum' => $result_forum, 'gallery' => $result_gallery, 'product' => $result_product, 'productcategory' => $result_productcategory, 'productbrand' => $result_productbrand),
		'content_param' => '',
		'meta' => array('active' => "on"));

		if ($_SESSION['admin']['page_run']=="")
		{
			$_SESSION['admin']['page_run'] = 0;
		}

		unset($_SESSION['admin']['page_run']);

		return $this->output;
	}

	public function AdminRun()
	{
		$result = $this->Generate();

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Htaccess Generator", 'template' => 'admin.common.tpl.php'),
		#'content' => $result,
		'content_param' => array('page_run' => $result),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function Generate()
	{
		// Determine target file
		$file_target = $_SERVER["DOCUMENT_ROOT"]."/.htaccess";

		if (file_exists($file_target))
		{
			$output = file_get_contents($file_target);

            #echo "Existing Version:<br /> ".$output;
            #echo "<br /><br />";

			// Define file segments
			$custom_start_line = "#####Generated Rules START - DO NOT REMOVE#####\n";
			$custom_end_line = "#####Generated Rules END - DO NOT REMOVE#####\n";

			$output_pos['upper'] = strpos($output, $custom_start_line)+strlen($custom_start_line);
			$output_pos['lower'] = strpos($output, $custom_end_line);

            #echo "Upper Part Position:<br /> ".$output_pos['upper'];
            #echo "<br /><br />";
            #echo "Lower Part Position:<br /> ".$output_pos['lower'];
            #echo "<br /><br />";

			// Extract file segments
			$output_parts['upper'] = substr($output,0,$output_pos['upper']);
			$output_parts['center'] = substr($output,$output_pos['upper'],$output_pos['lower'] - $output_pos['upper']);
			$output_parts['lower'] = substr($output,$output_pos['lower']);

			// Generate custom content
			// Pages
			$sql_page = "SELECT * FROM page ORDER BY Title ASC";
			$content_page = '';

			foreach ($this->dbconnect->query($sql_page) as $row_page)
			{
				$content_page .= "RewriteRule ^main/page/".$row_page['FriendlyURL']."$ /main/page/view/".$row_page['ID']." [QSA,L]\n";
			}

			// News
			$sql_news = "SELECT * FROM news ORDER BY Title ASC";
			$content_news = '';

			foreach ($this->dbconnect->query($sql_news) as $row_news)
			{
				$content_news .= "RewriteRule ^main/news/".$row_news['ID']."-".$row_news['FriendlyURL']."$ /main/news/view/".$row_news['ID']." [QSA,L]\n";
			}

			// Combine new file segments
			$output_parts['center'] = $content_page.$content_news;

			// Combine new content segments
			$new_output = $output_parts['upper'].$output_parts['center'].$output_parts['lower'];

            /*echo "Upper:<br /> ".$output_parts['upper'];
            echo "<br /><br />";
            echo "Center:<br /> ".$output_parts['center'];
            echo "<br /><br />";
            echo "Lower:<br /> ".$output_parts['lower'];
            echo "<br /><br />";
            echo $new_output;
            exit();*/

			// Rewrite .htaccess file
			$file = fopen($file_target, "w");
			fwrite($file, $new_output);
			fclose($file);

			$status = 1;
		}
		else
		{
			$status = 2;
		}

		return $status;
	}
}
?>