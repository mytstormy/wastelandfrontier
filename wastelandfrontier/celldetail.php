<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

// is the one accessing this page logged in or not?
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, move to login page
	header('Location: expired.php');
	exit;
}

		$user_id = $_SESSION['user_id'];
		
		include 'mods/config.php';
		include 'Connections/Rebirth1.php';

		include 'mods/opendb.php';

		include_once 'mods/userinfo.php';
		include 'mods/pagesecurity.php';
		
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php
include 'mods/sitename.php';
?>
</title>
<link rel="stylesheet" href="mods/gold.css" type="text/css" />

<script language="javascript"> 
function toggle2(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "show";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "hide";
	}
} 
</script>

</head>

<body>

<div id="map">
The map.
<?php
include 'minimap.php';
?>
</div>

<div id="banner">
The banner and whatnot... ofcourse.
<?php
include 'banner_inc.php';
?>
</div>

<div id="nav">
  <p>
      <?php
include 'nav_inc.php';
?>

  </p>

</div>

<div id="content">

<p>
<?php
		include 'cell_detail_inc.php';	
?>
</p>
<p>&nbsp;</p>


<div id="headerDiv">
     <div id="titleText">Random Snippets Hide/Show Div Demo - Click here ==></div><a id="myHeader" href="javascript:toggle2('myContent','myHeader');" >collapse</a>
</div>
<div style="clear:both;"></div>
<div id="contentDiv">
     <div id="myContent" style="display: block;">This is the content that is dynamically being collapsed.</div>
</div>

<p>
    <?php
include 'content.php';
?>
</p>



  <p>Should be info here now for the cell that we've clicked on... </p>
  
<p>Get the larger pic...</p>



      <div id="footer">
      <?php
      include 'footer_inc.php';
      ?> 
      </div>


</div>
<div id="statbar">
  <p>
      <?php
include 'statbar_inc.php';
?>

  </p>
</div>

</body>
</html>
