<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="CSS/style_index.css">
  <title>Portfolio</title>
</head>

<body>

<?php 
	include('header.php');
?>

<header id='bacheca_index'>

	<h1 style="position:absolute; top:50%; left:50%; font-size:20; color:white;" id="entra">ENTER</h1>

</header>

<!--<?php //include('footer.html'); ?> -->

</body>

<script type="text/javascript">
    document.getElementById("entra").onclick = function () {
        location.href = "gallery.php";
    };
</script>

</html>