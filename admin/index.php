<?php
define('IsAdminPage',true);
require_once ('../includes/config.php');
require_once ('../includes/session.php');	
require_once ('../includes/functions.php');
require_once ('../includes/connect.php');
CheckConnect();
require_once ('../includes/lang.php');

if (isset($_GET['clearfilter'])) 
{
	unset($_SESSION['login']['filter']);
	exit(header('Location: ./' ));	
}


// get the current page or set a default

$currentpage = (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']))  ? (int) $_GET['currentpage'] : 1;

//print_r($_GET['files']);

$search_param = (isset($_SESSION['login']['filter']['search_param'])) ? $_SESSION['login']['filter']['search_param'] : '';
$order_file   = (isset($_SESSION['login']['filter']['order_file']))   ? $_SESSION['login']['filter']['order_file']   : '';	
$order_user   = (isset($_SESSION['login']['filter']['order_user']))   ? $_SESSION['login']['filter']['order_user']   : '';	
$order_comment= (isset($_SESSION['login']['filter']['order_comment']))? $_SESSION['login']['filter']['order_comment']: '';	
$order_report = (isset($_SESSION['login']['filter']['order_report'])) ? $_SESSION['login']['filter']['order_report'] : '';	
$order_folder = (isset($_SESSION['login']['filter']['order_folder'])) ? $_SESSION['login']['filter']['order_folder'] : '';	

define('AdminGetIsEmpty' , ( isset($_GET['comments']) || isset($_GET['users']) || isset($_GET['plans']) || isset($_GET['folders']) ||  isset($_GET['reports']) || isset($_GET['statistics']) || isset($_GET['update']) || isset($_GET['settings']) || isset($_GET['files']) || isset($_GET['publicity']) ) ? false : true );

function TitleHeader()
{
	global $lang,$order_file,$order_user,$search_param,$order_report,$order_folder,$order_comment;
	

if(isset($_GET['users'])) 
		 $title= $lang[73];
     elseif(isset($_GET['folders'])) 
	     $title= $lang[74]; 
	 elseif(isset($_GET['reports'])) 
	     $title= $lang[101]; 
	 elseif(isset($_GET['statistics'])) 
	     $title= $lang[28]; 	
     elseif(isset($_GET['update'])) 
	     $title= $lang[133]; 
	 elseif(isset($_GET['settings'])) 
	     $title= $lang[29];  
	 elseif(isset($_GET['files']))  
         $title= $lang[48]; 
	 elseif(isset($_GET['publicity']))  
         $title= $lang[183]; 
	elseif(isset($_GET['comments'])) 
	     $title= $lang[240] ;	
	elseif(isset($_GET['plans'])) 
	     $title= $lang[230] ;			 
	 else 
		 $title= $lang[21]; 
	 

$TitleHeader = ( $search_param=='' && ( $order_folder == '`id` DESC' || empty($order_folder) )  && ( $order_comment == '`id` DESC' || empty($order_comment) ) && ( $order_file == '`id` DESC' || empty($order_file) ) && ( $order_user == '`id` DESC' || empty($order_user) ) && ($order_report == '`id` DESC' || empty($order_report) ) ) ? $title : $title .' / <a style="font-size: 14px;" href="?clearfilter">'.$lang[81].'</a>';

echo $TitleHeader;

/*
<ol class="breadcrumb">
  <li><a href="javascript:void(0)">Home</a></li>
  <li class="active">'.$TitleHeader.'</li>
</ol>
*/
}
	
	
(!IsLogin) ? exit(header('Location: ../' )):'';	
(!IsAdmin) ? exit(header('Location: ../?notadmin' )):'';
/*-----------Charts---------*/
$chart_dates_labels='';
$chart_dates_data  = '';
$chart_uploads_labels ='';
$chart_uploads_data ='';
$disk_total_space =0;
$disk_free_space=0;	
define('t_users'     ,Sql_Get_Users_Count() );
define('t_folders'   ,num_rows(Sql_query("SELECT * FROM `folders`")) );
define('t_reports'   ,num_rows(Sql_query("SELECT * FROM `reports`")) );
define('t_comments'  ,num_rows(Sql_query("SELECT * FROM `comments`")) );
define('t_statistics',num_rows(Sql_query("SELECT DISTINCT `file_id` FROM `stats`")) );
define('t_files'     ,num_rows(Sql_query("SELECT * FROM `files` $search_param")) );
define('t_size'      ,FileSizeConvert(folderSize( '..'.folderupload )) );
define('t_reports_o' ,num_rows(Sql_query("SELECT * FROM `reports` WHERE `status` = '0'")) );
define('t_comments_o',num_rows(Sql_query("SELECT * FROM `comments` WHERE `status` = '0'")) );
if(isset($_GET['users']))  
	$totalpages = ceil(t_users / rowsperpage);  
elseif(isset($_GET['folders']))  
	$totalpages = ceil(t_folders/ rowsperpage) ;
elseif(isset($_GET['reports']))  
	$totalpages = ceil(t_reports/ rowsperpage) ;
elseif(isset($_GET['statistics']))  
	$totalpages = ceil(t_statistics/rowsperpage);   
elseif(isset($_GET['files']))  
	$totalpages = ceil(t_files/ rowsperpage) ;
elseif(isset($_GET['comments']))  
	$totalpages = ceil(t_comments/ rowsperpage) ;	
else 
    $totalpages = 1 ;	


$totalpages =  ($totalpages < 1) ? 1 : $totalpages;


/*
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
print '<pre style="text-align: left;direction: ltr; ">' . print_r(get_defined_vars(), true) . '</pre>';

*/
//echo "<script>alert('".ceil((count(array_filter(glob('../..'.folderupload.'/*'), 'is_dir')))/ rowsperpage) ."')</script>";
?>
<!DOCTYPE html>
<html lang="<?php echo InterfaceLanguage ?>">
<head>
  <title><?php echo $lang[47] ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="../assets/css/images/favicon.png"/>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
  <link href="../includes/styles.php" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../assets/css/fontello.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-toggle.min.css">  
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-checkbox.min.css">
  
  <?php if(isset($_GET['comments']) || isset($_GET['settings']) || isset($_GET['publicity']) || isset($_GET['plans']) || isset($_GET['users']) || isset($_GET['folders']) || isset($_GET['reports']) ) { ?>  
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-tagsinput.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/summernote.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-colorselector.min.css">
  <?php } ?>
  
  <?php if(animated){ ?>
<link rel="stylesheet" type="text/css" href="../assets/css/animate.min.css">
  <?php } ?>
  
  <?php /*include_once ('../includes/styles.php');*/ ?> 

  <?php if(IsRtL()){ ?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-rtl.min.css"> 
  <?php } ?>
  <style>
   .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
    background-color: #f5f5f5;
	border-color: #ddd;
	color:#777;
	}
	
    .navbar-default {
    border: 1px solid #ddd ;
	}
	
	.panel.panel-default > panel.panel-heading {
	color: #fff;
    background-color: <?php echo PanelColor ?>;
    border-color: <?php echo PanelColor ?>;

	}
	
	.panel.panel-default {
	border: 1px solid #ddd ;
	}
	
	.note-toolbar.panel-heading {
    background-color: #f5f5f5;
	border-color: #ddd;
	color:#777;
	}
  </style>
  
  	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.min.js" type="text/javascript"></script>
      <script src="../assets/js/respond.min.js" type="text/javascript"></script>
	  <script src="../assets/js/es5-shim.min.js" type="text/javascript"></script>
    <![endif]-->
	
	<!--[if IE]>
	  <link rel="shortcut icon" href="../assets/css/images/favicon.ico">
	<![endif]-->
	
 <!--<script src="../assets/js/excanvas.min.js" type="text/javascript"></script>-->
 <!-- <script src="../assets/js/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script> -->
  <script src="../assets/js/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap-checkbox.min.js" type="text/javascript"></script>
  <script src="../assets/js/jquery.bootpag.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootbox.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap-show-password.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap-maxlength.min.js" type="text/javascript"></script>
  <script src="../assets/js/global.min.js" type="text/javascript"></script>
  
  
  <?php if(isset($_GET['files']) || isset($_GET['reports']) || isset($_GET['statistics']) ) { ?>  
  <script src="../assets/js/simpleajaxuploader.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap-toggle.min.js" type="text/javascript"></script>
  <?php } ?>


  <?php if(AdminGetIsEmpty && (!IsIeBrowser())){ ?>  
  <script src="../assets/js/chart.min.js" type="text/javascript"></script> 
  <?php } ?>
  
   <?php if(AdminGetIsEmpty){ ?>
	<script src="../assets/js/countup.min.js" type="text/javascript"></script> 
  <?php } ?>
  
  <?php if(isset($_GET['comments']) || isset($_GET['settings']) || isset($_GET['publicity']) || isset($_GET['plans']) || isset($_GET['users']) || isset($_GET['folders']) || isset($_GET['reports'])  ) { ?>  
  <script src="../assets/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
  <script src="../assets/js/summernote.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap-select.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap-colorselector.min.js" type="text/javascript"></script>

  <?php if( InterfaceLanguage=='ar'){ ?>  
  <script src="../assets/js/i18n/defaults-ar_AR.js" type="text/javascript"></script>
  <script src="../assets/js/i18n/summernote-ar-AR.js" type="text/javascript"></script>
  <?php } } ?>
  
  
</head>
<body>
<div class="se-pre-con loading-spin"></div>
<div class="container">
    <div class="row">  
  
  <?php require_once ('../modals/navbar.php');?> 
  <?php require_once ('./modals/sidemenu.php');  ?>

        <div class="col-sm-9 col-md-9" id="container">	

            <div class="panel-group">
                <div class="panel panel-default">
                    <div id="Titleheader" class="panel-heading"><?php TitleHeader();?></div>
	                <div class="panel-body">
	

<?php
if(isset($_GET['users'])) 
	require_once ('./modals/users.php'); 
elseif(isset($_GET['folders'])) 
    require_once ('./modals/folders.php'); 
elseif(isset($_GET['reports'])) 
    require_once ('./modals/reports.php'); 
elseif(isset($_GET['statistics'])) 
	require_once ('./modals/statistics.php');  
elseif(isset($_GET['update'])) 
	require_once ('./modals/update.php');  
elseif(isset($_GET['settings'])) 
	require_once ('./modals/settings.php');  	
elseif(isset($_GET['files']))  
	require_once ('./modals/files.php');
elseif(isset($_GET['publicity']))  
	require_once ('./modals/postedit.php');	
elseif(isset($_GET['plans']) ) 	
	require_once ('./modals/plans.php');
elseif(isset($_GET['comments']) ) 	
	require_once ('./modals/comments.php');			
else 
	require_once ('./modals/dashboard.php');

?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  
<?php 
require_once ('./modals/search.php');   
require_once ('../modals/fileinfo.php');  
require_once ('../modals/logout.php');
require_once ('../modals/upload.php');  
require_once ('./modals/edituser.php');
(isset($_GET['plans'])) ? require_once ('./modals/editplan.php') : '';
require_once ('./modals/ipinfo.php');
require_once ('./modals/editfolder.php');
require_once ('./modals/script.php');  
?>
</body>
</html>
<?php 
mysqliClose_freeVars() ;
foreach (array_keys(get_defined_vars()) as $var) 
	        unset($$var);
unset($var);
?>