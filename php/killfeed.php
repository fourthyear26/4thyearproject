<?php 

$IPaddress = $_GET[IPaddress];
$Port = $_GET[Port];

$command = escapeshellcmd('ssh pi@'.$IPaddress.' \'sudo pkill uv4l\'');

$output = shell_exec($command);

header("Location: /expanded_video.php?IPaddress=".$IPaddress."&Port=".$Port);
exit();

?>