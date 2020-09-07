<?php

$connect = new PDO('mysql:host=localhost;dbname=portfolio', 'root', '');

if($_FILES["upload_file"]["name"] != '')
{
 $data = explode(".", $_FILES["upload_file"]["name"]);
 $extension = $data[1];
 $allowed_extension = array("jpg", "JPG", "JPEG", "TIFF", "BMP", "png", "PNG", "gif");
 if(in_array($extension, $allowed_extension))
 {
  $new_file_name = rand() . '.' . $extension;
  $path = $_POST["hidden_folder_name"] . '/' . $new_file_name;
  
  $query = "INSERT INTO tbl_image (image_name, image_description) VALUES ('".$new_file_name."','');";
  $statement = $connect->prepare($query);
  $statement->execute();

  $query = "INSERT INTO immagini_x_cartelle (cartella, immagine) VALUES ('".$_POST["hidden_folder_name"]."','".$new_file_name."');";
  $statement = $connect->prepare($query);
  $statement->execute();

  if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $path))
  {
   echo 'Image successfully uploaded!';
  }
  else
  {
   echo 'Error has occcured while uploading image';
  }
 }
 else
 {
  echo 'Formato immagine non supportato';
 }
}
else
{
 echo 'Seleziona un immagine';
}
?>