<?php
// find out the path to the current file:
  $current_path = $_SERVER['SCRIPT_NAME'];
  $file_name = substr_replace($current_path,'',0,1);
  
	// see if the user can access this page...
	$sql = "SELECT *
	        FROM tbl_links
			WHERE link_lvl <= '$user_type' and link = '$file_name'";
	
	$result = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
	
	$pagesecurityresult = mysql_fetch_array($result,MYSQL_ASSOC);
		$page_id = $pagesecurityresult['id'];
	if (mysql_num_rows($result) == 1) {
		// this page is available to the user, dont kick them out
		$access = 'Yes!';
		}else{
		$access = 'No!';
	header('Location: index.php');
	exit;
		}
?>