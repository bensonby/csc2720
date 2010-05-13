<div id="menu">
  <ul>
    <? if($user){ ?>
      <li><a href="products.php">Products</a></li>
      <li><a href="cart.php">View my Cart</a></li>
      <li><a href="orders.php">My order status</a></li>
      <? if($user->is_admin()){ ?>
        <li><a href="admin.php">Admin Panel</a></li>
      <? } ?>
    <? } ?>
  </ul>
</div>

<div id="login"><!-- this is made according to twitter.com, for styling you may refer to that site -->
  <? if(!$user){ ?>
  <div><a href="login.php" id="sign-in">Sign In</a></div>
  <div id="sign-in-box" style="display: none;">
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
  <? }else{ ?>
  <div>
    Hello, <?=$user->get_name() ?>!
    <a href="logout.php">Sign Out</a></div>
  <? } ?>
</div>
  
  
