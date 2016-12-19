<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<div id="menu" class="col-sm-3 col-md-3 <?php echo ClassAnimated ?> bounceInDown">
	<div class="collapse navbar-collapse" id="sideNavbar">
      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="glyphicon glyphicon-home"></i> <?php echo $lang[21]?></a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse <?php if(GetIsEmpty || isset($_GET['plans']) || isset($_GET['contact']) || isset($_GET['download']) ) echo ' in';?>">
            <div class="list-group">
			  <a class="list-group-item<?php echo GetIsEmpty ? ' active' : '';?>" href="./"  ><i class="glyphicon glyphicon-cloud-upload"></i> <?php echo $lang[1]?></a>
			  <?php if(isset($_GET['download'])) {?>
			  <a href="javascript:void(0)"  class= "list-group-item active"  ><i class="glyphicon glyphicon-download-alt"></i> <?php echo $lang[128]?></a>
			  <?php }?>
			  <a class="list-group-item<?php actv2('contact') ?>" href="?contact"><i class="glyphicon glyphicon-envelope"></i> <?php echo $lang[22]?></a>
			  <a class="list-group-item<?php actv2('plans') ?>" href="?plans"><i class="glyphicon glyphicon-usd"></i> <?php echo $lang[230]?></a>

            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><i class="glyphicon glyphicon-user"></i> <?php echo $lang[192]?> </a> 
            </h4>
          </div>
          <div id="collapseFour" class="panel-collapse collapse <?php if( isset($_GET['register']) ||  isset($_GET['forgot']) || isset($_GET['files']) || isset($_GET['login']) || isset($_GET['profile']) || isset($_GET['authorized']) ) echo ' in';?>">
            <div class="list-group">
           
			   <?php if(IsLogin) {?>
			   <a class="list-group-item <?php actv2('files')?>" href="?files" ><i class="glyphicon glyphicon-hdd"></i> <?php echo $lang[50]?></a>
			   <a class="list-group-item<?php actv2('profile')?>" href="?profile" ><i class="glyphicon glyphicon-user"></i> <?php echo $lang[30]?></a>
			   <?php  if(IsAdmin) {?>
			   <a class="list-group-item" href="./admin"><code><i class="glyphicon glyphicon-tasks"></i></code> <?php echo $lang[75] ?></a>
			   <?php } //_is_admin ?>
			   <?php } else { if(register){?>
			   <a class="list-group-item<?php actv2('register') ?>" href="?register" ><i class="glyphicon glyphicon-user"></i> <?php echo $lang[39]?></a>
			   <?php } //register ?>
			   <a class="list-group-item <?php actv2('login') ; actv2('authorized'); ?>" href="?login"><i class="glyphicon glyphicon-log-in"></i> <?php echo $lang[20]?></a>  
			   <?php } //end else _is_login?>
			   
			   <?php if(!IsLogin && isset($_GET['forgot']) ) {?>
			   <a class="list-group-item active" href="javascript:void(0)" ><i class="glyphicon glyphicon-lock"></i> <?php echo $lang[41]?></a>
			   <?php } //_is_login ?>
			   
			   <?php if(IsLogin) {?>
			   <a class="list-group-item" href="javascript:void(0)" data-toggle="modal" data-target="#LogoutModal"><i class="glyphicon glyphicon-log-out"></i> <?php echo $lang[27]?></a>
			   <?php } //_is_login ?>

            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><i class="glyphicon glyphicon-globe"> </i> <?php echo $lang[193]?> </a>
            </h4>
          </div>
          <div id="collapseFive" class="panel-collapse collapse <?php if( isset($_GET['about'])) echo ' in';?>">
		      <a class="list-group-item" id="about1" href="javascript:void(0)" onclick="showPrivacy()"><i class="glyphicon glyphicon-chevron-<?php directionDiv(); ?>"></i> <?php echo $lang[153]?></a>
              <a class="list-group-item" id="about2" href="javascript:void(0)" onclick="showTerms()"><i class="glyphicon glyphicon-chevron-<?php directionDiv(); ?>"></i> <?php echo $lang[152]?></a>
              <a class="list-group-item  <?php actv2('about')?>" id="about3" href="javascript:void(0)" onclick="showAbout()" ><i class="glyphicon glyphicon-info-sign"></i> <?php echo $lang[19]?></a>
          </div>
        </div>
      </div>
   </div>
</div>
    