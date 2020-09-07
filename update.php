<?php
//update.php

include('database_connection.php');

if(isset($_POST["image_id"]))
{
 $old_name_appoggio = get_old_image_name($connect, $_POST["image_id"]);
 $old_name_array = explode(".", $old_name_appoggio);
 $old_name = $old_name_array[1]; //pos 0=cartella, pos 1=nome file

 $file_array = explode(".", $old_name);
 $file_extension = end($file_array);
 $new_name = $_POST["image_name"] . '.' . $file_extension;
 $old_name = $old_name . '.' . $file_extension;

 $query = '';
 $cartella=$old_name_array[0];
 if($old_name != $new_name)
 {
  $old_path = 'files/' .$cartella. $old_name;
  $new_path = 'files/' .$cartella. $new_name;
  if(rename($old_path, $new_path))
  { 
   $query = "
   UPDATE tbl_image 
   SET image_name = '".$new_name."', image_description = '".$_POST["image_description"]."' 
   WHERE image_id = '".$_POST["image_id"]."'
   ";
  }
 }
 else
 {
  $query = "
   UPDATE tbl_image 
   SET image_description = '".$_POST["image_description"]."' 
   WHERE image_id = '".$_POST["image_id"]."'
   ";
 }
 
 $statement = $connect->prepare($query);
 $statement->execute();
}
function get_old_image_name($connect, $image_id)
{
 $query = "
 SELECT T.image_name, I.cartella FROM tbl_image T INNER JOIN immagini_x_cartelle I ON T.image_name = I.immagine WHERE T.image_id = '".$image_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["cartella"].".".$row["image_name"];
 }
}

?>
