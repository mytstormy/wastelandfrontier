<?php

		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';


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
			

					// user mgmt include...
						// show current 
							// username
							// email
							// account status
					
					
					
					// can manage user related settings from anywhere...
						// travel type, 
						// battle type
						// password resets
						// account type - 
							// list donations or credit status from ingame purchases
							// or like order history?
							
						// ingame message center? communications from admin?
					
					// also list any admin or moderator priviliges a user may have...
					
					
?>
					
					<form action="" method="post" name="pwdupdate" target="_self"><table border="1" cellpadding="1">
						<tr>
							<td colspan="2">User Info:
						    <field></td>
						</tr>
						<tr>
							<td>Username:</td>
							<td><?php echo $user_name; ?> &nbsp;</td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><?php echo $user_email; ?> &nbsp;</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td><input type="hidden" name="hiddenField" id="hiddenField" /></td>
					  </tr>
						<tr>
							<td>Pwd Change:</td>
							<td>********</td>
						</tr>
						<tr>
							<td>Current:</td>
							<td><field>
						    <input type="password" name="textfield3" id="textfield3" /></td>
						</tr>
						<tr>
							<td>New:</td>
							<td><field>
						    <input type="password" name="textfield2" id="textfield2" /></td>
						</tr>
						<tr>
							<td>NEw Confirm:</td>
							<td><field>
						    <input type="password" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<td colspan="2" align="right"><input name="submit" type="submit" value="Change" />	</td>
						</tr>
</table></form>


					<br /><br />
					
<form action="" method="post" name="travelbattleupdate" target="_self">							
<table border="1" cellpadding="1">
						<tr COLSPAN=3>
							<td colspan="3">Other Info:</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Currently:</td>
							<td>Change To:</td>
						</tr>
<tr>
							<td>Travel Type</td>
							<td><?php echo $user_travel_type; ?></td>
							<td>Timed -<input type="radio" name="travel_type" value="0" /><br /> 
							Instant -<input type="radio" name="travel_type" value="1" /></td>
						</tr>
						<tr>
							<td>Battle type:</td>
							<td> 0 or 1</td>
							<td>Manual -<input type="radio" name="battle_type" value="0" /><br /> 
							Auto -<input type="radio" name="battle_type" value="1" /></td>
						</tr>
						<tr COLSPAN=3>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td><input name="submit2" type="submit" value="Change" /></td>
					  </tr>					
                      </table>

</form>				


					<form action="usermgmt.php" method="post">
					<table border="1" cellpadding="1">
                        <tr COLSPAN=3>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
						<tr COLSPAN=3>
							<td>account type.</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr COLSPAN=3>
							<td>donations or transaction history.</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr COLSPAN=3>
							<td align="right">admin privileges/links</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr COLSPAN=3>
						  <td align="right">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
						<tr COLSPAN=3>
						  <td align="right">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td><input name="submit3" type="submit" value="Change" /></td>
					  </tr>
					</table>
</form>
					
					<br />
					
					<?php
					
					

					
					
				
			
				echo "<br /><br />-------------------------------------------------------<br /><br />";
			
			
			
			
			
			
			
			// from inventory_inc - below... left for the moment in case i need anything...
			
			
			// do not display the move link if the veh is not at the same location as the base/hangar
				if(($vehicle_loc_x == $user_home_x) && ($vehicle_loc_y == $user_home_y)){
				// set the submit button here
				$button_value = "<input type='button' value='-->' onClick='return submit_form(this.form)'>";
				}else{
				// veh is not at the home location - set this to an X or something to indicate cannot move unless at home location
				$button_value = "X";
				echo "Cannot move items between Vehicles and Hangar unless the Vehicle is at the Hangar location.<br />";
				}
			
			$query = "SELECT * FROM tbl_items WHERE item_user_id = '$user_id' and item_status = '1' and item_location = '$vehicle_location'";
    		$vehinventresults =  mysql_query($query) or die('Query failed. ' . mysql_error());

			echo "<br />";
			echo '<table border="1" cellpadding="1"><tr><td>';  // start outer table
			echo '<table border="1" cellpadding="1">';  // start table 1
			
			
			echo '<tr><td COLSPAN=5>In your Veh Inventory: </td></tr>';
			echo '<tr><td>ID</td><td>TypeId</td><td>Qty</td><td>&nbsp;</td><td>Move</td></tr>';
			$i = 0;
			while($vehinvent = mysql_fetch_array($vehinventresults,MYSQL_ASSOC)){
			$i++;
			echo '<form name="form'.$i.'" method="post" action="actions.php"><tr>';
			echo '<td>'.$vehinvent["item_id"].'<input type="hidden" name="item_id" value="'.$vehinvent["item_id"].'"></td>';
			echo "<td>".$vehinvent['item_type_id']."</td>";
			echo '<td>'.$vehinvent["item_qty"].'<input type="hidden" name="max_qty" value="'.$vehinvent["item_qty"].'"></td>';
			echo '<td><input type="text" size="4" name="move_qty" value="'.$vehinvent["item_qty"].'"></td>';
			echo '<td>';
			// hidden parameters passed depending on where the items are being moved from / to...
			echo '<input type="hidden" name="action" value="move_invent">';
			echo '<input type="hidden" name="referer" value="inventory.php">';
			echo '<input type="hidden" name="from_loc" value="'.$vehicle_location.'">';
			echo '<input type="hidden" name="to_loc" value="'.$user_home_location_1.'">';
			// dont display button if veh is not at base/hangar location
			echo $button_value;
			
			echo '&nbsp;</td></tr></form>';
			}
			
			echo '</table>'; // end table 1
			echo '</td>';
			
			echo '<td>&nbsp; </td>'; // middle column spacer td
			echo '<td>&nbsp;';
			
			echo '<table border="1" cellpadding="1">';  // start table 2
			
				if(($vehicle_loc_x == $user_home_x) && ($vehicle_loc_y == $user_home_y)){
				// set the submit button here
				$button_value = "<input type='button' value='<--' onClick='return submit_form(this.form)'>";
				}else{
				// veh is not at the home location - set this to an X or something to indicate cannot move unless at home location
				$button_value = "X";
				}

			$query = "SELECT * FROM tbl_items WHERE item_user_id = '$user_id' and item_status = '1' and item_location = '$user_home_location_1'";
    		$homeinventresults =  mysql_query($query) or die('Query failed. ' . mysql_error());
			
			// for now - since this is not yet dynamic - set the max move amount from inventory to the vehicle this way....
			$max_move_amt = $vehicle_max_cargo - $vehicle_current_cargo;
			
			echo '<tr><td COLSPAN=5>In your Home Base / Hangar: </td></tr>';
			echo '<tr><td>ID</td><td>TypeId</td><td>Qty</td><td>&nbsp;</td><td>Move</td></tr>';
			$i = 0;
			while($homeinvent = mysql_fetch_array($homeinventresults,MYSQL_ASSOC)){
			$i++;
			$homeinvent_item_id = $homeinvent["item_id"];
			$homeinvent_item_type_id = $homeinvent['item_type_id'];
			$homeinvent_item_qty = $homeinvent["item_qty"];
			echo '<form name="form'.$i.'" method="post" action="actions.php"><tr>';
			echo '<td>'.$homeinvent_item_id.'<input type="hidden" name="item_id" value="'.$homeinvent_item_id.'"></td>';
			echo "<td>".$homeinvent_item_type_id."</td>";
			$homeinvent_item_qty_max = $homeinvent_item_qty;
			if($max_move_amt < $homeinvent_item_qty){
				$homeinvent_item_qty_max = $max_move_amt;
			}
			echo '<td>'.$homeinvent_item_qty.'<input type="hidden" name="max_qty" value="'.$homeinvent_item_qty_max.'"></td>';
			echo '<td><input type="text" size="4" name="move_qty" value="'.$homeinvent_item_qty_max.'"></td>';
			echo '<td>';
			// hidden parameters passed depending on where the items are being moved from / to...
			echo '<input type="hidden" name="action" value="move_invent">';
			echo '<input type="hidden" name="referer" value="inventory.php">';
			echo '<input type="hidden" name="from_loc" value="'.$user_home_location_1.'">';
			echo '<input type="hidden" name="to_loc" value="'.$vehicle_location.'">';
			// dont display button if veh is not at base/hangar location
			echo $button_value;
			
			echo '&nbsp;</td></tr></form>';
			}
			
			echo '</table>'; // end table 2
			
			echo '</td></tr></table>'; // end outer table


?>