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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO tbl_links (link_name, link, link_lvl, link_group, link_order, link_hidden) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['inslinkname'], "text"),
                       GetSQLValueString($_POST['inslink'], "text"),
                       GetSQLValueString($_POST['inslinklvl'], "int"),
                       GetSQLValueString($_POST['inslinkgroup'], "text"),
                       GetSQLValueString($_POST['inslinkorder'], "int"),
                       GetSQLValueString($_POST['inslinkhidden'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($insertSQL, $Rebirth1) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tbl_links SET link_name=%s, link=%s, link_lvl=%s, link_group=%s, link_order=%s, link_hidden=%s WHERE id=%s",
                       GetSQLValueString($_POST['editlinkname'], "text"),
                       GetSQLValueString($_POST['editlink'], "text"),
                       GetSQLValueString($_POST['editlinklvl'], "int"),
                       GetSQLValueString($_POST['editlinkgroup'], "text"),
                       GetSQLValueString($_POST['editlinkorder'], "int"),
                       GetSQLValueString($_POST['editlinkhidden'], "int"),
                       GetSQLValueString($_POST['editlinktblid'], "int"));

  mysql_select_db($database_Rebirth1, $Rebirth1);
  $Result1 = mysql_query($updateSQL, $Rebirth1) or die(mysql_error());
}

mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = "SELECT * FROM tbl_links ORDER BY tbl_links.link_lvl, tbl_links.link_group, tbl_links.link_order";
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<p>This page is for editing the Navigation Table.</p>
<p>Goto <a href="admin.php">Admin.php</a></p>
	



<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
<table width="150" border="1" cellpadding="1">
  <tr>
    <td colspan="2">Nav Add </td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap">Link Name </td>
    <td><input type="text" name="inslinkname" /></td>
    </tr>
  <tr>
    <td align="right" nowrap="nowrap">Link Group </td>
    <td><select name="inslinkgroup">
      <option value="None Selected" <?php if (!(strcmp("None Selected", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>&lt;Choose One&gt;</option>
      <option value="5" <?php if (!(strcmp("Admin", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>Admin</option>
      <option value="4" <?php if (!(strcmp("Mod", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>Mod</option>
      <option value="3" <?php if (!(strcmp("Premium", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>Premium</option>
      <option value="2" <?php if (!(strcmp("Main", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>Main</option>
      <option value="0" <?php if (!(strcmp("Pre", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>Pre</option>
      <option value="1" <?php if (!(strcmp("Info", $row_Recordset1['link_group']))) {echo "selected=\"selected\"";} ?>>Info</option>
      </select>
      </td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap">Sec Lvl </td>
    <td><input name="inslinklvl" type="text" size="5" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap">Hidden (0=N,1=Y)</td>
    <td><input name="inslinkhidden" type="text" size="5" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap">Group Order</td>
    <td><input name="inslinkorder" type="text" size="5" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap">Link</td>
    <td><input type="text" name="inslink" /></td>
    </tr>
  <tr>
    <td colspan="2" align="right">Add a Nav Link
      <input type="submit" name="Submit2" value="Submit" /></td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form2">
</form>
<br />
<table border="1" cellpadding="1">
  <tr>
    <td nowrap="nowrap">Id</td>
    <td nowrap="nowrap">Link Group </td>
    <td nowrap="nowrap">Group Order </td>
    <td nowrap="nowrap">Sec Lvl </td>
    <td nowrap="nowrap">Hide(0=N, 1=Y)</td>
    <td nowrap="nowrap">Link</td>
    <td nowrap="nowrap">Link Name </td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <?php do { ?>
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    <tr>
      <td nowrap="nowrap"><?php echo $row_Recordset1['id']; ?>
          <input name="editlinktblid" type="hidden" value="<?php echo $row_Recordset1['id']; ?>" /></td>
      <td nowrap="nowrap"><input name="editlinkgroup" type="text" value="<?php echo $row_Recordset1['link_group']; ?>" size="5" />      </td>
      <td nowrap="nowrap"><input name="editlinkorder" type="text" value="<?php echo $row_Recordset1['link_order']; ?>" size="5" /></td>
      <td nowrap="nowrap"><input name="editlinklvl" type="text" value="<?php echo $row_Recordset1['link_lvl']; ?>" size="5" />      </td>
      <td nowrap="nowrap"><input name="editlinkhidden" type="text" value="<?php echo $row_Recordset1['link_hidden']; ?>" size="5" /></td>
      <td nowrap="nowrap"><input name="editlink" type="text" value="<?php echo $row_Recordset1['link']; ?>" size="15" />      </td>
      <td nowrap="nowrap"><input name="editlinkname" type="text" value="<?php echo $row_Recordset1['link_name']; ?>" size="20" />      </td>
      <td nowrap="nowrap"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
    <input type="hidden" name="MM_update" value="form1" />
  </form>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td colspan="8" align="right">&nbsp;</td>
  </tr>
</table>

<br />



<table width="245" border="1" cellspacing="5">
      <tr>
        <td colspan="4" nowrap="nowrap">Nav Tree...ish</td>
      </tr>
      <tr>
        <td nowrap="nowrap">#-Id</td>
        <td nowrap="nowrap">LinkName  </td>
        <td align="right" nowrap="nowrap">Level</td>
        <td align="right" nowrap="nowrap">Group</td>
      </tr>
      <?php
		 $i = 0;

	// get the links the user is allowed to use
	$sql_links = "SELECT id, link_name, link, link_lvl, link_group
	        FROM tbl_links
			WHERE link_lvl <= '$user_type'
			ORDER BY link_group, link_order DESC";
	
	$result_links = mysql_query($sql_links) or die('Query failed. ' . mysql_error()); 
	
	while($list_links = mysql_fetch_array($result_links,MYSQL_ASSOC)){
	$link_name = $list_links['link_name'];
	$link = $list_links['link'];
	$link_id = $list_links['id'];
	$link_lvl = $list_links['link_lvl'];
	$link_group = $list_links['link_group'];
	
	$i = $i+1;
	
?>
      <tr>
        <td nowrap="nowrap"><?php echo $i; ?>-<?php echo $link_id; ?></td>
        <td nowrap="nowrap"><a href="<?php echo $link; ?>"><?php echo $link_name; ?></a></td>
        <td align="right" nowrap="nowrap"><?php echo $link_lvl; ?></td>
        <td align="right" nowrap="nowrap"><?php echo $link_group; ?></td>
      </tr>
      <?php } ?>
</table>
<?php
mysql_free_result($Recordset1);
?>
