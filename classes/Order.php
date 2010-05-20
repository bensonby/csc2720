<?php
class Order {
  private $info = array(); //id, user, status, time, name, address, email, phone, price
  private $cus_products = array();

  function __construct(){
    $this->info = array("id" => '',
                        "user" => false,
                        "status" => "created",
                        "time" => time(),
                        "name" => "",
                        "address" => "",
                        "email" => "",
                        "phone" => "",
                        "price" => 0.0);
  }

  private function update_price(){
    $price = 0;
    foreach($this->cus_products as $cus_product){
      $price += $cus_product->get_quantity()*$cus_product->get_price();
    }
    $this->info["price"] = $price;
  }

  function get_cus_products(){
    return $this->cus_products;
  }

  function assign_user($user){
    if(!$user instanceof User){
      log2('invalid object as a class of User when assigning user to an order');
      return false;
    }
    $this->info["user"] = $user;
    return true;
  }

  function is_saved(){
    return !empty($this->info["id"]);
  }

  function get_id(){
    return $this->info["id"];
  }

  function save(){
    if(empty($this->info["user"])){
      log2('Invalid User for the Cart');
      return false;
    }
    if($this->is_saved()){
      log2('Invalid action - save for a created cart');
      return false;
    }
    $str = dbstr(array('id'      => '',
                       'user_id' => $this->info["user"]->get_id(),
                       'status'  => $this->info["status"],
                       'time'    => "NOW()",
                       'name'    => $this->info["name"],
                       'address' => $this->info["address"],
                       'email'   => $this->info["email"],
                       'phone'   => $this->info["phone"],
                       'price'   => $this->info["price"]
                 ), ",", false);
    $result=sql("INSERT INTO orders VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->info["id"] = mysql_insert_id();
    return $this->info["id"];
  }

  function update(){
    if(!$this->is_saved()){
      log2('Invalid action - update for an unsaved order');
      return false;
    }
    $this->update_price();
    $str = dbstr(array('user_id' => $this->info["user"]->get_id(),
                       'status'  => $this->info["status"],
                       'time'    => "NOW()",
                       'name'    => $this->info["name"],
                       'address' => $this->info["address"],
                       'email'   => $this->info["email"],
                       'phone'   => $this->info["phone"],
                       'price'   => $this->info["price"]
                 ), ",", true);
    $result = sql("UPDATE orders SET $str WHERE id = {$this->info["id"]}");
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
    $result = sql("DELETE FROM orders WHERE id = {$this->info["id"]}");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  static function find($id){
    if(!$id) return false;

    $id = intval($id);

    $info = sql("SELECT * FROM orders WHERE id = $id", SQL_SINGLE_ROW);
    if(!$info){
      log2("failed to find the order with id $id");
      return false;
    }
    $order = new Order();
    $order->info = $info;
    $order->info["user"] = new User($info["user_id"]);

    $cus_product_ids = sql("SELECT cus_product_id FROM order_products WHERE order_id= {$id}", SQL_SINGLE_COL);
    foreach($cus_product_ids as $cp_id){
      $order->cus_products[] = CusProduct::find(intval($cp_id));
    }
    return $order;
  }
  
  static function get_orderid($user_id){
    $result=sql("SELECT id FROM orders WHERE user_id={$user_id} AND status='created'
                   ORDER BY time DESC LIMIT 1", SQL_SINGLE_COL);
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
                     'cart_id'=>$this->info["id"],
                     'cus_product_id'=>$cus_product->get_id()
                    ), ",", false);
    $result=sql("INSERT INTO order_products VALUES($str)");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->cus_products[] = $cus_product;
    return mysql_insert_id();
  }

  function remove_product($cus_product){
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log2('error: add_product to cart');
      return false;
    }
    $str = dbstr(array('cart_id' => $this->info["id"],
                       'cus_product_id' => $cus_product->get_id()
                 ), ",", true);
    $result = sql("DELETE FROM order_products WHERE $str");
    if(!$result){
      log2('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }
  
  function set_name($name){
    if (!empty($name)){
        $this->info["name"]=$name;
        return true;
    }
    return false;
  }
  
  function get_cus_product(){
    return $this->cus_products;
  }
  
  function set_address($address){
    if (!empty($address)){
        $this->info["address"]=$address;
        return true;
    }
    return false;
  }
  
  function set_email($email){
    if (!empty($email)){
        $this->info["email"]=$email;
        return true;
    }
    return false;
  }
  
  function set_phone($phone){
    if (!empty($phone)){
        $this->info["phone"]=$phone;
        return true;
    }
    return false;
  }
  
  function set_price($price){
  if (!empty($price)){
        $this->info["price"]=$price;
        return true;
    }
    return false;
  }
}
