<?php

		include_once 'mods/mods/vehicleinfo.php';
		include_once 'mods/mods/userinfo.php';

// list generic vendors when looking or when at the location
// list special vendors only when in that location

// perhaps include faction? info from the start?


// get the location?

			$query = "SELECT * FROM tbl_vendors WHERE vendor_loc_x = '$vehicle_loc_x' and vendor_loc_y = '$vehicle_loc_y'";
    		$vendorresults =  mysql_query($query) or die('Query failed. ' . mysql_error());

			echo "<br />";
			echo '<table border="1" cellpadding="1">';  // start table
			
			
			echo '<tr><td COLSPAN=5>Found these Vendors: </td></tr>';
			echo '<tr><td>ID</td><td>Name</td><td>Loc_X</td><td>Loc_Y</td><td>Desc</td><td>Actions</td></tr>';
			while($vendors = mysql_fetch_array($vendorresults,MYSQL_ASSOC)){
				$vendor_loc_x = $vendors['vendor_loc_x'];
				$vendor_loc_y = $vendors['vendor_loc_y'];
			
			echo '<form method="post" action="vendordet.php"><tr>';
			echo '<td>'.$vendors["vendor_id"].'<input type="hidden" name="vendor_id" value="'.$vendors["vendor_id"].'"></td>';
			echo "<td>".$vendors['vendor_name']."</td>";
			echo "<td>".$vendor_loc_x."</td>";
			echo "<td>".$vendor_loc_y."</td>";
			echo "<td>".$vendors['vendor_desc']."</td>";
			echo '<td>';
			if ($vehiclestatus == 'Active' && $vehicle_loc_x == $vendor_loc_x && $vehicle_loc_y == $vendor_loc_y) {
			// echo '<a href="vendordet.php?vendor='.$vendors['vendor_id'].'">Buy / Sell </a>';
			echo "<input type='submit' value='Go' >";
			

			}
			echo '&nbsp;</td></tr></form>';
			}
			
			echo '</table>'; // end table


?>