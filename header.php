<link href="CSS/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- jQuery (Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>

<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="CSS/stylesheets/navigation.css">
<link rel="stylesheet" type="text/css" href="CSS/stylesheets/style1.css" />
<link rel="stylesheet" type="text/css" href="CSS/stylesheets/style_common.css" />

<!-- Stylesheets -->
<link href="CSS/litebox-master/assets/css/litebox.css" rel="stylesheet" type="text/css" media="all" />

<!-- Optional - Adds useful class to manipulate icon font display -->
<link rel="stylesheet" href="CSS/sass-compiled.css" />

<style type="text/css">
/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

#admin_avatar {
  width: 40%;
  border-radius: 50%;
  height: 50%;
}

.container_modal {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 50%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>

<!-- JS -->
<script type="application/x-javascript"> 

addEventListener("load", function() {setTimeout(hideURLbar, 0); }, false); 

function hideURLbar(){ window.scrollTo(0,1); } 

//script nav
$("span.menu").click(function(){
$(".top-menu ul").slideToggle("slow" , function(){});});
</script>

<?php 
	include('modal_login.html');
?>

<?php 
//per stampare la pagina giusta nella sotto navbar
$che_pagina=$_SERVER['PHP_SELF'];

$che_pagina = preg_replace("/[^A-Za-z]/",'',$che_pagina);

$che_pagina = trim($che_pagina,"php");
  
if(!isset($_SESSION['admin'])){
  echo '
  <div class="header">
   <div class="container">
       <a href="index.php"><img src="img_varie/e-logo.png" id="logo" alt="logo" title="EN Logo" height="40" width="40"></a>
     
     <div class="top-menu">
        <span class="menu"> </span>
        <ul>
           <li class="active"><a href="index.php">HOME</a></li>
           <li><a href="about.php">ABOUT</a></li>
           <li><a href="gallery.php">GALLERY</a></li>      
           <li><a href="contact.php">CONTACT</a></li>
                     <li>|</li>   
                     <li id="pannello_admin" onclick="open_modal()">Admin Panel</li>       
         </ul>
     </div>
   </div>
</div>
<!--header-->
<div class="gallery-head">
   <div class="gallery-info">
     <div class="container">
       <a href="index.php">Portfolio/</a><h2>'.$che_pagina.'</h2>       
     </div>    
   </div>
</div>';

}
else{
    echo '
      <div class="header">
   <div class="container">
       <a href="pannello_admin.php"><img src="img_varie/e-logo.png" id="logo" alt="logo" title="EN Logo" height="40" width="40"></a>
     
     <div class="top-menu">
        <span class="menu"> </span>
        <ul>
           <li class="active"><a href="pannello_admin.php">ADMIN</a></li>
           <li><a href="files/gestore_cartelle.php">PANEL</a></li> 
           <li><a href="gallery.php">GALLERY</a></li>
                     <li>|</li>   
                     <li><b>'.$_SESSION['admin'].'<b></li> 
                     <li><a href="logout.php" style="color: red;">Logout</a></li>      
         </ul>
     </div>
   </div>
</div>
<!--header-->
<div class="gallery-head">
   <div class="gallery-info">
     <div class="container">
       <a href="pannello_admin.php">Admin/</a><h2>'.$_SESSION['admin'].'</h2>       
     </div>    
   </div>
</div>';
}
?>

<script type="text/javascript">

function open_modal(){
  document.getElementById('id01').style.display='block';
}

</script>


