<?php

class Cup extends CusProduct {
  protected $attr=array("image"=>'hello.jpg',
                        "size"=>array('Small', 'Medium', 'Large'),
                        "material"=>array('ceramic', 'glass', 'plastic'),
                        "color" => array("White", "Yellow", "Blue", "Green", "Pink")
                       );

}
?>
