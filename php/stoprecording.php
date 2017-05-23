<?php 

$IPaddress = $_GET[IPaddress];
$Port = $_GET[Port];

$command = escapeshellcmd('ssh pi@'.$IPaddress.' \'sudo pkill wget\'');

$output = shell_exec($command);

header("Location: /expanded_video.php?IPaddress=".$IPaddress."&Port=".$Port);
exit();

?>