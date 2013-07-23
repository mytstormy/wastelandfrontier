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

		include 'mods/userinfo.php';
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
include 'banner.php';
?>
</div>

<div id="nav">
  <p>
      <?php
include 'nav.php';
?>

  </p>

</div>

<div id="content">
  <p>
    <?php
include 'content.php';
?>
</p>
  <p>Yeah, if my plan has worked, there should be some stuff in here... we'll see :)<br />
Like... it should look like a map... </p>
  <p>&nbsp;</p>
<p>Testing the map without building the table in...</p>
<?php
/*
@Author = Kent Savage
*/

// turn this next section into the map_inc
		include 'mods/map_inc.php';
		
// what this include does, where it gets its info from...
// builds the main map page including navigation around the map or movment on it.
// gets ship location from the included file shipinfo.php 
// and user info from the included file userinfo.php


// this include should contain the method of getting the info for each cell of the map it builds.
// also all the methods for moving a vehicle or ship... via instant, timed, or waypoint/timed multiple destination...




// check to see if they have a vehicle on the map - if so, start with it's location, if not - return an error...
		include 'mods/vehicleinfo.php';
		include 'mods/travel_inc.php';
		
		
			if ($vehiclestatus == 'Active') {
				// see the variables in the include above
				}else{
					// need to be able to display an error message somewhere... perhaps right here :)
				$errormessage='Sorry, it seems as if you do not have an active vehicle.  Its possible however that you accidentally have more than one Active, which would also result in this error.  Please activate a vehicle, or failing that, contact an admin or a moderator.  Thankyou.';
				echo $errormessage;
				}

// get any destination ?  -> need to decide how to handle that... where does the ship show up when it is in route somewhere...??

		// $dest_x and $dest_y come from the vehicle info include.



// get the size of the map to build from the user's profile or skill - either or...  $user_map_size is in the userinfo.php include
// depending on the source of this var - could infer the scan radius as well? perhaps....

			if ($user_map_size > 0) {

	$mapsize = $user_map_size;
	$mapstart_x = $vehicle_loc_x - $mapsize;
	$mapend_x = $vehicle_loc_x + $mapsize;
	$mapstart_y = $vehicle_loc_y + $mapsize;
	$mapend_y = $vehicle_loc_y - $mapsize;
	$mapwhile_x = $mapstart_x;
	$mapwhile_y = $mapstart_y;
	
	// terrain types - pulled from the z value should match up to these - will note it in the db... or should...
	// array ... yeah
	
	$imgprearray = array(
		1 => 'desert',
		2 => 'mountain',
		3 => 'canyon',
		4 => 'oasis',
		5 => 'plains',
		6 => 'forest',
	);
	
		// Map Test
		
		// with no table - just rows of the images.
		echo '<p>';
	// Y-while	
	while ($mapend_y <= $mapwhile_y){
		//echo '<tr>';
	// X-while
	while ($mapend_x >= $mapwhile_x){
		//echo '<td>';
	$query1 = "SELECT * FROM tbl_map WHERE map_loc_x = '$mapwhile_x' and map_loc_y = '$mapwhile_y' order by map_loc_y ASC, map_loc_x ASC";
    $queryResult1 =  mysql_query($query1);
	$links = mysql_fetch_array($queryResult1);
	// set the image pre name for the cell
	$terraintype = $links[map_loc_z];
	if ($terraintype == 0){$terraintype = 1; }
	$imgpre = $imgprearray[$terraintype];
	// check to see if the cell in question is the current location - set image extension to reflect that
	if(($mapwhile_x == $vehicle_loc_x) && ($mapwhile_y == $vehicle_loc_y)){
		$imgextension = "-s-c";
		}elseif(($mapwhile_x == $dest_x) && ($mapwhile_y == $dest_y)){
		$imgextension = "-s-d";
		}else{
			$imgextension = "-s";
			}
	// let the query fill the maps part w/ data...
	
	echo '<a href="celldetail.php?loc_x='.$links[map_loc_x].'&loc_y='.$links[map_loc_y].'"><img src="img/'.$imgpre.''.$imgextension.'.jpg" alt="'.$links[map_loc_x].'/'.$links[map_loc_y].'"></a>';
	
		//echo '</td>';
		$mapwhile_x = $mapwhile_x+1;
	} // end X-while
		//echo '</tr>';
		echo '<br />';
		$mapwhile_x = $mapstart_x;
		$mapwhile_y = $mapwhile_y-1;
		} // end Y-while
		
		
		echo '</p>';  // end of table.
			}


		
?>
<p>&nbsp;</p>
<p>trying to build the table without running a query for each cell...  not sure how i'll do that yet.. perhaps an array that is set by how large the map should be, then checking first the array pulling from the database.  (which should hold only those cells which are NOT desert...)  (because the default terrain type is desert...)   then after checking that array - if it is not listed - it is desert?  i'll have to try somet things with arrays...</p>
<p>Yeah... fought it for 3 days, not worth the time right now... will have to revisit this...</p>

      <div id="footer">
      <?php
      include 'footer.php';
      ?> 
      </div>


</div>
<div id="statbar">
  <p>
      <?php
include 'statbar.php';
?>

  </p>
</div>

</body>
</html>
