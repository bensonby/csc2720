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
 <div id="admin-menu">
  <h2>Admin Panel</h2>
      <div class="admin-menu-item"><a href="admin_orders.php">List Orders</a></div>
      <div class="admin-menu-item"><a href="admin_orders_search.php">Search Orders</a></div>
      <div class="admin-menu-item"><a href="admin_cusproducts.php">List Customized Products</a></div>
      <div class="admin-menu-item"><a href="admin_cusproducts_search.php">Search Customized Products</a></div>
    </div>
    <div id="admin-content">
      <form id="admin-cusproducts-search-form" action="admin_cusproducts.php" method="post">
        <h2>Search Customer Orders</h2>
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
</div>

<?php
include 'footer.php';
?>
