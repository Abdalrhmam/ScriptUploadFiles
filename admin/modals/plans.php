<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<!-- <p><?php echo SiteName() ?></p> -->   
<div class="table-responsive">      
  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="active"></th>
		<th><?php echo $lang[226]?></th>
		<th><?php echo $lang[235]?></th>
        <th><?php echo $lang[227]?></th>
		<th><?php echo $lang[228]?></th>
      </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
  </table>
 </div>  
    <div id="page-selection"></div>
