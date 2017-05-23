<html>
<body>

<?php
ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );
include(__DIR__."/php/navbar.php");
?>

<embed src="http://<? echo $_GET["IPaddress"] ?>:<? echo $_GET["Port"] ?>/stream" width="600" height="400" scale="aspect" controller="true" style="padding-left: 20px"> 

<form>
<button type="button" onclick="parent.location='/php/startfeed.php?IPaddress=<? echo $_GET["IPaddress"]?>&Port=<? echo $_GET["Port"]?>'" style="margin-left: 20px; margin-top: 10px">Start feed</button>
<button type="button" onclick="parent.location='/php/killfeed.php?IPaddress=<? echo $_GET["IPaddress"]?>&Port=<? echo $_GET["Port"]?>'" style="margin-left: 20px">Kill feed</button>
<button type="button" onclick="parent.location='/php/startrecording.php?IPaddress=<? echo $_GET["IPaddress"]?>&Port=<? echo $_GET["Port"]?>'" style="margin-left: 20px">Start Recording</button>
<button type="button" onclick="parent.location='/php/stoprecording.php?IPaddress=<? echo $_GET["IPaddress"]?>&Port=<? echo $_GET["Port"]?>'" style="margin-left: 20px">Stop Recording</button>
<button type="button" onclick="parent.location='/recordings.php'" style="margin-left: 20px">Saved recordings</button>
</form>

<?php
include(__DIR__."/php/footer.php");
?>

</body>
</html>