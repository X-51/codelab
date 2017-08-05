<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="/favicon.png" />
<title>>Redirect</title>
<style>
body { font-size:48px; }
</style>
</head>
<body>

Current server address is:
<div id="ipVal">
<?php
$currentExternalServerIP = file_get_contents('my_current_external_ip.txt');
$currentServerAddr = 'http://'.$currentExternalServerIP.'/';
echo($currentServerAddr); 
?>
</div>
<script>
var redirectAddr = document.getElementById('ipVal').textContent;
setTimeout(function() {
window.location = redirectAddr;
},1000)
</script>
Redirecting...
</body>
</html>
