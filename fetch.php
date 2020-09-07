<?php
include('database_connection.php');
$query = "SELECT * FROM tbl_image T INNER JOIN immagini_x_cartelle I ON T.image_name = I.immagine ORDER BY T.image_id DESC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$number_of_rows = $statement->rowCount();
$output = '';
$output .= '
 <table class="table table-bordered table-striped">
  <tr>
   <th>Id</th>
   <th>Immagine</th>
   <th>Nome</th>
   <th>Didascalia</th>
   <th>Modifica</th>
  </tr>
';
if($number_of_rows > 0)
{
 $count = 0;
 foreach($result as $row)
 {
  $count ++; 
  $output .= '
  <tr>
   <td>'.$count.'</td>
   <td><img src="files/'.$row["cartella"].'/'.$row["image_name"].'" class="img-thumbnail" width="100" height="100" /></td>
   <td>'.$row["image_name"].'</td>
   <td>'.$row["image_description"].'</td>
   <td><button type="button" class="btn btn-warning btn-xs edit" id="'.$row["image_id"].'">Edit</button></td>
  </tr>
  ';
 }
}
else
{
 $output .= '
  <tr>
   <td colspan="6" align="center">Nessuna immagine caricata.</td>
  </tr>
 ';
}
$output .= '</table>';
echo $output;
?>
