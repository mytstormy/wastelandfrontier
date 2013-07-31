<?php require_once('Connections/Rebirth1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_POST['recipe_id'])) {
  $colname_Recordset1 = $_POST['recipe_id'];
}
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = sprintf("SELECT * FROM tbl_recipes WHERE recipe_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';




		// recipe result page include
		
			// all $_POST[values]
			
				$deliv_loc = $_POST['deliv_loc'];
			
				$form_item_type_1 = $_POST['recipe_item_type_1'];
				$form_item_type_1_qty = $_POST['recipe_item_type_1_qty'];
				$form_item_type_2 = $_POST['recipe_item_type_2'];
				$form_item_type_2_qty = $_POST['recipe_item_type_2_qty'];
				$form_item_type_3 = $_POST['recipe_item_type_3'];
				$form_item_type_3_qty = $_POST['recipe_item_type_3_qty'];
				$form_item_type_4 = $_POST['recipe_item_type_4'];
				$form_item_type_4_qty = $_POST['recipe_item_type_4_qty'];
				$form_item_type_5 = $_POST['recipe_item_type_5'];
				$form_item_type_5_qty = $_POST['recipe_item_type_5_qty'];
				$form_item_type_6 = $_POST['recipe_item_type_6'];
				$form_item_type_6_qty = $_POST['recipe_item_type_6_qty'];
				$form_item_type_7 = $_POST['recipe_item_type_7'];
				$form_item_type_7_qty = $_POST['recipe_item_type_7_qty'];
				$form_action_1 = $_POST['recipe_action_1'];
				$form_action_2 = $_POST['recipe_action_2'];
				
				
				// check the qtys to make sure the amount is still available
				
				$qty_avail_error = NULL;
				$recipe_qty_error = NULL;
				$recipe_item_type_error = NULL;
				
				$num_ingredients = $row_Recordset1['recipe_total_items'];
				
				if($num_ingredients >=1){
				// get the item again from the items db
			$checkquery1 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_1'";
    		$itemcheckquery1 =  mysql_query($checkquery1) or die('Query failed. ' . mysql_error());
			$itemcheck1 = mysql_fetch_array($itemcheckquery1,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_1'] != $itemcheck1['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 1 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_1_qty'] != $form_item_type_1_qty){
				$recipe_qty_error .= 'The quantity used for Material 1 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_1_qty > $itemcheck1['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 1 to create this.<br />';
				}
				}
				
				
				if($num_ingredients >=2){			
				// get the item again from the items db
			$checkquery2 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_2'";
    		$itemcheckquery2 =  mysql_query($checkquery2) or die('Query failed. ' . mysql_error());
			$itemcheck2 = mysql_fetch_array($itemcheckquery2,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_2'] != $itemcheck2['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 2 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_2_qty'] != $form_item_type_2_qty){
				$recipe_qty_error .= 'The quantity used for Material 2 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_2_qty > $itemcheck2['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 2 to create this.<br />';
				}
				}
				
				
				if($num_ingredients >=3){			
				// get the item again from the items db
			$checkquery3 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_3'";
    		$itemcheckquery3 =  mysql_query($checkquery3) or die('Query failed. ' . mysql_error());
			$itemcheck3 = mysql_fetch_array($itemcheckquery3,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_3'] != $itemcheck3['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 3 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_3_qty'] != $form_item_type_3_qty){
				$recipe_qty_error .= 'The quantity used for Material 3 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_3_qty > $itemcheck3['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 3 to create this.<br />';
				}
				}
				
				
				if($num_ingredients >=4){			
				// get the item again from the items db
			$checkquery4 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_4'";
    		$itemcheckquery4 =  mysql_query($checkquery4) or die('Query failed. ' . mysql_error());
			$itemcheck4 = mysql_fetch_array($itemcheckquery4,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_4'] != $itemcheck4['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 4 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_4_qty'] != $form_item_type_4_qty){
				$recipe_qty_error .= 'The quantity used for Material 4 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_4_qty > $itemcheck4['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 4 to create this.<br />';
				}
				}
				
				
				if($num_ingredients >=5){			
				// get the item again from the items db
			$checkquery5 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_5'";
    		$itemcheckquery5 =  mysql_query($checkquery5) or die('Query failed. ' . mysql_error());
			$itemcheck5 = mysql_fetch_array($itemcheckquery5,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_5'] != $itemcheck5['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 5 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_5_qty'] != $form_item_type_5_qty){
				$recipe_qty_error .= 'The quantity used for Material 5 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_5_qty > $itemcheck5['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 5 to create this.<br />';
				}
				}
				
				
				if($num_ingredients >=6){			
				// get the item again from the items db
			$checkquery6 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_6'";
    		$itemcheckquery6 =  mysql_query($checkquery6) or die('Query failed. ' . mysql_error());
			$itemcheck6 = mysql_fetch_array($itemcheckquery6,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_6'] != $itemcheck6['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 6 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_6_qty'] != $form_item_type_6_qty){
				$recipe_qty_error .= 'The quantity used for Material 6 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_6_qty > $itemcheck6['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 6 to create this.<br />';
				}
				}
				
				
				if($num_ingredients >=7){			
				// get the item again from the items db
								
			$checkquery7 = "SELECT * FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and item_id = '$form_item_type_7'";
    		$itemcheckquery7 =  mysql_query($checkquery7) or die('Query failed. ' . mysql_error());
			$itemcheck7 = mysql_fetch_array($itemcheckquery7,MYSQL_ASSOC);
					//check the item type is correct
				if($row_Recordset1['recipe_item_type_7'] != $itemcheck7['item_type_id']){
				$recipe_item_type_error .= 'The Item used for Material 7 is not the correct Item.<br />';
				}
					// check for correct qty for recipe
				if($row_Recordset1['recipe_item_type_7_qty'] != $form_item_type_7_qty){
				$recipe_qty_error .= 'The quantity used for Material 7 is not correct.<br />';
				}
					// check for available qty in user inventory
				if($form_item_type_7_qty > $itemcheck7['item_qty']){
				$qty_avail_error .= 'Something has changed - you no longer have enough of Material 7 to create this.<br />';
				}
				}
				
				
				// check the actions - not created in db yet - 
				// will eventually match actions that user has trained to be able to do...
				$recipe_action_error = NULL;
				if($row_Recordset1['recipe_action_1'] != $form_action_1){
					$recipe_action_error = 'The first action/technique used to create this is incorrect.<br />';
				}
				if($row_Recordset1['recipe_action_2'] != $form_action_2){
					$recipe_action_error .= 'The second action/technique used to create this is incorrect.<br />';
				}
				
				
				
				// if there are any errors, kill the creation
				if(($qty_avail_error !== NULL) or ($recipe_qty_error !== NULL) or ($recipe_item_type_error !== NULL) or ($recipe_action_error !== NULL)){
				if($qty_avail_error !== NULL){
				echo 'Available Quantities? :<br />' . $qty_avail_error . '<br /><br />';}
				if($recipe_qty_error !== NULL){
				echo 'Recipe Quantities? :<br />' . $recipe_qty_error . '<br /><br />';}
				if($recipe_item_type_error !== NULL){
				echo 'Item Type? :<br />' . $recipe_item_type_error . '<br /><br />';}
				if($recipe_action_error !== NULL){
				echo 'Actions or Techniques? :<br />' . $qty_avail_error . '<br /><br />';}
				
				// put a button for back to the recipe in question using a form?
					  ?>
					  <form action="recipe.php" method="post" name="backtorecipe">
					  <input name="recipe_id" type="hidden" value="<?php echo $row_Recordset1['recipe_id']; ?>" />
					  <input name="submit" type="submit" value="Back to Recipe" />
					  </form>
                      <br /><br />
					  <?php
				
				}else{
		//  all the rest of the crafting is in this wrapper
			// display details of the crafting results of this recipe as we go...
					
					// subtract all ingredients and echo
				if($num_ingredients >= 1){
					$newqty = $itemcheck1['item_qty'] - $form_item_type_1_qty;
					$item_id = $itemcheck1['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_1_qty . " Unit(s) of " . $itemcheck1['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				if($num_ingredients >= 2){
					$newqty = $itemcheck2['item_qty'] - $form_item_type_2_qty;
					$item_id = $itemcheck2['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_2_qty . " Unit(s) of " . $itemcheck2['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				if($num_ingredients >= 3){
					$newqty = $itemcheck3['item_qty'] - $form_item_type_3_qty;
					$item_id = $itemcheck3['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_3_qty . " Unit(s) of " . $itemcheck3['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				if($num_ingredients >= 4){
					$newqty = $itemcheck4['item_qty'] - $form_item_type_4_qty;
					$item_id = $itemcheck4['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_4_qty . " Unit(s) of " . $itemcheck4['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				if($num_ingredients >= 5){
					$newqty = $itemcheck5['item_qty'] - $form_item_type_5_qty;
					$item_id = $itemcheck5['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_5_qty . " Unit(s) of " . $itemcheck5['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				if($num_ingredients >= 6){
					$newqty = $itemcheck6['item_qty'] - $form_item_type_6_qty;
					$item_id = $itemcheck6['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_6_qty . " Unit(s) of " . $itemcheck6['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				if($num_ingredients >= 7){
					$newqty = $itemcheck7['item_qty'] - $form_item_type_7_qty;
					$item_id = $itemcheck7['item_id'];
				// if $newqty is >0 update the qty in the items db, else - delete the item
				if($newqty > 0){
			$updatequery = "UPDATE tbl_items SET item_qty = $newqty WHERE item_id = $item_id LIMIT 1";
    		$itemupdatequery =  mysql_query($updatequery) or die('Query failed. ' . mysql_error());
				}elseif($newqty = 0){
					$deleteemptyquery = "DELETE FROM tbl_items WHERE item_id = '$item_id' LIMIT 1";
					$deleteempty =  mysql_query($deleteemptyquery) or die('Query failed. ' . mysql_error());
				}
					//echo the change in qty
					echo "Updated: " . $form_item_type_7_qty . " Unit(s) of " . $itemcheck7['item_type_name'] . " were removed from your inventory.<br /><br />";
				}
				
				
				// random bonuses or disasters? and echo it here
					// create new item(s) and stack if needed
					if($row_Recordset1['recipe_item_type_result_1_qty'] > 0){
						$create_item_id_1 = $row_Recordset1['recipe_item_type_result_1'];
						// Check for dupe
						$query = "SELECT * FROM tbl_items WHERE item_type_id = '$create_item_id_1' and item_status = '1' and item_location = '$dest_loc'";
    					$dupecheck =  mysql_query($query) or die('Query failed. ' . mysql_error());
						if(mysql_num_rows($dupecheck) == 0){
							// no dupe - just create the item
							  $new_qty = $row_Recordset1['recipe_item_type_result_1_qty'];
							  $item_type_id = $row_Recordset1['recipe_item_type_result_1'];
							  $sqlinsert = "INSERT INTO tbl_items 
							  (item_user_id, item_type_id, item_status, item_location, item_qty)
							  VALUES('$user_id', '$item_type_id', '1', '$deliv_loc', '$new_qty')";
							  $resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
						}elseif(mysql_num_rows($dupecheck) == 1){
							// dupe - just add the quantity created
							  $dupeinfo = mysql_fetch_array($dupecheck,MYSQL_ASSOC);
							  $existing_id = $dupeinfo[item_id];
							  $existing_qty = $dupeinfo[item_qty];
							  $adj_qty = $existing_qty + $row_Recordset1['recipe_item_type_result_1_qty'];
							  $query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$existing_id' LIMIT 1";
							  $adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
						}
					//echo the item creation
						  $creationquery = "SELECT * FROM tbl_item_types WHERE item_type_id = '$create_item_id_1'";
						  $getcreation =  mysql_query($creationquery) or die('Query failed. ' . mysql_error());
						  $createdinfo = mysql_fetch_array($getcreation,MYSQL_ASSOC);
						  $created_name = $createdinfo['item_type_name'];
					echo "Created: " . $row_Recordset1['recipe_item_type_result_1_qty'] . " Unit(s) of " . $created_name . " were placed in your inventory.<br /><br />";
					}
					
					if($row_Recordset1['recipe_item_type_result_2_qty'] > 0){
						$create_item_id_2 = $row_Recordset1['recipe_item_type_result_2'];
						// Check for dupe
						$query = "SELECT * FROM tbl_items WHERE item_type_id = '$create_item_id_2' and item_status = '1' and item_location = '$dest_loc'";
    					$dupecheck =  mysql_query($query) or die('Query failed. ' . mysql_error());
						if(mysql_num_rows($dupecheck) == 0){
							// no dupe - just create the item
							  $new_qty = $row_Recordset1['recipe_item_type_result_2_qty'];
							  $item_type_id = $row_Recordset1['recipe_item_type_result_2'];
							  $sqlinsert = "INSERT INTO tbl_items 
							  (item_user_id, item_type_id, item_status, item_location, item_qty)
							  VALUES('$user_id', '$item_type_id', '1', '$deliv_loc', '$new_qty')";
							  $resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
						}elseif(mysql_num_rows($dupecheck) == 1){
							// dupe - just add the quantity created
							  $dupeinfo = mysql_fetch_array($dupecheck,MYSQL_ASSOC);
							  $existing_id = $dupeinfo[item_id];
							  $existing_qty = $dupeinfo[item_qty];
							  $adj_qty = $existing_qty + $row_Recordset1['recipe_item_type_result_2_qty'];
							  $query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$existing_id' LIMIT 1";
							  $adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
						}
					//echo the item creation
						  $creationquery = "SELECT * FROM tbl_item_types WHERE item_type_id = '$create_item_id_2'";
						  $getcreation =  mysql_query($creationquery) or die('Query failed. ' . mysql_error());
						  $createdinfo = mysql_fetch_array($getcreation,MYSQL_ASSOC);
						  $created_name = $createdinfo['item_type_name'];
					echo "Created: " . $row_Recordset1['recipe_item_type_result_2_qty'] . " Unit(s) of " . $created_name . " were placed in your inventory.<br /><br />";
					}
					
					if($row_Recordset1['recipe_item_type_result_3_qty'] > 0){
						$create_item_id_3 = $row_Recordset1['recipe_item_type_result_3'];
						// Check for dupe
						$query = "SELECT * FROM tbl_items WHERE item_type_id = '$create_item_id_3' and item_status = '1' and item_location = '$dest_loc'";
    					$dupecheck =  mysql_query($query) or die('Query failed. ' . mysql_error());
						if(mysql_num_rows($dupecheck) == 0){
							// no dupe - just create the item
							  $new_qty = $row_Recordset1['recipe_item_type_result_3_qty'];
							  $item_type_id = $row_Recordset1['recipe_item_type_result_3'];
							  $sqlinsert = "INSERT INTO tbl_items 
							  (item_user_id, item_type_id, item_status, item_location, item_qty)
							  VALUES('$user_id', '$item_type_id', '1', '$deliv_loc', '$new_qty')";
							  $resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
						}elseif(mysql_num_rows($dupecheck) == 1){
							// dupe - just add the quantity created
							  $dupeinfo = mysql_fetch_array($dupecheck,MYSQL_ASSOC);
							  $existing_id = $dupeinfo[item_id];
							  $existing_qty = $dupeinfo[item_qty];
							  $adj_qty = $existing_qty + $row_Recordset1['recipe_item_type_result_3_qty'];
							  $query = "UPDATE tbl_items SET item_qty = '$adj_qty' WHERE item_id = '$existing_id' LIMIT 1";
							  $adjustqty =  mysql_query($query) or die('Query failed. ' . mysql_error());
						}
					//echo the item creation
						  $creationquery = "SELECT * FROM tbl_item_types WHERE item_type_id = '$create_item_id_3'";
						  $getcreation =  mysql_query($creationquery) or die('Query failed. ' . mysql_error());
						  $createdinfo = mysql_fetch_array($getcreation,MYSQL_ASSOC);
						  $created_name = $createdinfo['item_type_name'];
					echo "Created: " . $row_Recordset1['recipe_item_type_result_3_qty'] . " Unit(s) of " . $created_name . " were placed in your inventory.<br /><br />";
					}
					
					
				// experience gain - general and/or specific and echo whatever it is
					
				$newenergy = $user_energy - 1;
				$newcraftingexp = $user_crafting_exp + 1;
				$query = "UPDATE tbl_users SET user_energy = '$newenergy', user_crafting_exp = '$newcraftingexp' WHERE user_id = '$user_id' LIMIT 1";
    				$adjustuser =  mysql_query($query) or die('Query failed. ' . mysql_error());
					
					echo "Energy Cost: 1<br />
					Crafting Exp: 1<br />";
					
					
		// end crafting sequence
				// allow to go back to the recipe to craft again?
				
					?>
					<form action="recipe.php" method="post" name="backtorecipe">
					<input name="recipe_id" type="hidden" value="<?php echo $row_Recordset1['recipe_id']; ?>" />
					<input name="submit" type="submit" value="Create Again?" />
					</form>
                    <br /><br />
					<?php
						
				}
				
				

				// allow to return to the same recipe or back to the same category or just back to crafting?
					// this will be fine whether the recipe is succesful or not...
				
			
				
				// and ... done!


?>
// output here... and this did not comment out did it?  <br />


<?php





mysql_free_result($Recordset1);
?>