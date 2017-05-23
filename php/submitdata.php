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

$Nickname = $_POST[Nickname];
$IPaddress = $_POST[IPaddress];
$Port = $_POST[Port];
$Username = $_POST[username];
$Password = $_POST[password];
$Description = $_POST[Description];

$stmt = $conn->prepare("INSERT INTO camera (Nickname, IPaddress, Port, username, password, Description) VALUES (?,?,?,?,?,?)");

if ($conn->query($stmt) === FALSE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->bind_param("ssssss", $Nickname, $IPaddress, $Port, $Username, $Password, $Description);

$stmt->execute();

$stmt->close();

$conn->close();    

header("Location: /index.php");
exit();
?>  
