<?php

include 'inc.php';

if(!$user->is_admin()){
  echo "System Error";
  exit();
}

if(@isset($_GET["order_id"])){
  $order_id = $_GET["order_id"];
  $order = Order::find($order_id, true);
}else if(@isset($_GET["cus_product_id"])){
  $order_id = Order::get_orderid_from_cusproduct($_GET["cus_product_id"]);
  $order = Order::find($order_id, true);
}

if(!$order instanceof Order){
  log2("Invalid order created for order ID $order_id");
  echo "Invalid Order";
  exit();
}
sleep(1); //for testing "loading..."
$cus_products = $order->get_cus_product();
?>
<!-- code from admin_orders.php -->
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
    </table><br />
<!-- code from admin_orders.php end -->
<!-- code from cart.php -->
    <table border="0" class="collapse">
        <tr class="show-table"><!--<td></td><td></td>--><td>Product</td><td>Quantity</td><td>Attributes</td>
                               <td> </td><td> </td><td> </td><td> </td><td>Unit Price</td><td>Sub Total</td></tr>
    <?php  foreach($cus_products as $p){ ?>
    <tbody>
        <tr>
<!--        <td class="up-and-low" rowspan="2">
            <div class="icons-container">
              <a href="edit_product.php?id=<?php echo $p->get_id(); ?>">
                <img src="images/modify.gif" />
                </a>
            </div>
          </td>
          <td class="up-and-low" rowspan="2">
            <div class="icons-container">
              <a href="cart.php?id=<?php echo $p->get_id(); ?>&oid=<?php echo $order_id; ?>">
                <img src="images/cart-remove.png" />                                    
              </a>
            </div>
          </td>  
-->
          <td class="up-and-low" rowspan="2"><?php echo $p->get_name(); ?></td>
          <td class="up-and-low" rowspan="2"><?php echo $p->get_quantity(); ?></td>
          
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td class="up"><?php echo $key; ?></td>
          <?php } ?>
          <?php echo str_repeat("<td class='up-and-low' rowspan='2'> </td>", 5-count($p->get_attr_list())); ?>
          <td class="up-and-low price" rowspan="2"><?php echo $p->get_price(); ?></td>
          <td class="up-and-low price" rowspan="2"><?php echo $p->get_price()*$p->get_quantity(); ?></td>
        </tr>
        <tr>
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td class="low"><em><?php echo ($key!="image"?$value:"<div id='cart-attr-img-container'><img src='show_image.php?id=$value' /></div>"); ?></em></td>
          <?php } ?>
          
        </tr>
      </tbody>
    <?php } ?>
     </table>
    <div id="checkout-price">Total Price: HKD <?php echo $order->get_price(); ?></div>
