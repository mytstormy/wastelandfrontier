<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

// is the one accessing this page logged in or not?
//if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, move to login page
//	header('Location: expired.php');
//	exit;
//}

		$user_id = $_SESSION['user_id'];
		
		include 'mods/config.php';
		include 'mods/opendb.php';

		include 'mods/userinfo.php';
		// include 'mods/pagesecurity.php';
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>

<body>
<p>Yeah, something here about... </p>
<p>Please log back in or tell the site admin that you've encountered an error...</p>
<p>&nbsp;</p>
<p>And, please go to the main page to login by clicking-  <a href="index.php">here</a> </p>
<p>&nbsp;</p>
<p>and perhaps a <a href="#" onclick="MM_callJS('history.back()')">Back</a> link... </p>
</body>
</html>
