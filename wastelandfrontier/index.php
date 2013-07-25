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

		$user_id = $_SESSION['user_id'];
		
		include 'mods/config.php';
		include 'mods/opendb.php';

		include 'mods/userinfo.php';
		
  $current_path = $_SERVER['SCRIPT_NAME'];
  $file_name = substr_replace($current_path,'',0,1);
		//include 'mods/pagesecurity.php';
		
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
include 'banner_inc.php';
?>
</div>

<div id="nav">
  <p>
      <?php
include 'nav_inc.php';
?>

  </p>
</div>

<div id="content">
  <p>
    <?php
include 'content.php';
?>
</p>
  <p>
    <?php
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// not logged in, include login script
echo 'Please sign in or <a href="register.php">Register here</a>. <br /><br />';
	include 'login.php';
}else{
echo "Thank you for logging in, $user_name.";

?>
  <p>To be honest, I'm not sure exactly what to say here...</p>
  <p>This game has been a hobby for 5 years off and on.<br/ ><br/ >
	I've finally got it in some sort of shape that is playable on a basic level.<br/ ><br/ >
	A rough description: The Planet is Earth several thousand years in the future.<br/ ><br/ >
	The planet's surface is now a wasteland (familiar post-apoc style :) ) although the reason is unclear at the moment.<br/ ><br/ >
	Sidenote: I actually wrote a NaNo novel about this in 2010, +50k words that was a sort of bridge between present day and this future point when the game is set.<br/ ><br/ >
	As far as the game is concerned - you begin in a vehicle - that vehicle is your avatar.<br/ ><br/ >
	This is pretty much text based at this point - images can be added easily so keep that in mind :).<br/ ><br/ >
	And if you've played any sort of MMO - alot will be familiar here in essence if not form.<br/ ><br/ ><br/ >
	
	In some cases its more proof-of-concept than fully functional, but here's what you can do at the moment:
	<ul>
		<li>Move around on the map - its cartesian style x,y coords. </li>
		<li>Mine things in the mining nodes - you do get mining experience. </li>
		<li>Kill things - yes, you get general experience for this also. </li>
		<li>Craft/Manufacture things: Smelting, Refining, Mods/Parts Crafting etc.</li>
		<li> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  (very few recipes exist so far) but you get experience for these and will be able to unlock more later.</li>
		<li>Sell things to Vendors </li>
		<li>Move inventory b/t vehicle and base/hangar. </li>
		<li> </li>
		<li> </li>
	</ul>
  </p>
  <p>I have alot in the works - the section below in the worklog will be updated regularly when I'm able to work 
on things.  At the moment - keep in mind this is a <strong><em>Rough</em></strong> Alpha :).  I do look forward to questions, comments and feed back in the forum!</p>
  <p>Thanks,</p>
<p>Admin</p>
		
  <p>&nbsp; 
      <?php
      include 'mods/worklog_inc.php';
}
      ?> </p>
  </p>


      <div id="footer">
      <?php
      include 'footer_inc.php';
      ?> 
      </div>


</div>
</body>
</html>
