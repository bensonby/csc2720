<?php
include 'inc.php';

$is_logged_in = User::is_logged_in();

//if(!$is_logged_in){
//  header("Location: login.php");
//  die();
//}


include 'header.php';

//include 'menu.php';
?>

<div id="index-login"><!-- this is made according to twitter.com, for styling you may refer to that site -->
  <div><a href="login.php" id="index-sign-in">Sign In</a></div>
  <div id="index-sign-in-box" style="display: none;">
    <form method="post" action="login.php">
      <p><label for="username">Username</label> <input type="text" name="username"/></p>
      <p><label for="password">Password</label> <input type="password" name="password"/></p>
      <input type="submit" value="Sign In" />
    </form>
  </div>
</div>

<div id="index-about">

</div>

<div id="index-news">

</div>

<div id="index-products">

</div>

<script type="text/javascript">
  index_signin_init();
</script>

<?
include 'footer.php';
?>
