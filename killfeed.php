<?php 

$command = escapeshellcmd('ssh -p2221 pi@174.112.74.174 \'sudo pkill uv4l\'');
$output = shell_exec($command);

header("Location: /index.php");
exit();

?>