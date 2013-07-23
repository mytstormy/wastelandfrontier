<?php
/*
@Author = Kent Savage
*/

	// get the vehicle's info
	$sqlvehiclelocation = "SELECT *
	        FROM tbl_vehicles, tbl_vehicle_types
			WHERE vehicle_type = vehicle_type_id and vehicle_user_id = '$user_id' and vehicle_active = 1";
	
	$resultvehiclelocation = mysql_query($sqlvehiclelocation) or die('Query failed. ' . mysql_error()); 
	
	$vehiclelocation = mysql_fetch_array($resultvehiclelocation,MYSQL_ASSOC);
	
		$vehicle_id = $vehiclelocation['vehicle_id'];
		$user_id = $vehiclelocation['vehicle_user_id'];
		$vehicle_type = $vehiclelocation['vehicle_type'];
		$vehicle_location = $vehiclelocation['vehicle_location'];
		$vehicle_loc_x = $vehiclelocation['vehicle_loc_x'];
		$vehicle_loc_y = $vehiclelocation['vehicle_loc_y'];
		$dest_x = $vehiclelocation['vehicle_dest_x'];
		$dest_y = $vehiclelocation['vehicle_dest_y'];
		$vehicle_arrival = $vehiclelocation['vehicle_arrival'];
		
		$vehicle_name = $vehiclelocation['vehicle_type_name'];
		$vehicle_desc = $vehiclelocation['vehicle_type_desc'];
	
	// check for movement first, then re-run this query...
// Travel check / update section
		
//************************************//	
		
					// a note about vehicle/map logics... the vehicle is the starting point... cant do anything if you dont have one.  
					
					// since this vehicle info include will be at the top/in each page, lets check the travel status and update it accordingly here.
			
			//  the vehicle is at its x,y location if not traveling
			
			// use the vehicle status field?  no, it doesnt need to be any more complex that what makes it work.
			
					// allow users to select instant travel or timer/eco travel?
					// if using instant travel - energy will be used
					// if no energy remains - automatically switch to instant?
					// calculate an arrival timer and apply it
					// regarding travel - if a destination x,y is set and is different from the vehicle's location, it will enter a travelling state
					// it will then check for an arrival timer, if none is set, the vehicle will reach the destination instantly
					// if a timer is set - make sure we are using the same timezone for the timestamp... if its all based on timestamps - we dont have to worry really.
					// set the timer and wait for the next page refresh  
					// at next page refresh that runs this include (which has the travel maint scripts) the vehicle will arrive.
					// that possibly presents a problem, do we allow them to keep their vehicle in limbo as it were?
					// if the vehicle is in limbo - how can we apply damage or weather or random events in regions?
					// when other scripts are running on the server 
					// for mob/item/node spawns, do we run a travel script once a minute? that updates all arrivals of vehicular travel?  perhaps...

//*******************************//
		if (($vehicle_loc_x != $dest_x || $vehicle_loc_y != $dest_y) && $vehicle_arrival < time()){
			
		$sqlup = "UPDATE tbl_vehicles SET vehicle_loc_x = '$dest_x', vehicle_loc_y = '$dest_y' WHERE vehicle_id = '$vehicle_id' and vehicle_user_id = '$user_id' LIMIT 1";

		$resultup = mysql_query($sqlup) or die('Query failed. ' . mysql_error()); 
		
		}
	
	$sqlvehiclelocation = "SELECT *
	        FROM tbl_vehicles
			WHERE vehicle_user_id = '$user_id' and vehicle_active = 1";
	
	$resultvehiclelocation = mysql_query($sqlvehiclelocation) or die('Query failed. ' . mysql_error()); 
	
	$vehiclelocation = mysql_fetch_array($resultvehiclelocation,MYSQL_ASSOC);
		if (mysql_num_rows($resultvehiclelocation) == 1) {
			

		$vehicle_id = $vehiclelocation['vehicle_id'];
		$user_id = $vehiclelocation['vehicle_user_id'];
		$vehicle_type = $vehiclelocation['vehicle_type'];
		$vehicle_loc_x = $vehiclelocation['vehicle_loc_x'];
		$vehicle_loc_y = $vehiclelocation['vehicle_loc_y'];
		$dest_x = $vehiclelocation['vehicle_dest_x'];
		$dest_y = $vehiclelocation['vehicle_dest_y'];
		$vehicle_arrival = $vehiclelocation['vehicle_arrival'];
		$vehicle_speed = $vehiclelocation['vehicle_speed'];
		$vehicle_speed_modifier = $vehiclelocation['vehicle_speed_modifier'];
		$vehicle_current_cargo = $vehiclelocation['vehicle_current_cargo'];
		$vehicle_max_cargo = $vehiclelocation['vehicle_max_cargo'];
		
		$vehicle_core_hp = $vehiclelocation['vehicle_core_hp'];
		$vehicle_armor_hp = $vehiclelocation['vehicle_armor_hp'];
		$vehicle_shield_hp = $vehiclelocation['vehicle_shield_hp'];
		$vehicle_max_shield_hp = $vehiclelocation['vehicle_max_shield_hp'];
		$vehicle_shield_regen = $vehiclelocation['vehicle_shield_regen'];
		$vehicle_attack_min = $vehiclelocation['vehicle_attack_min'];
		$vehicle_attack_max = $vehiclelocation['vehicle_attack_max'];
		$vehicle_attack_speed = $vehiclelocation['vehicle_attack_speed'];
		$vehicle_defense = $vehiclelocation['vehicle_defense'];
		
	// get the vehicle type info
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = "SELECT * FROM tbl_vehicle_types WHERE vehicle_type_id = '$vehicle_type'";
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
 
$vehicle_type_name = $row_Recordset1['vehicle_type_name'];
$vehicle_type_desc = $row_Recordset1['vehicle_type_desc'];
$vehicle_type_base_hp = $row_Recordset1['vehicle_type_base_hp'];
$vehicle_type_base_speed = $row_Recordset1['vehicle_type_base_speed'];
$vehicle_type_base_armor = $row_Recordset1['vehicle_type_base_armor'];
$vehicle_type_base_attack = $row_Recordset1['vehicle_type_base_attack'];
$vehicle_type_base_cost = $row_Recordset1['vehicle_type_base_cost'];

mysql_free_result($Recordset1);

		// if 1 vehicle was found - set status to single/active
		// in the future, possibly more that one ship can be active? perhaps...  we'll leave this possibility open...
		$vehiclestatus = 'Active';
		}else{
		$vehiclestatus = 'Inactive or More than one Vehicle';
		}
		
		
		
			// now update the total cargo density for speed modifier
			
				// query all items in vehicle inventory
				$query = "SELECT * FROM tbl_items, tbl_item_types WHERE item_user_id = '$user_id' and tbl_items.item_type_id = tbl_item_types.item_type_id and item_status = '1' and item_location = '$vehicle_location'";
    			$stackresultquery =  mysql_query($query) or die('Query failed. ' . mysql_error());
				$runtotal = 0;
				$volumetotal = 0;
				// determine density and total cargo volume
				while($stackresult = mysql_fetch_array($stackresultquery)){
					$stackid = $stackresult['item_id'];
					$stackqty = $stackresult['item_qty'];
					$stackdensity = $stackresult['item_type_density'];
					$itemstacktotal = $stackqty * $stackdensity;
					$runtotal = $runtotal + $itemstacktotal;
					$volumetotal = $volumetotal + $stackqty;
					}
					$maxcompval = $vehicle_max_cargo * 75;
					$densitypercent = ($runtotal/$maxcompval);
					if($densitypercent > 100){
						$densitypercent = (10000 / $densitypercent);
					}else{
						$densitypercent = 100;
					}
					
				// update vehicle db and speed_modifier value as a % integer - 1-100.
				$query = "UPDATE tbl_vehicles SET vehicle_current_cargo = '$volumetotal', vehicle_speed_modifier = '$densitypercent'  WHERE vehicle_id = '$vehicle_id' LIMIT 1";
    				$adjustcargodensity =  mysql_query($query) or die('Query failed. ' . mysql_error());
			
		$vehicle_current_cargo = $volumetotal;


?>