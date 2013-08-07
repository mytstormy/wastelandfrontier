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
Need a form for editing and adding recipes. Other edit/add script/pages will be cloned from this one :)

<p>
<form name="new_vendor" method="POST">
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
<p></p>
</form>

<p>&nbsp;</p>

<form name="edit_vendor" method="POST">
<table border="1" cellspacing="5">
      <tr>
        <td colspan="3">The Form For Editing</td>
  </tr>
		 
      <tr>
        <td>Vendor Name</td>
        <td><input name="edit_vendor_name" type="text"></td>
        <td>Yes - just put the vendor's name here.</td>
      </tr>
      <tr>
        <td>Vendor Type</td>
        <td><input name="edit_vendor_type" type="text"></td>
        <td>Related to the following values - this is just the name of it.</td>
      </tr>
      <tr>
        <td>Vendor Item Types</td>
        <td><input name="edit_vendor_item_type" type="text"></td>
        <td>Use the number here: 1 = vehicles, 2 = items, 3 = raw materials, 4 = refined materials.</td>
      </tr>
      <tr>
        <td>Vendor Item Rarity</td>
        <td><input name="edit_vendor_rarity" type="text"></td>
        <td>Part of the item managment - will determine how rare the items are the vendor can sell.</td>
      </tr>
      <tr>
        <td>Vendor Level Restriction</td>
        <td><input name="edit_vendor_item_level_restriction" type="text"></td>
        <td>Will become a factor later as items have levels and that will determine what a vendor can sell.</td>
      </tr>
      <tr>
        <td>Vendor Item Faction</td>
        <td><input type="text" name="edit_vendor_item_faction"></td>
        <td>Addtl faction values can be added later - currently - default to 0.</td>
      </tr>
      <tr>
        <td>Vendor Description</td>
        <td><textarea name="edit_vendor_desc"></textarea></td>
        <td>A brief description of the vendor or his wares?</td>
      </tr>
      <tr>
        <td>Vendor Location X / Y</td>
        <td><input name="edit_vendor_loc_x" type="text" size="4"> / <input name="edit_vendor_loc_y" type="text" size="4"></td>
        <td>Needs to be valid - currently b/t -99 and +99 for both x and y.</td>
      </tr>
	  <tr>
	    <td>Vendor Virtual Location</td>
	    <td><input name="edit_vendor_location" type="text" size="4" /></td>
	    <td align="right">Global vendor location = 0, for individual or single vendor use next avail location id in Locations table, can use regional numbers for groups of vendors.</td>
    </tr>
	  <tr>
        <td colspan="2">Click on the Submit... Silly :)</td>
	    <td align="right"><input name="edit_vendor_id" type="hidden" /><input type="submit" value="Save Edit!"> </td>
  	  </tr>
</table>
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
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>/</td>
    <td nowrap="nowrap"><form action="vendoradd.php" method="post" name="editpost">
      <input name="vendor_id" type="hidden" />
      <input name="submit" type="submit" value="Edit" />
    </form>
      /
      <form action="vendoradd.php" method="post" name="delpost">
        <input name="vendor_id_del" type="hidden" />
        <input name="submit" type="submit" value="Delete" />
      </form></td>
  </tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
</table>
