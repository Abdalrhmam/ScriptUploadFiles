<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<div class="table-responsive <?php echo ClassAnimated ?> swing">
  <table class="table table-hover">
    <tbody>	
<?php 
//$DownloadID    = protect(base64_decode($_GET['download']));
//$info  = Sql_Get_info($DownloadID);
//$DownloadID   = (is_numeric($_GET['download'])) ? (int)$_GET['download'] : protect(base64_decode($_GET['download']));
$_crypt_id  = "'".base64_encode($DownloadID)."'";

$Continue   = false;

function isPublic($status){global $lang;  return ($status)? '<code>'.$lang[176].'</code>' : '<code>'.$lang[177].'</code>';}

$confirm  = (isset($_GET['confirm'])) ? true : false ;
$notfound = (isset($_GET['notfound'])) ? true : false ;
$referrer = (isset($_SERVER['HTTP_REFERER'])) ? base64_encode($_SERVER['HTTP_REFERER']) : "";
$string   = (!isset($_SESSION['settings']['files'][$DownloadID])) ? GenerateRandomString() : $_SESSION['settings']['files'][$DownloadID];
(!isset($_SESSION['settings']['files'][$DownloadID])) ? $_SESSION['settings']['files'][$DownloadID]	= $string : '';
			
//print_r($info);

if(!empty($info['password']))
{
	if(isset($_SESSION['settings']['passwordfiles'][$DownloadID]))
		$Continue = ( $_SESSION['settings']['passwordfiles'][$DownloadID] == $info['password'] )  ? true : false ;	
} else 
	$Continue = true;	
	
/*--------------------------------------*/	
if (!$info["status"] && $confirm )
	echo '<tr><td colspan="2"><i class="glyphicon glyphicon-question-sign"></i> '.$lang[197].'.</td></tr>';

elseif(!$info["status"] && $notfound )
	echo '<tr><td colspan="2"><i class="glyphicon glyphicon-question-sign"></i> '.$lang[46].'.</td></tr>';

elseif(!$info['status'])
	echo '<tr><td colspan="2"><h2>'.$lang[46].'</h2></td></tr>';

elseif(!$info['public'] && (UserID !== $info['user_id']) )
    echo '<tr><td colspan="2"><h2>'.$lang[177].'</h2></td></tr>';
	
/*elseif(!IsLogin)
     echo '<tr><td colspan="2"><h2>'.$lang[49].'.</h2></td></tr>';	*/
	 
elseif(!$Continue)
    include_once('filepass.php');
		
elseif (!$info["isfile"])
	echo '<tr><td colspan="2"><h2>'.$lang[46].'.</h2></td></tr>';
	

else
	{
	echo 
	  '<tr>
        <th>'.$lang[35] .'</th>
        <td><mark id="userTD">'.$info["username"].'</mark></td>
      </tr>'; 
	  if(thumbnail && $info["thumbnail"])
		  echo
	  '<tr>
        <th>'.$lang[172]  .'</th>
        <td><img id="thumbnail_dir" src=".'.$info["thumbnail_dir"].'" class="img-thumbnail" alt=""></td>
      </tr>';
		   
      echo
	 '<tr>
        <th>'.$lang[36] .'</th>
        <td id="orgfilenameTD">'.icon($info["filename"]).' '.$info["orgfilename"].' / ( '.isPublic($info['public']).' ) </td>
      </tr>
	  
	  <tr>
        <th>'.$lang[33] .'</th>
        <td id="dateTD">'.time_elapsed_string(date('Y-m-d H:i:s',$info["date"])).'</td>
      </tr>	 
	  
	  <tr>
        <th>'.$lang[34] .'</th>
        <td id="downloadcountTD">'.$info["download"].'</td>
      </tr>
	  
	  <tr>
        <th>'.$lang[42] .'</th>
        <td id="sizeTD"><span class="label label-default">'.FileSizeConvert($info["size"]).'</span></td>
      </tr> 
	  
	  <tr>
        <th>'.$lang[184] .'</th>
		  <td><div id="dowloadDiv" class="btnDowload"><a href="javascript:void(0)" onclick="downloadFile('.$_crypt_id.','."'".$string."'".','."'".$referrer."'".')"><i class="glyphicon glyphicon-download-alt"></i>&nbsp;'.$lang[128].'</a></div></td>
      </tr> 
	 ';
	  	  

	if( ((IsLogin) && (UserID==$info["user_id"])) || IsAdmin ) 
		echo
     '<tr>
        <th>'.$lang[32] .'</th>
        <td><div id="deleteDiv"><a href="javascript:void(0)" onclick="deleteFile2('.$DownloadID.','."'".$info["deleteHash"]."'".','."'".$info["filename"]."'".')"><code><i class="glyphicon glyphicon-remove"></i> '.$lang[32].'</code></a></div></td>
      </tr>';
	 
	 echo 
	 '<tr>
        <th>'.$lang[82] .'</th>
        <td>
		<div id="reportDiv">
		 <div class="dropup">
		     <a href="javascript:void(0)" data-toggle="dropdown"><code><i class="glyphicon glyphicon-thumbs-down"></i> '.$lang[82].' <span class="caret"></span></code></a>
		    <ul class="dropdown-menu">
		       <li><a href="javascript:void(0)" onclick="reportFile('.$DownloadID.',1)" >'.$lang[201].'</a></li>
		       <li><a href="javascript:void(0)" onclick="reportFile('.$DownloadID.',2)" >'.$lang[202].'</a></li>
		       <li><a href="javascript:void(0)" onclick="reportFile('.$DownloadID.',3)" >'.$lang[203].'</a></li>
			   <li><a href="javascript:void(0)" onclick="reportFile('.$DownloadID.',4)" >'.$lang[204].'</a></li>
		    </ul>
		  </div>
		 </div>
		 </td>
      </tr>';
	  if((IsAdmin || statistics) && ($info["download"]>0) && ($info["stats"]>0))
	 echo 
      '<tr>
        <th>'.$lang[28] .'</th>
        <td><div id="statsDiv"><a href="javascript:void(0)" onclick="StatsFile('.$DownloadID.','."'".$info["orgfilename"]."'".')" ><span><i class="glyphicon glyphicon-stats"></i> '.$lang[28].'</span></a></div></td>
      </tr>'; 
	  
	  }
//echo  '<span class="badge"><small>'.time_elapsed_string(date('Y-m-d H:i:s',Sql_Get_Last_date_Download($DownloadID))).'</small></span>';	  
//unset($DownloadID);
unset($_crypt_id);

//mysqli_close($conn);

?>

	
    </tbody>
  </table>
 </div>