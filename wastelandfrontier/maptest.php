<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

// is the one accessing this page logged in or not?
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, move back to the index page
	header('Location: index.php');
	exit;
}

		$user_id = $_SESSION['user_id'];
		
		include 'mods/config.php';
		include 'mods/opendb.php';

		include 'mods/userinfo.php';
		include 'mods/pagesecurity.php';
		
		include 'mods/vehicleinfo.php';

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
Lets see.... i'm not sure where to begin... but i might as well start somewhere...<br />
You are currently at: <font color="purple"> <?php echo $fiel_name; ?></font>
<br />
<br />
<table width="140" height="140" border="1" bordercolor="#003333">
<tr>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"><?php
  print $ship_loc_x;
  echo ", ";
  print $ship_loc_y+2;
  ?></td>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $ship_loc_x;
  echo ", ";
  print $ship_loc_y+1;
  ?></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"><?php
  print $ship_loc_x-2;
  echo ", ";
  print $ship_loc_y;
  ?></td>
  <td nowrap="nowrap"><?php
  print $ship_loc_x-1;
  echo ", ";
  print $ship_loc_y;
  ?></td>
  <td nowrap="nowrap"><font color="green"><?php 
  //so lets start with code for where you are... and go from there...
  echo "Heya, $user_name, welcome to $ship_loc_x, $ship_loc_y.<br>
  		Ship Data: <br>
		ID#: $ship_id.<br>
		Type: $ship_type - $ship_type_name<br>
		Type Description: $ship_type_desc.<br>
		Current Destination (if any) $dest_x, $dest_y.<br>"; 
  
  
  
  ?></font></td>
  <td nowrap="nowrap">
  <?php
  print $ship_loc_x+1;
  echo ", ";
  print $ship_loc_y;
  ?>  </td>
  <td nowrap="nowrap"><?php
  print $ship_loc_x+2;
  echo ", ";
  print $ship_loc_y;
  ?></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $ship_loc_x;
  echo ", ";
  print $ship_loc_y-1;
  ?></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $ship_loc_x;
  echo ", ";
  print $ship_loc_y-2;
  ?></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
</tr>
</table>


<p>&nbsp;</p>
<p><a href="#" onclick="MM_callJS('history.back()')">Back</a></p>
</body>
</html>
