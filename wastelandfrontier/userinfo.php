<?php
// here is where the code will be for the user info...

	// get the user's information
	$sql = "SELECT *
	        FROM tbl_users
			WHERE user_id = '$user_id'";
	
	$result = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
	
	$userinfo = mysql_fetch_array($result,MYSQL_ASSOC);
		$user_name = $userinfo['user_name'];
		$user_email = $userinfo['user_email'];
		$user_type = $userinfo['user_type'];
		$user_battle_type = $userinfo['user_battle_type'];
		$last_ip = $userinfo['last_ip'];
		$user_status = $userinfo['user_status'];
		$skill_points = $userinfo['skill_points'];
		$activity_points = $userinfo['activity_points'];
		$date_created = $userinfo['date_created'];
		$user_map_size = $userinfo['user_map_size'];
		$user_energy = $userinfo['user_energy'];
		$user_mining_exp = $userinfo['user_mining_exp'];	
		$user_gen_exp = $userinfo['user_gen_exp'];
		$user_crafting_exp = $userinfo['user_crafting_exp'];
		$user_credits = $userinfo['user_credits'];
		$user_home_x = $userinfo['user_home_x'];
		$user_home_y = $userinfo['user_home_y'];
		$user_home_location_1 = $userinfo['user_home_location_1'];
		
		?>