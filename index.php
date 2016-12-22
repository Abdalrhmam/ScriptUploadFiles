<?php
require_once ('./includes/config.php');
require_once ('./includes/session.php');
require_once ('./includes/functions.php');
require_once ('./includes/connect.php');
require_once ('./includes/lang.php');
require_once ('./includes/csscolorgenerator.php');
require_once ('./includes/afterincludes.php');
?>
<!DOCTYPE html>
<html lang="<?php echo InterfaceLanguage ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo PageTitle ?></title>
	<meta name="description" content="<?php echo description ?>">
	<meta name="keywords" content="<?php echo keywords ?>">
	<meta name="author" id="author" content="onexite">
	
	<meta name="twitter:title" content="<?php echo PageTitle ?>"/>
	<meta name="twitter:description" content="<?php echo description ?>"/>
	<meta name="twitter:image" content="/assets/css/images/screenshot.png"/>
	
	<meta property="og:title" content="<?php echo PageTitle ?>"/>
	<meta property="og:image" content="/assets/css/images/screenshot.png"/>
	<meta property="og:description" content="<?php echo description ?>"/>

    <link rel="icon" type="image/png" href="./assets/css/images/favicon.png" />
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./assets/css/styles.css" rel="stylesheet" type="text/css">
	<link href="./assets/css/fontello.min.css" rel="stylesheet" type="text/css">
	<link href="./assets/css/sticky.min.css" rel="stylesheet" type="text/css" />
	<link href="./includes/styles.php" rel="stylesheet" type="text/css">
	<?php if(animated){ ?>
	<link href="./assets/css/animate.min.css" rel="stylesheet" type="text/css">
	<?php } ?>
	<?php if(isGet('download') || isGet('files')){ ?>
	<link href="./assets/css/famfamfam-flags.min.css" rel="stylesheet" type="text/css">
	<link href="./assets/css/platforms.min.css" rel="stylesheet" type="text/css">
	<link href="./assets/css/bootstrap-checkbox.min.css" rel="stylesheet" type="text/css">
	<?php } ?>
	<?php if(GetIsEmpty){ ?>
	<link href="./assets/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<?php } ?>
	<?php  /*include_once ('./includes/styles.php') ;*/ ?>
	<?php if(IsRtL()){ ?>
	<link href="./assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css">
	<?php } ?>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	
    <!--[if lt IE 9]>
      <script src="./assets/js/html5shiv.min.js" type="text/javascript"></script>
      <script src="./assets/js/respond.min.js" type="text/javascript"></script>
    <![endif]-->
	
	<!--[if IE]>
	  <link rel="shortcut icon" href="./assets/css/images/favicon.ico">
	<![endif]-->
	
	<!--<script src="./assets/js/excanvas.min.js" type="text/javascript"></script>-->
  </head>
  <body>
 <?php
isGet('404') ? exit(require_once ('./modals/404.php')) : '';
isGet('403') ? exit(require_once ('./modals/403.php')) : '';
 ?>

  <div class="se-pre-con loading-spin"></div>
  
<div class="container">	
  <?php require_once ('./modals/logo.php');?> 
 <div class="row">  

   <?php require_once ('./modals/navbar.php');?> 
   <?php require_once ('./modals/sidemenu.php');?> 

<div class="col-sm-9 col-md-9" id="container">	

<?php 
Get_Ads('ads_google' ) ; 
GetIsEmpty ? Get_Ads ('ads_index') : '';
isGet('download') ? Get_Ads ('ads_download') : '';
?>

  <div id="main" class="<?php echo ClassAnimated ?> bounceInDown">
 
  <div class="ribbon orange" >
    <span id="MainTitle">
    <?php 
	  echo ContainerTitle; 
	?> 
	</span>
  </div>
 
	
<div class="top70" id="htmlcontainer">

<?php
/*
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
print '<pre style="text-align: left;direction: ltr; ">' . print_r(get_defined_vars(), true) . '</pre>';
*/

if(isset($_GET['download']))
	require_once ('./modals/download.php');
elseif(isset($_GET['files']))
    ( IsLogin ) ? require_once ('./modals/files.php') : Need_Login() ;  
elseif(isset($_GET['about']))
    require_once ('./modals/about.php');
elseif(isset($_GET['profile']))	
    ( IsLogin ) ? require_once ('./modals/profile.php') : Need_Login() ;
elseif(isset($_GET['authorized']) ) 
    ( !IsLogin && authorized ) ? require_once ('./modals/authorization.php') : Need_Logout() ;  
elseif(isset($_GET['login'])) 
    ( !IsLogin  ) ? require_once ('./modals/login.php') : Need_Logout() ;  
elseif(isset($_GET['register']) ) 
    ( !IsLogin && register ) ? require_once ('./modals/register.php') : Need_Logout() ;  	
elseif(isset($_GET['forgot'])) 
    ( !IsLogin  ) ? require_once ('./modals/forgot.php') : Need_Logout() ;  
elseif(isset($_GET['contact']) ) 	
	require_once ('./modals/contact.php');
elseif(isset($_GET['plans']) ) 	
	require_once ('./modals/plans.php');
else
	require_once ('./modals/dropzone.php');

?>    
 
 </div>    <!-- htmlcontainer-->
		  		 	  
  </div>  <!--div main -->
<?php
 /* GetIsEmpty ? require_once ('./modals/totalstats.php')  : '';*/
  GetIsEmpty ? require_once ('./modals/uploadresult.php')  : '';
  isGet('download') && EnableComments ? require_once ('./modals/comments.php') : '';
?>  


  </div><!-- id container -->  
 </div> <!--div row -->
</div> <!--div container -->

  <!-- Modals -->
<?php
((IsAdmin || statistics)  && (isGet('download') || isGet('files'))) ? require_once ('./modals/stats.php')  : '';
(isGet('files')) ? require_once ('./modals/fileinfo.php')  : '';
 echo defined('SuccessfullyDeleted') ? '<div id="topalert" style="display:none;">'.SuccessfullyDeleted.'</div>' : '';
(siteclose)  ? require_once ('./modals/siteclose.php') : '';
(IsLogin)    ? require_once ('./modals/logout.php')    : '';
(GetIsEmpty) ? require_once ('./modals/links.php')     : '';
/*(GetIsEmpty) ? require_once ('./modals/upload.php')    : '';*/
?> 
 <!-- footer -->
<?php
 require_once ('./modals/footer.php');
?> 
<!-- JavaScript -->
<script type="text/javascript">
var IsLogin     = Boolean('<?php echo (bool)IsLogin ?>'),
    IsAdmin     = Boolean('<?php echo (bool)IsAdmin ?>'),
    IsClose     = Boolean('<?php echo (bool)siteclose ?>'),
	IsRtL       = Boolean('<?php echo (bool)IsRtL() ?>'),
	IsDirect    = Boolean('<?php echo (bool)directdownload ?>'),
	IsThumbnail = Boolean('<?php echo (bool)thumbnail ?>'),
	IsAnimated  = Boolean('<?php echo (bool)animated ?>'),
	IsFooterInfo= Boolean('<?php echo (bool)FooterInfo ?>'),
	multiple    = Boolean('<?php echo (bool)multiple ?>'),
	IsGetEmpty  = Boolean('<?php echo (bool)GetIsEmpty ?>'),
	IsCaptcha   = Boolean('<?php echo (bool)EnableCaptcha ?>'),
	DirectoryChanged  = Boolean('<?php echo (bool)DirectoryChanged ?>'),
    UpdateBrowser  = Boolean('<?php echo (bool)UpdateBrowser ?>'),
	IsGetFiles     = Boolean('<?php echo (bool)(isGet('files')) ?>'),
	IsGetProfile   = Boolean('<?php echo (bool)(isGet('profile')) ?>'),
	IsGetDownload  = Boolean('<?php echo (bool)(isGet('download')) ?>'),
	IsGetRegister  = Boolean('<?php echo (bool)(isGet('register')) ?>'),
	IsGetAbout     = Boolean('<?php echo (bool)(isGet('about')) ?>'),
	IsGetAuth      = Boolean('<?php echo (bool)(isGet('authorized')) ?>'),
	IsGetLogin     = Boolean('<?php echo (bool)(isGet('login')) ?>'),
	IsGetForgot    = Boolean('<?php echo (bool)(isGet('forgot')) ?>'),
	IsGetContact   = Boolean('<?php echo (bool)(isGet('contact')) ?>'),
	extensions_str = '<?php echo defined('Extensions_Str') ? Extensions_Str : '' ?>',

	
	filetypes   = [ <?php echo "'".implode(explode(",",extensions),"','")."'" ?>],   
    configSize  = parseInt('<?php echo MaxFileSize /1024 ?>'),
    TimeLoading = parseInt('<?php echo Interval ?>'),
	maxUploads  = parseInt('<?php echo maxUploads; ?>'),
	directionDiv= '<?php directionDiv(); ?>',
	DateLbl     = '<?php echo $lang[84] ?>',
	siteurl     = '<?php echo SERVER_HOST ?>',
	_path_      = '<?php echo siteurl ?>',
	SELF        = '<?php echo SELF ?>',
	QUERY       = '<?php echo QUERY ?>',
	HashCode    = '<?php echo HashCode ?>',
	Language    = '<?php echo InterfaceLanguage ?>',
	Loading     = '<?php echo $lang[45] ?>',
	confirmMsg  = '<?php echo $lang[154] ?>',
	ErrorMsg    = '<?php echo $lang[14] ?>',
	PleaseWait  = '<?php echo $lang[102] ?>',
	ErrorSending= '<?php echo $lang[103] ?>',
	UploadingMsg= '<?php echo $lang[11] ?> ..',
	ChooseOMsg  = '<?php echo $lang[13] ?>',
	DragMsg     = '<?php echo $lang[7] ?>',
	DownloadWait= '<?php echo $lang[76] ?> <code id="time">5</code> <?php echo $lang[77] ?>',
    uploadDir   = '<?php echo uploadDir.'/'; ?>',
	ErrorHMsg   = '<?php echo $lang[17] ?>',
	UnableMsg   = '<?php echo $lang[15] ?>',
	UploadedMsg = '<?php echo $lang[16] ?>',
	ExtErrMsg   = '<?php echo $lang[120] ?>',
	FilesMsg    = '<?php echo $lang[109] ?>',
	ErrorSzMsg  = '<?php echo $lang[110] ?>', 
	ErrorAborted= '<?php echo $lang[233] ?>', 
	ExtensionsSt= '<?php echo extensions ; ?>',
	UrlMsg      = '<?php echo $lang[18] ?>', 
	TitleClsMsg = '<?php echo $lang[64] ?>', 	
	UrlDeltMsg  = '<?php echo $lang[26] ?>', 
	UrlViewMsg  = '<?php echo $lang[164] ?>', 
	UrlthumMsg  = '<?php echo $lang[172] ?>', 
	DownLoadMsg = '<?php echo $lang[184] ?>', 
	ActionLabel = '<?php echo $lang[43]?>',
	CopyLabel   = '<?php echo $lang[146] ?>', 
	UrlDrktMsg  = '<?php echo $lang[51] ?>',
	BrowserUpd  = '<?php echo $lang[163] ?>',
	UrlChanged  = '<?php echo $lang[195] ?>',
	RefLabel    = '<?php echo $lang[161] ?>',
	PassLabel   = '<?php echo $lang[37] ?>',
	queueLabel  = '<?php echo $lang[180] ?>',
	deleteLabel = '<?php echo $lang[32] ?>',
	Numberlbl   = '<?php echo $lang[157] ?>',
	_Yes        = '<?php echo $lang[104] ?>',
	_No         = '<?php echo $lang[156] ?>',
	PublicLbl   = '<?php echo $lang[176] ?>',
	PrivateLbl  = '<?php echo $lang[177] ?>',
	LblSuccessDeleted = '<?php echo $lang[197] ?>',
	WellColor   = '<?php echo defined('WellColor') ? WellColor : 'ffffff' ?>',
	MainColor   = '<?php echo MainColor ?>',
    _maxVisible = 10,	
	FilesTotal  = 0,
	LoadJsCheckbox = false,
	myChart     = null;
	
	
if (IsLogin) { 		
var currentpage = parseInt('<?php  echo $currentpage ?>') ,
    totalpages  = parseInt('<?php  echo $totalpages ?>') ,
	rowsperpage = parseInt('<?php echo rowsperpage ?>') ; 
} 
</script>
    <!--<script src="./assets/js/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>-->
	<!--<script src="./assets/js/jquery-ui.min.js" type="text/javascript"></script>-->
	<script src="./assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/js/bootstrap.min.js" type="text/javascript"></script> 
	<script src="./assets/js/sticky.min.js" type="text/javascript"></script>	
	<?php if(GetIsEmpty){ ?>
<script src="./assets/js/simpleajaxuploader.min.js" type="text/javascript"></script>
	<script src="./assets/js/bootstrap-toggle.min.js" type="text/javascript"></script>
	<script src="./assets/js/countup.min.js" type="text/javascript"></script> 
	<?php } ?>
	
	<?php if(isGet('download') || isGet('files')){ ?>
<script src="./assets/js/jquery.bootpag.min.js" type="text/javascript"></script>
<script src="./assets/js/bootstrap-checkbox.min.js" type="text/javascript"></script>



   <?php if(!IsIeBrowser()){ ?>
   <script src="./assets/js/chart.min.js" type="text/javascript"></script> 
   <!--<script src="./assets/js/highcharts.js" type="text/javascript"></script> -->
   <?php } ?>
	
	<?php } ?>
<script src="./assets/js/bootbox.min.js" type="text/javascript"></script>
	<script src="./assets/js/bootstrap-show-password.min.js" type="text/javascript"></script>
	<script src="./assets/js/bootstrap-maxlength.min.js" type="text/javascript"></script>
	<script src="./assets/js/global.min.js" type="text/javascript"></script>
	<script src="./assets/js/functions.min.js" type="text/javascript"></script>
  </body>
</html>
<?php 
mysqliClose_freeVars() ;
foreach (array_keys(get_defined_vars()) as $var) 
	        unset($$var);
unset($var);

?>