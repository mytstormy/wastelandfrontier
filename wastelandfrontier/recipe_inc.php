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

$colname_Recordset2 = "-1";
if (isset($user_id)) {
  $colname_Recordset2 = $user_id;
}
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset2 = sprintf("SELECT * FROM tbl_items, tbl_item_types WHERE item_user_id = %s and tbl_items.item_type_id = tbl_item_types.item_type_id and item_location = 0", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $Rebirth1) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';



		// recipe page include
		
		// need to check location - must be in a city or a base/hangar to do any crafting
		
			// list basic info about the recipe - mats needed etc
			
			// give dropdowns for the material slots of the recipe
				// show totals of each material in the dropdown
					// must craft from veh inventory? or allow to use from veh/base inventory?
			
				// is the order important?  yes, we'll say that it is for now
					// unless i can find an easy way to make it not important...
					
				// make user choose qty - it will be specific... notes in the info above will give hints
					
					
			// choose delivery option... and tell user how long crafting will take
			
			// if delivery to base/hangar - no need to lock vehicle
				// else if delivering to vehicle - lock the veh in place
				
			// setting all $_POST[variables] -> send to reciperesult.php
			
			
			$recipe_total_items = $row_Recordset1['recipe_total_items'];

?>
<form action="recipe_result.php" method="post" name="recipeform">
<table width="300" border="1">
  <tr>
    <td colspan="4">Recipe Details and Material Choices: <?php echo $totalRows_Recordset1 ?></td>
  </tr>
  <tr>
    <td><?php echo $row_Recordset1['recipe_name']; ?>&nbsp;</td>
    <input name="recipe_id" type="hidden" value="<?php echo $row_Recordset1['recipe_id']; ?>" />
    <td colspan="3"><?php echo $row_Recordset1['recipe_desc']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Material 1:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_1_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_1">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_1_qty" type="text" value="0" /></td>
  </tr>
  <?php if ($recipe_total_items >= 2) { // Show if 2 items needed start ?>
  <tr>
    <td>Material 2:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_2_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_2">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_2_qty" type="text" value="0" /></td>
  </tr>
<?php } // Show if 2 items needed end ?>
  <?php if ($recipe_total_items >= 3) { // Show if 3 items needed start ?>
  <tr>
    <td>Material 3:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_3_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_3">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_3_qty" type="text" value="0" /></td>
  </tr>
<?php } // Show if 3 items needed end ?>
  <?php if ($recipe_total_items >= 4) { // Show if 4 items needed start ?>
  <tr>
    <td>Material 4:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_4_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_4">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_4_qty" type="text" value="0" /></td>
  </tr>
<?php } // Show if 4 items needed end ?>
  <?php if ($recipe_total_items >= 5) { // Show if 5 items needed start ?>
  <tr>
    <td>Material 5:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_5_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_5">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_5_qty" type="text" value="0" /></td>
  </tr>
<?php } // Show if 5 items needed end ?>
  <?php if ($recipe_total_items >= 6) { // Show if 6 items needed start ?>
  <tr>
    <td>Material 6:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_6_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_6">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_6_qty" type="text" value="0" /></td>
  </tr>
<?php } // Show if 6 items needed end ?>
  <?php if ($recipe_total_items >= 7) { // Show if 7 items needed start ?>
<tr>
    <td>Material 7:</td>
    <td><?php echo $row_Recordset1['recipe_item_type_7_name']; ?>&nbsp;</td>
    <td><select name="recipe_item_type_7">
      <option value="0">Choose Material</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset2['item_id']?>"><?php echo $row_Recordset2['item_type_name']. "(" . $row_Recordset2['item_qty']. ")" ?></option>
      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
    </select>      &nbsp;</td>
    <td><input name="recipe_item_type_7_qty" type="text" value="0" /></td>
</tr>
<?php } // Show if 7 items needed end ?>
  <tr>
    <td>Action/Technique 1:</td>
    <td>&nbsp;</td>
    <td><select name="recipe_action_1">
      <option value="0" selected="selected">Choose One</option>
      <option value="1">Smelting</option>
      <option value="2">Milling</option>
      &nbsp;</select></td>
    <td>&nbsp;</td>
</tr>
  <tr>
    <td>Action/Technique 2:</td>
    <td>&nbsp;</td>
    <td><select name="recipe_action_2">
      <option value="0" selected="selected">Choose One</option>
      <option value="1">Smelting</option>
      <option value="2">Milling</option>
      &nbsp;</select></td>
    <td>&nbsp;</td>
</tr>
  <tr>
    <td colspan="2">Delivery Location</td>
    <td> <label>
          <input name="deliv_loc" type="radio" id="deliv_loc_0" value="0" checked="checked" />
          Vehicle</label>
        <br />
        <label>
          <input type="radio" name="deliv_loc" value="<?php  echo $user_home_location_1; ?>" id="deliv_loc_1" />
          Hangar</label>
        <br />
      </td>
    <td>&nbsp;</td>
</tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
  <tr>
    <td colspan="4" align="right">Submit this recipe for Manufacturing: <input name="submit" type="submit" value="Create!" /></td>
  </tr>
</table>
</form>
<?php







mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>