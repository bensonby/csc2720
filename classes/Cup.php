<?php

class Cup extends CusProduct {
  private $product_id=1;
  private $product_name="cup";
  private $attr=array("size"=>array('Small', 'Medium', 'Large'),
                      "type"=>array('type 1', 'type 2', 'type 3'),
                      "image"=>array('hello.jpg')
                     );

  function __construct($attributes){
    foreach($this->attr as $key=>$values){
      if(!in_array($key, array_keys($attributes))) die('Hacking Attempt!');
      if(!in_array($attributes[$key], $this->attr[$key])) die('Hacking Attempt!');
      $this->custom[$key]=$attributes[$key];
    }
  }
}
