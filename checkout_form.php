
<div id="content">
<h3>Checkout Form</h3> 
  <form action="checkout.php" method="POST">
     <table>
       <tr>
          <td class="row1">Name:</td>
          <td class="row2"><input type="text" name="name" value="<?php echo $_POST["name"]; ?>" /> </td>
       </tr>
       <tr>
          <td class="row1">Receiver's Address:</td>
          <td class="row2"><input type="text" name="address" value="<?php echo $_POST["address"]; ?>" /> </td>
       </tr>
       <tr>
          <td class="row1">Phone:</td>
          <td class="row2"><input type="text" name="phone" value="<?php echo $_POST["phone"]; ?>" /> </td>
       </tr>
       <tr>
          <td class="row1">email:</td>
          <td class="row2"><input type="text" name="email" value="<?php echo $_POST["email"]; ?>"/> </td>
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
