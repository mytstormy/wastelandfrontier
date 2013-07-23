<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

if (isset($_POST['username']) && isset($_POST['password'])) {
	include 'mods/config.php';
	include 'mods/opendb.php';
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$email = $_POST['email'];
	$email2 = $_POST['email2'];
	$regcode = $_POST['regcode'];

	// check if the username exists in database
	$sql = "SELECT user_id 
	        FROM tbl_users
			WHERE user_name = '$username'";
	
	$result = mysql_query($sql) or die('Query failed. 1' . mysql_error()); 

	// check if the email address exists in database
	$sql2 = "SELECT user_id 
	        FROM tbl_users
			WHERE user_email = '$email'";
	
	$result2 = mysql_query($sql2) or die('Query failed. 2' . mysql_error()); 
	
	
	if (mysql_num_rows($result) == 1) {
		// the username is already in the DB,
		$errorMessage1 = 'Sorry, that username is already taken...';
	} elseif (mysql_num_rows($result2) == 1) {
		// the email address is already in the DB,
		$errorMessage2 = 'Sorry, that email address is already in use by a Member.';
	} elseif ($regcode != 'alpha1') {
		// the regcode is wrong
		$errorMessage3 = 'Sorry, the registration code is not correct.';
	} else {
	// insert the new user into the db
	$sqlinsert = "INSERT INTO tbl_users 
	        (user_name, user_password, user_email, date_created, last_active, user_type, user_gmt_offset, skill_points, activity_points, user_status, user_energy, user_max_energy, user_credits)
			VALUES('$username', '$password', '$email', NOW(), NOW(), '3', '0', '0', '1', '1', '50', '250', '25000')";
	
	$resultinsert = mysql_query($sqlinsert) or die('Query failed. insert1' . mysql_error()); 
	
		// get user id - need it to create a vehicle
			$sql3 = "SELECT user_id 
				FROM tbl_users
				WHERE user_name = '$username'";
	
			$result3 = mysql_query($sql3) or die('Query failed. 3' . mysql_error()); 
			$userresults3 =  mysql_fetch_array($result3,MYSQL_ASSOC);
			$userid = $userresults3[user_id];
			
			// get basic vehicle to insert - may be able to choose this later on
				// can atleast change it in the script here for the default veh
				
			$sql4 = "SELECT * 
				FROM tbl_vehicle_types
				WHERE vehicle_type_id = '1'";
	
			$result4 = mysql_query($sql4) or die('Query failed. 4' . mysql_error()); 
			$vehresults4 =  mysql_fetch_array($result4,MYSQL_ASSOC);

			
				$vehicle_type = $vehresults4[vehicle_type_id]; 
				
				// starting location - dertermined by questionaier later
				// vehicle_location = $vehresults4[vehicle_loc_x]; 
				$vehicle_location = 0; 
				$vehicle_loc_x = 0; 
				$vehicle_loc_y = 0; 
				
				$vehicle_current_cargo = 0; 
				$vehicle_max_cargo = $vehresults4[vehicle_type_base_cargo]; 
				$vehicle_speed = $vehresults4[vehicle_type_base_speed]; 
				$vehicle_core_hp = $vehresults4[vehicle_type_base_core_hp]; 
				$vehicle_armor_hp = $vehresults4[vehicle_type_base_armor_hp]; 
				$vehicle_shield_hp = $vehresults4[vehicle_type_base_shield_hp]; 
				$vehicle_max_shield_hp = $vehresults4[vehicle_type_base_shield_hp]; 
				$vehicle_shield_regen = $vehresults4[vehicle_type_base_shield_regen]; 
				$vehicle_attack_min = $vehresults4[vehicle_type_base_attack_min]; 
				$vehicle_attack_max = $vehresults4[vehicle_type_base_attack_max]; 
				$vehicle_attack_speed = $vehresults4[vehicle_type_base_attack_speed]; 
				$vehicle_defense = $vehresults4[vehicle_type_base_defense];
			
			// create generic first vehicle
				$sqlinsert = "INSERT INTO tbl_vehicles 
					(vehicle_user_id, vehicle_type, vehicle_location, vehicle_loc_x, vehicle_loc_y, vehicle_active, vehicle_current_cargo, vehicle_max_cargo, vehicle_speed, vehicle_core_hp, vehicle_armor_hp, vehicle_shield_hp, vehicle_max_shield_hp, vehicle_shield_regen, vehicle_attack_min, vehicle_attack_max, vehicle_attack_speed, vehicle_defense)
					VALUES('$userid', '$vehicle_type', '$vehicle_location', '$vehicle_loc_x', '$vehicle_loc_y', '1', '$vehicle_current_cargo', '$vehicle_max_cargo', '$vehicle_speed', '$vehicle_core_hp', '$vehicle_armor_hp', '$vehicle_shield_hp', '$vehicle_max_shield_hp', '$vehicle_shield_regen', '$vehicle_attack_min', '$vehicle_attack_max', '$vehicle_attack_speed', '$vehicle_defense')";
	
				$resultinsert = mysql_query($sqlinsert) or die('Query failed. insert2' . mysql_error()); 
				
				
			// set user to logged in so they dont have to do it again
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $userid;
	
		// after insert we move to the firstlogin page
		header('Location: newusers.php');
		exit;
}
	include 'mods/closedb.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+s)}
  document.MM_returnValue = (s=='');
}
//-->
</script>
</head>

<body>
<form action="" method="post" name="frmRegister" id="frmRegister">
 <table border="1">
  <tr>
   <td nowrap>User Name </td>
   <td><input name="username" type="text" id="username" value="<?php echo $username ?>"></td>
   <td><?php echo $errorMessage1 ?></td>
  </tr>
  <tr>
    <td height="10" colspan="3" nowrap></td>
    </tr>
  <tr>
   <td nowrap>Email Address </td>
   <td><input name="email" type="text" id="email" value="<?php echo $email ?>"></td>
   <td><?php echo $errorMessage2 ?></td>
  </tr>
  <tr>
   <td nowrap>Verify Email Address</td>
   <td><input name="email2" type="text" id="email2" value="<?php echo $email2 ?>"></td>
   <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="10" colspan="3" nowrap></td>
    </tr>
   <tr>
   <td nowrap>Password</td>
   <td><input name="password" type="password" id="password" value="<?php echo $password ?>"></td>
   <td>&nbsp;</td>
   </tr>
 <tr>
   <td nowrap>Confirm Password</td>
   <td><input name="password2" type="password" id="password2" value="<?php echo $password2 ?>"></td>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td height="10" colspan="3" nowrap></td>
   </tr>
 <tr>
   <td width="150">Registration Code</td>
   <td><input name="regcode" type="text" id="regcode" value="<?php echo $regcode ?>"></td>
   <td><?php echo $errorMessage3 ?></td>
   </tr>
  <tr>
   <td nowrap>&nbsp;</td>
   <td><input name="btnLogin" type="submit" id="btnLogin" onClick="YY_checkform('frmRegister','username','#q','0','Field \'username\' is not valid.','email','S','2','Field \'email\' is not valid.','email2','#email','6','Field \'email2\' is not valid.','password2','#password','6','Field \'password2\' is not valid.');return document.MM_returnValue" value="Submit"></td>
   <td>&nbsp;</td>
  </tr>
 </table>
</form>


</body>
</html>