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

		

		// update and clean the nodes table
			// nodes have an age?  set randomly.  that will effectively clean it out periodically.
				// age is a random number from 25 - 100
				
					// decrement the age every hour for all nodes... or on cron2 run...
						  $nodequery = "SELECT * FROM tbl_nodes";
						  $getnodes =  mysql_query($nodequery) or die('Query failed. ' . mysql_error());
						// run 2 queries:
						// 1 - decrement all nodes
						while($decrementnodes = mysql_fetch_array($getnodes,MYSQL_ASSOC)){
						$node_id = $decrementnodes['node_id'];
						$node_age = $decrementnodes['node_age'];
						$query = "UPDATE tbl_nodes SET node_age = node_age - 1 WHERE node_id = '$node_id' LIMIT 1";
						$decrement =  mysql_query($query) or die('Query failed. ' . mysql_error());
						echo "Decremented node $node_id. Age was $node_age. <br />";
						}

						  $nodequery2 = "SELECT * FROM tbl_nodes";
						  $getnodes2 =  mysql_query($nodequery2) or die('Query failed. ' . mysql_error());
						// 2 - delete all where age = 0
						while($deletenodes = mysql_fetch_array($getnodes2,MYSQL_ASSOC)){
						$node_id = $deletenodes['node_id'];
						$node_age = $deletenodes['node_age'];
						if($node_age <= 0){
						$query = "DELETE FROM tbl_nodes WHERE node_id = '$node_id' LIMIT 1";
						$deletequery =  mysql_query($query) or die('Query failed. ' . mysql_error());
						echo "Deleted node $node_id. Age was $node_age. <br />";
						}
						}
						
						
				// still have some nodes be infinite - they will age and move though...
					// do this randomly?  or only on common and med-rare?  not on rare...
						// sounds good to me... that will be in the min/max node qty field?
						// some will be infinite always? or should that be in this part?
				
				
				// will be using a region tag in the maps db and in the item types db... also in mobs, but not rdy for that yet
				
				// for now - 
					// 1 = common mats / no mobs
					// 2 = common mats / easy mobs
					// 3 = med rare mats / med hard mobs
					// 4 = rare mats / dangerous mobs
					// 5 = pvp zone / no mats, only dangerous mobs
					
				// rarity tag in itemtypes db will be like a percentage - can be balanced at any time, can be added to also
					// will be used to create an array
						// for each mat - the rarity value will put that number of the item id in the array
						// for ex:  if copper is rarity = 5, we will put the item id of copper in the array 5 times
						// then use shuffle array and then array_rand to pick a random one from the array
						
					// with that method - the percentages of materials will be manageable...

				
				// decide how many nodes there will be - a percent?  like 75% of cells will have nodes?  
					// will depend on the region and we can set that here.
					
						  $mapquery = "SELECT * FROM tbl_map WHERE map_loc_x < '10' and map_loc_x > '-10' and  map_loc_y < '10' and map_loc_y > '-10'";
						  $getmap =  mysql_query($mapquery) or die('Query failed. ' . mysql_error());
						  $num_rows = mysql_num_rows($getmap);
						  $createnum = round($num_rows * .75);
						  echo "row count map cells'$num_rows'<br />";
						  $maparea = mysql_fetch_array($getmap,MYSQL_ASSOC);
						  shuffle($maparea);
						  reset($maparea);
						  
						  $nodequery = "SELECT * FROM tbl_nodes WHERE node_loc_x < '10' and node_loc_x > '-10' and  node_loc_y < '10' and node_loc_y > '-10'";
						  $getnodes =  mysql_query($nodequery) or die('Query failed. ' . mysql_error());
						  $num_rows = mysql_num_rows($getnodes);
						  echo "row count nodes '$num_rows'<br />";
						  
						  $rnode = array(1,2,3,4,4,4,4,4,7,7,7,9,9,10,10,11,11,13,14,15);
						  
								shuffle($rnode);
								$rnode1 = $rnode[0];
						  
						while($maparea = mysql_fetch_array($getmap,MYSQL_ASSOC)){
						$check = rand(0,100);
						if($check < 50){
								reset($rnode);
								shuffle($rnode);
								$rnode1 = $rnode[0];
						$loc_id = $maparea['map_loc_id'];
						$map_loc_x = $maparea['map_loc_x'];
						$map_loc_y = $maparea['map_loc_y'];
						
							$nodequery2 = "SELECT * FROM tbl_nodes WHERE node_loc_x = '$map_loc_x' and  node_loc_y = '$map_loc_y'";
						  	$getnodes2 =  mysql_query($nodequery2) or die('Query failed. ' . mysql_error());
						  	$num_rows2 = mysql_num_rows($getnodes2);						
						if($num_rows2 < 2){
						echo "Loc id '$loc_id' - '$map_loc_x','$map_loc_y', create node of $rnode1.<br />";
								$new_node_qty = (rand(15,50) * 100);
								$new_node_age = rand(75,125);
							  $nodeinsert = "INSERT INTO tbl_nodes 
							  (node_type, node_loc_x, node_loc_y, node_loc_z, node_qty, node_age)
							  VALUES('$rnode1', '$map_loc_x', '$map_loc_y', '1', '$new_node_qty', '$new_node_age')";
							  $resultnodeinsert = mysql_query($nodeinsert) or die('Query failed. ' . mysql_error()); 
						}else{ echo "2 or more nodes exist in this cell ****<br />"; }
						}else{
						echo "none on this node this time ....<br />";
						}
						}
									
					// get the number of cells in the region - num rows on the query should be easy enough
						
						// take the difference - set an $i for the while that will create the new nodes
						
					// use array_rand from the item types for this region
					
				// also - use array_rand on the array holding the cells with no node
					// getting the x,y from that array randomly will give us random nodes in the region...
						// i suppose its possible for it to put more than one node in the same cell
						// but that would be perfectly random, no?
						
					// run that for the number needed to hit target % of cells with nodes...
			
			echo "<br /><br />Nodes done - on to mobs <br /><br />";
			
			
			// mob updates
				// run 3 queries:
				// 1. increment age for mobs
						  $mobquery = "SELECT * FROM tbl_mobs";
						  $getmobs =  mysql_query($mobquery) or die('Query failed. ' . mysql_error());

						while($decrementmobs = mysql_fetch_array($getmobs,MYSQL_ASSOC)){
						$mob_id = $decrementmobs['mob_id'];
						$mob_age = $decrementmobs['mob_age'];
						$query = "UPDATE tbl_mobs SET mob_age = mob_age - 1 WHERE mob_id = '$mob_id' LIMIT 1";
						$decrement =  mysql_query($query) or die('Query failed. ' . mysql_error());
						echo "Decremented mob $mob_id. Age was $mob_age. <br />";
						}

						  $mobquery2 = "SELECT * FROM tbl_mobs";
						  $getmobs2 =  mysql_query($mobquery2) or die('Query failed. ' . mysql_error());
						// 2 - delete all where age = 0
						while($deletemobs = mysql_fetch_array($getmobs2,MYSQL_ASSOC)){
						$mob_id = $deletemobs['mob_id'];
						$mob_age = $deletemobs['mob_age'];
						if($mob_age <= 0){
						$query = "DELETE FROM tbl_mobs WHERE mob_id = '$mob_id' LIMIT 1";
						$deletequery =  mysql_query($query) or die('Query failed. ' . mysql_error());
						echo "Deleted node $mob_id. Age was $mob_age. <br />";
						}
						}

						  
				// remove dead mobs - the battle script leaves them there for us to clean up...
					// if mob life = 0 delete it
						  $mobquery3 = "SELECT * FROM tbl_mobs";
						  $getmobs3 =  mysql_query($mobquery2) or die('Query failed. ' . mysql_error());
						// 2 - delete all where age = 0
						while($deletemobs2 = mysql_fetch_array($getmobs3,MYSQL_ASSOC)){
						$mob_id = $deletemobs2['mob_id'];
						$mob_hp = $deletemobs2['mob_hp'];
						if($mob_hp <= 0){
						$query = "DELETE FROM tbl_mobs WHERE mob_id = '$mob_id' LIMIT 1";
						$deletequery =  mysql_query($query) or die('Query failed. ' . mysql_error());
						echo "Deleted node $mob_id. HP was $mob_hp. <br />";
						}
						}
				
				// if mob has a range - move it 1 cell in a random direction +/- x/y and decrement range counter
					// not gonna do this just yet - at some point maybe...
					
				// if mob life is less than max and has regen rate greater than 0, add regen amt each tick
					// this also is waiting for now...
				
				// for now - use %50 ratio for mobs to cell count - so for 100 cells - have 50 mobs... 
				
					// so - count all mobs inside +/- 10 x/y and divide by 2 = total.
						  $mobquery4 = "SELECT * FROM tbl_mobs WHERE mob_loc_x < '10' and mob_loc_x > '-10' and  mob_loc_y < '10' and mob_loc_y > '-10'";
						  $getmobs4 =  mysql_query($mobquery4) or die('Query failed. ' . mysql_error());
						  	$mobscount = mysql_num_rows($getmobs4);						

					// get list of mobs for the region - for now will be specified array
						// once is pulling from db - will push into array the mob type id's
						
						  $rmobs = array(1,1,1,2,2,3,3,3,4);
						  
								shuffle($rmobs);
								$rmobs1 = $rmobs[0];
							
						//do the while to create mobs in the cell range - 
						  $mapquery2 = "SELECT * FROM tbl_map WHERE map_loc_x < '10' and map_loc_x > '-10' and  map_loc_y < '10' and map_loc_y > '-10'";
						  $getmap2 =  mysql_query($mapquery2) or die('Query failed. ' . mysql_error());
						  $num_rows2 = mysql_num_rows($getmap2);
						  $createnum2 = round($num_rows2 * .25);
						  echo "row count map cells: $num_rows2 / create num: $createnum2 / current mob count: $mobscount <br />";
						if($mobscount < $createnum2){  

						  $mapquery3 = "SELECT * FROM tbl_map WHERE map_loc_x < '10' and map_loc_x > '-10' and  map_loc_y < '10' and map_loc_y > '-10'";
						  $getmap3 =  mysql_query($mapquery3) or die('Query failed. ' . mysql_error());
						while($maparea3 = mysql_fetch_array($getmap3,MYSQL_ASSOC)){
							$loc_id = $maparea3[map_loc_id];
							$loc_x = $maparea3[map_loc_x];
							$loc_y = $maparea3[map_loc_y];
							
						  	$rand1 = rand(1,100);	
						if($rand1 < 7){
						  $mobqueryint = "SELECT * FROM tbl_mobs WHERE mob_loc_x = '$loc_x' and mob_loc_y = '$loc_y'";
						  $getmob =  mysql_query($mobqueryint) or die('Query failed. ' . mysql_error());
							$mobexists = mysql_num_rows($getmob);
						if($mobexists < 1){
								reset($rmobs);
								shuffle($rmobs);
								$rmobs1 = $rmobs[0];
						  $mobcreate = "SELECT * FROM tbl_mob_types WHERE mob_type_id = '$rmobs1'";
						  $getmobcreate =  mysql_query($mobcreate) or die('Query failed. ' . mysql_error());
						  $c_mob = mysql_fetch_array($getmobcreate,MYSQL_ASSOC);
						  $c_mob_hp = $c_mob[mob_type_base_hp];
						  $c_mob_shield_hp = $c_mob[mob_type_base_shield_hp];
						  $c_mob_attack_min = $c_mob[mob_type_base_attack_min];
						  $c_mob_attack_max = $c_mob[mob_type_base_attack_max];
						  $c_mob_attack_speed = $c_mob[mob_type_base_attack_speed];
						  $c_mob_defense = $c_mob[mob_type_base_defense];
						  $c_mob_range = $c_mob[mob_type_base_range];
						  $c_mob_level = $c_mob[mob_type_base_level];
						  $c_mob_rarity = $c_mob[mob_type_base_rarity];
						  $c_mob_exp = $c_mob[mob_type_base_exp];
						  $c_mob_credits = $c_mob[mob_type_base_credits];
						  
						echo "Loc id $loc_id - $loc_x/$loc_y, create mob of $rmobs1.<br />";
								$new_mob_age = rand(100,150);
							  $mobinsert = "INSERT INTO tbl_mobs 
							  (mob_type, mob_loc_x, mob_loc_y, mob_age, mob_hp, mob_shield_hp, mob_attack_min, mob_attack_max, mob_attack_speed, mob_defense, mob_range, mob_level, mob_rarity, mob_exp, mob_credits)
							  VALUES('$rmobs1', '$loc_x', '$loc_y', '$new_mob_age', '$c_mob_hp', '$c_mob_shield_hp', '$c_mob_attack_min', '$c_mob_attack_max', '$c_mob_attack_speed', '$c_mob_defense', '$c_mob_range', '$c_mob_level', '$c_mob_rarity', '$c_mob_exp', '$c_mob_credits')";
							  $resultmobinsert = mysql_query($mobinsert) or die('Query failed. ' . mysql_error()); 
						}else{ echo "there is alread a mob in this cell ****<br />"; }
						}else{
						echo "no mob this time ....<br />";
						}
						  }
						  
						}else{
						echo "mob count for area exceeded at this time...<br />";
						}
								
					
					// foreach cell without a mob and while counter goes up to total needed created this time around and with a random generator per cell - 
						// create a random mob in random cells? somthing like that...
						
						
					// fin
				
			

?>
<p>Cron 2. </p>
<p>This cron updates mobs/nodes...</p>
<p>Still in the works...</p>
