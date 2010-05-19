<?php

class Shirt extends CusProduct {
<<<<<<< HEAD:classes/Shirt.php
  protected $attr=array("size"=>array('Small', 'Medium', 'Large'),
                        "color"=>array('black', 'blue', 'brown', 'white'),
                        "text"=>15,
                        "image"=>'hello.jpg',
                        "image location" => array("[front] centre", "[front] bottom right",
                                                  "[front] bottom left", "[front] top right",
                                                  "[front] top left",
                                                  "[back] centre", "[back] bottom right",
                                                  "[back] bottom left", "[back] top right",
                                                  "[back] top left")
                       );

}
=======
  //private $product_id=3;
  //private $product_name="cap";
  protected $attr=array("size"=>array('Small', 'Medium', 'Large'),
                      "type"=>array('type 1', 'type 2', 'type 3'),
                      "image"=>array('hello.jpg')
                     );


}
?>
>>>>>>> 00420673697a197712f11a23c3390aa49fc162e2:classes/Shirt.php
