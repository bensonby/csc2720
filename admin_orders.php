<?php
include 'inc.php';

if(!$user->is_admin()){
  set_msg("You do not have enough permission.");
  header("Location: index.php");
  exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $orders = Order::search($_POST);
}else{
  $orders = Order::search(array());
}

include 'header.php';

include 'menu.php';

?>
<div id="content">
  <div id="admin-menu">
    <h2>Admin Panel</h2>
    <div class="admin-menu-item"><a href="admin_orders.php">List/Search Orders</a></div>
    <div class="admin-menu-item"><a href="admin_cusproducts.php">List/Search Customized Products</a></div>
  </div>
  <div id="admin-content">
    <h2>Search Customer Orders</h2>
    <form id="admin-orders-search-form" action="admin_orders.php" method="post">
      Leave the fields empty for no restrictions<br />
      <table border="0">
        <tr><td>Time Period</td>
            <td><label for="time_start">From: </label>
            <script type="text/javascript">
              DateInput('time_start', false, 'YYYY-MM-DD', '<?php echo $_POST["time_start"]?$_POST["time_start"]:"2010-05-21"; ?>');</script>
            </td>
            <td><label for="time_end">To: </label>
            <script type="text/javascript">DateInput('time_end', false, 'YYYY-MM-DD', '<?php echo $_POST["time_end"]?$_POST["time_end"]:"2010-05-21"; ?>');</script>
            </td>
        </tr>
        <tr>
          <td><label for="andor">And / Or</label></td>
          <td><input type="radio" name="andor" value="and" <?php if($_POST["andor"]=="and") echo 'checked="checked"'; ?> /> And
              <input type="radio" name="andor" value="or" <?php if($_POST["andor"]=="or") echo 'checked="checked"'; ?> /> Or
        </tr>
        <tr>
          <td><label for="email">Email Address</label></td>
          <td colspan="2"><input type="text" name="email" size="30" value="<?php echo $_POST["email"]; ?>" /></td>
        </tr>
     </table>
     <input type="submit" name="submit" value="Search Orders" />
    </form>

    <h2>Committed Order Details</h2>
    <?php if(empty($orders)){ ?>
      No orders found. Please try another search.
    <?php }else{ ?>
    <table border="0">
      <tr><td>ID</td><td>User</td><td>Time</td><td>Name</td><td>Address</td><td>Email</td><td>Phone</td><td>Price</td></tr>
    <?php foreach($orders as $order){ ?>
      <tr>
        <td><?php echo $order->get_id(); ?></td>
        <td><?php echo $order->get_user()->get_name(); ?></td>
        <td><?php echo $order->get_time(); ?></td>
        <td><?php echo $order->get_name(); ?></td>
        <td><?php echo $order->get_address(); ?></td>
        <td><?php echo $order->get_email(); ?></td>
        <td><?php echo $order->get_phone(); ?></td>
        <td><?php echo $order->get_price(); ?></td>
      </tr>
    <?php } ?>
    </table>
    <?php } ?>
  </div>
</div>

<?php
include 'footer.php';
?>
