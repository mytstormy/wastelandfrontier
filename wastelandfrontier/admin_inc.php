<p>This page will have all the admin links necesary... etc.
  <br />
  <br />
  <?php
echo "Thank you for being logged in :D . <br>
Your user id is '$user_id'. <br>
Your user name is '$user_name'. <br>
Your user lvl is '$user_type'. <br>

The current path for this page is: '$current_path'!<br><br>
The current filename for this page is $file_name.<br><br>
Access, Y/N? = $access<br><br>

Page id = $page_id .<br><br>
";
?>
  <br />
  <br />
   - <a href="/mods/cron1.php" target="_new">Cron 1 Test </a>
  <br />
  <br />
   - <a href="/mods/cron2.php" target="_new">Cron 2 Test </a>
  <br />
  <br />
Also, these are currently the only pages you can access at your current User Level.</p>
<p>&nbsp;</p>
<table border="1" cellspacing="5">
      <tr>
        <td colspan="4">Nav Tree...ish</td>
  </tr>
		 <?php
		 $i = 0;

	// get the links the user is allowed to use
	$sql_links = "SELECT id, link_name, link, link_lvl, link_group
	        FROM tbl_links
			WHERE link_lvl <= '$user_type'
			ORDER BY link_group, link_order DESC";
	
	$result_links = mysql_query($sql_links) or die('Query failed. ' . mysql_error()); 
	
	while($list_links = mysql_fetch_array($result_links,MYSQL_ASSOC)){
	$link_name = $list_links['link_name'];
	$link = $list_links['link'];
	$link_id = $list_links['id'];
	$link_lvl = $list_links['link_lvl'];
	$link_group = $list_links['link_group'];
	
	$i = $i+1;
	
?>
	
      <tr>
        <td><?php echo $i; ?> - <?php echo $link_id; ?></td>
        <td><a href="<?php echo $link; ?>"><?php echo $link_name; ?></a></td>
        <td align="right">Lvl <?php echo $link_lvl; ?></td>
        <td align="right">Grp <?php echo $link_group; ?></td>
      </tr>
	  <?php } ?>
	   <tr>
        <td colspan="4">Goto <a href="navedit.php">NavEdit.php</a></td>
  </tr>
</table>