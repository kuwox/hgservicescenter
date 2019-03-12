<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE>Captcha with Refresh Functionality</TITLE>
<LINK REV="made" href="mailto:sanjoy.sw@gmail.com" />
<META NAME="keywords" CONTENT="Free PHP Captcha, Captcha with refresh,php captcha,captcha code,refresh captcha,ajax captcha,Captcha with GD" />
<META NAME="description" CONTENT="Free PHP Captcha, Captcha with refresh,php captcha,captcha code,refresh captcha,ajax captcha,Captcha with GD" />
<META NAME="author" CONTENT="Sanjoy Ganguly" />
<META NAME="ROBOTS" CONTENT="ALL" />

<script language="javascript">
/*########### Captcha Validation Part [ START ] ###############*/
function checkSubmit(){
	if(document.getElementById('captcha').value == "") {
		alert("OOPs !! Please Enter Verification Code");
		document.getElementById('captcha').focus();
		return false;
	}
		
	if(document.getElementById('cap_code').value != document.getElementById('captcha').value) {
		alert("OOPs !! Verification Code Mismatch");
		document.getElementById('captcha').focus();
		return false;
	}	
	
	if(document.getElementById('cap_code').value == document.getElementById('captcha').value) {
		alert("Success: I have passed captcha validation......")
	}
	
}
/*########### Captcha Validation Part [ END ] ###############*/
</script>
<script type="text/javascript" src="../captcha/captcha.js"></script>
</head>
<body>
<form name="captchafrm"  method="post" onsubmit="return checkSubmit();" action="">

  <table>
  
    <tr>
	
      <td>Verification Code</td>
	  
      <td><input name="captcha" id="captcha" type="text" size="10" maxlength="6" /></td>
	  
    </tr>
	
    <tr>
	
      <td>&nbsp;</td>
	  
      <td><iframe src="../captcha/php_captcha.php" id="iframe1" frameborder="0"  height="50px" width="110px" style="border: 0px;" scrolling="no" marginheight="5px" marginwidth="0px"></iframe>
        <img src="../captcha/reload_icon.png"  marginheight="0px" marginwidth="0px"  onclick="Reload();refreshCaptcha();" vspace="19"/>
        <input id="cap_code" type="hidden" name="cap_code" value="<?=$_SESSION['captcha_val']?>" />
		
      </td>
	  
    </tr>
	
    <tr>
	
      <td colspan="2" align="center"><input type="submit" name="submit" value="Submit" /></td>
	  
    </tr>
	
  </table>
  
</form>

<script language="javascript">	
	window.onload = refreshCaptcha;
</script>
</body>
</html>