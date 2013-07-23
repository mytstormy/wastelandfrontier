<?php
/*
@Author = Kent Savage
*/

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

		include 'mods/vehicleinfo.php';


// we're obviously assuming some things here - what?  and we will need to double check it...
		// for each action - check the assumptions


// sections for each action...



	//*********************************************//

	// battle
		// $_GET from <a href="actions.php?action=fight&from='.$file_name.'&id='.$cellmobs['mob_id'].'">Fight </a>
			// also can scan the creature?  for energy...
			// $_GET from <a href="actions.php?action=scanmob&from='.$file_name.'&id='.$cellmobs['mob_id'].'">Scan </a>
	
	
	
	//*********************************************//
	
		// surveying?  is related, how does surveying allow a person to mine more than what is in the nodes tbl?
			// answer: it doesnt - it only allows them to see what is deeper via the depth field
			// but how do i only allow that person to see the node... could it create a temp node there that is locked to the person?  and perhaps limit how often they can survey?
			// no no no - its all done - surveying is automatic for now...  based on survey skill...
			// so - not getting anything - will comment out the survey link from the details page...
			// $_GET from <a href="actions.php?action=survey&from='.$file_name.'&loc_x='.$det_loc_x.'&loc_y='.$det_loc_y.'">Survey </a>
				// here is where we would consider any surveying skill
	
	
	
	//*********************************************//
	// mining
			// $_GET from <a href="actions.php?action=mine&from='.$file_name.'&id='.$cellnodes['node_id'].'">Mine </a>
			if($_GET["action"] == 'mine' && isset($_GET["node_id"]) && isset($_GET["from"])){
				$referer = $_GET["from"];
			// need to make sure the vehicle is at the location of this node, then check survey level?
					$node_id = $_GET[node_id];
				$query = "SELECT * FROM tbl_nodes, tbl_item_types WHERE node_type = item_type_id and node_id = '$node_id'";
    			$noderesult =  mysql_query($query) or die('Query failed. ' . mysql_error());
				$node_detail = mysql_fetch_array($noderesult);
				if($node_detail['node_loc_x'] == $vehicle_loc_x && $node_detail['node_loc_y'] == $vehicle_loc_y){

			// check mining module equipped on the vehicle = amount to mine && remaining space in cargo
				$module_mining_amount = 15;
				if($module_mining_amount >= $node_detail["node_qty"]){
					$module_mining_amount = $node_detail["node_qty"];
				}
					
				// $vehicle_current_cargo = 500;
				// $vehicle_max_cargo = 2000;
				// eventually - get these variables from the vehicle mods and vehicleinfo etc
			// compare & mine the smaller value as long as there is still space in cargo and still material left in the node...
			if($module_mining_amount >= ($vehicle_max_cargo - $vehicle_current_cargo)){
				$module_mining_amount = ($vehicle_max_cargo - $vehicle_current_cargo);
			}
			if($module_mining_amount <= ($vehicle_max_cargo - $vehicle_current_cargo)){
				// later - may add random bonuses to yield? based on random or skill in mining?
				
			// subtract mining amount from node qty or delete the node if it is depleted.
					// - unless the amount is unlimited - it will not be adjusted below...
					// unlimited nodes have qty of 99999
				$node_id = $node_detail['node_id'];
				if($node_detail['node_qty'] == 99999){
					// do not subtract from it... else - 
				}elseif($module_mining_amount == $node_detail["node_qty"]){
				$deletenodequery = "DELETE FROM tbl_nodes WHERE node_id = '$node_id' LIMIT 1";
    			$deletenode =  mysql_query($deletenodequery) or die('Query failed. ' . mysql_error());
				}else{
				$newqty = $node_detail['node_qty'] - $module_mining_amount;
				$query = "UPDATE tbl_nodes SET node_qty = '$newqty' WHERE node_id = '$node_id' LIMIT 1";
    				$adjustnode =  mysql_query($query) or die('Query failed. ' . mysql_error());
					}
					
			// add mining amount to cargo
				$newcargo = ($vehicle_current_cargo + $module_mining_amount);
				// $query = "UPDATE tbl_vehicles SET vehicle_current_cargo = '$newcargo' WHERE vehicle_id = '$vehicle_id' LIMIT 1";
    				// $adjustvehicle =  mysql_query($query) or die('Query failed. ' . mysql_error());
					
					
			// costs energy to mine - ergo - subtract energy from user total energy
			// add mining experience point/s to user experience
				$newenergy = $user_energy - 1;
				$newminingexp = $user_mining_exp + 1;
				$query = "UPDATE tbl_users SET user_energy = '$newenergy', user_mining_exp = '$newminingexp' WHERE user_id = '$user_id' LIMIT 1";
    				$adjustuser =  mysql_query($query) or die('Query failed. ' . mysql_error());
			
			
			// create the item to add to inventory.
				$item_type_id = $node_detail['node_type'];
				$query = "SELECT * FROM tbl_item_types WHERE item_type_id = '$item_type_id'";
    			$nodeinforesult =  mysql_query($query) or die('Query failed. ' . mysql_error());
				$nodeinfo = mysql_fetch_array($nodeinforesult);
				// raw materials = 3
			
			// stack the item if there are already some in the cargo
				$query = "SELECT * FROM tbl_items WHERE item_user_id = '$user_id' and item_type_id = '$item_type_id' and item_status = '1' and item_location = '$vehicle_location'";
    			$stackresult =  mysql_query($query) or die('Query failed. ' . mysql_error());
				//$stackcheck = mysql_num_rows($stackresult);
			if(mysql_num_rows($stackresult) == 1){
			// stack them if there are some already	
				$stackresult = mysql_fetch_array($stackresult);
			$stackid = $stackresult['item_id'];
			$newstackqty = $module_mining_amount + $stackresult['item_qty'];
				$query = "UPDATE tbl_items SET item_qty = '$newstackqty' WHERE item_id = '$stackid' LIMIT 1";
    				$stackitems =  mysql_query($query) or die('Query failed. ' . mysql_error());
			}else{
			// or, just add it to the inventory
			// for now - vehicle_location = 0 since they already have their own x,y coords - but use the var from vehicles include - $vehicle_location
	$sqlinsert = "INSERT INTO tbl_items 
	        (item_user_id, item_type_id, item_status, item_location, item_qty)
			VALUES('$user_id', '$item_type_id', '1', '$vehicle_location', '$module_mining_amount')";
	
	$resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
				
			} // end stacking if / else
			
			} // end mining amounts/ node remaining / cargo remaining if statement
			
			// include any scripts that must run to update veh data
			include 'mods/vehicleinfo.php';
			
			// set a session var to give success message - with mining amounts etc.
				$_SESSION['mining_confirm'] = 'Successfully Mined '.$module_mining_amount.' units of '.$node_detail["item_type_name"].'.';

	header('Location: celldetail.php?loc_x='.$vehicle_loc_x.'&loc_y='.$vehicle_loc_y);
				}
			}
			
			
			
			
			
	//************** VENDOR BUY/SELL (all except vehicles) *********************//
			// buy / sell script to and from vendors...
			// get vars from $_POST["action"] == buyfromvendor or == selltovendor
 			// *************
          	// <input type='hidden' name='action' value='vendor'>
			// <input type="text" size="4" name="transaction_qty" value="1">
			// <input type='hidden' name='transaction_direction' value='purchase'>
			// <input type='hidden' name='form_vehicle_max_cargo' value='".$vehicle_max_cargo."'>
			// <input type='hidden' name='max_purchase_vol' value='".$max_purchase_vol."'>
			// <input type='hidden' name='form_user_credits' value='".$user_credits."'>
			// <input type='hidden' name='form_vehicle_current_cargo' value='".$vehicle_current_cargo."'>
			// <input type='hidden' name='form_vehicle_loc_x' value='".$vehicle_loc_x."'>
			// <input type='hidden' name='form_vehicle_loc_y' value='".$vehicle_loc_y."'>
			// <input type='hidden' name='vendor_id' value='".$vendors['vendor_id']."'>
			// <input type='hidden' name='vendor_item_current_price' value='".$vendoritems['vendor_item_current_price']."'>
			// <input type='hidden' name='vendor_item_qty' value='".$vendoritems['vendor_item_qty']."'>
			// <input type='hidden' name='vendor_item_id' value='".$vendoritems['vendor_item_id']."'>
            
            // this value can change depending on the source page...
            // <input type="hidden" name="referer" value="vendordet.php">
			
			
			if(($_POST['action']) == 'vendor' && isset($_POST['transaction_direction']) && isset($_POST['transaction_qty'])){
				$_SESSION['vendor_error'] = '';
				
				$posted_transaction_qty = $_POST['transaction_qty'];
				//echo 'Value 1 is '.$posted_transaction_qty.'<br />';
				$posted_transaction_direction = $_POST['transaction_direction'];
				//echo 'Value 2 is '.$posted_transaction_direction.'<br />';
				$posted_form_vehicle_max_cargo = $_POST['form_vehicle_max_cargo'];
				//echo 'Value 3 is '.$posted_form_vehicle_max_cargo.'<br />';
				$posted_max_purchase_vol = $_POST['max_purchase_vol'];
				//echo 'Value 4 is '.$posted_max_purchase_vol.'<br />';
				$posted_form_user_credits = $_POST['form_user_credits'];
				//echo 'Value 5 is '.$posted_form_user_credits.'<br />';
				$posted_form_vehicle_current_cargo = $_POST['form_vehicle_current_cargo'];
				//echo 'Value 6 is '.$posted_form_vehicle_current_cargo.'<br />';
				$posted_form_dest_location = $_POST['form_dest_loc'];
				$posted_form_vehicle_loc_x = $_POST['form_vehicle_loc_x'];
				//echo 'Value 7 is '.$posted_form_vehicle_loc_x.'<br />';
				$posted_form_vehicle_loc_y = $_POST['form_vehicle_loc_y'];
				//echo 'Value 8 is '.$posted_form_vehicle_loc_y.'<br />';
				$posted_vendor_id = $_POST['vendor_id'];
				//echo 'Value 9 is '.$posted_vendor_id.'<br />';
				$posted_vendor_item_current_price = $_POST['vendor_item_current_price'];
				//echo 'Value 10 is '.$posted_vendor_item_current_price.'<br />';
				$posted_vendor_item_id = $_POST['vendor_item_id'];
				//echo 'Value 11 is '.$posted_vendor_item_id.'<br />';
				$posted_vendor_item_qty = $_POST['vendor_item_qty'];
				//echo 'Value 12 is '.$posted_vendor_item_qty.'<br />';
				$referer_page = $_POST['referer'];
				//echo 'Value 13 is '.$referer_page.'<br />';
				
				// check all user vars from form to make sure they match current values...


					// does the user still have same amt of credits?
					if($user_credits !== $posted_form_user_credits){
						$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'There is a discrepancy in your current funds.<br />';
					}
					
					// check vehicle_max_cargo and vehicle_current_cargo
					if($vehicle_max_cargo != $posted_form_vehicle_max_cargo || $vehicle_current_cargo != $posted_form_vehicle_current_cargo){
						$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'For some reason - your vehicle cargo space has changed.<br />
						vehicle_max_cargo = '.$vehicle_max_cargo.'<br />
						posted_form_vehicle_max_cargo = '.$posted_form_vehicle_max_cargo.'<br />
						vehicle_current_cargo = '.$vehicle_current_cargo.'<br />
						posted_form_vehicle_current_cargo = '.$posted_form_vehicle_current_cargo.'<br />';
					}
					
					// check veh location? yes, better do that
					if($vehicle_loc_x !== $posted_form_vehicle_loc_x || $vehicle_loc_y !== $posted_form_vehicle_loc_y){
						$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'Somehow, your vehicle is not at the correct location or has moved since loading this page.<br />';
					}
					
					// if vendor session error is set - send 'em back right now... *poof*
						if($_SESSION['vendor_error'] !== ''){
						$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'Please refresh and attempt your transaction again.<br />';
						header('Location: '.$referer_page);
						}
				
				// I appear to be assuming that i'm setting up the purchase script first... 
			if(($_POST['transaction_direction']) == 'purchase'){
					// need the vehicle location set correct - also need to correct the inventory managment scripts for locations
					// purchases must go into the current vehicle - how else you gonna transport it? lol
						// might add delivery options later...
					
					// is the item still available?
						// get item info from item id
							$query = "SELECT * FROM tbl_items WHERE item_id = '$posted_vendor_item_id'";
    						$itemresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
							  $iteminfo = mysql_fetch_array($itemresults,MYSQL_ASSOC);
								$item_id = $iteminfo['item_id'];
								$item_type_id = $iteminfo['item_type_id'];
								$item_qty = $iteminfo['item_qty'];
							// is the purchase qty available?
							if($posted_transaction_qty > $item_qty){
								$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'The quantity you attempted to purchase is no longer available. Please refresh and attempt your transaction again.<br />';
								header('Location: '.$referer_page);
							}
							
							
							// now that those values have been checked... proceed with transaction

								// check for item to stack in veh inventory

				// check dest inventory for a duplicate item
						$query = "SELECT * FROM tbl_items WHERE item_user_id = '$user_id' and item_type_id = '$item_type_id' and item_status = '1' and item_location = '$posted_form_dest_location'";
    					$dupecheck =  mysql_query($query) or die('Query failed. ' . mysql_error());
						if(mysql_num_rows($dupecheck) == 0){
					// no dupe - 
						// only partial purchases - even reducing vendor inv to 0 is fine
							if(($posted_transaction_qty <= $item_qty) && ($posted_transaction_qty <= $posted_form_vehicle_max_cargo)){
							// moving partial - create new item and set amt in base/hangar
								$new_qty = $posted_transaction_qty;
								$sqlinsert = "INSERT INTO tbl_items 
						        (item_user_id, item_type_id, item_status, item_location, item_qty)
								VALUES('$user_id', '$item_type_id', '1', '$posted_form_dest_location', '$new_qty')";
								$resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
							// subract and leave remainder in vendor inventory... unless qty is unlimited?  99999? could be higher?
									if($item_qty == 99999){
								// if we leave it at 99999 - why change anything :)
									}else{
								$adj_qty = $item_qty - $posted_transaction_qty;
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$item_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
									}
							}	
								// leave this part in for sales (assuming purchase only for the time being)
//								elseif($_POST["move_qty"] == $iteminfo[item_qty]){
//							// if moving all - change item location and done.
//								$query = "UPDATE tbl_items SET item_location = '$dest_loc' WHERE item_id = '$item_id' LIMIT 1";
//    							$changelocation =  mysql_query($query) or die('Query failed. ' . mysql_error());
//							}

						}// end no dupe move section
					
					// if duplicate exists, 
						if(mysql_num_rows($dupecheck) > 0){
							$dupeinfo = mysql_fetch_array($dupecheck,MYSQL_ASSOC);
							$existing_id = $dupeinfo[item_id];
							$existing_qty = $dupeinfo[item_qty];
						// is partial move? or all of item? - same procedure for stacking full or partial move
								// add move amt then go to cleanup section for remainder if any... wont be needed for purchases even to 0 left
								$adj_qty = $existing_qty + $posted_transaction_qty;
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$existing_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());

									if($item_qty == 99999){
								// if we leave it at 99999 - why change anything :)
									}else{
								$adj_qty = $item_qty - $posted_transaction_qty;
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$item_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
									}
						}// end dupe move section

							
								// subtract monies for purchase
									$total_cost = $posted_vendor_item_current_price * $posted_transaction_qty;
									$new_user_credits = $user_credits - $total_cost;
									$moniesquery = "UPDATE tbl_users SET user_credits = '$new_user_credits' WHERE user_id = '$user_id' LIMIT 1";
									$adjustmonies =  mysql_query($moniesquery) or die('Query failed. ' . mysql_error());
								
								// add monies to global ticker ? any other tracking? create a purchase/sale db for tracking?
								$sqlinserttrans = "INSERT INTO tbl_transactions 
						        (trans_user_id, trans_direction, trans_item_id, trans_qty, trans_price)
								VALUES('$user_id', '1', '$item_type_id', '$posted_transaction_qty', '$posted_vendor_item_current_price')";
								$resultinsert = mysql_query($sqlinserttrans) or die('Query failed. ' . mysql_error()); 
								
			}// end purchase.
					
					
					// now for sale script... similar only in reverse
			if(($_POST['transaction_direction']) == 'sale'){
					// need the vehicle location set correct - also need to correct the inventory managment scripts for locations
					
					// is the item still available?
						// get item info from item id
							$query = "SELECT * FROM tbl_items WHERE item_id = '$posted_vendor_item_id'";
    						$itemresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
							  $iteminfo = mysql_fetch_array($itemresults,MYSQL_ASSOC);
								$item_id = $iteminfo['item_id'];
								$item_type_id = $iteminfo['item_type_id'];
								$item_qty = $iteminfo['item_qty'];
							// is the purchase qty available?
							if($posted_transaction_qty > $item_qty){
								$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'The quantity you are trying to sell is no longer available. Please refresh and attempt your transaction again.<br />';
								header('Location: '.$referer_page);
							}
							
							
							// now that those values have been checked... proceed with transaction

				// check dest inventory for a duplicate item
					// for vendors - user_id will be 0 for now, and look for a matching location for the vendor which should match the value sent from teh form... not gonna check it for the time being
						$query = "SELECT * FROM tbl_items WHERE item_user_id = '0' and item_type_id = '$item_type_id' and item_status = '1' and item_location = '$posted_form_dest_location'";
    					$dupecheck =  mysql_query($query) or die('Query failed. ' . mysql_error());
						if(mysql_num_rows($dupecheck) == 0){
					// no dupe - 
						// only partial sales
							if($posted_transaction_qty < $item_qty){
							// moving partial - create new item and set amt in vendor inventory
								// remember vendor user_id = 0
								$new_qty = $posted_transaction_qty;
								$sqlinsert = "INSERT INTO tbl_items 
						        (item_user_id, item_type_id, item_status, item_location, item_qty)
								VALUES('0', '$item_type_id', '1', '$posted_form_dest_location', '$new_qty')";
								$resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
							// subract and leave remainder in vehicle inventory... 
								$adj_qty = $item_qty - $posted_transaction_qty;
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$item_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
							}elseif($posted_transaction_qty == $item_qty){
							// if moving all - change item location and done.
								$query = "UPDATE tbl_items SET item_user_id = '0', item_location = '$dest_loc' WHERE item_id = '$item_id' LIMIT 1";
    							$changelocation =  mysql_query($query) or die('Query failed. ' . mysql_error());
							}

						}// end no dupe move section
					
					// if duplicate exists, 
						if(mysql_num_rows($dupecheck) > 0){
							$dupeinfo = mysql_fetch_array($dupecheck,MYSQL_ASSOC);
							$existing_id = $dupeinfo[item_id];
							$existing_qty = $dupeinfo[item_qty];
						// is partial move? or all of item? - same procedure for stacking full or partial move

								// for vendors - if existing qty is 99999 - dont change it :)
									if($item_qty == 99999){
								// if we leave it at 99999 - why change anything :)
									}else{
										// update it if not 99999  - this is where max/min's could come in handy...
										// so someone doesnt trigger an infinite inventory accidentally or on purpose!  :)
								$adj_qty = $existing_qty + $posted_transaction_qty;
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$existing_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
									}
									
								// for user inventory
							if($posted_transaction_qty < $item_qty){
								$adj_qty = $item_qty - $posted_transaction_qty;
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$item_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
							}elseif($posted_transaction_qty == $item_qty){
							// if sale qty is all of item qty - delete old row from inventory
								$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
    							$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
							}
							
						}// end dupe move section

							
								// give user the monies for the sale
									$total_sale = $posted_vendor_item_current_price * $posted_transaction_qty;
									$new_user_credits = $user_credits + $total_sale;
									$moniesquery = "UPDATE tbl_users SET user_credits = '$new_user_credits' WHERE user_id = '$user_id' LIMIT 1";
									$adjustmonies =  mysql_query($moniesquery) or die('Query failed. ' . mysql_error());
								
								// add monies to global ticker ? any other tracking? create a purchase/sale db for tracking?
								$sqlinserttrans = "INSERT INTO tbl_transactions 
						        (trans_user_id, trans_direction, trans_item_id, trans_qty, trans_price)
								VALUES('$user_id', '2', '$item_type_id', '$posted_transaction_qty', '$posted_vendor_item_current_price')";
								$resultinsert = mysql_query($sqlinserttrans) or die('Query failed. ' . mysql_error()); 
								
			}// end sale.
								
							
							
						
				
				
				
				
			// set confirm message if there are no errors 
						if($_SESSION['vendor_error'] == ''){
						$_SESSION['vendor_error'] = $_SESSION['vendor_error'].'There appear to have been no errors - your transaction is complete.  (Details will follow as the script is completed.)<br />
						Purchase Complete for: <br />
						';
						
						$_SESSION['prev_posted_vendor_id'] = $_POST['vendor_id'];
						header('Location: '.$referer_page);
						}
				
			// redirect to the referer page once transaction is complete
				//echo 'Incomplete Vendor Action...';
			}








	//*********************************************//
		// Move inventory script
			if(($_POST["action"]) == 'move_invent' && isset($_POST["item_id"]) && isset($_POST["move_qty"])){
				// start move inventory if-else
					// inventory page wont allow moves unless veh loc matches current home base/ hangar loc
					
					// need to make this an all in one invnetory managment script... 
						// creating a locations table - wich will have vehicles, hangars, guild banks... etc, 
						// parameters passed will indicate the from --> and to locations... script will take that
						// and move item accordingly...
						$from_loc = $_POST["from_loc"];
						$dest_loc = $_POST["to_loc"];
						$referer_page = $_POST["referer"];
				
				// get item info from item id
			$query = "SELECT * FROM tbl_items WHERE item_user_id = '$user_id' and item_id = '".$_POST['item_id']."'";
    		$itemresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
					$iteminfo = mysql_fetch_array($itemresults,MYSQL_ASSOC);
					$item_id = $iteminfo['item_id'];
					$item_type_id = $iteminfo['item_type_id'];
					$item_qty = $iteminfo['item_qty'];
					
				// check dest inventory for a duplicate item
						$query = "SELECT * FROM tbl_items WHERE item_user_id = '$user_id' and item_type_id = '$item_type_id' and item_status = '1' and item_location = '$dest_loc'";
    					$dupecheck =  mysql_query($query) or die('Query failed. ' . mysql_error());
						if(mysql_num_rows($dupecheck) == 0){
					// no dupe - 
						// is partial move? or all of item?
							if(($_POST["move_qty"] < $iteminfo[item_qty]) && ($_POST["move_qty"] > 0)){
							// moving partial - create new item and set amt in base/hangar
								$new_qty = $_POST["move_qty"];
								$sqlinsert = "INSERT INTO tbl_items 
						        (item_user_id, item_type_id, item_status, item_location, item_qty)
								VALUES('$user_id', '$item_type_id', '1', '$dest_loc', '$new_qty')";
								$resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
							// subract and leave remainder in veh invent
								$adj_qty = $item_qty - $_POST["move_qty"];
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$item_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
								
							}elseif($_POST["move_qty"] == $iteminfo[item_qty]){
							// if moving all - change item location and done.
								$query = "UPDATE tbl_items SET item_location = '$dest_loc' WHERE item_id = '$item_id' LIMIT 1";
    							$changelocation =  mysql_query($query) or die('Query failed. ' . mysql_error());
							}
						}// end no dupe move section
					
					// if duplicate exists, 
						if(mysql_num_rows($dupecheck) > 0){
							$dupeinfo = mysql_fetch_array($dupecheck,MYSQL_ASSOC);
							$existing_id = $dupeinfo[item_id];
							$existing_qty = $dupeinfo[item_qty];
						// is partial move? or all of item? - same procedure for stacking full or partial move
								// add move amt then go to cleanup section for remainder if any...
								$adj_qty = $existing_qty + $_POST["move_qty"];
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$existing_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
								
							if(($_POST["move_qty"] < $iteminfo[item_qty]) && ($_POST["move_qty"] > 0)){
							// if move qty is between 0 and full amt - update for new qty.
								$adj_qty = $item_qty - $_POST["move_qty"];
								$query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$item_id' LIMIT 1";
    							$adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
							}elseif($_POST["move_qty"] == $iteminfo[item_qty]){
							// if move qty is all of item qty - delete old row from inventory
								$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
    							$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
							// echo "Something is wrong....";
							} 
						}// end dupe move section
					// include any scripts that must run to update veh data
					include 'mods/vehicleinfo.php';
				header('Location: '.$referer_page);
			}
	
	//*********************************************//
	
	// scanning
			// this is just examining said item for what?  um, size? weight? contents? perhaps...
		// $_GET from <a href="actions.php?action=scan&from='.$file_name.'&id='.$cellitems['map_item_id'].'">Scan </a>
	
	// salvage?
		// only happens on items - is similar to scanning...
			// $_GET from <a href="actions.php?action=salvage&from='.$file_name.'&id='.$cellitems['map_item_id'].'">Salvage </a>
	
	
	
	//*********************************************//
	
	// move - set dest coords and arrival timer fields
		// let the travel script take it from there
		// $_GET from <a href="actions.php?action=move&from='.$file_name.'&loc_x='.$det_loc_x.'&loc_y='.$det_loc_y.'">Move Here </a>
		
				// use $vehicle_loc_x and y from the vehicleinfo.php include
		if($_GET[action] == 'move' && isset($_GET["loc_x"]) && isset($_GET["loc_y"]) && isset($_GET["from"])){
			$referer = $_GET["from"];
			// update query for the x,y and calculate the timer for travel...
				// change in x squared plus change in y squared = distance squared
				$a1 = $vehicle_loc_x;
				$a2 = $_GET["loc_x"];
				if ($a1 > $a2){$a = $a1 - $a2; }else{$a = $a2 - $a1; }
				$b1 = $vehicle_loc_y;
				$b2 = $_GET["loc_y"];
				if ($b1 > $b2){$b = $b1 - $b2; }else{$b = $b2 - $b1; }
				
				$c1 = $a*$a + $b*$b;
				// default travel speed = 1 minute per unit of travel?
				// can get it from the 
				$s = $vehicle_speed;
				$s2 = ($vehicle_speed_modifier / 100);  // as a percentage
				$s = $s / $s2;
				// $s = 10;
				
				$c2 = round((sqrt($c1)*$s));
				// add the travel value to the current timestamp
				$c = time()+$c2;
				
		// also - if is instant travel - take away from energy? and do not add time.
		// check instant travel field in user db
				// instant travel = 0
				// timed travel = 1
				$instant = $userinfo['user_travel_type'];
				// duh... just make the change here, update all the fields if needed, but just make it happen here... lol wow, cant believe i didnt think of it for like 4 weeks...
				if($instant == 0){
					$c = time();
					$energytotal = ceil($c2/$vehicle_speed);
					$sqlup = "UPDATE tbl_vehicles SET vehicle_dest_x = '$a2', vehicle_dest_y = '$b2', vehicle_loc_x = '$a2', vehicle_loc_y = '$b2', vehicle_arrival = '$c' WHERE vehicle_id = '$vehicle_id' and vehicle_user_id = '$user_id' LIMIT 1";
					$resultup = mysql_query($sqlup) or die('Query failed. ' . mysql_error()); 
					$query = "UPDATE tbl_users SET user_energy = user_energy - '$energytotal' WHERE user_id = '$user_id' LIMIT 1";
    				$adjenergy =  mysql_query($query) or die('Query failed. ' . mysql_error());
				}else{
				
		$sqlup = "UPDATE tbl_vehicles SET vehicle_dest_x = '$a2', vehicle_dest_y = '$b2', vehicle_arrival = '$c' WHERE vehicle_id = '$vehicle_id' and vehicle_user_id = '$user_id' LIMIT 1";

		$resultup = mysql_query($sqlup) or die('Query failed. ' . mysql_error()); 
				}
		// after updating the values thus initiating traveling - redirect to the celldetail page for the dest.
	header('Location: celldetail.php?loc_x='.$_GET["loc_x"].'&loc_y='.$_GET["loc_y"]);
		
		
		
		}



// need to get the previous page path - so can redirect to correct page with whatever messages might be returned...



// setup redirect via the header Location: xxxxx.php method...
echo 'Nothing should display on this page... so somthing may be wrong here... '.$_POST["referer"].'';
?>