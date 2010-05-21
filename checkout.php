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

$error=false;
$msg='';

if($_SERVER["REQUEST_METHOD"]=="GET"){
    $_POST["name"]=$order->get_name();
    $_POST["address"]=$order->get_address();
    $_POST["phone"]=$order->get_phone();
    $_POST["email"]=$order->get_email();
    $_SESSION["checkout"]=false;
}

if (!$_SESSION["checkout"]){
    if (Validation::name($_POST["name"]))
      $order->set_name($_POST["name"]);
    else{
      $error=true;
      $msg="Name format incorrect (it can only contain alphabets or spaces)<br>";
    }
    if (Validation::address($_POST["address"]))
      $order->set_address($_POST["address"]);
    else {
      $error=true;
      $msg=$msg."Address format incorrect (it cannot be empty)<br>";
    }
    if (Validation::phone($_POST["phone"]))
      $order->set_phone($_POST["phone"]);
    else{
      $error=true;
      $msg=$msg."Phone format incorrect, it must be of 8 digits only<br>";
    }
    if (Validation::email($_POST["email"])) 
      $order->set_email($_POST["email"]);
    else{
      $error=true;
      $msg=$msg."Email format incorrect<br>";
    }
    $order->update();
}

if($_SERVER["REQUEST_METHOD"]=="POST")
  if ($error)
    set_msg("<h4>$msg</h4>");
  else{
    
    set_msg("<h4>Preview here</h4>");
    if ($_SESSION["checkout"]==true){
        $order->set_status("completed");
        $order->update();
        if(!Order::get_orderid($user_id)){
          $order = new Order();
          $user->assign_order($order);
          $order->save();
        }
        set_msg("<h4>Order Completed</h4>");
    }

}
include 'header.php';

include 'menu.php';
?>


<?php 
if(!$_SESSION["checkout"])
    if($_SERVER["REQUEST_METHOD"]=="GET" or $error)
      include 'checkout_form.php';
    else if ($_SERVER["REQUEST_METHOD"]=="POST" and !$error){
        $_SESSION["checkout"]=true;
        include 'preview.php';
    }
?>
