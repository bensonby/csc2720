<?php
include 'inc.php';

if(!Validation::own_image($_GET["id"], $user->get_id()))
  set_msg("You do not have enough permission.");
  header("Location: index.php");
  exit();
}

$image = Image::find($_GET["id"]);
if(!$image) die();
$image->generate_php_header();
echo file_get_contents("images/".$image->get_path());

?>
