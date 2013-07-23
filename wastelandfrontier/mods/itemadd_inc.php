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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_item")) {
  $insertSQL = sprintf("INSERT INTO tbl_items (item_user_id, item_type_id, item_status, item_location, item_qty, item_min_qty, item_max_qty) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['new_item_user_id'], "int"),
                       GetSQLValueString($_POST['new_item_type_id'], "int"),
                       GetSQLValueString($_POST['new_item_status'], "int"),
                       GetSQLValueString($_POST['new_item_location'], "int"),
                       GetSQLValueString($_POST['new_item_qty'], "int"),
                       GetSQLValueString($_POST['new_item_min_qty'], "int"),
                       GetSQLValueString($_POST['new_item_max_qty'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($insertSQL, $Rebirth1) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_item")) {
  $updateSQL = sprintf("UPDATE tbl_items SET item_user_id=%s, item_type_id=%s, item_status=%s, item_location=%s, item_qty=%s, item_min_qty=%s, item_max_qty=%s WHERE item_id=%s",
                       GetSQLValueString($_POST['edit_item_user_id'], "int"),
                       GetSQLValueString($_POST['edit_item_type_id'], "int"),
                       GetSQLValueString($_POST['edit_item_status'], "int"),
                       GetSQLValueString($_POST['edit_item_location'], "int"),
                       GetSQLValueString($_POST['edit_item_qty'], "int"),
                       GetSQLValueString($_POST['edit_item_min_qty'], "int"),
                       GetSQLValueString($_POST['edit_item_max_qty'], "int"),
                       GetSQLValueString($_POST['edit_item_id'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($updateSQL, $Rebirth1) or die(mysql_error());
}

mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = "SELECT tbl_items.*, tbl_item_types.item_type_name  FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id";
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset2 = "SELECT * FROM tbl_item_types";
$Recordset2 = mysql_query($query_Recordset2, $Rebirth1) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$posted_item_id_Recordset3 = "0";
if (isset($_POST['item_id_edit'])) {
  $posted_item_id_Recordset3 = $_POST['item_id_edit'];
}
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset3 = sprintf("SELECT tbl_items.*, tbl_item_types.item_type_name FROM tbl_items, tbl_item_types WHERE tbl_items.item_type_id = tbl_item_types.item_type_id and tbl_items.item_id = %s", GetSQLValueString($posted_item_id_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $Rebirth1) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<p>Item Management Console:
  <br />
  <br />
  <?php
echo "Thank you for being logged in :D . <br>
Your user id is '$user_id'. <br>
Your user name is '$user_name'. <br>
Your user lvl is '$user_type'. <br>

The current path for this page is: '$current_path'!<br><br>
The current filename for this page is $file_name.<br><br>
Access, Y/N? = $access<br><br>

Page id = $page_id .<br><br>
";
?>
  <br />
  
  <?php
  // here's the action for the form using the post-ed values :)
  
  
  //if (!mysql_query($vendor_insert)){
	//  die('Error: ' . mysql_error());
  //}
  echo "Added Item '" . $_POST[new_item_name] . "' Successfully! <br /> ";
  
  
  ?>
  
  <br />
  
  <a href="itemadd.php">Refresh this page</a>.

<p>

<?php if ($totalRows_Recordset3 == 0) { // Show if recordset empty ?>

<form action="<?php echo $editFormAction; ?>" name="new_item" method="POST">
<table border="1" cellspacing="5">
      <tr>
        <td colspan="3" nowrap="nowrap">The Form For Adding</td>
  </tr>
		 
      <tr>
        <td nowrap="nowrap">Item User ID</td>
        <td><input type="text" name="new_item_user_id"></td>
        <td>Need to know the user ID for this - no lookup</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Type ID</td>
        <td><select name="new_item_type_id">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['item_type_id']?>"><?php echo $row_Recordset2['item_type_name']?>(<?php echo $row_Recordset2['item_type_category']?>)</option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
        <td>Lookup from Item Types Tbl Name(cat)<br />
        cat: 1=gen items, 2=map, 3=nodes</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Status</td>
        <td><input type="text" name="new_item_status"></td>
        <td>1=main inventory, 2=veh inv, 3=auction, 4=on veh as a mod, etc?</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Location</td>
        <td><input type="text" name="new_item_location"></td>
        <td>0=on a vehicle, else 1 is your default home location, others are for vendors</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Qty</td>
        <td><input type="text" name="new_item_qty"></td>
        <td>duh</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Min Qty</td>
        <td><input type="text" name="new_item_min_qty" value="0"></td>
        <td>only for vendors</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Max Qty</td>
        <td><input name="new_item_max_qty" type="text" value="0" /></td>
        <td>not implemented yet...</td>
      </tr>
	  <tr>
        <td colspan="2" nowrap="nowrap">Click on the Submit... Silly :)</td>
	    <td align="right"><input type="submit" value="Submit!"> </td>
  	  </tr>
</table>

<input type="hidden" name="MM_insert" value="new_item" />
</form>


  <?php } // Show if recordset empty ?>
  
  <?php if ($totalRows_Recordset3 > 0) { // Show if recordset not empty ?>
<form action="<?php echo $editFormAction; ?>" name="edit_item" method="POST">
<table border="1" cellspacing="5">
      <tr>
        <td colspan="3" nowrap="nowrap">Item Edit for Item - <?php echo $row_Recordset3['item_id']; ?> (<?php echo $row_Recordset3['item_type_name']; ?>)</td>
  </tr>
		 
      <tr>
        <td nowrap="nowrap">Item User ID</td>
        <td><input name="edit_item_user_id" type="text" value="<?php echo $row_Recordset3['item_user_id']; ?>"></td>
        <td>Need to know the user ID for this - no lookup</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Type ID</td>
        <td><select name="edit_item_type_id">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['item_type_id']?>"<?php if (!(strcmp($row_Recordset2['item_type_id'], $row_Recordset3['item_type_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['item_type_name']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select></td>
        <td>Lookup from Item Types Tbl <br />
          Name(cat)<br />
        cat: 1=gen items, 2=map, 3=nodes</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Status</td>
        <td><input name="edit_item_status" type="text" value="<?php echo $row_Recordset3['item_status']; ?>"></td>
        <td>1=main inventory, 2=veh inv, 3=auction, 4=on veh as a mod, etc?</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Location</td>
        <td><input name="edit_item_location" type="text" value="<?php echo $row_Recordset3['item_location']; ?>"></td>
        <td>0=on a vehicle, else 1 is your default home location, others are for vendors</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Item Qty</td>
        <td><input name="edit_item_qty" type="text" value="<?php echo $row_Recordset3['item_qty']; ?>"></td>
        <td>duh</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Min Qty</td>
        <td><input type="text" name="edit_item_min_qty" value="<?php echo $row_Recordset3['item_min_qty']; ?>"></td>
        <td>only for vendors</td>
      </tr>
      <tr>
        <td nowrap="nowrap">Max Qty</td>
        <td><input name="edit_item_max_qty" type="text" value="<?php echo $row_Recordset3['item_max_qty']; ?>" /></td>
        <td>not implemented yet...</td>
      </tr>
	  <tr>
        <td colspan="2" nowrap="nowrap">Click on the Submit... Silly :)</td>
	    <td align="right"><input type="submit" value="Submit!"> </td>
  	  </tr>
</table>
<input name="edit_item_id" type="hidden" value="<?php echo $row_Recordset3['item_id']; ?>" />
<input type="hidden" name="MM_update" value="edit_item" />
</form>
    <?php } // Show if recordset not empty ?>

<p>&nbsp;</p>

<table border="1">
  <tr>
    <td colspan="5">Item List</td>
  </tr>
  <tr>
    <td>ID/UID/TID</td>
    <td>Name</td>
    <td>Status/Loc</td>
    <td>Qty(min/max)</td>
    <td nowrap="nowrap">Action</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_Recordset1['item_id']; ?>/<?php echo $row_Recordset1['item_user_id']; ?>/<?php echo $row_Recordset1['item_type_id']; ?></td>
    <td><?php echo $row_Recordset1['item_type_name']; ?></td>
    <td><?php echo $row_Recordset1['item_status']; ?>/<?php echo $row_Recordset1['item_location']; ?></td>
    <td><?php echo $row_Recordset1['item_qty']; ?>(<?php echo $row_Recordset1['item_min_qty']; ?>/<?php echo $row_Recordset1['item_max_qty']; ?>)</td>
    <td nowrap="nowrap">
    <form action="itemadd.php" method="post" name="editpost"><input name="item_id_edit" type="hidden" value="<?php echo $row_Recordset1['item_id']; ?>" /><input name="submit" type="submit" value="Edit" /></form>/<form action="itemadd.php" method="post" name="delpost"><input name="item_id_del" type="hidden" value="<?php echo $row_Recordset1['item_id']; ?>" /><input name="submit" type="submit" value="Delete" /></form>
    </td>
  </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
</table>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
