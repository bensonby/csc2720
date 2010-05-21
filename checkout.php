<?php
include 'inc.php';

$order_id=Order::get_orderid($_SESSION['user_id']);
if (!empty($order_id)){
  $order=Order::find($order_id);
  $cus_products=$order->get_cus_product();
}

if ($order->get_status=="completed"){

  header("Location: index.php");
  exit();  
}

if (empty($cus_products)){
  header("Location: cart.php");
  exit();
}
$keys=array("name","phone","email");
$error=false;
$msg='';
if (Validation::name($_POST["name"]))
  $order->set_name($_POST["name"]);
else{
  $error=true;
  $msg="Name format incorrect<br>";
}
if (Validation::address($_POST["address"]))
  $order->set_address($_POST["address"]);
else {
  $error=true;
  $msg=$msg."Address format incorrect<br>";
}
if (Validation::phone($_POST["phone"]))
  $order->set_phone($_POST["phone"]);
else{
  $error=true;
  $msg=$msg."Phone format incorrect<br>";
}
if (Validation::email($_POST["email"])) 
  $order->set_email($_POST["email"]);
else{
  $error=true;
  $msg=$msg."Email format incorrect<br>";
}
if($_SERVER["REQUEST_METHOD"]=="POST")
  if ($error)
    set_msg("<h4>$msg</h4>");
  else{
    $order->set_status("checkout");
    $order->update();
    set_msg("<h4>Order completed</h4>");

   /* if(!Order::get_orderid($user_id)){
      $order = new Order();
      $user->assign_order($order);
      $order->save();
    }
*/
}


include 'header.php';

include 'menu.php';
?>

<div id="content">
<?php 
if ($order->get_status()=="created")
  include 'checkout_form.php';
else
{
 echo "done";
}
?>
</div>

<?php
include 'footer.php';
?>
