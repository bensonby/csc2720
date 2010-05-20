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
  <h3>Admin Panel</h3>
    <div id="admin-menu">
      <div class="admin-menu-item"><a href="admin_orders.php">List Orders</a></div>
      <div class="admin-menu-item"><a href="admin_orders_search.php">Search Orders</a></div>
      <div class="admin-menu-item"><a href="admin_cusproducts.php">List Customized Products</a></div>
      <div class="admin-menu-item"><a href="admin_cusproducts_search.php">Search Customized Products</a></div>
    </div>
    <div id="admin-content">
    </div>
  </h3>
</div>

<?php
include 'footer.php';
?>
