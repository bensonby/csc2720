	<div id="menu">
    		<ul>
    				<li><a href="index.php">Home</a></li>
    				<li><a href="about.php">About</a></li>
    				<li><a href="products.php">Products</a></li>
    				<li><a href="cart.php">Cart</a></li>
    				<li><a href="contact.php">Contact</a></li>
    		<?php if($user){ ?>
        <?php if($user->is_admin()){ ?>
            <li><a href="admin_orders.php">Admin Panel</a></li>
        <?php } ?>
      <?php } ?>
      
     <li> 
    <div id="login">
  <?php if(!$user){ ?>
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
    </li>
  <?php }else{ ?>

    <a href="logout.php">Sign Out</a></div>
    </li>
   <?php if(!($user->is_admin())){ ?>
    <li>
    <div id="user">
      Hello, <?php echo $user->get_name(); ?>!
    </div>
    </li>
 <?php } ?>
  <?php } ?>
  
    		</ul>
	   </div>
	   
  <?php if(has_msg()){ ?><div class="message"><?php echo get_msg(); ?></div>
  <?php } ?>
  
  
