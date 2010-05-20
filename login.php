<?php

include 'inc.php';


//process login request..
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $user_id = User::auth($_POST["username"], $_POST["password"]);
  if($user_id){
    $_SESSION['user_id'] = $user_id;
    $user = new User($user_id);
    //to assign a new cart to a user if there are no carts
    if(!Order::get_orderid($user_id)){
      $order = new Order();
      $user->assign_order($order);
      $order->save();
    }

    header("Location: index.php");
    exit();
  }else{
    set_msg("Login Failed");
  }
}

include 'header.php';

include 'menu.php';
?>

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
