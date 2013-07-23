<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';
		include_once 'vehicleinfo.php';
		include_once 'userinfo.php';


?>
<SCRIPT>
    function submit_form(formname)
    {
		
		var returnval=false;
        var msg="";
		var max_qty=parseInt(formname.max_qty.value);
		var move_qty=parseInt(formname.move_qty.value);

        if(move_qty<=0)
            msg+="You can't move nothing or less-than nothing!\n";
        if(move_qty>max_qty)
            msg+="You can't move more than you have!\n";
        if(msg=="")
        {
            returnval=true;
        }
		
        if(returnval==true)
        {
            // return true;
            formname.submit(formname);
        }
        else
        {
			msg+="Please, enter a valid number.\n";
            alert(msg);
            return false;
        }
    }
</SCRIPT> 
<?php
			
			// must be physically at the base to do anything with the veh mods
				// can remove and add mods
				
				// each vehicle has certain mod slots and types
				
					// still check for locations				
				if(($vehicle_loc_x == $user_home_x) && ($vehicle_loc_y == $user_home_y)){
				// can see / change mods

					
					?>
					
					<table border="1" cellpadding="1">
						<tr COLSPAN=3>
							<td>Active Vehicle:</td>
						</tr>
						<tr>
							<td>Name:</td>
							<td><?php echo $vehicle_name; ?></td>
							<td>Equipment Button <br />
							(to mods page)</td>
						</tr>
						<tr>
							<td>Desc:</td>
							<td colspan="2"><?php echo $vehicle_desc; ?></td>
						</tr>
					</table>


					<br /><br />
					
                    
                    <?php
					// get mods info
						// mods are in items db with item_status of 4 when equipped
							// show table/grid layout here
							
							// set none echo variable.
							$none_echo = '<br /><img src="img/none.GIF" alt="None" width="25" height="25" />';
							
							// if this vehicle type allows for that slot - display dropdown for setting mod
								// use a drop list? on set - it calls the form?
							
						
					?>
						
					<table border="1" cellpadding="1">
						<tr>
							<td COLSPAN=3>mods</td>
						<tr>
							<td>Front weap<?php echo $none_echo; ?>
							</td>
							<td>Roof weap<?php echo $none_echo; ?>
							</td>
							<td>Rear weap<?php echo $none_echo; ?>
							</td>
						</tr>
						<tr>
							<td>Power Cell<?php echo $none_echo; ?>
							</td>
							<td>Main Veh Pic</td>
							<td>Cargo Mod<?php echo $none_echo; ?>
							</td>
						</tr>
						<tr>
							<td>Armor<?php echo $none_echo; ?>
							</td>
							<td>Shield<?php echo $none_echo; ?>
							</td>
							<td>Cargo Mod<?php echo $none_echo; ?>
							</td>
						</tr>
						<tr>
							<td COLSPAN=3>should be dynamic depending on what slots veh has available <br />Still working on this :)</td>
						</tr>
						<tr>
							<td COLSPAN=3 align="right">no button for changes here <br />- options for each mod in its cell... </td>
						</tr>
					</table>
						
						
                    <?php
						// list available mods here?
						
					
						
	$sqlaltvehicles = "SELECT *
	        FROM tbl_items, tbl_vehicle_types
			WHERE item_type_id = vehicle_item_type_id and item_user_id = '$user_id'";
	
	$resultaltvehicles = mysql_query($sqlaltvehicles) or die('Query failed. ' . mysql_error()); 
	
					?>
                    
					<form>
					<table border="1" cellpadding="1">
						<tr>
							<td COLSPAN=3>Other Vehicles:</td>
						<tr>
							<td>Name:</td>
							<td>Status/Location:</td>
							<td>Select to Activate:</td>
						</tr>
						</tr>
                        <?php
						while($altvehicles = mysql_fetch_array($resultaltvehicles,MYSQL_ASSOC)){
							
							?>
						<tr>
							<td><?php echo $altvehicles[vehicle_type_name]; ?></td>
							<td><?php echo "Inactive / 0,0  "; // currently home coords
							echo $user_home_x; echo ","; echo $user_home_y; ?></td>
							<td><input type="radio" name="alt_veh" value="from query" /> from query1 </td>
						</tr>
							
                            
                            <?php
							}
						?>
						<tr>
							<td>Name:</td>
							<td>$veh_name here...</td>
							<td><input type="radio" name="alt_veh" value="from query" /> from query2 </td>
						</tr>
						<tr>
							<td COLSPAN=3>Warning - changing veh will un-equip all mods on current active vehicle.</td>
						</tr>
						<tr>
							<td COLSPAN=3>Also - inventory must be empty before changing active vehicle.</td>
						</tr>
						<tr>
							<td COLSPAN=3 align="right">Change Button Here</td>
						</tr>
					</table>
					</form>
					
					<br />
					
					<?php
					
					
						// equip mods on current veh
					
						// change active vehicle
							// verify inventory is empty on veh before allowing change, 
					
						// sell/trade?/auction inactive vehicles
							// cannot do any of those with active vehicle
						
				
					// inventory
						// might as well try to include the inventory include? :)
						include 'mods/inventory_inc.php';
						// sell items from here?
						// move b/t veh and base
						// auction/trade?
					
				
				
				// crafting / recipe training?
				
				// skill management?
				// summary of skills and exp... links to skill training pages or trainers?
				// 
				
				// other items in the base...
					// archives?  like a knowledge collection?
						// mobs you've fought?
						// rare or unique items you've found
						
					// achievments?
						// need to start tracking things that will be achievable?
							// damage
								// crits, totals done and taken
							// money from mobs
							// money from vendors
							// purchases made
							// items equipped
							// items created
							// quests/missions completed
							
							
					// list quest summary here too
					// missions summary
					
					
					// drone controlls - for remote mining
						// drones avail at hhigher levels... ?
						
					
					// similar to skills - but this is upgradeable equipment for the base
						// possibly open up buildings - slots? have requirements for crafting/etc...
					// power managment? like energy storage for crafting?
						// like turns?  
						// allow some customization - can upgrade storage batteries to store more energy
							// can upgrade solar collectors to regen faster
					

				}else{
				// veh is not at the home location - set this to an X or something to indicate cannot move unless at home location
				echo "Please move your vehicle to this location in order to access all the Home Base / Hangar options.<br />";
				}
			
				
				
			
				echo "<br /><br />-------------------------------------------------------<br /><br />";
			
			
			


?>