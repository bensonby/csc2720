<?php
include 'inc.php';

$order_id=Order::get_orderid($_SESSION['user_id']);
if (!empty($order_id)){
  $order=Order::find($order_id);
  $cus_products=$order->get_cus_product();
}

if (empty($cus_products)){
  header("Location: cart.php");
  exit();
}
$keys=array("name","phone","email");
$error=array_fill_keys($keys,false);
if (Validation::name($_POST["name"]))
  $order->set_name($_POST["name"]);
else $error["name"]=true;
$order->set_address($_POST["address"]);
if (Validation::phone($_POST["phone"]))
  $order->set_phone($_POST["phone"]);
else $error["phone"]=true;
if (Validation::email($_POST["email"])) 
  $order->set_email($_POST["email"]);
else $error["email"]=true;
Validation::testing("order",$order);



include 'header.php';

include 'menu.php';
?>

<div id="content">
 <h3>Checkout Form</h3> 
  <form action="checkout.php" method="POST">
     <table>
       <tr>
          <td class="row1">Name:</td>
          <td class="row2"><input type="text" name="name"/> </td>
       </tr>
       <tr>
          <td class="row1">Receiver's Address:</td>
          <td class="row2"><input type="text" name="address"/> </td>
       </tr>
       <tr>
          <td class="row1">Phone:</td>
          <td class="row2"><input type="text" name="phone"/> </td>
       </tr>
       <tr>
          <td class="row1">email:</td>
          <td class="row2"><input type="text" name="email"/> </td>
       </tr>
       <tr>
          <td colspan="2"><input type="submit" value="Submit" /><input type="reset" value="Reset" /><input type="button" value="Back" /></td>
       </tr>
     </table>
  </form>
</div>

<?php
include 'footer.php';
?>
