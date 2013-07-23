<?php
// Start the session
session_save_path("/home/users/web/b746/sl.i1savage/public_html/cgi-bin/tmp");
session_start();
setcookie("PHPSESSION",$_COOKIE['PHPSESSION'],time()+1800);

// is the one accessing this page logged in or not?
//if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, move to login page
//	header('Location: expired.php');
//	exit;
//}

$errorMessage = '';
$user_type = 1;
if (isset($_POST['username']) && isset($_POST['password'])) {
	include 'mods/config.php';
	include 'mods/opendb.php';
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// check if the user id and password combination exist in database
	$sql = "SELECT *
	        FROM tbl_users
			WHERE user_name = '$username' AND user_password = '$password'";
	
	$result = mysql_query($sql) or die('Query failed. ' . mysql_error()); 
	
	$userinfo = mysql_fetch_array($result,MYSQL_ASSOC);
		$user_id = $userinfo['user_id'];
	
	if (mysql_num_rows($result) == 1) {
		// the user id and password match, 
		// set the session
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user_id;

		// get the ip address
		$last_ip = getenv('REMOTE_ADDR');

		// adjust the login count +1 and update the activity and IP address
		$sqlup = "UPDATE tbl_users SET login_count = login_count + 1, activity_count = activity_count + 1 , last_ip = '$last_ip', last_active = NOW() WHERE user_id = '$user_id' LIMIT 1";
 		
		$resultup = mysql_query($sqlup) or die('Query failed. ' . mysql_error()); 

	// update the login table for ip tracking...
	$sqlinsert = "INSERT INTO tbl_login_tracking 
	        (user_id, ip_address, datetime)
			VALUES('$user_id', '$last_ip', NOW())";
	
	$resultinsert = mysql_query($sqlinsert) or die('Query failed. ' . mysql_error()); 

		// after login we move to the main page
		header('Location: index.php');
		exit;
	} else {
		$errorMessage = 'Sorry, wrong user id / password';
	}
	
	//include 'mods/closedb.php';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php
include 'mods/sitename.php';
?>
</title>
<link rel="stylesheet" href="mods/gold.css" type="text/css" />

<script language="JavaScript" type="text/JavaScript">
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
<div id="map">
The map.
<?php
include 'minimap.php';
?>
</div>

<div id="banner">
The banner and whatnot... ofcourse.
<?php
include 'banner.php';
?>
</div>

<div id="nav">
  <p>
      <?php
include 'nav.php';
?>

  </p>
</div>

<div id="content">
<?php
if ($errorMessage != '') {
?>
<p><strong><font color="#990000"><?php echo $errorMessage; ?></font></strong></p>
<?php
}
?>
<form action="" method="post" name="frmLogin" id="frmLogin">
 <table border="1">
  <tr>
   <td>User Name:</td>
   </tr>
  <tr>
    <td><input name="username" type="text" id="username"></td>
    </tr>
  <tr>
   <td>Password:</td>
   </tr>
  <tr>
    <td nowrap><input name="password" type="password" id="password"></td>
    </tr>
  <tr>
   <td align="right" nowrap><input name="btnLogin" type="submit" id="btnLogin" onClick="YY_checkform('frmLogin','elguser','#q','0','Please enter a username.','password','#q','0','Please enter your password.');return document.MM_returnValue" value="Login"></td>
   </tr>
 </table>
</form>

  <p>Blah, Blah, Blah...</p>
  <p>yep, i said some stuff b4, now i'll say some more...</p>
  <p>the latest is that i'm ditching Dot5... and this in now in a sub folder of the savage fam site. we'll see how things go. maybe this will get its own site. </p>
  <p>Thanks,</p>
<p>Admin</p>
</div>
</body>
</html>
