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




// -------------------------------			
Used in file:  LoginOut.php
Used in function:  Login2

Variables passed to hook function:  $_REQUEST['user'], $_REQUEST['hash_passwrd'], $modsettings['cookieTime']
Variables expected from hook function: true, false, or 'retry'.

Usage:  This hook is started before checking for a valid SMF user on login.  This gives the integrated application a chance to use the login credentials before SMF does.  Something to keep in mind is that SMF hashes the password in SHA1 on the client side, so an unhashed password is not available to this function.

A value of true or false returned from the function will continue as normal, and a value of 'retry' will redisplay the login form, with the message "Password security has recently been upgraded.  Please login again."

Example of use:  A user that exists in the integrated application but not in SMF is attempting to login, so needs to ber migrated to SMF before SMF has a chance to authenticate.  Something to keep in mind here is that SMF can authenticate with many other types of hashes, so the hashed passwords of other systems can typically be written directly to the SMF members table, with the hook returning 'retry', which will automatically invoke SMF to rewrite to its own hash on the second login attempt.		
// -------------------------------------
			
		
		

	header('Location: /forum/index.php');
		
		
		
		}



// need to get the previous page path - so can redirect to correct page with whatever messages might be returned...



// setup redirect via the header Location: xxxxx.php method...
echo 'Nothing should display on this page... so somthing may be wrong here... '.$_POST["referer"].'';
?>