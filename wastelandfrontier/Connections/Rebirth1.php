<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Rebirth1 = "i1savage.startlogicmysql.com";
$database_Rebirth1 = "rebirth1";
$username_Rebirth1 = "rebirth1";
$password_Rebirth1 = "st9rmt0y";
$Rebirth1 = mysql_pconnect($hostname_Rebirth1, $username_Rebirth1, $password_Rebirth1) or trigger_error(mysql_error(),E_USER_ERROR); 
?>