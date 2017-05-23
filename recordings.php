<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "camera_info";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

if ($_SESSION["username"]!=NULL && $_SESSION["password"]!=NULL) {
  $user = $_SESSION["username"];
  $pass = $_SESSION["password"];
  $sql = "SELECT Nickname, IPaddress, Port, username, password, Description FROM camera WHERE username='$user' AND password='$pass'";
} else {
  $sql = "SELECT Nickname, IPaddress, Port, username, password, Description FROM camera";
}

$result = $conn->query($sql);

$count = 0;

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {         
         //store values in array that html below can use
         $data[$count] = array($row["Nickname"],$row["IPaddress"],$row["Port"],$row["username"],$row["password"],$row["Description"]);

         $count = $count+1; 
     }
} else {
     echo "0 results";
}

$conn->close();

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );
include(__DIR__."/php/navbar.php");

?>  


<html>
<body>
  <div class="row">
    <? foreach($data as $element) { ?>
      <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
         <h4><? echo $element[0] ?></h4>
          <embed src="http://<? echo $element[1] ?>:8000/Videos" width="300" height="270" scale="aspect" controller="true"> 
          <div class="caption"> </div>
        </div>
      </div>
    <? } ?>
  </div>

<?php
include(__DIR__."/php/footer.php");
?>

</body>
</html>