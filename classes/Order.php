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
  }
}