<!DOCTYPE html>
<html lang="en">
<head>
  <title>IP camera control panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>

<?php
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );
include(__DIR__."/php/navbar.php");
?>
  
<div class="container">
    <form action="/php/submitdata.php" method="post">
    <p>Nickname:</p>
    <input type="text" name="Nickname"><br>
    <p>IP Address:</p>
    <input type="text" name="IPaddress"><br>
    <p>Port number:</p>
    <input type="text" name="Port"><br>    
    <p>Username:</p>
    <input type="text" name="username"><br>
    <p>Password:</p>
    <input type="text" name="password"><br>
    <p>Description:</p>
    <input type="text" name="Description""><br><br>    

    <input type="submit" value="Submit">
</div>

<?php
include(__DIR__."/php/footer.php");
?>

</body>

</html>