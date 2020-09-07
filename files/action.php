<?php

$connect = new PDO('mysql:host=localhost;dbname=portfolio', 'root', '');


function format_folder_size($size)
{
 if ($size >= 1073741824)
 {
  $size = number_format($size / 1073741824, 2) . ' GB';
 }
    elseif ($size >= 1048576)
    {
        $size = number_format($size / 1048576, 2) . ' MB';
    }
    elseif ($size >= 1024)
    {
        $size = number_format($size / 1024, 2) . ' KB';
    }
    elseif ($size > 1)
    {
        $size = $size . ' bytes';
    }
    elseif ($size == 1)
    {
        $size = $size . ' byte';
    }
    else
    {
        $size = '0 bytes';
    }
 return $size;
}

function get_folder_size($folder_name)
{
 $total_size = 0;
 $file_data = scandir($folder_name);
 foreach($file_data as $file)
 {
  if($file === '.' or $file === '..')
  {
   continue;
  }
  else
  {
   $path = $folder_name . '/' . $file;
   $total_size = $total_size + filesize($path);
  }
 }
 return format_folder_size($total_size);
}

if(isset($_POST["action"]))
{
 if($_POST["action"] == "fetch")
 {
  $folder = array_filter(glob('*'), 'is_dir');
  
  $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Nome Cartella</th>
    <th>Files Totali</th>
    <th>Dimensione</th>
    <th>Update</th>
    <th>Delete</th>
    <th>Upload</th>
    <th>Contenuto</th>
   </tr>
   ';
  if(count($folder) > 0)
  {
   foreach($folder as $name)
   {
    $output .= '
     <tr>
      <td>'.$name.'</td>
      <td>'.(count(scandir($name)) - 2).'</td>
      <td>'.get_folder_size($name).'</td>
      <td><button type="button" name="update" data-name="'.$name.'" class="update btn btn-warning btn-xs">Aggiorna</button></td>
      <td><button type="button" name="delete" data-name="'.$name.'" class="delete btn btn-danger btn-xs">Elimina</button></td>
      <td><button type="button" name="upload" data-name="'.$name.'" class="upload btn btn-info btn-xs">Carica File</button></td>
      <td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-default btn-xs">Mostra</button></td>
     </tr>';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td colspan="6">Nessuna cartella ancora creata</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }
 
 if($_POST["action"] == "create")
 {
  if(!file_exists($_POST["folder_name"])) 
  {
   mkdir($_POST["folder_name"], 0777, true);
   echo 'Cartella Creata';
   $query = "INSERT INTO cartelle VALUES ('".$_POST["folder_name"]."');";
    $statement = $connect->prepare($query);
    $statement->execute();
  }
  else
  {
   echo 'Cartella gia esistente';
  }
 }
 if($_POST["action"] == "change")
 {
  if(!file_exists($_POST["folder_name"]))
  {
   rename($_POST["old_name"], $_POST["folder_name"]);
   echo 'Nome Cartella Aggiornato';
   $query = "UPDATE cartelle SET nome_cartella = '".$_POST["folder_name"]."' WHERE nome_cartella = '".$_POST["old_name"]."';";
    $statement = $connect->prepare($query);
    $statement->execute();

    $query = "UPDATE immagini_x_cartelle SET cartella = '".$_POST["folder_name"]."' WHERE cartella = '".$_POST["old_name"]."';";
    $statement = $connect->prepare($query);
    $statement->execute();
  }
  else
  {
   echo 'Folder Already Created';
  }
 }
 
 if($_POST["action"] == "delete")
 {
  $files = scandir($_POST["folder_name"]);
  foreach($files as $file)
  {
   if($file === '.' or $file === '..')
   {
    continue;
   }
   else
   {
    unlink($_POST["folder_name"] . '/' . $file);
   }
  }
  if(rmdir($_POST["folder_name"]))
  {
   echo 'Cartella eliminata';
   $query = "DELETE FROM cartelle WHERE nome_cartella = '".$_POST["folder_name"]."';";
    $statement = $connect->prepare($query);
    $statement->execute();

    $query = "DELETE T.*
              FROM immagini_x_cartelle C INNER JOIN tbl_image T ON T.image_name=C.immagine
              WHERE C.cartella = '".$_POST["folder_name"]."';";
    $statement = $connect->prepare($query);
    $statement->execute();

    $query = "DELETE FROM immagini_x_cartelle WHERE cartella = '".$_POST["folder_name"]."';";
    $statement = $connect->prepare($query);
    $statement->execute();
  }
 }
 
 if($_POST["action"] == "fetch_files")
 {
  $file_data = scandir($_POST["folder_name"]);
  $output = '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Immagine</th>
    <th>Nome File</th>
    <th>Elimina</th>
   </tr>
  ';
  
  foreach($file_data as $file)
  {
   if($file === '.' or $file === '..')
   {
    continue;
   }
   else
   {
    $path = $_POST["folder_name"] . '/' . $file;
    $output .= '
    <tr>
     <td><img src="'.$path.'" class="img-thumbnail" height="50" width="50" /></td>
     <td contenteditable="true" data-folder_name="'.$_POST["folder_name"].'"  data-file_name = "'.$file.'" class="change_file_name">'.$file.'</td>
     <td><button name="remove_file" class="remove_file btn btn-danger btn-xs" id="'.$path.'">Elimina</button></td>
    </tr>
    ';
   }
  }
  $output .='</table>';
  echo $output;
 }
 
 if($_POST["action"] == "remove_file")
 {
  if(file_exists($_POST["path"]))
  {
   unlink($_POST["path"]);
   echo 'File Rimosso';
   $array_app = explode("/",$_POST["path"]);
   $file_name=$array_app[1];
   $query = "DELETE FROM tbl_image WHERE image_name = '".$file_name."';";
    $statement = $connect->prepare($query);
    $statement->execute();

    $query = "DELETE FROM immagini_x_cartelle WHERE immagine = '".$file_name."';";
    $statement = $connect->prepare($query);
    $statement->execute();
  }
 }
 
 //non implementato il cambio nome file
 if($_POST["action"] == "change_file_name")
 {
  $old_name = $_POST["folder_name"] . '/' . $_POST["old_file_name"];
  $new_name = $_POST["folder_name"] . '/' . $_POST["new_file_name"];
  if(rename($old_name, $new_name))
  {
   echo 'Nome File aggiornato';
  $query = "UPDATE tbl_image SET image_name = '".$new_name."' WHERE image_name = '".$old_name."';";
  $statement = $connect->prepare($query);
  $statement->execute();

  $query = "UPDATE immagini_x_cartelle SET immagine = '".$new_name."' WHERE immagine = '".$old_name."';";
  $statement = $connect->prepare($query);
  $statement->execute();
  }
  else
  {
   echo 'Si e verificato un errore!';
  }
 }
}
?>