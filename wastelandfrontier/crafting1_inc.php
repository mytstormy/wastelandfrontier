<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';



		// main crafting page include
		
		// need to check location - must be in a city or a base/hangar to do any crafting
		
			// choose type of recipe here - can specialize in certain types ?
				// perhaps... 
				
				
				
				// $_POST[variables] will take you to crafting_det.php - on to that _inc page now...


?>



<table width="300" border="1">
  <tr>
    <td colspan="3">Choose Action Type:</td>
  </tr>
  <tr>
    <td colspan="3">Currently only allowed in Cities.</td>
  </tr>
  <form name="form1" method="post" action="crafting_det.php">
  <tr>
    <td>Refining:</td>
    <input type="hidden" name="recipe_category" value="1">
    <td>&nbsp;</td>
    <td>Click here.<input type="submit" value="Here" ></td>
  </tr></form>
  <tr>
    <td>Vehicle Blueprints:</td>
    <td>&nbsp;</td>
    <td>Click here.</td>
  </tr>
  <tr>
    <td>Parts Crafting:</td>
    <td>&nbsp;</td>
    <td>Click here.</td>
  </tr>
  <tr>
    <td>Reverse Engineering:</td>
    <td>&nbsp;</td>
    <td>Click here.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Spacecraft Blueprints:</td>
    <td>&nbsp;</td>
    <td>Click here.</td>
  </tr>
  <tr>
    <td>Spacecraft Parts:</td>
    <td>&nbsp;</td>
    <td>Click here.</td>
  </tr>
</table>

<?php









?>