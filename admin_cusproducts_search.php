<?php
include 'inc.php';

if(!$user->is_admin()){
  set_msg("You do not have enough permission.");
  header("Location: index.php");
  exit();
}else{
  echo "";
}

$products = Product::get_all_products();


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
      <form id="admin-cusproducts-search-form" action="admin_cusproducts.php" method="post">
        <h3>Search Customer Orders</h3>
        Leave the fields empty for no restrictions<br />
        <table border="0">
          <tr><td><label for="products[]">Product Types: </label>
                  <select name="products[]" multiple="multiple">
                    <?php foreach($products as $p){ ?>
                      <option value="<?php echo $p->get_name(); ?>"><?php echo $p->get_name(); ?></option>
                    <?php } ?>
              </td>
          </tr>
       </table>
       <input type="submit" name="submit" value="Search Orders" />
      </form>
    </div>
  </h3>
</div>

<?php
include 'footer.php';
?>
