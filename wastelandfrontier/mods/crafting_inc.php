<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';
		include_once 'vehicleinfo.php';
		include_once 'userinfo.php';



		// main crafting page include
		
		// need to check location - must be in a city or a base/hangar to do any crafting
		
			// choose type of recipe here - can specialize in certain types ?
				// perhaps... 
				
				
				
				// $_POST[variables] will take you to craftingdet.php - on to that _inc page now...


?>
<table width="300" border="1">
  <tr>
    <td colspan="3">Choose Action Type:</td>
  </tr>
  <tr>
    <td colspan="3">Currently only allowed in Cities.</td>
  </tr>
  <form name="form1" method="post" action="craftingdet.php">
  <tr>
    <td>Refining:</td>
    <input type="hidden" name="recipe_category" value="1">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
  <form name="form2" method="post" action="craftingdet.php">
  <tr>
    <td>Vehicle Blueprints:</td>
    <input type="hidden" name="recipe_category" value="2">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
  <form name="form3" method="post" action="craftingdet.php">
  <tr>
    <td>Parts Crafting:</td>
    <input type="hidden" name="recipe_category" value="3">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
  <form name="form4" method="post" action="craftingdet.php">
  <tr>
    <td>Reverse Engineering:</td>
    <input type="hidden" name="recipe_category" value="4">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <form name="form5" method="post" action="craftingdet.php">
  <tr>
    <td>Spacecraft Blueprints:</td>
    <input type="hidden" name="recipe_category" value="5">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
  <form name="form6" method="post" action="craftingdet.php">
  <tr>
    <td>Spacecraft Parts:</td>
    <input type="hidden" name="recipe_category" value="6">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
</table>

<?php







?>