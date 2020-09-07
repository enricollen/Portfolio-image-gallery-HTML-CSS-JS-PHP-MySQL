<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="generator" content="AlterVista - Editor HTML"/>
  <title></title>
</head>
<body>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to      = 'example@gmail.com';
    $subject = 'Contact Module';
    $message = $_POST['messaggio'];
    $headers = 'From: '.$_POST['email'].'' . "\r\n" .
        'Reply-To: example@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
    
    
    include('header.php');
    echo'<h2 style="position:absolute; top:50%; left:50%; font-size:20; color:black;" id="entra">Thank you for contacting me!</h2>';
  }
  else header('error404.php');
?> 

</body>
</html>
