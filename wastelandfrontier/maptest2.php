<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

require_once('Connections/Rebirth1.php');


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

		//if current_loc_ is empty, set it to the ship location
	if (!isset($_SESSION['current_loc_x']) || !isset($_SESSION['current_loc_y'])) {
		$_SESSION['current_loc_x'] = $ship_loc_x;
		$_SESSION['current_loc_y'] = $ship_loc_y;
		}
		//if center_loc_ is empty, set it to the ship location
	if (!isset($_SESSION['center_loc_x']) || !isset($_SESSION['center_loc_y'])) {
		$_SESSION['center_loc_x'] = $ship_loc_x;
		$_SESSION['center_loc_y'] = $ship_loc_y;
		}
		
		$current_loc_x = $_SESSION['current_loc_x'];
		$current_loc_y = $_SESSION['current_loc_y'];
		$center_loc_x = $_SESSION['center_loc_x'];
		$center_loc_y = $_SESSION['center_loc_y'];
		
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = "SELECT * FROM tbl_map WHERE map_loc_x =  '$current_loc_x' and map_loc_y = '$current_loc_y'";
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
Lets see.... i'm not sure where to begin... but i might as well start somewhere...<br />
You are currently at: <font color="purple"> <?php echo $fiel_name; ?></font>
<br />
To reset to ship loc : <a href="maptest2_edit.php?reset=1">Reset to Ship Loc</a><br />
<br />
<table width="140" height="140" border="1" bordercolor="#003333">
<tr>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y+2;
  ?></td>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><a href="maptest2_edit.php?x=-1&amp;y=1"><img src="img/diagul.gif" alt="Up and Left" /></a></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y+1;
  ?>
  <a href="maptest2_edit.php?x=0&amp;y=1"><img src="img/up.gif" alt="Up" /></a>
  </td>
  <td nowrap="nowrap"><a href="maptest2_edit.php?x=1&amp;y=1"><img src="img/diagur.gif" alt="Up and Right" /></a></td>
  <td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"><?php
  print $center_loc_x-2;
  echo ", ";
  print $center_loc_y;
  ?></td>
  <td nowrap="nowrap">  <a href="maptest2_edit.php?x=-1&amp;y=0"><img src="img/left.gif" alt="left" /></a>
<?php
  print $center_loc_x-1;
  echo ", ";
  print $center_loc_y;
  ?>
  </td>
  <td nowrap="nowrap"><font color="green">
    <?php 
  //so lets start with code for where you are... and go from there...
  echo "Welcome to $center_loc_x, $center_loc_y."; 
  
  ?>
  </font><br />
  <br />
  
    <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
    <table width="30" border="1" cellpadding="1">
      <tr>
        <td><a href="maptest2_edit.php?insert=1">Desert</a></td>
        <td><a href="maptest2_edit.php?insert=2">Forest</a></td>
      </tr>
      <tr>
        <td><a href="maptest2_edit.php?insert=3">Plains</a></td>
        <td><a href="maptest2_edit.php?insert=4">Mountain</a></td>
      </tr>
      <tr>
        <td><a href="maptest2_edit.php?insert=5">Water</a></td>
        <td><a href="maptest2_edit.php?insert=6">Ocean</a></td>
      </tr>
        </table>
    <?php } // Show if recordset empty ?></td>
  <td nowrap="nowrap">
  <?php
  print $center_loc_x+1;
  echo ", ";
  print $center_loc_y;
  ?>
  <a href="maptest2_edit.php?x=1&amp;y=0"><img src="img/right.gif" alt="Right" /></a>
  </td>
  <td nowrap="nowrap"><?php
  print $center_loc_x+2;
  echo ", ";
  print $center_loc_y;
  ?></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><a href="maptest2_edit.php?x=-1&amp;y=-1"><img src="img/diagdl.gif" alt="Down and Left" /></a></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y-1;
  ?>
  <a href="maptest2_edit.php?x=0&amp;y=-1"><img src="img/down.gif" alt="Down" /></a>
  </td>
  <td nowrap="nowrap"><a href="maptest2_edit.php?x=1&amp;y=-1"><img src="img/diagdr.gif" alt="Down and Right" /></a></td>
  <td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y-2;
  ?></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"></td>
</tr>
</table>


<p><a href="admin.php">Admin Page</a> <br />  
<a href="mapedit.php">Map Edit Page</a> </p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
codebase="http://download.macromedia.com/pub/
shockwave/cabs/flash/swflash.cab#version=7,0,0,0"
width="550" height="300" id="zoom_map" align="top">
<param name="movie" value="us_albers.swf?data_file=senate.xml" />
<param name="quality" value="high" />
<param name="bgcolor" value="#FFFFFF" />
<embed src="us_albers.swf?data_file=senate.xml" quality="high" bgcolor="#FFFFFF"
width="550" height="300" name="Clickable World Map" align="top" 
type="application/x-shockwave-flash" 
pluginspage="http://www.macromedia.com/go/getflashplayer">
</embed>
</object>


<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>



