<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<?php

	$nb_total              = num_rows(Sql_query("SELECT 1 FROM `stats`")) ;
	if($nb_total==0) 
		$nb_total = 1;
	$nb_dates              = num_rows(Sql_query("SELECT distinct(FROM_UNIXTIME(`date`,'%Y-%m-%d')) FROM `stats`"));	

	$dates_totalpages      = ceil( $nb_dates / rowsperpage);
	$dates       = '';
	$uploadsdates= '';
	   $result = Sql_query("SELECT distinct(FROM_UNIXTIME(`date`,'%Y-%m-%d')) as `_date_` , count(FROM_UNIXTIME(`date`,'%Y-%m-%d')) as `_count_` FROM `stats` GROUP BY `_date_` ORDER BY `date` DESC LIMIT 15");
	while ($data = mysqli_fetch_array($result))
	{
		$chart_dates_labels.=$data['_date_'].',';
		$chart_dates_data.=$data['_count_'].','; 
		$dates.='<tr><td>'.$data['_date_'].'</td> <td><code>'.$data['_count_'].'</code></td><td>'.percent($data['_count_']/$nb_total).'</td></tr>'; 
	}
		$result = Sql_query("SELECT distinct(FROM_UNIXTIME(`uploadedDate`,'%Y-%m-%d')) as `_date_` , count(FROM_UNIXTIME(`uploadedDate`,'%Y-%m-%d')) as `_count_` FROM `files` GROUP BY `_date_` ORDER BY `uploadedDate` DESC LIMIT 15");
	while ($data = mysqli_fetch_array($result))
	{
		$chart_uploads_labels.=$data['_date_'].',';
		$chart_uploads_data.=$data['_count_'].','; 
		$uploadsdates.='<tr><td>'.$data['_date_'].'</td> <td><code>'.$data['_count_'].'</code></td><td>'.percent($data['_count_']/$nb_total).'</td></tr>'; 	
	}
	
	    $disk_free_space = function_exists('disk_free_space') ? round(@disk_free_space("/") / pow(1024,2), 2) : 0 ;
		$disk_total_space = function_exists('disk_total_space') ? round(@disk_total_space("/") / pow(1024,2), 2) : 0 ;

	?>

 <ul class="ds-btn">
   <div class="row">
        <li class="col-xs-12 col-md-3">
             <a class="btn btn-lg btn-primary btn-block" href="./?users">
             <i class="glyphicon glyphicon-user pull-left"></i><span><span id="t_users"><?php echo t_users ?></span><br><small class="text-color"><?php echo $lang[73]?></small></span></a>   
        </li>
		
		<li class="col-xs-12 col-md-3">
             <a class="btn btn-lg btn-primary btn-block" href="./?files">
             <i class="glyphicon glyphicon-file pull-left"></i><span><span id="t_files"><?php echo t_files ?></span><br><small class="text-color"><?php echo $lang[109]?></small></span></a> 
        </li>
		
		<li class="col-xs-12 col-md-3">
             <a class="btn btn-lg btn-primary btn-block" href="./?reports">
             <i class="glyphicon glyphicon-flag pull-left"></i><span><span id="t_reports"><?php echo t_reports ?></span><br><small class="text-color"><?php echo $lang[101]?></small></span></a> 
        </li>
		
        <li class="col-xs-12 col-md-3">
            <a class="btn btn-lg btn-primary btn-block" href="./?folders">
            <i class="glyphicon glyphicon-folder-close pull-left"></i><span><span id="t_folders"><?php echo t_folders ?></span><br><small class="text-color"><?php echo $lang[74]?></small></span></a>    
        </li>
		
		
	</div>
	<div class="row">
        <li class="col-xs-12 col-md-3">
             <a class="btn btn-lg btn-primary btn-block" href="./?statistics">
             <i class="glyphicon glyphicon-stats pull-left"></i><span><span id="t_statistics"><?php echo t_statistics ?></span><br><small class="text-color"><?php echo $lang[28]?></small></span></a> 
        </li>
		
		<li class="col-xs-12 col-md-3">
		      <a class="btn btn-lg btn-primary btn-block" href="./?comments">
		      <i class="glyphicon glyphicon-comment pull-left"></i><span><span id="t_comments"><?php echo t_comments ?></span><br><small class="text-color"><?php echo $lang[240]?></small></span></a>
        </li>
       
		<li class="col-xs-12 col-md-3">
		      <a class="btn btn-lg btn-primary btn-block" href="javascript:void(0)">
		      <i class="glyphicon glyphicon-hdd pull-left"></i><span><span id="t_size"><?php echo t_size ?></span><br><small class="text-color"><?php echo $lang[42]?></small></span></a>
        </li>
		
		<li class="col-xs-12 col-md-3">

        </li>
	</div>	
  </ul>


  

    
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[105] ;?></div>
	    <div class="panel-body">
   
   
   
     <div class="col-xs-12">
	 
	 <div class="table-responsive">
	 <table class="table">
    <thead>
      <tr>
        <th>#</th>
		<th><?php echo $lang[194]?></th>
      </tr>
    </thead>
    <tbody>
	
	  <tr>
        <td>upload_max_filesize</td>
		<td><?php echo function_exists('ini_get') ? (@ini_get('upload_max_filesize')) : '' ?></td>
      </tr>
	  
	   <tr>
        <td>post_max_size</td>
		<td><?php echo function_exists('ini_get') ? (@ini_get('post_max_size')) : '' ?></td>
      </tr>
	  
	  <tr>
        <td>memory_limit</td>
		<td><?php echo function_exists('ini_get') ? (@ini_get('memory_limit')) : '' ?></td>
      </tr>
	  
	   <tr>
        <td>max_execution_time</td>
		<td><?php echo function_exists('ini_get') ? (@ini_get('max_execution_time')) : '' ?></td>
      </tr>
	  
	  <tr>
        <td>max_input_time</td>
		<td><?php echo function_exists('ini_get') ? (@ini_get('max_input_time')) : '' ?></td>
      </tr>
	  
	   <tr>
        <td>max_file_uploads</td>
		<td><?php echo function_exists('ini_get') ? (@ini_get('max_file_uploads')) : '' ?></td>
      </tr>
	  
	   <tr>
        <td>phpversion</td>
		<td><?php echo function_exists('phpversion') ? phpversion() : '' ?></td>
      </tr>
	  
	  <tr>
        <td>mysqlversion</td>
		<td><?php echo mysqlversion() ?></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[243] ?></td>
		<td><?php echo function_exists('disk_free_space') ? FileSizeConvert(@disk_free_space("/")):'-' ?></td>
      </tr>
	  
	  <tr>
        <td><?php echo $lang[242] ?></td>
		<td><?php echo function_exists('disk_total_space') ? FileSizeConvert(@disk_total_space("/")):'-' ?></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[193] ?></td>
		<td><a target="_blank" href="<?php echo siteurl ?>"><?php echo SiteName() ?></a></td>
      </tr>
	  
	   <tr>
        <td><?php echo $lang[5] ?></td>
		<td><code><?php echo scriptversion ?></code></td>
      </tr>
	  
	  <tr>
        <td><?php echo $lang[12] ?></td>
		<td><code id="author"><?php echo 'onexite' ?></code></td>
      </tr>

	  
    </tbody>
  </table>
</div>
	 
	 </div>
  </div>
  </div>
 </div>
 
  <?php if( function_exists('disk_total_space') && function_exists('disk_free_space') ){ ?>
   <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[173] ;?></div>
	       <div class="panel-body" id="DivChartSpace">
              <canvas class="col-xs-12" style="margin-top:60px;" id="ChartSpace"></canvas>
           </div>
    </div>
 </div>
  <?php }?>
  
  <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[128] ;?></div>
	    <div class="panel-body" id="DivChartDates">
           <canvas class="col-xs-12" style="margin-top:60px;" id="ChartDates"></canvas>
        </div>
    </div>
  </div>
 
 
 <div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading"><?php echo $lang[174] ;?></div>
	       <div class="panel-body" id="DivChartUploads">
              <canvas class="col-xs-12" style="margin-top:60px;" id="ChartUploads"></canvas>
           </div>
    </div>
 </div>
