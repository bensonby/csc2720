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
    if(empty($this->user)) die('Invalid User for the Cart');
    if(!empty($this->id)) die('Invalid action - save for a created cart');
    $str = dbstr(array('id'      => '',
                       'user_id' => $this->user->get_id(),
                       'status'  => $this->status,
                       'time'    => time(),
                       'name'    => $this->name,
                       'address' => $this->address,
                       'email'   => $this->email,
                       'phone'   => $this->phone
                 ), ",", false);
    $result=sql("INSERT INTO carts VALUES($str)");
    if(!$result) return false;
    $this->id = mysql_insert_id();
    return $this->id;
  }

  static function find($id){
  }

  function add_product(CusProduct $cus_product){
    //both the cart and the customized product should have been saved into db
    if(!$this->is_saved() || !$cus_product->is_saved()) return false;
    $str=dbstr(array('id'=>'',
                     'cart_id'=>$this->id,
                     'cus_product_id'=>$cus_product->get_id()
                    ), ",", false);
    $result=sql("INSERT INTO cart_products VALUES($str)");
    if(!$result) return false;
    else return mysql_insert_id();
  }

  function remove_product(CusProduct $cus_product){
  }
}
}
