<?php

// db properties
$dbhost = 'i1savage.startlogicmysql.com';
$dbuser = 'rebirth1'; 
$dbpass = 'st9rmt0y';
$dbname = 'rebirth1';

//# FileName="Connection_php_mysql.htm"
//# Type="MYSQL"
//# HTTP="true"
//$hostname_Rebirth1 = "i1savage.startlogicmysql.com";
//$database_Rebirth1 = "rebirth1";
//$username_Rebirth1 = "rebirth1";
//$password_Rebirth1 = "st9rmt0y";
//$Rebirth1 = mysql_pconnect($hostname_Rebirth1, $username_Rebirth1, $password_Rebirth1) or trigger_error(mysql_error(),E_USER_ERROR); 

$conn = mysql_connect ($dbhost, $dbuser, $dbpass) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($dbname);

		
		// update user energy every 5 min
	$sql = "SELECT *
	        FROM tbl_users
			WHERE user_energy < user_max_energy";
	
	$result = mysql_query($sql) or die('Query failed. ' . mysql_error()); 

			while($resultfetch = mysql_fetch_array($result,MYSQL_ASSOC)){
				$user_id = $resultfetch['user_id'];
			$query = "UPDATE tbl_users SET user_energy = user_energy + 1 WHERE user_id = '$user_id' LIMIT 1";
    		$adjenergy =  mysql_query($query) or die('Query failed. ' . mysql_error());
			}

			
	$sql2 = "SELECT *
	        FROM tbl_vehicles";
	
	$result2 = mysql_query($sql2) or die('Query failed. ' . mysql_error()); 

			while($resultfetch2 = mysql_fetch_array($result2,MYSQL_ASSOC)){
				if($resultfetch2['vehicle_shield_hp'] < $resultfetch2['vehicle_max_shield_hp']){
				$vehicle_id = $resultfetch2['vehicle_id'];
				$new_vehicle_shield_hp = $resultfetch2['vehicle_shield_hp'] + $resultfetch2['vehicle_shield_regen'];
				if($new_vehicle_shield_hp > $resultfetch2['vehicle_max_shield_hp']){
				$new_vehicle_shield_hp = $resultfetch2['vehicle_max_shield_hp'];
				}
			$query3 = "UPDATE tbl_vehicles SET vehicle_shield_hp = '$new_vehicle_shield_hp' WHERE vehicle_id = '$vehicle_id' LIMIT 1";
    		$adjshield =  mysql_query($query3) or die('Query failed. ' . mysql_error());
				}
			}
?>

<p>Cron1.  </p>
<p>This cron updates user energy and vehicle shields.  </p>
<p>Done.  </p>
