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
    $msg = "Login Failed";
  }
}

include 'header.php';
?>

<div id="login-block">
  <form id="login-form" method="post" action="login.php">

    <input type="submit" value="Log in" />
  </form>
</div>

<?php

include 'footer.php';

?>
