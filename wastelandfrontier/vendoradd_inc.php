<?php require_once('mods/Connections/Rebirth1.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_vendor")) {
  $updateSQL = sprintf("UPDATE tbl_vendors SET vendor_name=%s, vendor_type=%s, vendor_item_type=%s, vendor_item_rarity=%s, vendor_item_level_restriction=%s, vendor_item_faction=%s, vendor_desc=%s, vendor_loc_x=%s, vendor_loc_y=%s, vendor_location=%s WHERE vendor_id=%s",
                       GetSQLValueString($_POST['edit_vendor_name'], "text"),
                       GetSQLValueString($_POST['edit_vendor_type'], "text"),
                       GetSQLValueString($_POST['edit_vendor_item_type'], "int"),
                       GetSQLValueString($_POST['edit_vendor_rarity'], "int"),
                       GetSQLValueString($_POST['edit_vendor_item_level_restriction'], "int"),
                       GetSQLValueString($_POST['edit_vendor_item_faction'], "int"),
                       GetSQLValueString($_POST['edit_vendor_desc'], "text"),
                       GetSQLValueString($_POST['edit_vendor_loc_x'], "int"),
                       GetSQLValueString($_POST['edit_vendor_loc_y'], "int"),
                       GetSQLValueString($_POST['edit_vendor_location'], "int"),
                       GetSQLValueString($_POST['edit_vendor_id'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($updateSQL, $Rebirth1) or die(mysql_error());
}

if ((isset($_POST['vendor_id_del'])) && ($_POST['vendor_id_del'] != "")) {
  $deleteSQL = sprintf("DELETE FROM tbl_vendors WHERE vendor_id=%s",
                       GetSQLValueString($_POST['vendor_id_del'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($deleteSQL, $Rebirth1) or die(mysql_error());

  $deleteGoTo = "vendoradd.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_vendor")) {
  $insertSQL = sprintf("INSERT INTO tbl_vendors (vendor_name, vendor_type, vendor_item_type, vendor_item_rarity, vendor_item_level_restriction, vendor_item_faction, vendor_desc, vendor_loc_x, vendor_loc_y, vendor_location) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['new_vendor_name'], "text"),
                       GetSQLValueString($_POST['new_vendor_type'], "text"),
                       GetSQLValueString($_POST['new_vendor_item_type'], "int"),
                       GetSQLValueString($_POST['new_vendor_rarity'], "int"),
                       GetSQLValueString($_POST['new_vendor_item_level_restriction'], "int"),
                       GetSQLValueString($_POST['new_vendor_item_faction'], "int"),
                       GetSQLValueString($_POST['new_vendor_desc'], "text"),
                       GetSQLValueString($_POST['new_vendor_loc_x'], "int"),
                       GetSQLValueString($_POST['new_vendor_loc_y'], "int"),
                       GetSQLValueString($_POST['new_vendor_location'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($insertSQL, $Rebirth1) or die(mysql_error());
}

mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = "SELECT * FROM tbl_vendors";
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$posted_vendor_id_Recordset2 = "0";
if (isset($_POST['vendor_id'])) {
  $posted_vendor_id_Recordset2 = $_POST['vendor_id'];
}
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset2 = sprintf("SELECT * FROM tbl_vendors WHERE tbl_vendors.vendor_id = %s", GetSQLValueString($posted_vendor_id_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $Rebirth1) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<p>This page will have all the admin links necesary... etc.
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
  echo "Added Vendor '" . $_POST[new_vendor_name] . "' Successfully! <br /> ";
  
  
  ?>
  
  <br />
Need a form for editing and adding Vendors. Other edit/add script/pages will be cloned from this one :)

<p>
<form name="new_vendor" method="POST" action="<?php echo $editFormAction; ?>">
<table border="1" cellspacing="5">
      <tr>
        <td colspan="3">The Form For Adding</td>
  </tr>
		 
      <tr>
        <td>Vendor Name</td>
        <td><input type="text" name="new_vendor_name"></td>
        <td>Yes - just put the vendor's name here.</td>
      </tr>
      <tr>
        <td>Vendor Type</td>
        <td><input type="text" name="new_vendor_type"></td>
        <td>Related to the following values - this is just the name of it.</td>
      </tr>
      <tr>
        <td>Vendor Item Types</td>
        <td><input type="text" name="new_vendor_item_type"></td>
        <td>Use the number here: 1 = vehicles, 2 = items, 3 = raw materials, 4 = refined materials.</td>
      </tr>
      <tr>
        <td>Vendor Item Rarity</td>
        <td><input type="text" name="new_vendor_rarity"></td>
        <td>Part of the item managment - will determine how rare the items are the vendor can sell.</td>
      </tr>
      <tr>
        <td>Vendor Level Restriction</td>
        <td><input type="text" name="new_vendor_item_level_restriction"></td>
        <td>Will become a factor later as items have levels and that will determine what a vendor can sell.</td>
      </tr>
      <tr>
        <td>Vendor Item Faction</td>
        <td><input type="text" name="new_vendor_item_faction" value="0"></td>
        <td>Addtl faction values can be added later - currently - default to 0.</td>
      </tr>
      <tr>
        <td>Vendor Description</td>
        <td><textarea name="new_vendor_desc"></textarea></td>
        <td>A brief description of the vendor or his wares?</td>
      </tr>
      <tr>
        <td>Vendor Location X / Y</td>
        <td><input type="text" size="4" name="new_vendor_loc_x"> / <input type="text" size="4" name="new_vendor_loc_y"></td>
        <td>Needs to be valid - currently b/t -99 and +99 for both x and y.</td>
      </tr>
	  <tr>
	    <td>Vendor Virtual Location</td>
	    <td><input type="text" size="4" name="new_vendor_location" /></td>
	    <td align="right">Global vendor location = 0, for individual or single vendor use next avail location id in Locations table, can use regional numbers for groups of vendors.</td>
    </tr>
	  <tr>
        <td colspan="2">Click on the Submit... Silly :)</td>
	    <td align="right"><input type="submit" value="Submit!"> </td>
  	  </tr>
</table>
<p>
  <input type="hidden" name="MM_insert" value="new_vendor" />
</p>
</form>

<p>&nbsp;</p>

<form name="edit_vendor" method="POST" action="<?php echo $editFormAction; ?>">
<table border="1" cellspacing="5">
      <tr>
        <td colspan="3">The Form For Editing</td>
  </tr>
		 
      <tr>
        <td>Vendor Name</td>
        <td><input name="edit_vendor_name" type="text" value="<?php echo $row_Recordset2['vendor_name']; ?>"></td>
        <td>Yes - just put the vendor's name here.</td>
      </tr>
      <tr>
        <td>Vendor Type</td>
        <td><input name="edit_vendor_type" type="text" value="<?php echo $row_Recordset2['vendor_type']; ?>"></td>
        <td>Related to the following values - this is just the name of it.</td>
      </tr>
      <tr>
        <td>Vendor Item Types</td>
        <td><input name="edit_vendor_item_type" type="text" value="<?php echo $row_Recordset2['vendor_item_type']; ?>"></td>
        <td>Use the number here: 1 = vehicles, 2 = items, 3 = raw materials, 4 = refined materials.</td>
      </tr>
      <tr>
        <td>Vendor Item Rarity</td>
        <td><input name="edit_vendor_rarity" type="text" value="<?php echo $row_Recordset2['vendor_item_rarity']; ?>"></td>
        <td>Part of the item managment - will determine how rare the items are the vendor can sell.</td>
      </tr>
      <tr>
        <td>Vendor Level Restriction</td>
        <td><input name="edit_vendor_item_level_restriction" type="text" value="<?php echo $row_Recordset2['vendor_item_level_restriction']; ?>"></td>
        <td>Will become a factor later as items have levels and that will determine what a vendor can sell.</td>
      </tr>
      <tr>
        <td>Vendor Item Faction</td>
        <td><input type="text" name="edit_vendor_item_faction" value="<?php echo $row_Recordset2['vendor_item_faction']; ?>"></td>
        <td>Addtl faction values can be added later - currently - default to 0.</td>
      </tr>
      <tr>
        <td>Vendor Description</td>
        <td><textarea name="edit_vendor_desc"><?php echo $row_Recordset2['vendor_desc']; ?></textarea></td>
        <td>A brief description of the vendor or his wares?</td>
      </tr>
      <tr>
        <td>Vendor Location X / Y</td>
        <td><input name="edit_vendor_loc_x" type="text" value="<?php echo $row_Recordset2['vendor_loc_x']; ?>" size="4"> / <input name="edit_vendor_loc_y" type="text" value="<?php echo $row_Recordset2['vendor_loc_y']; ?>" size="4"></td>
        <td>Needs to be valid - currently b/t -99 and +99 for both x and y.</td>
      </tr>
	  <tr>
	    <td>Vendor Virtual Location</td>
	    <td><input name="edit_vendor_location" type="text" value="<?php echo $row_Recordset2['vendor_location']; ?>" size="4" /></td>
	    <td align="right">Global vendor location = 0, for individual or single vendor use next avail location id in Locations table, can use regional numbers for groups of vendors.</td>
    </tr>
	  <tr>
        <td colspan="2">Click on the Submit... Silly :)</td>
	    <td align="right"><input name="edit_vendor_id" type="hidden" value="<?php echo $row_Recordset2['vendor_id']; ?>" /><input type="submit" value="Save Edit!"> </td>
  	  </tr>
</table>
<input type="hidden" name="MM_update" value="edit_vendor" />
</form>

<p>&nbsp;</p>

<table border="1">
  <tr>
    <td colspan="5">Vendor List</td>
  </tr>
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Type</td>
    <td>X/Y</td>
    <td nowrap="nowrap">Action</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_Recordset1['vendor_id']; ?></td>
    <td><?php echo $row_Recordset1['vendor_name']; ?></td>
    <td><?php echo $row_Recordset1['vendor_type']; ?></td>
    <td><?php echo $row_Recordset1['vendor_loc_x']; ?>/<?php echo $row_Recordset1['vendor_loc_y']; ?></td>
    <td nowrap="nowrap">
    <form action="mods/vendoradd.php" method="post" name="editpost"><input name="vendor_id" type="hidden" value="<?php echo $row_Recordset1['vendor_id']; ?>" /><input name="submit" type="submit" value="Edit" /></form>/<form action="mods/vendoradd.php" method="post" name="delpost"><input name="vendor_id_del" type="hidden" value="<?php echo $row_Recordset1['vendor_id']; ?>" /><input name="submit" type="submit" value="Delete" /></form>
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
?>