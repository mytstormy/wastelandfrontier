<?php
		include_once 'mods/vehicleinfo.php';
		include_once 'mods/userinfo.php';

		echo "Stats for: ";
		echo "<br />".$user_name."<br /><br />";
		echo "Vehicle:<br />";
		// Vehicle details
		echo "Name: ".$vehicle_type_name."<br />";
		
		//$vehicle_core_hp = $vehiclelocation['vehicle_core_hp'];
		echo "HP: ".$vehicle_core_hp."<br />";
		//$vehicle_armor_hp = $vehiclelocation['vehicle_armor_hp'];
		echo "Armor: ".$vehicle_armor_hp."<br />";
		//$vehicle_shield_hp = $vehiclelocation['vehicle_shield_hp'];
		//$vehicle_max_shield_hp = $vehiclelocation['vehicle_max_shield_hp'];
		echo "Shield (curr/max): ".$vehicle_shield_hp."/".$vehicle_max_shield_hp."<br />";
		//$vehicle_shield_regen = $vehiclelocation['vehicle_shield_regen'];
		echo "Shield Regen: ".$vehicle_shield_regen."<br />";
		//$vehicle_attack_min = $vehiclelocation['vehicle_attack_min'];
		//$vehicle_attack_max = $vehiclelocation['vehicle_attack_max'];
		echo "Attack (min/max): ".$vehicle_attack_min."/".$vehicle_attack_max."<br />";
		//$vehicle_attack_speed = $vehiclelocation['vehicle_attack_speed'];
		echo "Attack Speed: ".$vehicle_attack_speed."<br />";
		//$vehicle_defense = $vehiclelocation['vehicle_defense'];
		echo "Defense: ".$vehicle_defense."<br />";

		
		$vehicle_speed_mph = $vehicle_speed;
		// speed and modifier
		echo "Speed: ".$vehicle_speed_modifier."% of ".$vehicle_speed_mph."<br />";
		
		// rough inventory overview
		echo "Cargo: ".$vehicle_current_cargo."/".$vehicle_max_cargo."<br />";
		
		
		// vehicle location
		echo "Location: ".$vehicle_loc_x.",".$vehicle_loc_y."<br />";
		
		if(($vehicle_loc_x != $dest_x || $vehicle_loc_y != $dest_y) && $vehicle_arrival > time()){
		// travel status, and destination
		echo "Destination: ".$dest_x.",".$dest_y."<br /><br />";
		
		
			$remaining = $vehicle_arrival - time();
		echo "Arrival In: ".$remaining." sec<br />";
		}else{
		echo "Not traveling.<br />";
					echo 'Travel 
					<a href="actions.php?action=move&from='.$file_name.'&loc_x=0&loc_y=0">Home </a> <br /><br />';
		
		}
		
		
		echo "<br />";
		echo "User Related:<br />";
		
		echo "Credits: ".$user_credits."<br />";
		// energy from userinfo mod
		echo "Energy: ".$user_energy."<br />";
		
		
		// exp and level? progression?
		echo "Mining Exp: ".$user_mining_exp."<br />";
		echo "Crafting Exp: ".$user_crafting_exp."<br />";



?>