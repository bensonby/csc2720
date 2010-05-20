<?php
include 'inc.php';

include 'header.php';

include 'menu.php';
?>

<div id="content">
 <h3>Checkout Form</h3> 
  <form>
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