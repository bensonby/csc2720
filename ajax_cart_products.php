<?php

include 'inc.php';
//sleep(2); //for testing "loading..."

if(!$user->is_admin()){
  echo "System Error";
  exit();
}

$order_id = $_GET["id"];
$order = Order::find($order_id, true);
if(!$order instanceof Order){
  log2("Invalid order created for order ID $order_id");
  echo "Invalid Order";
  exit();
}
$cus_products = $order->get_cus_product();
?>
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
