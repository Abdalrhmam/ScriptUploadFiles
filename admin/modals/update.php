<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php 
define('url_json_file',base64_decode('aHR0cDovL21hZ2RpZWlkLmNvbS91cC91cGRhdGUvdXBkYXRlLmpzb24='));
define('tmpZip_file','../tmp.zip');/*مكان تخزيا الملف المؤقت*/
define('extract_dir','../');/*مسار فك الضغط*/

if(isset($_SESSION['settings']['update']['url']))
	define('url_zip_file',$_SESSION['settings']['update']['url']);

if(isset($_SESSION['settings']['update']['version']))
	define('update_version',$_SESSION['settings']['update']['version']);
?>
<div class="table-responsive">
  <table class="table table-hover">
 <tbody>
 <tr> <th><?php echo $lang[134]?> </th> <td><code><?php echo sitename();?></code></td> </tr>
 <tr> <th><?php echo $lang[12]?>  </th> <td><?php echo base64_decode('PGNvZGU+b25leGl0ZTwvY29kZT4=');?></td> </tr> 
 <tr> <th><?php echo $lang[72]?>  </th> <td><code><?php echo sitename();?></code></td> </tr>
 <tr> <th><?php echo $lang[132]?> </th> <td><code><?php echo description;?></code></td> </tr>
 <tr> <th><?php echo $lang[5]?>   </th> <td><code><?php echo scriptversion;?></code></td> </tr>
 </tbody> 
 </table>
 </div>
    
     
	       
<?php 
if(isset($_GET['ZipArchive']))
{
	$data=extractUpdate(url_zip_file,extract_dir,tmpZip_file);
	echo $data['html'];
	unset($data);
	
    $contents = sqlUpdate(url_json_file); 
	if($contents['status'])
		{
			echo $contents['update_infos'];
			echo $contents['status_html'];
		}
		
	unset($contents);	
}
else
{
	$contents = getUpdate(url_json_file); 
	if($contents['status']) {
		echo $contents['update_infos'];
		echo $contents['status_html'];
	}
	unset($contents);
}


?>