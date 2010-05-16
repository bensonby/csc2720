<?php
class Cart {
  private $id;
  private $cus_products = array();
  private $user;
  private $status="", $time="", $name="", $address="", $email="", $phone="";

  function __construct(){
    $this->status = "created";
  }

  function assign_user(User $user){
    $this->user = $user;
  }

  function is_saved(){
    return !empty($this->id);
  }

  function get_id(){
    return $this->id;
  }

  function save(){
    if(empty($this->user)){
      log('Invalid User for the Cart');
      return false;
    }
    if($this->is_saved())){
      log('Invalid action - save for a created cart');
      return false;
    }
    $str = dbstr(array('id'      => '',
                       'user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => time(),
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone
                 ), ",", false);
    $result=sql("INSERT INTO orders VALUES($str)", SQL_SINGLE_VALUE);
    if(!$result){
      log('SQL execution error -- '.mysql_error());
      return false;
    }
    $this->id = mysql_insert_id();
    return $this->id;
  }

  function update(){
    if(!$this->is_saved()){
      log('Invalid action - update for an unsaved order');
      return false;
    }
    $str = dbstr(array('user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => time(),
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone
                 ), ",", true);
    $result = sql("UPDATE orders SET $str WHERE id = {$this->id}", SQL_SINGLE_VALUE);
    if(!$result){
      log('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  function delete(){
    if(!$this->is_saved()){
      log('Invalid action - delete a non-existing order');
      return false;
    }
    $result = sql("DELETE FROM orders WHERE id = {$this->id}", SQL_SINGLE_VALUE);
    if(!$result){
      log('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }

  static function find($id){
  }

  function add_product($cus_product){
    //both the cart and the customized product should have been saved into db
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log('error: add_product to cart');
      return false;
    }
    $str=dbstr(array('id'=>'',
                     'cart_id'=>$this->id,
                     'cus_product_id'=>$cus_product->get_id()
                    ), ",", false);
    $result=sql("INSERT INTO cart_products VALUES($str)");
    if(!$result){
      log('SQL execution error -- '.mysql_error());
      return false;
    }
    return mysql_insert_id();
  }

  function remove_product($cus_product){
    if(!$this->is_saved() || !$cus_product->is_saved() || !$cus_product instanceof CusProduct){
      log('error: add_product to cart');
      return false;
    }
    $str = dbstr(array('cart_id' => $this->id,
                       'cus_product_id' => $cus_product->get_id()
                 ), ",", true);
    $result = sql("DELETE FROM cart_products WHERE $str", SQL_SINGLE_VALUE);
    if(!$result){
      log('SQL execution error -- '.mysql_error());
      return false;
    }
    return true;
  }
}
