<?php
class Shirt extends CusProduct {
  protected $attr=array("image"=>'hello.jpg',
                        "size"=>array('Small', 'Medium', 'Large'),
                        "color"=>array('Black', 'Blue', 'Brown', 'White'),
                        "text"=>15,
                        "image location" => array("[front] centre", "[front] bottom right",
                                                  "[front] bottom left", "[front] top right",
                                                  "[front] top left",
                                                  "[back] centre", "[back] bottom right",
                                                  "[back] bottom left", "[back] top right",
                                                  "[back] top left")
                       );

}
?>
