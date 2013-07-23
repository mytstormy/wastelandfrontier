<?php
/*
@Author = Kent Savage
*/

// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

// is the one accessing this page logged in or not?
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, move to login page
	header('Location: expired.php');
	exit;
}

		$user_id = $_SESSION['user_id'];
		
		include 'mods/config.php';
		include 'Connections/Rebirth1.php';

		include 'mods/opendb.php';

		include 'mods/userinfo.php';
		include 'mods/pagesecurity.php';


			// need to include or send all login variables for the forum...

			
//integrate_verify_user
//« Reply #5 on: May 26, 2007, 04:11:57 PM »
//Used in file:  Load.php
//Used in function:  loadUserSettings

//Variables passed to hook function:  None
//Variables expected from hook function: $ID_MEMBER (int)

//Usage:  This hook is started before checking the SMF cookie for a valid user.  A valid SMF $ID_MEMBER is expected back from the hook function, or SMF will assume it should check the SMF cookie instead.

//Example of use:  User is logged into a CMS, but not into SMF, so we want to auto-login to SMF without the SMF cookie.
			
			
		

	//header('Location: /forum/index.php');
		
		



// need to get the previous page path - so can redirect to correct page with whatever messages might be returned...



// setup redirect via the header Location: xxxxx.php method...
// echo 'Nothing should display on this page... so somthing may be wrong here... '.$_POST["referer"].'';

// in case needed by integration scripts
// first admin acct in the forum is wfforumadmin and wfforumE~$ pwd
?>

When the integration is done - this will be seamless.<br /> 
Until then, please create a new account on the forum with the same username / password as you have in the game.  <br />
If you have already done so, just continue to the Forum and login.<br /><br />

<a href="forum/index.php">Forum</a>