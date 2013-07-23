<?php
// comment added in c9.io - testing sync settings...


		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';
		include_once 'vehicleinfo.php';
		include_once 'userinfo.php';


		
			
		
		// pull mob info from $_POST[mob_id]
			// make sure mob still exists or is not locked by someone else
			$mob_id = $_POST['mob_id'];
				$mobsql = "SELECT *
						FROM tbl_mobs, tbl_mob_types
						WHERE tbl_mobs.mob_type = tbl_mob_types.mob_type_id and mob_id = '$mob_id'";
			$mobresult = mysql_query($mobsql) or die('Query failed. ' . mysql_error()); 
			$mobinfo = mysql_fetch_array($mobresult,MYSQL_ASSOC);
			
				// check for mob lock - see if it is the user id - allow to proceed
					// if lock is 0, set to user id.
					// if lock is not 0 or not the user id, do not allow the battle :)
				
				$mob_lock_id = $mobinfo['mob_lock_id'];
				if(($mob_lock_id = 0) or ($mob_lock_id = $user_id)){// mob lock correct begin
				if($mob_lock_id = 0){
					// update if it is zero - so it will be locked
				$mobsqllock = "UPDATE tbl_mobs SET mob_lock_id = '$user_id' WHERE mob_id = '$mob_id' LIMIT 1";
				$mobresultlock = mysql_query($mobsqllock) or die('Query failed. ' . mysql_error()); 
				}
				
								
				// check mob and vehicle locations
				$mob_loc_x = $mobinfo['mob_loc_x'];
				$mob_loc_y = $mobinfo['mob_loc_y'];
				if(($mob_loc_x = $vehicle_loc_x) and ($mob_loc_y = $vehicle_loc_y)){// locations match - proceed
					

				$mob_loot_group = $mobinfo['mob_type_loot_group'];
				// if mult drops are allowed - no for now - only 1.
				$mob_loot_qty = $mobinfo['mob_type_loot_qty'];

				$mob_hp = $mobinfo['mob_hp'];
				$mob_shield_hp = $mobinfo['mob_shield_hp'];
				
				$new_mob_hp = $mob_hp;
				$new_mob_shield_hp = $mob_shield_hp;
				
				$mob_attack_min = $mobinfo['mob_attack_min'];
				$mob_attack_max = $mobinfo['mob_attack_max'];
				$mob_attack_speed = $mobinfo['mob_attack_speed'];
				$mob_defense = $mobinfo['mob_defense'];
				
				$mob_exp = $mobinfo['mob_exp'];
				$mob_credits = $mobinfo['mob_credits'];
				$mob_level = $mobinfo['mob_level'];
				$mob_rarity = $mobinfo['mob_rarity'];
				
				// echo 'Mob ID is :' . $_POST['mob_id'] . '.<br />';
		
		// get vehicle info from vehicleinfo include
		
		$vehicle_core_hp = $vehiclelocation['vehicle_core_hp'];
		$vehicle_armor_hp = $vehiclelocation['vehicle_armor_hp'];
		$vehicle_shield_hp = $vehiclelocation['vehicle_shield_hp'];
		$vehicle_shield_regen = $vehiclelocation['vehicle_shield_regen'];
		$vehicle_attack_min = $vehiclelocation['vehicle_attack_min'];
		$vehicle_attack_max = $vehiclelocation['vehicle_attack_max'];
		$vehicle_attack_speed = $vehiclelocation['vehicle_attack_speed'];
		$vehicle_defense = $vehiclelocation['vehicle_defense'];
		
		$new_vehicle_shield_hp = $vehicle_shield_hp ;
		$new_vehicle_armor_hp = $vehicle_armor_hp ;
		$new_vehicle_core_hp = $vehicle_core_hp ;


			// declare the globals?
			global $mob_hp,$mob_shield_hp,$mob_attack_min,$mob_attack_max,$mob_attack_speed,$mob_defense;
			global $vehicle_core_hp,$vehicle_armor_hp,$vehicle_shield_hp,$vehicle_attack_min,$vehicle_attack_max,$vehicle_attack_speed,$vehicle_defense;
			global $new_vehicle_shield_hp,$new_vehicle_armor_hp,$new_vehicle_core_hp,$new_mob_shield_hp,$new_mob_hp;
			global $m_attack,$m_attack_fin,$m_attack_rem1,$m_attack_rem2;
			global $v_attack,$v_attack_fin,$v_attack_rem;

// a couple functions?
function m_attack_v()
{
			global $mob_hp,$mob_shield_hp,$mob_attack_min,$mob_attack_max,$mob_attack_speed,$mob_defense;
			global $vehicle_core_hp,$vehicle_armor_hp,$vehicle_shield_hp,$vehicle_attack_min,$vehicle_attack_max,$vehicle_attack_speed,$vehicle_defense;
			global $new_vehicle_shield_hp,$new_vehicle_armor_hp,$new_vehicle_core_hp,$new_mob_shield_hp,$new_mob_hp;
			global $m_attack,$m_attack_fin,$m_attack_rem1,$m_attack_rem2;
			global $v_attack,$v_attack_fin,$v_attack_rem;
	
						$m_attack = rand($mob_attack_min, $mob_attack_max);
						$m_attack_fin = $m_attack - $vehicle_defense;
						if($m_attack_fin < 0){ $m_attack_fin = 0;}
						echo 'The mob attacks you for ' . $m_attack_fin . ' points of damage.<br /><br />';
						if($vehicle_shield_hp > 0){
							// veh has shield - take from it first
						$new_vehicle_shield_hp = $vehicle_shield_hp - $m_attack_fin;
							if($new_vehicle_shield_hp < 0){
								// if veh shield is less than 0, fix it and take leftover from HP
								$new_vehicle_shield_hp = 0;
								echo 'Your vehicle took ' . $vehicle_shield_hp . ' points shield damage.<br /><br />';
								$m_attack_rem1 = $m_attack_fin - $vehicle_shield_hp;
								$new_vehicle_armor_hp = $vehicle_armor_hp - $m_attack_rem1;
									if($new_vehicle_armor_hp < 0){
										// if veh armor less than 0 - set to 0 and take from the core
										$new_vehicle_armor_hp = 0;
										echo 'Your vehicle also took ' . $vehicle_armor_hp . ' points armor damage.<br />';
										$m_attack_rem2 = $m_attack_rem1 - $vehicle_armor_hp;
										$new_vehicle_core_hp = $vehicle_core_hp - $m_attack_rem2;
										echo 'Your vehicle also took ' . $m_attack_rem2 . ' points damage to the core structure.<br /><br />';
									}else{// if veh armor over 0, echo exact dmg to armor
									echo 'Your vehicle also took ' . $m_attack_fin . ' points armor damage.<br /><br />';
									}
							}else{//if veh shield over or = 0, echo exact dmg to shield
							echo 'Your vehicle took ' . $m_attack_fin . ' points shield damage.<br /><br />';
							}
						}elseif($vehicle_armor_hp > 0){
							// no veh shield - right into the armor hp
							$new_vehicle_armor_hp = $vehicle_armor_hp - $m_attack_fin;
								if($new_vehicle_armor_hp < 0){
									// if veh armor less than 0 - fix it too and take from the core
									$new_vehicle_armor_hp = 0;
									echo 'Your vehicle took ' . $vehicle_armor_hp . ' points armor damage.<br />';
									$m_attack_rem = $m_attack_fin - $vehicle_armor_hp;
									$new_vehicle_core_hp = $vehicle_core_hp - $m_attack_rem;
									echo 'Your vehicle also took ' . $m_attack_rem . ' points damage to the core structure.<br /><br />';
								}else{// if veh armor over 0, echo exact dmg to armor
								echo 'Your vehicle took ' . $m_attack_fin . ' points armor damage.<br /><br />';
								}
						}else{
							// no veh shield or armor - right into the core hp - expensive!
							$new_vehicle_core_hp = $vehicle_core_hp - $m_attack_fin;
							echo 'Your vehicle took ' . $m_attack_fin . ' points damage to the core structure.<br /><br />';
						}
}

function v_attack_m()
{
			global $mob_hp,$mob_shield_hp,$mob_attack_min,$mob_attack_max,$mob_attack_speed,$mob_defense;
			global $vehicle_core_hp,$vehicle_armor_hp,$vehicle_shield_hp,$vehicle_attack_min,$vehicle_attack_max,$vehicle_attack_speed,$vehicle_defense;
			global $new_vehicle_shield_hp,$new_vehicle_armor_hp,$new_vehicle_core_hp,$new_mob_shield_hp,$new_mob_hp;
			global $m_attack,$m_attack_fin,$m_attack_rem1,$m_attack_rem2;
			global $v_attack,$v_attack_fin,$v_attack_rem;
	
					$v_attack = rand($vehicle_attack_min, $vehicle_attack_max);
					$v_attack_fin = $v_attack - $mob_defense;
					if($v_attack_fin < 0){ $v_attack_fin = 0;}
					echo 'You attack the mob for ' . $v_attack_fin . ' points of damage.<br /><br />';
					//echo 'veh attack min/max: ' . $vehicle_attack_min . '/' . $vehicle_attack_max . ' points of damage.<br />';
					//echo 'Mob shield ' . $mob_shield_hp . ' points of damage.<br />';
					if($mob_shield_hp > 0){
						// mob has shield - take from it first
					  $new_mob_shield_hp = $mob_shield_hp - $v_attack_fin;
						if($new_mob_shield_hp < 0){
						  // if mob shield is less than 0, fix it and take leftover from HP
						  $new_mob_shield_hp = 0;
						
						  $v_attack_rem = $v_attack_fin - $mob_shield_hp;
						  $new_mob_hp = $mob_hp - $v_attack_rem;
						}
						
					  }else{
						// no mob shield - right into the hp
						$new_mob_hp = $mob_hp - $v_attack_fin;
					  }
}
function show_v_rem()
{
			global $mob_hp,$mob_shield_hp,$mob_attack_min,$mob_attack_max,$mob_attack_speed,$mob_defense;
			global $vehicle_core_hp,$vehicle_armor_hp,$vehicle_shield_hp,$vehicle_attack_min,$vehicle_attack_max,$vehicle_attack_speed,$vehicle_defense;
			global $new_vehicle_shield_hp,$new_vehicle_armor_hp,$new_vehicle_core_hp,$new_mob_shield_hp,$new_mob_hp;
			global $m_attack,$m_attack_fin,$m_attack_rem1,$m_attack_rem2;
			global $v_attack,$v_attack_fin,$v_attack_rem;
	
echo 'Your vehicle retains ' . $new_vehicle_shield_hp . ' points of shield protection.<br />';
echo 'Your vehicle retains ' . $new_vehicle_armor_hp . ' points of armor protection.<br />';
echo 'Your vehicle retains ' . $new_vehicle_core_hp . ' points of core structure.<br /><br />';
}
function show_m_rem()
{
			global $mob_hp,$mob_shield_hp,$mob_attack_min,$mob_attack_max,$mob_attack_speed,$mob_defense;
			global $vehicle_core_hp,$vehicle_armor_hp,$vehicle_shield_hp,$vehicle_attack_min,$vehicle_attack_max,$vehicle_attack_speed,$vehicle_defense;
			global $new_vehicle_shield_hp,$new_vehicle_armor_hp,$new_vehicle_core_hp,$new_mob_shield_hp,$new_mob_hp;
			global $m_attack,$m_attack_fin,$m_attack_rem1,$m_attack_rem2;
			global $v_attack,$v_attack_fin,$v_attack_rem;
	
echo 'The Mob retains ' . $new_mob_shield_hp . ' points of shield protection.<br />';
echo 'The Mob retains ' . $new_mob_hp . ' hit points.<br /><br />';
}

		
		
		// check for battle type - in user info - user_battle_type,  auto=0, manual=1
		// ********************* battle if in this wrapper for auto or manual
		if($user_battle_type = 1){//begin manual wrapper
		
		// if manual, set some ssession vars to handle the battle text? 
				// update the veh/mob stats each round though...
				
				// in manual mode - attack speed determines first attack, 
				// its just 1 for 1 attacks, so speed doesnt reeally get to stack to the faster attacker's benefit
				// they do however get the benefit of first attack each time... nice for them :)
				
				if($vehicle_attack_speed < $mob_attack_speed){
					// vehicle attacks first 
					
					v_attack_m();
					
					show_m_rem();
					
					// mob attacks second if not dead...
					if($new_mob_hp <= 0){
						// mob is dead - end battle
						$new_mob_hp = 0;
						echo 'The mob has been killed dead. /celebrate.<br /><br />';
					}else{
						
						m_attack_v();
						
						show_v_rem();
					}
					
				}else{
					// mob attacks first
					m_attack_v();
					
					show_v_rem();
					
					if($new_vehicle_core_hp <= 0){
						// you is dead - end battle
						$new_vehicle_core_hp = 0;
						echo 'You has been killed dead. /cry. <br /><br />';
					}else{
						
						v_attack_m();
						
						show_m_rem();
					}
					
				}
				
				
				// if mob and user not dead - give attack again button?
				
				if(($new_vehicle_core_hp > 0) and ($new_mob_hp > 0)){
				?>
                  <form action="battle.php" method="post" name="battleform">
                  <input name="mob_id" type="hidden" value="<?php echo $mob_id; ?>" />
                  <input name="submit" type="submit" value="Fight Again" />
                  </form>
				<?php
				
				
								echo "<br /><br />";
								
								}
				
				//$new_vehicle_shield_hp = $vehicle_shield_hp ;
				//$new_vehicle_armor_hp = $vehicle_armor_hp ;
				//$new_vehicle_core_hp = $vehicle_core_hp ;
				// update mob and user stats
				$vehsqlup = "UPDATE tbl_vehicles SET vehicle_core_hp = '$new_vehicle_core_hp', vehicle_armor_hp = '$new_vehicle_armor_hp', vehicle_shield_hp = '$new_vehicle_shield_hp' WHERE vehicle_id = '$vehicle_id' and vehicle_user_id = '$user_id' LIMIT 1";
				$vehresultup = mysql_query($vehsqlup) or die('Query failed. ' . mysql_error()); 
				
				//$new_mob_hp = $mob_hp;
				//$new_mob_shield_hp = $mob_shield_hp;
				$mobsqlup = "UPDATE tbl_mobs SET mob_hp = '$new_mob_hp', mob_shield_hp = '$new_mob_shield_hp' WHERE mob_id = '$mob_id' LIMIT 1";
				$mobresultup = mysql_query($mobsqlup) or die('Query failed. ' . mysql_error()); 
				
			
			//end manual wrapper	
		}else{//begin auto wrapper
		
		// for auto - use whiles and ifs :)
		
		
		}//end auto wrapper			
			
		// ********************** end of battle reached here - manual or auto
		
			// if user still alive - 
					if($new_mob_hp <= 0){
						// mob is dead - end battle
						// leave in the DB - let is be cleaned by the cron
							// leave lock in for lock id - salvaging before the cron cleans up...
						
						// create loot
							// pull loot in loot table from loot group, just pull item type id's
							// select from where - mob_loot_group = item_type_loot_group
								

				// test loot generation
						// create loot
						// currently only create one item if random allows,
						// eventually - some mobs can drop mult items... see mob_type_loot_qty vs item_type_loot_qty
							// pull loot in loot table from loot group, just pull item type id's
							// select from where - mob_loot_group = item_type_loot_group
								
								$lootsql = "SELECT item_type_id
								FROM tbl_item_types
								WHERE item_type_loot_group = $mob_loot_group";
								$lootresult = mysql_query($lootsql) or die('Query failed. ' . mysql_error()); 
								// $lootinfo = mysql_fetch_array($lootresult,MYSQL_ASSOC);

								$lootarray = array();
								while($lootinfo = mysql_fetch_array($lootresult,MYSQL_ASSOC)){
									// array_push($lootarray, $lootinfo[item_type_id]);
									$lootarray[] = $lootinfo[item_type_id];
									}
									
									// eventually pull this padding from the %'s for the drop chance...
									$padding = 5;
									$i = 0;
									while($i < $padding){
									// array_push($lootarray, $lootinfo[item_type_id]);
									$lootarray[] = 0;
									$i = $i +1;
									}								
								// do shuffle() on that array
								shuffle($lootarray);
								echo "Random Loot id: ";
								$random1 = $lootarray[0];
								echo $random1;
								echo "<br /><br />";
								
								// if not a 0 - you get an item...
								if($random1 != 0){
								echo "You win loots!<br />";
								
								// for each item - need to get qty for insert - is in tbl_item_types
								$itemlootsql = "SELECT item_type_id, item_type_loot_qty
								FROM tbl_item_types
								WHERE item_type_id = $random1";
								$itemlootresult = mysql_query($itemlootsql) or die('Query failed. ' . mysql_error()); 
								$itemlootinfo = mysql_fetch_array($itemlootresult,MYSQL_ASSOC);
								$item_loot_qty = $itemlootinfo[item_type_loot_qty];
								
								// create item of the first type in the array
								// for now - just insert - no stacking items...
								$sqlinsert = "INSERT INTO tbl_items 
								(item_user_id, item_type_id, item_status, item_location, item_qty)
								VALUES('$user_id', '$random1', '1', '0', '$item_loot_qty')";
	
								$resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 
								
								}else{
								echo "No loot for you. -_- (signed - The Loot Natzi)<br />";
								}
								
								echo "<br /><br />";
								
								echo "Whole list - Random: <br />";
								foreach ($lootarray as $item_id) {
								echo "$item_id ";
								}
								echo "<br /><br />";


						
						// $mob_exp = $mobinfo['mob_exp'];
						// $mob_credits = $mobinfo['mob_credits'];
						
						// award credits if any
							// rand() from 0 to max credits\
							// plus x% from user's vendor skill?
							$plus_credits = $mob_credits + 0;
						
						// award exp also
							// flat amount + any bonuses to exp...
								// maybe a rested bonus?
								// pay/donator bonuses?
								$plus_exp = $mob_exp + 0;
								
						$new_user_gen_exp = $user_gen_exp + $plus_exp;
						$new_user_credits = $user_credits + $plus_credits;
						$query = "UPDATE tbl_users SET user_gen_exp = '$new_user_gen_exp', user_credits = '$new_user_credits' WHERE user_id = '$user_id' LIMIT 1";
						$adjustuser =  mysql_query($query) or die('Query failed. ' . mysql_error());
						
								
						$new_mob_hp = 0;
						echo 'You have been awarded ' . $plus_credits . '/' . $plus_exp . ' - credits/exp. /celebrate.<br /><br />';
					}
			
			
			// if user died
				// still award exp
				
				
				
				}else{// locations dont match - throw error
				echo 'Either your vehicle has moved, or the mob has moved. Please check your location again.<br />';
				}// end location check

				}else{// mob lock not allowed - show error
				echo 'This mob is currently engaged by another user, check back in a few minutes.<br />';
				}// end mob lock not allowed




		echo 'Still in the works... anything that does show up here is not updated in the db yet... mob fights will be here soon :)';


?>