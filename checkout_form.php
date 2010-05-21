
<div id="content">
<h3>Checkout Form</h3> 
  <form action="checkout.php" method="POST">
     <span class="note">All fields are required</span><br />
     <table>
       <tr>
          <td class="row1">Name:</td>
          <td class="row2"><input type="text" name="name" value="<?php echo htmlspecialchars ($_POST["name"], ENT_QUOTES); ?>" /> </td>
       </tr>
       <tr>
          <td class="row1">Receiver's Address:</td>
          <td class="row2"><input type="text" name="address" value="<?php echo htmlspecialchars ($_POST["address"], ENT_QUOTES); ?>" /> </td>
       </tr>
       <tr>
          <td class="row1">Phone:</td>
          <td class="row2"><input type="text" name="phone" value="<?php echo htmlspecialchars ($_POST["phone"], ENT_QUOTES); ?>" /> </td>
       </tr>
       <tr>
          <td class="row1">email:</td>
          <td class="row2"><input type="text" name="email" value="<?php echo htmlspecialchars ($_POST["email"], ENT_QUOTES); ?>"/> </td>
       </tr>
       <tr>
          <td colspan="2">
          <div id="checkout-button-container">
              <input type="submit" value="Submit" />
              <input type="reset" value="Reset" />
                  <a href="cart.php"><img src="images/back.gif"/></a>
               </div>
          </td>
       </tr>
     </table>
  </form>
</div>
