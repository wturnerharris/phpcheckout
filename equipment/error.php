<?php 

include('includes/heading2.html'); ?>
<div style="margin-left: auto; margin-right: auto; text-align: left; width: 300px;">
<B><font color="red">You have entered an invalid User Name or Password. Try Again.</font></B>

<form name="form" action="login.php" method="post">
<p>
  Username:
    <input name="Username" type="text" id="Username">
  </p>
<p>
  Password :
    <input name="Password" type="password" id="Password"> 
</p>
<p>
  <input type="submit" name="Submit" value="Login">
</p>
</form>
</div>
<? include('includes/footer.html'); ?>
