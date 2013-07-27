<?php


/*
@Author = Kent Savage
*/

		include_once 'mods/vehicleinfo.php';
		
		// set the default cell detail location to the vehicle's current location - if location is unset, set it to the destination?  need to work out how that works... actually...
		if(isset($_GET["loc_x"]) && isset($_GET["loc_y"])){
			$det_loc_x = $_GET["loc_x"];
			$det_loc_y = $_GET["loc_y"];
		}else{
			$det_loc_x = $vehicle_loc_x;
			$det_loc_y = $vehicle_loc_y;
		}

	$query1 = "SELECT * FROM tbl_map WHERE map_loc_x = '$det_loc_x' and map_loc_y = '$det_loc_y'";
    $queryResult1 =  mysql_query($query1);
	$celldetail = mysql_fetch_array($queryResult1);

	// terrain types - pulled from the z value should match up to these - will note it in the db... or should...

	$imgprearray = array(
		1 => 'desert',
		2 => 'mountain',
		3 => 'canyon',
		4 => 'oasis',
		5 => 'plains',
		6 => 'forest',
	);

	// set the image pre name for the cell
	$terraintype = $celldetail[map_loc_z];
	if ($terraintype == 0){$terraintype = 1; }
	$imgpre = $imgprearray[$terraintype];
	// check to see if the cell in question is the current location - set image extension to reflect that
	if(($celldetail["map_loc_x"] == $vehicle_loc_x) && ($celldetail["map_loc_y"] == $vehicle_loc_y)){
		$imgextension = "-m-c";
		}elseif(($celldetail["map_loc_x"] == $dest_x) && ($celldetail["map_loc_y"] == $dest_y)){
		// is this the user's current destination?  display it if so...
		$imgextension = "-m-d";
		}else{
			$imgextension = "-m";
			}
	
// check to see if their vehicle is at this location - if so, list it in the location details?
				// the pic
			echo '<img src="img/'.$imgpre.''.$imgextension.'.jpg" alt="'.$celldetail[map_loc_x].'/'.$celldetail[map_loc_y].'"><br />'.$det_loc_x.'/'.$det_loc_y.'<br /><br />';
			
				// any extra details from the maps db...  or is there a different table to pull from?
			
			
			// display any errors or sucess/reports...
				echo $_SESSION['mining_confirm'];
				echo '<br /><br />';
				if(isset($_SESSION['mining_confirm'])){
				unset($_SESSION['mining_confirm']);
				}

		// also - if the vehicle is not there, they cannot mine, salvage, survey, etc...
		
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $det_loc_x && $vehicle_loc_y == $det_loc_y) {
				// see the variables in the include above
				echo "Your vehicle is here: You may perform these actions.<br /><br />";
				
				// is this the user's current destination?  display it if so...
				}elseif($vehiclestatus == 'Active' && $dest_x == $det_loc_x && $dest_y == $det_loc_y){
					echo "Your vehicle is traveling here: Please wait to perform these actions.<br />";
							// show timer?  yeah, once that is working...
						$remaining = $vehicle_arrival - time();
						echo "Time remaining = ".$remaining." Seconds.<br /><br />";
				}else{
					echo 'Your vehicle is not here: 
					<a href="actions.php?action=move&from='.$file_name.'&loc_x='.$det_loc_x.'&loc_y='.$det_loc_y.'">Travel Here </a>
					to perform these actions.<br /><br />';
				
				}

		
// got the basic info about the cell, should also get info from mobs table, and from nodes...
	$query2 = "SELECT * FROM tbl_map_items, tbl_item_types WHERE tbl_map_items.map_item_type = tbl_item_types.item_type_id AND tbl_map_items.map_item_loc_x = '$det_loc_x' AND tbl_map_items.map_item_loc_y = '$det_loc_y'";
    $queryResult2 =  mysql_query($query2);
	
			echo '<table border="1" cellpadding="1">';  // start table
			echo '<tr><td COLSPAN=5>Found these items: </td></tr>';
			echo '<tr><td>ID</td><td>Name</td><td>Loc_Z</td><td>Qty</td><td>Actions</td></tr>';
			while($cellitems = mysql_fetch_array($queryResult2)){
			echo '<tr>';
			echo "<td>".$cellitems['map_item_id']."</td>";
			echo "<td>".$cellitems['item_type_name']."</td>";
			echo "<td>".$cellitems['map_item_loc_z']."</td>";
			echo "<td>".$cellitems['map_item_qty']."</td>";
			echo '<td>';
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $det_loc_x && $vehicle_loc_y == $det_loc_y) {
			// scan and salvage not active at this time
			//echo '<a href="actions.php?action=scan&from='.$file_name.'&id='.$cellitems['map_item_id'].'">Scan </a> / <a href="actions.php?action=salvage&from='.$file_name.'&id='.$cellitems['map_item_id'].'">Salvage </a>';
			}
			echo '&nbsp;</td></tr>';
			}
						
			echo '<tr><td COLSPAN=5>&nbsp; </td></tr>';

	
	$query3 = "SELECT * FROM tbl_nodes, tbl_item_types WHERE node_type = item_type_id and node_loc_x = '$det_loc_x' and node_loc_y = '$det_loc_y' and node_loc_z <= 1";
    $queryResult3 =  mysql_query($query3);
	
			echo '<tr><td COLSPAN=5>Found these mining nodes: </td></tr>';
			echo '<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Loc_Z</td>
			<td>Qty</td>
			<td>Actions</td></tr>';
			while($cellnodes = mysql_fetch_array($queryResult3,MYSQL_ASSOC)){
			echo '<tr>';
			echo "<td>".$cellnodes['node_id']."</td>";
			echo "<td>".$cellnodes['item_type_name']."</td>";
			echo "<td>".$cellnodes['node_loc_z']."</td>";
			echo "<td>".$cellnodes['node_qty']."</td>";
			echo '<td>';
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $det_loc_x && $vehicle_loc_y == $det_loc_y) {
			echo '<a href="actions.php?action=mine&from='.$file_name.'&node_id='.$cellnodes['node_id'].'">Mine </a>';
			// echo '/ <a href="actions.php?action=survey&loc_x='.$det_loc_x.'&loc_y='.$det_loc_y.'">Survey </a>';
			}
			echo '&nbsp;</td></tr>';
			}
						
			echo '<tr><td COLSPAN=5>&nbsp; </td></tr>';


//***************************//
// use this secondary with an if to display the deeper survey results - if they have the appropriate survey skill or survey mod installed
		$survey_level = $userinfo['user_survey_skill'];
		if($survey_level > 1 && $vehicle_loc_x == $det_loc_x && $vehicle_loc_y == $det_loc_y){
	$query32 = "SELECT * FROM tbl_nodes, tbl_item_types WHERE node_type = item_type_id and node_loc_x = '$det_loc_x' and node_loc_y = '$det_loc_y' and node_loc_z >= 2 and node_loc_z <= '$survey_level'";
    $queryResult32 =  mysql_query($query32);
		if(mysql_num_rows($queryResult32) > 0){
			echo '<tr><td COLSPAN=5>Advanced Surveying found these deep nodes: </td></tr>';
			echo '<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Loc_Z</td>
			<td>Qty</td>
			<td>Actions</td></tr>';
			while($cellnodes2 = mysql_fetch_array($queryResult32,MYSQL_ASSOC)){
			echo '<tr>';
			echo "<td>".$cellnodes2['node_id']."</td>";
			echo "<td>".$cellnodes2['item_type_name']."</td>";
			echo "<td>".$cellnodes2['node_loc_z']."</td>";
			echo "<td>".$cellnodes2['node_qty']."</td>";
			echo '<td>';
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $det_loc_x && $vehicle_loc_y == $det_loc_y) {
			echo '<a href="actions.php?action=mine&from='.$file_name.'&node_id='.$cellnodes2['node_id'].'">Mine </a>';
			
		// echo '/ <a href="actions.php?action=survey&loc_x='.$det_loc_x.'&loc_y='.$det_loc_y.'">Survey </a>';
			}
			echo '&nbsp;</td></tr>';
			}
						
			echo '<tr><td COLSPAN=5>&nbsp; </td></tr>';
		} // end inner if
		} // end the survey nodes if section
	
	$query4 = "SELECT * FROM tbl_mobs, tbl_mob_types WHERE mob_type = mob_type_id and mob_loc_x = '$det_loc_x' and mob_loc_y = '$det_loc_y'";
    $queryResult4 =  mysql_query($query4);
	
			echo '<tr><td COLSPAN=5>Found these Monsters: </td></tr>';
			echo '<tr><td>ID</td><td>Name</td><td>Loc_Z</td><td>HP</td><td>Actions</td></tr>';
			while($cellmobs = mysql_fetch_array($queryResult4,MYSQL_ASSOC)){
			echo '<tr>';
			echo "<td>".$cellmobs['mob_id']."</td>";
			echo "<td>".$cellmobs['mob_type_name']."</td>";
			echo "<td>".$cellmobs['mob_loc_z']."</td>";
			echo "<td>".$cellmobs['mob_hp']."</td>";
			echo '<td>';
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $det_loc_x && $vehicle_loc_y == $det_loc_y && $cellmobs['mob_hp'] > 0) {
			?>
            <form action="mods/battle.php" method="post" name="battleform">
            <input name="mob_id" type="hidden" value="<?php echo $cellmobs['mob_id']; ?>" />
            <input name="submit" type="submit" value="Fight" />
            </form>
            
            <?php

			echo '<a href="actions.php?action=scanmob&from='.$file_name.'&id='.$cellmobs['mob_id'].'">Scan </a>';
			}
			echo '&nbsp;</td></tr>';
			}
			
			echo '</table>'; // end table
	
// show other peoples vehicles at the location???
		// not yet...
		
// also get info from any other tables?  like?  random events table? or run a query?
		


?>