<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<form id="register_form" role="form" onsubmit="return false;">
	
  <div class="form-group" id="RegisterResults"> </div>
	
  <div class="form-group">
    <label for="Username"><?php echo $lang[35] ?></label>
    <input type="text" id="register_username" class="form-control" name="Username" maxlength="15"  placeholder="<?php echo $lang[35] ?>" required>
  </div>
  <div class="form-group">
    <label for="Password"><?php echo $lang[37] ?></label>
    <input type="password" class="form-control" data-toggle="password" name="Password" maxlength="20" placeholder="<?php echo $lang[37] ?>" required>
  </div>
  <div class="form-group">
    <label for="Email"><?php echo $lang[40] ?></label>
    <input type="email" class="form-control" style="" maxlength="40" name="Email" placeholder="<?php echo $lang[40] ?>" required>
  </div>
  
  <?php if(EnableCaptcha){?>
  <div class="form-group">
    <img id="captcha_2" src="ajax/action.php?captcha&background=<?php echo MainColor ?>" onclick="this.src='ajax/action.php?captcha&background=<?php echo MainColor ?>&' + Math.random();" alt="captcha" style="cursor:pointer;">
	<a href="javascript:void(0)" onclick="GenerateCaptcha('<?php echo MainColor ?>');"><span class="glyphicon glyphicon-refresh"></span></a>
	<input type="text" class="captcha form-control" maxlength="4"  name="captcha" placeholder="<?php echo $lang[54] ?>">
  </div>
  <?php }?>
  <div class="form-group">
    <button type="submit" class="btn btn-primary btn-block" onclick="request('register','RegisterResults','register_form');"><?php echo $lang[39] ?></button>
  </div>
  
</form>
	