<form action="login1.php" method="post" name="frmLogin" id="frmLogin">
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