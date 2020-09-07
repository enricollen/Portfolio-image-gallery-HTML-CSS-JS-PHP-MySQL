<?php 
include('database_connection.php');
include('header.php');
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="CSS/style_gallery.css">
  <link rel="stylesheet" type="text/css" href="CSS/lightbox.min.css">
  <script type="text/javascript" src="JS/lightbox-plus-jquery.min.js"></script> 
  <title>Gallery</title>

<style>
.main {
  max-width: 1000px;
  margin: auto;
}

h1 {
  font-size: 50px;
  word-break: break-all;
}

.row {
  margin: 10px -16px;
}

/* Add padding BETWEEN each column */
.row,
.row > .column {
  padding: 8px;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  display: none; /* Hide all elements by default */
}

/* Clear floats after rows */ 
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Content */
.content {
  background-color: white;
  padding: 10px;
}

/* The "show" class is added to the filtered elements */
.show {
  display: block;
}

/* Style the buttons */
.btn {
  border: none;
  outline: none;
  padding: 10px 16px;
  background-color: white;
  cursor: pointer;
  width: 10%;
}

.btn:hover {
  background-color: #ddd;
}

.btn.active {
  background-color: #1f1f1f;
  color: white;
}

#myBtnContainer{
	padding: 12px 30px;
}

@media only screen and (max-width: 600px) {
  .btn {
  width: 30%;
  }
}
</style>


<script>
   // Function to hide all other elements, bar the parameter provided
    function filterSelection(elementToShow){

      if(elementToShow != "All"){ 
        // Get an array of elements with the class name, filter.
        var x = document.getElementsByClassName("filter");
        // For each of them
        for(var i = 0; i < x.length; i++){
        // Make them invisible
        x[i].style.display = "none";
        }
        // Get and then make the one you want, visible
        var y = document.getElementsByClassName(elementToShow);
        for(var i = 0; i < y.length; i++)
        y[i].style.display = "block";
        
      }

      else{ // If the parameter provided is all, we want to display everything
        // Get an array of elements with the class name, filter.
        var x = document.getElementsByClassName("filter");
        // For each of them
        for(var i = 0; i < x.length; i++)
        x[i].style.display = "block";

      }

    }
</script>
    
</head>

<body onload="filterSelection(`All`)">

<div class="gallery">

<div id="myBtnContainer">
    <?php
    $query = "SELECT DISTINCT cartella FROM immagini_x_cartelle ORDER BY cartella";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $number_of_rows = $statement->rowCount();
    $output = '';
	
    if ($result)
    $output .= '<button class="btn active" onclick="filterSelection(`All`)">ALL</button>';
    
    foreach($result as $row){
    $nome_cartella = $row['cartella'];
    $output.='
    <button class="btn active" onclick="filterSelection(`'.$nome_cartella.'`)">'.$nome_cartella.'</button>
    ';
    }
    
    echo $output;
    
    ?>  
</div>


<?php
$sql = "SELECT C.cartella, C.immagine, T.image_description
        FROM immagini_x_cartelle C INNER JOIN tbl_image T ON C.immagine = T.image_name ORDER BY C.cartella";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$img_name=$row['immagine'];
      $img_folder=$row['cartella'];
    	$img_description=$row['image_description'];
        echo "<a href='files/".$img_folder."/".$img_name."' data-lightbox='foto' title='".$img_description."''><img src='files/".$img_folder."/".$img_name."' alt=".$img_name." class='column ".$img_folder." filter'></a>";
    }
   
} else {
    echo "<h3 style='color:black;'>Nessuna immagine ancora caricata.</h3>";
}
?>

</div>

</body>
</html>