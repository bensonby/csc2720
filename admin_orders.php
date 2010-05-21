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
  <div id="ajax-popup" style="display: none;">
    <div id="ajax-close"><a href="#" onclick="close_ajax()">Close</a></div>
    <div id="ajax-title">Product Details for Order ID <span id="ajax-order-id">3</span></div>
    <div id="ajax-loading">Loading... </div>
    <div id="ajax-body" style=""> </div>
  </div>
  <div id="admin-menu">
    <h2>Admin Panel</h2>
    <div class="admin-menu-item"><a href="admin_orders.php">Search Orders</a></div>
    <div class="admin-menu-item"><a href="admin_cusproducts.php">Search Customized Products</a></div>
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
    <br />

    <h2>Committed Order Details</h2>
    <?php if(empty($orders)){ ?>
      No orders found. Please try another search.
    <?php }else{ ?>
    <div id="admin-order-table-container">
    <?php foreach($orders as $order){ ?>
    <table class="admin-order-table">
        <tr>
        <td class="row1">Order ID</td>
         <td class="row2"><?php echo $order->get_id(); ?></td>
         </tr>
         <tr>
        <td class="row1">User</td>
         <td class="row2"><?php echo $order->get_user()->get_name(); ?></td>
         </tr>
         <tr>
        <td class="row1">Time</td>
         <td class="row2"><?php echo $order->get_time(); ?></td>
         </tr>
         <tr>
         <td class="row1">Name</td>
          <td class="row2"><?php echo $order->get_name(); ?></td>
         </tr>
         <tr>
        <td class="row1">Address</td>
           <td class="row2"><?php echo $order->get_address(); ?></td>
          </tr>
         <tr>
        <td class="row1">Email</td>
          <td class="row2"><?php echo $order->get_email(); ?></td>
         </tr>
         <tr>
        <td class="row1">Phone</td>
        <td class="row2"><?php echo $order->get_phone(); ?></td>
         </tr>
         <tr>
        <td class="row1">Total Price</td>
         <td class="row2"><?php echo $order->get_price(); ?></td>
        </tr>
        <tr>
          <td class="row1">Products</td>
          <td class="row2"><a href="javascript:find_products(<?php echo $order->get_id(); ?>)">View details</a></td>
        </tr>
    </table><br />
    <?php } ?>
    <?php } ?>
  </div>
 </div>
</div>

<?php
include 'footer.php';
?>
