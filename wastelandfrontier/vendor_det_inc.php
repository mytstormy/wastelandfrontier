<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';

// list generic vendors when looking or when at the location
// list special vendors only when in that location

// error messages need to be displayed - 
		if(isset($_SESSION['vendor_error'])){
			echo "<br />vendor error?<br />";
			echo $_SESSION['vendor_error'];
		// unset error variable	
		unset($_SESSION['vendor_error']);
		}
		
		// if there was an error - need to reset to the same vendor - then unset
		if(isset($_SESSION['prev_posted_vendor_id'])){
			$_POST["vendor_id"] = $_SESSION['prev_posted_vendor_id'];
			echo "<br />set vendor id?<br />";
		// unset session vendor temp var	
		unset($_SESSION['prev_posted_vendor_id']);
		}

// perhaps include faction? info from the start?


// get the location?


// $_POST vars from the form 

			if(isset($_POST["vendor_id"])){ // start vendor if-else
			$vendorid = $_POST["vendor_id"];
			// get the vendor's info
			$query = "SELECT * FROM tbl_vendors WHERE vendor_id = '$vendorid'";
    		$vendorresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
			$vendors = mysql_fetch_array($vendorresults,MYSQL_ASSOC);
			$vendor_loc_x = $vendors[vendor_loc_x];
			$vendor_loc_y = $vendors[vendor_loc_y];
			$vendor_name = $vendors[vendor_name];
			$vendor_desc = $vendors[vendor_desc];
			$vendor_location = $vendors[vendor_location];
			
				$max_purchase_vol = $vehicle_max_cargo - $vehicle_current_cargo;
			
			// get the vendor's items... if they have any specific ones? or just all that correspond to the types thye have assigned to them...
			// using location system and item types and rarity and levels... pull from items table.
			$itemtype = $vendors['vendor_item_type'];
			$itemrarity = $vendors['vendor_item_rarity'];
			$itemfaction = $vendors['vendor_item_faction'];
			$itemlevelrestriction = $vendors['vendor_item_level_restriction'];
			$query = "SELECT tbl_items.*, tbl_item_types.* FROM tbl_items LEFT JOIN tbl_item_types ON tbl_items.item_type_id = tbl_item_types.item_type_id WHERE tbl_item_types.item_type_vendor_type = '$itemtype' and tbl_item_types.item_type_rarity <= '$itemrarity' and tbl_item_types.item_type_level <= '$itemlevelrestriction' and tbl_item_types.item_type_faction = '$itemfaction' and tbl_items.item_location = '$vendor_location'";
    		$vendordetresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
			// $vendoritems = mysql_fetch_array($vendordetresults,MYSQL_ASSOC);
			
			// if vehicles vendor - show vehicles
			if($itemtype = 1){
			$query = "SELECT tbl_items.*, tbl_item_types.*, tbl_vehicle_types.* FROM tbl_items, tbl_item_types, tbl_vehicle_types WHERE tbl_item_types.item_type_id = tbl_vehicle_types.vehicle_item_type_id and tbl_items.item_type_id = tbl_item_types.item_type_id and tbl_item_types.item_type_vendor_type = '$itemtype' and tbl_item_types.item_type_rarity <= '$itemrarity' and tbl_item_types.item_type_level <= '$itemlevelrestriction' and tbl_item_types.item_type_faction = '$itemfaction' and tbl_items.item_location = '$vendor_location' and tbl_items.item_user_id = '0'";
    		$vendordetresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
			}
			
			echo "<br />";
			echo "<br />";
			echo '<table border="1" cellpadding="1">';  // start table
			
			
			echo '<tr><td COLSPAN=5>Vendor: '.$vendor_name.'</td></tr>';
			echo '<tr><td COLSPAN=5>Desc: '.$vendor_desc.'</td></tr>';
			echo '<tr><td COLSPAN=5>Has these items for sale: </td></tr>';
			echo '<tr><td>ID</td><td>Name</td><td>Price</td><td>Qty Avail</td><td>Actions/Qty</td></tr>';
			$i = 0;
			while($vendoritems = mysql_fetch_array($vendordetresults,MYSQL_ASSOC)){
			$i++;
			echo '<form name="form'.$i.'" method="post" action="actions.php"><tr>';
			echo '<tr>';
			echo "<td>".$vendoritems['item_id']."</td>";
			echo "<td>".$vendoritems['item_type_name']."</td>";
			echo "<td>".$vendoritems['item_type_base_cost']."</td>";
			echo "<td>".$vendoritems['item_qty']."</td>";
			echo '<td>';
			
			// all vars to pass: (double check these at the action page to make sure they are current
				// vars from vendor
			echo "<input type='hidden' name='vendor_id' value='".$vendors['vendor_id']."'>";
			echo "<input type='hidden' name='vendor_item_current_price' value='".$vendoritems['item_type_base_cost']."'>";
			echo "<input type='hidden' name='vendor_item_qty' value='".$vendoritems['item_qty']."'>";
			echo "<input type='hidden' name='vendor_item_id' value='".$vendoritems['item_id']."'>";
			echo '<input type="hidden" name="referer" value="vendordet.php">';
					// check for vehicle status - if is a vehicle being bought - goes to hangar/base
					
					
				// vars from user
			// use javascript to check these before sending form and also check on action page, to prevent people cheating by buying or selling with values that are not current... etc...
					// check max inventory in veh - if there is enough room
					// check for enough money
					//$vehicle_current_cargo
					//$vehicle_max_cargo
					//$user_credits
			echo "<input type='hidden' name='form_vehicle_current_cargo' value='".$vehicle_current_cargo."'>";
			echo "<input type='hidden' name='form_vehicle_max_cargo' value='".$vehicle_max_cargo."'>";
			echo "<input type='hidden' name='form_vehicle_loc_x' value='".$vehicle_loc_x."'>";
			echo "<input type='hidden' name='form_vehicle_loc_y' value='".$vehicle_loc_y."'>";
			echo "<input type='hidden' name='max_purchase_vol' value='".$max_purchase_vol."'>";
			echo "<input type='hidden' name='form_user_credits' value='".$user_credits."'>";
			
			// purchases of everything default to vehicle inventory unless it is a vehicle - that goes to base/hangar...
				echo "<input type='hidden' name='form_dest_loc' value='".$vehicle_location."'>";
			
			// later - may be able to give option of changing default from veh to hangar etc...
			
			// pass action type so action script knows to execute the vendor buy/sell script
			echo "<input type='hidden' name='action' value='vendor'>";
			
			// also need to pass the transaction type - purchase or sale,
				// purchase - always goes to veh inventory - must have enough room,
				// sale - easy - takes from veh inventory - goes to global invent...
			echo "<input type='hidden' name='transaction_direction' value='purchase'>";
			
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $vendor_loc_x && $vehicle_loc_y == $vendor_loc_y) {
			echo '<input type="text" size="4" name="transaction_qty" value="1"><input type="submit" value="Buy" >';
			}
			echo '&nbsp;</td></tr></form>';
			}
			
			echo '</table>'; // end table
			




			echo "<br />";
			echo "<br />";
			echo "Veh inventory - Items you can sell.";
			echo '<table border="1" cellpadding="1">';  // start table
			
			$query = "SELECT tbl_items.*, tbl_item_types.* FROM tbl_items LEFT JOIN tbl_item_types ON tbl_items.item_type_id = tbl_item_types.item_type_id WHERE item_user_id = '$user_id' and tbl_items.item_location = '$vehicle_location'";
    		$vehinvresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
			
			
			echo '<tr><td COLSPAN=5>Vehicle: '.$vehicle_name.'</td></tr>';
			echo '<tr><td COLSPAN=5>Desc: '.$vehicle_desc.'</td></tr>';
			// echo '<tr><td COLSPAN=5>Has these items for sale: </td></tr>';
			echo '<tr><td>ID</td><td>Name</td><td>Price</td><td>Qty Avail</td><td>Actions/Qty</td></tr>';
			$i = 0;
			while($vehinv = mysql_fetch_array($vehinvresults,MYSQL_ASSOC)){
			$i++;
			echo '<form name="form'.$i.'" method="post" action="actions.php"><tr>';
			echo '<tr>';
			echo "<td>".$vehinv['item_id']."</td>";
			echo "<td>".$vehinv['item_type_name']."</td>";
			echo "<td>".$vehinv['item_type_base_cost']."</td>";
			echo "<td>".$vehinv['item_qty']."</td>";
			echo '<td>';
			
			// all vars to pass: (double check these at the action page to make sure they are current
				// vars from veh inv
			echo "<input type='hidden' name='vendor_id' value='".$vehinv['vendor_id']."'>";
			echo "<input type='hidden' name='vendor_item_current_price' value='".$vehinv['item_type_base_cost']."'>";
			echo "<input type='hidden' name='vendor_item_qty' value='".$vehinv['item_qty']."'>";
			echo "<input type='hidden' name='vendor_item_id' value='".$vehinv['item_id']."'>";
			echo '<input type="hidden" name="referer" value="vendordet.php">';
					// check for vehicle status - if is a vehicle being bought - goes to hangar/base
						// to sell vehicles - must be done from hangar/base
					
				// vars from user
			// use javascript to check these before sending form and also check on action page, to prevent people cheating by buying or selling with values that are not current... etc...
			
				// actually - not too worried at this point for a sale... can only sell what you have...
				
					// check max inventory in veh - if there is enough room
					// check for enough money
					//$vehicle_current_cargo
					//$vehicle_max_cargo
					//$user_credits
			echo "<input type='hidden' name='form_vehicle_current_cargo' value='".$vehicle_current_cargo."'>";
			echo "<input type='hidden' name='form_vehicle_max_cargo' value='".$vehicle_max_cargo."'>";
			echo "<input type='hidden' name='form_vehicle_loc_x' value='".$vehicle_loc_x."'>";
			echo "<input type='hidden' name='form_vehicle_loc_y' value='".$vehicle_loc_y."'>";
			echo "<input type='hidden' name='max_purchase_vol' value='".$max_purchase_vol."'>";
			echo "<input type='hidden' name='form_user_credits' value='".$user_credits."'>";
			
			// sales go into the vendor's inventory - or their regional/global inventory - whatever they are a part of...
			// eventually - may have to restrict what some vendors can buy - or have the items default to the correct
			// vendor type?  we'll see...  that will be determined here?  in the vendor location field
				echo "<input type='hidden' name='form_dest_loc' value='".$vendor_location."'>";
			
			// later - may be able to give option of changing default from veh to hangar etc...
			
			// pass action type so action script knows to execute the vendor buy/sell script
			echo "<input type='hidden' name='action' value='vendor'>";
			
			// also need to pass the transaction type - purchase or sale,
				// purchase - always goes to veh inventory - must have enough room,
				// sale - easy - takes from veh inventory - goes to global invent...
			echo "<input type='hidden' name='transaction_direction' value='sale'>";
			
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $vendor_loc_x && $vehicle_loc_y == $vendor_loc_y) {
			echo '<input type="text" size="4" name="transaction_qty" value="1"><input type="submit" value="Sell" >';
			}
			echo '&nbsp;</td></tr></form>';
			}
			
			echo '</table>'; // end table
			}else{
				
				// vendor else
			echo 'wow, you got some crazy-fuzzy logic goin on here - you need a vendor chosen to look at their inventory... lol <br />';
			echo 'If you were looking for a vendor at this location, please <a href="vendors.php">click here</a> to refresh the Vendor page. <br />';
			}// end vendor if-else

?>