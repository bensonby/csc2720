<?php

class Cup extends CusProduct {
  private $product_id=1;
  private $product_name="cup";
  private $attr=array("size"=>array('Small', 'Medium', 'Large'),
                      "type"=>array('type 1', 'type 2', 'type 3'),
                      "image"=>array('hello.jpg')
                     );

  function __construct($attributes){
  }
}
