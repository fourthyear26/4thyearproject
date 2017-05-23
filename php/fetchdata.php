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

?>  


<html>
<body>
  <div class="row">
	  <? foreach($data as $element) { ?>
      <div class="col-sm-6 col-md-4" style="padding-left: 30px; padding-right: 30px">
  	    <div class="thumbnail">
         <h4><? echo $element[0] ?></h4>
          <a href="expanded_video.php?IPaddress=<? echo $element[1] ?>&Port=<? echo $element[2] ?>" style="display: inline-block">
          <div>
          <!--<img src="/img/camera.jpg">-->
          <embed src="http://<? echo $element[1] ?>:<? echo $element[2] ?>/stream" width="300" height="270" scale="aspect" controller="true" style="pointer-events: none"> 
          </div>
          </a>
  	      <div class="caption">
  	        
  	        <p><? echo $element[5] ?></p>
              <form id="delete" method="post" action="/php/removedata.php?Nickname=<?php print $element[0]; ?>&IPaddress=<?php print $element[1]; ?>&Port=<?php print $element[2]; ?>&username=<?php print $element[3]; ?>&password=<?php print $element[4]; ?>&Description=<?php print $element[5]; ?>">

                <input type="hidden" name="delete_rec_id" value="<?php print $element[4]; ?>"/> 
                <input type="submit" name="delete" value="Remove Feed"/>    
              </form>
  	      </div>
  	    </div>
      </div>
	  <? } ?>
  </div>
</body>
<script type="text/javascript" src="/js/newpage.js"></script>
</html>