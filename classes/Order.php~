<<<<<<< HEAD:classes/Order.php
<?php
class Order {
  private $id;
  private $cus_products = array();
  private $user;
  private $status="", $time="", $name="", $address="", $email="", $phone="", $price=0.0;

  function __construct(){
    $this->status = "created";
    $this->time = time();
  }

  function assign_user($user){
    if(!$user instanceof User){
      log2('invalid object as a class of User when assigning user to an order');
      return false;
    }
    $this->user = $user;
    return true;
  }

  function is_saved(){
    return !empty($this->id);
  }

  function get_id(){
    return $this->id;
  }

  function save(){
    if(empty($this->user)){
      log2('Invalid User for the Cart');
      return false;
    }
    if($this->is_saved()){
      log2('Invalid action - save for a created cart');
      return false;
    }
    $str = dbstr(array('id'      => '',
                       'user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => "NOW()",
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone,
                       'price'   => $this->price
                 ), ",", false);
    $result=sql("INSERT INTO orders VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->id = mysql_insert_id();
    return $this->id;
  }

  function update(){
    if(!$this->is_saved()){
      log2('Invalid action - update for an unsaved order');
      return false;
    }
    $str = dbstr(array('user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => time(),
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone,
                       'price'   => $this->price
                 ), ",", true);
    $result = sql("UPDATE orders SET $str WHERE id = {$this->id}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  function delete(){
    if(!$this->is_saved()){
      log2('Invalid action - delete a non-existing order');
      return false;
    }
    $result = sql("DELETE FROM orders WHERE id = {$this->id}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  static function find($id){
    print $id;
    $cus_product_id = sql("SELECT cus_product_id FROM order_products WHERE order_id= {$id}");
    foreach($cus_product_id as $cp_id) $ret[] = intval($cp_id);
    return $ret;
    
    
  }
  
  static function get_orderid($user_id){
    $result=sql("SELECT id FROM orders WHERE user_id={$user_id}");
    if (!count($result)==1) return false;
    else return intval($result[0]);
  }

  function add_product($cus_product){
    //both the cart and the customized product should have been saved into db
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log2('error: add_product to cart');
      return false;
    }
    $str=dbstr(array('id'=>'',
                     'cart_id'=>$this->id,
                     'cus_product_id'=>$cus_product->get_id()
                    ), ",", false);
    $result=sql("INSERT INTO cart_products VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return mysql_insert_id();
  }

  function remove_product($cus_product){
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log2('error: add_product to cart');
      return false;
    }
    $str = dbstr(array('cart_id' => $this->id,
                       'cus_product_id' => $cus_product->get_id()
                 ), ",", true);
    $result = sql("DELETE FROM cart_products WHERE $str");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
=======
<?php
class Order {
  private $id;
  private $cus_products = array();
  private $user;
  private $status="", $time="", $name="", $address="", $email="", $phone="", $price=0.0;

  function __construct(){
    $this->status = "created";
    $this->time = time();
  }

  function assign_user($user){
    if(!$user instanceof User){
      log2('invalid object as a class of User when assigning user to an order');
      return false;
    }
    $this->user = $user;
    return true;
  }

  function is_saved(){
    return !empty($this->id);
  }

  function get_id(){
    return $this->id;
  }

  function save(){
    if(empty($this->user)){
      log2('Invalid User for the Cart');
      return false;
    }
    if($this->is_saved()){
      log2('Invalid action - save for a created cart');
      return false;
    }
    $str = dbstr(array('id'      => '',
                       'user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => "NOW()",
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone,
                       'price'   => $this->price
                 ), ",", false);
    $result=sql("INSERT INTO orders VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->id = mysql_insert_id();
    return $this->id;
  }

  function update(){
    if(!$this->is_saved()){
      log2('Invalid action - update for an unsaved order');
      return false;
    }
    $str = dbstr(array('user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => time(),
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone,
                       'price'   => $this->price
                 ), ",", true);
    $result = sql("UPDATE orders SET $str WHERE id = {$this->id}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  function delete(){
    if(!$this->is_saved()){
      log2('Invalid action - delete a non-existing order');
      return false;
    }
    $result = sql("DELETE FROM orders WHERE id = {$this->id}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  static function find($id){
  }

  function add_product($cus_product){
    //both the cart and the customized product should have been saved into db
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log2('error: add_product to cart');
      return false;
    }
    $str=dbstr(array('id'=>'',
                     'cart_id'=>$this->id,
                     'cus_product_id'=>$cus_product->get_id()
                    ), ",", false);
    $result=sql("INSERT INTO cart_products VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return mysql_insert_id();
  }

  function remove_product($cus_product){
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log2('error: add_product to cart');
      return false;
    }
    $str = dbstr(array('cart_id' => $this->id,
                       'cus_product_id' => $cus_product->get_id()
                 ), ",", true);
    $result = sql("DELETE FROM cart_products WHERE $str");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
>>>>>>> 8835c16609e9294017d37400682e1d721de639ad:classes/Order.php
  }
  
  function set_name($name){
    if (!empty($name)){
        $this->name=$name;
        return true;
    }
    return false;
  }
  
  function set_address($address){
    if (!empty($address)){
        $this->address=$address;
        return true;
    }
    return false;
  }
  
  function set_email($email){
    if (!empty($email)){
        $this->email=$email;
        return true;
    }
    return false;
  }
  
  function set_phone($phone){
    if (!empty($phone)){
        $this->phone=$phone;
        return true;
    }
    return false;
  }
  
  function set_price($price){
  if (!empty($price)){
        $this->price=$price;
        return true;
    }
    return false;
  }
}
