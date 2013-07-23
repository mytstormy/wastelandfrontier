<?php
// we must never forget to start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

		// end the session by unsetting and destroying...
		session_unset ();
		session_destroy ();

		// after logout we move back to the index page
		header('Location: ../index.php');
		exit;
?>
