<?php
include 'inc.php';

include 'header.php';

include 'menu.php';

function remove($cp_id,$order_id){
  $val=Validation::own_cus_product($cp_id,$_SESSION["user_id"]);
  if ($val){
    $cus_pro=CusProduct::find($cp_id);
    $order=Order::find($order_id);
    $order->remove_product($cus_pro);
  }
}

function change($cp_id,$attrs){
  //$val=Validation::cus_attrs($pid,$attrs);
}

if($_SERVER["REQUEST_METHOD"]=="GET"){
  if(!empty($_GET["id"]) and !empty($GET["oid"]))
  remove($_GET["id"],$GET["oid"]);}

$order_id=Order::get_orderid($_SESSION['user_id']);
//echo get_msg();
//$a=Order::find($order_id);
//echo "<pre>\n";
//var_dump($a);
//echo "</pre>\n";
//die();

if (!empty($order_id)){
  $order=Order::find($order_id);
  
  $cus_products=$order->get_cus_product();
  //Validation::testing("cus_product",$cus_products); 
  
  //Validation::testing("cart ",$cus_product_ids[0]->$cus_products);
  //print $cps[0]->get_id();
}else{
  set_msg("<h4>Your cart is empty. Click PRODUCTS to buy something.</h4>");
}
?>

<div id="content">
<h3>Your Cart</h3>
<?php if (!empty($order_id)){ ?>    
    <table border="0" class="collapse">
        <tr class="show-table"><td></td><td></td><td>Product</td><td>Quantity</td><td>Attributes</td></tr>
    <?php  foreach($cus_products as $p){ ?>
    <tbody>
        <tr>
        <td class="up-and-low" rowspan="2">
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
          <td class="up-and-low" rowspan="2"><?php echo $p->get_name(); ?></td>
          <td class="up-and-low" rowspan="2"><?php echo $p->get_quantity(); ?></td>
          
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td class="up"><?php echo $key; ?></td>
          <?php } ?>
        </tr>
        <tr>
          <?php foreach($p->get_custom() as $key=>$value){ ?>
          <td class="low"><em><?php echo ($key!="image"?$value:"<div id='cart-attr-img-container'><img src='show_image.php?id=$value' /></div>"); ?></em></td>
          <?php } ?>
          <?php echo str_repeat("<td class='low'> </td>", 5-count($p->get_attr_list())); ?>
        </tr>
      </tbody>
    <?php } ?>
    <?php } ?>
</div>
<?php
include 'footer.php';
?>
