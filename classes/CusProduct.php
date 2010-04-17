<?php
abstract class CusProduct {
  private $product_id, $product_name;
  private $attr=array(); //preset attributes
  private $custom=array(); //customized attributes input
  private $id;
  private $user_id;
  private $cart_id;

  function __construct(){ die('Hacking Attempt!'); }

  function save(){
    if($this->is_saved()) return false;
  }


  function update(){
    //update the customized product in the database
    //return true/false on success/failure
  }

  function delete(){
    //remove the customized product in the database
    //return true/false on success/failure
  }

  static function find($id){
    //create the object CusProduct of the specific type from reading the database for the id
    //return the object/false on success/failure
  }

  function is_saved(){
    return !empty($this->id);
  }

  function display_form(){
    //generate an HTML form according to the customizable attributes of the product
    //return an HTML string
  }
}
?>
