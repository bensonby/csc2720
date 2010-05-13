<?php

include 'inc.php';


//process login request..
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $user_id = User::auth($_POST["username"], $_POST["password"]);
  if($user_id){
    $_SESSION['user_id'] = $user_id;
    header("Location: index.php");
    exit();
  }else{
    set_msg("Login Failed");
  }
}

include 'header.php';

include 'menu.php';
?>

<div id="message-block">
  <?=get_msg() ?>
</div>

<div id="sign-in-block">
  <form method="post" action="login.php">
    <p>
      <label for="username">Username</label>
      <input type="text" name="username" size="10" />
    </p>
    <p>
      <label for="password">Password</label>
      <input type="password" name="password" size="10" />
    </p>
    <input type="submit" value="Sign In" />
  </form>
</div>

<?php

include 'footer.php';

?>
