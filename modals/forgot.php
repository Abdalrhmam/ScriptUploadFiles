<?php if(!isset($conn)) die('<title>Access Denied</title><i>This page cannot be accessed directly'); ?>
<form id="forgot_form" role="form" onsubmit="return false;">

   <div class="form-group" id="ForgotResults"> </div>	   
	   
  <div class="form-group">
    <label for="email"><?php echo $lang[40] ?></label>
    <input type="text" class="form-control" name="email"  maxlength="40" placeholder="<?php echo $lang[40] ?>">
  </div>
  <?php if(EnableCaptcha){?>
    <div class="form-group">
    <img id="captcha_5" src="ajax/action.php?captcha&background=<?php echo MainColor ?>" onclick="this.src='ajax/action.php?captcha&background=<?php echo MainColor ?>&' + Math.random();" alt="captcha" style="cursor:pointer;">
	<a href="javascript:void(0)" onclick="GenerateCaptcha();"><span class="glyphicon glyphicon-refresh"></span></a>
	<input type="text" class="captcha form-control" maxlength="4"  name="captcha" placeholder="<?php echo $lang[54] ?>">
  </div>
  <?php }?>
  <div class="form-group">
   <button type="submit" class="btn btn-primary btn-block" onclick="request('forgot','ForgotResults','forgot_form');"><?php echo $lang[129] ?></button>	
  </div>
</form>


  