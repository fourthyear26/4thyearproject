<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>IP camera control panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );
include(__DIR__."/php/navbar.php");
?>
  
<div class="container">
    <form action="/php/setdata.php" method="post">
    Email:<br>
    <input type="text" name="Email"><br>
    Password:<br>
    <input type="text" name="Password"><br><br>    

    <input type="submit" value="Log in">
</div>

</body>

</html>