<?php
//edit.php
include('database_connection.php');

$query = "
SELECT * FROM tbl_image 
WHERE image_id = '".$_POST["image_id"]."'
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row)
{
 $file_array = explode(".", $row["image_name"]);
 $output['image_name'] = $file_array[0];
 $output['image_description'] = $row["image_description"];
}

echo json_encode($output);

?>