<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

// is the one accessing this page logged in or not?
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, move back to the index page
	header('Location: index.php');
	exit;
}

		//if reset var is used reset center vars to current vars.
		if (isset($_GET['reset'])) {
		unset($_GET['reset']);
		$_SESSION['center_loc_x'] = $_SESSION['current_loc_x'];
		$_SESSION['center_loc_y'] = $_SESSION['current_loc_y'];
		header('Location: maptest2.php');
		}

		//if insert var is used trigger insert for specific Land Type.
		if (isset($_GET['insert'])) {
		$insert_type = $_GET['insert'];
		$_SESSION['center_loc_x'] = $_SESSION['current_loc_x'];
		$_SESSION['center_loc_y'] = $_SESSION['current_loc_y'];
		
		unset($_GET['insert']);
		header('Location: maptest2.php');
		}


		//if center_loc_ is empty, we cant do anything... back to the index page... something is wrong...
	if (!isset($_GET['x']) || !isset($_GET['y'])) {
		//vars not set... do something about it?
		header('Location: index.php');
		}
		$_SESSION['center_loc_x'] = $_SESSION['center_loc_x']+$_GET['x'];
		$_SESSION['center_loc_y'] = $_SESSION['center_loc_y']+$_GET['y'];
		unset($_GET['x']);
		unset($_GET['y']);		
	header('Location: maptest2.php');
	exit;

?>