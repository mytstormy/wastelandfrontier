<?php
	//use session variables to set and display the center of the current map - that can be used to move perspective on the current map.
	//also use session var to set and display your current location in relation to the current map.
	//use if clauses to insert, update or change each cell on the map.


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
		
?>
<script type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
 <p>Ok, so this is where all the magic should happen? I guess... lol
   <br />
You are currently at: <font color="purple"> <?php echo $fiel_name; ?></font></p>
 <p>Testing a reset function... &gt;.&gt; here - <a href="movemapedit.php?reset=1">Reset to Ship Loc</a></p>
 <style type="text/css">
<!--
.style2 {font-size: 11px}
-->
</style>
<span class="style2"><table width="250" height="250" border="1" bordercolor="#003333">
<tr>
<td nowrap="nowrap"><a href="movemapedit.php?x=-1&amp;y=1"><img src="img/diagul.gif" alt="Diag Up Left" /></a></td>
<td nowrap="nowrap"></td>
<td nowrap="nowrap">3:<br /><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y+2;
	// get the info for the coordinates
	$sql = "SELECT *
	        FROM tbl_map
			WHERE map_loc_x = '$ship_loc_x' and map_loc_y = '$ship_loc_y'+2";
	
	$result = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
	
	$mapdata = mysql_fetch_array($result,MYSQL_ASSOC);
		$loc_id = $mapdata['map_loc_id'];
		$loc_x = $mapdata['map_loc_x'];
		$loc_y = $mapdata['map_loc_y'];
		$loc_z = $mapdata['map_loc_z'];
		$loc_extra = $mapdata['map_loc_extra'];

  echo "Cell Id: $loc_id.<br>
  		X, Y: $loc_x, $loc_y.<br>
		Z, and Extra: $loc_z, $loc_extra."; 

  ?>
  <br /><a href="movemapedit.php?x=0&amp;y=1"><img src="img/up.gif" alt="Up" /></a></td>
<td nowrap="nowrap"></td>
<td nowrap="nowrap"><a href="movemapedit.php?x=1&y=1"><img src="img/diagur.gif" alt="Diag Up Right" /></a></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x-1;
  echo ", ";
  print $center_loc_y+1;
  ?></td>
  <td nowrap="nowrap">8:<br />
    <?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y+1;
  
  	// get the info for the coordinates
	$sql = "SELECT *
	        FROM tbl_map
			WHERE map_loc_x = '$ship_loc_x' and map_loc_y = '$ship_loc_y'+1";
	
	$result = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
	
	$mapdata = mysql_fetch_array($result,MYSQL_ASSOC);
		$loc_id = $mapdata['loc_id'];
		$loc_x = $mapdata['loc_x'];
		$loc_y = $mapdata['loc_y'];
		$loc_z = $mapdata['loc_z'];
		$loc_extra = $mapdata['loc_extra'];

  echo "Cell Id: $loc_id.<br>
  		X, Y: $loc_x, $loc_y.<br>
		Z, and Extra: $loc_z, $loc_extra."; 

  ?></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x+1;
  echo ", ";
  print $center_loc_y+1;
  ?></td>
  <td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"><?php
  print $center_loc_x-2;
  echo ", ";
  print $center_loc_y;
  ?>
    <br /><a href="movemapedit.php?x=-1&amp;y=0"><img src="img/left.gif" alt="Left" /></a></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x-1;
  echo ", ";
  print $center_loc_y;
  ?></td>
  <td nowrap="nowrap"><font color="green"><?php 
  //so lets start with code for where you are... and go from there...
  echo "Heya, $user_name, welcome to $center_loc_x, $center_loc_y.<br>
  		Your ship is at: $ship_loc_x, $ship_loc_y.<br>
		Current Destination (if any) $dest_x, $dest_y."; 
  
  
  
  ?></font></td>
  <td nowrap="nowrap">
  <?php
  print $center_loc_x+1;
  echo ", ";
  print $center_loc_y;
  ?>  </td>
  <td nowrap="nowrap"><?php
  print $center_loc_x+2;
  echo ", ";
  print $center_loc_y;
  ?>
    <br /><a href="movemapedit.php?x=1&amp;y=0"><img src="img/right.gif" alt="Right" /></a></td>
</tr>
<tr>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x-1;
  echo ", ";
  print $center_loc_y-1;
  ?></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y-1;
  ?></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x+1;
  echo ", ";
  print $center_loc_y-1;
  ?></td>
  <td nowrap="nowrap"></td>
</tr>
<tr>
  <td nowrap="nowrap"><a href="movemapedit.php?x=-1&amp;y=-1"><img src="img/diagdl.gif" alt="Diag Down Left" /></a></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><?php
  print $center_loc_x;
  echo ", ";
  print $center_loc_y-2;
  ?>
  <br /><a href="movemapedit.php?x=0&amp;y=-1"><img src="img/down.gif" alt="Down" /></a></td>
  <td nowrap="nowrap"></td>
  <td nowrap="nowrap"><a href="movemapedit.php?x=1&amp;y=-1"><img src="img/diagdr.gif" alt="Diag Down Right" /></a></td>
</tr>
</table>
</span>

<p>Ok, need to make center cell change with rest of page...? maybe or atleast list current map center.</p>
<p>also - setup some basic land type images - and setup the edit page... possibly use a mouseover &quot;popup like&quot; layer&gt;? </p>
<p>Each cell will have data about it's location, and links for editing that data. <br />
</p>
<p><a href="#" onclick="MM_callJS('history.back()')">Back</a></p>
</body>
</html>
