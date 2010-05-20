<?php
include 'inc.php';

if(!$user->is_admin()){
  set_msg("You do not have enough permission.");
  header("Location: index.php");
  exit();
}else{
  echo "";
}


var_dump($_POST);

include 'header.php';

include 'menu.php';

?>
<div id="content">
  <div id="admin-menu">
  <h2>Admin Panel</h2>
      <div class="admin-menu-item"><a href="admin_orders.php">List Orders</a></div>
      <div class="admin-menu-item"><a href="admin_orders_search.php">Search Orders</a></div>
      <div class="admin-menu-item"><a href="admin_cusproducts.php">List Customized Products</a></div>
      <div class="admin-menu-item"><a href="admin_cusproducts_search.php">Search Customized Products</a></div>
    </div>
    <div id="admin-content">
    </div>
</div>

<?php
include 'footer.php';
?>
