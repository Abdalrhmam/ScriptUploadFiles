<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php
define('IsArabicLang',($lang[0]=='ar') ? true : false )	;
if(isset($_GET['reset']))
{
	resetPassword($_GET['reset']);
	exit(header('Location: ./'));
}
	
(isset($_GET['file'])) ? forceDownload($_GET['file']) : '';
(isset($_GET['view'])) ? forceView($_GET['view']) : '';

if(!IsLogin)
	(defined('authorized') && authorized && empty($_GET)) ? exit(header('Location: ./?authorized')) : '';
	
if(isset($_GET['delete']))
	(delete_file($_GET['id'],$_GET['delete'],'.')) ? exit(header('Location: ./?download=deleteFile&confirm')) : exit(header('Location: ./?download=deleteFile&notfound'));	
		
define('PageTitle'      , Get_Page_Title()) ; 
define('ContainerTitle' , get_main_title()) ; 
delete_file_older_than( 0 , days_older , '.');
?>