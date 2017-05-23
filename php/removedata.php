<?php
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

if(isset($_POST['delete'])){
	$IPaddress = $_GET[IPaddress];
	$Port = $_GET[Port];

   $stmt = $conn->prepare("DELETE from camera WHERE IPaddress=? AND Port=?");

   $stmt->bind_param("ss", $IPaddress, $Port);

   $stmt->execute();

   $stmt->close();

   //$result = $conn->query($sql);
}

if ($conn->query($stmt) === FALSE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: /index.php");
exit();
?>  
