<?php
include 'inc.php';

if(!$user->is_admin()){
  set_msg("You do not have enough permission.");
  header("Location: index.php");
  exit();
}else{
  echo "";
}


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
      <form id="admin-orders-search-form" action="admin_orders.php" method="post">
        <h2>Search Customer Orders</h2>
        Leave the fields empty for no restrictions<br />
        <table border="0">
          <tr><td>Time Period</td>
              <td><label for="time_start">From: </label>
              <script type="text/javascript">DateInput('time_start', false, 'YYYY-MM-DD', '2010-05-21');</script>
              </td>
              <td><label for="time_end">To: </label>
              <script type="text/javascript">DateInput('time_end', false, 'YYYY-MM-DD', '2010-05-21');</script>
              </td>
          </tr>
          <tr>
            <td><label for="andor">And / Or</label></td>
            <td><input type="radio" name="andor" value="and" /> And
                <input type="radio" name="andor" value="or" /> Or
          </tr>
          <tr>
            <td><label for="email">Email Address</label></td>
            <td colspan="2"><input type="text" name="email" size="30" value="" /></td>
          </tr>
       </table>
       <input type="submit" name="submit" value="Search Orders" />
      </form>
    </div>
</div>

<?php
include 'footer.php';
?>
