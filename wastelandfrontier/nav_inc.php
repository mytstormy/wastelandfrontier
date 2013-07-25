<style type="text/css">
<!--
.style2 {font-size: 12px}
-->
</style>
<span class="style2">
<table border="0" cellspacing="2">
      <tr>
        <td><strong>Navigation</strong></td>
  </tr>      
     <tr>
        <td><a href="index.php">Home</a> </td>
     </tr>
		 <?php
		 $i = 0;
	if(isset ($user_type)){
	// good, else...
	$good = "Good!";
	}else{
	$user_type = 1;
	}
	// get the links the user is allowed to use below lvl 5
	$sql_links = "SELECT id, link_name, link, link_lvl, link_group
	        FROM tbl_links
			WHERE link_lvl <= '$user_type' and link_lvl < 5 and link_hidden = 0
			ORDER BY link_group, link_order DESC";
	
	$result_links = mysql_query($sql_links) or die('Query failed. ' . mysql_error()); 
	
	while($list_links = mysql_fetch_array($result_links,MYSQL_ASSOC)){
	$link_name = $list_links['link_name'];
	$link = $list_links['link'];
	$link_lvl = $list_links['link_lvl'];
	$link_group = $list_links['link_group'];
	$link_id = $list_links['id'];
	
?>
	
      <tr>
        <td><a href="<?php echo $link; ?>"><?php echo $link_name; ?></a> <?php if($link_id == $page_id){ echo "<--";} ?></td>
      </tr>
	  <?php } ?>
	  
		 <?php //if user lvl is high enough, list links for mods and admins
		 $i = 0;
	if(isset ($user_type)){
	// good, else...
	$good = "Good!";
	if($user_type >= 6){

	$sql_links = "SELECT id, link_name, link, link_lvl, link_group
	        FROM tbl_links
			WHERE link_lvl <= '$user_type' and link_lvl >= 5
			ORDER BY link_group, link_order DESC";
	
	$result_links = mysql_query($sql_links) or die('Query failed. ' . mysql_error()); 
	
	?>
	  <tr><td height="10"> </td>
	  </tr>

	  <tr>
	    <td><strong>Admin Links</strong></td>
  </tr>
	<?php
	while($list_links = mysql_fetch_array($result_links,MYSQL_ASSOC)){
	$link_name = $list_links['link_name'];
	$link = $list_links['link'];
	$link_lvl = $list_links['link_lvl'];
	$link_group = $list_links['link_group'];
	$link_id = $list_links['id'];
	
?>
	  <tr>
	  
	  <td><a href="<?php echo $link; ?>"><?php echo $link_name; ?></a> <?php if($link_id == $page_id){ echo "<--";} ?></td>
	  </tr>
	  <?php } 	}   }
?>
    </table>
    
    <?php
	if(isset($_SESSION['user_id'])){
	?>
    
  <p>
  <a href="forumlink.php" target="_new">Forum</a>
  </p>

    <?php
	}


	if($user_type >= 5){
	?>

  <p>
  <a href="admin.php">Admin Page</a>
  </p>

    <?php
	}
	
	
	if(isset($_SESSION['user_id'])){
	?>

  <p>
  <a href="mods/logout.php">Logout</a>
  </p>
  
      <?php
	}else{
		?>
<p>
  <a href="register.php">Register</a>
  </p>
	<?php
	}
	?>

  
</span>