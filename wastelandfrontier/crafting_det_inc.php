<?php include_once('Connections/Rebirth1.php'); ?>
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

$colname_Recordset1 = "0";
if (isset($_POST['recipe_category'])) {
  $colname_Recordset1 = $_POST['recipe_category'];
}
mysql_select_db($database_Rebirth1, $Rebirth1);
$query_Recordset1 = sprintf("SELECT * FROM tbl_recipes WHERE recipe_category = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Rebirth1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';


			// crafting details page - lists the actual recipes the crafting category that was chosen
			
				// check the veh location also - must be in a city or base/hangar to craft
				
				// once recipe is chosen -> go to recipe.php and the _inc file
				
					// use $_POST[variables] of course...  easy peasy :)


			if(isset($_POST["recipe_category"])){ // start crafting detail list
			$recipe_category = $_POST["recipe_category"];
			// get the category list
			$query = "SELECT * FROM tbl_recipes WHERE recipe_category = '$recipe_category'";
    		$recipes =  mysql_query($query) or die('Query failed. ' . mysql_error());
			$recipelist = mysql_fetch_array($recipes,MYSQL_ASSOC);
			$recipe_id = $recipelist["recipe_id"];
			$recipe_level = $recipelist["recipe_level"];
			$recipe_name = $recipelist["recipe_name"];
			$recipe_time = $recipelist["recipe_time"];





?>

<form action="recipe.php" method="post"><table width="200" border="1">
  <tr>
    <td colspan="3">Recipes for this Category</td>
  </tr>
  <tr>
    <td>Choose Recipe</td>
    <td>&nbsp;</td>
    <td><select name="recipe_id">
      <option value="0">Choose A Recipe</option>
      <?php
do {  
?>
      <option value="<?php echo $row_Recordset1['recipe_id']?>"><?php echo $row_Recordset1['recipe_name']?></option>
      <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right">GO: <input name="submit" type="submit" value="Craft This" /></td>
  </tr>
</table>
</form>

<?php




			}






mysql_free_result($Recordset1);
?>